<!-- Copy user modal starts here -->
<div class="modal fade" id="copy-user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Copy List</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">

                    <div class="row">
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">

                                <input type="text" class="form-control" id="campaign_id" name="list_id_new"
                                    aria-describedby="campaign_id" required>
                                <label for="campaign_id">Enter List ID</label>
                            </div>
                            <!-- <span class="error-msg">Error Msg</span> -->
                        </div>
                        <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                            <div class="my-dropdown">
                                <select name="list_id_old" id="list_id" required>
                                    <option></option>
                                    <?php 
$list_tbl_select = "SELECT * FROM `lists` WHERE ADMIN='$Adminuser'"; 
$list_query = mysqli_query($con, $list_tbl_select);
while ($list_row = mysqli_fetch_array($list_query)) {
?>
                                    <option value="<?= $list_row['LIST_ID'] ?>"><?= $list_row['NAME'] ?></option>

<?php } ?>
                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="list_id">List ID to Copy To</label>
                            </div>
                            <!-- <span class="error-msg">Error Msg</span> -->
                        </div>
                        <!-- <div class="my-dropdown-with-help col-6">
                            <div class="my-dropdown">
                                <select name="copy_option" id="copy_option">
                                    <option></option>
                                    <option value="APPEND">APPEND</option>
                                    <option value="UPDATE">UPDATE</option>
                                    <option value="REPLACE">REPLACE</option>
                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="copy_option">Copy Option</label>
                            </div>
                            <span class="error-msg">Error Msg</span>
                        </div> -->
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary my-btn-secondary"
                        data-dismiss="modal">Cancel</button>
                    <input class="my-btn-primary" type="submit" value="submit" name="dublicate_list">
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
                <h5 class="modal-title" id="exampleModalLabel">Add New List</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post">
                <div class="modal-body">

                    <div class="row">
                        <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                            <div class="form-group my-input">

                                <input type="text" class="form-control" id="campaign_id" name="list_id"
                                    aria-describedby="campaign_id">
                                <label for="campaign_id">List ID</label>
                            </div>

                        </div>
                        <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                            <div class="form-group my-input">

                                <input type="text" class="form-control" id="campaign_name" name="list_name"
                                    aria-describedby="campaign_name">
                                <label for="campaign_name">List Name</label>
                            </div>

                        </div>
                        <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                            <div class="form-group my-input">

                                <input type="text" class="form-control" id="campaign_description"
                                    name="list_description" aria-describedby="campaign_description">
                                <label for="campaign_description">List Description</label>
                            </div>

                        </div>
                        <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                            <div class="my-dropdown">
                                <select name="campaign_id" id="campaign_id">
                                    <option></option>
<?php 
$ussql = "SELECT * FROM `compaign_list` WHERE admin='$Adminuser'"; 
$usersresult = mysqli_query($con, $ussql);
while ($usersrow = mysqli_fetch_array($usersresult)) {
?>
                                    <option value="<?= $usersrow['compaign_id'] ?>"><?= $usersrow['compaign_id'] ?></option>

<?php } ?>
                                    </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="campaign_id">Campaign</label>
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

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary my-btn-secondary"
                        data-dismiss="modal">Cancel</button>
                    <input class="my-btn-primary" type="submit" value="submit" name="submit_add_list">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add user modal ends here -->

<!-- Add user modal starts here -->
<div class="modal fade" id="upload_lead" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div style="min-width: 1080px;" class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload Lead</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-body">

                    <div class="row">
                        <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                            <div class="form-group my-input">

                                <input type="text" class="form-control" id="list_id_neww" name="list_old_id"
                                    aria-describedby="campaign_id" readonly>
                                <label for="campaign_id">List ID</label>
                            </div>

                        </div>
                        <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                            <div class="form-group my-input">

                                <input type="text" class="form-control" id="campaign_name_nn" name="campaign_name"
                                    aria-describedby="campaign_name" readonly>
                                <label for="campaign_name">Campaign Name</label>
                            </div>

                        </div>
                        <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                            <div class="form-group my-input">

                                <input type="file" class="form-control" id="lead_upload"
                                    name="excel" aria-describedby="lead_upload" accept=".csv">
                                <label for="campaign_description">Lead Upload</label>
                            </div>

                        </div>

                       

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary my-btn-secondary"
                        data-dismiss="modal">Cancel</button>
                    <input class="my-btn-primary" type="submit" name="import">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add user modal ends here -->


<!-- Add Lead Modal -->
<div class="modal fade" id="dynamic_lead" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="" method="POST" enctype="multipart/form-data" id="leadForm">
                <div class="modal-body">
                    <div class="row">
                        <!-- Dynamic Fields Section -->
                        <div class="col-12">
                            <div class="section-title">
                                <h6>Dynamic Form Fields</h6>
                            </div>
                            <div id="dynamicFieldsContainer"></div>
                            <button type="button" class="btn btn-primary mt-3" onclick="addField()">Add Field</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <input class="btn btn-primary" type="submit" value="Submit">
                </div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade" id="updatalissst" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div style="min-width: 1080px;" class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update List</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post">
                <div class="modal-body">

                    <div class="row">
                        <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                            <div class="form-group my-input">

                                <input type="text" class="form-control" id="list_id_new" name="list_id"
                                    aria-describedby="campaign_id" readonly>
                                <label for="campaign_id">List ID</label>
                            </div>

                        </div>
                        <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                            <div class="form-group my-input">

                                <input type="text" class="form-control" id="list_name_new" name="list_name"
                                    aria-describedby="campaign_name">
                                <label for="campaign_name">List Name</label>
                            </div>

                        </div>
                        <div class="my-input-with-help col-12 col-md-6 col-lg-4">
                            <div class="form-group my-input">

                                <input type="text" class="form-control" id="campaign_description_new"
                                    name="list_description" aria-describedby="campaign_description">
                                <label for="campaign_description">List Description</label>
                            </div>

                        </div>
                        <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                            <div class="my-dropdown">
                                <select name="campaign_id" id="campaign_id_new">
                                    <option></option>
<?php 
$ussql = "SELECT * FROM `compaign_list` WHERE admin='$Adminuser'"; 
$usersresult = mysqli_query($con, $ussql);
while ($usersrow = mysqli_fetch_array($usersresult)) {
?>
                                    <option value="<?= $usersrow['compaign_id'] ?>"><?= $usersrow['compaign_id'] ?></option>

<?php } ?>
                                    </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="campaign_id">Campaign</label>
                            </div>

                        </div>
                    
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary my-btn-secondary"
                        data-dismiss="modal">Cancel</button>
                    <input class="my-btn-primary" type="submit" value="submit" name="update_list">
                </div>
            </form>

        </div>
    </div>
</div>