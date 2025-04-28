<?php

include "db.php";

// Allow requests from any origin
header("Access-Control-Allow-Origin: *");

// Allow POST and GET methods
header("Access-Control-Allow-Methods: POST, GET");

// Allow specified headers
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// Set the content type for the response to JSON
header('Content-Type: application/json');

// Get request parameters
$startDate = $_REQUEST['start_date'];
$NDate = $_REQUEST['date'];
$EndDate = $_REQUEST['end_date'];
$number = $_REQUEST['number'];
$uniqueid = $_REQUEST['uniqueid'];
$api_key = $_REQUEST['api_key'];

// Function to handle errors
function respondWithError($message) {
    echo json_encode(["ERROR" => $message]);
    exit();
}

// Function to handle success
function respondWithSuccess($message) {
    echo json_encode(["SUCCESS" => $message]);
    exit();
}

// Check if API key is missing or blank
if (empty($api_key)) {
    respondWithError("API KEY IS MISSING");
}

// Check if API KEY is valid (using 'conn' for this database)
$stmt = $conn->prepare("SELECT admin, api_key FROM users WHERE api_key = ?");
$stmt->bind_param("s", $api_key);
$stmt->execute();
$stmt->bind_result($admin, $db_api_key);
$stmt->fetch();


if (empty($db_api_key)) {
    respondWithError("INVALID API KEY");
}
$stmt->close();

function fetchLogRecords($conn, $query, $params = []) {
    $stmt = $conn->prepare($query);
    if ($params) {
        $stmt->bind_param(str_repeat('s', count($params)), ...$params);
    }
    $stmt->execute();
    
    // // Debug: Print SQL query and parameters
    // echo "Query: " . $query . "<br>";
    // echo "Params: " . implode(", ", $params) . "<br>";

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $log = [];
        while ($row = $result->fetch_assoc()) {
            $log[] = [
                'Uniqueid' => $row['uniqueid'],
                'Number' => $row['call_from'],
                'DID/PRI' => $row['did'],
                'User' => $row['call_to'],
                'CallType' => $row['direction'],
                'CallStatus' => $row['status'],
                'CallDuration' => $row['dur'],
                'Date' => $row['start_time'],
                'hangup' => $row['hangup'],
                'record_url' => $row['record_url']
            ];
        }
        respondWithSuccess($log);
    } else {
        respondWithError("No records found");
    }
    $stmt->close();
}


// Handle different scenarios
if ($startDate && $EndDate && $number) {
    // Scenario 1: Filter by start date, end date, and phone number
    $query = "SELECT * FROM cdr WHERE DATE_FORMAT(start_time, '%Y-%m-%d') BETWEEN ? AND ? AND call_from = ? AND admin = ?";
    fetchLogRecords($conn, $query, [$startDate, $EndDate, $number, $admin]);

} elseif ($NDate && $number) {
    // Scenario 2: Filter by specific date and phone number
    $query = "SELECT * FROM cdr WHERE DATE_FORMAT(start_time, '%Y-%m-%d') = ? AND call_from = ? AND admin = ?";
    fetchLogRecords($conn, $query, ["$NDate", $number, $admin]);

} elseif ($startDate && $EndDate) {
    // Scenario 3: Filter by start date and end date
    $query = "SELECT * FROM cdr WHERE DATE_FORMAT(start_time, '%Y-%m-%d') BETWEEN ? AND ? AND admin = ?";
    fetchLogRecords($conn, $query, [$startDate, $EndDate, $admin]);

} else {
    respondWithError("SOMETHING WENT WRONG");
}

// Close the database connection
$conn->close();
?>
