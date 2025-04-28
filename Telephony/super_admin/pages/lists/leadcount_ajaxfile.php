<?php
session_start();
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
include "../../../conf/db.php";
header('Content-Type: application/json');

$Adminuser = $_SESSION['user'] ?? null;

if ($con->connect_error) {
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

if (isset($_POST['list_id'])) {
    $list_id = $con->real_escape_string($_POST['list_id']);

    $usersql2 = "SELECT COUNT(*) as count_lead FROM `upload_data` WHERE dial_status='NEW' AND list_id=?";
    $stmt = $con->prepare($usersql2);
    $stmt->bind_param('i', $list_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    echo json_encode(['count' => $row['count_lead']]);
} else {
    echo json_encode(['error' => 'list_id not provided']);
}

$con->close();
?>
