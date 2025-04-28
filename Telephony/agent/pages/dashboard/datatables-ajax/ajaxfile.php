<?php
session_start();
include 'config.php';
$user = $_SESSION['user'];
$user_admin = $_SESSION['user_admin'];
$tfnsel_1 = "SELECT caller_email, caller_contact FROM users WHERE admin = '$user_admin'";
$data_1 = mysqli_query($con, $tfnsel_1);
$user_row = mysqli_fetch_assoc($data_1);
$caller_email = $user_row['caller_email'];
$caller_contact = $user_row['caller_contact'];
$start = 0;
$filter = isset($_SESSION['filter']) ? $_SESSION['filter'] : '';
$ifilter = isset($_SESSION['ifilter']) ? $_SESSION['ifilter'] : '';
$click_id = '';

$tfnsel_1 = "SELECT * FROM user WHERE userName='$username'";
$data_1 = mysqli_query($con, $tfnsel_1);
if($data_1) {
  if(mysqli_num_rows($data_1) > 0){
    $user_row = mysqli_fetch_assoc($data_1);
    $status_user = $user_row['status'];
    $tstatus = '1';
  } else {
    $tstatus = '0';
  }
} else {
  // Handle query error
  $tstatus = '0';
}

$to_date = date("Y-m-d");
$date_24 = date("Y-m-d h:i:s");
   $agentid = $_SESSION['agent_name'];
   $fromdate = $_SESSION['fromdate'];
   $todate = $_SESSION['todate'];
   $serch_type = $_SESSION['serch_type'];

## Read value
$draw = isset($_POST['draw']) ? intval($_POST['draw']) : 0;
$row = isset($_POST['start']) ? intval($_POST['start']) : 0;
$rowperpage = isset($_POST['length']) ? intval($_POST['length']) : 10; // Rows display per page
$columnIndex = isset($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0; // Column index
$columnName = 'id'; // Default Column name
$columnSortOrder = 'desc'; // Default sort order
// if(isset($_POST['order'][0]['dir'])) {
//   $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
// }
$searchValue = isset($_POST['search']['value']) ? mysqli_real_escape_string($con, $_POST['search']['value']) : ''; // Search value

## Search 
$searchQuery = "";
if($searchValue != ''){
  $searchQuery = " and (call_from like '%".$searchValue."%' or 
  call_to like '%".$searchValue."%' or 
  start_time like'%".$searchValue."%' or status like'%".$searchValue."%' ) ";
}


  $sel = mysqli_query($con, "select count(*) as allcount from cdr AND call_from = '$user' OR call_to = '$user'");
  $records = mysqli_fetch_assoc($sel);
  $totalRecords = isset($records['allcount']) ? $records['allcount'] : 0;
  
  $sel = mysqli_query($con, "select count(*) as allcount from cdr WHERE  call_from = '$user' OR call_to = '$user' AND 1 ".$searchQuery);
  $records = mysqli_fetch_assoc($sel);
  $totalRecordwithFilter = isset($records['allcount']) ? $records['allcount'] : 0;
  
    $query = "SELECT 
    *,
    TIME_FORMAT(SEC_TO_TIME(`dur`), '%H:%i:%s') AS dur_formatted,
    status,
    hangup,
    record_url,
    direction 
    FROM cdr WHERE call_from = '$user' OR call_to = '$user' AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;

$empRecords = mysqli_query($con, $query);
$data = array();
$sr = $row + 1;
while ($row = mysqli_fetch_assoc($empRecords)) {
  $direction = $row['direction'];

  if ($direction == 'outbound') {
    $call_from_one = $row['did'];
    $did_one = $row['call_from'];
    
    if ($caller_contact == '1') {
      $call_from = str_repeat('*', 6) . substr($call_from_one, -4); // Show last 4 digits
      $did = str_repeat('*', 6) . substr($did_one, -4); // Show last 4 digits
      } else {
      $call_from = $call_from_one;
      $did = $did_one;
     }

  } else {
    $call_from_one = $row['call_from'];
    $did_one = $row['did'];

    if ($caller_contact == '1') {
      $call_from = str_repeat('*', 6) . substr($call_from_one, -4); // Show last 4 digits
      $did = str_repeat('*', 6) . substr($did_one, -4); // Show last 4 digits
      } else {
      $call_from = $call_from_one;
      $did = $did_one;
     }
   
  }

  $data[] = array(
    "sr" => $sr,
    "id" => $row['id'],
    "full_name" => $row['full_name'],
    "click2call_call_from" => $call_from_one,
    "click2call_did" => $did_one,
    "call_from" => $call_from,
    "did" => $did,
    "call_to" => $row['call_to'],
    "start_time" => $row['start_time'],
    "end_time" => $row['end_time'],
    "dur" => $row['dur_formatted'],
    "status" => $row['status'],
    "record_url" => $row['record_url'],
    "direction" => $row['direction'],
    "compaignname" => $row['compaignname'],
    "hangup" => $row['hangup'],
  );
  $sr++;
}
// print_r($data);

## Response
$response = array(
  "draw" => $draw,
  "iTotalRecords" => $totalRecords,
  "iTotalDisplayRecords" => $totalRecordwithFilter,
  "aaData" => $data
);

echo json_encode($response);
?>
