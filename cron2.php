<?php
	//ob_start();
 	$agora=date("Y-m-d G:i:s");
    include ("config/config.inc.php");
    $db=mysql_connect($DBSERVER, $USERNAME, $PASSWORD);
    if (!$db) { die('Não foi possivel conectar: ' . mysql_error()); }
    mysql_select_db($DATABASENAME,$db);
    $tp=mysql_connect($DBSERVER, $USERNAME, $PASSWORD,true);
    mysql_select_db($DATABASENAME,$tp);
    ini_set("max_execution_time",45000);

    include ("tempo_sql.php");
    
    mysql_close($tp);
    mysql_close($db);
	//ob_end_flush();
?>
<html><head><meta http-equiv="refresh" content="1" /></head><body>Terminado!</body></html>