<?php 

$localhost = "localhost";
$user = "cron";
$pwd = "1234";
$database = "asterisk";
$Newdatabase = "telephony_db";

// Establish a database connection
$con = mysqli_connect($localhost, $user, $pwd) or die(mysqli_error());
mysqli_select_db($con, $database) or die(mysqli_error());

$conn = mysqli_connect($localhost, $user, $pwd);
mysqli_select_db($conn, $Newdatabase);


 ?>