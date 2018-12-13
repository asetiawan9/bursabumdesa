<?php
require "core/init.php"; 
if(!empty($_SESSION['eqty_userid'])) {
	$userid = $_SESSION['eqty_userid'];
	$ip=$ip_addr;
	$db->query("update register set logout_ip_addr='$ip' where id='$userid'");	
	$db->execute();
	session_destroy();
	
	$extra->redirect_to($baseUrl.'login/'); 
}
	
/* else if(isset($_COOKIE['mail']) || !empty($_COOKIE['mail']))
	{
	   $email=$_COOKIE['mail'];
	   @setcookie ("mail",$email,strtotime( '-3 days' ),"/refer-to-earn/");
	}
if(isset($_REQUEST['pass'])) 
	{
	$reurl=$baseUrl."logerr";
	$extra->redirect_to($reurl); 
	}
else 
	{ 
	$extra->redirect_to($baseUrl); 
	} */
?>
