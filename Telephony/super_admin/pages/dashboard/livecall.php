<?php
// Sample data for initial display
$liveCalls = [
    ['name' => 'John Doe', 'agent_name' => 'Agent A', 'number' => '1234567890', 'status' => 'In Progress'],
    ['name' => 'Jane Smith', 'agent_name' => 'Agent B', 'number' => '0987654321', 'status' => 'Completed'],
    // Add more sample data as needed
];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Live Calls</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #343a40;
        }
        .table-container {
            max-width: 900px;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
          font-size: 12px;
        }
        .table th {
            background-color: #343a40;
            color: #fff;
        }
        .table tbody tr:nth-child(odd) {
            background-color: #f8f9fa;
        }
        .table tbody tr:hover {
            background-color: #e9ecef;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            function fetchLiveCalls() {
                $.ajax({
                    url: 'liveajaxfie.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if(response.length > 0) {
                            let rows = '';
                            let sr = 1;
                            response.forEach(function(call) {
                                rows += `<tr>
                                            <td>${sr}</td>
                                            <td>${call.Full_name}</td>
                                            <td>${call.Agent}</td>
                                            <td>${call.time}</td>
                                            <td>${call.direction}</td>
                                            <td>${call.status}</td>
                                            <td>${call.call_from}</td>
                                            <td>${call.compaignname}</td>
                                        </tr>`;
                                        sr++; 
                            });
                            $('#liveCallsTable tbody').html(rows);
                        } else {
                            $('#liveCallsTable tbody').html('<tr><td colspan="8">No data found</td></tr>');
                        }
                    }
                });
            }

            fetchLiveCalls();

            // Optional: Refresh every 5 seconds
            setInterval(fetchLiveCalls, 5000);
        });
    </script>
</head>
<body>
    <h2>Live Calls</h2>
    <div class="table-container">
        <table id="liveCallsTable" class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Agent Name</th>
                    <th>Agent</th>
                    <th>Start Time</th>
                    <th>Direction</th>
                    <th>Call Status</th>
                    <th>call from</th>
                    <th>Campaign Name</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="8">Loading data...</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
