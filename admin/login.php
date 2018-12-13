<?php
require "../core/init.php";
if($user->isLoggedAdmin()) $extra->redirect_to($baseUrl);

/** process if the form has been submitted **/
if(isset($_POST['frmSubmit'])|| isset($_REQUEST['dlogin']))
{
if(isset($_REQUEST['dlogin'])){
$username = base64_decode(addslashes(ltrim($username)));
$password = base64_decode(addslashes(ltrim($password)));

$db->query("select id from staff where email=:username and password=:password and status='1'");
$db->bind(":username", $username);
$db->bind(":password", $user->pass_hash($password));
}else{
   	$db->query("select id from staff where email=:username and password=:password and status='1'");
	$db->bind(":username", $username);
	$db->bind(":password", $user->pass_hash($password)); 
}
 

	if($username==$admin_username && $user->pass_vfy($password, $admin_password)) {
		$_SESSION['isLgd']=true;
		if(isset($remember)) setcookie("lgdEmp", base64_encode("0"), time()+7*24*60*60*1000);
		else $_SESSION['lgdEmp']=base64_encode("0");
		$extra->redirect_to($baseUrl);
	}
	else {
	
		$result=$db->fetch();
		if(!empty($result)) {
			$_SESSION['isLgd']=true;
			if(isset($remember)) setcookie("lgdEmp", base64_encode($result['id']), time()+7*24*60*60*1000);
			else $_SESSION['lgdEmp']=base64_encode($result['id']);
			$extra->redirect_to($baseUrl);
		}
		else {
			$extra->setFormdata($_POST);
			$extra->setMsg("Incorrect login details!", "danger");
			$extra->redirect_to($baseUrl."login/");
		}
	}
}
$formdata=$extra->getFormdata();
if(!empty($formdata)) extract($formdata);
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
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>assets/fonts/feather/style.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>assets/fonts/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>assets/vendors/css/extensions/pace.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>assets/css/app.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>assets/css/core/menu/menu-types/vertical-menu-modern.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>assets/css/core/menu/menu-types/vertical-overlay-menu.css">
    <!--<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>assets/css/style.css">-->
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>assets/plugins/datatable/datatables.min.css">
	<style>.form-error{color:red}</style>
  </head>
<body data-open="click" data-menu="vertical-menu-modern" data-col="1-column" class="vertical-layout vertical-menu-modern 1-column   menu-expanded blank-page blank-page">
    <div class="app-content content container-fluid">
      <div class="content-wrapper">
        <div class="content-body">
		<section class="flexbox-container">
			<div class="col-md-4 offset-md-4 col-xs-10 offset-xs-1  box-shadow-2 p-0">
				<div class="card border-grey border-lighten-3 m-0">
					<div class="card-header no-border">
						<div class="card-title text-xs-center">
							<div class="p-1" style="border:1px solid #17c5ff;color:#FFF;"><img src="<?php echo dirname($baseUrl)."/uploads/settings/".$site_logo; ?>" alt="<?php echo $site_title; ?>"></div>
						</div>
						<h6 class="card-subtitle line-on-side text-muted text-xs-center font-small-3 pt-2"><span>Login</span></h6>
					</div>
					<div class="card-body collapse in">
						<div class="card-block">
							<?php $extra->flashMsg(); ?>
							<form class="form-horizontal form-simple" method="post">
								<fieldset class="form-group position-relative has-icon-left mb-5">
									<input type="text" class="form-control form-control-lg input-lg" name="username" placeholder="Username" value="<?php echo isset($username)?$username:''; ?>" data-validation="required" data-validation-error-msg-required="Please enter your username">
									<div class="form-control-position">
										<i class="ft-user"></i>
									</div>
								</fieldset>
								<fieldset class="form-group position-relative has-icon-left">
									<input type="password" class="form-control form-control-lg input-lg" name="password" placeholder="Password" data-validation="required" data-validation-error-msg-required="Please enter your password">
									<div class="form-control-position">
										<i class="fa fa-key"></i>
									</div>
								</fieldset>
								<fieldset class="form-group row">
									<div class="col-md-6 col-xs-12 text-xs-center text-md-left">
										<fieldset>
											<input type="checkbox" id="remember" class="chk-remember" name="remember">
											<label for="remember"> Remember Me</label>
										</fieldset>
									</div>
								</fieldset>
								<button type="submit" class="btn btn-primary btn-lg btn-block" name="frmSubmit"><i class="ft-unlock"></i> Login</button><br>
								
								</br>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>
        </div>
      </div>
    </div>
    <script src="<?php echo $baseUrl; ?>assets/vendors/js/vendors.min.js" type="text/javascript"></script>
    <script src="<?php echo $baseUrl; ?>assets/js/core/app-menu.js" type="text/javascript"></script>
    <script src="<?php echo $baseUrl; ?>assets/js/core/app.js" type="text/javascript"></script>
    <script src="<?php echo $baseUrl; ?>assets/plugins/datatable/datatables.min.js" type="text/javascript"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
	<script type="text/javascript">$(function(){ $.validate({ validateOnBlur : true, errorMessagePosition : 'top' ,scrollToTopOnError : true }); $('#datatable').DataTable({"processing": true}); }); function confirmAct() { return confirm("Sure to continue?"); }</script>
  </body>
</html>