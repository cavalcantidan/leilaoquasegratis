<?
	include("connect.php");
	include("admin.config.inc.php");
	include("security.php");

	$smscount = $_POST["smscount"];
	$smsflag  = $_POST["smsflag"];
	
	if($_POST["submit"]!="")
	{
		if($smsflag=="")
		{
			$smsflag = "0";
		}
		$qryupd = "update general_setting set perday_sms='$smscount',perday_sms_flag='$smsflag' where id='1'";
		mysql_query($qryupd) or die(mysql_error());
		header("location: message.php?msg=73");
	}
	
	$qrysel = "select * from general_setting where id='1'";
	$ressel = mysql_query($qrysel);
	$row = mysql_fetch_object($ressel);
	$total = mysql_num_rows($ressel);
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
		if(document.f1.smscount.value=="")
		{
			alert("Por favor informe o SMS diário!!!");
			document.f1.smscount.focus();
			return false;
		}
	}
</script>
</head>

<BODY bgColor=#ffffff>   
<form name="f1" action="perdaysms.php" method="post" onsubmit="return Check(f1)">
<table width="100%" cellpadding="0" cellSpacing="10">
  <tr>
	<td class="H1">Sms por dia</td>
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
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font>SMS por dia:</td>
		  <td><input type="text" size="8" name="smscount" value="<?=$row->perday_sms;?>" /></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2" align="center"><input type="checkbox" value="1" name="smsflag" <?=$row->perday_sms_flag=="1"?"Checked":"";?>/>
			&nbsp;&nbsp;Sim, enviar SMS aos usuarios.</td>
		</tr>
		<tr valign="middle">
			<td>&nbsp;</td>
		</tr>
		<tr valign="middle">
			<td colspan="2" align="center">
				<input type="submit" name="submit" value="Enviar" class="bttn" />
			</td>
		</tr>
	 </table>
	</td>
  </tr>
</table>
</form>
</BODY>
</html>
