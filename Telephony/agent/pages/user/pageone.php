<?php
require '../conf/db.php';
require '../include/campaign.php';
$con = new mysqli("localhost", "cron", "1234", "vicidial_master");
session_start();
// if (!$_SESSION['user_level'] == 8) {
//     header('location:../');
// }

$pdate = date('Y-m-d');

$sql = "UPDATE `login_log` SET status = '2' WHERE status = '1' AND log_in_time NOT LIKE '%$pdate%'";
$result = mysqli_query($con, $sql);

if($result){
    echo "success";
}else{
    echo "error";
}

?>
