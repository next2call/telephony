<?php
session_start();
include 'config.php';

// Get session variables
$user = $_SESSION['user'];
$agentid = $_SESSION['agent_name'];
$fromdate = $_SESSION['fromdate'];
$todate = $_SESSION['todate'];
$serch_type = $_SESSION['serch_type'];

$sel = "SELECT user_id FROM `users` WHERE SuperAdmin='$user'";
$sql = mysqli_query($con, $sel);
$admin_user = [];

while($rowu = mysqli_fetch_assoc($sql)){
    $admin_user[] = $rowu['user_id'];
}

$admin_user_list = implode("','", $admin_user);
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
    $searchQuery = " AND (company_name LIKE '%$searchValue%' OR 
                         name LIKE '%$searchValue%' OR 
                         phone_number LIKE '%$searchValue%' OR 
                         dialstatus LIKE '%$searchValue%' OR 
                         email LIKE '%$searchValue%' OR 
                         city LIKE '%$searchValue%' OR 
                         date LIKE '%$searchValue%')";
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
$totalRecordsQuery = "SELECT COUNT(*) as allcount FROM company_info WHERE DATE(date) between '$fromdate' AND '$todate' AND upload_user IN ('$admin_user_list') OR upload_user IN ('$agent_ids_str')  ";
$totalRecordsResult = mysqli_query($con, $totalRecordsQuery);
$totalRecords = mysqli_fetch_assoc($totalRecordsResult)['allcount'];

// Get total number of records with filtering
$totalRecordwithFilterQuery = "SELECT COUNT(*) as allcount FROM company_info WHERE DATE(date) between '$fromdate' AND '$todate' AND (upload_user IN ('$admin_user_list') OR upload_user IN ('$agent_ids_str')) $searchQuery";
$totalRecordwithFilterResult = mysqli_query($con, $totalRecordwithFilterQuery);
$totalRecordwithFilter = mysqli_fetch_assoc($totalRecordwithFilterResult)['allcount'];

// Fetch records
$query = "SELECT * FROM company_info WHERE DATE(date) between '$fromdate' AND '$todate' AND (upload_user IN ('$admin_user_list') OR upload_user IN ('$agent_ids_str')) $searchQuery 
          ORDER BY $columnName $columnSortOrder 
          LIMIT $row, $rowperpage";


} elseif ($serch_type == 'agent'){


  $totalRecordsQuery = "SELECT COUNT(*) as allcount FROM company_info WHERE upload_user IN ('$agentid')";
  $totalRecordsResult = mysqli_query($con, $totalRecordsQuery);
  $totalRecords = mysqli_fetch_assoc($totalRecordsResult)['allcount'];
  
  // Get total number of records with filtering
  $totalRecordwithFilterQuery = "SELECT COUNT(*) as allcount FROM company_info WHERE (upload_user IN ('$agentid')) $searchQuery";
  $totalRecordwithFilterResult = mysqli_query($con, $totalRecordwithFilterQuery);
  $totalRecordwithFilter = mysqli_fetch_assoc($totalRecordwithFilterResult)['allcount'];
  
  // Fetch records
  $query = "SELECT * FROM company_info WHERE (upload_user IN ('$agentid')) $searchQuery 
            ORDER BY $columnName $columnSortOrder 
            LIMIT $row, $rowperpage";
  
   
} elseif ($serch_type == 'date-agent'){

// Get total number of records without filtering
$totalRecordsQuery = "SELECT COUNT(*) as allcount FROM company_info WHERE DATE(date) between '$fromdate' AND '$todate' AND upload_user IN ('$agentid')  ";
$totalRecordsResult = mysqli_query($con, $totalRecordsQuery);
$totalRecords = mysqli_fetch_assoc($totalRecordsResult)['allcount'];

// Get total number of records with filtering
$totalRecordwithFilterQuery = "SELECT COUNT(*) as allcount FROM company_info WHERE DATE(date) between '$fromdate' AND '$todate' AND (upload_user IN ('$agentid')) $searchQuery";
$totalRecordwithFilterResult = mysqli_query($con, $totalRecordwithFilterQuery);
$totalRecordwithFilter = mysqli_fetch_assoc($totalRecordwithFilterResult)['allcount'];

// Fetch records
$query = "SELECT * FROM company_info WHERE DATE(date) between '$fromdate' AND '$todate' AND (upload_user IN ('$agentid')) $searchQuery 
          ORDER BY $columnName $columnSortOrder 
          LIMIT $row, $rowperpage";

    
} else {

// Get total number of records without filtering
$totalRecordsQuery = "SELECT COUNT(*) as allcount FROM company_info WHERE upload_user IN ('$admin_user_list') OR upload_user IN ('$agent_ids_str')";
$totalRecordsResult = mysqli_query($con, $totalRecordsQuery);
$totalRecords = mysqli_fetch_assoc($totalRecordsResult)['allcount'];

// Get total number of records with filtering
$totalRecordwithFilterQuery = "SELECT COUNT(*) as allcount FROM company_info WHERE (upload_user IN ('$admin_user_list') OR upload_user IN ('$agent_ids_str')) $searchQuery";
$totalRecordwithFilterResult = mysqli_query($con, $totalRecordwithFilterQuery);
$totalRecordwithFilter = mysqli_fetch_assoc($totalRecordwithFilterResult)['allcount'];

// Fetch records
$query = "SELECT * FROM company_info WHERE (upload_user IN ('$admin_user_list') OR upload_user IN ('$agent_ids_str')) $searchQuery 
          ORDER BY $columnName $columnSortOrder 
          LIMIT $row, $rowperpage";


}



$empRecords = mysqli_query($con, $query);

// Prepare data for JSON response
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
        "date" => $row['date'],
        "dialstatus" => $row['dialstatus'],
        "campaign_id" => $row['campaign_id'],
        "upload_user" => $row['upload_user'],
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
