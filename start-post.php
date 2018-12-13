<? include "includes/header.php"; 

if(empty($userlog)) {
	$extra->redirect_to($baseUrl."login/");
}
else if(!empty($userlog) && ($usr_prjt_ct > 0)) {
	$extra->redirect_to($baseUrl."project-post/");
}

$camp_post_img = $extra->chkprjtImg($campaign_main_img, "uploads/settings/");
?>
 		<!-- Slider Section -->
		<section class="slider-section" style="background:url('<?=$camp_post_img;?>');background-position: center;background-repeat: no-repeat;background-size: cover;">
			 <div class="container-fulid post-product-bg">
				<div class="container">
					<div class="col-sm-12">
						<div class="post_content">
							<h1 class="ttl" style="">Raise Capital for Your Startup Online</h1>
							<h4 class="cntnt"><?=stripslashes($campaign_img_text);?></h4>
							<a href="<?=$baseUrl;?>project-post/" class="button btn-block">Get Started</a>
						</div>
					</div>
				</div>
			 </div>
		</section>
		<!-- End Slider Section -->
		<!-- Causes Section -->
		<section class="section causes-section-two pdb0i">
		    <div class="container">
                <div class="row">
                    <div class="section-heading">
                        <?=stripslashes($campaign_mid_text);?>
                    </div>

					<div class="row how-it-works nobg">
						<div class="col-sm-4 text-center">
							<img class="hw-image" src="<?=$extra->chkprjtImg($campaign_img1, "uploads/settings/"); ?>">
							<h4 class="hw-head"><b><?=stripslashes($campaign_text1_head);?></b></h4>
							<p class="hw-content"><?=stripslashes($campaign_text1);?></p>
						</div>
						
						<div class="col-sm-4 text-center">
							<img class="hw-image" src="<?=$extra->chkprjtImg($campaign_img2, "uploads/settings/"); ?>">
							<h4 class="hw-head"><b><?=stripslashes($campaign_text2_head);?></b></h4>
							<p class="hw-content"><?=stripslashes($campaign_text2);?></p>
						</div>
						
						<div class="col-sm-4 text-center">
							<img class="hw-image" src="<?=$extra->chkprjtImg($campaign_img3, "uploads/settings/"); ?>">
							<h4 class="hw-head"><b><?=stripslashes($campaign_text3_head);?></b></h4>
							<p class="hw-content"><?=stripslashes($campaign_text3);?></p>
						</div>
					</div>
                </div>
		    </div>
		</section>  
		<section class="You-Can-Bring">
				<div class="You-Can-Bring-Item-Wrapper">
					<div class="row mrgn0i">
						<div class="col-sm-6 col-xs-12">
							<div class="Bring-Item text-center">
								<?=stripslashes($midcnt1);?>
							</div> <!-- /.Bring-Item -->
						</div> <!-- /.col -->
						<div class="col-sm-6  col-xs-12">
							<div class="Bring-Item bring-item-bg-two text-center">
								<?=stripslashes($midcnt2);?>
							</div> <!-- /.Bring-Item -->
						</div> <!-- /.col -->
					</div> <!-- /.row -->
				</div> <!-- /.You-Can-Bring-Item-Wrapper -->
			</section>		
		<!-- End Causes Section --> 
		<!-- Helping Section -->
		<section class="section helping-section">
		<div class="container">
			<div class="row">
				<div class="section-heading">
					<h3>Featured Campaign</h3>
				</div>                    
			</div>
			<div class="row">
				<div class="col-sm-3">
					<ul class="nav nav-tabs dum-nav" role="tablist">
					<? 	$i = 1;
						$sq = "select c.id,c.catagory_name,p.category from category c inner join project p on c.id=p.category and c.active_status='1' and p.active_status='1' and p.start_dt<='$tday' and p.deadline>='$tday' and p.featured_status='1' group by p.category order by c.id asc";
						$db->query($sq);
						$result = $db->fetchAll();
						foreach($result as $row):
					?>
						<li role="presentation" class="<? if($i==1) echo 'active';?>"><a href="#<?=$row['id'];?>" aria-controls="<?=$row['id'];?>" role="tab" data-toggle="tab"><i class="fab fa-gripfire"></i><?=$row['catagory_name'];?></a></li>
					<? $i++; endforeach; ?>
					</ul>
			   </div>
				<div class="col-sm-9">
				  <!-- Tab panes -->
				  <div class="tab-content">
<?	
	$i = 1;
	$sq = "select * from project where active_status='1' and start_dt<='$tday' and deadline>='$tday' and featured_status='1' order by category asc";
	$db->query($sq);
	$result = $db->fetchAll();
	foreach($result as $row1):
?>
					<div role="tabpanel" class="tab-pane <? if($i==1) echo 'active';?>" id="<?=$row1['category'];?>">
						<div class="row">
<? 
	$cat = $row1['category'];
	$sq = "select * from project where active_status='1' and start_dt<='$tday' and deadline>='$tday' and featured_status='1' and category='$cat' order by category asc limit 3";
	$db->query($sq);
	$result = $db->fetchAll();
	foreach($result as $row):
	$img1 = $row["img1"];
	$prjtimg1 = $extra->chkprjtImg($img1, "uploads/prjt-img/img1/");
	if(!empty($prjtimg1)) {
		$img_src = $prjtimg1;
	}
	else {
		$img_src = $baseUrl.'uploads/prjt-img/img1/noimage.jpg';
	}
	$posted_by = $row["userid"];
	if($posted_by == 0) {
		$usrname = 'Admin';
		$usrimg = $baseUrl.'uploads/user-profile/emptyimg.png';
	}
	else {
		$usrname = $db->extractCol("select firstname from register where id='$posted_by'");
		$profile_img = $db->extractCol("select profile_image from register where id='$posted_by'");
		$usrimg = $extra->chkImg($profile_img, "uploads/user-profile/");
	}
	$goal = $row["goal"];
	$contribute_amount = $row["contribute_amount"];
	$percentage = $contribute_amount/$goal;
	$per1 = $percentage*100;
	$per = round($per1,2);
	$deadline = $row["deadline"];
	$deadline = str_replace('-', '/', $deadline);
	$target = $extra->datetimestamp($deadline);
	$current = time();
	$diff = $target-$current;
	$days = floor($diff/86400);
	if($days < 0) $days = 'Closed';
	else $days = $days.' Days Left';
	$prjt_sum = $row["prjt_sum"];
	$prjt_sum = strip_tags($prjt_sum, '<p>');
	$prjt_sum = stripslashes($extra->checkLength($prjt_sum,55));
	$enc_id = base64_encode($row["id"]);
	$reurl_title = $extra->reurl(stripslashes($row["title"]));
	?>
						
						<div class="col-sm-4">
						 <div class="single-causes-box">
							  <div class="causes-img">
								 <a href="<?=$baseUrl;?>detail/<?=$reurl_title;?>/<?=$enc_id;?>/"><img src="<?=$img_src;?>" alt="Causes Image"></a>
							  </div>
							  <div class="causes-content ctype_2">
								 <div class="postr_details">
									<a class="pro_img"><img src="<?=$usrimg;?>" alt="Image" class="img-circle"></a>
									<h4 class="pro_name"><a class="font12i"> <?=ucfirst($extra->checkLength($usrname,15)); ?></a></h4>
								 </div>
								 <h4 class="text-center"><a href="<?=$baseUrl;?>detail/<?=$reurl_title;?>/<?=$enc_id;?>/"><? echo ucwords(stripslashes($extra->checkLength($row["title"],30))); ?></a></h4>
								 <div class="col-sm-12 padd0 f_div">
									<p><?=$prjt_sum;?></p>
									<div class="row">
									   <div class="col-sm-6">
										  <h5 class="black"> Goal: <? echo $site_currency.' '.$goal;?></h5>
									   </div>
									   <div class="col-sm-6">
										  <h5 class="clr">Min. Raise: <? echo $site_currency.' '.$row["min_raise"];?></h5>
									   </div>
									</div>
								 </div>
								 <div class="col-sm-12 pdng0i b_div">
									<div class="col-sm-12"> <a href="<?=$baseUrl;?>detail/<?=$reurl_title;?>/<?=$enc_id;?>/" class="don_btn">Invest Now </a> </div>
									<div class="col-sm-12 mt30i">
									   <ul class="p_share">
										  <li>Share</li>
										  <li><a href="http://www.facebook.com/sharer.php?u=<?=$baseUrl;?>detail/<?=$reurl_title;?>/<?=$enc_id;?>/" target="_blank"><i class="fab fa-facebook-square facebook"></i></a></li>
										  <li><a href="https://twitter.com/share?url=<?=$baseUrl;?>detail/<?=$reurl_title;?>/<?=$enc_id;?>/&amp;text=<?=$baseUrl;?>&amp;hashtags=<?=$baseUrl;?>"><i class="fab fa-twitter-square twitter"></i></a></li>
										  <li><a href="https://plus.google.com/share?url=<?=$baseUrl;?>detail/<?=$reurl_title;?>/<?=$enc_id;?>/"><i class="fab fa-google-plus-square googleplus"></i></a></li>
										  <li><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?=$baseUrl;?>detail/<?=$reurl_title;?>/<?=$enc_id;?>/"><i class="fab fa-linkedin linkedin"></i></a></li>
									   </ul>
									</div>
								 </div>
								 <div class="clearfix"></div>
								 <div class="progress-outer">
									<div class="progress">
									   <div class="progress-bar progress-bar-info progress-bar-striped active" style="width:<?=$per;?>%;"></div>
									   <div class="progress-value"><?=$per;?>%</div>
									</div>
								 </div>
								 <div class="clearfix"></div>
								 <div class="clearfix"></div>
								 <div class="time-shedule">
									<ul>
									   <li class="left"><i class="fa fa-clock-o" aria-hidden="true"></i><?=$days;?> </li>
									   <li class="left"><i class="fas fa-map-marker-alt"></i> <? echo ucfirst($row["location"]); ?></li>
									</ul>
								 </div>
							  </div>
						   </div>	
						</div>	
		<? endforeach; ?>			
					</div>					
					</div>
<? $i++; endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section>     
		<!-- End Helping Section -->
		     
		   
<? include "includes/footer.php"; ?>