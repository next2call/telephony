<?php
include "../../../conf/db.php";
include "../../../conf/url_page.php";
include "../../../conf/Get_time_zone.php";
if(isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    // echo $id;
    $usersql2 = "DELETE FROM `dispo` WHERE id='$id'"; 
   
    $usersresult = mysqli_query($con, $usersql2);
   if($usersresult){
    header("Location:https://coreoutsourcing.next2call.com/Telephony/admin/index.php?c=dashboard&v=disposition");
   }else{
    header("Location:$id_w_url?c=dashboard&v=disposition");
   }
}
?>
