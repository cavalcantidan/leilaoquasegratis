<?php
	include("config/connect.php");
	include("functions.php");
	$staticvar = "jobs";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
	    <meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
	    <title><?=$AllPageTitle;?></title>
	    <link href="css/style_youbid.css" rel="stylesheet" type="text/css" />
	    <link href="css/menu.css" rel="stylesheet" type="text/css" />
	    <script language="javascript" type="text/javascript" src="js/function.js"></script>
    </head>
    <body>
		<div id="conteudo-principal">
			<?php include("header.php"); ?>   
			<h3 id="conta-tit"><?=$lng_aucavejobs;?></h3>
			<?php include("leftstatic.php"); ?>	
			<div id="conteudo-conta">
				<h4 class="como-titulo"><?=$lng_jobs;?></h4>
				<?php 
					$qrysel = "select *,".$lng_prefix."content as content from static_pages where id='5'";
					$rssel = mysql_query($qrysel);
					$obj = mysql_fetch_object($rssel);
					echo stripslashes($obj->content);
				?>
			</div>
		</div>
		<?php include("footer.php"); ?>		
	</body>
</html>