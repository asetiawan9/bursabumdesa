<?php
require "../core/init.php";
$response = array(
  'valid' => false,
  'message' => 'Missing Email'
);
if(isset($email))
	{
		$exist_email=$db->query("select * from register where email=:email");
		$email=$db->bind(":email", $email);
		$exist_email=$db->rowCount();
		if ($exist_email == 1) 
			{ 
				$response = array('valid' => false, 'message' => 'This mail-id is already registered.');
			} 
		else
			{
				$response = array('valid' => true);
			}
			echo json_encode($response);
    } ?>
