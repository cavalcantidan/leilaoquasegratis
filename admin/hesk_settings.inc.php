<?php
/*******************************************************************************
*  Title: Helpdesk software Hesk
*  Version: 0.94.1 @ October 25, 2007
*  Author: Klemen Stirn
*  Website: http://www.phpjunkyard.com
********************************************************************************
*  COPYRIGHT NOTICE
*  Copyright 2005-2007 Klemen Stirn. All Rights Reserved.
*
*  This script may be used and modified free of charge by anyone
*  AS LONG AS COPYRIGHT NOTICES AND ALL THE COMMENTS REMAIN INTACT.
*  By using this code you agree to indemnify Klemen Stirn from any
*  liability that might arise from it's use.
*
*  Selling the code for this program, in part or full, without prior
*  written consent is expressly forbidden.
*
*  Obtain permission before redistributing this software over the Internet
*  or in any other medium. In all cases copyright and header must remain
*  intact. This Copyright is in full effect in any country that has
*  International Trade Agreements with the United States of America or
*  with the European Union.
*
*  Removing any of the copyright notices without purchasing a license
*  is illegal! To remove PHPJunkyard copyright notice you must purchase a
*  license for this script. For more information on how to obtain a license
*  please visit the site below:
*  http://www.phpjunkyard.com/copyright-removal.php
*******************************************************************************/

/* Website settings */
$hesk_settings['site_title']="My lovely website";
$hesk_settings['site_url']="http://localhost/jatin/helpdesk";

/* Contacts */
$hesk_settings['support_mail']="support@mywebsite.com";
$hesk_settings['webmaster_mail']="webmaster@mywebsite.com";
$hesk_settings['noreply_mail']="NOREPLY@mywebsite.com";

/* Help desk settings */
$hesk_settings['hesk_url']="http://localhost/jatin/helpdesk/hesk0941";
$hesk_settings['hesk_title']="My company support system";
$hesk_settings['server_path']="/websites/mitul/helpdesk/hesk0941";
$hesk_settings['language']="english";
$hesk_settings['max_listings']="15";
$hesk_settings['print_font_size']="12";
$hesk_settings['debug_mode']="0";
$hesk_settings['secimg_use']="1";
$hesk_settings['secimg_sum']="H29PEW9SQR";

/* File attachments */
$hesk_settings['attachments']=array (
    'use'           =>  1,
    'max_number'    =>  2,
    'max_size'      =>  1024, // kb
    'allowed_types' =>  array('.gif','.jpg','.jpeg','.zip','.rar','.csv','.doc','.txt','.pdf')
);

/* Custom fields */
$hesk_settings['use_custom']=0;
$hesk_settings['custom_place']=0;
$hesk_settings['custom_fields']=array (
    'custom1'  => array('use'=>0,'req'=>0,'name'=>'Custom field 1','maxlen'=>255),
    'custom2'  => array('use'=>0,'req'=>0,'name'=>'Custom field 2','maxlen'=>255),
    'custom3'  => array('use'=>0,'req'=>0,'name'=>'Custom field 3','maxlen'=>255),
    'custom4'  => array('use'=>0,'req'=>0,'name'=>'Custom field 4','maxlen'=>255),
    'custom5'  => array('use'=>0,'req'=>0,'name'=>'Custom field 5','maxlen'=>255)
);

/* Database settings */
$hesk_settings['database_host']  =   "localhost";
$hesk_settings['database_name']  =   "mydatabase";
$hesk_settings['database_user']  =   "database_user";
$hesk_settings['database_pass']  =   "password";
#############################
#     DO NOT EDIT BELOW     #
#############################
$hesk_settings['hesk_version']='0.94';
if ($hesk_settings['debug_mode']) {
    error_reporting(E_ALL ^ E_NOTICE);
} else {
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
}
if (!defined('IN_SCRIPT')) {die('Invalid attempt!');}
if (is_dir('install') && !defined('INSTALL')) {die('Please delete the <b>install</b> folder from your server for security reasons then refresh this page!');}
?>
