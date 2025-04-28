<?php
session_start();
include "../../../conf/db.php";

$_SESSION['page_start'] = 'Report_page';  

$user = $_SESSION['user'];
$sel = "SELECT user_id FROM `users` WHERE admin='$Adminuser'";
$sql = mysqli_query($con, $sel);
$admin_user = [];

while($rowu = mysqli_fetch_assoc($sql)){
    $admin_user[] = $rowu['user_id'];
}

$admin_user_list = implode("','", $admin_user);

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
                                 $sel_users = "SELECT * from users WHERE user_id NOT IN ('$admin_user_list') AND SuperAdmin IN ('$admin_user_list')";
                                 $sel_users_query = mysqli_query($con, $sel_users);
                                 while($users_row = mysqli_fetch_array($sel_users_query)){
                                 ?>
                                <option value="<?= $users_row['user_id'] ?>"><?= $users_row['admin'] ?> - <?= $users_row['full_name'] ?></option>
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
    <h4>Total Call Reports</h4>
    <!-- <a href="#"><i class="fa fa-download" aria-hidden="true"></i></a> -->
    <!-- <a class="btn btn-success ml-2 text-white"href="pages/dashboard/export_data.php">
                        Export</a> -->
    </div>
<!-- ################################################### -->
<div class="">
        <table id="employee_grid" class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Call From</th>
                <th scope="col">Number</th>
                <th scope="col">Start time</th>
                <!-- <th scope="col">End time</th> -->
                <th scope="col">Duration</th>
                <th scope="col">Status</th>
                <th scope="col">Direction</th>
                <th scope="col">Recordings</th>
            </tr>
            </thead>
        </table>
    </div>

<!-- ################################################### -->

</div>
</div>
<!-- jQuery script for clicktocall functionality -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.0.1/js/dataTables.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
<link rel="stylesheet" href="../assets/css/dataTables.dataTables.min.css" />

<script type="text/javascript">
$.noConflict();
jQuery( document ).ready(function( $ ) {
    
    $('#employee_grid').DataTable({
        "pageLength": 100,
                "processing": true,
                "serverSide": true,
        "ajax": {
            url :"pages/dashboard/datatables-ajax/ajaxfile.php", // PHP script that fetches data
            type: "post",  // method used for sending data to the server
            error: function(){  // error handling
              $("#employee_grid_processing").css("display","none");
            }
        },
        "columns": [  // define columns to be displayed
            { "data": "sr" },  // "id" should match with the key in your JSON response
            {
    data: "call_from",
    render: function(data, type, row) {
        if (data) {
            var noly10 = parseInt(data.substr(2)); // Extract substring and convert to integer
            var html = '<div>';
            if (row.direction == 'inbound') {
                html += data;
                html += '<a type="button" data-callernumber="' + data + '" class="badge bg-primary clicktocall ml-2 cursor_p">';
                html += '<i class="fa fa-phone-square"></i>';
                html += '</a>';
            } else {
                html += data;
            }
            html += '</div>';
            return html;
        } else {
            return '';
        }
    }
},  // "call_from" should match with the key in your JSON response
            {
    data: "call_to",
    render: function(data, type, row) {
        if (data) {
            var html = '<div>';
            if (row.direction == 'outbound') {
              html += data;
                html += '<a type="button" data-callernumber="' + data + '" class="badge bg-primary clicktocall ml-2 cursor_p">';
                html += '<i class="fa fa-phone-square"></i>';
                html += '</a>';
            } else {
                html += data;
            }
            html += '</div>';
            return html;
        } else {
            return '';
        }
    }
},  // "call_to" should match with the key in your JSON response
            { "data": "start_time" },  // "start_time" should match with the key in your JSON response
            { "data": "dur" },  // "dur" should match with the key in your JSON response
            { "data": "status" },  // "status" should match with the key in your JSON response
            { "data": "direction" },  // "record_url" should match with the key in your JSON response
            {
                data: 'record_url',
render: function(data, type, row) {
    var audioUrl = data.replace('http://', 'https://'); // Replace 'http://' with 'https://'
    var html = '<td>' +
        '<audio class="audio-player" id="myTune">' +
        '<source src="' + audioUrl + '" type="audio/wav">' +
        '</audio>' +
        '<button class="control" type="button" onclick="aud_play_pause(this)">' +
        '<span class="play-pause-icon">▶</span>' +
        '</button>' +
        '<a href="' + audioUrl + '" download>' +
        '<button class="download-button" type="button">' +
        '<i class="fa fa-download"></i>' +
        '</button>' +
        '</a>' + // Corrected closing tag for <a> element
        '</td>';
    return html;
}

}
        ]
    });
});
</script>
<script>
   var currentAudio = null;

function aud_play_pause(button) {
    var audio = button.previousElementSibling;

    if (currentAudio !== audio) {
        if (currentAudio) {
            currentAudio.pause();
            var currentPlayPauseIcon = currentAudio.nextElementSibling.querySelector('.play-pause-icon');
            currentPlayPauseIcon.textContent = '▶'; // Reset the icon
        }
        currentAudio = audio;
    }

    if (currentAudio.paused) {
        currentAudio.play();
        var playPauseIcon = button.querySelector('.play-pause-icon');
        playPauseIcon.textContent = '⏸';
    } else {
        currentAudio.pause();
        var playPauseIcon = button.querySelector('.play-pause-icon');
        playPauseIcon.textContent = '▶';
    }
}
</script>
     <script>
    document.getElementsByClassName('str_date')[0].max = new Date().toISOString().split("T")[0];
    document.getElementsByClassName('str_date2')[0].max = new Date().toISOString().split("T")[0];
</script>