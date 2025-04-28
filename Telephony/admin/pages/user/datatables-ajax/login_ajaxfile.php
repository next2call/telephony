<?php
session_start();
include 'config.php';

// Get session variables
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
$agentid = $_SESSION['agent_name_one'];
$fromdate = $_SESSION['fromdate_one'];
$todate = $_SESSION['todate_one'];
$serch_type = $_SESSION['serch_type'];

// Get POST parameters
$draw = isset($_POST['draw']) ? intval($_POST['draw']) : 0;
$row = isset($_POST['start']) ? intval($_POST['start']) : 0;
$rowperpage = isset($_POST['length']) ? intval($_POST['length']) : 10;
$columnIndex = isset($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
$columnSortOrder = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 'desc';
$searchValue = isset($_POST['search']['value']) ? mysqli_real_escape_string($con, $_POST['search']['value']) : '';

// Default column name
$columnName = 'id';

// Construct search query
$searchQuery = "";
if ($searchValue != '') {
    $searchQuery = " AND (login_log.id LIKE '%$searchValue%' OR 
                         login_log.user_name LIKE '%$searchValue%' OR 
                         login_log.log_in_time LIKE '%$searchValue%' OR 
                         login_log.log_out_time LIKE '%$searchValue%' OR 
                         login_log.status LIKE '%$searchValue%')";
}

// Get agent IDs for the current user
if ($user_level == 2) {
    $tfnsel_1 = "SELECT user_id FROM users WHERE admin='$user' AND campaigns_id='$new_campaign'";
} else {
    $tfnsel_1 = "SELECT user_id FROM users WHERE admin='$user'";
}

$data_1 = mysqli_query($con, $tfnsel_1);
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

// Get total number of records without filtering
$totalRecordsQuery = "SELECT COUNT(*) as allcount 
                      FROM login_log 
                      JOIN users ON login_log.user_name = users.user_id WHERE $condition AND login_log.admin = '$user' AND login_log.user_name NOT LIKE '$user' GROUP BY users.user_id, login_log.log_in_time, login_log.campaign_name";
$totalRecordsResult = mysqli_query($con, $totalRecordsQuery);
if (!$totalRecordsResult) {
    die("Query Failed: " . mysqli_error($con));
}
$totalRecords = mysqli_fetch_assoc($totalRecordsResult)['allcount'];

// Get total number of records with filtering
$totalRecordwithFilterQuery = "SELECT COUNT(*) as allcount 
                               FROM login_log 
                               JOIN users ON login_log.user_name = users.user_id WHERE $condition AND login_log.admin = '$user' AND login_log.user_name NOT LIKE '$user' GROUP BY users.user_id, login_log.log_in_time, login_log.campaign_name $searchQuery";
$totalRecordwithFilterResult = mysqli_query($con, $totalRecordwithFilterQuery);
if (!$totalRecordwithFilterResult) {
    die("Query Failed: " . mysqli_error($con));
}
$totalRecordwithFilter = mysqli_fetch_assoc($totalRecordwithFilterResult)['allcount'];

// Fetch records

$query = "SELECT login_log.*, TIME_FORMAT(TIMEDIFF(MAX(login_log.log_out_time), MIN(login_log.log_in_time)), '%H:%i:%s') AS total_login_time FROM `login_log` JOIN users ON login_log.user_name = users.user_id WHERE $condition AND login_log.admin = '$user' AND login_log.user_name NOT LIKE '$user' GROUP BY users.user_id, login_log.log_in_time, login_log.campaign_name ORDER BY $columnName $columnSortOrder LIMIT $row, $rowperpage";

$empRecords = mysqli_query($con, $query);
if (!$empRecords) {
    die("Query Failed: " . mysqli_error($con));
}

// Prepare data for JSON response
$data = [];
$sr = $row + 1;
while ($row = mysqli_fetch_assoc($empRecords)) {
    $data[] = array(
        "sr" => $sr,
        "id" => $row['id'],
        "user_name" => $row['user_name'],
        "log_in_time" => $row['log_in_time'],
        "log_out_time" => $row['log_out_time'],
        "total_login_time" => $row['total_login_time'],
        "status" => $row['status'],
        "campaign_name" => $row['campaign_name'],
        "admin" => $row['admin'],
        "user_type" => $row['user_type'],
    );
    $sr++;
}

// Response
$response = array(
    "draw" => $draw,
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $data
);

echo json_encode($response);
?>
