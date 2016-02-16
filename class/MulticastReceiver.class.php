<?php


class MulticastReceiver{

	public $ip = "0.0.0.0";
	public $channel = "0";
	public $port = "0";
	public $multicast = "0.0.0.0";
	public $isStreaming = 0;
	public $tuner = 0;
	public $nextMulticastReceiver = null;
	public $channelName = "";
	public $channelDescription = "";
	public $signalStrength = 0;
	public $lastChecked = "";
	public $uptime = "";
	public $receiverID = "";
	public $smartCardID = "";
	public $macAddress = "";
	
	function MulticastReceiver(){}

	function setIP($i){$this->ip = $i;}
	function setChannel($c){$this->channel=$c;}
	function setPort($c){$this->port=$c;}
	function setMulticast($c){$this->multicast=$c;}
	function setIsStreaming($c){$this->isStreaming=$c;}
	function setNextMulticastReceiver($r){$this->nextMulticastReceiver=$r;}
	function setTuner($t){$this->tuner = $t;}
	function setChannelName($c){$this->channelName = $c;}
	function setChannelDescription($c){$this->channelDescription = $c;}
	function setSignalStrength($c){$this->signalStrength = $c;}
	function setLastChecked($c){$this->lastChecked = $c;}
	function setUptime($c){$this->uptime = $c;}
	function setReceiverID($c){$this->receiverID = $c;}
	function setSmartCardID($c){$this->smartCardID = $c;}
	function setMacAddress($m){$this->macAddress = $m;}
	
	function getIP(){return $this->ip;}
	function getChannel(){return $this->channel;}
	function getPort(){return $this->port;}
	function getMulticast(){return $this->multicast;}
	function isStreaming(){return $this->isStreaming;}
	function getNextMulticastReceiver(){return $this->nextMulticastReceiver;}
	function getTuner(){return $this->tuner;}
	function getChannelName(){return $this->channelName;}
	function getSignalStrength(){return $this->signalStrength;}
	function getChannelDescription(){return $this->channelDescription;}
	function getLastChecked(){return $this->lastChecked;}
	function getUptime(){return $this->uptime;}
	function getReceiverID(){return $this->receiverID;}
	function getSmartCardID(){return $this->smartCardID;}
	function getMacAddress(){return $this->macAddress;}
	function getFormattedString(){
		$s = $this->ip;
		$s .= "," . $this->tuner;
		$s .= "," . $this->isStreaming;
		$s .= "," . $this->channelName;
		$s .= "," . $this->signalStrength;
		$s .= "," . $this->channel;
		$s .= "," . $this->multicast;
		$s .= "," . $this->port;
		$s .= "," . $this->uptime;
		$s .= "," . $this->lastChecked;
		$s .= "," . $this->macAddress;
		$s .= "," . $this->receiverID;
		$s .= "," . $this->smartCardID;
		return $s;
	}

}


?>
