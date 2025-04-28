<?php
include "db.php";
include "time_zone.php";


// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// date_default_timezone_set('Asia/Kolkata'); // Set the timezone to Indian Standard Time

// Get current date and time
$date = date("Y-m-d H:i:s");

// Sanitize and validate inputs
$uniqueid = filter_input(INPUT_GET, 'uniqueid', FILTER_SANITIZE_STRING);
$duration = filter_input(INPUT_GET, 'duration', FILTER_VALIDATE_INT);
$start_time = filter_input(INPUT_GET, 'start_time', FILTER_SANITIZE_STRING);
$end_time = filter_input(INPUT_GET, 'end_time', FILTER_SANITIZE_STRING);
$did = filter_input(INPUT_GET, 'did', FILTER_SANITIZE_STRING);
$call_to = filter_input(INPUT_GET, 'call_to', FILTER_SANITIZE_STRING);
$call_from = filter_input(INPUT_GET, 'call_from', FILTER_SANITIZE_STRING);
$status = filter_input(INPUT_GET, 'call_status', FILTER_SANITIZE_STRING);
$hangup = filter_input(INPUT_GET, 'hangup', FILTER_SANITIZE_STRING);
$direction = filter_input(INPUT_GET, 'direction', FILTER_SANITIZE_STRING);
$server_url = filter_input(INPUT_GET, 'server_url', FILTER_SANITIZE_URL);
$record_url = filter_input(INPUT_GET, 'record_url', FILTER_SANITIZE_URL);
$admin = filter_input(INPUT_GET, 'admin', FILTER_SANITIZE_STRING);
$campaign_id = filter_input(INPUT_GET, 'campaign_id', FILTER_SANITIZE_STRING);
$final_rec = $server_url . urlencode($record_url);

error_log("Starting script execution");

// Default values
$duration = $duration ?: 0;
$status = $status ?: 'NOAGENT';



// Validate required inputs
if (!$uniqueid || !$call_to || !$call_from || !$status || !$start_time) {
    echo "Missing required parameters";
    echo("Missing required parameters: uniqueid: $uniqueid, call_to: $call_to, call_from: $call_from, status: $status, start_time: $start_time");
    exit;
}



// Function to get admin status from the database
function getAdminStatus($conn, $call_to, $call_from, $did) {
    $query = "SELECT admin FROM users WHERE user_id = ? OR user_id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        echo("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        return null;
    }
    $stmt->bind_param('ss', $call_to, $call_from);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin_db = $result->fetch_assoc()['admin'] ?? null;
    $stmt->close();

    if (!$admin_db && $did) {
        $query = "SELECT admin FROM compaign_list WHERE campaign_number = ?";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            echo("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            return null;
        }
        $stmt->bind_param('s', $did);
        $stmt->execute();
        $result = $stmt->get_result();
        $admin_db = $result->fetch_assoc()['admin'] ?? null;
        $stmt->close();
    }

    return $admin_db;
}

// Function to update dial status
function updateDialStatus($conn, $status, $uniqueid, $call_to) {
    $update = "UPDATE upload_data SET dial_status = ?, uniqueid = ? WHERE phone_number = ? ORDER BY ins_date DESC LIMIT 1";
    $stmt = $conn->prepare($update);
    if (!$stmt) {
        error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        echo "Update error. Please check the logs.";
        return;
    }
    $stmt->bind_param('sss', $status, $uniqueid, $call_to);
    if (!$stmt->execute()) {
        error_log("Update error: " . $stmt->error);
        echo "Update error. Please check the logs.";
    }
    $stmt->close();
}

// Function to insert CDR record
function insertCDR($conn, $admin, $did, $uniqueid, $call_from, $call_to, $start_time, $end_time, $duration, $status, $final_rec, $direction, $hangup, $campaign_id) {
    $insert = "INSERT INTO cdr (admin, did, uniqueid, call_from, call_to, start_time, end_time, dur, status, record_url, direction, hangup, campaign_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert);
    if (!$stmt) {
        error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        echo "Insert error. Please check the logs.";
        return;
    }
    $stmt->bind_param('sssssssssssss', $admin, $did, $uniqueid, $call_from, $call_to, $start_time, $end_time, $duration, $status, $final_rec, $direction, $hangup, $campaign_id);
    if (!$stmt->execute()) {
        error_log("Insert error: " . $stmt->error);
        echo "Insert error. Please check the logs.";
    }
    $stmt->close();
}

error_log("Getting admin status");

// Use admin from the URL if it's provided and not empty, otherwise use the one from the database or default to "2020"
$admin_db = getAdminStatus($conn, $call_to, $call_from, $did);
$admin = $admin ?: $admin_db ?: "2020";

error_log("Admin status determined: $admin");

// Determine action based on call direction
if ($direction == 'outbound') {
    $hangup = $hangup ?: 'AGENT';
    updateDialStatus($conn, $status, $uniqueid, $call_to);
}else{
    $hangup = $hangup ?: 'CLIENT';

}

echo("Inserting CDR");

// Insert CDR record for all call directions
insertCDR($conn, $admin, $did, $uniqueid, $call_from, $call_to, $start_time, $end_time, $duration, $status, $final_rec, $direction, $hangup, $campaign_id);

$conn->close();
error_log("Script execution finished");
?>
