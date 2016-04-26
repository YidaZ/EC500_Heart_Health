
function getUrlVars(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)", "i"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

var patient_email= getUrlVars("patient_email");

document.getElementById("patient").innerHTML = patient_email;
// $(document).ready(function(){
// 	var patient_email= getUrlVars["patient_email"];
// 	$("#patient").text(patient_email);
// })
patient_info();

function patient_info(){
	var xmlhttp;
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {    //  code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    var url = "php/patient_info.php";
    xmlhttp.open("POST", url, true);
    //  Set content type header information for sending url encoded variables in the request
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.onreadystatechange = function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            //  code
            //document.getElementById("LogError").innerHTML = xmlhttp.responseText;
            // analysisResponse(xmlhttp.responseText);
            document.getElementById("patient_info").innerHTML = xmlhttp.responseText;
        }
    };
    var parameter="&patient_info="+patient_email;
    xmlhttp.send(parameter);
}
// function analysisResponse(res){
// 	document.getElementById("patient_info").innerHTML = 'Hello ' + res;
// }

