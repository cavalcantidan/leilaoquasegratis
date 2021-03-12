<?
	include("config/connect.php");
	include("session.php");
	include("functions.php");
	$uid = $_SESSION["userid"];
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
<title><?=$AllPageTitle;?></title>
<link href="css/style_youbid.css" rel="stylesheet" type="text/css" />
<link href="css/menu.css" rel="stylesheet" type="text/css" />
<!--[if lte IE 6]>
<link href="css/menu_ie.css" rel="stylesheet" type="text/css" />
<![endif]-->
<script language="javascript" type="text/javascript" src="js/function.js"></script>
</head>


<body>
<div id="main_div">
<?
	include("header.php");
?>
		<div id="middle_div">
			<? include("leftside.php"); ?>
			<div class="inner-container">
				<div class="titlebar">
					<div class="leftbar"></div>
					<div class="middlebar"><div class="page_title_font"><?=$lng_myauctionsavenue;?> - <?=$lng_buybidspayment;?></div></div>
					<div class="rightbar"></div>
				</div>
				<div class="bodypart">	
					<div class="normal_text" style="margin-top: 15px;" align="center"><?=$lng_sorrygoback;?></div>
					<br />		
					<br />		
					<div style="height: 20px; clear:both">&nbsp;</div>
				</div>
				<div class="bottomline">
					<div class="leftsidecorner"></div>
					<div class="middlecorner"></div>
					<div class="rightsidecorner"></div>
				</div>
			</div>
		</div>
<?
	include("footer.php");
?>		
</div>
</body>
</html>
