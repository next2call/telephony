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
    <form id="search_data" class="call_rp_maj" method="post">
    <div class="row my-card align-items-center">
                <div class="my-dropdown-with-help col-12 col-md-3 col-lg-3">
            <div class="my-dropdown">
                <select name="call_status" id="call_status">
                    <option value="">Select Status</option>
                    <option value="ANSWER">ANSWER</option>
                    <option value="CANCEL">CANCEL</option>
                    <option value="BUSY">BUSY</option>
        
                </select>
                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                <!-- <label for="local_call_time">Select Status</label> -->
            </div>
        </div>
        <div class="my-input-with-help col-12 col-md-3 col-lg-3">
            <div class="form-group my-input">
                <input type="date" class="form-control str_date" id="str_date" name="from_date" 
                       placeholder="YYYY-MM-DD">
                <label for="str_date">From Date</label>
            </div>
        </div> 
        <div class="my-input-with-help col-12 col-md-3 col-lg-3">
            <div class="form-group my-input">
                <input type="date" class="form-control str_date2" id="end_date" name="to_date" 
                       placeholder="YYYY-MM-DD">
                <label for="end_date">To Date</label>
            </div>
        </div>
        <button class="btn btn-primary ml-5" type="submit">Search</button> 
    </div>
</form>

        <div class="my-table mr-2 table-responsive" >
        <table id="employee_grid" class="display responsive nowrap" style="width:100%">
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
    // Initialize DataTable
    var table = $('#employee_grid').DataTable({
        "pageLength": 100,
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: "pages/dashboard/datatables-ajax/ajaxfile.php",
            type: "POST",
            data: function(d) { 
                // Pass form data to server-side script
                d.call_status = $('#call_status').val();
                d.from_date = $('#str_date').val();
                d.to_date = $('#end_date').val();
            },
            error: function() {
                $("#employee_grid_processing").css("display", "none");
            }
        },
        "columns": [
            { "data": "sr" },
            { "data": "call_to" },
            { "data": "call_from" },
            { "data": "did" },
            { "data": "start_time" },
            { "data": "dur" },
            { "data": "direction" },
            { "data": "status" },
            { "data": "hangup" },
            { "data": "record_url" }
        ]
    });

    // Redraw DataTable on form submission
    $('#search_data').on('submit', function(e) {
        e.preventDefault();
        table.ajax.reload(); // Reload DataTable with new parameters
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

