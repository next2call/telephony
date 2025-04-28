<?php
header('Content-Type: application/json');
include "../../../conf/db.php";
include "../../../conf/Get_time_zone.php";

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Retrieve and sanitize input parameters
$status = $_GET['status'] ?? '';
$date = $_GET['date'] ?? '';
$Adminuser = $_GET['Adminuser'] ?? '';
$all_data_check = $_GET['all_data_check'] ?? '';
$campaign_id = $_SESSION['campaign_id'] ?? '';

// Debug: Print the received parameters
error_log("Parameters: status=$status, date=$date, Adminuser=$Adminuser, all_data_check=$all_data_check");

// Build the base SQL query based on the status
$break_status_condition = '';
if ($status == 'Ready') {
    $break_status_condition = "AND bt.break_status = '2' AND bt.status = '2'";
} elseif ($status == 'pause') {
    $break_status_condition = "AND bt.break_status = '1' AND bt.status = '1'";
}

$user_level = $_SESSION['user_level'];

if ($user_level == 9) {

    $new_condition = "1=1";
    
    }elseif($user_level == 8 || $user_level == 7){
    
    $new_condition = "u.admin = '$Adminuser' AND u.user_id != '$Adminuser'";
    
    }elseif($user_level == 2){
    
        $new_condition = "u.campaigns_id = '$campaign_id' AND u.user_type = '1'";
    
    }else{
    
        $new_condition = "u.admin = '$Adminuser' AND u.user_id != '$Adminuser'";
    }
     

$sel = "SELECT 
    u.*, 
    ll.status AS login_status,
    ll.log_in_time,
    ll.log_out_time,
    bt.break_status,
    bt.status,
    bt.break_name,
    bt.start_time,
    bt.end_time,
    MAX(bt.end_time) AS ready_time,
    MAX(bt.start_time) AS stready_time,
    DATE_FORMAT(MAX(c.end_time), '%Y-%m-%d %H:%i:%s') AS wait_end_time,
    SEC_TO_TIME(TIMESTAMPDIFF(SECOND, MAX(c.start_time), MAX(bt.end_time))) AS wait_seconds,
    SEC_TO_TIME(TIMESTAMPDIFF(SECOND, MIN(bt.start_time), MAX(bt.end_time))) AS pause_seconds,
    SEC_TO_TIME(TIMESTAMPDIFF(SECOND, ll.log_in_time, ll.log_out_time)) AS login_duration_seconds
FROM 
    users u
LEFT JOIN (
    SELECT 
        ll1.*
    FROM 
        login_log ll1
    INNER JOIN (
        SELECT 
            user_name, 
            MAX(log_in_time) AS max_log_in_time
        FROM 
            login_log
        WHERE 
            log_in_time LIKE '%$date%'
        GROUP BY 
            user_name
    ) ll2 ON ll1.user_name = ll2.user_name AND ll1.log_in_time = ll2.max_log_in_time
) ll ON ll.user_name = u.user_id
LEFT JOIN (
    SELECT 
        bt1.*
    FROM 
        break_time bt1
    INNER JOIN (
        SELECT 
            user_name, 
            MAX(id) AS max_id
        FROM 
            break_time
        WHERE 
            start_time LIKE '%$date%'
        GROUP BY 
            user_name
    ) bt2 ON bt1.user_name = bt2.user_name AND bt1.id = bt2.max_id
) bt ON bt.user_name = u.user_id
LEFT JOIN cdr c ON bt.user_name = c.call_to AND c.start_time LIKE '%$date%'
WHERE 
    $new_condition 
    $break_status_condition
GROUP BY 
    u.user_id,
    ll.status,
    ll.log_in_time,
    ll.log_out_time,
    bt.break_status,
    bt.status,
    bt.break_name,
    bt.start_time,
    bt.end_time
ORDER BY 
    COALESCE(bt.id, 0) DESC";

// Debug: Print the SQL query
error_log("SQL Query: $sel");

$result = mysqli_query($con, $sel);

// Debug: Check if the query execution was successful
if (!$result) {
    error_log("Query Error: " . mysqli_error($con));
    echo json_encode(['error' => 'Query Error']);
    exit();
}

$data = [];

// Function to convert the DateInterval to total seconds
function intervalToSeconds($interval) {
    return ($interval->days * 24 * 60 * 60) +
           ($interval->h * 60 * 60) +
           ($interval->i * 60) +
           $interval->s;
}

// Function to convert total seconds to HH:MM:SS format
function secondsToTime($seconds) {
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    $seconds = $seconds % 60;
    return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
}

$sr= 1;


while ($row = mysqli_fetch_assoc($result)) {

    $cdr_filter = " AND start_time LIKE '%$date%' AND admin = '$Adminuser'";
    if ($all_data_check == 'all') {
        $cdr_filter = " AND admin = '$Adminuser'";
    }

    $user_id = $row['user_id'];
    $user_name = $row['full_name'];
    $ready_second = $row['pause_seconds'];

    $fetch = "SELECT * FROM live WHERE Agent='$user_id'";
    $Agentresult = mysqli_query($con, $fetch);
    $Agentrow = mysqli_fetch_assoc($Agentresult);
    $CallStatus = $Agentrow['status'] ?? '';
    
    
    if($CallStatus == 'Answer') {
        $status = '3';
        $Calldirection = $Agentrow['direction'];
    } else {
        $status = $row['status'];
        $Calldirection = $Agentrow['direction'] ?? '';
    }

    $SELECT = "SELECT end_time, SEC_TO_TIME( TIMESTAMPDIFF( SECOND, MIN(start_time), MAX(CASE WHEN break_duration != '' THEN end_time ELSE start_time END) ) ) AS pause_seconds FROM break_time WHERE start_time LIKE '%$date%' AND user_name = '$user_id'";
    $breakresult = mysqli_query($con, $SELECT);
    $breakrow = mysqli_fetch_assoc($breakresult);
    $pause_seconds = $breakrow['pause_seconds'] ?? '00:00:00';


    $sel5 = "SELECT CONCAT(
        LPAD(FLOOR(SUM(dur) / 3600), 2, '0'), ':',
        LPAD(FLOOR((SUM(dur) % 3600) / 60), 2, '0'), ':',
        LPAD(SUM(dur) % 60, 2, '0')) AS total_duration 
    FROM cdr WHERE status='ANSWER' AND (call_from='$user_id' OR call_to='$user_id') $cdr_filter";


        $live = "SELECT * FROM live WHERE time LIKE '%$date%' AND Agent = '$user_id'";
        $liveresult = mysqli_query($con, $live);
        $liverow = mysqli_fetch_assoc($liveresult);

        $stime = new DateTime($liverow['time']  ?? '00:00:00');
        // Get the current time
        $current_time = new DateTime();
        // Calculate the difference
        $liveinterval = $stime->diff($current_time);
        // Calculate the total seconds of the interval
        $livetotal_seconds = intervalToSeconds($liveinterval);



       $total_duration = mysqli_fetch_assoc(mysqli_query($con, $sel5))['total_duration'] ?? '00:00:00';


    $break_status = $row['break_status'];
    $login_duration_seconds = $row['login_duration_seconds'];
    $wait_seconds = $row['wait_seconds'];
    $break_duration = $row['break_duration_seconds'] ?? '00:00:00';
    
    // Calculate login duration
    $login_time = new DateTime($row['log_in_time']);
    $current_time = new DateTime();
    $interval = $login_time->diff($current_time);
    $total_seconds = intervalToSeconds($interval);

    // Calculate wait_duration_seconds
    $wait_time = new DateTime($row['wait_end_time'] ?? $row['log_in_time']);
    $waitinterval = $wait_time->diff($current_time);
    $total_wait_seconds = intervalToSeconds($waitinterval);

    // Calculate pause_duration_seconds
    $pause_time = new DateTime($row['start_time'] ?? $row['start_time']);
    $pauseinterval = $pause_time->diff($current_time);
    $pause_wait_seconds = intervalToSeconds($pauseinterval);

    // Calculate ready_time_seconds
    $ready_time = new DateTime($row['stready_time'] ?? $row['ready_time']);
    $readyinterval = $ready_time->diff($current_time);
    $ready_wait_seconds = intervalToSeconds($readyinterval);

     // Calculate reset
     $reset_time = new DateTime($row['ready_time'] ?? $row['stready_time']);
     $resetinterval = $reset_time->diff($current_time);
     $reset_wait_seconds = intervalToSeconds($resetinterval);

    if($break_status == '2' && $status == '2'){
        $login_duration = secondsToTime($total_seconds) ?? '00:00:00';
        $wait_duration_seconds = secondsToTime($total_wait_seconds);
        $ready_seconds = secondsToTime($reset_wait_seconds);
        $pause_duration_seconds = $pause_seconds ?? '00:00:00';

    } elseif($break_status == '2' && $status == '1'){
        $login_duration = $login_duration_seconds ?? '00:00:00';
        $wait_duration_seconds = $wait_seconds ?? '00:00:00';
        $pause_duration_seconds = $pause_seconds ?? '00:00:00';
        $ready_seconds = $ready_second ?? '00:00:00';

    } elseif($break_status == '2' && $status == '3'){
        $login_duration = secondsToTime($total_seconds) ?? '00:00:00';
        $total_duration = secondsToTime($livetotal_seconds) ?? '00:00:00';
        $wait_duration_seconds =  '00:00:00';
        $pause_duration_seconds = $pause_seconds ?? '00:00:00';
        $ready_seconds = secondsToTime($ready_wait_seconds);


    }else {
        $login_duration = secondsToTime($total_seconds) ?? '00:00:00';
        $wait_duration_seconds = $wait_seconds ?? '00:00:00';
        $pause_duration_seconds = secondsToTime($pause_wait_seconds);
        $ready_seconds = $ready_second ?? secondsToTime($ready_wait_seconds);

    }



    // Debug: Print the cdr_filter
    error_log("CDR Filter: $cdr_filter");

    $sel1 = "SELECT COUNT(*) AS total_calls FROM cdr WHERE (call_from='$user_id' OR call_to='$user_id') $cdr_filter";
    $sel2 = "SELECT COUNT(*) AS total_ans_calls FROM cdr WHERE status='ANSWER' AND (call_from='$user_id' OR call_to='$user_id') $cdr_filter";
    $sel3 = "SELECT COUNT(*) AS total_can_calls FROM cdr WHERE status='CANCEL' AND (call_from='$user_id' OR call_to='$user_id') $cdr_filter";
    $sel4 = "SELECT COUNT(*) AS total_oth_calls FROM cdr WHERE status!='ANSWER' AND status!='CANCEL' AND (call_from='$user_id' OR call_to='$user_id') $cdr_filter";
 

    // Execute the subqueries and fetch the results
    $total_calls = mysqli_fetch_assoc(mysqli_query($con, $sel1))['total_calls'] ?? 0;
    $total_ans_calls = mysqli_fetch_assoc(mysqli_query($con, $sel2))['total_ans_calls'] ?? 0;
    $total_can_calls = mysqli_fetch_assoc(mysqli_query($con, $sel3))['total_can_calls'] ?? 0;
    $total_oth_calls = mysqli_fetch_assoc(mysqli_query($con, $sel4))['total_oth_calls'] ?? 0;

    // Debug: Print the fetched data for each user
    error_log("User Data: user_id=$user_id, user_name=$user_name, total_calls=$total_calls, total_ans_calls=$total_ans_calls, total_can_calls=$total_can_calls, total_oth_calls=$total_oth_calls, total_duration=$total_duration");

    // Use user_id as the key to ensure uniqueness
    $data[$user_id] = [
        'sr' => $sr++,
        'user_name' => $user_name,
        'login_status' => $row['login_status'],
        'login_duration' => $login_duration,
        'wait_duration_seconds' => $wait_duration_seconds,
        'pause_seconds' => $pause_duration_seconds,
        'ready_seconds' => $ready_seconds,
        'break_status' => $break_status,
        'status' => $status,
        'Calldirection' => $Calldirection,
        'break_name' => $row['break_name'],
        'total_call_agent' => $total_calls,
        'total_ans_call_agent' => $total_ans_calls,
        'total_can_call_agent' => $total_can_calls,
        'total_oth_call_agent' => $total_oth_calls,
        'total_duration_A_call' => $total_duration
    ];
}

// Debug: Print the final data array
error_log("Final Data: " . json_encode($data));

echo json_encode(['data' => array_values($data)]);
?>
