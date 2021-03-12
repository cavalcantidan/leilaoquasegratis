<?php
include("admin.config.inc.php");
include("connect.php");
include("security.php");
$id=$_GET['id'];

	
$qrylang = "select * from language";
$reslang = mysql_query($qrylang);
$totallang = mysql_num_rows($reslang);

if($_POST['submit'])
{
	$qrylang = "select * from language";
	$reslang = mysql_query($qrylang);
	$totallang = mysql_num_rows($reslang);

	$id = $_POST["id"];
	$content=addslashes($_POST['description']);
//	$Query = "update static_pages set content='".$content."'";
	$Query = "update static_pages set content='".addslashes($_POST['description1'])."'";
	if($totallang>0)
	{
		for($i=1;$i<=$totallang;$i++)
		{
			$objlang = mysql_fetch_object($reslang);
			$Query .= ",".$objlang->language_prefix."_content='".addslashes($_POST["description$i"])."'";
		}
	}
	$Query .= " where id='$id'";

	mysql_query($Query) or die(mysql_error());
	header("Location: message.php?msg=29&id=".$id);
	exit;
}
else
{
	$cres=mysql_query("select * from static_pages where id='$id'");
	$crow=mysql_fetch_array($cres);
	$content=stripslashes($crow["content"]);

	$qrylang = "select * from language";
	$reslang = mysql_query($qrylang);
	$totallang = mysql_num_rows($reslang);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
<title></title>
<script language="javascript" type="text/javascript" src="editor/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="editor.js"></script>
<link href="main.css" rel="stylesheet" type="text/css">
</head>
<body>

<TABLE cellSpacing=10 cellPadding=0  border=0 width="70%">
<TR>
	<TD class=H1><? 
        if($id==1){ echo "Termos & Condi&ccedil;&otilde;es;"; } 
        elseif($id==2){ echo "Sobre N&oacute;s";} 
        elseif($id==3){ echo "Fale Conosco";}
        elseif($id==4){ echo "Privacidade";}
        elseif($id==5){ echo "Trabalhe Conosco";} 
        elseif($id==6){ echo "SMS Bid"; } 
        elseif($id==7){ echo "Como Funciona?"; } 
        elseif($id==9){ echo "Promo&ccedil;&otilde;es"; }
        else { echo "P&aacute;ginas"; } 
    ?></TD>
</TR>
<TR>
    <TD background="images/vdots.gif"><IMG height=1 src="images/spacer.gif" width=1 border=0></TD>
</TR>
<!--content-->
<tr>
<td>
 <form name=addprod action="#" method=post enctype="multipart/form-data">

	<?php
	      if($Error)
          {
            if($Error==1)
            {
              $msg = "Preencha os campos!!!";
            }
      
        ?>
		<table width="80%" bordercolor="#000000" bgcolor="#ffffff" cellspacing="0" cellpadding="0" align="center" border="1">
          <tr>
          <td>
		  <table border="0" cellpadding="0" cellspacing="0" align="center">
		  <tr>
          <td>
            <div align="center"><font face="Verdana" size="2" color="#990000">
              <?php echo $msg; ?>
              </font></div>
          </td>
        </tr>
		
			  </table>
          </td>
        </tr>
      </table>
		 <?php

          }

        ?>
      <TABLE cellSpacing=2 cellPadding=2 width="100%" border=0>
        <TBODY>
        </TBODY></TABLE>
        <TABLE cellSpacing=2 cellPadding=1 width="100%" border=0>
          <TBODY>
            <TR> 
              <TD colSpan=2></TD>
            </TR>
            <TR> 
              <TD class=th-d noWrap colSpan=2>Informa&ccedil;&otilde;es B&aacute;sicas</TD>
            </TR>
<?php /*?>            <tr> 
              <td width="87" align="right" nowrap class="f-c">Content<br /></td>
              <td>
			  	<textarea name="description" rows="20" cols="110"><?=$content?></textarea>
			  </td>
            </tr>
<?php */?>            <?
				if($totallang>0)
				{
					for($i=1;$i<=$totallang;$i++)
					{
						$objlang = mysql_fetch_object($reslang);
						$prefix  = strtolower($objlang->language_prefix);
			?>
			<tr>
				<td>&nbsp;</td>
			</tr>
            <tr> 
              <td width="87" align="right" nowrap class="f-c">Conteudo (
              <?=$objlang->language_name;?>)<br /></td>
              <td>
			  	<textarea name="description<?=$i;?>" rows="20" cols="110"><?=stripslashes($crow[$prefix."_content"]);?></textarea>
			  </td>
            </tr>
			<?
					}
				}
			?>
			<tr>
				<td>&nbsp;</td>
			</tr>
            <TR> 
              <TD align=right>&nbsp;</TD>
              <TD> <input type="submit" name="submit" class="bttn" value="   Editar   "> 
                &nbsp; </TD>
            </TR>
            <TR> 
              <TD colSpan=2> <P>&nbsp;</P>
                <P>&nbsp;</P></TD>
            </TR>
          </TBODY>
        </TABLE>
        <input type="hidden" value="<?=$id?>" name="id">
</FORM>
</td></tr></table>
</body>
</html>
