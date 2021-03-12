<?
	include("connect.php");
	include("admin.config.inc.php");
	include("security.php");
	$type1 = "1";
	$type3 = "3";
	include("pagepermission.php");

function ImageResizeFeature($img,$dest,$filename)
{
	//$img = $_GET['img'];
	//$percent = $_GET['percent'];
	/*$constrain = $_GET['constrain'];
	$w = $_GET['w'];
	$h = $_GET['h'];*/
	//Copy Org Image To Destination
	//@copy($img,$dest.'/'.$filename);
	
	$sh = 0;
	$sw = 0;
	$wi = 0;
	// get image size of img
	$x = @getimagesize($img);
	// image width
	$sw += $x[0];
	//echo $sw;
	//exit;
	// image height
	$sh = $x[1];
	
	$mi = 597*100;
	
	if($sw >= 597)
	{
		//echo "Width Greater Than 300<br>";
		$wi =$mi/$sw;
		$shfinal = ceil(($sh*$wi)/100);
		$swfinal = 597 ; 
	}
	/*elseif($sh >= 300)
	{
		//echo "height Greater Than 300<br>";
		//echo $mi."====".$sh."<br>";
		$wi = $mi/$sh;
		//echo $wi."<br>";
		
		$swfinal = ceil(($sw*$wi)/100);
		$shfinal = 300 ;
		//echo $swfinal;
		//exit;
	}*/
	elseif($sw < 597)
	{
		//echo "Both not Greater Than 300<br>";
		//$wi = $mi/$sw;
		$shfinal = $sh; //ceil(($wi*$sh)/100);
		$swfinal = $sw; // 300 ;	
	}
	//echo "Width:-".$swfinal." Orignal Width:-".$sw."<br>";
	//echo "Height:-".$shfinal." Orignal Height:-".$sh."<br>";
	//echo "Wi:-".$wi."<br>";
	//exit;
		
	$im = @ImageCreateFromJPEG ($img) or // Read JPEG Image
	$im = @ImageCreateFromPNG ($img) or // or PNG Image
	$im = @ImageCreateFromGIF ($img) or // or GIF Image
	$im = false; // If image is not JPEG, PNG, or GIF
	
	if (!$im) {
		// We get errors from PHP's ImageCreate functions...
		// So let's echo back the contents of the actual image.
		readfile ($img);
	} else {
		// Create the resized image destination
		$thumb = @ImageCreateTrueColor ($swfinal, $shfinal);
		// Copy from image source, resize it, and paste to image destination
		@ImageCopyResampled ($thumb, $im, 0, 0, 0, 0, $swfinal, $shfinal, $sw, $sh);
		//@imagecopyresized($this->dest_image, $this->src_image, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y);
		// Output resized image
		@ImageJPEG ($thumb,$dest.'/'.$filename);
		//if($thumb)copy($thumb,'thumb_'.$filename);
	}
}


	function getHours($aucstartdate,$aucenddate,$aucstarthour,$aucendhour,$aucstartmin,$aucendmin,$aucstartsec,$aucendsec)
		{
					$newstartdate = substr($aucstartdate,6)."-".substr($aucstartdate,3,2)."-".substr($aucstartdate,0,2);
			$newstarttime = $aucstarthour.":".$aucstartmin.":".$aucstartsec;

			$newenddate = substr($aucenddate,6)."-".substr($aucenddate,3,2)."-".substr($aucenddate,0,2);
			$newendtime = $aucendhour.":".$aucendmin.":".$aucendsec;
			
			$newstarttimestamp = strtotime($newstartdate." ".$newstarttime);
			$newendtimestapm = strtotime($newenddate." ".$newendtime);
			$finalsec = $newendtimestapm - $newstarttimestamp;

/*			if($aucenddate>$aucstartdate)
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
			$finalsec = ($aucendhour * 60 * 60) + ($aucendmin * 60) + $aucendsec;*/
			return $finalsec;
		}

	$categoryID = $_REQUEST["category"];
	$productID = $_REQUEST["product"];
	$auc_start_price = $_REQUEST["aucstartprice"];
	$auc_fixed_price = $_REQUEST["aucfixedprice"];
	if($auc_fixed_price=="")
	{
		$auc_fixed_price = 0;
	}
	if($_POST["startimmidiate"]!="")
	{
		$auc_start_date_ex = explode("/",date("d/m/Y"));
	}
	else
	{	
	$auc_start_date_ex = explode("/",$_REQUEST["aucstartdate"]);
	}
	
	$auc_start_date = $auc_start_date_ex[2]."-".$auc_start_date_ex[1]."-".$auc_start_date_ex[0];
	$auc_end_date_ex = explode("/",$_REQUEST["aucenddate"]);
	$auc_end_date =  $auc_end_date_ex[2]."-".$auc_end_date_ex[1]."-".$auc_end_date_ex[0];

	$aucstartdate = $_REQUEST["aucstartdate"];
	$aucenddate = $_REQUEST["aucenddate"];
	$aucstarthour = $_REQUEST["aucstarthours"];
	$aucendhour = $_REQUEST["aucendhours"];
	$aucstartmin = $_REQUEST["aucstartminutes"];
	$aucendmin = $_REQUEST["aucendminutes"];
	$aucstartsec = $_REQUEST["aucstartseconds"];
	$aucendsec = $_REQUEST["aucendseconds"]; 

	if($_POST["startimmidiate"]!="")
	{
		$auc_start_time = date("H:i:s");
		$auctionsplittime = explode(":",$auc_start_time);
		$aucstarthour = $auctionsplittime[0];
		$aucstartmin = $auctionsplittime[1];
		$aucstartsec = $auctionsplittime[2];	
	}
	else
	{
	$auc_start_time=$_REQUEST["aucstarthours"].":".$_REQUEST["aucstartminutes"].":".$_REQUEST["aucstartseconds"];
	}
	$auc_end_time=$_REQUEST["aucendhours"].":".$_REQUEST["aucendminutes"].":".$_REQUEST["aucendseconds"];
	$auc_status = $_REQUEST["aucstatus"];
	$auc_type = $_REQUEST["auctype"];
	$auc_recu = $_REQUEST["aucrec"];
	$fpa = $_REQUEST["fpa"];
	$pa = $_REQUEST["pa"];
	$nba = $_REQUEST["nba"];
	$off = $_REQUEST["off"];
	$na = $_REQUEST["na"];
	$oa = $_REQUEST["oa"];
	$duration = $_REQUEST["auctionduration"];
	
	$changesval = $_REQUEST['changestatusval'];
	$shippingmethod = $_REQUEST["shippingmethod"];
//	$auccode = $_REQUEST["auctioncode"];
	
	$auc_due_time = getHours($aucstartdate,$aucenddate,$aucstarthour,$aucendhour,$aucstartmin,$aucendmin,$aucstartsec,$aucendsec);
	
	if($_REQUEST["addauction"]!="")
	{
		$futuretstamp = mktime($aucstarthour,$aucstartmin,$aucstartsec,$auc_start_date_ex[1],$auc_start_date_ex[0],$auc_start_date_ex[2]);

		$qrycode = "select auction_code from auction where auction_code!='' order by auctionID desc limit 0,1";
		$rscode = mysql_query($qrycode);
		$totalcode = mysql_num_rows($rscode);
		$objcode = mysql_fetch_object($rscode);

		if($totalcode>0)
		{
			$str=substr($objcode->auction_code,1);
	
			$s=explode('0',$str);
			
			for($i=0;$i<count($s);$i++)
			{
				if($s[$i]=="")
				{
					$temp.="0";
				}
			}
			$auccode="S".$temp.($str+1);
		}
		else
		{
			$auccode = "S0001";
		}
		
		if($changesval=="1" && $auc_status=="2")
		{
			$auc_status = 1;
		}
		$qryins = "Insert into auction (categoryID,productID,auc_start_price,auc_fixed_price,auc_final_price,auc_start_date,auc_end_date,auc_start_time,auc_end_time,auc_status,auc_type,fixedpriceauction,pennyauction,nailbiterauction,offauction,nightauction,openauction,time_duration,auc_recurr,total_time,shipping_id,auction_code,featured_flag,future_tstamp) values('$categoryID','$productID',$auc_start_price,$auc_fixed_price,'','$auc_start_date','$auc_end_date','$auc_start_time','$auc_end_time','$auc_status','$auc_type','$fpa','$pa','$nba','$off','$na','$oa','$duration','$auc_recu','$auc_due_time','$shippingmethod','$auccode','1','$futuretstamp')";
		mysql_query($qryins) or die(mysql_error());
		$auctionID = mysql_insert_id();

	  if(isset($_FILES["image1"]) && $_FILES["image1"]["name"]!="")
	  {	
		if (isset($_FILES["image1"]) && $_FILES["image1"]["name"] && preg_match('/\.(jpg|jpeg|gif|jpe|pcx|bmp|png)$/i', $_FILES["image1"]["name"]))
		{		
			$time = time();		
			$logo = "1_".$time."_".$_FILES["image1"]["name"];
			$logo_temp = $_FILES["image1"]["tmp_name"];
			$dest = "images/products/feature_picture/";
			ImageResizeFeature($logo_temp,$dest,$logo);
			$upd = "update auction set featured_picture1='".$logo."' where auctionID='$auctionID'";
			mysql_query($upd) or die (mysql_error());
		}
	  }
	  elseif($_POST["editimage"]!="")
	  {
			$upd = "update auction set featured_picture1='".$_POST["editimage"]."' where auctionID='$auctionID'";
			mysql_query($upd) or die (mysql_error());			
	  }
		if($auc_status==2)
		{
			$qry = "Insert into auc_due_table (auction_id,auc_due_time,auc_due_price) values($auctionID,'$auc_due_time',$auc_start_price)";
			mysql_query($qry) or die(mysql_error());
		}

		header("location: message.php?msg=60");
		exit;
	}
	
	if($_REQUEST["editauction"] && $_REQUEST["edit_auction"])
	{
		$futuretstamp = mktime($aucstarthour,$aucstartmin,$aucstartsec,$auc_start_date_ex[1],$auc_start_date_ex[0],$auc_start_date_ex[2]);

		if($changesval=="1")
		{
			$auc_status = 1;
		}	
		$editid = $_REQUEST["edit_auction"];
		$userid = $_REQUEST["userid"];
		if($_REQUEST["auc_back_status"]=="3" and $userid==1)
		{
			//delete record from won_auctions and bid_account and 
			$delwonentry = "delete from won_auctions where userid='1' and auction_id='".$editid."'";
			mysql_query($delwonentry) or die(mysql_error());
			$delbidaccentry = "delete from bid_account where user_id='1' and auction_id='".$editid."'";
			mysql_query($delbidaccentry) or die(mysql_error());
			
			//end 
			$auc_due_time = getHours($aucstartdate,$aucenddate,$aucstarthour,$aucendhour,$aucstartmin,$aucendmin,$aucstartsec,$aucendsec);
			
			$q = "select * from auc_due_table where auction_id=$editid";
			$r = mysql_query($q);
			$to = mysql_num_rows($r);
			
			if($to>0)
			{
				$qry = "update auc_due_table set auc_due_time=$auc_due_time, auc_due_price=$auc_start_price where auction_id=$editid";
			}
			else
			{	
				$qry = "Insert into auc_due_table(auction_id,auc_due_time,auc_due_price) values($editid,'$auc_due_time',$auc_start_price)";
			}
			mysql_query($qry) or die(mysql_error());
			
			$qryupd = "update auction set categoryID='$categoryID', productID='$productID',auc_start_price='$auc_start_price',auc_start_date='$auc_start_date',auc_end_date='$auc_end_date', auc_start_time='$auc_start_time', auc_end_time='$auc_end_time', auc_status='$auc_status', fixedpriceauction='$fpa',pennyauction='$pa',nailbiterauction='$nba',offauction='$off',nightauction='$na',openauction='$oa',time_duration='$duration', auc_recurr='$auc_recu',auc_fixed_price=$auc_fixed_price,total_time='$auc_due_time',buy_user='',auc_final_end_date='0000-00-00 00:00:00',auc_final_price='0',shipping_id='$shippingmethod',future_tstamp='$futuretstamp'  where auctionID='$editid'";
			mysql_query($qryupd) or die(mysql_error());

			  if(isset($_FILES["image1"]))
			  {	
				if (isset($_FILES["image1"]) && $_FILES["image1"]["name"] && preg_match('/\.(jpg|jpeg|gif|jpe|pcx|bmp|png)$/i', $_FILES["image1"]["name"]))
				{		
					$time = time();		
					$logo = "1_".$time."_".$_FILES["image1"]["name"];
					$logo_temp = $_FILES["image1"]["tmp_name"];
					$dest = "images/products/feature_picture/";
					ImageResizeFeature($logo_temp,$dest,$logo);
					$upd = "update auction set featured_picture1='".$logo."' where auctionID='$editid'";
					mysql_query($upd) or die (mysql_error());
				}
			  }

			header("location: message.php?msg=61");
			exit;
		}
		else
		{
			if($_REQUEST["auc_back_status"]!=2)
			{
				$q = "select * from auc_due_table where auction_id=$editid";
				$r = mysql_query($q);
				$to = mysql_num_rows($r);
		
				if($auc_status==2)
				{
					$auc_due_time = getHours($aucstartdate,$aucenddate,$aucstarthour,$aucendhour,$aucstartmin,$aucendmin,$aucstartsec,$aucendsec);
		
					if($to>0)
					{
						$qry = "update auc_due_table set auc_due_time=$auc_due_time, auc_due_price=$auc_start_price where auction_id=$editid";
					}
					else
					{	
						$qry = "Insert into auc_due_table (auction_id,auc_due_time,auc_due_price) values($editid,'$auc_due_time',$auc_start_price)";
					}
				mysql_query($qry) or die(mysql_error());
				}
			}
	
			$qryupd = "update auction set categoryID='$categoryID', productID='$productID', auc_start_price='$auc_start_price',auc_start_date='$auc_start_date',auc_end_date='$auc_end_date', auc_start_time='$auc_start_time', auc_end_time='$auc_end_time', auc_status='$auc_status', fixedpriceauction='$fpa',pennyauction='$pa',nailbiterauction='$nba',offauction='$off',nightauction='$na',openauction='$oa',time_duration='$duration', auc_recurr='$auc_recu',auc_fixed_price=$auc_fixed_price,total_time='$auc_due_time', shipping_id='$shippingmethod',future_tstamp='$futuretstamp' where auctionID='$editid'";
			mysql_query($qryupd) or die(mysql_error());
			
			  if(isset($_FILES["image1"]))
			  {	
				if (isset($_FILES["image1"]) && $_FILES["image1"]["name"] && preg_match('/\.(jpg|jpeg|gif|jpe|pcx|bmp|png)$/i', $_FILES["image1"]["name"]))
				{		
					$time = time();		
					$logo = "1_".$time."_".$_FILES["image1"]["name"];
					$logo_temp = $_FILES["image1"]["tmp_name"];
					$dest = "images/products/feature_picture/";
					ImageResizeFeature($logo_temp,$dest,$logo);
					$upd = "update auction set featured_picture1='".$logo."' where auctionID='$editid'";
					mysql_query($upd) or die (mysql_error());
				}
			  }

			header("location: message.php?msg=61");
			exit;
		}	
	}
	
	if($_REQUEST["delete_auction"])
	{
		$delid = $_REQUEST["delete_auction"];

		$qryseld = "select auc_status from auction where auctionID=".$delid;
		$resseld = mysql_query($qryseld);
		$totalrow = mysql_affected_rows();
		$del = mysql_fetch_object($resseld);
		if($del->auc_status==2)
		{
			header("location: message.php?msg=62");
			exit;
		}

		$qrydel = "delete from auction where auctionID='$delid'";
		mysql_query($qrydel) or dir(mysql_error());
		header("location: message.php?msg=63");
	}
	
	if($_REQUEST["auction_edit"]!="" or $_REQUEST["auction_delete"]!="" or $_REQUEST["auction_clone"])
	{
		if($_REQUEST["auction_edit"]!=""){$aid=$_REQUEST["auction_edit"];}
		if($_REQUEST["auction_delete"]!=""){$aid=$_REQUEST["auction_delete"];}
		if($_REQUEST["auction_clone"]!=""){$aid=$_REQUEST["auction_clone"];}
		$qrys = "select * from auction a left join products p on a.productID=p.productID where auctionID=".$aid;
		$ress = mysql_query($qrys);
		$total = mysql_affected_rows();
		$rows = mysql_fetch_object($ress);
		if($total>0)
		{
			$category = $rows->categoryID;		
 			$product = $rows->productID;
			$pprice = $rows->price;
 			$aucstartprice = $rows->auc_start_price;		
 			$aucstartdate = $rows->auc_start_date;
				//$aucstartyear =  substr($aucstartdate,0,4);
				//$aucstartmonth = substr($aucstartdate,5,2);
				//$aucstartdate =  substr($aucstartdate,8,2);
 			$aucenddate = $rows->auc_end_date;
				//$aucendyear =  substr($aucenddate,0,4);
				//$aucendmonth = substr($aucenddate,5,2);
				//$aucenddate =  substr($aucenddate,8,2);
 			$aucstarttime = $rows->auc_start_time;
				$aucsthours = substr($aucstarttime,0,2);
				$aucstmin =  substr($aucstarttime,3,2);
				$aucstsec =  substr($aucstarttime,6,2);
 			$aucendtime = $rows->auc_end_time;
				$aucendhours = substr($aucendtime,0,2);
				$aucendmin =  substr($aucendtime,3,2);
				$aucendsec =  substr($aucendtime,6,2);
 			$aucstatus = $rows->auc_status;
// 			$auctype = $rows->auc_type;
 			$aucrecu = $rows->auc_recurr;
			$aucfixedprice = $rows->auc_fixed_price;
			$userid = $rows->buy_user;
			$shippingchargeid = $rows->shipping_id;
			$auccode = $rows->auction_code;
			$imagename = $rows->featured_picture1;
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
<title></title>
<LINK href="main.css" type=text/css rel=stylesheet>
<link href="zpcal/themes/aqua.css" rel="stylesheet" type="text/css" media="all" title="Calendar Theme - aqua.css" />
<script type="text/javascript" src="zpcal/src/utils.js"></script>
<script type="text/javascript" src="zpcal/src/calendar.js"></script>
<script type="text/javascript" src="zpcal/lang/calendar-en.js"></script>
<script type="text/javascript" src="zpcal/src/calendar-setup.js"></script>
<script language="javascript">
function delconfirm(loc)
{
	if(confirm("Are you sure do you want to delete this?"))
	{
		window.location.href=loc;
	}
	return false;
}

function Check(f1)
{
	if(document.f1.category.value=="none")
	{
		alert("Por favor selecione a categoria!!!");
		document.f1.category.focus();
		return false;
	}

	if(document.f1.product.value=="none")
	{
		alert("Por favor selecione o produto!!!");
		document.f1.product.focus();
		return false;
	}

	if(document.f1.aucstartprice.value=="")
	{
		alert("Por favor informe o preço inicial do leilão!!!");
		document.f1.aucstartprice.focus();
		return false;
	}

	if(document.f1.aucstartdate.value=="")
	{
		alert("Por favor selecione a data inicial!!!");
		document.f1.aucstartdate.focus();
		return false;
	}
	
	if(document.f1.aucenddate.value=="")
	{
		alert("Por favor selecione a data final!!!");
		document.f1.aucenddate.focus();
		return false;
	}
	var aucsdate = condate(document.f1.aucstartdate.value);
	var curdate = condate(document.f1.curdate.value); 
	var aucedate = condate(document.f1.aucenddate.value);

	var newaucsdate = new Date(aucsdate);
	var newcurdate = new Date(curdate);
	var newaucedate = new Date(aucedate);

	var newtime = document.f1.curtime.value;
	var temptime = newtime.split(":");

	var newtimehour = temptime[0];
	var newtimeminute = temptime[1];
	var newtimeseconds = temptime[2];
	
<? if($aucstatus==2 || $aucstatus==1 || $aucstatus=="" || $_REQUEST["auction_clone"]!="" || $_REQUEST["auction_edit"]){	?>
	if(newcurdate>newaucsdate)
	{
		alert("A data inicial não pode ser no passado.")
		document.f1.aucstartdate.focus();
		return false;
	}
	if(newaucsdate>newaucedate)
	{
		alert("A data final não pode ser anterior a data inicial!");
		document.f1.aucenddate.focus();
		return false;
	}
	if(newaucsdate>newcurdate)
	{
		document.f1.changestatusval.value = "1";
	}
	if(document.f1.startimmidiate.checked==false)
	{
		if(document.f1.changestatusval.value != "1")
		{
			if(Number(newtimehour)<Number(document.f1.aucstarthours.value))	
			{
				document.f1.changestatusval.value = "1";
			}
			else
			{
				if(Number(newtimeminute)<Number(document.f1.aucstartminutes.value))
				{
					document.f1.changestatusval.value = "1";
				}
			}
		}
	if(document.f1.changestatusval.value != "1")
	{
		if(document.f1.aucstarthours.value<newtimehour)
		{
			alert("Hora inicial não pode ser no passado!");
			document.f1.aucstarthours.focus();
			return false;
		}
		else
		{
			if(document.f1.aucstarthours.value==newtimehour)
			{
				if(document.f1.aucstartminutes.value<newtimeminute)
				{
					alert("Hora inicial não pode ser no passado!");
					document.f1.aucstartminutes.focus();
					return false;
				}
			}
		}
	
		if(document.f1.aucendminutes.value<newtimeminute)
			{
				if(document.f1.aucendhours.value==newtimehour)
				{
					alert("Hora final do leilao não pode ser no passado!");
					document.f1.aucendminutes.focus();
					return false;
				}
			}
			else
			{
				if(document.f1.aucendminutes.value==newtimeminute)
				{
					if(document.f1.aucendseconds.value<newtimeseconds)
					{
						alert("Hora final do leilao não pode ser no passado!");
						document.f1.aucendseconds.focus();
						return false;
					}
				}

		}
	}
  }
  else
  {
  	 if(aucsdate==aucedate)
	 {
		if(document.f1.aucendhours.value<newtimehour)
		{
			alert("Hora final do leilao não pode ser no passado!");
			document.f1.aucendhours.focus();
			return false;
		}
		else
		{
			if(document.f1.aucendminutes.value<newtimeminute)
			{
				if(document.f1.aucendhours.value==newtimehour)
				{
					alert("Hora final do leilao não pode ser no passado!");
					document.f1.aucendminutes.focus();
					return false;
				}
			}
			else
			{
				if(document.f1.aucendminutes.value==newtimeminute)
				{
					if(document.f1.aucendseconds.value<newtimeseconds)
					{
						alert("Hora final do leilao não pode ser no passado!");
						document.f1.aucendseconds.focus();
						return false;
					}
				}
			}
		}
	 }
  }
<? } ?>	

	if(document.f1.aucstarthours.value=="")
	{
		alert("Por favor selecione a hora inicial!!!");
		document.f1.aucstarthours.focus();
		return false;
	}
	
	if(document.f1.aucstartminutes.value=="")
	{
		alert("Por favor selecione o minuto inicial!!!");
		document.f1.aucstartminutes.focus();
		return false;
	}

	if(document.f1.aucstartseconds.value=="")
	{
		alert("Por favor selecione o segundo inicial!!!");
		document.f1.aucstartseconds.focus();
		return false;
	}

	if(document.f1.aucendhours.value=="")
	{
		alert("Por favor selecione a hora final!!!");
		document.f1.aucendhours.focus();
		return false;
	}

	if(document.f1.aucendminutes.value=="")
	{
		alert("Por favor selecione o minuto final!!!");
		document.f1.aucendminutes.focus();
		return false;
	}

	if(document.f1.aucendseconds.value=="")
	{
		alert("Por favor selecione o segundo final!!!");
		document.f1.aucendseconds.focus();
		return false;
	}
	if(aucsdate==aucedate)
	{
		if(Number(document.f1.aucendhours.value)<Number(document.f1.aucstarthours.value))
		{
			alert("A hora inicial não pode ser igual a hora final!!!");
			document.f1.aucendhours.focus();
			return false;
		}
		else
		{
			if(Number(document.f1.aucendhours.value)==Number(document.f1.aucstarthours.value))
			{
				if(Number(document.f1.aucendminutes.value)<Number(document.f1.aucstartminutes.value))
				{
					alert("O minuto inicial não pode ser igual ao minuto final!!!");
					document.f1.aucendminutes.focus();
					return false;
				}
				else
				{
					if(Number(document.f1.aucendminutes.value)==Number(document.f1.aucstartminutes.value))
					{
						if(Number(document.f1.aucendseconds.value)==Number(document.f1.	aucstartseconds.value))
						{
							alert("O segundo inicial não pode ser igual ao segundo final!!!");
							document.f1.aucendseconds.focus();
							return false;
						}
					
					}
				}
			}
		}
	}
	if(document.f1.fpa.checked==true && document.f1.off.checked==true)
	{
		alert("You can't select fixed price auction type with 100% off auction type!!!");
		return false;
	}
	if(document.f1.shippingmethod.value=="none")
	{
		alert("Por favor selecione shipping charge method");
		document.f1.shippingmethod.focus();
		return false;
	}
	if(document.f1.image1.value=="" && document.f1.editimage.value=="")
	{
		alert("Por favor informe o upload image");
		document.f1.image1.focus();
		return false;
	}
}
function condate(dt)
{
	var ndate= new String(dt);
	//alert(dt);
	var fdt=ndate.split("/");
	var nday=fdt[0];
	var nmon=fdt[1];
	var nyear=fdt[2];
	
	var finaldate=nmon+"/"+nday+"/"+nyear;
	//alert(finaldate);
	
	return finaldate;
}
function DisabledAuctionTime()
{
	if(document.f1.startimmidiate.checked == true)
	{
		document.f1.aucstarthours.disabled = true;
		document.f1.aucstartminutes.disabled = true;
		document.f1.aucstartseconds.disabled = true;
	}
	if(document.f1.startimmidiate.checked == false)
	{
		document.f1.aucstarthours.disabled = false;
		document.f1.aucstartminutes.disabled = false;
		document.f1.aucstartseconds.disabled = false;
	}
}
function EnableDisableFixAuc(f1)
{
	if(document.f1.fpa.checked==true)
	{
		document.f1.aucfixedprice.disabled = false;
	}
	else
	{
		document.f1.aucfixedprice.disabled = true;
		document.f1.aucfixedprice.value = "0.00";
	}
}
</script>
<script language="javascript">
// USE FOR AJAX //
function GetXmlHttpObject()
{
var xmlHttp=null;
try
  {
  // Firefox, Opera 8.0+, Safari
  xmlHttp=new XMLHttpRequest();
  }
catch (e)
  {
  // Internet Explorer
  try
    {
    xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
    }
  catch (e)
    {
    xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  }
return xmlHttp;
}

function setprice(prid)
{
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	  {
	  alert ("Your browser does not support AJAX!");
	  return;
	  } 
	var url="getprice.php";
	url=url+"?prid="+prid
	xmlHttp.onreadystatechange=changedprice;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function changedprice()
{
	if (xmlHttp.readyState==4)
	{ 
		var temp=xmlHttp.responseText
		document.getElementById("getprice").innerHTML = temp;
	}
}

function ChangeProduct(crid)
{
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	  {
	  alert ("Your browser does not support AJAX!");
	  return;
	  } 
	var url="getproductlist.php";
	url=url+"?crid="+crid
	xmlHttp.onreadystatechange=ChangedProduct;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function ChangedProduct()
{
	if (xmlHttp.readyState==4)
	{ 
		var tempproduct=xmlHttp.responseText
		document.getElementById("Productlist").innerHTML = tempproduct;
	}
}

</script>
</head>

<BODY bgColor=#ffffff onload="EnableDisableFixAuc(f1);">   
<form name="f1" action='addfeatureauction.php' method='POST' enctype="multipart/form-data" onsubmit="return Check(this)">
<table width="100%" cellpadding="0" cellSpacing="10">
  <tr>
	<td class="H1"><? if($_GET['auction_edit']!="") { ?> Edit Featured Auction<? } else { if($_GET['auction_delete']!=""){ ?> Confirm Delete Featured Auction <? }else { ?> Add  Featured Auction <? } } ?></td>
  </tr>
  <tr>
	<td background="<?=DIR_WS_ICONS?>vdots.gif"><IMG height=1 src="<?=DIR_WS_ICONS?>spacer.gif" width=1 border=0></td>
  </tr>
  <tr>
	<td class="a" align="right" colspan=2 >* Campos Obrigatorios</td>
  </tr>
  <tr>
 	<td>
 	  <table cellpadding="1" cellspacing="2">
	  <?
	  if($aucstatus=="2")
	  {	
	  ?>
	  	<tr>
			<td colspan="2"><font class="a">(Note: This Auction is currently running, So you cannot modify it at the moment.)</font></td>
		</tr>
		<tr>
			<td colspan="2" height="5"></td>
		</tr>
	<?
	  }
	  if($aid!="")
	  {
	?>	
<!--	    <tr valign="middle">
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Auction Code :</td>
		  <td><input type="text" value="<?$auccode;?>" name="auctioncode" maxlength="5" size="8" disabled="disabled" /></td>
		</tr>-->
	<?
	}
	?>
	    <tr valign="middle">
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Category :</td>
		  <td>
		  	<select name="category" style="100pt;" onchange="ChangeProduct(this.value);">
			<option value="none">selecione</option>
			<?
			$qryc = "select * from categories";
			$resc = mysql_query($qryc);
			$totalc = mysql_affected_rows();
			while($namec = mysql_fetch_array($resc))
			{
			?>
			<option <?=$category==$namec["categoryID"]?"selected":"";?> value="<?=$namec["categoryID"];?>"><?=$namec["name"];?></option>
			<?
			}
			?>
			</select></td>
		</tr>
	    <tr valign="middle">
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Product :</td>
	  	  <td id="Productlist">
		  <select name="product" style="width: 150pt;" onchange="setprice(this.value);">
		  <option value="none">selecione</option>
		  <?
		  	$qryp = "select * from products";
			$resp = mysql_query($qryp);
			$totalp = mysql_affected_rows();
			while($objp = mysql_fetch_array($resp))
			{
		  ?>
		  	<option <?=$product==$objp["productID"]?"selected":"";?> value="<?=$objp["productID"];?>"><?=$objp["name"];?></option>
		  <?
				}
		  ?>
		  </select></td>
 	    </tr>
	    <tr valign="middle">
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Product Market Price :</td>
	  	  <td id="getprice"><?=$pprice!=""?$pprice:"";?></td>
	    </tr>
		<tr>
			<td class="f-c"  align="right">Auction Type :</td>
			<td>
				<table border="0">
				<tr>
					<td>
						<input <?=$rows->fixedpriceauction=="1"?"checked":""?> type="checkbox" name="fpa" value="1" onclick="EnableDisableFixAuc(this);"> Fixed Price Auction </td>
					<td>
						<input <?=$rows->pennyauction=="pa"?"checked":""?> type="checkbox" name="pa" value="1"> Cent Auction 
					</td>
					<td>
						<input <?=$rows->nailbiterauction=="nba"?"checked":""?> type="checkbox" name="nba" value="1"> NailBiter Auction 
					</td>
				</tr>
				<tr>
					<td><input <?=$rows->offauction=="off"?"checked":""?> type="checkbox" name="off" value="1"> 100% off</td>
					<td><input <?=$rows->nightauction=="na"?"checked":""?> type="checkbox" name="na" value="1"> Night Auction</td>
					<td><input <?=$rows->openauction=="oa"?"checked":""?> type="checkbox" name="oa" value="1"> Open Auction</td>
				</tr>
				</table>
			</td>
			</tr>
	    <tr valign="middle">
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Auction Start Price :</td>
          <td><input name="aucstartprice" type="text" class="solidinput" id="member_name" value="<?=$aucstartprice?>" size="12" maxlength="20">&nbsp;<font color="#FF0000"><?=$Currency;?></font></td>
        </tr>
	    <tr valign="middle">
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Auction Fixed Price :</td>
          <td><input name="aucfixedprice" type="text" class="solidinput" value="<?=$aucfixedprice?>" size="12" disabled="disabled" id="aucfixedprice" maxlength="20">&nbsp;<font color="#FF0000"><?=$Currency;?> (Compulsory: If Auction Type is selected to Fixed price)</font></td>
        </tr>
		<tr valign="middle">
          <td class="f-c" align="right" valign="middle" width="191">Auction Date :</td>
          <td>
			<?php /*?><select name="aucstartdate">
			<option value="none">--</option>
			<?
				for($i=1;$i<=31;$i++)
				{
					if($i<10)
					{
						$i="0".$i;
					}
					if($aucstatus=="3" and $userid==1)
					{	
					?>
					<option <?=date("d")==$i?"selected":""?> value="<?=$i?>"><?=$i;?></option>
					<?
					}
					else
					{
			?>
			<option <?=$aucstartdate==$i?"selected":""?> value="<?=$i?>"><?=$i;?></option>
			<?		
					}
				}
			?>
			</select>
			<select name="aucstartmonth">
			<option value="none">--</option>
			<?
				for($i=1;$i<=12;$i++)
				{
					if($i<10)
					{
						$i="0".$i;
					}
					if($aucstatus=="3" and $userid==1)
					{
			?>
			<option <?=date("m")==$i?"selected":"";?> value="<?=$i?>"><?=$i;?></option>
			<?
					}
					else
					{
			?>
			<option <?=$aucstartmonth==$i?"selected":"";?> value="<?=$i?>"><?=$i;?></option>
			<?		
					}
				}
			?>
		 	</select>
	
			<select name="aucstartyear">
				<option value="none">----</option>
				<?
					for($i=2008;$i<=2050;$i++)
					{
						if($aucstatus=="3" and $userid==1)
						{
				?>
					<option <?=date("Y")==$i?"selected":""?> value="<?=$i;?>"><?=$i;?></option>
				<?
						}
						else
						{
				?>
					<option <?=$aucstartyear==$i?"selected":""?> value="<?=$i;?>"><?=$i;?></option>
				<?
						}
					}
				?>
			</select><?php */?>
			<input type="text" size="12" name="aucstartdate" id="aucstartdate" value="<?=$aucstartdate!=""?date("d/m/Y",strtotime($aucstartdate)):"";?>" />
			<img src="images/pmscalendar.gif" align="absmiddle" width="20" height="20" id="vfrom">
			 	<B>&nbsp;To&nbsp;</B>
				<input type="text" size="12" name="aucenddate" id="aucenddate" value="<?=$aucenddate!=""?date("d/m/Y",strtotime($aucenddate)):"";?>" />
			<img src="images/pmscalendar.gif" align="absmiddle" width="20" height="20" id="zfrom">
			<?php /*?><select name="aucenddate">
			<option value="none">--</option>
			<?
				for($i=1;$i<=31;$i++)
				{
					if($i<10)
					{
						$i="0".$i;
					}
					if($aucstatus=="3" and $userid==1)
					{
			?>
			<option <?=(date("d")+1)==$i?"selected":""?> value="<?=$i?>"><?=$i;?></option>
			<?
					}
					else
					{
			?>
			<option <?=$aucenddate==$i?"selected":""?> value="<?=$i?>"><?=$i;?></option>
			<?		
					}
				}
			?>
			</select>
			<select name="aucendmonth">
			<option value="none">--</option>
			<?
				for($i=1;$i<=12;$i++)
				{
					if($i<10)
					{
						$i="0".$i;
					}
					if($aucstatus=="3" and $userid==1)
					{
			?>
			<option <?=date("m")==$i?"selected":"";?> value="<?=$i?>"><?=$i;?></option>
			<?
					}
					else
					{
			?>
			<option <?=$aucendmonth==$i?"selected":"";?> value="<?=$i?>"><?=$i;?></option>
			<?		
					}
				}
			?>
		 	</select>
	
			<select name="aucendyear">
				<option value="none">----</option>
				<?
					for($i=2008;$i<=2050;$i++)
					{
						if($aucstatus=="3" and $userid==1)
						{
				?>
					<option <?=date("Y")==$i?"selected":""?> value="<?=$i;?>"><?=$i;?></option>
				<?
						}
						else
						{
				?>
					<option <?=$aucendyear==$i?"selected":""?> value="<?=$i;?>"><?=$i;?></option>
				<?			
						}
					}
				?>
			</select><?php */?>
		</td>
		</tr>
		<tr>
			<td class="f-c"  align="right">Auction Time :</td>
			<td>
			<? if($aucstatus=="3" and $userid==1) 
			{
			?>
			<select name="aucstarthours">
			<option value="">hh</option>
			<? for ($h=0;$h<=23;$h++){ ?>
				<option <?=date("H")==$h?"selected":"";?> value="<?=str_pad($h,2,"0",STR_PAD_LEFT);?>">
			<? } ?>
			</select> :
			<!--<input maxlength="2" type="text" name="aucstarthours" size="2" value="<?//date("H")!=""?date("H"):"";?>">-->
			<? }else{ ?>
			<select name="aucstarthours">
			<option value="">hh</option>
			<? for ($h=0;$h<=23;$h++){ ?>
				<option <?=$aucsthours==$h?"selected":"";?> value="<?=str_pad($h,2,"0",STR_PAD_LEFT);?>"><?=str_pad($h,2,"0",STR_PAD_LEFT);?></option>
			<? } ?>
			</select> :
			<?php /*?><input maxlength="2" type="text" name="aucstarthours" size="2" value="<?=$aucsthours!=""?$aucsthours:"";?>"> :<?php */?>
			<? } ?>
			<? if($aucstatus=="3" and $userid==1) 
			{
			?>
			<select name="aucstartminutes">
			<option value="">mm</option>
			<? for ($m=0;$m<=59;$m++){ ?>
				<option <?=date("i")==$m?"selected":"";?> value="<?=str_pad($m,2,"0",STR_PAD_LEFT);?>"><?=str_pad($m,2,"0",STR_PAD_LEFT);?></option>
			<? } ?>
			</select> :
			<?php /*?><input maxlength="2" type="text" name="aucstartminutes" size="2" value="<?=date("i")!=""?date("i"):"";?>"> :<?php */?>
			<? }else{ ?>
			<select name="aucstartminutes">
			<option value="">mm</option>
			<? for ($m=0;$m<=59;$m++){ ?>
				<option <?=$aucstmin==$m?"selected":"";?> value="<?=str_pad($m,2,"0",STR_PAD_LEFT);?>"><?=str_pad($m,2,"0",STR_PAD_LEFT);?></option>
			<? } ?>
			</select> :
			<?php /*?><input maxlength="2" type="text" name="aucstartminutes" size="2" value="<?=$aucstmin!=""?$aucstmin:"";?>"> :<?php */?>
			<? } ?>
			<? if($aucstatus=="3" and $userid==1) 
			{
			?>
			<select name="aucstartseconds">
			<option value="">ss</option>
			<? for ($s=0;$s<=59;$s++){ ?>
				<option <?=date("s")==$s?"selected":"";?> value="<?=str_pad($s,2,"0",STR_PAD_LEFT);?>"><?=str_pad($s,2,"0",STR_PAD_LEFT);?></option>
			<? } ?>
			</select>
			<?php /*?><input maxlength="2" type="text" name="aucstartseconds" size="2" value="<?=date("s")!=""?date("s"):"";?>"><?php */?>
			<? }else{ ?>
			<select name="aucstartseconds">
			<option value="">ss</option>
			<? for ($s=0;$s<=59;$s++){ ?>
				<option <?=$aucstsec==$s?"selected":"";?> value="<?=str_pad($s,2,"0",STR_PAD_LEFT);?>"><?=str_pad($s,2,"0",STR_PAD_LEFT);?></option>
			<? } ?>
			</select>
			<?php /*?><input maxlength="2" type="text" name="aucstartseconds" size="2" value="<?=$aucstsec!=""?$aucstsec:"";?>"><?php */?>
			<? } ?>
			 <b>&nbsp;To&nbsp;</b>
			 <? if($aucstatus=="3" and $userid==1) 
			{
			?>
			<select name="aucendhours">
			<option value="">hh</option>
			<? for ($h=0;$h<=23;$h++){ ?>
				<option <?=date("H")==$h?"selected":"";?> value="<?=str_pad($h,2,"0",STR_PAD_LEFT);?>"><?=str_pad($h,2,"0",STR_PAD_LEFT);?></option>
			<? } ?>
			</select> :
		    <?php /*?><input maxlength="2" type="text" name="aucendhours" size="2" value="<?=date("H")!=""?date("H"):"";?>"> :<?php */?>
			<? }else{ ?>
			<select name="aucendhours">
			<option value="">hh</option>
			<? for ($h=0;$h<=23;$h++){ ?>
				<option <?=$aucendhours==$h?"selected":"";?> value="<?=str_pad($h,2,"0",STR_PAD_LEFT);?>"><?=str_pad($h,2,"0",STR_PAD_LEFT);?></option>
			<? } ?>
			</select> :
			<?php /*?><input maxlength="2" type="text" name="aucendhours" size="2" value="<?=$aucendhours!=""?$aucendhours:"";?>"> :<?php */?>
			<? } ?>
			 <? if($aucstatus=="3" and $userid==1) 
			{
			?>
			<select name="aucendminutes">
			<option value="">mm</option>
			<? for ($m=0;$m<=59;$m++){ ?>
				<option <?=date("i")==$m?"selected":"";?> value="<?=str_pad($m,2,"0",STR_PAD_LEFT);?>"><?=str_pad($m,2,"0",STR_PAD_LEFT);?></option>
			<? } ?>
			</select> :
			<?php /*?><input maxlength="2" type="text" name="aucendminutes" size="2" value="<?=date("i")!=""?date("i"):"";?>"> :<?php */?>
			<? }else{ ?>
			<select name="aucendminutes">
			<option value="">mm</option>
			<? for ($m=0;$m<=59;$m++){ ?>
				<option <?=$aucendmin==$m?"selected":"";?> value="<?=str_pad($m,2,"0",STR_PAD_LEFT);?>"><?=str_pad($m,2,"0",STR_PAD_LEFT);?></option>
			<? } ?>
			</select> :
			<?php /*?><input maxlength="2" type="text" name="aucendminutes" size="2" value="<?=$aucendmin!=""?$aucendmin:"";?>"> :<?php */?>
			<? } ?>
			 <? if($aucstatus=="3" and $userid==1) 
			{
			?>
			<select name="aucendseconds">
			<option value="">ss</option>
			<? for ($s=0;$s<=59;$s++){ ?>
				<option <?=date("s")==$s?"selected":"";?> value="<?=str_pad($s,2,"0",STR_PAD_LEFT);?>"><?=str_pad($s,2,"0",STR_PAD_LEFT);?></option>
			<? } ?>
			</select>
			<?php /*?><input maxlength="2" type="text" name="aucendseconds" size="2" value="<?=date("s")!=""?date("s"):"";?>"><?php */?>
			<? }else{ ?>
			<select name="aucendseconds">
			<option value="">ss</option>
			<? for ($s=0;$s<=59;$s++){ ?>
				<option <?=$aucendsec==$s?"selected":"";?> value="<?=str_pad($s,2,"0",STR_PAD_LEFT);?>"><?=str_pad($s,2,"0",STR_PAD_LEFT);?></option>
			<? } ?>
			</select>
			<?php /*?><input maxlength="2" type="text" name="aucendseconds" size="2" value="<?=$aucendsec!=""?$aucendsec:"";?>"><?php */?>
			<? } ?>	<font class="a">(24 hours)</font>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="checkbox" name="startimmidiate" value="start" onclick="DisabledAuctionTime();" />&nbsp;Start Immidiately
		<tr>
		<tr>
			<td class="f-c"  align="right">Auction Status :</td>
			<td>
			<select name="aucstatus">
				<option <?=$aucstatus=="2"?"selected":"";?> value="2">Active</option>
				<option <?=($aucstatus=="4")?"selected":"";?> value="4">Pending</option>
			<?	if($_REQUEST["auction_edit"]!="")
				{
			?>	
				<option <?=$aucstatus=="3"?"selected":"";?> value="3">Sold</option>
			<?
				}
			?>	
			</select><br /><font class="a">(Note: If status is Active and start date is Future date then Auction will be considered as Future Auction.<br />If status is pending then auction is saved in system not for a sale, change status to Active for put them for sale.)</font>
			</td>
		</tr>
		<tr>
					<td class="f-c"  align="right">Auction Duration  :</td>
					<td>
						<select name="auctionduration">
							<option value="none">Default</option>
							<option value="10sa">10-Second Auction</option>
							<option value="15sa">15-Second Auction</option>
							<option value="20sa">20-Second Auction</option>
						</select>
					</td>
		</tr>
		<tr>
					<td class="f-c"  align="right">Shipping Method  :</td>
					<td>
					<select name="shippingmethod" style="width: 180px;">
					<option value="none">selecione</option>
					<?
						$qryshipping = "select * from shipping";
						$resshipping = mysql_query($qryshipping);
						while($objshipping = mysql_fetch_object($resshipping))
						{
					?>
					<option <?=$objshipping->id==$shippingchargeid?"selected":"";?> value="<?=$objshipping->id;?>"><?=$objshipping->shipping_title;?></option>
					<?
						}
					?>
						</select>
					</td>
		</tr>
		<tr>
			<td class="f-c"  align="right">Auction Image  :</td>
			<td>
				<table border="0">
				  <tr>
				  	<td>
						<input name="image1" type="file" class="solidinput" size="35"></td>
						<input type="hidden" name="editimage" value="<?=$imagename;?>" />
				  </tr>
				  <tr>
				  	<td class="a">(Note: Image size should be 597 &times; 393)</td>
				  </tr>
				  </table>
			</td>	  
		</tr>
<!--		<tr>
			<td class="f-c"  align="right">Recurring :</td>
			<td>
				<select name="aucrec" style="width:50pt;">
				<option <?$aucrecu=="yes"?"selected":"";?> value="yes">Yes</option>
				<option <?$aucrecu=="no"?"selected":"";?> value="no">No</option>
				</select>
			</td>
		</tr>-->
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
		<td align="center" colspan="2">
			<?
			if($_REQUEST["auction_edit"]!="")
			{
				if($aucstatus=="3" and $userid!=1)
				{
			?>
			<input type="submit" name="editauction" value="Edit Auction" disabled="disabled" class="bttn" />
			<?
				}
				else
				{
					if($aucstatus=="2")
					{
			?>
			<input type="submit" name="editauction" disabled="disabled" value="Edit Auction" class="bttn" />
			<?
					}
					else
					{
			?>
			<input type="submit" name="editauction" value="Edit Auction" class="bttn" />
			<?			
					}
				}
			?>
			<input type="hidden" name="edit_auction" value="<?=$_REQUEST["auction_edit"];?>" />
			<input type="hidden" name="auc_back_status" value="<?=$aucstatus;?>" />
			<input type="hidden" name="userid" value="<?=$userid;?>" />
			<?
			}
			elseif($_REQUEST["auction_delete"]!="")
			{
				$delid = $_REQUEST["auction_delete"];
			?>
			<input type="button" name="deleteauction" value="Delete Auction" class="bttn" onclick="delconfirm('addfeatureauction.php?delete_auction=<?=$delid?>');"/>
			<?
			}
			else
			{
			?>
			<input type="submit" name="addauction" value="Add Auction" class="bttn" />
			<?
			}
			?>
		</td>
		</tr>
		</table>
	</td>
	</tr>
</table>
<input type="hidden" name="curdate" value="<?=date("d/m/Y");?>" />
<input type="hidden" name="changestatusval" value="" />
<input type="hidden" name="curtime" value="<?=date("H:i:s");?>" />
</form>
<script type="text/javascript">
var cal = new Zapatec.Calendar.setup({ 
inputField:"aucstartdate",
ifFormat:"%d/%m/%Y",
button:"vfrom",
showsTime:false 
});
</script>
<script type="text/javascript">
var cal = new Zapatec.Calendar.setup({ 
inputField:"aucenddate",
ifFormat:"%d/%m/%Y",
button:"zfrom",
showsTime:false 
});
</script>
</body>
</html>