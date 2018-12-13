<? include "includes/header.php";

if(isset($ctcfrm_sub)) {
	$captcha=isset($_POST['g-recaptcha-response'])?$_POST['g-recaptcha-response']:'';
	if(!$captcha){
		$extra->swalMsg("Oops!","Fill all fields!","warning",$baseUrl."contact/");
	}
	else {
		$secretKey = $captchasecretkey;
		$ip = $_SERVER['REMOTE_ADDR'];
		$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
		$responseKeys = json_decode($response,true);
		if(intval($responseKeys["success"]) !== 1) {
			$extra->swalMsg("Oops!","Captcha mismatch!","warning",$baseUrl."contact/");
		}
		else {
			$set="name=:name";
			$set.=",email=:email";
			$set.=",ctc_num=:ctc_num";
			$set.=",comment=:comment";
			$set.=",ip='$ip'";
			
			$que="insert into contact_us set $set";
			$db->query($que);
			$db->bind(":name", $name);
			$db->bind(":email", $email);
			$db->bind(":ctc_num", $ctc_num);
			$db->bind(":comment", $comment);
			$db->execute();

			$site_logo_lnk = "$baseUrl/uploads/settings/$site_logo";
			$specific_title = '';
			$btn_name = 'Click Here to visit the Site';
			$text_to_admin = "<table>
				<tr>
					<td>Name </td>
					<td> : &nbsp;</td>
					<td> $name</td>
				</tr>
				<tr>
					<td>Email </td>
					<td> : &nbsp;</td>
					<td> $email</td>
				</tr>
				<tr>
					<td>Subject </td>
					<td> : &nbsp;</td>
					<td> $ctc_num</td>
				</tr>
				<tr>
					<td>Comment </td>
					<td> : &nbsp;</td>
					<td> $comment</td>
				</tr>
				</table>";
			$msg_to_admin = $extra->customtemplate($baseUrl,$site_logo_lnk,$text_to_admin,$site_title,$baseUrl,$specific_title,$btn_name);
			$sub_to_admin = 'User Contact us detail from '.$site_title;
			$result1 = $common->email($admin_email,$admin_email,$sub_to_admin,$msg_to_admin);
			
			$text_to_user = "<p>Thank you, Your enquiry has been submited.</p>";
			$msg_to_user = $extra->customtemplate($baseUrl,$site_logo_lnk,$text_to_user,$site_title,$baseUrl,$specific_title,$btn_name);	
			$sub_to_user = 'Your Contact us detail submission';	
			$result2 = $common->email($admin_email,$email,$sub_to_user,$msg_to_user);
			
			if(($result1 == "scs") && ($result2 == "scs")) {
				$extra->swalMsg("success!","Your contact detail submitted successfully","success",'contact/');	
			}
			else {
				$extra->swalMsg("Oops!","There is a problem with send email.Try again later","error",'contact/');	
			}
		}
	}
}
?>		 
		<section class="section">
            <div class="container">
                <div class="row">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="contact-details">
                                <ul class="contact-ul">
                                    <li>
                                        <span class="flaticon-placeholder"></span>
                                        <div class="contact-content">
                                            <h5>Our Address</h5>
                                            <h6><?=stripslashes($admin_address);?></h6>
                                        </div>
                                    </li>
                                    <li>
                                        <span class="flaticon-letter"></span>
                                        <div class="contact-content">
                                            <h5>Email Address</h5>
                                            <h6><?=$site_email;?></h6>
                                        </div>
                                    </li>
                                    <li>
                                        <span class="flaticon-phone"></span>
                                        <div class="contact-content">
                                            <h5>Phone Number</h5>
                                            <h6><?=$site_number;?></h6>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="social-icon">
                                            <ul>
											<? if(!empty($facebook)) { ?>
                                                <li><a href="<?=$facebook;?>"><i class="fab fa-facebook-f" aria-hidden="true"></i></a></li>
											<? } if(!empty($twitter)) { ?>
                                                <li><a href="<?=$twitter;?>"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>
											<? } if(!empty($gplus)) { ?>
                                                <li><a href="<?=$gplus;?>"><i class="fab fa-google-plus-g" aria-hidden="true"></i></a></li>
											<? } if(!empty($linkedin)) { ?>
                                                <li><a href="<?=$linkedin;?>"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a></li>
											<? } if(!empty($pinterest)) { ?>
                                                <li><a href="<?=$pinterest;?>"><i class="fab fa-pinterest-p" aria-hidden="true"></i></a></li>
											<? } ?>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>    
                        </div>
                        <div class="col-md-8 col-sm-6 col-xs-12">
                            <div class="submit-opinion">
                                <h4>Get In Touch</h4>
                                <form name="ctcfrm" method="post" class="comment-form">
                                    <div class="row">
                                        <div class="col-sm-4 col-xs-12">
                                            <input type="text" name="name" placeholder="Name*" class="input" required />
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            <input type="email" name="email" placeholder="Email*" class="input" required />
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            <input type="text" name="ctc_num" maxlength="15" minlength="10" onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57" placeholder="Mobile Number" class="input" required />
                                        </div>
                                    </div>
									<div class="row col-sm-12 col-xs-12">
										<textarea name="comment" rows="5" placeholder="Comment*" id="commentId" class="tinymce" required></textarea>
										<div id="cmtErr" style="color:#d51510;"> </div>
									</div>
									
									<div class="row col-sm-12 col-xs-12">
										<br /><div class="g-recaptcha" data-sitekey="<?=$captchasitekey;?>"></div>
									</div>
                                    <button onClick="return ctcfrm_valid()" type="submit" name="ctcfrm_sub" class="button">submit Comment</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
			
		<div class="clearfix"></div>
		<div class="col-sm-12 mt30 padd0i">
			<iframe class="embed-responsive-item" style="width:100%; height:250px;" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDHSvxBGz4cFL989BTKSJrgDe0iTQ7wNww&q=<?echo $admin_address;?>" frameborder="0" style="border:0" ></iframe>
		</div>
		<div class="clearfix"></div> 		
         	 
<? include "includes/footer.php"; ?>