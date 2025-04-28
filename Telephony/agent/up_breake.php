<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require '../conf/db.php';
include "../conf/Get_time_zone.php";

$select = "SELECT break_time.start_time, break_time.end_time, break_time.id FROM break_time JOIN users ON users.user_id=break_time.user_name WHERE users.admin='8080' AND break_time.end_time!=''";
$qury = mysqli_query($con, $select);    
while ($row = mysqli_fetch_assoc($qury)) {
    $start_time = $row['start_time'];
    $end_time = $row['end_time'];
    $id = $row['id'];

    // Convert start_time and end_time to timestamps
    $start_time_timestamp = strtotime($start_time);
    $end_time_timestamp = strtotime($end_time);

    if ($start_time_timestamp === false || $end_time_timestamp === false) {
        echo "<script>alert('Invalid date format in database')</script>";
        continue;
    }

    // Calculate duration in seconds (absolute value)
    $break_duration_seconds = abs($end_time_timestamp - $start_time_timestamp);

    // Convert duration to hours, minutes, and seconds
    $hours = floor($break_duration_seconds / 3600);
    $minutes = floor(($break_duration_seconds % 3600) / 60);
    $seconds = $break_duration_seconds % 60; 
    
    // Format the duration as H:i:s
    $formatted_duration = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    
    // Update the database with the formatted duration
    $updatedata = "UPDATE `break_time` SET break_duration='$formatted_duration' WHERE id='$id'";
   mysqli_query($con, $updatedata);
   //  if ($qury_up) {
   //      echo "<script>alert('Data Updated successfully')</script>";
   //  } else {
   //      echo "<script>alert('Data Not Updated')</script>";
   //  }
   //  die();
}
?>
