<? require "core/init.php";
	
if(isset($old_pass) && isset($uid)) {
	$db_pass = $db->extractCol("select password from register where id='$uid'");	
	if($old_pass != $db_pass)
		echo 1;
	else
		echo 0;
}
?>