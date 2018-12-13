<?
	include "includes/header.php";
	include "includes/profhead.php";
?>
      <div class="container">
         <div class="row">
            <div class="col-sm-12">
               <div class="col-sm-12 dashboard">
                  <div class="row">
					<h2 class="mb15i">Campaigns</h2>
                  </div>
				  <div class="row">
                     <div class="col-sm-12">
						  <h4>Following Campaigns</h4>
					   <div class="row gallery">
						 <div class="gallery-grid-4">
	<?
		$rowsPerPage = 8;
		$limit = limitation($rowsPerPage);
		$i = 1;
		$sq = "select f.prjt_id,p.title,p.img1,p.goal,p.contribute_amount from follow f inner join project p on f.user_id='$userlog' and p.active_status='1' and f. prjt_id=p.id order by f.id desc";
		$db->query($sq.$limit);
		$result = $db->fetchAll();
		foreach($result as $row):
		$prjtid = $row["prjt_id"];
		$title = $row["title"];
		$img1 = $row["img1"];
		$goal = $row["goal"];
		$contribute_amount = $row["contribute_amount"];		
		$encid = base64_encode($prjtid);
		$prjtimg1 = $extra->chkprjtImg($img1, "uploads/prjt-img/img1/");
		if(!empty($prjtimg1)) {
			$img_src = $prjtimg1;
		}
		else {
			$img_src = $baseUrl.'uploads/prjt-img/img1/noimage.jpg';
		}
		
		$reurl_title = $extra->reurl(stripslashes($title));
		?>				 
                             <div class="single-item-4 col-md-3 col-sm-6 breakfast dinner health education food">
                                 <div class="gallery-img">
                                     <img src="<?=$img_src;?>" alt="">
                                     <div class="overlay"></div>
                                     <!--<div class="gallery-content">
                                        <div class="row">
											<div class="col-sm-12 text-center">
												<h4><a href="#" id="unfollow" data-id="<?=$prjtid?>"><i class="far fa-trash-alt"></i><br> Remove</a></h4>
											</div>
										</div>
                                     </div>-->
                                 </div>
								 <div class="row mrgn0i">
									<div class="col-sm-12 text-center pdt10 project-details">
										<a href="<?=$baseUrl;?>detail/<?=$reurl_title;?>/<?=$encid;?>/" target="_blank">
										<h4><?=ucwords(stripslashes($title));?></h4> </a>
										<p><b>Goal: </b> <?=$site_currency.' '.$goal;?></p>
										<p><b>Raised: </b> <?=$site_currency.' '.$contribute_amount;?></p>
									</div>
								 </div>
                             </div>
		<? $i++; endforeach; ?>					 
                         </div>
					   </div>	
					<div class="row">
					<div class="pagination-div">
						<ul class="pagination">
							<? echo $pagingLink = getPagingLink1($sq,$rowsPerPage,"",$db); ?>
						</ul>
					</div>	
					</div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
	  
<script>
$("#unfollow").click(function(){
	var prjtid = $(this).data('id');alert(prjtid);
	swal({
	  title: "Remove from your Follow List",
	  text: "Are you sure to proceed?",
	  type: "info",
	  showCancelButton: true,
	  closeOnConfirm: false,
	  showLoaderOnConfirm: true
	},
	function(){
		setTimeout(function () {
		$.ajax({
		type:'POST',
		url:'<?=$baseUrl;?>/ajax.php',
		data:{listid:prjtid,usrid:<?=$userlog;?>},
		success:function(data){
				if(data == 1){
					swal({title: 'success',text: 'Successfully removed from your follow list',type: 'success',confirmButtonText: 'OK',},function(){	location.href='<?=$baseUrl;?>/user-following/';});
				}
				else {
					swal("Oops!","Try Later","error");
				}
			}
		});
		}, 1000);
	});
});
</script>
<? include "includes/footer.php"; ?>