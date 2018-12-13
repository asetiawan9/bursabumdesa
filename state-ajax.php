<?php 
require "core/init.php";

$state = "<option value=''>Select State</option>";
$DropDownQry = "select state_id,state_name from state where state_status='1' and state_country_id='$state_id' order by state_name asc";
$state .= $drop->dropselectSingle($DropDownQry,NULL);
echo $state;
?>