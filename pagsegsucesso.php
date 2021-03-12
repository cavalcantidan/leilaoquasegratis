<?
    $agora = Date("Y-m-d H:i:s") ;
	include_once("config/connect.php");
    include_once("functions.php");
	include_once("session.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?=$lng_characset;?>" />
    <title><?=$AllPageTitle;?></title>
    <link href="css/style_youbid.css" rel="stylesheet" type="text/css" />
    <link href="css/estilo.css" rel="stylesheet" type="text/css" />

</head>
<body>

<div id="conteudo-principal">
    <?
       include("header.php");
       include("leftside.php");  
  
    ?>
    <div id="conteudo-conta">
            <h3 id="comprar-tit"> <?=$lng_tabbuybids;//$lng_myauctionsavenue;?></h3>
            <br /><br /><br />
            <h3>Obrigado por efetuar a compra. Continue aproveitando nosso site.</h3>
 
    </div>
<? include("footer.php"); ?>
</div>
</body>
</html>