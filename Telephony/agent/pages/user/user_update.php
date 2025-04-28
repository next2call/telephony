<?php
session_start();
require '../../../conf/db.php';
include "../../../conf/Get_time_zone.php";
require '../../../conf/url_page.php';

$user = $_SESSION['user'];
$nidd = $_POST['get_id'];
$user_id = $_POST['user_id'];
$full_name = $_POST['edit_name_c'];
$mobile = $_POST['mobile'];
$email_id = $_POST['email_id'];
$password_new = $_POST['password_new'];
$profile_img = $_FILES['profile_img']['name'];
$temp_profile = $_FILES['profile_img']['tmp_name'];

// Define the upload directory
$upload_dir = 'profile_img/';
$upload_path = $upload_dir . basename($profile_img);

// Upload the profile image if provided
if (!empty($profile_img)) {
    move_uploaded_file($temp_profile, $upload_path);
}

$date = date("Y-m-d h:i:s");

// Update `vicidial_users`
$updatetwo = "UPDATE `vicidial_users` SET `pass`='$password_new' WHERE `user`='$user'";
mysqli_query($conn, $updatetwo);

// Update `phones`
$updatethree = "UPDATE `phones` SET `pass`='$password_new', `login_pass`='$password_new', `conf_secret`='$password_new' WHERE `extension`='$user'";
// $updatethree = "UPDATE `phones` SET `phone_ip`='10.101.1.16', `computer_ip`='10.101.1.16', `server_ip`='192.168.125.241', `pass`='$password_new', `login_pass`='$password_new', `conf_secret`='$password_new' WHERE `extension`='$user'";
mysqli_query($conn, $updatethree);

$stmtA = "UPDATE servers SET rebuild_conf_files='Y' where generate_vicidial_conf='Y' and active_asterisk_server='Y' and server_ip='$Local_ip'";
// $rslt=mysql_to_mysqli($stmtA, $link);
mysqli_query($conn, $stmtA); 

// Update `users`
$update_one = "UPDATE `users` SET 
    `password`='$password_new', 
    `full_name`='$full_name', 
    `ext_number`='$mobile',
    `admin_email`='$email_id'";

if (!empty($profile_img)) {
    $update_one .= ", `admin_profile`='$profile_img'";
}

$update_one .= " WHERE `id`='$nidd'";

$uupdate = mysqli_query($con, $update_one); 

// Check and return response
if ($uupdate) {
    echo "ok";
} else {
    echo "Not ok";
}
?>
