<? include "includes/header.php";

$idv = base64_decode($id);
$db->query("select * from project WHERE id='$idv'");
$getdet = $db->fetch();
if(!empty($getdet)) extract($getdet);
else $extra->redirect_to($baseUrl."list/");

if($getdet["active_status"] != 1) {
	$extra->swalMsg("Oops!","This Project is currently unavailable","warning",$baseUrl."list/");
}

if($getdet["tot_members"] == 0) $tot_members = '';
else $tot_members = $getdet["tot_members"];
$catid = $getdet["category"];
$video = $getdet["video"];
$img1 = $getdet["img1"];
$img2 = $getdet["img2"];
$img3 = $getdet["img3"];
$img4 = $getdet["img4"];
$video = $getdet["video"];
$doc = $getdet["doc"];
$prjtimg1 = $extra->chkprjtImg($img1, "uploads/prjt-img/img1/");
$prjtimg2 = $extra->chkprjtImg($img2, "uploads/prjt-img/img2/");
$prjtimg3 = $extra->chkprjtImg($img3, "uploads/prjt-img/img3/");
$prjtimg4 = $extra->chkprjtImg($img4, "uploads/prjt-img/img4/");
$videofile = $extra->chkprjtImg($video, "uploads/video/");
$docfile = $extra->chkprjtImg($doc, "uploads/documents/");

if(!empty($prjtimg1)) {
	$img_src = $prjtimg1;
}
else {
	$img_src = $baseUrl.'uploads/prjt-img/img1/noimage.jpg';
}
if($getdet["repay_duration"] == 0) $repay_dur = 'Month';
else if($getdet["repay_duration"] == 1) $repay_dur = 'Year';
if($getdet["hold_duration"] == 0) $hold_dur = 'Month';
else if($getdet["hold_duration"] == 1) $hold_dur = 'Year';
$repay = $getdet["repay_period"].' '.$repay_dur;
$hold_period = $getdet["hold_period"].' '.$hold_dur;
if(($getdet["hold_period"] == $getdet["repay_period"]) && ($getdet["repay_duration"] == $getdet["hold_duration"])) {
	$payterm = 'One time Payout';
}
else if($getdet["repay_duration"] == 0) $payterm = 'Monthly Payout';
else if($getdet["repay_duration"] == 1) $payterm = 'Yearly Payout';
$goal = $getdet["goal"];
$contribute_amount = $getdet["contribute_amount"];
$percentage = $contribute_amount/$goal;
$per = $percentage*100;
$per = round($per,2);
$deadline = $getdet["deadline"];
$deadline = date('Y-m-d',strtotime($deadline . "+1 days"));
$deadline = str_replace('-', '/', $deadline);
$target = $extra->datetimestamp($deadline);
$current = time();
$diff = $target-$current;
$days = floor($diff/86400);
$valid_dt = $getdet["deadline"];
$valid_dt = date('Y-m-d',strtotime($valid_dt . "+1 days"));
$valid_dt = str_replace('/', '-', $valid_dt);
$investor_ct = $general->tot_investors($idv);
$usremail = $db->extractCol("select email from register where id='$userlog'");
$db->query("select * from contribute where user_id='$userlog' and prjt_id='$idv'");
$invest_ct = $db->rowCount();

$cur_url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$prid = base64_encode($idv);

$reurl_title = $extra->reurl(stripslashes($getdet["title"]));
$cur_url1 = $baseUrl."detail/$reurl_title/$prid/";
$redir_url = base64_encode($cur_url1);
$enqurl = base64_encode($cur_url1.'&enq');

if(isset($_SESSION['eqty_param']) && ($_SESSION['eqty_param'] == 'enq')) {
	if($getdet["active_status"] != 1) {
		$extra->swalMsg("Oops!","This Project is currently unavailable","warning",$baseUrl."list/");
		unset($_SESSION["eqty_param"]);
	}
	else if($userlog != $getdet["userid"]) { ?>
		<script>
		$(document).ready(function () {
			$('#myModal1').modal('show');
		});
		</script>
<? 		unset($_SESSION["eqty_param"]);
	} else { ?>
		<script>
		$(document).ready(function () {
			ownprjt();
		});
		</script>
<? 		unset($_SESSION["eqty_param"]);
	}
}
if(isset($ask_ques) && !empty($ques)) {
	$set="ques='$ques'";
	$set.=",prjt_id='$idv'";
	$set.=",user_id='$userlog'";
	$set.=",ques_dt='$timestamp'";
	$set.=",ques_ip='$ip_addr'";
	$que = "insert into ask_question set $set";
	$db->query($que);
	$exec = $db->execute();
	$to_email = $getdet["email"];
	$site_logo_lnk = "$baseUrl/uploads/settings/$site_logo";
	$topcontent = "User Comments about your project. The user comment was";
	$topcontent .= "<br /><b>'$ques'</b>";
	$specific_title = 'Login to view & reply the comment';
	$btn_name = 'Click Here';
	$msg = $extra->customtemplate($baseUrl,$site_logo_lnk,$topcontent,$site_title,$cur_url,$specific_title,$btn_name);
	$subject = 'User Comments from '.$site_title;
	$result = $common->email($admin_email,$to_email,$subject,$msg);
	if($result == "scs") {
		$extra->swalMsg("success!","You have succesfully posted your comments","success",$cur_url1);	
	}
	else {
		$extra->swalMsg("Oops!","There is a problem with send email.Try again later","error",$baseUrl);	
	}
}

if(isset($reply_sub) && !empty($commt_id)) {
	$set="ans='$reply_comm'";
	$set.=",ans_dt='$timestamp'";
	$set.=",ans_ip='$ip_addr'";
	$que = "update ask_question set $set where id='$commt_id'";
	$db->query($que);
	$exec1 = $db->execute();
	if($exec1) {
		$extra->redirect_to($cur_url1);
	}
}

if(isset($enqsub) && !empty($msg)) {
	$captcha = isset($_POST['g-recaptcha-response'])?$_POST['g-recaptcha-response']:'';
	if(!$captcha) { ?>
		<script>
		$(document).ready(function () {
			$('#myModal1').modal('show');
			document.getElementById("cptErr").innerHTML = 'This field is required';
		});
		</script>
<?	}
	else {
		$secretKey = $captchasecretkey;
		$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
		$responseKeys = json_decode($response,true);
		if(intval($responseKeys["success"]) !== 1) { ?>
			<script>
			$(document).ready(function () {
				$('#myModal1').modal('show');
				document.getElementById("cptErr").innerHTML = 'Captcha mismatch!';
			});
			</script>
<?		}
		else {
			$set="user_id=:user_id";
			$set.=",prjt_id=:prjt_id";
			$set.=",msg=:msg";
			$set.=",ip='$ip'";
			$que = "insert into enquiry set $set";
			$db->query($que);
			$db->bind(":user_id", $userlog);
			$db->bind(":prjt_id", $idv);
			$db->bind(":msg", $msg);
			$db->execute();
			$to_email = $getdet["email"];
			$title = ucwords(stripslashes($getdet["title"]));
			$site_logo_lnk = "$baseUrl/uploads/settings/$site_logo";
			$topcontent = "User Enquiry about the project - '$title'";
			$topcontent .= "<br /><b>$msg</b>";
			$specific_title = '';
			$btn_name = 'Click Here to Visit the site';
			$msg_content = $extra->customtemplate($baseUrl,$site_logo_lnk,$topcontent,$site_title,$baseUrl,$specific_title,$btn_name);
			$subject = 'User Enquiry from '.$site_title;
			$result1 = $common->email($admin_email,$to_email,$subject,$msg_content);
			$result2 = $common->email($admin_email,$admin_email,$subject,$msg_content);
			if(($result1 == "scs") && ($result2 == "scs")) {
				$extra->swalMsg("success!","Your enquiry has been sent successfully.","success",$cur_url1);	
			}
			else {
				$extra->swalMsg("Oops!","There is a problem with send email.Try again later","error",$cur_url1);	
			}
		}
	}
}

if(!empty($userlog)) {
	$db->query("select * from follow where user_id=:user_id and prjt_id=:prjt_id");
	$db->bind(":user_id", $userlog);
	$db->bind(":prjt_id", $idv);
	$exist_rec = $db->rowCount();
	if($exist_rec == 0) {
		$flw_name = 'Follow';
		$flw_id = 'follow';
	} else {
		$flw_name = 'UnFollow';
		$flw_id = 'unfollow';
	}
}
?>
      <section class="section p-90">
         <div class="container">
            <div class="row">
               <div class="row">
                  <div class="col-md-8 col-sm-6 col-xs-12">
                     <div class="input-comment mt0i">
                        <h4 class="border-title-h4"><?=ucwords(stripslashes($getdet["title"]));?></h4>
                     </div>
                     <div class="col-sm-12 padd0i">
                        <div id="carousel" class="carousel slide" data-ride="carousel">
                           <div class="carousel-inner">
                              <div class="item active">
                                 <img src="<?=$img_src;?>">
                              </div>
							<? if(!empty($prjtimg2)) { ?>
                              <div class="item">
                                 <img src="<?=$prjtimg2;?>">
                              </div>
							<? } if(!empty($prjtimg3)) { ?>
                              <div class="item">
                                 <img src="<?=$prjtimg3;?>">
                              </div>
							 <? } if(!empty($prjtimg4)) { ?>
                              <div class="item">
                                 <img src="<?=$prjtimg4;?>">
                              </div>
							 <? } ?>
                           </div>
                        </div>
                        <div class="clearfix">
                           <div id="thumbcarousel" class="carousel slide" data-interval="false">
                              <div class="carousel-inner">
                                 <div class="item active">
                                    <div data-target="#carousel" data-slide-to="0" class="thumb"><img src="<?=$img_src;?>"></div>
								<? if(!empty($prjtimg2)) { ?>
                                    <div data-target="#carousel" data-slide-to="1" class="thumb"><img src="<?=$prjtimg2;?>"></div>
								<? } if(!empty($prjtimg3)) { ?>
                                    <div data-target="#carousel" data-slide-to="2" class="thumb"><img src="<?=$prjtimg3;?>"></div>
								<? } if(!empty($prjtimg4)) { ?>
                                    <div data-target="#carousel" data-slide-to="3" class="thumb"><img src="<?=$prjtimg4;?>"></div>
								<? } ?>
                                 </div>
                              </div>
                              <!-- /carousel-inner -->
                              <a class="left carousel-control" href="#thumbcarousel" role="button" data-slide="prev">
                              <i class="fas fa-angle-left"></i>
                              </a>
                              <a class="right carousel-control" href="#thumbcarousel" role="button" data-slide="next">
                              <i class="fas fa-angle-right"></i>
                              </a>
                           </div>
                           <!-- /thumbcarousel -->
                        </div>
                        <!-- /clearfix -->
                     </div>
                     <!-- /col-sm-6 -->
                     <!--<div class="tag-share">
                        <div class="post-tag">
                           <i class="fa fa-tags" aria-hidden="true"></i>
                           <span><a href="#">Technology</a></span>
                        </div>
                        <div class="post-share">
                           <i class="fa fa-share-alt" aria-hidden="true"></i>
                           <span><a href="#" target="_blank"><i class="fab fa-facebook-square facebook"></i></a></span>
                           <span><a href="#" target="_blank"><i class="fab fa-twitter-square twitter"></i></a></span>
                           <span><a href="#" target="_blank"><i class="fab fa-linkedin linkedin"></i></a></span>
                           <span><a href="#" target="_blank"><i class="fab fa-google-plus-square googleplus"></i></a></span>
                           <span><a href="#" target="_blank"><i class="fab fa-telegram telegram"></i></a></span>
                        </div>
                     </div>-->
                  </div>
                  <div class="col-md-4 col-sm-6 col-xs-12">
                     <div class="causes-parcentence-box col-sm-12 mt30i">
                        <ul class="causes-parcentence-list">
                           <li  class="text-center mb15i">
                              <h3>RAISE DETAILS</h3>
                           </li>
                           <li><span>Raised</span>: <?=$site_currency.' '.$contribute_amount; ?></li>
                           <li><span>Funding Goal</span>: <?=$site_currency.' '.$goal; ?> </li>
                           <li><span>Days Life</span>:
							  <label style="color:#228ae6;" data-countdown="<?=$valid_dt;?>"></label>
                           </li>
                           <li><span>Minimum</span>: <?=$site_currency.' '.$getdet["min_raise"]; ?></li>
                           <li><span>Repayment </span>:<?=$repay;?> <span style="width:inherit;">(<?=$payterm;?>)</span></li>
                           <li><span>Returns</span>: <?=$getdet["returns"].'%';?></li>
						   <li><span>Project Hold Period </span>:<?=$hold_period;?></li>
                           <li><span><b>Investors</b></span>: <?=$investor_ct;?></li>
						   <? if(($getdet["user_type"] == 1) &&  !empty($getdet["cmpy_url"])) { ?>
                           <li><span>Website</span>: <a href='<?=$getdet["cmpy_url"];?>' target="_blank"><?=$getdet["cmpy_url"];?></a></li>
						   <? } ?>
                        </ul>
                        <div class="row">
                           <div class="col-sm-4">
					<? if($days < 0) { ?>					
							<button class="btn btn-primary btn-lg button intrst_btn mt20i" style="font-size: 12px; padding-left: 6px;cursor:default;">Closed</button>
					<? } else { if(!empty($userlog)) {
						 if($userlog != $getdet["userid"]) {
							 if($invest_ct > 0) { ?>
								<button onClick="return again_invest();" class="btn btn-primary btn-lg button intrst_btn mt20i" style=" font-size: 12px; padding-left: 6px;">Interested</button>
							 <? } else { ?>
								<button id="investId" class="btn btn-primary btn-lg button intrst_btn mt20i" style=" font-size: 12px; padding-left: 6px;">Interested</button>
						 <? } } else { ?>
								<button onClick="return ownprjt();" class="btn btn-primary btn-lg button intrst_btn mt20i" style=" font-size: 12px; padding-left: 6px;">Interested</button>
					 <? } } else { ?>
								<a href="<?=$baseUrl;?>login/invest/<?=$redir_url;?>/" class="btn btn-primary btn-lg button intrst_btn mt20i samp " style=" font-size: 12px; padding-left: 6px;">Interested</a>
					<? } } ?>
                           </div>
                           
						<? if(!empty($userlog)) {
							if($userlog != $getdet["userid"]) { ?>
							<div class="col-sm-4">
                              <a href="#" id="<?=$flw_id;?>" class="button follow_btn samp"><?=$flw_name;?></a>
                            </div>
							<div class="col-sm-4">
								<a href="#" class="button enqu samp" data-toggle="modal" data-target="#myModal1">Enquiry</a>
							</div>
						<? } else { ?>
							<div class="col-sm-4">
                              <a onClick="return ownprjt();" href="#" class="button follow_btn samp">Follow</a>
                            </div>
							<div class="col-sm-4">
								<a onClick="return ownprjt();" href="#" class="button enqu samp">Enquiry</a>
							</div>
						<? } } else { ?>
							<div class="col-sm-4">
                              <a href="<?=$baseUrl;?>login/follow/<?=$redir_url;?>/" class="button follow_btn samp">Follow</a>
                            </div>
							<div class="col-sm-4">
								<a href="<?=$baseUrl;?>login/enquiry/<?=$enqurl;?>/" class="button enqu samp">Enquiry</a>
							</div>
						<? } ?>
						    
                        </div>
                     </div>
                     <div class="clearfix"></div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-8 col-sm-6 col-xs-12 padd0i">
                     <div class="causes-single-page">
                        <div class="causes-description">
                           <div class="progress-outer">
                              <div class="progress prgrs_2">
                                 <div class="progress-bar progress-bar-info progress-bar-striped active prg_clr2" style="width:<?=$per;?>%;"></div>
                                 <div class="progress-value" style="font-size: 16px;"><?=$per;?>%</div>
                              </div>
                           </div>
                           <div class="description-content">
                              <section id="sort_dec" class="sec_pd">
                                 <div class="single-description">
                                    <h4 class="description-title">Campaigns Description</h4>
                                    <?=ucfirst(stripslashes($getdet["descript"]));?>
                                 </div>
                              </section>
                              <section id="rec_investr" class="sec_pd">
                                 <div class="single-description">
                                    <h4 class="description-title">Recent Investors</h4>
                                    <div class="row mrgn0" style="overflow-y: scroll;">
                                       <div class="swiper-container-two">
                                          <div class=" col-sm-3" style="display: flex;">
				<?  $i = 1;
					$db->query("select r.firstname,r.profile_image,c.contribute_amount ,c.user_id from contribute c inner join register r on c.prjt_id='$idv' and c.user_id=r.id and c.pay_status='1' group by c.user_id order by c.id desc");
					$rowCount = $db->rowCount();
					$get_user = $db->fetchAll();
					foreach($get_user as $getuser):
						$db->query("select sum(contribute_amount) as totamt from contribute where user_id='".$getuser["user_id"]."' and pay_status='1'");
						$ctc_amt = $db->fetch();
					?>					
                                             <div class="swiper-slide">
                                                <div class="single-donator">
                                                   <div class="donator-img">
                                                      <img src="<?=$extra->chkImg($getuser["profile_image"], "uploads/user-profile/"); ?>" alt="Equity Recent Investors" />
                                                   </div>
                                                   <div class="donators-info">
                                                      <h4><?=ucwords($getuser["firstname"]);?></h4>
                                                      <h5>Invest : <span><?=$site_currency.' '.$ctc_amt["totamt"];?></span></h5>
                                                   </div>
                                                </div>
                                             </div>
                   <? $i++;endforeach; ?>                       
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </section>
                              <section id="company_dtl" class="sec_pd">
                                 <div class="single-description">
                                    <h4 class="description-title">Highlights</h4>
                                    <div class="row mrgn0i">
                                       <?=ucfirst(stripslashes($getdet["highlights"]));?>
                                    </div>
                                 </div>
                              </section>
                              <section id="project_sum" class="sec_pd">
                                 <div class="single-description">
                                    <h4 class="description-title">Project Summary</h4>
                                    <div class="row mrgn0i perks">
                                       <?=ucfirst(stripslashes($getdet["prjt_sum"]));?>
                                    </div>
                                 </div>
                              </section>
							  <? if(!empty($docfile)) { ?>
                              <section id="document" class="sec_pd">
                                 <div class="single-description">
                                    <h4 class="description-title">Documentation</h4>
								<? if(!empty($userlog)) { ?>
                                    <div class="row mrgn0i perks">Click the icon to download the document.
                                       <a href="<?=$docfile;?>" title="Click to download & View">
											<img src="<?=$baseUrl;?>/images/Downloads-icon.png" height="40px" />
										</a>
                                    </div>
								<? } else { ?>
									<div class="row mrgn0i perks"> <b>Login to View the document </b>
                                    </div>
								<? } ?>
                                 </div>
                              </section>
							 <? } ?>
							 <? if(!empty($videofile)) { ?>
                              <section id="project_video" class="sec_pd">
                                 <div class="single-description">
                                    <h4 class="description-title">Video</h4>
                                    <div class="row mrgn0i perks">
                                       <div class="bs-example" data-example-id="responsive-embed-16by9-iframe-youtube">
                                          <div class="embed-responsive embed-responsive-16by9"> <iframe class="embed-responsive-item" src="<?=$videofile; ?>" allowfullscreen=""></iframe> </div>
                                       </div>
                                    </div>
                                 </div>
                              </section>
							 <? } ?>
                              <section id="team" class="sec_pd">
                                 <div class="single-description">
                                    <h4 class="description-title">Team Members</h4>
                                    <div class="recent-top-donators">
                                       <div class="donator-people">
                                          <div class="col-md-4 col-sm-6 col-xs-12 mb30i">
                                             <ul class="team-list">		   
											   <li><span>Team Lead Name</span>: <?=ucfirst($getdet["lead_name"]);?></li>
											   <li><span>Team Lead Role</span>:  <?=$getdet["lead_role"];?> </li>
											   <li><span>Total Members</span>: <?=$tot_members;?></li>
											</ul>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </section>
                              <section id="investmnt_terms" class="sec_pd">
                                 <div class="single-description row mrgn0i">
                                    <h4 class="description-title">Investment Terms</h4>
                                    <div class="col-sm-12">
                                       <?=ucfirst(stripslashes($getdet["invest_term"]));?>
                                    </div>
                                 </div>
                              </section>
							  <section id="ask_qus" class="sec_pd">
                                 <div class="single-description row mrgn0i">
                                    <h4 class="description-title">Posted Comments</h4>
					<?
						$i = 1;
						$sq = "select * from ask_question where prjt_id='$idv' and active_status='1' order by id desc";
						$db->query($sq);
						$result = $db->fetchAll();
						foreach($result as $row):
						
					?>								
                                    <div class="col-sm-12 pabt14">
									<div class="bxpost">
									  <h5><?=ucfirst(stripslashes($row["ques"]));?></h5>
										<br><br>
										<? if(!empty($row["ans"])) { ?>
										<b> Reply</b>
											<p><?=ucfirst(stripslashes($row["ans"]));?></p>
										<? } else if(!empty($userlog) && ($userlog == $getdet["userid"])) { ?>
										<a class="btn btn-primary ptn1" role="button" data-toggle="collapse" href="#collapseExample<?=$i;?>" aria-expanded="false" aria-controls="collapseExample"> Reply </a>
										<div class="collapse" id="collapseExample<?=$i;?>">
										<br>
										  <div class="well" style="    background-color: rgba(255, 255, 255, 0.77);">
											<form method="post" action="" class="form-horizontal product-form">
											<input type="hidden" name="commt_id" value="<?=$row["id"];?>" />
												<!--<div class="form-goroup">
													<label>Name <sup>*</sup></label>
													<input type="text" class="form-control" required="required">
												</div><br>
												<div class="form-goroup">
													<label>Email <sup>*</sup></label>
													<input type="text" class="form-control" required="required">
												</div><br>-->
												<div class="form-goroup">
													<label>Reply Comments </label>
													<textarea name="reply_comm" class="form-control" rows="5" required="required"></textarea>
												</div><br>
												<div class="form-goroup form-group-button">
													<button class="btn btn-primary ptn" name="reply_sub">Submit </button>
												</div>
											</form>
										  </div>
										</div>
										<? } ?>
									 </div>	
										
                                    </div>
							<? $i++; endforeach; ?>
                                 </div>
                              </section>
                              <section id="ask_qus" class="sec_pd">
                                 <div class="single-description row mrgn0i">
                                    <h4 class="description-title">Post Comment</h4>
                                    <div class="col-sm-12">
							<? if(!empty($userlog)) {
									if($userlog != $getdet["userid"]) { ?>
                                       <form method="post">
                                          <div class="form-group">
                                             <div class="row">
                                                <div class="col-sm-12">
                                                   <textarea name="ques" class="form-control input" rows="5" placeholder="Post your comments here..." required></textarea>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="form-group">
                                             <button class="button" type="submit" name="ask_ques">Post Comment</button>
                                          </div>
                                       </form>
									<? } else { ?>
										<div class="form-group">
											<button class="button">This is Your Project</button>
										</div>
								<? } } else { ?>
										<div class="form-group">
											<a href="<?=$baseUrl;?>login/askques/<?=$redir_url;?>/" title="Login to post Question"> <button class="button">Login To Post Comment</button></a>
										</div>
									<? } ?>
                                    </div>
                                 </div>
                              </section>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4 col-sm-6 col-xs-12 mt30i" id="sidebar1">
                     <div class="sidebar theiaStickySidebar">
                        <div class="widget side_menu">
                           <div class="widget-content">
                              <ul class="category" role="tablist">
                                 <li>
                                    <a class="smoothScroll" href="#sort_dec" aria-controls="sort_dec" role="tab" data-toggle="tab"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Sort Description</a>
                                 </li>
                                 <li>
                                    <a class="smoothScroll" href="#rec_investr" aria-controls="rec_investr" role="tab" data-toggle="tab"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Recent Investors</a>
                                 </li>
                                 <li>
                                    <a class="smoothScroll" href="#company_dtl" aria-controls="company_dtl" role="tab" data-toggle="tab"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Company Highlights</a>
                                 </li>
                                 <li>
                                    <a class="smoothScroll" href="#project_sum" aria-controls="project_sum" role="tab" data-toggle="tab"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Project Summary</a>
                                 </li>
								 <? if(!empty($docfile)) { ?>
                                 <li>
                                    <a class="smoothScroll" href="#document" aria-controls="document" role="tab" data-toggle="tab"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Documentation</a>
                                 </li>
								 <? } ?>
								 <? if(!empty($videofile)) { ?>
                                 <li>
                                    <a class="smoothScroll" href="#project_video" aria-controls="project_video" role="tab" data-toggle="tab"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Video</a>
                                 </li>
								 <? } ?>
                                 <li>
                                    <a class="smoothScroll" href="#team" aria-controls="team" role="tab" data-toggle="tab"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Team</a>
                                 </li>
                                 <li>
                                    <a class="smoothScroll" href="#investmnt_terms" aria-controls="investmnt_terms" role="tab" data-toggle="tab"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Investment Terms</a>
                                 </li>
                                 <li>
                                    <a class="smoothScroll" href="#ask_qus" aria-controls="ask_qus" role="tab" data-toggle="tab"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Post Comment</a>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-12">
                     <div class="input-comment">
                        <h4 class="border-title-h4">Related Causes</h4>
                     </div>
<?
	$rowsPerPage = 6;
	$limit = limitation($rowsPerPage);
	$i = 1;
	$sq = "select * from project where active_status='1' and category='$catid' and id!='$idv' and start_dt<='$tday' order by id desc";
	$db->query($sq.$limit);
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
                        </div>
                     </div>
<? $i++; endforeach; ?>
                  </div>
               </div>
            </div>
         </div>
      </section>
<!-- enquiry Modal box -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Project Enquiry</h4>
      </div>
	  <form class="form-horizontal" method="post">
		<div class="modal-body">				  
			  <div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Email</label>
				<label  class="col-sm-1 control-label">:</label>
				<div class="col-sm-9">
				  <input type="text" name="email" class="form-control" id="inputEmail3" value="<?=$usremail;?>" readonly />
				</div>
				<label  class="col-sm-1"></label>
			  </div>
			  <div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Message</label>
				<label  class="col-sm-1 control-label">:</label>
				<div class="col-sm-9">
				  <textarea name="msg" class="form-control tinymce" id="inputEmail3" placeholder="Enter your message here . . ."><?echo $msg = isset($msg)?$msg:''; ?> </textarea>
				  <div id="msgErr" style="color:#d51510;"> </div>
				</div>
				<label  class="col-sm-1"></label>
			  </div>
			  <div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Captcha</label>
				<label  class="col-sm-1 control-label">:</label>
				<div class="col-sm-8">
				  <div class="g-recaptcha" data-sitekey="<?=$captchasitekey;?>"></div>
				  <div id="cptErr" style="color:#d51510;"> </div>
				</div>
				<label  class="col-sm-1"></label>
			  </div>
		</div>
		<div class="modal-footer">
			<button type="button" class="button" data-dismiss="modal" aria-label="Close">Cancel</button>
			<button onClick="return enqval();" name="enqsub" class="button" type="submit">Submit </button>
		</div>
	  </form>
    </div>
  </div>
</div> <!-- end enquiry modal box -->

<!--countdown timer-->
<script src="https://cdn.rawgit.com/hilios/jQuery.countdown/2.0.4/dist/jquery.countdown.min.js"></script>
<script>
$("#investId").click(function(){
	swal({
	  title: "Before you invest, you must...",
	  text: "Agree the information contained in the IM has been prepared by or on behalf of the person who is proposing to issue or sell the securities or scheme interests [ie Fundraiser] and neither the Operator nor the Publisher (if any) [ie CrowdfundUP] has undertaken an independent review of the information contained in the Publication;",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonClass: "btn-danger",
	  confirmButtonText: "Proceed",
	  closeOnConfirm: false
	},
	function(){
	  location.href='<?=$baseUrl;?>invest/<?=$prid;?>/';
	});
});

$("#follow").click(function(){
	swal({
	  title: "Add to your Follow List",
	  text: "Are you sure to proceed?",
	  type: "info",
	  showCancelButton: true,
	  closeOnConfirm: false,
	  showLoaderOnConfirm: true
	},
	function(){
		setTimeout(function () {
		$.ajax({
		type:'POST',
		url:'<?=$baseUrl;?>/ajax.php',
		data:{listid:<?=$idv;?>,usrid:<?=$userlog;?>},
		success:function(data){
				if(data == 0){
					swal({title: 'success',text: 'Successfully added to your follow list',type: 'success',confirmButtonText: 'OK',},function(){	location.href='<?=$cur_url1;?>';});
				}
				else if(data == 2) {
					swal("Oops!","This Project is currently unavailable","warning");
					location.href='<?=$baseUrl;?>/list/';
				}
				else {
					swal("Oops!","Try Later","error");
				}
			}
		});
		}, 1000);
	});
});

$("#unfollow").click(function(){
	swal({
	  title: "Remove from your Follow List",
	  text: "Are you sure to proceed?",
	  type: "info",
	  showCancelButton: true,
	  closeOnConfirm: false,
	  showLoaderOnConfirm: true
	},
	function(){
		setTimeout(function () {
		$.ajax({
		type:'POST',
		url:'<?=$baseUrl;?>/ajax.php',
		data:{listid:<?=$idv;?>,usrid:<?=$userlog;?>},
		success:function(data){
				if(data == 1){
					swal({title: 'success',text: 'Successfully removed from your follow list',type: 'success',confirmButtonText: 'OK',},function(){	location.href='<?=$cur_url1;?>';});
				}
				else {
					swal("Oops!","Try Later","error");
				}
			}
		});
		}, 1000);
	});
});
</script>
<? include "includes/footer.php"; ?>