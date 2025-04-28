<?php
session_start();
include "../../../conf/db.php";
$Adminuser = $_SESSION['user'];
require '../include/user.php';

$user = new user();
$usersql = "Select user,user_id, full_name, user_level, user_group, active from vicidial_users";

$sel = "SELECT user_id FROM `users` WHERE SuperAdmin='$Adminuser'";
$sql = mysqli_query($con, $sel);
$admin_user = [];

while($rowu = mysqli_fetch_assoc($sql)){
    $admin_user[] = $rowu['user_id'];
}

$admin_user_list = implode("','", $admin_user);

if(isset($_POST['search'])){
    
    if(empty($_POST['f_date']) && empty($_POST['to_date'])){
        
        $_SESSION['from_date_str'] = '';
        $_SESSION['to_date_str'] = '';
    //    $tfnsel="SELECT * from call_notes WHERE  admin = '$user' ORDER BY id DESC";
         $usersql_data = "SELECT login_log.* FROM `login_log` JOIN users ON login_log.user_name = users.user_id WHERE users.admin IN ('$admin_user_list') AND users.user_id NOT IN ('$admin_user_list') ORDER BY login_log.id DESC"; 

        // die();
    }elseif(!empty($_POST['f_date']) && !empty($_POST['to_date'])){

      $from_date=$_POST['f_date'];
      $_SESSION['from_date_str'] = $_POST['f_date'];
      $to_date=$_POST['to_date'];
      $_SESSION['to_date_str'] = $_POST['to_date'];

       $usersql_data = "SELECT login_log.* 
      FROM `login_log` 
      JOIN users ON login_log.user_name = users.user_id 
      WHERE DATE(login_log.log_in_time) BETWEEN '$from_date' AND '$to_date' 
      AND users.admin IN ('$admin_user_list') 
      AND users.user_id NOT IN ('$admin_user_list') 
      ORDER BY login_log.id DESC;"; 
    
    }else{
       
        $usersql_data = "SELECT login_log.* FROM `login_log` JOIN users ON login_log.user_name = users.user_id WHERE users.admin IN ('$admin_user_list') AND users.user_id NOT IN ('$admin_user_list') ORDER BY login_log.id DESC"; 

     }

  }else{
    
    $_SESSION['from_date_str'] = '';
    $_SESSION['to_date_str'] = '';
   
    $usersql_data = "SELECT login_log.* FROM `login_log` JOIN users ON login_log.user_name = users.user_id WHERE users.admin IN ('$admin_user_list') AND users.user_id NOT IN ('$admin_user_list') ORDER BY login_log.id DESC"; 

  }

  $usersresult = mysqli_query($con, $usersql_data);


?>

<div>
    <div class="show-users ml-5">

    <form action="" method="post">
    <div class="row my-card align-items-center">
        <div class="my-input-with-help col-12 col-md-6 col-lg-3">
            <div class="form-group my-input ">

                <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control str_date"
                       id="str_date" name="f_date" aria-describedby="begin_date">
                <label for="begin_date ">From Date</label>
            </div>
        </div>

        <div class="my-input-with-help col-12 col-md-6 col-lg-3">
            <div class="form-group my-input">

                <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control str_date2"
                       id="end_date" name="to_date" aria-describedby="end_date">
                <label for="end_date">To Date</label>
            </div>
        </div>
        <button class="btn btn-primary ml-5" type="submit" name="search">Search</button> 

        <!-- <a href="pages/user/user_login_status_export.php" class="btn btn-success ml-5">Export Data</a>  -->
  
    </div>
</form>

        <!-- user list table start -->
        <div class="table-responsive my-table ml-5">
            
            <div class="table-top">
                <h4>User Login and Logout status</h4>
                <!-- <div class="my-filter-dropdown">
                    <div class="dropdown">
                        <button class="btn btn-secondary" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="../assets/images/common-icons/filter_list.png" alt="">
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">
                                <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                          d="M16.5 15.5C18.22 15.5 20.25 16.3 20.5 16.78V17.5H12.5V16.78C12.75 16.3 14.78 15.5 16.5 15.5M16.5 14C14.67 14 11 14.92 11 16.75V19H22V16.75C22 14.92 18.33 14 16.5 14M9 13C6.67 13 2 14.17 2 16.5V19H9V17.5H3.5V16.5C3.5 15.87 6.29 14.34 9.82 14.5A5.12 5.12 0 0 1 11.37 13.25A12.28 12.28 0 0 0 9 13M9 6.5A1.5 1.5 0 1 1 7.5 8A1.5 1.5 0 0 1 9 6.5M9 5A3 3 0 1 0 12 8A3 3 0 0 0 9 5M16.5 8.5A1 1 0 1 1 15.5 9.5A1 1 0 0 1 16.5 8.5M16.5 7A2.5 2.5 0 1 0 19 9.5A2.5 2.5 0 0 0 16.5 7Z"/>
                                </svg>
                                </i> All</a>
                            <a class="dropdown-item" href="#">
                                <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                          d="M21.1,12.5L22.5,13.91L15.97,20.5L12.5,17L13.9,15.59L15.97,17.67L21.1,12.5M11,4A4,4 0 0,1 15,8A4,4 0 0,1 11,12A4,4 0 0,1 7,8A4,4 0 0,1 11,4M11,6A2,2 0 0,0 9,8A2,2 0 0,0 11,10A2,2 0 0,0 13,8A2,2 0 0,0 11,6M11,13C11.68,13 12.5,13.09 13.41,13.26L11.74,14.93L11,14.9C8.03,14.9 4.9,16.36 4.9,17V18.1H11.1L13,20H3V17C3,14.34 8.33,13 11,13Z"/>
                                </svg>
                                Active</a>
                        </div>
                    </div>
                </div> -->
            </div>
            <table class="all-user-table table table-hover">
                <thead>
                <tr>
                    <th scope="col"><a href="#">SR.</a></th>
                    <th scope="col"><a href="#">USER ID</a></th>
                    <th scope="col"><a href="#">LOGIN TIME</a></th>
                    <th scope="col"><a href="#">LOGOUT TIME</a></th>
                    
                    <th scope="col"><a href="#">STATUS</a></th>
                    <!-- <th scope="col"><a href="#">ACTION</a></th> -->
                  
                   <!-- <th>ACTIVE</th> -->
                    <!--  <th>MODIFY</th>
                    <th>STATS</th>
                    <th>STATUS</th>
                    <th>TIME</th> -->
                </tr>
                </thead>
                <tbody>
                <?php
$sr='1';
                while ($usersrow = mysqli_fetch_array($usersresult)) {
                    echo '<tr>';
                    echo '<td>' . $sr . '</td>';
                    echo '<td>' . $usersrow['user_name'] . '</td>';
                    echo '<td>' . $usersrow['log_in_time'] . '</td>';
                    echo '<td>' . $usersrow['log_out_time'] . '</td>';
                   
                    // if ($usersrow['status'] == 'Y') {
                    //     echo '<td><span class="active-yes">' . 'Active' . '</span></td>';
                    // } else {
                    //     echo '<td><span class="active-no">' . 'Inactive' . '</span></td>';
                    // }
                    // echo '<td>' . $usersrow['status'] . '</td>';
                           ?>
                            <td>
                       <!-- <a href="pages/user/editstatus.php?id=<?= $usersrow['user_id'] ?>"> -->
                          <?php 
                          if($usersrow['status'] == '1'){
                          echo '<span class="active-yes cursor_p" title="This user Login ">' . 'Login' . '</span>';
                          } else {
                           echo '<span class="active-no cursor_p" title="This user Logout">' . 'Logout' . '</span>';
                             }
                              ?>
                           <!-- </a> -->
                        </td>
                        
                        <!-- <td>
                       <a href="?c=user&v=user_break_status" ><span class="active-yes cursor_p">View</span>
                                      </a>
                        </td> -->
                    <?php  $sr++; }  ?>

                </tbody> 
            </table>
        </div>
        <!-- user list table ends -->

    </div>
</div>
</div>

<!-- Copy user modal starts here -->

<!-- Copy user modal ends here -->
