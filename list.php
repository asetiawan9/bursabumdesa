<? include "includes/header.php"; 

$srch_cat = isset($srch_cat)?$srch_cat:'';
$srch_title = isset($srch_title)?$srch_title:'';
$srch = '';
if(isset($search)) {
	if(!empty($srch_cat))
		$srch = "and category='$srch_cat'";
	if(!empty($srch_title))
		$srch .= " and title like '$srch_title%'";
}
?>
		 
		<section class="section causes-section causes-all">
		    <div class="container">
                <div class="row">
                    <div class="showing-result-box">
                        <!-- <div class="rusult-number">
                           <p>Showing <span>01 - 09</span> of 139 results</p>
                        </div>-->
                        <div class="search-result-right ">
                            <form method="get" class="row">
							 <div class="col-sm-3">
							   <label class="pdt5">Filter By:</label>
							 </div>
							 <div class="col-sm-5">
								<select class="form-control group caps" name="srch_cat" style="">
									<option value=""> Select Category </option>
								<?=$drop->dropselectSingle("select id,catagory_name from category where active_status='1' order by catagory_name asc",$srch_cat);?>
								</select>
						    </div>
						 <div class="col-sm-4">
							<input class="" type="text" name="srch_title" value="<?=$srch_title;?>" placeholder="Search The Causes" style="height:35px;">
							
							
							 <button class="" type="submit" name="search" style="position: absolute;right: 	-42px;top: 8px"><i class="fa fa-search" aria-hidden="true"></i></button>
	                      </div>
	
                            </form>
                        </div>
                    </div>                   
                </div>
                <div class="row">
                    <div class="causes">
<?	
	$rowsPerPage = 6;
	$limit = limitation($rowsPerPage);
	$i = 1;
	$sq = "select * from project where active_status='1' and start_dt<='$tday' $srch order by id desc";
	$db->query($sq.$limit);
	$result = $db->fetchAll();
	if(count($result) == 0) { ?>
		<div style="color:red;"> Your search results not found... </div>
<? $sq = "select * from project where active_status='1' and start_dt<='$tday' order by id desc";
	$db->query($sq.$limit);
	$result = $db->fetchAll();
	}
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
	if($goal <= $contribute_amount){
		$prjt_sts = 'Success';
		$cls = 'btn-success';
		$inl_style = 'style="padding:10px;"';
		$camp_rib = 'Success';
		$camp_rib_cls = 'success';
	}
	else if(($goal != $contribute_amount) && ($row["deadline"] >= $tday)) {
		$prjt_sts = 'Invest Now';
		$cls = 'don_btn';
		$inl_style = '';
		$camp_rib = 'In Progress';
		$camp_rib_cls = '';
	}
	else if(($goal != $contribute_amount) && ($row["deadline"] <= $tday)) {
		$prjt_sts = 'Unsuccess';
		$cls = 'btn-danger';
		$inl_style = 'style="padding:10px;"';
		$camp_rib = 'Unsuccess';
		$camp_rib_cls = 'unsuccess';
	}
	
	$reurl_title = $extra->reurl(stripslashes($row["title"]));
?>
<div class="col-md-4 col-sm-6 col-xs-12">
   <div class="single-causes-box">
      <div class="causes-img">
         <a href="<?=$baseUrl;?>detail/<?=$reurl_title;?>/<?=$enc_id;?>/"><img src="<?=$img_src;?>" alt="Causes Image"></a>
      </div>
      <div class="causes-content ctype_2">
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
            <div class="col-sm-12"> <a href="<?=$baseUrl;?>detail/<?=$reurl_title;?>/<?=$enc_id;?>/" class="<?=$cls;?>" <?=$inl_style;?>><?=$prjt_sts;?> </a> </div>
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
               <div class="progress-value"><?=$per;?>%</div>
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
	  <!--<div class="campaign-ribbon <?=$camp_rib_cls;?>"><a href="#"><?=$camp_rib;?></a></div>-->
   </div>
</div>  
<? $i++; endforeach; ?>

                    </div>
                </div>
				<div class="row">
					<div class="pagination-div">
						<ul class="pagination">
							<? echo $pagingLink = getPagingLink1($sq,$rowsPerPage,"",$db); ?>
						</ul>
					</div>	
				</div>
		    </div>
		</section>  		
         	 
<? include "includes/footer.php"; ?>