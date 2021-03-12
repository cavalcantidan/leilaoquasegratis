<?
	include("connect.php");
	include("config.inc.php");
	include("security.php");

	$qrylang = "select * from language";
	$reslang = mysql_query($qrylang);
	$totallang = mysql_num_rows($reslang);
	
	$newstitle = addslashes($_POST["newstitle"]);
	$newscontent = addslashes($_POST["newscontent"]);
	$longcontent = addslashes($_POST["description"]);
	$newsdate = $_POST["nyear"]."-".$_POST["nmonth"]."-".$_POST["ndate"];
	
	if($_POST["addnews"]!="")
	{
		$qrysel = "select * from news where news_date='$newsdate'";
		$ressel = mysql_query($qrysel);
		$totalrow = mysql_affected_rows();
		if($totalrow>0)
		{
			header("location: message.php?msg=31");
			exit;		
		}
		else
		{
//			$qryins = "insert into news (news_title,news_short_content,news_long_content,news_date) values('$newstitle','$newscontent','$longcontent','$newsdate')";
			$qryins = "insert into news (news_title,news_short_content,news_long_content,news_date) values('".addslashes($_POST["newstitle1"])."','".addslashes($_POST["newscontent1"])."','".addslashes($_POST["description1"])."','$newsdate')";
			mysql_query($qryins) or die(mysql_error());
			$insertid = mysql_insert_id();
			if($totallang>0)
			{
				for($i=1;$i<=$totallang;$i++)
				{	
					$objlang = mysql_fetch_object($reslang);
					$lngprefix = $objlang->language_prefix;
					$qryupd = "update news set ".$lngprefix."_news_title='".addslashes($_POST["newstitle$i"])."',".$lngprefix."_news_short_content='".addslashes($_POST["newscontent$i"])."',".$lngprefix."_news_long_content='".addslashes($_POST["description$i"])."'";
					mysql_query($qryupd) or die(mysql_error());
				}
			}
			header("location: message.php?msg=30");
			exit;
		}
		
	}
	
	if($_POST["editnews"]!="")
	{
		$id = $_POST["editid"];
		$qrysel = "select * from news where news_date='$newsdate' and id<>$id";
		$ressel = mysql_query($qrysel);
		$totalrow = mysql_affected_rows();
		if($totalrow>0)
		{
			header("location: message.php?msg=31");
			exit;		
		}
		else
		{
//			$qryupd = "update news set news_title='$newstitle', news_date='$newsdate', news_short_content='$newscontent', news_long_content='$longcontent'";
			$qryupd = "update news set news_title='".addslashes($_POST["newstitle1"])."', news_date='$newsdate', news_short_content='".addslashes($_POST["newscontent1"])."', news_long_content='".addslashes($_POST["description1"])."'";
			if($totallang>0)
			{
				for($i=1;$i<=$totallang;$i++)
				{
					$objlang = mysql_fetch_object($reslang);
					$lngprefix = $objlang->language_prefix;
					$qryupd .= ",".$lngprefix."_news_title='".addslashes($_POST["newstitle$i"])."',".$lngprefix."_news_short_content='".addslashes($_POST["newscontent$i"])."',".$lngprefix."_news_long_content='".addslashes($_POST["description$i"])."'";
				}
			}
			$qryupd .= " where id='$id'";
			mysql_query($qryupd) or die(mysql_error());
			header("location: message.php?msg=32");
			exit;
		}
	}
	
	if($_GET["delid"]!="")
	{
		$qryd = "delete from news where id='".$_GET["delid"]."'";
		mysql_query($qryd) or die(mysql_error());
		header("location: message.php?msg=33");
		exit;
	}
	
	if($_REQUEST["news_edit"]!="" || $_REQUEST["news_delete"]!="")
	{
		if($_REQUEST["news_edit"]!="")
		{
			$id = $_REQUEST["news_edit"];
		}
		else
		{
			$id = $_REQUEST["news_delete"];
		}
		$qrysel = "select * from news where id=$id";
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
<script language="javascript" type="text/javascript" src="editor/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="editor.js"></script>
<script language="JavaScript" type="text/javascript" class="g-s">				
</script> 
<script language="javascript">
	function Check(f1)
	{
/*		if(document.f1.newstitle.value=="")
		{
			alert("Por favor informe o título do tópico de ajuda!!!");
			document.f1.newstitle.focus();
			return false;
		}*/
		if(document.f1.ndate.value=='none')
		{
			alert("Por favor selecione a data!!!");
			document.f1.ndate.focus();
			return false;
		}
		if(document.f1.nmonth.value=='none')
		{
			alert("Por favor selecione a data!!!");
			document.f1.nmonth.focus();
			return false;
		}
		if(document.f1.nyear.value=='none')
		{
			alert("Por favor selecione a data!!!");
			document.f1.nyear.focus();
			return false;
		}
/*		if(document.f1.newscontent.value=="")
		{
			alert("Por favor informe o conteúdo novo!!!");
			document.f1.newscontent.focus();
			return false;
		}*/
	countervalue = Number(document.f1.countervalue.value) - 1;
	if(countervalue>0)
	{
		for(i=1;i<=countervalue;i++)
		{
			obj = document.getElementById('newstitle' + i);
			obj1 = document.getElementById('newscontent' + i);
			if(obj.value=="")
			{
			alert("Por favor informe o novo título!");
			obj.focus();
			return false;
			}
			if(obj1.value=="")
			{
			alert("Por favor informe o novo conteúdo!");
			obj1.focus();
			return false;
			}
		}
	}
 }
</script>
</head>

<BODY bgColor=#ffffff>   
<form name="f1" action="addnews.php" method="post" onsubmit="return Check(f1)">
<table width="100%" cellpadding="0" cellSpacing="10">
  <tr>
	<td class="H1"><? if($_GET['news_edit']!="") { ?> Editar Novidades<? } else { if($_GET['news_delete']!=""){ ?>
	  Excluir 
	  novidade<? }else { ?> Adicionar Novidade<? } } ?></td>
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
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Data :</td>
		  <td>
		  	<select name="ndate">
				<option value="none">--</option>
				<?
					for($i=1;$i<=31;$i++)
					{
						if($i<10)
						{
							$i = "0".$i;
						}
				?>
					<option <?=substr($row["news_date"],8,2)==$i?"selected":"";?> value="<?=$i;?>"><?=$i;?></option>
				<?
					}				
				?>
			</select>
		  	<select name="nmonth">
				<option value="none">--</option>
				<?
					for($i=1;$i<=12;$i++)
					{
						if($i<10)
						{
							$i = "0".$i;
						}
				?>
					<option <?=substr($row["news_date"],5,2)==$i?"selected":"";?> value="<?=$i;?>"><?=$i;?></option>
				<?
					}				
				?>
			</select>
		  	<select name="nyear">
				<option value="none">----</option>
				<?
					for($i=2000;$i<=2050;$i++)
					{
				?>
					<option <?=substr($row["news_date"],0,4)==$i?"selected":"";?> value="<?=$i;?>"><?=$i;?></option>
				<?
					}				
				?>
			</select>
		  </td>
		</tr>
<?php /*?>	    <tr valign="middle">
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> News Title :</td>
		  <td><input type="text" size="50" name="newstitle" value="<?=stripslashes($row["news_title"]);?>" maxlength="100" /></td>
		</tr>
	    <tr valign="middle">
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Short Description :</td>
		  <td>
		  	<textarea rows="5" cols="50" name="newscontent"><?=stripslashes($row["news_short_content"]);?></textarea>
		  </td>
		</tr>
	    <tr valign="middle">
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Long Description :</td>
		  <td>
		  	<textarea rows="20" cols="90" name="description"><?=stripslashes($row["news_long_content"]);?></textarea>
		  </td>
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
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Titulo (<?=$objlang->language_name;?>):</td>
		  <td><input type="text" size="50" name="newstitle<?=$i;?>" value="<?=stripslashes($row[$prefix."_news_title"]);?>" id="newstitle<?=$i;?>" maxlength="100" /></td>
		</tr>
	    <tr valign="middle">
          <!--<td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Descri&ccedil;&atilde;o Curta(<?=$objlang->language_name;?>):</td>
		  <td>
		  	<textarea rows="5" cols="50" id="newscontent<?=$i;?>" name="newscontent<?=$i;?>"><?=stripslashes($row[$prefix."_news_short_content"]);?></textarea>
		  </td>
		</tr>
	    <tr valign="middle">
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Descri&ccedil;&atilde;o Completa(<?=$objlang->language_name;?>):</td>
		  <td>
		  	<textarea rows="20" cols="90" id="description<?=$i;?>" name="description<?=$i;?>"><?=stripslashes($row[$prefix."_news_long_content"]);?></textarea>
		  </td>-->
		</tr>
		<?
				}
			}
		?>
		<input type="hidden" name="countervalue" value="<?=$i;?>" />
		<tr valign="middle">
			<td>&nbsp;</td>
		</tr>
		<tr valign="middle">
			<td colspan="2" align="center">
			<?
				if($_REQUEST["news_edit"])
				{
			?>
				<input type="submit" name="editnews" value="Editar" class="bttn" />
				<input type="hidden" name="editid" value="<?=$id?>" />
			<?
				}
				elseif($_REQUEST["news_delete"])
				{
			?>
			<input type="button" name="deletenews" value="Excluir" class="bttn" onclick="javascript: window.location.href='addnews.php?delid=<?=$id?>';" />
			<?
				}
				else
				{
			?>	
				<input type="submit" name="addnews" value="Adicionar" class="bttn" />
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
