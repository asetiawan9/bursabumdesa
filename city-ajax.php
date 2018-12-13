<? require "core/init.php";

$city = "<option value=''>Select City</option>";
$DropDownQry = "SELECT city_id,city_name from city where city_state_id='$city_id' AND city_status='1' order by city_name asc";
$city .= $drop->dropselectSingle($DropDownQry,NULL);
echo $city;
?>