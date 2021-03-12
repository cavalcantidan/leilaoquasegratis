<?
	include("connect.php");
	include("admin.config.inc.php");
	include("security.php");

	$qrylang = "select * from language";
	$reslang = mysql_query($qrylang);
	$totallang = mysql_num_rows($reslang);
	
	$topic = $_POST["topic"];
	$quetitle = addslashes($_POST["quetitle"]);
	$content = addslashes($_POST["description"]);
	
	if($_POST["addfaq"]!="")
	{
//		$qrys = "select * from faq where que_title='$quetitle'";
		$qrys = "select * from faq where que_title='".addslashes($_POST["quetitle1"])."'";
		$ress = mysql_query($qrys);
		$totals = mysql_affected_rows();
		if($totals>0)
		{
			header("location: message.php?msg=27");
			exit;
		}
		else
		{
//		$qryins = "insert into faq (parent_topic, que_title, que_content) values('$topic','$quetitle','$content')";	
		$qryins = "insert into faq (parent_topic, que_title, que_content) values('$topic','".addslashes($_POST["quetitle1"])."','".addslashes($_POST["description1"])."')";	
		mysql_query($qryins) or die(mysql_error());
		$insertid = mysql_insert_id();
		if($totallang>0)
		{
			for($i=1;$i<=$totallang;$i++)
			{	
				$objlang = mysql_fetch_object($reslang);
				$qryupd = "update faq set ".$objlang->language_prefix."_que_title='".$_POST["quetitle$i"]."',".$objlang->language_prefix."_que_content='".$_POST["description$i"]."' where id='".$insertid."'";
				mysql_query($qryupd) or die(mysql_error());
			}	
		}	
		header("location: message.php?msg=25");
		exit;
		}
	}
	
	if($_POST["editfaq"]!="")
	{
		$id = $_POST["editid"];
//		$qrys = "select * from faq where que_title='$quetitle' and id<>'$id'";
		$qrys = "select * from faq where que_title='".$_POST["quetitle1"]."' and id<>'$id'";
		$ress = mysql_query($qrys);
		$totals = mysql_affected_rows();
		if($totals>0)
		{
			header("location: message.php?msg=27");
			exit;
		}
		else
		{
//		$qryupd = "Update faq set parent_topic='$topic', que_title='$quetitle', que_content='$content'";
		$qryupd = "Update faq set parent_topic='$topic', que_title='".addslashes($_POST["quetitle1"])."', que_content='".addslashes($_POST["description1"])."'";
		if($totallang>0)
		{
			for($i=1;$i<=$totallang;$i++)
			{	
				$objlang = mysql_fetch_object($reslang);
				$qryupd .= ",".$objlang->language_prefix."_que_title='".addslashes($_POST["quetitle$i"])."',".$objlang->language_prefix."_que_content='".addslashes($_POST["description$i"])."'";
			}
		}
		$qryupd .= " where id='$id'";
		mysql_query($qryupd) or die(mysql_error());
		header("location: message.php?msg=26");
		exit;
		}
	}
	
	if($_GET["delid"]!="")
	{
		$id = $_GET["delid"];
		$qryd = "delete from faq where id='$id'";
		mysql_query($qryd) or die(mysql_error());
		header("location: message.php?msg=28");
	}
	
	if($_GET["faq_edit"]!="" || $_GET["faq_delete"]!="")
	{	
		if($_GET["faq_edit"]!=""){ $id = $_GET["faq_edit"]; }
		else{$id = $_GET["faq_delete"];}
		
		$qrysel = "select * from faq where id='$id'";
		$ressel = mysql_query($qrysel);
		$totalrow = mysql_affected_rows();
		$rows = mysql_fetch_array($ressel);
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
	if(document.f1.topic.value=="none")
	{
		alert("Por favor selecione o tópico de ajuda!");
		document.f1.topic.focus();
		return false;
	}

/*	if(document.f1.quetitle.value=="")
	{
		alert("Por favor informe o título da questão!");
		document.f1.quetitle.focus();
		return false;
	}

	if(document.f1.description.value=="")
	{
		alert("Por favor informe o conteúdo da questão!");
		//document.f1.content.focus();
		return false;
	}*/

	countervalue = Number(document.f1.countervalue.value) - 1;
	if(countervalue>0)
	{
		for(i=1;i<=countervalue;i++)
		{
			obj = document.getElementById('quetitle' + i)
			obj1 = document.getElementById('description' + i)
			if(obj.value=="")
			{
			alert("Por favor informe o título da questão!");
			obj.focus();
			return false;
			}
/*			if(obj1.value=="")
			{
			alert("Por favor informe o Question Content");
//			obj1.focus();
			return false;
			}*/
		}
	}
}
</script>
</head>

<body bgColor=#ffffff>   
<form name="f1" action="addfaq.php" method="post" onsubmit="return Check(f1)">
<table width="100%" cellpadding="0" cellSpacing="10">
  <tr>
	<td class="H1"><? if($_GET['faq_edit']!="") { ?> Editar FAQ<? } else { if($_GET['faq_delete']!=""){ ?> Excluir FAQ <? }else { ?> Adicionar FAQ <? } } ?></td>
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
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> T&oacute;pico de Ajuda:</td>
		  <td>
		  	<select name="topic" style="width: 300px;">
				<option value="none">selecione</option>
				<?
					$qry = "select * from helptopic";
					$res = mysql_query($qry);
					$totalrow = mysql_affected_rows();
					while($tp = mysql_fetch_array($res))
					{
				?>
				<option <?=$rows["parent_topic"]==$tp["topic_id"]?"selected":"";?> value="<?=$tp["topic_id"];?>"><?=stripslashes($tp["topic_title"]);?></option>	
				<?
					}
				?>
			</select></td>
		</tr>
<?php /*?>	    <tr valign="middle">
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Question Content :</td>
		  <td><input type="text" size="50" name="quetitle" value="<?=$rows["que_title"]!=""?stripslashes($rows["que_title"]):""; ?>" /></td>
		</tr>
		<tr>
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Answer :</td>
		  <td><textarea name="description" cols="80" rows="25"><?=$rows["que_content"]!=""?stripslashes($rows["que_content"]):"";?></textarea></td>
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
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Pergunta (<?=$objlang->language_name; ?>):</td>
		  <td><input type="text" size="50" name="quetitle<?=$i;?>" value="<?=stripslashes($rows[$prefix."_que_title"]); ?>" id="quetitle<?=$i;?>" /></td>
		</tr>
		<tr>
          <td class=f-c align=right valign="middle" width="191"><font class=a>*</font> Resposta (<?=$objlang->language_name;?>):</td>
		  <td><textarea name="description<?=$i;?>" cols="80" rows="25" id="description<?=$i;?>"><?=stripslashes($rows[$prefix."_que_content"]);?></textarea></td>
		</tr>  	
		<?
				}
			}
		?>
		<input type="hidden" name="countervalue" value="<?=$i;?>" />
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr valign="middle">
			<td colspan="2" align="center">
			<?
				if($_REQUEST["faq_edit"])
				{
			?>
				<input type="submit" name="editfaq" value="Editar" class="bttn" />
				<input type="hidden" name="editid" value="<?=$id?>" />
			<?
				}
				elseif($_REQUEST["faq_delete"])
				{
			?>
			<input type="button" name="deletefaq" value="Excluir" class="bttn" onclick="javascript: window.location.href='addfaq.php?delid=<?=$id?>';" />
			<?
				}
				else
				{
			?>	
				<input type="submit" name="addfaq" value="Adicionar" class="bttn" />
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
</body>
</html>
