<?php
session_start();
include 'config.php';

// Get session variables
$user_level = $_SESSION['user_level'];

if($user_level == 2){
    $user = $_SESSION['admin'];
    $new_user = $_SESSION['user'];
} else {
    $user = $_SESSION['user'];
}
$agentid = $_SESSION['agent_name'];
$fromdate = $_SESSION['fromdate'];
$todate = $_SESSION['todate'];
$serch_type = $_SESSION['serch_type'];

// Get POST parameters
$draw = isset($_POST['draw']) ? intval($_POST['draw']) : 0;
$row = isset($_POST['start']) ? intval($_POST['start']) : 0;
$rowperpage = isset($_POST['length']) ? intval($_POST['length']) : 10;
$columnIndex = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : 0;
$columnSortOrder = isset($_POST['order'][0]['dir']) && in_array($_POST['order'][0]['dir'], ['asc', 'desc']) ? $_POST['order'][0]['dir'] : 'desc';
$searchValue = isset($_POST['search']['value']) ? mysqli_real_escape_string($con, $_POST['search']['value']) : '';

// Default column name
$columnName = 'id';


// Construct search query
$searchQuery = "";
if ($searchValue != '') {
    $searchQuery = " AND (user_name LIKE '%$searchValue%' OR 
                         log_in_time LIKE '%$searchValue%' OR 
                         log_out_time LIKE '%$searchValue%' OR 
                         status LIKE '%$searchValue%')";
}

// Get the agent ID for the current user
$tfnsel_1 = "SELECT user_id FROM users WHERE admin='$user'";
$data_1 = mysqli_query($con, $tfnsel_1);
$agent_ids = [];

while ($user_row = mysqli_fetch_assoc($data_1)) {
    $agent_ids[] = $user_row['user_id'];
}

// Convert agent_ids array to a comma-separated string
$agent_ids_str = implode("','", $agent_ids);


if ($serch_type == 'date'){
  
// Get total number of records without filtering
$totalRecordsQuery = "SELECT COUNT(*) as allcount FROM break_time WHERE DATE(log_in_time) between '$fromdate' AND '$todate' AND admin = '$user' AND user_name !='$user'";
$totalRecordsResult = mysqli_query($con, $totalRecordsQuery);
$totalRecords = mysqli_fetch_assoc($totalRecordsResult)['allcount'];

// Get total number of records with filtering
$totalRecordwithFilterQuery = "SELECT COUNT(*) as allcount FROM break_time WHERE DATE(log_in_time) between '$fromdate' AND '$todate' AND (admin = '$user' AND user_name !='$user') $searchQuery";
$totalRecordwithFilterResult = mysqli_query($con, $totalRecordwithFilterQuery);
$totalRecordwithFilter = mysqli_fetch_assoc($totalRecordwithFilterResult)['allcount'];

// Fetch records
$query = "SELECT * FROM break_time WHERE DATE(log_in_time) between '$fromdate' AND '$todate' AND (admin = '$user' AND user_name !='$user') $searchQuery 
          ORDER BY $columnName $columnSortOrder 
          LIMIT $row, $rowperpage";


} elseif ($serch_type == 'agent'){


  $totalRecordsQuery = "SELECT COUNT(*) as allcount FROM break_time WHERE user_name IN ('$agentid')";
  $totalRecordsResult = mysqli_query($con, $totalRecordsQuery);
  $totalRecords = mysqli_fetch_assoc($totalRecordsResult)['allcount'];
  
  // Get total number of records with filtering
  $totalRecordwithFilterQuery = "SELECT COUNT(*) as allcount FROM break_time WHERE (user_name IN ('$agentid')) $searchQuery";
  $totalRecordwithFilterResult = mysqli_query($con, $totalRecordwithFilterQuery);
  $totalRecordwithFilter = mysqli_fetch_assoc($totalRecordwithFilterResult)['allcount'];
  
  // Fetch records
  $query = "SELECT * FROM break_time WHERE (user_name IN ('$agentid')) $searchQuery 
            ORDER BY $columnName $columnSortOrder 
            LIMIT $row, $rowperpage";
  
   
} elseif ($serch_type == 'date-agent'){

// Get total number of records without filtering
$totalRecordsQuery = "SELECT COUNT(*) as allcount FROM break_time WHERE DATE(log_in_time) between '$fromdate' AND '$todate' AND user_name IN ('$agentid') AND user_name !='$user'  ";
$totalRecordsResult = mysqli_query($con, $totalRecordsQuery);
$totalRecords = mysqli_fetch_assoc($totalRecordsResult)['allcount'];

// Get total number of records with filtering
$totalRecordwithFilterQuery = "SELECT COUNT(*) as allcount FROM break_time WHERE DATE(log_in_time) between '$fromdate' AND '$todate' AND (user_name IN ('$agentid') AND user_name !='$user') $searchQuery";
$totalRecordwithFilterResult = mysqli_query($con, $totalRecordwithFilterQuery);
$totalRecordwithFilter = mysqli_fetch_assoc($totalRecordwithFilterResult)['allcount'];

// Fetch records
$query = "SELECT * FROM break_time WHERE DATE(log_in_time) between '$fromdate' AND '$todate' AND (user_name IN ('$agentid') AND user_name !='$user') $searchQuery 
          ORDER BY $columnName $columnSortOrder 
          LIMIT $row, $rowperpage";

    
} else {

// Get total number of records without filtering
$totalRecordsQuery = "SELECT COUNT(break_time.*) as allcount FROM break_time JOIN users ON users.user_id=break_time.user_name WHERE users.admin = '$user' AND users.user_id !='$user'";
$totalRecordsResult = mysqli_query($con, $totalRecordsQuery);
$totalRecords = mysqli_fetch_assoc($totalRecordsResult)['allcount'];

// Get total number of records with filtering
$totalRecordwithFilterQuery = "SELECT COUNT(break_time.*) as allcount FROM break_time JOIN users ON users.user_id=break_time.user_name WHERE (users.admin = '$user' AND users.user_id !='$user') $searchQuery";
$totalRecordwithFilterResult = mysqli_query($con, $totalRecordwithFilterQuery);
$totalRecordwithFilter = mysqli_fetch_assoc($totalRecordwithFilterResult)['allcount'];

// Fetch records
$query = "SELECT break_time.* FROM break_time JOIN users ON users.user_id=break_time.user_name WHERE users.admin = '$user' AND users.user_id !='$user' $searchQuery 
          ORDER BY $columnName $columnSortOrder 
          LIMIT $row, $rowperpage";


}



$empRecords = mysqli_query($con, $query);
// Prepare data for JSON response

$data = array();
$sr = $row + 1;
while ($row = mysqli_fetch_assoc($empRecords)) {
    $user_name = $row['user_name'];
    
    // Fetch the full name for the user
    $usersql = "SELECT full_name FROM users WHERE user_id = '$user_name'";
    $onequery = mysqli_query($con, $usersql);
    $nrow = mysqli_fetch_assoc($onequery);
    $full_name = $nrow['full_name'];

    $data[] = array(
        "sr" => $sr,
        "id" => $row['id'],
        "user_name" => $row['user_name'],
        "full_name" => $full_name,
        "break_name" => $row['break_name'],
        "start_time" => $row['start_time'],
        "break_duration" => $row['break_duration'],
        "end_time" => $row['end_time'],
        "break_status" => $row['break_status'],
        "campaign_id" => $row['campaign_id'],
        "press_key" => $row['press_key'],
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
