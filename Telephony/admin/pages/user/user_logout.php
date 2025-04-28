<?php
session_start();
include "../../../conf/db.php";
include "../../../conf/url_page.php";
include "../../../conf/Get_time_zone.php";
$user_level = $_SESSION['user_level'];
// $Adminuser = $_SESSION['user'];
$date = date("Y-m-d H:i:s");
$user_level = $_SESSION['user_level'];

if ($user_level == 7 || $user_level == 6 || $user_level == 2) {
    $Adminuser = $_SESSION['admin'];
    $new_user = $_SESSION['user'];
    $new_campaign = $_SESSION['campaign_id'];
} else {
    $Adminuser = $_SESSION['user'];
}


$agent_sql = "SELECT user_id FROM users WHERE admin=?";
$stmt = mysqli_prepare($con, $agent_sql);
mysqli_stmt_bind_param($stmt, 's', $Adminuser);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$agent_ids = [];
while ($row = mysqli_fetch_assoc($result)) {
    $agent_ids[] = $row['user_id'];
}
$agent_ids_str = implode("','", $agent_ids);

$up_date = "UPDATE `login_log` SET `log_out_time`=?, `status`='2', `Emg_log_out`='1', `emg_log_out_time`=? WHERE (`user_type`='1' OR `user_type`='2' OR `user_type`='6' OR `user_type`='7')  AND `admin`=? OR user_name IN ('$agent_ids_str')";
$stmt1 = mysqli_prepare($con, $up_date);
mysqli_stmt_bind_param($stmt1, 'sss', $date, $date, $Adminuser);
$usersresult = mysqli_stmt_execute($stmt1);

$up_date_two = "UPDATE `break_time` SET `break_name`='Logout', `end_time`=?, `break_status`='2', `status`='1' WHERE user_name IN ('$agent_ids_str')";
$stmt2 = mysqli_prepare($con, $up_date_two);
mysqli_stmt_bind_param($stmt2, 's', $date);
$break_result = mysqli_stmt_execute($stmt2);


if ($usersresult && $break_result) {
    // echo "All users logged out successfully.";
    header("Location: " . $ip_url . "index.php?c=user&v=user_list"); 
} else {
    header("Location: " . $ip_url . "index.php?c=user&v=user_list");
}
?>
