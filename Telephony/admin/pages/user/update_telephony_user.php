<?php
include "../../../conf/db.php";
include "../../../conf/Get_time_zone.php";
session_start();
$user_level = $_SESSION['user_level'];

if ($user_level == 7 || $user_level == 6 || $user_level == 2) {
    $Adminuser = $_SESSION['admin'];
    $new_user = $_SESSION['user'];
    $new_campaign = $_SESSION['campaign_id'];
} else {
    $Adminuser = $_SESSION['user'];
}

 $c_number = $_POST['c_number'];
// echo "</br>";
 $edit_name_c = $_POST['edit_name_c'];
// echo "</br>";
 $use_did = $_POST['use_did'];
 $password_new = $_POST['password_new'];
 $user_lable_new = $_POST['user_lable_new'];
 $new_user_priority = $_POST['user_priority'];
 $external_num = $_POST['external_num'];
 $allocated_clients = $_POST['allocated_clients'];


    // Update user details without changing agent priority
    $update = "UPDATE `users` SET 
        `password`='$password_new', 
        `full_name`='$edit_name_c', 
        `use_did`='$use_did', 
        `user_type`='8',
        `ext_number`='$external_num', 
        `allocated_clients`='$allocated_clients'
         WHERE `user_id`='$c_number'";

  
// Update additional tables
$updatetwo = "UPDATE `vicidial_users` SET `pass`='$password_new', `user_level`='$user_lable_new' WHERE `user`='$c_number'";
mysqli_query($conn, $updatetwo);
$updatethree = "UPDATE `phones` SET `pass`='$password_new', `login_pass`='$password_new', `conf_secret`='$password_new' WHERE `extension`='$c_number'";
mysqli_query($conn, $updatethree);

// Execute the main user update query
$usersresult = mysqli_query($con, $update);
if ($usersresult) {
    echo "ok";
} else {
    echo "Not ok";
}

?>