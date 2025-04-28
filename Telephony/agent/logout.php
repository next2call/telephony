<?php

session_start();
require '../conf/db.php';
include "../conf/Get_time_zone.php";

$username = $_SESSION['user'];
$date_time=Date("Y-m-d H:i:s");
$date=Date("Y-m-d");

$u_sel="SELECT * FROM login_log WHERE log_in_time LIKE '%$date%' AND user_name='$username'";
$u_run=mysqli_query($con,$u_sel);
if(mysqli_num_rows($u_run) > 0){
    $u_ro=mysqli_fetch_array($u_run);
    $id = $u_ro['id']; 
    
    $ins_log="UPDATE `login_log` SET log_out_time='$date_time', status='2' WHERE id='$id'";

     $ins_break = "UPDATE `break_time` SET end_time='$date_time', status='1', break_status='2' WHERE start_time LIKE '%$date%' AND user_name='$username'";
   

    mysqli_query($con,$ins_break);
    
    $break_delete ="DELETE FROM `break_time` WHERE status='2' AND break_name='Ready' AND user_name='$username'";
    mysqli_query($con,$break_delete);

    if(mysqli_query($con,$ins_log)){
        unset($_SESSION);
        session_destroy();
        header('location:../');

    }
}else{
    $ins_log="UPDATE `login_log` SET log_out_time='No Logout Time', status='2' WHERE user_name='$username'";
    
    unset($_SESSION);
    session_destroy();
    header('location:../');

}