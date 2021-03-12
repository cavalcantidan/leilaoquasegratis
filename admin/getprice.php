<?
	include("connect.php");
	include("security.php");
	if($_GET["prid"]!="")
	{
		$prid = $_GET["prid"];
		$qrysel = "select price from products where productID='$prid'";
		$res = mysql_query($qrysel);
		$totalrow = mysql_affected_rows();
		$row = mysql_fetch_object($res);
		echo $row->price;
	}
?>