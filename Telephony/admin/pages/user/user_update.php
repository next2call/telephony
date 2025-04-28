<?php
include "../../../conf/db.php";
include "../../../conf/Get_time_zone.php";

// if($con){
//     echo "success";
// }else{
//     echo "no";
// }

session_start();
$Adminuser = $_SESSION['user'];

 $c_number = $_POST['c_number'];
// echo "</br>";
 $edit_name_c = $_POST['edit_name_c'];
// echo "</br>";
 $use_did = $_POST['use_did'];
 $password_new = $_POST['password_new'];
 $user_lable_new = $_POST['user_lable_new'];
 $new_user_priority = $_POST['user_priority'];
 $external_num = $_POST['external_num'];
 $calling_temp = $_POST['calling_temp'];

 if (isset($calling_temp) && !empty($calling_temp)) {
    $temp_id = $calling_temp;
} else {
    $temp_id = 'telephony';
}

$selected_values = json_decode($_POST['selected_values'], true); // Decoding the JSON encoded array
$compaign_id = isset($selected_values) ? implode(",", $selected_values) : '';

// Fetch the old user priority
$tfnsel_pri = "SELECT agent_priorty FROM users WHERE user_id='$c_number'";
$data_pri = mysqli_query($con, $tfnsel_pri);
$row_pri = mysqli_fetch_array($data_pri);
$old_user_priority = $row_pri['agent_priorty'];
$user_type_old = $row_pri['user_type'];

    $select_pr = "SELECT agent_priorty FROM users WHERE admin='$Adminuser' ORDER BY agent_priorty DESC LIMIT 1";
    $sel_query_pr = mysqli_query($con, $select_pr);
        $pr_row = mysqli_fetch_assoc($sel_query_pr);
        if(!empty($pr_row['agent_priorty'])){
          $priority = $pr_row['agent_priorty'] + 1;
        } else {
        $priority = 1;
        }   

// if($user_type_old == $new_user_priority){

// }else{
    
// }



if ($user_lable_new == '1') {
    // Update agent priority for another user
    $update_one = "UPDATE `users` SET `agent_priorty`='$old_user_priority' WHERE `agent_priorty`='$new_user_priority'";
    mysqli_query($con, $update_one);

    // Update user details
    $update = "UPDATE `users` SET 
        `password`='$password_new', 
        `full_name`='$edit_name_c', 
        `use_did`='$use_did', 
        `user_type`='$user_lable_new', 
        `agent_priorty`='$new_user_priority',
        `ext_number`='$external_num'" . 
        (!empty($compaign_id) ? ", `campaigns_id`='$compaign_id'" : "") . 
        " WHERE `user_id`='$c_number'";
} else {
    // Update user details without changing agent priority
    $update = "UPDATE `users` SET 
        `password`='$password_new', 
        `full_name`='$edit_name_c', 
        `use_did`='$use_did', 
        `user_type`='$user_lable_new',
        `ext_number`='$external_num'" . 
        (!empty($compaign_id) ? ", `campaigns_id`='$compaign_id'" : "") . 
        " WHERE `user_id`='$c_number'";
}
  
// Update additional tables
$updatetwo = "UPDATE `vicidial_users` SET `pass`='$password_new', `user_level`='$user_lable_new' WHERE `user`='$c_number'";
mysqli_query($conn, $updatetwo);
$updatethree = "UPDATE `phones` SET `pass`='$password_new', `login_pass`='$password_new', `conf_secret`='$password_new', `template_id`='$temp_id'  WHERE `extension`='$c_number'";
mysqli_query($conn, $updatethree);

// Execute the main user update query
$usersresult = mysqli_query($con, $update);
if ($usersresult) {
    echo "ok";
} else {
    echo "Not ok";
}

?>