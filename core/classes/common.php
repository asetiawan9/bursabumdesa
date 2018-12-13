<?php
class common extends database {
	
	/** image upload **/
	public function uploadImg($fname, $newname, $width, $height, $path, $oldimg) {
		$tmpname=$_FILES[$fname]['tmp_name'];
		if(!empty($tmpname)) {
			$name=$_FILES[$fname]['name'];
			$image_info=getimagesize($_FILES[$fname]["tmp_name"]);
			$image_width=$image_info[0];
			$image_height=$image_info[1];
			$size=filesize($_FILES[$fname]['tmp_name']);
			$ext=pathinfo($name, PATHINFO_EXTENSION);
			if($ext=="jpg" || $ext=="jpeg" || $ext=="png" || $ext=="gif") {
				if($image_width<$width || $image_height<$height){ 
					$this->imgErr="Image size Too small";
					return false;
				}
				$nImg=$newname.".".$ext;
				$imgpath="$path/$nImg";
				move_uploaded_file($tmpname,$imgpath);
				if($oldimg!="" && file_exists($path.'/'.$oldimg)) unlink($path.'/'.$oldimg);
				
				if(($ext!="png") && ($image_width>$width && $image_height>$height)){
					$resizeObj=new resize($imgpath);
					$resizeObj->resizeImage($width, $height, 'exact');
					$resizeObj->saveImage($imgpath, 72);
			    }
				$this->imgName=$nImg;
				$this->imgErr="ok";
				return true;
			}
			else {
				$this->imgErr="Missmatch Image format";
				return false;
			}
		}
		else {
			$this->imgErr="Image missing";
			return false;
		}
	}
	
	/** send mail with phpmailer **/
	public function email($from,$to,$subject,$msg){
		//$from=$admin_email;
		$mail = new PHPMailer;	
		$mail->IsSMTP();                           
		$mail->SMTPDebug = false;
		$mail->SMTPAuth = true; 
		$mail->SMTPSecure = 'ssl';
		$mail->Host = 'trailblazer.websitewelcome.com';  
		$mail->Port = 465;  
		$mail->IsHTML(true);     
		$mail->Username = 'no-reply@smsemailmarketing.in';         
		$mail->Password = 'dD}O-RnM#7]K';                         
		$mail->setFrom($from, 'Equity Crowdfunding');      
		$mail->Subject = $subject;
		$mail->Body    = $msg;
		$mail->addAddress($to, 'User');  
		
		if(!$mail->send()) {
			$ret = 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
			$ret = "scs";
		}
		return $ret;
	}
	
	/** returns timeago from a date **/
	public function timeago($d1){
		$d1=strtotime($d1);
		$d2=time();
		$mindiff=round(($d2-$d1)/60);
		$hourdiff=round(($d2-$d1)/(60*60));
		$daydiff=round(($d2-$d1)/(60*60*24));
		
		if($mindiff==1)
			return '1 minute ago';
		else if($hourdiff==1)
			return '1 hour ago';
		else if($daydiff==1)
			return '1 day ago';
		else if(round($daydiff/7)==1)
			return '1 week ago';
		else if(round($daydiff/30)==1)
			return '1 month ago';
		else if(round($daydiff/365)==1)
			return '1 year ago';
		
		if($mindiff==0)
			return 'just now';
		else if($mindiff<60)
			return $mindiff.' minutes ago';
		else if($hourdiff<24)
			return $hourdiff.' hours ago';
		else if($daydiff<7)
			return $daydiff.' days ago';
		else if($daydiff<31)
			return round($daydiff/7).' weeks ago';
		else if($daydiff<365)
			return round($daydiff/30).' months ago';
		else if($daydiff>365)
			return round($daydiff/365).' years ago';
	}
	
	/** document upload **/
	public function uploadfile($fname, $newname, $path, $oldfile) {
		$tmpname=$_FILES[$fname]['tmp_name'];
		if(!empty($tmpname)) {
			$name=$_FILES[$fname]['name'];
			$size=filesize($_FILES[$fname]['tmp_name']);
			$ext=pathinfo($name, PATHINFO_EXTENSION);
			if($ext=="docx" || $ext=="doc" || $ext=="pdf") {
				if($size>2000000){
					$this->Err="Document size should not exceed 2MB";
					return false;
				}
				$nDoc=$newname.".".$ext;
				$filepath="$path/$nDoc";
				move_uploaded_file($tmpname,$filepath);
				if($oldfile!="" && file_exists($path.'/'.$oldfile)) unlink($path.'/'.$oldfile);
				
				$this->fileName=$nDoc;
				$this->Err="ok";
				return true;
			}
			else {
				$this->Err="Missmatch Document format";
				return false;
			}
		}
		else {
			$this->Err="Document missing";
			return false;
		}
	}
	
	/** video upload **/
	public function uploadvideo($fname, $newname, $path, $oldfile) {
		$tmpname=$_FILES[$fname]['tmp_name'];
		if(!empty($tmpname)) {
			$name=$_FILES[$fname]['name'];
			$size=filesize($_FILES[$fname]['tmp_name']);
			$ext=pathinfo($name, PATHINFO_EXTENSION);
			if($ext=="mp4") {
				if($size>26246026){//25 MB
					$this->Err="Video size should not exceed 25MB";
					return false;
				}
				$nDoc=$newname.".".$ext;
				$filepath="$path/$nDoc";
				move_uploaded_file($tmpname,$filepath);
				if($oldfile!="" && file_exists($path.'/'.$oldfile)) unlink($path.'/'.$oldfile);
				
				$this->fileName=$nDoc;
				$this->Err="ok";
				return true;
			}
			else {
				$this->Err="Missmatch Video format";
				return false;
			}
		}
		else {
			$this->Err="Video file missing";
			return false;
		}
	}
}
?>