<?php
  session_start();
  $doctor_email = $_SESSION['useremail'];
  $patient_email = $_SESSION['patient_email'];
  $DBServerName = "localhost";
  $DBUserName = "root";
  $DBPassWord = "921022";
  $DBName = "AccountTest";
  // Create connection
  $conn = mysqli_connect($DBServerName, $DBUserName, $DBPassWord, $DBName) or die('Connect Error (' . mysqli_connect_errno() . ') '
. mysqli_connect_error());


  $sql = "SELECT file_id,file_oldname,upload_time,des,report FROM file WHERE patient_email='$patient_email' AND doctor_email='$doctor_email'";
  $res = mysqli_query($conn, $sql);
  if(!$res) {
    die('Invalid query:'. mysqli_error($conn));
  }

  $var = array();
  while ($obj = mysqli_fetch_object($res)) {
    $var[] = $obj;
  }

  echo '{"files":'.json_encode($var).'}';

?>

