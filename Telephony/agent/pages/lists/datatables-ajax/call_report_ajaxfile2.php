<?php
session_start();
if(!isset($_SESSION['username']))
{
// header("Location: login.php");
header("Location: session_out.php");
}

include 'config.php';


$username = $_SESSION['username'];
$sesnumber = $_SESSION['number'];
$AdminNu =$_SESSION['admin_number'];

$tfnsel_1 = "SELECT * FROM user WHERE userName='$username'";
$data_1 = mysqli_query($con, $tfnsel_1);
if(mysqli_num_rows($data_1) > 0){
  $user_row = mysqli_fetch_assoc($data_1);
  $status_user = $user_row['status'];

  if($status_user == '1'){

	$tstatus = 'superadmin';
	$sel_did="SELECT * FROM compaignlist WHERE admin='$username'";
	$sel_query=mysqli_query($con, $sel_did);
	$row_did=mysqli_fetch_array($sel_query);
	$data_camp=$row_did['compaignnumber'];

  }else if($status_user == '2'){

	$tstatus = 'groupsuperadmin';

  }else if($status_user == '0'){

	$tstatus = 'admin';

	$sel_did="SELECT * FROM compaignlist WHERE admin='$username'";
	$sel_query=mysqli_query($con, $sel_did);
	$row_did=mysqli_fetch_array($sel_query);
	$data_camp=$row_did['compaignnumber'];
  }

} else {
  $tstatus = 'agent';

  $sel_did1="SELECT compaignlist.*
  FROM compaignlist
  JOIN forwardingtable ON forwardingtable.user_name = compaignlist.admin
  WHERE forwardingtable.forwardnumber = '$sesnumber'";

$sel_query1=mysqli_query($con, $sel_did1);
$row_did1=mysqli_fetch_array($sel_query1);
 $data_camp=$row_did1['compaignnumber'];
// die();
}


$to_date = date("Y-m-d");

$date_24 = date("Y-m-d h:i:s");

// if(!empty($_SESSION['csptime'])){
    $csptime = $_SESSION['csptime']; 
// } else if(!empty($_SESSION['csagent'])){
    $csagent = $_SESSION['csagent'];
// } else if(!empty($_SESSION['cal_date']) && !empty($_SESSION['cal_date2'])){
//     $cal_date = $_SESSION['cal_date'];
//     $cal_date2 = $_SESSION['cal_date2'];    
// } else if(!empty($_SESSION['csptime']) && !empty($_SESSION['csagent'])){                        
//     $csptime = $_SESSION['csptime']; 
//     $csagent = $_SESSION['csagent'];
//   } else if(!empty($_SESSION['csagent']) && !empty($_SESSION['cal_date'])){ 
//   ;   
//     $csagent = $_SESSION['csagent'];
//    } 

// if($cal_date != $to_date){
    $cal_date = $_SESSION['cal_date'];
    $cal_date2 = $_SESSION['cal_date2'];
// }

echo "<script>alert('$csptime')</script>";
echo "<script>alert('$csagent')</script>";
echo "<script>alert('$cal_date')</script>";
echo "<script>alert('$cal_date2')</script>";

## Read value
// $draw = $_POST['draw'];
// $row = $_POST['start'];
// $rowperpage = $_POST['length']; // Rows display per page
// $columnIndex = $_POST['order'][0]['column']; // Column index
// $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
// $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
// $searchValue = mysqli_real_escape_string($con,$_POST['search']['value']); // Search value
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
	$searchQuery = " and (number like '%".$searchValue."%' or 
    forward like '%".$searchValue."%' or 
    agentName like'%".$searchValue."%' or starttime like'%".$searchValue."%' ) ";
}

if($tstatus == 'admin'){
###### main condition start for form submit ========================
if(!empty($csptime) && !empty($csagent) && !empty($cal_date) && !empty($cal_date2)){
## Total number of records without filtering
$sel = mysqli_query($con,"select count(*) as allcount from anveyacdr WHERE forward='$csagent' AND pri_number='$data_camp' AND starttime BETWEEN '$csptime' AND '$to_date'");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = mysqli_query($con,"select count(*) as allcount from anveyacdr WHERE forward='$csagent' AND pri_number='$data_camp' AND starttime BETWEEN '$csptime' AND '$to_date' AND 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
echo $empQuery = "select * from anveyacdr WHERE forward='$csagent' AND pri_number='$data_camp' AND starttime BETWEEN '$csptime' AND '$to_date' AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
// echo $empQuery = "select * from anveyacdr WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
die();
}elseif(!empty($csagent) && !empty($cal_date) && !empty($cal_date2) && empty($csptime)){
## Total number of records without filtering
$sel = mysqli_query($con,"select count(*) as allcount from anveyacdr WHERE forward='$csagent' AND pri_number='$data_camp' AND starttime BETWEEN '$cal_date' AND '$cal_date2'");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = mysqli_query($con,"select count(*) as allcount from anveyacdr WHERE forward='$csagent' AND pri_number='$data_camp' AND starttime BETWEEN '$cal_date' AND '$cal_date2' AND 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
echo $empQuery = "select * from anveyacdr WHERE forward='$csagent' AND pri_number='$data_camp' AND starttime BETWEEN '$cal_date' AND '$cal_date2' AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
// echo $empQuery = "select * from anveyacdr WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
die();
}
elseif(!empty($csagent) && !empty($cal_date) && !empty($cal_date2)){

## Total number of records without filtering
$sel = mysqli_query($con,"select count(*) as allcount from anveyacdr WHERE forward='$sesnumber' AND pri_number='$data_camp' AND starttime LIKE '%$to_date%'");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = mysqli_query($con,"select count(*) as allcount from anveyacdr WHERE forward='$sesnumber' AND pri_number='$data_camp' AND starttime LIKE '%$to_date%' AND 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
echo $empQuery = "select * from anveyacdr WHERE forward='$sesnumber' AND pri_number='$data_camp' AND starttime LIKE '%$to_date%' AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
// echo $empQuery = "select * from anveyacdr WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
die();
}elseif(!empty($csptime) && !empty($cal_date) && !empty($cal_date2)) {
    ## Total number of records without filtering
$sel = mysqli_query($con,"select count(*) as allcount from anveyacdr WHERE pri_number='$data_camp' AND starttime BETWEEN '$csptime' AND '$to_date'");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = mysqli_query($con,"select count(*) as allcount from anveyacdr WHERE pri_number='$data_camp' AND starttime BETWEEN '$csptime' AND '$to_date' AND 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
echo $empQuery = "select * from anveyacdr WHERE pri_number='$data_camp' AND starttime BETWEEN '$csptime' AND '$to_date' AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
// echo $empQuery = "select * from anveyacdr WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
die();
}
else{
 ## Total number of records without filtering
$sel = mysqli_query($con,"select count(*) as allcount from anveyacdr WHERE pri_number='$data_camp' AND starttime LIKE '%$to_date%'");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = mysqli_query($con,"select count(*) as allcount from anveyacdr WHERE pri_number='$data_camp' AND starttime LIKE '%$to_date%' AND 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
echo $empQuery = "select * from anveyacdr WHERE pri_number='$data_camp' AND starttime LIKE '%$to_date%' AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
// echo $empQuery = "select * from anveyacdr WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
die();
}


###### main condition start for form submit ========================

} elseif($tstatus == 'agent'){

## Total number of records without filtering
$sel = mysqli_query($con,"select count(*) as allcount from anveyacdr WHERE forward='$sesnumber' AND pri_number='$data_camp' AND starttime LIKE '%$to_date%'");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = mysqli_query($con,"select count(*) as allcount from anveyacdr WHERE forward='$sesnumber' AND pri_number='$data_camp' AND starttime LIKE '%$to_date%' AND 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "select * from anveyacdr WHERE forward='$sesnumber' AND pri_number='$data_camp' AND starttime LIKE '%$to_date%' AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
// echo $empQuery = "select * from anveyacdr WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;

}





$empRecords = mysqli_query($con, $empQuery);
$data = array();
$sr='1';
while ($row = mysqli_fetch_assoc($empRecords)) {
    $data[] = array(
            "sr" => $sr,
    		"agentName"=>$row['agentName'],
    		"client_name"=>$row['client_name'],
    		"number"=>$row['number'],
    		"status"=>$row['status'],
    		"starttime"=>$row['starttime'],
    		"endtime"=>$row['endtime'],
    		"forward"=>$row['forward'],
    		"call_location"=>$row['call_location'],
    		"recording"=>$row['recording'],
    		"direction"=>$row['direction']
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
