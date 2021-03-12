<?
include_once("admin.config.inc.php");
include_once("config.inc.php");
include("connect.php") ;
include("security.php");

	$sel="select * from admin where id='".$_SESSION["logid"]."'";
	$ressel=mysql_query($sel);
	$rowsel=mysql_fetch_object($ressel);
	$name=stripslashes($rowsel->username);
	$title=stripslashes($rowsel->pass);
	


if(isset($_POST['submit'])){
	$title = addslashes($_POST["title"]);
	$sql="update admin set pass='$title' where id='".$_SESSION["logid"]."'";			
    $ressql=mysql_query($sql) or die("Erro ao atualizar a senha!");
    header('location:message.php?msg=55');
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<HTML><HEAD>
<LINK 
href="main.css" type=text/css rel=stylesheet>
<SCRIPT language=javascript src="body.js"></SCRIPT>
<script language="javascript">
	function Check()
	{
		if(document.addlink.title.value=="")
		{
			alert("Please enter new password!!!");
			document.addlink.title.focus();
			return false;
		}
	}
</script>
<META content="MSHTML 6.00.2600.0" name=GENERATOR></HEAD>
<BODY bgColor=#ffffff leftMargin=0 topMargin=0 marginheight="0" marginwidth="0">
<TABLE cellSpacing=10 cellPadding=0  border=0>
<TR>
	<TD class=H1>Alterar Senha</TD>
</TR>
<TR>
    <TD background="images/vdots.gif"><IMG height=1 
      src="images/spacer.gif" width=1 border=0></TD>
</TR>
<!--content-->
<tr>
<td>
 <form name=addlink action="#" method=post enctype="multipart/form-data" onSubmit="return Check();">

	<?php
          if($Error)
          {
            if($Error==1)
            {
              $msg = "Form Not Completely Filled!!!";
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
      
        <TABLE cellSpacing=2 cellPadding=1 width="90%" border=0>
          <TBODY>
            <TR> 
              <TD colSpan=2></TD>
              <TD class=a align=right colSpan=2 >* Campos Obrigatorios</TD>
            </TR>
            <TR> 
              <TD class=th-d colSpan=4>Informa&ccedil;&otilde;es Basicas</TD>
            </TR>
            <TR> 
              <TD width="169" align=right></TD>
              <TD width="275"> </TD>
            </TR>
            <TR valign="middle"> 
              <TD class=f-c align=right valign="middle"><font class=a>*</font>Senha 
                :</TD>
              <TD> <input type="password" name="title" size="32" class="solidinput" value="<? echo $title; ?>"> 
                &nbsp; </td>
            </TR>
            <TR> 
              <TD align=right>&nbsp;</TD>
              <TD> <INPUT type="submit" value=" Editar " name="submit" class="bttn"> 
              </TD>
              <TD width="192" align=left>&nbsp; </TD>
            </TR>
            <TR> 
              <TD colSpan=4> <P>&nbsp;</P>
                <P>&nbsp;</P></TD>
            </TR>
          </TBODY>
        </TABLE>
        
</FORM>
</td></tr></table><!--/content--></TD></TR></TBODY></TABLE></BODY></HTML>