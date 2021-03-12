<?
	include("config/connect.php");
	include("session.php");
	include("functions.php");
	include("sendmail.php");

	$uid = $_SESSION["userid"];
	
	if($_POST["subscribesubmit"]!="")
	{
		if($_POST["subemail"]=="")
		{
			$msg=3;
		}
		else
		{
		$qryupd = "update registration set newsletter_email='".$_POST["subemail"]."', newslatter='1' where id='$uid'";
		mysql_query($qryupd) or die(mysql_error());

		$emailcont1 = sprintf("%s",$lng_emailcontent_newsletter);
		
		$email = $_POST["subemail"];
		$subject=$lng_mailnewslettersubject;
		$from=$adminemailadd;
		
		SendHTMLMail($email,$subject,$emailcont1,$from);
		header("location: newsletter.html?msg=1");
	}
}

	if($_POST["unsubscribesubmit"]!="")
	{
		if($_POST["unsubemail"]=="")
		{
			$msg=4;
		}
		else
		{
		
			$qrysel = "select * from registration where newsletter_email='".$_POST["unsubemail"]."'";
			$ressel = mysql_query($qrysel);
			$total = mysql_num_rows($ressel);
		
			if($total==0)
			{
				$msg = 5;
			}
			else
			{
			$qryupd = "update registration set newsletter_email='', newslatter='0' where id='$uid'";
			mysql_query($qryupd) or die(mysql_error());
			header("location: newsletter.html?msg=2");
			}
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
function Check()
{
	if(document.newsletter.subemail.value!="")
	{
		if(!validate_email(document.newsletter.subemail.value,"<?=$lng_entervalidemail;?>"))
			{
				document.newsletter.subemail.focus();
				return false;
			}
	}
}

function Check1()
{
	if(document.newsletter1.unsubemail.value!="")
	{
		if(!validate_email(document.newsletter1.unsubemail.value,"<?=$lng_entervalidemail;?>"))
		{
			document.newsletter1.unsubemail.focus();
			return false;
		}
	}
}

function validate_email(field,alerttxt){
	with (field){
		var value;
		value = field;
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
			<? include("leftside.php"); ?>
<div id="conteudo-conta">
<h3 id="conta-tit"><?=$lng_myauctionsavenue;?> - <?=$lng_accnewsletter;?></h3>

						<? 
							if($_GET["msg"]!="")
							{
								if($_GET["msg"]==1)
								{
						?>
<h4 style="font-size:16px; margin-bottom:20px; font-weight:bold"><?=$lng_thankyounewslet;?></h4>
<p style="margin-bottom:10px;"><?=$lng_funandgoodluck;?></p>
<p style="margin-bottom:10px;"><?=$lng_youraucaveteam;?></p>

						<?
								}
								elseif($_GET["msg"]==2)
								{
						?>
<h4 style="font-size:16px; margin-bottom:20px; font-weight:bold"><?=$lng_unsubscribenews;?></h4>
<p style="margin-bottom:10px;"><?=$lng_youraucaveteam;?></p>

						
						<?
								}
							}
							else
							{
								if($msg==3)
								{
						?>
<h4 style="font-size:16px; margin-bottom:20px; font-weight:bold"><?=$lng_plsentersubemail;?></h4>
						<?
								}
								elseif($msg==4)
								{
						?>
<h4 style="font-size:16px; margin-bottom:20px; font-weight:bold"><?=$lng_plsenterunsubemail;?></h4>
						<?
								}
								elseif($msg==5)
								{
						?>
<p style="color:#C00"><?=$lng_plscheckemailadd;?></p>
						<?
								}
						?>
<h4 style="font-size:16px; margin-bottom:20px; font-weight:bold"><?=$lng_wanttoknow;?></h4>
<p style="margin-bottom:10px;"><?=$lng_newslettersub;?></p>
<p style="margin-bottom:10px;"><?=$lng_youremailadd;?></p>
<form name="newsletter" action="" method="post" onsubmit="return Check();">				
<p><input type="text" name="subemail" class="campo1" size="50" maxlength="100" /></p>


<p style="margin-top:15px;"><span class="inscrevase"><input type="image"  name="subscribe" value="Subscribe" src="imagens/inscrevase.gif" width="84" height="53" onmouseout="this.style.margin='0 0 0 0'" onmouseover="this.style.margin='-26px 0 0 0'" /><input type="hidden" name="subscribesubmit" value="subscribesubmit" /></span></p>
</form>


<form name="newsletter1" action="" method="post" onsubmit="return Check1();">				
<h4 style="font-size:16px; margin-bottom:20px; margin-top:40px; font-weight:bold"><?=$lng_dontwanttoknow;?></h4>
<p style="margin-bottom:10px;"><?=$lng_newsletterunsub;?></p>
<p style="margin-bottom:10px;"><?=$lng_youremailadd;?></p>
							<div style="width: 435px;">
<p style="margin-bottom:10px;"><input type="text" name="unsubemail" class="campo1" size="50" maxlength="100" /></p>


<p style="margin-top:15px;"><span class="retire"><input type="image"  name="unsubscribe" value="Unsubscribe" src="imagens/retire-inscr.gif" width="104" height="53" onmouseout="this.style.margin='0 0 0 0'" onmouseover="this.style.margin='-26px 0 0 0'" /><input type="hidden" name="unsubscribesubmit" value="unsubscribesubmit" /></span></p>
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
