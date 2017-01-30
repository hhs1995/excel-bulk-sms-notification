<?php
	ini_set('display_errors', 0);
	if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();
	date_default_timezone_set('Asia/Kolkata');
	$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
	$HTTP_HOST = $_SERVER['HTTP_HOST'];
	define('ROOT', str_replace('\\', '/', dirname(__FILE__)));
	/*---------------- LIVE server ---------------------*/
	// define("ROOT_DIR",$DOCUMENT_ROOT."/assets/");
	// define("WWWROOT",'http://'. $HTTP_HOST . '/');
	
	/*---------------- LOCAL MACHINE server ---------------------*/
	define("ROOT_DIR",$DOCUMENT_ROOT."/bulk-sms/assets/");
	define("WWWROOT",'http://'. $HTTP_HOST . '/bulk-sms/');
	
	///////////////////////////////////////////////////////////////////////////////
	define("CSS", WWWROOT."assets/css/");
	define("JS", WWWROOT."assets/js/");
	define("IMAGES", WWWROOT."assets/images/");
	define("INC", ROOT."/includes/");
	define("CONTROLLER", ROOT."/controller/");
	define('MODEL', ROOT . '/model/');
	define("REDIRECT_URL", WWWROOT . 'logged.php');	
	define("TEMPLATES", WWWROOT."/assets/templates/");
	/*------------------ DB CONNECTION ---------------------*/
	define("DB_HOST", "localhost");
	define("DB_USER", "root");
	define("DB_PSSWD", "");
	define("DB_NAME", "test");
	
	$conn = mysql_connect(DB_HOST,DB_USER,DB_PSSWD);
	mysql_select_db(DB_NAME, $conn);

	/*------------------------------ SMS API KEY -------------------------------------*/
	define("SMS_API", "SMS API KEY");
	define("API_ACCESS_KEY", "GCM/FIREBASE API KEY");

	include ROOT.'/functions.php';	
?>
