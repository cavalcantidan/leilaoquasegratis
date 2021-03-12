<?
	include_once("session.php");

	if(!isset($_SESSION["userid"])){
		echo '[{"resultado":"falhou","total_lances":"0","motivo":"Sessão não identificada!"}]';
		exit;
	}
	$uid = $_SESSION["userid"];

	//include_once("config/connect.php");
	include_once("functions.php");
		
	$qrysel = "select final_bids from registration where id=$uid";
	$ressel = mysql_query($qrysel);
	$obj = mysql_fetch_object($ressel);
	
	$bal = $obj->final_bids;
	if($bal<=0){
		echo '[{"resultado":"falhou","total_lances":"'.$bal.'","motivo":"Sem Saldo!"}]';
		exit;
	}

	if(!isset($_POST["aid"])){
		echo '[{"resultado":"falhou","total_lances":"'.$bal.'","motivo":"Leilão não identificado!"}]';
		exit;
	}

	$aid = $_POST["aid"];
	
	$q = "select * from auc_due_table adt left join auction a on adt.auction_id=a.auctionID left join auction_management am on a.time_duration=am.auc_manage where auction_id=$aid";
	$r = mysql_query($q);
	$ob = mysql_fetch_object($r);
	$prid = $ob->productID;
		
	if($ob->pause_status=='1' || $ob->auc_status>2){
		echo '[{"resultado":"falhou","total_lances":"'.$bal.'","motivo":"Leilão indisponível!"}]';
		exit;
	}

	if($aceite_lance_futuro=false && $ob->auc_status==1){
		echo '[{"resultado":"falhou","total_lances":"'.$bal.'","motivo":"Leilão indisponível!"}]';
		exit;
	}		
			
	$qr = "select * from bid_account ba left join registration r on ba.user_id=r.id where auction_id='".$aid."' and bid_flag='d' order by ba.id desc limit 0,1";
	$res2 = mysql_query($qr);
	$total2 = mysql_num_rows($res2);
	$obj2 = mysql_fetch_object($res2);
	$uservecedor = $obj2->username;
	$username = getUserName($uid);
	if($username == $uservecedor){
		echo '[{"resultado":"falhou","total_lances":"'.$bal.'","motivo":"O lance anterior já é seu!"}]';
		exit;
	}

	$oldtime = $ob->auc_due_time;
	$oldprice = $ob->auc_due_price;
	$plusprice = $ob->auc_plus_price;
	$plustime = $ob->auc_plus_time;		
	$newprice = $ob->pennyauction==1? $oldprice + 0.01 : $oldprice + $plusprice;
	$newtime = $oldtime < $plustime ? $plustime : $oldtime;
				
	begin();
			
	$qupd = "update auc_due_table set auc_limite_atual=0, auc_due_time=$newtime,auc_due_price=$newprice where auction_id=$aid";
	$result1 = mysql_query($qupd);
			
	if(!$result1){
		rollback();
		echo '[{"resultado":"falhou","total_lances":"'.$bal.'","motivo":"Falha ao tentar enviar lance, tente novamente"}]';
		exit;
	}

	if ($ob->offauction==1){
		$final_bal = $bal;
		/* echo "<script>
				obj = document.getElementById('bids_count');
				if(obj.innerHTML!='0'){
					obj.innerHTML = Number(obj.innerHTML) + 1;
				}
			  </script>";  */
	}else{
		$final_bal = $bal-1;
	}	

	$qryupd = "update registration set final_bids=".$final_bal." where id=$uid";
	$result2 = mysql_query($qryupd);

	if(!$result2){
		rollback();
		echo '[{"resultado":"falhou","total_lances":"'.$bal.'","motivo":"Falha ao gerar lance, tente novamente"}]';
		exit;
	}
			
	$qryins = "Insert into bid_account (user_id,bidpack_buy_date,bid_count,auction_id,product_id,bid_flag,bidding_price,bidding_type,bidding_time)
				values('$uid','".date("Y-m-d H:i:s",time()-$TimeDifference)."','1','$aid','$prid','d',$newprice,'s',".$oldtime.")";
	$result3 = mysql_query($qryins);
	
	if(!$result3){
		rollback();
		echo '[{"resultado":"falhou","total_lances":"'.$bal.'","motivo":"Falha ao confirmar lance, tente novamente"}]';
		exit;
	}

	commit();
	echo '[{"resultado":"sucesso","total_lances":"'.$final_bal.'","motivo":""}]';

?>