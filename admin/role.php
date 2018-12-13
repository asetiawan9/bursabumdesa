<?php
require "includes/header.php";

$isEdit=false;
if(isset($info)) $isEdit=true;

/** process if the form has been submitted **/
if(isset($_POST['frmSubmit'])) {
	$set="name=:name";
	$set.=",can_access=:can_access";
	if(!$isEdit) $set.=",cdate='$timestamp'";
	$set.=",udate='$timestamp'";
	if($isEdit) $que="update staff_roles set $set where id=:id";
	else $que="insert into staff_roles set $set";
	$db->query($que);
	$db->bind(":name", $name);
	$db->bind(":can_access", json_encode($can_access));
	if($isEdit) $db->bind(":id", $info);
	$exec=$db->execute();
	if($isEdit) $msg="updated";
	else $msg="created";
	$extra->setMsg("Role $msg successfully!", "success");
	$extra->redirect_to($baseUrl."managerole/");
}
if($isEdit) {
	$db->query("select * from staff_roles where id=:id");
	$db->bind(":id", $info);
	$result=$db->fetch();
	if(!empty($result)) extract($result);
	else $extra->redirect_to($baseUrl."managerole/");
}
?>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-xs-12 mb-2">
                <h3 class="content-header-title mb-0"><?php echo ($isEdit)?"Edit":"Create"; ?> Role</h3>
            </div>
        </div>
        <div class="content-body">
            <section id="html">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"><?php echo ($isEdit)?"Edit":"Create"; ?> Role</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            </div>
                            <div class="card-body collapse in">
                                <div class="card-block card-dashboard table-responsive">
                                    <form class="form-horizontal" method="post">
                                        <div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Role Name</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" name="name" value="<?php echo isset($name)?$name:''; ?>" data-validation="required" data-validation-error-msg-required="Enter the role name">
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Can Access</label>
                                            <div class="col-sm-10">
                                                <?php
												$db->query("select * from menu where status='1' and parent_id='0'");
												$result=$db->fetchAll();
												foreach($result as $row):
													if(!empty($can_access) && in_array($row['id'], json_decode($can_access, true))) $ch="checked";
													else $ch="";
													echo '<input type="checkbox" name="can_access[]" value="'.$row['id'].'" data-validation="checkbox_group" data-validation-qty="min1" data-validation-error-msg-checkbox_group="Assign atleast a menu to the staff" '.$ch.'> '.$row['name'].'<br>';
												endforeach;
												?>
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