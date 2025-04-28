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

                                <input type="text" class="form-control" id="campaign_id" name="campaign_id"
                                    aria-describedby="campaign_id">
                                <label for="campaign_id">List ID to Copy From</label>
                            </div>
                            <span class="error-msg">Error Msg</span>
                        </div>
                        <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                            <div class="my-dropdown">
                                <select name="list_id" id="list_id" required>
                                    <option></option>
                                    <option value="998">998 - 998</option>
                                    <option value="999">999 - 999</option>
                                    <option value="12527">12527 - 12527-test</option>
                                    <option value="170620211">170620211 - TEST</option>
                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="list_id">List ID to Copy To</label>
                            </div>
                            <span class="error-msg">Error Msg</span>
                        </div>
                        <div class="my-dropdown-with-help col-6">
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
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary my-btn-secondary"
                        data-dismiss="modal">Cancel</button>
                    <input class="my-btn-primary" type="submit" value="submit">
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

                                <input type="text" class="form-control" id="campaign_id" name="list_id "
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
                                    <option value="12">12 - 12585274</option>
                                    <option value="Demo">Demo - DEMO Camp</option>
                                    <option value="ELISION">ELISION - ELISION TEST CAMPAIGN</option>
                                    <option value="LiveGren">LiveGren - Live Green BD</option>
                                    <option value="PENDULUM">PENDULUM - PENDULUM CAMP</option>
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
                    <input class="my-btn-primary" type="submit" value="submit" name="submit_list">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add user modal ends here -->