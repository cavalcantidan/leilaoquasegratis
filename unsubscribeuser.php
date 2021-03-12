<?
	include("config/connect.php");
	include("session.php");
	include("functions.php");

	$uid = $_SESSION["userid"];
	
	if($_POST["submit"]!="" && $_POST["unsubscribecheck"]!="")
	{
		$qryupd = "update registration set account_status='2', user_delete_flag='d' where id='$uid'";
		mysql_query($qryupd) or die(mysql_error());
		header("location: logout.html");
		exit;
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
		if(document.unsubscribe.unsubscribecheck.checked==false)
		{
			alert("<?=$lng_js_plstickcheckbox;?>");
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
<h3 id="conta-tit"><?=$lng_myauctionsavenue;?> - <?=$lng_closeaccount;?></h3>

				<form name="unsubscribe" action="" method="post" onsubmit="return check();">
<h4 style="font-size:16px; margin-bottom:20px;"><?=$lng_closeavenueacc;?></h4>
						<p><?=$lng_closeimportantnote;?></p>
						<div style="margin-top: 10px;" class="normal_text"><input type="checkbox" name="unsubscribecheck" value="unsubscribe" class="checkbox" />&nbsp;&nbsp;<b><?=$lng_yescloseaccount;?></b></div>
                        
<p style="margin-top:15px;"><span class="encerrar"><input type="image"  name="submitimage" value="Close" src="imagens/encerrar.gif" width="104" height="53" onmouseout="this.style.margin='0 0 0 0'" onmouseover="this.style.margin='-26px 0 0 0'" /><input type="hidden" name="submit" value="submit" /></span></p>
				</form>				
				</div>
		</div>
<?
	include("footer.php");
?>		
</body>
</html>
