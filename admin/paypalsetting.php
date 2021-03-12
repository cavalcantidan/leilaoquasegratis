<?
	include("connect.php");
	include("config.inc.php");
	include("security.php");
	include("security.php");
	$type1 = 1;
	include("pagepermission.php");
	
	if($_POST["editinfo"]!="")
	{
		$businessid = $_POST["businessid"];
		$token = $_POST["token"];
		
		$qryupd = "update paypal_info set business_id='".$businessid."',token='".$token."' where id='1'";
		mysql_query($qryupd) or die(mysql_error());
		header("location: message.php?msg=54");
	}
	
	$qrysel = "select * from paypal_info where id='1'";
	$ressel = mysql_query($qrysel);
	$row = mysql_fetch_object($ressel);
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
		if(document.f1.businessid.value=="")
		{
			alert("Por favor informe o Paypal Business ID!");
			document.f1.businessid.focus();
			return false;
		}
		if(document.f1.token.value=="")
		{
			alert("Por favor informe o Paypal Token!");
			document.f1.token.focus();
			return false;
		}
	}
</script>
</head>

<BODY bgColor=#ffffff>   
<form name="f1" action="paypalsetting.php" method="post" onsubmit="return Check(f1)">
<table width="100%" cellpadding="0" cellSpacing="10">
  <tr>
	<td class="H1">Configurar paypal</td>
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
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Paypal Business ID :</td>
		  <td><input type="text" size="50" name="businessid" value="<?=$row->business_id;?>" maxlength="255" /></td>
		</tr>
	    <tr valign="middle">
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Paypal Authentication Token :</td>
		  <td><input type="text" size="50" name="token" value="<?=$row->token;?>" maxlength="255" /></td>
		</tr>
	    <tr valign="middle">
			<td>&nbsp;</td>
		</tr>
		<tr valign="middle">
			<td colspan="2" align="center">
				<input type="submit" name="editinfo" value="Enviar" class="bttn" />
			</td>
		</tr>
	 </table>
	</td>
  </tr>
</table>
</form>
</BODY>
</html>
