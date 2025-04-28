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
       $_SESSION['agent_name_one'] = $agent_name;
       }else{
           $_SESSION['agent_name_one'] = '';
       }
 if(!empty($cal_date) && !empty($cal_date2)){
   $_SESSION['fromdate_one'] = $cal_date;
   $_SESSION['todate_one'] = $cal_date2;
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
   $_SESSION['agent_name_one'] = '';
   $_SESSION['fromdate_one'] = '';
   $_SESSION['todate_one'] = '';
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
        .heading_mang{
            margin-top: -10px !important;
        }
    </style> 

 <div class="user-stats">

        <div class="row my-card align-items-center">
        <div class="col-lg-6">
        <h5 class="">Agent Performance Overview</h5>

        <div class="stats-group">
            <div class="stats-card">
            <canvas id="doughnutChart" style="max-height: 250px;"></canvas>
            </div>
        </div>
       </div>

       <div class="col-lg-6">
        <h5 class="heading_mang">Calling Stats</h5>
        <div class="stats-group">
            <div class="stats-card">
                <canvas id="barChart" style="max-height: 250px;"></canvas>
                  <div class="card">
                   <div class="card-body">

                   </div>
                  </div>

            </div>
        </div>

    </div>

        </div>
   

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
    <h4>User Loging Reports <a href="?c=user&v=user_list" class="text-primary">Back</a></h4>
    <!-- <a href="#"><i class="fa fa-download" aria-hidden="true"></i></a> -->
    <a class="btn btn-success ml-2 text-white"href="pages/user/user_loginreport_export.php"> 
                        Export</a>
    </div>
<!-- ################################################### -->
<div class="">
<table id="employee_grid" class="table table-bordered">
                <thead>
                    <tr>
                    <th scope="col"><a href="#">SR.</a></th>
                            <th scope="col"><a href="#">USER ID</a></th>
                            <th scope="col"><a href="#">LOGIN TIME</a></th>
                            <th scope="col"><a href="#">No. OF CALL</a></th>
                            <th scope="col"><a href="#">NO. OF BREAK</a></th>
                            <th scope="col"><a href="#">BREAK NAME</a></th>
                            <th scope="col"><a href="#">STATUS</a></th>
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
                    "url": "pages/user/datatables-ajax/all_agent_report.php", // PHP script that fetches data
                    "type": "POST",
                    "error": function() {
                        $("#employee_grid_processing").css("display", "none");
                    }
                },
                "columns": [
    { "data": "sr" },
    { "data": "user_name" },
    { "data": "log_in_time" },
    { "data": "log_out_time" },
    { "data": "date_only" }, 
    { "data": "no_of_day_break" }, 
    { "data": "call_count" }
//     {
//     data: "status",
//     render: function(data, type, row) {
//         if (data) {
//             var html = '<div>';
//             if (data == '1') {
//                 html += '<span class="badge bg-success cursor_p text-white" title="This user is logged in">Login</span>';
//             } else {
//                 html += '<span class="badge bg-warning cursor_p text-white" title="This user is logged out">Logout</span>';
//             }
//             html += '</div>';
//             return html;
//         } else {
//             return '<div><span class="text-muted">No Status</span></div>';
//         }
//     }
// }


]

            });

        });
        </script>
        <script>
    let doughnutChart;

    document.addEventListener("DOMContentLoaded", () => {
        // Initialize the doughnut chart with dummy data
        doughnutChart = new Chart(document.querySelector('#doughnutChart'), {
            type: 'doughnut',
            data: {
                labels: ['Total Calls', 'Total Remarks', 'Performance (%)'],
                datasets: [{
                    label: 'Overall Performance',
                    data: [0, 0, 0], // Initial dummy data
                    backgroundColor: [
                        'rgb(54, 162, 235)', // Total Calls
                        'rgb(255, 159, 64)', // Total Remarks
                        'rgb(75, 192, 192)'  // Percentage Remarks
                    ],
                    hoverOffset: 4
                }]
            }
        });

        // Load initial data and set interval for updates
        loadChartData();
        setInterval(loadChartData, 5000); // Refresh every 5 seconds
    });

    // Function to fetch data and update the chart
    function loadChartData() {
        $.ajax({
            url: "pages/user/get_perfor_data.php", // Replace with your backend file path
            type: "POST",
            dataType: "json",
            success: function(res) {
                // console.log(res);
                if (res.error) {
                    console.error(res.error);
                    return;
                }

                // Update the chart with data from the response
                doughnutChart.data.datasets[0].data = [
                    res.Total_Calls || 0,
                    res.Total_Remarks || 0,
                    res.Percentage_Remarks || 0
                ];
                doughnutChart.update(); // Refresh the chart
            },
            error: function(xhr, status, error) {
                console.error("AJAX error:", status, error);
            }
        });
    }
</script>

        <script>
            document.addEventListener("DOMContentLoaded", async () => {
                // Fetch data from another page (API endpoint or server-side logic)
                const fetchCallData = async () => {
                    try {
                        // Example API call to fetch call counts
                        const response = await fetch('pages/user/dash_callcount.php'); // Replace with your endpoint
                        if (!response.ok) throw new Error('Network response was not ok');
                        const data = await response.json();
                        console.log(response);
                        return data; // Assuming API returns { answered: 50, cancelled: 20, other: 15, noAnswer: 30 }
                    } catch (error) {
                        console.error('Error fetching call data:', error);
                        return null; // Return null or fallback data in case of error
                    }
                };

                // Fetch the data and render the chart
                const callData = await fetchCallData();
                if (callData) {
                    const labels = ['Answered Calls', 'Cancelled Calls', 'Other Calls', 'No Answer Calls'];
                    const values = [
                        callData.answer_call || 0,
                        callData.cancel_call || 0,
                        callData.congetion_call || 0,
                        callData.noanswer_call || 0
                    ];

                    new Chart(document.querySelector('#barChart'), {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Call Counts',
                                data: values,
                                backgroundColor: [
                                    'rgba(75, 192, 192, 0.2)', // Answered
                                    'rgba(255, 99, 132, 0.2)', // Cancelled
                                    'rgba(255, 205, 86, 0.2)', // Other
                                    'rgba(54, 162, 235, 0.2)'  // No Answer
                                ],
                                borderColor: [
                                    'rgba(75, 192, 192)', // Answered
                                    'rgba(255, 99, 132)', // Cancelled
                                    'rgba(255, 205, 86)', // Other
                                    'rgba(54, 162, 235)'  // No Answer
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top',
                                    labels: {
                                        font: {
                                            size: 14
                                        }
                                    }
                                },
                                tooltip: {
                                    enabled: true
                                }
                            }
                        }
                    });
                } else {
                    console.error('Unable to load chart data.');
                }
            });
        </script>
