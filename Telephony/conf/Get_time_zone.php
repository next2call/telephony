<?php 
session_start();
  $user_level = $_SESSION['user_level'];
include "db.php";

if($user_level == 1){
    $new_user = $_SESSION['user'];
    // Single query to fetch both admin and user_timezone
   $que2wqasw = "
        SELECT u1.admin, u2.user_timezone 
        FROM users u1 
        LEFT JOIN users u2 ON u2.admin = u1.admin AND u2.user_type = '8'
        WHERE u1.user_type = '1' AND u1.user_id = '$new_user'"; 
    
    $sqlressusult = mysqli_query($con, $que2wqasw);
    $sqlroow = mysqli_fetch_assoc($sqlressusult);
        $uSr_Admin = $sqlroow['admin'];
      $admin_timeJJ = $sqlroow['user_timezone'];
    // echo "</br>";


}elseif($user_level == 2){

    $new_user = $_SESSION['user'];

   $que2wqasw = "
SELECT u1.admin, u2.user_timezone 
   FROM users u1 
   LEFT JOIN users u2 ON u2.admin = u1.admin AND u2.user_type = '8'
   WHERE u1.user_type = '2' AND u1.user_id = '$new_user'"; 

$sqlressusult = mysqli_query($con, $que2wqasw);
$sqlroow = mysqli_fetch_assoc($sqlressusult);
   $uSr_Admin = $sqlroow['admin'];
   $admin_timeJJ = $sqlroow['user_timezone'];

}elseif($user_level == 8){
   $Adminuser = $_SESSION['admin'];
   $new_user = $_SESSION['user'];

   $que2wqasw = "
   SELECT u1.admin, u2.user_timezone 
   FROM users u1 
   LEFT JOIN users u2 ON u2.admin = u1.admin AND u2.user_type = '8'
   WHERE u1.user_type = '8' AND u1.user_id = '$new_user'"; 

$sqlressusult = mysqli_query($con, $que2wqasw);
$sqlroow = mysqli_fetch_assoc($sqlressusult);
   $uSr_Admin = $sqlroow['admin'];
   $admin_timeJJ = $sqlroow['user_timezone'];

}else {
   $new_user = $_SESSION['user'];
   $que2wqasw = "
   SELECT u1.admin, u2.user_timezone 
   FROM users u1 
   LEFT JOIN users u2 ON u2.admin = u1.admin AND u2.user_type = '8'
   WHERE u1.user_id = '$new_user'"; 

$sqlressusult = mysqli_query($con, $que2wqasw);
$sqlroow = mysqli_fetch_assoc($sqlressusult);
   $uSr_Admin = $sqlroow['admin'];
   $admin_timeJJ = $sqlroow['user_timezone'];
}

// Set the timezone to the one retrieved from the database
if (!empty($admin_timeJJ)) {
    date_default_timezone_set($admin_timeJJ); // Set timezone from the database
} else {
    // Set a default timezone if the database does not return a timezone
    date_default_timezone_set('Asia/Kolkata'); // Default to IST if timezone is not found
}

// $name_of_time_zone can be used later if needed
$name_of_time_zone = $admin_timeJJ;

//  "$name_of_time_zone";
//  "</br>";
// echo "Current timezone set to: " . date_default_timezone_get(); // Display the current timezone
?>