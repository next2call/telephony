<?php
session_start();
$Adminuser = $_SESSION['user'];
require '../include/user.php';

$user = new user();
// $user = $Adminuser;
$usersql = "Select user,user_id, full_name, user_level, user_group, active from vicidial_users";
 
$usersql2 = "SELECT * FROM `compaignlist` WHERE admin='$Adminuser'"; 

// die();
$usersresult = mysqli_query($con, $usersql2);


$eUser = "";
$full_name = "";
$user_level = "";
$user_group = "";
$pass = "";
$error = 0;

// if (isset($_POST['add_user'])) {
//     $disposition = $_POST['disposition'];
//     $status= '1';
//     $date = date("Y-M-d");
//     // Query to check if user exists in 'users' table
//     // $user_id = $user->user;
//     $sel_check = "SELECT dispo FROM `dispo` WHERE dispo='$disposition'";
//     $quer_check = mysqli_query($con, $sel_check);
    
//     if (!$quer_check) {
//         die('Error with query: ' . mysqli_error($con));
//     }
    

//     if (mysqli_num_rows($quer_check) > 0) {
//         // echo "<script>alert('Data is already Inserted');</script>";
//         echo '
//         <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
//         <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
    
//         <script>
//         Swal.fire({
//             position: "top-end",
//             icon: "error",
//             title: "This Disposition has already been created !",
//             showConfirmButton: false,
//             timer: 1500
//         });
//         </script>';
//     } else{

//         // $data_ins="INSERT INTO `did_list`(`did`, `user`, `extension`, `status`) VALUES ('".$user->use_did."','".$user->user."','".$user->user."','1')";
//         $data_ins="INSERT INTO `dispo`(`dispo`, `admin`, `ins_date`, `status`) VALUES ('$disposition','$Adminuser','$date','$status')";
//        $query_ins = mysqli_query($con, $data_ins);
// // die();
//    if($query_ins){
// //    echo "<script>alert('Okey. data insert successfull')</script>";
//    echo '
//    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
//    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
   
//    <script>
//    // var username = document.getElementById("floatingInput1").value;
//    window.onload = function() {
//      Swal.fire({
//        title: "Add Disposition ",
//        text: "Add Disposition is successful.",
//        icon: "success",
//        confirmButtonText: "OK"
//      });
//    }
//    </script>';
//    }else{
//     // echo "<script>alert('Sorry')</script>";

//     echo '
//     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
//     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
    
//     <script>
//     // var username = document.getElementById("floatingInput1").value;
//     window.onload = function() {
//       Swal.fire({
//         title: "Failed",
//         text: "Sorry, Data is not Inserted!",
//         icon: "error",
//         confirmButtonText: "OK"
//       });
//     }
//     </script>';
//    }

// }
// } else {
//     $user->user = "";
//     $user->full_name = "";
//     $user->user_level = "";
//     $user->user_group = "";
//     $user->pass = "";
// }



if (isset($_POST['new_camp_add'])) {
     $com_name = $_POST['camp_name'];
     $remote_agent = '7690';
    // die();
    $com_id = $_POST['camp_id'];
    $info = '1';
    $camp_status = "1";
    // $camp_admin = $_POST['user_name'];
    $camp_admin = $Adminuser;
    $type = 'Domestic';
    $did = '1234';

        $dial_perefix = "8899";
        $con_ext = "689679";
    
    // $date = date('Y-m-d');
    $date = date('Y-m-d H:i:s');

    // echo '</br>';
    $select = "SELECT compaign_id FROM compaignlist WHERE compaign_id='$com_number'";
    $sel_query = mysqli_query($con, $select);
//   echo '</br>';
   $select1 = "SELECT * FROM vicidial_campaigns WHERE campaign_id='$com_id'";
    $sel_query1 = mysqli_query($conn, $select1);
  
    // die();

    if (mysqli_num_rows($sel_query1) > 0) {
      echo '
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
      
      <script>
      // var username = document.getElementById("floatingInput1").value;
      window.onload = function() {
        Swal.fire({
          title: "Failed",
          text: "Sorry, this Campain Id already exists",
          icon: "error",
          confirmButtonText: "OK"
        });
      }
      </script>';
    } else {
  
         $ins_remote_agent = "INSERT INTO `vicidial_remote_agents` (`remote_agent_id`, `user_start`, `number_of_lines`, `server_ip`, `conf_exten`, `status`, `campaign_id`, `closer_campaigns`, `extension_group`, `extension_group_order`, `on_hook_agent`, `on_hook_ring_time`) VALUES
         ('$remote_agent', '8848', 1, '192.168.125.241', '8848', 'ACTIVE', '$com_name', ' AGENTDIRECT AGENTDIRECT_CHAT winet -', 'NONE', 'NONE', 'N', 15)";
          mysqli_query($conn, $ins_remote_agent);


         $ins = "INSERT INTO compaignlist (compaignname, compaign_id, creat_date, status, admin, ivr, type) VALUES ('$com_name', '$com_id', '$date', '$camp_status', '$camp_admin', '$info', '$type')";
        $query = mysqli_query($con, $ins);

        $ins_camp = "INSERT INTO `vicidial_campaigns` (`campaign_id`, `campaign_name`, `active`, `dial_status_a`, `dial_status_b`, `dial_status_c`, `dial_status_d`, `dial_status_e`, `lead_order`, `park_ext`, `park_file_name`, `web_form_address`, `allow_closers`, `hopper_level`, `auto_dial_level`, `next_agent_call`, `local_call_time`, `voicemail_ext`, `dial_timeout`, `dial_prefix`, `campaign_cid`, `campaign_vdad_exten`, `campaign_rec_exten`, `campaign_recording`, `campaign_rec_filename`, `campaign_script`, `get_call_launch`, `am_message_exten`, `amd_send_to_vmx`, `xferconf_a_dtmf`, `xferconf_a_number`, `xferconf_b_dtmf`, `xferconf_b_number`, `alt_number_dialing`, `scheduled_callbacks`, `lead_filter_id`, `drop_call_seconds`, `drop_action`, `safe_harbor_exten`, `display_dialable_count`, `wrapup_seconds`, `wrapup_message`, `closer_campaigns`, `use_internal_dnc`, `allcalls_delay`, `omit_phone_code`, `dial_method`, `available_only_ratio_tally`, `adaptive_dropped_percentage`, `adaptive_maximum_level`, `adaptive_latest_server_time`, `adaptive_intensity`, `adaptive_dl_diff_target`, `concurrent_transfers`, `auto_alt_dial`, `auto_alt_dial_statuses`, `agent_pause_codes_active`, `campaign_description`, `campaign_changedate`, `campaign_stats_refresh`, `campaign_logindate`, `dial_statuses`, `disable_alter_custdata`, `no_hopper_leads_logins`, `list_order_mix`, `campaign_allow_inbound`, `manual_dial_list_id`, `default_xfer_group`, `xfer_groups`, `queue_priority`, `drop_inbound_group`, `qc_enabled`, `qc_statuses`, `qc_lists`, `qc_shift_id`, `qc_get_record_launch`, `qc_show_recording`, `qc_web_form_address`, `qc_script`, `survey_first_audio_file`, `survey_dtmf_digits`, `survey_ni_digit`, `survey_opt_in_audio_file`, `survey_ni_audio_file`, `survey_method`, `survey_no_response_action`, `survey_ni_status`, `survey_response_digit_map`, `survey_xfer_exten`, `survey_camp_record_dir`, `disable_alter_custphone`, `display_queue_count`, `manual_dial_filter`, `agent_clipboard_copy`, `agent_extended_alt_dial`, `use_campaign_dnc`, `three_way_call_cid`, `three_way_dial_prefix`, `web_form_target`, `vtiger_search_category`, `vtiger_create_call_record`, `vtiger_create_lead_record`, `vtiger_screen_login`, `cpd_amd_action`, `agent_allow_group_alias`, `default_group_alias`, `vtiger_search_dead`, `vtiger_status_call`, `survey_third_digit`, `survey_third_audio_file`, `survey_third_status`, `survey_third_exten`, `survey_fourth_digit`, `survey_fourth_audio_file`, `survey_fourth_status`, `survey_fourth_exten`, `drop_lockout_time`, `quick_transfer_button`, `prepopulate_transfer_preset`, `drop_rate_group`, `view_calls_in_queue`, `view_calls_in_queue_launch`, `grab_calls_in_queue`, `call_requeue_button`, `pause_after_each_call`, `no_hopper_dialing`, `agent_dial_owner_only`, `agent_display_dialable_leads`, `web_form_address_two`, `waitforsilence_options`, `agent_select_territories`, `campaign_calldate`, `crm_popup_login`, `crm_login_address`, `timer_action`, `timer_action_message`, `timer_action_seconds`, `start_call_url`, `dispo_call_url`, `xferconf_c_number`, `xferconf_d_number`, `xferconf_e_number`, `use_custom_cid`, `scheduled_callbacks_alert`, `queuemetrics_callstatus_override`, `extension_appended_cidname`, `scheduled_callbacks_count`, `manual_dial_override`, `blind_monitor_warning`, `blind_monitor_message`, `blind_monitor_filename`, `inbound_queue_no_dial`, `timer_action_destination`, `enable_xfer_presets`, `hide_xfer_number_to_dial`, `manual_dial_prefix`, `customer_3way_hangup_logging`, `customer_3way_hangup_seconds`, `customer_3way_hangup_action`, `ivr_park_call`, `ivr_park_call_agi`, `manual_preview_dial`, `realtime_agent_time_stats`, `use_auto_hopper`, `auto_hopper_multi`, `auto_hopper_level`, `auto_trim_hopper`, `api_manual_dial`, `manual_dial_call_time_check`, `display_leads_count`, `lead_order_randomize`, `lead_order_secondary`, `per_call_notes`, `my_callback_option`, `agent_lead_search`, `agent_lead_search_method`, `queuemetrics_phone_environment`, `auto_pause_precall`, `auto_pause_precall_code`, `auto_resume_precall`, `manual_dial_cid`, `post_phone_time_diff_alert`, `custom_3way_button_transfer`, `available_only_tally_threshold`, `available_only_tally_threshold_agents`, `dial_level_threshold`, `dial_level_threshold_agents`, `safe_harbor_audio`, `safe_harbor_menu_id`, `survey_menu_id`, `callback_days_limit`, `dl_diff_target_method`, `disable_dispo_screen`, `disable_dispo_status`, `screen_labels`, `status_display_fields`, `na_call_url`, `survey_recording`, `pllb_grouping`, `pllb_grouping_limit`, `call_count_limit`, `call_count_target`, `callback_hours_block`, `callback_list_calltime`, `user_group`, `hopper_vlc_dup_check`, `in_group_dial`, `in_group_dial_select`, `safe_harbor_audio_field`, `pause_after_next_call`, `owner_populate`, `use_other_campaign_dnc`, `allow_emails`, `amd_inbound_group`, `amd_callmenu`, `survey_wait_sec`, `manual_dial_lead_id`, `dead_max`, `dead_max_dispo`, `dispo_max`, `dispo_max_dispo`, `pause_max`, `max_inbound_calls`, `manual_dial_search_checkbox`, `hide_call_log_info`, `timer_alt_seconds`, `wrapup_bypass`, `wrapup_after_hotkey`, `callback_active_limit`, `callback_active_limit_override`, `allow_chats`, `comments_all_tabs`, `comments_dispo_screen`, `comments_callback_screen`, `qc_comment_history`, `show_previous_callback`, `clear_script`, `cpd_unknown_action`, `manual_dial_search_filter`, `web_form_address_three`, `manual_dial_override_field`, `status_display_ingroup`, `customer_gone_seconds`, `agent_display_fields`, `am_message_wildcards`, `manual_dial_timeout`, `routing_initiated_recordings`, `manual_dial_hopper_check`, `callback_useronly_move_minutes`, `ofcom_uk_drop_calc`, `manual_auto_next`, `manual_auto_show`, `allow_required_fields`, `dead_to_dispo`, `agent_xfer_validation`, `ready_max_logout`, `callback_display_days`, `three_way_record_stop`, `hangup_xfer_record_start`, `scheduled_callbacks_email_alert`, `max_inbound_calls_outcome`, `manual_auto_next_options`, `agent_screen_time_display`, `next_dial_my_callbacks`, `inbound_no_agents_no_dial_container`, `inbound_no_agents_no_dial_threshold`, `cid_group_id`, `pause_max_dispo`, `script_top_dispo`, `dead_trigger_seconds`, `dead_trigger_action`, `dead_trigger_repeat`, `dead_trigger_filename`, `dead_trigger_url`, `scheduled_callbacks_force_dial`, `scheduled_callbacks_auto_reschedule`, `scheduled_callbacks_timezones_container`, `three_way_volume_buttons`, `callback_dnc`, `manual_dial_validation`, `mute_recordings`, `auto_active_list_new`, `call_quota_lead_ranking`, `call_quota_process_running`, `call_quota_last_run_date`, `sip_event_logging`, `campaign_script_two`, `leave_vm_no_dispo`, `leave_vm_message_group_id`, `dial_timeout_lead_container`, `amd_type`, `vmm_daily_limit`, `opensips_cid_name`, `amd_agent_route_options`, `browser_alert_sound`, `browser_alert_volume`, `three_way_record_stop_exception`, `pause_max_exceptions`, `hopper_drop_run_trigger`, `daily_call_count_limit`, `daily_limit_manual`, `transfer_button_launch`, `shared_dial_rank`, `agent_search_method`, `qc_scorecard_id`, `qc_statuses_id`, `clear_form`, `leave_3way_start_recording`, `leave_3way_start_recording_exception`, `calls_waiting_vl_one`, `calls_waiting_vl_two`, `calls_inqueue_count_one`, `calls_inqueue_count_two`, `in_man_dial_next_ready_seconds`, `in_man_dial_next_ready_seconds_override`, `transfer_no_dispo`, `call_limit_24hour_method`, `call_limit_24hour_scope`, `call_limit_24hour`, `call_limit_24hour_override`, `cid_group_id_two`, `incall_tally_threshold_seconds`, `auto_alt_threshold`, `pause_max_url`, `agent_hide_hangup`, `ig_xfer_list_sort`, `script_tab_frame_size`, `max_logged_in_agents`, `user_group_script`) VALUES ('$com_id', '$com_name ', 'Y', '', '', '', '', '', 'DOWN', '', '', '', 'Y', 200, '1', 'longest_wait_time', '24hours', '', 60, '456545', '0000000000', '8368', '8309', 'ALLFORCE', 'FULLDATE_CUSTPHONE_AGENT', '', 'FORM', 'vm-goodbye', 'N', '', '', '', '', 'N', 'N', 'NONE', 5, 'AUDIO', '8307', 'Y', 0, 'Wrapup Call', ' 6272221 -', 'N', 0, 'N', 'RATIO', 'N', '3', '3.0', '2100', '0', 0, 'AUTO', 'NONE', ' B N NA DC -', 'N', 'Beetel_camp ', '$date', 'N', '$date', ' PRRM PRFENV PRFU LGSP WN CBNRP CB RR IR CDBC AC RDP BCNCR LB NR RNR CD CALLBK B NEW AB -', 'N', 'Y', 'DISABLED', 'Y', 4051, '---NONE---', ' 6272221 -', 50, '---NONE---', 'N', NULL, NULL, '24HRMIDNIGHT', 'NONE', 'Y', NULL, NULL, 'US_pol_survey_hello', '1238', '8', 'US_pol_survey_transfer', 'US_thanks_no_contact', 'AGENT_XFER', 'OPTIN', 'NI', '1-DEMOCRAT|2-REPUBLICAN|3-INDEPENDANT|8-OPTOUT|X-NO RESPONSE|', '8300', '/home/survey', 'Y', 'Y', 'NONE', 'NONE', 'N', 'N', 'CAMPAIGN', '', 'vdcwebform', 'LEAD', 'Y', 'Y', 'Y', 'DISABLED', 'N', '', 'ASK', 'N', '', 'US_thanks_no_contact', 'NI', '8300', '', 'US_thanks_no_contact', 'NI', '8300', '0', 'N', 'N', 'DISABLED', 'NONE', 'MANUAL', 'N', 'N', 'N', 'N', 'NONE', 'N', '', '', 'N', '2024-05-24 15:56:36', 'N', '', 'NONE', '', 1, '', '', '', '', '', 'N', 'NONE', 'DISABLED', 'N', 'ALL_ACTIVE', 'ALLOW_ALL', 'DISABLED', 'Someone is blind monitoring your session', '', 'DISABLED', '', 'DISABLED', 'DISABLED', '456545', 'ENABLED', 5, 'NONE', 'DISABLED', '', 'PREVIEW_AND_SKIP', 'CALLS_WAIT_CUST_ACW_PAUSE', 'Y', '1', 1, 'Y', 'STANDARD', 'DISABLED', 'N', 'N', 'LEAD_ASCEND', 'DISABLED', 'UNCHECKED', 'DISABLED', 'CAMPLISTS_ALL', '', 'N', 'PRECAL', 'N', 'CAMPAIGN', 'DISABLED', 'DISABLED', 'DISABLED', 0, 'DISABLED', 0, 'buzz', '', '', 0, 'ADAPT_CALC_ONLY', 'DISPO_ENABLED', '', '--SYSTEM-SETTINGS--', 'CALLID', '', 'N', 'DISABLED', 50, 0, 3, 0, 'DISABLED', 'Beetel', 'N', 'DISABLED', 'CAMPAIGN_SELECTED', 'DISABLED', 'DISABLED', 'DISABLED', '', 'N', '---NONE---', '---NONE---', 10, 'N', 0, 'DCMX', 0, 'DISMX', 0, 0, 'SELECTED', 'N', 0, 'ENABLED', 'DISABLED', 0, 'N', 'N', 'DISABLED', 'DISABLED', 'DISABLED', 'CLICK', 'ENABLED', 'DISABLED', 'DISABLED', 'NONE', '', 'ENABLED', 'ENABLED', 30, '', 'N', '', 'Y', 'N', 0, 'N', 0, 'N', 'N', 'DISABLED', 'N', 0, 0, 'N', 'N', 'N', 'DEFAULT', 'DEFAULT', 'DISABLED', 'DISABLED', '', 0, '---DISABLED---', 'PAUSMX', 'N', 0, 'DISABLED', 'NO', '', '', 'N', 'DISABLED', '', 'ENABLED', 'DISABLED', 'N', 'N', 'DISABLED', 'DISABLED', 0, NULL, 'DISABLED', '', 'DISABLED', '---NONE---', 'DISABLED', 'AMD', 0, '', 'DISABLED', '---NONE---', 50, 'DISABLED', '', 'N', 0, 'DISABLED', 'NONE', 99, '', '', '', 'ACKNOWLEDGE', 'DISABLED', 'DISABLED', 'DISABLED', 'DISABLED', 'DISABLED', 'DISABLED', 0, 'DISABLED', 'DISABLED', 'DISABLED', 'SYSTEM_WIDE', 0, 'DISABLED', '---DISABLED---', 0, 0, '', 'N', 'GROUP_ID_UP', 'DEFAULT', 0, 'DISABLED');";
        mysqli_query($conn, $ins_camp);
        // mysqli_query($conn, $ins_remote_agent);
        // mysqli_query($conn, $vicidial_user_insert_user);
        // mysqli_query($con, $did_up);
    if($query){
        echo '
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
      
      <script>
      // var username = document.getElementById("floatingInput1").value;
      window.onload = function() {
        Swal.fire({
          title: "Compaign Create",
          text: "Campaign creation is successful.",
          icon: "success",
          confirmButtonText: "OK"
        });
      }
      </script>';
    }
  
    } // check already insert number
  
    //  } // check select user select or no select
  }
  









if(isset($_POST["update"])){
    $new_camp=$_POST['new_camp'];
    $old_camp=$_POST['old_camp'];
    $camp_id=$_POST['camp_id'];
    // $date =date('Y-m-d');
    $Date = date("Y-m-d H:i:s", strtotime($date));

   if($new_camp == $old_camp){
    echo '
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">

    <script>
    Swal.fire({
        position: "top-end",
        icon: "success",
        title: "Campaign Name updated successfully.",
        showConfirmButton: false,
        timer: 1500
    });
    </script>';
   }else{

    
    $sel_check = "SELECT * FROM `vicidial_campaigns` WHERE campaign_name='$new_camp'";
    $quer_check = mysqli_query($conn, $sel_check);
    if (mysqli_num_rows($quer_check) > 0) {
        // echo "<script>alert('Data is already Inserted');</script>";
        echo '
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
    
        <script>
        Swal.fire({
            position: "top-end",
            icon: "error",
            title: "This Campaign has already been created !",
            showConfirmButton: false,
            timer: 1500
        });
        </script>';
    } else{    

    $Up_date="UPDATE `vicidial_campaigns` SET `campaign_name`='$new_camp' WHERE campaign_id='$camp_id'";

    $Up_date_data="UPDATE `compaignlist` SET `compaignname`='$new_camp', creat_date='$Date' WHERE compaign_id='$camp_id'";
//    die();
    mysqli_query($conn, $Up_date);
   $update = mysqli_query($con, $Up_date_data);
   if($update) {
    echo '
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">

    <script>
    Swal.fire({
        position: "top-end",
        icon: "success",
        title: "Campaign Name updated successfully.",
        showConfirmButton: false,
        timer: 1500
    });
    </script>';
    }

 }

   }

}


?>
<style>
.data_btn{
    background: #d1e1ff;
    color: #284f99;
    font-weight: bold;
    font-size: 16px;
    line-height: 22px;
    /* color: #637381; */
    /* background: transparent; */
    border-radius: 10px;
    padding: 15px;
    margin-right: 25px;
    transition: 0.3s all ease-in-out;
    margin-top: 25px;
    display: inline-block;
}
.data_btn1{
    background: #dfcbea;
    color: #284f99;
    font-weight: bold;
    font-size: 16px;
    line-height: 22px;
    /* color: #637381; */
    /* background: transparent; */
    border-radius: 10px;
    padding: 15px;
    margin-right: 25px;
    transition: 0.3s all ease-in-out;
    margin-top: 25px;
    display: inline-block;
}
.data_btn2{
    background: #f6dfce;
    color: #284f99;
    font-weight: bold;
    font-size: 16px;
    line-height: 22px;
    /* color: #637381; */
    /* background: transparent; */
    border-radius: 10px;
    padding: 15px;
    margin-right: 25px;
    transition: 0.3s all ease-in-out;
    margin-top: 25px;
    display: inline-block;
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
                 <a class="data_btn" href="#add-user" data-toggle="modal" data-target="#add-user"><i
                                class="fa fa-plus-circle" aria-hidden="true"></i>
                        Create Campaign</a> <h4> Show All Campaign</h4>

            </div>
            <table class="all-user-table table table-hover">
                <thead>
                <tr>
                    <th scope="col"><a href="#">Sr.</a></th>
                    <th scope="col"><a href="#">Campaign ID Name</a></th>
                    <th scope="col"><a href="#">Campaign Name</a></th>
                    <th scope="col"><a href="#">Status</a></th>
                    <th scope="col"><a href="#">Action</a></th>
                </tr>
                </thead>
                <tbody>
                <?php
                  $sr=1;
                while ($usersrow = mysqli_fetch_array($usersresult)) {

                    echo '<tr>';
                    echo '<td>' . $sr . '</td>';
                    echo '<td>' . $usersrow['compaign_id'] . '</td>';
                    echo '<td>' . $usersrow['compaignname'] . '</td>';
                           ?>
                            <td>
                       <a href="pages/new_action/edit_camp.php?camp_id=<?= $usersrow['compaign_id'] ?>">
                          <?php 
                          if($usersrow['status'] == '1'){
                          echo '<span class="active-yes cursor_p">' . 'Active' . '</span>';
                          } else {
                           echo '<span class="active-no cursor_p">' . 'Inactive' . '</span>';
                             }
                              ?>
            
                           </a>
                        </td>
                    <?php
                    // echo '<td>' . $usersrow['ins_date'] . '</td>';
                    ?>
                     <td> 

                     <span class="badge bg-info cursor_p text-white show_campaign_list" data-camp_id="<?Php echo $usersrow['compaign_id']; ?>" data-toggle="modal" data-target="#staticBackdrop" title="Click here and view list data and create List">View_list</span>
                    
                     <span class="badge bg-primary cursor_p text-white contact_add" data-id="<?Php echo $usersrow['compaign_id']; ?>" data-toggle="modal" data-target="#staticBackdrop" title="Click here and edit camp name">Edit</span>
                      <span class="badge bg-danger cursor_p text-white show_break_report" data-id="<?Php echo $usersrow['compaign_id']; ?>" title="You can click here to see why users take breaks">Remove</span></td>
                    <?php
                    echo '</tr>';
                    $sr++;  } 

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
                <h5 class="modal-title" id="exampleModalLabel">Add New Campaign</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">

                    <div class="row">
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">
                                <input type="text" class="form-control" id="full-name" name="camp_name"
                                       aria-describedby="full-name" required>
                                <label for="full-name">Enter Campaign Name</label>
                            </div>
                        </div>
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">
                                <input type="text" class="form-control" id="full-name" name="camp_id"
                                       aria-describedby="full-name" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="8" required>
                                <label for="full-name">Campaign ID</label>
                            </div>
                        </div>
                                        
                      
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary my-btn-secondary"
                            data-dismiss="modal">Cancel
                    </button>
                    <input class="my-btn-primary" type="submit" value="submit" name="new_camp_add">
                </div>
            </form>
        </div>
    </div>
</div> 
<!-- Add user modal ends here -->
<!-- Add user name for user id modal ends here -->
<!-- Modal -->
   <!-- add disposition open form  -->
   <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Campaign name</h5>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
      </div>
      <div class="modal-body">
        <form method="post">
          <div class="mb-3">
            <label for="name" class="form-label">Enter Campaign Name</label>
            <input type="text" class="form-control" id="edit_campname" name="new_camp" required>
            <input type="hidden" class="form-control" id="edit_campname_one" name="old_camp" required>
          </div>
          <div class="mb-3">
            <!-- <label for="number" class="form-label">Your Number</label> -->
            <input type="text" class="form-control" id="c_number" name="camp_id" readonly>
          </div>
          <button type="submit" class="btn btn-success" name="update">Update</button>
          <!-- Add an ID to the close button -->
            <button type="button" class="btn btn-warning" id="closeModalButton" data-bs-dismiss="modal" aria-label="Close">Close</button>

        </form>
      </div>
    </div>
  </div>
</div>


<!-- Add user name for user id modal ends here -->
<!-- Your modal HTML code -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $(document).on("click", ".contact_add", function() {
        var cnumber = $(this).data("id");
        // alert(cnumber);
        $("#edit_campname").val(""); // Clear the field before making the request
        $.ajax({
            url: "pages/new_action/get_camp.php", // URL to your PHP file
            type: "POST",
            data: { cnumber: cnumber },
            success: function(response) {
                // alert(response);
                $("#edit_campname").val(response);
                $("#edit_campname_one").val(response);
                $("#c_number").val(cnumber);
            },
            error: function(error) {
                console.log(error);
            }
        });
    });
});


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
        var id = $(this).data("id");
    // alert(id);
    Swal.fire({
        title: "Are you sure?",
        text: "This data is delete",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete"
    }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "pages/new_action/campaign_delete.php?id=" + id // Redirect to block.php with the 'id' query string
        }
    });
  });

});

// ########################################view list data###################### 

$(document).ready(function() {
    $(document).on("click", ".show_campaign_list", function() {
    // $(document).on("click", ".agent_dashboard.php", function() {
        var user_id = $(this).data("camp_id");
        // Assuming you want to redirect to another page
        // window.location.href = "?c=user&v=user_break_status&user_id=" + user_id;
        window.location.href = "?c=user&v=list_page&user_id=" + user_id;
    });
});

</script>