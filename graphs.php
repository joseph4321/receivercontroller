<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/222/inc/config.inc.php"); ?>
<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/222/inc/functions.inc.php"); ?>
<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/222/class/MulticastReceiver.class.php"); ?>

<HTML>

<HEAD>
<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/222/inc/head.inc.php"); ?>

<META HTTP-EQUIV="pragma" CONTENT="no-cache">

<SCRIPT TYPE="text/javascript">
var type = 0;
function changeGraph(id,r){
	var v = document.getElementById("receivers").options[document.getElementById('receivers').selectedIndex].value;
	
	//special case
	if(v == "Average"){
		document.getElementById("info").innerHTML="<CENTER><SPAN STYLE=\"font-size:16px\"><B>Average signal strength</B><BR><BR><IMG SRC=\"graphimage.php?r=all&g="+type+"\"></SPAN>";
		return;
	}

	// everything else
	var tokens = v.split(":");
	tokens[1] = tokens[1].substring(0,1);
	document.getElementById("info").innerHTML="<CENTER><SPAN STYLE=\"font-size:16px\"><B>"+tokens[0]+" tuner "+tokens[1] +"</B><BR><BR><IMG SRC=\"graphimage.php?r=" + tokens[0] + "&t=" + tokens[1]+"&g="+type+"\" ALT=\"Graph for "+tokens[0]+" tuner "+tokens[1]+"\"></SPAN>";

	var tmp = document.getElementById("receivers").options;
	for(var i=0;i<tmp.length;i++){
		if(tmp[i].value == v){
		}
	}
	
}
function changeGraphTime(){
	var tmp=document.getElementById("timeFrame").value;
	if(tmp == "24 hours"){type=1;}
	else if(tmp == "7 days"){type=2;}
	else if(tmp == "Month"){type=3;}
	else if(tmp == "Year"){type=4;}
	else{type=0;}
	changeGraph("","");
}
function goLeft(){
	var tmp = document.getElementById("receivers").options;
	var previous;
	var cur = document.getElementById("receivers").options[document.getElementById('receivers').selectedIndex].value;
	
	//special cases;
	if(cur == tmp[0].value){return;}
	if(cur == tmp[1].value){
		document.getElementById("receivers").options[0].selected="selected";
		document.getElementById("info").innerHTML="<CENTER><SPAN STYLE=\"font-size:16px\"><B>Average signal strength</B><BR><BR><IMG SRC=\"graphimage.php?r=all&g="+type+"\" ALT=\"Graph for average signal strength\"></SPAN>";
		return;
	}
		
	// all other cases
	var i=0
	for(;i<tmp.length;i++){
		if(i==0){}
		else{previous = tmp[i-1].value};
		if(tmp[i].value==cur){
			break;
		}
	}
	if(previous == null){return;}
	var tokens = previous.split(":");
	tokens[1] = tokens[1].substring(0,1);
	document.getElementById("receivers").options[--i].selected="selected";
	document.getElementById("info").innerHTML="<CENTER><SPAN STYLE=\"font-size:16px\"><B>"+tokens[0]+" tuner "+tokens[1] +"</B><BR><BR><IMG SRC=\"graphimage.php?r=" + tokens[0] + "&t=" + tokens[1]+"&g="+type+"\" ALT=\"Graph for "+tokens[0]+" tuner "+tokens[1]+"\"></SPAN>";
}
function goRight(){
        var tmp = document.getElementById("receivers").options;
        var next;
	var cur = document.getElementById("receivers").options[document.getElementById('receivers').selectedIndex].value;

        //special cases;
        if(cur == tmp[tmp.length-1].value){return;}

        // all other cases
        var i=0
        for(;i<tmp.length;i++){
                if(i>=tmp.length-1){}
                else{next = tmp[i+1].value;}
                if(tmp[i].value==cur){
                        break;
                }
        }

        if(next == null){return;}
        var tokens = next.split(":");
        tokens[1] = tokens[1].substring(0,1);
        document.getElementById("receivers").options[++i].selected="selected";
        document.getElementById("info").innerHTML="<CENTER><SPAN STYLE=\"font-size:16px\"><B>"+tokens[0]+" tuner "+tokens[1] +"</B><BR><BR><IMG SRC=\"graphimage.php?r=" + tokens[0] + "&t=" + tokens[1]+"&g="+type+"\" ALT=\"Graph for "+tokens[0]+" tuner "+tokens[1]+"\"></SPAN>";

	
}
function setOption(){
document.getElementById("receivers").options[0].selected = "selected";
document.getElementById("timeFrame").options[0].selected = "selected";
}
</SCRIPT>
</HEAD>

<TITLE>
<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/222/inc/title.inc.php"); ?>
</TITLE>

<BODY ID="body" onLoad="setOption()">
<TABLE WIDTH="550px" ALIGN="CENTER"><TR><TD WIDTH="5%" VALIGN="MIDDLE" ALIGN="CENTER"><IMG SRC="images/arrow-left.png" onClick="goLeft()"></TD>
<TD WIDTH="90%" ALIGN="CENTER"><SPAN ID="info" STYLE="font-size:16px"><B>Average signal strength</B><BR><BR><IMG SRC="graphimage.php?r=all&g=0&t=0"></SPAN></TD>
<TD WIDTH="5%" VALIGN="MIDDLE" ALIGN="CENTER"><IMG SRC="images/arrow-right.png" onClick="goRight()"></TD>
</TR></TABLE></CENTER><BR>

<?php
$cur = getAllReceivers();

$receivers = array();
$tuners = array();
$callLetters = array();
$i=0;
do{
	$ip = $cur->getIP(); $tuner = $cur->getTuner();
	if(verifyIPAddress($ip) && verifyTuner($tuner)){
		$receivers[$i] = $ip;
		$tuners[$i] = $tuner;
		$callLetters[$i] = $cur->getChannelName();
		
	}
	$cur = $cur->getNextMulticastReceiver(); $i++;
}while($cur != null);
	

print "<CENTER>View info for a receiver (ip:tuner) ";
print "<SELECT NAME=\"receivers\" ID=\"receivers\" onChange=\"changeGraph('this','r')\"><OPTION SELECTED VALUE=\"Average\">Average</OPTION>";
for($i=0;$i<count($receivers);$i++){
	print "<OPTION VALUE=\"" . $receivers[$i] . ":" . $tuners[$i] . " (" . $callLetters[$i] . ")\">" . $receivers[$i] . ":" . $tuners[$i] . " (" . $callLetters[$i] . ")</OPTION>";
}
print "</SELECT><BR>\n";

print "View info for this timeframe: ";
print "<SELECT NAME=\"timeFrame\" ID=\"timeFrame\" onChange=\"changeGraphTime()\"><OPTION SELECTED VALUE=\"12 hours\">12 hours</OPTION><OPTION VALUE=\"24 hours\">24 hours</OPTION><OPTION VALUE=\"7 days\">7 days</OPTION><OPTION VALUE=\"Month\">Month</OPTION><OPTION VALUE=\"Year\">Year</OPTION>\n";
print "</SELECT><BR>\n";

print "</CENTER>\n"

?>

<BR><BR><BR><BR><BR><BR>


</BODY>
<SCRIPT TYPE="text/javascript">
</SCRIPT>
</HTML>
