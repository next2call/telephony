<?php
session_start();
include "../../../conf/db.php";
include "../../../conf/Get_time_zone.php";


 $user = $_SESSION['user'];
 $from_date = $_SESSION['from_date_str'];
$to_date = $_SESSION['to_date_str'];
$user_id = $_SESSION['user_id_test'];

if(!empty($from_date) && !empty($to_date)){
 
    $sql = "SELECT id, user_name, log_in_time, log_out_time, status FROM login_log WHERE DATE(log_in_time) BETWEEN '$from_date' AND '$to_date' AND admin='$user_id' ORDER BY id DESC";

}elseif(!empty($user_id)){

    $sql = "SELECT id, user_name, log_in_time, log_out_time, status FROM login_log WHERE admin='$user_id' ORDER BY id DESC";

}else{
    
    $sql = "SELECT id, user_name, log_in_time, log_out_time, status FROM login_log WHERE admin='$user_id' ORDER BY id DESC";

}

$result = mysqli_query($con, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

// CSV file setup
$filename = "Report.csv";
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: text/csv");

// Create a file pointer connected to the output stream
$output = fopen("php://output", 'w');

// Output CSV header
$header = array('SR', 'USER ID', 'LOGIN TIME','WORKING HOURS', 'LOGOUT TIME', 'NO. OF BREAK', 'BREAK DURATION', 'BREAK NAME', 'INBOUND CALLS', 'OUTBOND CALLS', 'TOTAL CALLS', 'STATUS');
fputcsv($output, $header, ',', '"');

// Output data from rows
$sr = '1'; 
while ($row = mysqli_fetch_assoc($result)) {
    $user_name = $row['user_name'];
    $log_in_time = $row['log_in_time'];
    $log_out_time = $row['log_out_time'];
    $status = $row['status'];

    // Determine login/logout status
    $login_ss = ($status == '1') ? "Login" : "Logout";

    // Extract date
    $date_only = date('Y-m-d', strtotime($log_in_time));
      
    // Count number of breaks
    $sel_dis_one = "SELECT * FROM break_time WHERE start_time LIKE '%$date_only%' AND user_name LIKE '%$user_name%'";
    $qur_note_one = mysqli_query($con, $sel_dis_one);
    $no_of_day_break = mysqli_num_rows($qur_note_one);

    // Fetch break names
    $break_names = [];
    $break_duration = '';
    while ($Row_data = mysqli_fetch_assoc($qur_note_one)) {   
        $break_names[] = $Row_data['break_name'];
        $break_duration += $Row_data['break_duration'];
    }

    $total_minutes = round($break_duration);
$hours = floor($total_minutes / 60);
$minutes = $total_minutes % 60;
$seconds = 0;
$duration_formatted = sprintf("%02d:%02d", $hours, $minutes);

    // Calculate duration
    $start_time = strtotime($log_in_time);
    $end_time = strtotime($log_out_time);
    $durationInSeconds = $end_time - $start_time;
    $hours = floor($durationInSeconds / 3600);
    $minutes = floor(($durationInSeconds - ($hours * 3600)) / 60);
    $seconds = $durationInSeconds % 60;
    if(!empty($log_out_time)){
    $duration = $hours." : ".$minutes;
    } else {
        $duration = "12:00";
    }
    $sel_inbound = "SELECT * FROM cdr WHERE (call_from='$user_name' || call_to='$user_name') AND start_time LIKE '%$date_only%' AND direction='inbound'";
    $qurinbounde = mysqli_query($con, $sel_inbound);
    $inbound_call = mysqli_num_rows($qurinbounde);

    $sel_outbound = "SELECT * FROM cdr WHERE (call_from='$user_name' || call_to='$user_name') AND start_time LIKE '%$date_only%' AND direction='outbound'";
    $quroutbound = mysqli_query($con, $sel_outbound);
    $outbound_call = mysqli_num_rows($quroutbound);

    $sel_inout = "SELECT * FROM cdr WHERE (call_from='$user_name' || call_to='$user_name') AND start_time LIKE '%$date_only%'";
    $qurinout = mysqli_query($con, $sel_inout);
    $inout_call = mysqli_num_rows($qurinout);
   
    $row_data = array($sr, $user_name, $log_in_time, $duration, $log_out_time, $no_of_day_break, $duration_formatted, implode(', ', $break_names), $inbound_call, $outbound_call, $inout_call, $login_ss);
    fputcsv($output, $row_data, ',', '"');
$sr++; }
fclose($output);

mysqli_close($con);


?>