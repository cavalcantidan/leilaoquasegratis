<?
include("config/connect.php");
include("session.php");
include("functions.php");

$uid = $_SESSION['userid'];
//https://www.paypal.com/us/cgi-bin/webscr
$notsendshipping = 0;
$winid=base64_decode($_REQUEST['winid']);
$voucheridinfo = explode(",",$_REQUEST["voucher"]);
$voucherid = $voucheridinfo[0];
$usevoucherid = $voucheridinfo[1];
//echo $str;
$snew=explode("&",$winid);
$amt=$snew[0];
$waucid=$snew[1];
$businessid = getPaypalInfo(1);

if($voucherid!="" && $_REQUEST["novoucher"]=="")
{
	$qryvou = "select * from vouchers where id='".$voucherid."'";
	$resvou = mysql_query($qryvou);
	$objvou = mysql_fetch_object($resvou);
	$amt1 = $amt - $objvou->bids_amount;
	if($amt1>0)
	{
		$amt = $amt1;
	}
	else
	{
		$amt = "0.00";
	}
}
if($_REQUEST["novoucher"]=="")
{
	$waucid .= "|".$usevoucherid;
}

$qrysel = "select * from won_auctions w left join auction a on w.auction_id=a.auctionID  left join products p on a.productID=p.productID where w.userid='".$uid."' and a.auctionID='".$waucid."'";
$ressel = mysql_query($qrysel);
$total = mysql_num_rows($ressel);

if($total>0)
{
	$rowauctionname = mysql_fetch_array($ressel);
	$auctionname = $rowauctionname['name'];
	$shipping = getshipping($rowauctionname['shipping_id']);
}

if($amt<=0)
{
	$amt = $shipping;
	$notsendshipping = 1;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
<title><?=$AllPageTitle;?></title>
<script language='javascript'>
function frmnew()
{ 
	document._xclick.submit();
}
</script>
</head>

<body onload="frmnew();">
<!--<form name="_xclick" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">-->
<form name="_xclick" action="https://www.paypal.com/br/cgi-bin/webscr" method="post">											
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="<?=$businessid;?>">
<input type="hidden" name="return" value="<?=$SITE_URL;?>paymentsuccess.php">
<input type="hidden" name="cancel_return" value="<?=$SITE_URL;?>paymentunsuccess.php">
<input type="hidden" name="currency_code" value="BRL" />
<input type="hidden" name="item_name" value="<?=$auctionname;?>">
<input type="hidden" name="quantity" value="1">
<? if($notsendshipping==0){  ?>
<input type="hidden" name="shipping" value="<?=$shipping;?>" />
<? } ?>
<input type="hidden" name="amount" value="<?=$amt;?>">
<input type="hidden" name="custom" value="<?=$waucid;?>" >
</form>
</body>
</html>