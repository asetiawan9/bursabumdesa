<?php
class user extends database {
	
	/** password hasing **/
	public function pass_hash($pass) {
		return md5($pass);
		/* $options = array(
			'cost' => 11,
			'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
		);
		$hash=password_hash($pass, PASSWORD_BCRYPT, $options);
		return $hash; */
	}
	
	/** verify password hash **/
	public function pass_vfy($pass, $hash) {
		if($hash==md5($pass))
			return true;
		else
			return false;
		/* if(password_verify($pass, $hash))
			return true;
		else
			return false; */
	}
	
	public function browserName($ua) {
		//$brsr=get_browser($ua, true);
		//return $brsr['browser'];
		return "Chrome";
	}
	
	public function isLoggedAdmin() {
		if(isset($_SESSION['isLgd']) && $_SESSION['isLgd']==true) return true;
		else return false;
	}
	
	public function loggedStaffinfo() {
		$lgdEmp=base64_decode($_SESSION['lgdEmp']);
		$this->LoggedUser=$lgdEmp;
		if($lgdEmp=="0") {
			$this->Name="Admin";
			$this->canAccess="all";
		}
		else {
			$this->query("select a.name,b.can_access from staff as a inner join staff_roles as b on a.role=b.id where a.id='$lgdEmp'");
			$result=$this->fetch();
			$this->Name=$result['name'];
			$can_access=json_decode($result['can_access'],true);
			$this->canAccess=$can_access;
		}
	}
	
}
?>