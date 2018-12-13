<?php
require "includes/header.php";

if(isset($rmv)) {
	$db->query("delete from enquiry where id=:id");
	$db->bind(":id", $rmv);
	$db->execute();
	$extra->setMsg("Enquiry deleted successfully!", "success");
	$extra->redirect_to($baseUrl."enquiry/");
}
?>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-xs-12 mb-2">
                <h3 class="content-header-title mb-0">Project Enquires</h3>
            </div>
        </div>
        <div class="content-body">
            <section id="html">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-header">
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
                                                <th>Business Title</th>
												<th>Username</th>
												<th>User Email</th>
                                                <th>Message</th>
                                                <th>Date/IP</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php
											$i = 1;
											$db->query("select * from enquiry order by id desc");
											$result = $db->fetchAll();
											foreach($result as $row):
											$msg = ucfirst(stripslashes($row["msg"]));
											$date = date("d-m-Y",strtotime($row["date"]));
											$prjt_id = $row["prjt_id"];
											$title = $db->extractCol("select title from project where id='$prjt_id'");
											$title = ucwords(stripslashes($title));
											$usrname = $db->extractCol("select firstname from register where id='".$row['user_id']."'");
											$usremail = $db->extractCol("select email from register where id='".$row['user_id']."'");
											$enq_on = $date.'<b> /</b><br />'.$row["ip"];
											
											?>
                                            <tr>
                                                <td><?=$i; ?></td>
												<td><?=$title;?></td>
												<td><?=ucfirst($usrname); ?></td>
												<td style="text-transform:none;"><?=$usremail;?></td>
                                                <td width="30%"><?=$msg; ?></td>
                                                <td><?=$enq_on;?></td>
                                                <td>
                                                    <div class="btn-group btn-sm" role="group" aria-label="Action">
                                                        <a href="<?php echo $baseUrl."enquiry/?rmv=$row[id]"; ?>" class="btn btn-sm btn-icon btn-danger" onclick="return confirmAct();"><i class="fa fa-trash"></i></a>
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