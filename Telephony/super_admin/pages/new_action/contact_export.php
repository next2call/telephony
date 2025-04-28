<?php
session_start();
include "../../../conf/db.php";

// Get the user from the session
$user = $_SESSION['user'];
$from_date = $_SESSION['from_date_str'];
$to_date = $_SESSION['to_date_str'];
$user_id = $_SESSION['user_id'];

// Establish a database connection
// $con = new mysqli("localhost", "cron", "1234", "vicidial_master");

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// SQL query to fetch data
$sql = "SELECT `company_name`, `employee_size`, `industry`, `country`, `city`, `department`, `designation`, `email`, `name`, `phone_number`, `phone_2`, `phone_3` 
        FROM `upload_data` 
        WHERE `admin`='$user' AND `dial_status`='NEW'";

$result = mysqli_query($con, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

// CSV file setup
$filename = "Report.csv";
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: text/csv");

// Create a file pointer connected to the output stream
$output = fopen("php://output", 'w');

// Output CSV header (if required, uncomment and adjust the following line)
fputcsv($output, array('company_name', 'employee size', 'industry', 'country', 'city', 'department', 'designation', 'email', 'Name', 'phone_number', 'phone_2', 'phone_3'));

// Output data from rows
while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, $row);
}

// Close the file pointer
fclose($output);

// Close the database connection
mysqli_close($con);

// Echo "ok" to indicate completion
// echo "ok";

// Include SweetAlert2 script for alert and redirect

?>
