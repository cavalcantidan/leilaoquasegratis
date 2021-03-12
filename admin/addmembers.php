<?
include("connect.php");
include("security.php");

if($_REQUEST['add']){
	$qrysel = "select * from registration where username='".$_REQUEST['username']."' or email='".$_REQUEST['email']."'";
	$rsqrysel = mysql_query($qrysel);
	$totalrows = mysql_affected_rows();
	if($totalrows>0){
		header("location: message.php?msg=4");
		exit;
	}
	
	$username=$_REQUEST['username'];
	$fname=$_REQUEST['fname'];
	$lname=$_REQUEST['lname'];
	$gender=$_REQUEST["gender"];
	$bdate=$_REQUEST["cmbdate"]."-".$_REQUEST["cmbmonth"]."-".$_REQUEST["cmbyear"];
	$address1=$_REQUEST['address1'];
	$address2=$_REQUEST['address2'];
	$city=$_REQUEST['city'];
	$state=$_REQUEST['state'];
	$zipcode=$_REQUEST['zipcode'];
	$phone=$_REQUEST['phone'];
	$email=$_REQUEST['email'];
	$pass=$_REQUEST['pass_word'];
	$mobileno = $_REQUEST["mobileno"];
	
	$countryinfo = explode("|",$_REQUEST['country']);
	$country=$countryinfo[0];
	$countrycode=$countryinfo[1];
	$fullmobile = "+".$countrycode.$mobileno;
	$verifycode = md5($username);
	
	
	$qryins = "Insert into registration (username,firstname,lastname,sex,birth_date,addressline1,addressline2,city,state,country,postcode,phone,mobile_no,full_mobileno,email,password,register_date,verify_code)
                                 values('$username','$fname','$lname','$gender','$bdate','$address1','$address2','$city','$state','$country','$zipcode','$phone','$mobileno','$fullmobile','$email','$pass',NOW(),'$verifycode')";
	$resultu=mysql_query($qryins);
	header("location:message.php?msg=2");
	exit;
			
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
<title>Untitled Document</title>
<link rel="stylesheet" href="main.css" type="text/css">
<script language="javascript" src="Validation.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
function validation(f1){

	if(f1.username.value.length<=0)
	{
		alert("Por favor informe o seu nome de usuário!");
		f1.username.focus();
		return false;
	}

	if(f1.username.value.length<6)
	{
		alert("Nome de usuário muito curto!");
		f1.username.focus();
		return false;
	}

	if(f1.fname.value.length<=0)
	{
		alert("Por favor informe o seu primeiro nome!");
		f1.fname.focus();
		return false;
	}
	
	if(f1.lname.value.length<=0)
	{
		alert("Por favor informe o seu último nome!");
		f1.lname.focus();	
		return false;
	}
	
	if(f1.cmbdate.value=="none")
	{
		alert("Por favor selecione sua data de nascimento!");
		f1.cmbdate.focus();	
		return false;	
	}

	if(f1.cmbmonth.value=="none")
	{
		alert("Por favor selecione sua data de nascimento!");
		f1.cmbmonth.focus();	
		return false;	
	}
	
	if(f1.cmbyear.value=="none")
	{
		alert("Por favor selecione sua data de nascimento!");
		f1.cmbyear.focus();	
		return false;	
	}

	/*if(f1.address1.value.length<=0)
	{
		alert("Por favor informe o seu endereço!");
		f1.address1.focus();	
		return false;
	}
	
	if(f1.city.value.length<=0)
	{
		alert("Por favor informe o sua cidade!");
		f1.city.focus();	
		return false;
	}
	
	if(f1.state.value.length<=0)
	{
		alert("Por favor informe o seu estado!");
		f1.state.focus();	
		return false;
	}
	
	if(f1.country.value.length<=0)
	{
		alert("Por favor informe o seu país!");
		f1.country.focus();	
		return false;
	}
	
	if(f1.zipcode.value.length<=0)
	{
		alert("Por favor informe o seu CEP!");
		f1.zipcode.focus();	
		return false;
	}
	if(f1.phone.value.length<=0)
	{
		alert("Por favor informe o seu CPF!");
		f1.phone.focus();	
		return false;
	}*/
	
	if(f1.country.value=="none")
	{
		alert("Por favor selecione país!");
		f1.country.focus();	
		return false;
	}
	if(f1.email.value.length<=0)
	{
		alert("Por favor informe o seu E-mail!");
		f1.email.focus();	
		return false;
	}
	
	if(f1.cnfemail.value.length<=0)
	{
		alert("Por favor informe a confirmação do seu E-mail!");
		f1.cnfemail.focus();	
		return false;
	}
	
	if(f1.email.value!=f1.cnfemail.value)
	{
		alert("Email Mismatch!");
		f1.cnfemail.focus();
		f1.cnfemail.select();
		return false;		
	}
	else
	{
		if(!validate_email(f1.email.value,"Por favor informe um e-mail válido!"))
			{
				f1.email.select();
				return false;
			}
	}
	
	if(f1.pass_word.value=="")
	{
		alert("Por favor informe a senha!");
		f1.pass_word.focus();
		return false;
	}
	
	if(f1.pass_word.value.length<6)
	{
		alert("Senha muito curta!");
		f1.pass_word.focus();
		f1.pass_word.select();
		return false;
	}
	
	if(f1.cpassword.value=="")
	{
		alert("Por favor confirme a senha!");
		f1.cpassword.focus();		
		return false;
	}
	
	if(f1.cpassword.value!=f1.pass_word.value)
	{
		alert("Senha diferente!");
		f1.pass_word.focus();
		f1.cpassword.select();
		return false;
	}	
}
function validate_email(field,alerttxt){
	with (field){
		var value;
		value = document.newmember.email.value;
		apos=value.indexOf("@");
		dotpos=value.lastIndexOf(".");
		if (apos<1||dotpos-apos<2){
			alert(alerttxt);return false;
		}else{
			return true;
		}
	}
}
</script>
</head>

<body>
<TABLE cellSpacing=10 cellPadding=0  border=0 width="650">
		<TR>
			<TD class="H1">Adicionar Membro</TD>
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
<form action="addmembers.php" method="post" name="newmember" onsubmit="return validation(this);">
<TABLE cellSpacing=2 cellPadding=1 width="650" border=0>
   <TBODY>
     <TR align="right"> 
       <TD colSpan=3 class="a">* Required Information</TD>
     </TR>
     <TR> 
        <TD class=th-d colSpan=3>Basic Information</TD>
     </TR>
     <TR> 
       <TD width="182" align=right><IMG height=5 src="images/spacer.gif" width=1 border=0></TD>
       <TD width="458"> </TD>
     </TR>
   	 <tr>
	  <td class="normal" align="right"><font class="a">*</font>&nbsp;User Name :&nbsp;</td>									
 	  <td><input type="text" name="username"></td>
	 </tr>
     <tr>
	  <td class="normal" align="right"><font class="a">*</font>&nbsp;First Name :&nbsp;</td>	  
	  <td><input type="text" name="fname"></td>
	</tr>
	<tr>
	  <td class="normal" align="right"><font class="a">*</font>&nbsp;Last Name :&nbsp;</td>
	  <td><input type="text" name="lname"></td>
	</tr>
	<tr>
	  <td class="normal" align="right">&nbsp;Gender :&nbsp;</td>
	  <td><select name="gender" style="background:#F7F7F7">
	  		<option value="Male">Male</option>
			<option value="Female">Female</option>
		</select>
	   </td>
    </tr>
	<tr>
	  <td class="normal" align="right"><font class="a">*</font>&nbsp;Birth Date :&nbsp;</td>
	  <td>
		  <select name="cmbdate" style="background:#F7F7F7">
  	  		<option value="none" selected="selected">--</option>
	  		<?
				for($i=1;$i<=31;$i++)
				{
					if($i<=9)
					{
						$i="0".$i;
					}
			?>
				<option value="<?=$i;?>"><?=$i;?></option>
			<?	
				}
			?>
		  </select>
		  <select name="cmbmonth" style="background:#F7F7F7">
	  		<option value="none" selected="selected">--</option>
	  		<?
				for($i=1;$i<=12;$i++)
				{
					if($i<=9)
					{
						$i="0".$i;
					}
			?>
				<option value="<?=$i;?>"><?=$i;?></option>
			<?	
				}
			?>
		  </select>
		  <select name="cmbyear" style="background:#F7F7F7">
	  		<option value="none" selected="selected">----</option>
	  		<?
				for($i=1950;$i<=2020;$i++)
				{
			?>
				<option value="<?=$i;?>"><?=$i;?></option>
			<?	
				}
			?>
		  </select>
	   </td>
    </tr>
    <tr>
	  <td class="normal" align="right">&nbsp;Adicionarress Line 1 :&nbsp;</td>
	  <td><input type="text" name="address1" /></td>
    </tr>
    <tr>
	  <td class="normal" align="right">&nbsp;Adicionarress Line 2 :&nbsp;</td>
	  <td><input type="text" name="address2" /></td>
    </tr>
	<tr>
	 <td class="normal" align="right">&nbsp;City :&nbsp;</td>
	 <td><input type="text" name="city"></td>
	</tr>
    <tr>
	 <td class="normal" align="right">&nbsp;State :&nbsp;</td>
	 <td><input type="text" name="state"></td>
	</tr>
    <tr>
	 <td class="normal" align="right"><font class="a">*</font>&nbsp;Country :&nbsp;</td>
	 <td><select name="country" style="width:100pt;">
     	<option value="none">Por favor selecione one</option>
	 	 <? 
		 	$qrycou = "select * from countries order by printable_name";
			$rescou = mysql_query($qrycou);
			while($cou=mysql_fetch_array($rescou))
			{
		 ?>
		 	<option value="<?=$cou["countryId"];?>|<?=$cou["countrycode"];?>"><?=$cou["printable_name"];?></option>
		 <?
		 }
		 ?>
		 </select>
	 </td>
	</tr>
	<tr>
	 <td class="normal" align="right">&nbsp;Zipcode :&nbsp;</td>
	 <td><input type="text" name="zipcode"></td>
	</tr>
	<tr>
	 <td class="normal" align="right">&nbsp;CPF :&nbsp;</td>
	 <td><input type="text" name="phone"></td>
	</tr>
	<tr>
	 <td class="normal" align="right">&nbsp;Mobile No :&nbsp;</td>
	 <td><input type="text" name="mobileno"></td>
	</tr>
	<tr>
	 <td class="normal" align="right"><font class="a">*</font>&nbsp;Email :&nbsp;</td>
 	 <td><input type="text" name="email"></td>
	</tr>
	<tr>
	 <td class="normal" align="right"><font class="a">*</font>&nbsp;Confirme Email :&nbsp;</td>
	<td><input type="text" name="cnfemail"></td>
	</tr>
    <tr>
	 <td class="normal" align="right"><font class="a">*</font>&nbsp;Password :&nbsp;</td>
	 <td><input type="password" name="pass_word"></td>
	</tr>
	<tr>
	 <td class="normal" align="right"><font class="a">*</font>&nbsp;Confirme Password :&nbsp;</td>
	 <td><input type="password" name="cpassword"></td>
    </tr>
	<tr>
	 <td>&nbsp;</td><td>&nbsp;</td>
	</tr>
	<TR> 
     <TD align=right>&nbsp;</TD>
     <TD><INPUT type="submit" value="Add" name="add" class="bttn"></TD>
    </TR>
   </TBODY>
  </TABLE>
</form></td></tr></TABLE>
<!-- changeble part ends -->
</body>
</html>
