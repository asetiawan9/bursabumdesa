<? include "includes/header.php"; ?>
 		 
		 <section class="faq-page section p-90">
				<div class="container">					
					<div class="post_content">
						<h2 class="ttl text-center" style="">QUESTIONS</h2>
					</div>
					<div class="faq-item">
						<div class="inspiration-tab">
							<div class="inspiration-panel">
								<div class="panel-group theme-accordion faq-page" id="accordion">
			<?
			$i = 0;
			$db->query("select question,ans from faq where active_status='1' order by id desc");
			$result = $db->fetchAll();
			foreach($result as $row):
			$ques = stripslashes($row['question']);	
			$ans = stripslashes($row["ans"]);			
			?>					
									<div class="panel">
									    <div class="panel-heading active-panel">
										    <h6 class="panel-title">
										        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$i;?>" class="blk <? if($i==0) echo ""; else { echo "collapsed"; } ?>">
										        <?=$ques;?></a>
										    </h6>
									    </div>
									    <div id="collapse<?=$i;?>" class="panel-collapse collapse <? if($i==0) echo 'in'; ?>">
										    <div class="panel-body">
										      	<?=$ans;?>
										    </div>
									    </div>
									</div> <!-- /panel 1 -->
			<? $i++;endforeach; ?>
								</div> <!-- end #accordion -->
							</div> <!-- End of .inspiration-panel -->
						</div> <!-- /.inspiration-tab -->
					</div> <!-- /.faq-item -->
				</div> <!-- /.container -->
			</section> <!-- /.faq-page -->		
         	 
<? include "includes/footer.php"; ?>