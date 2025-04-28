<?php
session_start();
include_once("../../../conf/db.php"); // Adjust the path as necessary
include "../../../conf/Get_time_zone.php";

$Adminuser = $_SESSION['user'];


$ids = $_POST['id'];
$cam_number = $_POST['number'];
$camp_id = $_POST['camp_id'];
$press_key = $_POST['press_key'];

if(!empty($ids) && !empty($cam_number)){

    $arr = ''; 
    foreach ($ids as $item) {
    
        // $arr .= $item ." / ". $number;
         $selt = "SELECT * FROM `users` WHERE id='$item'";
        $sel_q = mysqli_query($con, $selt);
        $row = mysqli_fetch_assoc($sel_q);
         $user_id = $row['user_id'];
         $full_name = $row['full_name'];
         $agent_priorty = $row['agent_priorty'];
        //  $full_name = $row['full_name'];
        
        //  $agent_status = $row['status'];
    
         if(!empty($full_name) && !empty($camp_id)){
         $sela = "SELECT * FROM group_agent WHERE agent_id='$user_id' AND group_id='$cam_number'";
         $runa = mysqli_query($con, $sela);
         if(mysqli_num_rows($runa) < 1 ){
             $ins_que = "INSERT INTO group_agent(group_id, agent_id, agent_name, admin, campaign_id, press_key) VALUES ('$cam_number', '$user_id', '$full_name', '$Adminuser', '$camp_id', '$press_key')";
      
          $ins_data = mysqli_query($con, $ins_que);
          } 
              
         }
      }
    
      if($ins_data){
        echo "2";
              }else{
                echo "3";
              }
      
    } else {
      echo 6;
    }
    

?>
