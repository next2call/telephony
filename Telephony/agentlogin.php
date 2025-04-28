<?php
session_start();
require 'conf/db.php';
require 'conf/Get_time_zone.php';
require 'conf/sql_operation.php';
$sqlO = new sql_operation;
$msg = null;

$user = $_SESSION['user'] ?? '';
$npass = $_SESSION['pass'] ?? '';
$user_level = $_SESSION['user_level'] ?? '';
$newuser = '';
$newpass = '';
// if (empty($user) || !isset($user)) {
//     header('location: admin/index.php');
//     exit;
// }

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $admin_user = $_POST['admin_user'];
    $campaign_id = $_POST['campaign_id'];
    $password = $_POST['password'];
    $sql = "SELECT * from vicidial_users where user ='" . $username . "' AND pass='" . $password . "'";
    $row = $sqlO->sql_execution($sql);

 $user_sel = "SELECT users.agent_priorty, users.ext_number, group_agent.press_key, group_agent.group_id
FROM users
INNER JOIN group_agent ON users.user_id = group_agent.agent_id
WHERE users.user_id = '$username' AND group_agent.campaign_id = '$campaign_id'";

$user_run=mysqli_query($con, $user_sel);
$u_ro=mysqli_fetch_array($user_run);
  $agent_priorty = $u_ro['agent_priorty'];
 $press_key = $u_ro['press_key'];
 $ext_number = $u_ro['ext_number'];
 $group_id = $u_ro['group_id'];

  $u_sel_one = "SELECT * FROM vicidial_group WHERE campaign_id='$campaign_id' AND group_id='$group_id'";
 $u_run_one = mysqli_query($con, $u_sel_one);
    // echo "</br>";

  $u_sel_two = "SELECT * FROM vicidial_menu_group WHERE campaign_id='$campaign_id' AND group_id='$group_id'";
 $u_run_two = mysqli_query($con, $u_sel_two);
//  echo "</br>";


 if (mysqli_num_rows($u_run_one) > 0) 
 {
    $topress_key = $press_key;
//    echo "</br>";
    $ivr_filesec = '1';

    $menu_option = '1-'.$press_key;


 }elseif(mysqli_num_rows($u_run_two) > 0){

    $u_row1 = mysqli_fetch_array($u_run_two);
    $gmenu_id = $u_row1['menu_id'];  // Corrected variable name
     $u_sel_three = "SELECT * FROM menu_ivr_tbl1 WHERE campaign_id='$campaign_id' AND menu_id='$gmenu_id'";
    $u_run_three = mysqli_query($con, $u_sel_three);

    if (mysqli_num_rows($u_run_three) > 0) 
    {

        $u_ro_one = mysqli_fetch_array($u_run_three);
    $press_keysec = $u_ro_one['press_key'];  // Corrected variable name
    $ivr_files = $u_ro_one['ivr_file'];    // Corrected variable name
    $menu_ids = $u_ro_one['menu_id'];
    $ivr_type = $u_ro_one['ivr'];

    if($ivr_type == '1'){
         $topress_key = $press_keysec.','.$press_key;
        // echo "</br>";
         $ivr_filesec= $ivr_files.',1';

         $menu_option = '1-'.$press_keysec.',2-'.$press_key;

    } elseif($ivr_type == '2'){
        $u_sel_data = "SELECT * FROM menu_ivr_tbl2 WHERE campaign_id='$campaign_id' AND menu_ivr_id='$menu_ids'";
        $u_run_d = mysqli_query($con, $u_sel_data);
        $u_row_two = mysqli_fetch_array($u_run_d);

        $press_keysec_two = $u_row_two['press_key'];  // Corrected variable name
        $ivr_files_two = $u_row_two['ivr_file'];    // Corrected variable name
        $menu_ids_two = $u_row_two['menu_id'];
        $ivr_type_two = $u_row_two['ivr'];

         $topress_key = $press_keysec.','.$press_keysec_two.','.$press_key;
        // echo "</br>";
         $ivr_filesec= $ivr_files.','.$ivr_files_two.',1';

         $menu_option = '1-'.$press_keysec.',2-'.$press_keysec_two.',3-'.$press_key;
     
    }
   
    }else{
        
          $u_sel_data = "SELECT * FROM menu_ivr_tbl2 WHERE campaign_id='$campaign_id' AND menu_id='$gmenu_id'";
        $u_run_d = mysqli_query($con, $u_sel_data);
        $u_row_two = mysqli_fetch_array($u_run_d);
        $press_keysec_two = $u_row_two['press_key'];  // Corrected variable name
        $ivr_files_two = $u_row_two['ivr_file'];    // Corrected variable name
        $menu_ids_two = $u_row_two['menu_id'];
        $menu_ivr_id = $u_row_two['menu_ivr_id'];
        $ivr_type_two = $u_row_two['ivr'];

        $select_da = "SELECT * FROM menu_ivr_tbl1 WHERE menu_id='$menu_ivr_id'";
        $sel_query_n = mysqli_query($con, $select_da);
        $row_sel_on = mysqli_fetch_assoc($sel_query_n);
        $paress_kew_one = $row_sel_on['press_key'];  
        $ivr_file_one = $row_sel_on['ivr_file'];  

         $topress_key = $paress_kew_one.','.$press_keysec_two.','.$press_key;
        // echo "</br>";
         $ivr_filesec= $ivr_file_one.','.$ivr_files_two.',1';

         $menu_option = '1-'.$paress_kew_one.',2-'.$press_keysec_two.',3-'.$press_key;

    }

 }else{
     $topress_key = '0'; 
    // echo "</br>";
     $ivr_filesec = '0';

     $menu_option = '1-0';

 } 


// die();


    if ($row['user_level'] == 1 && $row['active']== 'Y' && !empty($campaign_id)) {
        $_SESSION['campaign_id'] = $campaign_id;
        $_SESSION['user_level'] = $row['user_level'];
        header('location:agent/index.php');
// ====================================insert user login time================================
$date_time = date("Y-m-d H:i:s");
$date = date("Y-m-d");

$u_sel="SELECT * FROM login_log WHERE log_in_time LIKE '%$date%' AND user_name='$username'"; 
$u_run=mysqli_query($con,$u_sel);
if(mysqli_num_rows($u_run) > 0){
$u_ro=mysqli_fetch_array($u_run);
$id = $u_ro['id'];
$ins_log="UPDATE `login_log` SET status='1', campaign_name='$campaign_id', emg_log_out='0' WHERE id='$id'";
mysqli_query($con,$ins_log);

$inse_b = "INSERT INTO `break_time`(`user_name`, `mobile_no`, `break_name`, `start_time`, `end_time`, `break_status`, `status`, `campaign_id`, `press_key`, `agent_priorty`, `menu_prompt`, `parent_option`) VALUES ('$username', '$ext_number', 'Ready','$date_time','$date_time','2','2','$campaign_id','$topress_key','$agent_priorty','$ivr_filesec', '$menu_option')";
mysqli_query($con,$inse_b);

} else {
$ins_log="UPDATE `login_log` SET status='2', emg_log_out='0' WHERE user_name='$username'";
mysqli_query($con,$ins_log);
$inse = "INSERT INTO `login_log`(`user_name`, `log_in_time`, `status`, `campaign_name`, `admin`, `user_type`, `emg_log_out`) VALUES ('$username','$date_time','1','$campaign_id','$admin_user','1', '0')";

mysqli_query($con,$inse);

$brek_up="UPDATE `break_time` SET break_status='2', status='2' WHERE user_name='$username'";
mysqli_query($con,$brek_up); 

$inse_b = "INSERT INTO `break_time`(`user_name`, `mobile_no`, `break_name`, `start_time`, `break_status`, `status`, `campaign_id`, `press_key`, `agent_priorty`, `menu_prompt`, `parent_option`) VALUES ('$username', '$ext_number', 'Ready','$date_time','2','2','$campaign_id','$topress_key','$agent_priorty','$ivr_filesec', '$menu_option')"; 
mysqli_query($con,$inse_b);
}
// ====================================insert user login time================================
    } elseif($row['user_level'] == 2 && $row['active']== 'Y' && !empty($campaign_id)){
       
        $_SESSION['campaign_id'] = $campaign_id;
        $_SESSION['user_level'] = $row['user_level'];
        header('location:admin/index.php');

        $date_time = date("Y-m-d H:i:s");
        $date = date("Y-m-d");
        
        $u_sel="SELECT * FROM login_log WHERE log_in_time LIKE '%$date%' AND user_name='$username'"; 
        $u_run=mysqli_query($con,$u_sel);
        if(mysqli_num_rows($u_run) > 0){
        $u_ro=mysqli_fetch_array($u_run);
        $id = $u_ro['id'];
        $ins_log="UPDATE `login_log` SET status='1', campaign_name='$campaign_id', emg_log_out='0' WHERE id='$id'";
        mysqli_query($con,$ins_log);
        
        $inse_b = "INSERT INTO `break_time`(`user_name`, `mobile_no`, `break_name`, `start_time`, `end_time`, `break_status`, `status`, `campaign_id`, `press_key`, `agent_priorty`, `menu_prompt`, `parent_option`) VALUES ('$username', '$ext_number', 'Ready','$date_time','$date_time','2','2','$campaign_id','$topress_key','$agent_priorty','$ivr_filesec', '$menu_option')";
        mysqli_query($con,$inse_b);
        
        } else {
        $ins_log="UPDATE `login_log` SET status='2', emg_log_out='0' WHERE user_name='$username'";
        mysqli_query($con,$ins_log);
        $inse = "INSERT INTO `login_log`(`user_name`, `log_in_time`, `status`, `campaign_name`, `admin`, `user_type`, `emg_log_out`) VALUES ('$username','$date_time','1','$campaign_id','$admin_user','1','0')";
        
        mysqli_query($con,$inse);
        
        $brek_up="UPDATE `break_time` SET break_status='2', status='2' WHERE user_name='$username'";
        mysqli_query($con,$brek_up); 
        
        $inse_b = "INSERT INTO `break_time`(`user_name`, `mobile_no`, `break_name`, `start_time`, `break_status`, `status`, `campaign_id`, `press_key`, `agent_priorty`, `menu_prompt`, `parent_option`) VALUES ('$username', '$ext_number', 'Ready','$date_time','2','2','$campaign_id','$topress_key','$agent_priorty','$ivr_filesec', '$menu_option')"; 
        mysqli_query($con,$inse_b);
        }


    }else {
        $msg = "Invalid Campaign input";

    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="https://next2call.com/assets/img/logo/logo5.png">
    <title>Next2call Dialer</title>

    <!-- All the css files here -->
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="./assets/css/font-awesome.min.css" />
    <link rel="stylesheet" href="./assets/css/style.css" />
    <style>
    .logo_img_main {
        /* height: 50px !important; */
        width: 15rem !important;
    }
    </style>
</head>

<body>
    <section>
        <div class="login">
            <div class="top-bar">
                <img src="./assets/images/dashboard/next2calld.png" class="logo_img_main" alt="" />
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="left">
                        <img src="./assets/images/login/sideImg1.png" alt="">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="right">
                        <h3>Log In</h3>

                        <form method="POST" action="" autocomplete="off">
                            <?php

                        if (isset($msg)) {
                            echo '<span class="error-msg">Invalid input</span>';
                        }
                        ?>

                            <div class="form-group">
                                <input type="text" id="email" name="username" class="form-control" value="<?= $user ?>"
                                    readonly>
                            </div>
                            <div class="form-group">
                                <input type="password" id="password" name="password" class="form-control"
                                    value="<?= $npass ?>" readonly>
                            </div>
                            <div class="form-group">
                                <select name="campaign_id" class="form-control">
                                    <option value="">SELECT CAMPAIGN</option>
                                    <?php
    $list_tbl_select = "SELECT * FROM `users` WHERE user_id='$user'";
    $list_query = mysqli_query($con, $list_tbl_select);
    $list_row = mysqli_fetch_array($list_query);
    
    if ($list_row) {
        $admin_user = $list_row['admin'];
        $delimiter = ",";
        $cam_id = $list_row['campaigns_id'];
        $cam_ids = explode($delimiter, $cam_id);
    
        $passengerIndex = 0;
        while ($passengerIndex < count($cam_ids)) {
            $p_camid = isset($cam_ids[$passengerIndex]) ? $cam_ids[$passengerIndex] : '';
             $cam_select = "SELECT * FROM compaign_list WHERE compaign_id='$p_camid' AND status='Y'";
            $cam_query = mysqli_query($con, $cam_select);
            $cam_row = mysqli_fetch_assoc($cam_query);
            $p_camname = $cam_row['compaignname'];
            ?>
            <option value="<?= htmlspecialchars($p_camid) ?>"><?= htmlspecialchars($p_camname) ?></option>
            <?php
            $passengerIndex++;
        }
    }
    ?>

                                </select>

                                <label for="source_campaign_id" class="form-control-placeholder">Campaign</label>
                            </div>
                            <input type="hidden" value="<?= $admin_user ?>" name="admin_user">

                            <div class="form-group">
                                <div id="dynamicFieldsContainer"></div>
                            </div>
                            <input type="submit" class="btn btn-primary btn-block" value="Log In" name="submit" />

                        </form>
                        <div class="footer">
                            <div class="footer-links">
                                <a href="https://next2call.com/" target="_blank"><span></span> About Next2call</a>
                                <a href="#"><span></span> Condition of use</a>
                                <a href="#"><span></span> Privacy Notice</a>
                                <a href="#"><span></span> Need help?</a>
                            </div>
                            <a href="https://next2call.com/" target="_blank">
                                <p> Copyright &copy 2024 Next2call</p> 
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- All the js files here -->
    <script src="./assets/js/jquery.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
    <script src="./assets/js/chart.min.js"></script>
    <script src="./assets/js/custom.js"></script>

    <script>
    function addField() {
        var dynamicFieldsContainer = document.getElementById('dynamicFieldsContainer');

        var inputWrapper = document.createElement('div');
        inputWrapper.classList.add('form-group');

        var input = document.createElement('select');
        input.type = 'select';
        input.name = 'dynamicField[]';
        input.classList.add('form-control');

        var label = document.createElement('label');
        label.classList.add('form-control-placeholder');
        label.textContent = 'Campaign';

        inputWrapper.appendChild(input);
        inputWrapper.appendChild(label);
        dynamicFieldsContainer.appendChild(inputWrapper);
    }
    </script>
</body>

</html>