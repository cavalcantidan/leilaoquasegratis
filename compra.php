<?
	include("config/connect.php");
	include("config/connect.php");
	include("functions.php");
	$auctionID = $_REQUEST["actionID"];
	$produtoName = $_REQUEST["produtoName"];
	$produtoFrete = $_REQUEST["produtoFrete"];
	$aucid = $_REQUEST["aid"];
	$prid = $_REQUEST["pid"];

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
$seguroid = getseguroInfo(1);

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
$qryselPreco = "select *,p.".$lng_prefix."name as name,".$lng_prefix."short_desc as short_desc,".$lng_prefix."long_desc as long_desc from products p left join auction a on p.productID=a.productID  left join auc_due_table adt on a.auctionID=adt.auction_id left join registration r on a.buy_user=r.id left join shipping s on a.shipping_id=s.id  left join auction_management am on am.auc_manage=a.time_duration where a.auctionID='".$auctionID."'";
$resselPreco = mysql_query($qryselPreco);
$totalPreco = mysql_num_rows($resselPreco);
$objPreco = mysql_fetch_object($resselPreco);

$qryselLance = "select *,sum(bid_count) as totalbid from bid_account where auction_id='".$auctionID."' and bid_flag='d' and bidding_type='s' and user_id='".$uid."' group by auction_id";	
$resselLance = mysql_query($qryselLance);
$objLance = mysql_fetch_object($resselLance);

$qrysel = "select * from won_auctions w left join auction a on w.auction_id=a.auctionID  left join products p on a.productID=p.productID where w.userid='".$uid."' and a.auctionID='".$auctionID."'";
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
<!--<form name="_xclick" action="https://pagseguro.uol.com.br/checkout/checkout.jhtml" method="post">-->
<form name="_xclick" action="https://pagseguro.uol.com.br/checkout/checkout.jhtml" method="post">											
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="email_cobranca" value="<?=$seguroid;?>">
<input type="hidden" name="tipo" value="CP">
<input type="hidden" name="return" value="<?=$SITE_URL;?>paymentsuccess.php">
<input type="hidden" name="cancel_return" value="<?=$SITE_URL;?>paymentunsuccess.php">
<input type="hidden" name="moeda" value="BRL" />
<input type="hidden" name="item_descr_1" value="<?=$produtoName;?> - (Compre Agora) - usuario:<?=getUserName($_SESSION["userid"]);?>"?>"?>"?>"?>"?>
<input type="hidden" name="item_quant_1" value="1">
<? if ($produtoFrete == null) {
	$produtoFrete = 0;
} ?>
<input type="hidden" name="item_frete_1" value="<?=$produtoFrete;?>" />
<?
$lances = $objLance->totalbid * 0.65;
$valor  = $objPreco->price;
$total  = ($valor - $lances) * 100;
?>
<input type="hidden" name="item_valor_1" value="<?=$total ;?>"/>
<input type="hidden" name="item_id_1" value="<?=$waucid;?>" >
</form>
</body>
</html>
