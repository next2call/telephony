<?php
session_start();
$Adminuser = $_SESSION['user'];
include "../../../conf/db.php";
include "../../../conf/url_page.php";
include "../../../conf/Get_time_zone.php";

if(isset($_REQUEST['number'])) {
    $number = $_REQUEST['number'];
    $date = date("Y-m-d H:i:s");
$status = '1';
    $data_ins = "INSERT INTO `block_no` (`block_no`, `admin`, `ins_date`, `status`) VALUES ('$number', '$Adminuser', '$date', '$status')";  
    $usersresult = mysqli_query($con, $data_ins);
   if($usersresult){
    header("Location:$id_w_url?c=dashboard&v=report");
   }else{
    header("Location:$id_w_url?c=dashboard&v=report");
   }
}
?>
