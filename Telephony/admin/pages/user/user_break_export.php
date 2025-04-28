<?php
session_start();
include "../../../conf/db.php";
include "../../../conf/Get_time_zone.php";

// Get the user from the session
$user_level = $_SESSION['user_level'];
// $user = $user_level == 2 ? $_SESSION['admin'] : $_SESSION['user'];
// $new_user = $_SESSION['user'];
$new_campaign = $_SESSION['campaign_id'];
if($user_level == 2 || $user_level == 7 || $user_level == 6){
    $user = $_SESSION['admin'];
    $new_user = $_SESSION['user'];
    $user_sql2 = "SELECT campaigns_id FROM `users` WHERE admin='$user' AND user_id='$new_user'"; 
    $user_query = mysqli_query($con, $user_sql2);
    if(!$user_query) {
        die("Query Failed: " . mysqli_error($con));
    }
    $row_compain = mysqli_fetch_assoc($user_query);
    $new_campaign = $row_compain['campaigns_id'];

} else {
    $user = $_SESSION['user'];
}

// Session variables for filters
$agentid = $_SESSION['agent_name'] ?? '';
$fromdate = $_SESSION['fromdate'] ?? '';
$todate = $_SESSION['todate'] ?? '';
$serch_type = $_SESSION['serch_type'] ?? '';

// Get agent IDs for the current user
if ($user_level == 2) {
    $tfnsel_1 = "SELECT user_id FROM users WHERE admin='$user' AND campaigns_id='$new_campaign'";
} else {
    $tfnsel_1 = "SELECT user_id FROM users WHERE admin='$user'";
}

$data_1 = mysqli_query($con, $tfnsel_1);
if (!$data_1) {
    die("Query Failed: " . mysqli_error($con));
}

$agent_ids = [];
while ($user_row = mysqli_fetch_assoc($data_1)) {
    $agent_ids[] = $user_row['user_id'];
}
$agent_ids_str = implode(",", $agent_ids);

// Determine condition based on search type
switch ($serch_type) {
    case 'date':
        $condition = "DATE(break_time.start_time) BETWEEN '$fromdate' AND '$todate'";
        break;
    case 'agent':
        $condition = "break_time.user_name IN ('$agentid')";
        break;
    case 'date-agent':
        $condition = "DATE(break_time.start_time) BETWEEN '$fromdate' AND '$todate' AND break_time.user_name IN ('$agentid')";
        break;
    default:
        $condition = "1=1";
        break;
}

// Fetch records
$query = "SELECT break_time.*, 
                 TIME_FORMAT(TIMEDIFF(MAX(break_time.end_time), MIN(break_time.start_time)), '%H:%i:%s') AS total_break_time 
          FROM break_time 
          JOIN users ON users.user_id = break_time.user_name 
          WHERE $condition AND users.admin = '$user' 
          GROUP BY users.user_id, break_time.start_time, break_time.campaign_id 
          ORDER BY break_time.id DESC";

$result = mysqli_query($con, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

// CSV file setup
$filename = "Break Reports.csv";
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: text/csv");

// Create a file pointer connected to the output stream
$output = fopen("php://output", 'w');

// Output CSV header
$header = ['Id', 'USER ID', 'BREAK NAME', 'TAKE BREAK TIME', 'BREAK DURATION'];
fputcsv($output, $header);

// Output data from rows
$sr = 1; // Initialize serial number
while ($row = mysqli_fetch_assoc($result)) {
    $csv_row = [
        $sr,
        $row['user_name'],
        $row['break_name'],
        $row['start_time'],
        $row['total_break_time']
    ];
    fputcsv($output, $csv_row);
    $sr++;
}

// Close the file pointer
fclose($output);

// Close the database connection
mysqli_close($con);
?>
