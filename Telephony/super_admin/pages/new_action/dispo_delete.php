<?php
include "../../../conf/db.php";
include "../../../conf/url_page.php";

if(isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    // echo $id;
    $usersql2 = "DELETE FROM `dispo` WHERE id='$id'"; 
   
    $usersresult = mysqli_query($con, $usersql2);
   if($usersresult){
    header("Location:$id_w_url?c=dashboard&v=disposition");
   }else{
    header("Location:$id_w_url?c=dashboard&v=disposition");
   }
}
?>
