<?
	include("config/connect.php");
	include("session.php");
	
	$aucid = $_GET["aid"];
	$uid = $_SESSION["userid"];

	if($uid!=""){	
		$qrysel = "select * from watchlist where user_id='$uid' and auc_id='$aucid'";
		$ressel = mysql_query($qrysel);
		$total = mysql_num_rows($ressel);
		if($total==0){
			$qryins = "insert into watchlist (user_id,auc_id) values('$uid','$aucid')";
			mysql_query($qryins) or die(mysql_error());	
		}
	}
?>