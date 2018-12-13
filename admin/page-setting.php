<?php
require "includes/header.php";

if(isset($_POST['frmSubmit'])) {
	foreach($_POST as $name => $data) {
		if($name!="frmSubmit")
			$general->put_option($name, $data);
	}
	
	if(!empty($_FILES['foot_img1']['tmp_name'])) {
		$newName = "ftimg1".uniqid();
		$oldImg = $general->get_option("foot_img1");
		$upd = $common->uploadImg("foot_img1", $newName, "125", "141", "../uploads/settings", $oldImg, false);
		if($upd) {
			$imgName = $common->imgName;
			$general->put_option("foot_img1", $imgName);
		}
		else {
			$err = $common->imgErr;
			$extra->setMsg($err, "danger");
			$extra->redirect_to($baseUrl."page-setting/");
		}
	}
	if(!empty($_FILES['foot_img2']['tmp_name'])) {
		$newName = "ftimg2".uniqid();
		$oldImg = $general->get_option("foot_img2");
		$upd = $common->uploadImg("foot_img2", $newName, "125", "141", "../uploads/settings", $oldImg, false);
		if($upd) {
			$imgName = $common->imgName;
			$general->put_option("foot_img2", $imgName);
		}
		else {
			$err = $common->imgErr;
			$extra->setMsg($err, "danger");
			$extra->redirect_to($baseUrl."page-setting/");
		}
	}
	if(!empty($_FILES['foot_img3']['tmp_name'])) {
		$newName = "ftimg3".uniqid();
		$oldImg = $general->get_option("foot_img3");
		$upd = $common->uploadImg("foot_img3", $newName, "125", "141", "../uploads/settings", $oldImg, false);
		if($upd) {
			$imgName = $common->imgName;
			$general->put_option("foot_img3", $imgName);
		}
		else {
			$err = $common->imgErr;
			$extra->setMsg($err, "danger");
			$extra->redirect_to($baseUrl."page-setting/");
		}
	}
	if(!empty($_FILES['campaign_img1']['tmp_name'])) {
		$newName = "cmpimg1".uniqid();
		$oldImg = $general->get_option("campaign_img1");
		$upd = $common->uploadImg("campaign_img1", $newName, "125", "141", "../uploads/settings", $oldImg, false);
		if($upd) {
			$imgName = $common->imgName;
			$general->put_option("campaign_img1", $imgName);
		}
		else {
			$err = $common->imgErr;
			$extra->setMsg($err, "danger");
			$extra->redirect_to($baseUrl."page-setting/");
		}
	}
	if(!empty($_FILES['campaign_img2']['tmp_name'])) {
		$newName = "cmpimg2".uniqid();
		$oldImg = $general->get_option("campaign_img2");
		$upd = $common->uploadImg("campaign_img2", $newName, "125", "141", "../uploads/settings", $oldImg, false);
		if($upd) {
			$imgName = $common->imgName;
			$general->put_option("campaign_img2", $imgName);
		}
		else {
			$err = $common->imgErr;
			$extra->setMsg($err, "danger");
			$extra->redirect_to($baseUrl."page-setting/");
		}
	}
	if(!empty($_FILES['campaign_img3']['tmp_name'])) {
		$newName = "cmpimg3".uniqid();
		$oldImg = $general->get_option("campaign_img3");
		$upd = $common->uploadImg("campaign_img3", $newName, "125", "141", "../uploads/settings", $oldImg, false);
		if($upd) {
			$imgName = $common->imgName;
			$general->put_option("campaign_img3", $imgName);
		}
		else {
			$err = $common->imgErr;
			$extra->setMsg($err, "danger");
			$extra->redirect_to($baseUrl."page-setting/");
		}
	}
	if(!empty($_FILES['campaign_main_img']['tmp_name'])) {
		$newName = "cmpimg".uniqid();
		$oldImg = $general->get_option("campaign_main_img");
		$upd = $common->uploadImg("campaign_main_img", $newName, "1920", "1200", "../uploads/settings", $oldImg, false);
		if($upd) {
			$imgName = $common->imgName;
			$general->put_option("campaign_main_img", $imgName);
		}
		else {
			$err = $common->imgErr;
			$extra->setMsg($err, "danger");
			$extra->redirect_to($baseUrl."page-setting/");
		}
	}
	$extra->setMsg("Changes saved successfully!", "success");
	$extra->redirect_to($baseUrl."page-setting/");
}
?>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-xs-12 mb-2">
                <h3 class="content-header-title mb-0">Page Setting</h3>
            </div>
        </div>
        <div class="content-body">
            <section id="html">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Page Setting</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            </div>
                            <div class="card-body collapse in">
                                <div class="card-block card-dashboard table-responsive">
									<?php echo $extra->flashMsg(); ?>
                                    <form name="pgsetfrm" class="form-horizontal" method="post" enctype="multipart/form-data">
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Home mid content1</label>
                                            <div class="col-sm-10">
                                                <textarea id="midcnt1Id" class="form-control tinymce" name="midcnt1"><?php echo $general->get_option("midcnt1"); ?></textarea>
												<div id="midcnt1Err" style="color:#d51510;"> </div>
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Home mid content2</label>
                                            <div class="col-sm-10">
                                                <textarea id="midcnt2Id" class="form-control tinymce" name="midcnt2"><?php echo $general->get_option("midcnt2"); ?></textarea>
												<div id="midcnt2Err" style="color:#d51510;"> </div>
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Home foot text1</label>
                                            <div class="col-sm-10">
												<input type="text" class="form-control" name="foot_text1" value="<?php echo $general->get_option("foot_text1"); ?>" required />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Home foot img1**</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="file" name="foot_img1" accept="image/*" />
                                                <div class="col-sm-12 mt15">
                                                    <img src="<?php $imgName=$general->get_option("foot_img1"); echo $extra->chkprjtImg($imgName, "../uploads/settings/"); ?>" width="125" height="141" />
                                                </div>
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Home foot text2</label>
                                            <div class="col-sm-10">
												<input type="text" class="form-control" name="foot_text2" value="<?php echo $general->get_option("foot_text2"); ?>" required />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Home foot img2**</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="file" name="foot_img2" accept="image/*" />
                                                <div class="col-sm-12 mt15">
                                                    <img src="<?php $imgName=$general->get_option("foot_img2"); echo $extra->chkprjtImg($imgName, "../uploads/settings/"); ?>" width="125" height="141" />
                                                </div>
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Home foot text3</label>
                                            <div class="col-sm-10">
												<input type="text" class="form-control" name="foot_text3" value="<?php echo $general->get_option("foot_text3"); ?>" required />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Home foot img3**</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="file" name="foot_img3" accept="image/*" />
                                                <div class="col-sm-12 mt15">
                                                    <img src="<?php $imgName=$general->get_option("foot_img3"); echo $extra->chkprjtImg($imgName, "../uploads/settings/"); ?>" width="125" height="141" />
                                                </div>
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Campaign post midtext</label>
                                            <div class="col-sm-10">
												<textarea id="midtxtId" class="form-control tinymce" name="campaign_mid_text"><?php echo $general->get_option("campaign_mid_text"); ?></textarea>
												<div id="midtxtErr" style="color:#d51510;"> </div>
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Campaign post text1 heading</label>
                                            <div class="col-sm-10">
												<input type="text" class="form-control" name="campaign_text1_head" value="<?php echo $general->get_option("campaign_text1_head"); ?>" required />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Campaign post text1</label>
                                            <div class="col-sm-10">
												<input type="text" class="form-control" name="campaign_text1" value="<?php echo $general->get_option("campaign_text1"); ?>" required />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Campaign post img1**</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="file" name="campaign_img1" accept="image/*" />
                                                <div class="col-sm-12 mt15">
                                                    <img src="<?php $imgName=$general->get_option("campaign_img1"); echo $extra->chkprjtImg($imgName, "../uploads/settings/"); ?>" width="125" height="141" />
                                                </div>
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Campaign post text2 heading</label>
                                            <div class="col-sm-10">
												<input type="text" class="form-control" name="campaign_text2_head" value="<?php echo $general->get_option("campaign_text2_head"); ?>" required />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Campaign post text2</label>
                                            <div class="col-sm-10">
												<input type="text" class="form-control" name="campaign_text2" value="<?php echo $general->get_option("campaign_text2"); ?>" required />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Campaign post img2**</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="file" name="campaign_img2" accept="image/*" />
                                                <div class="col-sm-12 mt15">
                                                    <img src="<?php $imgName=$general->get_option("campaign_img2"); echo $extra->chkprjtImg($imgName, "../uploads/settings/"); ?>" width="125" height="141" />
                                                </div>
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Campaign post text3 heading</label>
                                            <div class="col-sm-10">
												<input type="text" class="form-control" name="campaign_text3_head" value="<?php echo $general->get_option("campaign_text3_head"); ?>" required />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Campaign post text3</label>
                                            <div class="col-sm-10">
												<input type="text" class="form-control" name="campaign_text3" value="<?php echo $general->get_option("campaign_text3"); ?>" required />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Campaign post img3**</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="file" name="campaign_img3" accept="image/*" />
                                                <div class="col-sm-12 mt15">
                                                    <img src="<?php $imgName=$general->get_option("campaign_img3"); echo $extra->chkprjtImg($imgName, "../uploads/settings/"); ?>" width="125" height="141" />
                                                </div>
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Campaign post main img text</label>
                                            <div class="col-sm-10">
												<input type="text" class="form-control" name="campaign_img_text" value="<?php echo $general->get_option("campaign_img_text"); ?>" />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Campaign post main img*</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="file" name="campaign_main_img" accept="image/*" />
                                                <div class="col-sm-12 mt15">
                                                    <img src="<?php $imgName=$general->get_option("campaign_main_img"); echo $extra->chkprjtImg($imgName, "../uploads/settings/"); ?>" style="width:100%;" />
                                                </div>
												<p style="color:#000;"> * Only jpg, jpeg, png, gif file with dimension of 1920X1200 & maximum size of 1 MB is allowed for Campaign post main img. </p>
                                            </div>
                                        </div>
										<p style="color:#ae0707;"> ** Only jpg, jpeg, png, gif file with dimension above 125X141 & maximum size of 1 MB is allowed. </p>
                                        <div class="form-actions center col-sm-12">
										<? if($demo == 1) {?>
											<button onClick="return demo_user();" class="btn btn-primary mr-1"><i class="fa fa-check-square-o"></i> Save</button>
										<? } else {?>
											<button onClick="return pgsetvalid();" type="submit" class="btn btn-primary mr-1" name="frmSubmit"><i class="fa fa-check-square-o"></i> Save</button>
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