<?php
require '../conf/db.php';
include "../conf/Get_time_zone.php";
session_start();

$date = date("Y-m-d"); // Correct PHP date function

// Check if the session user exists
if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    $user = mysqli_real_escape_string($con, $_SESSION['user']); // Sanitize input

    // Fetch logout status from the database
    $sql_agent = "SELECT `emg_log_out` 
                  FROM `login_log` 
                  WHERE `emg_log_out_time` LIKE '%$date%' AND `user_name` = '$user' ORDER BY `id` DESC Limit 1";
    $sel_query = mysqli_query($con, $sql_agent);

    if (!$sel_query) {
        // Handle database query failure
        echo json_encode(['status' => 'error', 'message' => 'Database query failed.']);
        exit;
    }

    $users_row = mysqli_fetch_assoc($sel_query);
    $logout_status = $users_row['emg_log_out'] ?? null; // Null if no result

    if ($logout_status === '1') {
        // User is logged out, destroy session and return inactive status
        session_unset(); // Clear session variables
        session_destroy(); // Destroy the session

        echo json_encode(['status' => 'inactive']);
    } else {
        // User is active
        echo json_encode(['status' => 'active']);
    }
} else {
    // No user session, return inactive status
    echo json_encode(['status' => 'inactive']);
}
exit;
?>
