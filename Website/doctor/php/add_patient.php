<?php
  session_start();
  $doctor_email=$_SESSION['useremail'];
  

  // function debug_to_console( $data ) {
  //   if ( is_array( $data ) )
  //     $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
  //   else
  //     $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";
  //   echo $output;
  // }

  //debug_to_console("This is login.php");

  //  DB info
  //  $DBServerName = "52.33.164.228:3306";
  $DBServerName = "localhost";
  $DBUserName = "root";
  // $DBPassWord = "998998";
  $DBPassWord = "921022";
  //  $DBPassWord = "";
  $DBName = "AccountTest";
  // Create connection
  $conn = mysqli_connect($DBServerName, $DBUserName, $DBPassWord, $DBName) or die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());

  $add_contact = $_POST['add_contact'];

  $sql = "SELECT * FROM Patient_Account WHERE user_email='$add_contact' ";
    $res = mysqli_query($conn, $sql);
    if(!$res) {
      die('Invalid query:'. mysqli_error($conn));
    }
    $row = mysqli_fetch_array($res);
    $active = $row['active'];
    $count = mysqli_num_rows($res);
    if($count==0)
    {
      echo "not_exist";
    }else
    {
      $sql_insert = "INSERT INTO Doctor_Patient (doctor_email, patient_email) VALUES ('$doctor_email','$add_contact')";
      if (mysqli_query($conn, $sql_insert)) {

        echo 'added_patient';
      }
    }
?>
