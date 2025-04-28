<?php
$con = new mysqli("localhost", "cron", "1234", "vicidial_master");

if(isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    // echo $id;
    $usersql2 = "DELETE FROM `texttospeech` WHERE id='$id'"; 
   
    $usersresult = mysqli_query($con, $usersql2);
   if($usersresult){
    header("location:/vicidial-master/admin/index.php?c=dashboard&v=ivr_converter");
   }else{
    header("location:/vicidial-master/admin/index.php?c=dashboard&v=ivr_converter");
   }
}
?>
