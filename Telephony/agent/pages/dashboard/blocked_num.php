<?php
session_start();
$agentuser = $_SESSION['user'];
require '../../../conf/db.php';
include "../../../conf/Get_time_zone.php";
$sql_n = "Select * from users where user_id ='$agentuser' ";
$result_n = mysqli_query($con, $sql_n);
$users_row = mysqli_fetch_assoc($result_n);
$Admin_user = $users_row['admin'];

// die();
    $block_no = $_POST['block_no'];
    $status = '1';
    $date = date("Y-m-d H:i:s");

    $data_ins = "INSERT INTO `block_no` (`block_no`, `admin`, `ins_date`, `status`) VALUES ('$block_no', '$Admin_user', '$date', '$status')";
    $query_ins = mysqli_query($con, $data_ins);
    
    if($query_ins){
        echo "ok";

    } else {
        echo "Not ok";

    }



?>