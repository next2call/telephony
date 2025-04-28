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

        $sql_log_very = "SELECT status FROM login_log WHERE user_name = '" . $username . "' AND status = '1' AND DATE(log_in_time) = '$date'";
        // die();
        $query_log_very = mysqli_query($con, $sql_log_very); 
        if(mysqli_num_rows($query_log_very) > 0){ 
           
             $msg = 'This user Already login other PC';

        }else{
        $_SESSION['user_id'] = $row['user_id']; 
        $_SESSION['user'] = $row['user'];
        $_SESSION['pass'] = $row['pass'];
        $_SESSION['user_admin'] = $rowa['admin'];
        $_SESSION['user_level'] = $row['user_level']; 
        header('location:agentlogin.php');
      }
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
    #password-feedback {
    font-size: 10px;
    font-weight: bold;
    margin-top: 15px;
    margin-right: 25px;
}
#password-update {
    font-size: 10px;
    font-weight: bold;
    margin-top: 15px;
    margin-right: 25px;
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
                                <a href="check_db/check_cunnection.php"><span></span> Check Database Cunnection</a>
                                <a href="check_db/check_server_ip.php"><span></span> Check Server IP</a>
                                <a href="#add-user" data-toggle="modal" data-target="#add-user"><span></span>Create User</a>
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


    <div class="modal fade" id="add-user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="myForm_insert_data" method="POST">
                <div class="modal-body">

                    <div class="row">
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">

                                <input type="text" class="form-control" id="new-user-number" name="user_id"
                                    aria-describedby="new-user-no"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                    maxlength="8" required>
                                <label for="new-user-number">User ID</label>
                            </div>

                        </div>
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">

                                <input type="text" class="form-control" id="full-name" name="full_name"
                                    aria-describedby="full-name" required>
                                <label for="full-name">Full Name</label>
                            </div>

                        </div>
               
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">
                                <input type="text" class="form-control" id="Organization" name="use_did"
                                    aria-describedby=""
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                    maxlength="12">
                                <label for="password">Use DID </label>
                            </div>
                        </div>
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">

                                <input type="password" class="form-control" id="password" name="pass"
                                    aria-describedby="password" maxlength="15" required
                                    oninput="validatePassword(this)">
                                <label for="password">password</label>
                                <span id="password-feedback" class="form-text text-danger" style="display: none;">
            Password must be 12 to 15 characters long and contain only letters and numbers. Special characters are not allowed.
        </span>
                            </div>

                        </div>
                        <script>
    function validatePassword(input) {
        const feedback = document.getElementById('password-feedback');
        // Remove special characters and update input value 
        input.value = input.value.replace(/[^A-Za-z0-9]/g, '');

        // Validate password length
        if (input.value.length < 12 || input.value.length > 15) {
            feedback.style.display = 'block'; // Show error message
        } else {
            feedback.style.display = 'none'; // Hide error message
        }
    }
</script>
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">
                                <input type="int" class="form-control" id="external_num" name="external_num"
                                    aria-describedby="external_num"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                    maxlength="10">
                                <label for="Extername Number">Mobile Number</label>
                            </div>
                        </div>
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">
                                <input type="email" class="form-control" id="email_id" name="email">
                                <label for="Extername Number">Email </label>
                            </div>
                        </div>
                    

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary my-btn-secondary" data-dismiss="modal">Cancel
                    </button>
                    <button type="button" class="btn btn-primary my-btn-primary" onclick="saveData()">Submit</button>

                </div>
            </form>
        </div>
    </div>
</div>

    <!-- All the js files here -->
    <script src="./assets/js/jquery.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
    <script src="./assets/js/chart.min.js"></script>
    <script src="./assets/js/custom.js"></script>
    <script src="./assets/js/inputField.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">

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
    <script>
    function saveData() {
        var formData = new FormData(document.getElementById('myForm_insert_data'));

        $.ajax({
    type: 'POST',
    url: "check_db/create_user.php",
    data: formData,
    processData: false,
    contentType: false,
    dataType: 'json', // Expect JSON response
    success: function (response) {
        Swal.fire({
            icon: response.status === "success" ? "success" : "error",
            title: response.message,
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        }).then(() => {
            if (response.status === "success") {
                $('#add-user').modal('hide'); // Hide modal
                $('#add-user').find('form')[0].reset(); // Reset form
            }
        });
    },
    error: function () {
        Swal.fire({
            icon: "error",
            title: "An unexpected error occurred. Please try again.",
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
    }
});

    }
</script>
</body>

</html>