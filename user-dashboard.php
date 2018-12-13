<?
	include "includes/header.php";
	include "includes/profhead.php";
?>
      <div class="container">
         <div class="row">
            <div class="col-sm-12">
               <div class="col-sm-12 dashboard">
                  <div class="row">
					<h2 class="mb15i">Dashboard</h2>
                  </div>
				  <div class="row">
                     <div class="col-sm-12">
					   
					   <div class="row dash_details">
							<div class="row">
								<div class="col-md-3 col-sm-6 col-xs-12">
									<div class="col-sm-12 dash_dtl_box">
										<div class="col-xs-4 text-center">
										  <i class="far fa-calendar-check font40px clr_txt mt50p" aria-hidden="true"></i>
										</div>
										<div class="col-xs-8 brdr_left">
										  <h2 class="dtls"><?=$general->usr_comprjt($userlog,$tday);?>&nbsp;</h2>
										  <h4>Completed Campaigns</h4>
										</div>
									</div>
								</div>
								
								<div class="col-md-3 col-sm-6 col-xs-12">
									<div class="col-sm-12 dash_dtl_box">
										<div class="col-xs-4 text-center">
										  <i class="far fa-clock font40px clr_txt mt50p" aria-hidden="true"></i>
										</div>
										<div class="col-xs-8 brdr_left">
										  <h2 class="dtls"><?=$tot_investor;?>&nbsp;</h2>
										  <h4>Running Investor</h4>
										</div>
									</div>
								</div>
								
								<div class="col-md-3 col-sm-6 col-xs-12">
									<div class="col-sm-12 dash_dtl_box">
										<div class="col-xs-4 text-center">
										  <i class="fas fa-angle-double-up font40px clr_txt mt50p" aria-hidden="true"></i>
										</div>
										<div class="col-xs-8 brdr_left">
										  <h2 class="dtls"><span><?=$site_currency;?></span> <?=$extra->nice_number($my_invest["tot_invst"]);?>&nbsp;<span></span></h2>
										  <h4>My Investments</h4>
										</div>
									</div>
								</div>
								
								<div class="col-md-3 col-sm-6 col-xs-12">
									<div class="col-sm-12 dash_dtl_box">
										<div class="col-xs-4 text-center">
										  <i class="fas fa-download font40px clr_txt mt50p" aria-hidden="true"></i>
										</div>
										<div class="col-xs-8 brdr_left">
										  <h2 class="dtls"><span><?=$site_currency;?></span> <?=$extra->nice_number($recv_invest);?>&nbsp;<span></span></h2>
										  <h4>Investments Received</h4>
										</div>
									</div>
								</div>
								
								<div class="col-md-3 col-sm-6 col-xs-12">
									<div class="col-sm-12 dash_dtl_box">
										<div class="col-xs-4 text-center">
										  <i class="fas fa-hourglass-half font40px clr_txt mt50p" aria-hidden="true"></i>
										</div>
										<div class="col-xs-8 brdr_left">
										  <h2 class="dtls"><?=$general->usr_runprjt($userlog,$tday);?>&nbsp; </h2>
										  <h4>Running Campaigns</h4>
										</div>
									</div>
								</div>
								
								<div class="col-md-3 col-sm-6 col-xs-12">
									<div class="col-sm-12 dash_dtl_box">
										<div class="col-xs-4 text-center">
										  <i class="far fa-handshake font40px clr_txt mt50p" aria-hidden="true"></i>
										</div>
										<div class="col-xs-8 brdr_left">
										  <h2 class="dtls"><?=$general->my_prjt_flwrs($userlog);?>&nbsp; </h2>
										  <h4>Campaign Followers</h4>
										</div>
									</div>
								</div>
								
								
								<div class="col-md-3 col-sm-6 col-xs-12">
									<div class="col-sm-12 dash_dtl_box">
										<div class="col-xs-4 text-center">
										  <i class="far fa-money-bill-alt font40px clr_txt mt50p" aria-hidden="true"></i>
										</div>
										<div class="col-xs-8 brdr_left">
										  <h2 class="dtls"><?=$general->mycamp_investors($userlog);?>&nbsp; </h2>
										  <h4>Campaigns Investors</h4>
										</div>
									</div>
								</div>
								
								
								<div class="col-md-3 col-sm-6 col-xs-12">
									<div class="col-sm-12 dash_dtl_box">
										<div class="col-xs-4 text-center">
										  <i class="fas fa-certificate font40px clr_txt mt50p" aria-hidden="true"></i>
										</div>
										<div class="col-xs-8 brdr_left">
										  <h2 class="dtls"><?=$general->usr_flwprjt($userlog);?>&nbsp; </h2>
										  <h4>Following Projects</h4>
										</div>
									</div>
								</div>
								
							</div>
					   </div>
					   
					   
					   <div class="row gallery">
					   <div class="col-sm-12">
						 <h4>Recent Campaigns</h4>
					   </div>
						 <div class="gallery-grid-4">
<?
	$i = 1;
	$sq = "select * from project where userid='$userlog' order by id desc limit 4";
	$db->query($sq);
	$result = $db->fetchAll();
	foreach($result as $row):
	$encid = base64_encode($row["id"]);
	$img1 = $row["img1"];
	$prjtimg1 = $extra->chkprjtImg($img1, "uploads/prjt-img/img1/");
	if(!empty($prjtimg1)) {
		$img_src = $prjtimg1;
	}
	else {
		$img_src = $baseUrl.'uploads/prjt-img/img1/noimage.jpg';
	}
	
	$goal = $row["goal"];
	$contribute_amount = $row["contribute_amount"];
	if($contribute_amount > 0) {
		$del_opt = '<a onClick="return del_cancl()" href="#"><i class="far fa-trash-alt"></i><br> Delete</a>';
	} else if($contribute_amount == 0) {
		$del_opt = "<a href=\"$baseUrl/user-dashboard/$row[id]/\" title=\"Delete\" onclick=\"return confirmAct();\"><i class=\"far fa-trash-alt\"></i><br> Delete</a>";
	}
	
	$reurl_title = $extra->reurl(stripslashes($row["title"]));
?>
							 <div class="single-item-4 col-md-3 col-sm-6 breakfast dinner health education food">
                                 <div class="gallery-img">
                                     <img src="<?=$img_src;?>" alt="" height="150" />
                                     <div class="overlay"></div>
                                     <div class="gallery-content">
                                        <div class="row">
											<div class="col-sm-6 text-center">
												<h4><a href="<?=$baseUrl;?>edit-project/<?=$row["id"];?>/"><i class="far fa-edit"></i><br> Edit</a></h4>
											</div>
											<div class="col-sm-6 text-center">
												<h4><?=$del_opt;?>
												</h4>
											</div>
										</div>
                                     </div>
                                 </div>
								 <div class="row mrgn0i">
									<div class="col-sm-12 text-center pdt10 project-details">
										<a href="<?=$baseUrl;?>detail/<?=$reurl_title;?>/<?=$encid;?>/" target="_blank">
											<h4><?=ucwords(stripslashes($row["title"]));?></h4>
										</a>
										<p><b>Goal: </b> <? echo $site_currency.' '.$goal;?></p>
										<p><b>Raised: </b> <? echo $site_currency.' '.$contribute_amount;?></p>
									</div>
								 </div>
                             </div>
				<?php $i++; endforeach; ?>
                         </div>
					   </div>
					   
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
<? include "includes/footer.php"; ?>