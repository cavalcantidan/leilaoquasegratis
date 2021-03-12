<?
	include("connect.php");
	include("config.inc.php");
	include("security.php");
	$type1 = 1;
	include("pagepermission.php");
	


	if($_POST["editinfo"]!=""){
		$businessid = $_POST["businessid"];
		$url_verificacao = $_POST["url_verificacao"];
		$token = $_POST["token"];
		$email = $_POST["email"];
		
		$ressel = mysql_query("select * from pagseguro_info order by id desc limit 1");
		if (mysql_num_rows($ressel)>0){
			$qryupd = "update pagseguro_info set url_site='".$businessid."',url_verificacao='".$url_verificacao."',token='".$token."',email='".$email."' where id='1'";
		}else{
			$qryupd = "insert into pagseguro_info (url_site,url_verificacao,token,email) values ('".$businessid."','".$url_verificacao."','".$token."','".$email."')";
		}
		mysql_query($qryupd) or die(mysql_error());
		header("location: message.php?msg=54");
	}
	
	$qrysel = "select * from pagseguro_info order by id desc limit 1";
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
			alert("Por favor digite a página de pagamento do PagSeguro!");
			document.f1.businessid.focus();
			return false;
		}
		if(document.f1.businessid.value=="")
		{
			alert("Por favor digite a página de verificação do PagSeguro!");
			document.f1.businessid.focus();
			return false;
		}
		if(document.f1.token.value=="")
		{
			alert("Por favor digite o token gerado no PagSeguro!");
			document.f1.token.focus();
			return false;
		}
		if(document.f1.email.value=="")
		{
			alert("Por favor digite o e-mail cadatrado no PagSeguro!");
			document.f1.email.focus();
			return false;
		}
	}
</script>
</head>

<BODY bgColor=#ffffff>   
<form name="f1" action="pagsegurosetting.php" method="post" onsubmit="return Check(f1)">
<table width="100%" cellpadding="0" cellSpacing="10">
  <tr>
	<td class="H1">Configurar PagSeguro</td>
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
          <td class=f-c align=right valign="middle" width="250"><font class=a>*</font> P&aacute;gina de pagamento do PagSeguro  :</td>
		  <td><input type="text" size="100" name="businessid" value="<?php echo $row->url_site;?>" maxlength="255" /></td>
		</tr>
	    <tr valign="middle">
          <td class=f-c align=right valign="middle" width="250"><font class=a>*</font> P&aacute;gina de verifica&ccedil;&atilde;o do PagSeguro  :</td>
		  <td><input type="text" size="100" name="url_verificacao" value="<?php echo $row->url_verificacao;?>" maxlength="255" /></td>
		</tr>
	    <tr valign="middle">
          <td class=f-c align=right valign="middle" width="250"><font class=a>*</font> Token gerando no PagSeguro :</td>
		  <td><input type="text" size="100" name="token" value="<?php echo $row->token;?>" maxlength="255" /></td>
		</tr>
	    <tr valign="middle">
          <td class=f-c align=right valign="middle" width="250"><font class=a>*</font> E-mail cadatrado no PagSeguro :</td>
		  <td><input type="text" size="100" name="email" value="<?php echo $row->email;?>" maxlength="255" /></td>
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