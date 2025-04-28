<?php

session_start();
$_SESSION['page_start'] = 'index_page'; 

$Adminuser = $_SESSION['user'];

$Agent_id = $_REQUEST['user_id'];

include "../../../conf/db.php";
include "../../../conf/Get_time_zone.php";
$sel_data = "SELECT * FROM `users` WHERE user_id='$Agent_id'";
$sel_query = mysqli_query($con, $sel_data);
$sel_da_row = mysqli_fetch_assoc($sel_query);
$User_full_name = $sel_da_row['full_name'];
// echo "<script>alert('$Agent_id')</script>";
// echo $ip=$_SERVER['REMOTE_ADDR'];
// continent, etc using IP Address  
$ip = '119.82.85.212'; 
  
// Use JSON encoded string and converts 
// it into a PHP variable 
$ipdat = @json_decode(file_get_contents( 
    "http://www.geoplugin.net/json.gp?ip=" . $ip)); 
   
$all_data_check=$_REQUEST['filter_data'];
$date = date("Y-M-d");
$date1 = date("Y-m-d");

    // $sel1 = "select * from cdr WHERE admin = '' AND start_time Like '%$date1%' ORDER BY `id` DESC";


  if(isset($_POST['search'])){
    
    if(empty($_POST['f_date']) && empty($_POST['to_date'])){
        
        $_SESSION['from_date_str'] = '';
        $_SESSION['to_date_str'] = '';
        $_SESSION['user_id_test'] = $_REQUEST['user_id'];
        //  $usersql_data = "SELECT login_log.* FROM `login_log` JOIN users ON login_log.user_name = users.user_id WHERE users.admin = '$Adminuser' AND users.user_id!='$Adminuser' ORDER BY login_log.id DESC"; 
        $select_data = "SELECT * FROM `login_log` WHERE user_name='$Agent_id' ORDER BY id DESC";

        // die();
    }elseif(!empty($_POST['f_date']) && !empty($_POST['to_date'])){
      $_SESSION['user_id_test'] = $_REQUEST['user_id'];
      $from_date=$_POST['f_date'];
      $_SESSION['from_date_str'] = $_POST['f_date'];
      $to_date=$_POST['to_date'];
      $_SESSION['to_date_str'] = $_POST['to_date'];

      //  $usersql_data = "SELECT login_log.* 
      // FROM `login_log` 
      // JOIN users ON login_log.user_name = users.user_id 
      // WHERE DATE(login_log.log_in_time) BETWEEN '$from_date' AND '$to_date' 
      // AND users.admin = '$Adminuser' 
      // AND users.user_id != '$Adminuser' 
      // ORDER BY login_log.id DESC;"; 
        $select_data = "SELECT * FROM `login_log` WHERE DATE(log_in_time) BETWEEN '$from_date' AND '$to_date' AND user_name='$Agent_id' ORDER BY id DESC";
      // echo $select_data = "SELECT * from call_notes WHERE DATE(datetime) between '$from_date' and '$to_date' AND phone_code='$userss_id' ORDER BY id DESC";
      $_SESSION['user_id_test'] = $_REQUEST['user_id'];
   // die();
    }else{
       
      $_SESSION['user_id_test'] = $_REQUEST['user_id'];
    $_SESSION['from_date_str'] = '';
    $_SESSION['to_date_str'] = '';
   
        // $usersql_data = "SELECT login_log.* FROM `login_log` JOIN users ON login_log.user_name = users.user_id WHERE users.admin = '$Adminuser' AND users.user_id!='$Adminuser' ORDER BY login_log.id DESC"; 
        $select_data = "SELECT * FROM `login_log` WHERE user_name='$Agent_id' ORDER BY id DESC";

     }

  }else{
    
    $_SESSION['user_id_test'] = $_REQUEST['user_id'];
    $_SESSION['from_date_str'] = '';
    $_SESSION['to_date_str'] = '';
   
    // $usersql_data = "SELECT login_log.* FROM `login_log` JOIN users ON login_log.user_name = users.user_id WHERE users.admin = '$Adminuser' AND users.user_id!='$Adminuser' ORDER BY login_log.id DESC"; 
    $select_data = "SELECT * FROM `login_log` WHERE user_name='$Agent_id' ORDER BY id DESC";


  }

  $qur_nogente_two = mysqli_query($con, $select_data);



    // $total_call = mysqli_num_rows($qur_nogente);

// if($all_data_check == 'today'){

    // $sel1 = "select * from cdr WHERE call_from = '$Agent_id' OR call_to = '$Agent_id' AND start_time Like '%$date1%' ORDER BY `id` DESC";
    // $qur_nogente = mysqli_query($con, $sel1);
    // $total_call = mysqli_num_rows($qur_nogente);
    
    // $sel2 = "select * from cdr WHERE status='ANSWER' AND admin = '$Agent_id' AND start_time Like '%$date1%'";
    // $qur_nogente2 = mysqli_query($con, $sel2);
    // $answer_call = mysqli_num_rows($qur_nogente2);
    
    // $sel3 = "select * from cdr WHERE status='CANCEL' AND admin = '$Agent_id' AND start_time Like '%$date1%'";
    // $qur_nogente3 = mysqli_query($con, $sel3);
    // $cancel_call = mysqli_num_rows($qur_nogente3);
    
    // $sel4 = "select * from cdr WHERE status!='ANSWER' AND status!='CANCEL' AND admin = '$Agent_id' AND start_time Like '%$date1%'";
    // $qur_nogente4 = mysqli_query($con, $sel4);
    // $congetion_call = mysqli_num_rows($qur_nogente4);
    
// }elseif($all_data_check == 'all'){


$sel1 = "select * from cdr WHERE call_from = '$Agent_id'";
$qur_nogente = mysqli_query($con, $sel1);
$total_call = mysqli_num_rows($qur_nogente);

$sel2 = "select * from cdr WHERE status='ANSWER' AND call_from = '$Agent_id'";
$qur_nogente2 = mysqli_query($con, $sel2);
$answer_call = mysqli_num_rows($qur_nogente2);

$sel3 = "select * from cdr WHERE status='CANCEL' AND call_from = '$Agent_id'";
$qur_nogente3 = mysqli_query($con, $sel3);
$cancel_call = mysqli_num_rows($qur_nogente3);

$sel4 = "select * from cdr WHERE status!='ANSWER' AND status!='CANCEL' AND call_from = '$Agent_id'";
$qur_nogente4 = mysqli_query($con, $sel4);
$congetion_call = mysqli_num_rows($qur_nogente4);


// }else{
//     $sel1 = "select * from cdr WHERE admin = '$Adminuser' AND start_time Like '%$date1%'";
//     $qur_nogente = mysqli_query($con, $sel1);
//     $total_call = mysqli_num_rows($qur_nogente);
    
//     $sel2 = "select * from cdr WHERE status='ANSWER' AND admin = '$Adminuser' AND start_time Like '%$date1%'";
//     $qur_nogente2 = mysqli_query($con, $sel2);
//     $answer_call = mysqli_num_rows($qur_nogente2);
    
    
//     $sel3 = "select * from cdr WHERE status='CANCEL' AND admin = '$Adminuser' AND start_time Like '%$date1%'";
//     $qur_nogente3 = mysqli_query($con, $sel3);
//     $cancel_call = mysqli_num_rows($qur_nogente3);
    
//     $sel4 = "select * from cdr WHERE status!='ANSWER' AND status!='CANCEL' AND admin = '$Adminuser' AND start_time Like '%$date1%'";
//     $qur_nogente4 = mysqli_query($con, $sel4);
//     $congetion_call = mysqli_num_rows($qur_nogente4);
    
// }

// $sel_user = "select * from users WHERE admin = '$Adminuser'";
// $qur_user = mysqli_query($con, $sel_user);
// $count_use = mysqli_num_rows($qur_user);

// include "count_dispo_show_dashboard.php";

$sel_dis1 = "select * from call_notes WHERE disposition='Already with Consultant' AND phone_code = '$Agent_id'";
$qur_note1 = mysqli_query($con, $sel_dis1);
$Already_Consultant = mysqli_num_rows($qur_note1);

$sel_dis2 = "select * from call_notes WHERE disposition='Call Back-General' AND phone_code = '$Agent_id'";
$qur_note2 = mysqli_query($con, $sel_dis2);
$Call_General = mysqli_num_rows($qur_note2);


$sel_dis3 = "select * from call_notes WHERE disposition='Call Back-Specific' AND phone_code = '$Agent_id'";
$qur_note3 = mysqli_query($con, $sel_dis3);
$Call_Specific = mysqli_num_rows($qur_note3);


$sel_dis4 = "select * from call_notes WHERE disposition='DNC' AND phone_code = '$Agent_id'";
$qur_note4 = mysqli_query($con, $sel_dis4);
$DNC = mysqli_num_rows($qur_note4);

$sel_dis5 = "select * from call_notes WHERE disposition='Follow-up' AND phone_code = '$Agent_id'";
$qur_note5 = mysqli_query($con, $sel_dis5);
$Follow_up = mysqli_num_rows($qur_note5);

$sel_dis6 = "select * from call_notes WHERE disposition='Get back to prospect' AND phone_code = '$Agent_id'";
$qur_note6 = mysqli_query($con, $sel_dis6);
$Get_back_prospect = mysqli_num_rows($qur_note6);

$sel_dis7 = "select * from call_notes WHERE disposition='Gov company' AND phone_code = '$Agent_id'";
$qur_note7 = mysqli_query($con, $sel_dis7);
$Gov_company = mysqli_num_rows($qur_note7);

$sel_dis8 = "select * from call_notes WHERE disposition='Interested Appointment' AND phone_code = '$Agent_id'";
$qur_note8 = mysqli_query($con, $sel_dis8);
$Interested_Appointment = mysqli_num_rows($qur_note8);

$sel_dis9 = "select * from call_notes WHERE disposition='Interested Call Back' AND phone_code = '$Agent_id'";
$qur_note9 = mysqli_query($con, $sel_dis9);
$Interested_callkback = mysqli_num_rows($qur_note9);

$sel_dis10 = "select * from call_notes WHERE disposition='Interested Send Email' AND phone_code = '$Agent_id'";
$qur_note10 = mysqli_query($con, $sel_dis10);
$Interested_emeil = mysqli_num_rows($qur_note10);

$sel_dis11 = "select * from call_notes WHERE disposition='Interested Send WhatsApp' AND phone_code = '$Agent_id'";
$qur_note11 = mysqli_query($con, $sel_dis11);
$Interested_whatsapp = mysqli_num_rows($qur_note11);

$sel_dis12 = "select * from call_notes WHERE disposition='Managing Inhouse' AND phone_code = '$Agent_id'";
$qur_note12 = mysqli_query($con, $sel_dis12);
$Managing_Inhouse = mysqli_num_rows($qur_note12);

$sel_dis13 = "select * from call_notes WHERE disposition='No Answer' AND phone_code = '$Agent_id'";
$qur_note13 = mysqli_query($con, $sel_dis13);
$no_answer = mysqli_num_rows($qur_note13);

$sel_dis14 = "select * from call_notes WHERE disposition='Not Interested' AND phone_code = '$Agent_id'";
$qur_note14 = mysqli_query($con, $sel_dis14);
$Not_Interested = mysqli_num_rows($qur_note14);

$sel_dis15 = "select * from call_notes WHERE disposition='Not Ready Now-Later' AND phone_code = '$Agent_id'";
$qur_note15 = mysqli_query($con, $sel_dis15);
$Not_Ready_Later = mysqli_num_rows($qur_note15); 

$sel_dis16 = "select * from call_notes WHERE disposition='Number does not exist' AND phone_code = '$Agent_id'";
$qur_note16 = mysqli_query($con, $sel_dis16);
$Number_not_exist = mysqli_num_rows($qur_note16);

$sel_dis17 = "select * from call_notes WHERE disposition='RPC Now-Latter' AND phone_code = '$Agent_id'";
$qur_note17 = mysqli_query($con, $sel_dis17);
$RPC_Latter = mysqli_num_rows($qur_note17);

$sel_dis18 = "select * from call_notes WHERE disposition='Wrong Number' AND phone_code = '$Agent_id'";
$qur_note18 = mysqli_query($con, $sel_dis18);
$Wrong_Number = mysqli_num_rows($qur_note18);


?>

<style>
    .second_input{
        margin-left: 1rem !important;
    }
   
</style>
<div class="row justify-content-center ml-5">
    <div class="col-lg-6">
            <h3 class="ml-5">Total Call Stats</h3>
       
       <div class="stats-group">
           <div class="stats-card">
                <!-- <canvas id="pieChart" style="max-height: 400px;"></canvas> -->
                <canvas id="doughnutChart" style="max-height: 250px;"></canvas>
               <div class="card">
       <div class="card-body">
         <!-- <h5 class="card-title">Pie Chart</h5><canvas id="pieChart" style="max-height: 400px;"></canvas> -->
        
<!-- <script>document.addEventListener("DOMContentLoaded", () => {
             new Chart(document.querySelector('#pieChart'), {
               type: 'pie',
               data: {
                 labels: [
                 
                   'Answer Call',
                   'Other Call',
                   'Cancel Call'
                 ],
                 datasets: [{
                   label: 'My First Dataset',

                   data: [<?= $answer_call ?>, <?= $congetion_call ?>, <?= $cancel_call ?>],
                   backgroundColor: [
                   '#65fc8b',
                   '#b878f0',
                   '#fc8c3c'
                   ],
                   hoverOffset: 4
                 }]
               }
             });
           });</script> -->
           <script>document.addEventListener("DOMContentLoaded", () => {
            var total = <?php echo $total_call; ?>;
            var ANSWER = <?php echo $answer_call; ?>;
            var CONGESTION = <?php echo $congetion_call; ?>;
            var CANCEL = <?php echo $cancel_call; ?>;
        
             new Chart(document.querySelector('#doughnutChart'), {
               type: 'doughnut',
               data: {
                 labels: [
                   'Cancel Call',
                   'Total call',
                   'Answer Call',
                   'Other Call'
                 ],
                 datasets: [{
                   label: 'My First Dataset',
                   data: [CANCEL, total, ANSWER , CONGESTION],
                   backgroundColor: [
                     'rgb(255, 99, 132)',
                     'rgb(54, 162, 235)',
                     'rgb(14, 872, 135)',
                     'rgb(255, 205, 86)'
                   ],
                   hoverOffset: 4
                 }]
               }
             });
           });</script>

       </div>
     </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-xl-6 ">
    <h3>Total Disposition Stats</h3>
       
       <div class="stats-group">
           <div class="stats-card">
                <canvas id="barChart" style="max-height: 500px;"></canvas>
               <div class="card">
       <div class="card-body">
       <script>
  document.addEventListener("DOMContentLoaded", () => {
    var Already_Consultant = <?php echo $Already_Consultant; ?>;
    // var Already_Consultant = <?php echo '59'; ?>;
    var Call_General = <?php echo $Call_General; ?>;
    // var Call_General = <?php echo '10'; ?>;
    var Call_Specific = <?php echo $Call_Specific; ?>;
    // var Call_Specific = <?php echo '30'; ?>;
    var DNC = <?php echo $DNC; ?>;
    // var DNC = <?php echo '64'; ?>;
    var Follow_up = <?php echo $Follow_up; ?>;
    // var Follow_up = <?php echo '53'; ?>;
    var Get_back_prospect = <?php echo $Get_back_prospect; ?>;
    // var Get_back_prospect = <?php echo '34'; ?>;
    var Gov_company = <?php echo $Gov_company; ?>;
    // var Gov_company = <?php echo '76'; ?>;
    var Interested_Appointment = <?php echo $Interested_Appointment; ?>;
    // var Interested_Appointment = <?php echo '56'; ?>;
    var Interested_callkback = <?php echo $Interested_callkback; ?>;
    // var Interested_callkback = <?php echo '62'; ?>;
    var Interested_emeil = <?php echo $Interested_emeil; ?>;
    // var Interested_emeil = <?php echo '43'; ?>;
    var Interested_whatsapp = <?php echo $Interested_whatsapp; ?>;
    // var Interested_whatsapp = <?php echo '28'; ?>;
    var Managing_Inhouse = <?php echo $Managing_Inhouse; ?>;
    // var Managing_Inhouse = <?php echo '54'; ?>;
    var no_answer = <?php echo $no_answer; ?>;
    // var no_answer = <?php echo '43'; ?>;
    var Not_Interested = <?php echo $Not_Interested; ?>;
    // var Not_Interested = <?php echo '35'; ?>;
    var Not_Ready_Later = <?php echo $Not_Ready_Later; ?>;
    // var Not_Ready_Later = <?php echo '76'; ?>;
    var Number_not_exist = <?php echo $Number_not_exist; ?>;
    // var Number_not_exist = <?php echo '43'; ?>;
    var RPC_Latter = <?php echo $RPC_Latter; ?>;
    // var RPC_Latter = <?php echo '76'; ?>;
    var Wrong_Number = <?php echo $Wrong_Number; ?>;
    // var Wrong_Number = <?php echo '65'; ?>;

    new Chart(document.querySelector('#barChart'), {
      type: 'bar',
      data: {
        labels: ['Already with Consultant', 'Call Back-General', 'Call Back-Specific', 'DNC', 'Follow-up', 'Get back to prospect', 'Gov company', 'Interested Appointment', 'Interested Call Back', 'Interested Send Email', 'Interested Send WhatsApp', 'Managing Inhouse', 'No Answer', 'Not Interested', 'Not Ready Now-Later', 'Number does not exist', 'RPC Now-Latter', 'Wrong Number'],
        datasets: [{
          label: 'Data',
          data: [Already_Consultant, Call_General, Call_Specific, DNC, Follow_up, Get_back_prospect, Gov_company, Interested_Appointment, Interested_callkback, Interested_emeil, Interested_whatsapp, Managing_Inhouse, no_answer, Not_Interested, Not_Ready_Later, Number_not_exist, RPC_Latter, Wrong_Number],
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgb(255, 159, 64, 0.2)',
            'rgb(255, 205, 86, 0.2)',
            'rgb(75, 192, 192, 0.2)',
            'rgb(14, 162, 235, 0.2)',
            'rgb(54, 362, 215, 0.2)',
            'rgb(54, 112, 235, 0.2)',
            'rgb(24, 162, 235, 0.2)',
            'rgb(54, 112, 215, 0.2)',
            'rgb(64, 162, 235, 0.2)',
            'rgb(54, 562, 225, 0.2)',
            'rgb(44, 162, 215, 0.2)',
            'rgb(54, 392, 225, 0.2)',
            'rgb(54, 162, 125, 0.2)',
            'rgb(64, 162, 235, 0.2)',
            'rgb(54, 162, 235, 0.2)',
            'rgb(153, 102, 255, 0.2)',
            'rgb(201, 203, 207, 0.2)'
          ],
          borderColor: [
            'rgb(255, 99, 132)',
            'rgb(255, 159, 64)',
            'rgb(255, 205, 86)',
            'rgb(75, 192, 192)',
            'rgb(14, 162, 235)',
            'rgb(54, 362, 215)',
            'rgb(54, 112, 235)',
            'rgb(24, 162, 235)',
            'rgb(54, 112, 215)',
            'rgb(64, 162, 235)',
            'rgb(54, 562, 225)',
            'rgb(44, 162, 215)',
            'rgb(54, 392, 225)',
            'rgb(54, 162, 125)',
            'rgb(64, 162, 235)',
            'rgb(54, 162, 235)',
            'rgb(153, 102, 255)',
            'rgb(201, 203, 207)'
          ],
          borderWidth: 1
        }]
      },
      // options: {
      //   scales: {
      //     y: {
      //       beginAtZero: true
      //     }
      //   }
      // }
      options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        },
        legend: {
            display: true,
            labels: {
                fontColor: 'blue',
                fontSize: 4 // Set your desired font size here
            }
        }
    }
    });
  });
</script>
       </div>
     </div>
            </div>
        </div>

    </div>
</div>
<div class="row justify-content-center">
    <div class="col-lg-12">
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

        <div class="my-input-with-help col-12 col-md-6 col-lg-3 ml-5">
            <div class="form-group my-input second_input">

                <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control str_date2"
                       id="end_date" name="to_date" aria-describedby="end_date">
                <label for="end_date">To Date</label>
            </div>
        </div>
        <span class="ml-5">
        <button class="btn btn-primary ml-5" type="submit" name="search">Search</button> 
        </span>

        <a href="pages/user/agent_dashboard_data_export.php" class="btn btn-success ml-5">Export Data</a>
  
    </div>
      </form>

        <!-- user list table start -->
        <div class="table-responsive my-table ml-5">
            
            <div class="table-top">
                <h4> User <span Class="text-primary"><?= $User_full_name; ?></span> Login and Logout Details</h4>
               
            </div>
            <table class="all-user-table table table-hover">
                <thead>
                <tr>
                    <th scope="col"><a href="#">SR.</a></th>
                    <th scope="col"><a href="#">USER ID</a></th>
                    <th scope="col"><a href="#">LOGIN TIME</a></th>
                    <th scope="col"><a href="#">LOGOUT TIME</a></th>   
                    <th scope="col"><a href="#">NO. OF BREAK</a></th>   
                    <th scope="col"><a href="#">BREAK NAME</a></th>   
                    <th scope="col"><a href="#">STATUS</a></th>
                
                </tr>
                </thead>
                <tbody>
                <?php
               $sr='1';
                while ($usersrow = mysqli_fetch_array($qur_nogente_two)) {
                   $user_name = $usersrow['user_name'];
                   $log_in_time = $usersrow['log_in_time'];
                   $log_out_time = $usersrow['log_out_time'];

                   $datetime = new DateTime($log_in_time);
                   $date_only = $datetime->format('Y-m-d');
                   
                  //  echo $sel_dis_one = "SELECT * FROM break_time WHERE start_time LIKE '%2024-03-31%' AND user_name = '8846'";
                    $sel_dis_one = "SELECT * FROM `break_time` WHERE `start_time` LIKE '%$date_only%' AND `user_name` LIKE '%$Agent_id%'";
                  //  die();
                   $qur_note_one = mysqli_query($con, $sel_dis_one);
                   $no_of_day_break = mysqli_num_rows($qur_note_one);

                    ?>

                   <tr>
                    <td><?= $sr ?></td>
                    <td><?= $user_name ?></td>
                    <td><?= $log_in_time ?></td>
                    <td><?= $log_out_time ?></td>
                    <td><?= $no_of_day_break ?></td>
                    <td><?php 
                                       while ($Row_data = mysqli_fetch_array($qur_note_one)){
                                           echo $break_data_name = $Row_data['break_name'];
                                           echo ', ';
                                       }
                    ?></td>
                    
                        
                            <td>
                    
                          <?php 
                          if($usersrow['status'] == '1'){
                          echo '<span class="active-yes cursor_p" title="This user Login ">' . 'Login' . '</span>';
                          } else {
                           echo '<span class="active-no cursor_p" title="This user Logout">' . 'Logout' . '</span>';
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
<script
  src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
  crossorigin="anonymous"></script>
<script>
  $(document).ready(function(){
        $(".Total_call").on("click", function(){
            var user = '<?= $adminuser ?>'; 
            var f_data = 'total_data'; 
            var filter_data = '<?= $all_data_check ?>'; 
            // alert('ok');
            $.ajax({
                type: "POST",
                url: "pages/dashboard/filter_page.php", // Add a comma here
                // url: "pages/dashboard/filter_page.php", // Add a comma here
                 
                data: { user: user, data: f_data, filter_data: filter_data }, // Add a comma here
                success: function(response){
                    // Update the content of the element with the ID "result"
                    $("#content").html(response);
                }
            });
        });
    });
    $(document).ready(function(){
        $(".Other_call").on("click", function(){
            var user = '<?= $adminuser ?>'; 
            var f_data = 'other_data'; 
            var filter_data = '<?= $all_data_check ?>';
            // alert(user);
            $.ajax({
                type: "POST",
                url: "pages/dashboard/filter_page.php", // Add a comma here
                data: { user: user, data: f_data, filter_data: filter_data }, // Add a comma here
                success: function(response){
                    // Update the content of the element with the ID "result"
                    $("#content").html(response);
                }
            });
        });
    });
    $(document).ready(function(){
        $(".Answer_call").on("click", function(){
            var user = '<?= $adminuser ?>'; 
            var f_data = 'ansewer_data'; 
            var filter_data = '<?= $all_data_check ?>';
            // alert(user);
            $.ajax({
                type: "POST",
                url: "pages/dashboard/filter_page.php", // Add a comma here
                data: { user: user, data: f_data, filter_data: filter_data }, // Add a comma here
                success: function(response){
                    // Update the content of the element with the ID "result"
                    $("#content").html(response);
                }
            });
        });
    });
    $(document).ready(function(){
        $(".Cancel_call").on("click", function(){
            var user = '<?= $adminuser ?>'; 
            var f_data = 'cancel_data'; 
            var filter_data = '<?= $all_data_check ?>';
            // alert(user);
            $.ajax({
                type: "POST",
                url: "pages/dashboard/filter_page.php", // Add a comma here
                data: { user: user, data: f_data, filter_data: filter_data }, // Add a comma here
                success: function(response){
                    // Update the content of the element with the ID "result"
                    $("#content").html(response);
                }
            });
        });
    });
</script>
<script>
    function redirectToSelected() {
        var selectElement = document.getElementById("cars");
        var selectedValue = selectElement.options[selectElement.selectedIndex].value;
        if (selectedValue !== "") {
            window.location.href = selectedValue;
        }
    }
</script>

<script>
    function updateClock() {
        // Get the current time
        var currentTime = new Date().toLocaleTimeString();

        // Update the HTML element with the current time
        var timeDisplayElement = document.getElementById("timeDisplay");
        if (timeDisplayElement) {
            timeDisplayElement.innerHTML = currentTime;
        } else {
            console.error("Element with id 'timeDisplay' not found.");
        }
    }

    // Call the updateClock function every second
    setInterval(updateClock, 1000);
</script>
<script>
    document.getElementsByClassName('str_date')[0].max = new Date().toISOString().split("T")[0];
    document.getElementsByClassName('str_date2')[0].max = new Date().toISOString().split("T")[0];
</script>