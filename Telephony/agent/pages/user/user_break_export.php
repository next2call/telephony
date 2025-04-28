<?php
session_start();

// Include the database connection details
// require '../conf/db.php';

// Get the user from the session
 $user = $_SESSION['user'];

 $from_date = $_SESSION['from_date_str'];
//  echo "<br>";
$to_date = $_SESSION['to_date_str'];

$user_id = $_SESSION['user_id'];
//  echo "<br>";
// die();
$con = new mysqli("localhost", "cron", "1234", "telephony_db");
// SQL query to fetch data
if(!empty($from_date) && !empty($to_date)){

//  $sql = "SELECT `Id`, `phone_code`, `caller_number`, `massage`, `disposition`, `datetime` FROM `call_notes` WHERE DATE(datetime) between ' $from_date' and ' $to_date' AND phone_code='$user_id'";

 $sql = "SELECT `id`, `user_name`, `break_name`, `start_time`, `break_duration`, `end_time` FROM `break_time` WHERE DATE(start_time) between ' $from_date' and ' $to_date' AND break_name != 'Ready'";
//    die();
}else{
    // $sql = "SELECT `Id`, `phone_code`, `caller_number`, `massage`, `disposition`, `datetime` FROM `call_notes`";
    $sql = "SELECT `id`, `user_name`, `break_name`, `start_time`, `break_duration`, `end_time` FROM `break_time` WHERE AND break_name != 'Ready'";

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

$header = array('Id', 'User_id', 'Break_name', 'start_time', 'break_duration', 'end_time');
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