<?php
session_start();
include "../../../conf/db.php";

 $user = $_SESSION['user'];

$to_date = date("Y-m-d");
$date_24 = date("Y-m-d h:i:s");
   $agentid = $_SESSION['agent_name'];
   $fromdate = $_SESSION['fromdate'];
   $todate = $_SESSION['todate'];
   $serch_type = $_SESSION['serch_type'];


if ($serch_type == 'date'){
  // $sel = "SELECT cdr.id, cdr.call_from, IFNULL(users.full_name, 'NONE') AS from_name, IFNULL(upload_data.name, 'NONE') AS client_name, cdr.call_to, cdr.start_time, cdr.end_time, cdr.dur, cdr.status, cdr.record_url, cdr.direction
  //   FROM cdr 
  //   LEFT JOIN users ON cdr.call_from = users.user_id || cdr.call_to = users.user_id 
  //   LEFT JOIN upload_data ON cdr.call_from = upload_data.phone_number || cdr.call_to = upload_data.phone_number
  //   WHERE DATE(start_time) between '$fromdate' AND '$todate' AND cdr.admin = '$user'";
   

   $sel = "SELECT * from cdr WHERE DATE(start_time) between '$fromdate' AND '$todate' AND admin = '$user'";


  } elseif ($serch_type == 'agent'){

    $sel = "SELECT * from cdr WHERE (call_from='$agentid' || call_to='$agentid') AND admin = '$user' ";

  } elseif ($serch_type == 'date-agent'){

$sel = "SELECT * from cdr WHERE DATE(start_time) between '$fromdate' AND '$todate' AND (call_from='$agentid' || call_to='$agentid') AND admin = '$user' ";
   
  } else {
    $sel = "SELECT * from cdr WHERE admin = '$user'";

  }

$result = mysqli_query($con, $sel);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

$filename = "Report.csv";
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: text/csv");

// Create a file pointer connected to the output stream
$output = fopen("php://output", 'w');

// Output CSV header
$header = array('call_from', 'from_name', 'client_name', 'call_to', 'start_time', 'end_time', 'dur', 'status', 'record_url', 'direction');
fputcsv($output, $header, ',', '"');

while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, $row, ',', '"');
}

fclose($output);

mysqli_close($con);


?>