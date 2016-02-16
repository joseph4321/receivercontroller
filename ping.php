<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/222/inc/config.inc.php"); ?>
<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/222/inc/functions.inc.php"); ?>
<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/222/class/MulticastReceiver.class.php"); ?>
<?php

$receiver = $_GET["r"];

if(!verifyIPAddress($receiver)){print "The ip address format is incorrect";exit;}

$result = system("ping -c 4 " . $receiver);

?>
