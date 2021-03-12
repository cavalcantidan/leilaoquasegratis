<?php
	include_once("admin.config.inc.php");
	include("connect.php");
	include("functions.php");
	include("security.php");
	$type1 = "1";
	$type3 = "2";
	include("pagepermission.php");
	$aid = $_GET["aid"];
	$qrysel = "select * from won_auctions w left join auction a on w.auction_id=a.auctionID left join registration r on w.userid=r.id left join products p on a.productID=p.productID  left join shipping s on a.shipping_id=s.id left join countries c on r.country=c.countryId where payment_date!='0000-00-00 00:00:00' and w.auction_id='".$aid."'";
	$result = mysql_query($qrysel);
	$total=mysql_num_rows($result);
	$obj = mysql_fetch_object($result);
	if($obj->fixedpriceauction==1){ $fprice = $obj->auc_fixed_price; }
	elseif($obj->offauction==1) { $fprice = "0.00"; }
	else { $fprice = $obj->auc_final_price; }
?>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>">
</head>

<link href="main.css" type="text/css" rel="stylesheet">
<script language="javascript">
	function OpenPopup(url){
		window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=700,height=475,screenX=150,screenY=200,top=200,left=200')
}
</script>
<body bgcolor="#ffffff" onLoad="javascript: window.print();">
	
	<TABLE cellSpacing=5 cellPadding=0  border=0 width="99%">
		<TR>
			<TD class=H1>Auction Details</TD>
		</TR>
		<TR>
			<TD background="images/vdots.gif"><IMG height=1 
			  src="images/spacer.gif" width=1 border=0></TD>
		</TR>
		<!--Display Addresses-->
		<tr>
			<td>
				<table border="0" cellpadding="0" cellspacing="4" width="100%">
					<tr>
						<td class="simpletitle">Auction ID:&nbsp;&nbsp;<?=$obj->auctionID;?></td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td class="simpletitle">Auction Code:&nbsp;&nbsp;<?=$obj->auction_code;?></td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td valign="top" width="10%"><font class="simpletitle">Customer Address:</font></td>
						<td width="30%">
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td class="normalfont"><?=$obj->firstname."&nbsp;".$obj->lastname;?></td>
							</tr>
							<tr>
								<td class="normalfont"><?=$obj->addressline1;?></td>
							</tr>
							<tr>
								<td class="normalfont"><?=$obj->addressline2.",".$obj->postcode;?></td>
							</tr>
							<tr>
								<td class="normalfont"><?=$obj->city.",".$obj->printable_name;?></td>
							</tr>
							
							</table>
						</td>
					</tr>
					<tr height="10">
						<td></td>
					</tr>
					<TR>
						<TD background="images/vdots.gif" colspan="10"><IMG height=1 src="images/spacer.gif" width=1 border=0></TD>
					</TR>
					<tr height="5">
						<td></td>
					</tr>
					<tr>
						<td class="simpletitle">Telephone No:</td>
						<td><?=$obj->phone;?></td>
					</tr>
					<tr>
						<td class="simpletitle">Email Address:</td>
						<td><a href="mailto:<?=$obj->email?>"><?=$obj->email;?></a></td>
					</tr>
					<tr height="10">
						<td></td>
					</tr>
					<TR>
						<TD background="images/vdots.gif" colspan="10"><IMG height=1 src="images/spacer.gif" width=1 border=0></TD>
					</TR>
					<tr height="10">
						<td></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table border="1" width="100%" class="t-a" cellspacing="0">
				<tbody>
					<TR class="th-a">
					  <td width="13%" align="center">Auction Code</td>
					  <TD width="32%" align="center">Auction Name</TD>
					  <TD width="15%" align="center">Payment Date</TD>
					  <td width="8%" align="center">Price</td>
					  <TD width="5%" align="center">Shipping</TD>
					  <TD width="8%" align="center">Total</TD>
					</TR>
						<td align="center"><?=$obj->auction_code;?></td>
						<td align="center"><?=$obj->name;?></td>
						<td align="center"><?=arrangedate(substr($obj->payment_date,0,10));?></td>
						<td align="center"><?=$Currency.$fprice;?></td>
					    <td width="5%" align="center"><?=$Currency.$obj->shippingcharge;?></td>
						<td width="8%" align="center"><?=$Currency.number_format($obj->shippingcharge + $fprice,2);?></td>
					</tr>
				</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<!--end to display addresses-->
		
	</tbody>
	</table>
	<br><br>
</body>
</html>
