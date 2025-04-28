<?php
include "../../../conf/db.php";
include "../../../conf/url_page.php";

$id = $_REQUEST['id'];



$sel1="SELECT * FROM dispo WHERE id='$id'";
$result1 = mysqli_query($con, $sel1);
$row1 = mysqli_fetch_array($result1); 

  $status = $row1['status'];
  
  if( $status == '1'){
    $ins = "UPDATE dispo SET status='0' where id='$id'";

  } elseif($status == '0'){ 
    $ins = "UPDATE dispo SET status='1' where id='$id'";

  }
    
    $res = mysqli_query($con, $ins);
    if($res){
     header("Location:$id_w_url_s?c=dashboard&v=disposition");
    } else {
        header("Location:$id_w_url_s?c=dashboard&v=disposition");
    }


?>