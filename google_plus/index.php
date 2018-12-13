<?php
require_once ('../core/init.php');
require_once ('libraries/Google/autoload.php');

$gappid = $general->get_option("gappid");
$gkey = $general->get_option("gkey");
$greurl = $general->get_option("greurl");

//Insert your cient ID and secret 
//You can get it from : https://console.developers.google.com/
$client_id = $gappid;
$client_secret = $gkey;
$redirect_uri = $greurl;


//incase of logout request, just unset the session var
if (isset($logout)) {
  unset($_SESSION['access_token']);
}

/************************************************
  Make an API request on behalf of a user. In
  this case we need to have a valid OAuth 2.0
  token for the user, so we need to send them
  through a login flow. To do this we need some
  information from our API console project.
 ************************************************/
$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope("email");
$client->addScope("profile");

//$client->setScopes(array("https://www.googleapis.com/auth/plus.me https://www.googleapis.com/auth/moderator"));
//$client->setScopes(array("https://www.googleapis.com/auth/plus.profile.emails.read"));

//https://www.googleapis.com/auth/plus.profile.emails.read https://www.googleapis.com/auth/userinfo.email //https://www.googleapis.com/auth/plus.profile.emails.read https://www.googleapis.com/auth/userinfo.profile

/************************************************
  When we create the service here, we pass the
  client to it. The client then queries the service
  for the required scopes, and uses that when
  generating the authentication URL later.
 ************************************************/
$service = new Google_Service_Oauth2($client);

/************************************************
  If we have a code back from the OAuth 2.0 flow,
  we need to exchange that with the authenticate()
  function. We store the resultant access token
  bundle in the session, and redirect to ourself.
*/
  
if (isset($code)) {
  $client->authenticate($code);
  $_SESSION['access_token'] = $client->getAccessToken();
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
  //exit;
}

/************************************************
  If we have an access token, we can make
  requests, else we generate an authentication URL.
 ************************************************/
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
} else {
  $authUrl = $client->createAuthUrl();
}


//Display user info or display login url as per the info we have.
if (isset($authUrl)){
	$extra->redirect_to($authUrl);
}
else {
	$user = $service->userinfo->get(); //get user info 
	$g_name = $user->name;
	$g_email = $user->email;	
	$date = date('Y-m-d H:i:s');
	
	//check if user exist in database using COUNT
	$db->query("select * from register where email=:email");
	$db->bind(":email", $g_email);
	$exist_email = $db->rowCount();
	
	if($exist_email==0){
		$password = base64_encode(rand(0,9999));
		//$ori_passwd = base64_decode($password);
		$db->query("insert into register set firstname='$g_name',email='$g_email',password='$password',user_type='0',active_status='1',email_active_status='1',reg_ip_addr='$ip_addr',crcdt='$date'");
		$db->execute();
		$insert_id = $db->lastInsertId();
		$_SESSION['eqty_userid'] = $insert_id;
		$_SESSION['eqty_mail'] = $g_email;
		
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
}
?>