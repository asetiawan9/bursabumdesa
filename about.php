<? include "includes/header.php";

$abtusimg = $extra->chkprjtImg($aboutus_img, "uploads/settings/");
if(!empty($abtusimg)) {
	$abtus_img = "<div class=\"col-sm-4\"><img src=\"$abtusimg\" class=\"img-responsive\"></div>";
	$col_wd = 8;
}
else {
	$abtus_img = '';
	$col_wd = 12;
}
?>
		<section class="section careing-section">
		    <div class="container">
                <div class="row">
                    <div class="section-heading">                         
                        <h3>Because We Help</h3>
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-<?=$col_wd;?>">
									<?=stripslashes($about_us);?>
								</div>
								<?=$abtus_img;?>
							</div>
						</div>
                    </div>                    
                </div>
                <div class="row">
                    <div class="causes">                        
						<div class="col-sm-6 text-center">
                            <div class="single-causes-box">
                                <div class="causes-content">
                                    <h4>Our Vision</h4>
                                    <?=stripslashes($vision);?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 text-center">
                            <div class="single-causes-box">
                                <div class="causes-content">
                                    <h4>Our Mission</h4>
                                    <?=stripslashes($mission);?>
                                </div>
                            </div>
                        </div>                        
                    </div>
                </div>
		    </div>
		</section>		  	 
<? include "includes/footer.php"; ?>