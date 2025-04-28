<?php
session_start();
$user_level = $_SESSION['user_level'];



if ($user_level == 7 || $user_level == 6 || $user_level == 2) {
    $Adminuser = $_SESSION['admin'];
    $new_user = $_SESSION['user'];
    $new_campaign = $_SESSION['campaign_id'];
} else {
    $Adminuser = $_SESSION['user'];
}


require '../include/user.php';
include "../../../conf/db.php";
include "../../../conf/url_page.php";
include "../../../conf/Get_time_zone.php";

// echo $Local_ip;

// die();

$user = new user();

// $user = $Adminuser;


$usersql = "Select user,user_id, full_name, user_level, user_group, active from vicidial_users";

// $usersql2 = "SELECT * FROM `users` WHERE admin='$Adminuser' AND user_id!='$Adminuser'"; 
if ($user_level == 2 ) {
    $usersql2 = "SELECT * FROM `users` WHERE admin='$Adminuser' AND user_type !='2' AND campaigns_id='$new_campaign' AND user_type != '8'";
} elseif ($user_level == 7) {
    $usersql2 = "SELECT * FROM `users` WHERE admin='$Adminuser' AND user_id!='$Adminuser' AND user_id!='$new_user'";
}elseif ($user_level == 9) {
    $Sql_Get_admin = "SELECT admin FROM `users` WHERE SuperAdmin = '$Adminuser' AND user_type = '8'";
    $get_query = mysqli_query($con, $Sql_Get_admin);

    $Get_admin = [];
    while ($user_row = mysqli_fetch_assoc($get_query)) {
        $Get_admin[] = $user_row['admin'];
    }

        $admin_ids_str = "'" . implode("','", $Get_admin) . "'";
        $usersql2 = "SELECT * FROM `users` WHERE admin IN ($admin_ids_str) ORDER BY id DESC";
} else {
    $usersql2 = "SELECT * FROM `users` WHERE admin='$Adminuser' AND user_id!='$Adminuser'";
}

// echo $usersql2;
// die();
$usersresult = mysqli_query($con, $usersql2);


$eUser = "";
$full_name = "";
// $user_level = "";
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
    $user->template = $_POST['calling_temp'];
    $date = date("Y-m-d h:i:s");

    if (isset($user->template) && !empty($user->template)) {
        $temp_id = $user->template;
    } else {
        $temp_id = 'telephony';
    }

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
                                icon: "error",
                                title: "This extension already created phone",
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.onmouseenter = Swal.stopTimer;
                                    toast.onmouseleave = Swal.resumeTimer;
                                }
                            }).then(() => {
            window.location.href = "' . $admin_ind_page . '?c=user&v=user_list";
        });
        </script>';
    } elseif (mysqli_num_rows($quer_check_vici) > 0) {
        // echo "<script>alert('Data is already Inserted');</script>";
        echo '
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
    
        <script>
         Swal.fire({
                                icon: "error",
                                title: "This extension already created phone",
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.onmouseenter = Swal.stopTimer;
                                    toast.onmouseleave = Swal.resumeTimer;
                                }
                            }).then(() => {
            window.location.href = "' . $admin_ind_page . '?c=user&v=user_list";
        });
        </script>';
    } else {

        // $data_ins="INSERT INTO `did_list`(`did`, `user`, `extension`, `status`) VALUES ('".$user->use_did."','".$user->user."','".$user->user."','1')";
        // mysqli_query($con, $data_ins);


        $sql = "INSERT INTO vicidial_users (user, full_name, user_level, user_group, pass) VALUES ('" . $user->user . "','" . $user->full_name . "','" . $user->user_level . "','" . $user->user_group . "','" . $user->pass . "')";
        mysqli_query($conn, $sql);
        // echo "<br>";

        // $sql_vcd="INSERT INTO `phones`(`extension`, `dialplan_number`, `voicemail_id`, `login`, `pass`, `active`, `phone_type`, `fullname`, `company`) VALUES ('".$user->user."','".$user->user."','".$user->user."','".$user->user."','".$user->pass."','Y','VICIDIAL','".$user->full_name."','".$user->org."')";
        $phone_ins = "INSERT INTO phones (extension, dialplan_number, voicemail_id, phone_ip, computer_ip, server_ip, login, pass, status, active, phone_type, fullname, company, picture, messages, old_messages, protocol, local_gmt, ASTmgrUSERNAME, ASTmgrSECRET, login_user, login_pass, login_campaign, park_on_extension, conf_on_extension, VICIDIAL_park_on_extension, VICIDIAL_park_on_filename, monitor_prefix, recording_exten, voicemail_exten, voicemail_dump_exten, ext_context, dtmf_send_extension, call_out_number_group, client_browser, install_directory, local_web_callerID_URL, VICIDIAL_web_URL, AGI_call_logging_enabled, user_switching_enabled, conferencing_enabled, admin_hangup_enabled, admin_hijack_enabled, admin_monitor_enabled, call_parking_enabled, updater_check_enabled, AFLogging_enabled, QUEUE_ACTION_enabled, CallerID_popup_enabled, voicemail_button_enabled, enable_fast_refresh, fast_refresh_rate, enable_persistant_mysql, auto_dial_next_number, VDstop_rec_after_each_call, DBX_server, DBX_database, DBX_user, DBX_pass, DBX_port, DBY_server, DBY_database, DBY_user, DBY_pass, DBY_port, outbound_cid, enable_sipsak_messages, email, template_id, conf_override, phone_context, phone_ring_timeout, conf_secret, delete_vm_after_email, is_webphone, use_external_server_ip, codecs_list, codecs_with_template, webphone_dialpad, on_hook_agent, webphone_auto_answer, voicemail_timezone, voicemail_options, user_group, voicemail_greeting, voicemail_dump_exten_no_inst, voicemail_instructions, on_login_report, unavail_dialplan_fwd_exten, unavail_dialplan_fwd_context, nva_call_url, nva_search_method, nva_error_filename, nva_new_list_id, nva_new_phone_code, nva_new_status, webphone_dialbox, webphone_mute, webphone_volume, webphone_debug, outbound_alt_cid, conf_qualify, webphone_layout, mohsuggest, peer_status, ping_time, webphone_settings) VALUES
    ('" . $user->user . "', '" . $user->user . "', '" . $user->user . "', '10.101.1.16', '10.101.1.16', '" . $Local_ip . "', '" . $user->user . "', '" . $user->pass . "', 'ACTIVE', 'Y', '" . $user->user . "', '" . $user->user . "', '', '', 0, 0, 'SIP', '-5.00', 'cron', '1234', '', '', '', '8301', '8302', '8301', 'park', '8612', '8309', '8501', '85026666666666', 'default', 'local/8500998@default', 'Zap/g2/', '/usr/bin/mozilla', '/usr/local/perl_TK', 'http://www.vicidial.org/test_callerid_output.php', '', '1', '1', '1', '0', '0', '1', '1', '1', '1', '1', '1', '1', '0', 1000, '0', '1', '1', '', 'asterisk', 'cron', '1234', 3306, '', 'asterisk', 'cron', '1234', 3306, '" . $user->user . "', '0', '', '" . $temp_id . "', '', 'default', 60, '" . $user->pass . "', 'N', 'Y', 'N', '', '0', 'Y', 'N', 'Y', 'eastern', '', 'winet', '', '85026666666667', 'Y', 'N', '', '', '', 'NONE', '', 995, '1', 'NVAINS', 'Y', 'Y', 'Y', 'Y', '', 'Y', '', '', 'REACHABLE', 27, 'VICIPHONE_SETTINGS')";
        mysqli_query($conn, $phone_ins);


        $stmtA = "UPDATE servers SET rebuild_conf_files='Y' where generate_vicidial_conf='Y' and active_asterisk_server='Y' and server_ip='" . $Local_ip . "'";
        // $rslt=mysql_to_mysqli($stmtA, $link);
        mysqli_query($conn, $stmtA);
        // echo "<br>";

        // $select_pr = "SELECT agent_priorty FROM users WHERE admin='$Adminuser' ORDER BY agent_priorty DESC LIMIT 1";
        $select_pr = "SELECT MAX(CAST(agent_priorty AS UNSIGNED)) AS highest_priority 
FROM users
WHERE admin='$Adminuser'";
        $sel_query_pr = mysqli_query($con, $select_pr);
        $pr_row = mysqli_fetch_assoc($sel_query_pr);
        if (!empty($pr_row['highest_priority'])) {
            $priority = $pr_row['highest_priority'] + 1;
        } else {
            $priority = 1;
        }

        if ($user->user_level == '1') {
            $new_priority = $priority;
        } else {
            $new_priority = '';
        }

        $sql2 = "INSERT INTO `users`(`admin`, `user_id`, `password`, `full_name`, `status`, `campaigns_id`, `ins_date`, `use_did`, `user_type`, `agent_priorty`, `ext_number`) VALUES ('$Adminuser', '" . $user->user . "','" . $user->pass . "','" . $user->full_name . "','Y', '" . $user->use_campaign . "', '$date', '" . $user->use_did . "', '" . $user->user_level . "', '$new_priority', '" . $user->external_num . "')";


        $query_ins = mysqli_query($con, $sql2);

        //    echo "<br>";
// die();
        if ($query_ins) {
            //    echo "<script>alert('Okey. data insert successfull')</script>";
            echo '
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
   
   <script>
   // var username = document.getElementById("floatingInput1").value;
   window.onload = function() {
        Swal.fire({
                                icon: "success",
                                title: "Create User is successful",
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.onmouseenter = Swal.stopTimer;
                                    toast.onmouseleave = Swal.resumeTimer;
                                }
                            }).then(() => {
                      window.location.href = "' . $admin_ind_page . '?c=user&v=user_list";
                });
   }
   </script>';
        } else {
            // echo "<script>alert('Sorry')</script>";

            echo '
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
    
    <script>
    // var username = document.getElementById("floatingInput1").value;
    window.onload = function() {
                 Swal.fire({
                                icon: "error",
                                title: "Data is not Inserted",
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.onmouseenter = Swal.stopTimer;
                                    toast.onmouseleave = Swal.resumeTimer;
                                }
                            }).then(() => {
        window.location.href = "' . $admin_ind_page . '?c=user&v=user_list";
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

    .data_btn3 {
        background: #ff4d4d;
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
    #password-feedback {
    font-size: 10px;
    font-weight: bold;
    margin-top: 15px;
    margin-right: 25px;
}
#password-update {
    font-size: 10px;
    font-weight: bold;
    margin-top: 15px;
    margin-right: 25px;
}
</style>
<style>
    /* Dropdown styling */
    /* .my-dropdown select {
        width: 100%;
        padding: 8px;
        font-size: 14px;
    } */

    /* Selected values styling */
    #valuesBox {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    .value-item {
        display: flex;
        align-items: center;
        background: #f4f4f4;
        padding: 8px 12px;
        margin: 5px 0;
        margin-top: 5px 5px 5px;
        border-radius: 5px;
        font-size: 14px;
        justify-content: space-between;
        transition: background 0.3s;
    }

    .value-item:hover {
        background: #e0e0e0;
    }

    /* Remove icon styling */
    .remove-icon {
        cursor: pointer;
        color: #ff0000;
        font-size: 16px;
        margin-left: 10px;
    }

    .remove-icon:hover {
        color: #d00000;
    }

</style>

<div>
    <div class="show-users ml-5">
        <div class="table-responsive my-table ml-5">
            <div class="table-top">
                <a class="data_btn" href="#add-user" data-toggle="modal" data-target="#add-user"><i
                        class="fa fa-plus-circle" aria-hidden="true"></i>
                    Add User</a>
                <?php if ($user_level != 9) { ?>
                    <a class="data_btn1" href="?c=user&v=user_break_status"><i class="fa fa-plus-circle"
                            title="You can click here to see why users take breaks"></i>
                        View User Break </a>
                    <a class="data_btn2" href="?c=user&v=user_login_report"><i class="fa fa-plus-circle"
                            title="Your User login and Logout reports"></i>
                        Login Report</a>
                    <a class="data_btn1" href="?c=user&v=all_agent_report&admin_user_id=<?php echo $Adminuser; ?>">
                        <i class="fa fa-plus-circle" title="You can click here to see All Agent Report And Stats"></i>
                        All Agent Report
                    </a>
                    <a class="data_btn3 logout_user">
                        <i class="fa fa-plus-circle"
                            title="Emergency Logout: Click this button to log out all users from the application instantly."></i>
                        Logout all Users
                    </a>
                <?php } ?>
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
                        <th scope="col"><a href="#">LOGIN STATUS</a></th>
                        <th scope="col"><a href="#">ACTION</a></th>

                    </tr>
                </thead>
                <tbody>
                    <?php

                    while ($usersrow = mysqli_fetch_array($usersresult)) {
                        $user_idi = $usersrow['user_id'];
                        echo '<tr>';
                        echo '<td>' . $usersrow['user_id'] . '</td>';
                        echo '<td>' . $usersrow['password'] . '</td>';
                        echo '<td>' . $usersrow['full_name'] . '</td>';
                        echo '<td>' . $usersrow['campaigns_id'] . '</td>';


                        ?>
                        <td>
                            <a href="pages/user/editstatus.php?id=<?= $usersrow['user_id'] ?>">
                                <?php
                                if ($usersrow['status'] == 'Y') {
                                    echo '<span class="active-yes cursor_p">' . 'Active' . '</span>';
                                } else {
                                    echo '<span class="active-no cursor_p">' . 'Inactive' . '</span>';
                                }
                                ?>
                            </a>

                        </td>

                        <td>
                            <?php

                            if ($usersrow['user_type'] == '1') {
                                echo '<span class="text-success ">' . 'Agent' . '</span>';
                            } elseif ($usersrow['user_type'] == '2') {
                                echo '<span class="text-info ">' . 'Team Leader' . '</span>';
                            } elseif ($usersrow['user_type'] == '6') {
                                echo '<span class="text-warning ">' . 'Quality Analyst' . '</span>';
                            }  elseif ($usersrow['user_type'] == '7') {
                                echo '<span class="text-primary">' . 'Manager' . '</span>';
                            } else {
                                echo '<span class="text-primary ">' . 'Admin' . '</span>';
                            }
                            ?>
                        </td>
                        <?php
                        echo '<td>' . $usersrow['agent_priorty'] . '</td>';

                        // echo '<td>' . $usersrow['user_type'] . '</td>';
                        $date_one = date("Y-m-d");


                        $use_geedata = "SELECT status FROM `login_log` WHERE user_name='$user_idi' AND log_in_time Like ('%$date_one%') ORDER BY `id` DESC";
                        // die();
                        $us_gresult = mysqli_query($con, $use_geedata);
                        $user_row_data = mysqli_fetch_assoc($us_gresult);
                        if ($user_row_data['status'] == '1') {
                            echo '<td><span class="active-yes cursor_p" title="This user Login ">' . 'Login' . '</span></td>';
                        } else {
                            echo '<td><span class="active-no cursor_p" title="This user Logout">' . 'Logout' . '</span></td>';
                        }

                        // echo '<td>' . $user_row_data['status'] . '</td>';
                        ?>
                        <td>
                            <!-- <span class="badge bg-info cursor_p text-white contact_add"
                            data-user_id="<?Php echo $usersrow['user_id']; ?>" data-toggle="modal"
                            data-target="#edit_user" title="Click here and Edit user ">Edit</span> -->

                            <a class='contact_add text-primary cursor_p' data-user_id="<?Php echo $usersrow['user_id']; ?>"
                                data-toggle="modal" data-target="#edit_user" title="Click here and Edit user "><i
                                    class="fa fa-pencil-square" style="font-size:20px;"></i></a>

                            <!-- <span class="badge bg-primary cursor_p text-white show_break_report"
                            data-user_id="<?Php echo $usersrow['user_id']; ?>"
                            title="You can click here to see why users take breaks">View</span> -->

                            <a class='show_break_report text-info text-primary cursor_p'
                                data-user_id="<?Php echo $usersrow['user_id']; ?>"
                                title="You can click here to see why users take breaks"><i class="fa fa-eye"
                                    style="font-size:20px;;"></i></a>

                            <!-- <span class="badge bg-danger cursor_p text-white remove_user"
                            data-user_id="<?Php echo $usersrow['user_id']; ?>"
                            data-user_priorty="<?Php echo $usersrow['agent_priorty']; ?>"
                            title="You can click here and Delete this Users">Remove</span> -->
                            <i class="fa fa-sign-out cursor_p text-warning user_logout_user mb-2" style="font-size:20px;"
                                data-user_id="<?Php echo $usersrow['user_id']; ?>"
                                data-user_priorty="<?Php echo $usersrow['agent_priorty']; ?>"
                                title="You can click here and Delete this Users"></i>

                            <i class="fa fa-trash cursor_p text-danger remove_user mb-2" style="font-size:20px;"
                                data-user_id="<?Php echo $usersrow['user_id']; ?>"
                                data-user_priorty="<?Php echo $usersrow['agent_priorty']; ?>"
                                title="You can click here and Delete this Users"></i>
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
                        <?php if ($user_level == 2): ?>
    <div class="my-input-with-help col-6">
        <div class="form-group my-input">
            <input type="text" class="form-control" name="use_campaign" id="use_campaign" value="<?= $new_campaign ?>" aria-describedby="campaign_description" readonly>
            <label for="campaign_description">Campaign Name</label>
        </div>
    </div>
<?php else: ?>
    <div class="my-dropdown-with-help col-6">
        <div class="my-dropdown">
            <select name="use_campaign" id="use_campaign">
                <option></option>
                <?php
                $query = ($user_level != 9)
                    ? "SELECT * FROM `compaign_list` WHERE admin='$Adminuser' ORDER BY id DESC"
                    : "SELECT * FROM `compaign_list` WHERE admin IN ($admin_ids_str) ORDER BY id DESC";
                $result = mysqli_query($con, $query);
                while ($row = mysqli_fetch_assoc($result)):
                ?>
                    <option value="<?= $row['compaign_id']; ?>"><?= $row['compaignname']; ?></option>
                <?php endwhile; ?>
            </select>
            <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
            <label for="campaign_description">Campaign Name</label>
        </div>
    </div>
<?php endif; ?>
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
                                    aria-describedby="password" maxlength="15" required
                                    oninput="validatePassword(this)">
                                <label for="password">password</label>
                                <span id="password-feedback" class="form-text text-danger" style="display: none;">
            Password must be 12 to 15 characters long and contain only letters and numbers. Special characters are not allowed.
        </span>
                            </div>

                        </div>
                        <script>
    function validatePassword(input) {
        const feedback = document.getElementById('password-feedback');
        // Remove special characters and update input value 
        input.value = input.value.replace(/[^A-Za-z0-9]/g, '');

        // Validate password length
        if (input.value.length < 12 || input.value.length > 15) {
            feedback.style.display = 'block'; // Show error message
        } else {
            feedback.style.display = 'none'; // Hide error message
        }
    }
</script>
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
            <?php
            $userOptions = [
                8 => ['1' => 'Agent', '6' => 'Quality Analyst', '2' => 'Team Leader', '7' => 'Manager'],
                7 => ['1' => 'Agent', '6' => 'Quality Analyst', '2' => 'Team Leader'],
                2 => ['1' => 'Agent', '6' => 'Quality Analyst'],
                'default' => ['1' => 'Agent'],
            ];
            $options = $userOptions[$user_level] ?? $userOptions['default'];
            foreach ($options as $value => $label):
            ?>
                <option value="<?= $value; ?>"><?= $label; ?></option>
            <?php endforeach; ?>
        </select>
        <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
        <label for="campaign_description">Select User Type</label>
    </div>
</div>
<div class="my-dropdown-with-help col-6">
    <div class="my-dropdown">
        <select name="calling_temp" id="calling_temp">
        <option value="telephony">telephony</option> 
                <!-- <option value="tele_Sahil_UK_Calling">UK_call</option>
                <option value="telephony_Sahil">USA_call</option> -->
        </select>
        <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
        <label for="calling_template">Select Template Type</label>
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
                                    if ($user_level != 9) {
                                        $sel_check_one = "SELECT * FROM `compaign_list` WHERE admin='$Adminuser' ORDER BY id DESC";
                                    } else {
                                        $sel_check_one = "SELECT * FROM `compaign_list` ORDER BY id DESC";
                                    }
                                    $quer_check_one = mysqli_query($con, $sel_check_one);
                                    while ($row_one = mysqli_fetch_assoc($quer_check_one)) {
                                        $campaign_name = $row_one['compaignname'];
                                        $compaign_id = $row_one['compaign_id'];

                                        ?>
                                        <option value="<?= $compaign_id; ?>"><?= $compaign_id; ?></option>
                                    <?php } ?>
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
                                        removeIcon.onclick = function () {
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
                                    aria-describedby="password" required
                                    oninput="this.value = this.value.replace(/[^a-zA-Z0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                    maxlength="15">
                                <label for="password">password</label>
                            </div>
                        </div>

                        <?php
$userOptions = [
    8 => ['1' => 'Agent', '6' => 'Quality Analyst', '2' => 'Team Leader', '7' => 'Manager'],
    7 => ['1' => 'Agent', '6' => 'Quality Analyst', '2' => 'Team Leader'],
    2 => ['1' => 'Agent', '6' => 'Quality Analyst'],
    'default' => ['1' => 'Agent'],
];
$options = $userOptions[$user_level] ?? $userOptions['default'];
?>

<div class="my-dropdown-with-help col-6">
    <div class="my-dropdown">
        <select name="user_lable_new" id="user_lable_new">
            <?php foreach ($options as $value => $label): ?>
                <option value="<?= $value; ?>"><?= $label; ?></option>
            <?php endforeach; ?>
        </select>
        <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
        <label for="campaign_description">Select User Type (New)</label>
    </div>
</div>


                       <div class="my-dropdown-with-help col-6"> 
    <div class="my-dropdown">
        <select name="user_priority" id="user_priority">
            <?php
            // Query to fetch only users with non-empty agent_priorty
            $tfnsel_pri = "SELECT * FROM users WHERE admin='$Adminuser' AND (agent_priorty IS NOT NULL AND agent_priorty != '')";
            $data_pri = mysqli_query($con, $tfnsel_pri);

            while ($row_pri = mysqli_fetch_array($data_pri)) {
                // Check if the current priority matches the selected priority
                $selected = (isset($selectedPriority) && $selectedPriority == $row_pri['agent_priorty']) ? 'selected' : '';
                ?>
                <option value="<?= $row_pri['agent_priorty'] ?>" <?= $selected ?>>
                    <?= $row_pri['agent_priorty'] ?>
                </option>
                <?php
            }
            ?>
        </select>

        <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
        <label for="campaign_description">Select Agent Priority</label>
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

                        <div class="my-dropdown-with-help col-6">
    <div class="my-dropdown">
        <select name="calling_temp" id="calling_temp">
        <!-- <option></option>  -->
        <option value="telephony">telephony</option> 
                <!-- <option value="tele_Sahil_UK_Calling">UK_call</option>
                <option value="telephony_Sahil">USA_call</option> -->
        </select>
        <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
        <label for="calling_template">Select Template Type</label>
    </div>
</div>


                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary my-btn-secondary" data-dismiss="modal">Cancel
                    </button>
                    <button type="button" class="btn btn-primary my-btn-primary" onclick="saveData()">Submit</button>
                    <!-- <input class="my-btn-primary" type="submit" value="submit" name="update_user" onclick="saveData()"> -->
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
$(document).ready(function () {
    $(document).on("click", ".contact_add", function () {
        var cnumber = $(this).data("user_id");

        // Clear the fields before making the request
        $("#c_number").val("");
        $("#edit_name_c").val("");
        $("#use_did").val("");
        $("#password_new").val("");
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
            success: function (response) {
                if (response.error) {
                    alert(response.error);
                } else {
                    // Populate the fields with the response
                    $("#c_number").val(response.user_id);
                    $("#edit_name_c").val(response.full_name);
                    $("#use_did").val(response.use_did);
                    $("#password_new").val(response.password);
                    $("#user_lable_new").val(response.user_type);
                    $("#new_ext_number").val(response.ext_number);

                    // Check if priority is available, then set it
                    if (response.agent_priorty && response.agent_priorty !== "") {
                        $("#user_priority").val(response.agent_priorty);
                    } else {
                        // Remove the priority if not available
                        $("#user_priority").val("");
                    }
                }
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    });
});

</script>
<script>
    $(document).ready(function () {
        // Add an event listener to the Close button
        $("#closeModalButton").on("click", function () {
            // Find the modal and close it
            $("#staticBackdrop").modal("hide");
        });
    });
</script>
<script>
    $(document).ready(function () {
        $(document).on("click", ".show_break_report", function () {
            // $(document).on("click", ".agent_dashboard.php", function() {
            var user_id = $(this).data("user_id");
            // Assuming you want to redirect to another page
            // window.location.href = "?c=user&v=user_break_status&user_id=" + user_id;
            window.location.href = "?c=user&v=all_agent_report&admin_user_id=" + user_id;
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
            success: function (response) {
                // alert(response);

                // console.log(response);

                Swal.fire({
                                icon: "success",
                                title: "Your data Successfully Updated",
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.onmouseenter = Swal.stopTimer;
                                    toast.onmouseleave = Swal.resumeTimer;
                                }
                            }).then(() => {
                        // Close the modal programmatically
                        $('#edit_user').modal('hide');
                        $('#edit_user').find('form')[0].reset(); 
                    });
            },
            error: function (error) {
                // alert('sorry');
                Swal.fire({
                                icon: "error",
                                title: response || "An error occurred while sending Emails",
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.onmouseenter = Swal.stopTimer;
                                    toast.onmouseleave = Swal.resumeTimer;
                                }
                            });
                // Swal.fire({
                //     position: "top-end",
                //     icon: "error",
                //     title: "Your data is not inserted",
                //     showConfirmButton: false,
                //     timer: 1500
                // });
            }
        });
    }
    // https://192.168.125.241/Telephony/admin/pages/new_action/agent_user_delete.php
</script>
<script>
    $(document).ready(function () {
        $(document).on("click", ".remove_user", function () {
            var user_id = $(this).data("user_id");
            var user_priorty = $(this).data("user_priorty");

            // alert(user_id);
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

<script>
    $(document).ready(function () {
        // Event listener for the logout button click
        $(document).on("click", ".logout_user", function (e) {
            e.preventDefault(); // Prevent default action

            // Show an alert box
            // alert('ok');

            // SweetAlert confirmation dialog
            Swal.fire({
                title: "Are you sure?",
                text: "All users will be logged out.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Logout"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to the logout page
                    window.location.href = `pages/user/user_logout.php`;
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function () {
        // Event listener for the logout button click
        $(document).on("click", ".user_logout_user", function (e) {
            e.preventDefault(); // Prevent default action

            // Retrieve data attributes
            var user_id = $(this).data("user_id");

            // Show an alert box with user ID
            // alert(user_id);

            // SweetAlert confirmation dialog
            Swal.fire({
                title: "Are you sure?",
                text: "This will log out the selected user.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Logout"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to the logout page
                    window.location.href = `pages/user/user_swise_logout.php?user_id=${user_id}`;
                }
            });
        });
    });
</script>