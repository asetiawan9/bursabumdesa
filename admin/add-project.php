<?php
require "includes/header.php";

$isEdit=false;
if(isset($prjt)) $isEdit=true;

/** process if the form has been submitted **/
if(isset($prjt_sub)) {
	$deadline = str_replace('/', '-', $deadline);
	$deadline = date("Y-m-d",strtotime($deadline));
	$start_dt = str_replace('/', '-', $start_dt);
	$start_dt = date("Y-m-d",strtotime($start_dt));
	$set="userid=:post_by";
	$set.=",user_type=:user_type";
	$set.=",cmpy_name=:cmpy_name";
	//$set.=",cmpy_loc=:cmpy_loc";
	$set.=",cmpy_yrfound=:cmpy_yrfound";
	$set.=",cmpy_type=:cmpy_type";
	$set.=",cmpy_url=:cmpy_url";
	$set.=",lead_name=:lead_name";
	$set.=",lead_role=:lead_role";
	$set.=",tot_members=:tot_members";
	$set.=",email=:email";
	$set.=",ctc_num=:ctc_num";
	$set.=",location=:location";
	$set.=",title=:title";
	$set.=",category=:category";
	$set.=",goal=:goal";
	$set.=",min_raise=:min_raise";
	$set.=",repay_period=:repay_period";
	$set.=",repay_duration=:repay_duration";	
	$set.=",returns=:returns";	
	$set.=",start_dt=:start_dt";
	$set.=",deadline=:deadline";
	$set.=",hold_period=:hold_period";
	$set.=",hold_duration=:hold_duration";
	$set.=",descript=:descript";
	$set.=",highlights=:highlights";
	$set.=",invest_term=:invest_term";
	$set.=",prjt_sum=:prjt_sum";
	$set.=",edu_qual=:edu_qual";
	$set.=",exp=:exp";
	
	$insid = $insid1;
	if($insid == 'none') $insid = $insid2;
	if($insid == 'none') $insid = $insid3;
	if($insid == 'none') $insid = $insid4;
	if($insid == 'none') $insid = $insid5;
	if($isEdit) {
		$set.=",chngdt='$timestamp'";
		$set.=",chng_ip='$ip'";
		$que="update project set $set where id='$prjt'";
		$db->query($que);
		$pid = $prjt;
	}
	else if($insid!="none") {
		$id1=chr(rand(97,122));
		$id2=rand(0,100);
		$pro_post_id="Eqcrwd".$id1.$id2;
		$set.=",post_id='$pro_post_id'";
		$set.=",post_ip='$ip'";
		$set.=",crcdt='$timestamp'";
		$set.=",active_status='1'";
		$que="update project set $set where id='$insid'";
		$db->query($que);
		$pid = $insid;
	}
	else {
		$id1=chr(rand(97,122));
		$id2=rand(0,100);
		$pro_post_id="Eqcrwd".$id1.$id2;
		$set.=",post_id='$pro_post_id'";
		$set.=",post_ip='$ip'";
		$set.=",crcdt='$timestamp'";
		$set.=",active_status='1'";
		//$set.=",browser='$ua'";
		$que="insert into project set $set";
		$db->query($que);
	}
	
	$db->bind(":post_by", $post_by);
	$db->bind(":user_type", $user_type);
	$db->bind(":cmpy_name", $cmpy_name);
	//$db->bind(":cmpy_loc", $cmpy_loc);
	$db->bind(":cmpy_yrfound", $cmpy_yrfound);
	$db->bind(":cmpy_type", $cmpy_type);
	$db->bind(":cmpy_url", $cmpy_url);
	$db->bind(":lead_name", $lead_name);
	$db->bind(":lead_role", $lead_role);
	$db->bind(":tot_members", $tot_members);
	$db->bind(":email", $email);
	$db->bind(":ctc_num", $ctc_num);
	$db->bind(":location", $location);
	$db->bind(":title", $prjt_title);
	$db->bind(":category", $category);
	$db->bind(":goal", $goal);
	$db->bind(":min_raise", $min_raise);
	$db->bind(":repay_period", $repay_period);
	$db->bind(":repay_duration", $repay_duration);	
	$db->bind(":returns", $returns);	
	$db->bind(":start_dt", $start_dt);
	$db->bind(":deadline", $deadline);
	$db->bind(":hold_period", $hold_period);
	$db->bind(":hold_duration", $hold_duration);
	$db->bind(":descript", $descript);
	$db->bind(":highlights", $highlights);
	$db->bind(":invest_term", $invest_term);
	$db->bind(":prjt_sum", $prjt_sum);
	$db->bind(":edu_qual", $edu_qual);
	$db->bind(":exp", $exp);
	
	$exec = $db->execute();
	$insertid = $db->lastInsertId();
	if($insertid != 0) $pid = $insertid;
	
	/** process if document is uploaded **/
	if(isset($_FILES['doc']['tmp_name']) && !empty($_FILES['doc']['tmp_name'])) {
		$newName="doc".uniqid();
		$oldFile = $db->extractCol("select doc from project where id='$pid'");
		$upd=$common->uploadfile("doc", $newName, "../uploads/documents", $oldFile);
		if($upd) {
			$fileName=$common->fileName;
			$db->query("update project set doc='$fileName' where id='$pid'");
			$exec = $db->execute();
		}
		else {
			$err=$common->Err;
			$extra->setMsg($err, "danger");
			$cur_pg = $_SERVER['REQUEST_URI'];
			$rdir = dirname($baseUrl).'/'.substr(strrchr($cur_pg,'admin'), 0);
			$extra->redirect_to($rdir);
		}
	}

	if($exec) {
		if($isEdit) $msg="updated";
		else $msg="created";
		$extra->setMsg("Project $msg successfully!", "success");
		$extra->redirect_to($baseUrl."project/");
	}
}
$field_req = 'required';
if($isEdit) {
	$field_req = '';
	$db->query("select * from project where id=:id");
	$db->bind(":id", $prjt);
	$result=$db->fetch();
	if(!empty($result)) extract($result);
	else $extra->redirect_to($baseUrl."project/");
}

$prjt = isset($prjt)?$prjt:'none';

$userid = isset($result['userid'])?$result['userid']:0;
$user_type = isset($result['user_type'])?$result['user_type']:'';
$cmpy_name = isset($result['cmpy_name'])?$result['cmpy_name']:'';
//$cmpy_loc = isset($result['cmpy_loc'])?$result['cmpy_loc']:'';
$cmpy_yrfound = isset($result['cmpy_yrfound'])?$result['cmpy_yrfound']:'';
$cmpy_type = isset($result['cmpy_type'])?$result['cmpy_type']:'';
$cmpy_url = isset($result['cmpy_url'])?$result['cmpy_url']:'';
//$cmpy_logo = isset($result['cmpy_logo'])?$result['cmpy_logo']:'';
$edu_qual = isset($result['edu_qual'])?$result['edu_qual']:'';
$exp = isset($result['exp'])?$result['exp']:'';
$lead_name = isset($result['lead_name'])?$result['lead_name']:'';
$lead_role = isset($result['lead_role'])?$result['lead_role']:'';
$tot_members = isset($result['tot_members'])?$result['tot_members']:'';
$tot_members = ($tot_members != '0')?$tot_members:'';
$email = isset($result['email'])?$result['email']:'';
$ctc_num = isset($result['ctc_num'])?$result['ctc_num']:'';
$loc = isset($result['location'])?$result['location']:'';
$title = isset($result['title'])?$result['title']:'';
$category = isset($result['category'])?$result['category']:'';
$goal = isset($result['goal'])?$result['goal']:'';
$min_raise = isset($result['min_raise'])?$result['min_raise']:'';
$repay_period = isset($result['repay_period'])?$result['repay_period']:'';
$repay_duration = isset($result['repay_duration'])?$result['repay_duration']:'';
$returns = isset($result['returns'])?$result['returns']:'';
$start_dt = isset($result['start_dt'])?$result['start_dt']:'';
$deadline = isset($result['deadline'])?$result['deadline']:'';
$hold_period = isset($result['hold_period'])?$result['hold_period']:'';
$hold_duration = isset($result['hold_duration'])?$result['hold_duration']:'';
$descript = isset($result['descript'])?$result['descript']:'';
$highlights = isset($result['highlights'])?$result['highlights']:'';
$invest_term = isset($result['invest_term'])?$result['invest_term']:'';
$prjt_sum = isset($result['prjt_sum'])?$result['prjt_sum']:'';
$doc = isset($result['doc'])?$result['doc']:'';
$video = isset($result['video'])?$result['video']:'';
$img1 = isset($result['img1'])?$result['img1']:'';
$img2 = isset($result['img2'])?$result['img2']:'';
$img3 = isset($result['img3'])?$result['img3']:'';
$img4 = isset($result['img4'])?$result['img4']:'';

$prjtimg1 = $extra->chkprjtImg($img1, "../uploads/prjt-img/img1/");
$prjtimg2 = $extra->chkprjtImg($img2, "../uploads/prjt-img/img2/");
$prjtimg3 = $extra->chkprjtImg($img3, "../uploads/prjt-img/img3/");
$prjtimg4 = $extra->chkprjtImg($img4, "../uploads/prjt-img/img4/");
$document = $extra->chkprjtImg($doc, "../uploads/documents/");
$video = $extra->chkprjtImg($video, "../uploads/video/");

if(empty($prjtimg1)) {
	$prjtimg1 = dirname($baseUrl)."/uploads/prjt-img/img1/noimage.jpg";
}
if(!empty($prjtimg2)) { ?>
	<script>
	$(document).ready(function () {
		$('#imgId2').removeClass('hidden');
	});
	</script>
<? }
if(!empty($prjtimg3)) { ?>
	<script>
	$(document).ready(function () {
		$('#imgId3').removeClass('hidden');
	});
	</script>
<? }
if(!empty($prjtimg4)) { ?>
	<script>
	$(document).ready(function () {
		$('#imgId4').removeClass('hidden');
	});
	</script>
<? }
if(!empty($video)) { ?>
	<script>
	$(document).ready(function () {
		$('#vdoId').removeClass('hidden');
	});
	</script>
<? }
if($user_type == '0') {
	$cmpy_name = '';
	//$cmpy_loc = '';
	$cmpy_yrfound = '';
	$cmpy_type = '';
	$cmpy_url = '';
	//$cmpy_logo = '';
?>
	<script>
	$(document).ready(function () {
		$('#frlncerId').removeClass('hidden');			
		$('#cmpyId').addClass('hidden');
	});
	</script>
<? }
if($user_type == '1') {
	$edu_qual = '';
	$exp = '';
?>
	<script>
	$(document).ready(function () {
		$('#cmpyId').removeClass('hidden');			
		$('#frlncerId').addClass('hidden');
	});
	</script>
<? }
if(!empty($deadline))
	$deadline = date("d/m/Y",strtotime($deadline));
else
	$deadline = '';
if(!empty($start_dt))
	$start_dt = date("d/m/Y",strtotime($start_dt));
else
	$start_dt = '';
?>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-xs-12 mb-2">
                <h3 class="content-header-title mb-0"><?php echo ($isEdit)?"Edit":"Create"; ?> Project</h3>
            </div>
        </div>
        <div class="content-body">
            <section id="html">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Fund Raiser Details </h4>
								<?php echo $extra->flashMsg(); ?>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            </div>
                            <div class="card-body collapse in">
                                <div class="card-block card-dashboard table-responsive">
                                    <form name="ad_prjtpost" class="form-horizontal" method="post" enctype="multipart/form-data">
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Posted By </label>
                                            <div class="col-sm-10">
                                                <select id="postId" class="form-control group caps" name="post_by" onChange="return select(this.value)">
												<option value="0"> Select User </option>
												<?=$drop->dropselectSingle("select id,firstname from register where active_status='1' and email_active_status='1' order by firstname asc",$userid);?>
												</select>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Are You <span class="req"> * </span></label>
                                            <div class="col-sm-5">
                                                <input class="frln" name="user_type" type="radio" value="0" <? if($user_type == '0') echo 'checked'; ?> /> Individual &nbsp;&nbsp;&nbsp;
												<input class="cmpy" name="user_type" type="radio" value="1" <? if($user_type == '1') echo 'checked'; ?> /> Company
                                            </div>
                                        </div>
										
									<div id="cmpyId" class="hidden">
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Company Name <span class="req"> * </span></label>
                                            <div class="col-sm-10">
                                                <input class="form-control" name="cmpy_name" type="text" value="<?=$cmpy_name;?>" required />
                                            </div>
                                        </div>
										<!--<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Company Location <span class="req"> * </span></label>
                                            <div class="col-sm-10">
                                                <input class="form-control" name="cmpy_loc" type="text" value="<?=$cmpy_loc;?>" required />
                                            </div>
                                        </div>-->
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Year Founded <span class="req"> * </span> </label>
                                            <div class="col-sm-10">
                                                <input class="form-control" name="cmpy_yrfound" type="text" minlength="4" maxlength="4" onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57" value="<?=$cmpy_yrfound;?>" required />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Company Type <span class="req"> * </span></label>
                                            <div class="col-sm-10">
                                                <input class="form-control" name="cmpy_type" type="text" value="<?=$cmpy_type;?>" required />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Company Url</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" name="cmpy_url" type="url" value="<?=$cmpy_url;?>" />
                                            </div>
                                        </div>
										<!--<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Company Logo</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" name="cmpy_logo" type="file" />
                                            </div>
                                        </div>-->
									</div> 
									<div id="frlncerId" class="hidden">
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Qualification <span class="req">*</span></label>
                                            <div class="col-sm-10">
                                                <input id="qualId" class="form-control" name="edu_qual" type="text" value="<?=$edu_qual;?>" required />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Experience <span class="req">*</span></label>
                                            <div class="col-sm-10">
                                                <input id="expId" class="form-control" name="exp" type="text" value="<?=$exp;?>" required />
                                            </div>
                                        </div>
									</div>
									
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Email <span class="req"> * </span></label>
                                            <div class="col-sm-10">
                                                <input id="emailId" class="form-control" name="email" type="email" value="<?=$email;?>" required />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Contact Number <span class="req"> * </span></label>
                                            <div class="col-sm-10">
                                                <input id="ctcId" class="form-control" name="ctc_num" type="text" maxlength="15" minlength="10" onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57" value="<?=$ctc_num;?>" required />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Location <span class="req"> * </span></label>
                                            <div class="col-sm-10">
                                                <input class="form-control" name="location" type="text" value="<?=$loc;?>" required />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Highlights <span class="req"> * </span></label>
                                            <div class="col-sm-10">
                                                <textarea id="hglghtId" class="form-control tinymce" name="highlights"><?=stripslashes($highlights); ?> </textarea>
												<div id="hglghtErr" style="color:#d51510;"> </div>
                                            </div>
                                        </div>
										
										<div class="card-header">
											<h4 class="card-title">Team Members</h4>
											<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
										</div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Team Lead Name</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" name="lead_name" type="text" value="<?=$lead_name;?>" />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Team Lead Role</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" name="lead_role" type="text" value="<?=$lead_role;?>" />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Total Members </label>
                                            <div class="col-sm-10">
                                                <input class="form-control" name="tot_members" type="text" value="<?=$tot_members;?>" />
                                            </div>
                                        </div>
										
										<div class="card-header">
											<h4 class="card-title">Campaign Details</h4>
											<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
										</div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Campaign Name <span class="req"> * </span></label>
                                            <div class="col-sm-10">
                                                <input class="form-control" name="prjt_title" type="text" value="<?=stripslashes($title);?>" required />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Category <span class="req"> * </span></label>
                                            <div class="col-sm-10">
                                                <select class="form-control group caps"  name="category">
												<option value=""> Select Category </option>
												<?=$drop->dropselectSingle("select id,catagory_name from category where active_status='1' order by catagory_name asc",$category);?>
												</select>
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Goal  Amount <span class="req"> * </span> <br />(In <?=$site_currency; ?>)</label>
                                            <div class="col-sm-10">
                                                <input id="goalId" class="form-control" name="goal" type="text" onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57" value="<?=$goal;?>" required />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label"> Minimum Raise <span class="req"> * </span> <br />(In <?=$site_currency; ?>)</label>
                                            <div class="col-sm-10">
                                                <input id="min_investment" class="form-control" name="min_raise" type="text" onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57" value="<?=$min_raise;?>" required />
												<div id="minInvest" style="color:#d51510;"> </div>
                                            </div>
                                        </div>
										<!--<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Maximum Raise <span class="req"> * </span></label>
                                            <div class="col-sm-10">
                                                <input class="form-control" name="max_raise" type="text" value="<?=$val;?>" required />
                                            </div>
                                        </div>-->
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Repayment <span class="req"> * </span></label>
                                            <div class="col-sm-4">
                                                <input class="form-control" name="repay_period" type="text" onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57" value="<?=$repay_period;?>" required />
                                            </div>
											<div class="col-sm-5">
                                                <input name="repay_duration" type="radio" value="0" <? if($repay_duration == '0') echo 'checked'; ?> /> Month &nbsp;&nbsp;&nbsp;
												<input name="repay_duration" type="radio" value="1" <? if($repay_duration == '1') echo 'checked'; ?> /> Year
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Returns(%) <span class="req"> * </span></label>
                                            <div class="col-sm-10">
                                                <input class="form-control" name="returns" type="text" onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57" value="<?=$returns;?>" required />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Raise Starting Date <span class="req"> * </span></label>
                                            <div class="col-sm-10">
                                                <input class="form-control" name="start_dt" type="text" id="start_dt" value="<?=$start_dt;?>" required />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Raise Closing <br />Date <span class="req"> * </span></label>
                                            <div class="col-sm-10">
                                                <input class="form-control" name="deadline" type="text" id="end_dt" value="<?=$deadline;?>" required />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Hold Period <span class="req"> * </span></label>
                                            <div class="col-sm-4">
                                                <input class="form-control" name="hold_period" type="text" onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57" value="<?=$hold_period;?>" required />
                                            </div>
											<div class="col-sm-5">
                                                <input name="hold_duration" type="radio" value="0" <? if($hold_duration == '0') echo 'checked'; ?> /> Month &nbsp;&nbsp;&nbsp;
												<input name="hold_duration" type="radio" value="1" <? if($hold_duration == '1') echo 'checked'; ?> /> Year
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Project <br />Description <span class="req"> * </span></label>
                                            <div class="col-sm-10">
                                                <textarea id="descriptId" class="form-control tinymce" name="descript" rows="7" required><?=stripslashes($descript); ?></textarea>
												<div id="desErr" style="color:#d51510;"> </div>
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Investment <br />Terms <span class="req"> * </span></label>
                                            <div class="col-sm-10">
                                                <textarea id="investTerm" class="form-control tinymce" name="invest_term"> <?=stripslashes($invest_term); ?> </textarea>
												<div id="invErr" style="color:#d51510;"> </div>
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Project  <br />Summary <span class="req"> * </span></label>
                                            <div class="col-sm-10">
                                                <textarea id="prjtSum" class="form-control tinymce" name="prjt_sum"><?=stripslashes($prjt_sum); ?> </textarea>
												<div id="prjtErr" style="color:#d51510;"> </div>
                                            </div>
                                        </div>
										
										<div class="card-header">
											<h4 class="card-title">Document</h4>
											<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
										</div>
										
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">IM <span class="req"> * </span> </label>
                                            <div class="col-sm-6">
                                                <input class="form-control" name="doc" type="file" <?=$field_req ; ?> />
                                            </div>
											<? if(!empty($document)) { ?>
											<?=$doc;?>
												<a href="<?=dirname($baseUrl);?>/uploads/documents/<?=$doc;?>" title="Click to download">
													<img src="<?=dirname($baseUrl);?>/images/Downloads-icon.png" height="40px" />
												</a>
											<? } ?>
                                        </div>
										<div id="vdoId" class="form-group col-sm-12 hidden">
                                            <label class="col-sm-2 control-label"> </label>
                                            <div class="col-sm-10" id="showvdo">
											    <video width="300" height="200" controls>
													<source src="<? echo $video; ?>" type="video/mp4">
												</video>
												<input type="hidden"  name="insid5" id="dynamicid5" value="<?=$prjt;?>" />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Project Video</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" name="video" type="file" accept="video/mp4" onchange="video_upload()" />
                                            </div>
                                        </div>
										
										<div class="card-header">
											<h4 class="card-title">Image Gallery</h4>
											<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
										</div>
										<div id="imgId1" class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label"> </label>
                                            <div class="col-sm-10" id="showimg1" >
											    <img class="" src="<?=$prjtimg1; ?>" style="height:150px;width:150px;" />
												<input type="hidden"  name="insid1" id="dynamicid1" value="<?=$prjt;?>" />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Project Image1 </label>
                                            <div class="col-sm-10">
                                                <input class="form-control" name="img1" type="file" accept="image/*" onchange="prjt_img1()" <?=$field_req ; ?> />
                                            </div>
                                        </div>
										<div id="imgId2" class="form-group col-sm-12 hidden">
                                            <label class="col-sm-2 control-label"> </label>
                                            <div class="col-sm-10" id="showimg2" >
											   <img class="" src="<?=$prjtimg2; ?>" style="height:150px;width:150px;" />
											   <input type="hidden"  name="insid2" id="dynamicid2" value="<?=$prjt;?>" />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Project Image2 </label>
                                            <div class="col-sm-10">
                                                <input class="form-control" name="img2" type="file" accept="image/*" onchange="prjt_img2()" />
                                            </div>
                                        </div>
										<div id="imgId3" class="form-group col-sm-12 hidden">
                                            <label class="col-sm-2 control-label"> </label>
                                            <div class="col-sm-10" id="showimg3" >
											    <img class="" src="<?=$prjtimg3; ?>" style="height:150px;width:150px;" />
												<input type="hidden"  name="insid3" id="dynamicid3" value="<?=$prjt;?>" />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Project Image3 </label>
                                            <div class="col-sm-10">
                                                <input class="form-control" name="img3" type="file" accept="image/*" onchange="prjt_img3()" />
                                            </div>
                                        </div>
										<div id="imgId4" class="form-group col-sm-12 hidden">
                                            <label class="col-sm-2 control-label"> </label>
                                            <div class="col-sm-10" id="showimg4" >
											    <img class="" src="<?=$prjtimg4; ?>" style="height:150px;width:150px;" />
												<input type="hidden"  name="insid4" id="dynamicid4" value="<?=$prjt;?>" />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Project Image4 </label>
                                            <div class="col-sm-10">
                                                <input class="form-control" name="img4" type="file" accept="image/*" onchange="prjt_img4()" />
                                            </div>
                                        </div>
										<p style="color:#ae0707;"> ** Only jpg, jpeg, png, gif file with dimension above 770X400 & maximum size of 1 MB is allowed for Project Image upload.
										<br /> ** Only doc,docx,pdf file with maximum size of 2 MB is allowed for document(IM) upload.
										<br /> ** Only mp4 format with maximum size of 25 MB is allowed for video file upload. </p>
										<div class="form-actions center col-sm-12">
											<button onClick="return prjtvalid();" type="submit" class="btn btn-primary mr-1" name="prjt_sub"><i class="fa fa-check-square-o"></i> Save</button>
                                            <button type="button" class="btn btn-warning" onclick="window.history.back();"><i class="ft-x"></i> Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<script type="text/javascript">
function select(idval) {
	if(idval != '') {
		$.ajax({
		url: '<?=$baseUrl;?>getval-ajax.php?uid='+idval,
		type: 'POST',
		dataType: 'json',
		success: function (data) {
			$('#emailId').val(data.email);
			$('#ctcId').val(data.phone);
			return true;
	  }
	});
	}
}
</script>

<?php 
require "custom.php";
require "includes/footer.php";
?>