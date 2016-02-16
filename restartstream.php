<?php 

include_once($_SERVER["DOCUMENT_ROOT"] . "/222/inc/config.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/222/inc/functions.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/222/class/MulticastReceiver.class.php");

$receiver = $_GET["i"];

if($receiver < 0|| $receiver > 1000){print "Could not find the receiver";exit;}
$obj = getAllReceivers();
$i = 0;
do{
	if($i == $receiver){break;}
	$obj = $obj->getNextMulticastReceiver(); $i++;
}while($obj != null);

$ip = $obj->getIP();
$tmpTuner = $obj->getTuner();$tmpTuner++;$tmpTuner1=$obj->getTuner();
$wake = exec("\"" . $SOAP_DIR . "wakeup.pl\" " . $obj->getIP() . " " . $obj->getTuner());
$channel = exec("\"" . $SOAP_DIR . "setChannel.pl\" " . $obj->getIP() . " " . $obj->getChannel() . " " . $obj->getTuner());sleep(5);
$r = exec("cat /home/tg/soap/config.txt|grep $ip|awk -F \",\" '{if(\$4==$tmpTuner1 && \$6==1) print \"hd\"}'");
if(preg_match("/hd/",$r)){
	$r = exec("\"" . $SOAP_DIR . "increaseChannel.pl\" " . $obj->getIP() . " " . $obj->getTuner());sleep(5);
}
if(preg_match("/Channel set successfully/",$channel)){"Channel set successfully\n";}
else{print "There was an error setting the channel";exit;}
$result = exec("\"" . $SOAP_DIR . "rtsp.pl\" " . $obj->getIP() . " " . $obj->getMulticast() . " " . $tmpTuner);


if(preg_match("/RTSP\/1\.0 200 OK/",$result)){
	$r1 = new MulticastReceiver();
	$r2 = new MulticastReceiver();
	if(($r1 = findMulticastReceiver($obj->getIP(),$obj->getTuner())) == null){exit;}
	if($r1->getTuner()==1){$r2 = findMulticastReceiver($obj->getIP(),0);}
	else{ $r2 = findMulticastReceiver($obj->getIP(),1); }
	if($r1 != null && $r1->getTuner() == $obj->getTuner()){ $r1->setIsStreaming(1);logStatus($r1); }
	if($r2 != null && $r2->getTuner() == $obj->getTuner()){ $r2->setIsStreaming(1);logStatus($r2); }
	print "Stream was successfully restarted.";
}
else{
	$r1 = new MulticastReceiver();
	if(($r1 = findMulticastReceiver($obj->getIP(),$obj->getTuner())) == null){exit;}
	if($r1 != null && $r1->getTuner() == $obj->getTuner()){ $r1->setIsStreaming(0);logStatus($r1); }
	print "There was an error restarting the stream:\n$result";
}

?>
