// function listFunction(response){
//     var arr = JSON.parse(response);
//     var i;
//     var out;

//     for(i=0; i<arr.length; i++){
//         out += "<tr>"+"arr[i].patient_email"+ "</tr>";
//     }
//     // out += "</table>";
//     document.getElementById("patient_list").innerHTML = out;
// }
// function display(){
//     var url = "php/list.php";
//     var xmlhttp;
//         xmlhttp.open("POST", url, true);
//     //  Set content type header information for sending url encoded variables in the request
//     xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//     xmlhttp.onreadystatechange = function(){
//         if (xmlhttp.readyState==4 && xmlhttp.status==200) {
//             //  code
//             //document.getElementById("LogError").innerHTML = xmlhttp.responseText;
//             listFunction(xmlhttp.responseText);
//         }
// }
        var url = "php/list.php";
        $("#patient_list").html("");
        $.getJSON(url, function(data){
            $.each(data.patients, function(index, patient) {
                var newRow = 
                "<a class='listfiles' id='"+ patient.patient_email + "' href=''>" + patient.patient_email
                + "</a><br/>";
                $(newRow).appendTo("#patient_list");
            });
            $(".listfiles").click(function(){
                var string = this.id;
                var queryString = "?patient_email=" + string;
                $(".listfiles").attr("href","patient.html"+queryString);
                
            });

        });
        $(".listfiles").click(function(){
                var string = this.id;
                var queryString = "?patient_email=" + string;
                $(".listfiles").attr("href","patient.html"+queryString);
                
            });
function add(){
	var xmlhttp;
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {    //  code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    var url = "php/add_patient.php";
    xmlhttp.open("POST", url, true);
    //  Set content type header information for sending url encoded variables in the request
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.onreadystatechange = function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            //  code
            //document.getElementById("LogError").innerHTML = xmlhttp.responseText;
            analysisRes(xmlhttp.responseText);
        }
    };
    var add_contact = document.getElementById("add_contact").value;
    var parameter="&add_contact="+add_contact;

    xmlhttp.send(parameter);

} 
function analysisRes(res){
	if(res.trim()=='not_exist'){
        document.getElementById("reminder").innerHTML = "Patient doesn't exist!";
        
    
    }else if (res.trim()=='added_patient'){
    	document.getElementById("reminder").innerHTML="Added patient ! "
   
    
    var url = "php/list.php";
        $("#patient_list").html("");
        $.getJSON(url, function(data){
            $.each(data.patients, function(index, patient) {
                var newRow = 
                "<a class='listfiles' id='"+ patient.patient_email + "' href=''>" + patient.patient_email
                + "</a><br/>";
                $(newRow).appendTo("#patient_list");
            });
            $(".listfiles").click(function(){
                var string = this.id;
                var queryString = "?patient_email=" + string;
                $(".listfiles").attr("href","patient.html"+queryString);
                
            });
        });
    }
}

