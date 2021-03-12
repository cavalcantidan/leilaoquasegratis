<?
	include("config/connect.php");
	include("session.php");
	$uid = $_SESSION["userid"];
	
	$id = $_GET["delid"];	
	
	if($id!="" && $uid!="")
	{
		$qrysel="select * from bidbutler b left join auction a on a.auctionID=b.auc_id where b.id='$id' and b.butler_status='0'";
		$ressel = mysql_query($qrysel);
		$totalf = mysql_num_rows($ressel);
		$obj = mysql_fetch_object($ressel);
		
		if($obj->used_bids==0 && $obj->butler_status==0 && $totalf>0)
		{
			$aucid = $obj->auc_id;
			$qryd = "update bidbutler set butler_status='1' where id='$id' and used_bids=0";
			mysql_query($qryd) or die(mysql_error());
			
			$qryreg = "select * from registration where id='$uid'";
			$resreg = mysql_query($qryreg);
			$objreg = mysql_fetch_object($resreg);
			$fbids = $objreg->final_bids;
			$pbids = $obj->butler_bid;			
			$finalbids = $fbids + $pbids;
			
			$qryins = "Insert into bid_account (user_id,bidpack_buy_date,bid_count,auction_id,product_id,bid_flag) values('$uid',NOW(),'$pbids','".$aucid."','".$obj->productID."','b')";
			mysql_query($qryins) or die(mysql_error());
			
				$qryupd = "update registration set final_bids='$finalbids' where id='$uid'";
				mysql_query($qryupd) or die(mysql_error());
	
			$qrysel = "select * from bidbutler where user_id='$uid' and auc_id='$aucid' and butler_status='0' order by id desc limit 0,20";
			$ressel = mysql_query($qrysel);
			$total = mysql_num_rows($ressel);
			
			for($i=1;$i<=$total;$i++)
			{
				$obj = mysql_fetch_object($ressel);
				if($i==1)
				{
					$bidbutler = '{"bidbutler":{"startprice":"'.$obj->butler_start_price.'","endprice":"'.$obj->butler_end_price.'","bids":"'.$obj->butler_bid.'","id":"'.$obj->id.'","usedbids":"'.$obj->used_bids.'"}}';
				}
				else
				{
					$bidbutler .= ',{"bidbutler":{"startprice":"'.$obj->butler_start_price.'","endprice":"'.$obj->butler_end_price.'","bids":"'.$obj->butler_bid.'","id":"'.$obj->id.'","usedbids":"'.$obj->used_bids.'"}}';
				}
			}
	
				echo '{"butlerslength":['.$bidbutler.']}';
		}
		else
		{
			echo '[{"result":"unsuccess"}]';
		}
	}
?>