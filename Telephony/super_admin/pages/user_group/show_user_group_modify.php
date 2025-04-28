<?php
include "../include/userGroup.php";
$userGroup = new userGroup();
if (isset($_GET['id'])) {
    $id = $_GET['id'];

}
// echo $id;
if (isset($_POST['add_user_group'])) {
    // $abc = $_POST;
    // foreach ($abc as $k => $v) {
    //     echo $k;
    //     echo "<br>";
    // }

    // foreach ($abc as $k => $v) {
    //     echo '$userGroup';
    //     echo "->";
    //     echo $k;
    //     echo "= ";
    //     echo '$_POST[' . $k . ']';
    //     echo "<br>";

    // }

$userGroup->group_name= $_POST['group_name'];
$userGroup->forced_timeclock_login= $_POST['forced_timeclock_login'];
$userGroup->agent_status_view_time= $_POST['agent_status_view_time'];
$userGroup->agent_call_log_view= $_POST['agent_call_log_view'];
$userGroup->agent_xfer_consultative= $_POST['agent_xfer_consultative'];
$userGroup->agent_xfer_dial_override= $_POST['agent_xfer_dial_override'];
$userGroup->agent_xfer_vm_transfer= $_POST['agent_xfer_vm_transfer'];
$userGroup->agent_xfer_blind_transfer= $_POST['agent_xfer_blind_transfer'];
$userGroup->agent_xfer_dial_with_customer= $_POST['agent_xfer_dial_with_customer'];
$userGroup->agent_xfer_park_customer_dial= $_POST['agent_xfer_park_customer_dial'];
$userGroup->agent_xfer_park_3way= $_POST['agent_xfer_park_3way'];
$userGroup->agent_fullscreen= $_POST['agent_fullscreen'];
$userGroup->webphone_url_override= $_POST['webphone_url_override'];
$userGroup->webphone_systemkey_override= $_POST['webphone_systemkey_override'];
$userGroup->webphone_dialpad_override= $_POST['webphone_dialpad_override'];
$userGroup->webphone_layout= $_POST['webphone_layout'];
$userGroup->admin_ip_list= $_POST['admin_ip_list'];
$userGroup->agent_ip_list= $_POST['agent_ip_list'];
$userGroup->allowed_reports= $_POST['allowed_reports'];
$userGroup->add_user_group= $_POST['add_user_group'];

$sql="UPDATE `vicidial_campaigns` SELECT group_name='".$userGroup->group_name."',
forced_timeclock_login='".$userGroup->forced_timeclock_login."',
agent_status_view_time='".$userGroup->agent_status_view_time."',
agent_call_log_view='".$userGroup->agent_call_log_view."',
agent_xfer_consultative='".$userGroup->agent_xfer_consultative."',
agent_xfer_dial_override='".$userGroup->agent_xfer_dial_override."',
agent_xfer_vm_transfer='".$userGroup->agent_xfer_vm_transfer."',
agent_xfer_blind_transfer='".$userGroup->agent_xfer_blind_transfer."',
agent_xfer_dial_with_customer='".$userGroup->agent_xfer_dial_with_customer."',
agent_xfer_park_customer_dial='".$userGroup->agent_xfer_park_customer_dial."',
agent_xfer_park_3way='".$userGroup->agent_xfer_park_3way."',
agent_fullscreen='".$userGroup->agent_fullscreen."',
webphone_url_override='".$userGroup->webphone_url_override."',
webphone_systemkey_override='".$userGroup->webphone_systemkey_override."',
webphone_dialpad_override='".$userGroup->webphone_dialpad_override."',
webphone_layout='".$userGroup->webphone_layout."',
admin_ip_list='".$userGroup->admin_ip_list."',
agent_ip_list='".$userGroup->agent_ip_list."',
allowed_reports='".$userGroup->allowed_reports."',
add_user_group='".$userGroup->add_user_group."' WHERE user_group='" . $id . "'";

$result=mysqli_query($conn, $sql);




}

if (isset($_POST['add_delete'])) {

    // $abc = $_POST;
    // foreach ($abc as $k => $v) {
    //     echo $k;
    //     echo "<br>";
    // }
    //     foreach ($abc as $k => $v) {
    //     echo '$userGroup';
    //     echo "->";
    //     echo $k;
    //     echo "= ";
    //     echo '$_POST[' . $k . ']';
    //     echo "<br>";

 

    // }
    $userGroup->stage= $_POST['stage'];
    $userGroup->group_id= $_POST['group_id'];
  

    $sql="UPDATE `vicidial_campaigns` SELECT stage='".$userGroup->stage."',
    group_id='".$userGroup->group_id."', 
    WHERE user_group='".$id."'";

    $result=mysqli_query($conn, $sql);

    }




?>


<!-- Code goes here -->
<div class="add-user-step-1">
    <div class="back-btn-title-delete">
        <a href="#"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        <h4>Modify User Group</h4>
        <a href="#" data-toggle="modal" data-target="#confirmDelete"><img src="../assets/images/common-icons/delete.png"
                alt=""></a>
    </div>

    <div class="my-form">
        <h3>Modify User Group Record</h3>
        <form action="" method="POST">
            <div class="alert alert-danger" role="alert">
                Invalid Inputs!
            </div>
            <div class="row">
                <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                    <div class="form-group my-input">
                        <input type="text" class="form-control" id="user-group-name" name="user-group-name"
                            aria-describedby="user-group-name" value="AGENTS " disabled>
                        <label for="user-group-name">Group</label>
                    </div>
                </div>
                <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                    <div class="form-group my-input">

                        <input type="text" class="form-control" id="group_name" name="group_name"
                            aria-describedby="group_name">
                        <label for="group_name">Description</label>
                    </div>
                </div>

                <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                    <div class="my-dropdown">

                        <select name="forced_timeclock_login" id="forced_timeclock_login">
                            <option value="ADMIN_EXEMPT" selected>ADMIN_EXEMPT</option>
                            <option value="Y">Y</option>
                            <option value="N">N</option>
                        </select>
                        <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                        <label for="forced_timeclock_login">Force Timeclock Login</label>
                    </div>
                </div>

                <div class="my-switch-field col-12 col-md-6 col-lg-4">
                    <h6>Agent Status View Time</h6>
                    <div class="switch-field ">
                        <input type="radio" id="agent_status_view_time-radio-one" name="agent_status_view_time"
                            value="Y" check="yes" checked="">
                        <label for="agent_status_view_time-radio-one">Yes</label>
                        <input type="radio" id="agent_status_view_time-radio-two" name="agent_status_view_time"
                            value="N" check="no">
                        <label for="agent_status_view_time-radio-two">No</label>
                    </div>
                </div>
                <div class="my-switch-field col-12 col-md-6 col-lg-4">
                    <h6>Agent Call Log View</h6>
                    <div class="switch-field ">
                        <input type="radio" id="agent_call_log_view-radio-one" name="agent_call_log_view" value="Y"
                            check="yes" checked="">
                        <label for="agent_call_log_view-radio-one">Yes</label>
                        <input type="radio" id="agent_call_log_view-radio-two" name="agent_call_log_view" value="N"
                            check="no">
                        <label for="agent_call_log_view-radio-two">No</label>
                    </div>
                </div>
                <div class="my-switch-field col-12 col-md-6 col-lg-4">
                    <h6>Agent Allow Consultative Xfer</h6>
                    <div class="switch-field ">
                        <input type="radio" id="agent_xfer_consultative-radio-one" name="agent_xfer_consultative"
                            value="Y" check="yes" checked="">
                        <label for="agent_xfer_consultative-radio-one">Yes</label>
                        <input type="radio" id="agent_xfer_consultative-radio-two" name="agent_xfer_consultative"
                            value="N" check="no">
                        <label for="agent_xfer_consultative-radio-two">No</label>
                    </div>
                </div>
                <div class="my-switch-field col-12 col-md-6 col-lg-4">
                    <h6>Agent Allow Dial Override Xfer</h6>
                    <div class="switch-field ">
                        <input type="radio" id="agent_xfer_dial_override-radio-one" name="agent_xfer_dial_override"
                            value="Y" check="yes" checked="">
                        <label for="agent_xfer_dial_override-radio-one">Yes</label>
                        <input type="radio" id="agent_xfer_dial_override-radio-two" name="agent_xfer_dial_override"
                            value="N" check="no">
                        <label for="agent_xfer_dial_override-radio-two">No</label>
                    </div>
                </div>
                <div class="my-switch-field col-12 col-md-6 col-lg-4">
                    <h6>Agent Allow Voicemail Message Xfer</h6>
                    <div class="switch-field ">
                        <input type="radio" id="agent_xfer_vm_transfer-radio-one" name="agent_xfer_vm_transfer"
                            value="Y" check="yes" checked="">
                        <label for="agent_xfer_vm_transfer-radio-one">Yes</label>
                        <input type="radio" id="agent_xfer_vm_transfer-radio-two" name="agent_xfer_vm_transfer"
                            value="N" check="no">
                        <label for="agent_xfer_vm_transfer-radio-two">No</label>
                    </div>
                </div>
                <div class="my-switch-field col-12 col-md-6 col-lg-4">
                    <h6>Agent Allow Blind Xfer</h6>
                    <div class="switch-field ">
                        <input type="radio" id="agent_xfer_blind_transfer-radio-one" name="agent_xfer_blind_transfer"
                            value="Y" check="yes" checked="">
                        <label for="agent_xfer_blind_transfer-radio-one">Yes</label>
                        <input type="radio" id="agent_xfer_blind_transfer-radio-two" name="agent_xfer_blind_transfer"
                            value="N" check="no">
                        <label for="agent_xfer_blind_transfer-radio-two">No</label>
                    </div>
                </div>
                <div class="my-switch-field col-12 col-md-6 col-lg-4">
                    <h6>Agent Allow Dial With Customer Xfer</h6>
                    <div class="switch-field ">
                        <input type="radio" id="agent_xfer_dial_with_customer-radio-one"
                            name="agent_xfer_dial_with_customer" value="Y" check="yes" checked="">
                        <label for="agent_xfer_dial_with_customer-radio-one">Yes</label>
                        <input type="radio" id="agent_xfer_dial_with_customer-radio-two"
                            name="agent_xfer_dial_with_customer" value="N" check="no">
                        <label for="agent_xfer_dial_with_customer-radio-two">No</label>
                    </div>
                </div>
                <div class="my-switch-field col-12 col-md-6 col-lg-4">
                    <h6>Agent Allow Park Customer Dial Xfer</h6>
                    <div class="switch-field ">
                        <input type="radio" id="agent_xfer_park_customer_dial-radio-one"
                            name="agent_xfer_park_customer_dial" value="Y" check="yes" checked="">
                        <label for="agent_xfer_park_customer_dial-radio-one">Yes</label>
                        <input type="radio" id="agent_xfer_park_customer_dial-radio-two"
                            name="agent_xfer_park_customer_dial" value="N" check="no">
                        <label for="agent_xfer_park_customer_dial-radio-two">No</label>
                    </div>
                </div>
                <div class="my-switch-field col-12 col-md-6 col-lg-4">
                    <h6>Agent Allow Park Xfer</h6>
                    <div class="switch-field ">
                        <input type="radio" id="agent_xfer_park_3way-radio-one" name="agent_xfer_park_3way" value="Y"
                            check="yes" checked="">
                        <label for="agent_xfer_park_3way-radio-one">Yes</label>
                        <input type="radio" id="agent_xfer_park_3way-radio-two" name="agent_xfer_park_3way" value="N"
                            check="no">
                        <label for="agent_xfer_park_3way-radio-two">No</label>
                    </div>
                </div>
                <div class="my-switch-field col-12 col-md-6 col-lg-4">
                    <h6>Agent Fullscreen:</h6>
                    <div class="switch-field ">
                        <input type="radio" id="agent_fullscreen-radio-one" name="agent_fullscreen" value="Y"
                            check="yes" checked="">
                        <label for="agent_fullscreen-radio-one">Yes</label>
                        <input type="radio" id="agent_fullscreen-radio-two" name="agent_fullscreen" value="N"
                            check="no">
                        <label for="agent_fullscreen-radio-two">No</label>
                    </div>
                </div>

                <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                    <div class="form-group my-input">

                        <input type="text" class="form-control" id="webphone_url_override" name="webphone_url_override"
                            aria-describedby="webphone_url_override">
                        <label for="webphone_url_override">Webphone URL Override</label>
                    </div>
                </div>
                <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                    <div class="form-group my-input">

                        <input type="text" class="form-control" id="webphone_systemkey_override"
                            name="webphone_systemkey_override" aria-describedby="webphone_systemkey_override">
                        <label for="webphone_systemkey_override">Webphone System Key Override</label>
                    </div>
                </div>
                <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                    <div class="my-dropdown">

                        <select name="webphone_dialpad_override" id="webphone_dialpad_override">
                            <option value="DISABLED">DISABLED</option>
                            <option value="Y">Y</option>
                            <option value="N">N</option>
                            <option value="TOGGLE" selected="">TOGGLE</option>
                            <option value="TOGGLE_OFF" selected="">TOGGLE_OFF</option>
                        </select>
                        <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                        <label for="webphone_dialpad_override">Webphone Dialpad Override</label>
                    </div>
                </div>

                <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                    <div class="form-group my-input">

                        <input type="text" class="form-control" id="webphone_layout" name="webphone_layout"
                            aria-describedby="webphone_layout">
                        <label for="webphone_layout">Webphone Layout Override</label>
                    </div>
                </div>
                <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                    <div class="my-dropdown">

                        <select name="admin_ip_list" id="admin_ip_list">
                            <option value="DISABLED" selected>DISABLED</option>
                        </select>

                        <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                        <label for="admin_ip_list">Admin IP Whitelist</label>
                    </div>
                </div>

                <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                    <div class="my-dropdown">

                        <select name="agent_ip_list" id="agent_ip_list">
                            <option value="DISABLED" selected=""> --- DISABLED ---</option>
                        </select>
                        <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                        <label for="agent_ip_list">Agent IP Whitelist</label>
                    </div>
                </div>

                <div class="checkbox-input my-input-with-help col-lg-4 d-flex flex-row align-items-center mt-3 mb-5">
                    <div class="user-allow">
                        <h6>Allowed Campaigns: </h6>
                    </div>
                    <div class="all-inputs">
                        <div class="single-input">
                            <input type="checkbox" id="allowed_user_camp_2" name="campaigns[]" class="mr-3 mb-2">
                            <label for="allowed_user_camp_2">DEMO - DEMO Camp</label>
                        </div>
                        <div class="single-input">
                            <input type="checkbox" id="allowed_user_camp_1" name="campaigns[]" class="mr-3 mb-2">
                            <label for="allowed_user_camp_1">Hopper Drop-Run Trigger</label>
                        </div>
                        <div class="single-input">
                        </div>
                    </div>
                </div>
                <div class="checkbox-input my-input-with-help col-lg-4 d-flex flex-row align-items-center mt-3 mb-5">
                    <div class="user-allow">
                        <h6>Group Shifts: </h6>
                    </div>
                    <div class="all-inputs">
                        <div class="single-input">
                            <input type="checkbox" id="group_shifts[]" name="campaigns[]" class="mr-3 mb-2">
                            <label for="group_shifts[]">24HRMIDNIGHT</label>
                        </div>
                    </div>
                </div>
                <div class="checkbox-input my-input-with-help col-lg-4 d-flex flex-row align-items-center mt-3 mb-5">
                    <div class="user-allow">
                        <h6>Agent Status Viewable Groups: </h6>
                    </div>
                    <div class="all-inputs">
                        <div class="single-input">
                            <input type="checkbox" id="agent_status_viewable_groups[1]"
                                name="agent_status_viewable_groups[]" class="mr-3 mb-2">
                            <label for="agent_status_viewable_groups[1]">ALL-GROUPS</label>
                            <input type="checkbox" id="agent_status_viewable_groups[2]"
                                name="agent_status_viewable_groups[]" class="mr-3 mb-2">
                            <label for="agent_status_viewable_groups[2]">CAMPAIGN-AGENTS</label>
                            <input type="checkbox" id="agent_status_viewable_groups[3]"
                                name="agent_status_viewable_groups[]" class="mr-3 mb-2">
                            <label for="agent_status_viewable_groups[3]">NOT-LOGGED-IN-AGENTS</label>
                        </div>
                    </div>
                </div>
                <div class="checkbox-input my-input-with-help col-lg-4 d-flex flex-row align-items-center mt-3 mb-5">
                    <div class="user-allow">
                        <h6>Agent Allowed Chat Groups: </h6>
                    </div>
                    <div class="all-inputs">
                        <div class="single-input">
                            <input type="checkbox" id="agent_allowed_chat_groups[1]" name="agent_allowed_chat_groups[]"
                                class="mr-3 mb-2">
                            <label for="agent_allowed_chat_groups[1]">ALL-GROUPS</label>
                            <input type="checkbox" id="agent_allowed_chat_groups[2]" name="agent_allowed_chat_groups[]"
                                class="mr-3 mb-2">
                            <label for="agent_allowed_chat_groups[2]">CAMPAIGN-AGENTS</label>
                            <input type="checkbox" id="agent_allowed_chat_groups[3]" name="agent_allowed_chat_groups[]"
                                class="mr-3 mb-2">
                            <label for="agent_allowed_chat_groups[3]">NOT-LOGGED-IN-AGENTS</label>
                        </div>
                    </div>
                </div>
                <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                    <div class="my-dropdown">

                        <select multiple size="6" name="allowed_reports" id="allowed_reports[]"
                            style="height: auto;padding: 10px 15px 10px 15px;" required>
                            <option value="ALL REPORTS" selected="">ALL REPORTS</option>
                            <option value=" NONE"> NONE</option>
                            <option value=" Real-Time Main Report"> Real-Time Main Report</option>
                            <option value=" Real-Time Campaign Summary"> Real-Time Campaign Summary
                            </option>
                            <option value=" Real-Time Whiteboard Report"> Real-Time Whiteboard Report
                            </option>
                            <option value=" Inbound Report"> Inbound Report</option>
                            <option value=" Inbound Report by DID"> Inbound Report by DID</option>
                            <option value=" Inbound Service Level Report"> Inbound Service Level Report
                            </option>
                            <option value=" Inbound Summary Hourly Report"> Inbound Summary Hourly
                                Report
                            </option>
                            <option value=" Inbound Daily Report"> Inbound Daily Report</option>
                            <option value=" Inbound DID Report"> Inbound DID Report</option>
                            <option value=" Inbound DID Summary Report"> Inbound DID Summary Report
                            </option>
                            <option value=" Agent DID Report"> Agent DID Report</option>
                            <option value=" Inbound Email Report"> Inbound Email Report</option>
                            <option value=" Inbound Chat Report"> Inbound Chat Report</option>
                            <option value=" Inbound IVR Report"> Inbound IVR Report</option>
                            <option value=" Inbound Forecasting Report"> Inbound Forecasting Report
                            </option>
                            <option value=" Advanced Forecasting Report"> Advanced Forecasting Report
                            </option>
                            <option value=" Outbound Calling Report"> Outbound Calling Report</option>
                            <option value=" Outbound Summary Interval Report"> Outbound Summary Interval
                                Report
                            </option>
                            <option value=" Outbound IVR Report"> Outbound IVR Report</option>
                            <option value=" Callmenu Survey Report"> Callmenu Survey Report</option>
                            <option value=" Outbound Lead Source Report"> Outbound Lead Source Report
                            </option>
                            <option value=" Fronter - Closer Report"> Fronter - Closer Report</option>
                            <option value=" Fronter - Closer Detail Report"> Fronter - Closer Detail
                                Report
                            </option>
                            <option value=" Lists Campaign Statuses Report"> Lists Campaign Statuses
                                Report
                            </option>
                            <option value=" Lists Statuses Report"> Lists Statuses Report</option>
                            <option value=" Campaign Status List Report"> Campaign Status List Report
                            </option>
                            <option value=" Export Calls Report"> Export Calls Report</option>
                            <option value=" Export Leads Report"> Export Leads Report</option>
                            <option value=" Agent Time Detail"> Agent Time Detail</option>
                            <option value=" Agent Status Detail"> Agent Status Detail</option>
                            <option value=" Agent Inbound Status Summary"> Agent Inbound Status Summary
                            </option>
                            <option value=" Agent Performance Detail"> Agent Performance Detail</option>
                            <option value=" Team Performance Detail"> Team Performance Detail</option>
                            <option value=" Performance Comparison Report"> Performance Comparison
                                Report
                            </option>
                            <option value=" Single Agent Daily"> Single Agent Daily</option>
                            <option value=" Single Agent Daily Time"> Single Agent Daily Time</option>
                            <option value=" User Group Login Report"> User Group Login Report</option>
                            <option value=" User Group Hourly Report"> User Group Hourly Report</option>
                            <option value=" User Group Detail Hourly Report"> User Group Detail Hourly
                                Report
                            </option>
                            <option value=" User Timeclock Report"> User Timeclock Report</option>
                            <option value=" User Group Timeclock Status Report"> User Group Timeclock
                                Status Report
                            </option>
                            <option value=" User Timeclock Detail Report"> User Timeclock Detail Report
                            </option>
                            <option value=" Server Performance Report"> Server Performance Report
                            </option>
                            <option value=" Administration Change Log"> Administration Change Log
                            </option>
                            <option value=" List Update Stats"> List Update Stats</option>
                            <option value=" User Stats"> User Stats</option>
                            <option value=" User Time Sheet"> User Time Sheet</option>
                            <option value=" Download List"> Download List</option>
                            <option value=" Dialer Inventory Report"> Dialer Inventory Report</option>
                            <option value=" Custom Reports Links"> Custom Reports Links</option>
                            <option value=" CallCard Search"> CallCard Search</option>
                            <option value=" Maximum System Stats"> Maximum System Stats</option>
                            <option value=" Maximum Stats Detail"> Maximum Stats Detail</option>
                            <option value=" Search Leads Logs"> Search Leads Logs</option>
                            <option value=" Email Log Report"> Email Log Report</option>
                            <option value=" Lists Pass Report"> Lists Pass Report</option>
                            <option value=" Called Counts List IDs Report"> Called Counts List IDs
                                Report
                            </option>
                            <option value=" Front Page System Summary"> Front Page System Summary
                            </option>
                            <option value=" Report Page Servers Summary"> Report Page Servers Summary
                            </option>
                            <option value=" Admin Utilities Page"> Admin Utilities Page</option>
                            <option value=" Agent Debug Log Report"> Agent Debug Log Report</option>
                            <option value=" Agent Parked Call Report"> Agent Parked Call Report</option>
                            <option value=" Agent-Manager Chat Log"> Agent-Manager Chat Log</option>
                            <option value=" Recording Access Log Report"> Recording Access Log Report
                            </option>
                            <option value=" API Log Report"> API Log Report</option>
                            <option value=" Real-Time Monitoring Log Report"> Real-Time Monitoring Log
                                Report
                            </option>
                            <option value=" AMD Log Report"> AMD Log Report</option>
                            <option value=" SIP Event Report"> SIP Event Report</option>
                            <option value=" Caller ID Log Report"> Caller ID Log Report</option>
                        </select>
                        <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                        <label for="allowed_reports[]">Agent IP Whitelist</label>
                    </div>
                </div>

                <div class="checkbox-input my-input-with-help col-lg-4 d-flex flex-row align-items-center mt-3 mb-5">
                    <div class="user-allow">
                        <h6>Allowed User Groups </h6>
                    </div>
                    <div class="all-inputs">
                        <div class="single-input">
                            <input type="checkbox" id="admin_viewable_groups[1]" name="admin_viewable_groups[]"
                                class="mr-3 mb-2">
                            <label for="admin_viewable_groups[1]">ALL-GROUPS</label>
                            <input type="checkbox" id="dmin_viewable_groups[2]" name="admin_viewable_groups[]"
                                class="mr-3 mb-2">
                            <label for="dmin_viewable_groups[2]">CAMPAIGN-AGENTS</label>
                            <input type="checkbox" id="dmin_viewable_groups[3]" name="admin_viewable_groups[]"
                                class="mr-3 mb-2">
                            <label for="dmin_viewable_groups[3]">NOT-LOGGED-IN-AGENTS</label>
                        </div>
                    </div>
                </div>
                <div class="checkbox-input my-input-with-help col-lg-4 d-flex flex-row align-items-center mt-3 mb-5">
                    <div class="user-allow">
                        <h6>Allowed Call Times</h6>
                    </div>
                    <div class="all-inputs">
                        <div class="single-input">
                            <input type="checkbox" id="admin_viewable_call_times[1]" name="admin_viewable_call_times[]"
                                class="mr-3 mb-2">
                            <label for="admin_viewable_call_times[1]">ALL-GROUPS</label>
                            <input type="checkbox" id="admin_viewable_call_times[2]" name="admin_viewable_call_times[]"
                                class="mr-3 mb-2">
                            <label for="admin_viewable_call_times[2]">CAMPAIGN-AGENTS</label>
                            <input type="checkbox" id="admin_viewable_call_times[3]" name="admin_viewable_call_times[]"
                                class="mr-3 mb-2">
                            <label for="admin_viewable_call_times[3]">NOT-LOGGED-IN-AGENTS</label>
                        </div>
                    </div>
                </div>


            </div>
            <input class="my-btn-secondary mt-md-4 cancel-btn" type="reset" value="Cancel">
            <input class="my-btn-primary mt-md-4 submit-btn" type="submit" value="Submit" name="add_user_group">
        </form>

        <!-- user list table start -->
        <div class="table-responsive my-table">
            <div class="table-top">
                <h4>USERS WITHIN THIS USER GROUP: <span>5</span></h4>
            </div>
            <table class="all-user-table table table-hover">
                <thead>
                    <tr>
                        <th scope="col"><a href="#">USER</a></th>
                        <th scope="col"><a href="#">FULL NAME </a></th>
                        <th scope="col"><a href="#">ACTIVE</a></th>
                        <th scope="col"><a href="#">LEVEL</a></th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><a href="#">3001</a></td>
                        <td>Tazbin Ahad</td>
                        <td><span class="active-yes">Yes</span></td>
                        <td>All</td>

                    </tr>

                    <tr>
                        <td><a href="#">3001</a></td>
                        <td>Demo Campaign</td>
                        <td><span class="active-yes">Yes</span></td>
                        <td>All</td>
                    </tr>

                    <tr>
                        <td><a href="#">3001</a></td>
                        <td>Demo Campaign</td>
                        <td><span class="active-yes">Yes</span></td>
                        <td>All</td>

                    </tr>

                    <tr>
                        <td><a href="#">3001</a></td>
                        <td>Demo Campaign</td>
                        <td><span class="active-yes">Yes</span></td>
                        <td>All</td>
                    </tr>

                </tbody>
            </table>
        </div>
        <!-- user list table ends -->


        <form action="" method="POST">
            <div class="my-card-with-title">
                <div class="card-body">
                    <div class="row justify-content-start align-items-center">
                        <div class="col-lg-12 col-md-12">
                            <div class="row justify-content-center">
                                <div class="my-dropdown-with-help col-12 col-md-6 col-lg-12 flex-column">
                                    <h5>Add or Remove In-Group Selected For Active Users in This User
                                        Group</h5>

                                    <div class="my-dropdown">
                                        <select name="stage" id="stage">
                                            <option value="add" selected="">add</option>
                                            <option value="remove">remove</option>
                                        </select>
                                        <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                        <label for="stage"
                                            style="font-size: 100%; transform: translate3d(0px, -40%, 0px); opacity: 0.5; background-color: transparent; padding: 15px 0px 0px 13px; z-index: 0;"></label>
                                    </div>
                                </div>
                                <div class="my-input-with-help col-12 col-md-6 col-lg-12 align-items-center ">
                                    <h5>In-Group</h5>
                                    <div class="my-dropdown">
                                        <select name="group_id" id="group_id">
                                            <option value="AGENTDIRECT">AGENTDIRECT - Single Agent
                                                Direct Queue
                                            </option>
                                            <option value="AGENTDIRECT_CHAT">AGENTDIRECT_CHAT - Agent
                                                Direct Queue for Chats
                                            </option>
                                        </select>
                                        <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                        <label for="group_id"
                                            style="font-size: 100%; transform: translate3d(0px, -40%, 0px); opacity: 0.5; background-color: transparent; padding: 15px 0px 0px 13px; z-index: 0;"></label>
                                    </div>
                                </div>
                                <input type="submit" value="Submit" class="my-btn-primary" name="add_delete">
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </form>
        <div class="all-other-links d-flex flex-wrap py-5" style="justify-content: space-evenly;">
            <a href="#" class="btn my-btn-primary mt-4"><span>See all CallBack Holds in this user
                    group</span></a>
            <a href="#" class="btn my-btn-primary mt-4"><span>See the Timeclock Status for this user
                    group</span></a>
            <a href="#" class="btn my-btn-primary mt-4"><span>See Admin changes to this user
                    group</span></a>

        </div>
    </div>
</div>

<div class="modal fade" id="confirmDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6>Are you sure that you want to delete this user?</h6>
            </div>
            <div class="modal-footer">
                <a href="#" type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</a>
                <a href="#" type="button" class="btn btn-primary">Delete</a>
            </div>
        </div>
    </div>
</div>
<!-- Code goes here -->