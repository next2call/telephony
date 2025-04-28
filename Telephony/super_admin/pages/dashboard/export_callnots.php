<?php
session_start();

// Include the database connection details
include "../../../conf/db.php";

// Get the user from the session
 $user = $_SESSION['user'];

 $from_date = $_SESSION['from_date_str'];
//  echo "<br>";
$to_date = $_SESSION['to_date_str'];

$user_id = $_SESSION['user_id'];
//  echo "<br>";
// die();
// SQL query to fetch data
if(!empty($from_date) && !empty($to_date) && !empty($user_id)){

 $sql = "SELECT `Id`, `phone_code`, `caller_number`, `massage`, `disposition`, `datetime` FROM `call_notes` WHERE DATE(datetime) between ' $from_date' and ' $to_date' AND phone_code='$user_id'";
//    die();
}elseif(!empty($user_id)){

    // $sql = "SELECT `id`, `call_from`, `call_to`, `start_time`, `end_time`, `dur`, `status`, `msg`, `record_url` FROM `cdr` ";
    $sql = "SELECT `Id`, `phone_code`, `caller_number`, `massage`, `disposition`, `datetime` FROM `call_notes` WHERE phone_code='$user_id'";

}else{
    $sql = "SELECT `Id`, `phone_code`, `caller_number`, `massage`, `disposition`, `datetime` FROM `call_notes`";

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

$header = array('Id', 'call_from', 'call_to', 'Call Notes', 'Disposition', 'Note date');
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