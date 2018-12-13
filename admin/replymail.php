<?php
require "includes/header.php";

$sel_idval = $sel_id;

if(isset($send)) {
	$subject = addslashes($sub);
	$message = addslashes($msg);		

	$to_all = explode(",",$tomail);
	foreach($to_all as $to):
		$site_logo_lnk = dirname($baseUrl)."/uploads/settings/$site_logo";
		$content = '<center>Thank you for getting in touch with us!</center>';
		$content .= $message;
		$specific_title = "Warm Regards,<br />$mail_sign";
		$btn_name = 'Click Here to visit the site';
		$msg = $extra->customtemplate(dirname($baseUrl),$site_logo_lnk,$content,$site_title,dirname($baseUrl),$specific_title,$btn_name);
		$result = $common->email($admin_email,$to,$subject,$msg);
	endforeach;
	if($result == "scs") {
		$extra->swalMsg("success!","Email sent successfully","success",$baseUrl."contact-us/");	
	}
	else {
		$extra->swalMsg("Oops!","There is a problem with send email.Try again later","error",$baseUrl."contact-us/");	
	}	
}

if(isset($sel_idval)) {
	$ids = $sel_idval;
	$arr = explode(",",$ids);				
	$str = "";
	$arr_ct = count($arr);
	for($i=0; $i < $arr_ct; $i++) {
		$db->query("select email from contact_us where id=:id");
		$db->bind(":id", $arr[$i]);
		$result = $db->fetch();
		$str .= $result["email"].',';
	}	

	$str = rtrim($str,',');
	$to_mailval = $str;
}
?>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-xs-12 mb-2">
                <h3 class="content-header-title mb-0"> </h3>
            </div>
        </div>
        <div class="content-body">
            <section id="html">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"> Compose Mail</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            </div>
                            <div class="card-body collapse in">
                                <div class="card-block card-dashboard table-responsive">
                                    <form name="rplyfrm" class="form-horizontal" method="post" action="">
                                        <div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">To</label>
                                            <div class="col-sm-8">
                                                <input class="form-control" type="text" name="tomail" value="<?=$to_mailval;?>" readonly />
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Subject</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="sub" id="subvalId" class="form-control" required />
												<div id="subErr" style="color:#d51510;"> </div>
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Content</label>
                                            <div class="col-sm-8">
                                                <textarea name="msg" id="msg" class="form-control tinymce" placeholder="Leave your Message here..." required>	</textarea>
												<div id="cntErr" style="color:#d51510;"> </div>
                                            </div>
                                        </div>
                                        <div class="form-actions center col-sm-12">
											<button onClick="return reply_valid();" type="submit" class="btn btn-primary mr-1" name="send"><i class="fa fa-check-square-o"></i> Send</button>
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
<?php require "includes/footer.php"; ?>