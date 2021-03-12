<?php
@session_start();
date_default_timezone_set("America/Sao_Paulo");

$DBSERVER ="ec2-54-162-119-125.compute-1.amazonaws.com";  //servidor "localhost"
    $USERNAME = "crwcxvygkbhmwc";  // usuario .."root"
    $PASSWORD = "8a9e977c59af500429c8914b26d5952629b5ef0a16d41a97dc667bc15e695b15";  //senha
    $DATABASENAME = "deknapmv354jqd";  //banco de dados
$adminemailadd = "webmaster <dancavalcanti.bjj@gmail.com>"; 
$SITE_URL = "https://www.leilaoquasegratis.com/admin";

define("DIR_WS_IMAGES",'images/');
define("DIR_WS_ICONS",DIR_WS_IMAGES.'icons/');
define("DIR_WS_BANNERS",DIR_WS_IMAGES.'banners/');
define("DIR_WS_CATEGORIES",DIR_WS_IMAGES.'categories/');
define("DIR_WS_PRODUCTS",DIR_WS_IMAGES.'products/');
define("DIR_WS_MANUFACTURERS",DIR_WS_IMAGES.'manufacturers/');
	
$DIR_WS_IMAGES="images/";
$DIR_WS_ICONS="images/icons/";

$PRODUCTSPERPAGE = 10;

$Currency = "R$ ";
$minbiddingprice = "1.00";

?>