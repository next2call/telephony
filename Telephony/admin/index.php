<?php
require '../conf/db.php';
require '../conf/url_page.php';
require '../conf/Get_time_zone.php';
require '../include/campaign.php';


session_start();
if (!$_SESSION['user_level'] == 8) {
    header('location:../');
}
$user_level = $_SESSION['user_level'];
$sql = "Select * from vicidial_users where user_id =" . $_SESSION['user_id'];
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

$user2 = $_SESSION['user'];

$pdate = date('Y-m-d');

$sql = "UPDATE `login_log` SET status = '2' WHERE status = '1' AND log_in_time NOT LIKE '%$pdate%'";
$result = mysqli_query($con, $sql);


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="https://next2call.com/assets/img/logo/logo5.png">
    <title>Next2call Dialer</title>


    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/datatables.min.css" />
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css" />
    <link rel="stylesheet" href="../assets/css/style.css" />
    <script src="../ckeditor/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
    <style>
        .cursor_p {
            cursor: pointer;
        }

        .text_color {
            color: #1e90ff !important;
        }

        .text_color:hover {
            color: black !important;
        }

        .total-stats-table1 {
            height: 850px;
            overflow: auto;
        }

        /* Hide scrollbar for Webkit-based browsers (Chrome, Safari) */
        .total-stats-table1::-webkit-scrollbar {
            width: 0.5em;
        }

        .total-stats-table1::-webkit-scrollbar-thumb {
            background-color: transparent;
            /* or add your own color */
        }
    </style>
    <style>
        .timeui {
            font-size: 25px;
            font-weight: bold;
            color: #333;
        }

        #clock {
            font-size: 25px;
            font-weight: bold;
            color: #007BFF;
        }

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
            font-size: 36px !important;
            margin-left: 50px !important;
            color: #007bff !important;
        }

        .openbtn {
            font-size: 20px;
            cursor: pointer;
            background-color: #111;
            color: white;
            padding: 10px 15px;
            border: none;
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

        .livecall {
            /* cursor: pointer; */
            background: #dfcbea;
            font-weight: bold;
            color: #284f99;
            padding: 8px;
            border: 8px;
            border-radius: 5px;
            cursor: pointer;
        }

        /* .main_img{ */
        /* hieght: 400px !important; */
        /* width: 50px; */
        /* } */
        /* live call popup scc */
    </style>
</head>


<body>
    <div class="next2call-dashboard">
        <div class="row">
            <section class="next2call-sidebar-mbl">
                <div id="mySidebar" class="sidebar">
                    <div class="dashboard-sidedrawer">
                        <img src="../assets/images/dashboard/next2calld.png" alt="" />
                        <h2>
                        <?php 
            $user_roles = [
                9 => 'Super Admin',
                8 => 'Admin',
                7 => 'Manager',
                6 => 'Quality Analyst',
                2 => 'Team Leader',
                3 => 'IT User',
            ];
            echo $user_roles[$user_level] ?? 'Super Admin'; 
            ?>
        </h2>
        
        <?php if (in_array($user_level, [9, 8, 7, 6, 2])): ?>
            <a href="?c=dashboard&v=index" class="text_color">
                <i class="fa fa-th-large cursor_p" aria-hidden="true"></i> Overview
            </a>
            <a href="?c=user&v=user_profile" class="text_color">
                <i class="fa fa-user-circle-o cursor_p" aria-hidden="true"></i> Profile
            </a>
        <?php endif; ?>

        <?php if (in_array($user_level, [9, 8, 7])): ?>
            <a href="?c=user&v=user_list" class="text_color">
                <i class="fa fa-user-plus cursor_p" aria-hidden="true"></i> Users
            </a>
            <a href="?c=campaign&v=campaign_list" class="text_color">
                <i class="fa fa-list" aria-hidden="true"></i> Campaigns
            </a>
            <a href="?c=user_group&v=show_user_group" class="text_color">
                <i class="fa fa-users cursor_p" aria-hidden="true"></i> Extensions
            </a>
            <a href="?c=user_group&v=show_user_menu_group" class="text_color">
                <i class="fa fa-music cursor_p" aria-hidden="true"></i> Menu IVR
            </a>
            <a href="?c=lists&v=lists_list" class="text_color">
                <i class="fa fa-upload" aria-hidden="true"></i> Data Upload
            </a>
            <a href="?c=dashboard&v=report" class="text_color">
                <i class="fa fa-database" aria-hidden="true"></i> Call Reports
            </a>
            <a href="?c=dashboard&v=lead_report" class="text_color">
                <i class="fa fa-id-card-o cursor_p" aria-hidden="true"></i> Lead Reports
            </a>
            <a href="?c=dashboard&v=block_no" class="text_color">
                <i class="fa fa-ban" aria-hidden="true"></i> Block Number
            </a>
            <a href="?c=dashboard&v=disposition" class="text_color">
                <i class="fa fa-plus-square" aria-hidden="true"></i> Dispositions
            </a>
            <a href="?c=dashboard&v=ivr_converter" class="text_color">
                <i class="fa fa-volume-control-phone" aria-hidden="true"></i> IVR Converter
            </a>
        <?php elseif ($user_level == 2): ?>
            <a href="?c=user&v=user_list" class="text_color">
                <i class="fa fa-user-plus cursor_p" aria-hidden="true"></i> Users
            </a>
            <a href="?c=lists&v=lists_list" class="text_color">
                <i class="fa fa-upload" aria-hidden="true"></i> Data Upload
            </a>
            <a href="?c=dashboard&v=report" class="text_color">
                <i class="fa fa-database" aria-hidden="true"></i> Call Reports
            </a>
            <a href="?c=dashboard&v=lead_report" class="text_color">
                <i class="fa fa-id-card-o cursor_p" aria-hidden="true"></i> Lead Reports
            </a>
            <a href="?c=dashboard&v=block_no" class="text_color">
                <i class="fa fa-ban" aria-hidden="true"></i> Block Number
            </a>
            <a href="?c=dashboard&v=disposition" class="text_color">
                <i class="fa fa-plus-square" aria-hidden="true"></i> Dispositions
            </a>
        <?php elseif ($user_level == 6): ?>
            <a href="?c=dashboard&v=report" class="text_color">
                <i class="fa fa-database" aria-hidden="true"></i> Call Reports
            </a>
            <a href="?c=dashboard&v=lead_report" class="text_color">
                <i class="fa fa-id-card-o cursor_p" aria-hidden="true"></i> Lead Reports
            </a>
        <?php endif; ?>

                    </div>
            </section>
            <section class="next2call-sidebar col-2">
                <div class="sidebar-lg">

                    <img src="../assets/images/dashboard/next2calld.png" alt="" />
                    <h2>
                        <?php 
            $user_roles = [
                9 => 'Super Admin',
                8 => 'Admin',
                7 => 'Manager',
                6 => 'Quality Analyst',
                2 => 'Team Leader',
                3 => 'IT User',
            ];
            echo $user_roles[$user_level] ?? 'Super Admin'; 
            ?>
        </h2>
        
        <?php if (in_array($user_level, [9, 8, 7, 6, 2])): ?>
            <a href="?c=dashboard&v=index" class="text_color">
                <i class="fa fa-th-large cursor_p" aria-hidden="true"></i> Overview
            </a>
            <a href="?c=user&v=user_profile" class="text_color">
                <i class="fa fa-user-circle-o cursor_p" aria-hidden="true"></i> Profile
            </a>
        <?php endif; ?>

        <?php if (in_array($user_level, [9, 8, 7])): ?>
            <?php if (in_array($user_level, [9])): ?>
                <a href="?c=user&v=telephony_user" class="text_color">
                <i class="fa fa-user-plus cursor_p" aria-hidden="true"></i> Admin User
            </a>
                <a href="?c=email&v=send_email" class="text_color">
                <i class="fa fa-envelope cursor_p" aria-hidden="true"></i> Email Section
            </a>
            <?php endif; ?>
            <a href="?c=user&v=user_list" class="text_color">
                <i class="fa fa-user-plus cursor_p" aria-hidden="true"></i> Users
            </a>

            <a href="?c=campaign&v=campaign_list" class="text_color">
                <i class="fa fa-list" aria-hidden="true"></i> Campaigns
            </a>
            <a href="?c=user_group&v=show_user_group" class="text_color">
                <i class="fa fa-users cursor_p" aria-hidden="true"></i> Extensions
            </a>
            <a href="?c=user_group&v=show_user_menu_group" class="text_color">
                <i class="fa fa-music cursor_p" aria-hidden="true"></i> Menu IVR
            </a>
            <a href="?c=lists&v=lists_list" class="text_color">
                <i class="fa fa-upload" aria-hidden="true"></i> Data Upload
            </a>
            <a href="?c=dashboard&v=report" class="text_color">
                <i class="fa fa-database" aria-hidden="true"></i> Call Reports
            </a>
            <a href="?c=dashboard&v=lead_report" class="text_color">
                <i class="fa fa-id-card-o cursor_p" aria-hidden="true"></i> Lead Reports
            </a>
            <a href="?c=dashboard&v=block_no" class="text_color">
                <i class="fa fa-ban" aria-hidden="true"></i> Block Number
            </a>
            <a href="?c=dashboard&v=disposition" class="text_color">
                <i class="fa fa-plus-square" aria-hidden="true"></i> Dispositions
            </a>
            <a href="?c=dashboard&v=ivr_converter" class="text_color">
                <i class="fa fa-volume-control-phone" aria-hidden="true"></i> IVR Converter
            </a>
        <?php elseif ($user_level == 2): ?>
            <a href="?c=user&v=user_list" class="text_color">
                <i class="fa fa-user-plus cursor_p" aria-hidden="true"></i> Users
            </a>
            <a href="?c=lists&v=lists_list" class="text_color">
                <i class="fa fa-upload" aria-hidden="true"></i> Data Upload
            </a>
            <a href="?c=dashboard&v=report" class="text_color">
                <i class="fa fa-database" aria-hidden="true"></i> Call Reports
            </a>
            <a href="?c=dashboard&v=lead_report" class="text_color">
                <i class="fa fa-id-card-o cursor_p" aria-hidden="true"></i> Lead Reports
            </a>
            <a href="?c=dashboard&v=block_no" class="text_color">
                <i class="fa fa-ban" aria-hidden="true"></i> Block Number
            </a>
            <a href="?c=dashboard&v=disposition" class="text_color">
                <i class="fa fa-plus-square" aria-hidden="true"></i> Dispositions
            </a>
        <?php elseif ($user_level == 6): ?>
            <a href="?c=dashboard&v=report" class="text_color">
                <i class="fa fa-database" aria-hidden="true"></i> Call Reports
            </a>
            <a href="?c=dashboard&v=lead_report" class="text_color">
                <i class="fa fa-id-card-o cursor_p" aria-hidden="true"></i> Lead Reports
            </a>
        <?php endif; ?>
        
                </div>

            </section>
            <div class="col-12 col-lg-12 col-xl-10">
                <section class="top-bar">
                    <div id="main">
                        <!-- <button class="openbtn">&#9776;</button> -->
                        <button class="openbtn" onclick="toggleNav()">☰</button>

                    </div>


                    <div class="timeui" id="clock"></div>&nbsp;&nbsp;

                    <script>
                        function updateClock() {
                            // Ensure timeZoneSet is correctly defined
                            const timeZoneSet = "<?= $name_of_time_zone ?>";
                            const now = new Date();

                            // Format options for time
                            const options = {
                                timeZone: timeZoneSet,
                                hour: '2-digit',
                                minute: '2-digit',
                                second: '2-digit',
                                hour12: true,
                                // Optional: weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
                            };
                            const formattedTime = new Intl.DateTimeFormat('en-US', options).format(now);

                            // Get the time zone abbreviation for the specified time zone
                            const timeZoneAbbreviation = new Intl.DateTimeFormat('en-US', {
                                timeZone: timeZoneSet,
                                timeZoneName: 'short'
                            }).format(now).split(' ').pop();

                            // Display the formatted time and time zone abbreviation
                            document.getElementById('clock').textContent = `${formattedTime} ${timeZoneAbbreviation}`;
                        }

                        // Update the clock every second and immediately on page load
                        setInterval(updateClock, 1000);
                        updateClock(); 
                    </script>


                    <button class="livecall" id="livecallButton">Live calls</button>&nbsp;&nbsp;

                    <!-- The container for the popup -->
                    <div id="livePopupContainer"
                        style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; padding: 20px; border: 1px solid #ccc; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); z-index: 9999;">
                        <div id="livePopupHeader"
                            style="cursor: move; padding: 10px; background-color: #f1f1f1; border-bottom: 1px solid #ccc; display: flex; justify-content: space-between; align-items: center;">
                            <span>Drag</span>
                        </div>
                        <iframe id="livePopupIframe" src="/<?= $main_folder ?>/admin/pages/dashboard/livecall.php"
                            style="width: 900px; height: 500px; border: none;"></iframe>
                    </div>


                    <script>
                        document.getElementById('livecallButton').addEventListener('click', function () {
                            var popup = document.getElementById('livePopupContainer');
                            if (popup.style.display === 'none' || popup.style.display === '') {
                                popup.style.display = 'block';
                            } else {
                                popup.style.display = 'none';
                            }
                        });

                        // Make the popup draggable
                        dragElement(document.getElementById("livePopupContainer"));

                        function dragElement(el) {
                            var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
                            var header = document.getElementById(el.id + "Header");
                            if (header) {
                                header.onmousedown = dragMouseDown;
                            } else {
                                el.onmousedown = dragMouseDown;
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
                                el.style.top = (el.offsetTop - pos2) + "px";
                                el.style.left = (el.offsetLeft - pos1) + "px";
                            }

                            function closeDragElement() {
                                document.onmouseup = null;
                                document.onmousemove = null;
                            }
                        }

                    </script>



                    <!-- himanshu webphone code -->

                    <!-- The button to open the popup -->
                    <button class="btn btn-primary" id="openPopupButton">Phone</button>&nbsp;&nbsp;

                    <!-- The container for the popup -->
                    <div id="popupContainer"
                        style="display: none; position: fixed; top: 50%; right: 0; transform: translate(0, -50%); background-color: white; padding: 20px; border: 1px solid #ccc; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); z-index: 9999; cursor: move; width: 360px; height: 500px;">
                        <!-- Content of the popup -->
                        <iframe id="popupIframe" src="<?= $adminphone ?>"
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


                    <!-- <a href="tel:+919599406553">
                        <i class="fa fa-question-circle" aria-hidden="true"></i>
                    </a> -->


                    <a href="logout.php" data-toggle="tooltip" data-placement="bottom" title="Log Out">
                        <img src="../assets/images/dashboard/logout.png" alt="" />
                    </a>
                </section>
                <div id="content">
                    <!-- Layout Start -->
                    <?php
                    if (isset($_GET['c'])) {
                        include 'pages/' . $_GET['c'] . '/' . $_GET['v'] . '.php';
                    } else {
                        include 'pages/dashboard/index.php';
                    }
                    ?>

                    <!-- Layout End -->
                </div>


            </div>
        </div>
    </div>


    <script>



        // himanshu webphone

        // Function to handle the clicktocall action
        function clicktocall(callernumber) {
            if (callernumber) {
                callernumber = String(callernumber);
                if (/^(91|091)/.test(callernumber)) {
                    callernumber = callernumber.replace(/^(91|091)/, "0");
                }
            } else {
                console.error("Error: callernumber is undefined or null");
                return;
            }
            var iframe = document.getElementById('popupIframe');
            // iframe.src = "/vicnext2call-master/webphone/Phone/click-to-dial.php?d=" + callernumber;
            iframe.src = "<?= $click_2_call ?>?d=" + callernumber;
            console.log('Iframe src set to: ' + iframe.src); // For debugging
        }

        // Event listener to handle the clicktocall elements
        document.addEventListener('click', function (event) {
            var element = event.target.closest('.clicktocall');
            if (element) {
                var callernumber = element.getAttribute('data-callernumber');
                clicktocall(callernumber);
            }
        });

        // himanshu webphone



    </script>


    <!-- All the js files here -->
    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/chart.min.js"></script>
    <script src="../assets/js/chart_function.js"></script>
    <script src="../assets/js/datatables.min.js"></script>
    <script src="../assets/js/custom.js"></script>
    <script src="../assets/js/inputField.js"></script>


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
        }
        else {
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



</body>

</html>