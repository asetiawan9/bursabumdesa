<?php
require "includes/header.php";

$isEdit=false;
if(isset($info)) $isEdit=true;
/** process if the form has been submitted **/
if(isset($slider_sub)) {
	$set="title=:title";
	$set.=",description=:description";
	$set.=",button_name=:button_name";
	
	if($isEdit) {
		$set.=",chng_dt='$tday'";
		$set.=",chng_ip='$ip_addr'";
		$que = "update slider set $set where id=:id";
		$db->query($que);
	}
	else {
		$set.=",crc_dt='$tday'";
		$set.=",crc_ip='$ip_addr'";
		$que = "insert into slider set $set";
		$db->query($que);		
	}
	$db->bind(":title", $title_name);
	$db->bind(":description", $descript);
	$db->bind(":button_name", $btn_name);	
	if($isEdit) $db->bind(":id", $info);
	
	if($isEdit) {
		$db->execute();
		$sid = $info;
	}
	else {
		$sid = $db->lastInsertId();
	}
	
	if(isset($_FILES['sldr_img']['tmp_name']) && !empty($_FILES['sldr_img']['tmp_name'])) {
		$newName = "sldr".uniqid();
		$oldImg = $db->extractCol("select image from slider where id='$sid'");
		$upd = $common->uploadImg("sldr_img", $newName, "1920", "964", "../uploads/settings", $oldImg, false);
		if($upd) {
			$imgName = $common->imgName;
			$db->query("update slider set image='$imgName' where id='$sid'");
			$db->execute();
		}
		else {
			$err = $common->imgErr;
			$extra->setMsg($err, "danger");
			$cur_pg = $_SERVER['REQUEST_URI'];
			$rdir = dirname($baseUrl).'/'.substr(strrchr($cur_pg,'admin'), 0);
			$extra->redirect_to($rdir);
		}
	}
	
	if($isEdit) $msg="Updated";
	else $msg="Added";
	$extra->setMsg("Slider $msg successfully!", "success");
	$extra->redirect_to($baseUrl."manage-slider/");
}
if($isEdit) {
	$db->query("select * from slider where id=:id");
	$db->bind(":id", $info);
	$result = $db->fetch();
	if(!empty($result)) extract($result);
	else $extra->redirect_to($baseUrl."manage-slider/");
}
$image = isset($image)?$image:'';
?>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-xs-12 mb-2">
                <h3 class="content-header-title mb-0"><?php echo ($isEdit)?"Edit":"Create"; ?> Slider</h3>
            </div>
        </div>
        <div class="content-body">
            <section id="html">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"><?php echo ($isEdit)?"Edit":"Create"; ?> Slider</h4>
								<?php $extra->flashMsg(); ?>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            </div>
                            <div class="card-body collapse in">
                                <div class="card-block card-dashboard table-responsive">
                                    <form name="slider_frm" class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                                        <div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Title</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" type="text" name="title_name" maxlength="50" value="<?php echo isset($title)?$title:''; ?>" required />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Description</label>
                                            <div class="col-sm-6">
                                                <textarea class="form-control" name="descript" rows="5"><?php echo isset($description)?$description:''; ?></textarea>
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Button Name</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" type="text" name="btn_name" maxlength="30" value="<?php echo isset($button_name)?$button_name:''; ?>" required />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Image**</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" type="file" name="sldr_img" accept="image/*" />
                                                <div class="col-sm-12 mt15">
                                                    <img src="<?php echo $extra->chkprjtImg($image, "../uploads/settings/"); ?>" style="width:100%;" />
                                                </div>
                                            </div>
                                        </div>
										<p style="color:#ae0707;"> ** Only jpg, jpeg, png, gif file with dimension of 1920X964 & maximum size of 1 MB is allowed. </p>
                                        <div class="form-actions center col-sm-12">
										<? if($isEdit && ($demo == 1)) {?>
											<button onClick="return demo_user();" class="btn btn-primary mr-1"><i class="fa fa-check-square-o"></i> Save</button>
										<? } else {?>
											<button type="submit" class="btn btn-primary mr-1" name="slider_sub"><i class="fa fa-check-square-o"></i> Save</button>
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