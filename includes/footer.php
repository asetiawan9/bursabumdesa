<!-- Footer section -->
		<footer class="footer-section">
			<div class="footer-top">
					<div class="container">
						<div class="row">
							<div class="row">
								<div class="col-lg-3 col-md-6 col-sm-6">
									<div class="f-widget">
										<div class="footer-logo">
										    <a href="<?=$baseUrl;?>/index/"><img src="<?php echo $baseUrl."/uploads/settings/".$site_logo; ?>" alt="Image Name"></a>
										</div>
										<div class="footer-content">
											<p><?=stripslashes($site_description);?> </p>
										</div>
									</div>
								</div>
								<div class="col-lg-3 col-md-6 col-sm-6">
									<div class="f-widget">
									   <h2>Recent Investors</h2>
									   <ul class="latest-news">
					<?
						$db->query("select r.firstname,r.profile_image,c.user_id from contribute c inner join register r on c.user_id=r.id group by c.user_id order by c.id desc limit 3");
						$get_user = $db->fetchAll();
						foreach($get_user as $getuser):
						?>		   
										  <li>
											 <span class="small-thumbnail">
											 <img src="<?=$extra->chkImg($getuser["profile_image"], "uploads/user-profile/"); ?>" class="img-circle" alt="Equity Recent Investors" />
											 </span>
											 <div class="content">
												<p class="latest-news-title"><?=ucwords($extra->checkLength($getuser["firstname"],20));?></p>
											 </div>
										  </li>
						<? endforeach; ?>            
									   </ul>
									</div>
								</div>
								
								<div class="col-lg-3 col-md-6 col-sm-6">
									<div class="f-widget">
										<h2>Recent Project</h2>
										<ul class="recent-project">
				<?
					$sq = "select id,title from project where active_status='1' and start_dt<='$tday' order by id desc limit 6";
					$db->query($sq);
					$result = $db->fetchAll();
					foreach($result as $row):
					$title = ucwords(stripslashes($row["title"]));
					$enc_id = base64_encode($row["id"]);
					$reurl_title = $extra->reurl($title);
					?>							
											<li>
												<div class="content">
													<a target="_blank" href="<?=$baseUrl;?>detail/<?=$reurl_title;?>/<?=$enc_id;?>/" class="latest-news-title"><?=$extra->checkLength($title,30);?></a>
												</div>
											</li>
					<? endforeach; ?>						  
										</ul>
									</div>
								</div>
								<div class="col-lg-3 col-md-6 col-sm-6">
									<div class="f-widget">
										<h2>Reach Us</h2>
										<div class="contact-info">
											<ul>
												<li class="list-st"><i class="fa fa-home" aria-hidden="true" style="width: 42px;"></i><span> <?=stripslashes($admin_address);?></span></li>
												<li><i class="fa fa-phone"></i><span> <?=$site_number;?></span></li>
												<li><i class="far fa-envelope"></i><span> <?=$site_email;?></span></li>
											</ul>
											<div class="mt20">
											<ul class="soci">
											<? if(!empty($facebook)) { ?>
												<li><a href="<?=$facebook;?>" target="_blank"><i class="fa fa-facebook facebook"></i></a></li>
											<? } if(!empty($twitter)) { ?>
												<li><a href="<?=$twitter;?>" target="_blank"><i class="fab fa-twitter twitter"></i></a></li>
											<? } if(!empty($gplus)) { ?>
												<li><a href="<?=$gplus;?>" target="_blank"><i class="fab fa-google-plus-g googleplus"></i></a></li>
											<? } if(!empty($linkedin)) { ?>
												<li><a href="<?=$linkedin;?>" target="_blank"><i class="fab fa-linkedin-in linkedin"></i></a></li>
											<? } if(!empty($pinterest)) { ?>
												<li><a href="<?=$pinterest;?>" target="_blank"><i class="fa fa-pinterest pinterest"></i></a></li>
											<? } ?>
											</ul>
											</div>
										</div>
									</div>
								</div>						
							</div>
						</div>
					</div>
			</div>
			<div class="footer-bottom">
				<div class="container">
					<div class="row">
						<div class="col-sm-6">
							<p class="text-left">&copy; <? echo date("Y"); ?>. All Rights Reserved By <a href="<?=$baseUrl;?>/index/"><?php echo $site_title; ?></a></p>
						</div>
						<div class="col-sm-6">
							<p class="text-right"> 
								<a href="<?=$baseUrl;?>terms/" class="font13i">Terms & Condition</a>
								<a href="<?=$baseUrl;?>privacy/" class="font13i pdl15">Privacy Policy</a>
								<a href="<?=$baseUrl;?>faq/" class="font13i pdl15">FAQ's</a>
								<a href="<?=$baseUrl;?>contact/" class="font13i pdl15">Contact Us</a>
							</p>
						</div>
					</div>
				</div>
			</div>
		</footer>
        <!-- End Footer Section -->
        <script>window.jQuery || document.write('<script src="assets/js/vendor/jquery-1.12.0.min.js"><\/script>')</script>
        <!-- Bootstarp js -->
        <script src="<?=$baseUrl;?>assets/js/bootstrap.min.js"></script>
		<!-- data table -->
		<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
		<script>
		$(document).ready(function() {
			$('#example').DataTable();
		});

		$(function () {
		  $('[data-toggle="tooltip"]').tooltip()
		})
		</script>
		<!-- side bar -->
		<script src="<?=$baseUrl;?>assets/js/theia-sticky-sidebar.js"></script>
		<script>
		 jQuery('#sidebar1').theiaStickySidebar({
		   additionalMarginTop: 80
		 });
		  jQuery('#sidebar2').theiaStickySidebar({
		   additionalMarginTop: 80
		   
		 });
		  jQuery('#sidebar3').theiaStickySidebar({
		   additionalMarginTop: 80
		 });
		</script>
        <!-- Google Map -->
        <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAQlXnmyNPAeN3c3HNyWoUMqDk6bDF31Cg"></script>
        <script src="<?=$baseUrl;?>assets/js/gmap.script.js"></script>
        <!-- Progressbar Js -->
        <script src="<?=$baseUrl;?>assets/js/circle.progress.js"></script>
        <!-- Count Down -->
        <script src="<?=$baseUrl;?>assets/js/TimeCircles.js"></script>
        <!-- Custom ScrollBar  -->
        <script src="<?=$baseUrl;?>assets/js/enscroll-0.6.2.min.js"></script>
        <!-- LightCase  -->
        <script src="<?=$baseUrl;?>assets/js/lightcase.js"></script>
        <!-- Isotop -->
        <script src="<?=$baseUrl;?>assets/js/isotope.pkgd.min.js"></script>
        <!-- Masonry -->
        <script src="<?=$baseUrl;?>assets/js/masonry.js"></script>
        <!-- Swipper -->
        <script src="<?=$baseUrl;?>assets/js/swiper.min.js"></script>
        <!-- Flex Slider -->
        <script src="<?=$baseUrl;?>assets/js/jquery.flexslider.js"></script>
        <!-- NST slider -->
        <script src="<?=$baseUrl;?>assets/js/jquery.nstSlider.min.js"></script>
        <!-- Main Js -->
        <script src="<?=$baseUrl;?>assets/js/functions.js"></script>
		<!-- tiny text editor -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.7.6/tinymce.min.js" type="text/javascript"></script>
		<script>tinymce.init({ selector:'.tinymce' });</script>		
		<script>
         $(function() {
           // This will select everything with the class smoothScroll
           // This should prevent problems with carousel, scrollspy, etc...
           $('.smoothScroll').click(function() {
         	if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
         	  var target = $(this.hash);
         	  target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
         	  if (target.length) {
         		$('html,body').animate({
         		  scrollTop: target.offset().top
         		}, 1000); // The number here represents the speed of the scroll in milliseconds
         		return false;
         	  }
         	}
           });
         });        
         // Change the speed to whatever you want
         // Personally i think 1000 is too much
         // Try 800 or below, it seems not too much but it will make a difference        
      </script>
<script type="text/javascript">
$(document).ready(function(){
    get_active_class('home','<?=$livepage;?>');
	get_active_class('about','<?=$livepage;?>');
	get_active_class('browse','<?=$livepage;?>');
	get_active_class('st-post','<?=$livepage;?>');
	get_active_class('faq','<?=$livepage;?>');
	get_active_class('ctc','<?=$livepage;?>');
	
	get_active_class_profmenu('dashboard','<?=$livepage;?>');
	get_active_class_profmenu('profile','<?=$livepage;?>');
	get_active_class_profmenu('listing','<?=$livepage;?>');
	get_active_class_profmenu('invest','<?=$livepage;?>');
	get_active_class_profmenu('following','<?=$livepage;?>');
	get_active_class_profmenu('transaction','<?=$livepage;?>');
	get_active_class_profmenu('setting','<?=$livepage;?>');
	get_active_class_profmenu('trans','<?=$livepage;?>');
});

function get_active_class(getid,url) {
	if((getid=="home") && (url=="index.php")) {  
		var d = document.getElementById(getid);
		d.className += " active";
	}
	if((getid=="about") && (url=="about.php")) {  
		var d = document.getElementById(getid);
		d.className += " active";
	}
	if((getid=="browse") && (url=="list.php")) {  
		var d = document.getElementById(getid);
		d.className += " active";
	}
	if((getid=="st-post") && (url=="start-post.php")) {  
		var d = document.getElementById(getid);
		d.className += " active";
	}
	if((getid=="faq") && (url=="faq.php")) {  
	var d = document.getElementById(getid);
	d.className += " active";
	}
	if((getid=="ctc") && (url=="contact.php")) {  
		var d = document.getElementById(getid);
		d.className += " active";
	}
}

function get_active_class_profmenu(getid,url) {
	if((getid=="dashboard") && (url=="user-dashboard.php")) {  
		var d = document.getElementById(getid);
		d.className += " active";
	}
	if((getid=="profile") && ((url=="user-profile.php") || (url=="user-profile-edit.php"))) {  
		var d = document.getElementById(getid);
		d.className += " active";
	}
	if((getid=="listing") && (url=="user-listing.php")) {  
		var d = document.getElementById(getid);
		d.className += " active";
	}
	if((getid=="invest") && (url=="user-invest.php")) {  
		var d = document.getElementById(getid);
		d.className += " active";
	}
	if((getid=="following") && (url=="user-following.php")) {  
	var d = document.getElementById(getid);
	d.className += " active";
	}
	if((getid=="transaction") && (url=="user-trans.php")) {  
		var d = document.getElementById(getid);
		d.className += " active";
	}
	if((getid=="setting") && (url=="change-pass.php")) {  
		var d = document.getElementById(getid);
		d.className += " active";
	}
	if((getid=="trans") && (url=="trans.php")) {  
		var d = document.getElementById(getid);
		d.className += " active";
	}
}
</script>
<!--datepicker-->
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<script>
$(function() {  
	$( "#start_dt" ).datepicker({
		defaultDate: "+1w",  
		changeMonth: true,   
		numberOfMonths: 1,
		dateFormat: 'dd/mm/yy',	
		minDate: 1,
		onClose: function( selectedDate ) 
		{  
		$( "#end_dt" ).datepicker( "option", "minDate", selectedDate );  
		}  
	});  
	$( "#end_dt" ).datepicker({
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		dateFormat: 'dd/mm/yy',
		minDate: 1,
		onClose: function( selectedDate ) {
		$( "#start_dt" ).datepicker( "option", "maxDate", selectedDate );
		}
	});  
});
</script>
<!-- validation -->
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script src="<?=$baseUrl;?>assets/js/custom-validation.js"></script>
<!-- validation end -->
    </body>
</html>	