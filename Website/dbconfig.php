<?php
  $dbhost = "localhost";
  $dbuser = "root";
  $dbpass = "921022";
  $dbname = "AccountTest";

  mysql_connect($dbhost, $dbuser, $dbpass) or die ('cannot connect to the server');
  mysql_select_db($dbname) or die ('database selection problem');
//   $conn = mysqli_connect($DBServerName, $DBUserName, $DBPassWord, $DBName) or die('Connect Error (' . mysqli_connect_errno() . ') '
// . mysqli_connect_error());
?>

