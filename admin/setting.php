<?php
require "includes/header.php";

if(isset($_POST['frmSubmit'])) {
	foreach($_POST as $name => $data) {
		if($name!="frmSubmit")
			$general->put_option($name, $data);
	}
	/** process image if it is uploaded **/
	if(!empty($_FILES['site_logo']['tmp_name'])) {
		$newName="logo_".uniqid();
		$oldImg=$general->get_option("site_logo");
		$upd=$common->uploadImg("site_logo", $newName, "268", "43", "../uploads/settings", $oldImg, false);
		if($upd) {
			$imgName=$common->imgName;
			$general->put_option("site_logo", $imgName);
		}
		else {
			$err=$common->imgErr;
			$extra->setMsg($err, "danger");
			$extra->redirect_to($baseUrl."setting/");
		}
	}
	if(!empty($_FILES['site_icon']['tmp_name'])) {
		$newName="logo_".uniqid();
		$oldImg=$general->get_option("site_icon");
		$upd=$common->uploadImg("site_icon", $newName, "180", "50", "../uploads/settings", $oldImg, false);
		if($upd) {
			$imgName=$common->imgName;
			$general->put_option("site_icon", $imgName);
		}
		else {
			$err=$common->imgErr;
			$extra->setMsg($err, "danger");
			$extra->redirect_to($baseUrl."setting/");
		}
	}
	$extra->setMsg("Changes saved successfully!", "success");
	$extra->redirect_to($baseUrl."setting/");
}
?>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-xs-12 mb-2">
                <h3 class="content-header-title mb-0">Site Setting</h3>
            </div>
        </div>
        <div class="content-body">
            <section id="html">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">General Setting</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            </div>
                            <div class="card-body collapse in">
                                <div class="card-block card-dashboard table-responsive">
									<?php echo $extra->flashMsg(); ?>
                                    <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                        <div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Site Title</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="site_title" value="<?php echo $general->get_option("site_title"); ?>" data-validation="required" data-validation-error-msg-required="Site title is required">
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Site Description</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control tinymce" name="site_description" data-validation="required" data-validation-error-msg-required="Site description is required"><?php echo $general->get_option("site_description"); ?></textarea>
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Site Keywords</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="site_keywords" value="<?php echo $general->get_option("site_keywords"); ?>" data-validation="required" data-validation-error-msg-required="Site keywords is required">
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Contact Address</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="admin_address" data-validation="required" data-validation-error-msg-required="Contact address is required"><?php echo $general->get_option("admin_address"); ?></textarea>
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Site number</label>
                                            <div class="col-sm-10">
												<input type="text" class="form-control" name="site_number" value="<?php echo $general->get_option("site_number"); ?>" required />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Site Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" name="site_email" value="<?php echo $general->get_option("site_email"); ?>" required />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Admin Email</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="admin_email" value="<?php echo $general->get_option("admin_email"); ?>" data-validation="required email" data-validation-error-msg-required="Admin email is required" data-validation-error-msg-email="Please enter valid email">
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Paypal Email</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="paypal_email" value="<?php echo $general->get_option("paypal_email"); ?>" data-validation="required email" data-validation-error-msg-required="Paypal email is required" data-validation-error-msg-email="Please enter valid email">
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Site Currency</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="site_currency" value="<?php echo $general->get_option("site_currency"); ?>" data-validation="required" data-validation-error-msg-required="Site currency is required">
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Site Url</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="site_url" value="<?php echo $general->get_option("site_url"); ?>" data-validation="required" data-validation-error-msg-required="Site url is required">
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Facebook</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="facebook" value="<?php echo $general->get_option("facebook"); ?>">
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Twitter</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="twitter" value="<?php echo $general->get_option("twitter"); ?>">
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Linkedin</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="linkedin" value="<?php echo $general->get_option("linkedin"); ?>">
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Google Plus</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="gplus" value="<?php echo $general->get_option("gplus"); ?>">
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Pinterest</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="pinterest" value="<?php echo $general->get_option("pinterest"); ?>">
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Rss</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="rss" value="<?php echo $general->get_option("rss"); ?>">
                                            </div>
                                        </div>
										
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Vimeo</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="vimeo" value="<?php echo $general->get_option("vimeo"); ?>">
                                            </div>
                                        </div>
										
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">YouTube</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="utube" value="<?php echo $general->get_option("utube"); ?>">
                                            </div>
                                        </div>
										
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Mail Signature</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="mail_sign" data-validation="required" data-validation-error-msg-required="Mail Signature"><?php echo $general->get_option("mail_sign"); ?></textarea>
                                            </div>
                                        </div>
										
                                        <div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Logo</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="file" name="site_logo" accept="image/*">
                                                <div class="col-sm-12 mt15">
                                                    <img src="<?php $imgName=$general->get_option("site_logo"); echo $extra->chkImg($imgName, "../uploads/settings/"); ?>">
                                                </div>
                                            </div>
                                        </div>
										
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Icon</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="file" name="site_icon" accept="image/*">
                                                <div class="col-sm-12 mt15">
                                                    <img src="<?php $iconName=$general->get_option("site_icon"); echo $extra->chkImg($iconName, "../uploads/settings/"); ?>">
                                                </div>
                                            </div>
                                        </div>
										
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">GooglePlus Login App Id</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="gappid" value="<?php echo $general->get_option("gappid"); ?>">
                                            </div>
                                        </div>
										
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">GooglePlus Login secret Key</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="gkey" value="<?php echo $general->get_option("gkey"); ?>">
                                            </div>
                                        </div>
										
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">GooglePlus Login Redirect URL</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="greurl" value="<?php echo $general->get_option("greurl"); ?>">
                                            </div>
                                        </div>
										
										<!--<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">FB Login App Id</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="fbappid" value="<?php echo $general->get_option("fbappid"); ?>">
                                            </div>
                                        </div>
										
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">FB Login secret Key</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="fbkey" value="<?php echo $general->get_option("fbkey"); ?>">
                                            </div>
                                        </div>
										
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">FB Login redirect URL</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="fbreurl" value="<?php echo $general->get_option("fbreurl"); ?>">
                                            </div>
                                        </div>-->
										
                                        <div class="form-actions center col-sm-12">
										<? if($demo == 1) {?>
											<button onClick="return demo_user();" class="btn btn-primary mr-1"><i class="fa fa-check-square-o"></i> Save</button>
										<? } else {?>
											<button type="submit" class="btn btn-primary mr-1" name="frmSubmit"><i class="fa fa-check-square-o"></i> Save</button>
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