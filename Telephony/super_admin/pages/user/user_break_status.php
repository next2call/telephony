<?php
session_start();
$Adminuser = $_SESSION['user'];
require '../include/user.php';
include "../../../conf/db.php";


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
        $usersql_data = "SELECT break_time.* FROM `break_time` JOIN users ON users.user_id = break_time.user_name WHERE users.admin IN ('$admin_user_list') ORDER BY break_time.id DESC"; 
    }elseif(!empty($_POST['f_date']) && !empty($_POST['to_date'])){

      $from_date=$_POST['f_date'];
      $_SESSION['from_date_str'] = $_POST['f_date'];
      $to_date=$_POST['to_date'];
      $_SESSION['to_date_str'] = $_POST['to_date'];
 
 $usersql_data = "SELECT break_time.* 
   FROM `break_time` 
   JOIN users ON users.user_id = break_time.user_name 
   WHERE DATE(break_time.start_time) BETWEEN '$from_date' AND '$to_date' 
   AND users.admin IN ('$admin_user_list') 
   ORDER BY break_time.id DESC;"; 
    
    }else{
        $usersql_data = "SELECT break_time.* FROM `break_time` JOIN users ON users.user_id = break_time.user_name WHERE users.admin IN ('$admin_user_list') ORDER BY break_time.id DESC"; 
    
     }

  }else{
    
    $_SESSION['from_date_str'] = '';
    $_SESSION['to_date_str'] = '';

    $usersql_data = "SELECT break_time.* FROM `break_time` JOIN users ON users.user_id = break_time.user_name WHERE users.admin IN ('$admin_user_list') ORDER BY break_time.id DESC"; 
  }


  $usersresult = mysqli_query($con, $usersql_data);


?>
<style>
.my-input{
    margin-right: 5rem !important;
}
</style>

<div>
    <div class="show-users ml-5">

    <div class="user-stats">

<!-- form starts here -->

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

        <!-- <a href="pages/user/user_break_export.php" class="btn btn-success ml-5">Export Data</a>  -->
  
    </div>
</form>
       
        <!-- user list table start -->
        <div class="table-responsive my-table ml-5">
            <div class="table-top">
                <h4>User break status</h4>
            </div>
            <table class="all-user-table table table-hover">
                <thead>
                <tr>
                    <th scope="col"><a href="#">SR.</a></th>
                    <th scope="col"><a href="#">USER ID</a></th>
                    <th scope="col"><a href="#">BREAK NAME</a></th>
                    <th scope="col"><a href="#">TAKE BREAK TIME</a></th>
                    <th scope="col"><a href="#">BREAK DURATION</a></th>
                    <th scope="col"><a href="#">STATUS</a></th>
                  
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
 $total_minutes = round($usersrow['break_duration']);
                    $hours = floor($total_minutes / 60);
                    $minutes = $total_minutes % 60;
                    $duration_formatted = sprintf("%02d:%02d", $hours, $minutes);
                    echo '<tr>';
                    echo '<td>' . $sr . '</td>';
                    echo '<td>' . $usersrow['user_name'] . '</td>';
                    echo '<td>' . $usersrow['break_name'] . '</td>';
                    echo '<td>' . $usersrow['start_time'] . '</td>';
                    echo '<td>' . $duration_formatted . '</td>';
                   

                           ?>
                            <td>

                          <?php 
                          if($usersrow['break_status'] == '1'){
                          echo '<span class="active-no">Break</span>';
                          } else {
                           echo '<span class="active-yes">' . 'Ready' . '</span>';
                             }
                              ?>
                        </td>
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
