<?php require "core/init.php"; 

//echo $_GET["amount"];exit;
$invid = $_SESSION["invid"];
$que = "update contribute set pay_status='1' where invest_id='$invid'";
$db->query($que);
$db->execute();	

$db->query("select prjt_id,contribute_amount from contribute where invest_id='$invid'");
$result = $db->fetch();
$cont_amt = $result['contribute_amount'];
$prjt_id = $result['prjt_id'];
$get_ctamt = $db->extractCol("select contribute_amount from project where id='$prjt_id'");
$tot_ctamt = $get_ctamt + $cont_amt;
$que = "update project set contribute_amount='$tot_ctamt' where id='$prjt_id'";
$db->query($que);
$exec = $db->execute();
unset($_SESSION["invid"]);
if($exec) {
	$extra->redirect_to($baseUrl.'user-invest/?invsuc');
}
?>