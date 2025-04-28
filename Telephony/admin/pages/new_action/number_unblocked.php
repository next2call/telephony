<?php
include "../../../conf/db.php";
include "../../../conf/url_page.php";

if(isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    // echo $id;
    $usersql2 = "DELETE FROM `block_tbl` WHERE id='$id'"; 
   
    $usersresult = mysqli_query($con, $usersql2);
   if($usersresult){
    header("Location:$id_w_url?c=dashboard&v=block_number");
   }else{
    header("Location:$id_w_url?c=dashboard&v=block_number");
   }
}
?>
