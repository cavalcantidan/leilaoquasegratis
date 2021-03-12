<?
	include("config/connect.php");
	
	$qryupd = "update login_logout set logout_time=NOW() where load_time='".$_SESSION["ipid"]."'";
	mysql_query($qryupd);
?>