<?
	include("config/connect.php");
	include("sendmail.php");
	include("functions.php");

	if($_POST["submit"]!="")
	{
		$email = $_POST["email"];
		$qrysel = "select * from registration where email='$email' and user_delete_flag!='d'";
		$ressel = mysql_query($qrysel);
		$total = mysql_num_rows($ressel);
		$obj = mysql_fetch_object($ressel);

		if($total>0 && $obj->account_status!='0')
		{
			$fname = $obj->firstname;
			$username = $obj->username;
			$auctionwith_id = $obj->id;
			$encode_username = base64_encode($obj->username);
			$encode_password = base64_encode($obj->password);
			$session_id = session_id();
			
			$emailcont1 = sprintf($lng_emailcontent_forgotpassword,$fname,$username,$auctionwith_id,$encode_username,$encode_password,$session_id);
			
		$subject=$lng_mailsubjectaccinfo;
		$from=$adminemailadd;
		SendHTMLMail($email,$subject,$emailcont1,$from);
		}
		elseif($obj->account_status=='0')
		{
			$msg = 2;
		}
		else
		{
			$msg = 1;
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
<title><?=$AllPageTitle;?></title>
<link href="css/style_youbid.css" rel="stylesheet" type="text/css" />
<link href="css/menu.css" rel="stylesheet" type="text/css" />
<link href="css/estilo.css" rel="stylesheet" type="text/css" />
<!--[if IE 8]>
<link href="css/estiloie8.css" rel="stylesheet" type="text/css" />
<![endif]-->
<!--[if IE 7]>
<link href="css/estiloie7.css" rel="stylesheet" type="text/css" />
<![endif]-->
<!--[if lte IE 6]>
<link href="css/menu_ie.css" rel="stylesheet" type="text/css" />
<![endif]-->
<script language="javascript" type="text/javascript" src="js/function.js"></script>
<script language="javascript">
	function check()
	{
		if(document.forgot.email.value=="")
		{
			alert("<?=$lng_plsenteremailadd;?>");
			document.forgot.email.focus();
			document.forgot.email.select();
			return false;
		}
		else
		{
			if(!validate_email(document.forgot.email.value,"<?=$lng_entervalidemail;?>"))
				{
					document.forgot.email.select();
					return false;
				}
		}
	}
	function validate_email(field,alerttxt){
		with (field){
			var value;
			value = document.forgot.email.value;
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
<div id="conteudo-principal">
<?
	include("header.php");
?>
<div id="conteudo-conta" style="float:right; width:100%">
		<h3 id="conta-tit"><?=$lng_titleforgot;?></h3>

				<? if($msg==1){?>	
					<p style="color:#C30"><?=$lng_didnotfindemail;?></p>
				<? } elseif($msg==2){ ?>
<p><?=$lng_accountverify;?></p>
					<div style="height: 10px;">&nbsp;</div>
				<? } ?>
				<?
				if($_POST["email"]!="" && $total>0 && $obj->account_status!='0')
				{
				?>
<p style="margin-bottom:10px;"><?=$lng_emailsentto;?> <?=$email;?></p>
<p style="margin-bottom:10px;"><a href="index.html" style="color:#C30">
<!--
<?=$lng_tabhome;?>
-->
Voltar para p&aacute;gina inicial
</a></p>

			    <?
				}
				else
				{
				?>
				<form name="forgot" method="post" action="" onsubmit="return check();">
<h4 style="font-size:16px; margin-bottom:20px;"><?=$lng_forgottendata;?></h4>
<p style="margin-bottom:10px;"><?=$lng_noproblementer;?></p>
<p style="margin-bottom:10px;"><b><?=$lng_enteryouremail;?></b></p>
						<div style="height: 15px;">&nbsp;</div>
						<div><input type="text" name="email" size="50" class="campo1" />


<p><span class="enviar"><input type="image" value="sub" src="imagens/enviar.gif" width="54" height="53" onmouseout="this.style.margin='0 0 0 0'" onmouseover="this.style.margin='-26px 0 0 0'" /><input type="hidden" value="submit" name="submit" /></span></p>

				</form>
				<?
				}
				?>
  		 </div>
		</div>
<?
	include("footer.php");
?>		
</body>
</html>
