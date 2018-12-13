<?php
require "includes/header.php";

$isEdit=false;
if(isset($info)) $isEdit=true;
$currdate= date('Y-m-d H:i:s');
/** process if the form has been submitted **/
if(isset($bnk_sub)) {
	$set="bank_name=:bank_name";
	$set.=",branch_name=:branch_name";
	$set.=",acct_name=:acct_name";
	$set.=",account_num=:account_num";
	$set.=",ifsc=:ifsc";
	$set.=",date='$timestamp'";
	$set.=",ip='$ip_addr'";
	$que="update ad_bank_details set $set where id='1'";
	$db->query($que);
	$db->bind(":bank_name", $bank_name1);
	$db->bind(":branch_name", $branch_name1);
	$db->bind(":acct_name", $acct_name1);
	$db->bind(":account_num", $account_num1);
	$db->bind(":ifsc", $ifsc1);
	$exec = $db->execute();
	if($exec) {
		$extra->setMsg("Bank details updated successfully!", "success");
		$extra->redirect_to($baseUrl."bank-details/");
	}
}

$db->query("select * from ad_bank_details where id='1'");
$result=$db->fetch();
if(!empty($result)) extract($result);
$bank_name = isset($bank_name)?$bank_name:'';
$branch_name = isset($branch_name)?$branch_name:'';
$acct_name = isset($acct_name)?$acct_name:'';
$account_num = isset($account_num)?$account_num:'';
$ifsc = isset($ifsc)?$ifsc:'';
?>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-xs-12 mb-2">
                <h3 class="content-header-title mb-0">Bank Details </h3>
            </div>
        </div>
        <div class="content-body">
            <section id="html">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"> Bank Details</h4>
								<?php $extra->flashMsg(); ?>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            </div>
                            <div class="card-body collapse in">
                                <div class="card-block card-dashboard table-responsive">
                                    <form name="ad_bnkfrm" class="form-horizontal" method="post" action="">
                                        <div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Bank Name</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" type="text" name="bank_name1" value="<?=$bank_name;?>" required />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Branch Name</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" type="text" name="branch_name1" value="<?=$branch_name;?>" required />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Account Holder</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" type="text" name="acct_name1" value="<?=$acct_name;?>" required />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Account No.</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" type="text" name="account_num1" value="<?=$account_num;?>" required />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">IFSC </label>
                                            <div class="col-sm-6">
                                                <input class="form-control" type="text" name="ifsc1" value="<?=$ifsc;?>" required />
                                            </div>
                                        </div>
                                        <div class="form-actions center col-sm-12">
											<button type="submit" class="btn btn-primary mr-1" name="bnk_sub"><i class="fa fa-check-square-o"></i> Save</button>
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