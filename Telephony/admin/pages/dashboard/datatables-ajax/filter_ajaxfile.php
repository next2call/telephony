<?php
session_start();
include 'config.php';
$Adminuser = $_SESSION['user'];
$start = 0;
$filter = isset($_SESSION['filter']) ? $_SESSION['filter'] : '';
$ifilter = isset($_SESSION['ifilter']) ? $_SESSION['ifilter'] : '';
$click_id = '';

$date1 = date("Y-m-d");
$current_time = date("Y-m-d h:i:s");

    $get_data = $_SESSION['filter_type'];
  //  echo "</br>";
    $filter_data = $_SESSION['filter_data_ex'];

// echo "</br>";
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
  start_time like'%".$searchValue."%' or status like'%".$searchValue."%' or direction like'%".$searchValue."%' or dur like'%".$searchValue."%' ) ";
}

if($filter_data == 'today'){
  if($get_data == 'total_data')
  {
      $sel = mysqli_query($con, "select count(*) as allcount from cdr AND admin = '$Adminuser' AND start_time Like '%$date1%'");
  $records = mysqli_fetch_assoc($sel);
  $totalRecords = isset($records['allcount']) ? $records['allcount'] : 0;
  
  $sel = mysqli_query($con, "select count(*) as allcount from cdr WHERE  admin = '$Adminuser' AND start_time Like '%$date1%' AND 1 ".$searchQuery);
  $records = mysqli_fetch_assoc($sel);
  $totalRecordwithFilter = isset($records['allcount']) ? $records['allcount'] : 0;
  
   $query = "SELECT * from cdr WHERE admin = '$Adminuser' AND start_time Like '%$date1%' AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;

      // $tfnsel="SELECT * from cdr WHERE admin = '$Adminuser' AND start_time Like '%$date1%' ORDER BY id DESC";

  }elseif($get_data == 'other_data'){

    $sel = mysqli_query($con, "select count(*) as allcount from cdr AND admin = '$Adminuser' AND start_time Like '%$date1%' AND status!='CANCEL' AND status!='ANSWER'");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = isset($records['allcount']) ? $records['allcount'] : 0;
    
    $sel = mysqli_query($con, "select count(*) as allcount from cdr WHERE  admin = '$Adminuser' AND start_time Like '%$date1%' AND status!='CANCEL' AND status!='ANSWER' AND 1 ".$searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = isset($records['allcount']) ? $records['allcount'] : 0;
    
     $query = "SELECT * from cdr WHERE admin = '$Adminuser' AND start_time Like '%$date1%' AND status!='CANCEL' AND status!='ANSWER' AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
  
      // $tfnsel="SELECT * from cdr WHERE status!='CANCEL' AND status!='ANSWER' admin = '$Adminuser' AND start_time Like '%$date1%' ORDER BY id DESC";
  }elseif($get_data == 'ansewer_data'){

    $sel = mysqli_query($con, "select count(*) as allcount from cdr AND status='ANSWER'AND admin = '$Adminuser' AND start_time Like '%$date1%'");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = isset($records['allcount']) ? $records['allcount'] : 0;
    
    $sel = mysqli_query($con, "select count(*) as allcount from cdr WHERE status='ANSWER'AND admin = '$Adminuser' AND start_time Like '%$date1%' AND 1 ".$searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = isset($records['allcount']) ? $records['allcount'] : 0;
    
     $query = "SELECT * from cdr WHERE status='ANSWER'AND admin = '$Adminuser' AND start_time Like '%$date1%' AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;  

      // $tfnsel="SELECT * from cdr WHERE status='ANSWER'AND admin = '$Adminuser' AND start_time Like '%$date1%' ORDER BY id DESC";
  }elseif($get_data == 'cancel_data'){

    $sel = mysqli_query($con, "select count(*) as allcount from cdr AND status='CANCEL'AND admin = '$Adminuser' AND start_time Like '%$date1%'");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = isset($records['allcount']) ? $records['allcount'] : 0;
    
    $sel = mysqli_query($con, "select count(*) as allcount from cdr WHERE status='CANCEL'AND admin = '$Adminuser' AND start_time Like '%$date1%' AND 1 ".$searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = isset($records['allcount']) ? $records['allcount'] : 0;
    
     $query = "SELECT * from cdr WHERE status='CANCEL'AND admin = '$Adminuser' AND start_time Like '%$date1%' AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;  

      // $tfnsel="SELECT * from cdr WHERE status='CANCEL' AND admin = '$Adminuser' AND start_time Like '%$date1%' ORDER BY id DESC";
  }
  
}elseif($filter_data == 'all'){


  if($get_data == 'total_data')
  {
      $sel = mysqli_query($con, "select count(*) as allcount from cdr AND admin = '$Adminuser' ");
  $records = mysqli_fetch_assoc($sel);
  $totalRecords = isset($records['allcount']) ? $records['allcount'] : 0;
  
  $sel = mysqli_query($con, "select count(*) as allcount from cdr WHERE  admin = '$Adminuser' AND 1 ".$searchQuery);
  $records = mysqli_fetch_assoc($sel);
  $totalRecordwithFilter = isset($records['allcount']) ? $records['allcount'] : 0;
  
   $query = "SELECT * from cdr WHERE admin = '$Adminuser' AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;

      // $tfnsel="SELECT * from cdr WHERE admin = '$Adminuser' AND start_time Like '%$date1%' ORDER BY id DESC";

  }elseif($get_data == 'other_data'){

    $sel = mysqli_query($con, "select count(*) as allcount from cdr AND admin = '$Adminuser' AND status!='CANCEL' AND status!='ANSWER'");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = isset($records['allcount']) ? $records['allcount'] : 0;
    
    $sel = mysqli_query($con, "select count(*) as allcount from cdr WHERE  admin = '$Adminuser' AND status!='CANCEL' AND status!='ANSWER' AND 1 ".$searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = isset($records['allcount']) ? $records['allcount'] : 0;
    
     $query = "SELECT * from cdr WHERE admin = '$Adminuser' AND status!='CANCEL' AND status!='ANSWER' AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
  
      // $tfnsel="SELECT * from cdr WHERE status!='CANCEL' AND status!='ANSWER' admin = '$Adminuser' AND start_time Like '%$date1%' ORDER BY id DESC";
  }elseif($get_data == 'ansewer_data'){

    $sel = mysqli_query($con, "select count(*) as allcount from cdr AND status='ANSWER'AND admin = '$Adminuser'");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = isset($records['allcount']) ? $records['allcount'] : 0;
    
    $sel = mysqli_query($con, "select count(*) as allcount from cdr WHERE status='ANSWER' AND admin = '$Adminuser' 1 ".$searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = isset($records['allcount']) ? $records['allcount'] : 0;
    
     $query = "SELECT * from cdr WHERE status='ANSWER'AND admin = '$Adminuser' AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;  

      // $tfnsel="SELECT * from cdr WHERE status='ANSWER'AND admin = '$Adminuser' AND start_time Like '%$date1%' ORDER BY id DESC";
  }elseif($get_data == 'cancel_data'){

    $sel = mysqli_query($con, "select count(*) as allcount from cdr AND status='CANCEL'AND admin = '$Adminuser'");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = isset($records['allcount']) ? $records['allcount'] : 0;
    
    $sel = mysqli_query($con, "select count(*) as allcount from cdr WHERE status='CANCEL'AND admin = '$Adminuser' AND 1 ".$searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = isset($records['allcount']) ? $records['allcount'] : 0;
    
     $query = "SELECT * from cdr WHERE status='CANCEL'AND admin = '$Adminuser' AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;  

      // $tfnsel="SELECT * from cdr WHERE status='CANCEL' AND admin = '$Adminuser' AND start_time Like '%$date1%' ORDER BY id DESC";
  }
  
}else{


  if($get_data == 'total_data')
  {
    
      $sel = mysqli_query($con, "select count(*) as allcount from cdr AND admin = '$Adminuser' AND start_time Like '%$date1%'");
  $records = mysqli_fetch_assoc($sel);
  $totalRecords = isset($records['allcount']) ? $records['allcount'] : 0;
  
  $sel = mysqli_query($con, "select count(*) as allcount from cdr WHERE  admin = '$Adminuser' AND start_time Like '%$date1%' AND 1 ".$searchQuery);
  $records = mysqli_fetch_assoc($sel);
  $totalRecordwithFilter = isset($records['allcount']) ? $records['allcount'] : 0;
  // echo "</br>";//
  
    $query = "SELECT * from cdr WHERE admin = '$Adminuser' AND start_time Like '%$date1%' AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
  //  echo "</br>";

      // $tfnsel="SELECT * from cdr WHERE admin = '$Adminuser' AND start_time Like '%$date1%' ORDER BY id DESC";

  }elseif($get_data == 'other_data'){

    $sel = mysqli_query($con, "select count(*) as allcount from cdr AND admin = '$Adminuser' AND start_time Like '%$date1%' AND status!='CANCEL' AND status!='ANSWER'");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = isset($records['allcount']) ? $records['allcount'] : 0;
    
    $sel = mysqli_query($con, "select count(*) as allcount from cdr WHERE  admin = '$Adminuser' AND start_time Like '%$date1%' AND status!='CANCEL' AND status!='ANSWER' AND 1 ".$searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = isset($records['allcount']) ? $records['allcount'] : 0;
    
     $query = "SELECT * from cdr WHERE admin = '$Adminuser' AND start_time Like '%$date1%' AND status!='CANCEL' AND status!='ANSWER' AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
  
      // $tfnsel="SELECT * from cdr WHERE status!='CANCEL' AND status!='ANSWER' admin = '$Adminuser' AND start_time Like '%$date1%' ORDER BY id DESC";
  }elseif($get_data == 'ansewer_data'){

    $sel = mysqli_query($con, "select count(*) as allcount from cdr AND status='ANSWER'AND admin = '$Adminuser' AND start_time Like '%$date1%'");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = isset($records['allcount']) ? $records['allcount'] : 0;
    
    $sel = mysqli_query($con, "select count(*) as allcount from cdr WHERE status='ANSWER'AND admin = '$Adminuser' AND start_time Like '%$date1%' AND 1 ".$searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = isset($records['allcount']) ? $records['allcount'] : 0;
    
     $query = "SELECT * from cdr WHERE status='ANSWER'AND admin = '$Adminuser' AND start_time Like '%$date1%' AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;  

      // $tfnsel="SELECT * from cdr WHERE status='ANSWER'AND admin = '$Adminuser' AND start_time Like '%$date1%' ORDER BY id DESC";
  }elseif($get_data == 'cancel_data'){

    $sel = mysqli_query($con, "select count(*) as allcount from cdr AND status='CANCEL'AND admin = '$Adminuser' AND start_time Like '%$date1%'");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = isset($records['allcount']) ? $records['allcount'] : 0;
    
    $sel = mysqli_query($con, "select count(*) as allcount from cdr WHERE status='CANCEL'AND admin = '$Adminuser' AND start_time Like '%$date1%' AND 1 ".$searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = isset($records['allcount']) ? $records['allcount'] : 0;
    // echo "</br>";
    $query = "SELECT * from cdr WHERE status='CANCEL'AND admin = '$Adminuser' AND start_time Like '%$date1%' AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;  
    //  echo "</br>";
      // $tfnsel="SELECT * from cdr WHERE status='CANCEL' AND admin = '$Adminuser' AND start_time Like '%$date1%' ORDER BY id DESC";
  }

}





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
