<?php
include "../../../conf/db.php";
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
 $profile_img = $_FILES['profile_img']['name'];
 $temp_profile = $_FILES['profile_img']['tmp_name'];

 
if ($new_timezone) {
    echo "$new_timezone";
    // echo $profile_img;
} else {
    echo "Not ok";
}

?>