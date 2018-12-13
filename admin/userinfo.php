<?php
require "includes/header.php";

if(isset($info)) {
	$db->query("select a.*,b.country_name,c.state_name,d.city_name from register as a left join country as b on a.country=b.country_id left join state as c on a.state=c.state_id  left join city as d on a.city=d.city_id where a.id=:id");
	$db->bind(":id", $info);
	$result=$db->fetch();
	if(!empty($result)) extract($result);
	else $extra->redirect_to($baseUrl."manageuser/");
}
else $extra->redirect_to($baseUrl."manageuser/");
if($user_type==1) { $type="Vendor";  } else {  $type="User";  }
//if(empty($profile_image)) { $profile_image="emptyimg.png";  }
?>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-xs-12 mb-2">
                <h3 class="content-header-title mb-0">User Details</h3>
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
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">User Name </label>
										<div class="col-sm-10">:  &nbsp;&nbsp;<?=ucwords($firstname.' '.$lastname); ?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Email Address </label>
										<div class="col-sm-10">:  &nbsp;&nbsp;<?=$email; ?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Profile Image</label>
										<div class="col-sm-10">:  &nbsp;&nbsp;<img class="img-circle" src="<?=$extra->chkImg($profile_image, "../uploads/user-profile/"); ?>" style="height:150px;width:150px;" ></div>
									</div>
									<!--<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">User Type</label>
										<div class="col-sm-10">: &nbsp;&nbsp;<?=$type;?></div>
									</div>-->
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Country</label>
										<div class="col-sm-10">:  &nbsp;&nbsp;<?=$country_name;?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">State</label>
										<div class="col-sm-10">: &nbsp;&nbsp;<?=$state_name;?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">City</label>
										<div class="col-sm-10">: &nbsp;&nbsp;<?=$city_name;?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Phone Number</label>
										<div class="col-sm-10">: &nbsp;&nbsp;<?=$phone_code.'- '.$phone;?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Zipcode</label>
										<div class="col-sm-10">: &nbsp;&nbsp;<?=$zipcode;?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Website</label>
										<div class="col-sm-10">: &nbsp;&nbsp;<?=$website;?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Last used IP </label>
										<div class="col-sm-10">: &nbsp;&nbsp;<?=$login_ip_addr; ?></div>
									</div>
									<!--<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Last used Browser </label>
										<div class="col-sm-10">: &nbsp;&nbsp;<?=$user->browserName($recent_browser); ?></div>
									</div>-->
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Created on </label>
										<div class="col-sm-10">: &nbsp;&nbsp;<?=$crcdt; ?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Updated on </label>
										<div class="col-sm-10">: &nbsp;&nbsp;<?=$chngdt; ?></div>
									</div>
									
									 <div class="card-header">
										<h4 class="card-title">Bank Details</h4>
										<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Account Holder </label>
										<div class="col-sm-10">: &nbsp;&nbsp;<?=$acc_name; ?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Account Number </label>
										<div class="col-sm-10">: &nbsp;&nbsp;<?=$acc_num; ?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Bank Name</label>
										<div class="col-sm-10">: &nbsp;&nbsp;<?=ucfirst($bank_name); ?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Branch Name</label>
										<div class="col-sm-10">: &nbsp;&nbsp;<?=ucfirst($branch_name); ?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">IFSC </label>
										<div class="col-sm-10">: &nbsp;&nbsp;<?=$ifsc; ?></div>
									</div>
									<div class="card-header">
										<h4 class="card-title">Social Links</h4>
										<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Facebook </label>
										<div class="col-sm-10">: &nbsp;&nbsp;<?=$fb_url; ?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Twitter </label>
										<div class="col-sm-10">: &nbsp;&nbsp;<?=$twitter_url; ?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">LinkedIn </label>
										<div class="col-sm-10">: &nbsp;&nbsp;<?=$lnkdin_url; ?></div>
									</div>
									<div class="form-actions col-sm-12 abvbtn">
										<a href="<?php echo $baseUrl."user/$id/"; ?>" class="btn btn-primary mr-1"><i class="fa fa-check-square-o"></i> Edit</a>
										<button type="button" class="btn btn-warning" onclick="window.history.back();"><i class="fa fa-mail-reply"></i> Back</button>
									</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<?php require "includes/footer.php"; ?>