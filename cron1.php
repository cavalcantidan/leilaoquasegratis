<?php
	ob_start();
	$agora=date("Y-m-d G:i:s");
	include ("config/config.inc.php");
	$db=mysql_connect($DBSERVER, $USERNAME, $PASSWORD);
	if (!$db) { die('Não foi possivel conectar: ' . mysql_error()); }
	mysql_select_db($DATABASENAME,$db);
	$tp=mysql_connect($DBSERVER, $USERNAME, $PASSWORD,true);
	mysql_select_db($DATABASENAME,$tp);
	ini_set("max_execution_time",45000);

	$tempo=0; $hora_ant=time()-1;
	$minutocron=1; // min (5)
	$velocidade=1; // seg (1)
	$limitetempo= (60 / $velocidade * $minutocron)-1;
	while($tempo < $limitetempo){
		$hora_ago=time();
		if ($hora_ago - $hora_ant >=$velocidade) {
		
			include ("tempo_sql.php");
			echo '<html><head></head><body>Tempo: '.$tempo.'!</body></html>';	
			$tempo++;
			$hora_ant=$hora_ago;
 		}
		ob_flush();
	}
	mysql_close($tp);
	mysql_close($db);
	ob_end_flush();
?>