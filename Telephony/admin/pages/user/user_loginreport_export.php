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
    // $new_campaign = $row_compain['campaigns_id'];

} else {
    $user = $_SESSION['user'];
}


// Session variables for filters
$agentid = $_SESSION['agent_name_one'] ?? '';
$fromdate = $_SESSION['fromdate_one'] ?? '';
$todate = $_SESSION['todate_one'] ?? '';
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
if ($serch_type == 'date') {
    $condition = "DATE(login_log.log_in_time) BETWEEN '$fromdate' AND '$todate'";
} elseif ($serch_type == 'agent') {
    $condition = "login_log.user_name IN ('$agentid')";
} elseif ($serch_type == 'date-agent') {
    $condition = "DATE(login_log.log_in_time) BETWEEN '$fromdate' AND '$todate' AND login_log.user_name IN ('$agentid')";
} else {
    $condition = "1=1";
}

// Fetch records
$query = "SELECT login_log.*, 
                 TIME_FORMAT(TIMEDIFF(MAX(login_log.log_out_time), MIN(login_log.log_in_time)), '%H:%i:%s') AS total_login_time 
          FROM `login_log` 
          JOIN users ON login_log.user_name = users.user_id 
          WHERE $condition AND login_log.admin = '$user' AND login_log.user_name NOT LIKE '$user' 
          GROUP BY users.user_id, login_log.log_in_time, login_log.campaign_name 
          ORDER BY login_log.id DESC";

$result = mysqli_query($con, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

// CSV file setup
$filename = "Agents Login Report.csv";
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: text/csv");

// Create a file pointer connected to the output stream
$output = fopen("php://output", 'w');

// Output CSV header
$header = array('Sr', 'USER ID', 'LOGIN TIME', 'LOGOUT TIME', 'TOTAL TIME', 'STATUS');
fputcsv($output, $header);

// Output data from rows
$id = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $status = $row['status'] == '1' ? "Login" : "Logout";
    $data = array($id, $row['user_name'], $row['log_in_time'], $row['log_out_time'], $row['total_login_time'], $status);
    fputcsv($output, $data, ',', '"');
    $id++;
}

// Close the file pointer
fclose($output);

// Close the database connection
mysqli_close($con);
?>
