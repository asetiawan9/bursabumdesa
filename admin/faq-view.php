<?php
require "includes/header.php";

if(isset($info)) {
	$db->query("select * from faq where id=:id");
	$db->bind(":id", $info);
	$result=$db->fetch();
	if(!empty($result)) extract($result);
	else $extra->redirect_to($baseUrl."manage-faq/");
}
else $extra->redirect_to($baseUrl."manage-faq/");

if($chngdt != '0000-00-00')
	$chng_dt = date("d-M-Y",strtotime($chngdt));
else
	$chng_dt = '';
?>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-xs-12 mb-2">
                <h3 class="content-header-title mb-0">FAQ Details</h3>
            </div>
        </div>
        <div class="content-body">
            <section id="html">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">FAQ Details</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            </div>
                            <div class="card-body collapse in">
                                <div class="card-block card-dashboard table-responsive">
                                    <form class="form-horizontal" method="post">
                                        <div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Question </label>
											<label class="col-sm-1">: </label>
                                            <div class="col-sm-9"><?=stripslashes($question); ?></div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Answer </label>
											<label class="col-sm-1">: </label>
                                            <div class="col-sm-9"><?=stripslashes($ans); ?></div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Create Date </label>
											<label class="col-sm-1">: </label>
                                            <div class="col-sm-9"><?=date("d-M-Y",strtotime($crcdt));?></div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Create Ip </label>
											<label class="col-sm-1">: </label>
                                            <div class="col-sm-9"><?=$crc_ip;?></div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Change Date </label>
											<label class="col-sm-1">: </label>
                                            <div class="col-sm-9"><?=$chng_dt;?></div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Change IP</label>
											<label class="col-sm-1">: </label>
                                            <div class="col-sm-9"><?=$chng_ip;?></div>
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