<?php
session_start();
include "../../../conf/db.php";
include "../../../conf/Get_time_zone.php";
$user_level = $_SESSION['user_level'];

if ($user_level == 2) {
    $user = $_SESSION['admin'];
    $new_user = $_SESSION['user'];
    $user_sql2 = "SELECT campaigns_id FROM `users` WHERE admin='$user' AND user_id='$new_user'";
    $user_query = mysqli_query($con, $user_sql2);
    if (!$user_query) {
        die("Query Failed: " . mysqli_error($con));
    }
    $row_compain = mysqli_fetch_assoc($user_query);
    $new_campaign = $row_compain['campaigns_id'];
} else if($user_level == 6 || $user_level == 7) {
    $user = $_SESSION['admin'];
    $new_user = $_SESSION['user'];
  } else {
    $user = $_SESSION['user'];
}

$to_date = date("Y-m-d");
$date_24 = date("Y-m-d h:i:s");
$agentid = $_SESSION['agent_name'];
$fromdate = $_SESSION['fromdate'];
$todate = $_SESSION['todate'];
$serch_type = $_SESSION['serch_type'];


// if ($user_level == 2) {
//     $condition_one = "AND compaign_list.compaign_id = '$new_campaign'";
// } else {
//     $condition_one = "AND '1=1'";
// }
if ($user_level == 2) {
    $condition_one = "AND compaign_list.compaign_id = '$new_campaign'";
    $lavel_condition = "cdr.admin = '$user'";
    $lavel_agent = "(cdr.call_from='$agentid' OR cdr.call_to='$agentid')";
  } else if($user_level == 9) {
    $condition_one = "'1=1'";
    $lavel_condition = "";
    $lavel_agent = "cdr.admin='$agentid'";
  } else if($user_level == 6 || $user_level == 7) {
    $condition_one = "AND '1=1'";
    $lavel_condition = "cdr.admin = '$user'";
    $lavel_agent = "(cdr.call_from='$agentid' OR cdr.call_to='$agentid')";
  } else {
    $condition_one = "AND '1=1'";
    $lavel_condition = "cdr.admin = '$user'";
    $lavel_agent = "(cdr.call_from='$agentid' OR cdr.call_to='$agentid')";
  }

if ($serch_type == 'date') {
    $query = "WITH RankedData AS (
        SELECT cdr.*, TIME_FORMAT(SEC_TO_TIME(cdr.dur), '%H:%i:%s') AS dur_formatted, 
               users.full_name, users.campaigns_id, compaign_list.compaignname, 
               ROW_NUMBER() OVER (PARTITION BY cdr.id ORDER BY cdr.id DESC) AS rn 
        FROM cdr 
        JOIN users ON users.user_id = cdr.call_to 
        JOIN compaign_list ON compaign_list.compaign_id = users.campaigns_id 
        WHERE DATE(cdr.start_time) BETWEEN '$fromdate' AND '$todate' 
          AND $lavel_condition $condition_one
    ) 
    SELECT * FROM RankedData WHERE rn = 1 ORDER BY id DESC";
} elseif ($serch_type == 'agent') {
    $query = "WITH RankedData AS (
        SELECT cdr.*, TIME_FORMAT(SEC_TO_TIME(cdr.dur), '%H:%i:%s') AS dur_formatted, 
               users.full_name, users.campaigns_id, compaign_list.compaignname, 
               ROW_NUMBER() OVER (PARTITION BY cdr.id ORDER BY cdr.id DESC) AS rn 
        FROM cdr 
        JOIN users ON users.user_id = cdr.call_to 
        JOIN compaign_list ON compaign_list.compaign_id = users.campaigns_id 
        WHERE $lavel_agent AND $lavel_condition $condition_one
    ) 
    SELECT * FROM RankedData WHERE rn = 1 ORDER BY id DESC";
} elseif ($serch_type == 'date-agent') {
    $query = "WITH RankedData AS (
        SELECT cdr.*, TIME_FORMAT(SEC_TO_TIME(cdr.dur), '%H:%i:%s') AS dur_formatted, 
               users.full_name, users.campaigns_id, compaign_list.compaignname, 
               ROW_NUMBER() OVER (PARTITION BY cdr.id ORDER BY cdr.id DESC) AS rn 
        FROM cdr 
        JOIN users ON users.user_id = cdr.call_to 
        JOIN compaign_list ON compaign_list.compaign_id = users.campaigns_id 
        WHERE DATE(cdr.start_time) BETWEEN '$fromdate' AND '$todate' 
          AND $lavel_agent AND $lavel_condition $condition_one
    ) 
    SELECT * FROM RankedData WHERE rn = 1 ORDER BY id DESC";
} else {
    $query = "WITH RankedData AS (
        SELECT cdr.*, TIME_FORMAT(SEC_TO_TIME(cdr.dur), '%H:%i:%s') AS dur_formatted, 
               users.full_name, users.campaigns_id, compaign_list.compaignname, 
               ROW_NUMBER() OVER (PARTITION BY cdr.id ORDER BY cdr.id DESC) AS rn 
        FROM cdr 
        JOIN users ON users.user_id = cdr.call_to 
        JOIN compaign_list ON compaign_list.compaign_id = users.campaigns_id 
        WHERE $lavel_condition $condition_one
    ) 
    SELECT * FROM RankedData WHERE rn = 1 ORDER BY id DESC LIMIT 100";
}

// die();
$result = mysqli_query($con, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

$filename = "Report.csv";
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: text/csv");

// Create a file pointer connected to the output stream
$output = fopen("php://output", 'w');

// Output CSV header
$header = array('Sr.', 'Agent Name', 'Agent', 'Call From', 'Did', 'Campaign Name', 'Start Time', 'Call End Time', 'Dur', 'Direction', 'Status', 'Hangup', 'Recording url');
fputcsv($output, $header, ',', '"');

$sr = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $direction = $row['direction'];
    if ($direction == 'outbound') {
        $call_from = $row['did'];
        $did = $row['call_from'];
    } else {
        $call_from = $row['call_from'];
        $did = $row['did'];
    }

    $full_name = $row['full_name'];
    $call_to = $row['call_to'];
    $start_time = $row['start_time'];
    $end_time = $row['end_time'];
    $dur = $row['dur_formatted'];
    $status = $row['status'];
    $hangup = $row['hangup'];
    $record_url = $row['record_url'];
    $compaignname = $row['compaignname'];

    fputcsv($output, array($sr, $full_name, $call_to, $call_from, $did, $compaignname, $start_time, $end_time, $dur, $direction, $status, $hangup, $record_url));
    $sr++;
}

fclose($output);
mysqli_close($con);
?>