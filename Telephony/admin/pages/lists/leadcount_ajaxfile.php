<?php
session_start();
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
include "../../../conf/db.php";
include "../../../conf/Get_time_zone.php";

header('Content-Type: application/json');

// Get the session user ID (admin)
$Adminuser = $_SESSION['user'] ?? null;

if ($con->connect_error) {
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

// Check if list_id is set in POST
if (isset($_POST['list_id'])) {
    // Get and sanitize list_id
    $list_id = trim($con->real_escape_string($_POST['list_id'])); // Trim and sanitize the list_id

    // Ensure that list_id is not empty and it is an exact match
    if (empty($list_id)) {
        echo json_encode(['error' => 'Invalid or empty list_id']);
        exit;
    }

    // Prepare the SQL query to count leads based on admin, dial_status, and exact list_id
    $usersql2 = "SELECT COUNT(*) as count_lead 
                 FROM `upload_data` 
                 WHERE admin = ? 
                 AND dial_status = 'NEW' 
                 AND list_id = ?"; // Exact match for list_id
    
    // Prepare the SQL query
    $stmt = $con->prepare($usersql2);
    
    // Bind parameters: both $Adminuser and $list_id are expected to be integers and strings respectively
    $stmt->bind_param('is', $Adminuser, $list_id);  // 'i' for integer (Admin user), 's' for string (list_id)
    
    // Execute the query
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    // Return the count of leads in JSON format
    echo json_encode(['count' => $row['count_lead']]);
} else {
    // If list_id is not provided in the POST request
    echo json_encode(['error' => 'list_id not provided']);
}

$con->close();
?>
