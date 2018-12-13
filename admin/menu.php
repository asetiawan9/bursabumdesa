<?php
require "includes/header.php";

$isEdit=false;
if(isset($info)) $isEdit=true;

/** process if the form has been submitted **/
if(isset($_POST['frmSubmit'])) {
	$set="name=:name";
	$set.=",icon=:icon";
	$set.=",parent_id=:parent_id";
	$set.=",filename=:filename";
	$set.=",udate='$timestamp'";
	if($isEdit) $que="update menu set $set where id=:id";
	else $que="insert into menu set $set ,cdate='$timestamp'";
	$db->query($que);
	$db->bind(":name", $name);
	$db->bind(":icon", $icon);
	$db->bind(":filename", $filename);
	$db->bind(":parent_id", $parent_id);
	if($isEdit) $db->bind(":id", $info);
	$exec=$db->execute();
	if($isEdit) $msg="updated";
	else $msg="created";
	$extra->setMsg("Menu $msg successfully!", "success");
	$extra->redirect_to($baseUrl."managemenu/");
}
if($isEdit) {
	$db->query("select parent_id,name,icon,filename from menu where id=:id");
	$db->bind(":id", $info);
	$result=$db->fetch();
	if(!empty($result)) extract($result);
	else $extra->redirect_to($baseUrl."managemenu/");
	$cat_filename = $result["filename"];
}
?>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-xs-12 mb-2">
                <h3 class="content-header-title mb-0"><?php echo ($isEdit)?"Edit":"Create"; ?> Menu</h3>
            </div>
        </div>
        <div class="content-body">
            <section id="html">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"><?php echo ($isEdit)?"Edit":"Create"; ?> Menu</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            </div>
                            <div class="card-body collapse in">
                                <div class="card-block card-dashboard table-responsive">
                                    <form class="form-horizontal" method="post">
                                        <div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Menu Name</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" name="name" value="<?php echo isset($name)?$name:''; ?>" data-validation="required" data-validation-error-msg-required="Menu name is required">
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Menu Icon</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" name="icon" value="<?php echo isset($icon)?$icon:''; ?>">
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Filename</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" name="filename" value="<?php echo isset($cat_filename)?$cat_filename:''; ?>" data-validation="required" data-validation-error-msg-required="Filename is required">
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Parent Menu</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name="parent_id">
												<?php
												$que="select id,name from menu where parent_id='0' and status='1'";
												if(!empty($info)) $que.=" and id!=:id";
												$db->query($que);
												if(!empty($info)) $db->bind(":id", $info);
												$result=$db->fetchAll(true);
												echo $drop->dropselectArr($result, $parent_id);
												?>
												</select>
                                            </div>
                                        </div>
                                        <div class="form-actions center col-sm-12">
											<button type="submit" class="btn btn-primary mr-1" name="frmSubmit"><i class="fa fa-check-square-o"></i> Save</button>
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