<?
	include("config/connect.php");
	include("functions.php");
	$staticvar = "privacy";
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
</head>


<body>
<div id="conteudo-principal">
<?
	include("header.php");
?>
<h3 id="conta-tit"><?=$lng_aucaveprivacy;?></h3>
			<?
				include("leftstatic.php");
			?>	
<div id="conteudo-conta">
				<h4 class="como-titulo"><?=$lng_privacy;?></h4>
				<? 
				$qrysel = "select *,".$lng_prefix."content as content from static_pages where id='4'";
				$rssel = mysql_query($qrysel);
				$obj = mysql_fetch_object($rssel);
				?>
				<?=stripslashes($obj->content);?>
				</div>
			</div>
<?
	include("footer.php");
?>		
</body>
</html>
