<? include "includes/header.php";

if(empty($userlog)) {
	$extra->redirect_to($baseUrl.'login/');
}
if(isset($invest1_sub) && !empty($invest_amt)) {
	$_SESSION['invest'] = $invest_amt;
	
	$set="firstname=:firstname";
	$set.=",lastname=:lastname";
	$set.=",phone=:phone";
	$set.=",zipcode=:zipcode";
	$set.=",chngdt='$timestamp'";
	$set.=",recent_ipaddr='$ip_addr'";
	$que="update register set $set where id='$userlog'";
	$db->query($que);
	$db->bind(":firstname", $fname);
	$db->bind(":lastname", $lname);
	$db->bind(":phone", $ctc_num);
	$db->bind(":zipcode", $zipcode);
	$db->execute();	
}
if(empty($_SESSION['invest'])) {
	echo "<script>history.go(-1);</script>";
	exit;
}
if(isset($invest2_sub) && !empty($pay_type)) {
	$invest_amt = $_SESSION['invest'];
	$prjt_id = base64_decode($invid);
	$set="prjt_id=:prjt_id";
	$set.=",user_id=:user_id";
	$set.=",contribute_amount=:contribute_amount";
	$set.=",pay_type=:pay_type";
	$set.=",date='$timestamp'";
	$set.=",ip='$ip_addr'";
	$que = "insert into contribute set $set";
	$db->query($que);
	$db->bind(":prjt_id", $prjt_id);
	$db->bind(":user_id", $userlog);
	$db->bind(":contribute_amount", $invest_amt);
	$db->bind(":pay_type", $pay_type);
	//$db->execute();
	$insrt_id = $db->lastInsertId();			
	$unique = str_pad($insrt_id, 5, '0', STR_PAD_LEFT);
	$investid = "INV".date("Y").$unique;
	
	$set1="invest_id='$investid'";
	$que1 = "update contribute set $set1 where id='$insrt_id'";
	$db->query($que1);
	$db->execute();
	
	unset($_SESSION["invest"]);
	
	$db->query("select * from ad_bank_details where id='1'");
	$result = $db->fetch();
	if(!empty($result)) extract($result);
	
	$to_email = $db->extractCol("select email from register where id='$userlog'");
	$prjt_title = ucwords(stripslashes($db->extractCol("select title from project where id='$prjt_id'")));
	$topcontent = "<br /><center><div style='background-color:#f1f1f1;width:500px;padding:10px;'> <span style='color:#d779bf;'>Your have invested successfully.";
	$topcontent .="<br><br /> <span style='color:#7a79d7;'>Here is the Your Investment Details,</span>";
	$topcontent .="<table class='mail-tabl'>
	<tr><td> Investment ID  </td><td>:</td><td> $investid</td></tr>
	<tr><td> Project  </td><td>:</td><td> $prjt_title</td></tr>
	<tr><td> Investment Amount  </td><td>:</td><td> $site_currency $invest_amt</td></tr>
	</table></div>";
	if($pay_type==2) {
		$payup = base64_encode($baseUrl.'user-invest/');
		$topcontent .="<div style='background-color:#f1f1f1;width:500px;padding:10px;'><center><br><br><span style='color:#7a79d7;'>Here is the Your Payment Details,";
		$topcontent .="<br>You can Pay through Bank with below Details,</span>";
		$topcontent .="<table><tr><td> Bank Name  </td><td>:</td><td> $bank_name</td></tr>
		<tr><td> Branch Name  </td><td>:</td><td> $branch_name</td></tr>
		<tr><td> Account Holder Name  </td><td>:</td><td> $acct_name</td></tr>
		<tr><td> Account No.  </td><td>:</td><td> $account_num</td></tr>
		<tr><td> IFSC Code  </td><td>:</td><td> $ifsc</td></tr>
		</table></center>";
		$topcontent .="<br>After the payment, <a href='$baseUrl/login/payup/$payup/'>Click Here</a> to login & upload your payslip to confirm your payment.</div>";
	}
	
	$cur_url = $baseUrl;
	$site_logo_lnk = "$baseUrl/uploads/settings/$site_logo";
	$specific_title = 'Login to check your investment status';
	$btn_name = 'Click Here';
	$msg = $extra->customtemplate($baseUrl,$site_logo_lnk,$topcontent,$site_title,$cur_url,$specific_title,$btn_name);
	$subject = 'Project Investment report from '.$site_title;
	$result = $common->email($admin_email,$to_email,$subject,$msg);
	if($pay_type == 1) {
		$_SESSION['invid'] = $investid;
		$extra->redirect_to($baseUrl."paypal/");
	}
	if($pay_type == 2) {
		$extra->swalMsg("success!","Your investment success. Kindly check your email","success",$baseUrl."user-invest/");
	}
}

$db->query("select * from ad_bank_details where id='1'");
$result=$db->fetch();
if(!empty($result)) extract($result);
?>
   <div class="main-page-wrapper">
         <section class="Join-Volunteer-Pages" style="padding-bottom: 30px;">
            <div class="container">
               <div class="Theme-title text-center">
                  <h2>Become Investor</h2>
               </div>
               <div class="row new_row1">
                  <div class="col-sm-8">
                     <form name="invest_frm2" method="post" action="<?=$baseUrl;?>payment/">
					 <input type="hidden" id="invId" name="invid" value="<?=$invid;?>" />
                        <div class="row">
						   <div class="col-md-12 col-sm-12 col-xs-12">
                              <div class="">
                               <input type="radio" name="pay_type" id="pay_type1" value="1" />Paypal<img src="<?=$baseUrl;?>images/paypal-logo.png" />
								<br /><input type="radio" name="pay_type" id="pay_type2" value="2" onclick="checkmem(this.value);" />Offline Pay
                              </div>
							  <span id="pay_err" style="color:#d51510;"> </span>
                           </div>
                           <div id="bnkdetId" class="col-md-6 col-sm-6 col-xs-12 hidden">
                              <div class="table-responsive" style="background: #F3F3F3;">
								<table class="table">
								  <tr>
									<td> Name of the Account holder</td>
									<td><? echo $acct_name; ?></td>
								  </tr>
								   <tr>
									<td> Name of the Bank</td>
									<td> <? echo $bank_name; ?></td>
								  </tr>
								   <tr>
									<td> Name of the Branch Code</td>
									<td><? echo $branch_name; ?></td>
								  </tr>
								   <tr>
									<td> Account Number</td>
									<td> <? echo $account_num; ?></td>
								  </tr>
								   <tr>
									<td>IFSC</td>
									<td> <? echo $ifsc; ?></td>
								  </tr>
								</table>
							  </div>
                           </div>              
                        </div>
                        <button onClick="return invest_step2()" class="hvr-float-shadow" style="submit" name="invest2_sub">Next Step</button>
                     </form>
                     <!-- /Form -->
                  </div>
                  <div class="col-sm-4">
                     <div class="col-md-12 col-xs-12">
                        <div class="Causes-Item Causes-Item-margin">
                           <div class="Causes-Img"><img src="<?=$baseUrl;?>/images/donate.jpg" alt="image"></div>
                           <!-- /.Causes-Img -->
                           <div class="Causes-Text text-center">
                              <h5 class="donttxt">Rohinga people Need help</h5>
                              <p class="dontpxt">Child sponsorship is a unique relationship, that brings real hope and a life-affirming experience.</p>
                           </div>
                           <!-- /.Causes-Text -->
                        </div>
                        <!-- /.Causes-Item -->
                     </div>
                     <!-- /.col -->
                  </div>
               </div>
            </div>
            <!-- /.container -->
         </section>        
      </div>
<script>
function invest_step2() {
	var payType = document.invest_frm2.pay_type.value;
	if(payType == '') {
	   $("#pay_err").html("This field is required");
	   return false;
	}
	else {
		$("#pay_err").html("");
		return true;
	}
}
</script>
<? include "includes/footer.php"; ?>