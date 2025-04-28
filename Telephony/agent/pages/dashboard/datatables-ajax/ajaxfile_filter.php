<?php
session_start();
include 'config.php';
$user = $_SESSION['user'];
$user_admin = $_SESSION['user_admin'];
 
$tfnsel_1 = "SELECT caller_email, caller_contact FROM users WHERE $condition admin = '$user_admin'";
$data_1 = mysqli_query($con, $tfnsel_1);
$user_row = mysqli_fetch_assoc($data_1);
$caller_email = $user_row['caller_email'];
$caller_contact = $user_row['caller_contact']; 
$start = 0;
$filter = isset($_SESSION['filter']) ? $_SESSION['filter'] : '';
$ifilter = isset($_SESSION['ifilter']) ? $_SESSION['ifilter'] : '';
$click_id = '';

$date1 = date("Y-m-d");
$date_24 = date("Y-m-d h:i:s");
   $agentid = $_SESSION['agent_name'];
   $fromdate = $_SESSION['fromdate'];
   $todate = $_SESSION['todate'];
   $serch_type = $_SESSION['serch_type'];

   $all_data_check = $_SESSION['filter_data'];


   $get_data = $_SESSION['filter_type'];

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
  start_time like'%".$searchValue."%' or status like'%".$searchValue."%' ) ";
}

if($all_data_check == 'today'){
  $condition = "start_time Like '%$date1%' AND";
}elseif($all_data_check == 'all'){
  $condition = "'1=1' AND";
}else{
  $condition = "start_time Like '%$date1% AND'";
}




        if($get_data == 'total_data')
    {

      $sel = mysqli_query($con, "select count(*) as allcount from cdr WHERE $condition (call_from = '$user' OR call_to = '$user')");
      $records = mysqli_fetch_assoc($sel);
      $totalRecords = isset($records['allcount']) ? $records['allcount'] : 0;
      
      $sel = mysqli_query($con, "select count(*) as allcount from cdr WHERE $condition (call_from = '$user' OR call_to = '$user') AND 1 ".$searchQuery);
      $records = mysqli_fetch_assoc($sel);
      $totalRecordwithFilter = isset($records['allcount']) ? $records['allcount'] : 0;
      
         $query = "SELECT
          id,
    call_from,
    call_to,
    start_time,
    end_time,
    TIME_FORMAT(SEC_TO_TIME(dur), '%H:%i:%s') AS talk_hrs,
    status, hangup,
    record_url,
    direction
         FROM cdr WHERE $condition (call_from = '$user' OR call_to = '$user') AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
    
// die();
        // $tfnsel="SELECT * from cdr WHERE $condition call_from='$user' or call_to='$user' ORDER BY id DESC";
        
    }elseif($get_data == 'other_data'){


      $sel = mysqli_query($con, "select count(*) as allcount from cdr WHERE $condition (call_from = '$user' OR call_to = '$user') AND status!='CANCEL' AND status!='ANSWER'");
      $records = mysqli_fetch_assoc($sel);
      $totalRecords = isset($records['allcount']) ? $records['allcount'] : 0;
      
      $sel = mysqli_query($con, "select count(*) as allcount from cdr WHERE $condition (call_from = '$user' OR call_to = '$user') AND status!='CANCEL' AND status!='ANSWER' AND 1 ".$searchQuery);
      $records = mysqli_fetch_assoc($sel);
      $totalRecordwithFilter = isset($records['allcount']) ? $records['allcount'] : 0;
      
        $query = "SELECT
          id,
    call_from,
    call_to,
    start_time,
    end_time,
    TIME_FORMAT(SEC_TO_TIME(dur), '%H:%i:%s') AS talk_hrs,
    status, hangup,
    record_url,
    direction
         FROM cdr WHERE $condition (call_from = '$user' OR call_to = '$user') AND status!='CANCEL' AND status!='ANSWER' AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;

        // $tfnsel="SELECT * from cdr WHERE $condition (call_from='$user' || call_to='$user') AND status!='CANCEL' AND status!='ANSWER' ORDER BY id DESC";
    }elseif($get_data == 'answer_data'){

      $sel = mysqli_query($con, "select count(*) as allcount from cdr WHERE $condition (call_from='$user' || call_to='$user') AND status='ANSWER'");
      $records = mysqli_fetch_assoc($sel);
      $totalRecords = isset($records['allcount']) ? $records['allcount'] : 0;
      
      $sel = mysqli_query($con, "select count(*) as allcount from cdr WHERE $condition (call_from='$user' || call_to='$user') AND status='ANSWER' AND 1 ".$searchQuery);
      $records = mysqli_fetch_assoc($sel);
      $totalRecordwithFilter = isset($records['allcount']) ? $records['allcount'] : 0;
      
        $query = "SELECT 
        id,
    call_from,
    call_to,
    start_time,
    end_time,
    TIME_FORMAT(SEC_TO_TIME(dur), '%H:%i:%s') AS talk_hrs,
    status, hangup,
    record_url,
    direction
         FROM cdr WHERE $condition (call_from='$user' || call_to='$user') AND status='ANSWER' AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
    

        // $tfnsel="SELECT * from cdr WHERE $condition (call_from='$user' || call_to='$user') AND status='ANSWER' ORDER BY id DESC";

    }elseif($get_data == 'cancel_data'){

      $sel = mysqli_query($con, "select count(*) as allcount from cdr WHERE $condition (call_from='$user' || call_to='$user') AND status='CANCEL'");
      $records = mysqli_fetch_assoc($sel);
      $totalRecords = isset($records['allcount']) ? $records['allcount'] : 0;
      
      $sel = mysqli_query($con, "select count(*) as allcount from cdr WHERE $condition (call_from='$user' || call_to='$user') AND status='CANCEL' AND 1 ".$searchQuery);
      $records = mysqli_fetch_assoc($sel);
      $totalRecordwithFilter = isset($records['allcount']) ? $records['allcount'] : 0;
      
        $query = "SELECT  
        id,
    call_from,
    call_to,
    start_time,
    end_time,
    TIME_FORMAT(SEC_TO_TIME(dur), '%H:%i:%s') AS talk_hrs,
    status, hangup,
    record_url,
    direction
    FROM cdr WHERE $condition (call_from='$user' || call_to='$user') AND status='CANCEL' AND 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
    

        // $tfnsel="SELECT * from cdr WHERE $condition (call_from='$user' || call_to='$user') AND status='CANCEL' ORDER BY id DESC";
    }
     



// echo $query;
// die();
$empRecords = mysqli_query($con, $query);
$data = array();
$sr = $row + 1;
while ($row = mysqli_fetch_assoc($empRecords)) {
  $call_from_one = $row['call_from']; // Correct assignment

  // Apply masking logic based on $caller_contact
  if ($caller_contact == '1') {
      $call_from = str_repeat('*', 6) . substr($call_from_one, -4); // Show last 4 digits
  } else {
      $call_from = $call_from_one;
  }

  // Append the formatted data to the $data array
  $data[] = array(
      "sr" => $sr, 
      "id" => $row['id'],
      "call_from" => $call_from,
      "click2call_callfrom" => $call_from_one,
      "call_to" => $row['call_to'],
      "start_time" => $row['start_time'],
      "end_time" => $row['end_time'],
      "dur" => $row['talk_hrs'],
      "status" => $row['status'],
      "hangup" => $row['hangup'],
      "record_url" => $row['record_url'],
      "direction" => $row['direction'],
  );
  $sr++;
}

// print_r($data);

## Response
$response = array(
  "draw" => $draw,
  "iTotalRecords" => $totalRecords,
  "iTotalDisplayRecords" => $totalRecordwithFilter,
  "aaData" => $data
);

echo json_encode($response);
?>