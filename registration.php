<?
	include_once("config/connect.php");
    include_once("sendmail.php");
	include_once("functions.php");

    $head_tag = '<link href="zpcal/themes/aqua.css" rel="stylesheet" type="text/css" media="all" title="Calendar Theme - aqua.css" />';
	if($_GET["ref"]!=""){
		$_SESSION["refid"] = $_GET["ref"];
	}

	if($_POST["username"]!=""){ // adicionar
		$fname = $_POST["firstname"];
		$gender = $_POST["gender"];
		$bdateI = explode('/', $_POST["bdate"]); 
        $bdate = $bdateI[1].'/'.$bdateI[0].'/'.$bdateI[2];
		$email = $_POST["email"];
		$username = $_POST["username"];
		$pass = $_POST["password"];
		$cpf = $_POST["cpf"];
		$phoneno = $_POST["phoneno"];
		$mobile = $_POST["mobileno"];
		//$countryinfo = explode("|",$_POST["countrycode"]);$countrycode = $countryinfo[0];$countryID = $countryinfo[1];
        $countryID = 1;
		$postcode = $_POST["postcode"];
		$state = $_POST["state"];
		$city = $_POST["city"];
		$addressline2 = $_POST["addressline2"];
		$addressline1 = $_POST["addressline1"];
		$addressnumber = $_POST["addressnumber"];
		$addresscompl = $_POST["addresscompl"];
		$terms = $_POST["terms"];
		$privacy = $_POST["privacy"];		
		$news = $_POST["newslatter"];
		
		$final_bids = 0;
		$sql = "select * from general_setting";
		$res = mysql_query($sql);
		if ($res){ if(0<mysql_num_rows($res)){ $row = mysql_fetch_array($res); $final_bids = $row["bonusLanceCad"]; } }
		
		$sponser = $_SESSION["refid"];
		$agora=date("Y-m-d H:i:s");
		$verifycode = md5($username);
		
		$rndcode = strtolower($_POST["rndcode"]);
		// verificando usuario duplicado!
		$qrysel = "select * from registration where (username='$username' or email='$email' or cpf='$cpf') and user_delete_flag != 'd'";
		$ressel = mysql_query($qrysel);
		$totalrows = mysql_affected_rows();
		$obj = mysql_fetch_object($ressel);
		if($totalrows>0){
			if($email==$obj->email){
				 $err=1; // email repetido
			}else if ($cpf==$obj->cpf){
				 $err=4; // cpf repetido
			}else{
				 $err=2; // usuario repetido
			}
		}elseif($_SESSION['security_code']!=$rndcode){
			$err=3;  // codigo de seguranca repetido
		}else{ // fim das verificacoes de duplicaçoes
			$qryins = "Insert into registration (firstname, sex, birth_date, email, username, password, cpf, phone, mobile_no,
						 country, postcode, state, city, addressline2, addressline1, numero, complemento,
						 terms_condition, privacy, newslatter, final_bids, sponser, register_date, verify_code, ip_registro)
					   values('$fname','$gender','{$bdateI[2]}-{$bdateI[1]}-{$bdateI[0]}','$email','$username','$pass','$cpf','$phoneno','$mobile',
						 '$countryID','$postcode','$state','$city','$addressline2','$addressline1','$addressnumber','$addresscompl',
						 '$terms','$privacy','$news','$final_bids','$sponser','$agora','$verifycode','{$_SERVER[REMOTE_ADDR]}')";
			mysql_query($qryins) or die(mysql_error());
			$_SESSION["uid"] = mysql_insert_id();

			$uid = $_SESSION["uid"];
			$auction_username = $username;
			$auction_userid = $_SESSION["uid"];
			//		$encode_userid = base64_encode($_SESSION["uid"]);
			//		$encode_username = base64_encode($username);
			//		$encode_password = base64_encode($pass);
		
			$emailcont1 = sprintf($lng_emailcontent_registraion,$fname,$auction_username,$auction_userid,$verifycode);
			$subject = $lng_mailsubjectaccinfo;
			$from = $adminemailadd;
		
			SendHTMLMail($email,$subject,$emailcont1,$from);
//		header("location: registration.php");
		}
	}	
?>

<style>
	.normaltxt { background-color: white; width:320px; height:31px; display:block; border:groove green; font-size:18px;}
	.erradotxt { background-color: #FFAAAA; width:320px; height:31px; display:block; border:groove red; font-size:18px;}
	.certotxt  { background-color: #D0F0C0; width:320px; height:31px; display:block; border:groove green; font-size:18px;}
</style>
<script type="text/javascript" src="zpcal/src/utils.js"></script>
<script type="text/javascript" src="zpcal/src/calendar.js"></script>
<script type="text/javascript" src="zpcal/lang/calendar-en.js"></script>
<script type="text/javascript" src="zpcal/src/calendar-setup.js"></script>
<script language="javascript" src="js/pwd_strength.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript" src="js/function.js"></script>
<script language="javascript">
	function Check(){
		if(document.registration.firstname.value==""){
			alert("<?=$lng_regenterfirstname;?>");
			document.registration.firstname.focus();
			return false;
		}
		
		if(document.registration.bdate.value==""){
			alert("<?=$lng_regselbirthdate;?>");
			document.registration.date.focus();
			return false;
		}
		
		if(document.registration.postcode.value==""){
			alert("<?=$lng_regenterpostcode;?>");
			document.registration.postcode.focus();
			return false;
		}
	
		if(document.registration.state.value==""){
			alert("<?=$lng_regenterstate;?>");
			document.registration.state.focus();
			return false;
		}
	
		if(document.registration.city.value==""){
			alert("<?=$lng_regentercity;?>");
			document.registration.city.focus();
			return false;
		}
	
		if(document.registration.addressline1.value==""){
			alert("<?=$lng_js_regenteraddress;?>");
			document.registration.addressline1.focus();
			return false;
		}
		
		if(document.registration.addressline2.value==""){
			alert("<?=$lng_regenteraddress2;?>");
			document.registration.addressline2.focus();
			return false;
		}
		
		if(document.registration.addressnumber.value==""){
			alert("<?=$lng_js_regenteraddressn;?>");
			document.registration.addressnumber.focus();
			return false;
		}
		
		if(document.registration.phoneno.value=="" && document.registration.mobileno.value==""){
			alert("<?=$lng_regenterphoneno;?>");
			document.registration.phoneno.focus();
			return false;
		}
		
		if(document.registration.phoneno.value.length<14 && document.registration.mobileno.value.length<14){
			alert("<?=$lng_regenterphoneno;?>");
			document.registration.phoneno.focus();
			return false;
		}
		
		if(document.registration.username.value.length < 6){
			alert("<?=$lng_regusernametooshort;?>");
			document.registration.username.focus();
			document.registration.username.select();
			return false;
		}
		
		if(document.registration.cpf.value.length < 14){
			alert("<?=$lng_regentercpf;?>");
			document.registration.cpf.focus();
			document.registration.cpf.select();
			return false;
		}
		
		if(valida_cpf(document.registration.cpf.value)==false){
			alert("<?=$lng_js_regentercpf2;?>");
			document.registration.cpf.focus();
			document.registration.cpf.select();
			return false; 
		}
		
		if(document.registration.password.value==""){
			alert("<?=$lng_regenterpassword;?>");
			document.registration.password.focus();
			return false;
		}
		
		if(document.registration.password.value.length<6){
			alert("<?=$lng_regpasstooshort;?>");
			document.registration.password.focus();
			return false;
		}
		
		if(document.registration.cnfpassword.value==""){
			alert("<?=$lng_js_regconfpassword;?>");
			document.registration.cnfpassword.focus();
			return false;
		}
		
		if(document.registration.password.value!=document.registration.cnfpassword.value){
			alert("<?=$lng_regpassmismatch;?>");
			document.registration.cnfpassword.focus();
			return false;
		}
		
		if(document.registration.email.value==""){
			alert("<?=$lng_regenteremailadd;?>");
			document.registration.email.focus();
			return false;
		}else{
			if(!validate_email(document.registration.email,"<?=$lng_entervalidemail;?>")){
				document.registration.email.select();
				return false;
			}
		}
		if(document.registration.cnfemail.value==""){
			alert("<?=$lng_regenterconfemail;?>");
			document.registration.cnfemail.focus();
			return false;
		}
		
		if(document.registration.email.value!=document.registration.cnfemail.value){
			alert("<?=$lng_regemailmismatch;?>");
			document.registration.cnfemail.focus();
			return false;
		}
		
		if(document.registration.privacy.checked!=true){
			alert("<?=$lng_js_regreadprivacy;?>");
			document.registration.privacy.focus();
			return false;
		}
		
		if(document.registration.terms.checked!=true){
			alert("<?=$lng_js_regreadterms;?>");
			document.registration.terms.focus();
			return false;
		}
		
		if(document.registration.rndcode.value==""){
			alert("<?=$lng_js_regenterseccode;?>");
			document.registration.rndcode.focus();
			return false;
		}
		
		document.registration.submit();
	}

	function fone(o){
		v=o.value.replace(/\D/g,"")                 //Remove tudo o que nao eh digito
		v=v.replace(/^(\d\d)(\d)/g,"($1) $2") //Coloca parenteses em volta dos dois primeiros digitos
		v=v.replace(/(\d{4})(\d)/,"$1-$2")    //Coloca hifen entre o quarto e o quinto digitos
		o.value=v
	}
	
	function cep(o){
		v=o.value.replace(/\D/g,"")                //Remove tudo o que nao eh digito
		v=v.replace(/^(\d{5})(\d)/,"$1-$2") 
		o.value=v
	}

	function validate_email(field,alerttxt){
		with (field){
			apos=value.indexOf("@");
			dotpos=value.lastIndexOf(".");
			if (apos<1||dotpos-apos<2){
				alert(alerttxt);
                return false;
			}
		}
		return true;
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
</script>
		<?php include("header.php"); ?>

		<div id="conteudo-principal">
			<h2 id="registrar-tit"><?=$lng_tabregister;?></h2>
<? if($_SESSION["uid"]==""){ ?>
			<ul id="registrar-vantagens">
				<li><p><?=$lng_frregistration;?>
				<li><p><?=$lng_vouchermessage;?>
				<li><p><?=$lng_amazingproducts;?>
			</ul>
			<p>&nbsp;</p>
			<p align="left" style="padding-left: 50px;"><font size="+1"><?=$lng_registrationdata;?>:</font></p>
			<?
			if($err!=""){
				echo '<p align="left" style="margin-top: 25px; padding-left: 50px;" class="red-text-12-b">';
				if ($err == 4) {echo 'CPF j&aacute; existente.';} 
				elseif ($err == 1) {echo $lng_emailexists;}
				elseif ($err == 2) {echo $lng_usernameexists;}
				else {echo $lng_correctcode;}
				echo "</p>";
			}
			?>
			<form id="registration" name="registration" method="post" action="registration.php">				  
				<h3 class="info-pessoal"><?=$lng_personalinfo;?></h3>
				<p style="clear:both">
					<span class="registro-campo"><label for="firstname"><?=$lng_firstname;?></label>
						<input type="text" class="campo1" name="firstname" maxlength="100" value="<?=$fname!=""?$fname:"";?>" />
					</span>
					<span class="registro-campo"><label><?=$lng_birthdate;?></label>
						<input type="text" size="12" name="bdate" id="nascimento" class="campo3"
						 value="<?=$bdate!=""?date("d/m/Y",strtotime($bdate)):date("d/m/Y");?>" />
						<img name="datacal" src="images/pmscalendar.gif" align="absmiddle" width="31" height="31" id="vnascimento" />
					</span>
					<span class="registro-campo"><label><?=$lng_gender;?></label>
						<select size="1" name="gender" class="campo3">
							<option selected="selected" value="Male"><?=$lng_male;?></option>
							<option <?=$gender=="Female"?"selected":"";?> value="Female"><?=$lng_female;?></option>
						</select>
					</span>
					<span class="registro-campo"><label for="countryname"><?=$lng_country;?></label>
						<font size="+2">Brasil</font><br />
						<font size="-2">(Atualmente apenas cobertura nacional)</font>
						<input type="hidden" name="countrycode" value="BRA" />
					</span>
				</p>
				<p style="clear:both">
					<span class="registro-campo"><label><?=$lng_postcode;?></label>
						<input type="text" class="campo3" name="postcode" onkeyup="cep(this)" maxlength="9" value="<?=$postcode!=""?$postcode:"";?>" />
					</span>
					<span class="registro-campo"><label><?=$lng_state;?></label>
						<select name="state" class="campo3">
						<?
						$qryc = "select * from estado order by UFE_NOME";
						$resc = mysql_query($qryc);
						$totalc = mysql_affected_rows();
						while($namec = mysql_fetch_array($resc)){
							echo '<option '.($state==$namec["UF_COD"]?" selected ":"").' value="'.$namec["UF_COD"].'">'.stripslashes($namec["UFE_NOME"]).'</option>';
						}
						?>
						</select>
					</span>
					<span class="registro-campo"><label><?=$lng_towncity;?></label>
						<input type="text" class="campo2" name="city" maxlength="100" value="<?=$city!=""?$city:"";?>" />
					</span>
					<span class="registro-campo"><label><?=$lng_addressline2;?></label>
						<input type="text" class="campo2" name="addressline2" maxlength="100" value="<?=$addressline2!=""?$addressline2:"";?>" />
					</span>
				</p>
				<p style="clear:both">
					<span class="registro-campo"><label><?=$lng_addressline1;?></label>
						<input type="text" class="campo1" name="addressline1" maxlength="100" value="<?=$addressline1!=""?$addressline1:"";?>" />
					</span>
					<span class="registro-campo"><label><?=$lng_addressnumber;?></label>
						<input type="text" class="campo3" name="addressnumber" maxlength="100" value="<?=$addressnumber!=""?$addressnumber:"";?>" />
					</span>
					<span class="registro-campo"><label><?=$lng_addresscompl;?></label>
						<input type="text" class="campo1" name="addresscompl" maxlength="100" value="<?=$addresscompl!=""?$addresscompl:"";?>" />
					</span>
				</p>
				<p>
					<span class="registro-campo"><label><?=$lng_phoneno;?></label>
						<input name="phoneno" type="text" class="campo1" onkeyup="fone(this)" maxlength="14" value="<?=$phoneno!=""?$phoneno:"";?>" />
					</span>
					<span class="registro-campo"><label><?=$lng_mobilenumber;?></label>
						<input name="mobileno" type="text" class="campo1" onkeyup="fone(this)" maxlength="14" value="<?=$mobile!=""?$mobile:"";?>" />
					</span>
				</p>
				<h3 class="info-login" ><?=$lng_logininfo;?></h3>
				<p>
					<span class="registro-campo"><label><?=$lng_username;?></label>
					  <? if($err==2){ ?>					
						<input name="username" type="text" class="campo1" maxlength="16" />
					  <? } else { ?>
						<input name="username" type="text" class="campo1"  maxlength="16" value="<?=$username!=""?$username:"";?>" />
					  <? } ?>	
						<span style="display:block; font-size:11"><?=$lng_characterlong;?></span>
					</span>	
					<span class="registro-campo"><label><?=$lng_cpf;?></label>
						<input type="text" name="cpf"  class="normaltxt" maxlength="14" onkeyup="cpf_v(this)" value="<?=$cpf!=""?$cpf:"";?>" />
					</span>
				</p>
				<p style="clear:both">
					<span class="registro-campo"><label><?=$lng_password;?></label>
						<input name="password" class="campo1" type="password" maxlength="16" value="<?=$pass!=""?$pass:"";?>" onkeyup="pwd_test_password(this.value);" />
						<span style="display:block; font-size:11"><?=$lng_characterlong;?></span>
					</span>
					<span class="registro-campo"><label><?=$lng_retypepassword;?></label>
						<input name="cnfpassword" type="password" class="campo1" maxlength="16" value="<?=$pass!=""?$pass:"";?>" />
						<span style="display:block; font-size:11"><?=$lng_passsecurity;?>:</span>
					</span>
				</p>
				<p style="clear:both">
					<span class="registro-campo"><label><?=$lng_emailaddress;?></label>
						<? if($err==1){ ?>		
							<input name="email" type="text" class="campo1" maxlength="150" />
						<? } else { ?>
							<input name="email" type="text" class="campo1" maxlength="150" value="<?=$email!=""?$email:"";?>" />
						<? } ?>
					</span>
					<span class="registro-campo"><label><?=$lng_confirmemail;?></label>
						<? if($err==1){ ?>		
							<input name="cnfemail" type="text" class="campo1" maxlength="150" />
						<? } else { ?>
							<input name="cnfemail" type="text" class="campo1" maxlength="150" value="<?=$email!=""?$email:"";?>" />
						<? } ?>
					</span>
				</p>
				<div style="clear:both"></div>
				<div style="height: 25px; margin-top:15px;">
					<input class="checkbox" type="checkbox" name="privacy" value="1" <?=$privacy=="1"?"checked":"";?> /><?=$lng_acceptprivacy;?>
					<br /><input class="checkbox" type="checkbox" name="terms" value="1" <?=$terms=="1"?"checked":"";?> /><?=$lng_acceptterms;?>
					<br /><input class="checkbox" type="checkbox" name="newslatter" value="1" <?=$news=="1"?"checked":"";?> /><?=$lng_acceptnewsletter;?>
				</div>
			</div>			 
			<div style="height: 15px;">&nbsp;</div>
			<div class="register-form" style="padding-left: 540px;">
				<span id="registrar-botao">
					<input type="image" src="imagens/registrar.jpg" onmouseover="this.style.margin='-52px 0 0 0'" onmouseout="this.style.margin='0 0 0 0'" name="register"  onclick="return Check();" />
				</span>
			</div>			  
		</form>
<script type="text/javascript">
var cal = new Zapatec.Calendar.setup({ inputField:"nascimento", ifFormat:"%d/%m/%Y", button:"vnascimento", showsTime:false });
</script>  
<?
	}else{
		$qrys = "select email from registration where id='".$_SESSION["uid"]."'";
		$ress = mysql_query($qrys);
		$rows = mysql_fetch_object($ress);
?>
		<div style="height: 25px;">&nbsp;</div>
		<div style="padding-left: 30px; width: 800px; float: left">
			<p align="justify"><?=$lng_confirmregister;?></p> 
			<p align="justify"><?=$lng_sentemailto;?><?=$rows->email;?></p>
			<p align="justify"><?=$lng_registernote;?></p>
			<p align="justify" class="red-text-12-b"><?=$lng_importantword;?></p>
			<p align="justify"><?=$lng_dontreceivenote;?></p>
			<div style="height: 25px;">&nbsp;</div>
		</div>
<?      unset($_SESSION["uid"]);	
	}
?>		
<?	include("footer.php"); ?>