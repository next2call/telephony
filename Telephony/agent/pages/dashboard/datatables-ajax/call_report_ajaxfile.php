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

   $csptime = $_SESSION['csptime'];
   $agentid = $_SESSION['agent_name'];
   $fromdate = $_SESSION['fromdate'];
   $todate = $_SESSION['todate'];
   $serch_type = $_SESSION['serch_type'];

$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = 'id';
$columnSortOrder = 'desc';
$searchValue = mysqli_real_escape_string($con,$_POST['search']['value']); // Search value



$searchQuery = " ";
if($searchValue != ''){
	$searchQuery = " and (number like '%".$searchValue."%' or 
    forward like '%".$searchValue."%' or 
    agentName like'%".$searchValue."%' or starttime like'%".$searchValue."%' ) ";
}

if($tstatus == 'admin'){

if($serch_type == 'time'){
  $sel = mysqli_query($con, "SELECT COUNT(*) as allcount
  FROM compaignlist
  JOIN anveyacdr ON compaignlist.compaignnumber = anveyacdr.pri_number
     WHERE compaignlist.admin = '$username' AND anveyacdr.starttime BETWEEN '$csptime' AND '$to_date'");
 $records = mysqli_fetch_assoc($sel);
 $totalRecords = $records['allcount'];
 
 
 $sel = mysqli_query($con,"SELECT COUNT(*) as allcount
 FROM compaignlist
 JOIN anveyacdr ON compaignlist.compaignnumber = anveyacdr.pri_number
     WHERE compaignlist.admin = '$username' AND anveyacdr.starttime BETWEEN '$csptime' AND '$to_date' AND 1 ".$searchQuery);
 $records = mysqli_fetch_assoc($sel);
 $totalRecordwithFilter = $records['allcount'];
 
     $empQuery = "SELECT anveyacdr.*
     FROM compaignlist
     JOIN anveyacdr ON compaignlist.compaignnumber = anveyacdr.pri_number
     WHERE compaignlist.admin = '$username' AND anveyacdr.starttime BETWEEN '$csptime' AND '$to_date'
     AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;


} elseif ($serch_type == 'date'){

  $sel = mysqli_query($con, "SELECT COUNT(*) as allcount
  FROM compaignlist
  JOIN anveyacdr ON compaignlist.compaignnumber = anveyacdr.pri_number
     WHERE compaignlist.admin = '$username' AND anveyacdr.starttime BETWEEN '$fromdate' AND '$todate'");
 $records = mysqli_fetch_assoc($sel);
 $totalRecords = $records['allcount'];
 
 
 $sel = mysqli_query($con,"SELECT COUNT(*) as allcount
 FROM compaignlist
 JOIN anveyacdr ON compaignlist.compaignnumber = anveyacdr.pri_number
     WHERE compaignlist.admin = '$username' AND anveyacdr.starttime BETWEEN '$fromdate' AND '$todate' AND 1 ".$searchQuery);
 $records = mysqli_fetch_assoc($sel);
 $totalRecordwithFilter = $records['allcount'];
 
     $empQuery = "SELECT anveyacdr.*
     FROM compaignlist
     JOIN anveyacdr ON compaignlist.compaignnumber = anveyacdr.pri_number
     WHERE compaignlist.admin = '$username' AND anveyacdr.starttime BETWEEN '$fromdate' AND '$todate'
     AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;

   
} elseif ($serch_type == 'agent'){

  $sel = mysqli_query($con, "SELECT COUNT(*) as allcount
  FROM compaignlist
  JOIN anveyacdr ON compaignlist.compaignnumber = anveyacdr.pri_number
     WHERE compaignlist.admin = '$username' AND anveyacdr.forward = '$agentid'");
 $records = mysqli_fetch_assoc($sel);
 $totalRecords = $records['allcount'];
 
 
 $sel = mysqli_query($con,"SELECT COUNT(*) as allcount
 FROM compaignlist
 JOIN anveyacdr ON compaignlist.compaignnumber = anveyacdr.pri_number
     WHERE compaignlist.admin = '$username' AND anveyacdr.forward = '$agentid' AND 1 ".$searchQuery);
 $records = mysqli_fetch_assoc($sel);
 $totalRecordwithFilter = $records['allcount'];
 
      $empQuery = "SELECT anveyacdr.*
     FROM compaignlist
     JOIN anveyacdr ON compaignlist.compaignnumber = anveyacdr.pri_number
     WHERE compaignlist.admin = '$username' AND anveyacdr.forward = '$agentid'
     AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
   
} elseif ($serch_type == 'time-agent'){

  $sel = mysqli_query($con, "SELECT COUNT(*) as allcount
  FROM compaignlist
  JOIN anveyacdr ON compaignlist.compaignnumber = anveyacdr.pri_number
     WHERE compaignlist.admin = '$username' AND anveyacdr.forward = '$agentid' AND anveyacdr.starttime BETWEEN '$csptime' AND '$to_date'");
 $records = mysqli_fetch_assoc($sel);
 $totalRecords = $records['allcount'];
 
 
 $sel = mysqli_query($con,"SELECT COUNT(*) as allcount
 FROM compaignlist
 JOIN anveyacdr ON compaignlist.compaignnumber = anveyacdr.pri_number
     WHERE compaignlist.admin = '$username' AND anveyacdr.forward = '$agentid' AND anveyacdr.starttime BETWEEN '$csptime' AND '$to_date' AND 1 ".$searchQuery);
 $records = mysqli_fetch_assoc($sel);
 $totalRecordwithFilter = $records['allcount'];
 
      $empQuery = "SELECT anveyacdr.*
     FROM compaignlist
     JOIN anveyacdr ON compaignlist.compaignnumber = anveyacdr.pri_number
     WHERE compaignlist.admin = '$username' AND anveyacdr.forward = '$agentid' AND anveyacdr.starttime BETWEEN '$csptime' AND '$to_date'
     AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
   
} elseif ($serch_type == 'date-agent'){

  $sel = mysqli_query($con, "SELECT COUNT(*) as allcount
  FROM compaignlist
  JOIN anveyacdr ON compaignlist.compaignnumber = anveyacdr.pri_number
     WHERE compaignlist.admin = '$username' AND anveyacdr.forward = '$agentid' AND anveyacdr.starttime BETWEEN '$fromdate' AND '$todate'");
 $records = mysqli_fetch_assoc($sel);
 $totalRecords = $records['allcount'];
 
 
 $sel = mysqli_query($con,"SELECT COUNT(*) as allcount
 FROM compaignlist
 JOIN anveyacdr ON compaignlist.compaignnumber = anveyacdr.pri_number
     WHERE compaignlist.admin = '$username' AND anveyacdr.forward = '$agentid' AND anveyacdr.starttime BETWEEN '$fromdate' AND '$todate' AND 1 ".$searchQuery);
 $records = mysqli_fetch_assoc($sel);
 $totalRecordwithFilter = $records['allcount'];
 
      $empQuery = "SELECT anveyacdr.*
     FROM compaignlist
     JOIN anveyacdr ON compaignlist.compaignnumber = anveyacdr.pri_number
     WHERE compaignlist.admin = '$username' AND anveyacdr.forward = '$agentid' AND anveyacdr.starttime BETWEEN '$fromdate' AND '$todate'
     AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
   
} else {

  $sel = mysqli_query($con, "SELECT COUNT(*) as allcount
  FROM compaignlist
  JOIN anveyacdr ON compaignlist.compaignnumber = anveyacdr.pri_number
     WHERE compaignlist.admin = '$username'");
 $records = mysqli_fetch_assoc($sel);
 $totalRecords = $records['allcount'];
 
 
 $sel = mysqli_query($con,"SELECT COUNT(*) as allcount
 FROM compaignlist
 JOIN anveyacdr ON compaignlist.compaignnumber = anveyacdr.pri_number
     WHERE compaignlist.admin = '$username' AND 1 ".$searchQuery);
 $records = mysqli_fetch_assoc($sel);
 $totalRecordwithFilter = $records['allcount'];
 
     $empQuery = "SELECT anveyacdr.*
     FROM compaignlist
     JOIN anveyacdr ON compaignlist.compaignnumber = anveyacdr.pri_number
     WHERE compaignlist.admin = '$username'
     AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;

}


} elseif($tstatus == 'agent'){

  if($serch_type == 'time'){

    $sel = mysqli_query($con,"select count(*) as allcount from anveyacdr WHERE forward='$sesnumber' AND starttime BETWEEN '$csptime' AND '$to_date'");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];
    
    $sel = mysqli_query($con,"select count(*) as allcount from anveyacdr WHERE forward='$sesnumber' AND starttime BETWEEN '$csptime' AND '$to_date' AND 1 ".$searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];
    
        $empQuery = "SELECT * from anveyacdr where forward='$sesnumber' AND starttime BETWEEN '$csptime' AND '$to_date' AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
  
  } elseif($serch_type == 'date'){

    $sel = mysqli_query($con,"select count(*) as allcount from anveyacdr WHERE forward='$sesnumber' AND starttime BETWEEN '$fromdate' AND '$todate'");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];
    
    $sel = mysqli_query($con,"select count(*) as allcount from anveyacdr WHERE forward='$sesnumber' AND starttime BETWEEN '$fromdate' AND '$todate' AND 1 ".$searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];
    
        $empQuery = "SELECT * from anveyacdr where forward='$sesnumber' AND starttime BETWEEN '$fromdate' AND '$todate' AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
  
  } else {

$sel = mysqli_query($con,"select count(*) as allcount from anveyacdr WHERE forward='$sesnumber'");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

$sel = mysqli_query($con,"select count(*) as allcount from anveyacdr WHERE forward='$sesnumber' AND 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

	  $empQuery = "SELECT * from anveyacdr where forward='$sesnumber' AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
 


  } 
  

} elseif($tstatus == 'groupsuperadmin'){

  
if($serch_type == 'time'){
  $sel = mysqli_query($con, "SELECT COUNT(*) as allcount
  FROM compaignlist
  JOIN anveyacdr ON compaignlist.compaignnumber = anveyacdr.pri_number
     WHERE compaignlist.super_admin = '$username' AND anveyacdr.starttime BETWEEN '$csptime' AND '$to_date'");
 $records = mysqli_fetch_assoc($sel);
 $totalRecords = $records['allcount'];
 
 
 $sel = mysqli_query($con,"SELECT COUNT(*) as allcount
 FROM compaignlist
 JOIN anveyacdr ON compaignlist.compaignnumber = anveyacdr.pri_number
     WHERE compaignlist.super_admin = '$username' AND anveyacdr.starttime BETWEEN '$csptime' AND '$to_date' AND 1 ".$searchQuery);
 $records = mysqli_fetch_assoc($sel);
 $totalRecordwithFilter = $records['allcount'];
 
     $empQuery = "SELECT anveyacdr.*
     FROM compaignlist
     JOIN anveyacdr ON compaignlist.compaignnumber = anveyacdr.pri_number
     WHERE compaignlist.super_admin = '$username' AND anveyacdr.starttime BETWEEN '$csptime' AND '$to_date'
     AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;


} elseif ($serch_type == 'date'){

  $sel = mysqli_query($con, "SELECT COUNT(*) as allcount
  FROM compaignlist
  JOIN anveyacdr ON compaignlist.compaignnumber = anveyacdr.pri_number
     WHERE compaignlist.super_admin = '$username' AND anveyacdr.starttime BETWEEN '$fromdate' AND '$todate'");
 $records = mysqli_fetch_assoc($sel);
 $totalRecords = $records['allcount'];
 
 
 $sel = mysqli_query($con,"SELECT COUNT(*) as allcount
 FROM compaignlist
 JOIN anveyacdr ON compaignlist.compaignnumber = anveyacdr.pri_number
     WHERE compaignlist.super_admin = '$username' AND anveyacdr.starttime BETWEEN '$fromdate' AND '$todate' AND 1 ".$searchQuery);
 $records = mysqli_fetch_assoc($sel);
 $totalRecordwithFilter = $records['allcount'];
 
     $empQuery = "SELECT anveyacdr.*
     FROM compaignlist
     JOIN anveyacdr ON compaignlist.compaignnumber = anveyacdr.pri_number
     WHERE compaignlist.super_admin = '$username' AND anveyacdr.starttime BETWEEN '$fromdate' AND '$todate'
     AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;

   
} elseif ($serch_type == 'agent'){

  $sel = mysqli_query($con, "SELECT COUNT(*) as allcount
  FROM compaignlist
  JOIN anveyacdr ON compaignlist.compaignnumber = anveyacdr.pri_number
     WHERE compaignlist.super_admin = '$username' AND anveyacdr.forward = '$agentid'");
 $records = mysqli_fetch_assoc($sel);
 $totalRecords = $records['allcount'];
 
 
 $sel = mysqli_query($con,"SELECT COUNT(*) as allcount
 FROM compaignlist
 JOIN anveyacdr ON compaignlist.compaignnumber = anveyacdr.pri_number
     WHERE compaignlist.super_admin = '$username' AND anveyacdr.forward = '$agentid' AND 1 ".$searchQuery);
 $records = mysqli_fetch_assoc($sel);
 $totalRecordwithFilter = $records['allcount'];
 
      $empQuery = "SELECT anveyacdr.*
     FROM compaignlist
     JOIN anveyacdr ON compaignlist.compaignnumber = anveyacdr.pri_number
     WHERE compaignlist.super_admin = '$username' AND anveyacdr.forward = '$agentid'
     AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
   
} elseif ($serch_type == 'time-agent'){

  $sel = mysqli_query($con, "SELECT COUNT(*) as allcount
  FROM compaignlist
  JOIN anveyacdr ON compaignlist.compaignnumber = anveyacdr.pri_number
     WHERE compaignlist.super_admin = '$username' AND anveyacdr.forward = '$agentid' AND anveyacdr.starttime BETWEEN '$csptime' AND '$to_date'");
 $records = mysqli_fetch_assoc($sel);
 $totalRecords = $records['allcount'];
 
 
 $sel = mysqli_query($con,"SELECT COUNT(*) as allcount
 FROM compaignlist
 JOIN anveyacdr ON compaignlist.compaignnumber = anveyacdr.pri_number
     WHERE compaignlist.super_admin = '$username' AND anveyacdr.forward = '$agentid' AND anveyacdr.starttime BETWEEN '$csptime' AND '$to_date' AND 1 ".$searchQuery);
 $records = mysqli_fetch_assoc($sel);
 $totalRecordwithFilter = $records['allcount'];
 
      $empQuery = "SELECT anveyacdr.*
     FROM compaignlist
     JOIN anveyacdr ON compaignlist.compaignnumber = anveyacdr.pri_number
     WHERE compaignlist.super_admin = '$username' AND anveyacdr.forward = '$agentid' AND anveyacdr.starttime BETWEEN '$csptime' AND '$to_date'
     AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
   
} elseif ($serch_type == 'date-agent'){

  $sel = mysqli_query($con, "SELECT COUNT(*) as allcount
  FROM compaignlist
  JOIN anveyacdr ON compaignlist.compaignnumber = anveyacdr.pri_number
     WHERE compaignlist.super_admin = '$username' AND anveyacdr.forward = '$agentid' AND anveyacdr.starttime BETWEEN '$fromdate' AND '$todate'");
 $records = mysqli_fetch_assoc($sel);
 $totalRecords = $records['allcount'];
 
 
 $sel = mysqli_query($con,"SELECT COUNT(*) as allcount
 FROM compaignlist
 JOIN anveyacdr ON compaignlist.compaignnumber = anveyacdr.pri_number
     WHERE compaignlist.super_admin = '$username' AND anveyacdr.forward = '$agentid' AND anveyacdr.starttime BETWEEN '$fromdate' AND '$todate' AND 1 ".$searchQuery);
 $records = mysqli_fetch_assoc($sel);
 $totalRecordwithFilter = $records['allcount'];
 
      $empQuery = "SELECT anveyacdr.*
     FROM compaignlist
     JOIN anveyacdr ON compaignlist.compaignnumber = anveyacdr.pri_number
     WHERE compaignlist.super_admin = '$username' AND anveyacdr.forward = '$agentid' AND anveyacdr.starttime BETWEEN '$fromdate' AND '$todate'
     AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
   
} else {

  $sel = mysqli_query($con, "SELECT COUNT(*) as allcount
  FROM compaignlist
  JOIN anveyacdr ON compaignlist.compaignnumber = anveyacdr.pri_number
     WHERE compaignlist.super_admin = '$username'");
 $records = mysqli_fetch_assoc($sel);
 $totalRecords = $records['allcount'];
 
 
 $sel = mysqli_query($con,"SELECT COUNT(*) as allcount
 FROM compaignlist
 JOIN anveyacdr ON compaignlist.compaignnumber = anveyacdr.pri_number
     WHERE compaignlist.super_admin = '$username' AND 1 ".$searchQuery);
 $records = mysqli_fetch_assoc($sel);
 $totalRecordwithFilter = $records['allcount'];
 
     $empQuery = "SELECT anveyacdr.*
     FROM compaignlist
     JOIN anveyacdr ON compaignlist.compaignnumber = anveyacdr.pri_number
     WHERE compaignlist.super_admin = '$username'
     AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;

}

} else {

  if($serch_type == 'time'){
    $sel = mysqli_query($con,"select count(*) as allcount from anveyacdr WHERE starttime BETWEEN '$csptime' AND '$to_date'");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];


$sel = mysqli_query($con,"select count(*) as allcount from anveyacdr WHERE starttime BETWEEN '$csptime' AND '$to_date' AND 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

	  $empQuery = "SELECT * from anveyacdr where starttime BETWEEN '$csptime' AND '$to_date' AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
  } elseif($serch_type == 'date'){
    $sel = mysqli_query($con,"select count(*) as allcount from anveyacdr WHERE starttime BETWEEN '$fromdate' AND '$todate'");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];


$sel = mysqli_query($con,"select count(*) as allcount from anveyacdr WHERE starttime BETWEEN '$fromdate' AND '$todate' AND 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

	  $empQuery = "SELECT * from anveyacdr where starttime BETWEEN '$fromdate' AND '$todate' AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
  } else {

    $sel = mysqli_query($con,"select count(*) as allcount from anveyacdr");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];
    
    
    $sel = mysqli_query($con,"select count(*) as allcount from anveyacdr WHERE 1 ".$searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];
    
        $empQuery = "SELECT * from anveyacdr where 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;

  }

}





$empRecords = mysqli_query($con, $empQuery);
$data = array();
$sr = $row + 1;
while ($row = mysqli_fetch_assoc($empRecords)) {

    $data[] = array(
    		"sr"=>$sr,
    		"id"=>$row['id'],
    		"agentName"=>$row['agentName'],
    		"number"=>$row['number'],
    		"client_name"=>$row['client_name'],
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
