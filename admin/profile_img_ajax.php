<?php
require "../core/init.php"; 

//$userid= isSet($uid) ? $uid : '' ;
if(isset($uid))
{
	$userid = $uid;
	if(!isset($_FILES['img']['name']) )
	{ ?>	
		<img src="<?=dirname($baseUrl);?>/uploads/user-profile/emptyimg.png" class="img-responsive" style="height:150px;width:150px;">
		<input type="hidden" name="insid" id="dynamicid" value="none">		<?php 
    }
	else 
	{ 
				$img=$_FILES['img']['name'];
				$name1='img';
				$name2=uniqid();
				$width=100;
				$height=100;
				$path="../uploads/user-profile";
				$acn='';
				$db->query("select * from register where id='$userid'");
				$getuser=$db->fetch();
				if($getuser['profile_image'] != 'emptyimg.png')
					$oldimg = $getuser['profile_image'];
				else
					$oldimg = '';
				$result_img=$common->uploadImg($name1,$name2,$width,$height,$path,$oldimg);
			    $err_img=$common->imgErr;
				$crcdt= date('y-m-d H:i:s'); 
				if($err_img=='ok')
				{
					$img=$common->imgName;
					if(($userid!="none") && !empty($userid))
					{ 
					$db->query("update register set chngdt='$crcdt',profile_image=:img where id='$userid'");
					$db->bind(":img", $img);
					$db->execute();
					}
					else 
					{
					$db->query("insert register set chngdt='$crcdt',profile_image=:img");
					$db->bind(":img", $img);
					$userid=$db->lastInsertId();
					}
					
					$db->query("select * from register where id='$userid'");
					$getuser=$db->fetch();
					$currimg=$getuser['profile_image'];
				?>
					<img class="comment-avatar img-circle" alt="" src="<?=dirname($baseUrl);?>/uploads/user-profile/<?=$currimg;?>" style="height:150px;width:150px;">
			
					<input type="hidden" name="insid" id="dynamicid"   value="<?=$userid;?>">
			
		 <?php  } 
				else 
				{   ?>
					<p style="color:red;"><?=$err_img;?></p>
			
					<input type="hidden"  name="insid" id="dynamicid"  value="none">	
		<?php	}  
	}  
} ?>
				
				
				