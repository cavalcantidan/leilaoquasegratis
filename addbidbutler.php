<?
	include("config/connect.php");
	include("session.php");

	$aid = $_GET["aid"];	
	$user = $_SESSION["userid"];
	$bidsp = $_GET["bidsp"];
	$bidep = $_GET["bidep"];
	$totb = $_GET["totb"];

if($user!="" && $aid!="")
{
	$qrybid = "select * from bid_account where auction_id='$aid' and bid_flag='d' order by id desc limit 0,1";
	$resbid = mysql_query($qrybid);
	$objbid = mysql_fetch_object($resbid);
	$runprice = $objbid->bidding_price;
	
	if($runprice=="")
	{
		$qryprc = "select * from auc_due_table where auction_id='$aid'";
		$resprc = mysql_query($qryprc);
		$objprc = mysql_fetch_object($resprc);
		$runprice = $objprc->auc_due_price;
	}
	
	if(floatval($runprice)>=floatval($bidsp))
	{
		echo '[{"result":"unsuccessprice"}]';
		exit;
	}

	$qrys = "select * from registration where id='$user'";
	$res = mysql_query($qrys);
	$ob = mysql_fetch_object($res);
	$fb = $ob->final_bids;
	if($fb==0 || $fb<$totb)
	{
		echo '[{"result":"unsuccess"}]';
		exit;
	}

	$qryins = "insert into bidbutler (auc_id,user_id,butler_start_price,butler_end_price,butler_bid,butler_status,place_date) values('$aid','$user','$bidsp','$bidep','$totb','0',NOW())";
	mysql_query($qryins) or die(mysql_error());	
	$id = mysql_insert_id();

	$qryselreg = "select * from registration where id='$user'";
	$resselreg = mysql_query($qryselreg);
	$objreg = mysql_fetch_object($resselreg);

		$fbids = $objreg->final_bids;
		$finalbids = $fbids-$totb;

		$qryupd = "update registration set final_bids='$finalbids' where id='$user'";
		mysql_query($qryupd) or die(mysql_error());
	
	$qrysel = "select * from bidbutler where user_id='$user' and auc_id='$aid' and butler_status='0' order by id desc limit 0,20";
	$ressel = mysql_query($qrysel);
	$total = mysql_num_rows($ressel);
	
	for($i=1;$i<=$total;$i++)
	{
		$obj = mysql_fetch_object($ressel);
		if($i==1)
		{
			$bidbutler = '{"bidbutler":{"startprice":"'.$obj->butler_start_price.'","endprice":"'.$obj->butler_end_price.'","bids":"'.$obj->butler_bid.'","id":"'.$obj->id.'"}}';
		}
		else
		{
			$bidbutler .= ',{"bidbutler":{"startprice":"'.$obj->butler_start_price.'","endprice":"'.$obj->butler_end_price.'","bids":"'.$obj->butler_bid.'","id":"'.$obj->id.'"}}';
		}
	}
	echo '{"butlerslength":['.$bidbutler.']}';
}
?>