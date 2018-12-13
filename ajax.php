<?php
require "core/init.php"; 

if(!empty($listid) && !empty($usrid)) {
	$db->query("select * from follow where user_id=:user_id and prjt_id=:prjt_id");
	$db->bind(":user_id", $usrid);
	$db->bind(":prjt_id", $listid);
	$exist_rec = $db->rowCount();
	if($exist_rec == 0) {
		$set="user_id=:user_id";
		$set.=",prjt_id=:prjt_id";
		$set.=",ip='$ip'";
		
		$que="insert into follow set $set";
		$db->query($que);
		$db->bind(":user_id", $usrid);
		$db->bind(":prjt_id", $listid);
		$exec = $db->execute();
		if($exec) echo 0;
	}
	else if($exist_rec == 1) {
		$db->query("delete from follow where user_id=:user_id and prjt_id=:prjt_id");
		$db->bind(":user_id", $usrid);
		$db->bind(":prjt_id", $listid);
		$exec = $db->execute();
		if($exec) echo 1;
	}
}
?>			