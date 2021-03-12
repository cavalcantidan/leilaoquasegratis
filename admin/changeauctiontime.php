<?
	include("connect.php");
	include_once("admin.config.inc.php");
	include("security.php");
	include("config_setting.php");

	if($_POST["edit"]!="")
	{
		$title = $_POST["auctitle"];
		$price = $_POST["aucplusprice"];
		$time = $_POST["aucplustime"];
		$id = $_POST["editid"];
		
		if($id==1)
		{
		$qryupd = "update auction_management set auc_plus_price=$price, auc_plus_time=$time where id=$id";
		}
		else
		{
		$qryupd = "update auction_management set auc_title='$title', auc_plus_price=$price, auc_plus_time=$time where id=$id";
		}
		mysql_query($qryupd) or die(mysql_error());
		header("location: message.php?msg=38");
		exit;
	}
?>