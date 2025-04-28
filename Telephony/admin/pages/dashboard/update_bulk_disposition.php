<?php
session_start();
include "../../../conf/db.php";  // Include your database connection file

$user = $_SESSION['user'];
$user_level = $_SESSION['user_level'];
$list_id = $_SESSION['Get_list_id'];
$level_condition = "";

if ($user_level == 2 || $user_level == 6 || $user_level == 7) {
    $user = $_SESSION['admin'];  // Admin user
    $new_user = $_SESSION['user'];  // Original user
    $user_campaigns_id = $_SESSION['campaign_id'];
    $level_condition = "AND campaign_Id = '$user_campaigns_id'";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $old_disposition = $_POST['old_disposition'] ?? '';
    $new_disposition = $_POST['new_disposition'] ?? '';
    if (empty($old_disposition) || empty($new_disposition)) {
        echo json_encode(['success' => false, 'message' => 'Both dispositions are required.']);
        exit;
    }
    $sel_data = "SELECT COUNT(*) as total FROM upload_data WHERE dial_status = '$old_disposition' AND admin = '$user' AND list_id = '$list_id'";
    $sel_data_sql = mysqli_query($con, $sel_data);
    $row = mysqli_fetch_assoc($sel_data_sql);
    $count = $row['total'];
    if ($count > 0) {
        $query = "UPDATE upload_data SET dial_status = '$new_disposition', dial_count = dial_count + 1 WHERE dial_status = '$old_disposition' AND admin = '$user' AND list_id = '$list_id' $level_condition";
        $stmt = mysqli_query($con, $query);
        if ($stmt) {
            echo json_encode(['success' => true, 'message' => 'Disposition updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database query failed.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => '<b>'. $old_disposition . '</b> Status Data Not Found !']);
    }
    mysqli_close($con);
    exit;
}
?>