<? include "includes/header.php";

$logerrurl = $baseUrl."register_bumdes/";
$regsucurl = $baseUrl."login/";
if(isSet($regsub) && !empty($username) && !empty($email) && !empty($ctc_number) && !empty($pass)){
	$captcha=isset($_POST['g-recaptcha-response'])?$_POST['g-recaptcha-response']:'';
	if(!$captcha){
		$extra->swalMsg("Oops!","Fill all fields!","warning",$logerrurl);
	}
	else {
		$crcdt = date('y-m-d H:i:s');
		$secretKey = $captchasecretkey;
		$ip = $_SERVER['REMOTE_ADDR'];
		$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
		$responseKeys = json_decode($response,true);
		if(intval($responseKeys["success"]) !== 1) {
			$extra->swalMsg("Oops!","Captcha mismatch!","warning",$logerrurl);
		}
		else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$extra->swalMsg("Oops!","Invalid Email!","warning",$logerrurl);
		}
		else if(strlen($pass) < 6) {
			$extra->swalMsg("Oops!","Length of password atleast 6 characters","warning",$logerrurl);
		}
		else if(strlen($pass) > 15) {
			$extra->swalMsg("Oops!","Length of password should not exceed 15 characters","warning",$logerrurl);
		}
		else {
			$db->query("select * from register where email=:email");
			$db->bind(":email", $email);
			$exist_email = $db->rowCount();
			if($exist_email==0)
			{
				$id1=uniqid();
				$id2=rand(0,100);
				$activationkey=$id1 . $id2;
				$crcdt= date('Y-m-d H:i:s');
				$password=$user->pass_hash($pass);
				$db->query("insert into register set user_role=:user_role,firstname=:fname,email=:email,password=:password,repassword=:repassword,phone=:phone,user_type='0',tmp_key='$activationkey',active_status='1',reg_ip_addr='$ip_addr',crcdt='$crcdt'");
				$db->bind(":user_role", $user_role);
				$db->bind(":fname", $username);
				$db->bind(":email", $email);
				$db->bind(":password", $pass);
				$db->bind(":repassword", $password);
				$db->bind(":phone", $ctc_number);
				//$db->execute();
				$insert_id = $db->lastInsertId();
				$site_logo = $baseUrl."uploads/settings/".$site_logo;
				$topcontent="Welcome to the $site_title! We are an online rewards platform.Once you are registered, your earnings are endless!";
				$encodeid = base64_encode($insert_id);
				$redirecturl = $regsucurl."?code=".$activationkey."&lgid=".$encodeid;
				
				$signupmsg=$extra->signuptemplate($baseUrl,$site_logo,$topcontent,$site_title,$redirecturl);
				$subject="Activate your"." ".$site_title." "."account";
				$result=$common->email($admin_email,$email,$subject,$signupmsg);
				if($result == "scs") {
					$extra->swalMsg("Registered Succesfully!","We will send conformation message shortly.Kindly check your mail.","success",$regsucurl);	
				}
				else {
					$extra->swalMsg("Oops!","There is a problem with send email.Try again later","error",$baseUrl);	
				}
			}
			else {
				$extra->swalMsg("Oops!","Email id already exists!","error",$logerrurl);
			}
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
                            <h4 class="border-title-h4">Register Bumdesa</h4>
						</div>
					 
					 <form name="regfrm" method="post" action="">
                        <div class="row ">
							<div class="col-md-12 col-sm-12 col-xs-12 text-center">
							    <!--<div class="form-group">
									<a href="<?=$baseUrl;?>fblog_new/" class="hvr-float-shadow fb_btn btn-block"><i class="fab fa-facebook-f"></i> &nbsp; Register  with Facebook</a>
                                </div>-->
								<div class="form-group">
									<a href="<?=$baseUrl;?>google_plus/" class="hvr-float-shadow twit_btn btn-block"><i class="fab fa-google-plus-g"></i> &nbsp; Register  with Google Plus</a>
                                </div>
								<p>Or</p>
						   </div>

						   <div class="col-md-12 col-sm-12 col-xs-12">
                              <div class="single-input">
								 <input type="text" name="user_role" value="bumdesa" />
                              </div>
                           </div> 

                           <div class="col-md-12 col-sm-12 col-xs-12">
                              <div class="single-input">
								 <input type="text" name="username" placeholder="User Name"required />
                              </div>
                           </div>
						   
						   <div class="col-md-12 col-sm-12 col-xs-12">
                              <div class="single-input">
								 <input type="email" name="email" placeholder="User Email" required />
                              </div>
                           </div>
						   
						   <div class="col-md-12 col-sm-12 col-xs-12">
                              <div class="single-input">
								 <input type="text" name="ctc_number" maxlength="15" minlength="10" onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57" placeholder="Phone Number" required />
                              </div>
                           </div>
						   
						   <div class="col-md-12 col-sm-12 col-xs-12">
                              <div class="single-input">
								 <input type="Password" name="pass" id="passId" placeholder="Password" required />
                              </div>
                           </div>
						   
						   <div class="col-md-12 col-sm-12 col-xs-12">
                              <div class="single-input">
								 <input type="Password" name="cpass" placeholder="Confirm Password" required />
                              </div>
                           </div>
						   
						   <div class="col-md-12 col-sm-12 col-xs-12">
								<div class="g-recaptcha" data-sitekey="<?=$captchasitekey;?>"></div>
						   </div>
						   
						   <div class="col-md-12 col-sm-12 col-xs-12">
                              <div class="">
								 <br /><input type="checkbox" name="agree" value="checkbox" id="agreeId" required /> I have reviewed and agree to the <span><a target="_blank" href="<?=$baseUrl;?>terms/"> Terms of Service</a></span> and <span><a target="_blank" href="<?=$baseUrl;?>privacy/"> Privacy Policy</a></span>
							  </div><br />
							</div>
                           
						   <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                              <div class="form-group">
                                 <button class="hvr-float-shadow new_btn btn-block" type="submit" name="regsub"><i class="fas fa-sign-in-alt"></i> &nbsp; Register </button>
                              </div>
                           </div>
							<p class="small"><a class="pull-right" href="<?=$baseUrl;?>login/">Already User? Login</a></p>
                        </div>
                     </form>
                     <!-- /Form -->
                  </div>
               </div>
		    </div>
		</section>  		
    
<? include "includes/footer.php"; ?>