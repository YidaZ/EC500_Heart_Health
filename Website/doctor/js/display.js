function display(){
	var xmlhttp;
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {    //  code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    var url = "php/list.php";
    xmlhttp.open("POST", url, true);
    //  Set content type header information for sending url encoded variables in the request
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.onreadystatechange = function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            //  code
            //document.getElementById("LogError").innerHTML = xmlhttp.responseText;
            listFunction(xmlhttp.responseText);
        }
    }
    xmlhttp.send();
}
function listFunction(response){
    var arr = JSON.parse(response);
    var i;
    var out = "<table>";

    for(i=0; i<arr.length; i++){
        out += "<tr><td>"+arr[i].doctor_email+ "</td><td>"+arr[i].patient_email+"</td></tr>";
    }
    out += "</table>";
    document.getElementById("patient_list").innerHTML = out;
}

