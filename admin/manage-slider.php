<?php
require "includes/header.php";

if(isset($chksts)) {
	$db->query("update slider set active_status=(active_status^1) where id=:id");
	$db->bind(":id", $chksts);
	$db->execute();
	$extra->setMsg("Slider status changed successfully!", "success");
	$extra->redirect_to($baseUrl."manage-slider/");
}
if(isset($rmv)) {
    $db->query("select image from slider where id=:id");
	$db->bind(":id", $rmv);
	$result = $db->fetch();
	$sldrimg = $result['image'];
	if(($sldrimg!="") && file_exists('../uploads/settings/'.$sldrimg)) unlink('../uploads/settings/'.$sldrimg);
	
	$db->query("delete from slider where id=:id");
	$db->bind(":id", $rmv);
	$db->execute();
	$extra->setMsg("Slider deleted successfully!", "success");
	$extra->redirect_to($baseUrl."manage-slider/");
}
?>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-xs-12 mb-2">
                <h3 class="content-header-title mb-0">Manage Slider</h3>
            </div>
        </div>
        <div class="content-body">
            <section id="html">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Slider Management</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
										<a href="<?php echo $baseUrl."slider/"; ?>" class="btn btn-sm btn-info">Create new</a>
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
												<th>Image</th>
                                                <th>Slider <br />Title</th>
												<th>Slider <br />Description</th>
                                                <th>Button Name</th>
                                                <th>Date / IP</th>
												<th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php
											$i=1;
											$db->query("select * from slider order by id desc");
											$result=$db->fetchAll();
											foreach($result as $row):
											if($row['active_status']==1) { $cls="success"; $ico="check"; }
											else { $cls="danger"; $ico="times"; }
											$title = ucfirst(stripslashes($row["title"]));
											$description = ucfirst(stripslashes($row["description"]));
											$descript = $extra->checkLength($description,30);
											$crc_dt = date("d-M-Y",strtotime($row["crc_dt"]));
											$crcdt_ip = $crc_dt.'<b> /</b><br />'.$row['crc_ip'];
											if($row['chng_dt'] != '0000-00-00') {
												$chng_dt = date("d-M-Y",strtotime($row["chng_dt"]));
												$dt_ip = $chng_dt.'<b> /</b><br />'.$row['chng_ip'];
											}
											else
												$dt_ip = $crcdt_ip;
											?>
                                            <tr>
                                                <td><?=$i; ?></td>
												<td><img src='<?=$extra->chkprjtImg($row["image"], "../uploads/settings/");?>' width="80px" /></td>
												<td><?=$title; ?></td>
                                                <td width="30%"><?=$descript; ?></td>
                                                <td><?=stripslashes($row['button_name']);?></td>
												<td><?=$dt_ip; ?></td>
                                                <td width="17%">
                                                    <div class="btn-group btn-sm" role="group" aria-label="Action">
														<a href="<?php echo $baseUrl."slider-info/$row[id]/"; ?>" type="button" class="btn btn-sm btn-icon btn-info"><i class="fa fa-search"></i></a>
                                                        <a href="<?php echo $baseUrl."manage-slider/?chksts=$row[id]"; ?>" class="btn btn-sm btn-icon btn-<?php echo $cls; ?>" onclick="return confirmAct();"><i class="fa fa-<?php echo $ico; ?>"></i></a>
														<a href="<?php echo $baseUrl."slider/$row[id]/"; ?>" type="button" class="btn btn-sm btn-icon btn-warning"><i class="fa fa-pencil-square-o"></i></a>
													<? if($demo == 1) {?>
														<button onClick="return demo_user();" class="btn btn-sm btn-icon btn-danger"><i class="fa fa-trash"></i> </button>
													<? } else {?>
                                                        <a href="<?php echo $baseUrl."manage-slider/?rmv=$row[id]"; ?>" class="btn btn-sm btn-icon btn-danger" onclick="return confirmAct();"><i class="fa fa-trash"></i></a>
													<? } ?>
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