<?php
require "includes/header.php";

if(isset($info)) {
	$db->query("select * from slider where id=:id");
	$db->bind(":id", $info);
	$result=$db->fetch();
	if(!empty($result)) extract($result);
	else $extra->redirect_to($baseUrl."manage-slider/");
}
else $extra->redirect_to($baseUrl."manage-slider/");

if($chng_dt != '0000-00-00')
	$chng_dt = date('d-M-Y',strtotime($chng_dt));
else
	$chng_dt = '';
if($active_status == 1) $active_sts = 'Active';
else $active_sts = 'deactive';
?>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-xs-12 mb-2">
                <h3 class="content-header-title mb-0">Slider Details</h3>
            </div>
        </div>
        <div class="content-body">
            <section id="html">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Slider Details</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            </div>
                            <div class="card-body collapse in">
                                <div class="card-block card-dashboard table-responsive">
                                    <form class="form-horizontal" method="post">
                                        <div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Title</label>
											<label class="col-sm-1">:</label>
                                            <div class="col-sm-9"><?=$title; ?></div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Description </label>
											<label class="col-sm-1">:</label>
                                            <div class="col-sm-9"><?=stripslashes($description); ?></div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Button Name</label>
											<label class="col-sm-1">:</label>
                                            <div class="col-sm-9"><?=$button_name;?></div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Active Status</label>
											<label class="col-sm-1">:</label>
                                            <div class="col-sm-9"><?=$active_sts;?></div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Created On</label>
											<label class="col-sm-1">:</label>
                                            <div class="col-sm-9"><?=date('d-M-Y',strtotime($crc_dt));?></div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Created IP</label>
											<label class="col-sm-1">:</label>
                                            <div class="col-sm-9"><?=$crc_ip;?></div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Changed On </label>
											<label class="col-sm-1">:</label>
                                            <div class="col-sm-9"><?=$chng_dt;?></div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Changed IP</label>
                                            <div class="col-sm-10">: &nbsp;&nbsp;<?=$chng_ip;?></div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Slider Image</label>
											<label class="col-sm-1">:</label>
                                            <div class="col-sm-9"><img src="<?php echo $extra->chkprjtImg($image, "../uploads/settings/"); ?>" style="width:100%;" /></div>
                                        </div>
										<div class="form-actions col-sm-12">
                                            <a href="<?php echo $baseUrl."slider/$info/"; ?>" class="btn btn-primary mr-1"><i class="fa fa-check"></i> Edit</a>
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