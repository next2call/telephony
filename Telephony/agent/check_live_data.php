<?php
session_start();
require '../conf/db.php';
include "../conf/Get_time_zone.php";

header('Content-Type: application/json');

$user = $_SESSION['user'] ?? '';

// Log any errors to a file
ini_set('log_errors', 1);
ini_set('error_log', 'error_log.txt');
error_reporting(E_ALL);

// Check connection
if ($con->connect_error) {
    error_log("Connection failed: " . $con->connect_error);
    echo json_encode(["error" => "Connection failed: " . $con->connect_error]);
    exit;
}

// Retrieve the dialledNumber from the GET request and sanitize it
$dialledNumber = $_GET['dialledNumber'] ?? '';
$dialledNumber = preg_replace('/[^0-9]/', '', $dialledNumber);

if (empty($dialledNumber)) {
    error_log("Dialled number not provided");
    echo json_encode(["error" => "Dialled number not provided"]);
    exit;
}

// SQL query to fetch campaign information
$sqlCampaignQuery = "SELECT `status` FROM `live` WHERE call_to = ? OR call_from = ?";
$sqlCampaign = $con->prepare($sqlCampaignQuery);

if ($sqlCampaign === false) {
    error_log("Prepare failed: " . $con->error);
    echo json_encode(["error" => "SQL prepare failed: " . $con->error]);
    exit;
}

$sqlCampaign->bind_param("ss", $dialledNumber, $dialledNumber);
$sqlCampaign->execute();
$resultCampaign = $sqlCampaign->get_result();
$rowCampaign = $resultCampaign->fetch_assoc();

$status = $rowCampaign['status'] ?? null;

$sqlCampaign->close();
$con->close();

// Return the status in JSON format
if ($status) {
    echo json_encode(["status" => $status]);
} else {
    echo json_encode(["status" => "Not Found"]);
}
?>
 