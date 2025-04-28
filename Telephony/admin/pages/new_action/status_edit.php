<?php
include "../../../conf/db.php";
include "../../../conf/url_page.php";
include "../../../conf/Get_time_zone.php";
 $id = $_REQUEST['id'];

$sel1="SELECT * FROM lists WHERE ID='$id'";
$result1 = mysqli_query($con, $sel1);
$row1 = mysqli_fetch_array($result1); 

  $status = $row1['ACTIVE'];
  
  if( $status == 'Y'){
     $ins = "UPDATE lists SET ACTIVE='N' where ID='$id'";

  } elseif($status == 'N'){ 
    $ins = "UPDATE lists SET ACTIVE='Y' where ID='$id'";

  }else{
    $ins = "UPDATE lists SET ACTIVE='Y' where ID='$id'";

  }
  
//   die();

    $res = mysqli_query($con, $ins);
    if($res){
     header("Location:$id_w_url?c=lists&v=lists_list");

    } else {
        header("Location:$id_w_url?c=lists&v=lists_list");

    }


?>