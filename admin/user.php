<?php
require "includes/header.php";

$isEdit=false;
if(isset($info)) $isEdit=true;
$currdate= date('Y-m-d H:i:s'); 
$errurl = $baseUrl."user/";
/** process if the form has been submitted **/
if(isset($prf_sub)) {
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$extra->swalMsg("Oops!","Invalid Email!","warning",$errurl);
	}
	else if(strlen($password) < 6) {
		$extra->swalMsg("Oops!","Length of password atleast 6 characters","warning",$errurl);
	}
	else if(strlen($password) > 15) {
		$extra->swalMsg("Oops!","Length of password should not exceed 15 characters","warning",$errurl);
	}
	else {
		if(!empty($password)) $passEnc=$user->pass_hash($password);
		$set="firstname=:fname";
		$set.=",lastname=:lname";
		$set.=",email=:email";
		$set.=",password=:pass";
		if(isset($passEnc)) $set.=",repassword='$passEnc'";
		$set.=",country=:country";
		$set.=",state=:state";
		$set.=",city=:city";
		$set.=",phone_code=:phone_code";
		$set.=",phone=:phone";
		$set.=",zipcode=:zipcode";
		$set.=",website=:website";
		$set.=",acc_name=:acc_name";
		$set.=",acc_num=:acc_num";
		$set.=",bank_name=:bank_name";
		$set.=",branch_name=:branch_name";
		$set.=",ifsc=:ifsc";
		$set.=",fb_url=:fb_url";
		$set.=",twitter_url=:twitter_url";
		$set.=",lnkdin_url=:lnkdin_url";
		
		$set.=",recent_ipaddr='$ip'";
		/* $set.=",user_type='$usertype'";
		$set.=",address=:address";
		$set.=",about_me=:about_me";
		$set.=",user_paypal_email=:paypal"; */
		
		if($isEdit) {
			$set.=",chngdt='$currdate'";
			$que="update register set $set where id=:id";
			$db->query($que);
		}
		else {
			$usr_id = $db->extractCol("select id from register where email='$email'");
			if(empty($usr_id)) {
				//$set.=",browser='$ua'";
				//$set.=",recent_browser='$ua'";
				$set.=",crcdt='$currdate'";
				$set.=",email_active_status='1'";
				if($insid!="none") {
					$que="update register set $set where id='$insid'";
					$db->query($que);
				}
				else {
					$que="insert into register set $set";
					$db->query($que);
				}
			}
			else {
				$extra->swalMsg("Oops!","Email id already exists!","error",$errurl);
			}
		}
		
		$db->bind(":fname", $firstname);
		$db->bind(":lname", $lastname);
		$db->bind(":email", $email);
		$db->bind(":pass", $password);
		$db->bind(":country", $ctry_name);
		$db->bind(":state", $st_name);
		$db->bind(":city", $cty_name);
		$db->bind(":phone_code", $phonecode);
		$db->bind(":phone", $ctc_number);
		$db->bind(":zipcode", $zipcode);
		$db->bind(":website", $web);
		$db->bind(":acc_name", $acc_name);
		$db->bind(":acc_num", $acc_num);
		$db->bind(":bank_name", $bank_name);
		$db->bind(":branch_name", $branch_name);
		$db->bind(":ifsc", $ifsc);
		$db->bind(":fb_url", $fburl);
		$db->bind(":twitter_url", $twturl);
		$db->bind(":lnkdin_url", $lnkdinurl);
		
		/* $db->bind(":address", $address);
		$db->bind(":about_me", $about_me);
		$db->bind(":paypal", $paypal); */
		if($isEdit) $db->bind(":id", $info);
		$exec=$db->execute();
		if($exec) {
			if($isEdit)	$msg="updated";
			else $msg="created";
			$extra->setMsg("User profile $msg successfully!", "success");
			$extra->redirect_to($baseUrl."manageuser/");
		}
	}
}

$field_req = 'required';
if($isEdit) {
	$db->query("select * from register where id=:id");
	$db->bind(":id", $info);
	$result=$db->fetch();
	if(!empty($result)) extract($result);
	else $extra->redirect_to($baseUrl."manageuser/");
	
	$field_req = '';
}
$userid=isset($id)?$id:'none';

$firstname = isset($firstname)?$firstname:'';
$lastname = isset($lastname)?$lastname:'';
$email = isset($email)?$email:'';
$password = isset($password)?$password:'';
$country = isset($country)?$country:'';
$state = isset($state)?$state:'';
$city = isset($city)?$city:'';
$zipcode = isset($zipcode)?$zipcode:'';
$zipcode = ($zipcode != 0)?$zipcode:'';
$phone_code = isset($phone_code)?$phone_code:'';
$phone_code = ($phone_code != 0)?$phone_code:'';
$phone = isset($phone)?$phone:'';
$website = isset($website)?$website:'';
$acc_name = isset($acc_name)?$acc_name:'';
$acc_num = isset($acc_num)?$acc_num:'';
$bank_name = isset($bank_name)?$bank_name:'';
$branch_name = isset($branch_name)?$branch_name:'';
$ifsc = isset($ifsc)?$ifsc:'';
$fb_url = isset($fb_url)?$fb_url:'';
$twitter_url = isset($twitter_url)?$twitter_url:'';
$lnkdin_url = isset($lnkdin_url)?$lnkdin_url:'';
$profile_image = isset($profile_image)?$profile_image:'emptyimg.png';
?>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-xs-12 mb-2">
                <h3 class="content-header-title mb-0"><?php echo ($isEdit)?"Edit":"Create"; ?> User</h3>
            </div>
        </div>
        <div class="content-body">
            <section id="html">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Personal Details</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            </div>
                            <div class="card-body collapse in">
                                <div class="card-block card-dashboard table-responsive">
                                    <form name="usrfrm_adm" class="form-horizontal" method="post" action="">
                                        <div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">First Name <span class="req"> * </span></label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" name="firstname" value="<?=$firstname;?>" required />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Last Name <span class="req"> * </span></label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" name="lastname" value="<?=$lastname;?>" required />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Email Address <span class="req"> * </span></label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="email" name="email" value="<?=$email; ?>" <?=$field_req;?> />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Password <span class="req"> * </span></label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="password"name="password" value="<?=$password; ?>" id="password" minlength="6" maxlength="15" <?=$field_req;?> />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label"> Profile Image</label>
                                            <div class="col-sm-10" id="showimg" >
											    <img class="img-circle" src="<?=$extra->chkImg($profile_image, "../uploads/user-profile/"); ?>" style="height:150px;width:150px;" />
												<input type="hidden"  name="insid"  id="dynamicid" value="<?=$userid;?>" >
                                            </div>
                                        </div>
										
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label"> Upload Image</label>
                                            <div class="col-sm-10" >
												<input type="file" accept="image/*"  name="img" onchange="profileimage()" class="form-control" />
                                            </div>
                                        </div>
										
										<!--<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label"> User type</label><?php $user_type=isset($user_type)?$user_type:'';?>
                                            <div class="col-sm-10">
                                                 <input type="radio" name="usertype"  value="0"  data-validation="required" data-validation-qty="min1"
												 data-validation-error-msg-required="User type is required." <?php if($user_type=='0'){  echo "checked"; } ?> >&nbsp;User&nbsp;&nbsp;&nbsp;&nbsp;
												 <input type="radio" name="usertype" id="usertype" value="1" <?php if($user_type=='1') {  echo "checked"; }?> >&nbsp;Vendor
                                            </div>
                                        </div>-->
										
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label"> Country <span class="req"> * </span></label>
                                            <div class="col-sm-10">
                                               <select name="ctry_name" id="country" class="form-control" onchange="get_state(this.value);" required>
													<option value=""> Select Country </option>
													<?php echo $drop->dropselectSingle("select country_id,country_name from country where country_status='1' order by country_name asc",$country);?>
												</select>
                                            </div>
                                        </div>
										
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label"> State</label>
                                            <div class="col-sm-10">
                                              <select name="st_name" id="showstate" class="form-control" onchange="get_city(this.value);">
													<option value=""> Select State </option>
													<?php echo $drop->dropselectSingle("select state_id,state_name from state where state_status='1' and state_country_id='$country' order by state_name asc",$state);?>
												</select>
                                            </div>
                                        </div>
										
										<div class="form-group col-sm-12" >
                                            <label class="col-sm-2 control-label"> City</label>
                                            <div class="col-sm-10">
                                                <select name="cty_name" id="showcity" class="form-control">
													<option value=""> Select City </option>
													<?php echo $drop->dropselectSingle("select city_id,city_name from city where city_status='1' and city_state_id='$state' order by city_name asc",$city);?>
												</select>
                                            </div>
                                        </div>
										
										<!--<div class="form-group col-sm-12" >
                                            <label class="col-sm-2 control-label"> Address</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control group" name="address" value="<?=isset($address)?$address:'';?>">
                                            </div>
                                        </div>-->
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Phone number <span class="req"> * </span></label>
                                            <div class="col-sm-3">
                                                <input type="text" name="phonecode" class="form-control" maxlength="4" onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57" value="<?=$phone_code;?>" placeholder="Country Code" />
                                            </div>
											<div class="col-sm-7">
                                                <input type="text" class="form-control group" name="ctc_number" maxlength="15" minlength="10" onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57" value="<?=$phone;?>" />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label"> Zipcode <span class="req"> * </span></label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control group" name="zipcode" maxlength="6" minlength="5" onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57" value="<?=$zipcode;?>" required />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label"> Website</label>
                                            <div class="col-sm-10">
                                               <input type="url" name="web" class="form-control" placeholder="www.example.com" value="<?=$website;?>" />
                                            </div>
                                        </div>
										<!--<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">About  me</label>
                                            <div class="col-sm-10">
                                                <textarea rows="5" name="about_me" class="form-control group"  ><?=isset($about_me)?$about_me:'';?></textarea>
                                            </div>
                                        </div>
										
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label"> Paypal email </label>
                                            <div class="col-sm-10">
                                                <input class="form-control group" type="text" name="paypal"  data-validation="email" data-validation-error-msg-email="Please enter valid email"  value="<?=isset($user_paypal_email)?$user_paypal_email:'';?>"   >
                                            </div>
                                        </div>-->
										<div class="card-header">
											<h4 class="card-title">Bank Details</h4>
											<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
										</div>
                                        <div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Account Holder</label>
                                            <div class="col-sm-10">
                                               <input type="text" name="acc_name" class="form-control" value="<?=$acc_name;?>" placeholder="As Per Bank Account Name" />
                                            </div>
                                        </div>
										 <div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Account Number</label>
                                            <div class="col-sm-10">
                                               <input type="text" name="acc_num" class="form-control" value="<?=$acc_num;?>" placeholder="Bank Account Number" />
                                            </div>
                                        </div>
										 <div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Bank Name</label>
                                            <div class="col-sm-10">
                                               <input type="text" name="bank_name" class="form-control" value="<?=$bank_name;?>" placeholder="Bank Name" />
                                            </div>
                                        </div>
										 <div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Branch Name</label>
                                            <div class="col-sm-10">
                                               <input type="text" name="branch_name" class="form-control" value="<?=$branch_name;?>" placeholder="Branch Name" />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">IFSC Code</label>
                                            <div class="col-sm-10">
                                               <input type="text" name="ifsc" class="form-control" maxlength="16" value="<?=$ifsc;?>" placeholder="Bank IFSC Code" />
                                            </div>
                                        </div>
										
										<div class="card-header">
											<h4 class="card-title">Social Links</h4>
											<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
										</div>
                                        <div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Facebook</label>
                                            <div class="col-sm-10">
                                               <input type="text" name="fburl" class="form-control" placeholder="www.facebook.com/John William" value="<?=$fb_url;?>" />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Twitter</label>
                                            <div class="col-sm-10">
                                               <input type="text" name="twturl" class="form-control" placeholder="www.twitter.com/John William" value="<?=$twitter_url;?>" />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">LinkedIn</label>
                                            <div class="col-sm-10">
                                               <input type="text" name="lnkdinurl" class="form-control" placeholder="www.linkedIn.com/John William" value="<?=$lnkdin_url;?>" />
                                            </div>
                                        </div>
										
										<div class="form-actions center col-sm-12">
											<button type="submit" class="btn btn-primary mr-1" name="prf_sub"><i class="fa fa-check-square-o"></i> Save</button>
                                            <button type="button" class="btn btn-warning" onclick="window.history.back();"><i class="ft-x"></i> Cancel</button>
                                        </div>
									</form>
								</div>
							</div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<script type="text/javascript">
function get_state(val) {
	 $.ajax({url: "<?=dirname($baseUrl);?>/state-ajax.php?state_id="+val, success: function(result){
        $("#showstate").html(result);
    }});
}

function get_city(val) {
	 $.ajax({url: "<?=dirname($baseUrl);?>/city-ajax.php?city_id="+val, success: function(result){
        $("#showcity").html(result);
    }});
}

function profileimage() {
	var userid=document.getElementById('dynamicid').value;
	var formData = new FormData();
	formData.append('img', $('input[type=file]')[0].files[0]);
	$("#showimg").html("<img src='<?=dirname($baseUrl);?>/images/load.gif' height='100px;' width='100px;' alt='loading' />");
	
	$.ajax({
		url: '<?=$baseUrl;?>profile_img_ajax.php?uid='+userid,
		data: formData,
		type: 'POST',
		contentType: false,
		processData: false, 
		success: function (response) {
		if(response == 'Missmatch file format!') {
			response='<p style="color:red;">'+response+'</p>';
			$( '#showimg' ).html(response);
			return false;		   
		}
		else if(response=='Image missing!')	{
			response='<p style="color:red;">'+response+'</p>';
			$( '#showimg' ).html(response);
			return false;	
		}
		else {
			$( '#showimg' ).html(response);
			return true;	
		}
	  }
	});
}
</script>
<?php require "includes/footer.php"; ?>