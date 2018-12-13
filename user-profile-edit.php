<?
	include "includes/header.php";
	include "includes/profhead.php";
	
if(isset($prf_sub)) {
	$set="firstname=:firstname";
	$set.=",lastname=:lastname";
	$set.=",country=:country";
	$set.=",state=:state";
	$set.=",city=:city";
	$set.=",zipcode=:zipcode";
	$set.=",phone_code=:phone_code";
	$set.=",phone=:phone";
	$set.=",website=:website";
	$set.=",fb_url=:fb_url";
	$set.=",twitter_url=:twitter_url";
	$set.=",lnkdin_url=:lnkdin_url";
	
	$set.=",chngdt='$timestamp'";
	$set.=",recent_ipaddr='$ip_addr'";
	
	$que="update register set $set where id='$id'";
	$db->query($que);
	$db->bind(":firstname", $f_name);
	$db->bind(":lastname", $l_name);
	$db->bind(":country", $ctry_name);
	$db->bind(":state", $st_name);
	$db->bind(":city", $cty_name);
	$db->bind(":zipcode", $zip_code);
	$db->bind(":phone_code", $phonecode);
	$db->bind(":phone", $ctc_number);
	$db->bind(":website", $web);
	$db->bind(":fb_url", $fburl);
	$db->bind(":twitter_url", $twturl);
	$db->bind(":lnkdin_url", $lnkdinurl);
	$db->execute();
	$extra->swalMsg("success!","profile Updated successfully!","success",$baseUrl.'user-profile/');
}

if(isset($_FILES['prf_img']['tmp_name']) && !empty($_FILES['prf_img']['tmp_name'])) {
	$newName="usr_".uniqid();
	$usr_img = $db->extractCol("select profile_image from register where id='$id'");
	$upd=$common->uploadImg("prf_img", $newName, "100", "100", "uploads/user-profile", $usr_img, false);
	if($upd) {
		$imgName=$common->imgName;
		$db->query("update register set profile_image='$imgName' where id='$id'");
		$db->execute();
		$extra->redirect_to($baseUrl."user-profile-edit/");
	}
	else {
		$err=$common->imgErr;
		$extra->swalMsg("Oops!",$err,"error",$baseUrl."user-profile-edit/");
	}
}
?>        
      <div class="container">
         <div class="row">
            <div class="col-sm-9">
               <div class="col-sm-12 dashboard">
                  <div class="row">
					<h2>My Profile</h2>
                  </div>
				  <div class="row">
                     <div class="col-sm-8">
                        <form name="usrprf" method="post" class="form-horizontal" action="">
                           <div class="form-group">
                              <h4>Personal Details</h4>
                           </div>
                           <div class="form-group">
                              <label class="col-sm-3">First Name</label>
                              <div class="col-sm-1 text-center hidden-xs">:</div>
                              <div class="col-sm-8">
                                 <input type="text" name="f_name" class="form-control" value="<?=$fname;?>" required />
                              </div>
                           </div>
						   <div class="form-group">
                              <label class="col-sm-3">Last Name</label>
                              <div class="col-sm-1 text-center hidden-xs">:</div>
                              <div class="col-sm-8">
                                 <input type="text" name="l_name" class="form-control" value="<?=$lname;?>" required />
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="col-sm-3">Email</label>
                              <div class="col-sm-1 text-center hidden-xs">:</div>
                              <div class="col-sm-8">
                                 <input type="email" class="form-control" value="<?=$email;?>" readonly />
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="col-sm-3">Country</label>
                              <div class="col-sm-1 text-center hidden-xs">:</div>
                              <div class="col-sm-8">
                                <select name="ctry_name" id="country" class="form-control" onchange="get_state(this.value);" required>
									<option value=""> Select Country </option>
									<?php echo $drop->dropselectSingle("select country_id,country_name from country where country_status='1' order by country_name asc",$country);?>
								</select>
                              </div>
                           </div>
						   <div class="form-group">
                              <label class="col-sm-3">State</label>
                              <div class="col-sm-1 text-center hidden-xs">:</div>
                              <div class="col-sm-8">
                                <select name="st_name" id="showstate" class="form-control" onchange="get_city(this.value);">
									<option value=""> Select State </option>
									<?php echo $drop->dropselectSingle("select state_id,state_name from state where state_status='1' and state_country_id='$country' order by state_name asc",$state);?>
								</select>
                              </div>
                           </div>
						   <div class="form-group">
                              <label class="col-sm-3">City</label>
                              <div class="col-sm-1 text-center hidden-xs">:</div>
                              <div class="col-sm-8">
                                <select name="cty_name" id="showcity" class="form-control">
									<option value=""> Select City </option>
									<?php echo $drop->dropselectSingle("select city_id,city_name from city where city_status='1' and city_state_id='$state' order by city_name asc",$city);?>
								</select>
                              </div>
                           </div>
						   <div class="form-group">
                              <label class="col-sm-3">Zipcode</label>
                              <div class="col-sm-1 text-center hidden-xs">:</div>
                              <div class="col-sm-8">
                                 <input type="text" name="zip_code" class="form-control" maxlength="6" minlength="5" onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57" value="<?=$zipcode;?>" required />
                              </div>
                           </div>
						   <div class="form-group">
                              <label class="col-sm-3">Phone Number</label>
                              <div class="col-sm-1 text-center hidden-xs">:</div>
                              <div class="col-sm-8">
                                 <div class="row">
									<div class="col-xs-4">
										<input type="text" name="phonecode" class="form-control" maxlength="4" onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57" value="<?=ltrim($phone_code,'+');?>" />
									</div>
									<div class="col-xs-8">
										<input type="text" name="ctc_number" class="form-control" maxlength="15" minlength="10" onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57" value="<?=$phone;?>" required />
									</div>
								 </div>
                              </div>
                           </div>
						   <div class="form-group">
                              <label class="col-sm-3">Website</label>
                              <div class="col-sm-1 text-center hidden-xs">:</div>
                              <div class="col-sm-8">
                                 <input type="url" name="web" class="form-control" placeholder="www.example.com" value="<?=$website;?>" />
                              </div>
                           </div>
                           
						   <div class="form-group">
                              <h4>Social Link</h4>
                           </div>
						   <div class="form-group">
                              <label class="col-sm-3">Facebook</label>
                              <div class="col-sm-1 text-center hidden-xs">:</div>
                              <div class="col-sm-8">
								 <input type="text" name="fburl" class="form-control" placeholder="www.facebook.com/John William" value="<?=$fb_url;?>" />
                              </div>
                           </div>
						   <div class="form-group">
                              <label class="col-sm-3">Twitter</label>
                              <div class="col-sm-1 text-center hidden-xs">:</div>
                              <div class="col-sm-8">
								 <input type="text" name="twturl" class="form-control" placeholder="www.twitter.com/John William" value="<?=$twitter_url;?>" />
                              </div>
                           </div>
						   <div class="form-group">
                              <label class="col-sm-3">LinkedIn</label>
                              <div class="col-sm-1 text-center hidden-xs">:</div>
                              <div class="col-sm-8">
								 <input type="text" name="lnkdinurl" class="form-control" placeholder="www.linkedIn.com/John William" value="<?=$lnkdin_url;?>" />
                              </div>
                           </div>
						   
						     
						   <div class="form-group text-center">
								<input type="submit" name="prf_sub" class="button ml15" />
							</div>
                     </div>
					 </form>
					 <form id="jsform" action="" method="post" enctype="multipart/form-data">
					 <div class="col-sm-4">
						<div class="profile_pic text-center"> 
                           <img src="<?=$extra->chkImg($profile_image, "uploads/user-profile/"); ?>" class="img-circle">
                        </div>
						<div class="col-sm-12 text-center mt20">
							<div class="form-group">
								<input type="file" class="form-control" name="prf_img" accept="image/*" onChange="change_img();" />
							</div>
						</div>
					 </div>
					 </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
	  
<script type="text/javascript">
function get_state(val) {
	 $.ajax({url: "<?=$baseUrl;?>/state-ajax.php?state_id="+val, success: function(result){
        $("#showstate").html(result);
    }});
}

function get_city(val) {
	 $.ajax({url: "<?=$baseUrl;?>/city-ajax.php?city_id="+val, success: function(result){
        $("#showcity").html(result);
    }});
}
function change_img() {
  document.getElementById('jsform').submit();
}
</script>
<? include "includes/footer.php"; ?>