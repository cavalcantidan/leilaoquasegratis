<?
	include("connect.php");
	include("admin.config.inc.php");
	include("security.php");
	
	$auctiontype = $_POST["auctiontype"];
	$auctime = $_POST["aucplustime"];
	$aucprice = $_POST["aucplusprice"];
		
	if($_POST["addauctiontime"]!="")
	{
		$qrysel = "select * from auction_management where auction_type='$auctiontype'";
		$ressel = mysql_query($qrysel);
		$totalrow = mysql_affected_rows();
		if($totalrow>0)
		{
			header("location: message.php?msg=34");
			exit;		
		}
		else
		{
			$qryins = "insert into auction_management (auction_type,auc_time_diff,auc_price_diff) values ('$auctiontype',$auctime,$aucprice)";
			mysql_query($qryins) or die(mysql_error());
			header("location: message.php?msg=35");
			exit;
		}
		
	}
	
	if($_POST["editauctiontime"]!="")
	{
		$id = $_POST["editid"];
		$qrysel = "select * from auction_management where auction_type='auctiontype' and id<>$id";
		$ressel = mysql_query($qrysel);
		$totalrow = mysql_affected_rows();
		if($totalrow>0)
		{
			header("location: message.php?msg=34");
			exit;		
		}
		else
		{
			$qryupd = "update auction_management set auction_type='$auctiontype',auc_time_diff=$auctime,auc_price_diff=$aucprice where id='$id'";
			mysql_query($qryupd) or die(mysql_error());
			header("location: message.php?msg=36");
			exit;
		}
	}
	
	if($_GET["delid"]!="")
	{
		$qryd = "delete from auction_management where id='".$_GET["delid"]."'";
		mysql_query($qryd) or die(mysql_error());
		header("location: message.php?msg=37");
		exit;
	}
	
	if($_REQUEST["auctime_edit"]!="" || $_REQUEST["auctime_delete"]!="")
	{
		if($_REQUEST["auctime_edit"]!="")
		{
			$id = $_REQUEST["auctime_edit"];
		}
		else
		{
			$id = $_REQUEST["auctime_delete"];
		}
		$qrysel = "select * from auction_management where id=$id";
		$res = mysql_query($qrysel);
		$totalrow = mysql_affected_rows();
		$row = mysql_fetch_object($res);
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
		if(document.f1.auctiontype.value=="none")
		{
			alert("Por favor selecione o tipo do leilão!!!");
			document.f1.auctiontype.focus();
			return false;
		}
		if(document.f1.aucplustime.value=="")
		{
			alert("Por favor informe o tempo do leilão!!!");
			document.f1.aucplustime.focus();
			return false;
		}
		if(document.f1.aucplusprice.value=="")
		{
			alert("Por favor informe o preço do leilão!!!");
			document.f1.aucplusprice.focus();
			return false;
		}
	}
</script>
</head>

<BODY bgColor=#ffffff>   
<form name="f1" action="addauctiontime.php" method="post" onsubmit="return Check(f1)">
<table width="100%" cellpadding="0" cellSpacing="10">
  <tr>
	<td class="H1"><? if($_GET['auctime_edit']!="") { ?>
	   Editar Valor e Hor&aacute;rio de Leil&atilde;o

	   <? } else { if($_GET['auctime_delete']!=""){ ?>
	   Confima&ccedil;&atilde;o de exclus&atilde;o Valor e Hor&aacute;rio de Leil&atilde;o
<? }else { ?> Adicionar Valor e Hor&aacute;rio de Leil&atilde;o<? } } ?></td>
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
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Tipo de Leil&atilde;o:</td>
		  <td>
		  	<select name="auctiontype">
				<option value="none">---</option>
				<option value="fpa">Pre&ccedil;o Fixo</option>
				<option value="pa">1 Centavo</option>
				<option value="nba">Preg&atilde;o</option>
				<option value="off">100% off</option>
				<option value="na">Noturno</option>
				<option value="oa">Aberto</option>
				<option value="20sa">20-Segundos</option>
				<option value="15sa">15-Segundos</option>
				<option value="10sa">10-Segundos</option>
		  	</select>
		  </td>
		</tr>
	    <tr valign="middle">
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Tempo Leil&atilde;o:</td>
		  <td><input type="text" size="10" name="aucplustime" value="<?=$row->auc_time_diff;?>" /></td>
		</tr>
	    <tr valign="middle">
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Valor do Leil&atilde;o:</td>
		  <td><input type="text" size="10" name="aucplusprice" value="<?=$row->auc_price_diff;?>" />&nbsp;<font class="a">&pound;</font></td>
		</tr>
		<tr valign="middle">
			<td>&nbsp;</td>
		</tr>
		<tr valign="middle">
			<td colspan="2" align="center">
			<?
				if($_REQUEST["auctime_edit"])
				{
			?>
				<input type="submit" name="editauctiontime" value="Editar" class="bttn" />
				<input type="hidden" name="editid" value="<?=$id?>" />
			<?
				}
				elseif($_REQUEST["auctime_delete"])
				{
			?>
			<input type="button" name="deleteauctiontime" value="Excluir" class="bttn" onclick="javascript: window.location.href='addauctiontime.php?delid=<?=$id?>';" />
			<?
				}
				else
				{
			?>	
				<input type="submit" name="addauctiontime" value="Aicionar" class="bttn" />
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
