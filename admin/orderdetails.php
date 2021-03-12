<?php
	include_once("admin.config.inc.php");
	include("connect.php") ;
	
	if(isset($_GET["oid"])){
		$OrderId = $_GET["oid"];
		$Oquery = "Select o.*,DATE_FORMAT(purchasedate,'%m/%d/%Y') as ddate,c.printable_name as country,o.custmer_state as sname,o.delivery_state as sname1,d.printable_name as delcountry from order_total o left join countries c on o.custmer_country=c.countryid left join countries d on o.delivery_country = d.countryid where o.id='$OrderId'";
		$Oresult = mysql_query($Oquery) or die(mysql_error());
		$Ototalrows = mysql_num_rows($Oresult);
		$Orow = mysql_fetch_object($Oresult);
	}elseif(isset($_POST["submit"])){
		$Oid = $_POST["oid"];
		$Oquery = "Update order_total set order_status='2|2' where id='$Oid'";
		mysql_query($Oquery) or die(mysql_error());
		header("location:manageorder.php");
		exit;
	}elseif(isset($_POST["submit1"])){
		$Oid = $_POST["oid"];
		$Oquery = "Update order_total set order_status='2|3' where id='$Oid'";
		mysql_query($Oquery) or die(mysql_error());
		header("location:manageorder.php");
		exit;
	}else{
		header("location:manageorder.php");
		exit;
	}
?>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>">
</head>

<link href="main.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
	function conf()
	{
		if(confirm("Are You Sure"))
		{
			return true;
		}
		return false;
	}
	function delconfirm(loc)
	{
		if(confirm("Are you Sure Do You Want To Delete"))
		{
			window.location.href=loc;
		}
		return false;
	}
</script>
<script language="javascript">
	function OpenPopup(url){
		window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=700,height=475,screenX=150,screenY=200,top=200,left=200')
}
</script>
<body bgcolor="#ffffff">
	
	<TABLE cellSpacing=5 cellPadding=0  border=0 width="99%">
		<TR>
			<TD class=H1>Orders</TD>
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
						<td class="simpletitle">Order No:</td>
						<td><?=$Orow->id;?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td valign="top" width="20%"><font class="simpletitle">Custmer Address:</font></td>
						<td width="30%">
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
							
							<?php /*?><tr>
								<td class="normalfont"><?=$Orow->custmer_company;?></td>
							</tr><?php */?>
							<tr>
								<td class="normalfont"><?=$Orow->custmer_name;?></td>
							</tr>
							<tr>
								<td class="normalfont"><?=$Orow->custmer_address;?></td>
							</tr>
							<tr>
								<td class="normalfont"><?=$Orow->custmer_city.",".$Orow->custmer_postcode;?></td>
							</tr>
							<tr>
								<td class="normalfont"><?=$Orow->sname.",".$Orow->country;?></td>
							</tr>
							
							</table>
						</td>
						<td valign="top" class="simpletitle" width="20%">Shipping Address:</td>
						<td width="30%">
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
							
							<?php /*?><tr>
								<td class="normalfont"><?=$Orow->delivery_company;?></td>
							</tr><?php */?>
							<tr>
								<td class="normalfont"><?=$Orow->delivery_name;?></td>
							</tr>
							<tr>
								<td class="normalfont"><?=$Orow->delivery_address;?></td>
							</tr>
							<tr>
								<td class="normalfont"><?=$Orow->delivery_city.",".$Orow->delivery_postcode;?></td>
							</tr>
							<tr>
								<td class="normalfont"><?=$Orow->sname1.",".$Orow->delcountry;?></td>
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
						<td><?=$Orow->custmer_telephone;?></td>
					</tr>
					<tr>
						<td class="simpletitle">Email Address:</td>
						<td><a href="mailto:<?=$Orow->custmer_email?>"><?=$Orow->custmer_email;?></a></td>
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
					<tr>
						<td class="simpletitle">Payment Method:</td>
						<td><?=$Orow->payment_method;?></td>
					</tr>
					<tr>
						<td class="simpletitle">Order Status:</td>
						
						<td><? if(substr($Orow->order_status,2)==1) echo "Pending"; elseif(substr($Orow->order_status,2)==2) echo "Delivered"; elseif(substr($Orow->order_status,2)==3) echo "Cancelled";?></td>
					</tr>
				</table>
			</td>
		</tr>
		<?
			$Pquery = "select * from order_products where order_id='$OrderId'";
			$Presult = mysql_query($Pquery) or die(mysql_error());
			$Ptotalrows = mysql_num_rows($Presult);
			//$Prow = mysql_fetch_object($Presult);
			?>
		<tr>
			<td>
				<table border="1" width="100%" class="t-a" cellspacing="0">
				<tbody>
					<TR class="th-a">
					  <td width="6%">SrNo</td>
					  <td width="13%">Product Code</td>
					  <TD width="32%">Product Name</TD>
					  <TD width="15%">Purchase Date</TD>
					  <td width="8%">Price</td>
					  <td width="5%">Qty</td>
					  <TD width="8%">Amount</TD>
					  <TD width="5%">Tax</TD>
					  <TD width="8%">Total</TD>
					</TR>
					<?
						for($i=1;$i<=$Ptotalrows;$i++){
						$Prow = mysql_fetch_object($Presult);
					?>
					<tr>
						<td><?=$i?></td>
						<td><?=$Prow->product_code;?></td>
						<td><?=$Prow->product_name;?></td>
						<td><?=$Orow->ddate;?></td>
						<td><?=$Prow->product_price;?></td>
						<td><?=$Prow->product_quantity;?></td>
						<td><?=$Prow->product_price * $Prow->product_quantity;?></td>
						<td><?=(int)$Prow->product_tax;?>%</td>
						<td><?=$Prow->final_price;?></td>
					</tr>
					<? } ?>
				</tbody>
				</table>
			</td>
		</tr>
		
		<?
			$Tquery = "Select * from order_total where id='$OrderId'";
			$Tresult = mysql_query($Tquery) or die(mysql_error());
			$Ttotalrows = mysql_num_rows($Tresult);
			//$Trow = mysql_fetch_object($Tresult);
			
		?>
		<tr>
			<td align="right" width="100%">
			<table border="0" cellpadding="2" cellspacing="2" width="100%" align="right">
			<?
				for($i=0;$i<$Ttotalrows;$i++){
				$Trow = mysql_fetch_object($Tresult);
			?>
			<tr>
				<td align="right" width="93%">Sub-total : </td>
				<td align="right" width="5%"><?="&pound;".$Trow->sub_total;?></td>
			</tr>
			<tr>
				<td align="right" width="93%">Shipping Charge : </td>
				<td align="right" width="5%"><?="&pound;".$Trow->shipping;?></td>
			</tr>
			<tr>
				<td align="right" width="93%">Tax : </td>
				<td align="right" width="5%"><?="&pound;".$Trow->tax;?></td>
			</tr>
			<tr>
				<td align="right" width="93%">Grand Total : </td>
				<td align="right" width="5%"><?="&pound;".$Trow->grandtotal;?></td>
			</tr>
			<? } ?>
			</table>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td align="center">
				<table border="0" align="center" cellpadding="2" cellspacing="4">
				<form action="orderdetails.php" method="post">
					<tr>
						<? if($_REQUEST['prod']==""){ ?>
						<? if(substr($Orow->order_status,2)==1){?>
						<td><input type="submit" value="  Delivered  " class="bttn" name="submit"></td><? } ?>
						<td><input type="submit" value="  Cancel  " class="bttn" name="submit1"></td>
						<td><input type="button" value="  Print  " class="bttn" onClick="OpenPopup('printingoutput.php?oid=<?=$OrderId;?>');"></td>
						<? } else { ?>
						<td><input type="button" value="  Print  " class="bttn" onClick="window.print();"></td>
						<? } ?>
					</tr>
					<input type="hidden" value="<?=$OrderId?>" name="oid">
				</form>
				</table>
			</td>
		</tr>
		<!--end to display addresses-->
		
	</tbody>
	</table>
	<br><br>
</body>
</html>
