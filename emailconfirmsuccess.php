<?
	include("config/connect.php");
	include("functions.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
<title><?=$AllPageTitle;?></title>
<link href="css/style_youbid.css" rel="stylesheet" type="text/css" />
<link href="css/menu.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="js/function.js"></script>
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
</head>


<body>
<div id="main_div">
<?
	include("header.php");
?>
		<div id="middle_div">
		<div class="openAuction_bar_mainDIV">
			<div class="openAction_bar-left"></div>
			<div class="openAction_bar-middle"><div class="page_title_font"><?=$lng_regsuccess;?></div></div>
			<div class="openAction_bar-right"></div>
		 </div>
		 <div class="openAuction_bar_mainDIV2">
		 	<div style="height: 20px;">&nbsp;</div>
				<div class="normal_text" style="height: 300px;width: 930px;padding-left: 20px;">
					<div class="darkblue-text-17-b" style="margin-left: 10px; margin-top: 15px; padding-right: 5px;" align="center"><?=$lng_regcongratulat;?></div>
					<div class="normal_text" align="center" style="margin-left: 10px; margin-top: 15px; padding-right: 5px;"><?=$lng_yourregsuccess;?></div>
					<div style="height: 20px; clear:both">&nbsp;</div>
				</div>
		 </div>
		 <div class="openAuction_bar_bottom">
		 	<div class="openAuction_leftcorner"></div>
			<div class="openAuction_bar_middle"></div>
		 	<div class="openAuction_rightcorner"></div>
		 </div>
		</div>
<?
	include("footer.php");
?>		
</div>
</body>
</html>
