<?php
require "includes/header.php";

if(isset($rmv)) {
	$db->query("delete from contact_us where id=:id");
	$db->bind(":id", $rmv);
	$db->execute();
	$extra->setMsg("Deleted successfully!", "success");
	$extra->redirect_to($baseUrl."contact-us/");
}
?>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-xs-12 mb-2">
                <h3 class="content-header-title mb-0">User Contact Us Details</h3>
            </div>
        </div>
        <div class="content-body">
            <section id="html">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body collapse in">
                                <div class="card-block card-dashboard table-responsive">
									<?php $extra->flashMsg(); ?>
                                    <table id="datatable" class="table table-striped table-bordered sourced-data">
                                        <thead>
                                            <tr>
                                                <th></th>
												<th>S.No</th>
                                                <th>Username</th>
												<th>Email</th>
                                                <th>Contact Number</th>
                                                <th>Comment</th>
												<th>Date / IP</th>
												<th>Reply</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php
											$i = 1;
											$db->query("select * from contact_us order by id desc");
											$result = $db->fetchAll();
											foreach($result as $row):		
											$comment = ucfirst(stripslashes($row["comment"]));
											$comment = $extra->checkLength($comment,30);
											$date = date("d-m-Y",strtotime($row["date"]));
											$date_ip = $date.'<b>/ </b>'.$row["ip"];
											
											?>
                                            <tr>
                                                <td align='center'>
													<input type='checkbox' id='checkcount' name='checkbox[]' class='case' value='<?=$row["id"];?>' />
												</td>
												<td><?=$i; ?></td>
												<td><?=ucfirst($row["name"]);?></td>
												<td><?=$row["email"]; ?></td>
                                                <td><?=$row["ctc_num"]; ?></td>
                                                <td width="15%"><?=$comment;?></td>
												<td><?=$date_ip;?></td>
												<td>
													<a href='<?=$baseUrl."replymail/$row[id]/";?>' title='Reply' class='btn btn-default' data-toggle='tooltip'><img src='<?=dirname($baseUrl);?>/images/mail.png'></a>
												</td>
                                                <td width="12%">
                                                    <div class="btn-group btn-sm" role="group" aria-label="Action">
														<a href="<?php echo $baseUrl."contactus-view/$row[id]/"; ?>" type="button" class="btn btn-sm btn-icon btn-info"><i class="fa fa-search"></i></a>
                                                        <a href="<?php echo $baseUrl."contact-us/?rmv=$row[id]"; ?>" class="btn btn-sm btn-icon btn-danger" onclick="return confirmAct();"><i class="fa fa-trash"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
											<?php $i++; endforeach; ?>
                                        </tbody>
										<tfoot>
										<tr>
											<th><input type="checkbox" name="checkall" id="selectall" />Check All<br /> <button class='btn btn-default' data-toggle='tooltip' id="replylogg" title='Reply To Selected User'><img src='<?=dirname($baseUrl);?>/images/mail.png'></button></th>
											<th></th>				
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
										</tr>
										</tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<script>
$("#replylogg").on('click', function () {
    var ids = [];
    $(".case").each(function () {
        if ($(this).is(":checked")) {
            ids.push($(this).val());
        }
    });
    if (ids.length) {
		var count= $("input#checkcount:checked").length;
		var check=confirm('Please confirm to reply '+count+' users');
		if(check==true){
			window.location.href='<?=$baseUrl;?>replymail/'+ids+'/';        
		}
    } else {
        alert("Please select Users");
    }
});
</script>
<?php require "includes/footer.php"; ?>