<?
	include "includes/header.php";
	include "includes/profhead.php";
	
if(isset($_POST)) {
	if(isset($_FILES['prf_img']['tmp_name']) && !empty($_FILES['prf_img']['tmp_name'])) {
		$newName="pay_".uniqid();
		$pay_slip = $db->extractCol("select payslip from contribute where id='$inv_id'");
		$upd = $common->uploadImg("prf_img", $newName, "600", "400", "uploads/payproof", $pay_slip, false);
		if($upd) {
			$imgName = $common->imgName;
			$db->query("update contribute set payslip='$imgName' where id='$inv_id'");
			$db->execute();
			$extra->swalMsg("success!","Your Payment proof uploaded successfully","success",$baseUrl."user-invest/");
		}
		else {
			$err = $common->imgErr;
			$extra->swalMsg("Oops!",$err,"error",$baseUrl."pay-upload/$inv_id/");
		}
	}
}
?>
      <div class="container">
         <div class="row">
            <div class="col-sm-9">
               <div class="col-sm-12 dashboard">
                  <div class="row">
					<h2>Upload Your Payment Proof</h2>
                  </div>
				  <div class="row">
                     <div class="col-sm-12">
						<form id="jsform" action="" method="post" enctype="multipart/form-data">
						<input type="hidden" name="inv_id" value="<?=$pid;?>" />
                           <div class="form-group">
                              <div class="col-sm-8">
                                 <input type="file" name="prf_img" class="form-control" required onChange="change_img();" />
                              </div>
                           </div>
                        </form>
                     </div>
					 
						<span style="color:red; margin-top:10px;">Only jpg, jpeg, png, pdf file with dimension above 600X400 & maximum size of 1 MB is allowed.</span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
<script type="text/javascript">
function change_img() {
  document.getElementById('jsform').submit();
}
</script>
<? include "includes/footer.php"; ?>