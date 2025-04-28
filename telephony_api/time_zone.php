<?php 

include "db.php";

$extension = $_REQUEST['extension'];

// Prepare and execute the query to get the campaign name and user type
$userLogQuery = "SELECT campaign_name, user_name FROM login_log WHERE user_name = ?";
$stmt = $conn->prepare($userLogQuery);
$stmt->bind_param('s', $extension);
$stmt->execute();
$userLogResult = $stmt->get_result();

// Check if the user log query returned any results
if ($userLogResult->num_rows > 0) {
    $userLogRow = $userLogResult->fetch_assoc();
    $campaign_name = $userLogRow['campaign_name'];
    $user_name = $userLogRow['user_name'];

    // Prepare and execute the query to get the admin for the user
    $adminQuery = "SELECT admin FROM `users` WHERE user_id = ?";
    $stmt = $conn->prepare($adminQuery);
    $stmt->bind_param('s', $user_name);
    $stmt->execute();
    $adminResult = $stmt->get_result();
    $adminRow = $adminResult->fetch_assoc();
    $admin = $adminRow['admin'];

    // Prepare and execute the query to get the admin's user_timezone
    $timezoneQuery = "SELECT user_timezone FROM `users` WHERE user_id = ?";
    $stmt = $conn->prepare($timezoneQuery);
    $stmt->bind_param('s', $admin);
    $stmt->execute();
    $timezoneResult = $stmt->get_result();
    $timezoneRow = $timezoneResult->fetch_assoc();
    $user_timezone = $timezoneRow['user_timezone'];

    // Set the timezone to the admin's user_timezone
    date_default_timezone_set($user_timezone);

} else {
    // If no admin is found, get the user's timezone directly
    $timezoneQuery = "SELECT user_timezone FROM `users` WHERE user_id = ?";
    $stmt = $conn->prepare($timezoneQuery);
    $stmt->bind_param('s', $extension);
    $stmt->execute();
    $timezoneResult = $stmt->get_result();
    $timezoneRow = $timezoneResult->fetch_assoc();
    $user_timezone = $timezoneRow['user_timezone'];

    // Set the timezone to the user's timezone
    date_default_timezone_set($user_timezone);
}

// Output the timezone
// echo $time_zone = $user_timezone;

?>
