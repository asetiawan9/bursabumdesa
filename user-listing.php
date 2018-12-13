<?
	include "includes/header.php";
	include "includes/profhead.php";
?>
      <div class="container">
         <div class="row">
            <div class="col-sm-12">
               <div class="col-sm-12 dashboard">
                  <div class="row">
					<h2 class="mb15i">My Campaigns</h2>
                  </div>
				  
				  <div class="row dash_details">
					<div class="col-sm-12">
						<h4>Campaigns Details</h4>
					</div>
					<div class="clearfix"></div>
					<div class="col-md-3 col-sm-6 col-xs-12">
						<div class="col-sm-12 dash_dtl_box">
							<div class="col-xs-4 text-center">
							  <i class="fas fa-list font40px clr_txt mt50p" aria-hidden="true"></i>
							</div>
							<div class="col-xs-8 brdr_left">
							  <h2 class="dtls"><?=$general->usr_totprjt($userlog);?>&nbsp;</h2>
							  <h4>Total<br> Campaigns </h4>
							</div>
						</div>
					</div>
					
					<div class="col-md-3 col-sm-6 col-xs-12">
						<div class="col-sm-12 dash_dtl_box">
							<div class="col-xs-4 text-center">
							  <i class="fas fa-trophy font40px clr_txt mt50p" aria-hidden="true"></i>
							</div>
							<div class="col-xs-8 brdr_left">
							  <h2 class="dtls"><?=$general->usr_sucprjt($userlog);?>&nbsp;</h2>
							  <h4>Successful <br> Campaigns </h4>
							</div>
						</div>
					</div>
					
					<div class="col-md-3 col-sm-6 col-xs-12">
						<div class="col-sm-12 dash_dtl_box">
							<div class="col-xs-4 text-center">
							  <i class="fas fa-thumbs-down font40px clr_txt mt50p" aria-hidden="true"></i>
							</div>
							<div class="col-xs-8 brdr_left">
							  <h2 class="dtls"><?=$general->usr_unsucprjt($userlog,$tday);?>&nbsp;</h2>
							  <h4>Unsuccessful <br> Campaigns </h4>
							</div>
						</div>
					</div>
					
					<div class="col-md-3 col-sm-6 col-xs-12">
						<div class="col-sm-12 dash_dtl_box">
							<div class="col-xs-4 text-center">
							  <i class="fas fa-hourglass-half font40px clr_txt mt50p" aria-hidden="true"></i>
							</div>
							<div class="col-xs-8 brdr_left">
							  <h2 class="dtls"><?=$general->usr_runprjt($userlog,$tday);?>&nbsp;</h2>
							  <h4>Running <br> Campaigns </h4>
							</div>
						</div>
					</div>
					
				  </div>
				  
				  <div class="row">
                     <div class="col-sm-12">
					   <div class="row mt20">
							<div class="col-sm-12">
								<h4>Campaigns List</h4>
								<table id="example"  class="table table-striped dash_table" style="width:100%;border:1px solid #dadada;">
									<thead>
										<tr>
											<th>S.No</th>
											<th>Name</th>
											<th>Start / End Date</th>
											<th>Investors</th>
											<th>Min Raise (<?=$site_currency;?>)</th>
											<th>Followers</th>
											<th>Status</th>
											<th>Campaign Report (<?=$site_currency;?>)</th>
											<th>Approval Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
				<?php
					$i=1;
					$db->query("select * from project where userid='$userlog' order by id desc");
					$result = $db->fetchAll();
					foreach($result as $row):
					$encid = base64_encode($row["id"]);
					if($row['active_status']==1) 
						$approv_sts = '<label class="label label-success">Approved</label>';
					else
						$approv_sts = '<label class="label label-success">Pending</label>';
					
					$title = ucwords(stripslashes($row['title']));
					$category = $row["category"];
					$cat_name = $db->extractCol("select catagory_name from category where id='$category'");
					$start_dt = date("d-M-Y",strtotime($row['start_dt']));
					$deadline = date("d-M-Y",strtotime($row['deadline']));
					$goal = $row["goal"];
					$contribute_amount = $row["contribute_amount"];
					$percentage = $contribute_amount/$goal;
					$per = $percentage*100;
					$per = round($per,2);
					if($goal <= $contribute_amount){
						$prjt_sts = '<label class="label label-success">Success</label>';
					}
					else if(($goal != $contribute_amount) && ($row["deadline"] >= $tday)) {
						$prjt_sts = '<label class="label label-warning">In Progress</label>';
					}
					else if(($goal != $contribute_amount) && ($row["deadline"] <= $tday)) {
						$prjt_sts = '<label class="label label-danger">Unsuccess</label>';
					}
					if($contribute_amount > 0) {
						$del_opt = '<a onClick="return del_cancl()" href="#"><i class="far fa-trash-alt"></i></a>';
					} else if($contribute_amount == 0) {
						$del_opt = "<a href=\"$baseUrl/user-listing/$row[id]/\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Delete\" onclick=\"return confirmAct();\"><i class=\"far fa-trash-alt\"></i></a>";
					}
					
					$reurl_title = $extra->reurl($title);
					?>											
										<tr>
											<td><?=$i;?></td>
											<td><a href="<?=$baseUrl;?>detail/<?=$reurl_title;?>/<?=$encid;?>/" target="_blank"><?=$title;?></a></td>
											<td><?=$start_dt;?> to <br /> <?=$deadline;?></td>
											<td><?=$general->tot_investors($row["id"]);?></td>
											<td><?=$row["min_raise"]; ?></td>
											<td><?=$general->followers($row["id"]);?></td>
											<td><?=$prjt_sts;?></td>
											<td>
												<div class="progress">
												  <div data-percentage="0%"  class="progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="<?=$per;?>"></div>
												  <div style="color: #f00505;position: absolute;left: 72%;font-size: 11px;"><?=$per;?>%</div>
												</div>
												<p class="text-center small"><?=$contribute_amount;?> / <?=$goal;?></p>
											</td>
											<td><?=$approv_sts;?></label></td>
											<td>
												<ul class="dash_table_action">
													<li><a target="_blank" href="<?=$baseUrl;?>detail/<?=$reurl_title;?>/<?=$encid;?>/" data-toggle="tooltip" data-placement="top" title="View"><i class="fas fa-search"></i></a></li>
													<li><a href="<?=$baseUrl;?>edit-project/<?=$row["id"];?>/" data-toggle="tooltip" data-placement="top" title="Edit"><i class="far fa-edit"></i></a></li>
													<li><?=$del_opt;?></li>
												</ul>
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
            </div>
         </div>
      </div>

<? include "includes/footer.php"; ?>