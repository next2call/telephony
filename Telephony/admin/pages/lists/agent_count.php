<?php
session_start();

// Include necessary files
include "../../../conf/db.php";
include "../../../conf/Get_time_zone.php";

header('Content-Type: application/json');

// Get the session user ID (admin)
$Adminuser = $_SESSION['user'] ?? null;


// Check database connection
if ($con->connect_error) {
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

// Use a static user ID for testing purposes (to be replaced by actual POST data)
// $user_id = '8080'; 
// Check if list_id is set in POST
if (isset($_POST['user_id'])) {
    // Get and sanitize list_id
    $user_id = trim($con->real_escape_string($_POST['user_id'])); // Trim and sanitize the list_id

// Validate and sanitize user ID
if (empty($user_id)) {
    echo json_encode(['error' => 'Invalid or empty user ID']);
    exit;
}

// SQL query to count leads based on admin user and user type
$usersql2 = "SELECT COUNT(*) as agent_count
             FROM `users`
             WHERE user_type = '1' 
             AND admin = ?";

// Prepare the SQL statement
$stmt = $con->prepare($usersql2);
if (!$stmt) {
    echo json_encode(['error' => 'Failed to prepare SQL statement']);
    exit;
}

// Bind the parameters
$stmt->bind_param('s', $user_id); // 's' indicates a string parameter

// Execute the SQL statement
if (!$stmt->execute()) {
    echo json_encode(['error' => 'Failed to execute query']);
    exit;
}

// Fetch the result
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Return the count of agents in JSON format
echo json_encode(['count' => $row['agent_count'] ?? 0]);

} else {
    // If list_id is not provided in the POST request
    echo json_encode(['error' => 'user_id not provided']);
}
// Close the statement and connection
$stmt->close();
$con->close();
?>
