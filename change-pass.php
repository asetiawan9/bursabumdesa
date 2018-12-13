<?
	include "includes/header.php";
	include "includes/profhead.php";
	
if(isset($bank_det)) {
	$set="acc_name=:acc_name";
	$set.=",acc_num=:acc_num";
	$set.=",bank_name=:bank_name";
	$set.=",branch_name=:branch_name";
	$set.=",ifsc=:ifsc";
	
	$set.=",chngdt='$timestamp'";
	$set.=",recent_ipaddr='$ip_addr'";
	
	$que="update register set $set where id='$id'";
	$db->query($que);
	$db->bind(":acc_name", $acct_name);
	$db->bind(":acc_num", $acct_num);
	$db->bind(":bank_name", $bnk_name);
	$db->bind(":branch_name", $branch);
	$db->bind(":ifsc", $ifsc_code);
	$db->execute();
	$extra->swalMsg("success!","Bank details Updated successfully!","success",$baseUrl.'change-pass/');
}
if(isset($chng_pass)) {
	$db_pass = $db->extractCol("select password from register where id='$id'");
	if($old_pass != $db_pass) {
		$extra->swalMsg("Oops!","Incorrect Old Password!","error",$baseUrl.'change-pass/');
	}
	else if($old_pass == $new_pass) {
		$extra->swalMsg("Oops!","Your New Password is same as the Old Password !","error",$baseUrl.'change-pass/');
	}
	else if(strlen($new_pass) < 6) {
		$extra->swalMsg("Oops!","Length of password atleast 6 characters","warning",$baseUrl.'change-pass/');
	}
	else if(strlen($new_pass) > 15) {
		$extra->swalMsg("Oops!","Length of password should not exceed 15 characters","warning",$baseUrl.'change-pass/');
	}
	else {
		$enc_pass = $user->pass_hash($new_pass);
		$set="password=:password";
		$set.=",repassword=:repassword";
		
		$set.=",chngdt='$timestamp'";
		$set.=",recent_ipaddr='$ip_addr'";
		
		$que="update register set $set where id='$id'";
		$db->query($que);
		$db->bind(":password", $new_pass);
		$db->bind(":repassword", $enc_pass);
		$db->execute();
		$db->query("update register set logout_ip_addr='$ip_addr' where id='$id'");	
		$db->execute();
		session_destroy();
		$extra->swalMsg("Password Changed!","Now login with new Password!","success",$baseUrl.'login/');
	}
}

if(isset($tet_sub)) {
	if(strlen($comment) > 250) {
		$extra->swalMsg("Oops!","Comment length should not exceed 200 characters!","error",$baseUrl.'change-pass/');exit;
	}
	
	$set="comment=:comment";
	$set.=",user_id=:user_id";
	$db->query("select * from testimonial where user_id='$id'");
	$tet_ct = $db->rowCount();
	if($tet_ct > 0) {
		$set.=",chng_dt='$tday'";
		$set.=",chng_ip='$ip_addr'";
		$que = "update testimonial set $set where user_id='$id'";
	}
	else if($tet_ct == 0) {
		$set.=",post_dt='$tday'";
		$set.=",post_ip='$ip_addr'";
		$que = "insert into testimonial set $set";
	}
	$db->query($que);
	$db->bind(":comment", $comment);
	$db->bind(":user_id", $id);
	$exc = $db->execute();
	if($exc) {
		$extra->swalMsg("success!","Your Comment posted successfully!","success",$baseUrl.'change-pass/');
	}
}

if(isset($delt)) {
	$db->query("delete from testimonial where id=:id");
	$db->bind(":id", $delt);
	$db->execute();
	$extra->swalMsg("success!","Deleted successfully!","success",$baseUrl.'change-pass/');
}

$db->query("select * from testimonial where user_id=:usrid");
$db->bind(":usrid", $id);
$testimonial = $db->fetch();
$comnt = $testimonial['comment'];
$post_dt = $testimonial['post_dt'];
$chng_dt = $testimonial['chng_dt'];
$active_status = $testimonial['active_status'];
if($chng_dt != '0000-00-00')
	$tet_updt = date("d-M-Y",strtotime($chng_dt));
else
	$tet_updt = date("d-M-Y",strtotime($post_dt));
if($active_status == 0)
	$tet_sts = 'Inactive';
else
	$tet_sts = 'Active';
if(!empty($testimonial)) {
	$tetdel_opt = "<span style=\"margin-left:65%;\"><a href=\"$baseUrl/change-pass/$testimonial[id]/\" title=\"Delete Testimonial\" onclick=\"return confirmAct();\"><i class=\"far fa-trash-alt\"></i> Delete Testimonial</a></span>";
	$tetstatus = "<ul class=\"usr_hd_list\">
		<li><b>Last Updation : </b> $tet_updt</li>
		<li><b>Status : </b> $tet_sts</li>
	  </ul>";	  
}
else {
	$tetdel_opt = '';
	$tetstatus = '';
}
?>
      <div class="container">
         <div class="row">
            <div class="col-sm-9">
               <div class="col-sm-12 dashboard">
                  <div class="row">
					<h2>Settings</h2>
                  </div>
				  <div class="row">
                     <div class="col-sm-12">
						<form name="usr_bankdet" method="post" class="form-horizontal" action="">
                           <div class="form-group">
                              <h4>Account Settings</h4>
                           </div>
                           <div class="form-group">
                              <label class="col-sm-3">Account Holder</label>
                              <div class="col-sm-1 text-center hidden-xs">:</div>
                              <div class="col-sm-8">
                                 <input type="text" name="acct_name" class="form-control" value="<?=$acc_name;?>" placeholder="As Per Bank Account Name" required />
                              </div>
                           </div>
						   <div class="form-group">
                              <label class="col-sm-3">Account Number</label>
                              <div class="col-sm-1 text-center hidden-xs">:</div>
                              <div class="col-sm-8">
                                 <input type="text" name="acct_num" class="form-control" value="<?=$acc_num;?>" placeholder="Bank Account Number" required />
                              </div>
                           </div>
						   <div class="form-group">
                              <label class="col-sm-3">Bank Name</label>
                              <div class="col-sm-1 text-center hidden-xs">:</div>
                              <div class="col-sm-8">
                                 <input type="text" name="bnk_name" class="form-control" value="<?=$bank_name;?>" placeholder="Bank Name" required />
                              </div>
                           </div>
						   <div class="form-group">
                              <label class="col-sm-3">Branch Name</label>
                              <div class="col-sm-1 text-center hidden-xs">:</div>
                              <div class="col-sm-8">
                                 <input type="text" name="branch" class="form-control" value="<?=$branch_name;?>" placeholder="Branch Name" required />
                              </div>
                           </div>
						   <div class="form-group">
                              <label class="col-sm-3">IFSC Code</label>
                              <div class="col-sm-1 text-center hidden-xs">:</div>
                              <div class="col-sm-8">
                                 <input type="text" name="ifsc_code" class="form-control" value="<?=$ifsc;?>" placeholder="Bank IFSC Code" required />
                              </div>
                           </div>
						   <div class="form-group text-center">
								<input type="submit" name="bank_det" class="button ml15" value="Save Account">
						   </div>
                        </form>
                     </div>
						
						<div class="col-sm-12">
						<form name="usr_passchng" method="post" class="form-horizontal mt30" action="">
                           <div class="form-group">
                              <h4>Password Settings</h4>
                           </div>
                           <div class="form-group">
                              <label class="col-sm-3">Current Password</label>
                              <div class="col-sm-1 text-center hidden-xs">:</div>
                              <div class="col-sm-8">
                                 <input type="password" name="old_pass" id="oldPass" class="form-control" placeholder="Enter Current Password" required />
								 <div id="errId" style="color:#d51510;"> </div>
                              </div>
							  
                           </div>
						   <div class="form-group">
                              <label class="col-sm-3">New Password</label>
                              <div class="col-sm-1 text-center hidden-xs">:</div>
                              <div class="col-sm-8">
                                 <input type="password" name="new_pass" id="newpass" class="form-control" maxlength="15" minlength="6" placeholder="Enter New Password" required />
                              </div>
                           </div>
						   <div class="form-group">
                              <label class="col-sm-3">Confirm Password</label>
                              <div class="col-sm-1 text-center hidden-xs">:</div>
                              <div class="col-sm-8">
                                 <input type="password" name="cpass" class="form-control" placeholder="Confirm New Password" required />
                              </div>
                           </div>
						   <div class="form-group text-center">
								<input onClick="return checkDBPass();" type="submit" name="chng_pass" class="button ml15 chngpass" value="Save Password" />
						   </div>
						   <p><strong>Note: </strong>Changing your password will clear login cookies. You will need to login again after saving.</p>
                        </form>
						</div>
						
						<div class="col-sm-12">
						<form method="post" class="form-horizontal" action="">
						<div id="hidden" style="display:none"></div>
                           <div class="form-group">
                              <h4>Testimonial <?=$tetdel_opt;?> </h4>
							  <?=$tetstatus;?>
                           </div>
                           <div class="form-group">
                              <label class="col-sm-3">Comments</label>
                              <div class="col-sm-1 text-center hidden-xs">:</div>
                              <div class="col-sm-8">
								 <textarea id="tetcmntId" class="form-control tinymce" name="comment"><?=stripslashes($comnt); ?> </textarea>
								 <div id="tetcmntErr" style="color:#d51510;"> </div>
                              </div>
                           </div>
						   <div class="form-group text-center">
								<input onClick="return tetvalid();" type="submit" name="tet_sub" class="button ml15" value="Post">
						   </div>
                        </form>
                     </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
<script>
function checkDBPass() {
	var oldPass = document.usr_passchng.old_pass.value;
	var u_id = "<?=$id; ?>";
	if(oldPass != '') {
	$.ajax({url: "<?=$baseUrl;?>/checkpass/",
		type: 'POST',
		data: {old_pass:oldPass, uid:u_id} ,
		success: function(result){
			 if(result==1) {
				document.getElementById("errId").innerHTML = 'Incorrect Old Password';
				document.usr_passchng.old_pass.value="";
				return false;
			 }
		}
	});
	}
}
</script>
<? include "includes/footer.php"; ?>