<?php
require "includes/header.php";

if(isset($_POST['frmSubmit'])) {
	foreach($_POST as $name => $data) {
		if($name!="frmSubmit")
			$general->put_option($name, $data);
	}
	if(!empty($_FILES['aboutus_img']['tmp_name'])) {
		$newName = "abt_".uniqid();
		$oldImg = $general->get_option("aboutus_img");
		$upd=$common->uploadImg("aboutus_img", $newName, "360", "435", "../uploads/settings", $oldImg, false);
		if($upd) {
			$imgName = $common->imgName;
			$general->put_option("aboutus_img", $imgName);
		}
		else {
			$err = $common->imgErr;
			$extra->setMsg($err, "danger");
			$extra->redirect_to($baseUrl."cms/");
		}
	}
	$extra->setMsg("Changes saved successfully!", "success");
	$extra->redirect_to($baseUrl."cms/");
}
?>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-xs-12 mb-2">
                <h3 class="content-header-title mb-0">CMS Management</h3>
            </div>
        </div>
        <div class="content-body">
            <section id="html">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">CMS Management</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            </div>
                            <div class="card-body collapse in">
                                <div class="card-block card-dashboard table-responsive">
									<?php echo $extra->flashMsg(); ?>
                                    <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                        <div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">About Us</label>
                                            <div class="col-sm-10">
                                                <textarea id="aboutusId" class="form-control tinymce" name="about_us" rows="10"><?php echo $general->get_option("about_us"); ?></textarea>
												<div id="abtErr" style="color:#d51510;"> </div>
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Vision</label>
                                            <div class="col-sm-10">
                                                <textarea id="visionId" class="form-control tinymce" name="vision"><?php echo $general->get_option("vision"); ?></textarea>
												<div id="vsnErr" style="color:#d51510;"> </div>
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Mission</label>
                                            <div class="col-sm-10">
                                                <textarea id="missionId" class="form-control tinymce" name="mission"><?php echo $general->get_option("mission"); ?></textarea>
												<div id="msnErr" style="color:#d51510;"> </div>
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Terms & Conditions</label>
                                            <div class="col-sm-10">
                                                <textarea id="termId" class="form-control tinymce" name="terms_conditions" rows="10"><?php echo $general->get_option("terms_conditions"); ?></textarea>
												<div id="trmErr" style="color:#d51510;"> </div>
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Privacy Policy</label>
                                            <div class="col-sm-10">
                                                <textarea id="policyId" class="form-control tinymce" name="privacy_policy" rows="10"><?php echo $general->get_option("privacy_policy"); ?></textarea>
												<div id="plcyErr" style="color:#d51510;"> </div>
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">About Us Image**</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="file" name="aboutus_img" accept="image/*">
                                                <div class="col-sm-12 mt15">
                                                    <img src="<?php $imgName=$general->get_option("aboutus_img"); echo $extra->chkprjtImg($imgName, "../uploads/settings/"); ?>">
                                                </div>
                                            </div>
                                        </div>
										<p style="color:#ae0707;"> ** Only jpg, jpeg, png, gif file with dimension above 360X435 & maximum size of 1 MB is allowed. </p>
										<div class="form-actions center col-sm-12">
										<? if($demo == 1) {?>
											<button onClick="return demo_user();" class="btn btn-primary mr-1"><i class="fa fa-check-square-o"></i> Save</button>
										<? } else {?>
											<button onClick="return cmsvalid();" type="submit" class="btn btn-primary mr-1" name="frmSubmit"><i class="fa fa-check-square-o"></i> Save</button>
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