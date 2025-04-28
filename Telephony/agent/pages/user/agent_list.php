<?php
session_start();
include "../../../conf/db.php";
include "../../../conf/url_page.php";

date_default_timezone_set('America/New_York'); // Set the timezone to Eastern Time

$date = date('Y-m-d'); // Example date, replace with actual value

$_SESSION['page_start'] = 'Report_page';  
$Adminuser = $_SESSION['user'];

$usersql = "SELECT admin FROM `users` WHERE user_id='$Adminuser'"; 
$userResult = mysqli_query($con, $usersql);
$userRow = mysqli_fetch_assoc($userResult);
$admin = $userRow['admin'] ?? '';

?>
                <style>
        .status-ready {
            background-color: #A6F7A5;
            color: black;
        }
        .status-break {
            background-color: #E5F0A1;
            color: black;
        }
        .status-blue {
            background-color: blue;
            color: white;
        }
        .status-purple {
            background-color: purple;
            color: white;
        }
    </style>
                <div class="ml-5">
                    <!-- Layout Start -->
                    <div class="total-stats">
                    <!-- <div>
                        <h3 class="ml-5">Ready Agents</h3>
                        <div class="select">
                          
                        </div>
                    </div> -->
                    <div class="total-stats-table1 table-responsive">
                <table class="table" id="tbl_col">
                    <thead>
                        <tr>
                           <th scope="col">Sr.</th>
                            <th scope="col">Agents</th>
                            <th scope="col">Status</th>
                            <th scope="col">Last call</th>
                            <!-- <th scope="col">Pause</th> -->
                            <th scope="col">Ready/Pause</th>
                            <th scope="col">Login</th>
                            <th scope="col">Talk</th>
                            <th scope="col">Answer</th>
                            <th scope="col">Cancel</th>
                            <th scope="col">Other</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        <!-- Data will be dynamically inserted here -->
                    </tbody>
                </table>
            </div>
                    </div>
    

                    <!-- Layout End -->
                </div>


            </div>
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    
    $(document).ready(function() {
        var user = '<?= $admin ?>';
        var date = '<?= $date ?>'; 
        var filter_data = 'today'; 
        var status = '';
        
        console.log("User:", user);
        console.log("Date:", date);
        console.log("Filter Data:", filter_data);
        console.log("Status:", status);

        function fetchData() {
            $.ajax({
                url: 'pages/dashboard/Summary_data.php', // URL to your PHP script that fetches data
                type: 'GET',
                dataType: 'json',
                data: {
                    status: status, // Example status, replace with the actual status
                    date: date, // Example date, replace with the actual date
                    Adminuser: user, // Example admin user, replace with the actual admin user
                    all_data_check: filter_data // Example all_data_check, replace with the actual value
                },
                success: function(response) {
                    var tableBody = $('#table-body');
                    tableBody.empty(); // Clear existing table data

                    // Loop through the response and build table rows
                    $.each(response.data, function(index, row) {
                        
                        var statusText;
                            var rowClass;

                            if (row.break_status == '2' && row.status == '2') {
                                statusText = '<span class="text-success">Ready</span>';
                                rowClass = 'status-ready';
                            } else if (row.break_status == '2' && row.status == '3') {
                                if (row.Calldirection=='inbound') {
                                statusText = '<span class="text-blue">' + 'Incall/'+ row.Calldirection + '</span>';
                                rowClass = 'status-blue';
                                }else{
                                    statusText = '<span class="text-purple">' + 'Incall/'+ row.Calldirection + '</span>';
                                    rowClass = 'status-purple';
                                } 
                            } else if (row.break_status == '1' && row.status == '1') {
                                statusText = '<span class="text-break">' + row.break_name + '</span>';
                                rowClass = 'status-break';
                            } else {
                                statusText = '<span class="text-danger">Logout</span>';
                                rowClass = '';
                            }

                            console.log("response:", response.data); 


                        var newRow = '<tr class="' + rowClass + '">' +
                            '<td>' + row.sr + '</td>' +
                            '<td title="UserId: ' + row.user_name + '">' + row.user_name + '</td>' +
                            '<td>' + statusText + '</td>' +
                            '<td>' + row.wait_duration_seconds + '</td>' +
                            '<td>' + row.ready_seconds + '</td>' +
                            // '<td>' + row.pause_seconds + '</td>' +
                            '<td>' + row.login_duration + '</td>' +
                            '<td title="Total Answer Call Duration: ' + row.total_duration_A_call + ' Sec">' + row.total_duration_A_call + '</td>' +
                            '<td>' + row.total_ans_call_agent + '</td>' +
                            '<td>' + row.total_can_call_agent + '</td>' +
                            '<td>' + row.total_oth_call_agent + '</td>' +
                            '<td>' + row.total_call_agent + '</td>' +
                            '</tr>';

                        tableBody.append(newRow);
                    });
                },
                error: function(error) {
                    console.log('Error fetching data', error);
                }
            });
        }

        // Fetch data on page load
        fetchData();

        // Optionally, you can set an interval to refresh the data every X seconds
        setInterval(fetchData, 2000); // Fetch data every 2 seconds
    });

</script>
