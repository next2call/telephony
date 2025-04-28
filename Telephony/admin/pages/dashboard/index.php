<?php
session_start();
include "../../../conf/db.php";
include "../../../conf/url_page.php";
include "../../../conf/Get_time_zone.php";

$_SESSION['page_start'] = 'index_page'; 
$user_level = $_SESSION['user_level'];
$user_summary = '<a href="?c=dashboard&v=summry_index">Agents Summary</a>';
$summary_data_url = 'pages/dashboard/Summary_data.php';
if ($user_level == 2 || $user_level == 6 || $user_level == 7) {
    $Adminuser = $_SESSION['admin'];
    $new_user = $_SESSION['user'];
} elseif ($user_level == 9) {
    $Adminuser = $_SESSION['user'];
    $user_summary = 'Customer Summary';
    $summary_data_url = 'pages/dashboard/user_summary_data.php';
} else {
    $Adminuser = $_SESSION['user'];
}


$filter_data = $_GET['filter_data'] ?? 'Select option';
$status = $_GET['status'] ?? 'Select option';




$all_data_check=$_REQUEST['filter_data'];
$date = date("Y-M-d");


$sel_user = "select * from users WHERE admin = '$Adminuser'";
$qur_user = mysqli_query($con, $sel_user);
$count_use = mysqli_num_rows($qur_user);


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

<style>
    .total-stats-table1 {
    max-height: 320px; /* Adjust the height as needed */
    overflow-y: auto; /* Enables vertical scrolling */
    /* overflow-x: hidden; Hides horizontal scrolling if not needed */
}

.table-responsive {
    display: block;
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

</style>

<div class="row justify-content-center ml-5">
    <div class="col-lg-12 col-xl-12 ml-3">
        <div class="row small-cards-group">
             <div class="col-lg-2 Total_call">
                <div class="dashboard-card">
                    <div class="card-head">
                        <h5>Total Calls</h5>
                        <div class="card-head-icon">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <h2 id="total_call"></h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 Other_call">
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
            <div class="col-lg-2 Answer_call">
                <div class="dashboard-card">
                    <div class="card-head">
                        <h5>Answer Calls</h5>
                        <div class="card-head-icon">
                            <i class="fa fa-volume-control-phone" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <h2 id="answer_call"></h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 Cancel_call">
                <div class="dashboard-card">
                    <div class="card-head">
                        <h5>Cancel Calls</h5>
                        <div class="card-head-icon">
                            <i
                                    class="fa fa-times-circle-o"
                                    aria-hidden="true"
                            ></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <h2 id="cancel_call"></h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 call_queue_agents">
                <div class="dashboard-card">
                    <div class="card-head">
                        <h5>Call Queue</h5>
                        <div class="card-head-icon">
                            <i
                                    class="fa fa-circle-o-notch"
                                    aria-hidden="true"
                            ></i>
                        </div>
                    </div>

                    <div class="card-body">
                        <h2 id="call_queue_agents"></h2>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 out_boundcall">
                <div class="dashboard-card">
                    <div class="card-head">
                        <h5>Outbond Call</h5>
                        <div class="card-head-icon">
                            <i
                                    class="fa fa-phone"
                                    aria-hidden="true"
                            ></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <h2 id="outbond_call"></h2>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 Inbound_call mt-2">
                <div class="dashboard-card">
                    <div class="card-head">
                        <h5>Inbound Call</h5>
                        <div class="card-head-icon">
                            <i
                                    class="fa fa-phone"
                                    aria-hidden="true"
                            ></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <h2 id="Inbond_call"></h2>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 No_answer mt-2">
                <div class="dashboard-card">
                    <div class="card-head">
                        <h5>No Answer</h5>
                        <div class="card-head-icon">
                            <i
                                    class="fa fa-times-circle-o"
                                    aria-hidden="true"
                            ></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <h2 id="noanswer"></h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-2  login_agents cursor_p mt-2">
                <div class="dashboard-card">
                    <div class="card-head">
                        <h5>Login Agents </h5>
                        <div class="card-head-icon">
                            <i
                                    class="fa fa-user"
                                    aria-hidden="true"
                            ></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <h2 id="login_agents"></h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 idle_agents cursor_p mt-2">
                <div class="dashboard-card">
                    <div class="card-head">
                        <h5>Available Agents</h5>
                        <div class="card-head-icon">
                            <i
                                    class="fa fa-user"
                                    aria-hidden="true"
                            ></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <h2 id="idle_agents"></h2>
                        
                    </div>
                </div>
            </div>
            <div class="col-lg-2 pause_agents cursor_p mt-2">
                <div class="dashboard-card">
                    <div class="card-head">
                        <h5>Pause Agents</h5>
                        <div class="card-head-icon">
                            <i
                                    class="fa fa-user"
                                    aria-hidden="true"
                            ></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <h2 id="pause_agents"></h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 in_call_agents cursor_p mt-2">
                <div class="dashboard-card">
                    <div class="card-head">
                        <h5>In Call</h5>
                        <div class="card-head-icon">
                            <i
                                    class="fa fa-volume-control-phone"
                                    aria-hidden="true"
                            ></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <h2 id="in_call_agents"></h2>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="row justify-content-center ml-4 mt-3">
    <div class="col-lg-4"> 
        <div class="system-summary">
            <h3>Total Stats</h3>
            <div class="stats-group">
                <div class="stats-card">
                     <canvas id="pieChart" style="max-height: 400px;"></canvas>
                </div>
             
            </div>
        </div>
    </div>
    
    <div class="col-lg-8">
        <div class="total-stats">
            <div>
                <h5><a href="?c=dashboard&v=summry_index">Agents Summary</a></h5>
                <div class="select">
                <select name="cars" id="cars" onchange="redirectToSelected()">
                <option value=""><?echo $filter_data ?></option>
                <option value="<?= $admin_ind_page ?>?c=dashboard&v=index&filter_data=today#tbl_col">Today</option>
                <option value="<?= $admin_ind_page ?>?c=dashboard&v=index&filter_data=all#tbl_col">All</option>
                </select>
                    
                </div>
                <div class="select">
                <select name="car" id="car" onchange="redirectToSelect()">
              <option value="All"><?echo $status ?></option>
              <option value="<?= $admin_ind_page ?>?c=dashboard&v=index&filter_data=<?echo $filter_data ?>&status=All#tbl_col">All</option>
              <option value="<?= $admin_ind_page ?>?c=dashboard&v=index&filter_data=<?echo $filter_data ?>&status=Ready#tbl_col">Ready</option>
                 <option value="<?= $admin_ind_page ?>?c=dashboard&v=index&filter_data=<?echo $filter_data ?>&status=pause#tbl_col">pause</option>
                </select>
                    
                </div>
            </div>
            <div class="total-stats-table1 table-responsive">
                <table class="table" id="tbl_col">
                    <thead>
                        <tr>
                            <th scope="col">Agents</th>
                            <th scope="col">Status</th>
                            <th scope="col">Last call</th>
                            <th scope="col">Ready/Pause</th>
                            <!-- <th scope="col">Pause</th> -->
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
    const user = '<?= $adminuser ?>';
    const date = '<?= $date ?>';
    const filter_data = '<?= $admin_ind_page ?>';
    const status = '<?= $finalstatus ?>';

    console.log("User:", user);
    console.log("Date:", date);
    console.log("Filter Data:", filter_data);
    console.log("Status:", status);

    async function fetchData() {
        try {
            const response = await $.ajax({
                url: 'pages/dashboard/Summary_data.php',
                type: 'GET',
                dataType: 'json',
                data: {
                    status: status, 
                    date: date, 
                    Adminuser: user, 
                    all_data_check: filter_data 
                }
            });

            const tableBody = $('#table-body');
            tableBody.empty(); // Clear existing table data

            response.data.forEach(row => {
                let statusText;
                if (row.break_status === '2' && row.status === '2') {
                    statusText = '<span class="text-success">Ready</span>';
                } else if (row.break_status === '2' && row.status === '3') {
                    statusText = `<span class="text-success">Incall/${row.Calldirection}</span>`;
                } else if (row.break_status === '1' && row.status === '1') {
                    statusText = `<span class="text-warning">${row.break_name}</span>`;
                } else {
                    statusText = '<span class="text-danger">Logout</span>';
                }

                const newRow = `<tr>
                    <td title="UserId: ${row.user_name}">${row.user_name}</td>
                    <td>${statusText}</td>
                    <td>${row.wait_duration_seconds}</td>
                    <td>${row.ready_seconds}</td>
                    <td>${row.login_duration}</td>
                    <td title="Total Answer Call Duration: ${row.total_duration_A_call} Sec">${row.total_duration_A_call}</td>
                    <td>${row.total_ans_call_agent}</td>
                    <td>${row.total_can_call_agent}</td>
                    <td>${row.total_oth_call_agent}</td>
                    <td>${row.total_call_agent}</td>
                </tr>`;

                tableBody.append(newRow);
            });

            // Fetch data every 10 seconds
            setTimeout(fetchData, 100000);

        } catch (error) {
            console.log('Error fetching data', error);
        }
    }
    setInterval(function() {
        fetchData();
    }, 5000);
});
</script>


<script
  src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
  crossorigin="anonymous"></script>
<script>
   $(document).ready(function(){
    // For filter buttons
    $(".Total_call, .Other_call, .Answer_call, .Cancel_call, .out_boundcall, .Inbound_call, .No_answer").on("click", function() {
    var user = '<?= $adminuser ?>'; // Ensure this is correctly set in your PHP
    var filter_data = '<?= $all_data_check ?>'; // Ensure this is correctly set in your PHP
    
    // Array of filter classes
    var filterClasses = ['Total_call', 'Other_call', 'Answer_call', 'Cancel_call', 'out_boundcall', 'Inbound_call', 'No_answer'];
    
    // Find the correct class
    var f_data = filterClasses.find(function(className) {
        return $(this).hasClass(className);
    }.bind(this));
    
    if (f_data) {
        f_data = f_data.toLowerCase(); // Convert to lowercase if needed
        
        console.log("User:", user);
        console.log("Filter Data:", f_data);

        $.ajax({
            type: "POST",
            url: "pages/dashboard/filter_page.php",
            data: { 
                user: user, 
                data: f_data, 
                filter_data: filter_data 
            },
            success: function(response) {
                console.log("AJAX Response:", response);

                $("#content").html(response);
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
            }
        });
    } else {
        console.error("No matching filter class found.");
    }
});


    // For agent status buttons
    $(".idle_agents, .pause_agents, .login_agents").on("click", function(){
        var filter_data = '<?= $all_data_check ?>';
        
        // Array of status classes
        var statusClasses = ['idle_agents', 'pause_agents', 'login_agents'];
        
        // Find the correct class
        var status = statusClasses.find(function(className) {
            return $(this).hasClass(className);
        }.bind(this)).replace('_agents', '');

        // alert("Filter Data: " + status);

        var selectedValue = "index.php?c=dashboard&v=index&filter_data=" + filter_data + "&status=" + status + "#tbl_col";

        if (selectedValue !== "") {
            window.location.href = selectedValue;
        }
    });
});

$(document).ready(function() {
    $(".in_call_agents").on("click", function() {
        console.log('Opening popup for live'); // For debugging
        openPopup();

        var iframe = document.getElementById('livePopupIframe');
        
        if (iframe) {
            iframe.src = "/Telephony/admin/pages/dashboard/livecall.php";
            console.log('Iframe src set to: ' + iframe.src); // For debugging
        } else {
            console.error('Iframe with ID livePopupIframe not found');
        }
    });

    function openPopup() {
        var popup = document.getElementById('livePopupContainer');
        popup.style.display = 'block';

        // Add event listener to close the popup
        var closeBtn = document.getElementById('liveClosePopupButton');
        closeBtn.onclick = function() {
            popup.style.display = 'none';
        }

        // Make the popup draggable
        dragElement(popup);
        console.log('Popup opened'); // For debugging
    }

    function dragElement(element) {
        var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
        var header = document.getElementById(element.id + "Header");
        if (header) {
            header.onmousedown = dragMouseDown;
        } else {
            element.onmousedown = dragMouseDown;
        }

        function dragMouseDown(e) {
            e = e || window.event;
            e.preventDefault();
            pos3 = e.clientX;
            pos4 = e.clientY;
            document.onmouseup = closeDragElement;
            document.onmousemove = elementDrag;
        }

        function elementDrag(e) {
            e = e || window.event;
            e.preventDefault();
            pos1 = pos3 - e.clientX;
            pos2 = pos4 - e.clientY;
            pos3 = e.clientX;
            pos4 = e.clientY;
            element.style.top = (element.offsetTop - pos2) + "px";
            element.style.left = (element.offsetLeft - pos1) + "px";
        }

        function closeDragElement() {
            document.onmouseup = null;
            document.onmousemove = null;
        }
    }
});
$(document).ready(function() {
    $(".call_queue_agents").on("click", function() {
        console.log('Opening popup for live'); // For debugging
        openPopup();

        var iframe = document.getElementById('livePopupIframe');
        
        if (iframe) {
            iframe.src = "/Telephony/admin/pages/dashboard/livecall.php";
            console.log('Iframe src set to: ' + iframe.src); // For debugging
        } else {
            console.error('Iframe with ID livePopupIframe not found');
        }
    });

    function openPopup() {
        var popup = document.getElementById('livePopupContainer');
        popup.style.display = 'block';

        // Add event listener to close the popup
        var closeBtn = document.getElementById('liveClosePopupButton');
        closeBtn.onclick = function() {
            popup.style.display = 'none';
        }

        // Make the popup draggable
        dragElement(popup);
        console.log('Popup opened'); // For debugging
    }

    function dragElement(element) {
        var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
        var header = document.getElementById(element.id + "Header");
        if (header) {
            header.onmousedown = dragMouseDown;
        } else {
            element.onmousedown = dragMouseDown;
        }

        function dragMouseDown(e) {
            e = e || window.event;
            e.preventDefault();
            pos3 = e.clientX;
            pos4 = e.clientY;
            document.onmouseup = closeDragElement;
            document.onmousemove = elementDrag;
        }

        function elementDrag(e) {
            e = e || window.event;
            e.preventDefault();
            pos1 = pos3 - e.clientX;
            pos2 = pos4 - e.clientY;
            pos3 = e.clientX;
            pos4 = e.clientY;
            element.style.top = (element.offsetTop - pos2) + "px";
            element.style.left = (element.offsetLeft - pos1) + "px";
        }

        function closeDragElement() {
            document.onmouseup = null;
            document.onmousemove = null;
        }
    }
});


    
</script>

<script>
    function redirectToSelected() {
        var selectElement = document.getElementById("cars");
        var selectedValue = selectElement.options[selectElement.selectedIndex].value;
        if (selectedValue !== "") {
            window.location.href = selectedValue;
        }
        
    }
    function redirectToSelect() {
        var selectElement = document.getElementById("car");
        var selectedValue = selectElement.options[selectElement.selectedIndex].value;
        if (selectedValue !== "") {
            window.location.href = selectedValue;
        }

    }
</script>

<script>
    setInterval(loadPage, 500);

    function loadPage() {
        var list_id = $("#list_id").data("list_id");
        var filter_data = '<?= $_REQUEST['filter_data'] ?>';

        $.ajax({
            url: "pages/dashboard/dash_callcount.php?filter_data=<?= $filter_data ?>",
            data: { filter_data: filter_data }, // Or 'all', depending on the filter
            type: "POST",
            dataType: "json",
            success: function(res) {
                $("#total_call").text(res.total_call || '0');
                $("#answer_call").text(res.answer_call || '0');
                $("#cancel_call").text(res.cancel_call || '0');
                $("#congetion_call").text(res.congetion_call || '0');
                $("#outbond_call").text(res.outbond_call || '0');
                $("#Inbond_call").text(res.Inbond_call || '0');
                $("#noanswer").text(res.noanswer_call || '0');
            },
            error: function(xhr, status, error) {
            console.error("AJAX error: ", status, error);
            }
        });
    }
</script>
<script>
    setInterval(loadPage, 500);

    function loadPage() {
        var list_id = $("#list_id").data("list_id");
        var filter_data = '<?= $_REQUEST['filter_data'] ?>';

        $.ajax({
            url: "pages/dashboard/dash_live_agents.php?filter_data=<?= $filter_data ?>",
            data: { filter_data: filter_data }, // Or 'all', depending on the filter
            type: "POST",
            dataType: "json",
            success: function(res) {
                $("#login_agents").text(res.login_agents || '0');
                $("#idle_agents").text(res.idle_agents || '0');
                $("#pause_agents").text(res.pause_agents || '0');
                $("#in_call_agents").text(res.in_call_agents || '0');
                $("#call_queue_agents").text(res.call_queue_agents || '0');
            },
            error: function(xhr, status, error) {
                console.error("AJAX error: ", status, error);
            }
        });
    }
</script>
<script>
        let pieChart;

        document.addEventListener("DOMContentLoaded", () => {
            pieChart = new Chart(document.querySelector('#pieChart'), {
                type: 'pie',
                data: {
                    labels: ['Answer Call', 'Other Call', 'Cancel Call'],
                    datasets: [{
                        label: 'Call Status',
                        data: [0, 0, 0], // Initial dummy data
                        backgroundColor: ['#65fc8b', '#b878f0', '#fc8c3c'],
                        hoverOffset: 4
                    }]
                }
            });

            loadPage(); // Initial load
            setInterval(loadPage, 500); // Update every 500ms
        });

        function loadPage() {
            $.ajax({
                url: "pages/dashboard/dash_callcount.php",
                data: { filter_data: 'today' }, // Or 'all', depending on the filter
                type: "POST",
                dataType: "json",
                success: function(res) {
                    // Update chart data
                    pieChart.data.datasets[0].data = [
                        res.answer_call || 0,
                        res.congetion_call || 0,
                        res.cancel_call || 0

                    ];
                    pieChart.update();
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error: ", status, error);
                }
            });
        }
    </script>