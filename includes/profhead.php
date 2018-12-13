<?
if(empty($userlog)) {
	$extra->redirect_to($baseUrl.'login/');
}
else {
	$db->query("select a.*,b.country_name,c.state_name,d.city_name from register as a left join country as b on a.country=b.country_id left join state as c on a.state=c.state_id left join city as d on a.city=d.city_id where a.id=:lgnid");
	$db->bind(":lgnid", $userlog);
	$result=$db->fetch();
	if(!empty($result)) extract($result);
	else $extra->redirect_to($baseUrl);
}

$firstname = isset($firstname)?$firstname:'';
$lastname = isset($lastname)?$lastname:'';
$country = isset($country)?$country:'';
$state = isset($state)?$state:'';
$city = isset($city)?$city:'';
$zipcode = isset($zipcode)?$zipcode:'';
$zipcode = ($zipcode != 0)?$zipcode:'';
$phone_code = isset($phone_code)?$phone_code:'';
$phone_code = ($phone_code != 0)?'+'.$phone_code:'';
$phone = isset($phone)?$phone:'';
$website = isset($website)?$website:'';
$acc_name = isset($acc_name)?$acc_name:'';
$acc_num = isset($acc_num)?$acc_num:'';
$bank_name = isset($bank_name)?$bank_name:'';
$branch_name = isset($branch_name)?$branch_name:'';
$ifsc = isset($ifsc)?$ifsc:'';
$fb_url = isset($fb_url)?$fb_url:'';
$twitter_url = isset($twitter_url)?$twitter_url:'';
$lnkdin_url = isset($lnkdin_url)?$lnkdin_url:'';
$profile_image = isset($profile_image)?$profile_image:'emptyimg.png';

$fname = $firstname;
$lname = $lastname;
$usrname = ucwords($fname.' '.$lname);
$join_dt = date("d-M-Y", strtotime($crcdt));
$last_login = date("d-M-Y H:i:s", strtotime($last_login_date));

$db->query("select sum(contribute_amount) as tot_invst from contribute where user_id='$userlog' and pay_status='1'");
$my_invest = $db->fetch();

$db->query("select id from project where userid='$userlog'");
$prjtids = $db->fetchAll();
$recv_invest = '';
$tot_investor = 0;
foreach($prjtids as $prjtid):
	$prjtid = $prjtid["id"];
	$db->query("select sum(contribute_amount) as recv_inv from contribute where prjt_id='$prjtid' and pay_status='1'");
	$amt = $db->fetch();
	$recv_invest += $amt['recv_inv'];
	$db->query("select * from contribute where prjt_id='$prjtid' and pay_status='1' group by user_id");
	$investor_ct = $db->rowCount();
	$tot_investor += $investor_ct;
endforeach;

if(isset($rmv)) {
	$general->delProject($rmv);
	$db->query("delete from project where id=:id");
	$db->bind(":id", $rmv);
	$db->execute();
	$extra->swalMsg("success!","Project deleted successfully!","success",$baseUrl."user-listing/");
}
?>
<section class="section careing-section profile_bg">
         <div class="container">
            <div class="row">
               <div class="col-sm-5">
                  <div class="row">
                     <div class="col-sm-5">
                        <div class="profile_pic text-center"> 
                           <img src="<?=$extra->chkImg($profile_image, "uploads/user-profile/"); ?>" class="img-circle">
                        </div>
                     </div>
                     <div class="col-sm-7">
                        <h4 class="mt10 clr_txt"><?=$usrname;?></h4>
                        <ul class="usr_hd_list">
                           <li><b>Join Date : </b> <?=$join_dt;?></li>
                           <li><b>Last Login : </b> <?=$last_login;?></li>
                           <li class="mt10i">
                              <a href="<?=$baseUrl;?>user-profile/"><i class="fas fa-eye"></i> View Profile</a>
                              &nbsp; |
                              &nbsp;
                              <a href="<?=$baseUrl;?>user-profile-edit/"><i class="far fa-edit"></i> Edit Profile</a>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
               <div class="col-sm-7">
                  <div class="row">
                     <div class="col-sm-4 col-xs-6">
                        <div class="col-sm-12 das_box">
                           <h3><?=$general->usr_totprjt($userlog);?></h3>
                           <h4>Projects Posted</h4>
                        </div>
                     </div>
                     <div class="col-sm-4 col-xs-6">
                        <div class="col-sm-12 das_box">
                           <h3><?=$general->my_invest($userlog);?></h3>
                           <h4>Projects Funded</h4>
                        </div>
                     </div>
                     <div class="col-sm-4 col-xs-6">
                        <div class="col-sm-12 das_box">
                           <h3><?=$general->usr_flwprjt($userlog);?></h3>
                           <h4>Following Projects</h4>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <div class="clearfix"></div>
      <div class="mainmenu-area profile_menu">
         <div class="container">
            <div class="row">
               <div class="nav-menu">
                  <nav class="navbar navbar-default">
                     <!-- Brand and toggle get grouped for better mobile display -->
                     <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar-one bar-stick"></span>
                        <span class="icon-bar-two bar-stick"></span>
                        <span class="icon-bar-three bar-stick"></span>
                        </button>
                     </div>
                     <!-- Collect the nav links, forms, and other content for toggling -->
                     <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
                        <ul class="nav navbar-nav">
                           <li id="dashboard"><a href="<?=$baseUrl;?>user-dashboard/">Dashboard</a></li>
						   <li id="profile"><a href="<?=$baseUrl;?>user-profile/">Profile</a></li>
                           <li id="listing"><a href="<?=$baseUrl;?>user-listing/">Projects Posted</a></li>
                           <li id="invest"><a href="<?=$baseUrl;?>user-invest/">My Investment</a></li>
                           <li id="following"><a href="<?=$baseUrl;?>user-following/">Following Projects</a></li>
                           
                           <li id="transaction"><a href="<?=$baseUrl;?>user-trans/">My Transactions</a></li>
						   <li id="transaction"><a href="<?=$baseUrl;?>project-post/">Post Project</a></li>
						   <li id="setting"><a href="<?=$baseUrl;?>change-pass/">Setting</a></li>
						 
						   <li id="trans"><a href="<?=$baseUrl;?>trans/">User Transactions</a></li>
                        </ul>
                     </div>
                     <!-- /.navbar-collapse -->
                  </nav>
               </div>
            </div>
         </div>
      </div>
      <div class="clearfix"></div>