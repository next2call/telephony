<?php
session_start();
$user_level = $_SESSION['user_level'];

if($user_level == 2){
    $Adminuser = $_SESSION['admin'];
    $new_user = $_SESSION['user'];
} else {
    $Adminuser = $_SESSION['user'];
}
require '../include/user.php';
include "../../../conf/db.php";
include "../../../conf/url_page.php";
include "../../../conf/Get_time_zone.php";

$user = new user();
// $user = $Adminuser;
$usersql = "Select user,user_id, full_name, user_level, user_group, active from vicidial_users";
 
$usersql2 = "SELECT * FROM `dispo` WHERE admin='$Adminuser' ORDER BY id DESC"; 

// die();
$usersresult = mysqli_query($con, $usersql2);


$eUser = "";
$full_name = "";
// $user_level = "";
$user_group = "";
$pass = "";
$error = 0;

if (isset($_POST['add_user'])) {
    $disposition = $_POST['disposition'];
    $use_campaign = $_POST['use_campaign'];
    $status= '1';
    $date = date("Y-M-d");
    // Query to check if user exists in 'users' table
    // $user_id = $user->user;
    // $sel_check = "SELECT dispo FROM `dispo` WHERE dispo !='$disposition' AND admin='$Adminuser'";
    // die();
    // $quer_check = mysqli_query($con, $sel_check);
    
    // if (!$quer_check) {
    //     die('Error with query: ' . mysqli_error($con));
    // }
    

    // if (mysqli_num_rows($quer_check) > 0) {
        // echo "<script>alert('Data is already Inserted');</script>";
    //     echo '
    //     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
    //     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
    
    //     <script>
    //     Swal.fire({
    //         position: "top-end",
    //         icon: "error",
    //         title: "This Disposition has already been created !",
    //         confirmButtonText: "OK"
    //                 }).then(() => {
    //                     window.location.href = "'.$admin_ind_page.'?c=dashboard&v=disposition";
    //                 });
    //     </script>';
    // } else{

        // $data_ins="INSERT INTO `did_list`(`did`, `user`, `extension`, `status`) VALUES ('".$user->use_did."','".$user->user."','".$user->user."','1')";
        $data_ins="INSERT INTO `dispo`(`dispo`,`campaign_id`, `admin`, `ins_date`, `status`) VALUES ('$disposition','$use_campaign','$Adminuser','$date','$status')";
       $query_ins = mysqli_query($con, $data_ins);
// die();
   if($query_ins){
//    echo "<script>alert('Okey. data insert successfull')</script>";
   echo '
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
   
   <script>
   // var username = document.getElementById("floatingInput1").value;
   window.onload = function() {
     Swal.fire({
       title: "Add Disposition ",
       text: "Add Disposition is successful.",
       icon: "success",
       confirmButtonText: "OK"
    }).then(() => {
        window.location.href = "'.$admin_ind_page.'?c=dashboard&v=disposition";
    });
   }
   </script>';
   }else{
    // echo "<script>alert('Sorry')</script>";

    echo '
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
    
    <script>
    // var username = document.getElementById("floatingInput1").value;
    window.onload = function() {
      Swal.fire({
        title: "Failed",
        text: "Sorry, Data is not Inserted!",
        icon: "error",
        confirmButtonText: "OK"
                    }).then(() => {
                        window.location.href = "'.$admin_ind_page.'?c=dashboard&v=disposition";
                    });
    }
    </script>';
//    }

}
} else {
    $user->user = "";
    $user->full_name = "";
    $user->user_level = "";
    $user->user_group = "";
    $user->pass = "";
}

if(isset($_POST["update"])){
    $new_dispo=$_POST['new_dispo'];
    $new_id=$_POST['new_id'];
    // $date =date('Y-m-d');
    $Date = date("Y-m-d H:i:s", strtotime($date));
    $sel_check = "SELECT dispo FROM `dispo` WHERE dispo='$new_dispo' AND admin='$Adminuser'";
    // die();
    $quer_check = mysqli_query($con, $sel_check);
    if (mysqli_num_rows($quer_check) > 0) {
        // echo "<script>alert('Data is already Inserted');</script>";
        echo '
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
        <script>
        window.onload = function() {
            Swal.fire({
                icon: "error",
                title: "This Disposition has already been created !",
                confirmButtonText: "OK"
            }).then(() => {
                window.location.href = "'.$admin_ind_page.'?c=dashboard&v=disposition";
            });
        };                
        </script>';
    } else{    

    $Up_date="UPDATE `dispo` SET `dispo`='$new_dispo' WHERE id='$new_id'";
//    die();
   $update = mysqli_query($con, $Up_date);
   if($update) {
    echo '
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
                <script>
                window.onload = function() {
                    Swal.fire({
                        icon: "success",
                        title: "Disposition updated successfully.",
                        confirmButtonText: "OK"
                    }).then(() => {
                        window.location.href = "'.$admin_ind_page.'?c=dashboard&v=disposition";
                    });
                };                
                </script>';
    }
}
}


?>
<style>
.data_btn {
    background: #d1e1ff;
    color: #284f99;
    font-weight: bold;
    font-size: 12px;
    line-height: 22px;
    /* color: #637381; */
    /* background: transparent; */
    border-radius: 10px;
    padding: 8px;
    margin-right: 25px;
    transition: 0.3s all ease-in-out;
    margin-top: 25px;
    display: inline-block;
}

.data_btn1 {
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

.data_btn2 {
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
                    Add Disposition</a>
            </div>
            <table class="all-user-table table table-hover">
                <thead>
                    <tr>
                        <th scope="col"><a href="#">Sr.</a></th>
                        <th scope="col"><a href="#">Disposition Name</a></th>
                        <th scope="col"><a href="#">CAMPAIGN ID</a></th>
                        <th scope="col"><a href="#">STATUS</a></th>
                        <th scope="col"><a href="#">DATE</a></th>
                        <th scope="col"><a href="#">ACTION</a></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                  $sr=1;
                while ($usersrow = mysqli_fetch_array($usersresult)) {

                    echo '<tr>';
                    echo '<td>' . $sr . '</td>';
                    echo '<td>' . $usersrow['dispo'] . '</td>';
                     if(empty($usersrow['campaign_id'])){
                        echo '<td> No Campaign   </td>';
                     }else{
                        echo '<td>' . $usersrow['campaign_id'] . '</td>';
                     }

                           ?>
                    <td>
                        <a href="pages/new_action/edit_dispo.php?id=<?= $usersrow['id'] ?>">
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
                    echo '<td>' . $usersrow['ins_date'] . '</td>';
                    ?>
                    <td>
                        <!-- <span class="badge bg-primary cursor_p text-white contact_add"
                            data-id="<?Php echo $usersrow['id']; ?>" data-toggle="modal" data-target="#staticBackdrop"
                            title="Click here and add user name">Edit</span> -->
                        <a class='text-primary cursor_p contact_add' data-id="<?Php echo $usersrow['id']; ?>"
                            data-toggle="modal" data-target="#staticBackdrop" title="Click here and add user name"><i
                                class='fa fa-pencil-square' style='font-size:20px;'></i></a>
                            <?php
                                if ($user_level != 2) {
                                    ?>
                           <i class='fa fa-trash cursor_p text-danger mb-2 show_break_report' style='font-size:20px;'
                            data-id="<?Php echo $usersrow['id']; ?>"
                            title="You can click here to see why users take breaks"></i>
                         <?php }  ?>
                    </td>
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
                <h5 class="modal-title" id="exampleModalLabel">Add New Disposition</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">

                    <div class="row">
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">
                                <input type="text" class="form-control" id="full-name" name="disposition"
                                    aria-describedby="full-name" required>
                                <label for="full-name">Type disposition here</label>
                            </div>
                        </div>
                        <div class="my-dropdown-with-help col-6">
                            <div class="my-dropdown">
                                <select name="use_campaign" id="use_campaign">
                                <option value=" ">----Select Campaign ID---</option>

                                    <?php
                                        $sel_check_one = "SELECT * FROM `compaign_list` WHERE admin='$Adminuser'";
                                        $quer_check_one = mysqli_query($con, $sel_check_one);
                                        while($row_one = mysqli_fetch_assoc($quer_check_one)){
                                            $campaign_name = $row_one['compaignname'];
                                            $compaign_id = $row_one['compaign_id'];
                                            
                                            ?>
                                    <option value="<?= $compaign_id; ?>"><?= $compaign_id; ?></option>
                                    <?php }   ?>
                                    <option value=" ">None</option>

                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="campaign_description">Select Campaign ID</label>
                            </div>
                        </div>
                        <!-- <div class="my-input-with-help col-6">
                            <div class="form-group my-input">

                                <input type="text" class="form-control" id="full-name" name="full_name"
                                       aria-describedby="full-name" required>
                                <label for="full-name">Full Name</label>
                            </div>

                        </div> -->


                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary my-btn-secondary" data-dismiss="modal">Cancel
                    </button>
                    <input class="my-btn-primary" type="submit" value="submit" name="add_user">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add user modal ends here -->
<!-- Add user name for user id modal ends here -->
<!-- Modal -->
<!-- add disposition open form  -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Disposition</h5>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Disposition Name</label>
                        <input type="text" class="form-control" id="edit_name_c" name="new_dispo" required>
                    </div>
                    <div class="mb-3">
                        <!-- <label for="number" class="form-label">Your Number</label> -->
                        <input type="hidden" class="form-control" id="c_number" name="new_id" readonly>
                    </div>
                    <button type="submit" class="btn btn-success" name="update">Update</button>
                    <!-- Add an ID to the close button -->
                    <button type="button" class="btn btn-warning" id="closeModalButton" data-bs-dismiss="modal"
                        aria-label="Close">Close</button>

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
        $("#edit_name_c").val(""); // Clear the field before making the request
        $.ajax({
            url: "pages/new_action/get_dispo.php", // URL to your PHP file
            type: "POST",
            data: {
                cnumber: cnumber
            },
            success: function(response) {
                // alert(response);
                $("#edit_name_c").val(response);
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
                window.location.href = "pages/new_action/dispo_delete.php?id=" +
                    id // Redirect to block.php with the 'id' query string
            }
        });
    });

});
</script>