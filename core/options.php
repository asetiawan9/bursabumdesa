<?php
$dir=__DIR__;
foreach (glob("$dir/classes/*.php") as $filename) {
    require_once $filename;
	$explode=explode("/", $filename);
	$class=substr(end($explode),0,-4);
	$$class=new $class();
}
$baseUrl=$extra->baseUrl();
$curFilename=basename($_SERVER['SCRIPT_NAME']);
$timestamp=date("Y-m-d H:i:s");
$ip=$_SERVER['REMOTE_ADDR'];
$ua=$_SERVER['HTTP_USER_AGENT'];
$ip_addr = $extra->ipAddress();
$tday = date("Y-m-d");
$demo = 0;
/** list of options configured **/
$db->query("select * from options");
$opts=$db->fetchAll();
foreach($opts as $opt) {
	$$opt['option_name']=$opt['option_value'];
}

/** assign get and post values as variable **/
while(list($key,$val)=@each($_POST)){
	$$key=$val;
}
while(list($key,$val)=@each($_GET)){
    $$key=$val;
}

//google capchakey details
$captchasitekey = "6Ld5qCYTAAAAAIgd-nrbWgRXloSaTDKquFFIgWhb";
$captchasecretkey = "6Ld5qCYTAAAAAAd-ZRDK0qGa2cbzGHo1xdvISbbf";
?>