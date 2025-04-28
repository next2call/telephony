<?php 
session_start();
$_SESSION['page_start'] = 'index_page'; 
$date = date("Y M d");

require '../../../conf/db.php';
include "../../../conf/Get_time_zone.php";


 $adminuser = $_SESSION['user'];

 $full_name = $_SESSION['user'];
 $all_data_check = $_SESSION['filter_data'];

//  echo "<script>alert('$all_data_check')</script>";
$date1 = date("Y-m-d");

 
// Array of image paths
$imagePaths = [
    '../assets/images/dashboard/weather-girl.png',
    '../assets/images/dashboard/image3.png',
    '../assets/avatars/default.0.png',
    '../assets/avatars/default.1.png',
    '../assets/avatars/default.2.png',
    '../assets/avatars/default.3.png',
    '../assets/avatars/default.4.png',
    '../assets/avatars/default.5.png',
    '../assets/avatars/default.6.png',
    '../assets/avatars/default.7.png',
    '../assets/avatars/default.8.png',
    // Add more image paths as needed
];

// Get a random index
$randomIndex = array_rand($imagePaths);

// Get the randomly selected image path
$randomImagePath = $imagePaths[$randomIndex];

// Set desired width and height
$imageWidth = 150;
$imageHeight = 150;
 
?>
<div class="row justify-content-center ml-5">
<div class="col-lg-7 col-xl-6">
        <div class="row small-cards-group">
            <!-- <a href="filter_page.php"> -->
            <div class="col-lg-6 Total_call cursor_p">
                <div class="dashboard-card">
                    <div class="card-head">
                        <h5>Total Calls</h5>
                        <div class="card-head-icon">
                            <i class="fa fa-bar-chart" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <h2 id="total_call"></h2>
                    </div>
                </div>
            </div>
            <!-- </a> -->
            <div class="col-lg-6 Other_call cursor_p">
                <div class="dashboard-card">
                    <div class="card-head">
                        <h5>Other Calls</h5>
                        <div class="card-head-icon">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <h2 id="congetion_call"></h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 Answer_call cursor_p">
                <div class="dashboard-card">
                    <div class="card-head">
                        <h5>Answer Calls</h5>
                        <div class="card-head-icon">
                            <i class="fa fa-volume-control-phone" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <h2 title="Every conversation completed in seconds." id="answer_call"></h2>
                    </div>

                </div>
            </div>
            <div class="col-lg-6 Cancel_call cursor_p">
                <div class="dashboard-card">
                    <div class="card-head">
                        <h5>Cancel Calls</h5>
                        <div class="card-head-icon">
                            <i class="fa fa-times-circle-o" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <h2 id="cancel_call"></h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 cursor_p">
                <div class="dashboard-card">
                    <div class="card-head">
                        <h5>Call Queue</h5>
                        <div class="card-head-icon">
                            <i class="fa fa-volume-control-phone" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <h2 id="getqueueCalls"></h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 idle_agents cursor_p">
                <div class="dashboard-card" >
                    <div class="card-head">
                    <h5 title="Agents who are ready to take calls">Available Agents</h5>
                    <div class="card-head-icon">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <h2 id="idial_agents"></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="weather-card">
            <div class="row justify-content-between">
                <div class="col-md-5 mt-2">
                    <div class="row align-items-center">
                        <div class="todays-icon col-6">
                            <img src="../assets/images/dashboard/sun.png" alt="" />
                        </div>
                        <div class="todays-info col-6">
                            <h5><?= strtoupper(date('D')); ?></h5>
                            <h5><?php
                            echo $date;
                            ?></h5>
                        </div>
                    </div>
                    <div class="admin">
                        <!-- <img src="./assets/images/dashboard/Profile.png" alt=""> -->
                        <h5><?= $full_name ?></h5>
                    </div>
                    <div class="location">
                        <h5>
                            <img src="../assets/images/dashboard/Location.png" alt="" />
                            Noida, India
                        </h5>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="welcome-info">
                        <div>
                            <h4>Welcome Back</h4>
                            <h4 id="timeDisplay"></h4>
                        </div>
                        <img src="<?php echo $randomImagePath; ?>" alt="Random Image" width="<?php echo $imageWidth; ?>"
                            height="<?php echo $imageHeight; ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
<div class="row justify-content-center ml-5 px-5">
            <div class="col-lg-12">
                <div class="total-stats">
                    <div>
                        <div class="select">
                            <select name="cars" id="cars"
                                onchange="redirectToSelected(this.value, this.options[this.selectedIndex].getAttribute('filter_data'));">
                                <option value="">Select option</option>
                                <option value="/Telephony/agent/index.php" filter_data="today">Today</option>
                                <option value="/Telephony/agent/index.php" filter_data="all">All</option>
                            </select>
                        </div>
                    </div>
                    <div class="total-stats-table1 table-responsive">
                    <table class="table" id="notification_table">
                        <thead>
                            <tr>
                                <th scope="col">Sr.</th>
                                <th scope="col">Call From</th>
                                <th scope="col">Call To</th>
                                <th scope="col">Start Time</th>
                                <th scope="col">Duration</th>
                                <th scope="col">Status</th>
                                <th scope="col">Direction</th>
                            </tr>
                        </thead>
                    </table>
                </div>

                </div>
            </div>
        </div>

        <script type="text/javascript">
jQuery(document).ready(function($) {
    $('#notification_table').DataTable({
        "pageLength": 10,
        "processing": true,
        "serverSide": true,
        "searching": false, // Ensure searching is enabled
        "ajax": {
            url: "pages/dashboard/datatables-ajax/ajaxfile.php",
            type: "post",
            error: function() {
                $("#notification_table_processing").css("display", "none");
            }
        },
        "columns": [
            { "data": "sr" },
            {
    "data": "call_from",
    render: function(data, type, row) { 
        if (data) {
            var html = '<div>';
            
            // Check if direction is 'inbound'
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

        // Create HTML with masked number and click-to-call functionality
        var html = '<div>';
        html += data;  // Display the masked number
        html += '<a type="button" data-callernumber="' + row.click2call_did + '" class="badge bg-primary clicktocall ml-2 cursor_p">';
        html += '<i class="fa fa-phone-square"></i>';
        html += '</a>';
        html += '</div>';
        
        return html;
    }
},
            { "data": "start_time" },
            { "data": "dur" },
            { "data": "status" },
            { "data": "direction" },
          
        ]
    });
});
</script>     
<script>
$(document).ready(function() {
    $(".Total_call").on("click", function() {
        var user = '<?= $adminuser ?>';
        var f_data = 'total_data';
        // alert(url);
        $.ajax({
            type: "POST",
            url: "pages/dashboard/filter_page.php", // Add a comma here

            data: {
                user: user,
                data: f_data
            }, // Add a comma here
            success: function(response) {
                // Update the content of the element with the ID "result"
                $("#content").html(response);
            }
        });
    });
});
$(document).ready(function() {
    $(".Other_call").on("click", function() {
        var user = '<?= $adminuser ?>';
        var f_data = 'other_data';
        // alert(user);
        $.ajax({
            type: "POST",
            url: "pages/dashboard/filter_page.php", // Add a comma here
            data: {
                user: user,
                data: f_data
            }, // Add a comma here
            success: function(response) {
                // Update the content of the element with the ID "result"
                $("#content").html(response);
            }
        });
    });
});
$(document).ready(function() {
    $(".Answer_call").on("click", function() {
        var user = '<?= $adminuser ?>';
        var f_data = 'answer_data';
        // alert(user);
        $.ajax({
            type: "POST",
            url: "pages/dashboard/filter_page.php", // Add a comma here
            data: {
                user: user,
                data: f_data
            }, // Add a comma here
            success: function(response) {
                // Update the content of the element with the ID "result"
                $("#content").html(response);
            }
        });
    });
});
$(document).ready(function() {
    $(".Cancel_call").on("click", function() {
        var user = '<?= $adminuser ?>';
        var f_data = 'cancel_data';
        // alert(user);
        $.ajax({
            type: "POST",
            url: "pages/dashboard/filter_page.php", // Add a comma here
            //url: "pages/dashboard/filter_page_copy.php", // Add a comma here
            data: {
                user: user,
                data: f_data
            }, // Add a comma here
            success: function(response) {
                // Update the content of the element with the ID "result"
                $("#content").html(response);
            }
        });
    });
});

$(document).ready(function(){
    $(".idle_agents").on("click", function(){
        var filter_data = 'today';
        var user = '<?= $adminuser ?>';
        var f_data = 'cancel_data';
        // alert(user);
        $.ajax({
            type: "POST",
            url: "pages/user/agent_list.php", // Add a comma here
            data: {
                user: user,
                filter_data: filter_data
            }, // Add a comma here
            success: function(response) {
                // Update the content of the element with the ID "result"
                $("#content").html(response);
            }
        });
    });
});
</script>
<script>
function updateClock() {
    // Get the current time
    var name_time_zone = '<?= $name_of_time_zone ?>';

    var currentTime = new Date().toLocaleTimeString('en-US', { timeZone: name_time_zone });

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
        function redirectToSelected(url, filter_data) {
            if (filter_data) {

                var xhr = new XMLHttpRequest();
                xhr.open("POST", "pages/dashboard/filter_session.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.status === 'success') {
                            window.location.href = url;
                        } else {
                            console.error('Error:', response.message);
                        }
                    }
                };

                xhr.send("filter_data=" + encodeURIComponent(filter_data));
            }
        }
    </script>
    <script>
    setInterval(loaddata, 500);
    function loaddata() {
        var list_id = $("#list_id").data("list_id");
        var filter_data = '<?= $_SESSION['filter_data'] ?>';

        $.ajax({
            url: "pages/dashboard/dash_callcount.php",
            data: { filter_data: filter_data }, // Or 'all', depending on the filter
            type: "POST",
            dataType: "json",
            success: function(res) {
                $("#total_call").text(res.total_call || '0');
                $("#answer_call").text(res.answer_call || '0');
                $("#cancel_call").text(res.cancel_call || '0');
                $("#congetion_call").text(res.congetion_call || '0');
                $("#getqueueCalls").text(res.getqueueCalls || '0');
                $("#idial_agents").text(res.idial_agents || '0');
                // $("#noanswer").text(res.noanswer_call || '0');
            },
            error: function(xhr, status, error) {
                console.error("AJAX error: ", status, error);
            }
        });
    }
</script>
  
   