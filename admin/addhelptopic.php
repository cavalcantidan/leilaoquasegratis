<?
	include("connect.php");
	include("admin.config.inc.php");
	include("security.php");
	
	$qrylang = "select * from language";
	$reslang = mysql_query($qrylang);
	$totallang = mysql_num_rows($reslang);

	$title = addslashes($_POST["title1"]);
	
	if($_POST["addhelptopic"]!="")
	{
		$qrysel = "select * from helptopic where topic_title='$title'";
		$ressel = mysql_query($qrysel);
		$totalrow = mysql_num_rows($ressel);
		if($totalrow>0)
		{
			header("location: message.php?msg=21");
			exit;		
		}
		else
		{
//			$qryins = "insert into helptopic (topic_title) values ('$title')";
			$qryins = "insert into helptopic (topic_title) values ('".addslashes($_POST["title1"])."')";
			mysql_query($qryins) or die(mysql_error());
			$insertid = mysql_insert_id();

			if($totallang>0)
			{
				for($i=1;$i<=$totallang;$i++)
				{
					$objlang = mysql_fetch_object($reslang);
					$qryupd = "update helptopic set ".$objlang->language_prefix."_topic_title='".addslashes($_POST["title$i"])."' where topic_id='".$insertid."'";
					mysql_query($qryupd) or die(mysql_error());
				}
			}

			header("location: message.php?msg=22");
			exit;
		}
	}
	
	if($_POST["edithelptopic"]!="")
	{
		$id = $_POST["editid"];
//		$qrysel = "select * from helptopic where topic_title='$title' and topic_id<>$id";
		$qrysel = "select * from helptopic where topic_title='$title' and topic_id<>$id";
		$ressel = mysql_query($qrysel);
		$totalrow = mysql_affected_rows();
		if($totalrow>0)
		{
			header("location: message.php?msg=21");
			exit;		
		}
		else
		{
//			$qryupd = "update helptopic set topic_title='$title'";
			$qryupd = "update helptopic set topic_title='".addslashes($_POST["title1"])."'";
			if($totallang>0)
			{
				for($i=1;$i<=$totallang;$i++)
				{
					$objlang = mysql_fetch_object($reslang);
					$qryupd .= ",".$objlang->language_prefix."_topic_title='".$_POST["title$i"]."'";
				}
			}
			$qryupd .= " where topic_id='$id'";
			mysql_query($qryupd) or die(mysql_error());
			header("location: message.php?msg=23");
			exit;
		}
	}
	
	if($_GET["delid"]!="")
	{
		$qryd = "delete from helptopic where topic_id='".$_GET["delid"]."'";
		mysql_query($qryd) or die(mysql_error());
		header("location: message.php?msg=24");
		exit;
	}
	
	if($_REQUEST["help_edit"]!="" || $_REQUEST["help_delete"]!="")
	{
		if($_REQUEST["help_edit"]!="")
		{
			$id = $_REQUEST["help_edit"];
		}
		else
		{
			$id = $_REQUEST["help_delete"];
		}
		$qrysel = "select * from helptopic where topic_id=$id";
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
		countervalue = Number(document.f1.countervalue.value) - 1;
		if(document.f1.title.value=="")
		{
			alert("Por favor informe o título do tópico de ajuda");
			document.f1.title.focus();
			return false;
		}
	if(countervalue>0)
	{
		for(i=1;i<=countervalue;i++)
		{
			obj = document.getElementById('title' + i);
			if(obj.value=="")
			{
			alert("Por favor informe o título do tópico de ajuda");
			obj.focus();
			return false;
			}
		}
	}
  }
</script>
</head>

<BODY bgColor=#ffffff>   
<form name="f1" action="addhelptopic.php" method="post" onsubmit="return Check(f1)">
<table width="100%" cellpadding="0" cellSpacing="10">
  <tr>
	<td class="H1"><? if($_GET['help_edit']!="") { ?>
	   Editar T&oacute;pico de Ajuda
	   <? } else { if($_GET['help_delete']!=""){ ?> 
      Excluir T&oacute;pico de Ajuda<? }else { ?> Adicionar T&oacute;pico de Ajuda<? } } ?></td>
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
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Topic Title :</td>
		  <td><input type="text" size="50" name="title" value="<?=$row["topic_title"];?>" /></td>
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
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> T&iacute;tulo (<?=$objlang->language_name;?>) :</td>
		  <td><input type="text" size="50" id="title<?=$i;?>" name="title<?=$i;?>" value="<?=stripslashes($row[$prefix."_".topic_title]);?>" /></td>
		</tr>
		<?
				}
			}
		?>
		<input type="hidden" value="<?=$i;?>" name="countervalue" />
		<tr valign="middle">
			<td>&nbsp;</td>
		</tr>
		<tr valign="middle">
			<td colspan="2" align="center">
			<?
				if($_REQUEST["help_edit"])
				{
			?>
				<input type="submit" name="edithelptopic" value="Editar" class="bttn" />
				<input type="hidden" name="editid" value="<?=$id?>" />
			<?
				}
				elseif($_REQUEST["help_delete"])
				{
			?>
			<input type="button" name="deletehelptopic" value="Excluir" class="bttn" onclick="javascript: window.location.href='addhelptopic.php?delid=<?=$id?>';" />
			<?
				}
				else
				{
			?>	
				<input type="submit" name="addhelptopic" value="Adicionar" class="bttn" />
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
