<?php
require "includes/header.php";

if(isset($chksts)) {
	$db->query("update testimonial set active_status=(active_status^1) where id=:id");
	$db->bind(":id", $chksts);
	$db->execute();
	$extra->setMsg("Comment status changed successfully!", "success");
	$extra->redirect_to($baseUrl."testimonial/");
}
?>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-xs-12 mb-2">
                <h3 class="content-header-title mb-0">Manage Testimonial</h3>
            </div>
        </div>
        <div class="content-body">
            <section id="html">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Testimonial Management</h4>
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
												<th>Comment</th>
                                                <th>Posted On</th>
                                                <th>Updated On</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php
											$i = 1;
											$db->query("select * from testimonial order by id desc");
											$result=$db->fetchAll();
											foreach($result as $row):
											$uid = $row['user_id'];
											$usr_name = $db->extractCol("select firstname from register where id='$uid'");
											if($row['active_status']==1) { $cls="success"; $ico="check"; }
											else { $cls="danger"; $ico="times"; }
											$comment = stripslashes($row["comment"]);
											$post_dt = date("d-M-Y",strtotime($row["post_dt"]));							
											$chng_dt = date("d-M-Y",strtotime($row["chng_dt"]));
											$post_on = $post_dt.'<b> / </b>'.$row["post_ip"];
											if($row["chng_dt"] != '0000-00-00') {
												$chng_dt = date("d-M-Y",strtotime($row["chng_dt"]));
												$updt_on = $chng_dt.'<b> / </b>'.$row["chng_ip"];
											}
											else
												$updt_on = '';
											$imgsrc = dirname($baseUrl).'/images/right.png';
											$usr_lnk = "<a target='_blank' href='$baseUrl/userinfo/$uid/'> <img src='$imgsrc' /> $usr_name</a>";
											?>
                                            <tr>
                                                <td><?=$i; ?></td>
												<td width="12%"><?=$usr_lnk; ?></td>
												<td width="50%"><?=$comment;?></td>
                                                <td><?=$post_on;?></td>
												<td><?=$updt_on;?></td>
                                                <td>
                                                    <div class="btn-group btn-sm" role="group" aria-label="Action">
                                                        <a href="<?php echo $baseUrl."testimonial/?chksts=$row[id]"; ?>" class="btn btn-sm btn-icon btn-<?php echo $cls; ?>" onclick="return confirmAct();"><i class="fa fa-<?php echo $ico; ?>"></i></a>            
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