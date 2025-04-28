<?php

$host = "localhost"; /* Host name */
$user = "cron"; /* User */
$password = "1234"; /* Password */
$dbname = "telephony_db"; /* Database name */

$con = mysqli_connect($host, $user, $password,$dbname);
// Check connection
if (!$con) {
 die("Connection failed: " . mysqli_connect_error());

date_default_timezone_set('America/New_York'); // Set the timezone to Eastern Time

}