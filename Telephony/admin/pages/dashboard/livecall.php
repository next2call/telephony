<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Calls</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
        .badge {
            cursor: pointer;
        }
        .table tbody td[colspan="15"] {
            text-align: center;
        }
        .login { color: blue; }
        .idle { color: green; }
        .pause { color: orange; }
        .in-call { color: greenyellow; }
        .call-queue { color: purple; }
        .call-dial { color: rebeccapurple; }
        .status-container {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function callAgent(agentNumber) {
            var iframe = window.parent.document.getElementById('popupIframe');
            if (iframe) {
                iframe.src = '/Telephony/AdminPhone/Phone/click-wisper.php?d=99' + agentNumber;
            } else {
                alert('Unable to find the iframe in the parent page.');
            }
        }
        function callAgentBarge(agentNumber) {
            var iframe = window.parent.document.getElementById('popupIframe');
            if (iframe) {
                iframe.src = '/Telephony/AdminPhone/Phone/click-wisper.php?d=98' + agentNumber;
            } else {
                alert('Unable to find the iframe in the parent page.');
            }
        }
        function callAgentWhisper(agentNumber) {
            var iframe = window.parent.document.getElementById('popupIframe');
            if (iframe) {
                iframe.src = '/Telephony/AdminPhone/Phone/click-wisper.php?d=97' + agentNumber;
            } else {
                alert('Unable to find the iframe in the parent page.');
            }
        }

        function loadPage() {
            var filter_data = '<?= $_REQUEST['filter_data'] ?? 'today'?>';

            $.ajax({
                url: "dash_live_agents.php",
                data: { filter_data: filter_data }, // Or 'all', depending on the filter
                type: "POST",
                dataType: "json",
                success: function(res) {
                    $("#login_agents").text(res.login_agents || '0');
                    $("#idle_agents").text(res.idle_agents || '0');
                    $("#pause_agents").text(res.pause_agents || '0');
                    $("#in_call_agents").text(res.in_call_agents || '0');
                    $("#call_queue_agents").text(res.call_queue_agents || '0');
                    $("#call_dial_agents").text(res.call_dial_agents || '0');
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error: ", status, error);
                }
            });
        }

        $(document).ready(function() {
            function fetchLiveCalls() {
                $.ajax({
                    url: 'liveajaxfie.php',
                    method: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        if (response.length > 0) {
                            let rows = '';
                            let sr = 1;

                            response.forEach(function(call) {
                                let rowColor = '';
                                let durationFormatted = '00:00:00'; // Default duration
                                let tdColor = ' style="color: blue; background-color: #f0f0f0;"';

                                if (call.direction === 'outbound') {
                                    tdColor = ' style="color: purple; background-color: #f0f0f0;"';
                                }

                                if (call.status === 'Answer') {
                                    durationFormatted = call.time_in_seconds; // Format as HH:mm:ss   
                                    rowColor = ' style="color: green;"';
                                } else if (call.Agent === 'NOAGENT' || call.status === 'Ringing') {
                                    rowColor = ' style="color: red;"';
                                }

                                rows += `<tr${rowColor}>
                                            <td>${sr}</td>
                                            <td>${call.time}</td>
                                            <td>${call.Full_name}</td>
                                    
                                            <td>${call.Agent}</td>
                                            <td>${call.call_from}</td>
                                            <td>${call.call_to}</td>
                                            <td>${call.status}</td>
                                            <td>${durationFormatted}</td>
                                            <td${tdColor}>${call.direction}</td>
                                            <td>${call.compaignname}</td>
                                            <td>
                                            <div style="display: flex; gap: 10px; align-items: center;">
                                                <!-- Spy Call -->
                                                <a type="button" data-callernumber="${call.Agent}" onclick="callAgent('${call.Agent}')" title="You can click here to spy call">
                                                    <i class="fas fa-assistive-listening-systems"></i>
                                                </a>

                                                <!-- Barge Call -->
                                                <a type="button" data-callernumber="${call.Agent}" onclick="callAgentBarge('${call.Agent}')" title="You can click here to Barge call">
                                                    <i class="fas fa-phone-square"></i>
                                                </a> 

                                                <!-- Whisper Call -->
                                                <a type="button" data-callernumber="${call.Agent}" onclick="callAgentWhisper('${call.Agent}')" title="You can click here to Whisper call">
                                                    <i class="fa fa-user"></i>
                                                </a>
                                            </div>
                                        </td>

                                        </tr>`;
                                sr++;
                            });
                            $('#liveCallsTable tbody').html(rows);
                        } else {
                            $('#liveCallsTable tbody').html('<tr><td colspan="15">No data found</td></tr>');
                        }
                    },
                    error: function() {
                        $('#liveCallsTable tbody').html('<tr><td colspan="8">Error fetching data</td></tr>');
                    }
                });
            }

            fetchLiveCalls();
            setInterval(fetchLiveCalls, 1000); // Refresh every 1 second
            setInterval(loadPage, 2000); // Refresh agent counts every 2 seconds
        });
    </script>
</head>
<body>
<div class="status-container">
        <h5>
            <span class="login">Login: <span id="login_agents">0</span></span> |
            <span class="idle">Available: <span id="idle_agents">0</span></span> |
            <span class="pause">Pause: <span id="pause_agents">0</span></span> |
            <span class="in-call">In Call: <span id="in_call_agents">0</span></span> |
            <span class="call-dial">Call Dialing: <span id="call_dial_agents">0</span></span> |
            <span class="call-queue">Call Queue: <span id="call_queue_agents">0</span></span>
        </h5>
    </div>
    <div class="table-container">
        <table id="liveCallsTable" class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Start Time</th>
                    <th>Agent Name</th>
                    <th>Agent ID</th>
                    <th>Call From</th>
                    <th>Call To</th>
                    <th>Call Status</th>
                    <th>Duration</th>
                    <th>Direction</th>
                    <th>Camp.</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="9">Loading data...</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
