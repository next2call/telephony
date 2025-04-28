<?php
session_start();
require '../../../conf/db.php';
include "../../../conf/Get_time_zone.php";

$_SESSION['page_start'] = 'Report_page';  

$user = $_SESSION['user'];

// $user=$_POST['user'];
   $tfnsel="SELECT * from cdr WHERE call_from='$user' or  call_to='$user' ORDER BY id DESC";

?>
<div>
    <div class="show-users">
        <!-- user list table start -->
        <div class="my-table mr-2 table-responsive" >
            
        <!-- <table id="employee_grid" class="display responsive nowrap" style="width:100%"> -->
        <table id="employee_grid" class="table table-bordered table-striped table-hover" style="width:100%">

        <thead>
        <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Agent</th>
                    <th scope="col">Call From</th>
                    <th scope="col">Call To</th>
                    <th scope="col">Start time</th>
                    <th scope="col">Duration</th>
                    <th scope="col">Direction</th>
                    <th scope="col">Status</th>
                    <th scope="col">Hangup</th>
                    <th scope="col">Recordings</th>
                </tr>
    </thead>
  </table>
        </div>
    
    </div>
</div>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.0.1/js/dataTables.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
<link rel="stylesheet" href="../assets/css/dataTables.dataTables.min.css" />
<script type="text/javascript">
$.noConflict();
jQuery(document).ready(function($) {
$('#employee_grid').DataTable({
    "pageLength": 100,
    "processing": true,
    "serverSide": true,
    "ajax": {
        url: "pages/dashboard/datatables-ajax/ajaxfile.php",
        type: "post",
        error: function() {
            $("#employee_grid_processing").css("display", "none");
        }
    },
    "columns": [
        { "data": "sr" },
        { "data": "call_to" },
        // {
        //     "data": "call_to",
        //     render: function(data, type, row) {
        //         var html = '<div>';
        //         html += data;
        //         html += '<a type="button" data-callernumber="' + data + '" class="badge bg-primary clicktocall ml-2 cursor_p">';
        //         html += '<i class="fa fa-phone-square"></i>';
        //         html += '</a>';

        //         html += '</div>';
        //         return html;
        //     }
        // },
        {
    "data": "call_from",
    render: function(data, type, row) {
        if (data) {
            var data;
            var html = '<div>';
            
            // Check if the direction is 'inbound'
            if (row.direction == 'inbound') {
                html += data;  // Display the masked number
                html += '<a type="button" data-callernumber="' + row.click2call_call_from + '" class="badge bg-primary clicktocall ml-2 cursor_p">';
                html += '<i class="fa fa-phone-square"></i>';
                html += '</a>';
                html += '<a type="button" title="Click here and Block This number" class="badge bg-info ml-2 cursor_p num_block" data-number="' + row.click2call_call_from + '">';
                html += '<i class="fa fa-ban text-danger"></i>';
                html += '</a>';
            } else {
                html += data;  // Display the masked number for non-inbound cases
            }
            
            html += '</div>';
            return html;
        } else {
            return '';
        }
    }
},
        {
    "data": "did",
    render: function(data, type, row) {
        if (data) {
            var data;
            var html = '<div>';
            
            // Check if direction is 'outbound'
            if (row.direction == 'outbound') {
                // Show masked number but keep the original number for click-to-call and block
                html += data;
                html += '<a type="button" data-callernumber="' + row.click2call_did + '" class="badge bg-primary clicktocall ml-2 cursor_p">';
                html += '<i class="fa fa-phone-square"></i>';
                html += '</a>';
                html += '<a type="button" title="Click here and Block This number" class="badge bg-info ml-2 cursor_p num_block" data-number="' + row.click2call_did + '">';
                html += '<i class="fa fa-ban text-danger"></i>';
                html += '</a>';
            } else {
                // For other directions, display the masked data
                html += data;
            }

            html += '</div>';
            return html;
        } else {
            return '';
        }
    }
},
        { "data": "start_time" },
        { "data": "dur" },
        { "data": "direction" },
        { "data": "status" },
        { "data": "hangup" },
        {
            "data": "record_url",
            render: function(data, type, row) {
                var audioUrl = data.replace('http://', 'https://');
                var html = '<td>' +
                    '<audio class="audio-player" id="myTune">' +
                    '<source src="' + audioUrl + '" type="audio/wav">' +
                    '</audio>' +
                    '<button class="control" type="button" onclick="aud_play_pause(this)">' +
                    '<span class="play-pause-icon">▶</span>' +
                    '</button>' +
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

