<?php
require "includes/header.php";

if(isset($chst)) {
	$set="pay_status='1'";
	$set.=",payslip_upddt='$tday'";
	$db->query("update contribute set $set where id=:id");
	$db->bind(":id", $chst);
	$exc = $db->execute();	
	$cont_amt = $db->extractCol("select contribute_amount from contribute where id='$chst'");
	$get_ctamt = $db->extractCol("select contribute_amount from project where id='$prjtid'");
	$tot_ctamt = $get_ctamt + $cont_amt;
	$que = "update project set contribute_amount='$tot_ctamt' where id='$prjtid'";
	$db->query($que);
	$exec = $db->execute();	
	$extra->setMsg("Pay status changed successfully!", "success");
	$extra->redirect_to($baseUrl."project-info/$prjtid/");
}
if(isset($info)) {
	$db->query("select * from project where id=:id");
	$db->bind(":id", $info);
	$result=$db->fetch();
	if(!empty($result)) extract($result);
	else $extra->redirect_to($baseUrl."project/");
}
else $extra->redirect_to($baseUrl."project/");
if($user_type==0) { ?>
	<script>
	$(document).ready(function () {
		$('#frlncerId').removeClass('hidden');			
		$('#cmpyId').addClass('hidden');
	});
	</script>
<? }
if($user_type==1) { ?>
	<script>
	$(document).ready(function () {
		$('#cmpyId').removeClass('hidden');			
		$('#frlncerId').addClass('hidden');
	});
	</script>
<? }

if($userid != 0) {
	$posted_by = $db->extractCol("select firstname from register where id='$userid'");
	$email = $db->extractCol("select email from register where id='$userid'");
}
else {
	$posted_by = 'Admin';
	$email = 'Admin';
}
$prjtimg1 = $extra->chkprjtImg($img1, "../uploads/prjt-img/img1/");
$prjtimg2 = $extra->chkprjtImg($img2, "../uploads/prjt-img/img2/");
$prjtimg3 = $extra->chkprjtImg($img3, "../uploads/prjt-img/img3/");
$prjtimg4 = $extra->chkprjtImg($img4, "../uploads/prjt-img/img4/");
$document = $extra->chkprjtImg($doc, "../uploads/documents/");
$video = $extra->chkprjtImg($video, "../uploads/video/");

if(empty($prjtimg1)) {
	$prjtimg1 = dirname($baseUrl)."/uploads/prjt-img/img1/noimage.jpg";
}
if(!empty($prjtimg2)) { ?>
	<script>
	$(document).ready(function () {
		$('#imgId2').removeClass('hidden');
	});
	</script>
<? }
if(!empty($prjtimg3)) { ?>
	<script>
	$(document).ready(function () {
		$('#imgId3').removeClass('hidden');
	});
	</script>
<? }
if(!empty($prjtimg4)) { ?>
	<script>
	$(document).ready(function () {
		$('#imgId4').removeClass('hidden');
	});
	</script>
<? }
$category = $db->extractCol("select catagory_name from category where id='$category'");
$deadline = date("d-M-Y",strtotime($deadline));
$start_dt = date("d-M-Y",strtotime($start_dt));
$tot_members = ($tot_members != 0)?$tot_members:'';
if($repay_duration == 0) $repay_dur = 'Month';
else if($repay_duration == 1) $repay_dur = 'Year';
if($hold_duration == 0) $hold_dur = 'Month';
else if($hold_duration == 1) $hold_dur = 'Year';
?>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-xs-12 mb-2">
                <h3 class="content-header-title mb-0">Campaign Details</h3>
            </div>
        </div>
        <div class="content-body">
            <section id="html">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-header">
							<?php $extra->flashMsg(); ?>
                                <h4 class="card-title">Fund Raiser Details</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            </div>
                            <div class="card-body collapse in">
                                <div class="card-block card-dashboard table-responsive">
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Posted By </label>
										<label class="col-sm-1 ">: </label>
										<div class="col-sm-9"><?=ucfirst($posted_by); ?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">User Email </label>
										<label class="col-sm-1 ">: </label>
										<div class="col-sm-9"><?=$email; ?></div>
									</div>
									
									<div id="cmpyId" class="hidden">
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Company Name</label>
										<label class="col-sm-1 ">: </label>
										<div class="col-sm-9"><?=ucwords($cmpy_name);?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Company Location</label>
										<label class="col-sm-1 ">: </label>
										<div class="col-sm-10"><?=ucfirst($cmpy_loc);?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Year Founded</label>
										<div class="col-sm-10">: &nbsp;&nbsp;<?=$cmpy_yrfound;?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Company Type </label>
										<label class="col-sm-1 ">: </label>
										<div class="col-sm-9"><?=ucfirst($cmpy_type);?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Company Url</label>
										<label class="col-sm-1 ">: </label>
										<div class="col-sm-9"><?=$cmpy_url;?></div>
									</div>
									</div>
									<div id="frlncerId" class="hidden">
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Qualification</label>
										<label class="col-sm-1 ">: </label>
										<div class="col-sm-9"><?=$edu_qual;?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Experience </label>
										<label class="col-sm-1 ">: </label>
										<div class="col-sm-9"><?=$exp;?></div>
									</div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Company Highlights </label>
										<label class="col-sm-1 ">: </label>
										<div class="col-sm-9"><?=stripslashes($highlights); ?></div>
									</div>
									
									<div class="card-header">
										<h4 class="card-title">Team Members</h4>
										<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Team Lead Name </label>
										<label class="col-sm-1 ">: </label>
										<div class="col-sm-9"><?=ucwords($lead_name); ?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Team Lead Role </label>
										<label class="col-sm-1 ">: </label>
										<div class="col-sm-9"><?=$lead_role; ?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Total Members</label>
										<label class="col-sm-1 ">: </label>
										<div class="col-sm-9"><?=$tot_members; ?></div>
									</div>
									
									<div class="card-header">
										<h4 class="card-title">Campaign Details</h4>
										<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Project Title </label>
										<label class="col-sm-1 ">: </label>
										<div class="col-sm-9"><?=ucwords(stripslashes($title)); ?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Category </label>
										<label class="col-sm-1 ">: </label>
										<div class="col-sm-9"><?=$category; ?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Goal Amount</label>
										<label class="col-sm-1 ">: </label>
										<div class="col-sm-9"><?=$site_currency.' '.$goal; ?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Minimum Raise </label>
										<label class="col-sm-1 ">: </label>
										<div class="col-sm-9"><?=$site_currency.' '.$min_raise; ?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Repayment </label>
										<label class="col-sm-1 ">: </label>
										<div class="col-sm-9"><?=$repay_period.' '.$repay_dur; ?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Returns(%) </label>
										<label class="col-sm-1 ">: </label>
										<div class="col-sm-9"><?=$returns; ?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Raise Starting Date </label>
										<label class="col-sm-1 ">: </label>
										<div class="col-sm-9"><?=$start_dt; ?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Raise Closing Date </label>
										<label class="col-sm-1 ">: </label>
										<div class="col-sm-9"><?=$deadline; ?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Hold Period </label>
										<label class="col-sm-1 ">: </label>
										<div class="col-sm-9"><?=$hold_period.' '.$hold_dur; ?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Description</label>
										<label class="col-sm-1 ">: </label>
										<div class="col-sm-9"><?=stripslashes($descript); ?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Investment <br />Terms</label>
										<label class="col-sm-1 ">: </label>
										<div class="col-sm-9"><?=stripslashes($invest_term); ?></div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Project <br />Summary </label>
										<label class="col-sm-1 ">: </label>
										<div class="col-sm-9"><?=stripslashes($prjt_sum); ?></div>
									</div>
									
									<div class="card-header">
										<h4 class="card-title">Document</h4>
										<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">IM </label>
										<label class="col-sm-1 ">: </label>
										<div class="col-sm-9"><?=$doc; ?>
										<? if(!empty($document)) { ?>
										<a href="<?=dirname($baseUrl);?>/uploads/documents/<?=$doc;?>" title="Click to download">
											<img src="<?=dirname($baseUrl);?>/images/Downloads-icon.png" height="40px" />
										</a>
										<? } ?>
										</div>
									</div>
									<div class="form-group col-sm-12">
										<label class="col-sm-2 control-label">Project Video </label>
										<label class="col-sm-1 ">: </label>
										<div class="col-sm-9">
										<? if(!empty($video)) { ?>
										<video width="300" height="200" controls>
											<source src="<?=$video; ?>" type="video/mp4">
										</video>
										<? } ?>
										</div>
									</div>
									
									<div class="card-header">
										<h4 class="card-title">Image Gallery</h4>
										<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
									</div>
									<div class="form-group ">
										<div id="imgId1" class="col-sm-3">
											<img class="" src="<?=$prjtimg1; ?>" style="height:150px;width:230px;" />
										</div>
										<div id="imgId2" class="col-sm-3 hidden">
											<img class="" src="<?=$prjtimg2; ?>" style="height:150px;width:230px;" />
										</div>
										<div id="imgId3" class="col-sm-3 hidden">
											<img class="" src="<?=$prjtimg3; ?>" style="height:150px;width:230px;" />
										</div>
										<div id="imgId4" class="col-sm-3 hidden">
											<img class="" src="<?=$prjtimg4; ?>" style="height:150px;width:230px;" />
										</div>
									</div>
										
								<div class="card-block card-dashboard table-responsive">
								<div class="card-header abvbtn">
									<h4 class="card-title">Investors</h4>
									<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
								</div>
                                    <table id="datatable" class="table table-striped table-bordered sourced-data">
                                        <thead>
                                            <tr>
                                                <th>S.No.</th>
												<th>Invest ID</th>
												<th>Username</th>
												<th>Email Id</th>
												<th>Invest Amount<br /> (In <?=$site_currency;?>)</th>
												<th>Payout <br />Method</th>
												<th>Invest <br />Date /IP</th>
												<th>Pay Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php
											$i=1;
											$db->query("select * from contribute where prjt_id='$info' order by id desc");
											$result = $db->fetchAll();
											foreach($result as $row):
											$user_id = $row["user_id"];
											$usrname = $db->extractCol("select firstname from register where id='$user_id'");
											$usremail = $db->extractCol("select email from register where id='$user_id'");
											$invest_dt = date("d-m-Y",strtotime($row["date"]));
											if($row['pay_status']==1) {
												$lnk = "<a href='#' class='btn btn-sm btn-icon btn-success'><i class='fa fa-check'></i></a>";
											}
											else {
												$hrf_lnk = $baseUrl."project-info/?chst=$row[id]&prjtid=$info";
												$lnk = "<a href='$hrf_lnk' class='btn btn-sm btn-icon btn-danger' title='Click if User has paid' onClick='return confirmAct();'><i class='fa fa-times'></i></a>";
											}
											if($row["pay_type"] == 1)
												$pay_type = 'Paypal';
											else if($row["pay_type"] == 2)
												$pay_type = 'Offline';
											?>
                                            <tr>
                                                <td><?=$i; ?></td>
                                                <td><?=$row['invest_id']; ?></td>
                                                <td><?=ucwords($usrname); ?></td>
                                                <td style="text-transform:none;"><?=$usremail; ?></td>
                                                <td><?=$row['contribute_amount']; ?></td>
												<td><?=$pay_type; ?>
												<td><?=$invest_dt.'<br />'.$row['ip']; ?></td>
                                                <td>
                                                    <div class="btn-group btn-sm" role="group" aria-label="Action">
                                                        <a target="_blank" href="<?=$baseUrl."contributors-view/$row[id]/"; ?>" type="button" class="btn btn-sm btn-icon btn-info"><i class="fa fa-search"></i></a>
														<?=$lnk;?>
                                                    </div>
                                                </td>
                                            </tr>
											<?php $i++; endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
									<div class="form-actions col-sm-12 abvbtn">
										<a href="<?php echo $baseUrl."edit-project/$id/"; ?>" class="btn btn-primary mr-1"><i class="fa fa-check-square-o"></i> Edit</a>
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