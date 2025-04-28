<?php
session_start();
include 'config.php';

// Retrieve session data;
$user_level = $_SESSION['user_level'];
if ($user_level == 2) {
    $Adminuser = $_SESSION['admin'];
    $new_user = $_SESSION['user'];
    $user_sql2 = "SELECT campaigns_id FROM `users` WHERE admin='$Adminuser' AND user_id='$new_user'"; 
    $user_query = mysqli_query($con, $user_sql2);
    if(!$user_query) {
        die("Query Failed: " . mysqli_error($con));
    }
  
    $row_compain = mysqli_fetch_assoc($user_query);
    $new_campaign = $row_compain['campaigns_id'];
  
  } else { 
    $Adminuser = $_SESSION['user'];
  }

$get_data = $_SESSION['filter_type'];
$filter_data = $_SESSION['filter_to_time'];

// Define pagination and sorting variables
$draw = isset($_POST['draw']) ? intval($_POST['draw']) : 0;
$row = isset($_POST['start']) ? intval($_POST['start']) : 0;
$rowperpage = isset($_POST['length']) ? intval($_POST['length']) : 10;
$columnIndex = isset($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
$columnName = 'id';  // Default column to sort
$columnSortOrder = 'desc';  // Default sort order

// Search value (use prepared statements for better security)
$searchValue = isset($_POST['search']['value']) ? mysqli_real_escape_string($con, $_POST['search']['value']) : '';

// Build the search query condition
$searchQuery = "";
if ($searchValue != '') {
    $searchQuery = " AND (call_from LIKE '%" . $searchValue . "%' OR 
                          call_to LIKE '%" . $searchValue . "%' OR 
                          start_time LIKE '%" . $searchValue . "%' OR 
                          status LIKE '%" . $searchValue . "%' OR 
                          direction LIKE '%" . $searchValue . "%' OR 
                          id LIKE '%" . $searchValue . "%')";
}


// Define date variables
$date1 = date("Y-m-d");
$yesterday = date('Y-m-d', strtotime('-1 day'));
$weekStart = date('Y-m-d', strtotime('last week'));
$monthStart = date('Y-m-d', strtotime('-1 month'));
$threeMonthsAgo = date('Y-m-d', strtotime('-3 months'));
$sixMonthsAgo = date('Y-m-d', strtotime('-6 months'));

// Time condition
switch ($filter_data) {
    case 'today':
        $time_condition = "AND start_time LIKE '%$date1%'";
        break;
    case 'all':
        $time_condition = " ";
        break;
    default:
        $time_condition = "AND start_time LIKE '%$date1%'";
        break;
}

// Status condition
switch ($get_data) {
    case 'total_call':
        $status_condition = "1=1 AND admin='$Adminuser'";
        break;
    case 'other_call':
        $status_condition = "status != 'ANSWER' AND status != 'CANCEL' AND admin='$Adminuser'";
        break;
    case 'answer_call':
        $status_condition = "status='ANSWER' AND admin='$Adminuser'";
        break;
    case 'cancel_call':
        $status_condition = "status='CANCEL' AND admin='$Adminuser'";
        break;
    case 'out_boundcall':
        $status_condition = "direction = 'outbound' AND admin='$Adminuser'";
        break;
    case 'inbound_call':
        $status_condition = "direction = 'inbound' AND admin='$Adminuser'";
        break;
    case 'no_answer':
        $status_condition = "status = 'NOANSWER' AND admin='$Adminuser'";
        break;
    default:
        $status_condition = "1=1 AND admin='$Adminuser'";
        break;
}

// Combine the status and time conditions
// echo $filter_data;
// echo "</br>";
// echo $get_data;
// echo "</br>";
// echo $time_condition;
// echo "</br>";
// echo $status_condition;
// echo "</br>";
$condition = "$status_condition $time_condition";
// echo "</br>";
// Store the final condition in session
$_SESSION['final_condition'] = $condition;

// Fetch total number of records without filtering
$sel = mysqli_query($con, "SELECT COUNT(*) as allcount FROM cdr WHERE $condition");
$records = mysqli_fetch_assoc($sel);
$totalRecords = isset($records['allcount']) ? $records['allcount'] : 0;

// Fetch total number of records with filtering
$sel = mysqli_query($con, "SELECT COUNT(*) as allcount FROM cdr WHERE $condition $searchQuery");
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = isset($records['allcount']) ? $records['allcount'] : 0;

// Fetch records with pagination and ordering
$query = "SELECT * FROM cdr WHERE $condition $searchQuery ORDER BY $columnName $columnSortOrder LIMIT $row, $rowperpage";
$empRecords = mysqli_query($con, $query);

// Prepare data for response
$data = array();
$sr = $row + 1;
while ($row = mysqli_fetch_assoc($empRecords)) {
    $direction = $row['direction'];
    
    if ($direction == 'outbound') {
        $call_from = $row['did'];
        $did = $row['call_from'];
    } else {
        $call_from = $row['call_from'];
        $did = $row['did'];
    }
    
    $data[] = array(
        "sr" => $sr,
        "id" => $row['id'],
        "call_from" => $call_from,
        "did" => $did,
        "call_to" => $row['call_to'],
        "start_time" => $row['start_time'],
        "end_time" => $row['end_time'],
        "dur" => $row['dur_formatted'],
        "status" => $row['status'],
        "record_url" => $row['record_url'],
        "direction" => $row['direction'],
        "hangup" => $row['hangup'],
    );
    $sr++;
}

// Send response as JSON
$response = array(
    "draw" => $draw,
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $data
);

echo json_encode($response);
?>
