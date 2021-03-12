<?
  include("config/connect.php");
  include("functions.php");
  if($_GET["auc_key"]!="")
  {
//  	$uid = base64_decode($_GET["auc_key"]);
//  	$username = base64_decode($_GET["un"]);
//	$passs = base64_decode($_GET["pn"]);
	$auckey = $_GET["auc_key"];
	$confirmemail = 1;
	$qryupd = "update registration set account_status='1' where verify_code='$auckey'";
	mysql_query($qryupd) or die(mysql_error());
	
	$qryvoucher = "select * from vouchers where newuser_flag='1'";
	$resvoucher = mysql_query($qryvoucher);
	$totalvoucher = mysql_num_rows($resvoucher);
	if($totalvoucher>0)
	{
		$objvoucher = mysql_fetch_object($resvoucher);
		$voucherdesc = $objvoucher->voucher_title;
		if($objvoucher->validity>0)
		{
			$voucherdesc .= " (valid for ".$objvoucher->validity." days)";
			$expirydate = AcceptDateFunctionStatus_Voucher(date("Y-m-d H:i:s",time()),$objvoucher->validity);
			$qryinsv = "Insert into user_vouchers  (user_id,voucherid,issuedate,expirydate,voucher_status,voucher_desc) values('".$uid."','".$objvoucher->id."',NOW(),'".$expirydate."','0','".$voucherdesc."');";
			mysql_query($qryinsv) or die(mysql_error());
		}
		
	}
	
	 $query="select * from registration where verify_code='$auckey' and account_status='1' and user_delete_flag<>'d'";
  }
  
  elseif($_GET["ud"]!="" && $_GET["pd"]!="" && $_GET["key"]!="")
  {
  	$username = base64_decode($_GET["ud"]);
	$pass = base64_decode($_GET["pd"]);
	  $query="select * from registration where username='$username' and password='$pass' and account_status='1' and user_delete_flag<>'d'";
  }
  
  else
  {
  $username = $_POST["username"];
  $pass = $_POST["password"];

  $query="select * from registration where username='$username' and password='$pass' and account_status='1' and user_delete_flag<>'d'";
  }
  
  $result=mysql_query($query);
  $total = mysql_num_rows($result);
  $ress = mysql_fetch_object($result);
 if($total>0)
  {
  	if($ress->member_status=="0" && $ress->user_delete_flag!='d')
	{
	  $_SESSION["username"]=$ress->username;
	  $_SESSION["userid"]=$ress->id;
	  $_SESSION['url'] = $SITE_URL;
	  $_SESSION["sessionid"] = session_id();
	  
			if($_SESSION["ipid"]!="")
			{
				$qryipupd = "update login_logout set user_id='".$_SESSION["userid"]."',login_time=NOW() where load_time='".$_SESSION["ipid"]."'";
				mysql_query($qryipupd) or die(mysql_error());
			}
			else
			{
				$_SESSION["ipaddress"] = $_SERVER['REMOTE_ADDR'];
				$qryinsip = "insert into login_logout (user_id,ipaddress,login_time,load_time) values('".$_SESSION["userid"]."','".$_SESSION["ipaddress"]."',NOW(),NOW())";
				mysql_query($qryinsip) or die(mysql_error());
				$_SESSION["ipid"]=date("Y-m-d H:i:s",time());
				session_unregister("login_logout");
			}
	  
	  if($_GET["key"]!="")
	  {
	  header("location: editpassword.html");
	  }
	  elseif($_POST["feedback_hidden"]!="")
	  {
	 	 header("location: feedback.html");
	  }
	  else
	  {
	  	if($confirmemail==1)
		{
	 	 	header("location:emailconfirmsuccess.html");
			exit;
		}
		else
		{
			if($_POST["index"]!="")
			{
			header("location: index.html");
			exit;
			}
			if($_POST["wonauctions"]!=""){
    			header("location: wonauctions.html");
    			exit;
			}else{
    			header("location: myaccount.html");
    			exit;
			}
		}
	  }
	}else{
		if($ress->member_status=="1"){
			header("location:login.html?err=2");
			exit;
		}elseif($ress->user_delete_flag=='d'){
			header("location:login.html?err=3");
			exit;
		}
	} 
  }else{
	  if($username=="" && $pass==""){
	  	header("location:login.html?err=4");
	  }elseif($username!="" && $pass==""){
	  	  header("location:login.html?err=5");
	  }else{
	  	  header("location:login.html?err=1");
	  }
  }
  
?>