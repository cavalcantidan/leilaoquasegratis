<?
	include("config/connect.php");
	if($_SESSION["userid"]==""){
		header("location: login.html");
		exit;
	}
?>