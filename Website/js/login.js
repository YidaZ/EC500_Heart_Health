function btn_logpatient(){
    var xmlhttp;
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {    //  code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    var url = "php/login.php";
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
    var useremail = document.getElementById("useremail").value;
    var userpass = document.getElementById("password").value;
    var action = document.getElementById("logpatient").value;
    var parameters = "action=" + action + "&useremail=" + useremail + "&userpass=" + userpass;
//    xmlhttp.open("POST", "php/login.php", true);
    xmlhttp.send(parameters);
}

function btn_logdoctor(){
    var xmlhttp;
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {    //  code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    var url = "php/login.php";
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
    var useremail = document.getElementById("useremail").value;
    var userpass = document.getElementById("password").value;
    var action = document.getElementById("logdoctor").value;
    var parameters = "action=" + action + "&useremail=" + useremail + "&userpass=" + userpass;
//    xmlhttp.open("POST", "php/login.php", true);
    xmlhttp.send(parameters);
}

function btn_register(){
    var useremail = document.getElementById("useremailR").value;
    var userpass = document.getElementById("passwordR").value;
    var repeatpassword = document.getElementById("repeatpasswordR").value;
    //var action = document.getElementById("logpatient").value;   
    var action = getRadioCheckedValue("optradio");
    var parameters = "action=" + action + "&useremail=" + useremail + "&userpass=" + userpass;

    if(userpass!=repeatpassword){
        document.getElementById("RegError").innerHTML = "Please enter the same password!";
        return;
    }

    var xmlhttp;
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {    //  code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    var url = "php/login.php";
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
//    xmlhttp.open("POST", "php/login.php", true);
    xmlhttp.send(parameters);
}

function getRadioCheckedValue(radio_name){
   var oRadio = document.getElementsByName(radio_name);
   for(var i = 0; i < oRadio.length; i++){
      if(oRadio[i].checked){
         return oRadio[i].value;
      }
   } 
   return '';
}


function analysisResponse(res){
    if(res.trim()=='truePatient'){
        window.location.href = "startbootstrap/patient/index.html";             //  page directed to patient home page
    }
    else if(res.trim()=='falsePatient' || res.trim()=='falseDoctor'){
        document.getElementById("LogError").innerHTML = "User email and password do not match!";
    }
    else if(res.trim()=='emailtoken'){
        document.getElementById("RegError").innerHTML = "The user email is already token!";
    }
    else if(res.trim()=='registerpatient'){
        window.location.href = "startbootstrap/patient/index.html";             //  page directed to patient home page
    }
    else if(res.trim()=='trueDoctor'){
        window.location.href = "startbootstrap/doctor/index.html";             //  page directed to doctor home page
    }
    else if(res.trim()=='registerdoctor'){
        window.location.href = "startbootstrap/doctor/index.html";             //  page directed to doctor home page
    }
}
