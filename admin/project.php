<?php
require "includes/header.php";

if(isset($fsts)) {
	$db->query("update project set featured_status=(featured_status^1) where id=:id");
	$db->bind(":id", $fsts);
	$db->execute();
	$extra->setMsg("project Featured status changed successfully!", "success");
	$extra->redirect_to($baseUrl."project/");
}
if(isset($chst)) {
	$db->query("update project set active_status=(active_status^1) where id=:id");
	$db->bind(":id", $chst);
	$db->execute();
	$active_sts = $db->extractCol("select active_status from project where id='$chst'");
	$usrmail = $db->extractCol("select email from project where id='$chst'");
	if($active_sts == 1) {
		$subject = "Your Project Activation mail from $site_title";
		$site_logo_lnk = dirname($baseUrl)."/uploads/settings/$site_logo";
		$content = "<center>Your Project has been activated!</center>";
		$specific_title = "Let start raise funding to your project.";
		$btn_name = 'Click Here to visit the site';
		$message = $extra->customtemplate(dirname($baseUrl),$site_logo_lnk,$content,$site_title,dirname($baseUrl),$specific_title,$btn_name);
		$result = $common->email($admin_email,$usrmail,$subject,$message);
	}
	$extra->setMsg("project status changed successfully!", "success");
	$extra->redirect_to($baseUrl."project/");
}
if(isset($rmv)) {
	$general->delProject($rmv);
	$db->query("delete from project where id=:id");
	$db->bind(":id", $rmv);
	$db->execute();
	$extra->setMsg("Project deleted successfully!", "success");
	$extra->redirect_to($baseUrl."project/");
}
?>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-xs-12 mb-2">
                <h3 class="content-header-title mb-0">Manage Projects</h3>
            </div>
        </div>
        <div class="content-body">
            <section id="html">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Project Management</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
										<a href="<?php echo $baseUrl."add-project/"; ?>" class="btn btn-sm btn-info">Create new</a>
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
												<th>Project ID</th>
                                                <th>Title</th>
                                                <th>Category</th>
                                                <th>Process Bar</th>
                                                <!--<th>Last Used Browser</th>-->
                                                <th>Post on</th>
												<th>Featured <br /> Status</th>
												<th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
					<?php
					$i=1;
					if(isset($usr))
						$db->query("select p.*,f.prjt_id from project p inner join follow f on f.prjt_id=p.id and f.user_id='$usr' order by p.id desc");
					else if(isset($usrid))
						$db->query("select * from project where userid='$usrid' order by id desc");
					else if(isset($cat) && isset($catid))
						$db->query("select * from project where category='$catid' order by id desc");
					else
						$db->query("select * from project order by id desc");
					$result = $db->fetchAll();
					foreach($result as $row):
					if($row['active_status']==1) { $cls="success"; $ico="check"; }
					else { $cls="danger"; $ico="times"; }
					if($row['featured_status']==1) { $fcls="success"; $fico="check"; }
					else { $fcls="danger"; $fico="times"; }
					$title = ucwords(stripslashes($row['title']));
					$category = $row["category"];
					$cat_name = $db->extractCol("select catagory_name from category where id='$category'");
					$post_dt = date("d-M-Y",strtotime($row['crcdt']));
					$goal = $row["goal"];
					$contribute_amount = $row["contribute_amount"];
					$percentage = $contribute_amount/$goal;
					$per = $percentage*100;
					$per = round($per,2);
					$process_bar = "<div class='progress-outer'>
									<div class='progress'>
									   <div class='progress-bar progress-bar-info progress-bar-striped active' style='width:$per%;'></div>
									   <div class='progress-value'>$per%</div>
									</div>
									</div>
									Goal:<font color='green'>$site_currency $goal</font>&nbsp &nbsp &nbsp-	&nbsp &nbsp &nbsp Raised:<font color='blue'>$site_currency  $contribute_amount</font>";
					if($contribute_amount > 0) {
						$del_opt = '<a onClick="return del_cancl()" href="#" class="btn btn-sm btn-icon btn-danger"><i class="fa fa-trash"></i></a>';
					} else if($contribute_amount == 0) {
						$del_opt = "<a href=\"$baseUrl/project/?rmv=$row[id]\" class=\"btn btn-sm btn-icon btn-danger\" onClick=\"return confirmAct();\"><i class=\"fa fa-trash\"></i></a>";
					}
					?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
												<td><?php echo $row['post_id']; ?></td>
                                                <td width="20%"><?php echo $title; ?></td>
                                                <td><?php echo ucfirst($cat_name); ?></td>
                                                <td width="30%"><?php echo $process_bar; ?>	</td>
                                                <!--<td><?php echo $user->browserName($row['browser']);?></td>-->
												<td><?php echo $post_dt; ?></td>
												<td><a href="<?php echo $baseUrl."project/?fsts=$row[id]"; ?>" class="btn btn-sm btn-icon btn-<?php echo $fcls; ?>" onclick="return confirmAct();"><i class="fa fa-<?php echo $fico; ?>"></i></a></td>
                                                <td width="15%">
                                                    <div class="btn-group btn-sm" role="group" aria-label="Action">
                                                        <a href="<?php echo $baseUrl."project-info/$row[id]/"; ?>" type="button" class="btn btn-sm btn-icon btn-info"><i class="fa fa-search"></i></a>
                                                        <a href="<?php echo $baseUrl."project/?chst=$row[id]"; ?>" class="btn btn-sm btn-icon btn-<?php echo $cls; ?>" onclick="return confirmAct();"><i class="fa fa-<?php echo $ico; ?>"></i></a>
                                                        <a href="<?php echo $baseUrl."edit-project/$row[id]/"; ?>" type="button" class="btn btn-sm btn-icon btn-warning"><i class="fa fa-pencil-square-o"></i></a>
														<?=$del_opt;?>
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