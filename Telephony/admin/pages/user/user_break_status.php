<?php
session_start();
include "../../../conf/db.php";
include "../../../conf/Get_time_zone.php";

$_SESSION['page_start'] = 'Report_page';  

$user_level = $_SESSION['user_level'];

if($user_level == 2 || $user_level == 7 || $user_level == 6){
    $user = $_SESSION['admin'];
    $new_user = $_SESSION['user'];
    $user_sql2 = "SELECT campaigns_id FROM `users` WHERE admin='$user' AND user_id='$new_user'"; 
    $user_query = mysqli_query($con, $user_sql2);
    if(!$user_query) {
        die("Query Failed: " . mysqli_error($con));
    }
    $row_compain = mysqli_fetch_assoc($user_query);
    $new_campaign = $row_compain['campaigns_id'];

} else {
    $user = $_SESSION['user'];
}

if (isset($_POST['submit_search'])) {
    $agent_name = $_POST['agent_name'];
    $cal_date = $_POST['cal_date'];
    $cal_date2 = $_POST['cal_date2'];
  
   if((!empty($agent_name))){
       $_SESSION['agent_name'] = $agent_name;
       }else{
           $_SESSION['agent_name'] = '';
       }
 if(!empty($cal_date) && !empty($cal_date2)){
   $_SESSION['fromdate'] = $cal_date;
   $_SESSION['todate'] = $cal_date2;
 }


if(!empty($agent_name) && !empty($cal_date) && !empty($cal_date2)){
   $serch_type = 'date-agent';
} elseif(!empty($agent_name) && empty($cal_date) && empty($cal_date2)){
   $serch_type = 'agent';
} elseif(empty($agent_name) && !empty($cal_date) && !empty($cal_date2)){
   $serch_type = 'date';
}
// echo $serch_type. " , " . $agent_name . "  , " . $cal_date . "  , " . $serch_type;
// die();
$_SESSION['serch_type'] = $serch_type;
}else{
   $_SESSION['agent_name'] = '';
   $_SESSION['fromdate'] = '';
   $_SESSION['todate'] = '';
   $_SESSION['serch_type'] = '';
}



?>
 <style>
        /* Style the audio player container */
        .audio-container {
            display: flex;
            align-items: center;
        }

        /* Style the play/pause button */
        .control {
            background: none;
            border: none;
            cursor: pointer;
        }

        /* Style the Download button and its icon */
        .download-button {
            background: none;
            border: none;
            cursor: pointer;
        }

        /* Adjust the size of the icons */
        .control span, .download-button i {
            font-size: 24px; /* Change the size as needed */
        }
        .select_date{
          margin-top: -2rem;
        }
        .img_answer{
          height: 1.2rem;
          width: 1.1rem;
        }
        table td {
            padding: 2px 10px !important;
        }
    </style>

 <div class="user-stats">


    <!-- form starts here -->
    <form action="" method="post">
        <div class="row my-card align-items-center">

            <!-- first input for date -->
                         <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                            <div class="my-dropdown">
                                <select name="agent_name" id="local_call_time">
                                    <option value=""></option> 
                                    <?php 
                                        if($user_level == '2'){
                                            $sel_users = "select * from users WHERE admin = '$user' AND campaigns_id='$new_campaign'";
                                        } else {
                                            $sel_users = "select * from users WHERE admin = '$user' AND user_id != '$user'";
                                        }


                                 $sel_users_query = mysqli_query($con, $sel_users);
                                 while($users_row = mysqli_fetch_array($sel_users_query)){
                                    $user_id = $users_row['user_id'];
                                    $user_name = $users_row['full_name'];
                                 ?>
                                <!-- <option value="<?= $users_row['user_id'] ?>"><?= $users_row['full_name'] ?></option> -->
                                <option value="<?= $users_row['user_id'] ?>">User ID: <?= $user_id; ?> || Full Name: <?= $user_name; ?></option>
                                   <?php } ?>
                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="local_call_time">Select Agent</label>
                            </div>
                        </div>

            <div class="my-input-with-help col-12 col-md-6 col-lg-3">
                <div class="form-group my-input">

                    <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control str_date"
                           id="str_date" name="cal_date" aria-describedby="begin_date">
                    <label for="begin_date ">From Date</label>
                </div>
            </div>

            <div class="my-input-with-help col-12 col-md-6 col-lg-3">
                <div class="form-group my-input">

                    <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control str_date2"
                           id="end_date" name="cal_date2" aria-describedby="end_date">
                    <label for="end_date">To Date</label>
                </div>
            </div>
            <button class="btn btn-primary ml-5" type="submit" name="submit_search">Search</button> 

        </div>
    </form>


    <div class="my-card-with-title ">
    <div class="title-bar">
    <h4>All agents break Reports <a href="?c=user&v=user_list" class="text-primary">Back</a></h4>
    <!-- <a href="#"><i class="fa fa-download" aria-hidden="true"></i></a> -->
    <a class="btn btn-success ml-2 text-white"href="pages/user/user_break_export.php">
                        Export</a>
    </div>
<!-- ################################################### -->
<div class="">
<table id="employee_grid" class="table table-bordered">
                <thead>
                    <tr>
                    <th scope="col"><a href="#">SR.</a></th>
                    <th scope="col"><a href="#">USER ID</a></th>
                    <th scope="col"><a href="#">BREAK NAME</a></th>
                    <th scope="col"><a href="#">TAKE BREAK TIME</a></th>
                    <th scope="col"><a href="#">BREAK DURATION</a></th>
                    </tr>
                </thead>
            </table>
    </div>

<!-- ################################################### -->

</div>
</div>
<!-- jQuery script for clicktocall functionality -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.min.css" />
<script type="text/javascript" src="https://cdn.datatables.net/2.0.1/js/dataTables.min.js"></script>
<script type="text/javascript">
        $.noConflict();
        jQuery(document).ready(function($) {
            $('#employee_grid').DataTable({
                "pageLength": 100,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "pages/user/datatables-ajax/break_ajaxfile.php", // PHP script that fetches data
                    "type": "POST",
                    "error": function() {
                        $("#employee_grid_processing").css("display", "none");
                    }
                },
                "columns": [
                    { "data": "sr" },
                    { "data": "user_name" },
                    { "data": "break_name" },                  
                    { "data": "start_time" },
                    { "data": "total_break_time" }
                ]
            });

        });


        function load_otherpage(page) {
            var user = '<?= $adminuser ?>';
            $.ajax({
                url: page,
                type: 'POST',
                dataType: 'html',
                data: {
                    user: user
                },
                success: function(data) {
                    $('#content').html(data);
                    localStorage.setItem('currentPage', page);
                },
                error: function(xhr, status, error) {
                    console.error('Error loading page:', error);
                    console.log('XHR:', xhr);
                }
            });
        }
    </script>
