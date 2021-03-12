<?
	include("config/connect.php");
	include("functions.php");
    $head_tag = '<link href="css/menu.css" rel="stylesheet" type="text/css" />
    <link href="css/style_youbid.css" rel="stylesheet" type="text/css" />
    <link href="css/estilo.css" rel="stylesheet" type="text/css" />'; 
	$staticvar = "howit";
?>

<script language="javascript" type="text/javascript" src="js/function.js"></script>

<?
	include("header.php");
?>
<div id="conteudo-principal">
			<?
				include("leftstatic.php");
			?>	
    <div id="conteudo-conta">
        <h4 class="como-titulo"><span><?=$lng_howitwork;?></span></h4>
				<?
					$qrysel = "select *,".$lng_prefix."content as content from static_pages where id='7'";
					$rssel = mysql_query($qrysel);
					$obj = mysql_fetch_object($rssel);
				?>
				<?=$obj->content;?>

	</div>
</div>
<?
	include("footer.php");
?>