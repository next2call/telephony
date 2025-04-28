<?php
session_start();
if(!isset($_SESSION['user']))
{
// header("Location: login.php");
header("Location: session_out.php");
}

include 'config.php';


$to_date = date("Y-m-d");

$date_24 = date("Y-m-d h:i:s");


$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
// $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
// $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$columnName = 'id'; // Column name
$columnSortOrder = 'desc'; // asc or desc
$searchValue = mysqli_real_escape_string($con,$_POST['search']['value']); // Search value


## Search 
$searchQuery = " ";
if($searchValue != ''){
	$searchQuery = " and (caller_number like '%".$searchValue."%' or 
    massage like '%".$searchValue."%' or disposition like'%".$searchValue."%' ) ";
}


## Total number of records without filtering
$sel = mysqli_query($con,"select count(*) as allcount from call_notes");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = mysqli_query($con,"select count(*) as allcount from call_notes WHERE 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "select * from call_notes WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
// echo $empQuery = "select * from call_notes WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;







$empRecords = mysqli_query($con, $empQuery);
$data = array();
$sr='1';
while ($row = mysqli_fetch_assoc($empRecords)) {
    $data[] = array(
            "sr" => $sr,
    		"phone_code"=>$row['phone_code'],
    		"caller_number"=>$row['caller_number'],
    		"massage"=>$row['massage'],
    		"disposition"=>$row['disposition'],
    		"datetime"=>$row['datetime']
    
    	);
        $sr++;
}

## Response
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $data
);

echo json_encode($response);
