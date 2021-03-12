<?
	include("config/connect.php");
	include("session.php");
	include("functions.php");


	$uid = $_SESSION["userid"];
	
	if($_POST["submit"]!="")
	{
		$pass = $_POST["newpass"];
		$qryupd = "update registration set password='$pass' where id='$uid'";
		mysql_query($qryupd) or die(mysql_error());
		$msg=1;
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
		if(document.newpassword.newpass.value=="")
		{
			alert("<?=$lng_plsenternewpass;?>");
			document.newpassword.newpass.focus();
			return false;
		}	
		
		if(document.newpassword.newpass.value.length<6)
		{
			alert("<?=$lng_passtooshort;?>");
			document.newpassword.newpass.focus();
			document.newpassword.newpass.select();
			return false;
		}	

		if(document.newpassword.cnfnewpass.value=="")
		{
			alert("<?=$lng_plsenterconfpass;?>");
			document.newpassword.cnfnewpass.focus();
			return false;
		}	
		
		if(document.newpassword.newpass.value!=document.newpassword.cnfnewpass.value)
		{
			alert("<?=$lng_passmismatch;?>");
			document.newpassword.cnfnewpass.focus();
			document.newpassword.cnfnewpass.select();
			return false;
		}
	}
</script>
</head>


<body>
<div id="conteudo-principal">
<?
	include("header.php");
?>
			<? include("leftside.php"); ?>
<div id="conteudo-conta">
				<h3 id="conta-tit"><?=$lng_myauctionsavenue;?> - <?=$lng_changepassword;?></h3>

					<?
						if($msg==1)
						{
					?>
<p style="font-size:16px; color:#0C6; margin-bottom:20px;"><?=$lng_passwordchanged;?></p>
					<?
						}
					?>
					<h4 style="font-size:16px; margin-bottom:20px;"><?=$lng_yourpassword;?></h4>
						<form name="newpassword" action="" method="post" onsubmit="return check();">
<p style="margin-bottom:10px;"><label><?=$lng_enternewpassword;?></label><input type="password" name="newpass" size="30" maxlength="50" class="campo1" /></p>
<p  style="margin-bottom:10px;"><label><?=$lng_retypenewpassword;?></label><input type="password" name="cnfnewpass" size="30" maxlength="50" class="campo1" /></p>
<p><span class="enviar"><input type="image" name="submitimage" value="Submitimage" src="imagens/enviar.gif" width="54" height="53" onmouseout="this.style.margin='0 0 0 0'" onmouseover="this.style.margin='-26px 0 0 0'" /><input type="hidden" value="submit" name="submit" /></span></p>
						</form>					
				</div>

		</div>
<?
	include("footer.php");
?>		

</body>
</html>
