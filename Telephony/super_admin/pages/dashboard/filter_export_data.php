<?php
session_start();

// Include the database connection details
include "../../../conf/db.php";

// Get the user from the session
 $user = $_SESSION['user'];
 $get_data = $_SESSION['filter_type'];
 $filter_data_ex = $_SESSION['filter_data_ex'];
 $date1 = date("Y-m-d");
// $con = new mysqli("localhost", "cron", "1234", "vicidial_master");

if($filter_data_ex == 'today'){

if($get_data == 'total_data')
{
    $sql = "SELECT `call_from`, `call_to`, `start_time`, `end_time`, `dur`, `status`, `direction`, `record_url`, `direction` FROM `cdr` WHERE start_time Like '%$date1%' AND admin = '$user'";
}elseif($get_data == 'other_data'){
    $sql = "SELECT `call_from`, `call_to`, `start_time`, `end_time`, `dur`, `status`, `direction`, `record_url`, `direction` FROM `cdr` WHERE status!='CANCEL' AND status!='ANSWER' AND status!='BUSY' AND start_time Like '%$date1%' AND admin = '$user' ORDER BY id DESC";
}elseif($get_data == 'ansewer_data'){
    $sql = "SELECT `call_from`, `call_to`, `start_time`, `end_time`, `dur`, `status`, `direction`, `record_url`, `direction` FROM `cdr` WHERE status='ANSWER' AND start_time Like '%$date1%' AND admin = '$user' ORDER BY id DESC";
}elseif($get_data == 'cancel_data'){
    $sql = "SELECT `call_from`, `call_to`, `start_time`, `end_time`, `dur`, `status`, `direction`, `record_url`, `direction` FROM `cdr` WHERE status='CANCEL' OR status='BUSY' AND start_time Like '%$date1%' AND admin = '$user' ORDER BY id DESC";
}

}elseif($filter_data_ex == 'all'){ 

    if($get_data == 'total_data')
    {
        $sql = "SELECT `call_from`, `call_to`, `start_time`, `end_time`, `dur`, `status`, `direction`, `record_url`, `direction` FROM `cdr` WHERE admin = '$user'";
    }elseif($get_data == 'other_data'){
        $sql = "SELECT `call_from`, `call_to`, `start_time`, `end_time`, `dur`, `status`, `direction`, `record_url`, `direction` FROM `cdr` WHERE status!='CANCEL' AND status!='ANSWER' AND status!='BUSY' AND admin = '$user'ORDER BY id DESC";
    }elseif($get_data == 'ansewer_data'){
        $sql = "SELECT `call_from`, `call_to`, `start_time`, `end_time`, `dur`, `status`, `direction`, `record_url`, `direction` FROM `cdr` WHERE status='ANSWER' AND admin = '$user' ORDER BY id DESC";
    }elseif($get_data == 'cancel_data'){
        $sql = "SELECT `call_from`, `call_to`, `start_time`, `end_time`, `dur`, `status`, `direction`, `record_url`, `direction` FROM `cdr` WHERE status='CANCEL' OR status='BUSY' AND admin = '$user' ORDER BY id DESC";
    }
    

}else{ 

    if($get_data == 'total_data')
    {
        $sql = "SELECT `call_from`, `call_to`, `start_time`, `end_time`, `dur`, `status`, `direction`, `record_url`, `direction` FROM `cdr` WHERE start_time Like '%$date1%' AND admin = '$user'";
    }elseif($get_data == 'other_data'){
        $sql = "SELECT `call_from`, `call_to`, `start_time`, `end_time`, `dur`, `status`, `direction`, `record_url`, `direction` FROM `cdr` WHERE status!='CANCEL' AND status!='ANSWER' AND status!='BUSY' AND start_time Like '%$date1%' AND admin = '$user' ORDER BY id DESC";
    }elseif($get_data == 'ansewer_data'){
        $sql = "SELECT `call_from`, `call_to`, `start_time`, `end_time`, `dur`, `status`, `direction`, `record_url`, `direction` FROM `cdr` WHERE status='ANSWER' AND start_time Like '%$date1%' AND admin = '$user' ORDER BY id DESC";
    }elseif($get_data == 'cancel_data'){
        $sql = "SELECT `call_from`, `call_to`, `start_time`, `end_time`, `dur`, `status`, `direction`, `record_url`, `direction` FROM `cdr` WHERE status='CANCEL' OR status='BUSY' AND start_time Like '%$date1%' AND admin = '$user' ORDER BY id DESC";
    }   
    

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
$header = array('Id', 'call_from', 'call_to', 'start_time', 'end_time', 'dur', 'status', 'Call Direction', 'record_url', 'direction');
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