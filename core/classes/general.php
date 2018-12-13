<?php
class general extends database {
	
	/** get site options **/
	public function get_option($name) {
		$this->query("select option_value from options where option_name=:name");
		$this->bind(":name", $name);
		$result=$this->fetch();
		if(!empty($result)) return $result['option_value'];
		else return false;
	}
	
	/** insert or update site options **/
	public function put_option($name, $value) {
		$this->query("select option_value from options where option_name=:name");
		$this->bind(":name", $name);
		$result=$this->fetch();
		if(!empty($result)) {
			$this->query("update options set option_value=:value where option_name=:name");
			$this->bind(":value", $value);
			$this->bind(":name", $name);
			return $this->execute();
		}
		else {
			$this->query("insert into options set option_name=:name,option_value=:value");
			$this->bind(":name", $name);
			$this->bind(":value", $value);
			return $this->execute();
		}
	}
	
	public function hasSubmenu($menu_id) {
		$this->query("select id from menu where parent_id='$menu_id' and status='1'");
		$rowCount=$this->rowCount();
		if($rowCount>0) return true;
		else return false;
	}
	
	public function menuName($menu_id) {
		$this->query("select name from menu where id='$menu_id'");
		$result=$this->fetch();
		return $result['name'];
	}
	
	public function totalUsers() {
		$this->query("select * from register");
		$totusers=$this->rowCount();
		return $totusers;
	}
	
	public function inactiveUsers() {
		$this->query("select * from register where active_status!='1'");
		$totusers=$this->rowCount();
		return $totusers;
	}
	
	public function activeUsers() {
		$this->query("select * from register where active_status='1'");
		$totusers=$this->rowCount();
		return $totusers;
	}
	
	public function todayUsers() {
		$tdate=date("d m Y");
		$this->query("select id from register where DATE_FORMAT(crcdt, '%d %m %Y')='$tdate'");
		$totusers=$this->rowCount();
		return $totusers;
	}
	
	public function totprjts() {
		$this->query("select * from project");
		$totprjts=$this->rowCount();
		return $totprjts;
	}
	
	public function rungprjts() {
		$tday = date('Y-m-d');
		$this->query("select * from project where active_status='1' and deadline >='$tday'");
		$rungprjts=$this->rowCount();
		return $rungprjts;
	}
	
	public function sucprjts() {
		$this->query("select * from project where contribute_amount>=goal");
		$suc_prjts = $this->rowCount();
		return $suc_prjts;
	}
	
	public function unsucprjts() {
		$tday = date('Y-m-d');
		$this->query("select * from project where contribute_amount < goal and deadline < '$tday'");
		$unsuc_prjts = $this->rowCount();
		return $unsuc_prjts;
	}
	
	public function total_investors() {
		$this->query("select distinct user_id from contribute where pay_status='1'");
		$investors_tot = $this->rowCount();
		return $investors_tot;
	}
	
	public function total_invest() {
		$this->query("select sum(contribute_amount) as tot_invst from contribute where  pay_status='1'");
		$invest_tot = $this->fetch();
		return $invest_tot['tot_invst'];
	}
	
	public function today_investors() {
		$tday = date('Y-m-d');
		$this->query("select distinct user_id from contribute where pay_status='1' and date='$tday'");
		$investors_tday = $this->rowCount();
		return $investors_tday;
	}
	
	public function today_invest() {
		$tday = date('Y-m-d');
		$this->query("select sum(contribute_amount) as tot_invst from contribute where  pay_status='1' and date='$tday'");
		$invest_today = $this->fetch();
		return $invest_today['tot_invst'];
	}
	
	public function menuNamebyIDS($ids) {
		$ids=json_decode($ids, true);
		$mid=implode(",", $ids);
		$result=$this->extractCol("select name from menu where FIND_IN_SET(id, '$mid')");
		return $result;
	}
	
	public function roleName($rid) {
		$this->query("select name from staff_roles where id='$rid'");
		$result=$this->fetch();
		return $result['name'];
	}
	
	public function usr_totprjt($uid) {
		$this->query("select * from project where userid='$uid'");
		$tot_usrprjts = $this->rowCount();
		return $tot_usrprjts;
	}
	
	public function usr_runprjt($uid,$tday) {
		$this->query("select * from project where userid='$uid' and deadline >='$tday'");
		$run_usrprjts = $this->rowCount();
		return $run_usrprjts;
	}
	
	public function usr_sucprjt($uid) {
		$this->query("select * from project where userid='$uid' and contribute_amount>=goal");
		$suc_usrprjts = $this->rowCount();
		return $suc_usrprjts;
	}
	
	public function usr_unsucprjt($uid,$tday) {
		$this->query("select * from project where userid='$uid' and contribute_amount < goal and deadline < '$tday'");
		$unsuc_usrprjts = $this->rowCount();
		return $unsuc_usrprjts;
	}
	
	public function usr_comprjt($uid,$tday) {
		$this->query("select * from project where userid='$uid' and deadline < '$tday'");
		$comp_usrprjts = $this->rowCount();
		return $comp_usrprjts;
	}
	
	public function tot_investors($prjtid) {
		$this->query("select distinct user_id from contribute where prjt_id='$prjtid' and pay_status='1'");
		$investors = $this->rowCount();
		return $investors;
	}
	
	public function my_invest($uid) {
		$this->query("select distinct prjt_id from contribute where user_id='$uid' and pay_status='1'");
		$my_invest = $this->rowCount();
		return $my_invest;
	}
	
	public function usr_flwprjt($uid) {
		$this->query("select * from follow where user_id='$uid'");
		$flw_usrprjts = $this->rowCount();
		return $flw_usrprjts;
	}
	
	public function mycamp_investors($uid) {
		$this->query("select distinct c.prjt_id from contribute c inner join project p on p.userid='$uid' and p.id=c.prjt_id and c.pay_status='1'");
		$investors = $this->rowCount();
		return $investors;
	}
	
	public function followers($prjtid) {
		$this->query("select * from follow where prjt_id='$prjtid'");
		$followers = $this->rowCount();
		return $followers;
	}
	
	public function my_prjt_flwrs($uid) {
		$this->query("select p.id,f.user_id from project p inner join follow f on f.prjt_id=p.id and p.userid='$uid'");
		$flw_usrs = $this->rowCount();
		return $flw_usrs;
	}
	
	public function prjt_under_cat($catid) {
		$this->query("select * from project where category='$catid'");
		$prjt_ct = $this->rowCount();
		return $prjt_ct;
	}
	
	/** delete project **/
	public function delProject($id){
		$this->query("select img1,img2,img3,img4,doc,video from project where id=:id");
		$this->bind(":id", $id);
		$result = $this->fetch();
		$img1 = $result['img1'];
		$img2 = $result['img2'];
		$img3 = $result['img3'];
		$img4 = $result['img4'];
		$doc = $result['doc'];
		$video = $result['video'];
		if(($img1!="") && ($img1!="noimage.jpg") && file_exists('uploads/prjt-img/img1/'.$img1)) unlink('uploads/prjt-img/img1/'.$img1);
		if(($img2!="") && file_exists('uploads/prjt-img/img2/'.$img2)) unlink('uploads/prjt-img/img2/'.$img2);
		if(($img3!="") && file_exists('uploads/prjt-img/img3/'.$img3)) unlink('uploads/prjt-img/img3/'.$img3);
		if(($img4!="") && file_exists('uploads/prjt-img/img4/'.$img4)) unlink('uploads/prjt-img/img4/'.$img4);
		if(($doc!="") && file_exists('uploads/documents/'.$doc)) unlink('uploads/documents/'.$doc);
		if(($video!="") && file_exists('uploads/video/'.$video)) unlink('uploads/video/'.$video);
	}
	
	/** delete user **/
	public function delUser($id){
		$this->query("select id from project where userid='$id'");
		$usr_prjt_ct = $this->rowCount();
		if($usr_prjt_ct > 0) {
			$getids = $this->fetchAll();
			foreach($getids as $getid):
			$this->query("select img1,img2,img3,img4,doc,video from project where id=:id");
			$this->bind(":id", $getid['id']);
			$result = $this->fetch();
			$img1 = $result['img1'];
			$img2 = $result['img2'];
			$img3 = $result['img3'];
			$img4 = $result['img4'];
			$doc = $result['doc'];
			$video = $result['video'];
			if(($img1!="") && ($img1!="noimage.jpg") && file_exists('uploads/prjt-img/img1/'.$img1)) unlink('uploads/prjt-img/img1/'.$img1);
			if(($img2!="") && file_exists('uploads/prjt-img/img2/'.$img2)) unlink('uploads/prjt-img/img2/'.$img2);
			if(($img3!="") && file_exists('uploads/prjt-img/img3/'.$img3)) unlink('uploads/prjt-img/img3/'.$img3);
			if(($img4!="") && file_exists('uploads/prjt-img/img4/'.$img4)) unlink('uploads/prjt-img/img4/'.$img4);
			if(($doc!="") && file_exists('uploads/documents/'.$doc)) unlink('uploads/documents/'.$doc);
			if(($video!="") && file_exists('uploads/video/'.$video)) unlink('uploads/video/'.$video);
			$this->query("delete from project where id='".$getid['id']."'");
			$this->execute();
			endforeach;
		}
		$this->query("select profile_image from register where id=:uid");
		$this->bind(":uid", $id);
		$result = $this->fetch();
		$usrimg = $result['profile_image'];
		if(($usrimg!="") && ($usrimg!="emptyimg.png") && file_exists('uploads/user-profile/'.$usrimg)) unlink('uploads/user-profile/'.$usrimg);
		
		$this->query("delete from testimonial where user_id='$id'");
		$this->execute();
		$this->query("delete from follow where user_id='$id'");
		$this->execute();
		$this->query("delete from enquiry where user_id='$id'");
		$this->execute();
	}
}
?>