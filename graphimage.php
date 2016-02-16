<?php
include_once("inc/config.inc.php");
include_once("inc/functions.inc.php");

$ip = $_GET["r"];
$tuner = $_GET["t"];
$type = $_GET["g"];

$file = $SOAP_DIR . $ip . "-" . $tuner . "-" . $type . ".png";
if(file_exists($file) && verifyIPAddress($ip) && verifyTuner($tuner) && $type >=0 && $type <=4){
	header("Content-Type: image/png");
	readfile($file);
}
else if($ip == "all" && $tuner <= 4 && $tuner >= 0){
	header("Content-Type: image/png");
	readfile($SOAP_DIR . "total-".$type.".png");
}
else{exit;}
?>
