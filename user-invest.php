<?
	include "includes/header.php";
	include "includes/profhead.php";
	
if(isset($cancel)) {
	$invesid = $_SESSION['invid'];
	$db->query("delete from contribute where invest_id=:id");
	$db->bind(":id", $invesid);
	$db->execute();
	unset($_SESSION["invid"]);
}
if(isset($invsuc)) {
	$extra->swalMsgSingle("Your investment success. Kindly check your email");
}

$db->query("select sum(c.contribute_amount) as act_invst from contribute c inner join project p on p.id=c.prjt_id and p.deadline >= '$tday' and p.contribute_amount < p.goal and c.user_id='$userlog' and c.pay_status='1'");
$active_invest = $db->fetch();

$db->query("select sum(c.contribute_amount) as suc_invst from contribute c inner join project p on p.id=c.prjt_id and p.contribute_amount >= p.goal and c.user_id='$userlog' and c.pay_status='1'");
$suc_invest = $db->fetch();

$db->query("select sum(c.contribute_amount) as unsuc_invst from contribute c inner join project p on p.id=c.prjt_id and p.deadline < '$tday' and p.contribute_amount < p.goal and c.user_id='$userlog' and c.pay_status='1'");
$unsuc_invest = $db->fetch();
?>
      <div class="container">
         <div class="row">
            <div class="col-sm-12">
               <div class="col-sm-12 dashboard">
                  <div class="row">
					<h2 class="mb15i">My Investment</h2>
                  </div>
				  <div class="row">
                     <div class="col-sm-12">
					    <h4>Investment</h4>
					   <div class="row dash_details">
							<div class="row">
								<div class="col-md-3 col-sm-6 col-xs-12">
									<div class="col-sm-12 dash_dtl_box">
										<div class="col-xs-4 text-center">
										  <i class="far fa-money-bill-alt font40px clr_txt mt50p" aria-hidden="true"></i>
										</div>
										<div class="col-xs-8 brdr_left">
										  <h2 class="dtls"><span><?=$site_currency;?></span> <?=$extra->nice_number($my_invest["tot_invst"]);?>&nbsp;</h2>
										  <h4>Total<br> Investment </h4>
										</div>
									</div>
								</div>
								
								<div class="col-md-3 col-sm-6 col-xs-12">
									<div class="col-sm-12 dash_dtl_box">
										<div class="col-xs-4 text-center">
										  <i class="far fa-clock font40px clr_txt mt50p" aria-hidden="true"></i>
										</div>
										<div class="col-xs-8 brdr_left">
										  <h2 class="dtls"><span><?=$site_currency;?></span> <?=$extra->nice_number($active_invest["act_invst"]);?>&nbsp;</h2>
										  <h4>Active <br> Investment</h4>
										</div>
									</div>
								</div>
								
								<div class="col-md-3 col-sm-6 col-xs-12">
									<div class="col-sm-12 dash_dtl_box">
										<div class="col-xs-4 text-center">
										  <i class="far fa-check-circle font40px clr_txt mt50p" aria-hidden="true"></i>
										</div>
										<div class="col-xs-8 brdr_left">
										  <h2 class="dtls"><span><?=$site_currency;?></span> <?=$extra->nice_number($suc_invest["suc_invst"]);?>&nbsp;</h2>
										  <h4>Successful Investment</h4>
										</div>
									</div>
								</div>
								
								<div class="col-md-3 col-sm-6 col-xs-12">
									<div class="col-sm-12 dash_dtl_box">
										<div class="col-xs-4 text-center">
										  <i class="far fa-thumbs-down font40px clr_txt mt50p" aria-hidden="true"></i>
										</div>
										<div class="col-xs-8 brdr_left">
										  <h2 class="dtls"><span><?=$site_currency;?></span> <?=$extra->nice_number($unsuc_invest["unsuc_invst"]);?>&nbsp;</h2>
										  <h4>Unsuccessful Investment </h4>
										</div>
									</div>
								</div>
							</div>
							
							<div class="row mt20">
								<div class="col-sm-12">
								<h4>Investment List</h4>
									<div class="table-responsive">
										<table id="example"  class="table table-striped dash_table" style="width:100%;border:1px solid #dadada;">
											<thead>
												<tr>
													<th>S.No</th>
													<th>Campaign Name</th>
													<th>Invest Amount <br />(<?=$site_currency;?>)</th>
													<th>Invested On</th>
													<!--<th>Close Date</th>-->
													<th>Investors</th>
													<th>Campaign Status</th>
													<th>Campaign Report</th>
													<th>Payment Proof</th>
												</tr>
											</thead>
											<tbody>
					<?php
					$i=1;
					$db->query("select * from contribute where user_id='$userlog' order by id desc");
					$result = $db->fetchAll();
					foreach($result as $row):
					$prjt_id = $row["prjt_id"];
					$encid = base64_encode($prjt_id);
					$title = $db->extractCol("select title from project where id='$prjt_id'");
					$deadline = $db->extractCol("select deadline from project where id='$prjt_id'");
					$goal = $db->extractCol("select goal from project where id='$prjt_id'");
					$inv_amt = $db->extractCol("select contribute_amount from project where id='$prjt_id'");
					$title = ucwords(stripslashes($title));
					$invest_dt = date("d-M-Y",strtotime($row['date']));
					$cls_dt = date("d-M-Y",strtotime($deadline));
					$percentage = $inv_amt/$goal;
					$per = $percentage*100;
					$per = round($per,2);
					$investor_ct = $general->tot_investors($prjt_id);
					$cid = $row["id"];
					if($row["pay_type"] == 2) {
						if(!empty($row["payslip"])) {
							$pay_proof = '<font color="blue">Uploaded </font>';
							$pay_prf = '';
							$pay_verify = '';
						}
						else if(empty($row["payslip"]) && ($deadline >= $tday)){
							$pay_proof = '';
							$pay_prf = "Pending<br /><a href='$baseUrl/pay-upload/$cid/' title='Click to upload your payslip'> Upload</a>";
							$pay_verify = '';
						}
						else {
							$pay_proof = '';
							$pay_prf = "Cancelled";
							$pay_verify = '';
						}
						if($row["pay_status"] == 1) {
							$pay_proof = '<font color="blue">Uploaded </font>';
							$pay_prf = '';
							$pay_verify = '<font color="green"> Verified </font>';
						}
					}
					else if($row["pay_type"] == 1) {
						$pay_prf = '';
						$pay_proof = '';
						$pay_verify = '';
					}
					if($goal <= $inv_amt){
						$prjt_sts = '<label class="label label-success">Success</label>';
					}
					else if(($goal > $inv_amt) && ($deadline >= $tday)) {
						$prjt_sts = '<label class="label label-warning">In Progress</label>';
					}
					else if(($goal > $inv_amt) && ($deadline < $tday)) {
						$prjt_sts = '<label class="label label-danger">Unsuccess</label>';
					}
					
					$reurl_title = $extra->reurl(stripslashes($title));
					?>						
												<tr>
													<td><?=$i;?></td>
													<td><a href="<?=$baseUrl;?>detail/<?=$reurl_title;?>/<?=$encid;?>/" target="_blank"><?=$title;?></a></td>
													<td><?=$row["contribute_amount"];?></td>
													<td><?=$invest_dt;?></td>
													<!--<td><?//=$cls_dt;?></td>-->
													<td><?=$investor_ct;?></td>
													<td><?=$prjt_sts;?></td>
													<td>
														<div class="progress">
														  <div data-percentage="0%" style="width: <?=$per;?>%;line-height: 5px;color: #f60f0f;" class="progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="<?=$per;?>"></div>
														  <div style="color: #ee1919;position: absolute;left: 77%;font-size: 11px;"><?=$per;?> %</div>
														</div>
														
														<p class="text-center small"><?=$site_currency.' '.$inv_amt;?> / <?=$goal;?></p>
													</td>
													<td><?=$pay_prf.' '.$pay_proof.' '.$pay_verify;?></td>
												</tr>
				<?php $i++; endforeach; ?>			
											</tbody>
										</table>
									</div>
								</div>
							</div>
					   </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
<? include "includes/footer.php"; ?>