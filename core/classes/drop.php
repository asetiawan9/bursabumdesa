<?php
class drop extends database {
	
	/** selectbox with query-custom-country **/
	public function dropselectCountry($query, $chkFor) {
		$disp="<option value=''>Choose Country</option>";
		$this->query($query);
		$result=$this->fetchAll(true);
		for($i=0;$i<count($result);$i++) {
			$value=$result[$i][0];
			$name=$result[$i][1];
			if($value==$chkFor) $ch="selected";
			else $ch="";
			$disp.="<option value='$value' $ch>$name</option>";
		}
		return $disp;
	}
	/** selectbox with query-custom-state **/
	public function dropselectState($query, $chkFor) {
		$disp="<option value=''>Choose State</option>";
		$this->query($query);
		$result=$this->fetchAll(true);
		for($i=0;$i<count($result);$i++) {
			$value=$result[$i][0];
			$name=$result[$i][1];
			if($value==$chkFor) $ch="selected";
			else $ch="";
			$disp.="<option value='$value' $ch>$name</option>";
		}
		return $disp;
	}
	/** selectbox with query-custom-city **/
	public function dropselectCity($query, $chkFor) {
		$disp="<option value=''>Choose City</option>";
		$this->query($query);
		$result=$this->fetchAll(true);
		for($i=0;$i<count($result);$i++) {
			$value=$result[$i][0];
			$name=$result[$i][1];
			if($value==$chkFor) $ch="selected";
			else $ch="";
			$disp.="<option value='$value' $ch>$name</option>";
		}
		return $disp;
	}
	/** selectbox with query-custom-vendor **/
	public function dropselectVendor($query, $chkFor) {
		$disp="<option value=''>Choose Vendor</option>";
		$this->query($query);
		$result=$this->fetchAll(true);
		for($i=0;$i<count($result);$i++) {
			$value=$result[$i][0];
			$name=$result[$i][1];
			if($value==$chkFor) $ch="selected";
			else $ch="";
			$disp.="<option value='$value' $ch>$name</option>";
		}
		return $disp;
	}
	
	/** selectbox with single select **/
	public function dropselectSingle($query, $chkFor) {
		$this->query($query);
		$result=$this->fetchAll(true);
		$disp = '';
		for($i=0;$i<count($result);$i++) {
			$value=$result[$i][0];
			$name=$result[$i][1];
			if($value==$chkFor) $ch="selected";
			else $ch="";
			$disp.="<option value='$value' $ch>$name</option>";
		}
		return $disp;
	}
	
	/** selectbox without query **/
	public function dropselectArr($array, $chkFor) {
		$disp="<option value=''>Choose</option>";
		for($i=0;$i<count($array);$i++) {
			$value=$array[$i][0];
			$name=$array[$i][1];
			if($value==$chkFor) $ch="selected";
			else $ch="";
			$disp.="<option value='$value' $ch>$name</option>";
		}
		return $disp;
	}
	
	/** selectbox multiple with query **/
	public function dropmultiple($query, $chkFor) {
		$chkFor=explode(",", $chkFor);
		$disp="<option value=''>Choose</option>";
		$this->query($query);
		$result=$this->fetchAll(true);
		for($i=0;$i<count($result);$i++) {
			$value=$result[$i][0];
			$name=$result[$i][1];
			for($j=0;$j<count($chkFor);$i++) {
				if($value==$chkFor[$j]) { $ch="selected"; break; }
				else $ch="";
			}
			$disp.="<option value='$value' $ch>$name</option>";
		}
		return $disp;
	}
	
	/** selectbox multiple without query **/
	public function dropmultipleArr($array, $chkFor) {
		$chkFor=explode(",", $chkFor);
		$disp="<option value=''>Choose</option>";
		for($i=0;$i<count($array);$i++) {
			$value=$array[$i][0];
			$name=$array[$i][1];
			for($j=0;$j<count($chkFor);$i++) {
				if($value==$chkFor[$j]) { $ch="selected"; break; }
				else $ch="";
			}
			$disp.="<option value='$value' $ch>$name</option>";
		}
		return $disp;
	}
	
}
?>