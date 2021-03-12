<?php
  include ("config.inc.php");
  $db=mysql_connect($DBSERVER, $USERNAME, $PASSWORD);
  if (!$db) 
  {
   die('Could not connect: ' . mysql_error());
  }

  mysql_select_db($DATABASENAME,$db);
?>