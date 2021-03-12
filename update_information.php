<?php
		include("config/connect.php");
		include("functions.php");
        include_once("tempo_sql.php");


		$uid = $_SESSION["userid"];

		$aucidsnew = $_POST['leiloes'];
		
		$qrysel = "select * from auc_due_table where auction_id in (".$aucidsnew.") order by auc_due_time";
		$ressel = mysql_query($qrysel);
		$total = mysql_num_rows($ressel);
		$counter = 0;
		$p = 0;
		for($i=1;$i<=$total;$i++){
			$obj = mysql_fetch_object($ressel);
			$newtime = $obj->auc_due_time;
			$newprice = str_replace(".",",",$obj->auc_due_price);
			$oldprice = $prices[$p];
	
			$qr = "select * from bid_account ba left join registration r on ba.user_id=r.id where auction_id='".$obj->auction_id."' and bid_flag='d' order by ba.id desc limit 0,1";
			$res2 = mysql_query($qr);
			$total2 = mysql_num_rows($res2);
			$obj2 = mysql_fetch_object($res2);
			$username = $obj2->username;
			if($i==1){ $temp = ''; } else { $temp .= ','; }
            if($username=='')$username='Sem Lance';
			$temp .= '{"leilao":{"id_leilao":"'.$obj->auction_id.'","tempo_leilao":"'.$newtime.'","preco":"'.$newprice.'","id_pessoa":"'.$obj2->user_id.'","usuario":"'.$username.'"}}';
			$p++;
				
		}
		echo "[".$temp."]";
?>
