<?php
require "includes/header.php";

if(isset($chksts)) {
	$db->query("update ask_question set active_status=(active_status^1) where id=:id");
	$db->bind(":id", $chksts);
	$db->execute();
	$extra->setMsg("Comment status changed successfully!", "success");
	$extra->redirect_to($baseUrl."manage-comment/");
}
if(isset($rmv)) {
	$db->query("delete from ask_question where id=:id");
	$db->bind(":id", $rmv);
	$db->execute();
	$extra->setMsg("Comment deleted successfully!", "success");
	$extra->redirect_to($baseUrl."manage-comment/");
}
?>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-xs-12 mb-2">
                <h3 class="content-header-title mb-0">Manage Comments</h3>
            </div>
        </div>
        <div class="content-body">
            <section id="html">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Comments Management</h4>
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
                                                <th>Business <br />Title</th>
												<th>Comment</th>
                                                <th>Reply</th>
                                                <th>Posted On</th>
												<th>Reply On</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php
											$i=1;
											$db->query("select * from ask_question order by id desc");
											$result=$db->fetchAll();
											foreach($result as $row):
											if($row['active_status']==1) { $cls="success"; $ico="check"; }
											else { $cls="danger"; $ico="times"; }
											$ques = ucfirst(stripslashes($row["ques"]));
											$ans = ucfirst(stripslashes($row["ans"]));
											$ans = $extra->checkLength($ans,30);
											$post_dt = date("d-M-Y",strtotime($row["ques_dt"]));
											if($row["ans_dt"] != '0000-00-00 00:00:00') {
												$reply_dt = date("d-M-Y",strtotime($row["ans_dt"]));
												$reply_on = $reply_dt.'<b> / </b>'.$row["ans_ip"];
											}
											else
												$reply_on = '';
											$prjt_id = $row["prjt_id"];
											$title = $db->extractCol("select title from project where id='$prjt_id'");
											$title = ucwords(stripslashes($title));
											$post_on = $post_dt.'<b> / </b>'.$row["ques_ip"];
											
											?>
                                            <tr>
                                                <td><?=$i; ?></td>
												<td><?=$title;?></td>
												<td width="30%"><?=$ques; ?></td>
                                                <td><?=$ans; ?></td>
                                                <td><?=$post_on;?></td>
												<td><?=$reply_on;?></td>
                                                <td width="12%">
                                                    <div class="btn-group btn-sm" role="group" aria-label="Action">
														<a href="<?php echo $baseUrl."comment-info/$row[id]/"; ?>" type="button" class="btn btn-sm btn-icon btn-info"><i class="fa fa-search"></i></a>
                                                        <a href="<?php echo $baseUrl."manage-comment/?chksts=$row[id]"; ?>" class="btn btn-sm btn-icon btn-<?php echo $cls; ?>" onclick="return confirmAct();"><i class="fa fa-<?php echo $ico; ?>"></i></a>
                                                        <a href="<?php echo $baseUrl."manage-comment/?rmv=$row[id]"; ?>" class="btn btn-sm btn-icon btn-danger" onclick="return confirmAct();"><i class="fa fa-trash"></i></a>
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