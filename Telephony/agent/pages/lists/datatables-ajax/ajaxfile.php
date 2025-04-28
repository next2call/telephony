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

$searchValue = isset($_POST['search']['value']) ? mysqli_real_escape_string($con, $_POST['search']['value']) : ''; // Search value

## Search 
$searchQuery = "";
if($searchValue != ''){
  $searchQuery = " and (company_name like '%".$searchValue."%' or 
  name like '%".$searchValue."%' or 
  phone_number like'%".$searchValue."%' or date like'%".$searchValue."%' ) ";
}


  $sel = mysqli_query($con, "select count(*) as allcount from company_info AND upload_user = '$user'");
  $records = mysqli_fetch_assoc($sel);
  $totalRecords = isset($records['allcount']) ? $records['allcount'] : 0;
  
  $sel = mysqli_query($con, "select count(*) as allcount from company_info WHERE upload_user = '$user' AND 1 ".$searchQuery);
  $records = mysqli_fetch_assoc($sel);
  $totalRecordwithFilter = isset($records['allcount']) ? $records['allcount'] : 0;
  
    $query = "SELECT * from company_info WHERE upload_user = '$user' AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;

$empRecords = mysqli_query($con, $query);
$data = array();
$sr = $row + 1;
while ($row = mysqli_fetch_assoc($empRecords)) {
  $phone_number = $row['phone_number'];
  $email = $row['email'];

  // Process email hiding logic
  if ($caller_email == '1') {
      $emailParts = explode('@', $email);
      if (count($emailParts) == 2) {
          $username = $emailParts[0];
          $domain = $emailParts[1];

          // Hide middle part of the username (replace it with asterisks)
          if (strlen($username) > 2) {
              $username = substr($username, 0, 2) . str_repeat('*', strlen($username) - 2);
          }

          // Reassemble the email
          $formattedEmail = $username . '@' . $domain;
      } else {
          // If email format is incorrect, keep it as is
          $formattedEmail = $email;
      }
  } else {
      $formattedEmail = $email;
  }

  // Process phone number hiding logic
  if ($caller_contact == '1') {
      $formattedNumber = str_repeat('*', 6) . substr($phone_number, -4); // Show last 4 digits
  } else {
      $formattedNumber = $phone_number;
  }

  // Add row data to the result array
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
      "email" => $formattedEmail,
      "name" => $row['name'],
      "phone_number" => $formattedNumber,
      "phone_2" => $row['phone_2'],
      "date" => $row['date'],
      "dialstatus" => $row['dialstatus'],
      "ins_date" => $row['ins_date'],
      "remark" => $row['remark'],
      "campaign_id" => $row['campaign_id'],
      "upload_user" => $row['upload_user'],
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
