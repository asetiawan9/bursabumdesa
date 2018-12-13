<? include "includes/header.php"; 

$logerrurl = $baseUrl.'login/';
$rdirurl = $baseUrl.'register/';
if(isset($frgt_sub) && !empty($email)) {
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$extra->swalMsg("Oops!","Invalid Email!","warning",$rdirurl);
	}
	else {
		$usr_id = $db->extractCol("select id from register where email='$email'");
		if(!empty($usr_id)) {
			$id1 = uniqid();
			$id2 = rand(0,100);
			$ori_pass = $id1 . $id2;
			$enc_pass = $user->pass_hash($ori_pass);
			$set="password='$ori_pass'";
			$set.=",repassword='$enc_pass'";
			$db->query("update register set $set where id='$usr_id'");
			$db->execute();
			$site_logo = $baseUrl."uploads/settings/".$site_logo;
			$encodeid = base64_encode($usr_id);
			$redirecturl = $logerrurl.'?uid='.$encodeid;
			$frgtPass_msg = $extra->forgotpwtemplate($baseUrl,$site_logo,$site_title,$redirecturl,'username',$ori_pass);
			$subject = 'Forgot Password request from '.$site_title;
			$result=$common->email($admin_email,$email,$subject,$frgtPass_msg);
			if($result="scs") {
				$extra->swalMsg("success!","Kindly check your email to get New Password.","success",$logerrurl);	
			}
			else {
				$extra->swalMsg("Oops!","There is a problem with send email.Try again later","error",$baseUrl);	
			}
		}
		else {
			$extra->swalMsg("Oops!","Are you New User? Register Here...","error",$rdirurl);
		}
	}
}
?>
 		 
		<section class="section causes-section causes-all login_bg" style="">
		    <div class="container">
                <div class="row">
                  <div class="col-sm-3">
				  </div>
				  <div class="col-sm-6  new_row white_bg">
                     <div class="input-comment">
                            <h4 class="border-title-h4">Forgot Password</h4>
						</div>
					 
					 <form name="frgtfrm" method="post" action="">
                        <div class="row ">
                           <div class="col-md-12 col-sm-12 col-xs-12">
                              <div class="single-input">
								 <input type="email" name="email" placeholder="Email" required />
                              </div>
                           </div>
						   <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                              <div class="form-group">
                                 <button class="hvr-float-shadow new_btn btn-block" type="submit" name="frgt_sub"><i class="fas fa-sign-in-alt"></i> &nbsp; Get Password </button>
                              </div>
                           </div>
						   <p class="small"><a class="pull-right" href="<?=$baseUrl;?>login/">Login </a></p>
                        </div>
                     </form>
                  </div>
               </div>
		    </div>
		</section>  		
         	 
<? include "includes/footer.php"; ?>