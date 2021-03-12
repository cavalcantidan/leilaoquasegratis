<?
include("config/connect.php");
include("session.php");
include("functions.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
<title><?=$AllPageTitle;?></title>

<?
if($_POST['Submit']!=""){
    $accden = $_POST['Accden'];
    $mailpayflag = 0;
    $qrysel = "select *,p.".$lng_prefix."name as name from auction a left join products p on a.productID=p.productID  left join registration r on a.buy_user=r.id where a.auctionID='".$_REQUEST["auctionid"]."'";
	$ressel = mysql_query($qrysel);
	$objsel = mysql_fetch_object($ressel);
    if($accden=='Accepted'){ $situacaodescr = ''; }else{ $situacaodescr = 'Recusado pelo ganhador'; } 
    $Updateqry = "update won_auctions set accept_denied='".$accden."', accept_date=NOW(), situacaodescr = '$situacaodescr'
                    where userid='".$_SESSION["userid"]."' and auction_id='".$_REQUEST["auctionid"]."'";
    mysql_query($Updateqry) or die(mysql_error());
	if($objsel->offauction==1 || $objsel->fixedpriceauction==1){
		$qryshipping = "select * from shipping where id='".$objsel->shipping_id."'";
		$resshipping = mysql_query($qryshipping);
		$objshipping = mysql_fetch_object($resshipping);
		if($objsel->offauction==1){
			$totalamount = $objshipping->shippingcharge;
			if($totalamount<=0){
				$paymentdate = date("Y-m-d H:i:s");
				$qryupd = "update won_auctions set payment_date='".$paymentdate."' where auction_id='".$_REQUEST["auctionid"]."' and userid='".$_SESSION["userid"]."'";
				mysql_query($qryupd) or die(mysql_error());
				$paymentdate2 = arrangedate(substr($paymentdate,0,10))."<br>".substr($paymentdate,11);
				$mailpayflag = 1;
			}
		}
		if($objsel->fixedpriceauction==1){
			$totalamount = $objsel->auc_fixed_price + $objshipping->shippingcharge;
			if($totalamount<=0){
				$paymentdate = date("Y-m-d H:i:s");
				$qryupd = "update won_auctions set payment_date='".$paymentdate."' where auction_id='".$_REQUEST["auctionid"]."' and userid='".$_SESSION["userid"]."'";
				mysql_query($qryupd) or die(mysql_error());
				$paymentdate2 = arrangedate(substr($paymentdate,0,10))."<br>".substr($paymentdate,11);
				$mailpayflag = 1;
			}
		}
	}
	if($objsel->fixedpriceauction==1) { $winprice = $objsel->auc_fixed_price; }
	elseif($objsel->offauction==1) { $winprice = "0.01"; }
	else { $winprice = $objsel->auc_final_price; }
	$username = getUserName($_SESSION["userid"]);
	$mailwithauctionid = $_REQUEST["auctionid"];
	$auction_name = $objsel->name;
	$auction_price = $Currency.number_format($winprice,2);
	$winingdate = date("d/m/Y",time());
	$encode_auctionid = base64_encode($_REQUEST["auctionid"]);
	if($accden==$lng_onlyaccept){
		$emailcont1 = sprintf($lng_emailcontent_acceordeaccept,$username,$mailwithauctionid,$auction_name,$auction_price,$winingdate);
	}elseif($accden=='Accepted' && $mailpayflag==0){
		$emailcont1 = sprintf($lng_emailcontent_acceordeflag,$username,$mailwithauctionid,$auction_name,$auction_price,$winingdate,$encode_auctionid);
	}else{
		$emailcont1 = sprintf($lng_emailcontent_acceordedenied,$username,$mailwithauctionid,$auction_name,$auction_price,$winingdate);
	}
	$subject=$lng_mailsubjectacceptordenied;
	$from=$adminemailadd;
	$email = $objsel->email;
	SendHTMLMail2($email,$subject,$emailcont1,$from);
    //echo '<script language="javascript"> ;</script>';
    echo '<meta http-equiv="refresh" content="1;url=wonauctions.html" />';
    exit;
}
?>
<script language="javascript" type="text/javascript">
function CheckValue(f1){
	var wonstatus = f1.Accden.value;
	var acceptordenied = '<?=$lng_plsselaccordenied;?>';
	if(wonstatus==""){
		alert(acceptordenied);
		f1.Accden.focus();
		return false
	}
}
</script>
</head>
<body>
<form name="AcceptWon" action="" id="AcceptWon" method="post" onsubmit="return CheckValue(this);">
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
<td>
<table align="center" border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td colspan="2"><b><?=$lng_wonauctionaccept;?></b></td>
	</tr>
	<tr>
		<td height="5"></td>
	</tr>
	<tr>
		<td><?=$lng_acceptdenied;?>: </td>
		<td>
		<select name="Accden">
		<option value=""><?=$lng_pleaseselect;?></option>
		<option value="Accepted"><?=$lng_onlyaccept;?></option>
		<option value="Denied"><?=$lng_onlydenied;?></option>
		</select>
		</td>
	</tr>
	<tr>
		<td height="10"></td>
	</tr>
	<tr>
		<td align="center" colspan="2">
		<input type="image" name="submit1" src="<?=$lng_imagepath;?>submit_btn.png" onmouseover="this.src='<?=$lng_imagepath;?>submit_hover_btn.png'" onmouseout="this.src='<?=$lng_imagepath;?>submit_btn.png'" />
		<input type="hidden" name="Submit" value="Submit" /></td>
	</tr>
</table>
</td>
</tr>
</table>
<input type="hidden" name="auctionid" value="<?=$_REQUEST['auctionid'];?>" />
</form>
</body>
</html>
