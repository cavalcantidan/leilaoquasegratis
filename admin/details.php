<?php
	include_once("admin.config.inc.php");
	include("connect.php");
	include("functions.php");
	include("security.php");
	$type1 = "1";
	$type2 = "2";
	include("pagepermission.php");
	$aid = $_GET["aid"];
	$qrysel = "select * from won_auctions w left join auction a on w.auction_id=a.auctionID left join registration r on w.userid=r.id left join products p on a.productID=p.productID  left join shipping s on a.shipping_id=s.id left join countries c on r.country=c.countryId where payment_date!='0000-00-00 00:00:00' and w.auction_id='".$aid."'";
	$result = mysql_query($qrysel);
	$total=mysql_num_rows($result);
	$obj = mysql_fetch_object($result);
	if($obj->fixedpriceauction==1){ $fprice = $obj->auc_fixed_price; }
	elseif($obj->offauction==1) { $fprice = "0.00"; }
	else { $fprice = $obj->auc_final_price; }
	
	if($obj->delivery_country!="")
	{
		$qrydelc = "select * from countries where countryId='".$obj->delivery_country."'";
		$resdelc = mysql_query($qrydelc) or die(mysql_error());
		$objdelc = mysql_fetch_object($resdelc);
	}
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
<body bgcolor="#ffffff">
	
	<TABLE cellSpacing=5 cellPadding=0  border=0 width="99%">
		<TR>
			<TD class=H1>Detalhes Do Leil&atilde;o</TD>
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
						<td class="simpletitle" colspan="2">Leil&atilde;o ID:&nbsp;&nbsp;<?=$obj->auctionID;?></td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td valign="top" width="18%"><font class="simpletitle">Endere&ccedil;o de Cobran&ccedil;a:</font></td>
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
						<td valign="top" width="18%"><font class="simpletitle">Endere&ccedil;o de Entrega:</font></td>
						<td valign="top" width="30%">
								<table border="0" cellpadding="0" cellspacing="0" width="100%">
									<tr>	
										<td>
								<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td class="normalfont"><?=$obj->delivery_name;?></td>
								</tr>
								<tr>
									<td class="normalfont"><?=$obj->delivery_addressline2==""?$obj->delivery_addressline1.",".$obj->delivery_postcode:$obj->delivery_addressline1;?></td>
								</tr>
								<? if($obj->delivery_addressline2!=""){ ?>
								<tr>
									<td class="normalfont"><?=$obj->delivery_addressline2.",".$obj->delivery_postcode;?></td>
								</tr>
								<? } ?>
								<tr>
									<td class="normalfont"><?=$obj->delivery_city.",".$objdelc->printable_name;?></td>
								</tr>
								
								</table>
							</td>
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
						<td class="simpletitle">Telefone:</td>
						<td><?=$obj->phone;?></td>
					</tr>
					<tr>
						<td class="simpletitle">Email:</td>
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
					  <TD width="32%" align="center">Leil&atilde;o</TD>
					  <TD width="15%" align="center">Data do Pagamento</TD>
					  <td width="8%" align="center">Pre&ccedil;o</td>
					  <TD width="5%" align="center">Entrega</TD>
					  <TD width="8%" align="center">Total</TD>
					</TR>
					<tr>
						<td align="center"><?=$obj->name;?></td>
						<td align="center"><?=arrangedate(substr($obj->payment_date,0,10));?></td>
						<td align="center"><?=$Currency.' '.$fprice;?></td>
						<td width="5%" align="center"><?=$Currency.' '.$obj->shippingcharge;?></td>
						<td width="8%" align="center"><?=$Currency.' '.number_format($obj->shippingcharge + $fprice,2);?></td>
					</tr>
				</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td align="center">
				<table border="0" align="center" cellpadding="2" cellspacing="4">
						<td><input type="button" value="  Voltar  " class="bttn" name="submit1" onClick="javascript: history.go(-1);"></td>
						<td><input type="button" value="  Imprimir  " class="bttn" onClick="OpenPopup('printingoutput.php?aid=<?=$aid;?>');"></td>
				</table>
			</td>
		</tr>
		<!--end to display addresses-->
		
	</tbody>
	</table>
	<br><br>
</body>
</html>
