<?php
include "../../../conf/db.php";
include "../../../conf/url_page.php";
include "../../../conf/Get_time_zone.php";
 $id = $_REQUEST['id'];

$sel1="SELECT * FROM compaign_list WHERE id='$id'";
$result1 = mysqli_query($con, $sel1);
$row1 = mysqli_fetch_array($result1); 

  $status = $row1['status'];
  
  if( $status == 'Y'){
     $ins = "UPDATE compaign_list SET status='N' where id='$id'";

  } elseif($status == 'N'){ 
    $ins = "UPDATE compaign_list SET status='Y' where id='$id'";

  }else{
    $ins = "UPDATE compaign_list SET status='Y' where id='$id'";

  }
  
//   die();

    $res = mysqli_query($con, $ins);
    if($res){
     header("Location:$id_w_url?c=campaign&v=campaign_list");
    } else {
        header("Location:$id_w_url?c=campaign&v=campaign_list");
    }


?>