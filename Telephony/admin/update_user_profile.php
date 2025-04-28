<?php
include "../conf/db.php";
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
 $profile_img = $_FILES['profile_img']['name'];
 $temp_profile = $_FILES['profile_img']['tmp_name'];

 // Define the upload directory
 $upload_dir = 'img/';
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
        (!empty($compaign_id) ? ", `campaigns_id`='$compaign_id'" : "") . 
        " WHERE `user_id`='$c_number'";
 
  
// Update additional tables
$updatetwo = "UPDATE `vicidial_users` SET `pass`='$password_new' WHERE `user`='$c_number'";
mysqli_query($conn, $updatetwo);
$updatethree = "UPDATE `phones` SET `pass`='$password_new', `login_pass`='$password_new', `conf_secret`='$password_new' WHERE `extension`='$c_number'";
mysqli_query($conn, $updatethree);

// Execute the main user update query
$usersresult = mysqli_query($con, $update);
if ($usersresult) {
    echo "ok";
    // echo $profile_img;
} else {
    echo "Not ok";
}

?>