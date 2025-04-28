<?php
require '../conf/db.php';
require '../conf/url_page.php';
require '../include/campaign.php';
session_start();
if (!$_SESSION['user_level'] == 8) {
    header('location:../');
}
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
    <style>
            .cursor_p {
        cursor: pointer;
    }
    .text_color{
        color: #1e90ff  !important;
    }
    .text_color:hover {
    color: black !important;
    }
    .total-stats-table1 {
        height: 350px;
        overflow: auto;
    }
    /* Hide scrollbar for Webkit-based browsers (Chrome, Safari) */
.total-stats-table1::-webkit-scrollbar {
    width: 0.5em;
}

.total-stats-table1::-webkit-scrollbar-thumb {
    background-color: transparent; /* or add your own color */
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
    <div class="idial-dashboard">
        <div class="row">
            <section class="idial-sidebar-mbl">
                <div id="mySidebar" class="sidebar">
                    <div class="dashboard-sidedrawer">
                        <img src="../assets/images/dashboard/iDIAL.png" alt="" /> 
                        <h2>Administration</h2>
                        <a href="?c=dashboard&v=index" class="text_color"><i class="fa fa-th-large cursor_p" aria-hidden="true"></i> Overview</a>
                  
                  <a href="?c=campaign&v=campaign_list" class="text_color"><i class="fa fa-list" aria-hidden="true"></i> Campaigns</a>
                  <a href="?c=user&v=user_list" class="text_color"><i class="fa fa-users cursor_p" aria-hidden="true"></i> Agent List</a>
                  <a href="?c=user_group&v=show_user_group" class="text_color"><i class="fa-solid fa-people-group" aria-hidden="true"></i>Group</a>
                  <!-- <a href="?c=lists&v=lists_list" class="text_color"><i class="fa fa-upload" aria-hidden="true"></i>Data Upload</a> -->
                  <a href="?c=dashboard&v=report" class="text_color"><i class="fa fa-database" aria-hidden="true"></i> Call Reports</a>
                  <!-- <a href="?c=dashboard&v=call_notes" class="text_color"><i class="fa fa-sticky-note cursor_p" aria-hidden="true"></i> Call Notes</a> -->
                  <!-- <a href="?c=dashboard&v=ivr_converter" class="text_color"><i class="fa fa-volume-control-phone" aria-hidden="true"></i> IVR Converter</a> -->
                  <a href="?c=dashboard&v=disposition" class="text_color"><i class="fa fa-plus-square" aria-hidden="true"></i> Dispositions</a>
                    <a href="?c=dashboard&v=lead_report" class="text_color"><i class="fa fa-sticky-note cursor_p" aria-hidden="true"></i>Lead Report</a>
                    <!-- <a href="?c=dashboard&v=remote_agent" class="text_color"><i class="fa fa-user-circle-o" aria-hidden="true"></i> Remote Agents</a> -->
                    
                  
                     </div>
            </section>
            <section class="idial-sidebar col-2">
                <div class="sidebar-lg">
                    
                    <img src="../assets/images/dashboard/iDIAL.png" alt="" />
                    <h2>Administration</h2>
                    <a href="?c=dashboard&v=index" class="text_color"><i class="fa fa-th-large cursor_p" aria-hidden="true"></i> Overview</a>
                  
                    <a href="?c=campaign&v=campaign_list" class="text_color"><i class="fa fa-list" aria-hidden="true"></i> Campaigns</a>
                    <a href="?c=user&v=user_list" class="text_color"><i class="fa fa-user-secret cursor_p" aria-hidden="true"></i> Agent List</a>
                    <a href="?c=user_group&v=show_user_group" class="text_color"><i class="fa fa-users cursor_p" aria-hidden="true"></i>Group</a>
                    <!-- <a href="?c=lists&v=lists_list" class="text_color"><i class="fa fa-upload" aria-hidden="true"></i>Data Upload</a> -->
                    <a href="?c=dashboard&v=report" class="text_color"><i class="fa fa-database" aria-hidden="true"></i> Call Reports</a>
                    <!-- <a href="?c=dashboard&v=ivr_converter" class="text_color"><i class="fa fa-volume-control-phone" aria-hidden="true"></i> IVR Converter</a> -->
                    <a href="?c=dashboard&v=disposition" class="text_color"><i class="fa fa-plus-square" aria-hidden="true"></i> Dispositions</a>
                    <a href="?c=dashboard&v=lead_report" class="text_color"><i class="fa fa-sticky-note cursor_p" aria-hidden="true"></i> Lead Reports</a>
                    <!-- <a href="?c=dashboard&v=remote_agent" class="text_color"><i class="fa fa-user-circle-o" aria-hidden="true"></i> Remote Agents</a> -->
                    
                  
            </section>
            <div class="col-12 col-lg-12 col-xl-10">
                <section class="top-bar">
                    <div id="main">
                        <!-- <button class="openbtn">&#9776;</button> -->
                        <button class="openbtn" onclick="toggleNav()">☰</button>
                        
                    </div>

                    
                    <button class="livecall" id="livecallButton">Live calls</button>&nbsp;

<!-- The container for the popup -->
<div id="livePopupContainer" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; padding: 20px; border: 1px solid #ccc; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); z-index: 9999;">
    <iframe id="livePopupIframe" src="/<?= $main_folder ?>/super_admin/pages/dashboard/livecall.php" style="width: 750px; height: 500px; border: none;"></iframe>
    <button  style="display: none;" id="liveClosePopupButton">Close</button>
</div>
<!-- <div id="livePopupContainer">
    <iframe id="livePopupIframe" src="/vicidial-master/admin/pages/dashboard/livecall.php"></iframe>
    <button id="liveClosePopupButton" onclick="closeLivePopup()">Close</button>
</div> -->

<script>
    // Function to open the popup
    function openLivePopup() {
        // Show the popup container
        document.getElementById('livePopupContainer').style.display = 'block';
    }

    // Function to close the popup
    function closeLivePopup() {
        // Hide the popup container
        document.getElementById('livePopupContainer').style.display = 'none';
    }

    // Event listener to open the popup when the button is clicked
    document.getElementById('livecallButton').addEventListener('click', function(event) {
        openLivePopup();
        // Prevent the default behavior of the button (e.g., form submission)
        event.preventDefault();
    });

    // Event listener to close the popup when the close button is clicked
    document.getElementById('liveClosePopupButton').addEventListener('click', function(event) {
        closeLivePopup();
        // Prevent the default behavior of the button (e.g., form submission)
        event.preventDefault();
    });

    // Event listener to close the popup when clicking anywhere outside of it
    document.addEventListener('click', function(event) {
        var livePopupContainer = document.getElementById('livePopupContainer');
        var livecallButton = document.getElementById('livecallButton');

        // Check if the clicked element is not the popup container or the open button
        if (event.target !== livePopupContainer && event.target !== livecallButton && !livePopupContainer.contains(event.target)) {
            closeLivePopup();
        }
    });
</script>



                       <!-- himanshu webphone code -->

     <!-- The button to open the popup -->
<!-- <button class="btn btn-primary" id="openPopupButton">Phone</button>&nbsp; -->

<!-- The container for the popup -->
<div id="popupContainer" style="display: none; position: fixed; top: 50%; right: 0; transform: translate(0, -50%); background-color: white; padding: 20px; border: 1px solid #ccc; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); z-index: 9999;">
    <!-- Content of the popup -->
    <!-- <iframe id="popupIframe" src="/vicidial-master/webphone/Phone/index.php" style="width: 320px; height: 500px; border: none;"></iframe> -->
    <iframe id="popupIframe" src="<?= $phone_url87 ?>" style="width: 320px; height: 500px; border: none;"></iframe>
    <!-- Close button for the popup -->
    <button  style="display: none;" id="closePopupButton">Close</button>
</div>

<script>
    // Function to open the popup
    function openPopup() {
        // Show the popup container
        document.getElementById('popupContainer').style.display = 'block';
    }

    // Function to close the popup
    function closePopup() {
        // Hide the popup container
        document.getElementById('popupContainer').style.display = 'none';
    }

    // Event listener to open the popup when the button is clicked
    document.getElementById('openPopupButton').addEventListener('click', function(event) {
        openPopup();
        // Prevent the default behavior of the button (e.g., form submission)
        event.preventDefault();
    });

    // Event listener to close the popup when the close button is clicked
    document.getElementById('closePopupButton').addEventListener('click', function(event) {
        closePopup();
        // Prevent the default behavior of the button (e.g., form submission)
        event.preventDefault();
    });

    // Event listener to close the popup when clicking anywhere outside of it
    document.addEventListener('click', function(event) {
        var popupContainer = document.getElementById('popupContainer');
        var openPopupButton = document.getElementById('openPopupButton');

        // Check if the clicked element is not the popup container or the open button
        if (event.target !== popupContainer && event.target !== openPopupButton && !popupContainer.contains(event.target)) {
            closePopup();
        }
    });
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
        console.log('Opening popup for number: ' + callernumber); // For debugging
        openPopup();
        var iframe = document.getElementById('popupIframe');
        // iframe.src = "/vicidial-master/webphone/Phone/click-to-dial.php?d=" + callernumber;
        iframe.src = "<?= $click_2_call ?>?d=" + callernumber;
        console.log('Iframe src set to: ' + iframe.src); // For debugging
    }

    // Event listener to handle the clicktocall elements
    document.addEventListener('click', function(event) {
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
    window.addEventListener ("message", receive, false);        
}
else {
    if (window.attachEvent) {
        window.attachEvent("onmessage",receive, false);
    }
}

function receive(event){
    var data = event.data;
    if(typeof(window[data.func]) == "function"){
        window[data.func].call(null, data.params[0]);
    }
}

function alertMyMessage(msg){

    alert(msg);
}
  </script>

 

</body>

</html>