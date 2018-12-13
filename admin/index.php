<?php
require "includes/header.php";

if(isset($_GET['chst'])) 
{
	$db->query("update register set active_status=(active_status^1) where id=:id");
	$db->bind(":id", $chst);
	$db->execute();
	$extra->redirect_to($baseUrl);
}
?>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
			<div class="row">
			     <div class="col-sm-12">
			     <h4>User Report :</h4>
			   </div>
                <div class="col-xl-3 col-lg-6 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="p-2 text-xs-center bg-primary bg-darken-2 media-left media-middle"><i class="fa fa-users font-large-2 white"></i></div>
                                <div class="p-2  black media-body">
                                    <h5 class="text-bold-700" style="padding-top: 14px;">Total Users</h5>
                                    <h5><?php echo $general->totalUsers(); ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="col-xl-3 col-lg-6 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="p-2 text-xs-center bg-danger bg-darken-2 media-left media-middle"><i class="fa fa-users font-large-2 white"></i></div>
                                <div class="p-2 black media-body">
                                    <h5 class="text-bold-700" style="">Inactive Users</h5>
                                    <h5><?php echo $general->inactiveUsers(); ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="col-xl-3 col-lg-6 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="p-2 text-xs-center bg-success bg-darken-2 media-left media-middle"><i class="fa fa-users font-large-2 white"></i></div>
                                <div class="p-2 black media-body">
                                    <h5 class="text-bold-700" style="">Active Users</h5>
                                    <h5><?php echo $general->activeUsers(); ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="col-xl-3 col-lg-6 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="p-2 text-xs-center bg-warning bg-darken-2 media-left media-middle"><i class="fa fa-users font-large-2 white"></i></div>
                                <div class="p-2 black media-body">
                                    <h5 class="text-bold-700">Today Joined Users</h5>
                                    <h5><?php echo $general->todayUsers(); ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			
            <div class="row">
			<div class="col-sm-12">
			     <h4>Project Reports :</h4>
			   </div>
                <div class="col-xl-3 col-lg-6 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="p-2 text-xs-center bg-primary bg-darken-2 media-left media-middle"><i class="fa fa-cubes font-large-2 white"></i></div>
                                <div class="p-2  black media-body">
                                    <h5 class="text-bold-700" style="">Total Projects</h5>
                                    <h5><?php echo $general->totprjts(); ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="col-xl-3 col-lg-6 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="p-2 text-xs-center bg-danger bg-darken-2 media-left media-middle"><i class="fa fa-cube font-large-2 white"></i></div>
                                <div class="p-2 black media-body">
                                    <h5 class="text-bold-700" style="">Running Projects</h5>
                                    <h5><?php echo $general->rungprjts(); ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="col-xl-3 col-lg-6 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="p-2 text-xs-center bg-success bg-darken-2 media-left media-middle"><i class="fa fa-thumbs-up font-large-2 white"></i></div>
                                <div class="p-2 black media-body">
                                    <h5 class="text-bold-700" style="">Successful Projects</h5>
                                    <h5><?php echo $general->sucprjts(); ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="col-xl-3 col-lg-6 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="p-2 text-xs-center bg-warning bg-darken-2 media-left media-middle"><i class="fa fa-pause-circle-o font-large-2 white"></i></div>
                                <div class="p-2 black media-body">
                                    <h5 class="text-bold-700">UnSuccess Projects</h5>
                                    <h5><?php echo $general->unsucprjts(); ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			
			<div class="row">
			    <div class="col-sm-12">
			          <h4>Invest Reports :</h4>
			   </div>
			   <div class="col-xl-3 col-lg-6 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="p-2 text-xs-center bg-primary bg-darken-2 media-left media-middle"><i class="fa fa-users font-large-2 white"></i></div>
                                <div class="p-2 black media-body">
                                    <h5 class="text-bold-700" style="">Total Investors</h5>
                                    <h5><?php echo $general->total_investors(); ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="p-2 text-xs-center bg-danger bg-darken-2 media-left media-middle"><i class="fa fa-money font-large-2 white"></i></div>
                                <div class="p-2 black media-body">
                                    <h5 class="text-bold-700" style="">Total Raise</h5>
                                    <h5><?=$site_currency.' '.$extra->nice_number($general->total_invest());?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				
				<div class="col-xl-3 col-lg-6 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="p-2 text-xs-center bg-success bg-darken-2 media-left media-middle"><i class="fa fa-users font-large-2 white"></i></div>
                                <div class="p-2 black media-body">
                                    <h5 class="text-bold-700" style="">Today Investors </h5>
                                    <h5><?php echo $general->today_investors(); ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="col-xl-3 col-lg-6 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="p-2 text-xs-center bg-warning bg-darken-2 media-left media-middle"><i class="fa fa-money font-large-2 white"></i></div>
                                <div class="p-2 black media-body">
                                    <h5 class="text-bold-700">Today Raise</h5>
                                    <h5><?=$site_currency.' '.$extra->nice_number($general->today_invest());?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			
			
            <div class="row match-height">
                <div class="col-xl-12 col-lg-6">
                    <div class="card">
                        <div class="card-header card_bg_red">
                            <h4 class="card-title">Users Awaiting For Approval</h4>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body brdr_red">
                            <div class="table-responsive">
                                <table id="recent-orders" class="table table-hover mb-0 ps-container ps-theme-default">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>User Name</th>
											<th>Email</th>
                                            <th>Joined at</th>
                                            <th>Approve</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php
										$i=1;
										$db->query("select * from register where active_status!='1' order by id desc limit 5");
										$result=$db->fetchAll();
										if(empty($result)) echo '<tr><td colspan="4">No Records found</td></tr>';
										else {
										foreach($result as $row):
										$lastlog=$row['last_login_date'];
										$recentip=$row['recent_ipaddr'];
										if( ($lastlog=="0000-00-00 00:00:00") || empty($lastlog)){ $lastlog=$row['crcdt'];  }
										
										?>
                                        <tr>
                                            <td class="text-truncate"><?php echo $i; ?></td>
                                            <td class="text-truncate"><?php echo $row['firstname']." ".$row['lastname']; ?></td>
											<td class="text-truncate" style="text-transform:none;"><?php echo $row['email']; ?></td>
                                            <td class="text-truncate"><?php echo $lastlog ?></td>
                                            <td class="text-truncate"><a href="<?php echo $baseUrl."manageuser/?chst=$row[id]"; ?>" onclick="return confirmAct();" title="Click to approve"><i class="fa fa-2x fa-check-circle green"></i></a></td>
                                        </tr>
										<?php $i++; endforeach; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
				
                <div class="col-xl-12 col-lg-6">
                    <div class="card">
                        <div class="card-header card_bg_green">
                            <h4 class="card-title">Recently loggedin users</h4>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body brdr_green">
                            <div class="table-responsive">
                                <table id="recent-orders" class="table table-hover mb-0 ps-container ps-theme-default">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>User Name</th>
											<th>Email</th>
                                            <th>Recently Logged</th>
                                            <th>IP Address</th>
                                            <!--<th>Browser</th>-->
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php
										$i=1;
										$db->query("select * from register order by last_login_date desc limit 5");
										$result=$db->fetchAll();
										if(empty($result)) echo '<tr><td colspan="4">No Records found</td></tr>';
										else {
										foreach($result as $row):
										$lastlog=$row['last_login_date'];
										$recentip=$row['recent_ipaddr'];
										if( ($lastlog=="0000-00-00 00:00:00") || empty($lastlog)){ $lastlog=$row['crcdt'];  }
										if(empty($recentip)){ $recentip=$row['login_ip_addr']; }
										?>
                                        <tr>
                                            <td class="text-truncate"><?php echo $i; ?></td>
                                            <td class="text-truncate"><?php echo $row['firstname']." " .$row['lastname'] ; ?></td>
											<td class="text-truncate" style="text-transform:none;"><?php echo $row['email']; ?></td>
                                            <td class="text-truncate"><?php echo $lastlog; ?></td>
                                            <td class="text-truncate"><?php echo $recentip; ?></td>
                                            <!--<td class="text-truncate"><?php //echo $user->browserName($row['recent_browser']); ?></td>-->
                                        </tr>
										<?php $i++; endforeach; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
				
				<div class="col-xl-12 col-lg-6">
                    <div class="card">
                        <div class="card-header card_bg_green">
                            <h4 class="card-title">Ongoing Projects</h4>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body brdr_green">
                            <div class="table-responsive">
                                <table id="recent-orders" class="table table-hover mb-0 ps-container ps-theme-default">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Title</th>
											<th>Category</th>
                                            <th>Process Bar</th>
                                            <th>Invest End On</th>
                                            <th>View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php
										$i = 1;
										$db->query("select * from project where active_status='1' and start_dt<='$tday' and deadline>='$tday' and contribute_amount < goal order by id desc limit 5");
										$result=$db->fetchAll();
										if(empty($result)) echo '<tr><td colspan="4">No Records found</td></tr>';
										else {
										foreach($result as $row):
										$title = ucwords(stripslashes($row['title']));
										$category = $row["category"];
										$cat_name = $db->extractCol("select catagory_name from category where id='$category'");
										$inv_dt = date("d-M-Y",strtotime($row['deadline']));
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
										?>
                                        <tr>
                                            <td class="text-truncate"><?php echo $i; ?></td>
                                            <td class="text-truncate"><?php echo $title; ?></td>
											<td class="text-truncate"><?php echo $cat_name; ?></td>
                                            <td class="text-truncate"><?php echo $process_bar; ?></td>
                                            <td class="text-truncate"><?php echo $inv_dt; ?></td>
                                            <td class="text-truncate"><a target="_blank" href="<?php echo $baseUrl."project-info/$row[id]/"; ?>">View</a></td>
                                        </tr>
										<?php $i++; endforeach; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
				
				<div class="col-xl-12 col-lg-6">
                    <div class="card">
                        <div class="card-header card_bg_orng">
                            <h4 class="card-title">Projects Awaiting for Approval</h4>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body brdr_orng">
                            <div class="table-responsive">
                                <table id="recent-orders" class="table table-hover mb-0 ps-container ps-theme-default">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Title</th>
											<th>Category</th>
                                            <th>Process Bar</th>
                                            <th>Invest End On</th>
                                            <th>View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php
										$i = 1;
										$db->query("select * from project where active_status='0' order by id desc limit 5");
										$result=$db->fetchAll();
										if(empty($result)) echo '<tr><td colspan="4">No Records found</td></tr>';
										else {
										foreach($result as $row):
										$title = ucwords(stripslashes($row['title']));
										$category = $row["category"];
										$cat_name = $db->extractCol("select catagory_name from category where id='$category'");
										$inv_dt = date("d-M-Y",strtotime($row['deadline']));
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
										?>
                                        <tr>
                                            <td class="text-truncate"><?php echo $i; ?></td>
                                            <td class="text-truncate"><?php echo $title; ?></td>
											<td class="text-truncate"><?php echo $cat_name; ?></td>
                                            <td class="text-truncate"><?php echo $process_bar; ?></td>
                                            <td class="text-truncate"><?php echo $inv_dt; ?></td>
                                            <td class="text-truncate"><a target="_blank" href="<?php echo $baseUrl."project-info/$row[id]/"; ?>">View</a></td>
                                        </tr>
										<?php $i++; endforeach; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require "includes/footer.php"; ?>