<?php
	include("connect.php");
	include("config.inc.php");
	include("security.php");
	$type1 = 1;
	include("pagepermission.php");
	
	$acao = $_REQUEST["acao"];
	$idbanner = $_REQUEST["id"];
	switch ($acao) {
		case "excluir":
			$bann = mysql_query("select * from banners where Id=$idbanner");
			$imgbann = mysql_fetch_array($bann);				
			$qrydel = "delete from banners where Id=".$idbanner."";
			unlink("../banners/".$imgbann["banner"]."");
			mysql_query($qrydel) or die(mysql_error());
			echo "<script>alert('Banner excluido com sucesso!!');window.location.href='bannersetting.php';</script>";
			break;					
		case "ativa":
			$qryupd = "update banners set status = 1 where Id=".$idbanner."";
			mysql_query($qryupd) or die(mysql_error());
			echo "<script>alert('Banner alterado com sucesso!!');window.location.href='bannersetting.php';</script>";
			break;					
		case "inativa":			
			$qryupd = "update banners set status = 0 where Id=".$idbanner."";
			mysql_query($qryupd) or die(mysql_error());
			echo "<script>alert('Banner alterado com sucesso!!');window.location.href='bannersetting.php';</script>";
			break;
		case "ordem":
			$posi = $_REQUEST["posi"];
			$qryupd = "update banners set ordem = ".$posi." where Id=".$idbanner."";
			mysql_query($qryupd) or die(mysql_error());
			echo "<script>alert('Banner alterado com sucesso!!');window.location.href='bannersetting.php';</script>";
			break;
		
	}
	if($_POST["editinfo"]!="")
	{
		function uploadimage()
		{
			$time = time();
			$imagename = $time."_".$_FILES["banner"]["name"];
			$dest = "../banners/";
			copy($_FILES['banner']['tmp_name'],"../banners/".$imagename);
		}
		$time = time();
		$imagename = $time."_".$_FILES["banner"]["name"];
		uploadimage();	
		$linkbanner = $_REQUEST["linkbanner"];
		$qryupd = "insert into banners (banner, linkbanner, status) values('".$imagename."', '".$linkbanner."', 1);";
		mysql_query($qryupd) or die(mysql_error());
		header("location: message.php");
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
		if(document.f1.banner.value=="")
		{
			alert("Por Favor Informe o arquivo do banner!");
			document.f1.banner.focus();
			return false;
		}
	}
</script>
</head>

<BODY bgColor=#ffffff>   
<form name="f1" action="bannersetting.php" method="post" enctype="multipart/form-data"  onsubmit="return Check(f1)">
<table width="100%" cellpadding="0" cellSpacing="10">
  <tr>
	<td class="H1">Configurar Banner</td>
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
		  <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Banner  :</td>
		  <td><input type="file" size="50" name="banner" value="" maxlength="255" /></td>
		</tr>
		<tr valign="middle">
		  <td class=f-c align=right valign="middle">Link do banner :</td>
		  <td><label>
			<input type="text" name="linkbanner" id="linkbanner" size="50" />
			</label></td>
		  </tr>

		<tr valign="middle">
			<td colspan="2" align="center">Extens&otilde;es permitidas(.jpg, .gif, .png) max 10mb <br />
				<input type="submit" name="editinfo" value="Enviar" class="bttn" />
			</td>
		</tr>
	 </table>
	  <br />
	  <TABLE width="95%" border="1" cellSpacing="0" class="t-a" align="center">
		<TR class="th-a">
		  <th>Banner</th>
		  <th>Link</th>
		  <th>Status</th>
		  <th>Ordem</th>
		  <th width="20%">A&ccedil;&atilde;o</th>
		  </tr>
	  <?
	  $cons= "SELECT * FROM banners ORDER BY ordem";
	  $qbanner = mysql_query($cons);		
	  while($linha = mysql_fetch_array($qbanner)){
	  ?>
	  
		<tr>
		  <td align="center"><img src="../banners/<? echo $linha["banner"]; ?>" style="max-width:200px"/></td>
		  <td align="center"><? echo $linha["linkbanner"]; ?></td>
		  <td align="center"><? if($linha["status"] == 1){
			  echo "<font color='blue'>Ativo</font>";
			  }else{
				  echo "<font color='red'>Inativo</font>";
				  };?></td>
		  <td align="center">
			<input type="text" name="ordem<? echo $linha["Id"];?>" id="ordem<? echo $linha["Id"];?>" size="2" value="<?=$linha["ordem"]?>" />
			
			&nbsp;
			<input name="input"  type="button" class="bttn" value="OK" onclick="return mudaordem(<? echo $linha["Id"];?>,ordem<? echo $linha["Id"];?>.value);" />
			
			</td>
		  <td align="center">
			
			<? if($linha["status"] == 1){?>
			<input name="button2" type="button" class="bttn" value="Inativa" onclick="if(confirm('Deseja realmente inativar este banner?')){window.location.href='bannersetting.php?acao=inativa&id=<? echo $linha["Id"];?>'}" />
			<? }else{?>
			<input name="button2" type="button" class="bttn" value="Ativa" onclick="if(confirm('Deseja realmente ativar este banner?')){window.location.href='bannersetting.php?acao=ativa&id=<? echo $linha["Id"];?>'}" />
			<? }?>
			&nbsp;<input name="button" type="button" class="bttn" value="Excluir" onClick="if(confirm('Deseja realmente excluir este banner?')){window.location.href='bannersetting.php?acao=excluir&id=<? echo $linha["Id"]?>'}"></td>
			
		  </tr>
	   <? } ?> 
		 
	  </table>
	  <script>
			function mudaordem(id,posi){
				
				if(confirm('Deseja realmente mudar a ordem?')){				
					window.location.href="bannersetting.php?acao=ordem&id="+id+"&posi="+posi+"";
				}
			}
			</script>
			</td>
  </tr>
</table>
</form>
</BODY>
</html>
