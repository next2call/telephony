<?php
session_start();

$_SESSION['page_start'] = 'index_page'; 
$user_level = $_SESSION['user_level'];

if($user_level == 2 || $user_level == 6 || $user_level == 7){
    $Adminuser = $_SESSION['admin'];
    $new_user = $_SESSION['user'];
} else {
    $Adminuser = $_SESSION['user'];
}
include "../../../conf/db.php";
include "../../../conf/url_page.php";
include "../../../conf/Get_time_zone.php";

$filter_data = $_GET['filter_data'] ?? 'Select option';
$status = $_GET['status'] ?? 'Select option';



$all_data_check=$_REQUEST['filter_data'];
$date = date("Y-M-d");

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
<div class="row justify-content-center ml-5">
    <div class="col-lg-12 mr-2">
        <div class="total-stats">
            <div>
                <h5>Agents Summary</h5>
                <div class="select">
              
                </div>
                <div class="select">
                <select name="car" id="car" onchange="redirectToSelect()">
              <option value="All"><?echo $status ?></option>
              <option value="<?= $admin_ind_page ?>?c=dashboard&v=summry_index&filter_data=<?echo $filter_data ?>&status=All#tbl_col">All</option>
              <option value="<?= $admin_ind_page ?>?c=dashboard&v=summry_index&filter_data=<?echo $filter_data ?>&status=Ready#tbl_col">Ready</option>
                 <option value="<?= $admin_ind_page ?>?c=dashboard&v=summry_index&filter_data=<?echo $filter_data ?>&status=pause#tbl_col">pause</option>
                </select>
                    
                </div>
            </div>
            <!-- <div class="total-stats-table1 table-responsive"> -->   
                <table class="all-user-table table table-hover">
                <thead>
                <tr>
                            <th>Sr.</th>
                            <th>Agents</th>
                            <th>Status</th>
                            <th>Last call</th>
                            <!-- <th >Pause</th> -->
                            <th>Ready/Pause</th>
                            <th>Login</th>
                            <th>Talk</th>
                            <th>Answer</th>
                            <th>Cancel</th>
                            <th>Other</th>
                            <th>Total</th>
                        </tr>
                </thead>
                <tbody id="table-body">
                        <!-- Data will be dynamically inserted here -->
                    </tbody>
                </table>
            
            <!-- </div> -->

            <div class="view-all">
                <!-- <p>View All <i class="fa fa-angle-right" aria-hidden="true"></i></p> -->
            </div>
        </div>
    </div>
</div>
<script
  src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
  crossorigin="anonymous"></script>
  <?php
$adminuser = $Adminuser ; // Example value, replace with actual value
$date = date('Y-m-d'); // Example date, replace with actual value

if($filter_data=='Select option'){
    $filter_data = 'today'; // Example value, replace with actual value
}
if($status=='Select option'){
    $userStatus = ''; // Example value, replace with actual value
}else{
    $userStatus = $status;
}

$admin_ind_page = $filter_data; // Example value, replace with actual value
$finalstatus = $userStatus; // Example value, replace with actual value
?>


<script>
   $(document).ready(function() {
    var user = '<?= $adminuser ?>'; 
    var date = '<?= $date ?>'; 
    var filter_data = '<?= $admin_ind_page ?>'; 
    var status = '<?= $finalstatus ?>';
    
    console.log("User:", user);
    console.log("Date:", date);
    console.log("Filter Data:", filter_data);
    console.log("Status:", status);

    var firstLoad = true; // Flag to track first-time loading

    function fetchData() {
        $.ajax({
            url: 'pages/dashboard/Summary_extra.php', // URL to your PHP script that fetches data
            type: 'GET',
            dataType: 'json',
            data: {
                status: status, 
                date: date, 
                Adminuser: user, 
                all_data_check: filter_data 
            },
            success: function(response) {
                var tableBody = $('#table-body');
                tableBody.empty(); // Clear existing table data

                $.each(response.data, function(index, row) {
                    var statusText;
                    var rowClass;

                    if (row.break_status == '2' && row.status == '2') {
                        statusText = '<span class="text-success">Ready</span>';
                        rowClass = 'status-ready';
                    } else if (row.break_status == '2' && row.status == '3') {
                        if (row.Calldirection == 'inbound') {
                            statusText = '<span class="text-blue">Incall/' + row.Calldirection + '</span>';
                            rowClass = 'status-blue';
                        } else {
                            statusText = '<span class="text-purple">Incall/' + row.Calldirection + '</span>';
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
                        '<td>' + row.login_duration + '</td>' +
                        '<td title="Total Answer Call Duration: ' + row.total_duration_A_call + ' Sec">' + row.total_duration_A_call + '</td>' +
                        '<td>' + row.total_ans_call_agent + '</td>' +
                        '<td>' + row.total_can_call_agent + '</td>' +
                        '<td>' + row.total_oth_call_agent + '</td>' +
                        '<td>' + row.total_call_agent + '</td>' +
                        '</tr>';

                    tableBody.append(newRow);
                });

                // Set a delay for subsequent fetches
                if (firstLoad) {
                    firstLoad = false; // Set the flag to false after the first load
                    setTimeout(fetchData, 5000); // Delay next fetch by 5 seconds (adjust as needed)
                } else {
                    setTimeout(fetchData, 10000); // Subsequent fetches after 10 seconds
                }
            },
            error: function(error) {
                console.log('Error fetching data', error);
            }
        });
    }

    // Fetch data immediately on the first page visit
    fetchData();
});

</script>


