<?php
include '../include/userGroup.php';

$userGroup = new userGroup();


if (isset($_POST['submitstatus'])) {
    $abc = $_POST;
//    $userGroup->old_group = $_POST[old_group];
//    $userGroup->group = $_POST[group];
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

$userGroup->old_group= $_POST['old_group'];
$userGroup->group= $_POST['group'];

$sql = "UPDATE vicidial_user_groups SELECT old_group='".$userGroup->old_group."',
group='".$userGroup->group."' WHERE  "  ;

$result = mysqli_query($conn, $sql);



}
?>


<!--===========User Group Bulk Change: New Page Tazbin Ahad	 -->
<div class="user-stats group-hourly-stats">
    <!-- back button with title -->
    <div class="back-with-title">
        <a href="./show_users.html"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        <h5>User Group Bulk Change</h5>
    </div>

    <!-- form starts here -->
    <form action="" method="POST">
        <div class="my-card-with-title">
            <div class="card-body">
                <div class="row justify-content-start align-items-center">
                    <div class="col-lg-6 col-md-12">
                        <div class="row justify-content-center">
                            <div class="my-dropdown-with-help col-12 col-md-6 col-lg-12 flex-column">
                                <h5>Change Users in this group</h5>

                                <div class="my-dropdown">
                                    <select name="old_group" id="old_group">
                                        <option selected="" value="ADMIN">ADMIN - VICIDIAL ADMINISTRATORS</option>
                                        <option selected="" value="AGENTS">AGENTS - VICIDIAL AGENTS</option>
                                        <option selected="" value="CUSTOM-ADMIN">CUSTOM-ADMIN - CUSTOM-ADMIN</option>
                                    </select>
                                    <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                    <label for="old_group"
                                        style="font-size: 100%; transform: translate3d(0px, -40%, 0px); opacity: 0.5; background-color: transparent; padding: 15px 0px 0px 13px; z-index: 0;"></label>
                                </div>
                            </div>
                            <div class="my-input-with-help col-12 col-md-6 col-lg-12 align-items-center ">
                                <h5>to this group</h5>
                                <div class="my-dropdown">
                                    <select name="group" id="group">
                                        <option selected="" value="ADMIN">ADMIN - VICIDIAL ADMINISTRATORS</option>
                                        <option selected="" value="AGENTS">AGENTS - VICIDIAL AGENTS</option>
                                        <option selected="" value="CUSTOM-ADMIN">CUSTOM-ADMIN - CUSTOM-ADMIN</option>
                                    </select>
                                    <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                    <label for="group"
                                        style="font-size: 100%; transform: translate3d(0px, -40%, 0px); opacity: 0.5; background-color: transparent; padding: 15px 0px 0px 13px; z-index: 0;"></label>
                                </div>
                            </div>
                            <input type="submit" value="Submit" class=" my-btn-primary" name="submitstatus">
                        </div>

                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="row justify-content-center ">
                            <div class="my-dropdown-with-help col-sm-12 col-md-6 col-lg-12 flex-column">
                                <h5>Change ALL non-Admin Users to this group:
                                </h5>

                                <div class="my-dropdown">
                                    <select name="group" id="group">
                                        <option selected="" value="ADMIN">ADMIN - VICIDIAL ADMINISTRATORS</option>
                                        <option selected="" value="AGENTS">AGENTS - VICIDIAL AGENTS</option>
                                        <option selected="" value="CUSTOM-ADMIN">CUSTOM-ADMIN - CUSTOM-ADMIN</option>
                                    </select>
                                    <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                    <label for="group"
                                        style="font-size: 100%; transform: translate3d(0px, -40%, 0px); opacity: 0.5; background-color: transparent; padding: 15px 0px 0px 13px; z-index: 0;"></label>
                                </div>
                            </div>
                            <input type="submit" value="Submit" class=" my-btn-primary" name="submitstatus">
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </form>
</div>
<!--===========User Group Bulk Change: New Page Tazbin Ahad	 -->