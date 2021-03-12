<?php

/**
 * @author Sistemas Brasileiros
 * @copyright 2011
 */
//date_default_timezone_set("Brazil/East");
echo date("Y-m-d G:i:s")."<br>"; 
// mysql DATE_FORMAT(NOW(),'%T')
echo date("r");
echo "<br /><br />".date("l j F Y, G:i");

date_default_timezone_set("Brazil/East");
echo "<br /><br />".date("l j F Y, G:i");

?>