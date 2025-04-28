<?php
session_start();
require '../conf/db.php';
include "../conf/Get_time_zone.php";

$user_admin = $_SESSION['user_admin'];
$tfnsel_1 = "SELECT caller_email, caller_contact FROM users WHERE admin = '$user_admin'";
$data_1 = mysqli_query($con, $tfnsel_1);
$user_row = mysqli_fetch_assoc($data_1);
$caller_email = $user_row['caller_email'];
$caller_contact = $user_row['caller_contact'];
// Sanitize the input to avoid SQL injection
if (empty($caller_contact == '1')) {
    echo "hide";
    exit;
} else {
    echo "Unhide"; // If the query fails, return empty
}
?>
