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
                                    while($roow_camp = mysqli_fetch_assoc($sel_query1)){ 
                                        $camp_nname = $roow_camp['compaignname'];
                                        $compaign_id_old = $roow_camp['compaign_id'];
                                        ?>
                                    <option value="<?= $compaign_id_old ?>"><?= $camp_nname ?></option>
                                    <?php } ?>
                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="source_campaign_id">Coppy campaign</label>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary my-btn-secondary" data-dismiss="modal">Cancel
                    </button>
                    <input class="my-btn-primary" type="submit" value="Coppy Campaign" name="coppy_for_campaign">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Copy user modal ends here -->

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

                            <input type="number" class="form-control" id="campaign_no"
       name="campaign_no" aria-describedby="campaign_no" required
       max="9999999999" oninput="if(this.value.length > 10) this.value = this.value.slice(0, 10);">

                                <label for="campaign_no">Campaign CID.</label>
                            </div>
                        </div>
                        <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                            <div class="form-group my-input">

                            <input type="file" class="form-control" id="welcome_ivr"
       name="welcome_ivr" aria-describedby="welcome_ivr">

                                <label for="welcome_ivr">Welcome IVR</label>
                            </div>
                        </div>
                        <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                            <div class="form-group my-input">

                            <input type="file" class="form-control" id="after_office_ivr"
       name="after_office_ivr" aria-describedby="after_office_ivr">

                                <label for="campaign_no">After Office IVR</label>
                            </div>
                        </div>
                        <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                            <div class="form-group my-input">

                                <input type="file" class="form-control" id="park_file_name" name="park_file_name"
                                    aria-describedby="park_file_name">
                                <label for="park_file_name">Park Music-on-Hold</label>
                            </div>

                        </div>


                        <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                            <div class="form-group my-input">
                                <input type="file" class="form-control" id="week_of_ivr" name="week_of_ivr"
                                    aria-describedby="park_file_name">
                                <label for="park_file_name">Week of IVR</label>
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
                        <!-- <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                            <div class="form-group my-input">

                                <input type="text" class="form-control" id="web_form_address" name="web_form_address"
                                    aria-describedby="web_form_address" required>
                                <label for="web_form_address">Web Form</label>
                            </div>

                        </div> -->
                        <!-- <div class="my-switch-field col-12 col-md-6 col-lg-4">
                            <h6>Allow Closers</h6>
                            <div class="switch-field ">
                                <input type="radio" id="allow_closers-radio-one" name="allow_closers" value="Y"
                                    check="yes" checked />
                                <label for="allow_closers-radio-one">Yes</label>
                                <input type="radio" id="allow_closers-radio-two" name="allow_closers" value="N"
                                    check="no" />
                                <label for="allow_closers-radio-two">No</label>
                            </div>
                        </div> -->
                        <!-- <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                            <div class="my-dropdown">
                                <select name="hopper_level" id="hopper_level">
                                    <option></option>
                                    <option>1</option>
                                    <option>5</option>
                                    <option>10</option>
                                    <option>20</option>
                                    <option>50</option>
                                    <option>100</option>
                                    <option>200</option>
                                    <option>500</option>
                                    <option>1000</option>
                                    <option>2000</option>
                                    <option>3000</option>
                                    <option>4000</option>
                                    <option>5000</option>
                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="hopper_level">Minimum Hopper Level</label>
                            </div>

                        </div> -->
                        <!-- <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                            <div class="my-dropdown">
                                <select name="auto_dial_level" id="auto_dial_level">
                                    <option></option>
                                    <option>0</option>
                                    <option>1</option>
                                    <option>1.1</option>
                                    <option>1.2</option>
                                    <option>1.3</option>
                                    <option>1.4</option>
                                    <option>1.5</option>
                                    <option>1.6</option>
                                    <option>1.7</option>
                                    <option>1.8</option>
                                    <option>1.9</option>
                                    <option>2</option>
                                    <option>2.1</option>
                                    <option>2.2</option>
                                    <option>2.3</option>
                                    <option>2.4</option>
                                    <option>2.5</option>
                                    <option>2.6</option>
                                    <option>2.7</option>
                                    <option>2.8</option>
                                    <option>2.9</option>
                                    <option>3</option>
                                    <option>3.25</option>
                                    <option>3.5</option>
                                    <option>3.75</option>
                                    <option>4</option>
                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="auto_dial_level">Auto Dial Level (0 = off)</label>
                            </div>

                        </div> -->
                        <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                            <div class="my-dropdown">
                                <select name="next_agent_call" id="next_agent_call">
                                    <option value='random'>random</option>
                                    <option value='campaign_rank'>Rank</option>
                                    <!-- <option value='oldest_call_start'>oldest_call_start</option>
                                    <option value='oldest_call_finish'>oldest_call_finish</option>
                                    <option value='overall_user_level'>overall_user_level</option>
                                    <option value='campaign_rank'>campaign_rank</option>
                                    <option value='campaign_grade_random'>campaign_grade_random</option>
                                    <option value='fewest_calls'>fewest_calls</option>
                                    <option value='longest_wait_time'>longest_wait_time</option>
                                    <option value='overall_user_level_wait_time'>
                                        overall_user_level_wait_time
                                    </option>
                                    <option value='campaign_rank_wait_time'>campaign_rank_wait_time
                                    </option>
                                    <option value='fewest_calls_wait_time'>fewest_calls_wait_time
                                    </option> -->
                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="next_agent_call">Next Agent Call</label>
                            </div>

                        </div>
                        <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                            <div class="my-dropdown">
                                <select name="local_call_time" id="local_call_time">
                                    <option></option>
                                    <option value="12am-11pm">24hours - default 24 hours calling</option>
                                    <option value="9am-6pm">9am-6pm - default 9am to 6pm calling </option>
                                    <option value="10am-6pm">10am-6pm - default 10am to 6pm calling </option>
                                    <option value="12pm-5pm">12pm-5pm - default 12pm to 5pm calling </option>
                                    <option value="12pm-9pm">12pm-9pm - default 12pm to 9pm calling </option>
                                    <option value="5pm-9pm">5pm-9pm - default 5pm to 9pm calling </option>
                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="local_call_time">Local Call Time</label>
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
                                <select name="script_id" id="script_id">
                                    <option></option>
                                    <option value="NONE">NONE</option>
                                    <option value="CALLNOTES">CALLNOTES - Call Notes and Appointment
                                        Setting
                                    </option>
                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="script_id">Script</label>
                            </div>

                        </div>

                        <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                            <div class="my-dropdown">
                                <select name="get_call_launch" id="get_call_launch">
                                    <option></option>
                                    <option value='NONE'>NONE</option>
                                    <!-- <option value='SCRIPT'>SCRIPT</option> -->
                                    <option value='WEBFORM'>WEBFORM</option>
 
                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="get_call_launch">Get Call Launch</label>
                            </div>

                        </div>
                        <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                            <div class="my-dropdown">
                                <select name="group_wise" id="group_wise">
                                    <option></option>
                                    <option value='0'>NONE</option>
                                    <!-- <option value='SCRIPT'>SCRIPT</option> -->
                                    <option value='1'>GROUP</option>
 
                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="get_call_launch">Run Your campain Gproup wise agent or without group</label>
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

                                <input type="hidden" class="form-control" id="real_id" name="c_id"
                                    aria-describedby="">
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
                        <!-- <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                            <div class="form-group my-input">

                                <input type="text" class="form-control" id="campaign_description_new"
                                    name="campaign_description" aria-describedby="campaign_description">
                                <label for="campaign_description">Campaign Description</label>
                            </div>
                        </div> -->

                        <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                            <div class="my-dropdown">
                                <select name="campaign_description_new" id="campaign_description_new">
                                    <option></option>
                                    <option value="both">BOTH</option>
                                    <option value="inbound">INBOUND</option>
                                    <option value="outbound">OUTBOUND</option>
                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="campaign_description_new" class="default-focused-label">Campaign Type</label>
                            </div>

                        </div>
                        <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                            <div class="form-group my-input">

                            <input type="number" class="form-control" id="campaign_no_new"
       name="campaign_no" aria-describedby="campaign_no" required
       max="9999999999" oninput="if(this.value.length > 10) this.value = this.value.slice(0, 10);">

                                <label for="campaign_no">Campaign NO.</label>
                            </div>
                        </div>
                        <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                            <div class="form-group my-input">

                            <input type="file" class="form-control" id="welcome_ivr"
       name="welcome_ivr" aria-describedby="welcome_ivr">

                                <label for="welcome_ivr">Welcome IVR</label>
                            </div>
                        </div>
                        <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                            <div class="form-group my-input">

                            <input type="file" class="form-control" id="after_office_ivr"
       name="after_office_ivr" aria-describedby="after_office_ivr">

                                <label for="campaign_no">After Office IVR</label>
                            </div>
                        </div>
                        <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                            <div class="form-group my-input">

                                <input type="file" class="form-control" id="park_file_name_new" name="park_file_name_new"
                                    aria-describedby="park_file_name">
                                <label for="park_file_name">Park Music-on-Hold</label>
                            </div>
                        </div>
                        <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                            <div class="my-dropdown">
                                <select name="next_agent_call" id="next_agent_call_new">
                                
                                    <option value='random'>random</option>
                                    <option value='campaign_rank'>Rank</option>
                                     </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="next_agent_call" class="default-focused-label">Next Agent Call</label>
                            </div>

                        </div>
                        <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                            <div class="my-dropdown">
                                <select name="local_call_time" id="local_call_time_new">
                                    <option></option>
                                    <option value="12pm-5pm">12pm-5pm - default 12pm to 5pm calling
                                    </option>
                                    <option value="12pm-9pm">12pm-9pm - default 12pm to 9pm calling
                                    </option>
                                    <option value="12am-11pm">24hours - default 24 hours calling</option>
                                    <option value="5pm-9pm">5pm-9pm - default 5pm to 9pm calling
                                    </option>
                                    <option value="9am-5pm">9am-5pm - default 9am to 5pm calling
                                    </option>
                                    <option value="9am-9pm">9am-9pm - default 9am to 9pm calling
                                    </option>
                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="local_call_time" class="default-focused-label">Local Call Time</label>
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
                                <select name="script_id" id="script_id_new">
                                    <option></option>
                                    <option value="NONE">NONE</option>
                                    <option value="CALLNOTES">CALLNOTES - Call Notes and Appointment
                                        Setting
                                    </option>
                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="script_id" class="default-focused-label">Script</label>
                            </div>

                        </div>

                        <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                            <div class="my-dropdown">
                                <select name="get_call_launch" id="get_call_launch_new">
                                    <option></option>
                                    <option value='NONE'>NONE</option>
                                    <!-- <option value='SCRIPT'>SCRIPT</option> -->
                                    <option value='WEBFORM'>WEBFORM</option>
                                    <!-- <option value='SCRIPTTWO'>SCRIPTTWO</option>
                                    <option value='WEBFORMTWO'>WEBFORMTWO</option>
                                    <option value='WEBFORMTHREE'>WEBFORMTHREE</option>
                                    <option value='FORM'>FORM</option>
                                    <option value='EMAIL'>EMAIL</option>
                                    <option value='CHAT'>CHAT</option> -->
                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="get_call_launch" class="default-focused-label">Get Call Launch</label>
                            </div>

                        </div>
                        <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                            <div class="my-dropdown">
                                <select name="group_wise" id="group_wise_new">
                                    <option></option>
                                    <option value='0'>NONE</option>
                                    <!-- <option value='SCRIPT'>SCRIPT</option> -->
                                    <option value='1'>GROUP</option>
 
                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="get_call_launch" class="default-focused-label">Run Your campain Gproup wise agent or without group</label>
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