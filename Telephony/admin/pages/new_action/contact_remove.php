<?php
session_start();
include "../../../conf/db.php";
include "../../../conf/url_page.php";
include "../../../conf/Get_time_zone.php";

$_SESSION['page_start'] = 'Report_page';  
 $user = $_SESSION['user'];
 $list_id = $_SESSION['Get_list_id'];
// die();
$dial_status = $_REQUEST['dial_status'];
if(isset($_SESSION['user']) && !empty($dial_status)) {
    $user = $_SESSION['user'];
    if($dial_status != 'all'){
        $dial_status_con = "AND dial_status='$dial_status'";
    } else {
        $dial_status_con = "";
    }
    $usersql2 = "DELETE FROM `upload_data` WHERE admin='$user' AND list_id='$list_id' $dial_status_con"; 
   
    $usersresult = mysqli_query($con, $usersql2);
   if($usersresult){
    header("Location:$id_w_url?c=dashboard&v=contact_upload&list_id=".$list_id);
   }else{
    header("Location:$id_w_url?c=dashboard&v=contact_upload&list_id=".$list_id);
   }
}
?>
