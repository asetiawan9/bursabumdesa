<?php
require "includes/header.php";

$isEdit=false;
if(isset($info)) $isEdit=true;
/** process if the form has been submitted **/
if(isset($faq_sub)) {
	$set="question=:question";
	$set.=",ans=:ans";
	
	if($isEdit) {
		$set.=",chngdt='$tday'";
		$set.=",chng_ip='$ip_addr'";
		$que = "update faq set $set where id=:id";
		$db->query($que);
	}
	else {
		$set.=",crcdt='$tday'";
		$set.=",crc_ip='$ip_addr'";
		$que = "insert into faq set $set";
		$db->query($que);		
	}
        $ques = trim(strip_tags($ques,'<p>'));
	$answer = trim(strip_tags($answer,'<p>'));
	$db->bind(":question", $ques);
	$db->bind(":ans", $answer);
	if($isEdit) $db->bind(":id", $info);
	$exec = $db->execute();
	if($exec) {
		if($isEdit) $msg="Updated";
		else $msg="Added";
		$extra->setMsg("$msg successfully!", "success");
		$extra->redirect_to($baseUrl."manage-faq/");
	}
}
if($isEdit) {
	$db->query("select question,ans from faq where id=:id");
	$db->bind(":id", $info);
	$result=$db->fetch();
	if(!empty($result)) extract($result);
	else $extra->redirect_to($baseUrl."manage-faq/");
}
?>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-xs-12 mb-2">
                <h3 class="content-header-title mb-0"><?php echo ($isEdit)?"Edit":"Create"; ?> FAQ</h3>
            </div>
        </div>
        <div class="content-body">
            <section id="html">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"><?php echo ($isEdit)?"Edit":"Create"; ?> FAQ</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            </div>
                            <div class="card-body collapse in">
                                <div class="card-block card-dashboard table-responsive">
                                    <form class="form-horizontal" method="post" action="">
                                        <div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Question</label>
                                            <div class="col-sm-6">
                                                <input id="quseId" class="form-control" type="text" name="ques" maxlength="50" value="<?php echo isset($question)?$question:''; ?>" required />
												<div id="quesErr" style="color:#d51510;"> </div>
                                            </div>
                                        </div>
										<div class="form-group col-sm-12">
                                            <label class="col-sm-2 control-label">Answer</label>
                                            <div class="col-sm-6">
                                                <textarea id="ansId" class="form-control tinymce" name="answer" rows="7"><?php echo isset($ans)?$ans:''; ?></textarea>
												<div id="ansErr" style="color:#d51510;"> </div>
                                            </div>
                                        </div>
                                        <div class="form-actions center col-sm-12">
											<button onClick="return faq_valid();" type="submit" class="btn btn-primary mr-1" name="faq_sub"><i class="fa fa-check-square-o"></i> Save</button>
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