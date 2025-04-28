<?php
include "../../../conf/db.php";
include "../../../conf/url_page.php";

if(isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    $group_id = $_REQUEST['group_id'];
    $pid = $_REQUEST['pid'];
    // echo $id;
    // $usersql = "DELETE FROM `vicidial_campaigns` WHERE campaign_id='$id'"; 
//    echo '</br>';
    $usersql2 = "DELETE FROM `group_agent` WHERE id='$id'";  
//    die();
    $usersresult = mysqli_query($con, $usersql2);
   if($usersresult){
    header("Location:$id_w_url?c=user_group&v=show_group_agent&group_id=$group_id&id=$pid");
   }else{
    header("Location:$id_w_url?c=user_group&v=show_group_agent&group_id=$group_id&id=$pid");
   }
}
?>
