<?php
include "../../../conf/db.php";
include "../../../conf/url_page.php";

session_start();
$Adminuser = $_SESSION['user'];

 $c_number = $_POST['c_number'];
// echo "</br>";
 $edit_name_c = $_POST['edit_name_c'];
// echo "</br>";
 $use_did = $_POST['use_did'];
 $password_new = $_POST['password_new'];
 $user_lable_new = $_POST['user_lable_new'];
 $new_user_priority = $_POST['user_priority'];
 $external_num = $_POST['external_num'];

 $email_id = $_POST['email_id'];
 $mobile = $_POST['mobile'];
 $new_timezone = $_POST['new_timezone'];

 $get_hide_email = isset($_POST['get_hide_email']) ? $_POST['get_hide_email'] : 0; // Default to 0 if not checked
 $hide_number = isset($_POST['hide_number']) ? $_POST['hide_number'] : 0; // Default to 0 if not checked
 
 $profile_img = $_FILES['profile_img']['name'];
 $temp_profile = $_FILES['profile_img']['tmp_name'];

 // Define the upload directory
 $upload_dir = 'profile_img/';

 // Create the directory if it doesn't exist
//  if (!is_dir($upload_dir)) {
//     echo 'ok';
    //  mkdir($upload_dir, 0777, true);
//  } else {
//     echo 'not ok';
//  }

// die();
 // Define the full path where the file will be uploaded
 $upload_path = $upload_dir . basename($profile_img);
  move_uploaded_file($temp_profile, $upload_path);

$selected_values = json_decode($_POST['selected_values'], true); // Decoding the JSON encoded array
$compaign_id = isset($selected_values) ? implode(",", $selected_values) : '';

    // Update user details without changing agent priority
     $update = "UPDATE `users` SET 
        `password`='$password_new', 
        `full_name`='$edit_name_c', 
        `use_did`='$use_did', 
        `admin_email`='$email_id',
        
        `admin_mobile`='$mobile'".(!empty($profile_img) ? ", `admin_profile`='$profile_img'" : "").",
        `ext_number`='$external_num'" . 
        (!empty($compaign_id) ? ", `campaigns_id`='$compaign_id'" : "") . ", 
    `user_timezone` = '$new_timezone',
    `caller_email` = '$get_hide_email',
    `caller_contact` = '$hide_number'
    WHERE `user_id` = '$c_number'"; 
 
//   die();
// Update additional tables
$updatetwo = "UPDATE `vicidial_users` SET `pass`='$password_new' WHERE `user`='$c_number'";
mysqli_query($conn, $updatetwo);
$updatethree = "UPDATE `phones` SET `pass`='$password_new', `login_pass`='$password_new', `conf_secret`='$password_new' WHERE `extension`='$c_number'";
mysqli_query($conn, $updatethree);

$stmtA = "UPDATE servers SET rebuild_conf_files='Y' where generate_vicidial_conf='Y' and active_asterisk_server='Y' and server_ip='192.168.125.241'";
// $rslt=mysql_to_mysqli($stmtA, $link);
mysqli_query($conn, $stmtA);
// Execute the main user update query
$usersresult = mysqli_query($con, $update);
if ($usersresult) { 
    echo "ok";
    // echo $update;
} else {
    echo "Not ok";
    // echo $update;

}

?>