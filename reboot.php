<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/222/inc/config.inc.php"); ?>
<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/222/inc/functions.inc.php"); ?>
<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/222/class/MulticastReceiver.class.php"); ?>
<?php

$receiver = $_GET["r"];
$tuner = $_GET["t"];

if(!verifyIPAddress($receiver)){print "The ip address format is incorrect";exit;}
if(!verifyTuner($tuner)){print "Could not find the tuner for this receiver";exit;}

$result = exec("\"" . $SOAP_DIR . "reboot.pl\" " . $receiver);

if(preg_match("/Receiver is rebooting/",$result)){
	print "Receiver is rebooting.  Please allow 10 minutes for the receiver to come back online.";
}
else{
	print "There was an error rebooting the receiver.";
}

$r1 = new MulticastReceiver();
$r2 = new MulticastReceiver();

if(($r1 = findMulticastReceiver($receiver,$tuner)) == null){exit;}

if($r1->getTuner()==1){$r2 = findMulticastReceiver($receiver,0);}
else{ $r2 = findMulticastReceiver($receiver,1); }

if($r1 != null){ $r1->setIsStreaming(0);logStatus($r1); }
if($r2 != null){ $r2->setIsStreaming(0);logStatus($r2); }

?>