<?php
   include_once("admin.config.inc.php");
  $default=$_REQUEST['default'];  
?>
<HTML>
<HEAD>
<TITLE>Bem vindo ao <?php echo $ADMIN_MAIN_SITE_NAME ?></TITLE>
<META http-equiv=Content-Type content="text/html; charset=<?=$lng_characset;?>">

</HEAD>
<FRAMESET rows="76,*" border="0" framespacing="0" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
	<FRAME border="0" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" src="framehead.php?active=<? echo urlencode("Configura&ccedil;&otilde;es");?>" resizeable="no" scrolling="no" frameborder="no" name="header">
	<FRAMESET border="0" framespacing="1" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" frameborder="1" bordercolor="#CCCCCC" cols="202,*">
		<FRAME border="0" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" src="leftsetting.php" scrolling="auto" frameborder="0" name="menu">
		<FRAME border="0" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" src="<? if($default){ echo $default;} else { ?>defaultsetting.php<? } ?>" scrolling="auto" frameborder="0" name="body">
	</FRAMESET>
</FRAMESET>
<NOFRAMES>
		<body bgcolor="#FFFFFF">Your browser must support frames to view this program.</body></NOFRAMES></HTML>