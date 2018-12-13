<?php
require "../core/init.php";
if(!$user->isLoggedAdmin()) $extra->redirect_to($baseUrl."login/");
$user->loggedStaffinfo();

?>
<!DOCTYPE html>
<html lang="en" data-textdirection="ltr" class="loading">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content=" ">
    <meta name="keywords" content=" ">
    <meta name="author" content="">
    <title><?php echo $site_title; ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo dirname($baseUrl)."/uploads/settings/".$site_icon; ?>">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>assets/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>assets/css/core/colors/palette-gradient.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>assets/fonts/feather/style.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>assets/fonts/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>assets/vendors/css/extensions/pace.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>assets/css/app.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>assets/css/core/menu/menu-types/vertical-menu-modern.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>assets/css/core/menu/menu-types/vertical-overlay-menu.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>assets/plugins/datatable/datatables.min.css">
	<!-- Custom css -->
    <link rel="stylesheet" href="<?=dirname($baseUrl); ?>/assets/css/custom.css">
	<!-- sweet alert-->
	<link rel="stylesheet" href="<?=dirname($baseUrl); ?>/assets/css/sweetalert.css">
	<script src="<?=dirname($baseUrl); ?>/assets/js/sweetalert.min.js"></script>
	<!-- jquery -->
	<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
	<!--datepicker-->
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/smoothness/jquery-ui.css"/>
	
	<style>
	.form-error {
		color:red
	}
	#chk_frame {
		display:none !important;
		}
	.iifr {
		display:none !important;
	}
	.abvbtn {
	  border-top: 1px solid #d3dce9;
	  padding: 20px 0;
	  margin-top: 20px;
	}
	</style>
</head>
<body data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" class="vertical-layout vertical-menu-modern 2-columns   menu-expanded fixed-navbar">
    <nav class="header-navbar navbar navbar-with-menu navbar-fixed-top navbar-semi-dark navbar-shadow">
        <div class="navbar-wrapper">
            <div class="navbar-header">
                <ul class="nav navbar-nav">
                    <li class="nav-item mobile-menu hidden-md-up float-xs-left"><a href="javascript:;" class="nav-link nav-menu-main menu-toggle hidden-xs"><i class="ft-menu font-large-1"></i></a></li>
                    <li class="nav-item"><a href="<?php echo $baseUrl; ?>"><img alt="<?php echo $site_title; ?>" src="<?php echo dirname($baseUrl)."/uploads/settings/".$site_logo; ?>" class="brand-logo" width="220px" style="padding:10px 5px;"></a></li>
                </ul>
            </div>
            <div class="navbar-container content container-fluid">
                <div id="navbar-mobile" class="collapse navbar-toggleable-sm">
                    <ul class="nav navbar-nav">
                        <li class="nav-item hidden-sm-down"><a href="javascript:;" class="nav-link nav-link-expand"><i class="ficon ft-maximize"></i></a></li>
                    </ul>
                    <ul class="nav navbar-nav float-xs-right">
                        <li class="dropdown dropdown-user nav-item"><a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle nav-link dropdown-user-link"><span class="abs_ico"><i class="fa fa-user-circle"></i></span><span class="abs_usr"><?php echo $user->Name; ?></span></a>
                            <div class="dropdown-menu dropdown-menu-right setdrop" style="">
                                <a href="<?php echo $baseUrl."setting/"; ?>" class="dropdown-item"><i class="fa fa-cogs"></i> Setting</a>
                                <a href="<?php echo $baseUrl."changepass/"; ?>" class="dropdown-item"><i class="fa fa-lock"></i> Change Password</a>
                                <div class="dropdown-divider"></div>
								<a href="<?php echo $baseUrl."logout/"; ?>" class="dropdown-item"><i class="ft-power"></i> Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
<?php require "leftmenu.php"; ?>