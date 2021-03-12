<?php
  include_once("admin.config.inc.php");
?>

<HTML>
<HEAD>
<TITLE>Bem vindo ao gerenciador do site <?php echo $ADMIN_MAIN_SITE_NAME ?></TITLE>
<META http-equiv=Content-Type content="text/html; charset=<?=$lng_characset;?>">

</HEAD>
<FRAMESET rows="76,*" border="0" framespacing="0" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
	<FRAME border="0" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" src="framehead.php?active=Menu Geral" resizeable="no" scrolling="no" frameborder="no" name="header">
	<FRAMESET border="0" framespacing="1" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" frameborder="1" bordercolor="#CCCCCC" cols="100%,*">
		<FRAME border="0" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" src="defaulthome.php" resizeable="no" scrolling="auto" frameborder="0" name="body">
	<frame src="UntitledFrame-1"></FRAMESET>
</FRAMESET>
<NOFRAMES>
		<body bgcolor="#FFFFFF">Seu navegador n&atilde;o suporta frames para visualizar este sistema.</body>
</NOFRAMES>
</HTML>