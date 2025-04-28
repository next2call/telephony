<?php 
session_start();
$Adminuser = $_SESSION['user'];
// require '../include/user.php';
include "../../../conf/db.php";

if (isset($_POST['user'])) {
    $user->user = $_POST['user'];
}else{
    echo "please fill all fieldes";
}
if(isset($_POST['full_name'])) {
    $user->full_name = $_POST['full_name'];
}else{
    echo "please fill all fieldes";
}
   
    $user->user_level = '1';
    $user->user_group = 'winet';
    $user->pass = $_POST['pass'];
    $user->org = $_POST['Organization'];

    $date = date("Y-M-d");

    $sel_check = "SELECT user_id FROM `users` WHERE user_id='$user->user'";
    $quer_check = mysqli_query($con, $sel_check);
    
    $sel_check_vicidial = "SELECT extension FROM `phones` WHERE extension='$user->user'";
    $quer_check_vici = mysqli_query($conn, $sel_check_vicidial);

    if (mysqli_num_rows($quer_check) > 0 && mysqli_num_rows($quer_check_vici) > 0) {
        // echo "<script>alert('Data is already Insert')</script>";
        echo "Data is alreadyexist";
    } else {
        
//  die();
    // $sql="INSERT INTO vicidial_users (user, full_name, user_level, user_group, pass) VALUES ('".$user->user."','".$user->user."','".$user->user_level."','".$user->user_group."','".$user->pass."')";
    // mysqli_query($conn,$sql);
// echo "<br>";

    // $sql_vcd="INSERT INTO `phones`(`extension`, `dialplan_number`, `voicemail_id`, `login`, `pass`, `active`, `phone_type`, `fullname`, `company`) VALUES ('".$user->user."','".$user->user."','".$user->user."','".$user->user."','".$user->pass."','Y','VICIDIAL','".$user->full_name."','".$user->org."')";
    // $phone_ins="INSERT INTO phones (extension, dialplan_number, voicemail_id, phone_ip, computer_ip, server_ip, login, pass, status, active, phone_type, fullname, company, picture, messages, old_messages, protocol, local_gmt, ASTmgrUSERNAME, ASTmgrSECRET, login_user, login_pass, login_campaign, park_on_extension, conf_on_extension, VICIDIAL_park_on_extension, VICIDIAL_park_on_filename, monitor_prefix, recording_exten, voicemail_exten, voicemail_dump_exten, ext_context, dtmf_send_extension, call_out_number_group, client_browser, install_directory, local_web_callerID_URL, VICIDIAL_web_URL, AGI_call_logging_enabled, user_switching_enabled, conferencing_enabled, admin_hangup_enabled, admin_hijack_enabled, admin_monitor_enabled, call_parking_enabled, updater_check_enabled, AFLogging_enabled, QUEUE_ACTION_enabled, CallerID_popup_enabled, voicemail_button_enabled, enable_fast_refresh, fast_refresh_rate, enable_persistant_mysql, auto_dial_next_number, VDstop_rec_after_each_call, DBX_server, DBX_database, DBX_user, DBX_pass, DBX_port, DBY_server, DBY_database, DBY_user, DBY_pass, DBY_port, outbound_cid, enable_sipsak_messages, email, template_id, conf_override, phone_context, phone_ring_timeout, conf_secret, delete_vm_after_email, is_webphone, use_external_server_ip, codecs_list, codecs_with_template, webphone_dialpad, on_hook_agent, webphone_auto_answer, voicemail_timezone, voicemail_options, user_group, voicemail_greeting, voicemail_dump_exten_no_inst, voicemail_instructions, on_login_report, unavail_dialplan_fwd_exten, unavail_dialplan_fwd_context, nva_call_url, nva_search_method, nva_error_filename, nva_new_list_id, nva_new_phone_code, nva_new_status, webphone_dialbox, webphone_mute, webphone_volume, webphone_debug, outbound_alt_cid, conf_qualify, webphone_layout, mohsuggest, peer_status, ping_time, webphone_settings) VALUES
    // ('".$user->user."', '".$user->user."', '".$user->user."', '10.101.1.16', '10.101.1.16', '10.10.10.17', '".$user->user."', '".$user->pass."', 'ACTIVE', 'Y', '".$user->user."', '".$user->user."', '', '', 0, 0, 'SIP', '-5.00', 'cron', '1234', '', '', '', '8301', '8302', '8301', 'park', '8612', '8309', '8501', '85026666666666', 'default', 'local/8500998@default', 'Zap/g2/', '/usr/bin/mozilla', '/usr/local/perl_TK', 'http://www.vicidial.org/test_callerid_output.php', '', '1', '1', '1', '0', '0', '1', '1', '1', '1', '1', '1', '1', '0', 1000, '0', '1', '1', '', 'asterisk', 'cron', '1234', 3306, '', 'asterisk', 'cron', '1234', 3306, '".$user->user."', '0', '', 'webRTC_Winet', '', 'default', 60, '".$user->pass."', 'N', 'Y', 'N', '', '0', 'Y', 'N', 'Y', 'eastern', '', 'winet', '', '85026666666667', 'Y', 'N', '', '', '', 'NONE', '', 995, '1', 'NVAINS', 'Y', 'Y', 'Y', 'Y', '', 'Y', '', '', 'REACHABLE', 27, 'VICIPHONE_SETTINGS')";
    // mysqli_query($conn,$phone_ins);


    // $stmtA="UPDATE servers SET rebuild_conf_files='Y' where generate_vicidial_conf='Y' and active_asterisk_server='Y' and server_ip='10.10.10.17'";
	// $rslt=mysql_to_mysqli($stmtA, $link);
    // mysqli_query($conn,$stmtA);
    // echo "<br>";

     $sql2="INSERT INTO `users`(`admin`, `user_id`, `password`, `full_name`, `status`, `org`) VALUES ('$Adminuser', '".$user->user."','".$user->pass."','".$user->full_name."','Y', '".$user->org."')";
   $query_ins = mysqli_query($con,$sql2);
//    echo "<br>";
// die();
   if($query_ins){
    echo "data Insert";
//    echo "<script>alert('Okey. data insert successfull')</script>";
//    echo '
//    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
//    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
   
//    <script>
//    // var username = document.getElementById("floatingInput1").value;
//    window.onload = function() {
//      Swal.fire({
//        title: "Create User ",
//        text: "Create User is successful.",
//        icon: "success",
//        confirmButtonText: "OK"
//      });
//    }
//    </script>';
   }else{
    // echo "<script>alert('Sorry')</script>";
    echo "data Insert";

    // echo '
    // <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
    // <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
    
    // <script>
    // // var username = document.getElementById("floatingInput1").value;
    // window.onload = function() {
    //   Swal.fire({
    //     title: "Failed",
    //     text: "Sorry, Data is not Inserted!",
    //     icon: "error",
    //     confirmButtonText: "OK"
    //   });
    // }
    // </script>';
//    }


}
}

?>