<?php
session_start();

// Include the database connection details
require '../../../conf/db.php';
include "../../../conf/Get_time_zone.php";
 $user = $_SESSION['user'];

 $from_date = $_SESSION['from_date_str'];
 //  echo "<br>";
 $to_date = $_SESSION['to_date_str'];
// die();
// SQL query to fetch data
if(isset($from_date) && isset($to_date)){

    $sql = "SELECT `id`, `call_from`, `call_to`, `start_time`, `end_time`, `dur`, `status`, `record_url`, `direction` FROM `cdr` WHERE DATE(start_time) between ' $from_date' and ' $to_date' and call_from='$user'";
   //    die();
   }else{
   
    $sql = "SELECT `id`, `call_from`, `call_to`, `start_time`, `end_time`, `dur`, `status`, `record_url`, `direction` FROM `cdr` WHERE call_from='$user'";

   
   }



   $result = mysqli_query($con, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}
// else{
//     echo "Ok";
// }
// die();

// CSV file setup
$filename = "Report.csv";
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: text/csv");

// Create a file pointer connected to the output stream
$output = fopen("php://output", 'w');

// Output CSV header
$header = array('Id', 'call_from', 'call_to', 'start_time', 'end_time', 'dur', 'status', 'record_url', 'direction');
fputcsv($output, $header, ',', '"');

// Output data from rows
while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, $row, ',', '"');
}

// Close the file pointer
fclose($output);

// Close the database connection
mysqli_close($con);


?>