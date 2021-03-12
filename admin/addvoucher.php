<?
	include("connect.php");
	include("admin.config.inc.php");
	include("security.php");
	
	$qrylang = "select * from language";
	$reslang = mysql_query($qrylang);
	$totallang = mysql_num_rows($reslang);
	
	$title = $_POST["title1"];
	$amount = $_POST["amount"];
	$combinable = $_POST["combinable"];
	$vouchertype = $_POST["vouchertype"];
	$validity = $_POST["validity"];
// value 1 for free bids voucher
//value 2 for money voucher
	
	if($_POST["addvoucher"]!="")
	{
		$qrysel = "select * from vouchers where voucher_title='$title'";
		$ressel = mysql_query($qrysel);
		$totalrow = mysql_affected_rows();
		if($totalrow>0)
		{
			header("location: message.php?msg=64");
			exit;		
		}
		else
		{
			$qryins = "Insert into vouchers (voucher_title,combinable,bids_amount,voucher_type,validity)  values('".$title."','".$combinable."','".$amount."','".$vouchertype."','".$validity."')";
			mysql_query($qryins) or die(mysql_error());
			
			$insertid = mysql_insert_id();
			
			if($totallang>0)
			{
				for($i=1;$i<=$totallang;$i++)
				{
					$objlang = mysql_fetch_object($reslang);
					$qryupd = "update vouchers set ".$objlang->language_prefix."_voucher_title='".addslashes($_POST["title$i"])."' where id='".$insertid."'";			
					mysql_query($qryupd) or die(mysql_error());
				}
			}
			header("location: message.php?msg=65");
			exit;
		}
	}
	
	if($_POST["editvoucher"]!="")
	{
		$id = $_POST["editid"];
		$qrysel = "select * from vouchers where voucher_title='$title' and id<>$id";
		$ressel = mysql_query($qrysel);
		$totalrow = mysql_affected_rows();
		if($totalrow>0)
		{
			header("location: message.php?msg=64");
			exit;		
		}
		else
		{
			$qryupd = "update vouchers set voucher_title='$title',combinable='$combinable',bids_amount='$amount',voucher_type='$vouchertype',validity='$validity'";
			
			if($totallang>0)
			{
				for($i=1;$i<=$totallang;$i++)
				{
					$objlang = mysql_fetch_object($reslang);
					$qryupd .= ",".$objlang->language_prefix."_voucher_title='".$_POST["title$i"]."'";
				}			
			}
			$qryupd .= " where id='$id'";
			mysql_query($qryupd) or die(mysql_error());
			header("location: message.php?msg=66");
			exit;
		}
	}
	
	if($_GET["delid"]!="")
	{
		$qrysel = "select * from user_vouchers where voucherid='".$_GET["delid"]."'";
		$ressel = mysql_query($qrysel);
		$totalvou = mysql_num_rows($ressel);
		if($totalvou>0)
		{
			header("location: message.php?msg=74");
			exit;
		}
		$qryd = "delete from vouchers where id='".$_GET["delid"]."'";
		mysql_query($qryd) or die(mysql_error());
		header("location: message.php?msg=67");
		exit;
	}
	
	if($_REQUEST["voucher_edit"]!="" || $_REQUEST["voucher_delete"]!="")
	{
		if($_REQUEST["voucher_edit"]!="")
		{
			$id = $_REQUEST["voucher_edit"];
		}
		else
		{
			$id = $_REQUEST["voucher_delete"];
		}
		$qrysel = "select * from vouchers where id='$id'";
		$res = mysql_query($qrysel);
		$totalrow = mysql_affected_rows();
		$row = mysql_fetch_array($res);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
<title></title>
<LINK href="main.css" type=text/css rel=stylesheet>
<script language="javascript">
	function Check(f1)
	{
	countervalue = Number(f1.countervalue.value) - 1;
	if(countervalue>0)
	{
		for(i=1;i<=countervalue;i++)
		{
			obj = document.getElementById('title' + i);
			if(obj.value=="")
			{
			alert("Por favor digite o nome do bônus!");
			obj.focus();
			return false;
			}
		}
	}
		if(document.f1.vouchertype.value=='none')
		{
			alert("Por favor selecione tipo de bônus!");
			document.f1.vouchertype.focus();
			return false;
		}
		if(document.f1.amount.value=="")
		{
			alert("Por favor digite o valor/lances!")
			document.f1.amount.focus()
			return false;
		}
		
	}
</script>
</head>

<BODY bgColor=#ffffff>   
<form name="f1" action="addvoucher.php" method="post" onsubmit="return Check(f1)">
<table width="100%" cellpadding="0" cellSpacing="10">
  <tr>
	<td class="H1"><? if($_GET['voucher_edit']!="") { ?>
	   Editar 
      Bonus<? } else { if($_GET['voucher_delete']!=""){ ?>
       Excluir B&ocirc;nus
      <? }else { ?> Adicionar B&ocirc;nus<? } } ?></td>
  </tr>
  <tr>
	<td background="<?=DIR_WS_ICONS?>vdots.gif"><IMG height=1 src="<?=DIR_WS_ICONS?>spacer.gif" width=1 border=0></td>
  </tr>
  <tr>
	<td class="a" align="right" colspan=2>* Campos Obrigatorios</td>
  </tr>
  <tr>
 	<td>
 	  <table cellpadding="1" cellspacing="2">
<?php /*?>	    <tr valign="middle">
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Voucher Title :</td>
		  <td><input type="text" size="50" name="title" value="<?=stripslashes($row["voucher_title"]);?>" maxlength="255" /></td>
		</tr>
<?php */?>		<?
			if($totallang>0)
			{
				for($i=1;$i<=$totallang;$i++)
				{
					$objlang = mysql_fetch_object($reslang);
					$prefix  = $objlang->language_prefix;
		?>
	    <tr valign="middle">
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Nome do B&ocirc;nus(<?=$objlang->language_name;?>):</td>
		  <td><input type="text" size="50" name="title<?=$i;?>" value="<?=stripslashes($row[$prefix."_voucher_title"]);?>" id="title<?=$i;?>" maxlength="255" /></td>
		</tr>
		<?
				}
			}
		?>
		<input type="hidden" name="countervalue" value="<?=$i;?>" />
	    <tr valign="middle">
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Tipo :</td>
		  <td>
			<select name="vouchertype">
				<option value="none">-- Selecione --</option>
				<option <?=$row["voucher_type"]==1?"selected":"";?> value="1">B&ocirc;nus Lance Livre</option>
				<option <?=$row["voucher_type"]==2?"selected":"";?> value="2">B&ocirc;nus em Dinheiro</option>
			</select>
		  </td>
		</tr>
	    <tr valign="middle" id="moneyvoucher">
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Valor/Lances :</td>
		  <td><input type="text" size="10" name="amount" value="<?=$row["bids_amount"];?>" />&nbsp;<font class=a><?=$Currency;?></font></td>
		</tr>
	    <tr valign="middle" id="moneyvoucher">
          <td class=f-c align=right valign="middle" width="191">Validade:</td>
		  <td><input type="text" size="10" name="validity" value="<?=$row["validity"];?>" />
		  &nbsp; <span class="a">Dias</span><br />
		  <font class="a">Nota:Se o campo de validade for deixado em branco, ent&atilde;o  termina quando o usu&aacute;rio usar.</font></td>
		</tr>
	    <tr valign="middle">
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Combin&aacute;veis :</td>
		  <td>
		  	  <select name="combinable">
			  	<option value="1">Sim</option>
				<option <?=$row["combinable"]=="0"?"selected":"";?> value="0">N&atilde;o</option>
			  </select>
		  </td>
		</tr>
		<tr valign="middle">
			<td>&nbsp;</td>
		</tr>
		<tr valign="middle">
			<td colspan="2" align="center">
			<?
				if($_REQUEST["voucher_edit"])
				{
			?>
				<input type="submit" name="editvoucher" value="Editar" class="bttn" />
				<input type="hidden" name="editid" value="<?=$id?>" />
			<?
				}
				elseif($_REQUEST["voucher_delete"])
				{
			?>
			<input type="button" name="deletevoucher" value="Excluir" class="bttn" onclick="javascript: window.location.href='addvoucher.php?delid=<?=$id?>';" />
			<?
				}
				else
				{
			?>	
				<input type="submit" name="addvoucher" value="Adicionar" class="bttn" />
			<?
				}
			?>
			</td>
		</tr>
	 </table>
	</td>
  </tr>
</table>
</form>
</BODY>
</html>
