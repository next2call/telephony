<?php
session_start();
include "../../../conf/db.php";
include "../../../conf/url_page.php";

$_SESSION['page_start'] = 'Report_page';  

 $user = $_SESSION['user'];

 $list_id = $_SESSION['Get_list_id'];
// die();

if(isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    // echo $id;
    $usersql2 = "DELETE FROM `upload_data` WHERE admin='$user' AND list_id='$list_id' AND dial_status='NEW'"; 
   
    $usersresult = mysqli_query($con, $usersql2);
   if($usersresult){
    header("Location:$id_w_url?c=dashboard&v=contact_upload&list_id=".$list_id);
   }else{
    header("Location:$id_w_url?c=dashboard&v=contact_upload&list_id=".$list_id);
   }
}
?>
