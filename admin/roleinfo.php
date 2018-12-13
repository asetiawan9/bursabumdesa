<?php
require "includes/header.php";

if(isset($info)) {
	$db->query("select * from staff_roles where id=:id");
	$db->bind(":id", $info);
	$result=$db->fetch();
	if(!empty($result)) extract($result);
	else $extra->redirect_to($baseUrl."managerole/");
}
else $extra->redirect_to($baseUrl."managerole/");
?>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-xs-12 mb-2">
                <h3 class="content-header-title mb-0">Role Detail</h3>
            </div>
        </div>
        <div class="content-body">
            <section id="html">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Role Detail</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            </div>
                            <div class="card-body collapse in">
                                <div class="card-block card-dashboard table-responsive">
                                    <form class="form-horizontal" method="post">
                                        <div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Role Name :</label>
                                            <div class="col-sm-10"><?php echo $name; ?></div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Can Access :</label>
                                            <div class="col-sm-10"><?php echo $general->menuNamebyIDS($can_access); ?></div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Created on :</label>
                                            <div class="col-sm-10"><?php echo $cdate; ?></div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Updated on :</label>
                                            <div class="col-sm-10"><?php echo $udate; ?></div>
                                        </div>
										<div class="form-actions col-sm-12">
											<a href="<?php echo $baseUrl."role/$id/"; ?>" class="btn btn-primary mr-1"><i class="fa fa-check-square-o"></i> Edit</a>
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