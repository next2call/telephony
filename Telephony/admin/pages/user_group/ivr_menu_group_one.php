<?php
include "../include/userGroup.php";
include "../../../conf/db.php";
include "../../../conf/url_page.php";
include "../../../conf/Get_time_zone.php";


$user_level = $_SESSION['user_level'];

if($user_level == 2){
    $Adminuser = $_SESSION['admin'];
    $new_user = $_SESSION['user'];
} else {
    $Adminuser = $_SESSION['user'];
}
$menu_id_get = $_REQUEST['menu_id'];

if(isset($_REQUEST['menu_id'])){
    $menu_id_get = $_REQUEST['menu_id'];
    $camp_id_get = $_REQUEST['camp_id'];

    $select_da = "SELECT * FROM menu_ivr_tbl1 WHERE menu_id='$menu_id_get'";
    $sel_query_n = mysqli_query($con, $select_da);
    $row_sel_on = mysqli_fetch_assoc($sel_query_n);
    $camp_id = $row_sel_on['compaign_id'];   
}



$id = $_REQUEST['id'];

$select = "SELECT * FROM compaign_list WHERE id='$id'";
$sel_query = mysqli_query($con, $select);
$row_sel = mysqli_fetch_assoc($sel_query);
$camp_id = $row_sel['compaign_id'];

if(!empty($_REQUEST['id'])){
    $sel = "SELECT * FROM menu_ivr_tbl2 WHERE campaign_id='$camp_id'";
    } else {
        $sel = "SELECT menu_ivr_tbl2.* FROM menu_ivr_tbl2
    JOIN compaign_list ON compaign_list.compaign_id=menu_ivr_tbl2.campaign_id WHERE compaign_list.admin='$Adminuser'";
    }

    // die();
    $sel_q = mysqli_query($con, $sel);


if(isset($_POST['submit'])){

    $group_id = $_POST['group_id'];
    $group_name = $_POST['group_name'];
    $campaign_id = $_POST['campaign_id'];
    $presskey = $_POST['presskey'];
    $menu_ivr = $_FILES['menu_ivr']['name'];
    $menu_ivr_temp = $_FILES['menu_ivr']['tmp_name'];
    $group_wise = $_POST['group_wise'];
    $target_directory = 'ivr/';  // Define your target directory

    // Check if directory exists, if not create it
    if (!is_dir($target_directory)) {
        mkdir($target_directory, 0777, true);
    }
    
    if (!empty($menu_ivr)) {
        $menu_ivr_path = $target_directory . uniqid() . '.wav';
        
        // Move the uploaded file to the target directory
        move_uploaded_file($menu_ivr_temp, $menu_ivr_path);
            // echo "<script>alert('Uploaded successfully');</script>";
        
    }
    
    // $select1 = "SELECT * FROM `vicidial_group` WHERE group_id='$group_id' OR press_key='$presskey'";
    $select1 = "SELECT menu_ivr_tbl2.* FROM `menu_ivr_tbl2` JOIN compaign_list ON compaign_list.compaign_id=menu_ivr_tbl2.campaign_id WHERE (menu_ivr_tbl2.menu_id='$group_id' OR menu_ivr_tbl2.press_key='$presskey') AND compaign_list.admin='$Adminuser'";
    $sel_query1 = mysqli_query($con, $select1);

    if (mysqli_num_rows($sel_query1) > 0) {
      echo '
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
      
      <script>
      // var username = document.getElementById("floatingInput1").value;
      window.onload = function() {
        Swal.fire({
          title: "Failed",
          text: "Sorry, this Group Id or Press Key already exists", 
          icon: "error",
          confirmButtonText: "OK"
        });
      }
      </script>';
    } else {
// Create the SQL query string
  $sql_New = "INSERT INTO `menu_ivr_tbl2`(`menu_id`, `menu_name`, `campaign_id`, `press_key`, `ivr_file`, `menu_ivr_id`, `ivr`) VALUES ('$group_id','$group_name','$campaign_id','$presskey','$menu_ivr_path','$menu_id_get','$group_wise')";

// $sql_New = "INSERT INTO `vicidial_group`(`group_id`, `group_name`, `campaign_id`, `press_key`, `ivr_file1`, `ivr`) VALUES ()";
// die();
$insert =mysqli_query($con, $sql_New);

    if($insert){
        // header("Location:/vicidial-master/admin/index.php?c=campaign&v=campaign_list");
        // $msg = 1;
        echo '
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
        <script>
        window.onload = function() {
            Swal.fire({
                icon: "success",
                title: "Group creation successful",
                confirmButtonText: "OK"
            }).then(() => {
            window.location.href = "' . $admin_ind_page . '?c=user_group&v=ivr_menu_group_one&id=' . $id . '";
            });
        };                
        </script>';
        // exit; // Ma
    }else{
        $msg=2;
    }

}
}
################################### group update start code #############################################################
if(isset($_POST['update'])){

    $ind_id = $_POST['ind_id'];
    $group_id = $_POST['group_id'];
    $group_name = $_POST['group_name'];
    $campaign_id = $_POST['campaign_id'];
    $presskey = $_POST['presskey'];
    $menu_ivr = $_FILES['menu_ivr']['name'];
    $menu_ivr_temp = $_FILES['menu_ivr']['tmp_name'];
    $group_wise = $_POST['group_wise'];
    $target_directory = 'ivr/';  


 $select1 = "SELECT * FROM `menu_ivr_tbl2` WHERE id='$ind_id'";
    $sel_query1 = mysqli_query($con, $select1);
    if (mysqli_num_rows($sel_query1) > 0) {
       $r_data = mysqli_fetch_assoc($sel_query1);
        $o_pressk = $r_data['press_key'];
       $sql_New = "UPDATE `menu_ivr_tbl2` SET `press_key`='$o_pressk' WHERE press_key='$presskey'";
       mysqli_query($con, $sql_New);
    }

    if (!is_dir($target_directory)) {
        mkdir($target_directory, 0777, true);
    }
    if (!empty($menu_ivr)) {
        $menu_ivr_path = $target_directory . uniqid() . '.wav';
        move_uploaded_file($menu_ivr_temp, $menu_ivr_path);
    }
    

// Create the SQL update query
 $sql_New = "UPDATE `menu_ivr_tbl2` 
            SET `menu_name` = '$group_name', 
                `campaign_id` = '$campaign_id', 
                `press_key` = '$presskey', 
                `ivr` = '$group_wise'";

// If the menu_ivr_path is not empty, add the ivr_file to the update query
if (!empty($menu_ivr_path)) {
    $sql_New .= ", `ivr_file` = '$menu_ivr_path'";
}

// Add the WHERE clause to the query
$sql_New .= " WHERE id = '$ind_id'";

// die();
$insert =mysqli_query($con, $sql_New);

    if($insert){
        
        // header("Location:/vicidial-master/admin/index.php?c=campaign&v=campaign_list");
        // $msg = 1;
        echo '
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
        <script>
        window.onload = function() {
            Swal.fire({
                icon: "success",
                title: "Group Update successful",
                confirmButtonText: "OK"
            }).then(() => {
            window.location.href = "' . $admin_ind_page . '?c=user_group&v=ivr_menu_group_one&id=' . $id . '";
            });
        };                
        </script>';
        // exit; // Ma
    }else{
        $msg=2;
    }

// }
}
################################### group update start code #############################################################
?>
<style>
    .horizontal-container {
    display: flex;
    align-items: center;
    justify-content: space-around;
}

.horizontal-container img {
    /* margin: 0 4px; */
}

</style>
<style>
.audio-player-container {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 20px;
}

.audio-player {
    display: none;
    /* Hide the default audio player */
}

.control {
    background-color: #4CAF50;
    /* Green background */
    border: none;
    color: white;
    padding: 0px 10px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 12px;
    margin: 1px 0.5px;
    cursor: pointer;
    border-radius: 8px;
    /* Rounded corners */
    transition: background-color 0.3s ease;
}

.control:hover {
    background-color: #2718d6;
    /* Darker green on hover */
}

.control:focus {
    outline: none;
}

#play-pause-icon {
    font-size: 10px;
}
</style>
<!-- =========Show User Groups Start -->
<div>
    <div class="show-users-group">

        <!-- this is the top navbar that containes add user, copy user, time sheet and search option -->
        <div class="my-nav">
            <ul>
                <li>
                    <a class="nav-active" href="#add-menu-ivr" data-toggle="modal" data-target="#add-menu-ivr"><i
                            class="fa fa-plus-circle" aria-hidden="true"></i>
                        ADD NEW IVR MENU</a>
                </li>
            </ul>
        </div>
        <!-- this is where top navbar ends -->

        <!-- user list table start -->
        <div class="table-responsive my-table">
            <div class="table-top">
                <h4>USER GROUPS LISTINGS</h4>
            
            </div>
            <table class="all-user-table table table-hover">
                <thead>
                    <tr>
                        <th scope="col"><a href="#">USER GROUP</a></th>
                        <th scope="col"><a href="#">GROUP NAME</a></th>
                        <th scope="col"><a href="#">PRESS KEY</a></th>
                        <th scope="col"><a href="#">CAMPAIGN ID</a></th>
                        <th scope="col"><a href="#">IVR FILE</a></th>
                        <th scope="col"><a href="#">ACTION</a></th>
                    </tr>
                </thead>
                <tbody>

                    <?php  while ($row = mysqli_fetch_assoc($sel_q)) {  
                       $menu_id = $row['menu_id'];
                       $ivr_type = $row['ivr'];
                    //  echo '/'.$main_folder.'/admin/'.$ivr_file = $row['ivr_file'];
                    //    die();
                        ?>
                           
                   <tr></tr><td><?= $row['menu_id'] ?></td>
                    <td><?= $row['menu_name'] ?></td>
                    <td><?= $row['press_key'] ?></td>

                    <td><?= $row['campaign_id'] ?></td>
                 <?php 
                     if(empty($row['ivr_file'])){
                        echo '<td>Empty</td>';
                        }else{
                          echo '<td>
                          <audio class="audio-player" id="myTune">
                          <source src="/'.$main_folder.'/admin/' . $row['ivr_file'] . '" type="audio/wav">
                    
                          </audio>
                          <button class="control" type="button" onclick="aud_play_pause(this.previousElementSibling)">
                                      <span id="play-pause-icon" style="color:green;">▶</span>
                                   </button>
  
                      </td>';
                        }
                    
                      ?>
                    <td>
                   <?php if($ivr_type == '1'){ ?> 

                                                 <i class="fa fa-recycle group_wised_one cursor_p" aria-hidden="true" data-menu_id="<?= $row['menu_id'] ?>" style="font-size:20px; color:green;"></i>
                                                 &nbsp;&nbsp;
                                                 <i class="fa fa-pencil-square update_gp cursor_p" aria-hidden="true" data-toggle="modal" data-target="#update-user-group" data-id="<?= $row['id'] ?>" style="font-size:20px; color:blue;"></i>
                                                 &nbsp;&nbsp;
                                                <i class="fa fa-trash remove_this_agent cursor_p" aria-hidden="true" style="font-size:24px; color:red;" data-id="<?= $row['id'] ?>" data-group_id="<?= $row['menu_id'] ?>" data-pid="<?= $id?>" title='You can click here to remove agent'></i>
                    </div>                            <!-- show the all assin campaing agent end -->
                    <?php }else if($ivr_type == '2'){ ?> 
                        <i class="fa fa-repeat ivr_menu_group cursor_p" style="font-size:20px; color:blue;" data-toggle="modal" data-target="#add-menu-ivr"></i> &nbsp;&nbsp;
                        <i class="fa fa-pencil-square update_gp cursor_p" aria-hidden="true" data-toggle="modal" data-target="#update-user-group" data-id="<?= $row['id'] ?>" style="font-size:20px; color:blue;"></i>
                        &nbsp;&nbsp;
                        <i class="fa fa-trash remove_this_agent cursor_p" aria-hidden="true" style="font-size:24px; color:red;" data-id="<?= $row['id'] ?>" data-group_id="<?= $row['menu_id'] ?>" data-pid="<?= $id?>" title='You can click here to remove agent'></i>
                    <?php } ?>
                </td>
               <?php } ?>

                </tbody>
            </table>
        </div>

    </div>
</div>
<!-- =========Show User Groups End -->

<!-- Add user-group modal starts here -->
<div class="modal fade" id="add-menu-ivr" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New IVR Menu </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">
                                <input type="text" class="form-control" id="new-user-group" name="group_id"
                                    aria-describedby="user_group" required>
                                <label for="new-user-group">Menu ID</label>
                            </div>
                            <!-- <span class="error-msg">Error Msg</span> -->
                        </div>
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">

                                <input type="text" class="form-control" id="group_name" name="group_name"
                                    aria-describedby="group_name" required>
                                <label for="group_name">Menu Name</label>
                            </div>
                            <!-- <span class="error-msg">Error Msg</span> -->
                        </div>
                    </div>
                    <div class="row">
                        <?php if($_REQUEST['menu_id']) { ?>
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">
                                <input type="text" class="form-control" id="new-user-group" name="frist_menu_id"
                                    aria-describedby="user_group" value="<?= $menu_id_get; ?>" readonly>
                                <label for="new-user-group">Frist Menu ID</label>
                            </div>
                            <!-- <span class="error-msg">Error Msg</span> -->
                        </div>
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">
                                <input type="text" class="form-control" id="new-user-group" name="campaign_id"
                                    aria-describedby="user_group" value="<?= $camp_id_get; ?>" readonly>
                                <label for="new-user-group">Campaign ID</label>
                            </div>
                            <!-- <span class="error-msg">Error Msg</span> -->
                        </div>
                        <?php } else{ ?>
                            <div class="my-dropdown-with-help col-6">
                            <div class="my-dropdown">
                                <select name="campaign_id" id="new-user-group" required>
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
                                <label for="source_campaign_id">Campaign Name</label>
                            </div>
                        </div>
                        <?php } ?>


                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">
                            <input type="number" class="form-control" id="presskey"
                                name="presskey" aria-describedby="presskey" required
                                min="0" max="9" oninput="if(this.value.length > 1) this.value = this.value.slice(0, 1);">
                                <label for="new-user-group">Enter Press key</label>
                            </div>
                        </div>

                            <div class="my-dropdown-with-help col-6">
                            <div class="my-dropdown">
                                <select name="group_wise" id="new-user-group" required>
                                    <option value='1'>GROUP</option>
                                    <!-- <option value='2'>CALL MENU</option>                                </select> -->
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="source_campaign_id">Campaign Call Route</label>
                            </div>
                        </div>

                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">
                            <input type="file" class="form-control" id="file"
                                name="menu_ivr" aria-describedby="menu_ivr" required>
                                <label for="new-user-group">Menu Prompt</label>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary my-btn-secondary" data-dismiss="modal">Cancel
                    </button>
                    <input class="my-btn-primary" type="submit" value="submit" name="submit">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- #############################################Edit this group################################## -->
<div class="modal fade" id="update-user-group" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Group</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-body">

                    <div class="row">
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">
                                <input type="hidden" id="id" name="ind_id">
                                <input type="text" class="form-control" id="newgroup_id" name="group_id"
                                    aria-describedby="user_group" readonly>
                                <label for="new-user-group">Group ID</label>
                            </div>
                            <!-- <span class="error-msg">Error Msg</span> -->
                        </div>
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">

                                <input type="text" class="form-control" id="newgroup_name" name="group_name"
                                    aria-describedby="group_name" required>
                                <label for="group_name">Group Name</label>
                            </div>
                            <!-- <span class="error-msg">Error Msg</span> -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="my-dropdown-with-help col-6">
                            <div class="my-dropdown">
                                <select id="new_camp_id" name="campaign_id" required>
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
                                <label for="source_campaign_id">Campaign Name</label>
                            </div>
                        </div>
                    
                        <div class="my-dropdown-with-help col-6">
                            <div class="my-dropdown">
                                <select id="newpresskey" name="presskey" required>
                                    <?php 
                                    $select1 = "SELECT menu_ivr_tbl2.* FROM menu_ivr_tbl2 JOIN compaign_list ON compaign_list.compaign_id=menu_ivr_tbl2.campaign_id WHERE compaign_list.admin='$Adminuser'";
                                    $sel_query1 = mysqli_query($con, $select1);
                                    while($roow_camp = mysqli_fetch_assoc($sel_query1)){ 
                                        $press_key = $roow_camp['press_key'];
                                        ?>
                                    <option value="<?= $press_key ?>"><?= $press_key ?></option>
                                    <?php } ?>
                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="source_campaign_id">Your Press Key</label>
                            </div>
                        </div>
                        <div class="my-dropdown-with-help col-6">
                            <div class="my-dropdown">
                                <select name="group_wise" id="new-user-groupone">
                                    <option value='1'>GROUP</option>
                                    <!-- <option value='2'>CALL MENU</option>                                </select> -->
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="source_campaign_id">Campaign Call Route</label>
                            </div>
                        </div>

                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">
                            <input type="file" class="form-control" id="file_new"
                                name="menu_ivr" aria-describedby="menu_ivr" >
                                <label for="new-user-group">Menu Prompt</label>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary my-btn-secondary" data-dismiss="modal">Cancel
                    </button>
                    <input class="my-btn-primary" type="submit" value="submit" name="update">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- #############################################Edit this group################################## -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('.check-all').on('change', function() {
            var uniqnumber = $(this).data('uniqnumber');
            $('.' + uniqnumber).prop('checked', $(this).prop('checked')); 
        });
    });

    $(".select-btn").on("click", function() {
        var cam_number = $(this).data("cnumber");
        var camp_id = $(this).data("cname");
        var press_key = $(this).data("press_key");
        var id = [];
// alert(cam_number);
// alert(camp_id);
        $(":checkbox:checked.agent").each(function(key) {
            id[key] = $(this).val();
        });
        // alert(id);

        if (id.length === 0) {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "error",
                title: "Please Select at least one checkbox! Try Again!"
            });
        } else {
            if (cam_number != "" && id.length > 0) {
                Swal.fire({
                    title: "Are you sure?",
                    text: "Do you really want to Forward these records?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Forward it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/<?php echo $main_folder; ?>/admin/pages/user_group/forward_agent.php",
                            type: "POST",
                            data: {
                                id: id,
                                number: cam_number,
                                camp_id: camp_id,
                                press_key: press_key
                            },
                            success: function(data) {
                                // alert(data);
                                if (data == '2') {
                                    // window.location.href='national-post.php';alert('Data Deleted Successfully.');
                                    Swal.fire({
                                        title: "Assign!",
                                        text: "Your Agent has been Assigned Successfull!",
                                        icon: "success",
                                        confirmButtonText: "OK"
                                    });
                                } else if(data == '1') {

                                    Swal.fire({
                                        title: "Assign Failed!",
                                        text: "Your Agent has been Assigned Failed ! Try Again",
                                        icon: "error"
                                    });

                                }else{
                                    Swal.fire({
                                        title: "Assign Failed!",
                                        text: "Your Agent has been already Assigned This Group",
                                        icon: "error"
                                    });

                                }
                                // console.log(data);
                              

                            }
                        });
                    }
                });
            }
        }
    });
</script>
<script>
$(document).ready(function() {
    $(document).on("click", ".update_gp", function() {
        var id = $(this).data("id");
        // alert(id);

        $("#id").val("");
        $("#newgroup_id").val("");
        $("#newgroup_name").val("");
        $("#new_camp_id").val("");
        $("#newpresskey").val("");
        $("#new-user-groupone").val("");
        $("#file_new").val("");

        $.ajax({
            url: "pages/new_action/get_menu_grouptwo.php",
            type: "POST",
            data: { id: id },
            dataType: "json", // Expect JSON response
            success: function(response) {
                // Check if response is not empty
                if ($.isEmptyObject(response)) {
                    console.log("No data found");
                } else {
                    // Populate the fields with the response
                    $("#id").val(response.id);
                    $("#newgroup_id").val(response.menu_id);
                    $("#newgroup_name").val(response.menu_name);
                    $("#new_camp_id").val(response.campaign_id);
                    $("#newpresskey").val(response.press_key);
                    $("#new-user-groupone").val(response.ivr);
                    $("#file_new").val(response.ivr_file);

                }
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
    $(document).on("click", ".remove_this_agent", function() {
        var id = $(this).data("id");
        var group_id = $(this).data("group_id");
        var pid = $(this).data("pid");
    // alert(id);  
    // alert(group_id);  
    // alert(pid);  
    Swal.fire({
        title: "Are you sure?",
        text: "This Agent remove for Group",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "pages/new_action/remove_menu_group_two.php?id=" + id + "&group_id=" + group_id + "&pid=" + pid;
        }
    });
  });

});

</script>

<script>
var currentAudio = null;

function aud_play_pause(audio) {
    if (currentAudio !== audio) {
        if (currentAudio) {
            currentAudio.pause();
            var currentPlayPauseIcon = currentAudio.nextElementSibling.querySelector('.control span');
            currentPlayPauseIcon.textContent = '▶'; // Reset the icon
        }
        currentAudio = audio;
    }

    if (audio.paused) {
        audio.play();
        var playPauseIcon = audio.nextElementSibling.querySelector('.control span');
        playPauseIcon.textContent = '⏸';
        consol.log('playPauseIcon');
    } else {
        audio.pause();
        var playPauseIcon = audio.nextElementSibling.querySelector('.control span');
        playPauseIcon.textContent = '▶';
    }
}
</script>
<script>
$(document).ready(function() {
    $(document).on("click", ".group_wised_one", function() {
        var menu_id = $(this).data("menu_id");
        // alert(menu_id);
        window.location.href = "?c=user_group&v=show_user_menu_group&menu_id=" + menu_id;
    });
});
</script>
<!-- Add user-group modal End here -->