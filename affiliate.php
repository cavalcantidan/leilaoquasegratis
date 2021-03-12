<?
	include("config/connect.php");
	include("session.php");
	include("functions.php");
	include("sendmail.php");
	$uid = $_SESSION["userid"];

	if($_POST["submit"]!="")
	{
		$qrysel = "select * from registration where id='".$uid."'";
		$ressel = mysql_query($qrysel);
		$obj = mysql_fetch_object($ressel);
		
		$emailaddresses = $_POST["emailaddresses"];
		$email = split(',',$emailaddresses);
		$totalemail = count($email);
		
		for($i=0;$i<$totalemail;$i++)
		{
			$mailrecieved = $obj->firstname;
			$emailcont1 = sprintf($lng_emailcontent_affiliate,$mailrecieved,$uid);

			$subject=$lng_mailsubjectaffiliate;
			$to = $email[$i];
			$from = $adminemailadd;
			SendHTMLMail($to,$subject,$emailcont1,$from);
		}
	?>
		<script language="javascript" type="text/javascript">
			window.location.href='affiliate.html?sc=1';
		</script>
	<?
//		header("location: affiliate.html?sc=1");
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
	function Check()
	{
		if(document.affiliate.emailaddresses.value=="")
		{
			alert("<?=$lng_plsenteremailadd;?>");
			document.affiliate.emailaddresses.focus();
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
				<div class="titlebar">
<h3 class="historico-tit"><?=$lng_myauctionsavenue;?> - <?=$lng_accreferral;?></h3>
					<div class="rightbar"></div>
				</div>
				<div class="bodypart" style="text-align: left; min-height: 300px;">	
				<form name="affiliate" method="post" action="" onSubmit="return Check()">
						<div style="margin-top: 30px;">
							<div style="margin-left: 40px;">
						<? if($_GET["sc"]=="1"){ ?>
								<div class="greenfont" style="margin-left: 80px;"><?=$lng_invitationsent;?></div>
								<div style="height: 10px;"></div>
						<? } ?>
							
								<div style="margin-top: 5px; font-size: 14px; font-weight: bold;"><?=$lng_referralurl;?> &nbsp;&nbsp; <span style="color: #666666"><?=$SITE_URL;?>registration.html?ref=<?=$uid;?></span></div>
								<div class="normal_text" style="margin-top: 20px;"><?=$lng_referralmessage.$lng_separatecoma;?></div>
								<div style="margin-top: 5px;">
								<textarea name="emailaddresses" cols="50" rows="5" class="textboxclas"></textarea>
								</div>
								<div style="margin-top: 20px; margin-left: 100px;"><input type="image" src="<?=$lng_imagepath;?>send_btn.png" name="send" value="SEND" onMouseOut="this.src='<?=$lng_imagepath;?>send_btn.png'" onMouseOver="this.src='<?=$lng_imagepath;?>send_hover_btn.png'" /></div>
								<input type="hidden" name="submit" value="submit" />
							</div>	
						</div>
				</form>				
				</div>
			</div>
		</div>
<?
	include("footer.php");
?>		
</div>
</body>
</html>
