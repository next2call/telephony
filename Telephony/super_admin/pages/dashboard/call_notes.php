<?php
session_start();
include "../../../conf/db.php";

$_SESSION['page_start'] = 'Report_page';  

 $user = $_SESSION['user'];

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
        .data_btn2{
    background: #f6dfce;
    color: #284f99;
    font-weight: bold;
    font-size: 16px;
    line-height: 22px;
    /* color: #637381; */
    /* background: transparent; */
    border-radius: 10px;
    padding: 15px;
    margin-right: 25px;
    transition: 0.3s all ease-in-out;
    margin-top: 25px;
    display: inline-block;
}
.data_btn1{
    background: #dfcbea;
    color: #284f99;
    font-weight: bold;
    font-size: 16px;
    line-height: 22px;
    /* color: #637381; */
    /* background: transparent; */
    border-radius: 10px;
    padding: 15px;
    margin-right: 25px;
    transition: 0.3s all ease-in-out;
    margin-top: 25px;
    display: inline-block;
}
.data_btn{
    background: #dfcb56;
    color: #284f99;
    font-weight: bold;
    font-size: 16px;
    line-height: 22px;
    /* color: #637381; */
    /* background: transparent; */
    border-radius: 10px;
    padding: 15px;
    margin-right: 25px;
    transition: 0.3s all ease-in-out;
    margin-top: 25px;
    display: inline-block;
}
    
        /* #blockedForm.unblocked-form {
    display: block !important;
    visibility: visible !important;
} */
        


                            /* <th class='remove_a'># <input type="checkbox" class='remove_a' id="check-all"></th> */
    </style>


 <div class="user-stats">


    <!-- form starts here -->
    <form action="" method="post">
        <div class="row my-card align-items-center">

           
            <div class="my-input-with-help col-12 col-md-3 col-lg-3">
                <div class="form-group my-input">

                   
                    <select name="userss_id" id="" class="form-control">
                    <option value="">Select User</option>
                                <?php 
                                 $sel_users = "select * from users WHERE admin='$user'";
                                 $sel_users_query = mysqli_query($con, $sel_users);
                                 while($users_row = mysqli_fetch_array($sel_users_query)){
                                 ?>
                                <option value="<?= $users_row['user_id'] ?>"><?= $users_row['full_name'] ?></option>
                                   <?php } ?>
                    </select>
                </div>
            </div>

            <div class="my-input-with-help col-12 col-md-6 col-lg-3">
                <div class="form-group my-input">

                    <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control str_date"
                           id="str_date" name="f_date" aria-describedby="begin_date">
                    <label for="begin_date ">From Date</label>
                </div>
            </div>

            <div class="my-input-with-help col-12 col-md-6 col-lg-3">
                <div class="form-group my-input">

                    <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control str_date2"
                           id="end_date" name="to_date" aria-describedby="end_date">
                    <label for="end_date">To Date</label>
                </div>
            </div>
            <button class="btn btn-primary ml-5" type="submit" name="search">Search</button> 
      
        </div>
    </form>


    <div class="my-card-with-title">
    <div class="title-bar">
    <h4>Total Call Notes</h4>
    <!-- <a href="#"><i class="fa fa-download" aria-hidden="true"></i></a> -->
    <!-- <a class="data_btn2" href="#dynamic_lead" data-toggle="modal" data-target="#dynamic_lead"><i -->
                                class="fa fa-plus-circle" title="Dynamic Lead Add"></i>
                        New Note</a>
    <a class="data_btn" href="?c=dashboard&v=note_list"><i
                                class="fa fa-plus-circle" title="Your Note lists"></i>
                        Notes Lists</a>
    <a class="data_btn1" href="pages/dashboard/export_callnots.php">
                        Export</a>
</div>
<div class="card-body">
    <div class="my-secondary-table">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Call From</th>
                <th scope="col">Number</th>
                <th scope="col">Start time</th>
                <th scope="col">Disposition</th>
                <th scope="col">Task</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            
            <tbody>
    <?php

    //   $tfnsel="SELECT * from cdr WHERE call_from='$user'";
    if(isset($_POST['search'])){

      $userss_id=$_POST['userss_id'];
      if(empty($userss_id) && empty($_POST['f_date']) && empty($_POST['to_date'])){

         $tfnsel="SELECT * from call_notes WHERE  admin = '$user' ORDER BY id DESC";

      }elseif(empty($userss_id)){
        $from_date=$_POST['f_date'];
        $_SESSION['from_date_str'] = $_POST['f_date'];
        $to_date=$_POST['to_date'];
        $_SESSION['to_date_str'] = $_POST['to_date'];
        $tfnsel="SELECT * from call_notes WHERE DATE(datetime) between '$from_date' and '$to_date' ORDER BY Id DESC";
    //    die();
       }elseif(!empty($userss_id) && !empty($_POST['f_date']) && !empty($_POST['to_date'])){
        $userss_id=$_POST['userss_id'];
        $_SESSION['user_id'] = $_POST['userss_id'];
        $from_date=$_POST['f_date'];
        $_SESSION['from_date_str'] = $_POST['f_date'];
        $to_date=$_POST['to_date'];
        $_SESSION['to_date_str'] = $_POST['to_date'];
        $tfnsel="SELECT * from call_notes WHERE DATE(datetime) between '$from_date' and '$to_date' AND phone_code='$userss_id' ORDER BY id DESC";
    //    die();  
      }elseif(!empty($userss_id)){
        $userss_id=$_POST['userss_id'];
        $_SESSION['user_id'] = $_POST['userss_id'];
        $_SESSION['from_date_str'] = '';
        $_SESSION['to_date_str'] = '';
         $tfnsel="SELECT * from call_notes WHERE  admin = '$user' AND phone_code='$userss_id' ORDER BY id DESC";
        // die();
       }else{
         $tfnsel="SELECT * from call_notes WHERE  admin = '$user' ORDER BY id DESC";
    //   die();
       }
  
    }else{
       $tfnsel="SELECT * from call_notes WHERE  admin = '$user' ORDER BY id DESC";
    //   die();
    }
     
$data = mysqli_query($con, $tfnsel);
$count = 0;

while ($row = mysqli_fetch_array($data))
{
  $call_from=$row['phone_code'];
    $call_to = $row['caller_number'];
    $start_time = $row['datetime'];
    $disposition = $row['disposition'];
  $sms_ins = $row['massage'];

  $count++;
    ?>
      <tr>
        <td><?php echo $count ; ?></td>
        <td><?php echo $call_from ; ?></td>
        <td><?php echo $call_to ; ?><a type="button" onclick='clicktocall(<?= $call_to ?>)' data-callernumber="<?= $call_to ?>"
                                            class="badge bg-primary ml-2 cursor_p">
                                            <i class="fa fa-phone-square"></i></a></td>
        <td><?php echo $start_time ; ?></td>
        <td><?php echo $disposition; ?></td>    
        <td><?php echo $sms_ins ; ?></td>    
        <td class="btn btn-primary">View</td>    
      </tr>
      <?php } ?>
            <!-- <tr>
                <td colspan="3">No data available</td>
            </tr> -->
            </tbody>
        </table>
    </div>
</div>
</div>
</div>
<?php
require 'not_modals.php';
?>
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
     <script>
    document.getElementsByClassName('str_date')[0].max = new Date().toISOString().split("T")[0];
    document.getElementsByClassName('str_date2')[0].max = new Date().toISOString().split("T")[0];
</script>

