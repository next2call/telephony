<?php
session_start();
include 'config.php';
$Adminuser = $_SESSION['user'];
$user_level = $_SESSION['user_level']; 
if ($user_level == 2 || $user_level == 6 || $user_level == 7) {
    $Adminuser = $_SESSION['admin'];
    $new_user = $_SESSION['user'];
    $user_campaigns_id = $_SESSION['campaign_id'];
}

$Get_list = $_SESSION['Get_list_id'];
$start = 0;
$filter = isset($_SESSION['filter']) ? $_SESSION['filter'] : '';
$ifilter = isset($_SESSION['ifilter']) ? $_SESSION['ifilter'] : '';
$click_id = '';

$tfnsel_1 = "SELECT * FROM user WHERE userName='$Adminuser'";
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
if ($searchValue != '') {
  $searchQuery = " and (company_name like '%" . $searchValue . "%' or 
  name like '%" . $searchValue . "%' or 
  ins_date like'%" . $searchValue . "%' or phone_number like'%" . $searchValue . "%' or dial_status like'%" . $searchValue . "%') ";
}
$sel = mysqli_query($con, "select count(*) as allcount from upload_data AND admin = '$Adminuser' AND dial_status!='NEW' AND list_id='$Get_list'");
$records = mysqli_fetch_assoc($sel);
$totalRecords = isset($records['allcount']) ? $records['allcount'] : 0;

$sel = mysqli_query($con, "select count(*) as allcount from upload_data WHERE  admin = '$Adminuser' AND dial_status!='NEW' AND list_id='$Get_list' AND 1 " . $searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = isset($records['allcount']) ? $records['allcount'] : 0;

$query = "SELECT * from upload_data WHERE admin = '$Adminuser' AND dial_status!='NEW' AND list_id='$Get_list' AND 1 " . $searchQuery . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;

$empRecords = mysqli_query($con, $query);
$data = array();
$sr = $row + 1;
while ($row = mysqli_fetch_assoc($empRecords)) {
  $data[] = array(
    "sr" => $sr,
    "id" => $row['id'],
    "company_name" => $row['company_name'],
    "employee_size" => $row['employee_size'],
    "industry" => $row['industry'],
    "country" => $row['country'],
    "city" => $row['city'],
    "department" => $row['department'],
    "designation" => $row['designation'],
    "email" => $row['email'],
    "name" => $row['name'],
    "phone_number" => $row['phone_number'],
    "phone_2" => $row['phone_2'],
    "phone_3" => $row['phone_3'],
    "phone_code" => $row['phone_code'],
    "username" => $row['username'],
    "admin" => $row['admin'],
    "ins_date" => $row['ins_date'],
    "dial_status" => $row['dial_status'],
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