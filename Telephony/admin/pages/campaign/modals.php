<!--Add Campaign Modal -->

<!-- Copy user modal starts here -->
<div class="modal fade" id="copy-user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Copy Campaign</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-body">

                    <div class="row">
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">

                                <input type="text" class="form-control" id="campaign_id" name="campaign_id"
                                    aria-describedby="campaign_id" required>
                                <label for="campaign_id">New Campaign ID</label>
                            </div>

                        </div>
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">

                                <input type="text" class="form-control" id="campaign_name" name="campaign_name"
                                    aria-describedby="campaign_name" required>
                                <label for="campaign_name">New Campaign Name</label>
                            </div>

                        </div>
                        <div class="my-dropdown-with-help col-6">
                            <div class="my-dropdown">
                                <select name="source_campaign_id" id="source_campaign_id" required>
                                    <option></option>
                                    <?php
                                    $select1 = "SELECT * FROM compaign_list WHERE admin='$Adminuser'";
                                    $sel_query1 = mysqli_query($con, $select1);
                                    while ($roow_camp = mysqli_fetch_assoc($sel_query1)) {
                                        $camp_nname = $roow_camp['compaignname'];
                                        $compaign_id_old = $roow_camp['compaign_id'];
                                        ?>
                                        <option value="<?= $compaign_id_old ?>"><?= $camp_nname ?></option>
                                    <?php } ?>
                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="source_campaign_id">Copy campaign</label>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary my-btn-secondary" data-dismiss="modal">Cancel
                    </button>
                    <input class="my-btn-primary" type="submit" value="Copy Campaign" name="coppy_for_campaign">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Copy user modal ends here -->
<!-- remove the IVR FIRL -->
<div class="modal fade" id="remove_ivr" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Remove IVR File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="removeIvrForm" action="" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">

                        <div class="my-dropdown-with-help col-6">
                            <div class="my-dropdown">
                                <select name="welcome_vr" id="">
                                    <option value="set">Set IVR File</option>
                                    <option value="remove">Remove IVR</option>
                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="source_campaign_id">Select Welcome IVR Type</label>
                            </div>
                        </div>

                        <div class="my-dropdown-with-help col-6">
                            <div class="my-dropdown">
                                <select name="after_office_ivr" id="">
                                    <option value="set">Set IVR File</option>
                                    <option value="remove">Remove IVR</option>
                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="source_campaign_id">Select After Office hours IVR Type</label>
                            </div>
                        </div>
                        <div class="my-dropdown-with-help col-6">
                            <div class="my-dropdown">
                                <select name="week_off_ivr" id="">
                                    <option value="set">Set IVR File</option>
                                    <option value="remove">Remove IVR</option>
                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="source_campaign_id">Select Week off IVR Type</label>
                            </div>
                        </div>
                        <div class="my-dropdown-with-help col-6">
                            <div class="my-dropdown">
                                <select name="park_music_ivr" id="">
                                    <option value="set">Set IVR File</option>
                                    <option value="remove">Remove IVR</option>
                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="source_campaign_id">Select Park Music Type</label>
                            </div>
                        </div>
                        <div class="my-dropdown-with-help col-6">
                            <div class="my-dropdown">
                                <select name="no_agent_ivr" id="">
                                    <option value="set">Set IVR File</option>
                                    <option value="remove">Remove IVR</option>
                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="source_campaign_id">Select No Agent IVR Type</label>
                            </div>
                        </div>
                        <div class="my-dropdown-with-help col-6">
                            <div class="my-dropdown">
                                <select name="ringtone_ivr" id="">
                                    <option value="set">Set IVR File</option>
                                    <option value="remove">Remove IVR</option>
                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="source_campaign_id">Select RingTone Music Type</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary my-btn-secondary" data-dismiss="modal">Cancel
                    </button>
                    <!-- <input class="my-btn-primary" type="submit" value="Remove_to_ivr" name="Remove_to_ivr"> -->
                    <button type="submit" class="my-btn-primary">Remove to IVR</button>

                </div>
            </form>
        </div>
    </div>
</div>
<!-- remove the IVR FIRL -->
<!-- Add user modal starts here -->
<div class="modal fade" id="add-user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div style="min-width: 1080px;" class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Campaign</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="modal-body">

                    <div class="row">
                        <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                            <div class="form-group my-input">

                                <input type="text" class="form-control" id="campaign_id" name="campaign_id"
                                    aria-describedby="campaign_id" required>
                                <label for="campaign_id">Campaign ID</label>
                            </div>
                        </div>
                        <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                            <div class="form-group my-input">

                                <input type="text" class="form-control" id="campaign_name" name="campaign_name"
                                    aria-describedby="campaign_name" required>
                                <label for="campaign_name">Campaign Name</label>
                            </div>
                        </div>
                        <!-- <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                            <div class="form-group my-input">
                                <input type="text" class="form-control" id="campaign_description"
                                    name="campaign_description" aria-describedby="campaign_description">
                                <label for="campaign_description">Campaign Description</label>
                            </div>
                        </div> -->
                        <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                            <div class="my-dropdown">
                                <select name="campaign_description" id="campaign_description" required>
                                    <option></option>
                                    <option value="both">BOTH</option>
                                    <option value="inbound">INBOUND</option>
                                    <option value="outbound">OUTBOUND</option>
                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="campaign_description">Campaign Type</label>
                            </div>
                        </div>
                        <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                            <div class="form-group my-input">

                                <input type="number" class="form-control" id="campaign_no" name="campaign_no"
                                    aria-describedby="campaign_no" required max="999999999999"
                                    oninput="if(this.value.length > 12) this.value = this.value.slice(0, 12);">

                                <label for="campaign_no">Inbound (CLI/DID).</label>
                            </div>
                        </div>
                        <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                            <div class="form-group my-input">

                                <input type="number" class="form-control" id="Outbound_no" name="Outbound_no"
                                    aria-describedby="Outbound_no" required max="999999999999"
                                    oninput="if(this.value.length > 12) this.value = this.value.slice(0, 12);">

                                <label for="Outbound_no">Outbound (CLD/DID).</label>
                            </div>
                        </div>
                        <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                            <div class="form-group my-input">

                                <input type="file" class="form-control" id="welcome_ivr" name="welcome_ivr"
                                    aria-describedby="welcome_ivr">

                                <label for="welcome_ivr">Welcome IVR</label>
                            </div>
                        </div>
                        <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                            <div class="form-group my-input">

                                <input type="file" class="form-control" id="after_office_ivr" name="after_office_ivr"
                                    aria-describedby="after_office_ivr">

                                <label for="campaign_no">After Office IVR</label>
                            </div>
                        </div>
                        <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                            <div class="form-group my-input">

                                <input type="file" class="form-control" id="park_file_name" name="park_file_name"
                                    aria-describedby="park_file_name">
                                <label for="park_file_name">Call on hold music</label>
                            </div>

                        </div>

                        <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                            <div class="form-group my-input">

                                <input type="file" class="form-control" id="ringtone_file_name"
                                    name="ringtone_file_name" aria-describedby="park_file_name">
                                <label for="ringtone_file_name">Ring Tone Music</label>
                            </div>

                        </div>

                        <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                            <div class="form-group my-input">

                                <input type="file" class="form-control" id="noagent_file_name" name="noagent_file_name"
                                    aria-describedby="park_file_name">
                                <label for="noagent_file_name">No Agent IVR</label>
                            </div>

                        </div>


                        <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                            <div class="form-group my-input">
                                <input type="file" class="form-control" id="week_of_ivr" name="week_of_ivr"
                                    aria-describedby="park_file_name">
                                <label for="park_file_name">Week off IVR
                                </label>
                            </div>
                        </div>

                        <div class="my-switch-field col-12 col-md-6 col-lg-4">
                            <h6>Active</h6>
                            <div class="switch-field ">
                                <input type="radio" id="active-radio-one" name="active" value="Y" check="yes" checked />
                                <label for="active-radio-one">Yes</label>
                                <input type="radio" id="active-radio-two" name="active" value="N" check="no" />
                                <label for="active-radio-two">No</label>
                            </div>
                        </div>
                        <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                            <div class="my-dropdown">
                                <select name="ring_time" id="ring_time">
                                    <option value='60'>60 SECONDS</option>
                                    <option value='45'>45 SECONDS</option>
                                    <option value='30'>30 SECONDS</option>

                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="ring_time">Ring Time</label>
                            </div>
                        </div>

                        <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                            <div class="my-dropdown">
                                <select name="auto_dial_level" id="auto_dial_level">
                                    <option></option>
                                    <option>0</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                    <option>9</option>
                                    <option>10</option>
                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="auto_dial_level">Auto Dial Level (0 = off)</label>
                            </div>

                        </div>
                        <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                            <div class="my-dropdown">
                                <select name="next_agent_call" id="next_agent_call">
                                    <option value='random'>random</option>
                                    <option value='campaign_rank'>Rank</option>
                                    <option value='ring_all'>Ring All</option>
                                    <option value='longest_wait_time'>Longest Wait Time</option>
                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="next_agent_call">Ring Type</label>
                            </div>

                        </div>
                        <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                            <div class="my-dropdown">
                                <select name="local_call_time" id="local_call_time">
                                    <option value="12am-11pm">24hours - default 24 hours calling</option>
                                    <option value="9am-6pm">9am-6pm - default 9am to 6pm calling </option>
                                    <option value="10am-6pm">10am-6pm - default 10am to 6pm calling </option>
                                    <option value="10am-7pm">10am-7pm - default 10am to 7pm calling </option>
                                    <option value="12pm-5pm">12pm-5pm - default 12pm to 5pm calling </option>
                                    <option value="12pm-9pm">12pm-9pm - default 12pm to 9pm calling </option>
                                    <option value="5pm-9pm">5pm-9pm - default 5pm to 9pm calling </option>
                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="local_call_time">Calling Time</label>
                            </div>

                        </div>
                        <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                            <div class="my-dropdown">
                                <select name="week_off" id="week_off">
                                    <option value=""></option>
                                    <option value="Sunday">Sunday</option>
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                    <option value="Saturday">Saturday</option>
                                    <option value="SaturdaytoSunday">Saturday to Sunday</option>

                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="week_off">Week Off</label>
                            </div>
                        </div>





                        <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                            <div class="my-dropdown">
                                <select name="get_call_launch" id="get_call_launch">
                                    <option></option>
                                    <option value='NONE'>Inactive</option>
                                    <option value='WEBFORM'>Active</option>

                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="get_call_launch">Lead Form</label>
                            </div>

                        </div>
                        <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                            <div class="my-dropdown">
                                <select name="group_wise" id="group_wise">
                                    <option></option>
                                    <option value='0'>NONE</option>
                                    <!-- <option value='SCRIPT'>SCRIPT</option> -->
                                    <option value='1'>GROUP</option>
                                    <option value='2'>Call Menu</option>

                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="get_call_launch">Call Route</label>
                            </div>

                        </div>
                        <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                            <div class="my-dropdown">

                                <select name="select_user" id="select_user" required>
                                    <option value="">--Select User--</option>
                                    <?php
                                    if ($user_level != '9') {
                                        $select_us = "SELECT user_id, full_name FROM users WHERE user_type= '8' AND admin='$Adminuser'";
                                    } else {
                                        $select_us = "SELECT user_id, full_name FROM users WHERE user_type= '8'AND admin IN ($admin_ids_str) ORDER BY id DESC";
                                    }
                                    $sel_query_us = mysqli_query($con, $select_us);
                                    $num_rows = mysqli_num_rows($sel_query_us);
                                    while ($roow_us = mysqli_fetch_assoc($sel_query_us)) {
                                        $user_id = $roow_us['user_id'];
                                        $user_name = $roow_us['full_name'];
                                        if ($num_rows == 1) {
                                            echo "<option value='$user_id' selected>$user_id - $user_name</option>";
                                        } else {
                                            echo "<option value='$user_id'>$user_id - $user_name</option>";
                                        }
                                    }
                                    ?>
                                </select>

                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="get_call_launch" class="default-focused-label">Select User</label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary my-btn-secondary" data-dismiss="modal">Cancel
                    </button>
                    <input class="my-btn-primary" type="submit" value="submit" name="add_campaign">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add user modal ends here -->


<!-- Update Camp modal starts here -->
<div class="modal fade" id="update_camp" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div style="min-width: 1080px;" class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Campaign</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="modal-body">

                    <div class="row">
                        <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                            <div class="form-group my-input">

                                <input type="hidden" class="form-control" id="real_id" name="c_id" aria-describedby="">
                                <input type="text" class="form-control" id="campaign_id_new" name="campaign_id"
                                    aria-describedby="campaign_id">
                                <label for="campaign_id">Campaign ID</label>
                            </div>
                        </div>
                        <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                            <div class="form-group my-input">

                                <input type="text" class="form-control" id="campaign_name_new" name="campaign_name"
                                    aria-describedby="campaign_name">
                                <label for="campaign_name">Campaign Name</label>
                            </div>
                        </div>


                        <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                            <div class="my-dropdown">
                                <select name="campaign_description_new" id="campaign_description_new">
                                    <option></option>
                                    <option value="both">BOTH</option>
                                    <option value="inbound">INBOUND</option>
                                    <option value="outbound">OUTBOUND</option>
                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="campaign_description_new" class="default-focused-label">Campaign
                                    Type</label>
                            </div>

                        </div>
                        <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                            <div class="form-group my-input">

                                <input type="number" class="form-control" id="campaign_no_new" name="campaign_no"
                                    aria-describedby="campaign_no" required max="999999999999"
                                    oninput="if(this.value.length > 12) this.value = this.value.slice(0, 12);">

                                <label for="campaign_no">Inbound (CLI/DID).</label>
                            </div>
                        </div>

                        <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                            <div class="form-group my-input">
 
                                <input type="number" class="form-control" id="Outbound_no_new" name="Outbound_no"
                                    aria-describedby="Outbound_no" required max="999999999999"
                                    oninput="if(this.value.length > 12) this.value = this.value.slice(0, 12);">

                                <label for="Outbound_no">Outbound (CLI/DID).</label>
                            </div>
                        </div>


                        <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                            <div class="form-group my-input">

                                <input type="file" class="form-control" id="welcome_ivr" name="welcome_ivr"
                                    aria-describedby="welcome_ivr">

                                <label for="welcome_ivr">Welcome IVR</label>
                            </div>
                        </div>
                        <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                            <div class="form-group my-input">

                                <input type="file" class="form-control" id="after_office_ivr" name="after_office_ivr"
                                    aria-describedby="after_office_ivr">

                                <label for="campaign_no">After Office IVR</label>
                            </div>
                        </div>
                        <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                            <div class="form-group my-input">

                                <input type="file" class="form-control" id="park_file_name_new"
                                    name="park_file_name_new" aria-describedby="park_file_name">
                                <label for="park_file_name">Call on hold music</label>
                            </div>
                        </div>

                        <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                            <div class="form-group my-input">

                                <input type="file" class="form-control" id="ringtone_file_name"
                                    name="ringtone_file_name_new" aria-describedby="park_file_name">
                                <label for="ringtone_file_name">RingTone Music</label>
                            </div>

                        </div>

                        <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                            <div class="form-group my-input">

                                <input type="file" class="form-control" id="noagent_file_name"
                                    name="noagent_file_name_new" aria-describedby="park_file_name">
                                <label for="noagent_file_name">No Agent IVR</label>
                            </div>

                        </div>

                        <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                            <div class="form-group my-input">
                                <input type="file" class="form-control" id="week_of_ivr" name="week_of_ivr_new"
                                    aria-describedby="park_file_name">
                                <label for="park_file_name">Week off IVR
                                </label>
                            </div>
                        </div>

                        <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                            <div class="my-dropdown">
                                <select name="ring_time" id="ring_time_new">
                                    <option value='60'>60 SECONDS</option>
                                    <option value='45'>45 SECONDS</option>
                                    <option value='30'>30 SECONDS</option>

                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="ring_time">Ring Time</label>
                            </div>

                        </div>
                        <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                            <div class="my-dropdown">
                                <select name="auto_dial_level" id="auto_dial_level_new">
                                    <option></option>
                                    <option>0</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                    <option>9</option>
                                    <option>10</option>
                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="auto_dial_level">Auto Dial Level (0 = off)</label>
                            </div>

                        </div>

                        <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                            <div class="my-dropdown">
                                <select name="next_agent_call" id="next_agent_call_new">
                                    <option value='random'>random</option>
                                    <option value='campaign_rank'>Rank</option>
                                    <option value='ring_all'>Ring All</option>
                                    <option value='longest_wait_time'>Longest Wait Time</option>
                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="next_agent_call">Ring Type</label>
                            </div>

                        </div>
                        <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                            <div class="my-dropdown">
                                <select name="local_call_time" id="local_call_time_new">
                                    <option></option>
                                    <option value="12am-11pm">24hours - default 24 hours calling</option>
                                    <option value="9am-6pm">9am-6pm - default 9am to 6pm calling </option>
                                    <option value="10am-6pm">10am-6pm - default 10am to 6pm calling </option>
                                    <option value="10am-7pm">10am-7pm - default 10am to 7pm calling </option>
                                    <option value="12pm-5pm">12pm-5pm - default 12pm to 5pm calling </option>
                                    <option value="12pm-9pm">12pm-9pm - default 12pm to 9pm calling </option>
                                    <option value="5pm-9pm">5pm-9pm - default 5pm to 9pm calling </option>
                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="local_call_time" class="default-focused-label">Calling Time</label>
                            </div>

                        </div>
                        <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                            <div class="my-dropdown">
                                <select name="week_off" id="week_off_new">
                                    <option value=""></option>
                                    <option value="Sunday">Sunday</option>
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                    <option value="Saturday">Saturday</option>
                                    <option value="SaturdaytoSunday">Saturday to Sunday</option>

                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="week_off" class="default-focused-label">Week Off</label>
                            </div>
                        </div>



                        <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                            <div class="my-dropdown">
                                <select name="get_call_launch" id="get_call_launch_new">
                                    <option></option>
                                    <option value='NONE'>Inactive</option>
                                    <!-- <option value='SCRIPT'>SCRIPT</option> -->
                                    <option value='WEBFORM'>Active</option>
                                    <!-- <option value='SCRIPTTWO'>SCRIPTTWO</option>
                                    <option value='WEBFORMTWO'>WEBFORMTWO</option>
                                    <option value='WEBFORMTHREE'>WEBFORMTHREE</option>
                                    <option value='FORM'>FORM</option>
                                    <option value='EMAIL'>EMAIL</option>
                                    <option value='CHAT'>CHAT</option> -->
                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="get_call_launch" class="default-focused-label">Lead Form</label>
                            </div>

                        </div>
                        <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                            <div class="my-dropdown">
                                <select name="group_wise" id="group_wise_new">
                                    <option></option>
                                    <option value='0'>NONE</option>
                                    <!-- <option value='SCRIPT'>SCRIPT</option> -->
                                    <option value='1'>GROUP</option>
                                    <option value='2'>Call Menu</option>


                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="get_call_launch" class="default-focused-label">Call Route</label>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary my-btn-secondary" data-dismiss="modal">Cancel
                    </button>
                    <input class="my-btn-primary" type="submit" value="Update" name="update_campaign">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add user modal ends here -->
<!--Add Campaign Modal -->