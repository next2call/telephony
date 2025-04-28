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
$usersql2 = "SELECT * FROM `block_no` WHERE admin='$Adminuser'";
$usersresult = mysqli_query($con, $usersql2);

$eUser = "";
$full_name = "";
$user_group = "";
$pass = "";
$error = 0;

if (isset($_POST['add_user'])) {
    $block_no = $_POST['block_no'];
    $status = '1';
    $date = date("Y-m-d H:i:s");

    $data_ins = "INSERT INTO `block_no` (`block_no`, `admin`, `ins_date`, `status`) VALUES ('$block_no', '$Adminuser', '$date', '$status')";
    $query_ins = mysqli_query($con, $data_ins);
    
    if($query_ins){
        echo '
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
        <script>
        window.onload = function() {
            Swal.fire({
                title: "Add Block No.",
                text: "Block No. added successfully.",
                icon: "success",
                confirmButtonText: "OK"
            }).then(() => {
                window.location.href = "'.$admin_ind_page.'?c=dashboard&v=block_no";
            });
        }
        </script>';
    } else {
        echo '
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
        <script>
        window.onload = function() {
            Swal.fire({
                title: "Failed",
                text: "Sorry, data was not inserted!",
                icon: "error",
                confirmButtonText: "OK"
            }).then(() => {
                window.location.href = "'.$admin_ind_page.'?c=dashboard&v=block_no";
            });
        }
        </script>';
    }
}

if(isset($_POST["update"])){
    $new_block_no = $_POST['new_block_no'];
    $new_id = $_POST['new_id'];
    $date = date("Y-m-d H:i:s");
    $sel_check = "SELECT block_no FROM `block_no` WHERE block_no='$new_block_no' AND admin='$Adminuser'";
    $quer_check = mysqli_query($con, $sel_check);

    if (mysqli_num_rows($quer_check) > 0) {
        echo '
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
        <script>
        window.onload = function() {
            Swal.fire({
                icon: "error",
                title: "This Block No. has already been created!",
                confirmButtonText: "OK"
            }).then(() => {
                window.location.href = "'.$admin_ind_page.'?c=dashboard&v=block_no";
            });
        }
        </script>';
    } else {    
        $Up_date = "UPDATE `block_no` SET `block_no`='$new_block_no' WHERE id='$new_id'";
        $update = mysqli_query($con, $Up_date);
        
        if($update) {
            echo '
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
            <script>
            window.onload = function() {
                Swal.fire({
                    icon: "success",
                    title: "Block No. updated successfully.",
                    confirmButtonText: "OK"
                }).then(() => {
                    window.location.href = "'.$admin_ind_page.'?c=dashboard&v=block_no";
                });
            }
            </script>';
        }
    }
}

if(isset($_POST['delete_id'])){
    $delete_id = $_POST['delete_id'];
    $delete_sql = "DELETE FROM `block_no` WHERE id='$delete_id'";
    $delete_result = mysqli_query($con, $delete_sql);

    if($delete_result){
        echo 'success';
    } else {
        echo 'error';
    }
    exit();
}

if(isset($_POST['activate_id'])){
    $activate_id = $_POST['activate_id'];
    $status = $_POST['status_id'];
    if($status == '1'){
        $activate_sql = "UPDATE `block_no` SET status='0' WHERE id='$activate_id'";
    }else{
        $activate_sql = "UPDATE `block_no` SET status='1' WHERE id='$activate_id'";
    }
// die();
    $activate_result = mysqli_query($con, $activate_sql);

    if($activate_result){
        echo 'success';
    } else {
        echo 'error';
    }
    exit();
}

?>

    <style>
        .data_btn, .data_btn1, .data_btn2 {
            background: #d1e1ff;
            color: #284f99;
            font-weight: bold;
            font-size: 12px;
            line-height: 22px;
            border-radius: 10px;
            padding: 8px;
            margin-right: 25px;
            transition: 0.3s all ease-in-out;
            margin-top: 25px;
            display: inline-block;
        }
    </style>

<div class="show-users ml-5">
    <div class="table-responsive my-table ml-5">
        <div class="table-top">
            <a class="data_btn" href="#add-user" data-toggle="modal" data-target="#add-user">
                <i class="fa fa-plus-circle" aria-hidden="true"></i> Add Block
            </a>
        </div>
        <table class="all-user-table table table-hover">
            <thead>
                <tr>
                    <th scope="col"><a href="#">Sr.</a></th>
                    <th scope="col"><a href="#">Block No.</a></th>
                    <th scope="col"><a href="#">Status</a></th>
                    <th scope="col"><a href="#">Date</a></th>
                    <th scope="col"><a href="#">Action</a></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sr = 1;
                while ($usersrow = mysqli_fetch_array($usersresult)) {
                    echo '<tr>';
                    echo '<td>' . $sr . '</td>';
                    echo '<td>' . $usersrow['block_no'] . '</td>';
                    echo '<td>';
                    if ($usersrow['status'] == '1') {
                        echo '<span class="active-no cursor_p activate-block" data-id="' . $usersrow['id'] . '" data-status="' . $usersrow['status'] . '" title="This number is blocked. If you click here, this number will be activated for calling.">Blocked</span>';
                    } else {
                        echo '<span class="active-yes cursor_p activate-block" data-id="' . $usersrow['id'] . '" data-status="' . $usersrow['status'] . '" title="This number is activated. If you click here, this number will be blocked for calling.">Active</span>';

                    }
                    echo '</td>';
                    echo '<td>' . $usersrow['ins_date'] . '</td>';
                    echo '<td>';
                    echo '<i class="fa fa-trash cursor_p text-danger mb-2 delete-block" style="font-size:20px;" data-id="' . $usersrow['id'] . '" title="Click here to delete this number."></i>';
                    echo '</td>';
                    echo '</tr>';
                    $sr++;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="add-user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Block No.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <div class="form-group my-input">
                        <label for="block_no">Block No.</label>
                        
                          <input type="text" class="form-control" id="block_no" name="block_no"
                                    aria-describedby="block_no" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                    maxlength="12" required> 
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="add_user" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Update Block No.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <input type="hidden" name="new_id" id="new_id">
                    <div class="form-group">
                        <label for="new_block_no">Block No.</label>
                        <input type="text" class="form-control" id="new_block_no" name="new_block_no" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
<script>
$(document).ready(function() {
    $('.delete-block').on('click', function() {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '', // Keep it empty to target the same file
                    type: 'POST',
                    data: { delete_id: id },
                    success: function(response) {
                        console.log("Response from server: " + response); // Debugging line    
                                window.location.reload();    
                    },
                    error: function(xhr, status, error) {
                        console.log("AJAX error: " + error); // Debugging line
                        Swal.fire(
                            'Error!',
                            'Failed to delete Block No.',
                            'error'
                        );
                    }
                });
            }
        });
    });

    $('.activate-block').on('click', function() {
        var id = $(this).data('id');
        var status = $(this).data('status');
        // alert(id);
        // alert(status);
        $.ajax({
            url: '', // Keep it empty to target the same file
            type: 'POST',
            data: { activate_id: id, status_id: status },
            success: function(response) {
                console.log("Response from server: " + response); // Debugging line
                    Swal.fire(
                        'Activated!',
                        'Block No. has been activated.',
                        'success'
                    ).then(() => {
                        window.location.reload();
                    });
               
            },
            error: function(xhr, status, error) {
                console.log("AJAX error: " + error); // Debugging line
                Swal.fire(
                    'Error!',
                    'Failed to activate Block No.',
                    'error'
                );
            }
        });
    });
});
</script>

</body>
</html>
