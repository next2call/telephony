<?php
session_start();
$Adminuser = $_SESSION['user'];

include "../../../conf/db.php";
include "../../../conf/url_page.php";
include "../../../conf/Get_time_zone.php";

if(isset($_REQUEST['user_id'])) {
    $user_id = $_REQUEST['user_id'];
    $user_priorty = $_REQUEST['user_priorty'];
  
    // SELECT * FROM `users` WHERE admin='4040' AND agent_priorty > '2';

    $selprioc = "SELECT * FROM `users` WHERE admin='$Adminuser' AND agent_priorty > '$user_priorty'";
    // die();
    $querypioc = mysqli_query($con, $selprioc); 
     while($rowprioc = mysqli_fetch_assoc($querypioc)){
         $oldpriority = $rowprioc['agent_priorty'];
         $idpriority = $rowprioc['id'];
         $newpriority = $oldpriority-1;
         $upprioc = "UPDATE `users` SET `agent_priorty`='$newpriority' WHERE `id`='$idpriority'";
        mysqli_query($con, $upprioc);
     }

    $usersql2 = "DELETE FROM `users` WHERE user_id='$user_id'"; 

 //  die();
    $usersresult = mysqli_query($con, $usersql2);
   if($usersresult){

    $delete_user = "DELETE FROM `vicidial_users` WHERE user='$user_id'"; 
    mysqli_query($conn, $delete_user);

    $delete_phone = "DELETE FROM `phones` WHERE extension='$user_id'"; 
    mysqli_query($conn, $delete_phone);

    header("Location:$id_w_url?c=user&v=user_list");
   }else{
    header("Location:$id_w_url?c=user&v=user_list");
   }
}
?>
