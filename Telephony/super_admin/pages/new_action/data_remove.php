<?php
session_start();
include "../../../conf/db.php";
include "../../../conf/url_page.php";
$_SESSION['page_start'] = 'Report_page';  
$user = $_SESSION['user'];
 $list_id = $_SESSION['Get_list_id'];
//  $_SESSION['Get_list_id'] = $list_id;

if(isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    // echo $id;
    $usersql2 = "DELETE FROM `upload_data` WHERE id='$id'"; 

    // c=dashboard&v=contact_upload&list_id=98787986
   
    $usersresult = mysqli_query($con, $usersql2);
   if($usersresult){
    header("location:$id_w_url?c=dashboard&v=contact_upload&list_id=".$list_id);
   }else{
    header("location:$id_w_url?c=dashboard&v=contact_upload&list_id=".$list_id);
   }
}
?>
