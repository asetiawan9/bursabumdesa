<?
	include "includes/header.php";
	include "includes/profhead.php";
?>
      <div class="container">
         <div class="row">
            <div class="col-sm-12">
               <div class="col-sm-12 dashboard">
                  <div class="row">
					<h2 class="mb15i">My Transactions</h2>
                  </div>
				  <div class="row">
                     <div class="col-sm-12">
					   <div class="row ">
							<div class="col-sm-12">
								<h4>Transactions History</h4>
								<table id="example"  class="table table-striped dash_table" style="width:100%;border:1px solid #dadada;">
									<thead>
										<tr>
											<th>S.No</th>
											<th>Project</th>
											<th>Investment (In <?=$site_currency;?>)</th>
											<th>Earning (In <?=$site_currency;?>)</th>
											<th>Commission (%)</th>
											<th>Transaction <br />Date</th>
											<th>Details</th>
											<th>Proof ID</th>
										</tr>
									</thead>
									<tbody>
				<?php				
					$db->query("select id from contribute where user_id='$userlog' and pay_status='1'");
					$cntDets = $db->fetchAll();
					foreach($cntDets as $cntDet):
						$db->query("select * from transaction where contribute_id='".$cntDet["id"]."' order by id desc");
						$result = $db->fetchAll();
						$i = 1;
						foreach($result as $row):
						$cntid = $row['contribute_id'];
						$db->query("select prjt_id,contribute_amount from contribute where id='$cntid'");
						$invdet = $db->fetch();
						$pid = $invdet['prjt_id'];
						$db->query("select title,returns from project where id='$pid'");
						$prjtdet = $db->fetch();
						$prjt_title = ucwords(stripslashes($prjtdet['title']));
						if($row['trans_status'] == 1) $transid = $row['trans_proof'];
						else $transid = '';
						$encid = base64_encode($pid);
						if($row['trans_status'] == 1) $trans_sts = '<label class="label label-success">Credited</label>';
						else $trans_sts = '<label class="label label-warning">Pending</label>';
						$reurl_title = $extra->reurl($prjt_title);
					?>						
										<tr>
											<td><?=$i;?></td>
											<td><a href="<?=$baseUrl;?>detail/<?=$reurl_title;?>/<?=$encid;?>/" target="_blank"><?=$prjt_title;?></a></td>
											<td><?=$invdet['contribute_amount'];?></td>
											<td><?=$row['return_amt'];?></td>
											<td><?=$prjtdet['returns'];?></td>
											<td><?=date("d-M-Y",strtotime($row['trans_dt']));?></td>
											<td><?=$trans_sts;?></td>
											<td><?=$transid;?> </td>
										</tr>
					<?php $i++; endforeach;
						endforeach;
						?>				
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