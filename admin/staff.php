<?php
require "includes/header.php";

$isEdit=false;
if(isset($info)) $isEdit=true;

/** process if the form has been submitted **/
if(isset($_POST['frmSubmit'])) {
	if(!empty($pass) && $pass!=$pass_confirmation) {
		$extra->setMsg("Passwords do not match");
		$extra->redirect_to($baseUrl."staff/");
	}
	else {
		if(!empty($pass)) $passEnc=$user->pass_hash($pass);
		$set="name=:name";
		$set.=",email=:email";
		$set.=",mobile=:mobile";
		$set.=",role=:role";
		if(isset($passEnc)) $set.=",password='$passEnc'";
		if(!$isEdit) {
			$set.=",ipaddr='$ip'";
			$set.=",browser='$ua'";
			$set.=",recent_ipaddr='$ip'";
			$set.=",recent_browser='$ua'";
			$set.=",cdate='$timestamp'";
		}
		$set.=",udate='$timestamp'";
		if($isEdit) $que="update staff set $set where id=:id";
		else $que="insert into staff set $set";
		$db->query($que);
		$db->bind(":name", $name);
		$db->bind(":email", $email);
		$db->bind(":mobile", $mobile);
		$db->bind(":role", $role);
		if($isEdit) $db->bind(":id", $info);
		$exec=$db->execute();
		if($isEdit) $msg="updated";
		else $msg="created";
		$extra->setMsg("Staff $msg successfully!", "success");
		$extra->redirect_to($baseUrl."managestaff/");
	}
}
if($isEdit) {
	$db->query("select name,role,email,mobile from staff where id=:id");
	$db->bind(":id", $info);
	$result=$db->fetch();
	if(!empty($result)) extract($result);
	else $extra->redirect_to($baseUrl."managestaff/");
}
?>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-xs-12 mb-2">
                <h3 class="content-header-title mb-0"><?php echo ($isEdit)?"Edit":"Create"; ?> Staff</h3>
            </div>
        </div>
        <div class="content-body">
            <section id="html">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"><?php echo ($isEdit)?"Edit":"Create"; ?> Staff</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            </div>
                            <div class="card-body collapse in">
                                <div class="card-block card-dashboard table-responsive">
                                    <form class="form-horizontal" method="post">
                                        <div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Staff Name</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" name="name" value="<?php echo isset($name)?$name:''; ?>" data-validation="required" data-validation-error-msg-required="User name is required">
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Email Address</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="email" name="email" value="<?php echo isset($email)?$email:''; ?>" data-validation="required email" data-validation-error-msg-required="Email address is required" data-validation-error-msg-email="Invalid email address">
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Mobile</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" name="mobile" value="<?php echo isset($mobile)?$mobile:''; ?>" data-validation="required" data-validation-error-msg-required="Mobile number is required">
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Staff Role</label>
                                            <div class="col-sm-10">
												<select class="form-control" name="role" data-validation="required" data-validation-error-msg-required="Choose a role">
													<?php echo $drop->dropselect("select id,name from staff_roles where status='1'", isset($role)?$role:''); ?>
												</select>
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Password</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="password" name="pass_confirmation" <?php if(!isset($info)) { ?>data-validation="required" data-validation-error-msg-required="Password is required"<?php } ?>>
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Confirm Password</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="password" name="pass" <?php if(!isset($info)) { ?> data-validation="required confirmation" data-validation-error-msg-required="Reenter the password" data-validation-error-msg-confirmation="Passwords do not match"<?php } ?>>
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