<?php
require '../conf/db.php';
include "../conf/Get_time_zone.php";

session_start();
$username = $_SESSION['user'];
$campaign_id = $_SESSION['campaign_id'];

$date_time = date("Y-m-d H:i:s");
$date = date("Y-m-d");

$date_time_timestamp = strtotime($date_time);
$start_time_timestamp = strtotime($start_time_new);

// Calculate duration in seconds (absolute value)
$break_duration_seconds = abs($start_time_timestamp - $date_time_timestamp);

// Convert duration to hours, minutes, and seconds
$hours = floor($break_duration_seconds / 3600);
$minutes = floor(($break_duration_seconds % 3600) / 60);
$seconds = $break_duration_seconds % 60;

// Format the duration as H:i:s
$formatted_duration = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);



 $pause = filter_input(INPUT_GET, 'break_type', FILTER_SANITIZE_STRING);


$select = "SELECT * FROM break_time WHERE start_time LIKE '%$date%' AND (status='2' OR  status='1') AND user_name='$username' ORDER BY id DESC Limit 1";
 $qury = mysqli_query($con,$select);    
 $row = mysqli_fetch_assoc($qury);
 $id = $row['id'];
 $break_name = $row['break_name'];
 $status = $row['status'];
 $mobile_no = $row['mobile_no'];
 $campaign_id = $row['campaign_id'];
 $press_key = $row['press_key'];
 $agent_priorty = $row['agent_priorty'];
 


 if($pause=='Ready'){

  echo 'match pause';


if($break_name=='mobile'){
    $break_update = "UPDATE `break_time` SET `break_duration`='$formatted_duration', `end_time`='$date_time', `break_status`='2', `status`='1' WHERE id='$id'";
    mysqli_query($con, $break_update);

    $break_insert = "INSERT INTO `break_time`(`user_name`, `mobile_no`, `break_name`, `start_time`, `break_status`, `status`, `campaign_id`, `press_key`, `agent_priorty`, take_call_mobile) VALUES ('$username','$mobile_no','$pause','$date_time','2','2','$campaign_id','$press_key','$agent_priorty','$pause')";
    mysqli_query($con, $break_insert);
}else{

    $break_update = "UPDATE `break_time` SET `break_duration`='$formatted_duration', `end_time`='$date_time', `break_status`='2', `status`='2' WHERE id='$id'";
     mysqli_query($con, $break_update);
}


 }elseif($pause=='mobile'){

    echo 'match pause call_mobile';

    $break_update = "UPDATE `break_time` SET `break_status`='2', `status`='1' WHERE id='$id'";
    mysqli_query($con, $break_update);

    $break_insert = "INSERT INTO `break_time`(`user_name`, `mobile_no`, `break_name`, `start_time`, `break_status`, `status`, `campaign_id`, `press_key`, `agent_priorty`, take_call_mobile) VALUES ('$username','$mobile_no','$pause','$date_time','1','2','$campaign_id','$press_key','$agent_priorty','$pause')";
    mysqli_query($con, $break_insert);

 }else{

    echo 'Nomatch pause';

    // $break_update = "UPDATE `break_time` SET `break_status`='2', `status`='1' WHERE id='$id'";
    // mysqli_query($con, $break_update);

    $break_update = "UPDATE `break_time` SET `break_duration`='$formatted_duration', `end_time`='$date_time', `break_status`='2', `status`='1' WHERE id='$id'";
    mysqli_query($con, $break_update);

    $break_insert = "INSERT INTO `break_time`(`user_name`, `mobile_no`, `break_name`, `start_time`, `break_status`, `status`, `campaign_id`, `press_key`, `agent_priorty`) VALUES ('$username','$mobile_no','$pause','$date_time','1','1','$campaign_id','$press_key','$agent_priorty')";
    mysqli_query($con, $break_insert);

 }
