<?php
    //include_once 'dbconfig.php';

    session_start();
    $doctor_email = $_SESSION['useremail'];
    $patient_email = $_SESSION['patient_email'];

    // echo $doctor_email;
    // echo $patient_email;

    $dbhost = "localhost";
  $dbuser = "root";
  $dbpass = "921022";
  $dbname = "AccountTest";

  mysql_connect($dbhost, $dbuser, $dbpass) or die ('cannot connect to the server');
  mysql_select_db($dbname) or die ('database selection problem');



//  if (isset($_POST['btn_uploadFile']) {
    $file_oldname = $_FILES['file']['name'];
    $file_name = rand(1000,100000)."-".$_FILES['file']['name'];
    // $file_name = $_FILES['file']['name'];
    $file_size = $_FILES['file']['size'];
    $file_type = $_FILES['file']['type'];
    // $file_data = file_get_contents(addslashes($_FILES['file']['tmp_name']));
    // $file_data = file_get_contents($_FILES['file']['tmp_name']);
    $file_data = $_FILES['file']['tmp_name'];
    // $file_data = addslashes(file_get_contents($_FILES['file']['tmp_name']));
    // 
    // $fp      = fopen($file_data, 'r');
    // $file_data = fread($fp, filesize($file_data));
    // $file_data = addslashes($file_data);
    // fclose($fp);

    // $upload_time = date("Y-m-d H:i:s");
    date_default_timezone_set("America/New_York");
    
    $upload_time = substr(str_replace("+",":",str_replace("T"," ",date(DATE_ATOM))),0,18);
    $folder = "upload/";
    $dirpath = realpath(dirname(getcwd()))."/upload/";

    $file_name = basename($file_name);

    move_uploaded_file($file_data,$dirpath.$file_name);

    // //  new file size in KB
    // $new_size = $file_size/1024;

    //  make file name in lower case
    // $new_file_name = strtolower($file);

    //  $final_file = str_replace(' ', '-', $new_file_name);
    // echo $file_oldname;
    //   echo $file_name;
    //   echo $file_size;
    //   echo $file_type;
    //   echo $upload_time;
    //   echo $dirpath;

//    if(move_uploaded_file($file_loc,$folder,$final_file)){
      // $sql = "INSERT INTO file(file_oldname,file_name,file_size,file_type, upload_time,upload_path, patient_email, doctor_email)
      //         VALUES ('$file_oldname','$file_name','$file_size','$file_type','$upload_time','$dirpath','$patient_email','$doctor_email')";
      // $sql = "INSERT INTO file(file_oldname,file_name,file_size,file_type, upload_time, upload_path)
      //         VALUES ('$file_oldname','$file_name','$file_size','$file_type','$upload_time','$dirpath')";
      $sql = "INSERT INTO file(file_oldname,file_name,file_size,file_type,upload_time,upload_path,patient_email, doctor_email)
              VALUES ('$file_oldname','$file_name','$file_size','$file_type','$upload_time','$dirpath','$patient_email','$doctor_email')";      
      mysql_query($sql) or die('Error, query failed');

//    }
//  }

?>

