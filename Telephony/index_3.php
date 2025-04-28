<?php
session_start();
require 'conf/db.php';
require 'conf/Get_time_zone.php';
require 'conf/sql_operation.php';
$sqlO = new sql_operation;
$msg = null;

$user = $_SESSION['user'] ?? '';
$npass = $_SESSION['pass'] ?? '';
$user_level = $_SESSION['user_level'] ?? '';
$newuser = '';
$newpass = '';
if (!empty($user)) {
    $newuser = 'value="'. htmlspecialchars($user) .'" readonly';
    $newpass = 'value="'. htmlspecialchars($npass) .'" readonly';
    // echo $newuser;
    // die();
}



// var_dump($_SESSION);
// // Debugging output
// echo "User level: " . $_SESSION['user'] . "<br>";

if (isset($user) && $user_level == 8) {
    header('location: admin/index.php');
    exit;
} elseif (isset($user) && $user_level == 1) {
    if(isset($_SESSION['campaign_id'])){
        // header('location: agent/index.php');
        exit;
    } else {
        // header('location: agentlogin.php');
        exit;
    }
}  elseif (isset($user) && $user_level == 2) {
    // if(isset($_SESSION['campaign_id'])){
    //     header('location: agent/index.php');
    //     exit;
    // } else {
        header('location: agentlogin.php');
        exit;
    // }
} elseif (isset($user) && $user_level == 9) {
    header('location: admin/index.php');
    exit;
} 

$date_time=Date("Y-m-d h:i:s");
$date = Date("Y-m-d");


if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql_lcdb = "SELECT * from users where user_id ='" . $username . "'";
    $query_lcdb = mysqli_query($con, $sql_lcdb);
    if(mysqli_num_rows($query_lcdb) > 0){
        $sql = "SELECT * from vicidial_users where user ='" . $username . "' AND pass='" . $password . "'";
        $row = $sqlO->sql_execution($sql);
    if ($row['user_level'] == 1 && $row['active']== 'Y') {
        $rowa = mysqli_fetch_assoc($query_lcdb);
        // check condition user already login start code

        // $sql_log_very = "SELECT status FROM login_log WHERE user_name = '" . $username . "' AND status = '1' AND DATE(log_in_time) = '$date'";
        // // die();
        // $query_log_very = mysqli_query($con, $sql_log_very); 
        // if(mysqli_num_rows($query_log_very) > 0){ 
           
        //      $msg = 'This user Already login other PC';

        // }else{
        $_SESSION['user_id'] = $row['user_id']; 
        $_SESSION['user'] = $row['user'];
        $_SESSION['pass'] = $row['pass'];
        $_SESSION['user_admin'] = $rowa['admin'];
        $_SESSION['user_level'] = $row['user_level']; 
        header('location:agentlogin.php');
    //   }
        // check condition user already login end code

    } elseif ($row['user_level'] == 8) {
        header('location:admin/index.php');
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['user_level'] = $row['user_level'];
        $_SESSION['user'] = $row['user'];
        $_SESSION['pass'] = $row['pass'];
        $inse = "INSERT INTO `login_log`(`user_name`, `log_in_time`, `status`, `admin`, `user_type`, `emg_log_out`) VALUES ('$username','$date_time','1','$username','8','0')";
        mysqli_query($con,$inse);
    } elseif ($row['user_level'] == 2) {
        $rowa = mysqli_fetch_assoc($query_lcdb);
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['user_level'] = $row['user_level'];
        $_SESSION['admin'] = $rowa['admin'];
        $_SESSION['user'] = $row['user'];
        $_SESSION['pass'] = $row['pass'];
        $inse = "INSERT INTO `login_log`(`user_name`, `log_in_time`, `status`, `admin`, `user_type`, `emg_log_out`) VALUES ('$username','$date_time','1','$username','2','0')";
        mysqli_query($con,$inse);
        header('location:agentlogin.php');
    }  elseif ($row['user_level'] == 6 && $row['active'] == 'Y') {
        $rowa = mysqli_fetch_assoc($query_lcdb);
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['user_level'] = $row['user_level'];
        $_SESSION['admin'] = $rowa['admin'];
        $_SESSION['user'] = $row['user'];
        $_SESSION['pass'] = $row['pass'];
        $inse = "INSERT INTO `login_log`(`user_name`, `log_in_time`, `status`, `admin`, `user_type`, `emg_log_out`) VALUES ('$username','$date_time','1','$username','2','0')";
        mysqli_query($con,$inse);
        header('location:admin/index.php');
        exit();
    }  elseif ($row['user_level'] == 7 && $row['active'] == 'Y') {
        $rowa = mysqli_fetch_assoc($query_lcdb);
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['user_level'] = $row['user_level'];
        $_SESSION['admin'] = $rowa['admin'];
        $_SESSION['user'] = $row['user'];
        $_SESSION['pass'] = $row['pass'];
        $inse = "INSERT INTO `login_log`(`user_name`, `log_in_time`, `status`, `admin`, `user_type`, `emg_log_out`) VALUES ('$username','$date_time','1','$username','2','0')";
        mysqli_query($con,$inse);
        header('location:admin/index.php');
        exit();
    } elseif ($row['user_level'] == 9) {
        header('location: admin/index.php');
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['user_level'] = $row['user_level'];
        $_SESSION['user'] = $row['user'];
        $_SESSION['pass'] = $row['pass'];
    } else {
        $msg = "Invalid input";

    }
} else {
    $msg = "Invalid User Name"; 
}

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="https://next2call.com/assets/img/logo/logo5.png">
    <title>Dialer</title>

    <!-- All the css files here -->
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="./assets/css/font-awesome.min.css" />
    <link rel="stylesheet" href="./assets/css/style.css" />
    <style>
    .logo_img_main {
        /* height: 50px !important; */
        width: 15rem !important;
    }
    </style>
</head>

<body>
    <section>
        <div class="login">
            <div class="top-bar">
                <img src="./assets/images/dashboard/next2calld.png" class="logo_img_main" alt="" />
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="left">
                        <img src="./assets/images/login/sideImg1.png" alt="">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="right">
                        <h3>Log In</h3>

                        <form method="POST" action="" autocomplete="off">
                            <div class="login-options">
                                <div class="form-check">
                                    <!-- <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1"
                                       value="option1" checked> -->
                                    <!-- <label class="form-check-label" for="exampleRadios1">
                                    Administration
                                </label> -->
                                </div>
                                <!-- <div class="form-check">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2"
                                       value="option2">
                                <label class="form-check-label" for="exampleRadios2">
                                    TimeClock
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3"
                                       value="option3">
                                <label class="form-check-label" for="exampleRadios3">
                                    Agent
                                </label>
                            </div> -->
                            </div>
                            <?php

                        if (isset($msg)) {
                            echo '<span class="error-msg">'. $msg .'</span>';
                        }
                        ?>

                            <div class="form-group">
                                <input type="text" id="email" name="username" class="form-control" required>
                                <label class="form-control-placeholder" for="email">Username</label>
                            </div>
                            <div class="form-group">
                                <input type="password" id="password" name="password" class="form-control" required>
                                <label class="form-control-placeholder" for="password">Password</label>
                            </div>
                            <div class="form-group">
                                <div id="dynamicFieldsContainer"></div>
                            </div>

                            <!-- Will be needed later -->

                            <!-- <div class="remember-me">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                  Remember Me
                                </label>
                              </div>
                        </div> -->

                            <!-- Will be needed later -->
                            <input type="submit" class="btn btn-primary btn-block" value="Log In" name="submit" />

                        </form>
                        <div class="footer">
                            <div class="footer-links">
                                <!-- <a href="https://next2call.com/" target="_blank"><span></span> About Next2call</a> -->
                                <a href="#"><span></span> Condition of use</a>
                                <a href="#"><span></span> Privacy Notice</a>
                                <a href="#"><span></span> Need help?</a>
                            </div>
                            <!-- <a href="https://next2call.com/" target="_blank">
                                <p> Copyright &copy 2024 Next2call</p>
                            </a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- All the js files here -->
    <script src="./assets/js/jquery.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
    <script src="./assets/js/chart.min.js"></script>
    <script src="./assets/js/custom.js"></script>

    <script>
    function addField() {
        var dynamicFieldsContainer = document.getElementById('dynamicFieldsContainer');

        var inputWrapper = document.createElement('div');
        inputWrapper.classList.add('form-group');

        var input = document.createElement('input');
        input.type = 'text';
        input.name = 'dynamicField[]';
        input.classList.add('form-control');

        var label = document.createElement('label');
        label.classList.add('form-control-placeholder');
        label.textContent = 'Campaign';

        inputWrapper.appendChild(input);
        inputWrapper.appendChild(label);
        dynamicFieldsContainer.appendChild(inputWrapper);
    }
    </script>
</body>

</html>