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
	$extra->redirect_to($baseUrl."contributors/");
}
?>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-xs-12 mb-2">
                <h3 class="content-header-title mb-0">Manage Contributors</h3>
            </div>
        </div>
        <div class="content-body">
            <section id="html">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Contributors</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body collapse in">
                                <div class="card-block card-dashboard table-responsive">
									<?php $extra->flashMsg(); ?>
                                    <table id="datatable" class="table table-striped table-bordered sourced-data">
                                        <thead>
                                            <tr>
                                                <th>S.No.</th>
												<th>Invest ID</th>
												<th>Username</th>
												<th>Email Id</th>
												<th>Project </th>
												<th>Invest Amount<br /> (In <?=$site_currency;?>)</th>
												<th>Payout <br />Method</th>
												<th>Invest <br />Date /IP</th>
												<th>Pay Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php
											$i=1;
											$db->query("select * from contribute order by id desc");
											$result = $db->fetchAll();
											foreach($result as $row):
											$user_id = $row["user_id"];
											$prjt_id = $row["prjt_id"];
											$usrname = $db->extractCol("select firstname from register where id='$user_id'");
											$usremail = $db->extractCol("select email from register where id='$user_id'");
											$title = $db->extractCol("select title from project where id='$prjt_id'");
											$invest_dt = date("d-m-Y",strtotime($row["date"]));
											if($row['pay_status']==1) {
												$lnk = "<a href='#' class='btn btn-sm btn-icon btn-success'><i class='fa fa-check'></i></a>";
											}
											else {
												$hrf_lnk = $baseUrl."contributors/?chst=$row[id]&prjtid=$prjt_id";
												$lnk = "<a href='$hrf_lnk' class='btn btn-sm btn-icon btn-danger' onClick='return confirmAct();'><i class='fa fa-times'></i></a>";
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
                                                <td><?=ucwords(stripslashes($title)); ?></td>
                                                <td><?=$row['contribute_amount']; ?></td>
												<td><?=$pay_type; ?>
												<td><?=$invest_dt.'<br />'.$row['ip']; ?></td>
                                                <td>
                                                    <div class="btn-group btn-sm" role="group" aria-label="Action">
                                                        <a href="<?=$baseUrl."contributors-view/$row[id]/"; ?>" type="button" class="btn btn-sm btn-icon btn-info"><i class="fa fa-search"></i></a>
														<?=$lnk;?>
                                                    </div>
                                                </td>
                                            </tr>
											<?php $i++; endforeach; ?>
                                        </tbody>
                                    </table>
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