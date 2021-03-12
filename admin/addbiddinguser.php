<?
	include("connect.php");
	include("security.php");
	$type1 = 1;
	include("pagepermission.php");

	$firstname = $_POST["firstname"];
	$lastname = $_POST["lastname"];
	$gender = "Male";
	$birthdate = rand(1,29)."-".rand(1,12)."-".rand(1980,2000);
	$city = $_POST["city"];
	$country = $_POST["country"];
	$username = $_POST["username"];
	$password = $_POST["password"];
	if($password=="")
	{
		$password = "password";
	}
	$email = $_POST["email"];
	$phone = $_POST["phoneno"];


	if($_POST["add"]!="")
	{
		$qrysel = "select * from registration where username='".$_REQUEST['username']."'";
		$rsqrysel = mysql_query($qrysel);
		$totalrows = mysql_affected_rows();
		if($totalrows>0)
		{
			header("location: message.php?msg=76");
			exit;
		}
		else
		{
			$qryins = "Insert into registration (username,firstname,lastname,sex,birth_date,city,country,phone,password,terms_condition,privacy,account_status,register_date,admin_user_flag,email) values('".$username."','".$firstname."','".$lastname."','".$gender."','".$birthdate."','".$city."','".$country."','".$phone."','".$password."','1','1','1',NOW(),'1','".$email."')";
			mysql_query($qryins) or die(mysql_error());
			header("location: message.php?msg=75");
		}
	}
	
	if($_POST["edit"]!="")
	{
		$id = $_POST["editrecord"];
		$qrysel1 = "select * from registration where (username='".$_REQUEST['username']."') and id!='".$id."'";
		$rsqrysel1 = mysql_query($qrysel1);
		$totalavailable = mysql_num_rows($rsqrysel1);
		if($totalavailable>0)
		{
			header("location: message.php?msg=76");
			exit;
		}
		else
		{
			$qryupd = "update registration set username='".$username."',firstname='".$firstname."',lastname='".$lastname."',sex='".$gender."',birth_date='".$birthdate."',city='".$city."',country='".$country."',phone='".$phone."',password='".$password."',email='".$email."' where id='".$id."'";
			mysql_query($qryupd) or die(mysql_error());
			header("location: message.php?msg=77");
		}
	}
	
	if($_GET["deleterecord"]!="")
	{
		$delid = $_GET["deleterecord"];
		$qrydel = "update registration set user_delete_flag='d' where id='".$delid."'";
		mysql_query($qrydel) or die(mysql_error());
		header("location: message.php?msg=78");
	}

	if($_GET["editid"]!="" || $_GET["delid"]!="")
	{
		if($_GET["editid"]!="") { $id=$_GET["editid"]; }
		else{ $id = $_GET["delid"]; }

		$qryreg = "select * from registration where id='".$id."'";
		$resreg = mysql_query($qryreg);
		$obj = mysql_fetch_object($resreg);
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

/*		if(document.f1.country.value=="none")
		{
			alert("Por favor selecione o país!!!");
			document.f1.country.focus();
			return false;
		}
*/
		if(document.f1.username.value=="")
		{
			alert("Por favor informe o usuário!!!");
			document.f1.username.focus();
			return false;
		}
		if(f1.username.value.length<6)
		{
			alert("Nome de usuário muito curto!");
			f1.username.focus();
			f1.username.select();
			return false;
		}
/*		if(document.f1.password.value=="")
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
		if(document.f1.cnfpassword.value=="")
		{
			alert("Por favor informe a confirmação da senha!!!");
			document.f1.cnfpassword.focus();
			return false;
		}
		if(document.f1.password.value!=document.f1.cnfpassword.value)
		{
			alert("Senha diferente!!!");
			document.f1.password.focus();
			return false;
		}*/
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
			if(!validate_email(document.f1.email.value,"Por favor informe um e-mail válido"))
				{
					document.f1.email.select();
					return false;
				}
		}
/*		if(document.f1.phoneno.value=="")
		{
			alert("Por favor informe o telefone!!!");
			document.f1.phoneno.focus();
			return false;
		}
*/	}
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
			window.location.href='addbiddinguser.php?deleterecord=' + id;
		}
	}
</script>
<body>
<TABLE cellSpacing=10 cellPadding=0  border=0 width="650">
		<TR>
			<TD class="H1"><? if($_GET["editid"]!=""){ ?>
			  Editar usu&aacute;rio rob&ocirc; 
			<? }elseif($_GET["delid"]!=""){ ?>
			Excluir usu&aacute;rio rob&ocirc;
			<? }else{ ?>
			Adiconar usu&aacute;rio rob&ocirc;		    <? } ?></TD>
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
		<TD class=th-d colSpan=3>Informa&ccedil;&otilde;es b&aacute;sicas</TD>
	 </TR>
	 <TR> 
	   <TD width="182" align=right><IMG height=5 src="images/spacer.gif" width=1 border=0></TD>
	   <TD width="458"> </TD>
	 </TR>
	 <tr>
	  <td class="normal" align="right"><font class="a">*</font>&nbsp;Primeiro nome:&nbsp;</td>									
	  <td><input type="text" name="firstname" size="20" value="<?=$obj->firstname!=""?$obj->firstname:"";?>"></td>
	 </tr>
	 <tr>
	  <td class="normal" align="right"><font class="a">*</font>&nbsp;&Uacute;ltimo nome:&nbsp;</td>									
	  <td><input type="text" name="lastname" size="20" value="<?=$obj->lastname!=""?$obj->lastname:"";?>"></td>
	 </tr>
<?php /*?>   	 <tr>
	  <td class="normal" align="right"><font class="a">*</font>&nbsp;Gender :&nbsp;</td>									
	  <td>
		<select name="gender">
			<option value="Male">Male</option>
			<option <?=$obj->sex=="Female"?"selected":"";?> value="Female">Female</option>
		</select>
	  </td>
	 </tr>
	 <tr>
	  <td class="normal" align="right"><font class="a">*</font>&nbsp;Birth Date :&nbsp;</td>									
	  <td>
			<select name="bdate">
				<option value="none">DD</option>
				<?
					for($i=1;$i<=31;$i++)
					{
				?>
				  <option <?=substr($obj->birth_date,0,2)==$i?"selected":"";?> value="<?=$i<=9?"0".$i:$i;?>"><?=$i<=9?"0".$i:$i;?></option>
				<?
					}
				?>
			</select>
			<select name="bmonth">
				<option value="none">MM</option>
				<?
					for($i=1;$i<=12;$i++)
					{
				?>
				  <option <?=substr($obj->birth_date,3,5)==$i?"selected":"";?> value="<?=$i<=9?"0".$i:$i;?>"><?=$i<=9?"0".$i:$i;?></option>
				<?
					}
				?>
			</select>
			<select name="byear">
				<option value="none">YYYY</option>
				<?
					for($i=1960;$i<=2020;$i++)
					{
				?>
				  <option <?=substr($obj->birth_date,6)==$i?"selected":"";?>  value="<?=$i<=9?"0".$i:$i;?>"><?=$i<=9?"0".$i:$i;?></option>
				<?
					}
				?>
			</select>
	  </td>
	 </tr>
	 <tr>
	  <td class="normal" align="right"><font class="a">*</font>&nbsp;City :&nbsp;</td>									
	  <td><input type="text" name="city" size="20" value="<?=$obj->city!=""?$obj->city:"";?>"></td>
	 </tr>
<?php */?>   	 <tr>
	  <td class="normal" align="right">&nbsp;Pa&iacute;s :&nbsp;</td>									
	  <td>
		<select name="country" style="width: 200px;">
			<option value="none">--</option>
			<?
				$qrycou = "select * from countries order by printable_name";
				$rescou = mysql_query($qrycou);
				while($objcou = mysql_fetch_object($rescou))
				{
			?>	
				<option <?=$objcou->countryId==$obj->country?"selected":"";?> value="<?=$objcou->countryId;?>"><?=$objcou->printable_name;?></option>
			<?
				}
			?>
		</select>
		</td>
	 </tr>
	 <tr>
	  <td class="normal" align="right"><font class="a">*</font>&nbsp;Nome de usu&aacute;rio:&nbsp;</td>									
	  <td><input type="text" name="username" size="20" maxlength="16" value="<?=$obj->username!=""?$obj->username:"";?>"></td>
	 </tr>
	 <tr>
	  <td class="normal" align="right">&nbsp;Senha :&nbsp;</td>	 
	  <td><input type="password" name="password" size="20" value="<?=$obj->password!=""?$obj->password:"";?>"></td>
	</tr>
<?php /*?>     <tr>
	  <td class="normal" align="right">&nbsp;Confirm Password :&nbsp;</td>	 
	  <td><input type="password" name="cnfpassword" size="20" value="<?=$obj->password!=""?$obj->password:"";?>"></td>
	</tr>
<?php */?>     <tr>
	  <td class="normal" align="right"><font class="a">*</font>&nbsp;Email :&nbsp;</td>	  
	  <td><input type="text" name="email" size="20" value="<?=$obj->email!=""?$obj->email:"";?>"></td>
	</tr>
	 <tr>
	  <td class="normal" align="right"><font class="a">*</font>&nbsp;Confirmar e-mail :&nbsp;</td>	  
	  <td><input type="text" name="cnfemail" size="20" value="<?=$obj->email!=""?$obj->email:"";?>"></td>
	</tr>
<?php /*?>     <tr>
	  <td class="normal" align="right"><font class="a">*</font>&nbsp;Phone No :&nbsp;</td>	  
	  <td><input type="text" name="phoneno" size="20" value="<?=$obj->phone!=""?$obj->phone:"";?>"></td>
	</tr>
<?php */?>	<tr>
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
		<? } else { ?>
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
