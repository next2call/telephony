<?php
session_start();
include 'config.php';

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
    $searchQuery = " WHERE (id LIKE '%$searchValue%' OR 
                             to_emails LIKE '%$searchValue%' OR 
                             subject LIKE '%$searchValue%' OR 
                             email_body LIKE '%$searchValue%' OR 
                             status LIKE '%$searchValue%' OR 
                             type LIKE '%$searchValue%' OR 
                             Agents LIKE '%$searchValue%' OR 
                             Admin LIKE '%$searchValue%')";
}

// Get total number of records without filtering
$totalRecordsQuery = "SELECT COUNT(*) as allcount FROM email_templates";
$totalRecordsResult = mysqli_query($con, $totalRecordsQuery);
$totalRecords = mysqli_fetch_assoc($totalRecordsResult)['allcount'];

// Get total number of records with filtering
$totalRecordwithFilterQuery = "SELECT COUNT(*) as allcount FROM email_templates $searchQuery";
$totalRecordwithFilterResult = mysqli_query($con, $totalRecordwithFilterQuery);
$totalRecordwithFilter = mysqli_fetch_assoc($totalRecordwithFilterResult)['allcount'];

// Fetch records
$query = "SELECT id, to_emails, subject, email_body, status, type, Agents, Admin, Create_time, Ip_Address 
          FROM email_templates $searchQuery 
          ORDER BY $columnName $columnSortOrder 
          LIMIT $row, $rowperpage";

$empRecords = mysqli_query($con, $query);
$data = [];
$sr = $row + 1;
while ($row = mysqli_fetch_assoc($empRecords)) {
    $data[] = array(
        "sr" => $sr,
        "id" => $row['id'],
        "to_emails" => $row['to_emails'],
        "subject" => $row['subject'],
        "email_body" => $row['email_body'],
        "status" => $row['status'],
        "type" => $row['type'],
        "Agents" => $row['Agents'],
        "Admin" => $row['Admin'],
        "Create_time" => $row['Create_time'],
        "Ip_Address" => $row['Ip_Address']
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