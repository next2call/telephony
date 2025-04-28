<?php
session_start();
$user = $_SESSION['user'];
$campaign_id = $_SESSION['campaign_id'];
$present_time = date("Y-m-d H:i:s");

// Database connection
require '../conf/db.php';
include "../conf/Get_time_zone.php";

// Set response headers
header('Content-Type: application/json');

// Check connection
if ($con->connect_error) {
    echo json_encode([
        'success' => false,
        'message' => 'Connection failed: ' . $con->connect_error
    ]);
    exit();
}

// Fetch user level
$select1 = "SELECT * FROM `users` WHERE user_id='$user'";
$sel_query1 = mysqli_query($con, $select1);
$row_data = mysqli_fetch_assoc($sel_query1);
$user_level = $row_data['user_type'];

// Get form data
$company_name = $_POST['company_name'];
$employee_size = $_POST['employee_size'];
$industry = $_POST['industry'];
$country = $_POST['country'];
$city = $_POST['city'];
$department = $_POST['department'];
$designation = $_POST['designation'];
$email = $_POST['email'];
$name = $_POST['name'];
$phone_number = $_POST['phone_number'];
$phone_2 = $_POST['phone_2'];
$date = $_POST['date'];
$dialstatus = $_POST['dialstatus'];
$remark = $_POST['remark'];


$sel_cdr = "SELECT uniqueid FROM cdr WHERE call_from = '$phone_number' OR call_to = '$phone_number' ORDER BY id DESC LIMIT 1";
$qur_cdr = mysqli_query($con, $sel_cdr);

$sel_data = "SELECT uniqueid FROM live WHERE (call_from = '$phone_number' OR call_to = '$phone_number' OR Agent = '$user')";
$qur_data = mysqli_query($con, $sel_data); 

if(mysqli_num_rows($qur_data) > 0) {
    $get = mysqli_fetch_assoc($qur_data);
    $uniq_id = $get['uniqueid'];
} else {
    if(mysqli_num_rows($qur_cdr) > 0) {
        $get_cdr = mysqli_fetch_assoc($qur_cdr);
        $uniq_id = $get_cdr['uniqueid'];
    } else {
        $uniq_id = uniqid();
    } 
}

// Prepare and bind
if ($user_level == '1') {
    $stmt = $con->prepare("INSERT INTO company_info (cdr_uniqueid, company_name, employee_size, industry, country, city, department, designation, email, name, phone_number, phone_2, date, dialstatus, campaign_id, upload_user, ins_date, remark) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssssssssss", $uniq_id, $company_name, $employee_size, $industry, $country, $city, $department, $designation, $email, $name, $phone_number, $phone_2, $date, $dialstatus, $campaign_id, $user, $present_time, $remark);
} else {
    $stmt = $con->prepare("INSERT INTO company_info (cdr_uniqueid, company_name, employee_size, industry, country, city, department, designation, email, name, phone_number, phone_2, date, dialstatus, upload_user, ins_date, remark) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssssssssss", $uniq_id, $company_name, $employee_size, $industry, $country, $city, $department, $designation, $email, $name, $phone_number, $phone_2, $date, $dialstatus, $user, $present_time, $remark);
}

// Execute statement
if ($stmt->execute()) {
    // handleDelete($con, $user);
    echo json_encode([
        'success' => true,
        'message' => 'New record created successfully'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $stmt->error
    ]);
}

// Function to handle 'delete' status
// function handleDelete($con, $user) {
//     $stmtdelete = $con->prepare("DELETE FROM `live` WHERE `Agent` = ?");
//     $stmtdelete->bind_param('s', $user);
    
//     if (!$stmtdelete->execute()) {
//         error_log("Delete failed: " . $stmtdelete->error);
//     }
    
//     $stmtdelete->close();
// }

$stmt->close();
$con->close();
?>
