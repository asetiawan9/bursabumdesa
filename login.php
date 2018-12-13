<? include "includes/header.php"; 

if(!empty($code) && !empty($lgid)) {
	$extra->swalMsgSingle("You have succesfully activated your Account!!");
	$decid = base64_decode($lgid);
	$usr_mail = $db->extractCol("select email from register where id='$decid'");
        $db->query("update register SET email_active_status='1' WHERE id='$decid'");
	$db->execute();
}
if(!empty($uid)) {
	$decid = base64_decode($uid);
	$usr_mail = $db->extractCol("select email from register where id='$decid'");
}
$usr_mail = isset($usr_mail)?$usr_mail:'';
$logerrurl = $baseUrl.'login/';
$userurl = $baseUrl.'user-profile/';
$retpg = isset($retpg)?$retpg:'';
if(isset($lgsub)|| isset($dlogin)) {
    
if(isset($dlogin)){
$email=base64_decode($username);
$password=base64_decode($password);
$db->query("select id,email_active_status,active_status from register where email=:email and password=:password");
$db->bind(":email",$email);
$db->bind(":password",$password);     

}else{
    $db->query("select id,email_active_status,active_status from register where email=:email and password=:password");
		$db->bind(":email",$email);
		$db->bind(":password",$password);
} 

 
	if(empty($email) || empty($password)) {
		$extra->swalMsg("Oops!","Fillout the empty fields!","warning",$logerrurl);
	}
	else {
		$exit_record = $db->rowCount();
		if($exit_record > 0) {
			$query = $db->fetch();
			$userid = $query['id'];
			$email_sts = $query['email_active_status'];
			$active_sts = $query['active_status'];
		
			if($active_sts == 1) {
				if($email_sts == 1) {
					$_SESSION['eqty_userid'] = $userid;
					$_SESSION['eqty_mail'] = $email;
					
					$logindt = date('Y-m-d H:i:s');
					$login_ip_addr = $ip_addr;
					$db->query("update register SET last_login_date='$logindt',login_ip_addr='$login_ip_addr' WHERE id='$userid'");
					$db->execute();
					if(!empty($retpg)) {
						$rdirurl = base64_decode($retpg);
						$array = explode('&', $rdirurl);
						$get_param = $array[1];
						if($get_param == 'enq')
							$_SESSION['eqty_param'] = 'enq';
						$extra->redirect_to($rdirurl);
					}
					else {
						$extra->redirect_to($userurl);
					}
				}
				else {
					$extra->swalMsg("Oops!","Kindly activate your account via Email!","warning",$logerrurl);
				}
			}
			else {
				$extra->swalMsg("Oops!","Your account is inactive!","warning",$logerrurl);
			}
		}
		else {
			$extra->swalMsg("Oops!","Invalid Credentials!","error",$logerrurl);
		}
	}
}

$lgmsg = isset($lgmsg)?$lgmsg:'';
$hid_val = '';
if(isset($askq)) {
	$lgmsg = 'Please Login to post your Comments';
	$hid_val = $askq;
}
if(isset($enq)) {
	$lgmsg = 'Please Login to submit your Enquires';
	$hid_val = $enq;
}
if(isset($invst)) {
	$lgmsg = 'Please Login to Invest';
	$hid_val = $invst;
}
if(isset($flw)) {
	$lgmsg = 'Please Login to add project to your Follow List';
	$hid_val = $flw;
}
if(isset($payup)) {
	$lgmsg = 'Please Login to upload your payslip & confirm your payment';
	$hid_val = $payup;
}
?>
 		 
		<section class="section causes-section causes-all login_bg" style="">
		    <div class="container">
                <div class="row">
                  <div class="col-sm-3">
				  </div>
				  <div class="col-sm-6  new_row white_bg">
                     <div class="input-comment">
                            <h4 class="border-title-h4">Login</h4>
						</div>
					 
					 <form name="lgfrm" method="post" action="">
					 <h4 style='text-align:center;padding-bottom:15px;color:#228ae6;'> <?=$lgmsg;?></h4>
					 <input type="hidden" name="retpg" value="<?=$hid_val;?>" />
                        <div class="row ">
							<div class="col-md-12 col-sm-12 col-xs-12 text-center">
								
							    <!--<div class="form-group">
									<a href="<?=$baseUrl;?>fblog_new/" class="hvr-float-shadow fb_btn btn-block"><i class="fab fa-facebook-f"></i> &nbsp; Login  with Facebook</a>
                                </div>-->
								
								<div class="form-group">
									<a href="<?=$baseUrl;?>google_plus/" class="hvr-float-shadow twit_btn btn-block"><i class="fab fa-google-plus-g"></i> &nbsp; Login  with Google Plus</a>
                                </div>
								<p>Or</p>
						   </div>

                           <div class="col-md-12 col-sm-12 col-xs-12">
                              <div class="single-input">
								 <input type="email" name="email" placeholder="Email" value="<?=$usr_mail;?>" required />
                              </div>
                           </div>
                         
                           <div class="col-md-12 col-sm-12 col-xs-12">
                              <div class="single-input">
								 <input type="password" name="password" placeholder="Password"  />
                              </div>
                           </div>
						   
						   <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                              <div class="form-group">
                                 <button class="hvr-float-shadow new_btn btn-block" type="submit" name="lgsub"><i class="fas fa-sign-in-alt"></i> &nbsp; Login </button>
                              </div>
                           </div>
						   <p class="small"><a class="pull-left" href="<?=$baseUrl;?>register/">New User? Register</a></p>
						   <p class="small"><a class="pull-right" href="<?=$baseUrl;?>forgot-pass/">Forgot password </a></p><br>
						   </br>
                        </div>
                     </form>
                  </div>
               </div>
		    </div>
		</section>  		
         	 
<? include "includes/footer.php"; ?>