<?php
require "../core/init.php"; 

if(!empty($uid)) {
	$usr_email = $db->extractCol("select email from register where id='$uid'");
	$usr_phone = $db->extractCol("select phone from register where id='$uid'");
	
	$data = array(
            "email"     => $usr_email,
            "phone"  => $usr_phone
        );
	echo json_encode($data);
}
?>			