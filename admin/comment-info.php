<?php
require "includes/header.php";

if(isset($info)) {
	$db->query("select * from ask_question where id=:id");
	$db->bind(":id", $info);
	$result=$db->fetch();
	if(!empty($result)) extract($result);
	else $extra->redirect_to($baseUrl."manage-comment/");
}
else $extra->redirect_to($baseUrl."manage-comment/");

$title = $db->extractCol("select title from project where id='$prjt_id'");
$title = ucwords(stripslashes($title));
$fname = $db->extractCol("select firstname from register where id='$user_id'");
$lname = $db->extractCol("select lastname from register where id='$user_id'");
$usrname = ucwords($fname.' '.$lname);
$post_dt = date("d-M-Y",strtotime($ques_dt));
if($ans_dt != '0000-00-00 00:00:00') {
	$reply_dt = date("d-M-Y",strtotime($ans_dt));
	$reply_ip = $ans_ip;
}
else {
	$reply_dt = '';
	$reply_ip = '';
}
?>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-xs-12 mb-2">
                <h3 class="content-header-title mb-0">User Comment Details</h3>
            </div>
        </div>
        <div class="content-body">
            <section id="html">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">User Comment Details</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            </div>
                            <div class="card-body collapse in">
                                <div class="card-block card-dashboard table-responsive">
                                    <form class="form-horizontal" method="post">
                                        <div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Project Title</label>
											<label class="col-sm-1">:</label>
                                            <div class="col-sm-9"><?=$title; ?></div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Posted Comment </label>
											<label class="col-sm-1">:</label>
                                            <div class="col-sm-9"><?=ucfirst(stripslashes($ques)); ?></div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Reply Comment</label>
											<label class="col-sm-1">:</label>
                                            <div class="col-sm-9"><?=ucfirst(stripslashes($ans));?></div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Posted By</label>
											<label class="col-sm-1">:</label>
                                            <div class="col-sm-9"><?=$usrname;?></div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Posted On</label>
											<label class="col-sm-1">:</label>
                                            <div class="col-sm-9"><?=$post_dt;?></div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Posted IP</label>
											<label class="col-sm-1">:</label>
                                            <div class="col-sm-9"><?=$ques_ip;?></div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Reply On </label>
											<label class="col-sm-1">:</label>
                                            <div class="col-sm-9"><?=$reply_dt;?></div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Reply IP</label>
											<label class="col-sm-1">:</label>
                                            <div class="col-sm-9"><?=$reply_ip;?></div>
                                        </div>
										<div class="form-actions col-sm-12">
                                            <button type="button" class="btn btn-warning" onclick="window.history.back();"><i class="fa fa-mail-reply"></i> Back</button>
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