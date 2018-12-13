<?php
require "core/init.php";

function invest_payout() {
	Global $db;
	$db->query("select id from register where active_status='1'");
	$getUsers = $db->fetchAll();
	foreach($getUsers as $getUser):
		$usrid = $getUser['id'];
		$db->query("select id from contribute where user_id='$usrid' and pay_status='1'");
		$result = $db->fetchAll();
		foreach($result as $row):
			$cntid = $row['id'];
			camp_payout($cntid);
		endforeach;
	endforeach;		
}

function camp_payout($cntid) {
	Global $db;
	$db->query("select prjt_id,contribute_amount,date from contribute where id='$cntid'");
	$invdet = $db->fetch();
	$prjtid = $invdet['prjt_id'];
	$invamt = $invdet['contribute_amount'];
	$ctn_dt = $invdet['date'];
	$db->query("select * from project where id='$prjtid' and contribute_amount>=goal");
	$suc_prjtct = $db->rowCount();
	if($suc_prjtct > 0) {
		$result = $db->fetch();
		$repay_period = $result['repay_period'];
		$repay_duration = $result['repay_duration'];
		$hold_period = $result['hold_period'];
		if($result['repay_duration'] == 0) $repay_dur = 'days';
		else $repay_dur = 'year';
		if($result['hold_duration'] == 0) $hold_dur = 'days';
		else $hold_dur = 'year';
		$deadline = $result['deadline'];
		$ret_perct = $result['returns'];			
		$end_hold_period = strtotime(date("Y-m-d", strtotime($deadline))." +$hold_period $hold_dur");
		$end_hold_period = date('Y-m-d', $end_hold_period);
		$return_comm = round($invamt*($ret_perct/100),4);
		
		$now_date = date('Y-m-d');
		if(($result["hold_period"] == $result["repay_period"]) && ($result["repay_duration"] == $result["hold_duration"])) {
			$completed_dt = date('Y-m-d',strtotime($end_hold_period . "+$repay_period $repay_dur"));
			$completed_dt = date('Y-m-d', $completed_dt);
			if($now_date == $completed_dt) {
				$db->query("select * from transaction where contribute_id='$cntid'");
				$trans_ct = $db->rowCount();
				if($trans_ct == 0) {
					$set="contribute_id='$cntid'";
					$set.=",return_amt='$return_comm'";
					$que = "insert into transaction set $set";
					$db->query($que);
					$db->execute();
				}
			}
		}
		else if($now_date <= $end_hold_period) {
			$db->query("select * from transaction where contribute_id='$cntid'");
			$trans_ct = $db->rowCount();
			if($trans_ct == 0) {
				$payout_first = strtotime(date("Y-m-d", strtotime($deadline))." +$repay_period $repay_dur");
				$payout_first = date('Y-m-d', $payout_first);
				if(($now_date >= $payout_first) && ($payout_first <= $end_hold_period)) {
					$set="contribute_id='$cntid'";
					$set.=",return_amt='$return_comm'";
					$set.=",trans_dt='$now_date'";
					$que = "insert into transaction set $set";
					$db->query($que);
					$db->execute();
				}
			}
			else if($trans_ct > 0) {
				$last_payout = $db->extractCol("select trans_dt from transaction where contribute_id='$cntid' order by trans_dt desc limit 1");
				if($last_payout != $now_date) {
					$payout_repeat = strtotime(date("Y-m-d", strtotime($last_payout))." +$repay_period $repay_dur");
					$payout_repeat = date('Y-m-d', $payout_repeat);
					if(($now_date >= $payout_repeat) && ($payout_repeat <= $end_hold_period)) {
						$set="contribute_id='$cntid'";
						$set.=",return_amt='$return_comm'";
						$set.=",trans_dt='$now_date'";
						$que = "insert into transaction set $set";
						$db->query($que);
						$db->execute();
					}
				}
			}
		}				
	}
}

invest_payout();
?>