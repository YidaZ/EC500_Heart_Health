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
    echo $upload_time;
    $folder = "upload/";
    $path = realpath(dirname(getcwd()));
    
    $dirpath = realpath(dirname(getcwd()))."/doctor/upload/";
    // $dirpath = realpath(dirname(getcwd()))."/upload/";
    $file_name = basename($file_name);
    echo $file_name;

    // echo $dirpath;
    // echo $file_name;

  //   $sql = "SELECT * FROM Doctor_Account WHERE user_email='$doctor_email'";
  // $res = mysql_query($sql);
  // $count = mysql_num_rows($res);
  // echo $count;

    move_uploaded_file($file_data,$dirpath.$file_name);
    
    $zip = new ZipArchive;
    $res = $zip->open($dirpath.$file_name);
    $folder_name = trim($zip->getNameIndex(0));
    if ($res == TRUE) {
      $zip->extractTo($dirpath);
      $zip->close();
      echo 'Succeed';
    } else {
      echo 'failed';
    }
    

    // $file_name_delzip = explode('.', $file_name);
    // rename($dirpath.$folder_name, $dirpath.$file_name_delzip[0]);
    $file_name_ini = explode('.', $file_oldname);
    $mri_folder = $file_name_ini[0];
    echo $mri_folder;
    $old_dir = $dirpath.$folder_name;
    // echo $old_dir;
 
	$mri = "upload/".trim($mri_folder);
	echo $mri;


    $command = "chmod -R 0777 $old_dir";
    exec($command);

    $input1 =".";
    $command1 = "python upload/final.py $input1 $mri"; 
    echo $command1;
    $data =array();
    exec($command1,$data, $ret);
	echo $ret;
    if ($ret ==0){
        foreach ($data as $line){
          echo "$line \n";
        }
    }else{
          echo"Eroor";
    }

      $file_name_delzip = explode('.', $file_name);
      rename($dirpath.$folder_name, $dirpath.$file_name_delzip[0]);
	$num = (float)$line;
	if($num<1 && $num >= 0.75){
		$report = "Hyperdynamic";
	}else if($num < 0.75 && $num >=0.65){
		$report = "Slight Hyperdynamic";
	}else if($num < 0.65 && $num >=0.55){
		$report = "Normal EF";
	}else if($num < 0.55 && $num >=0.45){
		$report = "Mildly Abnomal";
	}else if($num < 0.45 && $num >=0.35){
		$report = "Moderately Abnomal";
	}else if($num < 0.35 && $num>0){
		$report = "Severely Abnomal";
	}else{
		$report = "Error";
	}
	echo $report;

   
    

    $sql = "INSERT INTO file(file_oldname,file_name,file_size,file_type,upload_time,upload_path,patient_email, doctor_email,des,report)
              VALUES ('$file_oldname','$file_name','$file_size','$file_type','$upload_time','$dirpath','$patient_email','$doctor_email','$line','$report')";      
      mysql_query($sql) or die('Error, query failed');



?>
