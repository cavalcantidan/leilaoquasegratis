<?
	include("connect.php");
	include("admin.config.inc.php");
	include("security.php");
	
	if($_POST["submit"]!=""){
		$bonuscad = $_REQUEST["bonuscad"];
		$bonusind = $_REQUEST["bonusind"];
		$sql = "select * from general_setting";
		$res = mysql_query($sql) or die(mysql_error());
		if(0<mysql_num_rows($res)){
			$qryupd = "update general_setting set bonusLanceCad='".$bonuscad."', bonus_indicacao ='".$bonusind."'";
			mysql_query($qryupd) or die(mysql_error());

			header("location: message.php?msg=81");
			exit;
		}else{
			$qryins = "insert into general_setting (bonusLanceCad,bonus_indicacao) values('".$bonuscad."','".$bonusind."')";
			mysql_query($qryins) or die(mysql_error());
			header("location: message.php?msg=81");
			exit;
		}
	}
    
	$bonuscad = 0; $bonusind = 0;
	$sql = "select * from general_setting";
	$res = mysql_query($sql) or die(mysql_error());
	if(0<mysql_num_rows($res)){
		$row = mysql_fetch_array($res);
		$bonuscad = $row["bonusLanceCad"];
		$bonusind = $row["bonus_indicacao"];
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
		if(document.f1.bonuscad.value=="")	{
			alert("Por favor digite a quantidade de lances bônus ao cadastrarem.");
			document.f1.bonuscad.focus();
			return false;
		}
		if(document.f1.bonuscad.value<0)	{
			alert("A quantidade de lances bônus não pode ser negativa!");
			document.f1.bonuscad.focus();
			return false;
		}
		if(document.f1.bonusind.value=="")	{
			alert("Por favor digite a quantidade de lances bônus ao indicarem.");
			document.f1.bonusind.focus();
			return false;
		}
        if(document.f1.bonusind.value<0)	{
			alert("A quantidade de lances bônus não pode ser negativa!");
			document.f1.bonusind.focus();
			return false;
		}
	}
</script>
</head>

<body bgcolor="#ffffff">   
<form name="f1" action="" method="post" onsubmit="return Check(f1)">
<table width="100%" cellpadding="0" cellspacing="10">
  <tr>
	<td class="H1">Administrar B&ocirc;nus por Cadastro</td>
  </tr>
  <tr>
	<td background="<?=DIR_WS_ICONS?>vdots.gif"><img height="1" src="<?=DIR_WS_ICONS?>spacer.gif" width="1" border="0" /></td>
  </tr>
  <tr>
	<td class="a" align="right" colspan="2">* Campos Obrigatorios</td>
  </tr>
  <tr>
 	<td>
 	  <table cellpadding="1" cellspacing="2">
	    <tr valign="middle">
          <td class="f-c" align="right" valign="middle" width="250"><font class="a">*</font> Lances B&ocirc;nus de Cadastro:</td>
		  <td><input type="text" size="10" name="bonuscad" value="<?=$bonuscad;?>" /></td>
		</tr>
		<tr valign="middle">
			<td>&nbsp;</td>
		</tr>
        <tr valign="middle">
          <td class="f-c" align="right" valign="middle" width="250"><font class="a">*</font> Lances B&ocirc;nus de Indicação:</td>
		  <td><input type="text" size="10" name="bonusind" value="<?=$bonusind;?>" /></td>
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
</body>
</html>
