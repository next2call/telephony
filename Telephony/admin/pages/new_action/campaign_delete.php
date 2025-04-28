<?php
include "../../../conf/db.php";
include "../../../conf/url_page.php";
include "../../../conf/Get_time_zone.php";
if(isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    // echo $id;
    // $usersql = "DELETE FROM `vicidial_campaigns` WHERE campaign_id='$id'"; 
//    echo '</br>';
    $usersql2 = "DELETE FROM `compaign_list` WHERE id='$id'"; 
//    die();
    mysqli_query($conn, $usersql);
    $usersresult = mysqli_query($con, $usersql2);
   if($usersresult){
    header("Location:$id_w_url?c=campaign&v=campaign_list");
   }else{
    header("Location:$id_w_url?c=campaign&v=campaign_list");
   }
}
?>
