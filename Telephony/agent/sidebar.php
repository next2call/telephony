<?php
require '../conf/db.php';
require '../conf/url_page.php';
include "../conf/Get_time_zone.php";

session_start();
if (!$_SESSION['user_level'] == 1) {
    header('location:../');
}


$sql = "Select * from vicidial_users where user_id =" . $_SESSION['user_id'];
$result = mysqli_query($conn, $sql);
$users = mysqli_fetch_assoc($result);
$user2 = $_SESSION['user'];
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
$date = date("Y M d");
// echo $ip=$_SERVER['REMOTE_ADDR'];
// continent, etc using IP Address  
$ip = '119.82.85.212'; 
  
// Use JSON encoded string and converts 
// it into a PHP variable 
$ipdat = @json_decode(file_get_contents( 
    "http://www.geoplugin.net/json.gp?ip=" . $ip)); 
   
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
if(isset($_POST["import"])){
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
    foreach($reader as $key => $row){
      $full_name = $row[0];
      $number = $row[1];
      $phone_code = $row[2];
   
if (!empty($full_name) && !empty($number)) {

  
    $tfnsnjkj = "SELECT * FROM upload_data WHERE number='$number' AND ins_date='$ins_date'";
    $njnkkmkj = mysqli_query($con, $tfnsnjkj);

    if (mysqli_num_rows($njnkkmkj) == 0) {
        // Record doesn't exist, insert it
        $insert = "INSERT INTO upload_data(full_name, number, phone_code, status, username, ins_date) VALUES('$full_name', '$number', '$phone_code', '1', '$user2', '$ins_date')";
        $queryy = mysqli_query($con, $insert);
          // echo "condition true";
        //   $insert="INSERT INTO upload_data(full_name, number, phone_code, status, username, ins_date) VALUES('$full_name', '$number', '$phone_code', '1', '$user2', '$ins_date')";
        //   // mysqli_query($conn, "INSERT INTO vicidial_list VALUES('', '$status', '$source_id', '$list_id')");
        //   // die();
        //   $queryy=mysqli_query($con, $insert);
          if($queryy){
            echo '
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
            
            <script>
            // var username = document.getElementById("floatingInput1").value;
            window.onload = function() {
              Swal.fire({
                title: "Success",
                text: "File Uploaded is successful.",
                icon: "success",
                confirmButtonText: "OK"
              });
            }
            </script>';
          }
  
      }else{
        echo '
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
        
        <script>
        // var username = document.getElementById("floatingInput1").value;
        window.onload = function() {
          Swal.fire({
            title: "Failed",
            text: "File Uploade already Insert.",
            icon: "error",
            confirmButtonText: "OK"
          });
        }
        </script>';
      }
  }
  

  
  }//========================check soource code for already insert
}    //========================while code condition for 

// }         //========================submit code
  //======================== end code start 
  


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
      font-size: 25px;
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
  </style>
</head>

<script>
        function HelloFromChild(digits) {
          clicktocall(digits);
            // alert("Hello " + digits + " , (called from child window)");
        }
    </script>

<body>
    <div class="idial-dashboard">
        <div class="row">
            <section class="idial-sidebar col-2">
                <div class="sidebar-lg">
                    <img src="../assets/images/dashboard/iDIAL.png" alt="" />
                    <h2>Agent</h2>


                    <a href="#" onclick="loadPage('pages/dashboard/index.php')"><i class="fa fa-th-large" aria-hidden="true"></i> Overview</a>

                    <a chref="#" onclick="loadPage('pages/dashboard/index.php')"><i class="fa fa-upload" aria-hidden="true"></i>Contact Upload</a>
                
                    <a href="#" onclick="loadPage('pages/dashboard/index.php')"><i class="fa fa-file" aria-hidden="true"></i> Report</a>
                   
            </section>
            <div class="col-12 col-lg-12 col-xl-10">
            <div id="mySidebar" class="sidebar sidebar-lg">
            <a href="javascript:void(0)" class="closebtn" onclick="toggleNav()">×</a>

            <img src="../assets/images/dashboard/iDIAL.png" alt="" />
                    <h2>Agent</h2>
                    
                    <a onclick="onLoadFunction()" class="cursor_p"><i class="fa fa-th-large" aria-hidden="true"></i> Overview</a>
                    <a href="javascript:void(0)" class="closebtn" onclick="toggleNav()">×</a>

                    <a class="show_upload cursor_p"><i class="fa fa-upload" aria-hidden="true"></i>Contact Upload</a>

                    <!-- <a onclick="onLoadFunction2()"><i class="fa fa-upload" aria-hidden="true"></i>Contact Upload</a> -->
              
                    <a class="report_data cursor_p"><i class="fa fa-file" aria-hidden="true"></i> Report</a>
                              </section>

</div>
                <section class="top-bar">
                  
                    <div id="main">
                    <button class="openbtn" onclick="toggleNav()">☰</button>


</div>
                    <a data-toggle="tooltip" href="#">
                        <i class="fa fa-question-circle" aria-hidden="true"></i>
                    </a>
                    <!-- Will be needed later -->
                    <!-- <a href="#" style="display: none;">
            <i class="fa fa-bell" aria-hidden="true"></i>
          </a>
          <span"></span> -->
                    <!-- Will be needed later -->

                    <a href="logout.php" data-toggle="tooltip" data-placement="bottom" title="Log Out">
                        <img src="../assets/images/dashboard/logout.png" alt="" />
                    </a>
                </section>
                <!-- <div id="result"> -->
                    <!-- Layout Start -->
                
                    
         

                    <!-- Layout End -->
                <!-- </div> -->


            </div>
        </div>
    </div>



<div id="content">
    <!-- Content from page.php will be loaded here -->
</div>
<!-- Your HTML and jQuery script -->
<script>
    function loadPage(page) {
        $.ajax({
            url: page,
            type: 'GET',
            dataType: 'html',
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
  
     <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script>


  $(document).ready(function() {
    $('#example').DataTable();
  });
</script>
<script>

    function onLoadFunction() {
        var date = '<?= $date ?>'; 
        var total_call = '<?= $total_call ?>'; 
        var congetion_call = '<?= $congetion_call ?>'; 
        var answer_call = '<?= $answer_call ?>'; 
        var cancel_call = '<?= $cancel_call ?>'; 
        var adminuser = '<?= $adminuser ?>'; 
        var full_name = '<?= $Current_user['full_name'] ?>'; 
        $.ajax({
            type: "POST",
            url: "pages/dashboard/index.php",
            data: { date: date, full_name: full_name, total_call: total_call, congetion_call: congetion_call, answer_call: answer_call, cancel_call: cancel_call, adminuser: adminuser }, // Add a comma here
            success: function(response){
                // Update the content of the element with the ID "result"
                $("#result").html(response);
            }
        });
    }

</script>

<script>
    $(document).ready(function(){
        $(".show_upload").on("click", function(){
            // function onLoadFunction2() {
            var user = '<?= $adminuser ?>'; 
            // alert(user);
            $.ajax({
                type: "POST",
                url: "pages/dashboard/data_upload.php", // Add a comma here
                data: { user: user }, // Add a comma here
                success: function(response){
                    // Update the content of the element with the ID "result"
                    $("#result").html(response);
                }
            });
        // }

        });
    });
</script>
<script>
    // Your existing script
    $(document).ready(function(){
        $(".report_data").on("click", function(){
            var user = '<?= $adminuser ?>'; 
            // var user = '<?= $adminuser ?>'; 
            // alert(user);
            $.ajax({
                type: "POST",
                url: "pages/dashboard/report.php", // Add a comma here
                data: { user: user }, // Add a comma here
                success: function(response){
                    // Update the content of the element with the ID "result"
                    $("#result").html(response);
                }
            });
        });
    });
</script>
<script>
    <?php
                if (!isset($page)) {
                   ?>
                    window.onload = onLoadFunction;
                   <?php
                } else{ ?>
                    window.onload = onLoadFunction;
              <?php  }     ?>
             
</script>
<script>

 function clicktocall(digits) {

    var user = "<?php echo $user2;?>";

    if(digits !== ''){

        
    var urlCheck = "https://10.10.10.17/himanshu/click2callsip.php?callerNumber=" + user + "&receiverNumber=0" + digits + "&anil&key=jbti89692vc60b2o9nu%^7";

$.ajax({
    type: 'GET',
    url: urlCheck,
    success: function (data, status, xhr) {
        console.log('data: ', data);
        if (data !== '') {
            Swal.fire({
                position: "top",
                icon: "success",
                title: data,
                showConfirmButton: false,
                timer: 1500
            });

            setTimeout(async () => {
                const { value: text } = await Swal.fire({
                    input: "textarea",
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    inputLabel: "Leave a message when the call disconnects",
                    inputPlaceholder: "Type your message here...",
                    inputAttributes: {
                        "aria-label": "Type your message here"
                    },
                    showCancelButton: true
                });

                if (text) {
                    // Send the message to the server using another AJAX request
                    $.ajax({
                        type: 'POST',
                        url: '/<?= $main_folder ?>/agent/pages/dashboard/insert_message.php',
                        data: { message: text, user: user, callernumber: digits },
                        success: function (response) {
                            Swal.fire(response);
                            // hangupCall();
                        }
                    });
                }
            }, 4000);
        } else {
            Swal.fire({
                position: 'top',
                icon: 'error',
                title: 'Something Went Wrong',
                showConfirmButton: false,
                timer: 3000
            });
        }
    }
});

    }else{

        Swal.fire({
                position: 'top',
                icon: 'error',
                title: 'Something Went Wrong',
                showConfirmButton: false,
                timer: 3000
            });

    }

  }



    $(document).on("click", ".clicktocall", function () {
    var callernumber = $(this).data("callernumber");
    var fornumber = $(this).data("idf");
    var prinumber = $(this).data("prinumber");
    var adminNo = "<?php echo $adminNu;?>";
    var user = "<?php echo $user2;?>";

    var urlCheck = "https://10.10.10.17/himanshu/click2callsip.php?callerNumber=" + user + "&receiverNumber=0" + callernumber + "&anil&key=jbti89692vc60b2o9nu%^7";

    $.ajax({
        type: 'GET',
        url: urlCheck,
        success: function (data, status, xhr) {
            console.log('data: ', data);
            if (data !== '') {
                Swal.fire({
                    position: "top",
                    icon: "success",
                    title: data,
                    showConfirmButton: false,
                    timer: 1500
                });

                setTimeout(async () => {
                    const { value: text } = await Swal.fire({
                        input: "textarea",
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        inputLabel: "Leave a message when the call disconnects",
                        inputPlaceholder: "Type your message here...",
                        inputAttributes: {
                            "aria-label": "Type your message here"
                        },
                        showCancelButton: true
                    });

                    if (text) {
                        // Send the message to the server using another AJAX request
                        $.ajax({
                            type: 'POST',
                            url: '/<?= $main_folder ?>/agent/pages/dashboard/insert_message.php',
                            data: { message: text, user: user, callernumber: callernumber },
                            success: function (response) {
                                Swal.fire(response);
                                // hangupCall();
                            }
                        });
                    }
                }, 4000);
            } else {
                Swal.fire({
                    position: 'top',
                    icon: 'error',
                    title: 'Something Went Wrong',
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        }
    });
});

</script>

</body>

</html>