<?php
require "includes/header.php";

$isEdit=false;
if(isset($info)) $isEdit=true;
$currdate= date('Y-m-d H:i:s');
/** process if the form has been submitted **/
if(isset($cat_sub)) {
	$set="catagory_name=:cat_name";
	
	if($isEdit) {
		$set.=",chngdt='$currdate'";
		$que="update category set $set where id=:id";
		$db->query($que);
	}
	else {
		$cat_id = $db->extractCol("select id from category where catagory_name='$cat_name'");
		if(empty($cat_id)) {
			$set.=",crcdt='$currdate'";
			$que="insert into category set $set";
			$db->query($que);
		}
		else {
			$extra->setMsg("Category name already exists!", "danger");
			$extra->redirect_to($baseUrl."category/");
		}
	}
	$db->bind(":cat_name", $cat_name);
	if($isEdit) $db->bind(":id", $info);
	$exec=$db->execute();
	if($exec) {
		if($isEdit) $msg="updated";
		else $msg="created";
		$extra->setMsg("Category $msg successfully!", "success");
		$extra->redirect_to($baseUrl."manage-category/");
	}
}
if($isEdit) {
	$db->query("select catagory_name from category where id=:id");
	$db->bind(":id", $info);
	$result=$db->fetch();
	if(!empty($result)) extract($result);
	else $extra->redirect_to($baseUrl."manage-category/");
}
$catid=isset($catid)?$catid:'none';
?>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-xs-12 mb-2">
                <h3 class="content-header-title mb-0"><?php echo ($isEdit)?"Edit":"Create"; ?> Category</h3>
            </div>
        </div>
        <div class="content-body">
            <section id="html">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"><?php echo ($isEdit)?"Edit":"Create"; ?> Category</h4>
								<?php $extra->flashMsg(); ?>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            </div>
                            <div class="card-body collapse in">
                                <div class="card-block card-dashboard table-responsive">
                                    <form name="catfrm" class="form-horizontal" method="post" action="">
                                        <div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Category Name</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" type="text" name="cat_name" maxlength="25" value="<?php echo isset($catagory_name)?$catagory_name:''; ?>" required />
                                            </div>
                                        </div>
                                        <div class="form-actions center col-sm-12">
											<button type="submit" class="btn btn-primary mr-1" name="cat_sub"><i class="fa fa-check-square-o"></i> Save</button>
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