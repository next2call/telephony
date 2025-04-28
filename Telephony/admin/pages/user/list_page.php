<?php
session_start();
$Adminuser = $_SESSION['user'];
require '../include/user.php';
include "../../../conf/db.php";
include "../../../conf/Get_time_zone.php";


$user = new user();
// $user = $Adminuser;
$usersql = "Select user,user_id, full_name, user_level, user_group, active from vicidial_users";
 
$usersql2 = "SELECT * FROM `lists_tbl` WHERE admin='$Adminuser'"; 

// die();
$usersresult = mysqli_query($con, $usersql2);


$eUser = "";
$full_name = "";
$user_level = "";
$user_group = "";
$pass = "";
$error = 0;


if (isset($_POST['new_list_add'])) {
     $list_name = $_POST['list_name'];
     $remote_agent = '7690';
    // die();
    $list_id = $_POST['list_id'];
    $info = '1';
    $camp_status = "1";
    // $camp_admin = $_POST['user_name'];
    $camp_admin = $Adminuser;
    $type = 'Domestic';
    $did = '1234';

        $dial_perefix = "8899";
        $con_ext = "689679";
    
    // $date = date('Y-m-d');
    $date = date('Y-m-d H:i:s');

    // echo '</br>';
    // $select = "SELECT compaign_id FROM compaignlist WHERE compaign_id='$com_number'";
    // $sel_query = mysqli_query($con, $select);
//   echo '</br>';
   $select1 = "SELECT * FROM lists_tbl WHERE list_id='$list_id'";
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
          text: "Sorry, this Lists Id already exists",
          icon: "error",
          confirmButtonText: "OK"
        });
      }
      </script>';
    } else {
  
        //  $ins_remote_agent = "INSERT INTO `vicidial_remote_agents` (`remote_agent_id`, `user_start`, `number_of_lines`, `server_ip`, `conf_exten`, `status`, `campaign_id`, `closer_campaigns`, `extension_group`, `extension_group_order`, `on_hook_agent`, `on_hook_ring_time`) VALUES
        //  ('$remote_agent', '8848', 1, '10.10.10.17', '8848', 'ACTIVE', '$com_name', ' AGENTDIRECT AGENTDIRECT_CHAT winet -', 'NONE', 'NONE', 'N', 15)";
        //   mysqli_query($conn, $ins_remote_agent);


          $ins = "INSERT INTO `lists_tbl`(`list_name`, `list_id`, `creat_date`, `status`, `admin`) VALUES ('$list_name','$list_id','$date','Y','$Adminuser')";
        $query = mysqli_query($con, $ins);

// die();
        // mysqli_query($conn, $ins_remote_agent);
        // mysqli_query($conn, $vicidial_user_insert_user);
        // mysqli_query($con, $did_up);
    if($query){
        echo '
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
      
      <script>
      // var username = document.getElementById("floatingInput1").value;
      window.onload = function() {
        Swal.fire({
          title: "Lists Create",
          text: "Lists creation is successful.",
          icon: "success",
          confirmButtonText: "OK"
        });
      }
      </script>';
    }
  
    } // check already insert number
  
    //  } // check select user select or no select
  }
  









if(isset($_POST["update"])){
    $new_camp=$_POST['new_camp'];
    $old_camp=$_POST['old_camp'];
    $camp_id=$_POST['camp_id'];
    // $date =date('Y-m-d');
    $Date = date("Y-m-d H:i:s", strtotime($date));

   if($new_camp == $old_camp){
    echo '
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">

    <script>
    Swal.fire({
        position: "top-end",
        icon: "success",
        title: "Campaign Name updated successfully.",
        showConfirmButton: false,
        timer: 1500
    });
    </script>';
   }else{

    
    $sel_check = "SELECT * FROM `vicidial_campaigns` WHERE campaign_name='$new_camp'";
    $quer_check = mysqli_query($conn, $sel_check);
    if (mysqli_num_rows($quer_check) > 0) {
        // echo "<script>alert('Data is already Inserted');</script>";
        echo '
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
    
        <script>
        Swal.fire({
            position: "top-end",
            icon: "error",
            title: "This Campaign has already been created !",
            showConfirmButton: false,
            timer: 1500
        });
        </script>';
    } else{    

    $Up_date="UPDATE `vicidial_campaigns` SET `campaign_name`='$new_camp' WHERE campaign_id='$camp_id'";

    $Up_date_data="UPDATE `compaignlist` SET `compaignname`='$new_camp', creat_date='$Date' WHERE compaign_id='$camp_id'";
//    die();
    mysqli_query($conn, $Up_date);
   $update = mysqli_query($con, $Up_date_data);
   if($update) {
    echo '
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">

    <script>
    Swal.fire({
        position: "top-end",
        icon: "success",
        title: "Campaign Name updated successfully.",
        showConfirmButton: false,
        timer: 1500
    });
    </script>';
    }

 }

   }

}


?>
<style>
.data_btn{
    background: #b3e2f5;
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
.data_btn1{
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
.data_btn2{
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
                        Create List</a>

            </div>
            <table class="all-user-table table table-hover">
                <thead>
                <tr>
                    <th scope="col"><a href="#">Sr.</a></th>
                    <th scope="col"><a href="#">List ID </a></th>
                    <th scope="col"><a href="#">List Name</a></th>
                    <th scope="col"><a href="#">Status</a></th>
                    <th scope="col"><a href="#">Action</a></th>
                </tr>
                </thead>
                <tbody>
                <?php
                  $sr=1;
                while ($usersrow = mysqli_fetch_array($usersresult)) {

                    echo '<tr>';
                    echo '<td>' . $sr . '</td>';
                    echo '<td>' . $usersrow['list_id'] . '</td>';
                    echo '<td>' . $usersrow['list_name'] . '</td>';
                           ?>
                            <td>
                       <a href="pages/new_action/edit_list.php?camp_id=<?= $usersrow['list_id'] ?>">
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
                    // echo '<td>' . $usersrow['ins_date'] . '</td>';
                    ?>
                     <td> 

                     <span class="badge bg-info cursor_p text-white show_campaign_list" data-camp_id="<?Php echo $usersrow['list_id']; ?>" data-toggle="modal" data-target="#staticBackdrop" title="Click here and view list data and create List">View_list</span>
                    
                     <span class="badge bg-primary cursor_p text-white contact_add" data-id="<?Php echo $usersrow['list_id']; ?>" data-toggle="modal" data-target="#staticBackdrop" title="Click here and edit camp name">Edit</span>
                      <span class="badge bg-danger cursor_p text-white show_break_report" data-id="<?Php echo $usersrow['list_id']; ?>" title="You can click here to see why users take breaks">Remove</span></td>
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
                <h5 class="modal-title" id="exampleModalLabel">Create New List</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">

                    <div class="row">
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">
                                <input type="text" class="form-control" id="full-name" name="list_name"
                                       aria-describedby="full-name" required>
                                <label for="full-name">Enter List Name</label>
                            </div>
                        </div>
                        <div class="my-input-with-help col-6">
                            <div class="form-group my-input">
                                <input type="text" class="form-control" id="full-name" name="list_id"
                                       aria-describedby="full-name" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="8" required>
                                <label for="full-name">List ID</label>
                            </div>
                        </div>
                                        
                      
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary my-btn-secondary"
                            data-dismiss="modal">Cancel
                    </button>
                    <input class="my-btn-primary" type="submit" value="submit" name="new_list_add">
                </div>
            </form>
        </div>
    </div>
</div> 
<!-- Add user modal ends here -->
<!-- Add user name for user id modal ends here -->
<!-- Modal -->
   <!-- add disposition open form  -->
   <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update List name</h5>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
      </div>
      <div class="modal-body">
        <form method="post">
          <div class="mb-3">
            <label for="name" class="form-label">Enter List Name</label>
            <input type="text" class="form-control" id="edit_campname" name="new_camp" required>
            <input type="hidden" class="form-control" id="edit_campname_one" name="old_camp" required>
          </div>
          <div class="mb-3">
            <!-- <label for="number" class="form-label">Your Number</label> -->
            <input type="text" class="form-control" id="c_number" name="camp_id" readonly>
          </div>
          <button type="submit" class="btn btn-success" name="update">Update</button>
          <!-- Add an ID to the close button -->
            <button type="button" class="btn btn-warning" id="closeModalButton" data-bs-dismiss="modal" aria-label="Close">Close</button>

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
        $("#edit_campname").val(""); // Clear the field before making the request
        $.ajax({
            url: "pages/new_action/get_camp.php", // URL to your PHP file
            type: "POST",
            data: { cnumber: cnumber },
            success: function(response) {
                // alert(response);
                $("#edit_campname").val(response);
                $("#edit_campname_one").val(response);
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
          window.location.href = "pages/new_action/campaign_delete.php?id=" + id // Redirect to block.php with the 'id' query string
        }
    });
  });

});

// ########################################view list data###################### 

$(document).ready(function() {
    $(document).on("click", ".show_campaign_list", function() {
    // $(document).on("click", ".agent_dashboard.php", function() {
        var user_id = $(this).data("camp_id");
        // Assuming you want to redirect to another page
        // window.location.href = "?c=user&v=user_break_status&user_id=" + user_id;
        window.location.href = "?c=user&v=list_page&user_id=" + user_id;
    });
});

</script>