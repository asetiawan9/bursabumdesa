<?php
require "includes/header.php";

if(isset($trans_sub) && !empty($transid)) {	
	$set="trans_proof='$transid'";
	$set.=",trans_status='1'";
	$db->query("update transaction set $set where id=:id");
	$db->bind(":id", $t_id);
	$db->execute();
	$extra->setMsg("Status changed successfully!", "success");
	$extra->redirect_to($baseUrl."transaction/");
}
?>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-xs-12 mb-2">
                <h3 class="content-header-title mb-0">Manage Payout</h3>
            </div>
        </div>
        <div class="content-body">
            <section id="html">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Payout Management</h4>
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
                                                <th>S.No</th>
												<th>Username</th>
												<th>Project Title</th>
                                                <th>Invested (In <?=$site_currency;?>)</th>
                                                <th>Earning (In <?=$site_currency;?>)</th>
												<th>Commission(%)</th>
												<th>Transaction <br />Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
					<?php
						$i = 1;
						$db->query("select * from transaction order by id desc");
						$result = $db->fetchAll();
						foreach($result as $row):
						$cntid = $row['contribute_id'];
						$tid = $row['id'];
						$db->query("select prjt_id,contribute_amount,user_id from contribute where id='$cntid'");
						$invdet = $db->fetch();
						$uid = $invdet['user_id'];
						$pid = $invdet['prjt_id'];
						$usr_name = $db->extractCol("select firstname from register where id='$uid'");
						$db->query("select title,returns from project where id='$pid'");
						$prjtdet = $db->fetch();
						$prjt_title = ucwords(stripslashes($prjtdet['title']));
						if($row['trans_status'] == 1) {
							$btn = '<button class="btn btn-success" style="cursor:default;">Success </button>';
						}
						else {
							$btn = "<a href=\"#\" class=\"btn btn-warning transId\" data-toggle=\"modal\" data-target=\"#myModal\" data-id=\"$tid\">Pending</a>";
						}
						$imgsrc = dirname($baseUrl).'/images/right.png';
						$usr_lnk = "<a target='_blank' href='$baseUrl/userinfo/$uid/'> <img src='$imgsrc' /> $usr_name</a>";
						?>
                                            <tr>
                                                <td><?=$i;?></td>
												<td width="15%"><?=$usr_lnk; ?></td>
												<td width="30%"><?=$prjt_title;?></td>
                                                <td><?=$invdet['contribute_amount'];?></td>
												<td><?=$row['return_amt'];?></td>
												<td><?=$prjtdet['returns'];?></td>
												<td><?=date("d-M-Y",strtotime($row['trans_dt']));?></td>
                                                <td>
                                                    <div class="btn-group btn-sm" role="group" aria-label="Action">
														<?=$btn;?>	           
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
<!----MOdal--->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Transaction Proof</h4>
      </div>
	  <form method="post">
	  <input type="hidden" name="t_id" id="tId" />
      <div class="modal-body">
		  <div class="form-group">
			<label for="exampleInputid1">Transaction Id</label>
			<input type="text" name="transid" class="form-control" id="exampleInputid1" placeholder="trnx110011" required />
		  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name="trans_sub" class="btn btn-primary">Submit </button>
      </div>
	  </form>
    </div>
  </div>
</div>

<script>
$(document).ready(function () {             
    $('.transId').click(function(){
        $('#tId').val($(this).data('id'));
    });
});
</script>
<?php require "includes/footer.php"; ?>