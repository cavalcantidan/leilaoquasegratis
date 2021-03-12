<?
	include("config/connect.php");
	include("session.php");
	include("functions.php");
	$uid = $_SESSION["userid"];
	$winid = $_GET["winid"];
	$winid1 = base64_decode($_GET["winid"]);
	$expwin = explode("&",$winid1);
	$aid = $expwin[1];

	$qryauc = "select *,p.".$lng_prefix."name as name from auction a left join products p on a.productID=p.productID left join shipping s on a.shipping_id=s.id where a.auctionID='".$aid."'";
	$resauc = mysql_query($qryauc);
	$objauc = mysql_fetch_object($resauc);

	
	$qryvou = "select *,uv.id as useruseid,".$lng_prefix."voucher_title as voucher_title from user_vouchers uv left join vouchers v on uv.voucherid=v.id where uv.user_id='".$uid."' and uv.voucher_status='0'";
	$resvou = mysql_query($qryvou);
	$totalvou = mysql_num_rows($resvou);
	$finalamount = $expwin[0] + $objauc->shippingcharge;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
<title><?=$AllPageTitle;?></title>
<link href="css/style_youbid.css" rel="stylesheet" type="text/css" />
<link href="css/menu.css" rel="stylesheet" type="text/css" />
<!--[if lte IE 6]>
<link href="css/menu_ie.css" rel="stylesheet" type="text/css" />
<![endif]-->
<script language="javascript" type="text/javascript" src="js/function.js"></script>
<script language="javascript">
function Check()
{
	if(document.f1.novoucher.checked==false && document.f1.voucher.value=='none')
	{
		alert("<?=$lng_plschoosevoucher;?>");
		document.f1.voucher.focus();
		return false;
	}
}
function number_format( number, decimals, dec_point, thousands_sep ) {
    var n = number, c = isNaN(decimals = Math.abs(decimals)) ? 2 : decimals;
    var d = dec_point == undefined ? "." : dec_point;
    var t = thousands_sep == undefined ? "," : thousands_sep, s = n < 0 ? "-" : "";
    var i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
    
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}
function TotalCountAmount(value)
{
		totalamount = document.getElementById('final_amount');
		subtotalamount = document.getElementById('sub_final_amount');
		voucheramount = document.getElementById('amountvoucher');
		voucher = value.split(",");
		selvoucheramount = voucher[2];
		vouchertype = voucher[3];

	if(vouchertype==2)
	{
		if(value!="none")
		{
			auctionamountvalue = Number(document.getElementById('auctionamount').innerHTML);
			shippingamountvalue = Number(document.getElementById('shippingamount').innerHTML);
			
			oldtotalamount = auctionamountvalue;

			if(auctionamountvalue<selvoucheramount)
			{
				selvoucheramount1 = auctionamountvalue;
			}
			else
			{
				selvoucheramount1 = selvoucheramount;
			}
			
			newtotalamount = oldtotalamount - selvoucheramount;
			if(newtotalamount<0)
			{
				newtotalamount = shippingamountvalue + 0.00;
			}
			else
			{
				 newtotalamount = newtotalamount + shippingamountvalue
			}
			voucheramount.innerHTML =  number_format(selvoucheramount1,2,'.','');
			document.getElementById('dispvoucheramount').innerHTML = selvoucheramount;
			if(document.f1.novoucher.checked==false)
			{
			totalamount.innerHTML = number_format(newtotalamount,2,'.','');
			subtotalamount.innerHTML = number_format(newtotalamount-shippingamountvalue,2,'.','');
			document.getElementById("vouchercontent").style.display = 'block';
			}
		}
		else
		{
			document.getElementById("vouchercontent").style.display = 'none';
			totalamount = document.getElementById('final_amount');
			subtotalamount = document.getElementById('sub_final_amount');
		
			auctionvalue = Number(document.getElementById('auctionamount').innerHTML);
			shippingvalue = Number(document.getElementById('shippingamount').innerHTML);
		
			totalvalue = auctionvalue + shippingvalue;
			totalamount.innerHTML = number_format(totalvalue,2,'.','');
			subtotalamount = number_format(totalvalue-shippingvalue,2,'.','');
		}
		document.getElementById('freebidsnote').style.display = 'none';
	}
	else
	{
			auctionvalue = Number(document.getElementById('auctionamount').innerHTML);
			shippingvalue = Number(document.getElementById('shippingamount').innerHTML);
		
			totalvalue = auctionvalue + shippingvalue;
			totalamount.innerHTML = number_format(totalvalue,2,'.','');
			subtotalamount.innerHTML = number_format(auctionvalue,2,'.','');
			voucheramount.innerHTML = "0.00";
			document.getElementById('dispvoucheramount').innerHTML = "0.00";
			document.getElementById("vouchercontent").style.display = 'block';
			if(value!="none")
			{
			document.getElementById('freebidsnote').style.display = 'block';
			}
			else
			{
			document.getElementById('freebidsnote').style.display = 'none';
			}
	}
}
function HideVoucher()
{
	value = document.getElementById('voucher').value;
	voucher = value.split(",");
	vouchertype = voucher[3];
	if(document.f1.novoucher.checked==true)
	{
		document.getElementById("vouchercontent").style.display = 'none';
	
		totalamount = document.getElementById('final_amount');
		subtotalamount = document.getElementById('sub_final_amount');
	
		auctionvalue = Number(document.getElementById('auctionamount').innerHTML);
		shippingvalue = Number(document.getElementById('shippingamount').innerHTML);
	
		totalvalue = auctionvalue + shippingvalue;
		totalamount.innerHTML = number_format(totalvalue,2,'.','');
		subtotalamount.innerHTML = number_format(auctionvalue,2,'.','');
		document.getElementById('freebidsnote').style.display = 'none';
	}
	else
	{
		if(document.f1.voucher.value=='none')
		{
			document.getElementById("vouchercontent").style.display = 'none';
		
			totalamount = document.getElementById('final_amount');
			subtotalamount = document.getElementById('sub_final_amount');
		
			auctionvalue = Number(document.getElementById('auctionamount').innerHTML);
			shippingvalue = Number(document.getElementById('shippingamount').innerHTML);
		
			totalvalue = auctionvalue + shippingvalue;
			totalamount.innerHTML = number_format(totalvalue,2,'.','');
			subtotalamount.innerHTML = number_format(auctionvalue,2,'.','');
			document.getElementById('freebidsnote').style.display = 'none';
		}
		else
		{
			document.getElementById("vouchercontent").style.display = 'block';
		
			totalamount = document.getElementById('final_amount');
			subtotalamount = document.getElementById('sub_final_amount');
		
			auctionvalue = Number(document.getElementById('auctionamount').innerHTML);
			shippingvalue = Number(document.getElementById('shippingamount').innerHTML);
			vouchervalue = Number(document.getElementById('amountvoucher').innerHTML)
		
			totalvalue = auctionvalue - vouchervalue;
			if(totalvalue<0)
			{
				totalvalue = shippingvalue + 0.00;
			}
			totalamount.innerHTML = number_format(totalvalue + shippingvalue,2,'.','');
			subtotalamount.innerHTML = number_format(totalvalue,2,'.','');
			if(vouchertype==1)
			{
			document.getElementById('freebidsnote').style.display = 'block';
			}
		}
		
	}
}
</script>
</head>


<body>
<div id="main_div">
<?
	include("header.php");
?>
		<div id="middle_div">
			<? include("leftside.php"); ?>
			<div class="inner-container">
				<div class="titlebar">
					<div class="leftbar"></div>
					<div class="middlebar"><div class="page_title_font"><?=$lng_myauctionsavenue;?> - <?=$lng_makepayment;?></div></div>
					<div class="rightbar"></div>
				</div>
				<div class="bodypart" style="text-align: left;">
				<form name="f1" action="payment.php" method="post" onsubmit="return Check();">
							<div style="margin-top: 30px; margin-left: 20px;" class="normal_text">
								<?=$lng_plsselvoucher;?> : <select name="voucher" onchange="TotalCountAmount(this.value)" id="voucher">
									<option value="none"><?=$lng_selectone;?></option>
									<?
									 while($obj = mysql_fetch_object($resvou))
									 {
									 ?>
									<option value="<?=$obj->voucherid;?>,<?=$obj->useruseid;?>,<?=$obj->bids_amount;?>,<?=$obj->voucher_type;?>"><?=$obj->voucher_title;?></option>
									<? } ?>
								</select></div>
							<div style="margin-left: 20px; margin-top: 20px;" class="normal_text"><input type="checkbox" name="novoucher" value="novoucher" onclick="HideVoucher();" />&nbsp;<?=$lng_dontwantvou;?><br /><br /><br /><br /></div>
								<div style="margin-left: 20px;">
								<div class="darkblue-text-17-b" style="margin-left: 20px;"><?=$lng_auctiondetails;?>:</div>
								<div id="footerspace" style="clear:both; height: 10px;"></div>
							<div style="width: 600px;margin-left: 20px;">
								<div style="float:left; width: 500px; height:15px;" class="normal_text"><?=$objauc->name;?></div>
								<div style="float: right; width: 100px; height:15px;" class="normal_text" align="right"><?=$Currency;?>&nbsp;<span id="auctionamount"><?=number_format($expwin[0],2) ?></span></div>
								<div id="vouchercontent" style="display:none">
								<div style="float:left; width: 500px; height:15px;" class="normal_text"> <?=$lng_vouchermaximum;?><?=$Currency;?> <span id="dispvoucheramount"></span>)</div>
								<div style="float: right; width: 100px; height:15px;" class="normal_text" align="right">-&nbsp;<?=$Currency;?>&nbsp;<span id="amountvoucher"><?=number_format($obj->bids_amount,2) ?></span></div>
								</div>
								<div style="clear: both; width: 600px; height:15px; padding-top:5px;background:url(images/hg_motd2.gif) repeat-x center;"></div>
                                <div style="float:left; width: 500px;" class="normal_text"><?=$lng_subtotal;?></div>
                                <div style="float: right; width: 100px;" class="normal_text" align="right">&nbsp;<?=$Currency;?>&nbsp;<span id="sub_final_amount"><?=number_format($expwin[0],2) ?></span></div>
								<div style="float:left; width: 500px; height:15px;" class="normal_text"><?=$lng_shippingcharge;?></div>
								<div style="float: right; width: 100px; height:15px;" class="normal_text" align="right">+&nbsp;<?=$Currency;?>&nbsp;<span id="shippingamount"><?=number_format($objauc->shippingcharge,2) ?></span></div>
								<div style="clear: both; width: 600px; height:15px; padding-top:5px;background:url(images/hg_motd2.gif) repeat-x center;"></div>
								<div style="float:left; width: 500px;" class="normal_text"><?=$lng_totalpayment;?></div>
								<div style="float: right; width: 100px;" class="normal_text" align="right">&nbsp;<?=$Currency;?>&nbsp;<span id="final_amount"><?=number_format($finalamount,2) ?></span></div>
								</div>
								<div style="clear:both; padding-top: 10px; margin-left: 20px; display:none" class="normal_text" id="freebidsnote"><span class="red-text-12-b"><?=$lng_vouchernote1;?></span><?=$lng_vouchernote2;?></div>
								<div id="footerspace" style="clear:both; height: 35px;"></div>
								<input type="hidden" value="<?=$winid;?>" name="winid" />
							<input type="image" value="Make Payment" name="submit" src="<?=$lng_imagepath;?>make a payment_btn.png" onmouseout="this.src='<?=$lng_imagepath;?>make a payment_btn.png'" onmouseover="this.src='<?=$lng_imagepath;?>make a payment_hover_btn.png'" style="margin-left: 220px;" />
							<div style="height: 20px; clear:both">&nbsp;</div>
							</div>
						</form>				
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
