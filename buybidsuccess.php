<?
	include("config/connect.php");
	include("functions.php");
	include("language/english.php");

	$token = $paypaltoken;
	
	$merchantemail = $_POST["pay_to_email"];
	$payersemail = $_POST["pay_from_email"];
	$merchantid = $_POST["merchant_id"];
	$transactionid = $_POST["transaction_id"];
	$mb_transaction_id=$_POST["mb_transaction_id"];
	$paymentstatus = $_POST["status"];
	$md5sig = $_POST["md5sig"];
	$amount = $_POST["amount"];

	$id = $_POST["bpd"];
	$uid = $_POST["upd"];

	function SendDetailMail($email){
		$from = $adminemailadd;
		$subject = "Lances Creditados em sua Conta";
		
		$content1='';

		$content1.= "<font style='font-size: 10px;font-family: Arial, Helvetica, sans-serif;color: #333333;'>
        Membro,</font><br><br><p align='center' style='font-size: 14px;font-family: Arial, Helvetica, sans-serif;font-weight:bold;'>
        </p><br>".	
	
	"<table border='0' cellpadding='3' cellspacing='0' width='100%' align='center' class='style13'>";

		$content1.="<tr style='font-size: 10px;font-family: Arial, Helvetica, sans-serif;color: #333333;'>
		<td>Aviso de credito de lances por compra aprovada.</td>
		</tr>";
		
		foreach($_POST as $name => $value){
			$content1.="<tr style='font-size: 10px;font-family: Arial, Helvetica, sans-serif;color: #333333;'>
			<td>".$name." :".$value.".</td>
			</tr>";
		}
		
		$content1.="<tr style='font-size: 10px;font-family: Arial, Helvetica, sans-serif;color: #333333;'>
		<td></td>
		</tr>
		</table>";

		SendHTMLMail2($email,$subject,$content1,$from);
	}
	
	
		if($paymentstatus==2){
			if($id!="" and $id!=0){
				$qrypay = "Insert into payment_detail (transaction_id,user_id,bidpack_id,temp_data) values('".$mb_transaction_id."|".$md5sig."','".$uid."','".$id."','".$_REQUEST."')";
				mysql_query($qrypay) or die(mysql_error());
				
				$qrysel1 = "select * from bidpack where id='$id'";
				$ressel1 = mysql_query($qrysel1);
				$obj1 = mysql_fetch_array($ressel1);
				
				$creditdesc = $lng_bidpackchar.$obj1["bidpack_name"]."&nbsp;".$obj1["bid_size"]."&nbsp;".$lng_bidsfor."&nbsp;".$Currency.$obj1["bid_price"];
				
				$qrysel = "select * from registration where id='$uid'";
				$rssel = mysql_query($qrysel);
				$obj = mysql_fetch_object($rssel);
				
				$qr = "select * from bid_account where user_id='".$uid."' and bid_flag='c' and recharge_type='re'";
				$rs = mysql_query($qr);
				$totalrecharge = mysql_num_rows($rs);
				
                SendDetailMail($obj->email);
		//recharge type re for recharge
		//recharge type af for affiliate
		//recharge type ad for admin
				if($totalrecharge=="0" && $obj->sponser!="0"){
					$qryaff = "select * from registration where id='".$obj->sponser."'";
					$resaff = mysql_query($qryaff);
					$objaff = mysql_fetch_object($resaff);
					$fbid = $objaff->final_bids;
		
        	        $qrybonus = "select * from general_setting";
	                $resbonus = mysql_query($qrybonus) or die(mysql_error());
	                if(0<mysql_num_rows($resbonus)){
		                $objbonus = mysql_fetch_array($resbonus);
		                $bonusbids = $objbonus["bonus_indicacao"];
	                }
					
					$finalbids = $fbid + $bonusbids;
		
					$updaff = "update registration set final_bids='".$finalbids."' where id='".$obj->sponser."'";
					mysql_query($updaff) or die(mysql_error());			
					
					$insaff = "Insert into bid_account (user_id, bidpack_buy_date, bid_count, bid_flag, recharge_type, referer_id, credit_description) 
                                                values('".$obj->sponser."',NOW(),'$bonusbids','c','af','$uid','Bônus de indicação')";
					mysql_query($insaff) or die(mysql_error());
					$insertidaff = mysql_insert_id();
				}
				
				$qryins = "Insert into bid_account (user_id, bidpack_buy_date, bid_count, bid_flag, recharge_type, bidpack_id, credit_description) values('$uid',NOW(),'".$obj1["bid_size"]."','c','re','$id','".$creditdesc."')";
				mysql_query($qryins) or die(mysql_error());
				$insertid = mysql_insert_id();
                	
				$qrylng = "select * from language";
				$reslng = mysql_query($qrylng);
				$totallng = mysql_num_rows($reslng);
					
					if($totallng>0){
						while($objlng = mysql_fetch_array($reslng)){
							$prefix = $objlng["language_prefix"];

							include("language/".$objlng["language_name"].".php");

							$creditdesc = $lng_bidpackchar.$obj1[$prefix."_bidpack_name"]."&nbsp;".$obj1["bid_size"]."&nbsp;".$lng_bidsfor."&nbsp;".$Currency.$obj1["bid_price"];;

							$creditdesc2 = $lng_bidreffbonus;

							$qryupd = "update bid_account set ".$prefix."_credit_description='".$creditdesc."' where id='".$insertid."'";
							mysql_query($qryupd) or die(mysql_error());
							
							if($insertidaff!="")
							{
								$qryupd2 = "update bid_account set ".$prefix."_credit_description='".$creditdesc2."' where id='".$insertidaff."'";
								mysql_query($qryupd2) or die(mysql_error());
							}
						}
					}
				//end bid_account
			
				if($obj->final_bids>0)
				{
					$bal = $obj->final_bids;
					$new = $obj1["bid_size"];
					$final = $bal + $new;
				}
				else
				{
					$final = $obj1["bid_size"];
				}
				
				$qryupd = "update registration set final_bids='$final' where id='$uid'";
				mysql_query($qryupd) or die(mysql_error());
			}
	}
?>
