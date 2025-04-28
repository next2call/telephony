<?php 
session_start();
$_SESSION['page_start'] = 'index_page'; 
date_default_timezone_set('America/New_York'); // Set the timezone to Eastern Time


$date = date("Y-M-d");

//  $date = $_POST['date'];
//  $full_name = $_POST['full_name'];
//  $total_call = $_POST['total_call'];
//  $congetion_call = $_POST['congetion_call'];
//  $answer_call = $_POST['answer_call'];
//  $cancel_call = $_POST['cancel_call'];
//  $adminuser = $_POST['adminuser'];
 $con = new mysqli("localhost", "cron", "1234", "telephony_db");

 $adminuser = $_SESSION['user'];

 $full_name = $_SESSION['user'];
 //========================count calling===================
 $sel1 = "select * from cdr Where call_from='$adminuser' or call_to='$adminuser'";
 $qur_nogente = mysqli_query($con, $sel1);
 $total_call = mysqli_num_rows($qur_nogente);
 
 $sel2 = "select * from cdr WHERE status='ANSWER' AND call_from='$adminuser' or call_to='$adminuser'";
 $qur_nogente2 = mysqli_query($con, $sel2);
 $answer_call = mysqli_num_rows($qur_nogente2);
 
 $sel3 = "select * from cdr WHERE status='CANCEL'  AND call_from='$adminuser'";
 $qur_nogente3 = mysqli_query($con, $sel3);
 $cancel_call = mysqli_num_rows($qur_nogente3);
 
 $sel4 = "select * from cdr WHERE status!='ANSWER' AND status!='CANCEL' AND call_from='$adminuser'";
 $qur_nogente4 = mysqli_query($con, $sel4);
 $congetion_call = mysqli_num_rows($qur_nogente4);

 $sel5 = "SELECT SUM(dur) AS dur FROM cdr WHERE status='ANSWER' AND call_from='$adminuser' or call_to='$adminuser'";
 $qur_sel5 = mysqli_query($con, $sel5);
 $tot_dur_row = mysqli_fetch_array($qur_sel5);
 $total_duration_A_call = $tot_dur_row['dur'];
  



 
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
<div class="row justify-content-center ml-5">
    <div class="col-lg-12">
        <div class="mt-5 ml-5">
            <div class="row justify-content-between">
                <div class="col-md-6">
                    <h5>Caller Details</h5>
                    <div class="row mt-5">
                        <div class="col-md-6"><h6>Name</h6></div>
                        <div class="col-md-6"><p>Chandan Sharma</p></div>
                    </div>

                </div>
                <div class="col-md-6">
                    <h5> </h5>
                      <div class="row mt-5">
                        <div class="col-md-6"><h6>Contact</h6></div>
                        <div class="col-md-6"><p>7706912044 </p></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="col-lg-7 col-xl-6">
        <div class="row small-cards-group">
    
            <div class="col-lg-6 Total_call cursor_p">
                <div class="dashboard-card">
                    <div class="card-head">
                        <h5>Total Calls</h5>
                        <div class="card-head-icon">
                            <i class="fa fa-bar-chart" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <h2><?= $total_call ?></h2>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 Other_call cursor_p">
                <div class="dashboard-card">
                    <div class="card-head">
                        <h5>Other Calls</h5>
                        <div class="card-head-icon">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <h2><?= $congetion_call ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 Answer_call cursor_p">
                <div class="dashboard-card">
                    <div class="card-head">
                        <h5>Answer Calls</h5>
                        <div class="card-head-icon">
                            <i class="fa fa-volume-control-phone" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <h2 title="Every conversation completed in seconds."><?= $answer_call ?> <span class="call_text">Total Duration: <?= $total_duration_A_call ?></span> </h2>
                    </div>
                    
                </div>
            </div>
            <div class="col-lg-6 Cancel_call cursor_p">
                <div class="dashboard-card">
                    <div class="card-head">
                        <h5>Cancel Calls</h5>
                        <div class="card-head-icon">
                            <i class="fa fa-times-circle-o" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <h2><?= $cancel_call ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

</div>




