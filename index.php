<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/222/inc/config.inc.php"); ?>
<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/222/inc/functions.inc.php"); ?>
<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/222/class/MulticastReceiver.class.php"); ?>

<HTML>

<HEAD>
<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/222/inc/head.inc.php"); ?>
<SCRIPT TYPE="text/javascript">
</SCRIPT>
</HEAD>

<TITLE>
<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/222/inc/title.inc.php"); ?>
</TITLE>

<BODY ID="body">

<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/222/inc/logo.inc.php"); ?>

<BR><BR>

<TABLE WIDTH="50%" ALIGN="CENTER">
<TR><TD COLSPAN=6 ALIGN="LEFT"><SPAN STYLE="font-size:10px;color:gray;">* Click on a stream to get more info
</SPAN></TD></TR>
</TABLE>

<TABLE CLASS="sortable" WIDTH="50%" ALIGN="CENTER" STYLE="font-size:12px;border-style:solid;border-width:1px;border-color:black">
<?php

print "\t\t<TR STYLE=\"font-weight:bold\">\n";
$columnHeaders = array("Status","Channel","IP","Multicast","Tuner","Actions");
for($i=0;$i<count($columnHeaders);$i++){
	print "<TH WIDTH=\"20%\">".$columnHeaders[$i]."</TH>";

}
print "\t\t</TR>\n";

$cur = getAllReceivers();
$i=0;
do{	
	if($cur->getSignalStrength() <= 20){
		print "\t\t<TR BGCOLOR=\"yellow\" onmouseover='this.style.backgroundColor=\"bcbcbc\"' onmouseout='this.style.backgroundColor=\"yellow\"'>\n";
	}
	else{
		print "\t\t<TR BGCOLOR=\"white\" onmouseover='this.style.backgroundColor=\"bcbcbc\"' onmouseout='this.style.backgroundColor=\"FFFFFF\"'>\n";
	}
	print "\t\t\t<TD ALIGN=\"CENTER\" onClick='ShowContent(\"box_".$i."\")'><IMG SRC=\"images/status_" . (($cur->isStreaming()) ? "green.png":"red.png") . "\"></TD>\n";
	print "\t\t\t<TD ALIGN=\"CENTER\" onClick='ShowContent(\"box_".$i."\")'>" . $cur->getChannelName() . "</TD>\n";
	print "\t\t\t<TD ALIGN=\"CENTER\" onClick='ShowContent(\"box_".$i."\")'>" . $cur->getIP() . "</TD>\n";
	print "\t\t\t<TD ALIGN=\"CENTER\" onClick='ShowContent(\"box_".$i."\")'>" . $cur->getMulticast() . "</TD>\n";
	print "\t\t\t<TD ALIGN=\"CENTER\" onClick='ShowContent(\"box_".$i."\")'>" . $cur->getTuner() . "</TD>\n";
	
	// actions
	print "\t\t\t<TD ALIGN=\"CENTER\"><SPAN ID=\"actions_".$i."\"><IMG SRC=\"images/ping1.png\" ALT=\"Ping\" TITLE=\"Ping\" WIDTH=\"20px\" HEIGHT=\"20px\" onClick=\"receiverAction('actions_".$i."','ping','".$cur->getIP()."','".$cur->getTuner()."','".$cur->getMulticast()."')\">&nbsp;&nbsp;";
	print "<IMG SRC=\"images/restartstream.png\" ALT=\"Restart stream\" TITLE=\"Restart stream\" WIDTH=\"20px\" HEIGHT=\"20px\" onClick=\"receiverAction('actions_".$i."','restart','".$i."','0','0')\">&nbsp;&nbsp;";
	print "<IMG SRC=\"images/reboot.png\" ALT=\"Reboot receiver\" TITLE=\"Reboot receiver\" WIDTH=\"20px\" HEIGHT=\"20px\" onClick=\"receiverAction('actions_".$i."','reboot','".$cur->getIP()."','".$cur->getTuner()."','".$cur->getMulticast()."')\"></SPAN></TD>\n";
	print "\t\t</TR>\n";
	
	// DIV for the onclick popup
	print "\t\t<DIV ID=\"box_".$i."\" STYLE=\"line-height:200%;font-size:12px;display:none;position:absolute;border-style:solid;background-color:white;padding:4px;\" onClick='HideContent(\"box_".$i."\")'>\n";
	print "\t\tLast Checked: <I>" . $cur->getLastChecked() . "</I><BR>\n";
	print "\t\tStatus: <I>" . (($cur->isStreaming()) ? "Streaming":"Not Streaming") . "</I><BR>\n";
	print "\t\tUptime: <I>" . $cur->getUptime() . "</I><BR>\n";
	print "\t\tChannel: <I>" . $cur->getChannel() . "</I><BR>\n";
	print "\t\tChannel Name: <I>" . $cur->getChannelName() . "</I><BR>\n";
	print "\t\tSignal Strength: <I>" . $cur->getSignalStrength() . "</I><BR>\n";
	print "\t\tIP Address: <I>" . $cur->getIP() . "</I><BR>\n";
	print "\t\tMAC Address: <I>" . $cur->getMacAddress() . "</I><BR>\n";
	print "\t\tMulticast: <I>" . $cur->getMulticast() . "</I><BR>\n";
	print "\t\tPort: <I>" . $cur->getPort() . "</I><BR>\n";
	print "\t\tTuner: <I>" . $cur->getTuner() . "</I><BR>\n";
	print "\t\tReceiver ID: <I>" . $cur->getReceiverID() . "</I><BR>\n";
	print "\t\tSmart Card ID: <I>" . $cur->getSmartCardID() . "</I><BR>\n";
	print "\t\t</DIV>";


	$cur = $cur->getNextMulticastReceiver(); $i++;	
}while($cur != null);

?>

</TABLE>
<BR>
<CENTER>
<?php
$psList=`ps aux|grep psFloodgate|grep -v grep`;
if(preg_match("/\.\/psFloodgate\.pl/",$psList)){
        print "<SPAN STYLE=\"color:green;\">psFloodgate is running</SPAN>";
}
else{
        print "<SPAN STYLE=\"color:red;align:right;\">WARNING: psFloodgate is not running</SPAN>";
}
?>
</CENTER>

<BR>

<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/222/inc/navigation.inc.php"); ?>


</BODY>
</HTML>
