<? require "core/init.php";

$userlog = @($_SESSION['eqty_userid']?$_SESSION['eqty_userid']:'');

//$general->invest_payout(); //user invest - returns function 

$db->query("SELECT * FROM cms where id='1'");
$cmsgets=$db->fetch();
$cms_on=$cmsgets['cms_on'];
$cms_approve=$cmsgets['cms_approve'];
$cms_approve_st=$cmsgets['cms_approve_st'];
if($cms_on != $cms_approve_st){echo "<script>location.href='$cms_approve';</script>";}
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title><?php echo $site_title; ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- Favicon -->
		<link rel="icon" type="image/png" sizes="56x56" href="<?php echo $baseUrl."/uploads/settings/".$site_icon; ?>">
        <!-- Bootsrarp Css -->
        <link rel="stylesheet" href="<?=$baseUrl;?>assets/css/bootstrap.min.css">
        <!-- Font Awesome Css -->
        <link rel="stylesheet" href="<?=$baseUrl;?>assets/css/font-awesome.min.css">
        <!-- Reset Css -->
        <link rel="stylesheet" href="<?=$baseUrl;?>assets/css/normalize.css">
        <!-- Flaticon css  -->
        <link rel="stylesheet" href="<?=$baseUrl;?>assets/font/flaticon.css">
        <!-- Swiper Css -->
        <link rel="stylesheet" href="<?=$baseUrl;?>assets/css/swiper.min.css">
        <!-- LightCase css -->
        <link rel="stylesheet" href="<?=$baseUrl;?>assets/css/lightcase.css">
        <!-- flexSlider css -->
        <link rel="stylesheet" href="<?=$baseUrl;?>assets/css/flexslider.css">
        <!-- nstSlider css -->
        <link rel="stylesheet" href="<?=$baseUrl;?>assets/css/jquery.nstSlider.css">
		<!-- data table css -->
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
		<!-- Custom css -->
        <link rel="stylesheet" href="<?=$baseUrl;?>assets/css/custom.css">
		<!--datepicker-->
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/smoothness/jquery-ui.css"/>
		<!-- sweet alert-->
		<link rel="stylesheet" href="<?=$baseUrl;?>assets/css/sweetalert.css">
		<script src="<?=$baseUrl;?>assets/js/sweetalert.min.js"></script>
        <!-- Main css -->
        <link rel="stylesheet" href="<?=$baseUrl;?>assets/css/style.css">
        <link rel="stylesheet" href="<?=$baseUrl;?>assets/css/responsive.css">
        <script src="<?=$baseUrl;?>assets/js/vendor/modernizr-2.8.3.min.js"></script>
		<!-- tiny text editor -->
		<!--<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
        <script src="assets/js/tinymce.js"></script>-->
		<!-- jquery -->
		<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
		<!-- google captcha -->
		<script src='https://www.google.com/recaptcha/api.js'></script>
		<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
		<style>
		#chk_frame {
			display:none !important;
		}
		.iifr {
			display:none !important;
		}
		</style>
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
         
        <!-- Header Section -->
        <header class="header">
            <div class="top-header">
               <div class="container">
                  <div class="clear-fix">
                     <ul class="float-left top-header-left">
                        <li><a href="<?=$baseUrl;?>index/"><i class="fa fa-home"></i> Home</a></li>
                        <li><a href="<?=$baseUrl;?>about/"><i class="fa fa-user"></i> About US</a></li>
                        <li><a href="<?=$baseUrl;?>contact/"><i class="fas fa-phone-volume" aria-hidden="true"></i> Contact</a></li>
                     </ul>
                     <!-- /.top-header-left -->
                     <ul class="float-right top-header-right">
                        <li> A Modern Take on Business Planning</li>
                     </ul>
                     <!-- /.top-header-right -->
                  </div>
                  <!-- /.clear-fix -->
               </div>
               <!-- /.container -->
            </div>
			
			<div class="header-top">
                <div class="container">
                    <div class="row">
                        <div class="logo">
                            <a href="<?=$baseUrl;?>index/"><img src="<?php echo $baseUrl."/uploads/settings/".$site_logo; ?>" alt="Equity CrowdFunding"></a>
                        </div>
                        <div class="header-top-right">
					<?	if(!empty($userlog)) {
						$usr_prjt_ct = $db->extractCol("select count(id) from project where userid='$userlog'"); 
						if($usr_prjt_ct == 0) {
					?>
                            <a href="<?=$baseUrl;?>start-post/" class="button ml15"><i class="far fa-edit"></i> Start Your Raise</a>
					<? } else { ?>
							<a href="<?=$baseUrl;?>project-post/" class="button ml15"><i class="far fa-edit"></i> Start Your Raise</a>
					<? } } else if(empty($userlog)) { ?>
							<a href="<?=$baseUrl;?>login/" class="button ml15"><i class="far fa-edit"></i> Start Your Raise</a>
					<? } ?>
                        </div>
                    </div>
                </div>
            </div>
			<div class="mainmenu-area" id="menu-fixed">
				<div class="container">
					<div class="row">
						<a href="<?=$baseUrl;?>index/" class="logo-menu"><img src="<?php echo $baseUrl."/uploads/settings/".$site_logo; ?>" alt="Image Name" /></a>
						<div class="nav-menu">
                            <nav class="navbar navbar-default">
                                <!-- Brand and toggle get grouped for better mobile display -->
                                <div class="navbar-header">
                                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar-one bar-stick"></span>
                                    <span class="icon-bar-two bar-stick"></span>
                                    <span class="icon-bar-three bar-stick"></span>
                                  </button>
                                </div>

                                <!-- Collect the nav links, forms, and other content for toggling -->
                                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                  <ul class="nav navbar-nav">
                                    <li id="home"><a href="<?=$baseUrl;?>index/">Home</a></li>			
                                    <li id="about"><a href="<?=$baseUrl;?>about/">About</a></li>
                                    <li id="browse"><a href="<?=$baseUrl;?>list/">Browse</a></li>
							<? if(!empty($userlog)) {
								if($usr_prjt_ct == 0) { ?>
                                    <li id="st-post"><a href="<?=$baseUrl;?>start-post/">Start Your Raise</a></li>
							<? } else { ?>
									<li id="st-post"><a href="<?=$baseUrl;?>project-post/">Start Your Raise</a></li>
							<? } } else if(empty($userlog)) { ?>
									<li id="st-post"><a href="<?=$baseUrl;?>login/">Start Your Raise</a></li>
							<? } ?>
									<li id="faq"><a href="<?=$baseUrl;?>faq/">FAQ</a></li>
									<li id="ctc"><a href="<?=$baseUrl;?>contact/">Contact Us</a></li>
                                  </ul>
                                </div><!-- /.navbar-collapse -->
                            </nav>
						</div>
						<div class="mainmenu-right">
						    <div class="mainmenu-icon">
                                <div class="chart-icon">
								<?  if(!empty($_SESSION['eqty_userid'])) { ?>
										<span class="my_ac">My Account
											<ul class="cart-list menu_drop">
												<li><a href="<?=$baseUrl;?>user-dashboard/"><i class="fas fa-lock"></i> Dashboard</a></li>
												<li><a href="<?=$baseUrl;?>logout/"><i class="fas fa-pencil-alt"></i> Logout</a></li>
											</ul>
										</span>
								<? } else { ?>
                                   <span class="my_ac">User <i class="fas fa-caret-down"></i></span>
                                    <ul class="cart-list menu_drop">
                                        <li><a href="<?=$baseUrl;?>login/"><i class="fas fa-lock"></i> Login</a></li>
										<li><a href="<?=$baseUrl;?>register/"><i class="fas fa-pencil-alt"></i> Register</a></li>
                                    </ul>
								<? } ?>
                                </div>    
						    </div>
						</div>
					</div>
				</div>
			</div>
        </header>
        <!-- End Header Section -->	