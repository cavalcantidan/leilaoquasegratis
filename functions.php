<?php
    //functions added for transcommit in sql
	function begin(){mysql_query("BEGIN");}

	function commit(){mysql_query("COMMIT");}

	function rollback(){mysql_query("ROLLBACK");}

	function ChangeDateFormat($date){
		$day = substr($date,0,2);
		$month = substr($date,3,2);
		$year = substr($date,6,4);
		$newdate = $year."-".$month."-".$day;
		return $newdate;
	}

	function ChangeDateFormatSlash($date){
		$year = substr($date,0,4);
		$month = substr($date,5,2);
		$day = substr($date,8,2);
		$newdate = $day."/".$month."/".$year;	
		return $newdate;
	}	
	
	function ChangeDateBT($date,$tp){
	   if ($tp='-'){
		   $dt = ChangeDateFormat($date).substr($date,10);
	   }else{
		   $dt = ChangeDateFormatSlash($date).substr($date,10);
	   }
	   return $dt;
	}
	
	function SendHTMLMail2($to,$subject,$mailcontent,$from){
		$array = split("@",$from,2);
		$SERVER_NAME = $array[1];
		$username =$array[0];
		$headers = "From: $username@$SERVER_NAME\nReply-To:$username@$SERVER_NAME\nX-Mailer: PHP\n";
	
		$limite = "_parties_".md5 (uniqid (rand()));
	
		$headers .= "Date: ".date("l j F Y, G:i")."\n";
		$headers .= "MIME-Version: 1.0\n";
		$headers .= "Content-Type: text/html;\n";
		$headers .= " boundary=\"----=$limite\"\n\n";
	
		/*
		$eol = "\n";
		$headers .= "Return-Path: Nome <contato@localhost.com>{$eol}";    

		$mime_boundary=md5(time());
	 
		$msg .= "--".$mime_boundary.$eol; 
		$msg .= "Content-Type: text/html; charset=<?=$lng_characset;?>{$eol}"; 
		$msg .= "Content-Transfer-Encoding: 8bit{$eol}"; 
		$msg .= $mailcontent.$eol.$eol; 
		*/
		mail($to,$subject,$mailcontent,$headers);
	}
	                      
	function arrangedate($date){
		$year = substr($date,0,4);
		$month = substr($date,5,2);
		$day = substr($date,8,2);
		$date = $day."/".$month."/".$year;
		return $date;
	}

	function choose_short_desc($shortdesc,$length){
			$long_desc = $shortdesc;
	//			$length=150;
			$totallen = strlen($long_desc);
			for($i=$length;$i<$totallen;$i++){
				if(substr($long_desc,$i,1)==" "){
					$length = $i;
					break;
				}
			}
			if(strlen($long_desc)>$length){
				$short_desc = nl2br(substr($long_desc,0,$length));
				$short_desc .= "...";
			}else{
				$short_desc = nl2br($long_desc)."...";
			}	
			return $short_desc;
	}

	function resumir_frase($frase,$tamanho_limite){
			$long_desc = stripslashes($frase);
			$totallen = strlen($long_desc);
			if($totallen<=$tamanho_limite) return $long_desc;
			$corte=0;
			for($i=$tamanho_limite-4;$i>0;$i--){
				if(substr($long_desc,$i,1)==" "){
					$corte = $i;
					break;
				}
			}
			if($corte==0)$corte=$tamanho_limite-4;

			return nl2br(substr($long_desc,0,$corte))." ...";
	}

	function getBidHistory($aid,$uid){
		global $lng_bidbuddy;
		global $lng_backbooking;
		global $lng_biddingsinglebid;
		global $lng_biddingsmsbid;
		$qry = "select * from bid_account where user_id=$uid and auction_id=$aid   and bid_flag='d' and bidding_type='s' order by id desc";
		$res = mysql_query($qry);
		$totalqry = mysql_num_rows($res);

		$qry1 = "select * from bidbutler where user_id='$uid' and auc_id='$aid'";
		$res1 = mysql_query($qry1);
		$totalqry1 = mysql_num_rows($res1);
	
		if($totalqry1>0){
			for($i=1;$i<=$totalqry1;$i++){
				$v1 = mysql_fetch_array($res1);
	?>
			<div class="normal_text">
				<div class="normal_text" style="font-size: 12px; float: left; width: 65px; margin-left: 5px;" align="center"><?=arrangedate(substr($v1["place_date"],0,10));?></div>
				<div class="normal_text"  style="font-size: 12px; float:left; width: 65px;" align="center"><?=substr($v1["place_date"],11);?></div>
				<div class="normal_text"  style="font-size: 12px; float:left; text-align: center; width: 120px;"><?=$lng_bidbuddy;?></div>
				<div align="center" class="red-text-12-b" style="font-size: 12px; float: right; width: 20px; padding-right: 5px;"><? echo "-".$v1["butler_bid"]; ?></div>
			</div>
	<?		
			}
		}
	
		$qry2 = "select * from bid_account where user_id='$uid' and auction_id='$aid' and bid_flag='b'";
		$res2 = mysql_query($qry2);
		$totalqry2 = mysql_num_rows($res2);
		if($totalqry2>0){
			for($i=1;$i<=$totalqry2;$i++){
				$v2 = mysql_fetch_array($res2);
	?>
			<div class="normal_text">
				<div class="normal_text" style="font-size: 12px; float: left; width: 65px; margin-left: 5px;" align="center"><?=arrangedate(substr($v2["bidpack_buy_date"],0,10));?></div>
				<div class="normal_text"  style="font-size: 12px; float:left; width: 65px;" align="center"><?=substr($v2["bidpack_buy_date"],11);?></div>
				<div class="normal_text"  style="font-size: 12px; float:left; text-align: center; width: 120px;"><?=$lng_backbooking;?></div>
				<div align="center" class="greenfont" style="font-size: 12px; float: right; width: 20px; padding-right: 5px;"><b><? echo $v2["bid_count"]; ?></b></div>
			</div>
	<?		
			}
		
		}
	
		while($v = mysql_fetch_array($res)){
	?>
			<div class="normal_text">
				<div class="normal_text" style="font-size: 12px; float: left; width: 65px; margin-left: 5px;" align="center"><?=substr(arrangedate($v["bidpack_buy_date"]),0,10);?></div>
				<div class="normal_text"  style="font-size: 12px; float:left; width: 65px;" align="center"><?=substr($v["bidpack_buy_date"],11);?></div>
				<div class="normal_text"  style="font-size: 12px; float:left; text-align: center; width: 120px;"><? if($v["bidding_type"]=='s'){ echo $lng_biddingsinglebid; } elseif($v["bidding_type"]=='b'){ echo $lng_bidbuddy; } elseif($v["bidding_type"]=='m'){ echo $lng_biddingsmsbid; } ?></div>
				<div align="center" class="red-text-12-b" <? if($v["bidding_type"]!='m') { ?>style="font-size: 12px; float: right; width: 20px; padding-right: 5px;"<? } else { ?>style="font-size: 12px; float: right;  width: 20px; padding-right: 5px;"<? } ?>><? echo "-".$v["bid_count"]; ?></div>
			</div>
			<div style="clear: both;"></div>
	<?		
		}
	}

	function getshipping($id){
		$sqlgetshipping = "select shippingcharge from shipping where id='$id'";
		$resgetshipping = mysql_query($sqlgetshipping) or die(mysql_error());
		if(0<mysql_num_rows($resgetshipping))	{
			$rowgetshipping = mysql_fetch_array($resgetshipping);
			$shippingchr = $rowgetshipping["shippingcharge"];
			return $shippingchr;
		}else{
			return 0.00;
		}
	}	
                       	
	function getPaypalInfo($stat){
		$qrysel = "select * from paypal_info where id='1'";
		$ressel = mysql_query($qrysel);
		$obj = mysql_fetch_object($ressel);
		$businessid = $obj->business_id;
		$token = $obj->token;
		if($stat==1)
		{
			return $businessid;
		}
		if($stat==2)
		{
			return $token;
		}
	}

	function getseguroInfo($stat){
		$qrysel = "select * from paypal_info where id='1'";
		$ressel = mysql_query($qrysel);
		$obj = mysql_fetch_object($ressel);
		$businessid = $obj->seguro_id;
		$token = $obj->token1;
		if($stat==1)
		{
			return $businessid;
		}
		if($stat==2)
		{
			return $token;
		}
	}
                       
	function enddatefunction($date){
		$year = substr($date,0,4);
		$month = substr($date,5,2);
		$day = substr($date,8,2) + 5;
			
			if($day>31){
				if($month==1 || $month==3 || $month==5 || $month==7 || $month==8 || $month==10 || $month==12){
					if($month==12){
						$month = 01;
						$year = $year + 1;
					}else{
					    $month = $month + 01;
					}
					$day1 = 31;						
				}else{
					$month = $month + 01;
					$day1 = 30;
				}
				$diff = $day - $day1;
				$date = $diff."/".$month."/".$year;
			}else{
				$date = $day."/".$month."/".$year;
			}
		return $date;
	}
	
	function getTotalPlaceBids($aid)
		{
			$qrysel = "select *,sum(bid_count) as totalbid from bid_account where auction_id='$aid' and bid_flag='d' and bidding_type='s' and user_id='".$_SESSION["userid"]."' group by auction_id";
			$ressel = mysql_query($qrysel);
			$obj = mysql_fetch_object($ressel);

			$qrysel1 = "select *,sum(butler_bid) as butlerbid from bidbutler where auc_id='$aid' and user_id='".$_SESSION["userid"]."' group by auc_id";
			$ressel1 = mysql_query($qrysel1);
			$obj1 = mysql_fetch_object($ressel1);

			$qrysel2 = "select *,sum(bid_count) as savebid from bid_account where auction_id='$aid' and bid_flag='b' and user_id='".$_SESSION["userid"]."' group by auction_id";
			$ressel2 = mysql_query($qrysel2);
			$obj2 = mysql_fetch_object($ressel2);

			$totalbid = $obj->totalbid;
			$butlerbid  = $obj1->butlerbid;
			$savebid = $obj2->savebid;

			$placebid = ($butlerbid  + $totalbid) - $savebid;

			return $placebid;
		}

	function GetUserFinalBids($uid){
		$qrybal = "select final_bids from registration where id='{$uid}'";
		$resbal = mysql_query($qrybal);
		$objbal = mysql_fetch_object($resbal);
		$final = $objbal->final_bids;
		return $final;
	}	

	function AcceptDateFunction($date){
			$year = substr($date,0,4);
			$month = substr($date,5,2);
			$day = substr($date,8,2) + 7;
			
				if($day>31)
				{
					if($month==1 || $month==3 || $month==5 || $month==7 || $month==8 || $month==10 || $month==12)
					{
						if($month==12)
						{
							$month = 01;
							$year = $year + 1;
							$day1 = 31;						
							$diff = $day - $day1;						
						}
						else
						{
						$month = $month + 01;
						$day1 = 31;
						$diff = $day - $day1;
						}
					}
					else
					{
						$month = $month + 01;
						$day1 = 30;
						$diff = $day - $day1;
					}
					$date = str_pad($diff,2,0,STR_PAD_LEFT)."-".str_pad($month,2,0,STR_PAD_LEFT)."-".$year;
				}
				else
				{
					$date = str_pad($day,2,0,STR_PAD_LEFT)."-".str_pad($month,2,0,STR_PAD_LEFT)."-".$year;
				}
			return $date;
		}

	function AcceptDateFunctionStatus($date){
		$year = substr($date,0,4);
		$month = substr($date,5,2);
		$day = substr($date,8,2) + 7;	
		$newdate = explode(" ",$date);
		$exdate = explode("-",$newdate[0]);
		$newyear = $exdate[0];
		$newmonth = $exdate[1];
		$newday = $exdate[2];
		$newtime = explode(":",$newdate[1]);
		$newhour = $newtime[0];
		$newmin = $newtime[1];
		$newsec = $newtime[2];
		$returndate1 = date("Y-m-d H:i:s",mktime($newhour,$newmin,$newsec,$newmonth,$newday+7,$newyear));
		
		$newdate1 = explode(" ",$returndate1);
		$exdate1 = explode("-",$newdate1[0]);
		$newyear1 = $exdate1[0];
		$newmonth1 = $exdate1[1];
		$newday1 = $exdate1[2];
		$newtime1 = explode(":",$newdate1[1]);
		$newhour1 = $newtime1[0];
		$newmin1 = $newtime1[1];
		$newsec1 = $newtime1[2];
		
		
		$returndate = array("Hour"=>$newhour1,"Min"=>$newmin1,"Sec"=>$newsec1,"Month"=>$newmonth1,"Day"=>$newday1,"Year"=>$newyear1);
		return $returndate;
	}	
	                   	
	function SendWinnerMail($auctionid){
		global $SITE_URL,$adminemailadd;
		global $lng_mailwonaucinfo, $lng_mailhi,$lng_mailcongratulation,$lng_mailyouhavewon,$lng_mailauctionid,$lng_mailname,$lng_mailprice,$lng_mailclosingdate,$lng_mailclosingnote,$lng_mailaccdenclick1,$lng_mailaccdenclick2,$lng_mailsubjectauctionwon;

		$qrysel = "select * from won_auctions w left join auction a on w.auction_id=a.auctionID left join registration r on w.userid=r.id left join products p on a.productID=p.productID where w.auction_id='".$auctionid."'";
		$ressel = mysql_query($qrysel);
		$objsel = mysql_fetch_object($ressel);
		if($objsel->fixedpriceauction==1) { 
		   $winprice = $objsel->auc_fixed_price; 
		}elseif($objsel->offauction==1){ 
			$winprice = "0.01"; 
		}else{ 
			$winprice = $objsel->auc_final_price; 
		}

		$content1='';
		$content1.= "<font style='font-size: 10px;font-family: Arial, Helvetica, sans-serif;color: #333333;'>"."</font><br>"."<br>".
		"<p align='center' style='font-size: 14px;font-family: Arial, Helvetica, sans-serif;font-weight:bold;'>".$lng_mailwonaucinfo."</p>"."<br>".	
		"<table border='0' cellpadding='3' cellspacing='0' width='100%' align='center' class='style13'>";

		$content1.="<tr style='font-size: 10px;font-family: Arial, Helvetica, sans-serif;color: #333333;'>
		<td>".$lng_mailhi.$objsel->username.", </td>
		</tr>";

		$content1.="<tr style='font-size: 10px;font-family: Arial, Helvetica, sans-serif;color: #333333;'>
		<td>".$lng_mailcongratulation.":</td>
		</tr>";

		$content1.="<tr style='font-size: 10px;font-family: Arial, Helvetica, sans-serif;color: #333333;'>
		<td>".$lng_mailyouhavewon."</td>
		</tr>";

		$content1.="<tr style='font-size: 10px;font-family: Arial, Helvetica, sans-serif;color: #333333;'>
		<td>".$lng_mailauctionid.": ".$auctionid."</td>
		</tr>";

		$content1.="<tr style='font-size: 10px;font-family: Arial, Helvetica, sans-serif;color: #333333;'>
		<td>".$lng_mailname.": ".$objsel->name."</td>
		</tr>";

		$content1.="<tr style='font-size: 10px;font-family: Arial, Helvetica, sans-serif;color: #333333;'>
		<td>".$lng_mailprice.": R$ ".number_format($winprice,2)."</td>
		</tr>";

		$content1.="<tr style='font-size: 10px;font-family: Arial, Helvetica, sans-serif;color: #333333;'>
		<td>".$lng_mailclosingdate.": ".arrangedate(substr($objsel->won_date,0,10))."</td>
		</tr>";

		$content1.="<tr style='font-size: 10px;font-family: Arial, Helvetica, sans-serif;color: #333333;'>
		<td>".$lng_mailclosingnote."</td>
		</tr>";

		$content1 .= "<tr style='font-size: 10px;font-family: Arial, Helvetica, sans-serif;color: #333333;'>
		<td>".$lng_mailaccdenclick1."<a href='".$SITE_URL."wonauctionaccept.php?winid=".base64_encode($auctionid)."'>".$lng_mailaccdenclick2."</a></td>
		</tr>
		</table>";

		$subject=$lng_mailsubjectauctionwon;
		$from=$adminemailadd;
		$email = $objsel->email;

	//		echo $content1."<br>";
	//		exit;

	//		exit;
		//$ADMIN_EMAIL = "contato@lancelouco.com";
		//$ADMIN_EMAIL = "contato@lancelouco.com";
		SendHTMLMail2($email,$subject,$content1,$from);
	}	
                       	
	function AcceptDateFunctionStatus_Voucher($date,$validity){
		$year = substr($date,0,4);
		$month = substr($date,5,2);
		$day = substr($date,8,2) + $validity;	
		$newdate = explode(" ",$date);
		$exdate = explode("-",$newdate[0]);
		$newyear = $exdate[0];
		$newmonth = $exdate[1];
		$newday = $exdate[2];
		$newtime = explode(":",$newdate[1]);
		$newhour = $newtime[0];
		$newmin = $newtime[1];
		$newsec = $newtime[2];
		$returndate1 = date("Y-m-d H:i:s",mktime($newhour,$newmin,$newsec,$newmonth,$newday+$validity,$newyear));
	
		$newdate1 = explode(" ",$returndate1);
		$exdate1 = explode("-",$newdate1[0]);
		$newyear1 = $exdate1[0];
		$newmonth1 = $exdate1[1];
		$newday1 = $exdate1[2];
		$newtime1 = explode(":",$newdate1[1]);
		$newhour1 = $newtime1[0];
		$newmin1 = $newtime1[1];
		$newsec1 = $newtime1[2];
	
		$returndate = array("Hour"=>$newhour1,"Min"=>$newmin1,"Sec"=>$newsec1,"Month"=>$newmonth1,"Day"=>$newday1,"Year"=>$newyear1);
		return $returndate1;
	}

	function getUserName($uid){
		$qryusername = "select * from registration where id='{$uid}'";
		$resusername = mysql_query($qryusername);
		$objusername = mysql_fetch_object($resusername);
		$uname = $objusername->username;
		return $uname;
	}
    
?>