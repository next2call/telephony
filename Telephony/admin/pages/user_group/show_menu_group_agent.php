<?php
include "../include/userGroup.php";
include "../../../conf/db.php";
include "../../../conf/url_page.php";
// if($con){
//     echo "success";
// }else{
//     echo "no";
// }

$user_level = $_SESSION['user_level'];

if($user_level == 2){
    $Adminuser = $_SESSION['admin'];
    $new_user = $_SESSION['user'];
} else {
    $Adminuser = $_SESSION['user'];
}
$group_id = $_REQUEST['group_id'];
$menu_id = $_REQUEST['menu_id'];
$id = $_REQUEST['id'];


$select = "SELECT * FROM compaign_list WHERE id='$id'";
$sel_query = mysqli_query($con, $select);
$row_sel = mysqli_fetch_assoc($sel_query);
$camp_id = $row_sel['compaign_id'];


$sel = "SELECT * FROM group_agent WHERE group_id='$group_id'";
$sel_q = mysqli_query($con, $sel);



if(isset($_POST['submit'])){

    $group_id = $_POST['group_id'];
    $group_name = $_POST['group_name'];
    $campaign_id = $_POST['campaign_id'];
// die();
    $select1 = "SELECT * FROM `vicidial_group` WHERE group_id='$group_id'";
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
          text: "Sorry, this Group Id already exists",
          icon: "error",
          confirmButtonText: "OK"
        });
      }
      </script>';
    } else {
// Create the SQL query string
  $sql_New = "INSERT INTO `vicidial_group`(`group_id`, `group_name`, `campaign_id`) VALUES ('$group_id','$group_name','$campaign_id')";
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
        <!-- this is where top navbar ends -->

        <!-- user list table start -->
        <div class="table-responsive my-table">
            <div class="table-top">
                <?php if(isset($id)){ ?>
                    <a href="?c=user_group&v=show_user_menu_group&id=<?= $id ?>"><i class="fa fa-arrow-left" aria-hidden="true" title="Click to go to the previous page"></i></a>
               <?php }else{ ?>
                <a href="?c=user_group&v=show_user_group"><i class="fa fa-arrow-left" aria-hidden="true" title="Click to go to the previous page"></i></a>
              <?php  } ?>

                <h4>USER GROUPS LISTINGS</h4>
            
            </div>
            <table class="all-user-table table table-hover">
                <thead>
                    <tr>
                        <th scope="col"><a href="#">USER GROUP ID</a></th>
                        <th scope="col"><a href="#">AGENT Ext.</a></th>
                        <th scope="col"><a href="#">AGENT NAME</a></th>
                        <th scope="col"><a href="#">CAMPAIGN ID</a></th>
                        <th scope="col"><a href="#">ACTION</a></th>
                    </tr>
                </thead>
                <tbody>

                    <?php  while ($row = mysqli_fetch_assoc($sel_q)) {  ?>
    <tr> <td><?= $row['group_id'] ?></td>
                   <td><?= $row['agent_id'] ?></td>
                    <td><?= $row['agent_name'] ?></td>
                    <td><?= $row['campaign_id'] ?></td>
                    <td>
                       <i class="fa fa-trash remove_this_agent" aria-hidden="true" style="font-size:24px; color:red;" data-id="<?= $row['id'] ?>" data-group_id="<?= $row['group_id'] ?>" data-pid="<?= $id?>" title='You can click here to see why users take breaks'></i>
                    </td>
                    </tr>
               <?php } ?>

                </tbody>
            </table>
        </div>
        <!-- user list table ends -->

    </div>
</div>
<!-- =========Show User Groups End -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
            window.location.href = "pages/new_action/remove_agent_group.php?id=" + id + "&group_id=" + group_id + "&pid=" + pid;
        }
    });
  });

});

</script>



<!-- Add user-group modal End here -->