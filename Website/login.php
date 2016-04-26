<?php
  session_start();

  function debug_to_console( $data ) {
    if ( is_array( $data ) )
      $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
    else
      $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";
    echo $output;
  }

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
  $conn = mysqli_connect($DBServerName, $DBUserName, $DBPassWord, $DBName) or die('Connect Error (' . mysqli_connect_errno() . ') '
. mysqli_connect_error());

  //
  $action = $_POST['action'];
  $useremail = $_POST['useremail'];
  $userpass = $_POST['userpass'];

  // debug_to_console($action);
  // debug_to_console($useremail);
  // debug_to_console($userpass);


  //--------------------------------------
  // log as patient
  // -------------------------------------
  if($action=="logpatient"){
    //--------------------------------------
    // sql - select data from table
    // -------------------------------------
    $sql = "SELECT * FROM Patient_Account WHERE user_email='$useremail' and user_pass='$userpass'";
    $res = mysqli_query($conn, $sql);
    if(!$res) {
      die('Invalid query:'. mysqli_error($conn));
    }
    $row = mysqli_fetch_array($res);
    $active = $row['active'];
    $count = mysqli_num_rows($res);
    //debug_to_console("count=" . $count);
    if ($count==1) {
      //echo "You have entered valid use name and password";
      //header('Location: ../home.html');
      //debug_to_console($row['user_pass'] );
      // echo '<script type="text/javascript"> 
      //           window.location = "home.html";
      //       </script>';
      // Set session variables
      $_SESSION["useremail"] = $useremail;
      $_SESSION["role"] = 'patient';
      echo 'truePatient';
    } else {
      //$msg = 'Wrong username or password';
      //echo 'user email and password do not match';
      echo 'falsePatient';
    }
  }


  //--------------------------------------
  // register as patient
  // -------------------------------------
  if ($action=="registerpatient") {
    //--------------------------------------
    // sql - select data from table
    // -------------------------------------
    $sql = "SELECT * FROM Patient_Account WHERE user_email='$useremail'";
    $res = mysqli_query($conn, $sql);
    if(!$res) {
      die('Invalid query:'. mysqli_error($conn));
    }
    $row = mysqli_fetch_array($res);
    $active = $row['active'];
    $count = mysqli_num_rows($res);

    if ($count==1) {
      echo 'emailtoken';
    } else {
      //--------------------------------------
      // sql - insert data into table
      // -------------------------------------
      $sql_insert = "INSERT INTO Patient_Account (user_email, user_pass) VALUES ('$useremail','$userpass')";
      if (mysqli_query($conn, $sql_insert)) {
        $_SESSION["useremail"] = $useremail;
        $_SESSION["role"] = 'patient';
        echo 'registerpatient';
        // echo "New record created successfully";
        // echo '<script type="text/javascript">
        //                         window.location = "home.html";
        //                     </script>';
      } else {
        //echo "Error: " . $sql_insert . "<br>" . mysqli_error($conn);
      }

    }
  }



  //--------------------------------------
  // log as doctor
  // -------------------------------------
  if($action=="logdoctor"){
    //--------------------------------------
    // sql - select data from table
    // -------------------------------------
    $sql = "SELECT * FROM Doctor_Account WHERE user_email='$useremail' and user_pass='$userpass'";
    $res = mysqli_query($conn, $sql);
    if(!$res) {
      die('Invalid query:'. mysqli_error($conn));
    }
    $row = mysqli_fetch_array($res);
    $active = $row['active'];
    $count = mysqli_num_rows($res);
    //debug_to_console("count=" . $count);
    if ($count==1) {
      //echo "You have entered valid use name and password";
      //header('Location: ../home.html');
      //debug_to_console($row['user_pass'] );
      // echo '<script type="text/javascript"> 
      //           window.location = "home.html";
      //       </script>';
      // Set session variables
      $_SESSION["useremail"] = $useremail;
      $_SESSION["role"] = 'doctor';
      echo 'trueDoctor';
    } else {
      //$msg = 'Wrong username or password';
      //echo 'user email and password do not match';
      echo 'falseDoctor';
    }
  }


  //--------------------------------------
  // register as doctor
  // -------------------------------------
  if ($action=="registerdoctor") {
    //--------------------------------------
    // sql - select data from table
    // -------------------------------------
    $sql = "SELECT * FROM Doctor_Account WHERE user_email='$useremail'";
    $res = mysqli_query($conn, $sql);
    if(!$res) {
      die('Invalid query:'. mysqli_error($conn));
    }
    $row = mysqli_fetch_array($res);
    $active = $row['active'];
    $count = mysqli_num_rows($res);

    if ($count==1) {
      echo 'emailtoken';
    } else {
      //--------------------------------------
      // sql - insert data into table
      // -------------------------------------
      $sql_insert = "INSERT INTO Doctor_Account (user_email, user_pass) VALUES ('$useremail','$userpass')";
      if (mysqli_query($conn, $sql_insert)) {
        $_SESSION["useremail"] = $useremail;
        $_SESSION["role"] = 'doctor';
        echo 'registerdoctor';
        // echo "New record created successfully";
        // echo '<script type="text/javascript">
        //                         window.location = "home.html";
        //                     </script>';
      } else {
        //echo "Error: " . $sql_insert . "<br>" . mysqli_error($conn);
      }

    }
  }


?>

