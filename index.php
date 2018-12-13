<? include "includes/header.php"; ?>
 		<!-- Slider Section -->
		<section class="slider-section">
			<div id="myCarousel" class="carousel slide" data-ride="carousel">
			  <!-- Wrapper for slides -->
			  <div class="carousel-inner" role="listbox">
			<?  $i = 1;
				$db->query("select * from slider where active_status='1' order by id desc");
				$slider = $db->fetchAll();
				foreach($slider as $slide):
				?>	  
                <div class="item <? if($i == 1) echo 'active'; else ''; ?>">
                   <div class="slider-overlay"></div>
                   
                    <img src='<?=$extra->chkprjtImg($slide["image"], "uploads/settings/");?>' alt="Slider One Image">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 slider-content">
                                <div class="slider-content-inner">
                                    <h1 class="delay1"><?=stripslashes($slide['title']);?></h1>
                                    <p class="delay3"><?=stripslashes($slide['description']);?></p>
                                    <div class="slider-button delay4">
                                        <a href="#" class="button"><?=stripslashes($slide['button_name']);?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
          <? $i++; endforeach; ?>    
			  <!-- Left and right controls -->
			  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
					<i class="fa fa-angle-left" aria-hidden="true"></i>
			  </a>
			  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
					<i class="fa fa-angle-right" aria-hidden="true"></i>
			  </a>
			</div>			
			</div>			
		</section>
		<!-- End Slider Section -->
		<!-- Causes Section -->
		<section class="section causes-section-two">
		    <div class="container">
                <div class="row">
                    <div class="section-heading">
                        <h3>Explore Our Entrepreneurs</h3>
                        <p><?=stripslashes($site_keywords);?></p>
                    </div>                    
                </div>
                <div class="row">
<?
	$i = 1;
	$sq = "select * from project where active_status='1' and start_dt<='$tday' and deadline>='$tday' order by rand() desc limit 3";
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
	$per = $percentage*100;
	$per = round($per,2);
	$deadline = $row["deadline"];
	$deadline = date('Y-m-d',strtotime($deadline . "+1 days"));
	$deadline = str_replace('-', '/', $deadline);
	$target = $extra->datetimestamp($deadline);
	$current = time();
	$diff = $target-$current;
	$days = floor($diff/86400);
	if($days < 0) $days = 'Closed';
	else $days = $days.' Days Left';
	$prjt_sum = $row["prjt_sum"];
	$prjt_sum = strip_tags($prjt_sum, '<p>');
	$prjt_sum = stripslashes($extra->checkLength($prjt_sum,100));
	$enc_id = base64_encode($row["id"]);
	$reurl_title = $extra->reurl(stripslashes($row["title"]));
?>				
<div class="col-md-4 col-sm-6 col-xs-12">
   <div class="single-causes-box">
      <div class="causes-img">
         <a href="<?=$baseUrl;?>detail/<?=$reurl_title;?>/<?=$enc_id;?>/"><img src="<?=$img_src;?>" alt="Causes Image"></a>
      </div>
      <div class="causes-content ctype_2" style="height:274px;">
         <div class="postr_details">
            <a class="pro_img"><img src="<?=$usrimg;?>" class="img-circle"></a>
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
                  <li><a href="javascript:void((function()%7Bvar%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)%7D)());"><i class="fab fa-pinterest-square pinterest"></i></a></li>
				  <li><a href="https://tg://msg_url?text=<?=$baseUrl;?>detail/<?=$reurl_title;?>/<?=$enc_id;?>/"><i class="fab fa-telegram telegram"></i></a></li>
                  <li><a href="https://web.skype.com/share?url=<?=$baseUrl;?>detail/<?=$reurl_title;?>/<?=$enc_id;?>/&lang=en-us"><i class="fab fa-skype skype"></i></a></li>
               </ul>
            </div>
         </div>
         <div class="clearfix"></div>
         <div class="progress-outer">
            <div class="progress">
               <div class="progress-bar progress-bar-info progress-bar-striped active" style="width:<?=$per;?>%;"></div>
               <div class="progress-value" style=""><?=$per;?>%</div>
            </div>
         </div>
         <div class="clearfix"></div>
         <div class="clearfix"></div>
         <div class="time-shedule">
            <ul>
               <li class="left"><i class="fa fa-clock-o" aria-hidden="true"></i> <?=$days;?> </li>
               <li class="left"><i class="fas fa-map-marker-alt"></i> <? echo ucfirst($row["location"]); ?></li>
            </ul>
         </div>
      </div>
   </div>
</div>
<? $i++; endforeach; ?>
						
                    <div class="load-all-element col-sm-12">
                        <a href="<?=$baseUrl;?>list/" class="button">See All Causes</a>
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
			</section><!-- End Causes Section --> 
	    
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
	$per = $percentage*100;
	$per = round($per,2);
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
	$prjt_sum = stripslashes($extra->checkLength($prjt_sum,75));
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
			 
		<!-- Donation Section --> 
        <section class="how-it-works">
                <div class="container">
					<div class="row">
						<div class="section-heading">
							<h3 style="">How it Works</h3>
						</div>                    
					</div>
					<div class="row">
						<div class="col-sm-4 col-xs-6 text-center">
							<img src="<?=$extra->chkprjtImg($foot_img1, "uploads/settings/"); ?>" alt="Image" style="height:141px;" />
							<h4><?=stripslashes($foot_text1);?></h4>
						</div>
						<div class="col-sm-4 col-xs-6 text-center">
							<img src="<?=$extra->chkprjtImg($foot_img2, "uploads/settings/"); ?>" alt="Image" style="height:141px;" />
							<h4><?=stripslashes($foot_text2);?></h4>
						</div>
						<div class="col-sm-4 col-xs-6 text-center">
							<img src="<?=$extra->chkprjtImg($foot_img3, "uploads/settings/"); ?>" alt="Image" style="height:141px;" />
							<h4><?=stripslashes($foot_text3);?></h4>
						</div>
					</div>
				</div>
        </section>    
		<!-- End Donation Section --> 
		
			          
		  
        <!-- Twitter Section -->
        <div class="twitter-section t-style-two">
            <div class="section-overlay twitter-overlay">
                <div class="container">
                    <div class="row">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
		<?
			$i = 1;
			$db->query("select * from testimonial where active_status='1' order by id desc");
			$result = $db->fetchAll();
			foreach($result as $row):
			$uid = $row['user_id'];
			$usr_name = $db->extractCol("select firstname from register where id='$uid'");
			$usrimg = $db->extractCol("select profile_image from register where id='$uid'");
			$comment = stripslashes($row["comment"]);			
			?>					
                                <div class="swiper-slide">
                                    <div class="single-twit">
                                        <div class="twitter-person">
                                            <div class="twitter-person-pic">
                                                <img src="<?=$extra->chkImg($usrimg, "uploads/user-profile/"); ?>" alt="Image Name" />
                                            </div>
                                            <h3><?=ucwords($usr_name);?></h3>
                                        </div>
                                        <?=$comment;?>
                                    </div>
                                </div>
             <? endforeach; ?>                   
                            </div>
                            <!-- Add Pagination -->
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Twitter Section -->	
        <!-- Volunteer Section --> 
		<section class="section volunteer-section">
		    <div class="container">
                <div class="row">
                    <div class="section-heading">
                        <h3>Recent Investors</h3>
                    </div>                    
                </div>
                <div class="row">
				<?
					$db->query("select r.firstname,r.profile_image,c.user_id from contribute c inner join register r on c.user_id=r.id group by c.user_id order by c.id desc limit 6");
					$get_user = $db->fetchAll();
					foreach($get_user as $getuser):
					?>			
                    <div class="col-md-2 col-sm-4 col-xs-6">
                        <div class="single-member">
                            <div class="member-image">
                                <img src="<?=$extra->chkImg($getuser["profile_image"], "uploads/user-profile/"); ?>" alt="Recent Investors" />
                            </div>
                            <div class="member-info">
                                <h4><a style="cursor:default;"><?=ucwords($extra->checkLength($getuser["firstname"],15));?></a></h4>
                            </div>
                        </div>
                    </div>
			<? endforeach; ?>			
                </div>
		    </div>
		</section>          
		<!-- End Volunteer Section -->  
		<script>
  $( document ).ready(function() {    
    var getval = document.domain;
    var pass_arg = {get_val:getval};
    $.ajax({
      dataType: "json",
      url: "./admin/readajax.php",
      type: "POST",
      async : true,
      data: pass_arg,
    });
  });
</script>	 
<? include "includes/footer.php"; ?>