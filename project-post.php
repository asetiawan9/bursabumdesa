<?
	include "includes/header.php";
	include "includes/profhead.php";

$isEdit=false;
if(isset($prjt)) $isEdit=true;
if(isset($usrprjt_sub)) {
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
		//$set.=",browser='$ua'";
		$que="insert into project set $set";
		$db->query($que);
	}
	
	$db->bind(":post_by", $id);
	$db->bind(":user_type", $usertype);
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
		$newName = "doc".uniqid();
		$oldFile = $db->extractCol("select doc from project where id='$pid'");
		$upd = $common->uploadfile("doc", $newName, "uploads/documents", $oldFile);
		if($upd) {
			$fileName = $common->fileName;
			$db->query("update project set doc='$fileName' where id='$pid'");
			$exec = $db->execute();
		}
		else {
			$err = $common->Err;
			$extra->swalMsg("Oops!",$err,"error",$baseUrl."project-post/");
		}
	}

	if($exec) {
		if($isEdit) {
			$msg = "updated";			
			$extra->swalMsg("success!","Project $msg successfully!","success",$baseUrl.'user-listing/');
		}
		else {
			$msg = "created";
			if($hold_duration == 0) $hold_dur = 'Month';
			else $hold_dur = 'Year';
			$usrmail = $email;
			$subject = "New project post from $site_title";
			$site_logo_lnk = "$baseUrl/uploads/settings/$site_logo";
			$content = "<center>User Have posted new project on $site_title!";
			$content .="<br><br><span style='color:#7a79d7;'>Here is the Project short Details,</span>";
			$content .="<table class='mail-tabl'><tr><td> Project Title </td><td>:</td><td> $prjt_title</td></tr>
			<tr><td> Goal Amount  </td><td>:</td><td> $site_currency $goal</td></tr>
			<tr><td> Raise Starting Date  </td><td>:</td><td> $start_dt</td></tr>
			<tr><td> Raise Closing Date  </td><td>:</td><td> $deadline</td></tr>
			<tr><td> Returns  </td><td>:</td><td> $returns %</td></tr>
			<tr><td> Project Completion  </td><td>:</td><td> $hold_period $hold_dur</td></tr>
			</table></center>";
			$specific_title = "";
			$btn_name = 'Click Here to visit the site & activate the User Project';
			$message = $extra->customtemplate($baseUrl,$site_logo_lnk,$content,$site_title,$baseUrl,$specific_title,$btn_name);
			$result = $common->email($usrmail,$admin_email,$subject,$message);
			$extra->swalMsg("success!","Project $msg successfully! After Approval from Admin your project on live. Kindly check your email.","success",$baseUrl.'user-listing/');
		}
	}
}
$field_req = 'required';
if(isset($prjt)) {
	$field_req = '';
	$db->query("select * from project where id=:id");
	$db->bind(":id", $prjt);
	$result = $db->fetch();
	if(!empty($result)) extract($result);
	else $extra->redirect_to($baseUrl."list/");
}
$prjt = isset($prjt)?$prjt:'none';
$userid = isset($result['userid'])?$result['userid']:0;
$user_type = isset($result['user_type'])?$result['user_type']:'';
$cmpy_name = isset($result['cmpy_name'])?$result['cmpy_name']:'';
//$cmpy_loc = isset($result['cmpy_loc'])?$result['cmpy_loc']:'';
$cmpy_yrfound = isset($result['cmpy_yrfound'])?$result['cmpy_yrfound']:'';
$cmpy_type = isset($result['cmpy_type'])?$result['cmpy_type']:'';
$cmpy_url = isset($result['cmpy_url'])?$result['cmpy_url']:'';
$cmpy_logo = isset($result['cmpy_logo'])?$result['cmpy_logo']:'';
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

$prjtimg1 = $extra->chkprjtImg($img1, "uploads/prjt-img/img1/");
$prjtimg2 = $extra->chkprjtImg($img2, "uploads/prjt-img/img2/");
$prjtimg3 = $extra->chkprjtImg($img3, "uploads/prjt-img/img3/");
$prjtimg4 = $extra->chkprjtImg($img4, "uploads/prjt-img/img4/");
$document = $extra->chkprjtImg($doc, "uploads/documents/");
$video = $extra->chkprjtImg($video, "uploads/video/");

if(empty($prjtimg1)) {
	$prjtimg1 = $baseUrl."/uploads/prjt-img/img1/noimage.jpg";
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
	$cmpy_logo = '';
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
	  
<div class="container">
 <div class="col-sm-12">
                  <div class="row dash">
					<h2 class="mb15i">Post Project</h2>
                  </div>	
	<form name="usr_adprjt" method="post" class="post_form" action="">
			<div class="row setup-content">
			     <div class="col-sm-4 mt20i" id="sidebar2">
					 <div class="sidebar theiaStickySidebar">
						<div class="widget side_menu">
						   <div class="widget-content">
							  <ul class="category" role="tablist">
								 <li><h4 class="text-center">Company Profile</h4></li>
								 <li>
									<a class="smoothScroll" href="#company_basic" aria-controls="company_basic" role="tab" data-toggle="tab">Company Basic</a>
								 </li>
								 <li>
									<a class="smoothScroll" href="#company_overview" aria-controls="company_overview" role="tab" data-toggle="tab"> Company Overview</a>
								 </li>
								 <li>
									<a class="smoothScroll" href="#conpany_contact" aria-controls="conpany_contact" role="tab" data-toggle="tab">Company Contact</a>
								 </li>
								 <li>
									<a class="smoothScroll" href="#company_team" aria-controls="company_team" role="tab" data-toggle="tab">Team Members</a>
								 </li>
								 <li class="disabled"><h4 class="text-center">Post Campaign</h4></li>
								 <li>
									<a class="smoothScroll" href="#fundraising_detail" aria-controls="fundraising_detail" role="tab" data-toggle="tab">Fundraising Detail</a>
								 </li>
								 <li>
									<a class="smoothScroll" href="#campaign_details" aria-controls="campaign_details" role="tab" data-toggle="tab">Campaign Details</a>
								 </li>
								 <li>
									<a class="smoothScroll" href="#investment_terms" aria-controls="investment_terms" role="tab" data-toggle="tab">Investment Terms</a>
								 </li>
								 <li>
									<a class="smoothScroll" href="#sumry" aria-controls="sumry" role="tab" data-toggle="tab">Project Summary</a>
								 </li>
								 <li><h4 class="text-center">Media and Document</h4></li>
								 <li>
									<a class="smoothScroll" href="#documents" aria-controls="documents" role="tab" data-toggle="tab">Documents</a>
								 </li>
								 <li>
									<a class="smoothScroll" href="#img_gal" aria-controls="img_gal" role="tab" data-toggle="tab">Image Gallery</a>
								 </li>
								 <li>
									<a class="smoothScroll" href="#video" aria-controls="video" role="tab" data-toggle="tab">Video</a>
								 </li>
							  </ul>
						   </div>
						</div>
					 </div>
				  </div>
				<div class="col-sm-8">
					<div class="causes-single-page">
						<div class="causes-description mt20i">
						   <div class="description-content">
							 
							  <section id="company_basic" class="sec_pd mt30">
								 <div class="single-description">
									<h4 class="description-title mt30">Company Basic</h4>
									
									<div class="form-group">
										<label>Are You <span class="req">*</span></label>
										<input id="radio1" class="frln" name="usertype" type="radio" value="0" <? if($user_type == '0') echo 'checked'; ?> /> Individual &nbsp;&nbsp;&nbsp;
										<input id="radio1" class="cmpy" name="usertype" type="radio" value="1" <? if($user_type == '1') echo 'checked'; ?> /> Company
										<div id="usrtypErr" style="color:#d51510;"> </div>
									</div>
									
									<div id="cmpyId" class="hidden">
									<div class="form-group">
										<label>Company Name <span class="req">*</span></label>
										<input id="cmpId" class="form-control" name="cmpy_name" type="text" value="<?=$cmpy_name;?>" required />
										<div id="cmpErr" style="color:#d51510;"> </div>
									</div>
									
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label>Year Founded <span class="req">*</span></label>
												<input id="yrfndId" class="form-control" name="cmpy_yrfound" type="text" minlength="4" maxlength="4" onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57" value="<?=$cmpy_yrfound;?>" required />
												<div id="yrfndErr" style="color:#d51510;"> </div>
											</div>
										</div>
									</div>
									
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label>Company Type <span class="req">*</span></label>
												<input id="cmptypId" class="form-control" name="cmpy_type" type="text" value="<?=$cmpy_type;?>" required />
												<div id="cmptypErr" style="color:#d51510;"> </div>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label>Company Url</label>
												<input class="form-control" name="cmpy_url" type="url" value="<?=$cmpy_url;?>" />
											</div>
										</div>
									</div>
									</div>
									
									<div id="frlncerId" class="hidden">
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label>Qualification<span class="req">*</span></label>
												<input id="qualId" class="form-control" name="edu_qual" type="text" value="<?=$edu_qual;?>" required />
												<div id="qualErr" style="color:#d51510;"> </div>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label>Experience <span class="req">*</span></label>
												<input id="expId" class="form-control" name="exp" type="text" value="<?=$exp;?>" required />
												<div id="expErr" style="color:#d51510;"> </div>
											</div>
										</div>
									</div>
									</div>
								 </div>
							  </section>
							  
							  <section id="company_overview" class="sec_pd mt30">
								<div class="single-description">
									<h4 class="description-title mt30"> Overview</h4>
									<div class="form-group">
										<label>Highlights <span class="req">*</span></label>
										<textarea id="hglghtId" class="form-control tinymce" name="highlights"><?=stripslashes($highlights); ?> </textarea>
										<div id="hglghtErr" style="color:#d51510;"> </div>
									</div>
								</div>
							  </section>
							  
							  <section id="conpany_contact" class="sec_pd mt30">
								<div class="single-description">
									<h4 class="description-title mt30">Company Contact</h4>
									<div class="form-group">
										<label>Email ID<span class="req">*</span></label>
										<input id="emailId" class="form-control" name="email" type="email" value="<?=$email;?>" required />
										<div id="mailErr" style="color:#d51510;"> </div>
									</div>
									
									<div class="form-group">
										<label>Contact Number<span class="req">*</span></label>
										<input id="ctcId" class="form-control" name="ctc_num" type="text" maxlength="15" minlength="10" onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57" value="<?=$ctc_num;?>" required />
										<div id="ctcErr" style="color:#d51510;"> </div>
									</div>
									
									<div class="form-group">
										<label>Location<span class="req">*</span></label>
										<input id="locId" class="form-control" name="location" type="text" value="<?=$loc;?>" required />
										<div id="locErr" style="color:#d51510;"> </div>
									</div>
								</div>
							  </section>
							  
							  <section id="company_team" class="sec_pd mt30">
								<div class="single-description">
									<h4 class="description-title mt30">Team Members</h4>
									<div class="form-group">
										<label>Team Lead Name </label>
										<input class="form-control" name="lead_name" type="text" value="<?=$lead_name;?>" />
									</div>
									<div class="form-group">
										<label>Team Lead Role </label>
										<input class="form-control" name="lead_role" type="text" value="<?=$lead_role;?>" />
									</div>
									<div class="form-group">
										<label>Total Members </label>
										<input class="form-control" name="tot_members" type="text" value="<?=$tot_members;?>" />
									</div>
								</div>
							  </section>
							  
						   </div>
						</div>
					 </div>
				<!--</div>-->
				<!--</div>	-->  
			<!--<div class="row setup-content">
				<div class="col-sm-4">
				</div>
			  <div class="col-sm-8">-->
				 <div class="causes-single-page">
					<div class="causes-description mt20i">
					   <div class="description-content">        
						  <section id="fundraising_detail" class="sec_pd mt30">
							 <div class="single-description">
								<h4 class="description-title mt30">Fundraising Detail</h4>
								
								<div class="form-group">
									<label>Campaign Name <span class="req">*</span></label>
									<input id="prjtId" class="form-control" name="prjt_title" type="text" value="<?=stripslashes($title);?>" required />
									<div id="campnmErr" style="color:#d51510;"> </div>
								</div>
								<div class="form-group">
									<label>Category <span class="req">*</span></label>
									<select id="catId" class="form-control group caps"  name="category">
									<option value=""> Select Category </option>
									<?=$drop->dropselectSingle("select id,catagory_name from category where active_status='1' order by catagory_name asc",$category);?>
									</select>
									<div id="catErr" style="color:#d51510;"> </div>
								</div>
								
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label>Fundraising Goal <span class="req">*</span></label>
											<input id="goalId" class="form-control" name="goal" type="text" onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57" value="<?=$goal;?>" required />
											<div id="goalErr" style="color:#d51510;"> </div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label>Minimum Raise <span class="req">*</span></label>	<input id="min_investment" class="form-control" name="min_raise" type="text" onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57" value="<?=$min_raise;?>" required />
											<div id="minInvest" style="color:#d51510;"> </div>
										</div>
									</div>		
								</div>
								
								<div class="row">
									<div class="col-sm-3">
										<div class="form-group">
											<label>Repayment <span class="req">*</span></label>
											<input id="repayId" class="form-control" name="repay_period" type="text" onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57" value="<?=$repay_period;?>" required />
											<div id="repayErr" style="color:#d51510;"> </div>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<br /><br /><input name="repay_duration" type="radio" value="0" <? if($repay_duration == '0') echo 'checked'; ?> /> Month &nbsp;&nbsp;&nbsp;
											<input name="repay_duration" type="radio" value="1" <? if($repay_duration == '1') echo 'checked'; ?> /> Year
										</div>
									</div>
								
									<div class="col-sm-6">
										<div class="form-group">
											<label>Returns(%) <span class="req">*</span></label>
											<input id="rtnId" class="form-control" name="returns" type="text" onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57" value="<?=$returns;?>" required />
											<div id="rtnErr" style="color:#d51510;"> </div>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label>Start Date <span class="req">*</span></label>
											<input class="form-control" name="start_dt" type="text" id="start_dt" value="<?=$start_dt;?>" required />
											<div id="strdtErr" style="color:#d51510;"> </div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label>Closing Date <span class="req">*</span></label>
											<input class="form-control" name="deadline" type="text" id="end_dt" value="<?=$deadline;?>" required />
											<div id="clsdtErr" style="color:#d51510;"> </div>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label>Hold Period <span class="req">*</span></label>
											<input id="holdId" class="form-control" name="hold_period" type="text" onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57" value="<?=$hold_period;?>" required />
											<div id="holdErr" style="color:#d51510;"> </div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<br /><br /><input name="hold_duration" type="radio" value="0" <? if($hold_duration == '0') echo 'checked'; ?> /> Month &nbsp;&nbsp;&nbsp;
											<input name="hold_duration" type="radio" value="1" <? if($hold_duration == '1') echo 'checked'; ?> /> Year
										</div>
									</div>
								</div>
								 
							 </div>
						  </section>
						  
						  <section id="campaign_details" class="sec_pd mt30">
							<div class="single-description">
								<h4 class="description-title mt30">Campaign Description</h4>
								<div class="form-group">
									<label>Campaign Description <span class="req">*</span></label>
									<textarea id="descriptId" class="form-control tinymce" name="descript" rows="7" required><?=stripslashes($descript); ?></textarea>
									<div id="desErr" style="color:#d51510;"> </div>
								</div>
							</div>
						  </section>
						  
						  <section id="investment_terms" class="sec_pd mt30">
							<div class="single-description">
								<h4 class="description-title mt30">Investment Terms</h4>
								<div class="form-group">
									<label>Investment Terms <span class="req">*</span></label>
									<textarea id="investTerm" class="form-control tinymce" name="invest_term"> <?=stripslashes($invest_term); ?> </textarea>
									<div id="invErr" style="color:#d51510;"> </div>
								</div>
							</div>
						  </section>
						  
						  <section id="risk" class="sec_pd mt30">
							<div class="single-description">
								<h4 class="description-title mt30">Project Summary</h4>
								<div class="form-group">
									<label>Investment Terms <span class="req">*</span></label>
									<textarea id="prjtSum" class="form-control tinymce" name="prjt_sum"><?=stripslashes($prjt_sum); ?> </textarea>
									<div id="prjtErr" style="color:#d51510;"> </div>
								</div>
								<div class="clearfix"></div>
							</div>
						  </section>
						  
					   </div>
					</div>
				 </div>
			  <!--</div>-->
			<!--</div>-->
			<!--<div class="row setup-content">
				<div class="col-sm-4">
				</div>
			  <div class="col-sm-8">-->
				 <div class="causes-single-page">
					<div class="causes-description mt20i">
					   <div class="description-content">
						  <section id="documents" class="sec_pd mt30">
							<div class="single-description">
								<h4 class="description-title mt30">Documents</h4>
								<div class="form-group">
									<label>Document <span class="req">*</span></label>
									<input name="doc" type="file" <?=$field_req ; ?> />
								</div>
							</div>
						  </section>
						  
						  <section id="img_gal" class="sec_pd mt30">
							<div class="single-description">
								<h4 class="description-title mt30">Image Gallery</h4>
								<div id="imgId1" class="form-group">
									<label> </label>
									<div class="col-sm-10" id="showimg1" >
										<img class="" src="<?=$prjtimg1; ?>" style="height:150px;width:150px;" />
										<input type="hidden"  name="insid1" id="dynamicid1" value="<?=$prjt;?>" />
									</div>
								</div>
								<div class="form-group">
									<label>Project Image1 <span class="req">*</span></label>
									<input name="img1" type="file" accept="image/*" onchange="prjt_img1()" <?=$field_req ; ?> />
								</div>
								<div id="imgId2" class="form-group hidden">
									<label> </label>
									<div class="col-sm-10" id="showimg2" >
									   <img class="" src="<?=$prjtimg2; ?>" style="height:150px;width:150px;" />
									   <input type="hidden"  name="insid2" id="dynamicid2" value="<?=$prjt;?>" />
									</div>
								</div>
								<div class="form-group">
									<label>Project Image2 </label>
									<input name="img2" type="file" accept="image/*" onchange="prjt_img2()" />
								</div>
								<div id="imgId3" class="form-group hidden">
									<label> </label>
									<div class="col-sm-10" id="showimg3" >
										<img class="" src="<?=$prjtimg3; ?>" style="height:150px;width:150px;" />
										<input type="hidden"  name="insid3" id="dynamicid3" value="<?=$prjt;?>" />
									</div>
								</div>
								<div class="form-group">
									<label>Project Image3 </label>
									<input name="img3" type="file" accept="image/*" onchange="prjt_img3()" />
								</div>
								<div id="imgId4" class="form-group hidden">
									<label> </label>
									<div class="col-sm-10" id="showimg4" >
										<img class="" src="<?=$prjtimg4; ?>" style="height:150px;width:150px;" />
										<input type="hidden"  name="insid4" id="dynamicid4" value="<?=$prjt;?>" />
									</div>
								</div>
								<div class="form-group">
									<label>Project Image4 </label>
									<input name="img4" type="file" accept="image/*" onchange="prjt_img4()" />
								</div>
							</div>
						  </section>
						  
						  <section id="video" class="sec_pd mt30">
							<div class="single-description">
								<h4 class="description-title mt30">Video</h4>
								<div id="vdoId" class="form-group hidden">
									<label> </label>
									<div class="col-sm-10" id="showvdo">
										<video width="300" height="200" controls>
											<source src="<? echo $video; ?>" type="video/mp4">
										</video>
										<input type="hidden"  name="insid5" id="dynamicid5" value="<?=$prjt;?>" />
									</div>
								</div>
								<div class="form-group">
									<label>Upload Video </label>
									<input class="form-control" name="video" type="file" accept="video/mp4" onchange="video_upload()" />
								</div>
								<div class="row">
								<div class="col-sm-6 text-left">
								<? if($isEdit) {?>
									<input onClick="return usr_prjt_sub();" type="Submit" name="usrprjt_sub" class="button follow_btn" value="Update" style="width: inherit;margin-bottom:10px;">
								<? } else {?>
									<input onClick="return usr_prjt_sub();" type="Submit" name="usrprjt_sub" class="button follow_btn" value="Post" style="width: inherit;margin-bottom:10px;">
								<? } ?>
								</div>
							</div>
								
							</div>
						  </section>
						   
					   </div>
					</div>
				 </div>
			  <!--</div>-->
			</div>
			</div>
		</form>
	
</div>
</div>

<? 
require "custom.php";
include "includes/footer.php";
?>