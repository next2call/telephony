<?php
require '../conf/db.php';
require '../conf/url_page.php';
include "../conf/Get_time_zone.php";

session_start();
if (!$_SESSION['user_level'] == 1) {
    header('location: ../../Telephony/index.php');
}
$user = $_SESSION['user'] ?? '';
$npass = $_SESSION['pass'] ?? '';
$user_level = $_SESSION['user_level'] ?? '';
$newuser = '';
$newpass = '';
if (empty($user) || !isset($user)) {
    header('location: ../../Telephony/index.php');
    exit;
}

$agentuser = $_SESSION['user'] ?? '';

$campaign_id = $_SESSION['campaign_id'];

$sql_n = "Select * from users where user_id ='$agentuser' ";
$result_n = mysqli_query($con, $sql_n);
$users_row = mysqli_fetch_assoc($result_n);
$Admin_user = $users_row['admin'];
$ext_number = $users_row['ext_number'];
// die();

$sql_list = "Select * from lists where CAMPAIGN ='$campaign_id' ";
$result_list = mysqli_query($con, $sql_list);
$list_row = mysqli_fetch_assoc($result_list);
$ins_list_id = $list_row['LIST_ID'];



// ======================index mateal==============================

require '../include/user.php';
require '../include/function.php';
require '../include/sql_query.php';
// $user = new user();
$Current_user = sql_execute($Current_user);
$campaigns_count = sql_count($count_campaigns);
$count_agent = sql_count($sql_agents);
$count_agent_call_Today = sql_count($sql_agents_call_today);
$Count_user = sql_count($users);
$Count_user_active = sql_count($user_active);
$Count_user_inactive = sql_count($user_inactive);
$count_campaigns = sql_count($count_campaigns);
$count_campaigns_active = sql_count($count_campaigns_active);
$count_campaigns_inactive = sql_count($count_campaigns_inactive);
$count_lists = sql_count($count_lists);
$count_lists_active = sql_count($count_lists_active);
$count_lists_inactive = sql_count($count_lists_inactive);
$count_dids = sql_count($count_dids);
$count_dids_active = sql_count($count_dids_active);
$count_dids_inactive = sql_count($count_dids_inactive);
$query_active_call = sql_count($query_active_call);
$query_calling = sql_count($query_calling);
$date = Date("Y-m-d");
// echo $ip=$_SERVER['REMOTE_ADDR'];
// continent, etc using IP Address  
$ip = '119.82.85.212';

// Use JSON encoded string and converts 
// it into a PHP variable 
$ipdat = @json_decode(file_get_contents(
    "http://www.geoplugin.net/json.gp?ip=" . $ip
));

$Country = $ipdat->geoplugin_countryName . "\n";
$City = $ipdat->geoplugin_city . "\n";
// echo 'Continent Name: ' . $ipdat->geoplugin_continentName . "\n"; 
// echo 'Latitude: ' . $ipdat->geoplugin_latitude . "\n"; 
// echo 'Longitude: ' . $ipdat->geoplugin_longitude . "\n"; 
// echo 'Currency Symbol: ' . $ipdat->geoplugin_currencySymbol . "\n"; 
// echo 'Currency Code: ' . $ipdat->geoplugin_currencyCode . "\n"; 
// echo 'Timezone: ' . $ipdat->geoplugin_timezone; 

// ======================index mateal==============================

$adminuser = $_SESSION['user'];
//========================count calling===================
$sel1 = "select * from cdr Where call_from='$adminuser'";
$qur_nogente = mysqli_query($con, $sel1);
$total_call = mysqli_num_rows($qur_nogente);

$sel2 = "select * from cdr WHERE status='ANSWER' AND call_from='$adminuser'";
$qur_nogente2 = mysqli_query($con, $sel2);
$answer_call = mysqli_num_rows($qur_nogente2);

$sel3 = "select * from cdr WHERE status='CANCEL'  AND call_from='$adminuser'";
$qur_nogente3 = mysqli_query($con, $sel3);
$cancel_call = mysqli_num_rows($qur_nogente3);

$sel4 = "select * from cdr WHERE status!='ANSWER' AND status!='CANCEL' AND call_from='$adminuser'";
$qur_nogente4 = mysqli_query($con, $sel4);
$congetion_call = mysqli_num_rows($qur_nogente4);

// $sel4 = "select * from cdr WHERE status!='ANSWER' AND status!='CANCEL'";
// $qur_nogente4 = mysqli_query($con, $sel4);
// $congetion_call = mysqli_num_rows($qur_nogente4);
//========================count calling===================

//==================== new code start 
if (isset($_POST["import"])) {
    $fileName = $_FILES["excel"]["name"];
    $fileExtension = explode('.', $fileName);
    $fileExtension = strtolower(end($fileExtension));
    $newFileName = date("Y.m.d") . " - " . date("h.i.sa") . "." . $fileExtension;
    $ins_date = date("d-m-Y");
    $targetDirectory = "uploads/" . $newFileName;
    move_uploaded_file($_FILES['excel']['tmp_name'], $targetDirectory);

    error_reporting(0);
    ini_set('display_errors', 0);

    require 'excelReader/excel_reader2.php';
    require 'excelReader/SpreadsheetReader.php';

    $reader = new SpreadsheetReader($targetDirectory);
    foreach ($reader as $key => $row) {
        $company_name = $row[0];
        $employee_size = $row[1];
        $industry = $row[2];
        $country = $row[3];
        $city = $row[4];
        $department = $row[5];
        $designation = $row[6];
        $email = $row[7];
        $name = $row[8];
        $phone_number = $row[9];
        $phone2 = $row[10];
        $phone3 = $row[11];
        $phone_code = '0';


        if (!empty($company_name) && !empty($phone_number) && $company_name != 'company_name') {

            $tfnsnjkj = "SELECT * FROM upload_data WHERE phone_number='$phone_number' AND dial_status='NEW'";
            $njnkkmkj = mysqli_query($con, $tfnsnjkj);

            if (mysqli_num_rows($njnkkmkj) == 0) {

                $insert = "INSERT INTO `upload_data`(`company_name`, `employee_size`, `industry`, `country`, `city`, `department`, `designation`, `email`, `name`, `phone_number`, `phone_2`, `phone_3`, `phone_code`, `username`, `admin`, `ins_date`, `dial_status`, `list_id`, `campaign_Id`) VALUES ('$company_name', '$employee_size', '$industry', '$country', '$city', '$department', '$designation', '$email', '$name', '$phone_number', '$phone2', '$phone3', '$phone_code', '$adminuser', '$Admin_user', '$ins_date', 'NEW', '$ins_list_id', '$campaign_id')";

                $queryy = mysqli_query($con, $insert);
            }
        }                 //========================check soource code for already insert
    }     //========================for each loop code cond

    if ($queryy) {
        echo '
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
    
    <script>
    window.onload = function() {
      Swal.fire({
        title: "Success",
        text: "Your file has been uploaded successfully.",
        icon: "success",
        confirmButtonText: "OK"
      });
    }
    </script>';
        // echo "<script>alert('Okay, your file has been uploaded successfully.')</script>";
    } else {

        echo '
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
    
    <script>
    // var username = document.getElementById("floatingInput1").value;
    window.onload = function() {
      Swal.fire({
        title: "Failed",
        text: "Your is not Uploaded !",
        icon: "error",
        confirmButtonText: "OK"
      });
    }
    </script>';
    }




    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Process the form data

        // Reset or clear the input values after processing
        $fileName = '';
        // $email = '';
    } else {
        // Set default values for the form
        $fileName = '';
        // $email = '';
    }

}         //========================submit code




?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="https://next2call.com/assets/img/logo/logo5.png">
    <title>Next2call Dialer</title>

    <!-- All the css files here -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/datatables.min.css" />
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css" />
    <link rel="stylesheet" href="../assets/css/style.css" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
    <style>
        .cursor_p {
            cursor: pointer;
        }

        .total-stats-table {
            height: 350px;
            overflow: auto;
        }

        /* Hide scrollbar for Webkit-based browsers (Chrome, Safari) */
        .total-stats-table::-webkit-scrollbar {
            width: 0.5em;
        }

        .total-stats-table::-webkit-scrollbar-thumb {
            background-color: transparent;
            /* or add your own color */
        }

        .text_color {
            color: #1e90ff !important;
        }

        .text_color:hover {
            color: black !important;
        }
    </style>
    <style>
        .sidebar {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #111;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }

        .sidebar a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 18px;
            color: #818181;
            display: block;
            transition: 0.3s;
        }

        .sidebar a:hover {
            color: #f1f1f1;
        }

        .sidebar .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
            color: #007bff;
        }

        .openbtn {
            font-size: 20px;
            cursor: pointer;
            background-color: #111;
            color: white;
            padding: 10px 15px;
            border: none;
        }

        .autodial {
            /* cursor: pointer; */
            background: #dfcbea;
            font-weight: bold;
            color: #284f99;
            padding: 8px;
            border: 8px;
            border-radius: 5px;
        }

        .openbtn:hover {
            background-color: #444;
        }

        #main {
            transition: margin-left .5s;
            padding: 16px;
        }

        /* On smaller screens, where height is less than 450px, change the style of the sidenav (less padding and a smaller font size) */
        @media screen and (max-height: 450px) {
            .sidebar {
                padding-top: 15px;
            }

            .sidebar a {
                font-size: 18px;
            }
        }

        .call_text {
            font-size: 15px !important;
            color: #7f7f7f;
        }

        #trid td {
            padding: 5px;
        }

        .align-left {
            float: left;
            margin-right: 45rem;
            position: absolute;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            background-color: #fff;
            min-width: 160px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            z-index: 1;
            margin-top: -50px !important;
            margin-left: 170px;
        }

        .dropdown-menu.show {
            display: block;
        }
    </style>
</head>





<body>

    <div class="next2call-dashboard">
        <div class="row">
            <section class="next2call-sidebar col-2">
                <div class="sidebar-lg">
                    <img src="../assets/images/dashboard/next2calld.png" alt="" />
                    <h2>Agent</h2>

                    <a href="#" onclick="loadPage('pages/dashboard/index.php')" class="cursor_p  text_color"><i
                            class="fa fa-th-large" aria-hidden="true"></i> Overview</a>
                    <?php if ($Admin_user != '45010') { ?>
                        <!-- <a href="#" onclick="loadPage('pages/user/user_list.php')" class="cursor_p text_color"><i
                                class="fa fa-user-circle-o" aria-hidden="true"></i>Profile</a> -->

                                <a href="#" onclick="loadPage('pages/user/user_profile.php')" class=" cursor_p text_color"><i
                                class="fa fa-user-circle-o" aria-hidden="true"></i>Profile</a>
                    <?php } ?>
                    <a href="#" onclick="loadPage('pages/dashboard/data_upload.php')" class="cursor_p text_color"><i
                            class="fa fa-upload" aria-hidden="true"></i>Data Upload</a>

                    <a href="#" onclick="loadPage('pages/dashboard/report.php')" class=" cursor_p text_color"><i
                            class="fa fa-database" aria-hidden="true"></i> Call Report</a>

                    <a href="#" onclick="loadPage('pages/lists/lists_list.php')" class=" cursor_p text_color"><i
                            class="fa fa-id-card-o" aria-hidden="true"></i>Lead Report</a>
                    <!-- <a href="#" onclick="loadPage('pages/user/agent_list.php')" class=" cursor_p text_color"><i class="fa fa-users cursor_p" aria-hidden="true"></i>Agent Status</a> -->
                    <a href="#" onclick="loadPage('pages/dashboard/block_no.php')" class=" cursor_p text_color"><i
                            class="fa fa-ban" aria-hidden="true"></i> Block Number</a>


            </section>
            <div class="col-12 col-lg-12 col-xl-10">
                <div id="mySidebar" class="sidebar sidebar-lg">
                    <a href="javascript:void(0)" class="closebtn" onclick="toggleNav()">×</a>

                    <img src="../assets/images/dashboard/next2calld.png" alt="" />
                    <h2>Agent</h2>

                    <a href="#" onclick="loadPage('pages/dashboard/index.php')" class="cursor_p  text_color"><i
                            class="fa fa-th-large" aria-hidden="true"></i> Overview</a>
                    <!-- <a href="#" onclick="loadPage('pages/user/user_list.php')" class=" cursor_p text_color"><i
                            class="fa fa-user-circle-o" aria-hidden="true"></i>Profile</a> -->

                    <a href="#" onclick="loadPage('pages/user/user_profile.php')" class=" cursor_p text_color"><i
                            class="fa fa-user-circle-o" aria-hidden="true"></i>Profile</a>

                    <a href="javascript:void(0)" class="closebtn" onclick="toggleNav()">×</a>
                    <a href="#" onclick="loadPage('pages/dashboard/data_upload.php')" class="cursor_p text_color"><i
                            class="fa fa-upload" aria-hidden="true"></i>Data Upload</a>

                    <a href="#" onclick="loadPage('pages/dashboard/report.php')" class=" cursor_p text_color"><i
                            class="fa fa-bar-chart" aria-hidden="true"></i> Call Report</a>
                    <a href="#" onclick="loadPage('pages/list/list_lists.php')" class=" cursor_p text_color"><i
                            class="fa fa-id-card-o" aria-hidden="true"></i>Lead Report</a>
                    <!-- <a href="#" onclick="loadPage('pages/user/agent_list.php')" class="cursor_p text_color"><i class="fa fa-users cursor_p" aria-hidden="true"></i>Agent Status</a> -->
                    <a href="#" onclick="loadPage('pages/dashboard/block_no.php')" class="cursor_p text_color"><i
                            class="fa fa-ban" aria-hidden="true"></i> Block Number</a>
                    </section>

                </div>
                <section class="top-bar">

                    <div id="main">
                        <button class="openbtn" onclick="toggleNav()">☰</button>


                    </div>
                    <!-- Button for auto dial -->
                    <button class="autodial" id="autoDialBtn">Auto Dial (OFF)</button>&nbsp;&nbsp;



                    <script>
                        // JavaScript to handle the toggle button and initiate phone call
                        const autoDialBtn = document.getElementById("autoDialBtn");
                        let autoDialOn = false;
                        let intervalId = null; // To store the interval ID

                        autoDialBtn.addEventListener("click", function () {
                            autoDialOn = !autoDialOn; // Toggle auto dial state

                            if (autoDialOn) {
                                autoDialBtn.textContent = "Auto Dial (ON)";
                                console.log("autodial");
                                // Start the dialing process
                                intervalId = setInterval(dialBtn, 10000);
                            } else {
                                autoDialBtn.textContent = "Auto Dial (OFF)";
                                // Stop the dialing process
                                clearInterval(intervalId);
                            }
                        });

                        function dialBtn() {
                            console.log("Initiating phone call...");
                            var live = "live";

                            $.ajax({
                                url: "autodial.php",
                                data: {
                                    live: live
                                },
                                type: "POST",
                                dataType: "json",
                                success: function (res) {
                                    if (res && res.length > 0) {
                                        for (var i = 0; i < res.length; i++) {
                                            var name = res[i].name;
                                            var number = res[i].number;
                                            console.log("Name: " + name + ", Number: " + number);

                                            // Open the popup for each number
                                            openPopup();

                                            // Pass the phone number to the iframe
                                            var iframe = document.getElementById('popupIframe');
                                            iframe.src =
                                                "<?= $click_2_call ?>?d=" + number;
                                        }
                                    } else {
                                        console.log("No data received from the server.");
                                    }
                                },
                                error: function (xhr, status, error) {
                                    console.error("Error occurred while making AJAX request:", error);
                                }
                            });
                        }

                        // Call dialBtn function initially and then every 2 minutes
                    </script>

                    <!-- himanshu webphone code -->

                    <!-- The button to open the popup -->
                    <!-- <button class="btn btn-info" id="openform">Form</button> -->
                    <!-- <button class="btn btn-info" onclick="show_E_Form()">Open Form</button> -->
                    <!-- <button onclick="show_E_Form()">Click Me</button> -->



                    <button class="btn btn-primary" id="openPopupButton">Phone</button>&nbsp;&nbsp;

                    <!-- The container for the popup -->
                    <div id="popupContainer"
                        style="display: none; position: fixed; top: 50%; right: 0; transform: translate(0, -50%); background-color: white; padding: 20px; border: 1px solid #ccc; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); z-index: 9999; cursor: move; width: 360px; height: 500px;">
                        <!-- Content of the popup -->
                        <iframe id="popupIframe" src="<?= $phone_url87 ?>"
                            style="width: 100%; height: 100%; border: none;"></iframe>
                        <!-- Close button for the popup -->
                        <button style="display: none;" id="closePopupButton">Close</button>
                    </div>

                    <script>
                        // Function to open the popup
                        function openPopup() {
                            document.getElementById('popupContainer').style.display = 'block';
                        }

                        // Function to close the popup
                        function closePopup() {
                            document.getElementById('popupContainer').style.display = 'none';
                        }

                        // Event listener to toggle the popup when the button is clicked
                        document.getElementById('openPopupButton').addEventListener('click', function (event) {
                            var popupContainer = document.getElementById('popupContainer');
                            if (popupContainer.style.display === 'none' || popupContainer.style.display === '') {
                                openPopup();
                            } else {
                                closePopup();
                            }
                            event.preventDefault();
                        });

                        // Event listener to close the popup when the close button is clicked
                        document.getElementById('closePopupButton').addEventListener('click', function (event) {
                            closePopup();
                            event.preventDefault();
                        });

                        // Make the popup draggable
                        dragElement(document.getElementById('popupContainer'));

                        function dragElement(element) {
                            var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
                            if (document.getElementById(element.id)) {
                                document.getElementById(element.id).onmousedown = dragMouseDown;
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
                    </script>

                    <!-- himanshu webphone code -->

                    <div class="dropdown">
                        <button
                            class="btn btn-md mr-2 ready <?php echo $break_p_status == '1' ? 'btn-danger' : 'btn-success'; ?> dropdown-toggle"
                            type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            onclick="toggleDropdown()">

                        </button>
                        <div class="dropdown-menu" aria-labelledby="select-btn" id="dropdownMenu">
                            <a href="#" onclick="callPageAndCloseDropdown('takebreake.php?break_type=Ready', 'Ready');"
                                class="dropdown-item select-btn text-danger" data-method='campaign'>Ready</a>
                            <a href="#"
                                onclick="callPageAndCloseDropdown('takebreake.php?break_type=Lunch Break', 'Lunch Break');"
                                class="dropdown-item select-btn break" data-method='campaign'>Lunch Break</a>
                            <a href="#"
                                onclick="callPageAndCloseDropdown('takebreake.php?break_type=Bio Break', 'Bio Break');"
                                class="dropdown-item select-btn break" data-method='assign'>Bio Break</a>
                            <a href="#"
                                onclick="callPageAndCloseDropdown('takebreake.php?break_type=Meeting Break', 'Meeting Break');"
                                class="dropdown-item select-btn break" data-method='download'>Meeting Break</a>
                            <a href="#"
                                onclick="callPageAndCloseDropdown('takebreake.php?break_type=Other Break', 'Other Break');"
                                class="dropdown-item select-btn break" data-method='download'>Other Break</a>
                            <?php if (!empty($ext_number)) { ?>
                                <a href="#"
                                    onclick="callPageAndCloseDropdown('takebreake.php?break_type=mobile', 'mobile');"
                                    class="dropdown-item select-btn break"
                                    title="When agent takes your call on mobile, click here" data-method='download'>Take
                                    call Mobile</a>
                            <?php } ?>
                        </div>
                    </div>

                    <script>
                        // Function to update the button text
                        function updateButtonColor(text) {
                            var button = document.querySelector('.ready');
                            var dropdownItems = document.querySelectorAll('.dropdown-item');

                            // Reset all buttons to red color
                            dropdownItems.forEach(function (item) {
                                item.classList.remove('btn-success');
                                item.classList.add('btn-danger');
                            });

                            // Set Ready button to green color
                            if (text === 'Ready') {
                                button.classList.remove('btn-danger');
                                button.classList.add('btn-success');
                            } else {
                                button.classList.remove('btn-success');
                                button.classList.add('btn-danger');
                            }

                            button.innerText = text;

                            var message = text === 'Ready' ? 'false' : 'true'; // Adjusted message based on text
                            openPopup();

                            // Pass the message to the iframe
                            var iframe = document.getElementById('popupIframe');
                            iframe.src = "<?= $phone_url87 ?>?DND=" + message;
                            console.log('Iframe src set to: ' + iframe.src); // For debugging
                        }

                        // Call updateButtonColor function with default text 'Ready' when the page loads
                        updateButtonColor('Ready');
                    </script>




                    <!-- Will be needed later -->
                    <!-- <a href="#" style="display: none;">
            <i class="fa fa-bell" aria-hidden="true"></i>
          </a>
          <span"></span> -->
                    <!-- Will be needed later -->


                    <a href="logout.php" data-toggle="tooltip" data-placement="bottom" title="Log Out">
                        <!-- <a href="logout_coppy.php" data-toggle="tooltip" data-placement="bottom" title="Log Out"> -->
                        <img src="../assets/images/dashboard/logout.png" alt="" />
                    </a>
                </section>
                <div id="content">
                    <!-- Content from page.php will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleNav() {
            var sidebar = document.getElementById("mySidebar");
            var mainContent = document.getElementById("main");
            var openBtn = document.getElementsByClassName("openbtn")[0];

            if (sidebar.style.width === "300px") {
                sidebar.style.width = "0";
                mainContent.style.marginLeft = "0";
                openBtn.style.display = "block";
            } else {
                sidebar.style.width = "300px";
                mainContent.style.marginLeft = "300px";
                openBtn.style.display = "none";
            }
        }
        if (window.addEventListener) {
            window.addEventListener("message", receive, false);
        } else {
            if (window.attachEvent) {
                window.attachEvent("onmessage", receive, false);
            }
        }

        function receive(event) {
            var data = event.data;
            if (typeof (window[data.func]) == "function") {
                window[data.func].call(null, data.params[0]);
            }
        }

        function alertMyMessage(msg) {

            alert(msg);
        }
    </script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>
    <script>
        function loadPage(page) {
            var user = '<?= $adminuser ?>';
            // alert(user);
            $.ajax({
                url: page,
                type: 'POST',
                dataType: 'html',
                data: {
                    user: user
                }, // Add a comma here
                success: function (data) {
                    $('#content').html(data);
                    // Store the current page in localStorage
                    localStorage.setItem('currentPage', page);
                },
                error: function (xhr, status, error) {
                    console.error('Error loading page:', error);
                    console.log('XHR:', xhr);
                }
            });
        }

        // =================================
        function callPage(page) {
            var user = '<?= $adminuser ?>';
            // alert(user);
            $.ajax({
                url: page,
                type: 'GET', // Changed to GET method
                dataType: 'html',
                data: {
                    user: user
                },
                success: function (data) {
                    // Do nothing with the response
                    // alert('ok');
                },
                error: function (xhr, status, error) {
                    console.error('Error loading page:', error);
                    console.log('XHR:', xhr);
                }
            });
        }
        // =================================

        // Check if there is a stored current page; otherwise, load the default page
        $(document).ready(function () {
            var currentPage = localStorage.getItem('currentPage');
            if (currentPage) {
                loadPage(currentPage);
            } else {
                // Set the default page to load initially
                var defaultPage = 'pages/dashboard/index.php'; // Change this to your default page
                loadPage(defaultPage);
            }
        });
    </script>
    <script>

    </script>


    <script>
        $(document).on("click", ".clicktocall", function () {

            var callernumber = $(this).data("callernumber");
            if (callernumber) {
                callernumber = String(callernumber);
                if (/^(91|091)/.test(callernumber)) {
                    callernumber = callernumber.replace(/^(91|091)/, "0");
                }
            } else {
                console.error("Error: callernumber is undefined or null");
                return;
            }
            var fornumber = $(this).data("idf");
            var prinumber = $(this).data("prinumber");
            var adminNo = "<?php echo $adminNu; ?>";
            var user = "<?php echo $user2; ?>";

            // himanshu webphone
            // Open the popup
            openPopup();

            // Pass the phone number to the iframe
            var iframe = document.getElementById('popupIframe');
            iframe.src = "/Telephony/webphone/Phone/click-to-dial.php?d=" + callernumber + '&user=' + user;
            // himanshu webphone

        });
    </script>

    <script>
        //           function toggleDropdown() {
        //     var dropdownMenu = document.getElementById("dropdownMenu");
        //     dropdownMenu.classList.toggle("show");
        // }
        function toggleDropdown() {
            var dropdownMenu = document.getElementById("dropdownMenu");
            dropdownMenu.classList.toggle("show");
        }

        // Function to close dropdown when clicking outside of it
        document.addEventListener("click", function (event) {
            var dropdownMenu = document.getElementById("dropdownMenu");
            var dropdownToggle = document.querySelector(".dropdown-toggle");
            var takeBreakOption = document.querySelector(".dropdown-item[data-method='campaign']");

            // Close dropdown if clicked outside of dropdown menu or its toggle button
            if (!dropdownMenu.contains(event.target) && !dropdownToggle.contains(event.target) && event.target !==
                takeBreakOption) {
                dropdownMenu.classList.remove("show");
            }
        });
    </script>

    <script>
        function toggleDropdown() {
            var dropdownMenu = document.getElementById("dropdownMenu");
            dropdownMenu.classList.toggle("show");
        }

        function callPageAndCloseDropdown(url, buttonText) {
            callPage(url);
            updateButtonColor(buttonText); // Assuming you have a function to update button color
            toggleDropdown(); // Close the dropdown menu
        }
    </script>
    <script>
        function saveData() {
            event.preventDefault();

            var formData = new FormData(document.getElementById('myForm_insert_data'));
            var close_id = document.getElementById('close_id'); // Assuming 'close_id' exists in your HTML

    // alert(close_id);
            $.ajax({
                type: 'POST',
                url: "pages/user/user_update.php", // Replace with the actual server-side file to handle data insertion
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    // alert(response);
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Your data has been saved",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        $('#content').html(response);
                        var page = localStorage.getItem('currentPage');
                        loadPage(page);
                            close_id.click(); // Trigger click event if element exists
                    });
                },
            });
        }
    </script>
    <script>
        function block_num() {
            event.preventDefault();

            var formData = new FormData(document.getElementById('myForm_data_block'));
            var block_m_close = document.getElementById('block_m_close'); // Assuming 'close_id' exists in your HTML


            $.ajax({
                type: 'POST',
                url: "pages/dashboard/blocked_num.php", // Replace with the actual server-side file to handle data insertion
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    // alert(response);
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Your Number has been Blocked",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
            // Replace content with response HTML
            $('#content').html(response);

            // Retrieve and load the current page from localStorage
            const page = localStorage.getItem('currentPage');
            if (page) {
                loadPage(page);
            }


            // Trigger a click event on the element with ID "close_id"
            const closeButton = $('#close_id');
            if (closeButton.length) {
                closeButton.click();
            } else {
                console.warn("Element with ID 'close_id' not found.");
            }
        });
                    // .than{(
                    // redirect: 
                    // )};
                },
            });
        }
    </script>
    <script>
    function checkSession() {
        fetch('session_check.php')
            .then(response => response.json())
            .then(data => {
                if (data.status === 'inactive') {
                    // Redirect to the login page if the session is inactive
                    // header('location: ../../Telephony/index.php');
                    // exit;
                    window.location.href = '../../Telephony/index.php';
                }
            })
            .catch(error => console.error('Error checking session:', error));
    }

    // Check the session every 5 seconds (5000 milliseconds)
    setInterval(checkSession, 5000);



</script>

</body>

</html>