<?
include("config/connect.php");
include("session.php");
include("functions.php");

$uid = $_SESSION['userid'];

$bid=base64_decode($_REQUEST['bpid']);
$businessid = getPaypalInfo(1);
//echo $str;
//exit;
//https://www.paypal.com/us/cgi-bin/webscr

$qrysel = "select * from bidpack where id='$bid'";
$ressel = mysql_query($qrysel);
$total = mysql_num_rows($ressel);
if($total>0)
{
	$rowauctionname = mysql_fetch_array($ressel);
	$bidpackname = $rowauctionname['bidpack_name'];
	$amt = $rowauctionname['bidpack_price'];
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
<!--<form name="_xclick" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">	-->		
<form name="_xclick" action="https://www.paypal.com/br/cgi-bin/webscr" method="post">							
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="<?=$businessid;?>">
<input type="hidden" name="return" value="<?=$SITE_URL;?>thankyou.php">
<input type="hidden" name="cancel_return" value="<?=$SITE_URL;?>buybidsunsuccess.php">
<input type="hidden" name="currency_code" value="BRL" />
<input type="hidden" name="item_name" value="<?=$bidpackname;?> - usuario:<?=getUserName($_SESSION["userid"]);?>"?>"?>">
<input type="hidden" name="amount" value="<?=$amt;?>">
<!--<input type="hidden" name="amount" value="0.01">-->
<input type="hidden" name="custom" value="<?=$bid."_".$uid;?>"?>"?>"?>"?>" >
</form>
</body>
</html>
