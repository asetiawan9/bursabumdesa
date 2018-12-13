<?php
require "../core/init.php";

$_SESSION['isLgd']=false;
$extra->redirect_to($baseUrl."login/");
?>