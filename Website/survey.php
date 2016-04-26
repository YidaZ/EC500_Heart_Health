<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Self-test</title>

    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="../dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        input[type="radio"]{
          margin: 10px 50px 10px 100px;
        }
        label{
            font-family: "Times New Roman", Times, serif;;
            font-weight: lighter;
            font-size: 1.2em;
        }
    </style>
    <script src="js/getsession.js"></script>

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html" id="useremail">Hello! </a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>I read your MRI images and...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>The time of appointment is...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>Read All Messages</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
                </li> 
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-comment fa-fw"></i> New Message
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> Message Sent
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-tasks fa-fw"></i> New Appointment
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> New Result
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a type="button" id="Logout" onclick="btn_logout();"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                                </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="index.html"><i class="fa fa-home fa-fw"></i> Home</a>
                        </li>
                        <!-- <li>
                            <a href="report.html"><i class="fa fa-file-text-o fa-fw"></i> Report</a>
                        </li>
                        <li>
                            <a href="history.html"><i class="fa fa-files-o fa-fw"></i> History</a>
                        </li>
                        <li>
                            <a href="message.html"><i class="fa fa-envelope-o fa-fw"></i> Message</a>
                        </li> -->
                        <!-- <li>
                            <a href="forum.html"><i class="fa fa-comments-o fa-fw"></i> Forum</a>
                        </li>
                        <li>
                            <a href="appointment.html"><i class="fa fa-calendar fa-fw"></i> Appointment</a>
                        </li> -->
                        <!-- <li>
                            <a href="profile.html"><i class="fa fa-user fa-fw"></i> Profile</a>
                        </li>
                        <li>
                            <a href="survey.php"><i class="fa fa-gear fa-fw"></i> Self-test</a>
                        </li> -->
                        <li>
                            <a type="button" onclick="btn_logout();"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
              
                        
                        
                     </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Test yourself!</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                                
                            <?php
                                //define variables and set to empty values
                                
                                $hypertensive = $HYPNinFamily = $Diabetic = $DBTSinFamily = $heartAttack = $smoking = $dizziness = $dryTongue = $numbness = $height = $weight = $waist = "";
                                $finished = $finished1 = $finished2 = $finished3 = $finished4 = $finished5 = $finished6 = $finished7 = $finished8 = $finished9 = $finished10 = $finished11 = false;

                                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                
                                    if (!empty($_POST["hypertensive"])) {
                                        $hypertensive = $_POST["hypertensive"];
                                    }
                                    if (!empty($_POST["HYPNinFamily"])) {
                                        $HYPNinFamily = $_POST["HYPNinFamily"];
                                    }
                                    if (!empty($_POST["Diabetic"])) {
                                        $Diabetic = $_POST["Diabetic"];
                                    }
                                    if (!empty($_POST["DBTSinFamily"])) {
                                        $DBTSinFamily = $_POST["DBTSinFamily"];
                                    }
                                    if (!empty($_POST["heartAttack"])) {
                                        $heartAttack = $_POST["heartAttack"];
                                    }
                                    if (!empty($_POST["smoking"])) {
                                        $smoking = $_POST["smoking"];
                                    }
                                    if (!empty($_POST["dizziness"])) {
                                        $dizziness = $_POST["dizziness"];
                                    }
                                    if (!empty($_POST["dryTongue"])) {
                                        $dryTongue = $_POST["dryTongue"];
                                    }
                                    if (!empty($_POST["numbness"])) {
                                        $numbness = $_POST["numbness"];
                                    }
                                    if (!empty($_POST["height"])) {
                                        $height = test_form($_POST["height"]);
                                    }
                                    if (!empty($_POST["weight"])) {
                                        $weight = test_form($_POST["weight"]);
                                    }
                                    if (!empty($_POST["waist"])) {
                                        $waist = test_form($_POST["waist"]);
                                    }

                                }
                                function test_form($data) {
                                    $data = trim($data);
                                    $data = stripslashes($data);
                                    $data = htmlspecialchars($data);
                                    return $data;
                                }
                            ?>
                                                
                                                
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                                <label> 1. Are you Hypertensive? </label></br>
                                <input type="radio" name="hypertensive" value="1"
                                        <?php if (isset($_POST["hypertensive"]) && $_POST["hypertensive"] == "1") echo "checked";?>> Yes
                                <input type="radio" name="hypertensive" value="0"
                                        <?php if (isset($_POST["hypertensive"]) && $_POST["hypertensive"] == "0") echo "checked";?>> No 
                                <?php 
                                    if(isset($_POST["hypertensive"])) {
                                        $finished = true;
                                    }
                                ?>
                                <br><br>

                                <label> 2. Hypertensive in Family? </label></br>
                                <input type="radio" name="HYPNinFamily" 
                                        <?php if (isset($_POST["HYPNinFamily"]) && $_POST["HYPNinFamily"] == "1") echo "checked"; ?>
                                value= "1"> Yes
                                        <input type="radio" name="HYPNinFamily"
                                        <?php if (isset($_POST["HYPNinFamily"]) && $_POST["HYPNinFamily"] == "0") echo "checked"; ?>
                                value= "0"> No
                                <?php 
                                    if(isset($_POST["HYPNinFamily"])) {
                                        $finished1 = true;
                                    }
                                ?>
                                <br><br>

                                <label> 3. Are you Diabetic : </label></br>
                                <input type="radio" name="Diabetic"
                                        <?php if (isset($_POST["Diabetic"]) && $_POST["Diabetic"] == "1") echo "checked" ?>
                                value= "1"> Yes
                                <input type="radio" name="Diabetic"
                                        <?php if (isset($_POST["Diabetic"]) && $_POST["Diabetic"] == "0") echo "checked" ?>
                                value= "0"> No
                                <?php 
                                    if(isset($_POST["Diabetic"])) 
                                        $finished2 = true;
                                ?>
                                <br><br>

                                <label> 4. Diabetic in Family? </label></br>
                                <input type="radio" name="DBTSinFamily"
                                        <?php if (isset($_POST["DBTSinFamily"]) && $_POST["DBTSinFamily"] == "1") echo "checked"; ?>
                                value= "1"> Yes
                                <input type="radio" name="DBTSinFamily"
                                        <?php if (isset($_POST["DBTSinFamily"]) && $_POST["DBTSinFamily"] == "0") echo "checked"; ?>
                                value= "0"> No
                                <?php 
                                    if(isset($_POST["DBTSinFamily"])) 
                                        $finished3 = true;
                                ?>
                                <br><br>

                                <label> 5. Have you ever experienced a Heart Attack? </label></br>
                                <input type="radio" name="heartAttack"
                                        <?php if (isset($_POST["heartAttack"]) && $_POST["heartAttack"] == "1") echo "checked" ?>
                                value= "1"> Yes
                                <input type="radio" name="heartAttack"
                                        <?php if (isset($_POST["heartAttack"]) && $_POST["heartAttack"] == "0") echo "checked" ?>
                                value= "0"> No
                                <?php 
                                    if(isset($_POST["heartAttack"])) 
                                        $finished4 = true;
                                ?>
                                <br><br>

                                <label> 6. Are you a Smoker? </label></br>
                                <input type="radio" name="smoking"
                                        <?php if (isset($_POST["smoking"]) && $_POST["smoking"] == "1") echo "checked" ?>
                                value= "1"> Yes
                                <input type="radio" name="smoking"
                                        <?php if (isset($_POST["smoking"]) && $_POST["smoking"] == "0") echo "checked" ?>
                                value= "0"> No
                                <?php 
                                    if(isset($_POST["smoking"])) 
                                        $finished5 = true;
                                ?>
                                <br><br>

                                <label> 7. Have you ever feel Dizziness? </label></br>
                                <input type="radio" name="dizziness"
                                        <?php if (isset($_POST["dizziness"]) && $_POST["dizziness"] == "1") echo "checked" ?>
                                value= "1"> Yes
                                <input type="radio" name="dizziness"
                                        <?php if (isset($_POST["dizziness"]) && $_POST["dizziness"] == "0") echo "checked" ?>
                                value= "0"> No
                                <?php 
                                    if(isset($_POST["dizziness"])) 
                                        $finished6 = true;
                                ?>
                                <br><br>

                                <label> 8. Do you have Dry tongue? </label></br>
                                <input type="radio" name="dryTongue"
                                        <?php if (isset($_POST["dryTongue"]) && $_POST["dryTongue"] == "1") echo "checked" ?>
                                value= "1"> Yes
                                <input type="radio" name="dryTongue"
                                        <?php if (isset($_POST["dryTongue"]) && $_POST["dryTongue"] == "0") echo "checked" ?>
                                value= "0"> No
                                <?php 
                                    if(isset($_POST["dryTongue"])) 
                                        $finished7 = true;
                                ?>
                                <br><br>

                                <label> 9. Have you ever feel Numbness in your body? </label></br>
                                <input type="radio" name="numbness"
                                        <?php if (isset($_POST["numbness"]) && $_POST["numbness"] == "1") echo "checked" ?>
                                value= "1"> Yes
                                        <input type="radio" name="numbness"
                                        <?php if (isset($_POST["numbness"]) && $_POST["numbness"] == "0") echo "checked" ?>
                                value= "0"> No
                                <?php 
                                    if(isset($_POST["numbness"])) 
                                        $finished8 = true;
                                ?>
                                <br><br>

                                <label style="width: 150px"> 10. Height: </label>
                                <input type="text" name="height" value="<?php echo $height;?>"> cm
                                <!-- <span class="error">* <?php echo $err; ?></span> -->
                                <?php 
                                    if(isset($_POST["height"])) 
                                        $finished9 = true;
                                ?>
                                <br><br>
                                <label style="width: 150px"> 11. Weight: </label>
                                <input type="text" name="weight" value="<?php echo $weight;?>">
                                <select name="wgtunit">
                                    <option value="kg">kg</option>
                                    <option value="lbs">lbs</option>
                                </select>
                                <!-- <span class="error">* <?php echo $err; ?></span> -->
                                <?php 
                                    if(isset($_POST["weight"]) && isset($_POST["wgtunit"])){
                                        if($_POST["wgtunit"]=="lbs"){
                                            $weight *= 0.45;
                                        }
                                        echo "weight in kg: $weight";
                                        $finished10 = true;
                                    }
                                ?>
                                <br><br>
                                <label style="width: 150px"> 12. Waist: </label>
                                <input type="text" name="waist" value="<?php echo $waist;?>">
                                <select name="wstunit">
                                    <option value="cm">cm</option>
                                    <option value="inch">inch</option>
                                </select>
                                <!-- <span class="error">* <?php echo $err; ?></span> -->
                                <?php 
                                    if(isset($_POST["waist"]) && isset($_POST["wstunit"])){
                                        if($_POST["wstunit"]=="inch"){
                                            $waist *= 2.54;
                                        }
                                        echo "waist in cm: $waist";
                                        $finished11 = true;
                                    } 
                                ?>
                                <br><br>
                            
                                <button type="submit" class="btn btn-primary"> Submit </button>

                            
                            </form>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">Result</h1>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?php
                                if ($finished && $finished1 && $finished2 && $finished3 && $finished4 && $finished5 && $finished6 && $finished7 && $finished8 && $finished9 && $finished10 && $finished11){
                                    if(is_numeric($height) && is_numeric($weight) && is_numeric($waist)){
                                        $height /= 156.4506;
                                        $weight /= 60.3399;
                                        $waist /= 87.4219;

                                        $result1 = 0.0;
                                        $result1 += 0.5862 * $hypertensive;
                                        $result1 += -0.0227 * $HYPNinFamily;
                                        $result1 += 0.3443 * $Diabetic;
                                        $result1 += -0.0607 * $DBTSinFamily;
                                        $result1 += -0.017 * $heartAttack;
                                        $result1 += 0.2008 * $smoking;
                                        $result1 += -0.1306 * $dizziness;
                                        $result1 += 0.0317 * $dryTongue;
                                        $result1 += -0.081 * $numbness;
                                        $result1 += -1.1563 * $height;
                                        $result1 += 0.3765 * $weight;
                                        $result1 += 0.2562 * $waist;
                                        
                                        if ($result1 >= 0.0){
                                            echo "<h3></br>High risk of hypertension!</br></h3>";
                                        }
                                        else{
                                            echo "<h3></br>Low risk of hypertension!</br></h3>";
                                        }

                                        $result2 = 0.0;
                                        $result2 += 0.4335 * $hypertensive;
                                        $result2 += -0.1179 * $HYPNinFamily;
                                        $result2 += 1.0558 * $Diabetic;
                                        $result2 += 0.5428 * $DBTSinFamily;
                                        $result2 += 0.2123 * $heartAttack;
                                        $result2 += 0.0322 * $smoking;
                                        $result2 += 0.2951 * $dizziness;
                                        $result2 += 0.2945 * $dryTongue;
                                        $result2 += 0.3785 * $numbness;
                                        $result2 += -1.5721 * $height;
                                        $result2 += 0.1668 * $weight;
                                        $result2 += 0.2354 * $waist;

                                        if ($result2 >= 0.0){
                                            echo "<h3></br>High risk of hyperglycaemia!</br></h3>";
                                        }
                                        else{
                                            echo "<h3></br>Low risk of hyperglycaemia!</br></h3>";
                                        }
                                    }
                                    else{
                                        echo "<h3> Invalid input!</h3>";
                                    }
                                }
                                else{
                                    echo "<h3>See result once you finished all questions!</h3>";
                                }
                                
                            ?>
                            </div>
                    </div>
        </div>
    </div>
</div>
        <!-- /#page-wrapper

    </div>
    <!-- /#wrapper -->
<!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../bower_components/raphael/raphael-min.js"></script>
    <script src="../bower_components/morrisjs/morris.min.js"></script>
    <script src="../js/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="js/getsession.js"></script>
    
</body>

</html>
