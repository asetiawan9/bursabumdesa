<?php
require "includes/header.php";

if(isset($info)) {
	$db->query("select * from contribute where id=:id");
	$db->bind(":id", $info);
	$result=$db->fetch();
	if(!empty($result)) extract($result);
	else $extra->redirect_to($baseUrl."contributors/");
}
else $extra->redirect_to($baseUrl."contributors/");
$usrname = $db->extractCol("select firstname from register where id='$user_id'");
$usremail = $db->extractCol("select email from register where id='$user_id'");
$title = $db->extractCol("select title from project where id='$prjt_id'");
if($pay_type == 1)
	$pay_type = 'Paypal';
else if($pay_type == 2)
	$pay_type = 'Offline';
if($pay_status == 1)
	$pay_sts = 'Paid';
else if($pay_status == 0)
	$pay_sts = "<font color='red'>Pending </font>";
$invest_dt = date("d-m-Y",strtotime($date));
?>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-xs-12 mb-2">
                <h3 class="content-header-title mb-0">contributors Details</h3>
            </div>
        </div>
        <div class="content-body">
            <section id="html">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            </div>
                            <div class="card-body collapse in">
                                <div class="card-block card-dashboard table-responsive">
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Invest ID </label>
										<div class="col-sm-10">:  &nbsp;&nbsp;<?=$invest_id; ?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">User Name </label>
										<div class="col-sm-10">:  &nbsp;&nbsp;<?=ucwords($usrname); ?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Email Address </label>
										<div class="col-sm-10">:  &nbsp;&nbsp;<?=$usremail; ?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Business Title</label>
										<div class="col-sm-10">:  &nbsp;&nbsp;<?=ucwords(stripslashes($title));?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Invest Amount</label>
										<div class="col-sm-10">: &nbsp;&nbsp;<?=$site_currency.' '.$contribute_amount;?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Payout Method</label>
										<div class="col-sm-10">: &nbsp;&nbsp;<?=$pay_type;?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Pay Status</label>
										<div class="col-sm-10">: &nbsp;&nbsp;<?=$pay_sts;?></div>
									</div>
									<? if(!empty($payslip)) { ?>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Payment Proof</label>
										<div class="col-sm-10">: &nbsp;&nbsp;<img src="<?=dirname($baseUrl);?>/uploads/payproof/<?=$payslip;?>" width="100" /></div>
									</div>
									<? } ?>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Invested On</label>
										<div class="col-sm-10">: &nbsp;&nbsp;<?=$invest_dt;?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Invested IP</label>
										<div class="col-sm-10">: &nbsp;&nbsp;<?=$ip;?></div>
									</div>
									
									<div class="form-actions col-sm-12 abvbtn">
										<button type="button" class="btn btn-warning" onclick="window.history.back();"><i class="fa fa-mail-reply"></i> Back</button>
									</div>
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