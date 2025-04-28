<?php
include "../../../conf/db.php";
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

// SQL query to fetch data
if(!empty($from_date) && !empty($to_date)){
  $usersql_data = "SELECT `id`, `user_name`, `log_in_time`, `log_out_time`, `status` FROM `login_log` WHERE DATE(log_in_time) between ' $from_date' and ' $to_date' "; 

}else{

    $usersql_data = "SELECT `id`, `user_name`, `log_in_time`, `log_out_time`, `status` FROM `login_log` "; 

}

 $result = mysqli_query($con, $usersql_data);
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
$header = array('Id', 'user_name', 'log_in_time', 'log_out_time', 'status');
fputcsv($output, $header, ',', '"');

// Output data from rows
$id='1';
while ($row = mysqli_fetch_assoc($result)) {
    if($row['status'] == '1'){
        $status = "Login";
    } else {
        $status = "Logout";
    }
    $data = array($id, $row['user_name'], $row['log_in_time'], $row['log_out_time'], $status);
    fputcsv($output, $data, ',', '"');

$id++;
}

// Close the file pointer
fclose($output);

// Close the database connection
mysqli_close($con);

?>