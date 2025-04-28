<?php
session_start();
$_SESSION['page_start'] = 'index_page'; 
$Adminuser = $_SESSION['user'];
include "../../../conf/db.php";
include "../../../conf/url_page.php";
// echo "<script>alert('$Adminuser')</script>";

$ip = '119.82.85.212'; 

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

$all_data_check=$_REQUEST['filter_data'];
$date = date("Y-M-d");
$date1 = date("Y-m-d");

$sel = "SELECT user_id FROM `users` WHERE SuperAdmin='$Adminuser'";
$sql = mysqli_query($con, $sel);
$admin_user = [];

while($rowu = mysqli_fetch_assoc($sql)){
    $admin_user[] = $rowu['user_id'];
}

$admin_user_list = implode("','", $admin_user);

// $usersql2 = "SELECT * FROM `users` WHERE user_id NOT IN ('$admin_user_list') AND admin IN ('$admin_user_list')";
// $usersresult = mysqli_query($con, $usersql2);

if($all_data_check == 'today'){

    $sel1 = "select * from cdr WHERE admin IN ('$admin_user_list') AND start_time Like '%$date1%' ORDER BY `id` DESC";
    $qur_nogente = mysqli_query($con, $sel1);
    $total_call = mysqli_num_rows($qur_nogente);
    
    $sel2 = "select * from cdr WHERE status='ANSWER' AND admin IN ('$admin_user_list') AND start_time Like '%$date1%'";
    $qur_nogente2 = mysqli_query($con, $sel2);
    $answer_call = mysqli_num_rows($qur_nogente2);
    
    $sel3 = "select * from cdr WHERE status='CANCEL' AND admin IN ('$admin_user_list') AND start_time Like '%$date1%'";
    $qur_nogente3 = mysqli_query($con, $sel3);
    $cancel_call = mysqli_num_rows($qur_nogente3);
    
    $sel4 = "select * from cdr WHERE status!='ANSWER' AND status!='CANCEL' AND admin IN ('$admin_user_list') AND start_time Like '%$date1%'";
    $qur_nogente4 = mysqli_query($con, $sel4);
    $congetion_call = mysqli_num_rows($qur_nogente4);
    
}elseif($all_data_check == 'all'){


$sel1 = "select * from cdr WHERE admin IN ('$admin_user_list') ";
$qur_nogente = mysqli_query($con, $sel1);
$total_call = mysqli_num_rows($qur_nogente);

$sel2 = "select * from cdr WHERE status='ANSWER' AND admin IN ('$admin_user_list')";
$qur_nogente2 = mysqli_query($con, $sel2);
$answer_call = mysqli_num_rows($qur_nogente2);

$sel3 = "select * from cdr WHERE status='CANCEL' AND admin IN ('$admin_user_list')";
$qur_nogente3 = mysqli_query($con, $sel3);
$cancel_call = mysqli_num_rows($qur_nogente3);

$sel4 = "select * from cdr WHERE status!='ANSWER' AND status!='CANCEL' AND admin IN ('$admin_user_list') ";
$qur_nogente4 = mysqli_query($con, $sel4);
$congetion_call = mysqli_num_rows($qur_nogente4);

}else{
    $sel1 = "select * from cdr WHERE admin IN ('$admin_user_list') AND start_time Like '%$date1%'";
    $qur_nogente = mysqli_query($con, $sel1);
    $total_call = mysqli_num_rows($qur_nogente);
    
    $sel2 = "select * from cdr WHERE status='ANSWER' AND admin IN ('$admin_user_list') AND start_time Like '%$date1%'";
    $qur_nogente2 = mysqli_query($con, $sel2);
    $answer_call = mysqli_num_rows($qur_nogente2);
    
    
    $sel3 = "select * from cdr WHERE status='CANCEL' AND admin IN ('$admin_user_list') AND start_time Like '%$date1%'";
    $qur_nogente3 = mysqli_query($con, $sel3);
    $cancel_call = mysqli_num_rows($qur_nogente3);
    
    $sel4 = "select * from cdr WHERE status!='ANSWER' AND status!='CANCEL' AND admin IN ('$admin_user_list') AND start_time Like '%$date1%'";
    $qur_nogente4 = mysqli_query($con, $sel4);
    $congetion_call = mysqli_num_rows($qur_nogente4);
    
}

$sel_user = "select * from users WHERE admin IN ('$admin_user_list')";
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


<div class="row justify-content-center ml-5">
    <div class="col-lg-5">
        <div class="weather-card">
            <div class="row justify-content-between">
                <div class="col-md-5">
                    <div class="row align-items-center">
                        <div class="todays-icon col-6">
                            <img src="../assets/images/dashboard/sun.png" alt=""/>
                        </div>
                        <div class="todays-info col-6">
                        <h5><?= strtoupper(date('D')); ?></h5>
                            <h5><?php
                            echo $date;
                            ?></h5>
                        </div>
                    </div>
                    <div class="admin">
                        <h5><?= $Adminuser ?></h5>
                    </div>
                    <div class="location">
                        <h5>
                            <img src="../assets/images/dashboard/Location.png" alt=""/>
                            Noida, India
                        </h5>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="welcome-info">
                        <div>
                            <h4>Welcome Back</h4>
                            <h4 id="timeDisplay"></h4>
                        </div>
                        <img src="<?php echo $randomImagePath; ?>" alt="Random Image" width="<?php echo $imageWidth; ?>" height="<?php echo $imageHeight; ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-7 col-xl-6 ">
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
                        <h2><?= $answer_call ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 Cancel_call cursor_p">
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
                        <h2><?= $cancel_call ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row justify-content-center ml-5">
    <div class="col-lg-6">
        <div class="system-summary">
            <h3>Total Stats <span>Total records</span></h3>
       
            <div class="stats-group">
                <div class="stats-card">
                     <canvas id="pieChart" style="max-height: 400px;"></canvas>
                    <div class="card">
            <div class="card-body">
              <!-- <h5 class="card-title">Pie Chart</h5><canvas id="pieChart" style="max-height: 400px;"></canvas> -->
              <script>
  new Chart(document.querySelector('#pieChart'), {
    type: 'pie',
    data: {
      labels: [
        'Answer Call',
        'Other Call',
        'Cancel Call'
      ],
      datasets: [{
        label: 'My First Dataset',
        data: [<?= $answer_call ?>, <?= $congetion_call ?>, <?= $cancel_call ?>],
        backgroundColor: [
          '#65fc8b',
          '#b878f0',
          '#fc8c3c'
        ],
        hoverOffset: 4
      }]
    }
  });
</script>
<script>document.addEventListener("DOMContentLoaded", () => {
                  new Chart(document.querySelector('#pieChart'), {
                    type: 'pie',
                    data: {
                      labels: [
                      
                        'Answer Call',
                        'Other Call',
                        'Cancel Call'
                      ],
                      datasets: [{
                        label: 'My First Dataset',

                        data: [<?= $answer_call ?>, <?= $congetion_call ?>, <?= $cancel_call ?>],
                        backgroundColor: [
                        '#65fc8b',
                        '#b878f0',
                        '#fc8c3c'
                        ],
                        hoverOffset: 4
                      }]
                    }
                  });
                });</script>

            </div>
          </div>
                </div>
             
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="total-stats">
            <div>
                <h3>Agents Summary</h3>
                <div class="select">
                <select name="cars" id="cars" onchange="redirectToSelected()">
    <option value="">Select option</option>
    <option value="/vicidial-master/super_admin/index.php?c=dashboard&v=index&filter_data=today">Today</option>
    <option value="/vicidial-master/super_admin/index.php?c=dashboard&v=index&filter_data=all">All</option>
</select>
                    
                </div>
            </div>
            <div class="total-stats-table1 table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Agents</th>
                        <th scope="col">admin</th>
                        <th scope="col">Answer</th>
                        <th scope="col">Duration</th>
                        <!-- <th scope="col">Cancel</th>
                        <th scope="col">Other</th> -->
                        <th scope="col">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // if($all_data_check == 'today'){
                        //     $sel = "SELECT * FROM `users` WHERE date='date1' ORDER BY (
                        //         SELECT COUNT(*) FROM cdr WHERE call_from = users.user_id
                        //     ) DESC";
                        // }else{
                            $sel = "SELECT * FROM `users` WHERE admin IN ('$admin_user_list') AND user_id NOT IN ('$admin_user_list') ORDER BY (
                                SELECT COUNT(*) FROM cdr WHERE admin IN ('$admin_user_list')
                            ) DESC";
                        // }
                             
                        $sel_query = mysqli_query($con, $sel);
                        while($row_data = mysqli_fetch_array($sel_query)){
                            $user_id = $row_data['user_id'];
                            $admin_user = $row_data['admin'];
                            $user_name = $row_data['full_name'];
                           
                            if($all_data_check == 'today'){
                                $sel1 = "select * from cdr WHERE (call_from='$user_id' OR call_to='$user_id') AND start_time Like '%$date1%' AND admin IN ('$admin_user_list')";
                            }else if($all_data_check == 'all'){
                                $sel1 = "select * from cdr WHERE call_from='$user_id' OR call_to='$user_id' ";
                            }else{
                                $sel1 = "select * from cdr WHERE (call_from='$user_id' OR call_to='$user_id') AND start_time Like '%$date1%' AND admin IN ('$admin_user_list') ";
                            }
                    
                            $qur_sel1 = mysqli_query($con, $sel1);
                           $total_call_agent = mysqli_num_rows($qur_sel1);

                           if($all_data_check == 'today'){
                            $sel2 = "select * from cdr WHERE status='ANSWER' AND (call_from='$user_id' OR call_to='$user_id') AND start_time Like '%$date1%' AND admin IN ('$admin_user_list')";
                           }else if($all_data_check == 'all'){ 
                            $sel2 = "select * from cdr WHERE status='ANSWER' AND (call_from='$user_id' OR call_to='$user_id') AND admin IN ('$admin_user_list')";
                           }else{
                            $sel2 = "select * from cdr WHERE status='ANSWER' AND (call_from='$user_id' OR call_to='$user_id') AND start_time Like '%$date1%' AND admin IN ('$admin_user_list')";
                           }
                           
                           $qur_sel2 = mysqli_query($con, $sel2);
                          $total_ans_call_agent = mysqli_num_rows($qur_sel2);

                          if($all_data_check == 'today'){
                            $sel3 = "select * from cdr WHERE status='CANCEL' AND (call_from='$user_id' OR call_to='$user_id') AND start_time Like '%$date1%' AND admin IN ('$admin_user_list')";
                          }else if($all_data_check == 'all'){
                            $sel3 = "select * from cdr WHERE status='CANCEL' AND (call_from='$user_id' OR call_to='$user_id') ";
                           }else{
                            $sel3 = "select * from cdr WHERE status='CANCEL' AND (call_from='$user_id' OR call_to='$user_id') AND start_time Like '%$date1%' AND admin IN ('$admin_user_list')";
                           }
                          
                          $qur_sel3 = mysqli_query($con, $sel3);
                         $total_can_call_agent = mysqli_num_rows($qur_sel3);

                         if($all_data_check == 'today'){
                            $sel4 = "select * from cdr WHERE status!='ANSWER' AND status!='CANCEL' AND (call_from='$user_id' OR call_to='$user_id') AND start_time Like '%$date1%' AND admin IN ('$admin_user_list')";
                         }else if($all_data_check == 'all'){
                            $sel4 = "select * from cdr WHERE status!='ANSWER' AND status!='CANCEL' AND (call_from='$user_id' OR call_to='$user_id') ";
                         }else{
                            $sel4 = "select * from cdr WHERE status!='ANSWER' AND status!='CANCEL' AND (call_from='$user_id' OR call_to='$user_id') AND start_time Like '%$date1%' AND admin IN ('$admin_user_list')";
                         }
                         
                         $qur_sel4 = mysqli_query($con, $sel4);
                        $total_oth_call_agent = mysqli_num_rows($qur_sel4);

                        if($all_data_check == 'today'){
                            $sel5 = "SELECT SUM(dur) AS dur FROM cdr WHERE status='ANSWER' AND (call_from='$user_id' OR call_to='$user_id') AND start_time Like '%$date1%' AND admin IN ('$admin_user_list')";
                        }else if($all_data_check == 'all'){
                            $sel5 = "SELECT SUM(dur) AS dur FROM cdr WHERE status='ANSWER' AND (call_from='$user_id' OR call_to='$user_id')";
                        }else{
                            $sel5 = "SELECT SUM(dur) AS dur FROM cdr WHERE status='ANSWER' AND (call_from='$user_id' OR call_to='$user_id') AND start_time Like '%$date1%' AND admin IN ('$admin_user_list')";
                        }
                        
                        $qur_sel5 = mysqli_query($con, $sel5);
                        $tot_dur_row = mysqli_fetch_array($qur_sel5);
                        $total_duration_A_call = $tot_dur_row['dur'];
            

                        ?>
                      
                       
                    <tr>
                        <td title="UserId: <?= $user_name ?>"><?= $user_name ?>
                        <br>
                        <?php 
                         $sele_data = "SELECT * FROM `login_log` WHERE user_name='$user_id' AND status='1' ORDER BY id DESC LIMIT 1";
                        $sele_data_query = mysqli_query($con, $sele_data);
                        if(mysqli_num_rows($sele_data_query) > 0){

                             $sele_break = "SELECT * FROM `break_time` WHERE user_name='$user_id' AND break_status='1' ORDER BY id DESC LIMIT 1";
                            // die();
                            $sele_break_query = mysqli_query($con, $sele_break);
                            if(mysqli_num_rows($sele_break_query)> 0){
                                $d_row_d = mysqli_fetch_assoc($sele_break_query);
                                $break_name = $d_row_d['break_name'];
                                if($break_name == 'mobile'){ ?>
                          <span class="text-success"><?= $break_name ?> Break</span>
                               <?php } else{ ?>      
                          <span class="text-danger"><?= $break_name ?></span>
                           <?php }   }else{ ?>
                            <span class="text-success">Ready</span>
                           <?php }
                        }else{ ?>
                        <span class="text-danger">Logout</span>
                     <?php   } ?> 
                       </td>
                       <td><?= $admin_user ?></td>
                        <td><?= $total_ans_call_agent ?></td>
                        <td title="Total Answer Call Duration: <?= $total_duration_A_call ?> Sec"><?= $total_duration_A_call ?></td>
                        <!-- <td><?= $total_can_call_agent ?></td>
                        <td><?= $total_oth_call_agent ?></td> -->
                        <td><?= $total_call_agent ?></td>
                    </tr>
                    <?php }  ?>
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
<script>
  $(document).ready(function(){
        $(".Total_call").on("click", function(){
            var user = '<?= $adminuser ?>'; 
            var f_data = 'total_data'; 
            var filter_data = '<?= $all_data_check ?>'; 
            // alert('ok');
            $.ajax({
                type: "POST",
                url: "pages/dashboard/filter_page.php", // Add a comma here
                // url: "pages/dashboard/filter_page.php", // Add a comma here
                 
                data: { user: user, data: f_data, filter_data: filter_data }, // Add a comma here
                success: function(response){
                    // Update the content of the element with the ID "result"
                    $("#content").html(response);
                }
            });
        });
    });
    $(document).ready(function(){
        $(".Other_call").on("click", function(){
            var user = '<?= $adminuser ?>'; 
            var f_data = 'other_data'; 
            var filter_data = '<?= $all_data_check ?>';
            // alert(user);
            $.ajax({
                type: "POST",
                url: "pages/dashboard/filter_page.php", // Add a comma here
                data: { user: user, data: f_data, filter_data: filter_data }, // Add a comma here
                success: function(response){
                    // Update the content of the element with the ID "result"
                    $("#content").html(response);
                }
            });
        });
    });
    $(document).ready(function(){
        $(".Answer_call").on("click", function(){
            var user = '<?= $adminuser ?>'; 
            var f_data = 'ansewer_data'; 
            var filter_data = '<?= $all_data_check ?>';
            // alert(user);
            $.ajax({
                type: "POST",
                url: "pages/dashboard/filter_page.php", // Add a comma here
                data: { user: user, data: f_data, filter_data: filter_data }, // Add a comma here
                success: function(response){
                    // Update the content of the element with the ID "result"
                    $("#content").html(response);
                }
            });
        });
    });
    $(document).ready(function(){
        $(".Cancel_call").on("click", function(){
            var user = '<?= $adminuser ?>'; 
            var f_data = 'cancel_data'; 
            var filter_data = '<?= $all_data_check ?>';
            // alert(user);
            $.ajax({
                type: "POST",
                url: "pages/dashboard/filter_page.php", // Add a comma here
                data: { user: user, data: f_data, filter_data: filter_data }, // Add a comma here
                success: function(response){
                    // Update the content of the element with the ID "result"
                    $("#content").html(response);
                }
            });
        });
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
</script>

<script>
    function updateClock() {
        // Get the current time
        var currentTime = new Date().toLocaleTimeString();

        // Update the HTML element with the current time
        var timeDisplayElement = document.getElementById("timeDisplay");
        if (timeDisplayElement) {
            timeDisplayElement.innerHTML = currentTime;
        } else {
            console.error("Element with id 'timeDisplay' not found.");
        }
    }

    // Call the updateClock function every second
    setInterval(updateClock, 1000);
</script>