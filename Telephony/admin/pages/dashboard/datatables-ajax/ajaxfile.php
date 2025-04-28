<?php
session_start();
include 'config.php';
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
} else if($user_level == 6 || $user_level == 7) {
  $Adminuser = $_SESSION['admin'];
  $new_user = $_SESSION['user'];
} else { 
  $Adminuser = $_SESSION['user'];
}
$start = 0;
$filter = isset($_SESSION['filter']) ? $_SESSION['filter'] : '';
$ifilter = isset($_SESSION['ifilter']) ? $_SESSION['ifilter'] : '';
$click_id = '';

$tfnsel_1 = "SELECT * FROM user WHERE userName='$username'";
$data_1 = mysqli_query($con, $tfnsel_1);
if ($data_1) {
  if (mysqli_num_rows($data_1) > 0) {
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
$sel_campains_id = $_SESSION['sel_campains_id'];
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
$columnSortOrder = 'DESC'; // Default sort order
// if(isset($_POST['order'][0]['dir'])) {
//   $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
// }
$searchValue = isset($_POST['search']['value']) ? mysqli_real_escape_string($con, $_POST['search']['value']) : ''; // Search value

## Search
$searchQuery = "";
if ($searchValue != '') {
  $searchQuery = " AND (cdr.call_from LIKE '%" . $searchValue . "%' OR 
  cdr.call_to LIKE '%" . $searchValue . "%' OR 
  cdr.start_time LIKE '%" . $searchValue . "%' OR 
  cdr.status LIKE '%" . $searchValue . "%' OR 
  cdr.direction LIKE '%" . $searchValue . "%' OR 
  users.full_name LIKE '%" . $searchValue . "%' OR 
  compaign_list.compaignname LIKE '%" . $searchValue . "%' OR 
  cdr.id LIKE '%" . $searchValue . "%')";
}



if ($user_level == 2) {
  $condition_one = "AND compaign_list.compaign_id = '$new_campaign'";
  $lavel_condition = "AND cdr.admin = '$Adminuser'";
  $lavel_agent = "(cdr.call_from='$agentid' OR cdr.call_to='$agentid')";
  $lavel_cam = "1=1";
} else if($user_level == 9) {
  $condition_one = "AND '1=1'";
  $lavel_condition = "";
  $lavel_agent = "cdr.admin='$agentid'";
  $lavel_cam = "compaign_list.compaign_id = '$sel_campains_id'";
} else if($user_level == 6 || $user_level == 7) {
  $condition_one = "AND '1=1'";
  $lavel_condition = "AND cdr.admin = '$Adminuser'";
  $lavel_agent = "(cdr.call_from='$agentid' OR cdr.call_to='$agentid')";
  $lavel_cam = "compaign_list.compaign_id = '$sel_campains_id'";
} else {
  $condition_one = "AND '1=1'";
  $lavel_condition = "AND cdr.admin = '$Adminuser'";
  $lavel_agent = "(cdr.call_from='$agentid' OR cdr.call_to='$agentid')";
  $lavel_cam = "compaign_list.compaign_id = '$sel_campains_id'";
}


if ($serch_type == 'date') {

  $sel = mysqli_query($con, "SELECT COUNT(*) as allcount 
                             FROM cdr 
                             LEFT JOIN users ON users.user_id = cdr.call_to 
                             LEFT JOIN compaign_list ON compaign_list.compaign_id = users.campaigns_id 
                             WHERE DATE(cdr.start_time) BETWEEN '$fromdate' AND '$todate' $lavel_condition $condition_one");
  $records = mysqli_fetch_assoc($sel);
  $totalRecords = isset($records['allcount']) ? $records['allcount'] : 0;

  $sel = mysqli_query($con, "SELECT COUNT(*) as allcount 
                             FROM cdr 
                             LEFT JOIN users ON users.user_id = cdr.call_to 
                             LEFT JOIN compaign_list ON compaign_list.compaign_id = users.campaigns_id 
                             WHERE DATE(cdr.start_time) BETWEEN '$fromdate' AND '$todate' $lavel_condition $condition_one $searchQuery");
  $records = mysqli_fetch_assoc($sel);
  $totalRecordwithFilter = isset($records['allcount']) ? $records['allcount'] : 0;

  $query = "SELECT 
              cdr.*, 
              TIME_FORMAT(SEC_TO_TIME(cdr.dur), '%H:%i:%s') AS dur_formatted,
              IFNULL(users.full_name, 'NONE') AS full_name,
              IFNULL(users.campaigns_id, 'NONE') AS campaigns_id,
              IFNULL(compaign_list.compaignname, 'NONE') AS compaignname 
            FROM cdr 
            LEFT JOIN users ON users.user_id = cdr.call_to
            LEFT JOIN compaign_list ON compaign_list.compaign_id = users.campaigns_id 
            WHERE DATE(cdr.start_time) BETWEEN '$fromdate' AND '$todate' $lavel_condition $condition_one $searchQuery 
            ORDER BY $columnName $columnSortOrder 
            LIMIT $row, $rowperpage";

} elseif ($serch_type == 'agent') {

  $sel = mysqli_query($con, "SELECT COUNT(*) as allcount 
                             FROM cdr 
                             LEFT JOIN users ON users.user_id = cdr.call_to 
                             LEFT JOIN compaign_list ON compaign_list.compaign_id = users.campaigns_id 
                             WHERE $lavel_agent $lavel_condition $condition_one");
  $records = mysqli_fetch_assoc($sel);
  $totalRecords = isset($records['allcount']) ? $records['allcount'] : 0;

  $sel = mysqli_query($con, "SELECT COUNT(*) as allcount 
                             FROM cdr 
                             LEFT JOIN users ON users.user_id = cdr.call_to 
                             LEFT JOIN compaign_list ON compaign_list.compaign_id = users.campaigns_id 
                             WHERE $lavel_agent $lavel_condition $condition_one $searchQuery");
  $records = mysqli_fetch_assoc($sel);
  $totalRecordwithFilter = isset($records['allcount']) ? $records['allcount'] : 0;

  $query = "SELECT 
              cdr.*, 
              TIME_FORMAT(SEC_TO_TIME(cdr.dur), '%H:%i:%s') AS dur_formatted,
              IFNULL(users.full_name, 'NONE') AS full_name,
              IFNULL(users.campaigns_id, 'NONE') AS campaigns_id,
              IFNULL(compaign_list.compaignname, 'NONE') AS compaignname 
            FROM cdr 
            LEFT JOIN users ON users.user_id = cdr.call_to
            LEFT JOIN compaign_list ON compaign_list.compaign_id = users.campaigns_id 
            WHERE $lavel_agent $lavel_condition $condition_one $searchQuery 
            ORDER BY $columnName $columnSortOrder 
            LIMIT $row, $rowperpage";

} elseif ($serch_type == 'date-agent') {

  $sel = mysqli_query($con, "SELECT COUNT(*) as allcount 
                             FROM cdr 
                             LEFT JOIN users ON users.user_id = cdr.call_to 
                             LEFT JOIN compaign_list ON compaign_list.compaign_id = users.campaigns_id 
                             WHERE DATE(cdr.start_time) BETWEEN '$fromdate' AND '$todate' AND $lavel_agent $lavel_condition $condition_one");
  $records = mysqli_fetch_assoc($sel);
  $totalRecords = isset($records['allcount']) ? $records['allcount'] : 0;

  $sel = mysqli_query($con, "SELECT COUNT(*) as allcount 
                             FROM cdr 
                             LEFT JOIN users ON users.user_id = cdr.call_to 
                             LEFT JOIN compaign_list ON compaign_list.compaign_id = users.campaigns_id 
                             WHERE DATE(cdr.start_time) BETWEEN '$fromdate' AND '$todate' AND $lavel_agent $lavel_condition $condition_one $searchQuery");
  $records = mysqli_fetch_assoc($sel);
  $totalRecordwithFilter = isset($records['allcount']) ? $records['allcount'] : 0;

  $query = "SELECT 
              cdr.*, 
              TIME_FORMAT(SEC_TO_TIME(cdr.dur), '%H:%i:%s') AS dur_formatted,
              IFNULL(users.full_name, 'NONE') AS full_name,
              IFNULL(users.campaigns_id, 'NONE') AS campaigns_id,
              IFNULL(compaign_list.compaignname, 'NONE') AS compaignname 
            FROM cdr 
            LEFT JOIN users ON users.user_id = cdr.call_to
            LEFT JOIN compaign_list ON compaign_list.compaign_id = users.campaigns_id 
            WHERE DATE(cdr.start_time) BETWEEN '$fromdate' AND '$todate' AND $lavel_agent $lavel_condition $condition_one $searchQuery 
            ORDER BY $columnName $columnSortOrder 
            LIMIT $row, $rowperpage";

} elseif ($serch_type == 'campaign') {

  $sel = mysqli_query($con, "SELECT COUNT(*) as allcount 
                             FROM cdr 
                             LEFT JOIN users ON users.user_id = cdr.call_to 
                             LEFT JOIN compaign_list ON compaign_list.compaign_id = users.campaigns_id 
                             WHERE $lavel_cam $lavel_condition $condition_one");
  $records = mysqli_fetch_assoc($sel);
  $totalRecords = isset($records['allcount']) ? $records['allcount'] : 0;

  $sel = mysqli_query($con, "SELECT COUNT(*) as allcount 
                             FROM cdr 
                             LEFT JOIN users ON users.user_id = cdr.call_to 
                             LEFT JOIN compaign_list ON compaign_list.compaign_id = users.campaigns_id 
                             WHERE $lavel_cam $lavel_condition $condition_one $searchQuery");
  $records = mysqli_fetch_assoc($sel);
  $totalRecordwithFilter = isset($records['allcount']) ? $records['allcount'] : 0;

  $query = "SELECT 
              cdr.*, 
              TIME_FORMAT(SEC_TO_TIME(cdr.dur), '%H:%i:%s') AS dur_formatted,
              IFNULL(users.full_name, 'NONE') AS full_name,
              IFNULL(users.campaigns_id, 'NONE') AS campaigns_id,
              IFNULL(compaign_list.compaignname, 'NONE') AS compaignname 
            FROM cdr 
            LEFT JOIN users ON users.user_id = cdr.call_to
            LEFT JOIN compaign_list ON compaign_list.compaign_id = users.campaigns_id 
            WHERE $lavel_cam $lavel_condition $condition_one $searchQuery 
            ORDER BY $columnName $columnSortOrder 
            LIMIT $row, $rowperpage";

} elseif ($serch_type == 'date-campaign') {

  $sel = mysqli_query($con, "SELECT COUNT(*) as allcount 
                             FROM cdr 
                             LEFT JOIN users ON users.user_id = cdr.call_to 
                             LEFT JOIN compaign_list ON compaign_list.compaign_id = users.campaigns_id 
                             WHERE DATE(cdr.start_time) BETWEEN '$fromdate' AND '$todate' AND $lavel_cam $lavel_condition $condition_one");
  $records = mysqli_fetch_assoc($sel);
  $totalRecords = isset($records['allcount']) ? $records['allcount'] : 0;

  $sel = mysqli_query($con, "SELECT COUNT(*) as allcount 
                             FROM cdr 
                             LEFT JOIN users ON users.user_id = cdr.call_to 
                             LEFT JOIN compaign_list ON compaign_list.compaign_id = users.campaigns_id 
                             WHERE DATE(cdr.start_time) BETWEEN '$fromdate' AND '$todate' AND $lavel_cam $lavel_condition $condition_one $searchQuery");
  $records = mysqli_fetch_assoc($sel);
  $totalRecordwithFilter = isset($records['allcount']) ? $records['allcount'] : 0;

  $query = "SELECT 
              cdr.*, 
              TIME_FORMAT(SEC_TO_TIME(cdr.dur), '%H:%i:%s') AS dur_formatted,
              IFNULL(users.full_name, 'NONE') AS full_name,
              IFNULL(users.campaigns_id, 'NONE') AS campaigns_id,
              IFNULL(compaign_list.compaignname, 'NONE') AS compaignname 
            FROM cdr 
            LEFT JOIN users ON users.user_id = cdr.call_to
            LEFT JOIN compaign_list ON compaign_list.compaign_id = users.campaigns_id 
            WHERE DATE(cdr.start_time) BETWEEN '$fromdate' AND '$todate' AND $lavel_cam $lavel_condition $condition_one $searchQuery 
            ORDER BY $columnName $columnSortOrder 
            LIMIT $row, $rowperpage";

} elseif ($serch_type == 'agent-campaign') {

  $sel = mysqli_query($con, "SELECT COUNT(*) as allcount 
                             FROM cdr 
                             LEFT JOIN users ON users.user_id = cdr.call_to 
                             LEFT JOIN compaign_list ON compaign_list.compaign_id = users.campaigns_id 
                             WHERE $lavel_cam AND $lavel_agent $lavel_condition $condition_one");
  $records = mysqli_fetch_assoc($sel);
  $totalRecords = isset($records['allcount']) ? $records['allcount'] : 0;

  $sel = mysqli_query($con, "SELECT COUNT(*) as allcount 
                             FROM cdr 
                             LEFT JOIN users ON users.user_id = cdr.call_to 
                             LEFT JOIN compaign_list ON compaign_list.compaign_id = users.campaigns_id 
                             WHERE $lavel_cam AND $lavel_agent $lavel_condition $condition_one $searchQuery");
  $records = mysqli_fetch_assoc($sel);
  $totalRecordwithFilter = isset($records['allcount']) ? $records['allcount'] : 0;

  $query = "SELECT 
              cdr.*, 
              TIME_FORMAT(SEC_TO_TIME(cdr.dur), '%H:%i:%s') AS dur_formatted,
              IFNULL(users.full_name, 'NONE') AS full_name,
              IFNULL(users.campaigns_id, 'NONE') AS campaigns_id,
              IFNULL(compaign_list.compaignname, 'NONE') AS compaignname 
            FROM cdr 
            LEFT JOIN users ON users.user_id = cdr.call_to
            LEFT JOIN compaign_list ON compaign_list.compaign_id = users.campaigns_id 
            WHERE $lavel_cam AND $lavel_agent $lavel_condition $condition_one $searchQuery 
            ORDER BY $columnName $columnSortOrder 
            LIMIT $row, $rowperpage";

} elseif ($serch_type == 'date-agent-campaign') {

  $sel = mysqli_query($con, "SELECT COUNT(*) as allcount 
                             FROM cdr 
                             LEFT JOIN users ON users.user_id = cdr.call_to 
                             LEFT JOIN compaign_list ON compaign_list.compaign_id = users.campaigns_id 
                             WHERE DATE(cdr.start_time) BETWEEN '$fromdate' AND '$todate' AND $lavel_cam AND $lavel_agent $lavel_condition $condition_one");
  $records = mysqli_fetch_assoc($sel);
  $totalRecords = isset($records['allcount']) ? $records['allcount'] : 0;

  $sel = mysqli_query($con, "SELECT COUNT(*) as allcount 
                             FROM cdr 
                             LEFT JOIN users ON users.user_id = cdr.call_to 
                             LEFT JOIN compaign_list ON compaign_list.compaign_id = users.campaigns_id 
                             WHERE DATE(cdr.start_time) BETWEEN '$fromdate' AND '$todate' AND $lavel_cam AND $lavel_agent $lavel_condition $condition_one $searchQuery");
  $records = mysqli_fetch_assoc($sel);
  $totalRecordwithFilter = isset($records['allcount']) ? $records['allcount'] : 0;

  $query = "SELECT 
              cdr.*, 
              TIME_FORMAT(SEC_TO_TIME(cdr.dur), '%H:%i:%s') AS dur_formatted,
              IFNULL(users.full_name, 'NONE') AS full_name,
              IFNULL(users.campaigns_id, 'NONE') AS campaigns_id,
              IFNULL(compaign_list.compaignname, 'NONE') AS compaignname 
            FROM cdr 
            LEFT JOIN users ON users.user_id = cdr.call_to
            LEFT JOIN compaign_list ON compaign_list.compaign_id = users.campaigns_id 
            WHERE DATE(cdr.start_time) BETWEEN '$fromdate' AND '$todate' AND $lavel_cam AND $lavel_agent $lavel_condition $condition_one $searchQuery 
            ORDER BY $columnName $columnSortOrder 
            LIMIT $row, $rowperpage";

} else {
  
  $sel = mysqli_query($con, "SELECT COUNT(*) as allcount 
  FROM cdr 
  LEFT JOIN users ON users.user_id = cdr.call_to 
  LEFT JOIN compaign_list ON compaign_list.compaign_id = users.campaigns_id 
  WHERE DATE(cdr.start_time) BETWEEN '$to_date' AND '$to_date' $lavel_condition $condition_one");
$records = mysqli_fetch_assoc($sel);
$totalRecords = isset($records['allcount']) ? $records['allcount'] : 0;

$sel = mysqli_query($con, "SELECT COUNT(*) as allcount 
  FROM cdr 
  LEFT JOIN users ON users.user_id = cdr.call_to 
  LEFT JOIN compaign_list ON compaign_list.compaign_id = users.campaigns_id 
  WHERE DATE(cdr.start_time) BETWEEN '$to_date' AND '$to_date' $lavel_condition $condition_one $searchQuery");
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = isset($records['allcount']) ? $records['allcount'] : 0;

$query = "SELECT 
cdr.*, 
TIME_FORMAT(SEC_TO_TIME(cdr.dur), '%H:%i:%s') AS dur_formatted,
IFNULL(users.full_name, 'NONE') AS full_name,
IFNULL(users.campaigns_id, 'NONE') AS campaigns_id,
IFNULL(compaign_list.compaignname, 'NONE') AS compaignname 
FROM cdr 
LEFT JOIN users ON users.user_id = cdr.call_to
LEFT JOIN compaign_list ON compaign_list.compaign_id = users.campaigns_id 
WHERE DATE(cdr.start_time) BETWEEN '$to_date' AND '$to_date' $lavel_condition  $condition_one $searchQuery 
ORDER BY $columnName $columnSortOrder 
LIMIT $row, $rowperpage";
  $sel = mysqli_query($con, $query);
}
// echo "</br>";
// Process the result of the query as needed


$empRecords = mysqli_query($con, $query);
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
    "full_name" => $row['full_name'],
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
    "agent_remark" => $row['agent_remark'],
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