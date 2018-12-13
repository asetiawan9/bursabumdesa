<?
 require "../core/init.php";
$get_val = addslashes($_REQUEST['get_val']);
$get_val = str_replace("www.","",$get_val);
$getva = $get_val;
$getval = md5($getva);
$GetRec = $db->extractCol("select cms_on from cms where id='1'");

if($GetRec != $getval){
$data = base64_encode($getval);

$db->query("update cms set cms_approve_st='$data',cms_approve ='$getval' where id='1'");
$db->execute();
}
?>