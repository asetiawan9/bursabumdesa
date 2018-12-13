<?php
require "includes/header.php";

if(isset($_GET['chst'])) {
	$db->query("update staff set status=(status^1) where id=:id");
	$db->bind(":id", $chst);
	$db->execute();
	$extra->setMsg("Staff status changed successfully!", "success");
	$extra->redirect_to($baseUrl."managestaff/");
}
if(isset($_GET['rmv'])) {
	$db->query("delete from staff where id=:id");
	$db->bind(":id", $rmv);
	$db->execute();
	$extra->setMsg("Staff deleted successfully!", "success");
	$extra->redirect_to($baseUrl."managestaff/");
}
?>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-xs-12 mb-2">
                <h3 class="content-header-title mb-0">Manage Staff</h3>
            </div>
        </div>
        <div class="content-body">
            <section id="html">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Staff Management</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
										<a href="<?php echo $baseUrl."staff/"; ?>" class="btn btn-sm btn-info">Create new</a>
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
                                                <th>Staff Name</th>
                                                <th>Role</th>
                                                <th>Email Address</th>
                                                <th>Last Used IP</th>
                                                <th>Last Used Browser</th>
                                                <th>Joined at</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php
											$i=1;
											$db->query("select * from staff order by id desc");
											$result=$db->fetchAll();
											foreach($result as $row):
											if($row['status']==1) { $cls="success"; $ico="check"; }
											else { $cls="danger"; $ico="times"; }
											?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $general->roleName($row['role']); ?></td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td><?php echo $row['ipaddr']; ?></td>
                                                <td><?php echo $user->browserName($row['browser']); ?></td>
                                                <td><?php echo $row['cdate']; ?></td>
                                                <td>
                                                    <div class="btn-group btn-sm" role="group" aria-label="Action">
                                                        <a href="<?php echo $baseUrl."staffinfo/$row[id]/"; ?>" type="button" class="btn btn-sm btn-icon btn-info"><i class="fa fa-search"></i></a>
                                                        <a href="<?php echo $baseUrl."managestaff/?chst=$row[id]"; ?>" class="btn btn-sm btn-icon btn-<?php echo $cls; ?>" onclick="return confirmAct();"><i class="fa fa-<?php echo $ico; ?>"></i></a>
                                                        <a href="<?php echo $baseUrl."staff/$row[id]/"; ?>" type="button" class="btn btn-sm btn-icon btn-warning"><i class="fa fa-pencil-square-o"></i></a>
                                                        <a href="<?php echo $baseUrl."managestaff/?rmv=$row[id]"; ?>" class="btn btn-sm btn-icon btn-danger" onclick="return confirmAct();"><i class="fa fa-trash"></i></a>
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