<?php
ob_start();
//session_save_path("/home/thavasu/tmp");
//session_save_path(dirname(dirname(__FILE__))."/tmp");
//ini_set('session.gc_probability',1);
date_default_timezone_set('Asia/Kolkata');
session_start();

/** load required files **/
require "database.php";
require "resize.php";
require "mailer/PHPMailerAutoload.php";

/** database configuration **/
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "bursabumdesa.com");
$db=new database();

/** options loader **/
require "options.php";

/** pagination **/
require "pagination.php";

/** custom-get current page **/
$livepage = $_SERVER["PHP_SELF"];
$livepage = substr(strrchr($livepage,'/'), 1);
?>