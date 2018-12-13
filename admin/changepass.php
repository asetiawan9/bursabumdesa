<?php
require "includes/header.php";

if(isset($adn_chng_pass)) {
	if(!$user->pass_vfy($adm_curPass, $admin_password)) {
		$extra->setMsg("Current password is incorrect", "danger");
		$extra->redirect_to($baseUrl."changepass/");
	}
	else if($adm_newPass!=$adm_cnfrmPass) {
		$extra->setMsg("Passwords does not match", "danger");
		$extra->redirect_to($baseUrl."changepass/");
	}
	else {
		$general->put_option("admin_password", $user->pass_hash($adm_newPass));
		$extra->setMsg("Password changed successfully!", "success");
		$extra->redirect_to($baseUrl."changepass/");
	}
}
?>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-xs-12 mb-2">
                <h3 class="content-header-title mb-0">Change Password</h3>
            </div>
        </div>
        <div class="content-body">
            <section id="html">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Change Password</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            </div>
                            <div class="card-body collapse in">
                                <div class="card-block card-dashboard table-responsive">
									<?php echo $extra->flashMsg(); ?>
                                    <form name="adn_passchng" class="form-horizontal" method="post">
                                        <div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Current Password</label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" name="adm_curPass" required />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">New Password</label>
                                            <div class="col-sm-10">
                                                <input type="password" id="adn_passId" class="form-control" name="adm_newPass" required />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Confirm Password</label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" name="adm_cnfrmPass" required />
                                            </div>
                                        </div>
										<div class="form-actions col-sm-12">
										<? if($demo == 1) {?>
											<button onClick="return demo_user();" class="btn btn-primary mr-1"><i class="fa fa-check"></i> Save</button>
										<? } else {?>
											<button type="submit" class="btn btn-primary mr-1" name="adn_chng_pass"><i class="fa fa-check"></i> Save</button>
										<? } ?>
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
<?php require "includes/footer.php"; ?>