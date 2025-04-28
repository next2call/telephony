<?php
session_start();
require '../../../conf/db.php';
include "../../../conf/Get_time_zone.php";

$_SESSION['page_start'] = 'Report_page';  

 $user = $_SESSION['user'];
// die();
$get_data = $_POST['data'];
// echo "<script>alert($get_data)</script>";
$_SESSION['filter_type']=$get_data;
// echo "</br>";
// $user=$_POST['user'];
$all_data_check = $_SESSION['filter_data'];
// die(); 

$date1 = date("Y-m-d");

$tfnsel="SELECT * from cdr WHERE call_from='$user' or  call_to='$user' ORDER BY id DESC";

?>
<div>
    <div class="show-users">

        <div class="my-table mr-2" >
            
        <table id="employee_grid" class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Call From</th>
        <th>Call To</th>
        <th>Start time</th>
        <th>Duration</th>
        <th>Status</th>
        <th>Hangup</th>
        <th>Direction</th>
        <th>Recordings</th>
      </tr>
    </thead>
  </table>
        </div>
    
    </div>
</div>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.0.1/js/dataTables.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.min.css" />
<script type="text/javascript">
$.noConflict();
jQuery( document ).ready(function( $ ) {
    
    $('#employee_grid').DataTable({
        // "pageLength": 100,
                "processing": true,
                "serverSide": true,
        "ajax": {
            url :"pages/dashboard/datatables-ajax/ajaxfile_filter.php", // PHP script that fetches data
            type: "post",  // method used for sending data to the server
            error: function(){  // error handling
              $("#employee_grid_processing").css("display","none");
            }
        },
        "columns": [  // define columns to be displayed
            { "data": "sr" },  // "id" should match with the key in your JSON response
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
{
    data: "call_from",
    render: function(data, type, row) {
        if (data) {
            let noly10;

            // Determine value of noly10 based on click2call_callfrom
            if (row.click2call_callfrom.length > 10) {
                noly10 = parseInt(row.click2call_callfrom.substr(2), 10); // Extract substring and convert to integer
            } else {
                noly10 = row.click2call_callfrom; // Use the value directly
            }

            // Build HTML for the "call_from" field
            let html = '<div>';
            if (row.direction === 'inbound') {
                html += data;
                html += '<a type="button" data-callernumber="' + noly10 + '" class="badge bg-primary clicktocall ml-2 cursor_p">';
                html += '<i class="fa fa-phone-square"></i>';
                html += '</a>';
            } else {
                html += data;
                html += '<a type="button" data-callernumber="' + noly10 + '" class="badge bg-primary clicktocall ml-2 cursor_p">';
                html += '<i class="fa fa-phone-square"></i>';
                html += '</a>';
            }
            html += '</div>';
            return html;
        } else {
            return '';
        }
    }
}, 
{ "data": "start_time" },  // "start_time" should match with the key in your JSON response
            { "data": "dur" },  // "dur" should match with the key in your JSON response
            { "data": "status" },  // "status" should match with the key in your JSON response
            { "data": "hangup" },  // "status" should match with the key in your JSON response
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
        // '<a href="' + audioUrl + '" download>' +
        // '<button class="download-button" type="button">' +
        // '<i class="fa fa-download"></i>' +
        // '</button>' +
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

