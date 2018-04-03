function _(x){
return document.getElementById(x);
}
var hasImage = ""; 
window.onbeforeunload = function(){ 
	if(hasImage !== ""){ 
		return "Your image has not been upload it"; 
		}
	 } 
function showBtnDiv(){
if(_("body").style.height = "80px"){
_("btns_SP").style.display = "block";
	}else{
	_("body").style.height = "40px";
	_("btns_SP").style.display = "none";
	}
}
function notShowBtnDiv(){
if(_("body").style.height = "40px"){
_("btns_SP").style.display = "none";
	}else{
	_("body").style.height = "80px";
	_("btns_SP").style.display = "block";
	}
}
function doUpload(id){
	// www.developphp.com/video/JavaScript/File-Upload-Progress-Bar-Meter-Tutorial-Ajax-PHP
	var file = _(id).files[0];
	if(file.name === ""){
		return false;		
	}
	if(file.type != "image/jpeg" && file.type != "image/gif" && file.type != "image/png"){
		alert("That file type is not supported.");
		return false;
	}
	_("triggerBtn_SP").style.display = "none";
	_("uploadDisplay_SP").innerHTML = "Uploading image......";
	var formdata = new FormData();
	formdata.append("stPic", file);
	var ajax = new XMLHttpRequest();
	ajax.addEventListener("load", completeHandler, false);
	ajax.addEventListener("error", errorHandler, false);
	ajax.addEventListener("abort", abortHandler, false);
	ajax.open("POST", "php_parsers/photo_system.php");
	ajax.send(formdata);	
}
function completeHandler(event){
	var data = event.target.responseText;
	var datArray = data.split("|");
	if(datArray[0] == "upload_complete"){
		hasImage = datArray[1];
		_("uploadDisplay_SP").innerHTML = '<img src="tempUploads/'+datArray[1]+'" class="statusImage" />';
	} else {
		_("uploadDisplay_SP").innerHTML = datArray[0];
		_("triggerBtn_SP").style.display = "block";
	}
}
function errorHandler(event){
	_("uploadDisplay_SP").innerHTML = "Upload Failed";
	_("triggerBtn_SP").style.display = "block";
}
function abortHandler(event){
	_("uploadDisplay_SP").innerHTML = "Upload Aborted";
	_("triggerBtn_SP").style.display = "block";
}
function triggerUpload(e,elem){
	e.preventDefault();
	document.getElementById(elem).click();	
}
function linkifyYouTubeURLs(text) {
    var re = /https?:\/\/(?:[0-9A-Z-]+\.)?(?:youtu\.be\/|youtube(?:-nocookie)?\.com\S*[^\w\s-])([\w-]{11})(?=[^\w-]|$)(?![?=&+%\w.-]*(?:['"][^<>]*>|<\/a>))[?=&+%\w.-]*/ig;
    return text.replace(re,
        '<p><iframe title="YouTube video player" class="youtube-player" type="text/html" src="https://www.youtube.com/embed/$1" frameborder="10" allowfullscreen></iframe></p>');
}
function postToStatus(action,type,user,ta){
	var data = _(ta).value;
	if(data === "" && hasImage === ""){
		alert("Type something first weenis");
		return false;
	}
	var data2 = "";
	if(data !== ""){
		data2 = data.replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/\n/g,"<br />").replace(/\r/g,"<br />");
		data2 = linkifyYouTubeURLs(data2);
	}
	if (data2 === "" && hasImage !== ""){
		data = "||na||";
		data2 = '<img width="100%" src="/user/'+user+'/'+hasImage+'" />';		
	} else if (data2 !== "" && hasImage !== ""){
		data2 += '<br /><img width="100%" src="/user/'+user+'/'+hasImage+'" />';
		data2 = linkifyYouTubeURLs(data2);
	} else {
		hasImage = "na";
	}
	_("statusBtn").disabled = true;
	var ajax = ajaxObj("POST", "php_parsers/status_system.php");
	ajax.onreadystatechange = function() {
		if(ajaxReturn(ajax) === true) {
			var datArray = ajax.responseText.split("|");
			if(datArray[0] == "post_ok"){
				var sid = datArray[1];
				var currentHTML = _("statusarea").innerHTML;
				_("statusarea").innerHTML = '<div id="status_'+sid+'" class="status_boxes"><div><b>Sent by you just now:</b> <span id="sdb_'+sid+'"><a href="#" onclick="return false;" onmousedown="deleteStatus(\''+sid+'\',\'status_'+sid+'\');" title="DELETE THIS STATUS AND ITS REPLIES"></a></span><br />'+data2+'</div></div><textarea id="replytext_'+sid+'" class="replytext" onkeyup="statusMax(this,250)" placeholder="Type your comment here.."></textarea><button id="replyBtn_'+sid+'" onclick="replyToStatus('+sid+',\'<?php echo $u; ?>\',\'replytext_'+sid+'\',this)">Comment</button>'+currentHTML;
				_("statusBtn").disabled = false;
				_(ta).value = "";
				_("triggerBtn_SP").style.display = "block";
				_("btns_SP").style.display = "none";
				_("uploadDisplay_SP").innerHTML = "";
				_("statustext").style.height = "40px";
				_("fu_SP").value = "";
				hasImage = "";
			} else {
				alert(ajax.responseText);
			}
		}
	}
	ajax.send("action="+action+"&type="+type+"&user="+user+"&data="+data+"&image="+hasImage);
}
