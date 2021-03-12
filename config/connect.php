<?php
    include_once("config.inc.php");

    include_once("language/english.php");

    $db=mysql_connect($DBSERVER, $USERNAME, $PASSWORD);
    if (!$db) {die('N&atilde;o foi possivel conectar: ' . mysql_error());}
    mysql_select_db($DATABASENAME,$db);
?>