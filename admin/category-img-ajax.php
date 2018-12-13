<?php
require "core/init.php"; 
$_REQUEST['cid']= isSet($_REQUEST['cid']) ? $_REQUEST['cid'] : 'none' ;
$catid=$_REQUEST['cid'];
if(isset($_POST))
{
	if(!isset($_FILES['icon']['name']))
	{ ?>	
		<img src="<?=$baseUrl;?>images/product/emptyproimg.jpg" style="height:150px;width:200px;">
		<input type="hidden" name="proid" id="proid" value="<?=$proid;?>">
			   <?php 
    }
	else 
	{ 
				$img=$_FILES['icon']['name'];
				$name1='icon';
				$name2=uniqid();
				$width=900;
				$height=600;
				$path="images/product";
				$acn='';
			
				$db->query("select * from  category where id='$proid'");
				$getuser=$db->fetch();
				$oldimg=$getuser['icon'];
				$result_img=$common->uploadImg($name1,$name2,$width,$height,$path,$oldimg);
			    $err_img=$common->imgErr;
				$crcdt= date('y-m-d H:i:s');
				if($err_img=='ok')
				{
					$img=$common->imgName; 
					if(($proid!="none") && !empty($proid))
					{ 
					$db->query("update category set chngdt='$crcdt',icon=:icon where id='$proid'");
					$db->bind(":icon", $img);
					$db->execute();
					}
					else 
					{
					$db->query("insert category set chngdt='$crcdt',icon=:icon");
					$db->bind(":icon", $img);
					$proid=$db->lastInsertId();
					}
					
					$db->query("select * from category where id='$proid'");
					$getproduct=$db->fetch();
					$currimg=$getproduct['icon'];
				?>
					<img src="<?=$baseUrl;?>images/product/<?=$currimg;?>" style="height:150px;width:200px;">
					<input type="hidden" name="proid" id="proid"  value="<?=$proid;?>">
			
		 <?php  } 
				else 
				{   ?>
					<p style="color:red;"><?=$err_img;?></p>
					<input type="hidden" name="proid"  id="proid" value="<?=$proid;?>">
		<?php	}  
	}  
} ?>
				
				
				