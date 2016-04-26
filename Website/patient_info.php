<?php
  session_start();
  $_SESSION['patient_email'] = $_POST['patient_info'];
  echo $_SESSION['patient_email'];
?>
