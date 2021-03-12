<?

	include("connect.php");
	include("config.inc.php");
	include("security.php");
	$type1 = 1;
	include("pagepermission.php");	
	
	$iddepo = $_REQUEST["id"];	
		
	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
<title></title>
<LINK href="main.css" type=text/css rel=stylesheet>
</head>

<BODY bgColor=#ffffff>   
<form name="f1" action="manage_depo.php" method="post" enctype="multipart/form-data"  onsubmit="return Check(f1)">
<table width="100%" cellpadding="0" cellSpacing="10">
  <tr>
	<td class="H1">Depoimentos</td>
  </tr>
  <tr>
	<td background="<?=DIR_WS_ICONS?>vdots.gif"><IMG height=1 src="<?=DIR_WS_ICONS?>spacer.gif" width=1 border=0></td>
  </tr>

  <tr>
 	<td>
 		<?
	  $cons= mysql_query("SELECT * FROM depoimentos WHERE Id = $iddepo");
	  $qdepo = mysql_fetch_array($cons);
	  $consusu = mysql_query("SELECT * FROM registration WHERE Id = ".$qdepo["Id"]."");
	  $qusu =mysql_fetch_array($consusu);
       ?>
<table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td align="right" nowrap="nowrap"><strong>Data :</strong></td>
    <td><?=date("d-m-y",$qdepo["date"]);?></td>
  </tr>
  <tr>
    <td width="7%" align="right" nowrap="nowrap"><strong>Usu&aacute;rio :</strong></td>
    <td width="93%"><?=$qusu["username"];?></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><strong>Titulo :</strong></td>
    <td><?=$qdepo["titulo"];?></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><strong>Descri&ccedil;&atilde;o :</strong></td>
    <td><?=$qdepo["conteudo"];?></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table><br />
<a href="manage_depo.php">Voltar </a></td>
  </tr>
</table>
</form>
</BODY>
</html>
