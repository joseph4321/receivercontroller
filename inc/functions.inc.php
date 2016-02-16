<?php 

include_once($_SERVER["DOCUMENT_ROOT"] . "/222/inc/config.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/222/class/MulticastReceiver.class.php");


function readConfig(){
}

function verifyIPAddress($ip){
	if(preg_match("/^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/",$ip)){return 1;}
	else{return 0;}
}

function verifyTuner($t){
	if($t == 1 || $t == 0 || $t == 2){return 1;}
	return 0;
}

function getAllReceivers(){
	global $CONFIG_FILE,$STATUS_FILE;
	
	$lines = file($STATUS_FILE);
	
	$first = null;
	$cur = new MulticastReceiver();
	$next = new MulticastReceiver();
	for($i=0;$i<count($lines);$i++){
		list($ip,$tuner,$status,$channelCallLetters,$signalStrength,$channel,$multicast,$port,$uptime,$lastChecked,$mac,$rid,$smart) = explode(",",$lines[$i]);

		$next = new MulticastReceiver();
		$next->setChannel($channel);
		$next->setIP($ip);
		$next->setMulticast($multicast);
		$next->setPort(chop($port));
		$next->setTuner($tuner);
		$next->setIsStreaming($status);
		$next->setChannelName($channelCallLetters);
		$next->setSignalStrength($signalStrength);
		$next->setLastChecked($lastChecked);
		$next->setUptime($uptime);
		$next->setMacAddress($mac);
		$next->setReceiverID($rid);
		$next->setSmartCardID($smart);
		if($i == 0){ $first = $next; $cur = $next;}
		else{ $cur->setNextMulticastReceiver($next); $cur=$next; }
	}
	return $first;
}

function findMulticastReceiver($ip,$tuner){
	$cur = getAllReceivers();
	do{
		if($cur->getIP() == $ip && $cur->getTuner() == $tuner){ return $cur;}
		else{}
		$cur = $cur->getNextMulticastReceiver();
	}while($cur != null);
	
	return null;
}


function logStatus($r){
	global $STATUS_FILE;
	
	if($r==null){return;}
	
	$cur = getAllReceivers();
	$first = $cur;
	do{
		if(($cur->getIP() == $r->getIP()) && ($cur->getTuner() == $r->getTuner())){
			$cur->setChannel($r->getChannel());
			$cur->setIsStreaming($r->isStreaming());
			$cur->setPort($r->getPort());
			$cur->setMulticast($r->getMulticast());
			$cur->setChannelName($r->getChannelName());
			$cur->setSignalStrength($r->getSignalStrength());
			$cur->setLastChecked($r->getLastChecked());
			$cur->setUptime($r->getUptime());
			$cur->setMacAddress($r->getMacAddress());
			$cur->setReceiverID($r->getReceiverID());
			$cur->setSmartCardID($r->getSmartCardID());
			break;
		}
		$cur = $cur->getNextMulticastReceiver();
	}while($cur != null);
	
	$cur = $first;
	$fileHandle = fopen($STATUS_FILE,'w');
	do{
		fwrite($fileHandle,$cur->getFormattedString());
		$cur = $cur->getNextMulticastReceiver();
	}while($cur != null);
}
?>
