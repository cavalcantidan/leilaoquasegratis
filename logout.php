<?php
	include("config/connect.php");	
	if($_SESSION["ipid"]!=""){
		$qryipupd = "update login_logout set logout_time=NOW() where load_time='".$_SESSION["ipid"]."'";
		mysql_query($qryipupd) or die(mysql_error());
	}
	$_SESSION["login_logout"] = $_SESSION["ipid"];
	session_unregister('userid');
	session_unregister('username');
	session_unregister('ipid');
	session_unregister('url');
	//session_destroy();
	echo "<script language='javascript'>window.parent.location.replace('index.html');</script>";
	exit;
?>