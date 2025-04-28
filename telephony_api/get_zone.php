<?php 

include "db.php";

$extension = $_REQUEST['extension'];
$did_number = $_REQUEST['did_number'];

// Function to set timezone based on user_id
function setTimezoneByUserId($conn, $user_id) {
    $timezoneQuery = "SELECT user_timezone FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($timezoneQuery);
    $stmt->bind_param('s', $user_id);
    $stmt->execute();
    $timezoneResult = $stmt->get_result();
    if ($timezoneResult->num_rows > 0) {
        $timezoneRow = $timezoneResult->fetch_assoc();
        $user_timezone = $timezoneRow['user_timezone'];
        date_default_timezone_set($user_timezone);
        return $user_timezone;
    }
    return null;
}

if ($did_number) {
    // Get admin based on the campaign_number (did_number)
    $adminQuery = "SELECT admin FROM compaign_list WHERE campaign_number = ?";
    $stmt = $conn->prepare($adminQuery);
    $stmt->bind_param('s', $did_number);
    $stmt->execute();
    $adminResult = $stmt->get_result();

    if ($adminResult->num_rows > 0) {
        $adminRow = $adminResult->fetch_assoc();
        $admin = $adminRow['admin'];

        // Set the timezone using the admin's user_id
        $user_timezone = setTimezoneByUserId($conn, $admin);
    }

} else {
    // Get user details based on the extension
    $userLogQuery = "SELECT campaign_name, user_name FROM login_log WHERE user_name = ?";
    $stmt = $conn->prepare($userLogQuery);
    $stmt->bind_param('s', $extension);
    $stmt->execute();
    $userLogResult = $stmt->get_result();

    if ($userLogResult->num_rows > 0) {
        $userLogRow = $userLogResult->fetch_assoc();
        $user_name = $userLogRow['user_name'];

        // Get admin based on user_id
        $adminQuery = "SELECT admin FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($adminQuery);
        $stmt->bind_param('s', $user_name);
        $stmt->execute();
        $adminResult = $stmt->get_result();

        if ($adminResult->num_rows > 0) {
            $adminRow = $adminResult->fetch_assoc();
            $admin = $adminRow['admin'];

            // Set the timezone using the admin's user_id
            $user_timezone = setTimezoneByUserId($conn, $admin);
        }
    }

    // If no admin or user timezone found, default to the user's timezone
    if (!isset($user_timezone)) {
        $user_timezone = setTimezoneByUserId($conn, $extension);
    }
}

// Output the timezone
echo $user_timezone ?? 'Timezone not found';

?>
