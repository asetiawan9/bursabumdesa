<? include "includes/header.php";

if(empty($userlog)) {
	$extra->redirect_to($baseUrl.'login/');
}
else {
	$db->query("select firstname,lastname,email,country,phone,zipcode from register where id=:lgnid");
	$db->bind(":lgnid", $userlog);
	$result = $db->fetch();
	if(empty($result)) $extra->redirect_to($baseUrl);
}
$country_id = $result["country"];
$country = $db->extractCol("select country_name from country where country_id='$country_id'");
$dec_invid = base64_decode($invid);
$prjt_sts = $db->extractCol("select active_status from project where id='$dec_invid'");
if($prjt_sts != 1) {
	$extra->swalMsg("Oops!","This Project is currently unavailable","warning",$baseUrl."list/");
}
$min_invest = $db->extractCol("select min_raise from project where id='$dec_invid'");
?>
      <div class="main-page-wrapper">
         <section class="Join-Volunteer-Pages" style="padding-bottom: 30px;">
            <div class="container">
               <div class="Theme-title text-center">
                  <h2>Become Investor</h2>
               </div>
               <div class="row new_row1">
                  <div class="col-sm-8">
                     <form name="invest_frm1" method="post" action="<?=$baseUrl;?>payment/">
					 <input type="hidden" id="invId" name="invid" value="<?=$invid;?>" />
					 <input type="hidden" id="min_raiseid" name="min_raise" value="<?=$min_invest;?>" />
                        <div class="row">
						   <div class="col-md-12 col-sm-12 col-xs-12">
                              <div class="single-input">
                                 <input type="text" name="invest_amt" id="invamt_id" onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57" placeholder="Enter the Amount To Invest*" required style="margin-bottom: 14px;" />
								
                              </div>
							   <span id="invest_err" style="color:#d51510;"> </span><br>
							  <b>Minimum investment amount is <?=$site_currency.' '.$min_invest;?> </b>
                           </div>
                           <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="single-input">
                                 <input type="text" name="fname" value="<?=$result['firstname'];?>" placeholder="You firstname *" required />
                              </div>
							 
                           </div>
						   <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="single-input">
                                 <input type="text" name="lname" value="<?=$result['lastname'];?>" placeholder="You lastname *" required />
                              </div>
                           </div>
                           <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="single-input">
                                 <input type="email" name="email" value="<?=$result['email'];?>" placeholder="Email *" readonly />
                              </div>
                           </div>
						    <div class="col-md-6 col-xs-12">
                              <div class="single-input">
                                 <input type="text" name="country" value="<?=$country;?>" placeholder="Country *" readonly />
                              </div>
                           </div>
                           <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="single-input">
                                 <input type="text" name="ctc_num" maxlength="15" minlength="10" onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57" value="<?=$result['phone'];?>" placeholder="Phone *" required />
                              </div>
                           </div>
                           <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="single-input">
                                 <input type="text" name="zipcode" maxlength="6" minlength="5" onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57" value="<?=$result['zipcode'];?>"  placeholder="Zipcode" required />
                              </div>
                           </div>
                           <!--<div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="single-input">
                                 <input type="text" placeholder="Address" >
                              </div>
                           </div>-->                          
                        </div>
                        <button onClick="return invest_step1()" class="hvr-float-shadow" style="submit" name="invest1_sub">Next Step</button>
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
function invest_step1() {
	var invamtId = $("#invamt_id").val();
	var minraiseId = $("#min_raiseid").val();

	if(invamtId != '') {
		investAmt = parseInt(invamtId);
		minInvest = parseInt(minraiseId);
	}
   if(investAmt == '0') {
	   $("#invest_err").html("This field is required");
	   return false;
   }
   else if(investAmt < minInvest) {
	   $("#invest_err").html("Enter the amount above or equal to Minimum Investment");
	   return false;
   }
   else
	  $("#invest_err").html("");
}
</script>
<? include "includes/footer.php"; ?>