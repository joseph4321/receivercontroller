var xmlhttp;
function receiverAction(id,action,r,t,m){
if(window.XMLHttpRequest){xmlhttp = new XMLHttpRequest();}
else{xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");}
if(action == "restart"){xmlhttp.open("GET","restartstream.php?i="+r,true);}
else if (action == "reboot"){
	var answer = confirm("Are you sure you want to reboot this receiver?");
	if(answer){xmlhttp.open("GET","reboot.php?r="+r+"&t="+t,true);}
}
else if (action == "ping"){xmlhttp.open("GET","ping.php?r="+r,true);}
//alert("post 1");
xmlhttp.onreadystatechange=processRequest;
xmlhttp.send(null);
document.getElementById(id).innerHTML = "<IMG SRC=\"images/loading1.gif\" ALT=\"Loading...\" WIDTH=\"22px\" HEIGHT=\"22px\">";
document.getElementById('body').style.cursor = "wait";
}

function processRequest(){
	if(xmlhttp.readyState==4){
		alert(xmlhttp.responseText);
		//location.href="http://localhost/222/index.php";
		location.href="index.php";
	}
	//alert(xmlhttp.status);
}
//xmlhttp.send();
//var result = xmlhttp.responseXML;


var cX = 0; var cY = 0; var rX = 0; var rY = 0;
function UpdateCursorPosition(e){ cX = e.pageX; cY = e.pageY;}
function UpdateCursorPositionDocAll(e){ cX = event.clientX; cY = event.clientY;}
if(document.all) { document.onmousemove = UpdateCursorPositionDocAll; }
else { document.onmousemove = UpdateCursorPosition; }
function AssignPosition(d) {
if(self.pageYOffset) {
rX = self.pageXOffset;
rY = self.pageYOffset;
}
else if(document.documentElement && document.documentElement.scrollTop) {
rX = document.documentElement.scrollLeft;
rY = document.documentElement.scrollTop;
}
else if(document.body) {
rX = document.body.scrollLeft;
rY = document.body.scrollTop;
}
if(document.all) {
cX += rX;
cY += rY;
}
d.style.left = (cX+10) + "px";
d.style.top = (cY+10) + "px";
}
function HideContent(d) {
if(d.length < 1) { return; }
document.getElementById(d).style.display = "none";
}
function ShowContent(d) {
if(d.length < 1) { return; }
var dd = document.getElementById(d);
AssignPosition(dd);
dd.style.display = "block";
}
function ReverseContentDisplay(d) {
if(d.length < 1) { return; }
var dd = document.getElementById(d);
AssignPosition(dd);
if(dd.style.display == "none") { dd.style.display = "block"; }
else { dd.style.display = "none"; }
}
