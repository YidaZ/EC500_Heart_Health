getsession();

function getsession(){
    var xmlhttp;
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {    //  code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    var url = "php/getsession.php";
    xmlhttp.open("POST", url, true);
    //  Set content type header information for sending url encoded variables in the request
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.onreadystatechange = function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            //  code
            //document.getElementById("LogError").innerHTML = xmlhttp.responseText;
            analysisResponse(xmlhttp.responseText);
        }
    };
    xmlhttp.send();
}

function analysisResponse(res){
    var response = res;
    document.getElementById("useremail").innerHTML = 'Hello ' + res;
    if (res.trim()=='') {
        window.location.href = "../../index.html";                 //  if no session go to login page
    };
}

function btn_logout(){
    var xmlhttp;
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {    //  code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    var url = "php/logout.php";
    xmlhttp.open("POST", url, true);
    //  Set content type header information for sending url encoded variables in the request
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.onreadystatechange = function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            window.location.href = "../../index.html";
        }
    };
    xmlhttp.send();
}