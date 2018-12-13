$(document).ready(function () {
$("form[name='regfrm']").validate({
    // Specify validation rules
    rules: {    
      username: "required",
      email: {
        required: true,       
        email: true
      },
	  ctc_number: {
        required: true,
        minlength: 10,
		maxlength: 15
      },
      pass: {
        required: true,
        minlength: 6,
		maxlength: 15
      },
	  cpass: {
        required: true,
		equalTo: "#passId"
      },
	  agree: "required"
    },
    // Specify validation error messages
    messages: {
      username: "This field is required",
      email: {
        required: "This field is required",       
        email: "Invalid Email Id"
      },
	  ctc_number: {
        required: "This field is required",
        minlength: "Length should be 10 characters minimum",
		maxlength: "Length should not exceed 15 characters maximum"
      },
      pass: {
        required: "This field is required",
        minlength: "Length should be 6 characters minimum",
		maxlength: "Length should not exceed 15 characters maximum"
      },
	  cpass: {
        required: "This field is required",
		equalTo: "Password doesn't match"
      },
	  agree: "Click to agree the terms & conditions"
    },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
      form.submit();
    }
});

$("form[name='lgfrm']").validate({
    rules: {    
      email: "required",     
	  password: "required"
    },
    messages: {
      email: "This field is required",
	  password: "This field is required"
    },
    submitHandler: function(form) {
      form.submit();
    }
});

$("form[name='frgtfrm']").validate({
    rules: {    
      email: "required"
    },
    messages: {
      email: "This field is required"
    },
    submitHandler: function(form) {
      form.submit();
    }
});

$("form[name='usrprf']").validate({
    rules: {    
      f_name: "required",
	  l_name: "required",
      ctry_name: "required",
	  ctc_number: {
        required: true,
        minlength: 10,
		maxlength: 15
      },
      zip_code: {
        required: true,
        minlength: 5,
		maxlength: 6
      }
    },
    messages: {
      f_name: "This field is required",
	  l_name: "This field is required",
	  ctry_name: "This field is required",
	  ctc_number: {
        required: "This field is required",
        minlength: "Length should be 10 characters minimum",
		maxlength: "Length should not exceed 15 characters maximum"
      },
      zip_code: {
        required: "This field is required",
        minlength: "Length should be 5 characters minimum",
		maxlength: "Length should not exceed 6 characters maximum"
      }
    },
    submitHandler: function(form) {
      form.submit();
    }
});

$("form[name='usr_bankdet']").validate({
    rules: {
	  acct_name: "required",
	  acct_num: "required",
      bnk_name: "required",
	  branch: "required",
	  ifsc_code: {
        required: true,
        minlength: 16,
		maxlength: 16
      }
    },
    messages: {
	  acct_name: "This field is required",
	  acct_num: "This field is required",
      bnk_name: "This field is required",
	  branch: "This field is required",
	  ifsc_code: {
        required: "This field is required",
        minlength: "Length should be 16 characters minimum",
		maxlength: "Length should not exceed 16 characters maximum"
      }
    },
    submitHandler: function(form) {
      form.submit();
    }
});

$("form[name='usr_passchng']").validate({
    rules: {    
      old_pass: "required",
      new_pass: {
        required: true,
        minlength: 6,
		maxlength: 15
      },
	  cpass: {
        required: true,
		equalTo: "#newpass"
      }
    },
    messages: {
      old_pass: "This field is required",
      new_pass: {
        required: "This field is required",
        minlength: "Length should be 6 characters minimum",
		maxlength: "Length should not exceed 15 characters maximum"
      },
	  cpass: {
        required: "This field is required",
		equalTo: "Password doesn't match"
      }
    },
    submitHandler: function(form) {
      form.submit();
    }
});

$("form[name='usr_adprjt']").validate({
    rules: {
	  usertype: "required",
	  edu_qual: "required",
	  exp: "required",
	  cmpy_name: "required",
	 /*  cmpy_loc: "required", */
	  cmpy_yrfound: {
        required: true
      },
	  cmpy_type: "required",
	  email: {
        required: true,       
        email: true
      },
	  ctc_number: {
        required: true,
        minlength: 10,
		maxlength: 15
      },
	  location: "required",
	  prjt_title: {
        required: true,
		maxlength: 25
      },
	  category: "required",
	  goal: "required",
	  min_raise: "required",
	  //max_raise: "required",
	  repay_period: "required",
	  repay_duration: "required",
	  returns: "required",
	  deadline: "required",
	  hold_period: "required",
	  hold_duration: "required"
    },
    messages: {
      usertype: "This field is required",
	  edu_qual: "This field is required",
	  exp: "This field is required",
	  cmpy_name: "This field is required",
	  /* cmpy_loc: "This field is required", */
	  cmpy_yrfound: {
        required: "This field is required"
      },
	  cmpy_type: "This field is required",
	  email: {
        required: "This field is required",       
        email: "Invalid Email Id"
      },
	  ctc_number: {
        required: "This field is required",
        minlength: "Length should be 10 characters minimum",
		maxlength: "Length should not exceed 15 characters maximum"
      },
	  location: "This field is required",
	  prjt_title: {
        required: "This field is required",
		maxlength: "Length should not exceed 25 characters maximum"
      },
	  category: "This field is required",
	  goal: "This field is required",
	  min_raise: "This field is required",
	 // max_raise: "This field is required",
	  repay_period: "This field is required",
	  repay_duration: "This field is required",
	  returns: "This field is required",
	  deadline: "This field is required",
	  hold_period: "This field is required",
	  hold_duration: "This field is required"
    },
    submitHandler: function(form) {
      form.submit();
    }
});

$("form[name='invest_frm1']").validate({
    rules: {    
      invest_amt: "required",
	  fname: "required",
	  lname: "required",
      ctc_num: {
        required: true,
        minlength: 10,
		maxlength: 15
      },
	  zipcode: {
        required: true,
        minlength: 5,
		maxlength: 6
      }
    },
    messages: {
      invest_amt: "This field is required",
	  fname: "This field is required",
	  lname: "This field is required",
      ctc_num: {
        required: "This field is required",
        minlength: "Length should be 10 characters minimum",
		maxlength: "Length should not exceed 15 characters maximum"
      },
      zipcode: {
        required: "This field is required",
        minlength: "Length should be 5 characters minimum",
		maxlength: "Length should not exceed 6 characters maximum"
      }
    },
    submitHandler: function(form) {
      form.submit();
    }
});

$("form[name='ctcfrm']").validate({
    rules: {    
      name: "required",
      email: {
        required: true,       
        email: true
      },
	  ctc_num: {
        required: true,
        minlength: 10,
		maxlength: 15
      }
    },
    messages: {
      name: "This field is required",
      email: {
        required: "This field is required",       
        email: "Invalid Email Id"
      },
	  ctc_num: {
        required: "This field is required",
        minlength: "Length should be 10 characters minimum",
		maxlength: "Length should not exceed 15 characters maximum"
      }
    },
    submitHandler: function(form) {
      form.submit();
    }
});

$("form[name='usrfrm_adm']").validate({
    rules: {    
      firstname: "required",
	  lastname: "required",
      ctry_name: "required",
	  ctc_number: {
        required: true,
        minlength: 10,
		maxlength: 15
      },
      zip_code: {
        required: true,
        minlength: 5,
		maxlength: 6
      },
	  /* acc_name: "required",
	  acc_num: "required",
      bank_name: "required",
	  branch_name: "required", */
	  ifsc: {
        //required: true,
        minlength: 16,
		maxlength: 16
      }
    },
    messages: {
      firstname: "This field is required",
	  lastname: "This field is required",
	  ctry_name: "This field is required",
	  ctc_number: {
        required: "This field is required",
        minlength: "Length should be 10 characters minimum",
		maxlength: "Length should not exceed 15 characters maximum"
      },
      zip_code: {
        required: "This field is required",
        minlength: "Length should be 5 characters minimum",
		maxlength: "Length should not exceed 6 characters maximum"
      },
	  /* acc_name: "This field is required",
	  acc_num: "This field is required",
      bank_name: "This field is required",
	  branch_name: "This field is required", */
	  ifsc: {
        //required: "This field is required",
        minlength: "Length should be 16 characters minimum",
		maxlength: "Length should not exceed 16 characters maximum"
      }
    },
    submitHandler: function(form) {
      form.submit();
    }
});

$("form[name='catfrm']").validate({
    rules: {
      cat_name: {
        required: true,
		maxlength: 25
      }
    },
    messages: {
      cat_name: {
        required: "This field is required",
		maxlength: "Length should not exceed 25 characters maximum"
      }
    },
    submitHandler: function(form) {
      form.submit();
    }
});

$("form[name='adn_passchng']").validate({
    rules: {    
      adm_curPass: "required",
      adm_newPass: {
        required: true,
        minlength: 6,
		maxlength: 15
      },
	  adm_cnfrmPass: {
        required: true,
		equalTo: "#adn_passId"
      }
    },
    messages: {
      adm_curPass: "This field is required",
      adm_newPass: {
        required: "This field is required",
        minlength: "Length should be 6 characters minimum",
		maxlength: "Length should not exceed 15 characters maximum"
      },
	  adm_cnfrmPass: {
        required: "This field is required",
		equalTo: "Password doesn't match"
      }
    },
    submitHandler: function(form) {
      form.submit();
    }
});

$("form[name='ad_prjtpost']").validate({
    rules: {
	  user_type: "required",
	  edu_qual: "required",
	  exp: "required",
	  cmpy_name: "required",
	 /*  cmpy_loc: "required", */
	  cmpy_yrfound: {
        required: true
      },
	  cmpy_type: "required",
	  email: {
        required: true,       
        email: true
      },
	  ctc_number: {
        required: true,
        minlength: 10,
		maxlength: 15
      },
	  location: "required",
	  prjt_title: {
        required: true,
		maxlength: 25
      },
	  category: "required",
	  goal: "required",
	  min_raise: "required",
	 // max_raise: "required",
	  repay_period: "required",
	  repay_duration: "required",
	  returns: "required",
	  deadline: "required",
	  hold_period: "required",
	  hold_duration: "required"
    },
    messages: {
      user_type: "This field is required",
	  edu_qual: "This field is required",
	  exp: "This field is required",
	  cmpy_name: "This field is required",
	  /* cmpy_loc: "This field is required", */
	  cmpy_yrfound: {
        required: "This field is required"
      },
	  cmpy_type: "This field is required",
	  email: {
        required: "This field is required",       
        email: "Invalid Email Id"
      },
	  ctc_number: {
        required: "This field is required",
        minlength: "Length should be 10 characters minimum",
		maxlength: "Length should not exceed 15 characters maximum"
      },
	  location: "This field is required",
	  prjt_title: {
        required: "This field is required",
		maxlength: "Length should not exceed 25 characters maximum"
      },
	  category: "This field is required",
	  goal: "This field is required",
	  min_raise: "This field is required",
	  //max_raise: "This field is required",
	  repay_period: "This field is required",
	  repay_duration: "This field is required",
	  returns: "This field is required",
	  deadline: "This field is required",
	  hold_period: "This field is required",
	  hold_duration: "This field is required"
    },
    submitHandler: function(form) {
      form.submit();
    }
});

$("form[name='ad_bnkfrm']").validate({
    rules: {    
      bank_name1: "required",     
	  branch_name1: "required",
	  acct_name1: "required",
	  account_num1: "required",
	  ifsc1: {
        required: true,
        minlength: 16,
		maxlength: 16
      }
    },
    messages: {
      bank_name1: "This field is required",
	  branch_name1: "This field is required",
	  acct_name1: "This field is required",
	  account_num1: "This field is required",
	  ifsc1: {
        required: "This field is required",
        minlength: "Length should be 16 characters minimum",
		maxlength: "Length should not exceed 16 characters maximum"
      }
    },
    submitHandler: function(form) {
      form.submit();
    }
});

$("form[name='slider_frm']").validate({
    rules: {    
      title_name: {
        required: true,
		maxlength: 50
      },
	  descript: "required",
	  btn_name: {
        required: true,
		maxlength: 30
      }
    },
    messages: {
      title_name: {
        required: "This field is required",
		maxlength: "Length should not exceed 50 characters maximum"
      },
	  descript: "This field is required",
	  btn_name: {
        required: "This field is required",
		maxlength: "Length should not exceed 30 characters maximum"
      }
    },
    submitHandler: function(form) {
      form.submit();
    }
});

$("form[name='pgsetfrm']").validate({
    rules: {    
      foot_text1: "required",     
	  foot_text2: "required",
	  foot_text3: "required",
	  campaign_text1_head: "required",
	  campaign_text1: "required",
	  campaign_text2_head: "required",
	  campaign_text2: "required",
	  campaign_text3_head: "required",
	  campaign_text3: "required"
    },
    messages: {
      foot_text1: "This field is required",     
	  foot_text2: "This field is required",
	  foot_text3: "This field is required",
	  campaign_text1_head: "This field is required",
	  campaign_text1: "This field is required",
	  campaign_text2_head: "This field is required",
	  campaign_text2: "This field is required",
	  campaign_text3_head: "This field is required",
	  campaign_text3: "This field is required"
    },
    submitHandler: function(form) {
      form.submit();
    }
});

$('.frln').click(function(){
	$('#frlncerId').removeClass('hidden');			
	$('#cmpyId').addClass('hidden');
	$('#cmpy_name').val("");
	//$('#cmpy_loc').val("");
	$('#cmpy_yrfound').val("");
	$('#cmpy_type').val("");
	$('#cmpy_url').val("");
});
$('.cmpy').click(function(){
	$('#cmpyId').removeClass('hidden');			
	$('#frlncerId').addClass('hidden');
	$('#qualId').val("");
	$('#expId').val("");
});

$('[data-countdown]').each(function() {
  var $this = $(this), finalDate = $(this).data('countdown');
  $this.countdown(finalDate, function(event) {
    $this.html(event.strftime('%D d : %H h: %M m: %S s'));
  });
});

$('#pay_type2').click(function(){
	$('#bnkdetId').removeClass('hidden'); 
});

$('#pay_type1').click(function(){
	$('#bnkdetId').addClass('hidden'); 
});

/* add multiple select / deselect functionality */
$("#selectall").click(function () {
	  $('.case').prop('checked', this.checked);
});

/* if all checkbox are selected, check the selectall checkbox and viceversa */
$(".case").click(function(){
	if($(".case").length == $(".case:checked").length) {
		$("#selectall").attr("checked", "checked");
	} else {
		$("#selectall").removeAttr("checked");
	}
});

});

/* demo user alert */
function demo_user() {
	return swal("Oops!","Access denied to Demo User","error");
}
/* confirm alert */
function confirmAct() {
	return confirm("Sure to proceed?");
}
/* own project alert */
function ownprjt() {
	return alert("This is your Project!!");
}
/* one more time invest alert */
function again_invest() {
	return alert("You have already invested!!");
}
/* restrict delete option alert */
function del_cancl() {
	return swal("Oops!","Can't delete! User has invested.","warning");
}
/* restrict delete option because user posted projected get invested alert */
function del_cancl_prjtinv() {
	return swal("Oops!","Can't delete! User project has in investment process.","warning");
}
/* user side add campaign validation */
function usr_prjt_sub() {
	var hglghtId = tinyMCE.get('hglghtId').getContent();
	var descriptId = tinyMCE.get('descriptId').getContent();
	var invtermId = tinyMCE.get('investTerm').getContent();
	var prjtsumId = tinyMCE.get('prjtSum').getContent();
	var goalAmt = $("#goalId").val();
	var minInvest = $("#min_investment").val();
	goalAmt = parseInt(goalAmt);
	minInvest = parseInt(minInvest);
	
	if(hglghtId == '') {
		document.getElementById("hglghtErr").innerHTML = 'This field is required';
		return false;
	}
	else if(hglghtId.length < 20){
		document.getElementById("hglghtErr").innerHTML = 'Minimum 20 Characters requied!';
		return false;
	}
	else {
		document.getElementById("hglghtErr").innerHTML = '';
	}
	if(descriptId == '') {
		document.getElementById("desErr").innerHTML = 'This field is required';
		return false;
	}
	else if(descriptId.length < 20){
		document.getElementById("desErr").innerHTML = 'Minimum 20 Characters requied!';
		return false;
	}
	else {
		document.getElementById("desErr").innerHTML = '';
	}
	if(invtermId == '') {
		document.getElementById("invErr").innerHTML = 'This field is required';
		return false;
	}
	else if(invtermId.length < 20){
		document.getElementById("invErr").innerHTML = 'Minimum 20 Characters requied!';
		return false;
	}
	else {
		document.getElementById("invErr").innerHTML = '';
	}
	if(prjtsumId == '') {
		document.getElementById("prjtErr").innerHTML = 'This field is required';
		return false;
	}
	else if(prjtsumId.length < 20){
		document.getElementById("prjtErr").innerHTML = 'Minimum 20 Characters requied!';
		return false;
	}
	else {
		document.getElementById("prjtErr").innerHTML = '';
	}
	if(minInvest > goalAmt) {
		document.getElementById("minInvest").innerHTML = 'Minimum Investment should be less than the Goal amount';
		return false;
	}else {
		document.getElementById("minInvest").innerHTML = '';
	}	
}
/* admin side add campaign validation */
function prjtvalid() {
	var hglghtId = tinyMCE.get('hglghtId').getContent();
	var descriptId = tinyMCE.get('descriptId').getContent();
	var invtermId = tinyMCE.get('investTerm').getContent();
	var prjtsumId = tinyMCE.get('prjtSum').getContent();
	var goalAmt = $("#goalId").val();
	var minInvest = $("#min_investment").val();
	goalAmt = parseInt(goalAmt);
	minInvest = parseInt(minInvest);
	
	if(hglghtId == '') {
		document.getElementById("hglghtErr").innerHTML = 'This field is required';
		return false;
	}
	else if(hglghtId.length < 20){
		document.getElementById("hglghtErr").innerHTML = 'Minimum 20 Characters requied!';
		return false;
	}
	else {
		document.getElementById("hglghtErr").innerHTML = '';
	}
	if(descriptId == '') {
		document.getElementById("desErr").innerHTML = 'This field is required';
		return false;
	}
	else if(descriptId.length < 20){
		document.getElementById("desErr").innerHTML = 'Minimum 20 Characters requied!';
		return false;
	}
	else {
		document.getElementById("desErr").innerHTML = '';
	}
	if(invtermId == '') {
		document.getElementById("invErr").innerHTML = 'This field is required';
		return false;
	}
	else if(invtermId.length < 20){
		document.getElementById("invErr").innerHTML = 'Minimum 20 Characters requied!';
		return false;
	}
	else {
		document.getElementById("invErr").innerHTML = '';
	}
	if(prjtsumId == '') {
		document.getElementById("prjtErr").innerHTML = 'This field is required';
		return false;
	}
	else if(prjtsumId.length < 20){
		document.getElementById("prjtErr").innerHTML = 'Minimum 20 Characters requied!';
		return false;
	}
	else {
		document.getElementById("prjtErr").innerHTML = '';
	}
	if(minInvest > goalAmt) {
		document.getElementById("minInvest").innerHTML = 'Minimum Investment should be less than the Goal amount';
		return false;
	}else {
		document.getElementById("minInvest").innerHTML = '';
	}	
}
/* enquiry validation */
function enqval() {
	var msgId = tinyMCE.get('inputEmail3').getContent();
	if(msgId == '') {
		document.getElementById("msgErr").innerHTML = 'This field is required';
		return false;
	}
	else {
		document.getElementById("msgErr").innerHTML = '';
	}
}
/* contact us form validation */
function ctcfrm_valid() {
	var cmtId = tinyMCE.get('commentId').getContent();
	if(cmtId == '') {
		document.getElementById("cmtErr").innerHTML = 'This field is required';
		return false;
	}
	else {
		document.getElementById("cmtErr").innerHTML = '';
	}
}
/* reply mail validation */
function reply_valid() {
	var subId = document.getElementById("subvalId").value;
	var cntId = tinyMCE.get('msg').getContent();
	if(subId == '') {
		document.getElementById("subErr").innerHTML = 'This field is required';
		return false;
	}
	else {
		document.getElementById("subErr").innerHTML = '';
	}
	if(cntId == '') {
		document.getElementById("cntErr").innerHTML = 'This field is required';
		return false;
	}
	else {
		document.getElementById("cntErr").innerHTML = '';
	}
}
/* testimonial validation */
function tetvalid() {
	var cmntId = tinyMCE.get('tetcmntId').getContent();
	if(cmntId == '') {
		document.getElementById("tetcmntErr").innerHTML = 'This field is required';
		return false;
	}
	else {
		document.getElementById("tetcmntErr").innerHTML = '';
	}
}
/* FAQ validation */
function faq_valid() {
	var quseId = document.getElementById("quseId").value;
	var ansId = tinyMCE.get('ansId').getContent();
	if(quseId == '') {
		document.getElementById("quesErr").innerHTML = 'This field is required';
		return false;
	}
	else {
		document.getElementById("quesErr").innerHTML = '';
	}
	if(ansId == '') {
		document.getElementById("ansErr").innerHTML = 'This field is required';
		return false;
	}
	else {
		document.getElementById("ansErr").innerHTML = '';
	}
}
/* cms page validation */
function cmsvalid() {
	var aboutusId = tinyMCE.get('aboutusId').getContent();
	var visionId = tinyMCE.get('visionId').getContent();
	var missionId = tinyMCE.get('missionId').getContent();
	var termId = tinyMCE.get('termId').getContent();
	var policyId = tinyMCE.get('policyId').getContent();
	if(aboutusId == '') {
		document.getElementById("abtErr").innerHTML = 'This field is required';
		return false;
	}
	else {
		document.getElementById("abtErr").innerHTML = '';
	}
	if(visionId == '') {
		document.getElementById("vsnErr").innerHTML = 'This field is required';
		return false;
	}
	else {
		document.getElementById("vsnErr").innerHTML = '';
	}
	if(missionId == '') {
		document.getElementById("msnErr").innerHTML = 'This field is required';
		return false;
	}
	else {
		document.getElementById("msnErr").innerHTML = '';
	}
	if(termId == '') {
		document.getElementById("trmErr").innerHTML = 'This field is required';
		return false;
	}
	else {
		document.getElementById("trmErr").innerHTML = '';
	}
	if(policyId == '') {
		document.getElementById("plcyErr").innerHTML = 'This field is required';
		return false;
	}
	else {
		document.getElementById("plcyErr").innerHTML = '';
	}
}
/* Page setting form validation */
function pgsetvalid() {
	var midcnt1Id = tinyMCE.get('midcnt1Id').getContent();
	var midcnt2Id = tinyMCE.get('midcnt2Id').getContent();
	var midtxtId = tinyMCE.get('midtxtId').getContent();
	
	if(midcnt1Id == '') {
		document.getElementById("midcnt1Err").innerHTML = 'This field is required';
		return false;
	}
	else {
		document.getElementById("midcnt1Err").innerHTML = '';
	}
	if(midcnt2Id == '') {
		document.getElementById("midcnt2Err").innerHTML = 'This field is required';
		return false;
	}
	else {
		document.getElementById("midcnt2Err").innerHTML = '';
	}
	if(midtxtId == '') {
		document.getElementById("midtxtErr").innerHTML = 'This field is required';
		return false;
	}
	else {
		document.getElementById("midtxtErr").innerHTML = '';
	}
}