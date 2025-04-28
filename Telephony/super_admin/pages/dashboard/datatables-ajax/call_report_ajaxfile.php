<?php
session_start();
include 'config.php';

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

// $to_date = date("Y-m-d");
// $date_24 = date("Y-m-d h:i:s");
//    $agentid = $_SESSION['agent_name'];
//    $fromdate = $_SESSION['fromdate'];
//    $todate = $_SESSION['todate'];
//    $serch_type = $_SESSION['serch_type'];

## Read value
$draw = isset($_POST['draw']) ? intval($_POST['draw']) : 0;
$row = isset($_POST['start']) ? intval($_POST['start']) : 0;
$rowperpage = isset($_POST['length']) ? intval($_POST['length']) : 10; // Rows display per page
$columnIndex = isset($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0; // Column index
$columnName = 'id'; // Default Column name
$columnSortOrder = 'desc'; // Default sort order
if(isset($_POST['order'][0]['dir'])) {
  $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
}
$searchValue = isset($_POST['search']['value']) ? mysqli_real_escape_string($con, $_POST['search']['value']) : ''; // Search value

## Search 
$searchQuery = "";
if($searchValue != ''){
  $searchQuery = " and (call_from like '%".$searchValue."%' or 
  call_to like '%".$searchValue."%' or 
  start_time like'%".$searchValue."%' or status like'%".$searchValue."%' ) ";
}


  $sel = mysqli_query($con, "select count(*) as allcount from cdr");
  $records = mysqli_fetch_assoc($sel);
  $totalRecords = isset($records['allcount']) ? $records['allcount'] : 0;
  
  $sel = mysqli_query($con, "select count(*) as allcount from cdr WHERE 1 ".$searchQuery);
  $records = mysqli_fetch_assoc($sel);
  $totalRecordwithFilter = isset($records['allcount']) ? $records['allcount'] : 0;
  
   $query = "SELECT * from cdr WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;




$empRecords = mysqli_query($con, $query);
$data = array();
$sr = $row + 1;
while ($row = mysqli_fetch_assoc($empRecords)) {
  $data[] = array(
    "sr" => $sr,
    "id" => $row['id'],
    "call_from" => $row['call_from'],
    "call_to" => $row['call_to'],
    "start_time" => $row['start_time'],
    "end_time" => $row['end_time'],
    "dur" => $row['dur'],
    "status" => $row['status'],
    "record_url" => $row['record_url'],
    "direction" => $row['direction'],
  );
  $sr++;
}

## Response
$response = array(
  "draw" => $draw,
  "iTotalRecords" => $totalRecords,
  "iTotalDisplayRecords" => $totalRecordwithFilter,
  "aaData" => $data
);

echo json_encode($response);
?>
