<?
	include("connect.php");
	include("config.inc.php");
	include("security.php");
	include("sendmail.php");
	
	$qrylang = "select * from language";
	$reslang = mysql_query($qrylang);
	$totallang = mysql_num_rows($reslang);

	if($_POST["deletenewsletter"]!="")
	{
		$qrydelete = "delete from newslatter_email where id='".$_POST["delete_id"]."'";
		mysql_query($qrydelete) or die(mysql_error());
		header("location: message.php?msg=42");
		exit;
	}
	if($_POST["sendandsave"]!="")
	{
		$subject = $_POST["subject1"];
		$content1 = $_POST["description1"];
		$from = $adminemailadd;

		$qryins = "insert into newslatter_email (date,subject,content) values('".date("Y-m-d",time())."','".addslashes($subject)."','".addslashes($content1)."')";		
		mysql_query($qryins) or die(mysql_error());
		$insertid = mysql_insert_id();

		if($totallang>0)
		{
			for($i=1;$i<=$totallang;$i++)
			{
				$objlang = mysql_fetch_object($reslang);
				$qryupd = "update newslatter_email set ".$objlang->language_prefix."_subject='".addslashes($_POST["subject$i"])."',".$objlang->language_prefix."_content='".addslashes($_POST["description$i"])."' where id='".$insertid."'";
				mysql_query($qryupd) or die(mysql_error());
			}
		}

		$content='';
		$content.= "<font style='font-size: 10px;font-family: Arial, Helvetica, sans-serif;color: #333333;'>Ol&aacute; usu&aacute;rio,"."</font><br>"."<br>"."<p align='center' style='font-size: 14px;font-family: Arial, Helvetica, sans-serif;font-weight:bold;'></p>"."<br>".	
		
		"<table border='0' cellpadding='3' cellspacing='0' width='100%' align='center' class='style13'>";
	
		$content.="<tr style='font-size: 10px;font-family: Arial, Helvetica, sans-serif;color: #333333;'>".$content1."</tr>
		</table>";

		$qrysel = "select * from registration where newslatter='1' and account_status='1' and member_status='0' and user_delete_flag!='d'";
		$ressel = mysql_query($qrysel);
		$total = mysql_num_rows($ressel);
		
		while($obj = mysql_fetch_object($ressel))
		{
			if($obj->newsletter_email!="")
			{
				$to = $obj->newsletter_email;
			}
			else
			{
				$to = $obj->email;
			}
			
//			echo $subject."<br>";
//			echo $to."<br>";
//			echo $from."<br>";
//			echo $content."<br>";
			SendHTMLMail($to,$subject,$content,$from);
		}	
		header("location: message.php?msg=71");
		exit;
	}

	if($_POST["send"]!="")
	{
		$subject = $_POST["subject1"];
		$content1 = $_POST["description1"];
		$from = $adminemailadd;

		$content='';
		$content.= "<font style='font-size: 10px;font-family: Arial, Helvetica, sans-serif;color: #333333;'>Aos Membros,"."</font><br>"."<br>".
		"<p align='center' style='font-size: 14px;font-family: Arial, Helvetica, sans-serif;font-weight:bold;'></p>"."<br>".	
		
		"<table border='0' cellpadding='3' cellspacing='0' width='100%' align='center' class='style13'>".
	
		"<tr style='font-size: 10px;font-family: Arial, Helvetica, sans-serif;color: #333333;'>".$content1."</tr>
		</table>";

		$qrysel = "select * from registration where newslatter='1' and account_status='1' and member_status='0' and user_delete_flag!='d'";
		$ressel = mysql_query($qrysel);
		$total = mysql_num_rows($ressel);
		
		while($obj = mysql_fetch_object($ressel))
		{
			if($obj->newsletter_email!="")
			{
				$to = $obj->newsletter_email;
			}
			else
			{
				$to = $obj->email;
			}
			
			// echo 'assunto > '.$subject."<br>";
			// echo 'para > '.$to."<br>";
			// echo 'de > '. htmlspecialchars( $from)."<br>";
			// echo 'conteudo > '.$content."<br>";
			SendHTMLMail($to,$subject,$content,$from);
		}	
		header("location: message.php?msg=43");
		exit;
	}

	if($_POST["save"]!="")
	{
		$subject = $_POST["subject1"];
		$content1 = $_POST["description1"];
		$from = $adminemailadd;

		$qryins = "insert into newslatter_email (date,subject,content) values('".date("Y-m-d",time())."','".addslashes($subject)."','".addslashes($content1)."')";		
		mysql_query($qryins) or die(mysql_error());
		$insertid = mysql_insert_id();
		if($totallang>0)
		{
			for($i=1;$i<=$totallang;$i++)
			{
				$objlang = mysql_fetch_object($reslang);
				$qryupd = "update newslatter_email set ".$objlang->language_prefix."_subject='".addslashes($_POST["subject$i"])."',".$objlang->language_prefix."_content='".addslashes($_POST["description$i"])."' where id='".$insertid."'";
				mysql_query($qryupd) or die(mysql_error());
			}
		}

		$content='';
		$content.= "<font style='font-size: 10px;font-family: Arial, Helvetica, sans-serif;color: #333333;'>Dear Members,"."</font><br>"."<br>"."<p align='center' style='font-size: 14px;font-family: Arial, Helvetica, sans-serif;font-weight:bold;'></p>"."<br>".	
		
		"<table border='0' cellpadding='3' cellspacing='0' width='100%' align='center' class='style13'>";
	
		$content.="<tr style='font-size: 10px;font-family: Arial, Helvetica, sans-serif;color: #333333;'>".$content1."</tr>
		</table>";

		$qrysel = "select * from registration where newslatter='1' and account_status='1' and member_status='0' and user_delete_flag!='d'";
		$ressel = mysql_query($qrysel);
		$total = mysql_num_rows($ressel);
		
		header("location: message.php?msg=72");
		exit;
	}
	if($_GET["newsletter_delete"]!="" || $_GET["newsletter_resend"])
	{
		if($_GET["newsletter_delete"]!="")
		{
		$id = $_GET["newsletter_delete"];
		}
		else
		{
		$id = $_GET["newsletter_resend"];		
		}
		$qrysel1 = "select * from newslatter_email where id='".$id."'";
		$ressel1 = mysql_query($qrysel1);
		$obj1 = mysql_fetch_object($ressel1);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
<title>Untitled Document</title>
<script language="javascript" type="text/javascript" src="editor/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="editor.js"></script>
<script language="JavaScript" type="text/javascript" class="g-s">				
</script> 
<script language="javascript">
	function Check()
	{
		/*if(document.newslatter.subject.value=="")
		{
			alert("Por favor informe o assunto do e-mail!");
			document.newslatter.subject.focus();
			return false;
		}
		if(document.newslatter.description.value=="")
		{
			alert("Por favor informe o conteúdo do e-mail!");
			return false;
		}*/
		countervalue = Number(document.newslatter.countervalue.value) - 1;
		if(countervalue>0)
		{
			for(i=1;i<=countervalue;i++)
			{
				obj = document.getElementById('subject' + i);
				if(obj.value=="")
				{
				alert("Por favor informe o assunto do e-mail!");
				obj.focus();
				return false;
				}
			}
		}
	}
</script>
<link href="main.css" rel="stylesheet" />
</head>

<body>
<TABLE cellSpacing=10 cellPadding=0  border=0 width="100%">
	<TR>
		<TD class=H1><? if($_GET["newsletter_delete"]!=""){?>Excluir
		  
<? } else{ ?>
Enviar News Letter
<? } ?></TD>
	</TR>
	<TR>
		<TD background="images/vdots.gif"><IMG height=1 src="images/spacer.gif" width=1 border=0></TD>
	</TR>
	<TR height="5">
		<td>&nbsp;</td>
	</TR>
	<tr>
		<td>
			 <form name="newslatter" action="" method="post" onsubmit="return Check();">
			 <table border="0">
<?php /*?>				<tr>
					<td align="right" class="f-c">Subject:</td>
					<td><input type="text" name="subject" size="50" value="<?=$obj1->subject!=""?stripslashes($obj1->subject):"";?>" /></td>
				</tr>
				<tr> 
				  <td width="87" align="right" nowrap class="f-c">Content:<br /></td>
				  <td>
					<textarea name="description" rows="25" cols="80"><?=$obj1->content!=""?stripslashes($obj1->content):"";?></textarea>
				  </td>
				</tr>
<?php */?>				<?
					if($totallang>0)
					{
						for($i=1;$i<=$totallang;$i++)
						{
							$objlang = mysql_fetch_object($reslang);
				?>
				<tr>
					<td align="right" nowrap="nowrap" class="f-c">Assunto (
					<?=$objlang->language_name;?>):</td>
					<td><input type="text" id="subject<?=$i;?>" name="subject<?=$i;?>" size="50" value="<?=$obj1->subject!=""?stripslashes($obj1->subject):"";?>" /></td>
				</tr>
				<tr> 
				  <td width="87" align="right" nowrap class="f-c">Conteudo: (<?=$objlang->language_name;?>)<br /></td>
				  <td>
					<textarea name="description<?=$i;?>" id="description<?=$i;?>" rows="25" cols="80"><?=$obj1->content!=""?stripslashes($obj1->content):"";?></textarea>
				  </td>
				</tr>
				<?
						}
					}
				?>
				<input type="hidden" name="countervalue" value="<?=$i;?>" />
				<tr height="5">
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
					<?
						if($_GET["newsletter_delete"]!="")
						{
					?>
					<input type="submit" name="deletenewsletter" value="Excluir" class="bttn" onclick="return confirm('Are you sure to delete this newsletter')" />
					<input type="hidden" name="delete_id" value="<?=$_GET["newsletter_delete"];?>" />
					<?
						}
						else
						{
					?>
					<input type="submit" name="send" value="Enviar" class="bttn" />&nbsp;&nbsp;
					<input type="submit" name="sendandsave" value="Salvar e Enviar" class="bttn" />&nbsp;&nbsp;
					<input type="submit" name="save" value="Salvar" class="bttn" />
					<?
						}
					?>
					</td>
				</tr>
			  </table>
		</form>
		</td>
	</tr>
</TABLE>
</body>
</html>
