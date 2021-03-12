<?
include("connect.php");
include("security.php");

$id=$_REQUEST['id'];
$username=$_REQUEST['username'];
$fname=$_REQUEST['fname'];
$lname=$_REQUEST['lname'];
$gender=$_REQUEST["gender"];
$bdate=$_REQUEST["cmbyear"]."-".$_REQUEST["cmbmonth"]."-".$_REQUEST["cmbdate"];
$date = $_REQUEST["cmbdate"];
$month = $_REQUEST["cmbmonth"];
$year =$_REQUEST["cmbyear"];
$address1=$_REQUEST['address1'];
$address2=$_REQUEST['address2'];
$city=$_REQUEST['city'];
$state=$_REQUEST['state'];
$zipcode=$_REQUEST['zipcode'];
$phone=$_REQUEST['phone'];
$mobileno = $_REQUEST["mobileno"];
$email=$_REQUEST['email'];
$pass=$_REQUEST['pass_word'];
$cpf = $_REQUEST["cpf"];
$rg = $_REQUEST["rg"];
$countryinfo = explode("|",$_REQUEST['country']);
$country=$countryinfo[0];
$countrycode=$countryinfo[1];
$fullmobile = "+".$countrycode.$mobileno;

if($_REQUEST['salva_ed']){
	$qrysel = "select * from registration where username='".$_REQUEST['username']."' and id <> '$id'";
	$rsqrysel = mysql_query($qrysel);
	$totalrows = mysql_affected_rows();
	if($totalrows>0){ // Nao permite mudar o nome de usuario para outro que ja existe !!!
		header("location: message.php?msg=4"); exit;
	}
	$sqlu="update registration set username='$username', firstname='$fname',  lastname='$lname', sex='$gender',
            birth_date='$bdate', addressline1='$address1',addressline2='$address2', city='$city',  state='$state',
            country='$country', postcode='$zipcode', phone='$phone', mobile_no='$mobileno', full_mobileno='$fullmobile',
            email='$email', password='$pass', cpf='$cpf',rg='$rg'  where id='$id'";
	$resultu=mysql_query($sqlu);
	header("location:message.php?msg=3"); exit;		
}

if($_REQUEST['salva_nv']){
	$qrysel = "select * from registration where username='".$_REQUEST['username']."'";
	$rsqrysel = mysql_query($qrysel);
	$totalrows = mysql_affected_rows();
	if($totalrows>0){ // Nao permite salvar o nome de usuario para outro que ja existe !!!
		header("location: message.php?msg=4"); exit;
	}
    $verifcode = md5($username);
    $agora=Date("Y-m-d H:i:s");
	$sqlu="insert into registration (username,firstname,lastname,sex,birth_date,addressline1,addressline2,city,state,
            country,postcode,phone,mobile_no,full_mobileno,email,password,cpf,rg,register_date,verify_code,
            final_bids,account_status,member_status,user_delete_flag,sponser,sms_flag,admin_user_flag) values
            ('$username','$fname','$lname','$gender','$bdate','$address1','$address2','$city','$state',
            '$country','$zipcode','$phone','$mobileno','$fullmobile','$email','$pass','$cpf','$rg','$agora','$verifcode',
            0,0,'0','',0,'0','0')";
            //echo $sqlu; exit;
	$resultu=mysql_query($sqlu);
	header("location:message.php?msg=2"); exit;
}

if($_REQUEST['editid']){
	$id=$_REQUEST['editid'];
	$sql="select * from registration where id='$id'";
	$result=mysql_query($sql);
	$row=mysql_fetch_object($result) or die(mysql_error());
    
    $username=$row->username;
	$fname=$row->firstname;
	$lname=$row->lastname;
	$gender=$row->sex;
	$bdate=$row->birth_date;
		$date = Date("d", strtotime($bdate));
		$month = Date("m", strtotime($bdate));
		$year = Date("Y", strtotime($bdate));
	$address1=$row->addressline1;
	$address2=$row->addressline2;
	$city=$row->city;
	$state=$row->state;
	$country=$row->country;
	$zipcode=$row->postcode;
	$phone=$row->phone;
	$mobile=$row->mobile_no;
	$email=$row->email;
	$pass=$row->password;
	$cpf=$row->cpf;
	$rg=$row->rg;
}

if($_REQUEST['delid']){
	$id=$_REQUEST['delid'];
	$sqldel="update registration set user_delete_flag='d' where id='$id'";
	$resultdel=mysql_query($sqldel) or die(mysql_error());
	header("location:message.php?msg=1");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
    <title>Untitled Document</title>
    <link rel="stylesheet" href="main.css" type="text/css">
    <style>
        .normaltxt { background-color: #F7F7F7; }
        .erradotxt { background-color: red;  }
        .certotxt  { background-color: #D0F0C0; }
    </style>
    <script language="javascript" src="Validation.js" type="text/javascript"></script>
    <script language="javascript" type="text/javascript">
        function validation(f1){
        	if(f1.username.value.length<=0){
        		alert("Por favor informe o nome de usuário!");
        		f1.username.focus();
        		return false;
        	}
        	if(f1.username.value.length<6){
        		alert("Nome de usuário muito pequeno! Mínimo 6");
        		f1.username.focus();
        		return false;
        	}
        	if(f1.fname.value.length<=0){
        		alert("Por favor informe o nome!");
        		f1.fname.focus();
        		return false;
        	}

        	if(f1.cmbmonth.value=="none"){
        		alert("Por favor selecione o mês de nascimento!");
        		f1.cmbmonth.focus();	
        		return false;	
        	}
        	if(f1.cmbdate.value=="none"){
        		alert("Por favor selecione o dia de nascimento!");
        		f1.cmbdate.focus();	
        		return false;	
        	}
        	if(f1.cmbyear.value=="none"){
        		alert("Por favor selecione o ano de nascimento!");
        		f1.cmbyear.focus();	
        		return false;	
        	}
        	if(f1.address1.value.length<=0){
        		alert("Por favor informe o endereço!");
        		f1.address1.focus();	
        		return false;
        	}
        	if(f1.city.value.length<=0){
        		alert("Por favor informe a cidade!");
        		f1.city.focus();	
        		return false;
        	}
        	if(f1.state.value.length<=0){
        		alert("Por favor informe o estado!");
        		f1.state.focus();	
        		return false;
        	}
        	if(f1.zipcode.value.length<=0){
        		alert("Por favor informe o cep!");
        		f1.zipcode.focus();	
        		return false;
        	}
        	/*if(f1.phone.value.length<=0){
        		alert("Por favor Enter Your Phone Number!");
        		f1.phone.focus();	
        		return false;
        	}*/
        	/*if(f1.country.value.length<=0){
        		alert("Por favor informe o país!");
        		f1.country.focus();	
        		return false;
        	}*/        	
        	if(f1.country.value=="none"){
        		alert("Por favor selecione o país!");
        		f1.country.focus();	
        		return false;
        	}
        	if(f1.cpf.value.length < 14){
        		alert("Por favor digite o CPF");
        		f1.cpf.focus();
        		f1.cpf.select();
        		return false;
        	}
            
            if(valida_cpf(f1.cpf.value)==false){
        		alert("CPF inválido");
        		f1.cpf.focus();
        		f1.cpf.select();
        		return false; 
            }
            
        	if(f1.email.value.length<=0){
        		alert("Por favor informe o Email!");
        		f1.email.focus();	
        		return false;
        	}
        	if(f1.cnfemail.value.length<=0){
        		alert("Por favor confirme o Email!");
        		f1.cnfemail.focus();	
        		return false;
        	}
        	if(f1.email.value!=f1.cnfemail.value){
        		alert("Emails diferentes!");
        		f1.cnfemail.focus();
        		f1.cnfemail.select();
        		return false;		
        	}else{
        		if(!validate_email(f1.email.value,"Por favor informe um email válido!")){
        				f1.email.select();
        				return false;
        		}
        	}
        	if(f1.pass_word.value==""){
        		alert("Por favor informe a senha!");
        		f1.pass_word.focus();
        		return false;
        	}
        	if(f1.pass_word.value.length<6){
        		alert("Senha muito pequena! Mínimo 6 caracteres");
        		f1.pass_word.focus();
        		f1.pass_word.select();
        		return false;
        	}
        	if(f1.cpassword.value==""){
        		alert("Por favor confirme a senha!");
        		f1.cpassword.focus();		
        		return false;
        	}
        	if(f1.cpassword.value!=f1.pass_word.value){
        		alert("Senhas diferentes!");
        		f1.pass_word.focus();
        		f1.cpassword.select();
        		return false;
        	}	
        }
        
        // Valida os campos
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
        function cpf_v(o){
            v=o.value.replace(/\D/g,"")                    //Remove tudo o que nao eh digito
        	if(valida_cpf(v)){
        		o.className="certotxt"
        	}else{
        		o.className="erradotxt"
        	}
        
            v=v.replace(/(\d{3})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto digitos
            v=v.replace(/(\d{3})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto digitos
                                                     //de novo (para o segundo bloco de numeros)
            v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2") //Coloca um hifen entre o terceiro e o quarto digitos
        	if(v.length < 14)
        		o.className="normaltxt"
            o.value=v
        }
        function valida_cpf(cpf){
        	var numeros, digitos, soma, i, resultado, digitos_iguais;
            cpf =cpf.replace(/\D/g,"");
            digitos_iguais = 1;
            if (cpf.length < 11)
                return false;
            for (i = 0; i < cpf.length - 1; i++)
                if (cpf.charAt(i) != cpf.charAt(i + 1)){
                    digitos_iguais = 0;
                    break;
                }
            if (!digitos_iguais){
        		numeros = cpf.substring(0,9);
        		digitos = cpf.substring(9);
        		soma = 0;
        		for (i = 10; i > 1; i--)
        			soma += numeros.charAt(10 - i) * i;
        		resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        		if (resultado != digitos.charAt(0))
        			return false;
        		numeros = cpf.substring(0,10);
        		soma = 0;
        		for (i = 11; i > 1; i--)
        			soma += numeros.charAt(11 - i) * i;
        		resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        		if (resultado != digitos.charAt(1))
        			return false;
        		return true;
        	}else{return false;}
        }
        
        function formataCampo(campo, Mascara, evento) {
            var boleanoMascara;
         
            var Digitato = evento.keyCode;
            exp = "/\-|\.|\/|\(|\)| /g";
            campoSoNumeros = campo.value.toString().replace( exp, "" );
         
            var posicaoCampo = 0;    
            var NovoValorCampo="";
            var TamanhoMascara = campoSoNumeros.length;;
         
            if (Digitato != 8) { // backspace
                for(i=0; i<= TamanhoMascara; i++) {
                    boleanoMascara  = ((Mascara.charAt(i) == "-") || (Mascara.charAt(i) == ".")
                                        || (Mascara.charAt(i) == "/"))
                    boleanoMascara  = boleanoMascara || ((Mascara.charAt(i) == "(")
                                        || (Mascara.charAt(i) == ")") || (Mascara.charAt(i) == " "))
                    if (boleanoMascara) {
                        NovoValorCampo += Mascara.charAt(i);
                          TamanhoMascara++;
                    }else {
                        NovoValorCampo += campoSoNumeros.charAt(posicaoCampo);
                        posicaoCampo++;
                      }           
                  }    
                campo.value = NovoValorCampo;
                  return true;
            }else {
                return true;
            }
        }
    </script>

</head>

<body>
<table cellspacing="10" cellpadding="0"  border="0" width="650">
		<tr>
        <? if($id){?>
			<td class="H1">Editar Usu&aacute;rio</td>
        <? }else{?>
			<td class="H1">Adicionar Usu&aacute;rio</td>
        <?}?>
		</tr>
		<tr>
			<td background="images/vdots.gif">
            <img src="images/spacer.gif" height="1" width="1" border="0" /></td>
		</tr>
	<? if($msg){ ?>
		<tr>
			<td bgcolor="#F1F0EF" style='color:#FF0000;' align="center"><?=$msg?></td>
		</tr>
	<? } ?>
        <tr><td>
<!-- changeble part starts -->
<form action="edit_member.php" method="post" name="newmember" onsubmit="return validation(this);">
<input type="hidden" name="id" value="<?=$id?>" />
<table cellspacing="2" cellpadding="1" width="650" border="0">
   <tbody>
     <tr align="right"><td colspan="2" class="a">* Campos Obrigatorios</td></tr>
     <tr><td class="th-d" colspan="2">Informa&ccedil;&otilde;es B&aacute;sicas</td></tr>
     <tr> 
       <td width="250" align="right"><img height="5" src="images/spacer.gif" width="1" border="0" /></td>
       <td width="400"> </td>
     </tr>
   	 <tr>
	  <td class="normal" align="right"><font class="a">*</font>&nbsp;Nome de Usu&aacute;rio :&nbsp;</td>									
 	  <td><input type="text" name="username" value="<?=$username?>" /></td>
	 </tr>
     <tr>
	  <td class="normal" align="right"><font class="a">*</font>&nbsp;Primeiro Nome :&nbsp;</td>	  
	  <td><input type="text" name="fname" value="<?=$fname?>" /></td>
	</tr>
	<tr>
	  <td class="normal" align="right"><font class="a">*</font>&nbsp;&Uacute;ltimo Nome:&nbsp;</td>
	  <td><input type="text" name="lname" value="<?=$lname?>" /></td>
	</tr>
	<tr>
	  <td class="normal" align="right"><font class="a">*</font>&nbsp;Sexo :&nbsp;</td>
	  <td><select name="gender" style="background:#F7F7F7;width:87pt">
	  		<option value="Male" <?=$gender=="Male"?selected:"";?>>Masculino</option>
			<option value="Female" <?=$gender=="Female"?selected:"";?>>Feminino</option>
		</select>
	   </td>
    </tr>
	<tr>
	  <td class="normal" align="right"><font class="a">*</font>&nbsp;Data de Nascimento :&nbsp;</td>
	  <td>
		  <select name="cmbdate" style="background:#F7F7F7">
	  		<option value="none" selected="selected">--</option>		  
	  		<?
				for($i=1;$i<=31;$i++){
					if($i<=9){
						$i="0".$i;
					}
			?>
				<option value="<?=$i;?>" <?=$date==$i?"selected":"";?>><?=$i;?></option>
			<?	
				}
			?>
		  </select>
		<select name="cmbmonth" style="background:#F7F7F7">
	  		<option value="none" selected="selected">--</option>
	  		<?
				for($i=1;$i<=12;$i++){
					if($i<=9){
						$i="0".$i;
					}
			?>
				<option value="<?=$i;?>" <?=$month==$i?"selected":"";?>><?=$i;?></option>
			<?	
				}
			?>
		  </select>		  
		  <select name="cmbyear" style="background:#F7F7F7">
	  		<option value="none" selected="selected">----</option>		  
	  		<?
				for($i=1950;$i<=2020;$i++){
			?>
				<option value="<?=$i;?>" <?=$year==$i?"selected":"";?>><?=$i;?></option>
			<?	
				}
			?>
		  </select>
	   </td>
    </tr>
    <tr>
	  <td class="normal" align="right"><font class="a">*</font>&nbsp;Endere&ccedil;o :&nbsp;</td>
	  <td><input type="text" name="address1" value="<?=$address1;?>" /></td>
    </tr>
    <tr>
	  <td class="normal" align="right">&nbsp;Complemento :&nbsp;</td>
	  <td><input type="text" name="address2" value="<?=$address2;?>" /></td>
    </tr>
	<tr>
	 <td class="normal" align="right"><font class="a">*</font>&nbsp;Cidade :&nbsp;</td>
	 <td><input type="text" name="city" value="<?=$city?>" /></td>
	</tr>
    <tr>
	 <td class="normal" align="right"><font class="a">*</font>&nbsp;Estado :&nbsp;</td>
	 <td><input type="text" name="state" value="<?=$state?>" /></td>
	</tr>
    <tr>
      <td class="normal" align="right"><font class="a">*</font>&nbsp;CPF :&nbsp;</td>
      <td><input type="text" name="cpf" class="normaltxt"  onkeyup="cpf_v(this)" value="<?=$cpf?>" /></td>
    </tr>
    <tr>
      <td class="normal" align="right">&nbsp;RG :&nbsp;</td>
      <td><input type="text" name="rg" value="<?=$rg?>" /></td>
    </tr>
    <tr>
	 <td class="normal" align="right"><font class="a">*</font>&nbsp;Pa&iacute;s :&nbsp;</td>
	 <td><select name="country" style="background:#F7F7F7;width:87pt">
     	<option value="none">-- Selecione --</option>
	 	 <? 
		 	$qrycou = "select * from countries order by printable_name";
			$rescou = mysql_query($qrycou);
			while($cou=mysql_fetch_array($rescou)){
		 ?>
		 	<option <?=$country==$cou["countryId"]?"selected":"";?> value="<?=$cou["countryId"];?>|<?=$cou["countrycode"];?>"><?=$cou["printable_name"];?></option>
		<?
			}
		?>
		</select>
		</td>
	</tr>
	<tr>
	 <td class="normal" align="right">&nbsp;CEP :&nbsp;</td>
	 <td><input type="text" name="zipcode" value="<?=$zipcode?>" /></td>
	</tr>
	<tr>
	 <td class="normal" align="right">&nbsp;Telefone :&nbsp;</td>
	 <td><input type="text" name="phone" value="<?=$phone;?>" /></td>
	</tr>
	<tr>
	 <td class="normal" align="right">&nbsp;Celular :&nbsp;</td>
	 <td><input type="text" name="mobileno" value="<?=$mobile;?>" /></td>
	</tr>
	<tr>
	 <td class="normal" align="right"><font class="a">*</font>&nbsp;Email :&nbsp;</td>
 	 <td><input type="text" name="email" value="<?=$email?>" /></td>
	</tr>
	<tr>
	 <td class="normal" align="right"><font class="a">*</font>&nbsp;Confirma&ccedil;&atilde;o de Email:&nbsp;</td>
	 <td><input type="text" name="cnfemail" value="<?=$email?>" /></td>
	</tr>
    <tr>
	 <td class="normal" align="right"><font class="a">*</font>&nbsp;Senha :&nbsp;</td>
	 <td><input type="password" name="pass_word" value="<?=$pass?>" /></td>
	</tr>
	<tr>
	 <td class="normal" align="right"><font class="a">*</font>&nbsp;Confirma&ccedil;&atilde;o de Senha :&nbsp;</td>
	 <td><input type="password" name="cpassword" value="<?=$pass?>" /></td>
    </tr>
	<tr>
	 <td>&nbsp;</td><td>&nbsp;</td>
	</tr>
	<tr> 
     <td align="right">&nbsp;</td>
     <td>
     <? if($_REQUEST['editid']){ ?>
        <input type="hidden" name="salva_ed" value="<?=$id?>" />
		<input type="submit" value="Editar" name="Editar" class="bttn" /></td>
     <? }else{ ?>
        <input type="hidden" name="salva_nv" value="1" />
		<input type="submit" value="Salvar" name="Salvar" class="bttn" /></td>
     <? } ?>
    </tr>
   </tbody>
  </table>
</form></td></tr></table>
<!-- changeble part ends -->
</body>
</html>