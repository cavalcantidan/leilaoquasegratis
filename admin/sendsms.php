<?

	include("config/connect.php");
	include("functions.php");

	$oldfifteen = time() - 900;
	
	$qryauc = "select * from auction where auc_status='2' and future_tstamp between '$oldfifteen' and '".time()."'";
	$resauc = mysql_query($qryauc);
	$totalauc = mysql_num_rows($resauc);
	echo $totalauc;
	exit;
	while($objauc = mysql_fetch_object($resauc))
	{
		echo SendAuctionSMS($objauc->auctionID);
	}

	function CallCurlFunc($req)
	{
		$request = $req;
		//this is the url of the gateway's interface
		$url = "http://195.178.62.120/send.asp";
		//initialize curl handle
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url); //set the url
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); //return as a variable
		curl_setopt($ch, CURLOPT_POST, 1); //set POST method
		curl_setopt($ch, CURLOPT_POSTFIELDS, $request); //set the POST variables
		$response = curl_exec($ch); //run the whole process and return the response
		curl_close($ch); //close the curl handle
		//show the result onscreen for debugging
		//print $response;
		return $response;
	}

	function SendAuctionSMS($aid)
	{
		global $SMSUSERNAME;
		global $SMSPASSWORD;
		global $SITE_URL;
		
		$qry = "select * from auction_sms where date='".date("Y-m-d")."'";
		$rs = mysql_query($qry);
		$ob = mysql_fetch_object($rs);
		$total = mysql_num_rows($rs);
		
		$qrysetting = "select * from general_setting where id='1'";
		$ressetting = mysql_query($qrysetting);
		$objsetting = mysql_fetch_object($ressetting);
			
		if($total==0)
		{
			$qryins = "Insert into auction_sms (date,sms_count) values(NOW(),'0')";
			mysql_query($qryins) or die(mysql_error());

			$qry = "select * from auction_sms where date='".date("Y-m-d")."'";
			$rs = mysql_query($qry);
			$ob = mysql_fetch_object($rs);
		}
		
		$usedsms = $ob->sms_count;
		$totalsms = $objsetting->perday_sms;

		if($usedsms<$totalsms)
		{
			$qryaucname = "select * from auction a left join products p on a.productID=p.productID where a.auctionID='$aid'";
			$resaucname = mysql_query($qryaucname);
			$objaucname = mysql_fetch_object($resaucname);
		
			$qrysel = "select * from registration where account_status='1' and member_status='0' and user_delete_flag!='d' and sms_flag='1'";
			$ressel = mysql_query($qrysel);
			$total = mysql_num_rows($ressel);

			while($objuser = mysql_fetch_object($ressel))
			{
				$mobileno = substr($objuser->full_mobileno,1);
				$text = $objaucname->name;

				$request = "user=".urlencode($SMSUSERNAME)."&pass=".urlencode($SMSPASSWORD)."&display=auctions&phone=".urlencode($mobileno)."&sms=".urlencode($text)."&id=".urlencode($objaucname->auctionID)."&ip=".urlencode($SITE_URL."smsbulknotify.php");
				if($msgresponse!=2)
				{
					$msgresponse = CallCurlFunc($request);
				}
				echo $mobileno."<br>";
			}

			if($msgresponse==2)
			{
				SendMailToAdmin();
			}
			
			$qryupd = "update auction_sms set sms_count=sms_count + 1 where id='".$ob->id."'";
			mysql_query($qryupd) or die(mysql_error());
		}
	}
?>