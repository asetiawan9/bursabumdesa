<?php
require "includes/header.php";

if(isset($info)) {
	$db->query("select * from contact_us where id=:id");
	$db->bind(":id", $info);
	$result=$db->fetch();
	if(!empty($result)) extract($result);
	else $extra->redirect_to($baseUrl."contact-us/");
}
else $extra->redirect_to($baseUrl."contact-us/");
?>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-xs-12 mb-2">
                <h3 class="content-header-title mb-0">User Contact Us Details</h3>
            </div>
        </div>
        <div class="content-body">
            <section id="html">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">User Contact Us Details</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            </div>
                            <div class="card-body collapse in">
                                <div class="card-block card-dashboard table-responsive">
                                    <form class="form-horizontal" method="post">
                                        <div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Username</label>
											<label class="col-sm-1">:</label>
                                            <div class="col-sm-9"><?=ucfirst($name); ?></div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Email </label>
											<label class="col-sm-1">:</label>
                                            <div class="col-sm-9"><?=$email; ?></div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Contact No. </label>
											<label class="col-sm-1">:</label>
                                            <div class="col-sm-9"><?=$ctc_num;?></div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Comment</label>
											<label class="col-sm-1">:</label>
                                            <div class="col-sm-9"><?=stripslashes($comment);?></div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Date</label>
											<label class="col-sm-1">:</label>
                                            <div class="col-sm-9"><?=date("d-M-Y",strtotime($date));?></div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">IP Address</label>
											<label class="col-sm-1">:</label>
                                            <div class="col-sm-9"><?=$ip;?></div>
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