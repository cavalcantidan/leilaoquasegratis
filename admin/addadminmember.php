<?
	include("connect.php");
	include("security.php");
	$type1 = 1;
	include("pagepermission.php");

		$username = $_POST["username"];
		$password =$_POST["password"];
		$firstname = $_POST["firstname"];
		$lastname = $_POST["lastname"];
		$email = $_POST["email"];
		$phoneno = $_POST["phoneno"];
		$category = $_POST["category"];
	
	
	if($_POST["add"]!="")
	{
		$qrysel = "select * from admin where username='$username'";
		$ressel = mysql_query($qrysel);
		$totalrows  = mysql_num_rows($ressel);
		if($totalrows>0)
		{
			header("location: message.php?msg=50");
			exit;
		}
		else
		{
			$qryins = "insert into admin (username,pass,firstname,lastname,email,phoneno,type) values('".$username."','".$password."','".$firstname."','".$lastname."','".$email."','".$phoneno."','".$category."')";
			mysql_query($qryins) or die(mysql_error());
			header("location: message.php?msg=51");
		}
	}
	
	if($_POST["edit"]!="")
	{
		$id = $_POST["editrecord"];
		$qrysel = "select * from admin where username='$username' and id<>$id";
		$ressel = mysql_query($qrysel);
		$totalrows  = mysql_num_rows($ressel);
		if($totalrows>0)
		{
			header("location: message.php?msg=50");
			exit;
		}
		else
		{
			$qryupd = "update admin set username='$username', pass='$password',firstname='$firstname',lastname='$lastname',email='$email',phoneno='$phoneno',type='$category' where id='$id'";
			mysql_query($qryupd) or die(mysql_error());
			header("location: message.php?msg=52");
		}
	}
	
	if($_GET["editid"]!="" || $_GET["delid"]!="")
	{
		if($_GET["editid"]!="") { $ids = $_GET["editid"]; }
		else{ $ids = $_GET["delid"]; }
		
		$select = "select * from admin where id='$ids'";
		$rs = mysql_query($select);
		$obj = mysql_fetch_object($rs);
	}
	
	if($_GET["deleterecord"]!="")
	{
		if($_GET["deleterecord"]=="1")
		{
			header("location:message.php?msg=54");	
			exit;
		}
		$qryd = "delete from admin where id='".$_GET["deleterecord"]."'";
		mysql_query($qryd) or die(mysql_error());
		header("location:message.php?msg=53");
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
<title>Untitled Document</title>
<link rel="stylesheet" href="main.css" type="text/css">
</head>
<script language="javascript">
	function Check(f1)
	{
		if(document.f1.username.value=="")
		{
			alert("Por favor informe o usuário!!!");
			document.f1.username.focus();
			return false;
		}
		if(document.f1.password.value=="")
		{
			alert("Por favor informe a senha!!!");
			document.f1.password.focus();
			return false;
		}
		if(f1.password.value.length<6)
		{
			alert("Senha muito curta!");
			f1.password.focus();
			f1.password.select();
			return false;
		}
		if(document.f1.firstname.value=="")
		{
			alert("Por favor informe o primeiro nome!!!");
			document.f1.firstname.focus();
			return false;
		}
		if(document.f1.lastname.value=="")
		{
			alert("Por favor informe o último nome!!!");
			document.f1.lastname.focus();
			return false;
		}
		if(document.f1.email.value=="")
		{
			alert("Por favor informe o e-mail!!!");
			document.f1.email.focus();
			return false;
		}
		if(document.f1.cnfemail.value=="")
		{
			alert("Por favor informe a confirmação do e-mail!!!");
			document.f1.cnfemail.focus();
			return false;
		}
		if(document.f1.email.value!=document.f1.cnfemail.value)
		{
			alert("E-mail diferente!");
			f1.cnfemail.focus();
			f1.cnfemail.select();
			return false;		
		}
		else
		{
			if(!validate_email(document.f1.email.value,"Por favor informe um email válido!"))
				{
					document.f1.email.select();
					return false;
				}
		}
		if(document.f1.phoneno.value=="")
		{
			alert("Por favor informe o telefone!!!");
			document.f1.phoneno.focus();
			return false;
		}
		if(document.f1.category.value=="none")
		{
			alert("Por favor selecione a categoria!!!");
			document.f1.category.focus();
			return false;
		}
	}
	function validate_email(field,alerttxt){
		with (field){
			var value;
			value = document.f1.email.value;
			apos=value.indexOf("@");
			dotpos=value.lastIndexOf(".");
			if (apos<1||dotpos-apos<2){
				alert(alerttxt);return false;
			}else{
				return true;
			}
		}
	}
	
	function ConfirmDelete(id)
	{
		if(confirm("Deseja apagar esse membro!!!"))
		{
			window.location.href='addadminmember.php?deleterecord=' + id;
		}
	}
</script>
<body>
<TABLE cellSpacing=10 cellPadding=0  border=0 width="650">
		<TR>
			<TD class="H1"><? if($_GET["editid"]!=""){ ?>Editar Usu&aacute;rio
		    <? }elseif($_GET["delid"]!=""){ ?>Excluir usu&aacute;rio <? }else{ ?>Adicionar usu&aacute;rio<? } ?></TD>
		</TR>
		<TR>
			<TD background="images/vdots.gif"><IMG height=1 
			  src="images/spacer.gif" width=1 border=0></TD>
		</TR>
	<? if($msg){ ?>
		<tr>
			<td bgcolor="#F1F0EF" style='color:#FF0000;' align="center"><?=$msg?></td>
		</tr>
	<? } ?>
<tr><td>
<!-- changeble part starts -->
<form action="" method="post" name="f1" onsubmit="return Check(this);">
<TABLE cellSpacing=2 cellPadding=1 width="650" border=0>
   <TBODY>
     <TR align="right"> 
       <TD colSpan=3 class="a">* Campos Obrigatorios</TD>
     </TR>
     <TR> 
        <TD class=th-d colSpan=3>Informa&ccedil;&otilde;es B&aacute;sicas</TD>
     </TR>
     <TR> 
       <TD width="182" align=right><IMG height=5 src="images/spacer.gif" width=1 border=0></TD>
       <TD width="458"> </TD>
     </TR>
   	 <tr>
	  <td class="normal" align="right"><font class="a">*</font>&nbsp;Login :&nbsp;</td>									
 	  <td><input type="text" name="username" size="20" maxlength="16" value="<?=$obj->username!=""?$obj->username:"";?>"></td>
	 </tr>
     <tr>
	  <td class="normal" align="right"><font class="a">*</font>&nbsp;Senha :&nbsp;</td>	 
	  <td><input type="password" name="password" size="20" maxlength="16" value="<?=$obj->pass!=""?$obj->pass:"";?>"></td>
	</tr>
     <tr>
	  <td class="normal" align="right"><font class="a">*</font>&nbsp;Primeiro Nome :&nbsp;</td>	  
 	  <td><input type="text" name="firstname" size="20" value="<?=$obj->firstname!=""?$obj->firstname:"";?>"></td>
	</tr>
     <tr>
	  <td class="normal" align="right"><font class="a">*</font>&nbsp;Ultimo Nome :&nbsp;</td>	  
 	  <td><input type="text" name="lastname" size="20" value="<?=$obj->lastname!=""?$obj->lastname:"";?>"></td>
	</tr>
     <tr>
	  <td class="normal" align="right"><font class="a">*</font>&nbsp;Email :&nbsp;</td>	  
 	  <td><input type="text" name="email" size="20" value="<?=$obj->email!=""?$obj->email:"";?>"></td>
	</tr>
     <tr>
	  <td class="normal" align="right"><font class="a">*</font>&nbsp;Confirmar Email :&nbsp;</td>	  
 	  <td><input type="text" name="cnfemail" size="20" value="<?=$obj->email!=""?$obj->email:"";?>"></td>
	</tr>
     <tr>
	  <td class="normal" align="right"><font class="a">*</font>&nbsp;Telefone :&nbsp;</td>	  
 	  <td><input type="text" name="phoneno" size="20" value="<?=$obj->phoneno!=""?$obj->phoneno:"";?>"></td>
	</tr>
     <tr>
	  <td class="normal" align="right"><font class="a">*</font>&nbsp;Categoria :&nbsp;</td>	   	  <td>
	  	<select name="category">
			<option value="none">selecione</option>
			<option <?=$obj->type=="1"?"selected":"";?> value="1">Supervisor</option>
			<option <?=$obj->type=="2"?"selected":"";?> value="2">Administrador Financeiro</option>
			<option <?=$obj->type=="3"?"selected":"";?> value="3">Administrador de Marketing</option>
		</select>
	  </td>
	</tr>
	<tr>
	 <td>&nbsp;</td><td>&nbsp;</td>
	</tr>
	<TR> 
     <TD align="right">&nbsp;</TD>
     <TD>
	 	<? if($_GET["editid"]!="") { ?>
	 	<INPUT type="submit" value="Editar" name="edit" class="bttn">
		<input type="hidden" value="<?=$_GET["editid"];?>" name="editrecord" />
		<? } elseif($_GET["delid"]!="") { ?>
	 	<INPUT type="button" value="Excluir" name="delete" class="bttn" onclick="ConfirmDelete('<?=$_GET["delid"];?>')">
		<? }else { ?>
	 	<INPUT type="submit" value="Adicionar" name="add" class="bttn">
		<? } ?>
	 </TD>
    </TR>
</TBODY>
</TABLE>
</form>
</td>
</tr>
</TABLE>
</body>
</html>
