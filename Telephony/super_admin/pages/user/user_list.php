<?php
session_start();
$Adminuser = $_SESSION['user'];
require '../include/user.php';
include "../../../conf/db.php";
include "../../../conf/url_page.php";
$user = new user();

// $user = $Adminuser;


$usersql = "Select user,user_id, full_name, user_level, user_group, active from vicidial_users";

$sel = "SELECT user_id FROM `users` WHERE SuperAdmin='$Adminuser'";
$sql = mysqli_query($con, $sel);
$admin_user = [];

while($rowu = mysqli_fetch_assoc($sql)){
    $admin_user[] = $rowu['user_id'];
}

$admin_user_list = implode("','", $admin_user);

$usersql2 = "SELECT * FROM `users` WHERE user_id NOT IN ('$admin_user_list') AND admin IN ('$admin_user_list')";
$usersresult = mysqli_query($con, $usersql2);



// $usersresult = mysqli_query($con, $usersql2);


$eUser = "";
$full_name = "";
$user_level = "";
$user_group = "";
$pass = "";
$error = 0;

if (isset($_POST['add_user'])) {
    $user->user = $_POST['user'];
    $user->full_name = $_POST['full_name'];
    $user->use_did = $_POST['use_did'];
    $user->use_campaign = $_POST['use_campaign'];
    $user->user_level = $_POST['user_lable'];
    $user->user_group = 'winet';
    $user->pass = $_POST['pass'];
    $user->external_num = $_POST['external_num'];
    // $user->org = $_POST['Organization'];
    $date = date("Y-m-d h:i:s");


    // Assuming $user and database connections ($con, $conn) are already defined
    
    // Query to check if user exists in 'users' table
    // $user_id = $user->user;
    $sel_check = "SELECT user_id FROM `users` WHERE user_id='$user->user'";
    $quer_check = mysqli_query($con, $sel_check);
    
    if (!$quer_check) {
        die('Error with query: ' . mysqli_error($con));
    }
    
    $sel_check_vicidial = "SELECT extension FROM `phones` WHERE extension='$user->user'";
    $quer_check_vici = mysqli_query($conn, $sel_check_vicidial);
    
    if (!$quer_check_vici) {
        die('Error with query: ' . mysqli_error($conn));
    }
    
    if (mysqli_num_rows($quer_check) > 0) {
        // echo "<script>alert('Data is already Inserted');</script>";
        echo '
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
    
        <script>
        Swal.fire({
            position: "top-end",
            icon: "error",
            title: "This user has already been created !",
            showConfirmButton: false,
            timer: 1500
        }).then(() => {
            window.location.href = "'.$admin_ind_page.'?c=user&v=user_list";
        });
        </script>';
    } elseif(mysqli_num_rows($quer_check_vici) > 0){
        // echo "<script>alert('Data is already Inserted');</script>";
        echo '
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
    
        <script>
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "This extension already created phone",
            showConfirmButton: false,
            timer: 1500
        }).then(() => {
            window.location.href = "'.$admin_ind_page.'?c=user&v=user_list";
        });
        </script>';
    } else {

        // $data_ins="INSERT INTO `did_list`(`did`, `user`, `extension`, `status`) VALUES ('".$user->use_did."','".$user->user."','".$user->user."','1')";
        // mysqli_query($con, $data_ins);


    $sql="INSERT INTO vicidial_users (user, full_name, user_level, user_group, pass) VALUES ('".$user->user."','".$user->full_name."','".$user->user_level."','".$user->user_group."','".$user->pass."')";
    mysqli_query($conn,$sql);
// echo "<br>";

    // $sql_vcd="INSERT INTO `phones`(`extension`, `dialplan_number`, `voicemail_id`, `login`, `pass`, `active`, `phone_type`, `fullname`, `company`) VALUES ('".$user->user."','".$user->user."','".$user->user."','".$user->user."','".$user->pass."','Y','VICIDIAL','".$user->full_name."','".$user->org."')";
    $phone_ins="INSERT INTO phones (extension, dialplan_number, voicemail_id, phone_ip, computer_ip, server_ip, login, pass, status, active, phone_type, fullname, company, picture, messages, old_messages, protocol, local_gmt, ASTmgrUSERNAME, ASTmgrSECRET, login_user, login_pass, login_campaign, park_on_extension, conf_on_extension, VICIDIAL_park_on_extension, VICIDIAL_park_on_filename, monitor_prefix, recording_exten, voicemail_exten, voicemail_dump_exten, ext_context, dtmf_send_extension, call_out_number_group, client_browser, install_directory, local_web_callerID_URL, VICIDIAL_web_URL, AGI_call_logging_enabled, user_switching_enabled, conferencing_enabled, admin_hangup_enabled, admin_hijack_enabled, admin_monitor_enabled, call_parking_enabled, updater_check_enabled, AFLogging_enabled, QUEUE_ACTION_enabled, CallerID_popup_enabled, voicemail_button_enabled, enable_fast_refresh, fast_refresh_rate, enable_persistant_mysql, auto_dial_next_number, VDstop_rec_after_each_call, DBX_server, DBX_database, DBX_user, DBX_pass, DBX_port, DBY_server, DBY_database, DBY_user, DBY_pass, DBY_port, outbound_cid, enable_sipsak_messages, email, template_id, conf_override, phone_context, phone_ring_timeout, conf_secret, delete_vm_after_email, is_webphone, use_external_server_ip, codecs_list, codecs_with_template, webphone_dialpad, on_hook_agent, webphone_auto_answer, voicemail_timezone, voicemail_options, user_group, voicemail_greeting, voicemail_dump_exten_no_inst, voicemail_instructions, on_login_report, unavail_dialplan_fwd_exten, unavail_dialplan_fwd_context, nva_call_url, nva_search_method, nva_error_filename, nva_new_list_id, nva_new_phone_code, nva_new_status, webphone_dialbox, webphone_mute, webphone_volume, webphone_debug, outbound_alt_cid, conf_qualify, webphone_layout, mohsuggest, peer_status, ping_time, webphone_settings) VALUES
    ('".$user->user."', '".$user->user."', '".$user->user."', '10.101.1.16', '10.101.1.16', '192.168.125.241', '".$user->user."', '".$user->pass."', 'ACTIVE', 'Y', '".$user->user."', '".$user->user."', '', '', 0, 0, 'SIP', '-5.00', 'cron', '1234', '', '', '', '8301', '8302', '8301', 'park', '8612', '8309', '8501', '85026666666666', 'default', 'local/8500998@default', 'Zap/g2/', '/usr/bin/mozilla', '/usr/local/perl_TK', 'http://www.vicidial.org/test_callerid_output.php', '', '1', '1', '1', '0', '0', '1', '1', '1', '1', '1', '1', '1', '0', 1000, '0', '1', '1', '', 'asterisk', 'cron', '1234', 3306, '', 'asterisk', 'cron', '1234', 3306, '".$user->user."', '0', '', 'vicidial_master', '', 'default', 60, '".$user->pass."', 'N', 'Y', 'N', '', '0', 'Y', 'N', 'Y', 'eastern', '', 'winet', '', '85026666666667', 'Y', 'N', '', '', '', 'NONE', '', 995, '1', 'NVAINS', 'Y', 'Y', 'Y', 'Y', '', 'Y', '', '', 'REACHABLE', 27, 'VICIPHONE_SETTINGS')";
    mysqli_query($conn,$phone_ins);


    $stmtA="UPDATE servers SET rebuild_conf_files='Y' where generate_vicidial_conf='Y' and active_asterisk_server='Y' and server_ip='192.168.125.241' OR server_ip='103.113.27.163'";
	// $rslt=mysql_to_mysqli($stmtA, $link);
    mysqli_query($conn,$stmtA);
    // echo "<br>";

    $select_pr = "SELECT agent_priorty FROM users WHERE admin='$Adminuser' ORDER BY agent_priorty DESC LIMIT 1";
    $sel_query_pr = mysqli_query($con, $select_pr);
        $pr_row = mysqli_fetch_assoc($sel_query_pr);
        if(!empty($pr_row['agent_priorty'])){
          $priority = $pr_row['agent_priorty'] + 1;
        } else {
        $priority = 1;
        }
   
        if($user->user_level == '1'){
        $new_priority = $priority;
        }else{
            $new_priority = '';
        }

    $sql2= "INSERT INTO `users`(`admin`, `user_id`, `password`, `full_name`, `status`, `campaigns_id`, `ins_date`, `use_did`, `user_type`, `agent_priorty`, `ext_number`) VALUES ('$Adminuser', '".$user->user."','".$user->pass."','".$user->full_name."','Y', '".$user->use_campaign."', '$date', '".$user->use_did."', '".$user->user_level."', '$new_priority', '".$user->external_num."')";


   $query_ins = mysqli_query($con, $sql2);

//    echo "<br>";
// die();
   if($query_ins){
//    echo "<script>alert('Okey. data insert successfull')</script>";
   echo '
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
   
   <script>
   // var username = document.getElementById("floatingInput1").value;
   window.onload = function() {
     Swal.fire({
       title: "Create User ",
       text: "Create User is successful.",
       icon: "success",
       confirmButtonText: "OK"
     }).then(() => {
        window.location.href = "'.$admin_ind_page.'?c=user&v=user_list";
    });
   }
   </script>';
   }else{
    // echo "<script>alert('Sorry')</script>";

    echo '
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
    
    <script>
    // var username = document.getElementById("floatingInput1").value;
    window.onload = function() {
      Swal.fire({
        title: "Failed",
        text: "Sorry, Data is not Inserted!",
        icon: "error",
        confirmButtonText: "OK"
      }).then(() => {
        window.location.href = "'.$admin_ind_page.'?c=user&v=user_list";
    });
    }
    </script>';
   }

}
} else {
    $user->user = "";
    $user->full_name = "";
    $user->user_level = "";
    $user->user_group = "";
    $user->pass = "";
}


?>
<style>
.data_btn {
    background: #d1e1ff;
    color: #284f99;
    font-weight: bold;
    font-size: 12px;
    line-height: 22px;
    /* color: #637381; */
    /* background: transparent; */
    border-radius: 10px;
    padding: 8px;
    margin-right: 25px;
    transition: 0.3s all ease-in-out;
    margin-top: 25px;
    display: inline-block;
}

.data_btn1 {
    background: #dfcbea;
    color: #284f99;
    font-weight: bold;
    font-size: 12px;
    line-height: 22px;
    /* color: #637381; */
    /* background: transparent; */
    border-radius: 10px;
    padding: 8px;
    margin-right: 25px;
    transition: 0.3s all ease-in-out;
    margin-top: 25px;
    display: inline-block;
}

.data_btn2 {
    background: #f6dfce;
    color: #284f99;
    font-weight: bold;
    font-size: 12px;
    line-height: 22px;
    /* color: #637381; */
    /* background: transparent; */
    border-radius: 10px;
    padding: 8px;
    margin-right: 25px;
    transition: 0.3s all ease-in-out;
    margin-top: 25px;
    display: inline-block;
}
</style>

<style>
.value-item {
    display: flex;
    align-items: center;
    margin-bottom: 5px;
}

.remove-icon {
    margin-left: 10px;
    cursor: pointer;
    color: red;
    font-weight: bold;
    margin-top: 1px;
}
</style>
<div>
    <div class="show-users ml-5">

        <!-- this is the top navbar that containes add user, copy user, time sheet and search option -->
        <!-- <div class="my-nav">
            <ul>
                <li>
                    <a class="nav-active" href="#add-user" data-toggle="modal" data-target="#add-user"><i
                                class="fa fa-plus-circle" aria-hidden="true"></i>
                        Add User</a>
                </li>

                <li>
                    <a href="#copy-user" data-toggle="modal" data-target="#copy-user"><i
                                class="fa fa-clone" aria-hidden="true"></i> Copy User</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-clock-o" aria-hidden="true"></i> Time Sheet</a>
                </li>
                <li>
                    <input type="search" placeholder="Search User" name="search" id="search-user">
                </li>
            </ul>
        </div> -->
        <!-- this is where top navbar ends -->

        <!-- user list table start -->
        <div class="table-responsive my-table ml-5">
            <div class="table-top">
                <!-- <a class="data_btn" href="#add-user" data-toggle="modal" data-target="#add-user"><i
                        class="fa fa-plus-circle" aria-hidden="true"></i>
                    Add Agent</a> -->
                <a class="data_btn1" href="?c=user&v=user_break_status"><i class="fa fa-plus-circle"
                        title="You can click here to see why users take breaks"></i>
                    View Agent Break </a>
                <a class="data_btn2" href="?c=user&v=user_login_status"><i class="fa fa-plus-circle"
                        title="Your User login and Logout reports"></i>
                    Login Report</a>
                <a class="data_btn1" href="?c=user&v=all_agent_report&admin_user_id=<?php echo $Adminuser; ?>">
                    <i class="fa fa-plus-circle" title="You can click here to see All Agent Report And Stats"></i>
                    All Agent Report
                </a>

                <!-- <a class="data_btn2" href="?c=dashboard&v=disposition"><i
                                class="fa fa-plus-circle" title="Your User login and Logout reports"></i>
                        Disposition</a>
                        <a class="data_btn2" href="?c=dashboard&v=create_camp"><i
                                class="fa fa-plus-circle" title="Your User login and Logout reports"></i>
                        Campaign Create</a> -->


            </div>
            <table class="all-user-table table table-hover">
                <thead>
                    <tr>
                        <th scope="col"><a href="#">USER ID</a></th>
                        <th scope="col"><a href="#">PASSWORD</a></th>
                        <th scope="col"><a href="#">FULL NAME</a></th>
                        <th scope="col"><a href="#">AVAIL. CAMPAIGN</a></th>
                        <th scope="col"><a href="#">STATUS</a></th>
                        <th scope="col"><a href="#">LAVEL</a></th>
                        <th scope="col"><a href="#">PRIORITY</a></th>
                        <th scope="col"><a href="#">DATE</a></th>
                        <th scope="col"><a href="#">ACTION</a></th>

                    </tr>
                </thead>
                <tbody>
                    <?php

                while ($usersrow = mysqli_fetch_array($usersresult)) {
                    echo '<tr>';
                    echo '<td>' . $usersrow['user_id'] . '</td>';
                    echo '<td>' . $usersrow['password'] . '</td>';
                    echo '<td>' . $usersrow['full_name'] . '</td>';
                    echo '<td>' . $usersrow['campaigns_id'] . '</td>';
                   

                           ?>
                    <td>
                        <a href="pages/user/editstatus.php?id=<?= $usersrow['user_id'] ?>">
                            <?php 
                          if($usersrow['status'] == 'Y'){
                          echo '<span class="active-yes cursor_p">' . 'Active' . '</span>';
                          } else {
                           echo '<span class="active-no cursor_p">' . 'Inactive' . '</span>';
                             }
                              ?>
                        </a>

                    </td>

                    <td>
                        <?php 

                          if($usersrow['user_type'] == '1'){
                          echo '<span class="text-success cursor_p">' . 'Agent' . '</span>';
                          } else {
                           echo '<span class="text-warning cursor_p">' . 'Admin' . '</span>';
                             }
                              ?>
                    </td>
                    <?php
                                        echo '<td>' . $usersrow['agent_priorty'] . '</td>';

                    // echo '<td>' . $usersrow['user_type'] . '</td>';
                    echo '<td>' . $usersrow['ins_date'] . '</td>';
                    ?>
                    <td>
                        <!-- <a class='contact_add text-primary cursor_p' data-user_id="<?Php echo $usersrow['user_id']; ?>"
                            data-toggle="modal" data-target="#edit_user" title="Click here and Edit user "><i
                                class="fa fa-pencil-square" style="font-size:20px;"></i></a> -->

                        <a class='show_break_report text-info text-primary cursor_p' data-user_id="<?Php echo $usersrow['user_id']; ?>"
                        title="You can click here to see why users take breaks"><i
                                class="fa fa-eye" style="font-size:20px;;"></i></a>
                        
                            <!-- <i class="fa fa-trash cursor_p text-danger remove_user mb-2" style="font-size:20px;" data-user_id="<?Php echo $usersrow['user_id']; ?>"
                            data-user_priorty="<?Php echo $usersrow['agent_priorty']; ?>"
                            title="You can click here and Delete this Users"></i> -->
                    </td>
                    <?php
                    echo '</tr>';
                }

                ?>

                </tbody>
            </table>
        </div>
        <!-- user list table ends -->

    </div>
</div>

<!-- Copy user modal starts here -->
<!-- Copy user modal ends here -->

<!-- Add user modal starts here -->


<div class="modal fade" id="add-user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">

                    <div class="row">
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">

                                <input type="text" class="form-control" id="new-user-number" name="user"
                                    aria-describedby="new-user-no"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                    maxlength="8" required>
                                <label for="new-user-number">User ID</label>
                            </div>

                        </div>
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">

                                <input type="text" class="form-control" id="full-name" name="full_name"
                                    aria-describedby="full-name" required>
                                <label for="full-name">Full Name</label>
                            </div>

                        </div>
                        <div class="my-dropdown-with-help col-6">
                            <div class="my-dropdown">
                                <select name="use_campaign" id="use_campaign">
                                    <option></option>
                                    <?php
                                        $sel_check_one = "SELECT * FROM `compaign_list` WHERE admin='$Adminuser'";
                                        $quer_check_one = mysqli_query($con, $sel_check_one);
                                        while($row_one = mysqli_fetch_assoc($quer_check_one)){
                                            $campaign_name = $row_one['compaignname'];
                                            $compaign_id = $row_one['compaign_id'];
                                            
                                            ?>
                                    <option value="<?= $compaign_id; ?>"><?= $compaign_id; ?></option>
                                    <?php }   ?>
                                </select>

                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="campaign_description">Campaign Name</label>
                            </div>

                        </div>

                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">
                                <input type="text" class="form-control" id="Organization" name="use_did"
                                    aria-describedby=""
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                    maxlength="12">
                                <label for="password">Use DID </label>
                            </div>
                        </div>





                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">

                                <input type="password" class="form-control" id="password" name="pass"
                                    aria-describedby="password" required>
                                <label for="password">password</label>
                            </div>

                        </div>
                        <!-- <div class="my-input-with-help col-6">
                            <div class="form-group my-input">
                                <input type="text" class="form-control" id="Organization" name="Organization"
                                    aria-describedby="">
                                <label for="password">User Organization</label>
                            </div>
                        </div> -->
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">
                                <input type="int" class="form-control" id="external_num" name="external_num"
                                    aria-describedby="external_num"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                    maxlength="10">
                                <label for="Extername Number">External Number</label>
                            </div>
                        </div>
                        <div class="my-dropdown-with-help col-6">
                            <div class="my-dropdown">
                                <select name="user_lable" id="user_lable">
                                    <option value="1">Agent</option>
                                    <option value="8">Admin</option>
                                </select>

                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="campaign_description">Select User Type</label>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary my-btn-secondary" data-dismiss="modal">Cancel
                    </button>
                    <input class="my-btn-primary" type="submit" value="submit" name="add_user">
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="edit_user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="myForm_insert_data" method="POST">
                <div class="modal-body">

                    <div class="row">
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">

                                <input type="text" class="form-control" id="c_number" name="c_number"
                                    aria-describedby="new-user-no"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                    maxlength="15" readonly>
                                <label for="new-user-number">User ID</label>
                            </div>

                        </div>
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">

                                <input type="text" class="form-control" id="edit_name_c" name="edit_name_c"
                                    aria-describedby="full-name" required>
                                <label for="full-name">Full Name</label>
                            </div>

                        </div>

                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">
                                <input type="text" class="form-control" id="use_did" name="use_did" aria-describedby=""
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                    maxlength="12">
                                <label for="password">Use DID </label>
                            </div>
                        </div>

                        <div class="my-dropdown-with-help col-6">
                            <div class="my-dropdown">
                                <select name="add_subject" id="add_subject" onchange="addValue()">
                                    <option></option>
                                    <?php
                                        $sel_check_one = "SELECT * FROM `compaign_list` WHERE admin='$Adminuser'";
                                        $quer_check_one = mysqli_query($con, $sel_check_one);
                                        while($row_one = mysqli_fetch_assoc($quer_check_one)){
                                            $campaign_name = $row_one['compaignname'];
                                            $compaign_id = $row_one['compaign_id'];
                                            
                                            ?>
                                    <option value="<?= $compaign_id; ?>"><?= $compaign_id; ?></option>
                                    <?php }   ?>
                                </select>

                                <br><br>
                                <div id="valuesBox"></div>

                                <script>
                                function addValue() {
                                    var selectBox = document.getElementById("add_subject");
                                    var selectedIndex = selectBox.selectedIndex;
                                    var selectedValue = selectBox.options[selectedIndex].value;

                                    // Add the selected value to the box
                                    var valuesBox = document.getElementById("valuesBox");
                                    var newElement = document.createElement("div");
                                    newElement.className = "value-item";
                                    newElement.textContent = selectedValue;

                                    var removeIcon = document.createElement("span");
                                    removeIcon.className = "remove-icon";
                                    removeIcon.textContent = "✖";
                                    removeIcon.onclick = function() {
                                        removeValue(newElement, selectedValue);
                                    };

                                    newElement.appendChild(removeIcon);
                                    valuesBox.appendChild(newElement);

                                    // Remove the selected option from the dropdown
                                    selectBox.remove(selectedIndex);
                                }

                                function removeValue(element, value) {
                                    var selectBox = document.getElementById("add_subject");

                                    // Re-add the option to the dropdown
                                    var newOption = document.createElement("option");
                                    newOption.value = value;
                                    newOption.text = value;
                                    selectBox.add(newOption);

                                    // Remove the element from the valuesBox
                                    element.remove();
                                }
                                </script>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="campaign_description">Campaign Name</label>
                            </div>

                        </div>

                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">

                                <input type="password" class="form-control" id="password_new" name="password_new"
                                    aria-describedby="password" required>
                                <label for="password">password</label>
                            </div>
                        </div>

                        <div class="my-dropdown-with-help col-6">
                            <div class="my-dropdown">
                                <select name="user_lable_new" id="user_lable_new">
                                    <option value="1">Agent</option>
                                    <option value="8">Admin</option>
                                </select>

                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="campaign_description">Select User Type</label>
                            </div>

                        </div>

                        <div class="my-dropdown-with-help col-6">
                            <div class="my-dropdown">
                                <select name="user_priority" id="user_priority">
                                    <?php
    $tfnsel_pri = "SELECT * FROM users WHERE admin='$Adminuser'";
    $data_pri = mysqli_query($con, $tfnsel_pri);

    while ($row_pri = mysqli_fetch_array($data_pri)) {
      $selected = (isset($selectedPriority) && $selectedPriority == $row_pri['agent_priorty']) ? 'selected' : '';
      ?>
                                    <option value="<?= $row_pri['agent_priorty'] ?>" <?= $selected ?>>
                                        <?= $row_pri['agent_priorty'] ?></option>
                                    <?php
    }
  ?>
                                </select>


                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="campaign_description">Select Agent priority</label>
                            </div>

                        </div>
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">
                                <input type="int" class="form-control" id="new_ext_number" name="external_num"
                                    aria-describedby="external_num"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                    maxlength="10">
                                <label for="Extername Number">External Number</label>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary my-btn-secondary" data-dismiss="modal">Cancel
                    </button>
                    <input class="my-btn-primary" type="submit" value="submit" name="update_user" onclick="saveData()">
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Add user name for user id modal ends here -->
<!-- Your modal HTML code -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $(document).on("click", ".contact_add", function() {
        var cnumber = $(this).data("user_id");

        // Clear the fields before making the request
        $("#c_number").val("");
        $("#edit_name_c").val("");
        $("#use_did").val("");
        $("#password_new").val("");
        // $("#valuesBox").val("");
        $("#user_lable_new").val("");
        $("#user_priority").val("");
        $("#new_ext_number").val("");

        $.ajax({
            url: "pages/user/get_name.php",
            type: "POST",
            data: {
                cnumber: cnumber
            },
            dataType: "json",
            success: function(response) {
                if (response.error) {
                    alert(response.error);
                } else {
                    // Populate the fields with the response
                    $("#c_number").val(response.user_id);
                    $("#edit_name_c").val(response.full_name);
                    $("#use_did").val(response.use_did);
                    $("#password_new").val(response.password);
                    $("#valuesBox").val(response.campaigns_id);
                    $("#user_lable_new").val(response.user_type);
                    $("#user_priority").val(response.agent_priorty);
                    $("#new_ext_number").val(response.ext_number);
                    // $("#Organization_new").val(response.CAMPAIGN);

                    // alert(response.admin); // Show the alert box
                }
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    });
});
</script>

</script>
<script>
$(document).ready(function() {
    // Add an event listener to the Close button
    $("#closeModalButton").on("click", function() {
        // Find the modal and close it
        $("#staticBackdrop").modal("hide");
    });
});
</script>
<script>
$(document).ready(function() {
    $(document).on("click", ".show_break_report", function() {
        // $(document).on("click", ".agent_dashboard.php", function() {
        var user_id = $(this).data("user_id");
        // Assuming you want to redirect to another page
        // window.location.href = "?c=user&v=user_break_status&user_id=" + user_id;
        window.location.href = "?c=user&v=agent_dashboard&user_id=" + user_id;
    });
});
</script>
<script>
function saveData() {
    var formData = new FormData(document.getElementById('myForm_insert_data'));

    // Collect values from valuesBox
    var valuesBox = document.getElementById('valuesBox');
    var valueItems = valuesBox.getElementsByClassName('value-item');
    var values = [];
    for (var i = 0; i < valueItems.length; i++) {
        values.push(valueItems[i].textContent.replace('✖', '').trim());
    }

    // Add the values to the formData
    formData.append('selected_values', JSON.stringify(values));

    $.ajax({
        type: 'POST',
        url: "pages/user/user_update.php", // Replace with the actual server-side file to handle data insertion
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            // alert(response);

            // console.log(response);

            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Your data has been saved",
                showConfirmButton: false,
                timer: 1500
            });
        },
        error: function(error) {
            alert('sorry');
            Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Your data is not inserted",
                showConfirmButton: false,
                timer: 1500
            });
        }
    });
}
</script>
<script>
$(document).ready(function() {
    $(document).on("click", ".remove_user", function() {
        var user_id = $(this).data("user_id");
        var user_priorty = $(this).data("user_priorty");

        Swal.fire({
            title: "Are you sure?",
            text: "This data will be deleted",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href =
                    `pages/new_action/agent_user_delete.php?user_id=${user_id}&user_priorty=${user_priorty}`;
            }
        });
    });
});
</script>