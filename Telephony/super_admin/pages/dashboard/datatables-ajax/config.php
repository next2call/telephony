<?php

$host = "localhost"; /* Host name */
$user = "cron"; /* User */
$password = "1234"; /* Password */
$dbname = "vicidial_master"; /* Database name */
// $con = new mysqli("localhost", "cron", "1234", "test");

$con = mysqli_connect($host, $user, $password,$dbname);
// Check connection
if (!$con) {
 die("Connection failed: " . mysqli_connect_error());
}