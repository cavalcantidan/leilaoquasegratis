<?
	include_once("admin.config.inc.php");
	include("connect.php");
	include("security.php");

	$aucid = $_GET["aucid"];
	$aucidstart = $_GET["aucidstart"];
	
	if($aucid!="")
	{	
		$qryupd = "update auction set pause_status='1' where auctionID='".$aucid."'";
		mysql_query($qryupd) or die(mysql_error());
		echo "success|".$aucid;
	}
	elseif($aucidstart!="")
	{
		$qryupd = "update auction set pause_status='0' where auctionID='".$aucidstart."'";
		mysql_query($qryupd) or die(mysql_error());
		echo "success|".$aucidstart;
	}
	else
	{
		echo "unsuccess";
	}
?>