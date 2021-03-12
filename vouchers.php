<?
	include("config/connect.php");
	include("session.php");
	include("functions.php");
	$uid = $_SESSION["userid"];

	if(!$_GET['pgno'])
	{
		$PageNo = 1;
	}
	else
	{
		$PageNo = $_GET['pgno'];
	}

	$qryselupd = "select *,uv.id as uservoucherid from user_vouchers uv left join vouchers v on uv.voucherid=v.id where uv.user_id='$uid'";
	$resselupd = mysql_query($qryselupd);
	$totalupd = mysql_num_rows($resselupd);
	while($obj1 = mysql_fetch_array($resselupd))
	{
		$status = "";
		if($obj1["expirydate"]!="0000-00-00 00:00:00" && $obj1["voucher_status"]==0)
		{
			$expiry = strtotime($obj1["expirydate"]);
			$today = time();
			if($today>$expiry)
			{
				$status="expire";
			}
		}
		if($status=="expire")
		{
			$qry = "update user_vouchers set voucher_status='2' where id='".$obj1["uservoucherid"]."'";
			mysql_query($qry) or die(mysql_error());
		}
	}

	
	$qrysel = "select *,".$lng_prefix."voucher_desc as voucher_desc from user_vouchers uv left join vouchers v on uv.voucherid=v.id where uv.user_id='$uid'";
	$ressel = mysql_query($qrysel);
	$total = mysql_num_rows($ressel);
	$totalpage=ceil($total/$PRODUCTSPERPAGE);	

	if($totalpage>=1)
	{
	$startrow=$PRODUCTSPERPAGE*($PageNo-1);
	$qrysel.=" LIMIT $startrow,$PRODUCTSPERPAGE";
	//echo $sql;
	$ressel=mysql_query($qrysel);
	$total=mysql_num_rows($ressel);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
<title><?=$AllPageTitle;?></title>
<link href="css/style_youbid.css" rel="stylesheet" type="text/css" />
<link href="css/menu.css" rel="stylesheet" type="text/css" />
<link href="css/estilo.css" rel="stylesheet" type="text/css" />
<!--[if IE 8]>
<link href="css/estiloie8.css" rel="stylesheet" type="text/css" />
<![endif]-->
<!--[if IE 7]>
<link href="css/estiloie7.css" rel="stylesheet" type="text/css" />
<![endif]-->
<!--[if lte IE 6]>
<link href="css/menu_ie.css" rel="stylesheet" type="text/css" />
<![endif]-->
<script language="javascript" type="text/javascript" src="function.js"></script>
</head>


<body>
<div id="conteudo-principal">
<?
	include("header.php");
?>
			<? include("leftside.php"); ?>
<div id="conteudo-conta">
				<div class="titlebar">
<h3 class="historico-tit"><?=$lng_myauctionsavenue;?> - <?=$lng_accvouchers;?></h3>
					<div class="rightbar"></div>
				</div>
				<div class="bodypart">	
				<? if($total>0){ ?>
					<div class="strip">
						<div class="voucherdate" align="center"><?=$lng_voucherdate;?></div>
						<div class="voucherdescription" style="text-align: center;"><?=$lng_voucherlabel;?></div>
						<div class="voucherprice" align="center"><?=$lng_voucheramount;?></div>
						<div class="vouchercombinable" align="center"><?=$lng_vouchercombinable;?></div>
						<div class="voucherauction" align="center"><?=$lng_voucherauction;?></div>
						<div class="voucherstatus" align="center"><?=$lng_voucherstatus;?></div>
						<div class="voucherexpiry" align="center"><?=$lng_vouchervalidto;?></div>
					</div>
					 <?
					 	$i = 1;
						while($obj = mysql_fetch_array($ressel))
						{
							$status = "";
							if($obj["used_auction"]!="")
							{
								$qryauc = "select *,p.".$lng_prefix."name as name from auction a left join products p on a.productID=p.productID where a.auctionID='".$obj["used_auction"]."'";
								$resauc = mysql_query($qryauc);
								$objauc = mysql_fetch_array($resauc);
							}
					  ?>
						<div <? if($i!=$total){?> style="height: 40px; border-bottom: 1px solid #cddce9;" <? } else { ?> style="height: 40px;"  <? } ?>>
							<div class="voucherdate" align="center"><span class="normal_text"><b><?=arrangedate(substr($obj["issuedate"],0,10));?></span></b></div>
							<div class="voucherdescription"><? if($obj["voucher_status"]==1 || $obj["voucher_status"]==2){?><span class="normal_text"><strike><b><?=stripslashes($obj["voucher_desc"]);?></b></strike></span><? } else { ?><span class="normal_text"><b><?=stripslashes($obj["voucher_desc"]);?></b></span> <? } ?></div>
							<div class="voucherprice" align="center"><span class="normal_text"><?=$obj["voucher_type"]==2?$Currency.$obj["bids_amount"]:substr($obj["bids_amount"],0,strpos($obj["bids_amount"],".",1))."&nbsp;".$lng_bids;?></span></div>
							<div class="vouchercombinable" align="center"><span class="normal_text"><?=$obj["combinable"]==1?"Yes":"No"; ?></span></div>
							<div class="voucherauction" align="center"><? if($obj["used_auction"]!="") { ?><a href="auction_<?=str_replace(" ","_",strtolower($objauc["name"]));?>_<?=$objauc["auctionID"];?>.html" class="alink"><?=$objauc["name"];?></a><? } else { ?>--<? } ?></div>
							<div class="voucherstatus" align="center"><span class="normal_text"><? if($obj["voucher_status"]=='1'){?><?=$lng_voucherused;?><? } elseif($obj["voucher_status"]=='2'){ ?><?=$lng_voucherexpired;?><? } else { ?><?=$lng_voucherrunning;?><? } ?></span></div>
							<div class="voucherexpiry" align="center"><span class="normal_text"><b><?=$obj["expirydate"]!="0000-00-00 00:00:00"?arrangedate(substr($obj["expirydate"],0,10)):"--";?></b></span></div>
							<div class="cleaner"></div>
						</div>
					   <?
					   		$i++;
						   }
					   ?>
					<div class="strip">
						<div style="padding-top: 2px;">
							<?
							if($PageNo>1)
							{
							  $PrevPageNo = $PageNo-1;
							?>
								  <A class="alink" href="vouchers_<?=$PrevPageNo;?>.html">&lt; <?=$lng_previouspage;?></A>
							<?
								if($totalpage>2 && $totalpage!=$PageNo)
								{
							 ?>
								<span class="paging">&nbsp;|</span>
							 <?
								}
							  }
							 ?>&nbsp;
							 <?php
							  if($PageNo<$totalpage)
							  {
								 $NextPageNo = 	$PageNo + 1;
							  ?>
								  <A class="alink" id="next" href="vouchers_<?=$NextPageNo;?>.html"><?=$lng_nextpage;?> &gt;</A>
							  <?
							   }
							  ?>
					     </div>
					</div>					   
				 <? } else { ?>
				  <div style="clear: both; height: 15px;">&nbsp;</div>
					<div align="center" class="noauction_message"><?=$lng_novoucher;?></div>				 
				  <div style="clear: both; height: 15px;">&nbsp;</div>
				 <? } ?>
				</div>
				<div class="bottomline">
					<div class="leftsidecorner"></div>
					<div class="middlecorner"></div>
					<div class="rightsidecorner"></div>
				</div>
			</div>
		</div>
<?
	include("footer.php");
?>		
</div>
</body>
</html>
