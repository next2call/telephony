<?php
session_start();
require '../../../conf/db.php';
include "../../../conf/Get_time_zone.php";

// Get the user from the session
 $user = $_SESSION['user'];
 $get_data = $_SESSION['filter_type'];
// die();

if($get_data == 'total_data')
{
    $sql = "SELECT `id`, `call_from`, `call_to`, `start_time`, `end_time`, `dur`, `status`, `msg`, `record_url`, `direction` FROM `cdr` WHERE call_from='$user'";
}elseif($get_data == 'other_data'){
    $sql = "SELECT `id`, `call_from`, `call_to`, `start_time`, `end_time`, `dur`, `status`, `msg`, `record_url`, `direction` FROM `cdr` WHERE call_from='$user' AND status!='CANCEL' AND status!='ANSWER' AND status!='BUSY' ORDER BY id DESC";
}elseif($get_data == 'ansewer_data'){
    $sql = "SELECT `id`, `call_from`, `call_to`, `start_time`, `end_time`, `dur`, `status`, `msg`, `record_url`, `direction` FROM `cdr` WHERE call_from='$user' AND status='ANSWER' ORDER BY id DESC";
}elseif($get_data == 'cancel_data'){
    $sql = "SELECT `id`, `call_from`, `call_to`, `start_time`, `end_time`, `dur`, `status`, `msg`, `record_url`, `direction` FROM `cdr` WHERE call_from='$user' AND status='CANCEL' OR status='BUSY' ORDER BY id DESC";
}
// $sql = "SELECT `id`, `call_from`, `call_to`, `start_time`, `end_time`, `dur`, `status`, `msg`, `record_url` FROM `cdr` WHERE call_from='$user'";
$result = mysqli_query($con, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}
// else{
//     echo "Ok";
// }
// die();

// CSV file setup
$filename = "Report.csv";
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: text/csv");

// Create a file pointer connected to the output stream
$output = fopen("php://output", 'w');

// Output CSV header
$header = array('Id', 'call_from', 'call_to', 'start_time', 'end_time', 'dur', 'status', 'msg', 'record_url', 'direction');
fputcsv($output, $header, ',', '"');

// Output data from rows
while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, $row, ',', '"');
}

// Close the file pointer
fclose($output);

// Close the database connection
mysqli_close($con);


?>