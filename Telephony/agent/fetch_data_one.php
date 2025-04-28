<?php

session_start();
require '../conf/db.php';
include "../conf/Get_time_zone.php";

$user = $_SESSION['user'] ?? '';

header('Content-Type: application/json');

// Log any errors to a file
ini_set('log_errors', 1);
ini_set('error_log', 'error_log.txt');
error_reporting(E_ALL);

// Check connection
if ($con->connect_error) {
    error_log("Connection failed: " . $con->connect_error);
    die(json_encode(["error" => "Connection failed: " . $con->connect_error]));
}

// Retrieve the dialledNumber from the GET request and clean it
$dialledNumber = $_GET['dialledNumber'] ?? '';
$dialledNumber = preg_replace('/[^0-9]/', '', $dialledNumber);

if (empty($dialledNumber)) {
    error_log("Dialed number not provided");
    die(json_encode(["error" => "Dialed number not provided"]));
}

// SQL query to fetch campaign information
$sqlCampaignQuery = "
    SELECT sc.get_call_lunch 
    FROM break_time s 
    JOIN compaign_list sc ON s.campaign_id = sc.compaign_id 
    WHERE s.user_name = ?
";
error_log("SQL Campaign Query: " . $sqlCampaignQuery);

$sqlCampaign = $con->prepare($sqlCampaignQuery);

if ($sqlCampaign === false) {
    error_log("Prepare failed: " . $con->error);
    die(json_encode(["error" => "SQL prepare failed: " . $con->error]));
}

$sqlCampaign->bind_param("s", $user);
$sqlCampaign->execute();
$resultCampaign = $sqlCampaign->get_result();

if ($resultCampaign === false) {
    error_log("Execute failed: " . $sqlCampaign->error);
    die(json_encode(["error" => "SQL execute failed: " . $sqlCampaign->error]));
}

$rowCampaign = $resultCampaign->fetch_assoc();

$get_call_lunch = $rowCampaign['get_call_lunch'] ?? '';

if ($get_call_lunch === 'WEBFORM') {
    // SQL query to fetch data based on the dialled number using LIKE
    $sqlQuery = "SELECT * FROM company_info WHERE phone_number LIKE ? ORDER BY id DESC LIMIT 1";
    error_log("SQL Query: " . $sqlQuery);

    $sql = $con->prepare($sqlQuery);

    if ($sql === false) {
        error_log("Prepare failed: " . $con->error);
        die(json_encode(["error" => "SQL prepare failed: " . $con->error]));
    }

    $likeDialledNumber = "{$dialledNumber}%"; // Prepare the dialled number for the LIKE query
    $sql->bind_param("s", $likeDialledNumber);
    $sql->execute();

    $result = $sql->get_result();

    if ($result === false) {
        error_log("Execute failed: " . $sql->error);
        die(json_encode(["error" => "SQL execute failed: " . $sql->error]));
    }

    if ($result->num_rows > 0) {
        // Output data of all entries
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        echo json_encode($rows);
    } else {

        // echo json_encode(["error" => "No data found for the provided phone number"]);
        $sqlQuery_up = "SELECT * FROM upload_data WHERE phone_number LIKE ? ORDER BY id DESC LIMIT 1";
        error_log("SQL Query: " . $sqlQuery_up);
    
        $sql_up = $con->prepare($sqlQuery_up);
        $likeDialledNumber = "{$dialledNumber}%"; // Prepare the dialled number for the LIKE query
        $sql_up->bind_param("s", $likeDialledNumber);
        $sql_up->execute();
    
        $result_up = $sql_up->get_result();
        if ($result_up->num_rows > 0) {

        $rows = array();
        while ($row = $result_up->fetch_assoc()) {
            $rows[] = $row;
        }
        echo json_encode($rows);
          
        }else{
            
        // echo json_encode(["error" => "No data found for the provided phone number"]);

         }

    }

    $sql->close();
} else {
    echo json_encode(["get_call_lunch" => "None"]);
}

$sqlCampaign->close();
$con->close();

?>
