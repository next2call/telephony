<?php
session_start();
include "../../../conf/db.php";

$_SESSION['page_start'] = 'Report_page';  

 $Adminuser = $_SESSION['user'];
// die();
$get_data = $_POST['data'];
$filter_data = $_POST['filter_data'];
// echo "<script>alert($get_data)</script>";
$date1 = date("Y-m-d");
$_SESSION['filter_type']=$get_data;
$_SESSION['filter_data_ex']=$filter_data;

$sel = "SELECT user_id FROM `users` WHERE SuperAdmin='$Adminuser'";
$sql = mysqli_query($con, $sel);
$admin_user = [];

while($rowu = mysqli_fetch_assoc($sql)){
    $admin_user[] = $rowu['user_id'];
}

$admin_user_list = implode("','", $admin_user);

if($filter_data == 'today'){
    if($get_data == 'total_data')
    {
        $tfnsel="SELECT * from cdr WHERE admin IN ('$admin_user_list') AND start_time Like '%$date1%' ORDER BY id DESC";
    }elseif($get_data == 'other_data'){
        $tfnsel="SELECT * from cdr WHERE status!='CANCEL' AND status!='ANSWER' admin IN ('$admin_user_list') AND start_time Like '%$date1%' ORDER BY id DESC";
    }elseif($get_data == 'ansewer_data'){
        $tfnsel="SELECT * from cdr WHERE status='ANSWER'AND admin IN ('$admin_user_list') AND start_time Like '%$date1%' ORDER BY id DESC";
    }elseif($get_data == 'cancel_data'){
        $tfnsel="SELECT * from cdr WHERE status='CANCEL' AND admin IN ('$admin_user_list') AND start_time Like '%$date1%' ORDER BY id DESC";
    }
    
}elseif($filter_data == 'all'){
    if($get_data == 'total_data')
    {
        $tfnsel="SELECT * from cdr WHERE admin IN ('$admin_user_list') ORDER BY id DESC";
    }elseif($get_data == 'other_data'){
        $tfnsel="SELECT * from cdr WHERE status!='CANCEL' AND status!='ANSWER' AND admin IN ('$admin_user_list') ORDER BY id DESC";
    }elseif($get_data == 'ansewer_data'){
        $tfnsel="SELECT * from cdr WHERE status='ANSWER' AND admin IN ('$admin_user_list') ORDER BY id DESC";
    }elseif($get_data == 'cancel_data'){
        $tfnsel="SELECT * from cdr WHERE status='CANCEL' AND admin IN ('$admin_user_list') ORDER BY id DESC";
    }
    
}else{
    if($get_data == 'total_data')
    {
        $tfnsel="SELECT * from cdr WHERE admin IN ('$admin_user_list') AND start_time Like '%$date1%' ORDER BY id DESC";
    }elseif($get_data == 'other_data'){
          $tfnsel="select * from cdr WHERE status!='ANSWER' AND status!='CANCEL' AND admin IN ('$admin_user_list') AND start_time Like '%$date1%' ORDER BY id DESC";
    }elseif($get_data == 'ansewer_data'){
        $tfnsel="SELECT * from cdr WHERE status='ANSWER' AND admin IN ('$admin_user_list') AND start_time Like '%$date1%' ORDER BY id DESC";
    }elseif($get_data == 'cancel_data'){
        $tfnsel="SELECT * from cdr WHERE status='CANCEL' AND admin IN ('$admin_user_list') AND start_time Like '%$date1%' ORDER BY id DESC";
    }
    
}




// if(isset($_POST['search'])){
//     echo "OK";
//     die();
// }

?>
 <style>
        /* Style the audio player container */
        .audio-container {
            display: flex;
            align-items: center;
        }

        /* Style the play/pause button */
        .control {
            background: none;
            border: none;
            cursor: pointer;
        }

        /* Style the Download button and its icon */
        .download-button {
            background: none;
            border: none;
            cursor: pointer;
        }

        /* Adjust the size of the icons */
        .control span, .download-button i {
            font-size: 24px; /* Change the size as needed */
        }
        .select_date{
          margin-top: -2rem;
        }
        .img_answer{
          height: 1.2rem;
          width: 1.1rem;
        }
    
        /* #blockedForm.unblocked-form {
    display: block !important;
    visibility: visible !important;
} */
        


                            /* <th class='remove_a'># <input type="checkbox" class='remove_a' id="check-all"></th> */
    </style>
<!-- 
<div class="row ml-5 mt-2">
  <form action="" >
<div class="col-sm-4 ml-5">
<label for="">From Date</label>
<input type="text" class="form-control" value="<?php echo date('Y-m-d'); ?>">
</div>
<div class="col-sm-4">
<label for="">To Date</label>
<input type="text" class="form-control" value="<?php echo date('Y-m-d'); ?>">
</div>
<div class="col-sm-3">
  <button class="btn btn-info">Search</button><button class="btn btn-info ml-5">Export</button>
</div>
</form>
</div> -->

                <div class="ml-5">
                    <!-- Layout Start -->
                    <div class="total-stats">
                    <div class="ml-5">
                        <!-- <form action="" method="post">  -->

                       
                        <h3><?php echo str_replace('_', ' ', strtoupper($get_data)); ?></h3>
                        <div class="select">
                            <!-- <select name="cars" id="cars">
                                <option value="today">Today</option>
                                <option value="yesterday">Yesterday</option>
                            </select>
                            <button type="submit" name="search" class="btn btn-primary">Serach</button>
                    </form> -->
                            <a class="btn btn-success ml-2"href="pages/dashboard/filter_export_data.php">
                    Export</a>
                        </div>
                       
            </div>
            <div class="container mt-4">
                            <!-- <button class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">Upload</button> -->
        <div class="">
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th>ID</th>
        <!-- <th>Name</th> -->
        <th>Call From</th>
        <th>Number</th>
        <th>Start time</th>
        <th>End time</th>
        <th>Duration</th>
        <th>Status</th>
        <th>Direction</th>
        <th>Recording URL</th>
        <!-- <th>Msg</th> -->
        <!-- <th></th> -->
      </tr>
    </thead>
    <?php
    //   $tfnsel="SELECT * from cdr WHERE call_from='$user'";

     
$data = mysqli_query($con, $tfnsel);
$count = 0;

while ($row = mysqli_fetch_array($data))
{
  $call_from=$row['call_from'];
    $call_to = $row['call_to'];
    $start_time = $row['start_time'];
    $end_time = $row['end_time'];
    $dur = $row['dur'];
    $record_url = $row['record_url'];
    $msg = $row['msg'];
    $status = $row['status'];
    $direction = $row['direction'];

    // $call_from = substr($call_from, 2); 
    $noly10 = substr($call_from, 2); 
 
    $updatedUrl = str_replace("http://", "https://", $record_url);
  $count++;
    ?>
      <tr>
        <td><?php echo $count ; ?></td>

     <td><?php if($direction == 'inbound'){
      echo $call_from ; ?><a type="button" data-callernumber="<?= $noly10 ?>"
      class="badge bg-primary clicktocall ml-2 cursor_p">
      <i class="fa fa-phone-square"></i></a>
        <?php }else{ echo $call_from ; }?></td>                             
      <td><?php if($direction == 'outbound'){
      echo $call_to ; ?><a type="button" data-callernumber="<?= $call_to ?>"
      class="badge bg-primary clicktocall ml-2 cursor_p">
      <i class="fa fa-phone-square"></i></a>
        <?php }else{ echo $call_to ; }?></td>

        <td><?php echo $start_time ; ?></td>
        <td><?php echo $end_time ; ?></td>
        <td><?php echo $dur ; ?></td>
        <td><?php echo $status ; ?></td>
        <td><?php echo $direction ; ?></td>
        
        <?php 
 
      echo '<td>
      <audio class="audio-player" id="myTune">
      <source src="' . $updatedUrl . '" type="audio/wav">

      </audio>
      <button class="control" type="button" onclick="aud_play_pause(this.previousElementSibling)">
                  <span id="play-pause-icon">▶</span>
              </button>
              <a href="' . $updatedUrl . '" download>
              <button class="download-button" type="button">
                  <i class="fa fa-download"></i>
              </button>
          </a>
  </td>';
        ?>
    
        <!-- <td><?php echo $msg ; ?></td> -->
       
        
      </tr>
      <?php } ?>
      <!-- Add more rows as needed -->
    

  </table>
  <!-- jQuery script for clicktocall functionality -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
        var currentAudio = null;

        function aud_play_pause(audio) {
            if (currentAudio !== audio) {
                if (currentAudio) {
                    currentAudio.pause();
                    var currentPlayPauseIcon = currentAudio.nextElementSibling.querySelector('.control span');
                    currentPlayPauseIcon.textContent = '▶'; // Reset the icon
                }
                currentAudio = audio;
            }

            if (audio.paused) {
                audio.play();
                var playPauseIcon = audio.nextElementSibling.querySelector('.control span');
                playPauseIcon.textContent = '⏸';
                consol.log('playPauseIcon');
            } else {
                audio.pause();
                var playPauseIcon = audio.nextElementSibling.querySelector('.control span');
                playPauseIcon.textContent = '▶';
            }
        }
    </script>
</div>
</div>
    

                    <!-- Layout End -->
                </div>
                </div>


