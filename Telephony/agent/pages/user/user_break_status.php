<?php
session_start();
$Adminuser = $_SESSION['user'];
require '../include/user.php';
$con = new mysqli("localhost", "cron", "1234", "telephony_db");
$user = new user();
$usersql = "Select user,user_id, full_name, user_level, user_group, active from vicidial_users";

// $usersql2 = "SELECT login_log.* FROM `login_log` JOIN users ON login_log.user_name = users.user_id WHERE users.admin = '$Adminuser' ORDER BY login_log.id DESC"; 

// $user_id = $_REQUEST['user_id'];
// if(isset($_REQUEST['user_id'])){

//     $usersql_data = "SELECT break_time.* FROM `break_time` JOIN users ON users.user_id = break_time.user_name WHERE users.admin = '$Adminuser' AND break_time.user_name='$user_id' ORDER BY break_time.id DESC"; 

// }else{
//      $usersql_data = "SELECT break_time.* FROM `break_time` JOIN users ON users.user_id = break_time.user_name WHERE users.admin = '$Adminuser' ORDER BY break_time.id DESC"; 
// }
// $usersresult = mysqli_query($con, $usersql_data);


if(isset($_POST['search'])){
    
    if(empty($_POST['f_date']) && empty($_POST['to_date'])){
        
        $_SESSION['from_date_str'] = '';
        $_SESSION['to_date_str'] = '';
    //    $tfnsel="SELECT * from call_notes WHERE  admin = '$user' ORDER BY id DESC";
        $usersql_data = "SELECT break_time.* FROM `break_time` JOIN users ON users.user_id = break_time.user_name WHERE users.admin = '$Adminuser' AND break_time.break_name != 'Ready' ORDER BY break_time.id DESC"; 
// die();
    }elseif(!empty($_POST['f_date']) && !empty($_POST['to_date'])){

      $from_date=$_POST['f_date'];
      $_SESSION['from_date_str'] = $_POST['f_date'];
      $to_date=$_POST['to_date'];
      $_SESSION['to_date_str'] = $_POST['to_date'];
    //   $tfnsel="SELECT * from call_notes WHERE DATE(datetime) between '$from_date' and '$to_date' AND phone_code='$userss_id' ORDER BY id DESC";
//    echo $usersql_data = "SELECT break_time.* FROM `break_time` JOIN users ON users.user_id = break_time.user_name WHERE DATE(break_time.start_time) between '$from_date' and '$to_date' users.admin = '$Adminuser' ORDER BY break_time.id DESC"; 
    $usersql_data = "SELECT break_time.* 
   FROM `break_time` 
   JOIN users ON users.user_id = break_time.user_name 
   WHERE DATE(break_time.start_time) BETWEEN '$from_date' AND '$to_date' 
   AND users.admin = '$Adminuser' AND break_time.break_name != 'Ready' 
   ORDER BY break_time.id DESC;"; 
    
    }else{
        $usersql_data = "SELECT break_time.* FROM `break_time` JOIN users ON users.user_id = break_time.user_name WHERE users.admin = '$Adminuser' AND break_time.break_name != 'Ready' ORDER BY break_time.id DESC"; 
    
     }

  }else{
    
    $_SESSION['from_date_str'] = '';
    $_SESSION['to_date_str'] = '';

    $usersql_data = "SELECT break_time.* FROM `break_time` JOIN users ON users.user_id = break_time.user_name WHERE users.admin = '$Adminuser' AND break_time.break_name != 'Ready' ORDER BY break_time.id DESC"; 
// die();

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

        <a href="pages/user/user_break_export.php" class="btn btn-success ml-5">Export Data</a> 
  
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
                          echo '<span class="active-no cursor_p">Break</span>';
                          } else {
                           echo '<span class="active-yes cursor_p">' . 'Ready' . '</span>';
                             }
                              ?>
                           <!-- </a> -->
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
