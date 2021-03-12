<?
	include("config/connect.php");
	include("functions.php");
	$aucid = $_GET["winid"];
//	$err = 1;
	if($aucid!="")
	{
		$auctionID = base64_decode($aucid);
		$qrysel = "select *,".$lng_prefix."name as name from auction a left join products p on a.productID=p.productID  left join won_auctions w on a.auctionID=w.auction_id where a.auctionID='".$auctionID."'";
		$ressel = mysql_query($qrysel);
		$objsel = mysql_fetch_object($ressel);
	}
	
	if($_POST["submit"]!="")
	{
		  $query="select * from registration where username='$username' and password='$pass' and account_status='1' and member_status='0' and user_delete_flag!='d'";
		  $rs = mysql_query($query);
		  $total = mysql_num_rows($rs);
		  $objquery = mysql_fetch_object($rs);

		$auctionID = $_REQUEST["auctionid"];
		$qrysel = "select * from auction a left join products p on a.productID=p.productID  left join won_auctions w on a.auctionID=w.auction_id where a.auctionID='".$auctionID."'";
		$ressel = mysql_query($qrysel);
		$objsel = mysql_fetch_object($ressel);
		if($objsel->fixedpriceauction==1)
		 { $winprice = $objsel->auc_fixed_price; }
		elseif($objsel->offauction==1) { $winprice = "0.01"; }
		else { $winprice = $objsel->auc_final_price; }

		if($objsel->accept_denied=="")
		{
		  if($total>0 && $objquery->id==$objsel->userid)
		  {
			$expiry = AcceptDateFunctionStatus($objsel->won_date);
			
			$todaytime = time();
			$expirytime = mktime($expiry["Hour"],$expiry["Min"],$expiry["Sec"],$expiry["Month"],$expiry["Day"],$expiry["Year"]);
			$dateDiff = $todaytime - $expirytime;   

			if($todaytime>$expirytime)
			{
				$new_status = "Expire";
			}
			else
			{
				$new_status = "Running";
			}	
/*			$fullDays = floor($dateDiff/(60*60*24));
			if ($fullDays>0) { 
			$new_status = "Expire"; 
			} else { 
			$new_status = "Running"; 
			} */

			if($new_status=="Expire")
			{
				$err = 1;
			}

			else
			{
				$accden = $_POST['Accden'];				
				if($accden=='Accepted')
				{
					$Updateqry = "update won_auctions set accept_denied='".$accden."',accept_date=NOW() where userid='".$objsel->userid."' and auction_id='".$_REQUEST["auctionid"]."'";
				}
				else
				{
					$Updateqry = "update won_auctions set accept_denied='".$accden."' where userid='".$objsel->userid."' and auction_id='".$_REQUEST["auctionid"]."'";
				}
				mysql_query($Updateqry) or die(mysql_error());

			    $_SESSION["username"]=$username;
			    $_SESSION["userid"]=$objquery->id;
			    $_SESSION["sessionid"] = session_id();

				$mailpayflag = 0;
				if($accden=='Accepted')
				{
					if($objsel->offauction==1 || $objsel->fixedpriceauction==1)
					{
						$qryshipping = "select * from shipping where id='".$objsel->shipping_id."'";
						$resshipping = mysql_query($qryshipping);
						$objshipping = mysql_fetch_object($resshipping);
						
						if($objsel->offauction==1)
						{
							$totalamount = $objshipping->shippingcharge;
							if($totalamount<=0)
							{
								$paymentdate = date("Y-m-d H:i:s");
								$qryupd = "update won_auctions set payment_date='".$paymentdate."' where auction_id='".$_REQUEST["auctionid"]."' and userid='".$objsel->userid."'";
								mysql_query($qryupd) or die(mysql_error());
								$paymentdate2 = arrangedate(substr($paymentdate,0,10))."<br>".substr($paymentdate,11);
								$mailpayflag = 1;
							}
						}
						if($objsel->fixedpriceauction==1)
						{
							$totalamount = $objsel->auc_fixed_price + $objshipping->shippingcharge;
							if($totalamount<=0)
							{
								$paymentdate = date("Y-m-d H:i:s");
								$qryupd = "update won_auctions set payment_date='".$paymentdate."' where auction_id='".$_REQUEST["auctionid"]."' and userid='".$objsel->userid."'";
								mysql_query($qryupd) or die(mysql_error());
								$paymentdate2 = arrangedate(substr($paymentdate,0,10))."<br>".substr($paymentdate,11);
								$mailpayflag = 1;
							}
						}
					}
				}
				
				$username = getUserName($_SESSION["userid"]);
				$mailwithauctionid = $_REQUEST["auctionid"];
				$auction_name = $objsel->name;
				$auction_price = $Currency.number_format($winprice,2);
				$winingdate = date("d/m/Y",time());
				$url_auctionid = base64_encode($_REQUEST["auctionid"]); 
				
				if($accden==$lng_onlyaccept)
				{
					$emailcont1 = sprintf($lng_emailcontent_wonaccept,$username,$mailwithauctionid,$auction_name,$auction_price,$winingdate);
					
				}
				elseif($accden=='Accepted' && $mailpayflag==0)
				{
					
					$emailcont1 = sprintf($lng_emailcontent_wonacceptflag,$username,$mailwithauctionid,$auction_name,$auction_price,$winingdate,$url_auctionid);
				}
				else
				{
					$emailcont1 = sprintf($lng_emailcontent_wondenied,$mailacceptwithuser,$mailwithauctionid,$auction_name,$auction_price,$winingdate);
				}
				
				
				/*$content1='';
		
				$content1.= "<font style='font-size: 10px;font-family: Arial, Helvetica, sans-serif;color: #333333;'>"."</font><br>"."<br>"."<p align='center' style='font-size: 14px;font-family: Arial, Helvetica, sans-serif;font-weight:bold;'>".$lng_mailauctioninfo."</p>"."<br>".	
			
			"<table border='0' cellpadding='3' cellspacing='0' width='100%' align='center' class='style13'>";
		
				$content1.="<tr style='font-size: 10px;font-family: Arial, Helvetica, sans-serif;color: #333333;'>
				<td> ".$lng_mailaccepthi.getUserName($_SESSION["userid"]).", </td>
				</tr>";
		
				$content1.="<tr style='font-size: 10px;font-family: Arial, Helvetica, sans-serif;color: #333333;'>
				<td>";
				if($accden==$lng_onlyaccept)
				{
					$content1 .= $lng_mailwonandaccept;
				}
				else
				{
					$content1 .= $lng_mailwonanddenied;	
				}
				"</td>
				</tr>";
		
				$content1.="<tr style='font-size: 10px;font-family: Arial, Helvetica, sans-serif;color: #333333;'>
				<td>".$lng_mailwonacceptid.": ".$_REQUEST["auctionid"]."</td>
				</tr>";
		
				$content1.="<tr style='font-size: 10px;font-family: Arial, Helvetica, sans-serif;color: #333333;'>
				<td>".$lng_mailwonname.": ".$objsel->name."</td>
				</tr>";
		
				$content1.="<tr style='font-size: 10px;font-family: Arial, Helvetica, sans-serif;color: #333333;'>
				<td>".$lng_mailwonprice.": ".$Currency.number_format($winprice,2)."</td>
				</tr>";
		
				$content1.="<tr style='font-size: 10px;font-family: Arial, Helvetica, sans-serif;color: #333333;'>
				<td>".$lng_mailaccedenieddate.": ".date("d/m/Y",time())."</td>
				</tr>";

			if($accden=='Accepted')
			{
				$content1.="<tr style='font-size: 10px;font-family: Arial, Helvetica, sans-serif;color: #333333;'>
				<td>".$lng_mailauctionpaid."</td>
				</tr>";
				
				$content1.="<tr style='font-size: 10px;font-family: Arial, Helvetica, sans-serif;color: #333333;'>
				<td>".$lng_mailtomakepay1."<a href='".$SITE_URL."login.php?wid=".base64_encode($_REQUEST["auctionid"])."'>".$lng_mailtomakepay2."</a></td>
				</tr>
				</table>";
			}*/
		
				$subject=$lng_mailsubjectacceptordenied;
				$from=$adminemailadd;
				$email = $objquery->email;
		
				SendHTMLMail2($email,$subject,$emailcont1,$from);
				header("location: wonauctions.html");
			}
		  }
		  else
		  {
		  	header("location: login.html?err=1");
		  }
		 }
		 else
		 {
		 	$err = 2;	
		 }
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
<title><?=$AllPageTitle;?></title>
<link href="css/style_youbid.css" rel="stylesheet" type="text/css" />
<link href="css/menu.css" rel="stylesheet" type="text/css" />
<!--[if lte IE 6]>
<link href="css/menu_ie.css" rel="stylesheet" type="text/css" />
<![endif]-->
<script language="javascript" type="text/javascript" src="js/function.js"></script>
<script language="javascript" type="text/javascript">
function CheckValue(f1)
{
	var wonstatus = f1.Accden.value;
	if(wonstatus=="")
	{
		alert("<?=$lng_js_plsselaccordenied;?>");
		f1.Accden.focus();
		return false
	}
}
</script>
</head>


<body>
<div id="main_div">
<?
	include("header.php");
?>
		<div id="middle_div">
		<div class="openAuction_bar_mainDIV">
			<div class="openAction_bar-left"></div>
			<div class="openAction_bar-middle"><div class="page_title_font"><?=$lng_wonauctionaccept;?></div></div>
			<div class="openAction_bar-right"></div>
		 </div>
		 <div class="openAuction_bar_mainDIV2">
		 	<div style="height: 20px;">&nbsp;</div>
				<div style="margin-left: 20px; padding-right: 10px; margin-top: 20px;" align="center">
					<div style="width: 400px;" align="center">
						<div align="center" style="padding-bottom: 15px; margin-top: 10px;" class="darkblue-text-17-b"><? echo $objsel->name;?></div>
						<?
						if($err==1)
						{
						?>
							<div style="margin-top: 10px; margin-left: 40px;" align="center" class="red-text-12-b"><?=$lng_acceptperiodover;?></div>
						<?
						}
						elseif($err==2)
						{
						?>
							<div style="margin-top: 10px;" align="center" class="red-text-12-b"><?=$lng_alreadyacceptdenied;?></div>
						<?
						}
						?>
						<br />
						<div style="width:270px;" align="center">
						<form name="login" action="" method="post" onsubmit="return CheckValue(this);">
								<div class="normal_text" style="height: 25px; clear:both" align="left"><?=$lng_username;?> :</div>
								<div class="style15" style="height: 25px; clear:both;" align="left"><input type="text" name="username" size="40" class="textboxclas" /></div>
								<div class="normal_text" style="height: 25px; clear:both; margin-top: 15px;" align="left"><?=$lng_password;?> : </div>
								<div class="style15" style="height: 25px; clear:both" align="left"><input type="password" name="password" size="40" class="textboxclas" /></div>
								<div class="normal_text" style="height: 25px; clear:both; margin-top: 20px; padding-bottom: 10px;" align="left"><?=$lng_acceptdenied;?> : 
								<select name="Accden">
										<option value=""><?=$lng_pleaseselect;?></option>
										<option value="Accepted"><?=$lng_onlyaccept;?></option>
										<option value="Denied"><?=$lng_onlydenied;?></option>
								</select>
								<input type="hidden" value="<?=$auctionID;?>" name="auctionid" />
								</div>
								<div style="padding-bottom: 10px; margin-top: 15px;" align="center"><input type="image" name="submit1" value="Submit1" src="<?=$lng_imagepath;?>submit_btn.png" onmouseout="this.src='<?=$lng_imagepath;?>submit_btn.png';" onmouseover="this.src='<?=$lng_imagepath;?>submit_hover_btn.png';" /></div>
								<input type="hidden" value="Submit" name="submit" />
						</form>
						</div>
					</div>
					</div>
			 </div>
		 <div class="openAuction_bar_bottom">
		 	<div class="openAuction_leftcorner"></div>
			<div class="openAuction_bar_middle"></div>
		 	<div class="openAuction_rightcorner"></div>
		 </div>
		</div>
<?
	include("footer.php");
?>		
</div>
</body>
</html>
