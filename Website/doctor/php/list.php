<?php
  session_start();
  $doctor_email=$_SESSION['useremail'];
  
  $DBServerName = "localhost";
  $DBUserName = "root";
  // $DBPassWord = "998998";
  $DBPassWord = "921022";
  //  $DBPassWord = "";
  $DBName = "AccountTest";
  $conn = mysqli_connect($DBServerName, $DBUserName, $DBPassWord, $DBName) or die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
  $sql = "SELECT patient_email FROM Doctor_Patient WHERE doctor_email='$doctor_email'";
  $res = mysqli_query($conn, $sql);
  if(!$res) {
    die('Invalid query:'. mysqli_error($conn));
  }
   $var = array();
  while ($obj = mysqli_fetch_object($res)) {
    $var[] = $obj;
  }

  echo '{"patients":'.json_encode($var).'}';
  // $outp = "[";
  // while($rs = mysqli_fetch_assoc($res)) {
  //   if ($outp != "[") {$outp .= ",";}
  //   $outp .= '{"Doctor":"'  . $rs["doctor_email"] . '",';
  //   $outp .= ' "Patient":"'  . $rs["patient_email"] . '"}';
  // }
  // $outp .="]";
  // mysqli_close($conn);
  // echo($outp);
?>

