<?php
include "../include/userGroup.php";
include "../../../conf/db.php";
include "../../../conf/url_page.php";

$Adminuser = $_SESSION['user'];
$id = $_REQUEST['id'];

$sel = "SELECT user_id FROM `users` WHERE SuperAdmin='$Adminuser'";
$sql = mysqli_query($con, $sel);
$admin_user = [];

while($rowu = mysqli_fetch_assoc($sql)){
    $admin_user[] = $rowu['user_id'];
}

$admin_user_list = implode("','", $admin_user);

$select = "SELECT * FROM compaign_list WHERE id='$id'";
$sel_query = mysqli_query($con, $select);
$row_sel = mysqli_fetch_assoc($sel_query);
$camp_id = $row_sel['compaign_id'];

if(!empty($_REQUEST['id'])){
    $sel = "SELECT * FROM vicidial_group WHERE campaign_id='$camp_id'";
    } else {
        $sel = "SELECT vicidial_group.* FROM vicidial_group
    JOIN compaign_list ON compaign_list.compaign_id=vicidial_group.campaign_id WHERE compaign_list.admin IN ('$admin_user_list')";
    }
    $sel_q = mysqli_query($con, $sel);


if(isset($_POST['submit'])){

    $group_id = $_POST['group_id'];
    $group_name = $_POST['group_name'];
    $campaign_id = $_POST['campaign_id'];
    $presskey = $_POST['presskey'];
// die();
    $select1 = "SELECT * FROM `vicidial_group` WHERE group_id='$group_id' OR press_key='$presskey'";
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
  $sql_New = "INSERT INTO `vicidial_group`(`group_id`, `group_name`, `campaign_id`, `press_key`) VALUES ('$group_id','$group_name','$campaign_id','$presskey')";
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
            window.location.href = "' . $admin_ind_page . '?c=user_group&v=show_user_group&id=' . $id . '";
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
//    echo "</br>";

    $group_id = $_POST['group_id'];
    $group_name = $_POST['group_name'];
    $campaign_id = $_POST['campaign_id'];
    $presskey = $_POST['presskey'];
 $select1 = "SELECT * FROM `vicidial_group` WHERE id='$ind_id'";
    $sel_query1 = mysqli_query($con, $select1);
    if (mysqli_num_rows($sel_query1) > 0) {
       $r_data = mysqli_fetch_assoc($sel_query1);
        $o_pressk = $r_data['press_key'];
       $sql_New = "UPDATE `vicidial_group` SET `press_key`='$o_pressk' WHERE press_key='$presskey'";
       mysqli_query($con, $sql_New);
    }

// Create the SQL query string
//   $sql_New = "INSERT INTO `vicidial_group`(`group_id`, `group_name`, `campaign_id`, `press_key`) VALUES ('$group_id','$group_name','$campaign_id','$presskey')";
  $sql_New = "UPDATE `vicidial_group` SET `group_name`='$group_name',`campaign_id`='$campaign_id',`press_key`='$presskey' WHERE id='$ind_id'";

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
            window.location.href = "' . $admin_ind_page . '?c=user_group&v=show_user_group&id=' . $id . '";
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

<!-- =========Show User Groups Start -->
<div>
    <div class="show-users-group">

        <!-- this is the top navbar that containes add user, copy user, time sheet and search option -->
        <!-- <div class="my-nav">
            <ul>
                <li>
                    <a class="nav-active" href="#add-user-group" data-toggle="modal" data-target="#add-user-group"><i
                            class="fa fa-plus-circle" aria-hidden="true"></i>
                        Add Group</a>
                </li>
                <li>
                    <a href="#copy-user" data-toggle="modal" data-target="#copy-user"><i class="fa fa-clone"
                            aria-hidden="true"></i> Copy User-group</a>
                </li>
            </ul>
        </div> -->
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
                        <th scope="col"><a href="#">FORCE TIMECLOCK</a></th>
                        <th scope="col"><a href="#">ACTION</a></th>
                    </tr>
                </thead>
                <tbody>

                    <?php  while ($row = mysqli_fetch_assoc($sel_q)) {  
                       $group_id = $row['group_id'];
                        ?>

                    <tr></tr>
                    <td><?= $row['group_id'] ?></td>
                    <td><?= $row['group_name'] ?></td>
                    <td><?= $row['press_key'] ?></td>

                    <td><?= $row['campaign_id'] ?></td>
                    <td>
                        <div class="horizontal-container">

                            <!-- <i class="fa fa-pencil-square update_gp cursor_p" aria-hidden="true" data-toggle="modal"
                                data-target="#update-user-group" data-id="<?= $row['id'] ?>"
                                style="font-size:20px; color:blue;"></i> -->

                            <!-- add to campaing agent start -->
                            <!-- <div class="dropdown">
                                <img src="../assets/images/common-icons/addclint.png" alt="add_icon"
                                    style="height:23px; width:23px;"
                                    class=" shadow-sm best_font dropdown-toggle cursor_p" data-toggle="dropdown"
                                    aria-haspopup="true" title="Assign Department to agents" data-id="<?= $row['id'] ?>"
                                    data-compaignname="<?= $row['compaignname'] ?>">

                                <?php
                                               $sel_agent = "SELECT * FROM users WHERE admin='$Adminuser' AND user_id!='$Adminuser' ORDER BY id DESC";
                                            //  die();
                                              $agent_query = mysqli_query($con, $sel_agent);
                                              $num_scroller = mysqli_num_rows($agent_query);
                                              if($num_scroller >= '0' && $num_scroller <= '2' ){
                                              $hieght_scrol = '200px';
                                              } elseif($num_scroller > '2'){
                                               $hieght_scrol = '300px';
                                               }
                                               ?>
                                <div class="dropdown-menu"
                                    style="overflow: scroll; height: <?= $hieght_scrol ?>; width:auto"
                                    aria-labelledby="select-btn">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" class='cursor-p check-all'
                                                        id='<?= $row['user_id'] ?>'
                                                        data-uniqnumber='<?= $row['user_id'] ?>'>
                                                </th>
                                                <th>Agent Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
        
                                                    while ($agent_row = mysqli_fetch_array( $agent_query)) {
    
                                                     ?>

                                            <tr>
                                                <td><input type="checkbox" value="<?= $agent_row['id'] ?>"
                                                        class='cursor-p agent <?= $row['user_id'] ?>'>
                                                </td>
                                                <td><?= $agent_row['full_name'] ?></td>
                                            </tr>


                                            <?php } ?>
                                            <tr>
                                                <td colspan='2'><button
                                                        class="btn btn-md btn-primary shadow-sm best_font select-btn"
                                                        data-cnumber="<?= $row['group_id'] ?>"
                                                        data-cname="<?= $row['campaign_id'] ?>"
                                                        data-press_key="<?= $row['press_key'] ?>">assign</button>
                                                </td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div> -->

                            <!-- add to campaing agent start -->
                            <!-- show the all assin campaing agent start -->
                            <div class="dropdown">
                                <img src="../assets/images/common-icons/assign_agent.png" alt="add_icon"
                                    style="height:20px; width:27px;" class="cursor_p" data-toggle="dropdown"
                                    aria-haspopup="true" title="Review agents assigned Department">
                                <div class="dropdown-menu" aria-labelledby="select-btn">
                                    <table>
                                        <thead>
                                            <!-- <tr style="background-color: #3085d6;"> -->
                                            <tr>
                                                <th>Assign Agent</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                            $sel_agent1 = "SELECT * FROM group_agent where group_id='$group_id' ORDER BY id DESC";
                                                             $agent_query1 = mysqli_query($con, $sel_agent1);
                                                            while ($agent_row1 = mysqli_fetch_array( $agent_query1)) {
                                                            ?>

                                            <tr>

                                                <td><?= $agent_row1['agent_name'] ?></td>
                                            </tr>


                                            <?php } ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <a href="?c=user_group&v=show_group_agent&group_id=<?= $group_id ?>&id=<?= $id ?>">
                                <i class="fa fa-eye" aria-hidden="true" style="font-size:20px; color:#7B241C;"></i>
                            </a>
                            <!-- <i class="fa fa-trash remove_this_agent cursor_p" aria-hidden="true" style="font-size:24px; color:red;" data-id="<?= $row['id'] ?>" data-group_id="<?= $row['group_id'] ?>" data-pid="<?= $id?>" title='You can click here to remove agent'></i> -->
                        </div>
                    </td>
                    <?php } ?>

                </tbody>
            </table>
        </div>
        <!-- user list table ends -->

    </div>
</div>
<!-- =========Show User Groups End -->

<!-- Add user-group modal starts here -->
<div class="modal fade" id="add-user-group" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Group</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">
                                <input type="text" class="form-control" id="new-user-group" name="group_id"
                                    aria-describedby="user_group" required>
                                <label for="new-user-group">Group ID</label>
                            </div>
                            <!-- <span class="error-msg">Error Msg</span> -->
                        </div>
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">

                                <input type="text" class="form-control" id="group_name" name="group_name"
                                    aria-describedby="group_name" required>
                                <label for="group_name">Group Name</label>
                            </div>
                            <!-- <span class="error-msg">Error Msg</span> -->
                        </div>
                    </div>
                    <div class="row">
                        <?php if($_REQUEST['id']) { ?>
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">
                                <input type="text" class="form-control" id="new-user-group" name="campaign_id"
                                    aria-describedby="user_group" value="<?= $camp_id; ?>" readonly>
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
                                <input type="number" class="form-control" id="presskey" name="presskey"
                                    aria-describedby="presskey" required min="0" max="9"
                                    oninput="if(this.value.length > 1) this.value = this.value.slice(0, 1);">
                                <label for="new-user-group">Enter Press key</label>
                            </div>
                            <!-- <span class="error-msg">Error Msg</span> -->
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
            <form action="" method="post">
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
                                    $select1 = "SELECT vicidial_group.* FROM vicidial_group JOIN compaign_list ON compaign_list.compaign_id=vicidial_group.campaign_id WHERE compaign_list.admin='$Adminuser'";
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
                            } else if (data == '1') {

                                Swal.fire({
                                    title: "Assign Failed!",
                                    text: "Your Agent has been Assigned Failed ! Try Again",
                                    icon: "error"
                                });

                            } else {
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

        $.ajax({
            url: "pages/new_action/get_group.php",
            type: "POST",
            data: {
                id: id
            },
            dataType: "json", // Expect JSON response
            success: function(response) {
                // Check if response is not empty
                if ($.isEmptyObject(response)) {
                    console.log("No data found");
                } else {
                    // Populate the fields with the response
                    $("#id").val(response.id);
                    $("#newgroup_id").val(response.group_id);
                    $("#newgroup_name").val(response.group_name);
                    $("#new_camp_id").val(response.campaign_id);
                    $("#newpresskey").val(response.press_key);

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
                window.location.href = "pages/new_action/remove_group.php?id=" + id +
                    "&group_id=" + group_id;
            }
        });
    });

});
</script>




<!-- Add user-group modal End here -->