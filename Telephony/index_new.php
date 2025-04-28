<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'conf/db.php';
// require 'conf/Get_time_zone.php';
require 'conf/sql_operation.php';

$sqlO = new sql_operation;
$msg = null;

$user = $_SESSION['user'] ?? '';
$npass = $_SESSION['pass'] ?? '';
$user_level = $_SESSION['user_level'] ?? '';
$newuser = '';
$newpass = '';
// if (!empty($user)) {
//     $newuser = 'value="'. htmlspecialchars($user) .'" readonly';
//     $newpass = 'value="'. htmlspecialchars($npass) .'" readonly';
// }

// if (isset($user) && $user_level == 8) {
//     header('location: admin/index.php');
//     exit;
// } elseif (isset($user) && $user_level == 1) {
//     if(isset($_SESSION['campaign_id'])){
//         header('location: agent/index.php');
//         exit;
//     } else {
//         header('location: agentlogin.php');
//         exit;
//     }
// } elseif (isset($user) && $user_level == 2) {
//     header('location: agentlogin.php');
//     exit;
// } elseif (isset($user) && $user_level == 9) {
//     header('location: super_admin/index.php');
//     exit;
// }

// $date_time = date("Y-m-d H:i:s");

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        // Prepared statement to prevent SQL injection
        $stmt = $con->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $stmt2 = $conn->prepare("SELECT * FROM vicidial_users WHERE user = ?");
            $stmt2->bind_param('s', $username);
            $stmt2->execute();
          
            $userResult = $stmt2->get_result();
            $row = $userResult->fetch_assoc();
            if (isset($row['pass'])) {
                if ($password == $row['pass']) {
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['user'] = $row['user'];
                    $_SESSION['pass'] = $row['pass'];
                    $_SESSION['user_level'] = $row['user_level'];

                    if ($row['user_level'] == 1 && $row['active'] == 'Y') {
                        header('location: agentlogin.php');
                        exit;
                    } elseif ($row['user_level'] == 8) {
                        header('location: admin/index.php');
                        exit;
                    } elseif ($row['user_level'] == 2) {
                        header('location: agentlogin.php');
                        exit;
                    } elseif ($row['user_level'] == 9) {
                        header('location: super_admin/index.php');
                        exit;
                    }
                } else {
                    echo "Not ok"; 
                }
            } else {
                echo "Password field is missing";
            }
        } else {
            echo "Invalid Username";
        }
    } else {
        echo "Please enter both username and password";
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
                            echo '<span class="error-msg">"'. $msg .'"</span>';
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