<?php
include("../core/init.php");

$fbappid = $general->get_option("fbappid");
$fbkey = $general->get_option("fbkey");
$fbreurl = $general->get_option("fbreurl");

define('APP_ID',$fbappid);
define('APP_SECRET',$fbkey);
define('REDIRECT_URL',$fbreurl);

require_once('lib/Facebook/FacebookSession.php');
require_once('lib/Facebook/FacebookRequest.php');
require_once('lib/Facebook/FacebookResponse.php');
require_once('lib/Facebook/FacebookSDKException.php');
require_once('lib/Facebook/FacebookRequestException.php');
require_once('lib/Facebook/FacebookRedirectLoginHelper.php');
require_once('lib/Facebook/FacebookAuthorizationException.php');
require_once('lib/Facebook/FacebookAuthorizationException.php');
require_once('lib/Facebook/GraphObject.php');
require_once('lib/Facebook/GraphUser.php');
require_once('lib/Facebook/GraphSessionInfo.php');
require_once('lib/Facebook/Entities/AccessToken.php');
require_once('lib/Facebook/HttpClients/FacebookCurl.php');
require_once('lib/Facebook/HttpClients/FacebookHttpable.php');
require_once('lib/Facebook/HttpClients/FacebookCurlHttpClient.php');

//USING NAMESPACES
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\GraphUser;
use Facebook\GraphSessionInfo;
use Facebook\HttpClients\FacebookHttpable;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookCurl;

FacebookSession::setDefaultApplication(APP_ID,APP_SECRET);
$helper = new FacebookRedirectLoginHelper(REDIRECT_URL);
$sess = $helper->getSessionFromRedirect();

if(isset($error)) {
	$extra->redirect_to($baseUrl.'login/');
}
if(isset($sess)){
	$request  = new FacebookRequest($sess, 'GET', '/me?fields=first_name,last_name,email');
	//fields=name,first_name,last_name,email,link,gender,locale,picture
	$response = $request->execute();
	$graph = $response->getGraphObject(GraphUser::className());
	$fb_fname = $graph->getFirstName();
	$fb_lname = $graph->getLastName();
	$fb_email= $graph->getEmail();	
	$date = date('Y-m-d H:i:s');
	
	$db->query("select * from register where email=:email");
	$db->bind(":email", $fb_email);
	$exist_email = $db->rowCount();
	
	if($exist_email==0){
		$password = base64_encode(rand(0,9999));
		//$ori_passwd = base64_decode($password);
		$db->query("insert into register set firstname='$fb_fname',lastname='$fb_lname',email='$fb_email',password='$password',user_type='0',active_status='1',email_active_status='1',reg_ip_addr='$ip_addr',crcdt='$date'");
		$db->execute();
		$insert_id = $db->lastInsertId();
		$_SESSION['eqty_userid'] = $insert_id;
		$_SESSION['eqty_mail'] = $fb_email;
		
		$extra->redirect_to(dirname($baseUrl).'/user-profile/');	
	}
	else if($exist_email>0){
		$query = $db->fetch();
		$userid = $query['id'];
		$email = $query['email'];
		
		$_SESSION['eqty_userid'] = $userid;
		$_SESSION['eqty_mail'] = $email;
		
		$extra->redirect_to(dirname($baseUrl).'/user-profile/');
	}
}else{
	$url = $helper->getLoginUrl(array('scope' => 'email'));
	$extra->redirect_to($url);
}