<?php
session_start();
require '../conf/db.php';
include "../conf/Get_time_zone.php";

$dialledNumber = $_POST['dialledNumber'] ?? '';

// Sanitize the input to avoid SQL injection
if (empty($dialledNumber)) {
    echo "";
    exit;
}

$dialledNumber = mysqli_real_escape_string($con, $dialledNumber); // Prevent SQL injection

// Query to get the employee name
$sqlCampaignQuery = "SELECT `name` FROM `employee` WHERE `number` = '$dialledNumber'"; 
$sqlCampaign = mysqli_query($con, $sqlCampaignQuery);

if ($sqlCampaign) {
    $row_data = mysqli_fetch_assoc($sqlCampaign);
    $name = $row_data['name'];
    if ($name) {
        echo $name; // Return the employee name
    } else {
        echo ""; // Return empty if no name found
    }
} else {
    echo ""; // If the query fails, return empty
}
?>
