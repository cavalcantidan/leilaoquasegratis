<?
	include("connect.php");
	include("admin.config.inc.php");
	include("security.php");
	
	if($_POST["edit"]!="")
	{
		$minbidprice = $_POST["minbidprice"];
		
		$qryupd = "update general_setting set min_bid_price='".$minbidprice."' where id='1'";
		mysql_query($qryupd) or die(mysql_error());
		header("location: message.php?msg=68");
		exit;
	}
	
	$qrysel = "select * from general_setting where id='1'";
	$ressel = mysql_query($qrysel);
	$objsel = mysql_fetch_object($ressel);
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
		if(document.f1.minbidprice.value=="")
		{
			alert("Por favor informe o preço mínimo do lance!");
			document.f1.minbidprice.focus();
			return false;
		}
	}
</script>
</head>

<BODY bgColor=#ffffff>   
<form name="f1" action="" method="post" onsubmit="return Check(f1)">
<table width="100%" cellpadding="0" cellSpacing="10">
  <tr>
	<td class="H1">Gerenciar Lance m&iacute;nimo Pre&ccedil;o Para o c&aacute;lculo simulado</td>
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
	    <tr valign="middle">
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Pre&ccedil;o do lance minimo:</td>
		  <td><input type="text" size="10" name="minbidprice" value="<?=$objsel->min_bid_price;?>" />&nbsp;<font class="a"><?=$Currency;?></font></td>
		</tr>
		<tr valign="middle">
			<td>&nbsp;</td>
		</tr>
		<tr valign="middle">
			<td colspan="2" align="center">
				<input type="submit" name="edit" value="Editar" class="bttn" />
			</td>
		</tr>
	 </table>
	</td>
  </tr>
</table>
</form>
</BODY>
</html>
