<?php
session_start();
include "../../../conf/db.php";
include "../../../conf/url_page.php";
include "../../../conf/Get_time_zone.php";
$user_level = $_SESSION['user_level'];
// $Adminuser = $_SESSION['user'];
$date = date("Y-m-d H:i:s");


if ($user_level == 7 || $user_level == 6 || $user_level == 2) {
    $Adminuser = $_SESSION['admin'];
    $new_user = $_SESSION['user'];
    $new_campaign = $_SESSION['campaign_id'];
} else {
    $Adminuser = $_SESSION['user'];
}
$user_id = $_REQUEST['user_id'];

 $up_date = "UPDATE `login_log` SET `log_out_time`='$date', `status`='2', `Emg_log_out`='1', `emg_log_out_time`='$date' WHERE `user_type`='1' AND `admin`='$Adminuser' AND user_name IN ('$user_id')";
// die();
$usersresult = mysqli_query($con, $up_date);




$up_date_two = "UPDATE `break_time` SET `break_name`='Logout', `end_time`=?, `break_status`='2', `status`='1' WHERE user_name IN ('$user_id')";
$stmt2 = mysqli_prepare($con, $up_date_two);
mysqli_stmt_bind_param($stmt2, 's', $date);
$break_result = mysqli_stmt_execute($stmt2);


if ($usersresult && $break_result) {
    // echo "All users logged out successfully.";
    header("Location: " . $ip_url . "admin/index.php?c=user&v=user_list"); 
} else {
    header("Location: " . $ip_url . "admin/index.php?c=user&v=user_list");
}
?>
