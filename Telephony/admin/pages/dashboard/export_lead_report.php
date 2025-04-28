<?php
session_start();
include "../../../conf/db.php";
include "../../../conf/Get_time_zone.php";
$user_level = $_SESSION['user_level'];

if($user_level == 2){
    $user = $_SESSION['admin'];
    $new_user = $_SESSION['user'];
    $user_sql2 = "SELECT campaigns_id FROM `users` WHERE admin='$user' AND user_id='$new_user'"; 
    $user_query = mysqli_query($con, $user_sql2);
    if(!$user_query) {
        die("Query Failed: " . mysqli_error($con));
    }
  
    $row_compain = mysqli_fetch_assoc($user_query);
    $new_campaign = $row_compain['campaigns_id'];

    
} else {
    $user = $_SESSION['user'];
}


$to_date = date("Y-m-d");
$date_24 = date("Y-m-d h:i:s");
   $agentid = $_SESSION['agent_name'];
//  echo "</br>";

   $fromdate = $_SESSION['fromdate'];
   $todate = $_SESSION['todate'];
    $serch_type = $_SESSION['serch_type'];
// echo "</br>";

   // Get the agent ID for the current user
if($user_level == 2){

    $tfnsel_1 = "SELECT user_id FROM users WHERE admin='$user' AND campaigns_id='$new_campaign'";

}else{

    $tfnsel_1 = "SELECT user_id FROM users WHERE admin='$user'";

}

$data_1 = mysqli_query($con, $tfnsel_1);
$agent_ids = [];

while ($user_row = mysqli_fetch_assoc($data_1)) {
    $agent_ids[] = $user_row['user_id'];
}

// Convert agent_ids array to a comma-separated string
$agent_ids_str = implode("','", $agent_ids);



if ($serch_type == 'date'){

   $sel = "SELECT `company_name`, `employee_size`, `industry`, `country`, `city`, `department`, `designation`, `email`, `name`, `phone_number`, `ins_date`, `dialstatus`, `upload_user`, `remark` from company_info WHERE DATE(ins_date) between '$fromdate' AND '$todate' AND (upload_user = '$user' OR upload_user IN ('$agent_ids_str'))";

  } elseif ($serch_type == 'agent'){

     $sel = "SELECT `company_name`, `employee_size`, `industry`, `country`, `city`, `department`, `designation`, `email`, `name`, `phone_number`, `ins_date`, `dialstatus`, `upload_user`, `remark` from company_info WHERE upload_user = '$agentid'";

  } elseif ($serch_type == 'date-agent'){

 $sel = "SELECT `company_name`, `employee_size`, `industry`, `country`, `city`, `department`, `designation`, `email`, `name`, `phone_number`, `phone_2`, `ins_date`, `dialstatus`, `upload_user`, `remark` from company_info WHERE DATE(ins_date) between '$fromdate' AND '$todate' AND upload_user = '$agentid')";
   
  } else {
     $sel = "SELECT `company_name`, `employee_size`, `industry`, `country`, `city`, `department`, `designation`, `email`, `name`, `phone_number`, `ins_date`, `dialstatus`, `upload_user`, `remark` from company_info WHERE (upload_user = '$user' OR upload_user IN ('$agent_ids_str'))";

  }


  // die();

$result = mysqli_query($con, $sel);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

$filename = "Lead_Report.csv";
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: text/csv");

// Create a file pointer connected to the output stream
$output = fopen("php://output", 'w');

// Output CSV header
// $header = array('call_from', 'from_name', 'client_name', 'call_to', 'start_time', 'end_time', 'dur', 'status', 'record_url', 'direction');

$header = array(
  'company_name', 
  'employee_size', 
  'industry', 
  'country', 
  'city', 
  'department', 
  'designation', 
  'email', 
  'name', 
  'phone_number', 
  'date', 
  'dialstatus', 
  'remark',
  'upload_user'
);
fputcsv($output, $header, ',', '"');

while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, $row, ',', '"');
}

fclose($output);

mysqli_close($con);


?>