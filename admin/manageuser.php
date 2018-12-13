<?php
require "includes/header.php";

if(isset($chst)) {
	$db->query("update register set active_status=(active_status^1),tmp_key='0',email_active_status='1' where id=:id");
	$db->bind(":id", $chst);
	$db->execute();
	$extra->setMsg("User status changed successfully!", "success");
	$extra->redirect_to($baseUrl."manageuser/");
}
if(isset($msts)) {
	$mail_sts = $db->extractCol("select email_active_status from register where id='$msts'");
	if($mail_sts == 0)
		$db->query("update register set email_active_status='1' where id=:id");
	else
		$db->query("update register set email_active_status='0' where id=:id");
	$db->bind(":id", $msts);
	$db->execute();
	$extra->setMsg("User Email status changed successfully!", "success");
	$extra->redirect_to($baseUrl."manageuser/");
}
if(isset($rmv)) {
	$general->delUser($rmv);
	$db->query("delete from register where id=:id");
	$db->bind(":id", $rmv);
	$db->execute();
	$extra->setMsg("User deleted successfully!", "success");
	$extra->redirect_to($baseUrl."manageuser/");
}
?>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-xs-12 mb-2">
                <h3 class="content-header-title mb-0">Manage Users</h3>
            </div>
        </div>
        <div class="content-body">
            <section id="html">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">User Management</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
										<a href="<?php echo $baseUrl."user/"; ?>" class="btn btn-sm btn-info">Create new</a>
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
                                                <th>User Name</th>
                                                <th>Email Address</th>
												<th>posted<br />Projects</th>
												<th>Following<br />Projects</th>
                                                <th>Last Used IP</th>
                                                <!--<th>Last Used Browser</th>-->
                                                <th>Joined at</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
					<?php
						$i=1;
						$db->query("select * from register order by id desc");
						$result = $db->fetchAll();
						foreach($result as $row):
						if($row['active_status']==1) { $cls="success"; $ico="check"; }
						else { $cls="danger"; $ico="times"; }
						if($row['email_active_status']==1) { $m_cls="success"; $m_ico="check"; }
						else { $m_cls="danger"; $m_ico="times"; }
						$db->query("select * from follow where user_id='$row[id]'");
						$flwprjt_ct = $db->rowCount();
						$posted_prjts = $general->usr_totprjt($row['id']);
						$db->query("select * from contribute where user_id='$row[id]'");
						$invest_ct = $db->rowCount();
						$my_investors_ct = $general->mycamp_investors($row['id']);
						if($invest_ct > 0) {
							$delt_opt = '<a onClick="return del_cancl();" href="#" class="btn btn-sm btn-icon btn-danger"><i class="fa fa-trash"></i></a>';
						}
						else if($my_investors_ct > 0) {
							$delt_opt = '<a onClick="return del_cancl_prjtinv();" href="#" class="btn btn-sm btn-icon btn-danger"><i class="fa fa-trash"></i></a>';
						} else {
							$delt_opt = "<a href=\"$baseUrl/manageuser/?rmv=$row[id]\" class=\"btn btn-sm btn-icon btn-danger\" onclick=\"return confirmAct();\"><i class=\"fa fa-trash\"></i></a>";
						}
						?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $row['firstname']." " . $row['lastname']; ?></td>
                                                <td style="text-transform:none;"><?php echo $row['email']; ?></td>
												<td><a href='<?=$baseUrl."project/posted/$row[id]/";?>' target='_blank'> 
												<img src="<?=dirname($baseUrl);?>/images/right.png" /> <?=$posted_prjts;?> </a> </td>
												<td><a href='<?=$baseUrl."project/$row[id]/";?>' target='_blank'> 
												<img src="<?=dirname($baseUrl);?>/images/right.png" /> <?=$flwprjt_ct;?> </a> </td>
                                                <td><?php echo $row['login_ip_addr']; ?></td>
                                                <!--<td><?php echo $user->browserName($row['browser']); ?></td>-->
                                                <td><?php echo $row['crcdt']; ?></td>
                                                <td>
                                                    <div class="btn-group btn-sm" role="group" aria-label="Action">
                                                        <a href="<?php echo $baseUrl."userinfo/$row[id]/"; ?>" type="button" class="btn btn-sm btn-icon btn-info"><i class="fa fa-search"></i></a>
                                                        <a href="<?php echo $baseUrl."manageuser/?chst=$row[id]"; ?>" class="btn btn-sm btn-icon btn-<?php echo $cls; ?>" onclick="return confirmAct();" title="User Active status"><i class="fa fa-<?php echo $ico; ?>"></i></a>
                                                        <a href="<?php echo $baseUrl."user/$row[id]/"; ?>" type="button" class="btn btn-sm btn-icon btn-warning"><i class="fa fa-pencil-square-o"></i></a>
														<?=$delt_opt;?>
														<a href="<?php echo $baseUrl."manageuser/?msts=$row[id]"; ?>" class="btn btn-sm btn-icon btn-<?php echo $m_cls; ?>" onclick="return confirmAct();" title="Email Active status"><i class="fa fa-<?php echo $m_ico; ?>"></i></a>
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