<?
	include "includes/header.php";
	include "includes/profhead.php";
	
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
                        <form class="form-horizontal" action="">
                           <div class="form-group">
                              <h4>Personal Details</h4>
                           </div>
                           <div class="form-group">
                              <label class="col-sm-3">Name</label>
                              <div class="col-sm-1 text-center hidden-xs">:</div>
                              <div class="col-sm-8">
                                 <h6 class="u_dtl"><?=$usrname;?></h6>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="col-sm-3">Email</label>
                              <div class="col-sm-1 text-center hidden-xs">:</div>
                              <div class="col-sm-8">
                                 <h6 class="u_dtl"><?=$email;?></h6>
                              </div>
                           </div>
						    <div class="form-group">
                              <label class="col-sm-3">Country</label>
                              <div class="col-sm-1 text-center hidden-xs">:</div>
                              <div class="col-sm-8">
                                 <h6 class="u_dtl"><?=$country_name;?></h6>
                              </div>
                           </div>
						    <div class="form-group">
                              <label class="col-sm-3">State</label>
                              <div class="col-sm-1 text-center hidden-xs">:</div>
                              <div class="col-sm-8">
                                 <h6 class="u_dtl"><?=$state_name;?></h6>
                              </div>
                           </div>
						    <div class="form-group">
                              <label class="col-sm-3">City</label>
                              <div class="col-sm-1 text-center hidden-xs">:</div>
                              <div class="col-sm-8">
                                 <h6 class="u_dtl"><?=$city_name;?></h6>
                              </div>
                           </div>
						   <div class="form-group">
                              <label class="col-sm-3">Zipcode</label>
                              <div class="col-sm-1 text-center hidden-xs">:</div>
                              <div class="col-sm-8">
                                 <h6 class="u_dtl"><?=$zipcode;?></h6>
                              </div>
                           </div>
						   <div class="form-group">
                              <label class="col-sm-3">Phone Number</label>
                              <div class="col-sm-1 text-center hidden-xs">:</div>
                              <div class="col-sm-8">
                                 <h6 class="u_dtl"><?=$phone_code.' '.$phone;?></h6>
                              </div>
                           </div>
						   <div class="form-group">
                              <label class="col-sm-3">Website</label>
                              <div class="col-sm-1 text-center hidden-xs">:</div>
                              <div class="col-sm-8">
                                 <h6 class="u_dtl"><a href="website" target="_blank"><?=$website;?></a></h6>
                              </div>
                           </div>
						   
						   <div class="form-group">
                              <h4>Social Link</h4>
                           </div>
						   <div class="form-group">
                              <label class="col-sm-3">Facebook</label>
                              <div class="col-sm-1 text-center hidden-xs">:</div>
                              <div class="col-sm-8">
                                 <h6 class="u_dtl"><a href="<?=$fb_url;?>" target="_blank"><?=$fb_url;?></a></h6>
                              </div>
                           </div>
						   <div class="form-group">
                              <label class="col-sm-3">Twitter</label>
                              <div class="col-sm-1 text-center hidden-xs">:</div>
                              <div class="col-sm-8">
                                 <h6 class="u_dtl"><a href="<?=$twitter_url;?>" target="_blank"><?=$twitter_url;?></a></h6>
                              </div>
                           </div>
						   <div class="form-group">
                              <label class="col-sm-3">LinkedIn</label>
                              <div class="col-sm-1 text-center hidden-xs">:</div>
                              <div class="col-sm-8">
                                 <h6 class="u_dtl"><a href="<?=$lnkdin_url;?>" target="_blank"><?=$lnkdin_url;?></a></h6>
                              </div>
                           </div>
						   
                            <div class="form-group text-center">
                               <a href="<?=$baseUrl;?>user-profile-edit/" class="button ml15"><i class="far fa-edit"></i> Edit Profile</a>
							</div> 
                        </form>
                     </div>
					 <div class="col-sm-4">
						<div class="profile_pic text-center"> 
                           <img src="<?=$extra->chkImg($profile_image, "uploads/user-profile/"); ?>" class="img-circle">
                        </div>
						<div class="col-sm-12 text-center mt20">
							<a href="<?=$baseUrl;?>user-profile-edit/"><i class="far fa-edit"></i>Edit Profile </a>
						</div>
					 </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
<? include "includes/footer.php"; ?>