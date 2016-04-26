$(document).on('change', '.file', function() {
  var input = $(this),
      numFiles = input.get(0).files ? input.get(0).files.length : 1,
      label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
  input.trigger('fileselect', [numFiles, label]);
});

$(document).ready( function() {
    $('.file').on('fileselect', function(event, numFiles, label) {
        
        var input = $(this).parents('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;
        
        if( input.length ) {
            input.val(log);
        } else {
            if( log ) alert(log);
        }
        
    });

        var url = "php/list_files.php";
        $("#list_files").html("");
        $.getJSON(url, function(data){
            // var table = "<table style='width:100%'><thead><tr><th style='width:50%'>File Name</th><th style='width:50%'>Uploaded Time</th></tr></thead><tbody>";
            // $(table).appendTo("#list_files");
            // $.each(data.files, function(index, file) {
                // var newRow = 
                // "<tr>"
                // + "<td class='listfiles' id='"+ file.file_id + "'>" + file.file_oldname 
                // + "</td>" 
                // + "<td>" + file.upload_time + "</td>"
                // +"<td>"+"<button type='button' class='btn btn-primary btn-sm'>"+"</button>"+"</td>"+"</tr>";
                // $(newRow).appendTo("#list_files");
            // });
            $.each(data.files, function(index, file) {
                var newRow = 
                "<tr>"
                + "<td>" + "<a class='listfiles' id='"+ file.file_id + "'>"+ file.file_oldname+"</a>" 
                + "</td>" 
                + "<td>" + file.upload_time + "</td>"
                +"<td>" + file.des + "</td>"
		+"<td>" + file.report + "</td>"
                // +"<td>"+"<a href='' class='btn btn-primary btn-sm' id='"+ file.file_id + "'>"+"view"+"</a>"+"</td>"+"</tr>";
                $(newRow).appendTo("#list_files");
                // var newRow = 
                // "<p>"
                // + "<a class='listfiles' id='"+ file.file_id + "'>" + file.file_oldname + "- upload time - " + file.upload_time + "" 
                // + "</a></p>" ;
                // $(newRow).appendTo("#list_files");
            });
            table = "</tbody></table>";
            $(table).appendTo("#list_files");

            //$(".list_files").on('click', function() {
            $(".listfiles").click(function(){
                var string = this.id;
                var queryString = "?file_id=" + string;
//                window.location.href = "download.php" + queryString;

                var url = "php/download.php";
                var form = $('<form action="' + url + '" method="post">' +
                  '<input type="text" name="file_id" value="' + string + '" />' +
                  '</form>');
                $('body').append(form);
                $(form).submit();
            });
            $(".btn-sm").click(function(){
                $(".btn-sm").attr("href", "http://www.w3schools.com/jquery");
                var string = this.id;
                $.post("php/mri_id.php",{id:string},
                    function(data){
                                            });
                // $.ajax({
                //     type:"POST",
                //     url:"php/mri_id.php",
                //     data:{id: string},
                //     success:function(){
                //         alert("message sent");
                        
                        
                //     }
                // });
                
            })
        });

    // $("#btn_uploadFile").click(function() {
    //  /* Act on the event */

    // });
    $('#btn_uploadFile').on('click', function() {
        var file_data = $('#file').prop('files')[0];   
        var form_data = new FormData();                  
        form_data.append('file', file_data);

        if(typeof(file_data)!='undefined'){
        // alert(form_data);
           $('#loader-icon').show();                             
        $.ajax({
                url: 'upload.php', // point to server-side PHP script 
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                success: function(php_script_response){
                    // alert(php_script_response); // display response from the PHP script, if any               
                    //  Clear chosen file
		    $('#loader-icon').hide();
                    var file = $("#file");  
                    file.replaceWith( file = file.clone(true) );
                    // $("#text_file").val('');

                    var url = "php/list_files.php";
                    $("#list_files").html("");
                    $.getJSON(url, function(data){
                        $.each(data.files, function(index, file) {
                            // var newRow = 
                            //     "<p>"
                            //     + "<a class='listfiles' id='"+ file.file_id + "'>" + file.file_oldname + "- upload time - " + file.upload_time + "" 
                            //     + "</a></p>" ;
                            //     $(newRow).appendTo("#list_files");
                            var newRow = 
                                "<tr>"
                                + "<td>" + "<a class='listfiles' id='"+ file.file_id + "'>"+ file.file_oldname+"</a>" 
                                + "</td>" 
                                + "<td>" + file.upload_time + "</td>"
                                +"<td>" + file.des + "</td>"
				+"<td>" + file.report + "</td>"
                                // +"<td>"+"<button type='button' class='btn btn-primary btn-sm'>"+"view"+"</button>"+"</td>"+"</tr>";
                                $(newRow).appendTo("#list_files");
                        });

                        //$(".list_files").on('click', function() {
                        $(".listfiles").click(function(){
                            var string = this.id;
                            var queryString = "?file_id=" + string;
            //                window.location.href = "download.php" + queryString;

                            var url = "php/download.php";
                            var form = $('<form action="' + url + '" method="post">' +
                              '<input type="text" name="file_id" value="' + string + '" />' +
                              '</form>');
                            $('body').append(form);
                            $(form).submit();
                        });
                        $(".btn-sm").click(function(){
                            $(".btn-sm").attr("href", "http://www.w3schools.com/jquery");
                            var string = this.id;
                            $.post("php/mri_id.php",{id:string},
                                function(){
                                    
                                });
                            // $.ajax({
                            //     type:"POST",
                            //     url:"php/mri_id.php",
                            //     data:{id: string},
                            //     success:function(){
                            //         alert("message sent");
                                    
                                    
                            //     }
                            // });
                            
                        })

                    });
                }
        });

        }
    });

    // $('#btn_downloadFile').on('click', function() {
 //     // var file_data = $('#choose_file').prop('files')[0];   
 //     // var form_data = new FormData();                  
 //     // form_data.append('file', file_data);
 //     // alert(form_data); 
 //     window.location.replace("download.php");                          
 //     $.ajax({
 //                url: 'download.php', // point to server-side PHP script 
 //                // dataType: 'text',  // what to expect back from the PHP script, if anything
 //                // cache: false,
 //                // contentType: false,
 //                // processData: false,
 //                // data: form_data,                         
 //                type: 'post',
 //                success: function(php_script_response){
 //                    // alert(php_script_response); // display response from the PHP script, if any
 //                }
 //         });
    // });
});
