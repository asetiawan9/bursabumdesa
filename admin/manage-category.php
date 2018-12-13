<?php
require "includes/header.php";

if(isset($chksts)) {
	$db->query("update category set active_status=(active_status^1) where id=:id");
	$db->bind(":id", $chksts);
	$db->execute();
	$extra->setMsg("Category status changed successfully!", "success");
	$extra->redirect_to($baseUrl."manage-category/");
}
if(isset($rmv)) {
	$db->query("delete from category where id=:id");
	$db->bind(":id", $rmv);
	$db->execute();
	$extra->setMsg("Category deleted successfully!", "success");
	$extra->redirect_to($baseUrl."manage-category/");
}
?>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-xs-12 mb-2">
                <h3 class="content-header-title mb-0">Manage Category</h3>
            </div>
        </div>
        <div class="content-body">
            <section id="html">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Category Management</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
										<a href="<?php echo $baseUrl."category/"; ?>" class="btn btn-sm btn-info">Create new</a>
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
                                                <th>Category Name</th>
                                                <th>Business Count</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php
											$i=1;
											$db->query("select * from category order by catagory_name asc");
											$result=$db->fetchAll();
											foreach($result as $row):
											if($row['active_status']==1) { $cls="success"; $ico="check"; }
											else { $cls="danger"; $ico="times"; }
											$catname = strtolower($row["catagory_name"]);
											?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $row['catagory_name']; ?></td>
                                                <td><a href='<?=$baseUrl."project/$catname/$row[id]/";?>' target='_blank'> 
												<img src="<?=dirname($baseUrl);?>/images/right.png" /> <?php echo $general->prjt_under_cat($row['id']); ?> </a></td>
                                                <td>
                                                    <div class="btn-group btn-sm" role="group" aria-label="Action">
                                                        <a href="<?php echo $baseUrl."manage-category/?chksts=$row[id]"; ?>" class="btn btn-sm btn-icon btn-<?php echo $cls; ?>" onclick="return confirmAct();"><i class="fa fa-<?php echo $ico; ?>"></i></a>
                                                        <a href="<?php echo $baseUrl."category/$row[id]/"; ?>" type="button" class="btn btn-sm btn-icon btn-warning"><i class="fa fa-pencil-square-o"></i></a>
                                                        <a href="<?php echo $baseUrl."manage-category/?rmv=$row[id]"; ?>" class="btn btn-sm btn-icon btn-danger" onclick="return confirmAct();"><i class="fa fa-trash"></i></a>
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