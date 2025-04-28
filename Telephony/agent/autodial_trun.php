<?php
require '../conf/db.php';
session_start();
include "../conf/Get_time_zone.php";

$user = $_SESSION['user'];

// Fetch user admin details
$sql_ddata = "SELECT * FROM users WHERE user_id = '$user'";
$result_data = mysqli_query($con, $sql_ddata);
$ad_user = mysqli_fetch_assoc($result_data);
$user_admin = $ad_user['admin'];

// Check if user has live data
$sel = "SELECT * FROM live WHERE Agent = '$user' OR call_to = '$user'";
$qur = mysqli_query($con, $sel);

$arr = []; // Initialize result array

if ((mysqli_num_rows($qur) > 0)) {
    echo "live";
} else {
    // Fetch data from upload_data excluding numbers present in live table
    $sel = "
        SELECT u.name, u.phone_number
        FROM upload_data u
        LEFT JOIN live l ON u.phone_number = l.call_to
        WHERE u.admin = '$user_admin' AND u.dial_status = 'NEW' AND l.call_to IS NULL
        LIMIT 1
    ";
    $qur = mysqli_query($con, $sel);
    if (mysqli_num_rows($qur) > 0) {
        while ($get = mysqli_fetch_assoc($qur)) {
            $arr[] = ['name' => $get['name'], 'number' => $get['phone_number']];
        }
    } else {
        // Additional fallback query
        $sel_two = "
            SELECT u.name, u.phone_number
            FROM upload_data u
            LEFT JOIN live l ON u.phone_number = l.call_to
            WHERE u.username = '$user' AND u.dial_status = 'NEW' AND l.call_to IS NULL
            LIMIT 1
        ";
        $qur_two = mysqli_query($con, $sel_two);
        if (mysqli_num_rows($qur_two) > 0) {
            while ($get_one = mysqli_fetch_assoc($qur_two)) {
                $arr[] = ['name' => $get_one['name'], 'number' => $get_one['phone_number']];
            }
        }
    }
}

// Return the result as JSON
echo json_encode($arr);
?>
