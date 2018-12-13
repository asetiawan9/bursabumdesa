<?php
require "core/init.php"; 

if(isset($prjt_id1)) {
	if(isset($_FILES['img1']['name'])) {
		$img=$_FILES['img1']['name'];
		$name1='img1';
		$name2=uniqid();
		$width=770;
		$height=400;
		$path="uploads/prjt-img/img1";
		$oldimg = $db->extractCol("select img1 from project where id='$prjt_id1'");		
		$result_img=$common->uploadImg($name1,$name2,$width,$height,$path,$oldimg);
		$err_img=$common->imgErr;
		$crcdt= date('Y-m-d H:i:s'); 
		if($err_img=='ok') {
			$img=$common->imgName;
			if(($prjt_id1!="none") && !empty($prjt_id1)) {
				$db->query("update project set chngdt='$crcdt',img1=:img where id='$prjt_id1'");
				$db->bind(":img", $img);
				$db->execute();
			}
			else {
				$db->query("insert project set crcdt='$crcdt',img1=:img");
				$db->bind(":img", $img);
				$prjt_id1=$db->lastInsertId();
			}
			$currimg = $db->extractCol("select img1 from project where id='$prjt_id1'");
		?>
			<img class="comment-avatar" alt="" src="<?=$baseUrl;?>/uploads/prjt-img/img1/<?=$currimg;?>" style="height:150px;width:150px;" />
			<input type="hidden" name="insid1" id="dynamicid1" value="<?=$prjt_id1;?>">
	<?  } else { ?>
			<p style="color:red;"><?=$err_img;?></p>
			<input type="hidden" name="insid1" id="dynamicid1" value="<?=$prjt_id1;?>">
		<? }  
	}  
}

if(isset($prjt_id2)) {
	if(isset($_FILES['img2']['name'])) {
		$img=$_FILES['img2']['name'];
		$name1='img2';
		$name2=uniqid();
		$width=770;
		$height=400;
		$path="uploads/prjt-img/img2";
		$oldimg = $db->extractCol("select img2 from project where id='$prjt_id2'");
		$result_img=$common->uploadImg($name1,$name2,$width,$height,$path,$oldimg);
		$err_img=$common->imgErr;
		$crcdt= date('Y-m-d H:i:s'); 
		if($err_img=='ok') {
			$img=$common->imgName;
			if(($prjt_id2!="none") && !empty($prjt_id2)) { 
				$db->query("update project set chngdt='$crcdt',img2=:img where id='$prjt_id2'");
				$db->bind(":img", $img);
				$db->execute();
			}
			else {
				$db->query("insert project set crcdt='$crcdt',img2=:img");
				$db->bind(":img", $img);
				$prjt_id2=$db->lastInsertId();
			}
			$currimg = $db->extractCol("select img2 from project where id='$prjt_id2'");
		?>
			<img class="comment-avatar" alt="" src="<?=$baseUrl;?>/uploads/prjt-img/img2/<?=$currimg;?>" style="height:150px;width:150px;" />
			<input type="hidden" name="insid2" id="dynamicid2" value="<?=$prjt_id2;?>">
	<?  } else { ?>
			<p style="color:red;"><?=$err_img;?></p>
			<input type="hidden" name="insid2" id="dynamicid2" value="<?=$prjt_id2;?>">
		<? }  
	}  
}

if(isset($prjt_id3)) {
	$prjId = $prjt_id3;
	$img_name = 'img3';
	$img_indb = 'img3';
	if(isset($_FILES[$img_name]['name'])) {
		$img=$_FILES[$img_name]['name'];
		$name1 = $img_name;
		$name2=uniqid();
		$width=770;
		$height=400;
		$path="uploads/prjt-img/img3";
		$oldimg = $db->extractCol("select $img_indb from project where id='$prjId'");
		$result_img=$common->uploadImg($name1,$name2,$width,$height,$path,$oldimg);
		$err_img=$common->imgErr;
		$crcdt= date('Y-m-d H:i:s'); 
		if($err_img=='ok') {
			$img=$common->imgName;
			if(($prjId!="none") && !empty($prjId)) { 
				$db->query("update project set chngdt='$crcdt',$img_indb=:img where id='$prjId'");
				$db->bind(":img", $img);
				$db->execute();
			}
			else {
				$db->query("insert project set crcdt='$crcdt',$img_indb=:img");
				$db->bind(":img", $img);
				$prjId=$db->lastInsertId();
			}
			$currimg = $db->extractCol("select $img_indb from project where id='$prjId'");
		?>
			<img class="comment-avatar" alt="" src="<?=$baseUrl;?>/uploads/prjt-img/img3/<?=$currimg;?>" style="height:150px;width:150px;" />
			<input type="hidden" name="insid3" id="dynamicid3" value="<?=$prjId;?>">
	<?  } else { ?>
			<p style="color:red;"><?=$err_img;?></p>
			<input type="hidden" name="insid3" id="dynamicid3" value="<?=$prjId;?>">
		<? }  
	}  
}

if(isset($prjt_id4)) {
	$prjId = $prjt_id4;
	$img_name = 'img4';
	$img_indb = 'img4';
	if(isset($_FILES[$img_name]['name'])) {
		$img=$_FILES[$img_name]['name'];
		$name1 = $img_name;
		$name2=uniqid();
		$width=770;
		$height=400;
		$path="uploads/prjt-img/img4";
		$oldimg = $db->extractCol("select $img_indb from project where id='$prjId'");
		$result_img=$common->uploadImg($name1,$name2,$width,$height,$path,$oldimg);
		$err_img=$common->imgErr;
		$crcdt= date('Y-m-d H:i:s'); 
		if($err_img=='ok') {
			$img=$common->imgName;
			if(($prjId!="none") && !empty($prjId)) { 
				$db->query("update project set chngdt='$crcdt',$img_indb=:img where id='$prjId'");
				$db->bind(":img", $img);
				$db->execute();
			}
			else {
				$db->query("insert project set crcdt='$crcdt',$img_indb=:img");
				$db->bind(":img", $img);
				$prjId=$db->lastInsertId();
			}
			$currimg = $db->extractCol("select $img_indb from project where id='$prjId'");
		?>
			<img class="comment-avatar" alt="" src="<?=$baseUrl;?>/uploads/prjt-img/img4/<?=$currimg;?>" style="height:150px;width:150px;" />
			<input type="hidden" name="insid4" id="dynamicid4" value="<?=$prjId;?>">
	<?  } else { ?>
			<p style="color:red;"><?=$err_img;?></p>
			<input type="hidden" name="insid4" id="dynamicid4" value="<?=$prjId;?>">
		<? }  
	}  
}

if(isset($vdo_file)) {
	$prjId = $vdo_file;
	$txt_name = 'video';
	$name_indb = 'video';
	if(isset($_FILES[$txt_name]['name'])) {
		$video=$_FILES[$txt_name]['name'];
		$name1 = $txt_name;
		$name2 = 'vdo'.uniqid();
		$width=770;
		$height=400;
		$path="uploads/video";
		$oldfile = $db->extractCol("select $name_indb from project where id='$prjId'");
		$result_vdo = $common->uploadvideo($name1,$name2,$path,$oldfile);
		$err_msg = $common->Err;
		$crcdt = date('Y-m-d H:i:s'); 
		if($err_msg=='ok') {
			$video=$common->fileName;
			if(($prjId!="none") && !empty($prjId)) { 
				$db->query("update project set chngdt='$crcdt',$name_indb=:video where id='$prjId'");
				$db->bind(":video", $video);
				$db->execute();
			}
			else {
				$db->query("insert project set crcdt='$crcdt',$name_indb=:video");
				$db->bind(":video", $video);
				$prjId=$db->lastInsertId();
			}
			$currfile = $db->extractCol("select $name_indb from project where id='$prjId'");
		?>
			<video width="300" height="200" controls>
				<source src="<?=$baseUrl;?>/uploads/video/<? echo $currfile; ?>" type="video/mp4">
			</video>
			<input type="hidden" name="insid5" id="dynamicid5" value="<?=$prjId;?>">
	<?  } else { ?>
			<p style="color:red;"><?=$err_msg;?></p>
			<input type="hidden" name="insid5" id="dynamicid5" value="<?=$prjId;?>">
		<? }  
	}  
}
?>