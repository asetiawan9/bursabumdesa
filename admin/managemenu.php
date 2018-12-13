<?php
require "includes/header.php";

if(isset($_GET['chst'])) {
	$db->query("update menu set status=(status^1) where id=:id");
	$db->bind(":id", $chst);
	$db->execute();
	$extra->setMsg("Menu status changed successfully!", "success");
	$extra->redirect_to($baseUrl."managemenu/");
}
if(isset($_GET['rmv'])) {
	$db->query("delete from menu where id=:id");
	$db->bind(":id", $rmv);
	$db->execute();
	$extra->setMsg("Menu deleted successfully!", "success");
	$extra->redirect_to($baseUrl."managemenu/");
}
?>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-xs-12 mb-2">
                <h3 class="content-header-title mb-0">Manage Menus</h3>
            </div>
        </div>
        <div class="content-body">
            <section id="html">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Menu Management</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
										<?php if(isset($info)) { ?><a href="javascript:;" class="btn btn-sm btn-warning" onclick="window.history.back();">Back</a><?php } ?>
										<a href="<?php echo $baseUrl."menu/"; ?>" class="btn btn-sm btn-info">Create new</a>
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
                                                <th>Menu Name</th>
												<?php if(!isset($info)) { ?><th>Icon</th><?php } ?>
                                                <th>Filename</th>
                                                <?php if(!isset($info)) { ?><th>Submenu</th><?php } ?>
                                                <th>Created on</th>
                                                <th>Updated on</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php
											$i=1;
											if(isset($info)) $que="select * from menu where parent_id=:parent_id";
											else $que="select * from menu where parent_id='0'";
											$db->query($que);
											if(isset($info)) $db->bind(":parent_id", $info);
											$result=$db->fetchAll();
											foreach($result as $row):
											if($row['status']==1) { $cls="success"; $ico="check"; }
											else { $cls="danger"; $ico="times"; }
											$db->query("select * from menu where parent_id='$row[id]'");
											$submenucount=$db->rowCount();
											?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $row['name']; ?></td>
                                                <?php if(!isset($info)) { ?><td><i class="fa fa-<?php echo $row['icon']; ?>"></i></td><?php } ?>
                                                <td style="text-transform:none;"><?php echo $row['filename']; ?></td>
												<?php if(!isset($info)) { ?>
													<?php if($submenucount>0) { ?>
													<td><a href="<?php echo $baseUrl."managemenu/$row[id]/"; ?>"><label class="btn btn-sm btn-info"><?php echo $submenucount; ?></label></a></td>
													<?php } else { ?>
													<td><label class="btn btn-sm btn-info"><?php echo $submenucount; ?></label></td>
													<?php } ?>
												<?php } ?>
                                                <td><?php echo $row['cdate']; ?></td>
                                                <td><?php echo $row['udate']; ?></td>
                                                <td width="17%">
                                                    <div class="btn-group btn-sm" role="group" aria-label="Action">
                                                        <a href="<?php echo $baseUrl."menuinfo/$row[id]/"; ?>" type="button" class="btn btn-sm btn-icon btn-info"><i class="fa fa-search"></i></a>
                                                        <a href="<?php echo $baseUrl."managemenu/?chst=$row[id]"; ?>" class="btn btn-sm btn-icon btn-<?php echo $cls; ?>" onclick="return confirmAct();"><i class="fa fa-<?php echo $ico; ?>"></i></a>
                                                        <a href="<?php echo $baseUrl."menu/$row[id]/"; ?>" type="button" class="btn btn-sm btn-icon btn-warning"><i class="fa fa-pencil-square-o"></i></a>
                                                        <a href="<?php echo $baseUrl."managemenu/?rmv=$row[id]"; ?>" class="btn btn-sm btn-icon btn-danger" onclick="return confirmAct();"><i class="fa fa-trash"></i></a>
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