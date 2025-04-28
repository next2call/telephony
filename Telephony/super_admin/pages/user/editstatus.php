<?php

include "../../../conf/db.php";
include "../../../conf/url_page.php";


$id = $_REQUEST['id'];



$sel1="SELECT * FROM users WHERE user_id='$id'";
$result1 = mysqli_query($con, $sel1);
$row1 = mysqli_fetch_array($result1); 

  $status = $row1['status'];
  
  if( $status == 'Y'){
    $ins = "UPDATE users SET status='N' where user_id='$id'";
    $ins_vicidial = "UPDATE  vicidial_users SET active='N' where user='$id'";
  } elseif($status == 'N'){ 
    $ins = "UPDATE users SET status='Y' where user_id='$id'";
    $ins_vicidial = "UPDATE  vicidial_users SET active='Y' where user='$id'";
  }
    mysqli_query($conn, $ins_vicidial);
     
    $res = mysqli_query($con, $ins);
    if($res){
     header("location:$id_w_url_s?c=user&v=user_list");
    } else {
        header("location:$id_w_url_s?c=user&v=user_list");
    }


?>