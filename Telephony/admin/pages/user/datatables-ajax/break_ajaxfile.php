<?php
session_start();
include 'config.php';

// Get session variables
// $user_level = $_SESSION['user_level'];
// $user = $user_level == 2 ? $_SESSION['admin'] : $_SESSION['user'];
// $new_user = $_SESSION['user'];
$new_campaign = $_SESSION['campaign_id'];
$user_level = $_SESSION['user_level'];

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
$agentid = $_SESSION['agent_name'];
$fromdate = $_SESSION['fromdate'];
$todate = $_SESSION['todate'];
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
    $searchQuery = " AND (break_time.id LIKE '%$searchValue%' OR 
                         break_time.user_name LIKE '%$searchValue%' OR 
                         break_time.break_name LIKE '%$searchValue%' OR 
                         break_time.start_time LIKE '%$searchValue%')";
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
    $condition = "DATE(break_time.start_time) BETWEEN '$fromdate' AND '$todate'";
} elseif ($serch_type == 'agent') {
    $condition = "break_time.user_name IN ('$agentid')";
} elseif ($serch_type == 'date-agent') {
    $condition = "DATE(break_time.start_time) BETWEEN '$fromdate' AND '$todate' AND break_time.user_name IN ('$agentid')";
} else {
    $condition = "1=1";
}

// Get total number of records without filtering
$totalRecordsQuery = "SELECT COUNT(*) as allcount 
                      FROM break_time 
                      JOIN users ON users.user_id = break_time.user_name 
                      WHERE $condition AND users.admin = '$user'";
$totalRecordsResult = mysqli_query($con, $totalRecordsQuery);
if (!$totalRecordsResult) {
    die("Query Failed: " . mysqli_error($con));
}
$totalRecords = mysqli_fetch_assoc($totalRecordsResult)['allcount'];

// Get total number of records with filtering
$totalRecordwithFilterQuery = "SELECT COUNT(*) as allcount 
                               FROM break_time 
                               JOIN users ON users.user_id = break_time.user_name 
                               WHERE $condition AND users.admin = '$user' $searchQuery";
$totalRecordwithFilterResult = mysqli_query($con, $totalRecordwithFilterQuery);
if (!$totalRecordwithFilterResult) {
    die("Query Failed: " . mysqli_error($con));
}
$totalRecordwithFilter = mysqli_fetch_assoc($totalRecordwithFilterResult)['allcount'];

// Fetch records
$query = "SELECT break_time.* , 
                 TIME_FORMAT(TIMEDIFF(MAX(break_time.end_time), MIN(break_time.start_time)), '%H:%i:%s') AS total_break_time 
          FROM break_time 
          JOIN users ON users.user_id = break_time.user_name 
          WHERE $condition AND users.admin = '$user' $searchQuery 
          GROUP BY users.user_id, break_time.start_time, break_time.campaign_id 
          ORDER BY $columnName $columnSortOrder 
          LIMIT $row, $rowperpage";
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
        "break_name" => $row['break_name'],
        "start_time" => $row['start_time'],
        "total_break_time" => $row['total_break_time'],
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
