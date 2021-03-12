<?
	include("config.inc.php");
	function arrangedate($date)
	{
		$year = substr($date,0,4);
		$month = substr($date,5,2);
		$day = substr($date,8,2);
		$date = $day."/".$month."/".$year;
		return $date;
	}

	function ChangeDateFormat($date)
	{
		$day = substr($date,0,2);
		$month = substr($date,3,2);
		$year = substr($date,6,4);
		$newdate = $year."-".$month."-".$day;
		return $newdate;
	}

	function ChangeDateFormatSlash($date)
	{
		$year = substr($date,0,4);
		$month = substr($date,5,2);
		$day = substr($date,8,2);
		$newdate = $day."/".$month."/".$year;	
		return $newdate;
	}	
	
    function ChangeDateBT($date,$tp)
	{
	   if ($tp='-'){
	       $dt = ChangeDateFormat($date).substr($date,10);
	   }else{
	       $dt = ChangeDateFormatSlash($date).substr($date,10);
	   }
       return $dt;
	}

    
	function getTotalTimeCategory($categoryID)
	{
		$qr1 = "select * from auction where categoryID='".$categoryID."' and auc_status='3'";
		$rs1 = mysql_query($qr1);
		$totalauc = mysql_num_rows($rs1);
		
		while($ob1 = mysql_fetch_object($rs1))
		{
			$qr2 = "select *,sum(bid_count) as totalbids from bid_account ba left join  auction a on a.auctionID=ba.auction_id left join auction_management am on am.auc_manage=a.time_duration where auction_id='".$ob1->auctionID."' and bid_flag='d' group by ba.auction_id";
			$rs2 = mysql_query($qr2);
			$ob2 = mysql_fetch_object($rs2);
			$plustime = ($ob2->totalbids * $ob2->auc_plus_time) + $newtime;
			$newtime = $plustime;
		}
		return $plustime."|".$totalauc;
	}
	
	function GetPayAmountAndAuctions($pid,$startdate,$enddate,$SMSCHARGE)
	{
		$qrysel = "select * from auction a left join products p on a.productId=p.productID where auc_start_date>='$startdate' and auc_end_date<='$enddate' and auc_status='3' and a.productID='$pid'";
		$rssel = mysql_query($qrysel);
		$total = mysql_num_rows($rssel);
		
		while($obj = mysql_fetch_object($rssel))
		{
			if($obj->fixedpriceauction=="1")
			{
				$fprice = $obj->auc_fixed_price;
			}
			elseif($obj->offauction=="1")
			{
				$fprice = "0.01";
			}
			else
			{
				$fprice = $obj->auc_final_price;
			}
			$finalprice = $fprice + $fpriceplus;
			$fpriceplus = $fprice;
			
			$priceinfo = explode("|",GetTotalBidsAmount($obj->auctionID,$SMSCHARGE));
			
			$biddingprice = $priceinfo[0] + $biddingprice1;
			$biddingprice1 = $biddingprice;

			$onlineprice = $priceinfo[1] + $onlineprice1;
			$onlineprice1 = $onlineprice;

			$smsprice = $priceinfo[2] + $smsprice1;
			$smsprice1 = $smsprice;
		}
		$totalprice = $finalprice + $biddingprice;
		return $totalprice."|".$total."|".$finalprice."|".$biddingprice."|".$onlineprice."|".$smsprice;
	}
	
	function GetTotalBidsAmount($aid,$SMSCHARGE)
	{
		$qr1 = "select *,sum(bid_count) as totalonlinebid from bid_account where auction_id='$aid' and bid_flag='d' and (bidding_type='s' or bidding_type='b') group by auction_id";
		$rs1 = mysql_query($qr1);
		$ob1 = mysql_fetch_object($rs1);
		$onlinebid = $ob1->totalonlinebid;
		$onlineprice = $onlinebid * 0.50;
		
		$qr2 = "select *,sum(bid_count) as totalsmsbid from bid_account where auction_id='$aid' and bid_flag='d' and bidding_type='m' group by auction_id";
		$rs2 = mysql_query($qr2);
		$ob2 = mysql_fetch_object($rs2);
		$smsbid = $ob2->totalsmsbid;
		$smsprice = $smsbid * $SMSCHARGE;
		
		$biddingprice = $onlineprice + $smsprice;

		return $biddingprice."|".$onlineprice."|".$smsprice;
	}

	function GetPayAmountAndAuctionsCategory($cid,$startdate,$enddate)
	{
		$qrysel = "select * from auction a left join categories c on a.categoryID=c.categoryID  where auc_start_date>='$startdate' and auc_end_date<='$enddate' and auc_status='3' and a.categoryID='$cid'";
		$rssel = mysql_query($qrysel);
		$total = mysql_num_rows($rssel);
		
		while($obj = mysql_fetch_object($rssel))
		{
			if($obj->fixedpriceauction=="1")
			{
				$fprice = $obj->auc_fixed_price;
			}
			else
			{
				$fprice = $obj->auc_final_price;
			}
			$finalprice = $fprice + $fpriceplus;
			$fpriceplus = $fprice;

			$priceinfo = explode("|",GetTotalBidsAmount($obj->auctionID,$SMSCHARGE));
			
			$biddingprice = $priceinfo[0] + $biddingprice1;
			$biddingprice1 = $biddingprice;

			$onlineprice = $priceinfo[1] + $onlineprice1;
			$onlineprice1 = $onlineprice;

			$smsprice = $priceinfo[2] + $smsprice1;
			$smsprice1 = $smsprice;
		}
		$totalprice = $finalprice + $biddingprice;
		return $totalprice."|".$total."|".$finalprice."|".$biddingprice."|".$onlineprice."|".$smsprice;
	}
	
		function GetTotalAmountAuction($aid,$SMSCHARGE)
		{
			$qrysel = "select *,sum(bid_count) as totalonlinebid from bid_account where bid_flag='d' and auction_id='$aid' and (bidding_type='s' or bidding_type='b') group by auction_id";
			$ressel = mysql_query($qrysel);
			$objsel = mysql_fetch_object($ressel);
			$totalonline = $objsel->totalonlinebid * 0.50;

			$qrysel1 = "select *,sum(bid_count) as totalsmsbid from bid_account where bid_flag='d' and auction_id='$aid' and bidding_type='m' group by auction_id";
			$ressel1 = mysql_query($qrysel1);
			$objsel1 = mysql_fetch_object($ressel1);
			$totalsms = $objsel1->totalsmsbid * $SMSCHARGE;
			return $totalonline."|".$totalsms;			
		}


	function getFirstBidTime($aucstartdate,$aucstarttime,$aucendtime)
		{
			$infodata = explode(" ",$aucendtime);
			
			$aucenddate = substr($infodata[0],8);
			$aucstartdate = substr($aucstartdate,8);
			
			$aucstarthour = substr($aucstarttime,0,2);
			$aucendhour = substr($infodata[1],0,2);
			
			$aucstartmin = substr($aucstarttime,3,2);
			$aucendmin = substr($infodata[1],3,2);
			
			$aucstartsec = substr($aucstarttime,6,2);
			$aucendsec = substr($infodata[1],6,2);
			
			if($aucenddate>$aucstartdate)
			{
				$diff = $aucenddate-$aucstartdate;
				$aucendhour = $aucendhour + ((24*$diff)-$aucstarthour);
			}
			else
			{
				$aucendhour = $aucendhour - $aucstarthour;
			}
			
			if($aucendmin<$aucstartmin)
			{
				$aucendhour = $aucendhour - 1;
				$aucendmin1 = $aucendmin + 60;
				$aucendmin = $aucendmin1 - $aucstartmin;
			}
			else
			{
				$aucendmin = $aucendmin - $aucstartmin;
			}
			
			if($aucendsec<$aucstartrsec)
			{
				$aucendmin = $aucendmin - 1;
				$aucendsec1 = $aucendsec + 60;
				$aucendsec = $aucendsec1 - $aucendsec;
			}
			else
			{
				$aucendsec = $aucendsec - $aucstartsec;
			}
			$finalsec = ($aucendhour * 60 * 60) + ($aucendmin * 60) + $aucendsec;
			return $finalsec;
		}
		
		function AverageFirstBidTime($cid)
		{
			$qr = "select * from auction where categoryID='$cid'";
			$rs = mysql_query($qr);
			$totalauction = mysql_num_rows($rs);
			while($ob = mysql_fetch_object($rs))
			{
				$qr1 = "select * from bid_account where bid_flag='d' and auction_id='".$ob->auctionID."'  order by id desc limit 0,1";
				$rs1 = mysql_query($qr1);
				$total1 = mysql_num_rows($rs1);
				$ob1 = mysql_fetch_object($rs1);
			
				$timeduration = getFirstBidTime($ob->auc_start_date,$ob->auc_start_time,$ob1->bidpack_buy_date) + $timeduration1;
				$timeduration1 = $timeduration;
			}
			return $timeduration."|".$totalauction;
		}
		
	function GetFinalLoginLogoutTime($startdate,$enddate)
	{
		$infodatastart = explode(" ",$startdate);
		$infodataend = explode(" ",$enddate);

		$aucstartdate = substr($infodatastart[0],8);
		$aucenddate = substr($infodataend[0],8);
		
		$starttime = explode(":",$infodatastart[1]);
		$endtime = explode(":",$infodataend[1]);
		
		$aucstarthour = $starttime[0];
		$aucendhour = $endtime[0];
		
		$aucstartmin = $starttime[1];
		$aucendmin = $endtime[1];
		
		$aucstartsec = $starttime[2];
		$aucendsec = $endtime[2];
		
/*		echo $aucstarthour.":".$aucstartmin.":".$aucstartsec."<br>";
		echo "end::".$aucendhour.":".$aucendmin.":".$aucendsec."<br>";*/
			if($aucenddate>$aucstartdate)
			{
				$diff = $aucenddate-$aucstartdate;
				$aucendhour = $aucendhour + ((24*$diff)-$aucstarthour);
			}
			else
			{
				$aucendhour = $aucendhour - $aucstarthour;
			}
			
			if($aucendmin<$aucstartmin)
			{
				$aucendhour = $aucendhour - 1;
				$aucendmin1 = $aucendmin + 60;
				$aucendmin = $aucendmin1 - $aucstartmin;
			}
			else
			{
				$aucendmin = $aucendmin - $aucstartmin;
			}
			
			if($aucendsec<$aucstartrsec)
			{
				$aucendmin = $aucendmin - 1;
				$aucendsec1 = $aucendsec + 60;
				$aucendsec = $aucendsec1 - $aucendsec;
			}
			else
			{
				$aucendsec = $aucendsec - $aucstartsec;
			}
			$finalsec = ($aucendhour * 60 * 60) + ($aucendmin * 60) + $aucendsec;
			return $finalsec;
	}

	function getTotalTimeLogin($uid,$startdate,$enddate)
	{
		$qr = "select *,DATE_FORMAT(login_time, '%Y-%m-%d')  AS logindate,DATE_FORMAT(logout_time, '%Y-%m-%d') as logoutdate from login_logout where user_id='".$uid."' and login_time>='$startdate 00:00:01' and logout_time<='$enddate 23:59:59'";
		$rs = mysql_query($qr);
		$tot =mysql_num_rows($rs);
		while($objtime = mysql_fetch_object($rs))
		{
			$gettime = GetFinalLoginLogoutTime($objtime->login_time,$objtime->logout_time);
			$totaltime = $gettime + $totaltimeplus;
			$totaltimeplus = $totaltime;
		}
		return $tot."|".$totaltime;
	}

function hesk_input($in) {

    $in = trim($in);

    if (strlen($in))
    {
        $in = htmlspecialchars($in);
        $in = preg_replace('/&amp;(\#[0-9]+;)/','&$1',$in);
    }
/*    elseif ($error)
    {
        hesk_error($error);
    }
*/
    if (!ini_get('magic_quotes_gpc'))
    {
        if (!is_array($in))
            $in = addslashes($in);
        else
            $in = hesk_slashArray($in);
    }

    return $in;

} // END hesk_input()
/***************************
Function hesk_slashArray()
***************************/
function youraff_slashArray ($a)
{
    while (list($k,$v) = each($a))
    {
        if (!is_array($v))
            $a[$k] = addslashes($v);
        else
            $a[$k] = hesk_slashArray($v);
    }

    reset ($a);
    return ($a);
} // END hesk_slashArray()
	function getTotalTimeLogin1($uid,$startdate,$enddate)
	{
		$qr = "select *,DATE_FORMAT(login_time, '%Y-%m-%d')  AS logindate,DATE_FORMAT(logout_time, '%Y-%m-%d') as logoutdate from login_logout where user_id='".$uid."' and login_time>='$startdate' and logout_time<='$enddate'";
		$rs = mysql_query($qr);
		$tot =mysql_num_rows($rs);
		
		while($objtottime = mysql_fetch_object($rs))
		{
			if($objtottime->logout_time!="" && $objtottime->logout_time!="0000-00-00 00:00:00")
			{
				$totaltime = (strtotime($objtottime->logout_time) - strtotime($objtottime->login_time)) + $finaltottime;
			}
			$finaltottime = $totaltime;
		}
		return $tot."|".$finaltottime;
	}
	function GetTotalAuctionForCat($cat,$startdate,$enddate)
	{
		$qrysel = "select * from auction a left join products p on a.productId=p.productID where auc_start_date>='$startdate' and auc_end_date<='$enddate' and auc_status='3' and a.categoryID='$cat'";
		$rssel = mysql_query($qrysel);
		$total = mysql_num_rows($rssel);
		return $total;
	}

function GetBidsDetails($aid)
{
	$qrysel = "select *,sum(bid_count) as totalbids from bid_account ba left join registration r on ba.user_id=r.id where auction_id='".$aid."' and bid_flag='d' and r.admin_user_flag='0' group by auction_id";
	$ressel = mysql_query($qrysel);
	$objsel = mysql_fetch_object($ressel);

	$qrysel1 = "select *,sum(bid_count) as totalbids from bid_account ba left join registration r on ba.user_id=r.id where auction_id='".$aid."' and bid_flag='d' and r.admin_user_flag='1' group by auction_id";
	$ressel1 = mysql_query($qrysel1);
	$objsel1 = mysql_fetch_object($ressel1);

	return $objsel->totalbids."|".$objsel1->totalbids;
}

function GetProductName($pid)
{
	$qrysel = "select * from products where productID='".$pid."'";
	$ressel = mysql_query($qrysel);
	$objsel = mysql_fetch_object($ressel);
	
	return stripslashes($objsel->name);
}
?>