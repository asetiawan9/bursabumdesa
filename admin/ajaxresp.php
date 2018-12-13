<?php
require "../core/init.php";

if(isset($admcurPass)) {
	if($user->pass_vfy($admcurPass, $admin_password)) { $response=array("valid"=>true); }
	else { $response=array("valid"=>false, "message"=>"Current password is incorrect"); }
	echo json_encode($response);
}
?>