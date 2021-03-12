<?
		include("config/connect.php");
		include("functions.php");
		$uid = $_SESSION["userid"];
/*		$auc_his_id = $_GET["auc_his_id"];
		$aucids = explode(',',$_GET["aids"]);
		$totcount = count($aucids);
		$temp = "";
		for($i=0;$i<$totcount;$i++)
		{
			if($i==$totcount-1)
			{
				$aucidsnew .= "'".$aucids[$i]."'";
			}
			else
			{
				$aucidsnew .= "'".$aucids[$i]."',"; 						
			}
		}
*/			$aucidsnew = '';
			foreach($_POST as $name => $value)
			{
				if($aucidsnew=='')
				{
					$aucidsnew .= "'".$value."'";
				}
				else
				{
					$aucidsnew .= ",'".$value."'";
	
				}	
			}
			
		$qrysel = "select * from auc_due_table adt left join auction a on a.auctionID=adt.auction_id where a.auctionID in (".$aucidsnew.") order by auc_due_time";
		$ressel = mysql_query($qrysel);
		$total = mysql_num_rows($ressel);
//		$counter = 0;
		for($i=1;$i<=$total;$i++)
		{
			$obj = mysql_fetch_object($ressel);
			$newtime = $obj->auc_due_time;
/*			$qry = "select pause_status from auction where auctionID=".$obj->auction_id;
			$r = mysql_query($qry);
			$ob = mysql_fetch_object($r);				
*/			$pstatus = $obj->pause_status;
			if($i==1)
			{
				$temp = '{"auction":{"id":"'.$obj->auction_id.'","time":"'.$newtime.'","pause":"'.$pstatus.'"}}';
//				$temp = $obj->auction_id.":".$newtime.":".$pstatus;
			}
			/*elseif($i==$total)
			{
				$temp .= "#".$obj->auction_id.":".$newtime.":".$pstatus;						
			}*/
			else
			{
				$temp .= ',{"auction":{"id":"'.$obj->auction_id.'","time":"'.$newtime.'","pause":"'.$pstatus.'"}}';
			}

		}
		echo "[".$temp."]";
?>
