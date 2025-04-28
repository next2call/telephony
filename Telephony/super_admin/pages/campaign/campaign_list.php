<?php
session_start();
$Adminuser = $_SESSION['user'];
include "../../../conf/db.php";
include "../../../conf/url_page.php";

$campaign = new campaign();

$sel = "SELECT user_id FROM `users` WHERE SuperAdmin='$Adminuser'";
$sql = mysqli_query($con, $sel);
$admin_user = [];

while($rowu = mysqli_fetch_assoc($sql)){
    $admin_user[] = $rowu['user_id'];
}

$admin_user_list = implode("','", $admin_user);

 $sql = "SELECT * FROM `compaign_list` WHERE admin IN ('$admin_user_list') ORDER BY id DESC";
// die();
$reslut = mysqli_query($con, $sql);

$msg=0;


if (isset($_POST['add_campaign'])) {

    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);

    $campaign->campaign_id = $_POST['campaign_id'];
    $campaign->campaign_name = $_POST['campaign_name'];
    $campaign->campaign_description = $_POST['campaign_description'];
    $campaign->active = $_POST['active'];
    // $campaign->park_file_name = $_file['park_file_name'];


    // $campaign->after_office_ivr = $_file['after_office_ivr'];   
    $campaign->campaign_no = $_POST['campaign_no'];
    $campaign->next_agent_call = $_POST['next_agent_call'];
    $campaign->local_call_time = $_POST['local_call_time'];
    $campaign->week_off = $_POST['week_off'];
    $campaign->script_id = $_POST['script_id'];
    $campaign->get_call_launch = $_POST['get_call_launch'];
    $campaign->group_wise = $_POST['group_wise'];



 // Secure the inputs to prevent SQL Injection
$campaign_id = mysqli_real_escape_string($con, $campaign->campaign_id);
$campaign_name = mysqli_real_escape_string($con, $campaign->campaign_name);
$campaign_description = mysqli_real_escape_string($con, $campaign->campaign_description);
$active = mysqli_real_escape_string($con, $campaign->active);
// $park_file_name = mysqli_real_escape_string($con, $campaign->park_file_name);
// $welcome_ivr = mysqli_real_escape_string($con, $campaign->welcome_ivr);
// $after_office_ivr = mysqli_real_escape_string($con, $campaign->after_office_ivr);
$campaign_no = mysqli_real_escape_string($con, $campaign->campaign_no);
$next_agent_call = mysqli_real_escape_string($con, $campaign->next_agent_call);
$local_call_time = mysqli_real_escape_string($con, $campaign->local_call_time);
$week_off = mysqli_real_escape_string($con, $campaign->week_off);
$script_id = mysqli_real_escape_string($con, $campaign->script_id);
$get_call_launch = mysqli_real_escape_string($con, $campaign->get_call_launch);
$group_wise = mysqli_real_escape_string($con, $campaign->group_wise);
$admin = mysqli_real_escape_string($con, $_SESSION['admin']);




$date = date('Y-m-d H:i:s');


    $welcome_ivr = $_FILES['welcome_ivr']['name'];
    $tmpFilePath = $_FILES['welcome_ivr']['tmp_name'];

    $target_directory = 'ivr/';  // Define your target directory

// Check if directory exists, if not create it
if (!is_dir($target_directory)) {
    mkdir($target_directory, 0777, true);
}


    if(!empty($welcome_ivr)){
        // $welcome_ivr_path = "ivr/" . $welcome_ivr;
        $welcome_ivr_path = $target_directory . uniqid() . '.wav';  
        move_uploaded_file($tmpFilePath, $welcome_ivr_path);

        $ins_welcome_ivr_path = "INSERT INTO `welcome_ivr`(`campaign_Id`, `file_name`, `status`, `admin`, `time`) VALUES ('$campaign_id','$welcome_ivr_path','1','$Adminuser','$date')";
        mysqli_query($con, $ins_welcome_ivr_path);
    }


    $park_file_name = $_FILES['park_file_name']['name'];
    $park_file_nametemp = $_FILES['park_file_name']['tmp_name'];


    if(!empty($park_file_name)){
        $new_df_name = uniqid();
        $target_directory2 = "ivr/" . $new_df_name . "/"; 
        if (!is_dir($target_directory2)) {
            mkdir($target_directory2, 0777, true);
        }
        $park_file_name_two = $target_directory2 . $new_df_name . '.wav';  
        move_uploaded_file($park_file_nametemp, $park_file_name_two);
    
        $new_moh_class = [
            'custom-'.$campaign_id => '/srv/www/htdocs/'.$main_folder.'/admin/ivr/' . $new_df_name,
        ];
        
        // Path to the musiconhold.conf file
        $file_path = '/etc/asterisk/musiconhold.conf';
        
        // Read the existing contents of the file
        $existing_content = '';
        if (file_exists($file_path)) {
            $existing_content = file_get_contents($file_path);
        }
        
        // Parse the existing MOH classes
        $existing_moh_classes = [];
        if ($existing_content !== false) {
            $lines = explode("\n", $existing_content);
            $current_class = null;
            foreach ($lines as $line) {
                if (preg_match('/^\[(.+)\]$/', trim($line), $matches)) {
                    $current_class = $matches[1];
                } elseif ($current_class && preg_match('/^directory=(.+)$/', trim($line), $matches)) {
                    $existing_moh_classes[$current_class] = $matches[1];
                    $current_class = null;
                }
            }
        }
        
        // Merge the new MOH class with the existing ones
        $moh_classes = array_merge($existing_moh_classes, $new_moh_class);
        
        // Open the file for writing
        $file = fopen($file_path, 'w');
        if ($file === false) {
            die("Unable to open or create $file_path");
        }
        
        // Write the MOH classes to the file
        foreach ($moh_classes as $class => $directory) {
            fwrite($file, "[$class]\n");
            fwrite($file, "mode=files\n");
            fwrite($file, "directory=$directory\n");
            fwrite($file, "random=no\n\n");
        }
        
        // Close the file
        fclose($file);
       
        $stmtA="UPDATE servers SET rebuild_conf_files='Y' where generate_vicidial_conf='Y' and active_asterisk_server='Y' and server_ip='192.168.125.241' OR server_ip='103.113.27.163'";
        $selstm = "SELECT active FROM vicidial_music_on_hold WHERE moh_id='vicidial_master'";
        $sqlsel = mysqli_query($conn, $selstm);
        $sql_row = mysqli_fetch_assoc($sqlsel);
        $activestatus = $sql_row['active'];
        if($activestatus == 'Y'){
           $active = 'N';
        } else {
            $active = 'Y';
        }
        $stmtA1="UPDATE vicidial_music_on_hold SET active='$active' where moh_id='vicidial_master'";
            mysqli_query($conn,$stmtA1);
            mysqli_query($conn,$stmtA);
       

        $ins_park_file_name_two = "INSERT INTO `music_on_hold_tbl`(`campaign_Id`, `file_name`, `status`, `admin`, `time`) VALUES ('$campaign_id','$park_file_name_two','1','$Adminuser','$date')";
        mysqli_query($con, $ins_park_file_name_two);
    }

    $after_office_ivr = $_FILES['after_office_ivr']['name'];
    $after_office_ivrtemp = $_FILES['after_office_ivr']['tmp_name'];

    if(!empty($after_office_ivr)){
        // $after_office_ivr_three = "ivr/" . $after_office_ivr;
        $after_office_ivr_three = $target_directory . uniqid() . '.wav';  

        move_uploaded_file($after_office_ivrtemp, $after_office_ivr_three);
        $ins_after_office_ivr = "INSERT INTO `after_office_ivr_tbl`(`campaign_Id`, `file_name`, `status`, `admin`, `time`) VALUES ('$campaign_id','$after_office_ivr_three','1','$Adminuser','$date')";
        mysqli_query($con, $ins_after_office_ivr);

    }


    $week_of_ivr = $_FILES['week_of_ivr']['name'];
    $week_of_ivrtemp = $_FILES['week_of_ivr']['tmp_name'];

    if(!empty($week_of_ivr)){
        // $after_office_ivr_three = "ivr/" . $after_office_ivr;
        $week_of_ivr_four = $target_directory . uniqid() . '.wav';  
        move_uploaded_file($week_of_ivrtemp, $week_of_ivr_four);

        $ins_week_of_ivr = "INSERT INTO `week_off_ivr_tbl`(`campaign_Id`, `file_name`, `status`, `admin`, `time`) VALUES ('$campaign_id','$week_of_ivr_four','1','$Adminuser','$date')";
        mysqli_query($con, $ins_week_of_ivr);
    }

    
   $select1 = "SELECT * FROM compaign_list WHERE compaign_id='$campaign_id'";
    $sel_query1 = mysqli_query($con, $select1);

    if (mysqli_num_rows($sel_query1) > 0) {
      echo '
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
      
      <script>
      // var username = document.getElementById("floatingInput1").value;
      window.onload = function() {
        Swal.fire({
          title: "Failed",
          text: "Sorry, this Campain Id already exists",
          icon: "error",
          confirmButtonText: "OK"
        });
      }
      </script>';
    } else {
// Create the SQL query string
  $sql_New = "INSERT INTO `compaign_list` (
    `compaign_id`, `compaignname`, `campaign_number`, `campaign_dis`, `creat_date`, `status`, 
    `music_on_hold`, `welcome_ivr`, `after_office_ivr`, `week_off_ivr`, `local_call_time`, `week_off`,
    `script_notes`, `get_call_lunch`, `admin`, `ring_time`, `agent_number`, 
    `ivr`, `type`
) VALUES (
    '$campaign_id', '$campaign_name', '$campaign_no','$campaign_description', '$date', '$active', 
    '$park_file_name_two', '$welcome_ivr_path', '$after_office_ivr_three', '$week_of_ivr_four', '$local_call_time', '$week_off',
    '$script_id', '$get_call_launch', '$Adminuser', '0', 
    '', '$group_wise', '$next_agent_call')";

$insert =mysqli_query($con, $sql_New);

    if($insert){
        // $msg = 1;
        echo '
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
        <script>
        window.onload = function() {
            Swal.fire({
                icon: "success",
                title: "Campaign creation successful",
                confirmButtonText: "OK"
            }).then(() => {
                window.location.href = "'.$admin_ind_page.'?c=campaign&v=campaign_list";
            });
        };                
        </script>';
        // exit; // Ma
    }else{
        $msg=2;
    }

}


}

####################################################### Working start for campaign Update #####################################

if(isset($_POST['update_campaign']))
{
    $campaign->c_id = $_POST['c_id'];
    $campaign->campaign_id = $_POST['campaign_id'];
    $campaign->campaign_name = $_POST['campaign_name'];
    $campaign->campaign_description_new = $_POST['campaign_description_new'];
    $campaign->active = $_POST['active'];
    // $campaign->park_file_name = $_file['park_file_name'];


    // $campaign->after_office_ivr = $_file['after_office_ivr'];   
    $campaign->campaign_no = $_POST['campaign_no'];
    $campaign->next_agent_call = $_POST['next_agent_call'];
    $campaign->local_call_time = $_POST['local_call_time'];
    $campaign->week_off = $_POST['week_off'];
    $campaign->script_id = $_POST['script_id'];
    $campaign->get_call_launch = $_POST['get_call_launch'];
    $campaign->group_wise = $_POST['group_wise'];

 // Secure the inputs to prevent SQL Injection
$c_id = mysqli_real_escape_string($con, $campaign->c_id);
$campaign_id = mysqli_real_escape_string($con, $campaign->campaign_id);
$campaign_name = mysqli_real_escape_string($con, $campaign->campaign_name);
$campaign_description = mysqli_real_escape_string($con, $campaign->campaign_description_new);
$active = mysqli_real_escape_string($con, $campaign->active);
// $park_file_name = mysqli_real_escape_string($con, $campaign->park_file_name);
// $welcome_ivr = mysqli_real_escape_string($con, $campaign->welcome_ivr);
// $after_office_ivr = mysqli_real_escape_string($con, $campaign->after_office_ivr);
$campaign_no = mysqli_real_escape_string($con, $campaign->campaign_no);
$next_agent_call = mysqli_real_escape_string($con, $campaign->next_agent_call);
$local_call_time = mysqli_real_escape_string($con, $campaign->local_call_time);
$week_off = mysqli_real_escape_string($con, $campaign->week_off);
$script_id = mysqli_real_escape_string($con, $campaign->script_id);
$get_call_launch = mysqli_real_escape_string($con, $campaign->get_call_launch);
$group_wise = mysqli_real_escape_string($con, $campaign->group_wise);
$admin = mysqli_real_escape_string($con, $_SESSION['admin']);
$date = date('Y-m-d H:i:s');

$welcome_ivr = $_FILES['welcome_ivr']['name'];
$tmpFilePath = $_FILES['welcome_ivr']['tmp_name'];
$welcome_ivr_one = '';

$target_directory = 'ivr/';  // Define your target directory

// Check if directory exists, if not create it
if (!is_dir($target_directory)) {
    mkdir($target_directory, 0777, true);
}



if (!empty($welcome_ivr)) {

    // $welcome_ivr_one = "ivr/" . $welcome_ivr;
    $welcome_ivr_one = $target_directory . uniqid() . '.wav';  
    move_uploaded_file($tmpFilePath, $welcome_ivr_one);
}

$park_file_name = $_FILES['park_file_name_new']['name'];
$park_file_nametemp = $_FILES['park_file_name_new']['tmp_name'];
$park_file_name_two = '';

if (!empty($park_file_name)) {
    $new_df_name = uniqid();
    $target_directory2 = "ivr/" . $new_df_name . "/"; 
    if (!is_dir($target_directory2)) {
        mkdir($target_directory2, 0777, true);
    }
    $park_file_name_two = $target_directory2 . $new_df_name . '.wav';  
    move_uploaded_file($park_file_nametemp, $park_file_name_two);

    $new_moh_class = [
        'custom-'.$campaign_id => '/srv/www/htdocs/'.$main_folder.'/admin/ivr/' . $new_df_name,
    ];
    
    // Path to the musiconhold.conf file
    $file_path = '/etc/asterisk/musiconhold.conf';
    
    // Read the existing contents of the file
    $existing_content = '';
    if (file_exists($file_path)) {
        $existing_content = file_get_contents($file_path);
    }
    
    // Parse the existing MOH classes
    $existing_moh_classes = [];
    if ($existing_content !== false) {
        $lines = explode("\n", $existing_content);
        $current_class = null;
        foreach ($lines as $line) {
            if (preg_match('/^\[(.+)\]$/', trim($line), $matches)) {
                $current_class = $matches[1];
            } elseif ($current_class && preg_match('/^directory=(.+)$/', trim($line), $matches)) {
                $existing_moh_classes[$current_class] = $matches[1];
                $current_class = null;
            }
        }
    }
    
    // Merge the new MOH class with the existing ones
    $moh_classes = array_merge($existing_moh_classes, $new_moh_class);
    
    // Open the file for writing
    $file = fopen($file_path, 'w');
    if ($file === false) {
        die("Unable to open or create $file_path");
    }
    
    // Write the MOH classes to the file
    foreach ($moh_classes as $class => $directory) {
        fwrite($file, "[$class]\n");
        fwrite($file, "mode=files\n");
        fwrite($file, "directory=$directory\n");
        fwrite($file, "random=no\n\n");
    }
    
    // Close the file
    fclose($file);
   
    $stmtA="UPDATE servers SET rebuild_conf_files='Y' where generate_vicidial_conf='Y' and active_asterisk_server='Y' and server_ip='192.168.125.241' OR server_ip='103.113.27.163'";
    $selstm = "SELECT active FROM vicidial_music_on_hold WHERE moh_id='vicidial_master'";
    $sqlsel = mysqli_query($conn, $selstm);
    $sql_row = mysqli_fetch_assoc($sqlsel);
    $activestatus = $sql_row['active'];
    if($activestatus == 'Y'){
       $active = 'N';
    } else {
        $active = 'Y';
    }
    $stmtA1="UPDATE vicidial_music_on_hold SET active='$active' where moh_id='vicidial_master'";
        mysqli_query($conn,$stmtA1);
        mysqli_query($conn,$stmtA);
   
}
$after_office_ivr = $_FILES['after_office_ivr']['name'];
$after_office_ivrtemp = $_FILES['after_office_ivr']['tmp_name'];
$after_office_ivr_three = '';

if (!empty($after_office_ivr)) {
    // $after_office_ivr_three = "ivr/" . $after_office_ivr;
    $after_office_ivr_three = $target_directory . uniqid() . '.wav';  
    move_uploaded_file($after_office_ivrtemp, $after_office_ivr_three);
}

// Start building the update query
$update_camp = "UPDATE `compaign_list` SET 
    `compaignname` = '$campaign_name',
    `campaign_number` = '$campaign_no',
    `campaign_dis` = '$campaign_description',
    `creat_date` = '$date',
    `local_call_time` = '$local_call_time',
    `week_off` = '$week_off',
    `script_notes` = '$script_id',
    `get_call_lunch` = '$get_call_launch',
    `admin` = '$Adminuser',
    `ivr` = '$group_wise',
    `type` = '$next_agent_call'";

// Append file fields if they are set
if (!empty($welcome_ivr_one)) {
    $update_camp .= ", `welcome_ivr` = '$welcome_ivr_one'";
}
if (!empty($park_file_name_two)) {
    $update_camp .= ", `music_on_hold` = '$park_file_name_two'"; 
}
if (!empty($after_office_ivr_three)) {
    $update_camp .= ", `after_office_ivr` = '$after_office_ivr_three'";
}

// Complete the query
$update_camp .= " WHERE `id` = '$c_id'";

// die(); 
if(mysqli_query($con, $update_camp)){
    // $msg=3;
    echo '
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
    <script>
    window.onload = function() {
        Swal.fire({
            icon: "success",
            title: "Campaign Update successful",
            confirmButtonText: "OK"
        }).then(() => {
            window.location.href = "'.$admin_ind_page.'?c=campaign&v=campaign_list";
        });
    };                
    </script>';

}else{
    $msg=4;
}


}
####################################################### Working start for campaign Update #####################################
####################################################### Working start for campaign Coppy #####################################
if(isset($_POST['coppy_for_campaign'])){

     $campaign_id = $_POST['campaign_id'];
//   echo "</br>";
   $campaign_name = $_POST['campaign_name'];
//   die();
     $source_campaign_id = $_POST['source_campaign_id'];
//    echo "</br>";
    // echo $select_coppy = "SELECT * FROM compaign_list WHERE campaign_id='$source_campaign_id'";
     $select_coppy = "SELECT * FROM `compaign_list` WHERE compaign_id='$source_campaign_id'";
    // echo "</br>";
    $sel_quer2 = mysqli_query($con, $select_coppy);
    $row_camp = mysqli_fetch_assoc($sel_quer2);

    $campaign_number = $row_camp['campaign_number'];
    $campaign_dis = $row_camp['campaign_dis'];
    $status = $row_camp['status'];
    $music_on_hold = $row_camp['music_on_hold'];
    $welcome_ivr = $row_camp['welcome_ivr'];
    $after_office_ivr = $row_camp['after_office_ivr'];
    $local_call_time = $row_camp['local_call_time'];
    $week_off = $row_camp['week_off'];
    $script_notes = $row_camp['script_notes'];
    $get_call_lunch = $row_camp['get_call_lunch'];
    $ring_time = $row_camp['ring_time'];
    $agent_number = $row_camp['agent_number'];
    $type = $row_camp['type'];

    $date = date('Y-m-d H:i:s');


    $sel_d1 = "SELECT * FROM compaign_list WHERE campaign_id='$campaign_id'";
    $sel_query1 = mysqli_query($con, $sel_d1);
    if(mysqli_fetch_assoc($sel_query1) > 0){
        //    echo "<script>alert('Data already insert')</script>";
        echo '
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
        <script>
        window.onload = function() {
            Swal.fire({
                icon: "error",
                title: "This Campaign ID already exists!",
                confirmButtonText: "OK"
            }).then(() => {
                window.location.href = "'.$admin_ind_page.'?c=campaign&v=campaign_list";
            });
        };                
        </script>';
     }else{


        $ins_ddata = "INSERT INTO `compaign_list`(`compaign_id`, `compaignname`, `campaign_number`, `campaign_dis`, `creat_date`, `status`, `music_on_hold`, `welcome_ivr`, `after_office_ivr`, `local_call_time`, `week_off`, `script_notes`, `get_call_lunch`, `admin`, `ring_time`, `agent_number`, `type`) VALUES ('$campaign_id','$campaign_name','$campaign_number','$campaign_dis','$date','$status','$music_on_hold','$welcome_ivr','$after_office_ivr','$local_call_time','$week_off','$script_notes','$get_call_lunch','$Adminuser','$ring_time','$agent_number','$type')";
    //    die();
        $coppy_d_ins = mysqli_query($con, $ins_ddata);
if($coppy_d_ins){
    // echo "<script>alert('Data insert SUccess')</script>";
    echo '
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
    <script>
    window.onload = function() {
        Swal.fire({
            icon: "success",
            title: "Campaign creation successful",
            confirmButtonText: "OK"
        }).then(() => {
            window.location.href = "'.$admin_ind_page.'?c=campaign&v=campaign_list";
        });
    };                
    </script>';

}else{
    // echo "<script>alert('Data Not insert')</script>";
    echo '
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
    <script>
    window.onload = function() {
        Swal.fire({
            icon: "error",
            title: "Campaign creation failed! Please try again.",
            confirmButtonText: "OK"
        }).then(() => {
            window.location.href = "'.$admin_ind_page.'?c=campaign&v=campaign_list";
        });
    };                
    </script>';


}

     }


}
####################################################### Working start for campaign Coppy #####################################

?>
<style>
.audio-player-container {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 20px;
}

.audio-player {
    display: none;
    /* Hide the default audio player */
}

.control {
    background-color: #4CAF50;
    /* Green background */
    border: none;
    color: white;
    padding: 0px 10px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 12px;
    margin: 1px 0.5px;
    cursor: pointer;
    border-radius: 8px;
    /* Rounded corners */
    transition: background-color 0.3s ease;
}

.control:hover {
    background-color: #2718d6;
    /* Darker green on hover */
}

.control:focus {
    outline: none;
}

#play-pause-icon {
    font-size: 10px;
}
</style>

<!--  -->
<div>
    <div class="show-users">
        <!-- this is the top navbar that containes add user, copy user, time sheet and search option -->
        <?php

     if($msg==1){
         echo '<div class="alert alert-success alert-dismissible ml-5">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Success!</strong> Data Insert Succefull.
                          </div>';
     }elseif($msg==2){
         echo '<div class="alert alert-danger alert-dismissible ml-5">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Failed!</strong> Data Insert Failed.
                          </div>';
     }elseif($msg==3){
        echo '<div class="alert alert-success alert-dismissible ml-5">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success!</strong> Data Update Succefull.
      </div>';
     }elseif($msg==4){
        echo '<div class="alert alert-danger alert-dismissible ml-5">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Failed!</strong> Data Update Failed.
      </div>';
     }
     ?>
        <div class="my-nav">
            <ul>
                <!-- <li>
                    <a class="nav-active" href="#add-user" data-toggle="modal" data-target="#add-user"><i
                            class="fa fa-plus-circle" aria-hidden="true"></i>
                        Add New Campaign</a>
                </li>
                <li>
                    <a href="#copy-user" data-toggle="modal" data-target="#copy-user"><i class="fa fa-clone"
                            aria-hidden="true"></i> Copy Campaign</a>
                </li> -->
                <!-- <li>
                    <input type="search" placeholder="Search" name="search" id="search-user">
                </li> -->
            </ul>
        </div>
        <!-- this is where top navbar ends -->

        <!-- user list table start -->
        <div class="table-responsive my-table">
            <div class="table-top">
                <h4>Campaign List</h4>
                <div class="my-filter-dropdown">
                    <div class="dropdown">
                        <button class="btn btn-secondary" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <img src="../../assets/images/common-icons/filter_list.png" alt="">
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">
                                <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M16.5 15.5C18.22 15.5 20.25 16.3 20.5 16.78V17.5H12.5V16.78C12.75 16.3 14.78 15.5 16.5 15.5M16.5 14C14.67 14 11 14.92 11 16.75V19H22V16.75C22 14.92 18.33 14 16.5 14M9 13C6.67 13 2 14.17 2 16.5V19H9V17.5H3.5V16.5C3.5 15.87 6.29 14.34 9.82 14.5A5.12 5.12 0 0 1 11.37 13.25A12.28 12.28 0 0 0 9 13M9 6.5A1.5 1.5 0 1 1 7.5 8A1.5 1.5 0 0 1 9 6.5M9 5A3 3 0 1 0 12 8A3 3 0 0 0 9 5M16.5 8.5A1 1 0 1 1 15.5 9.5A1 1 0 0 1 16.5 8.5M16.5 7A2.5 2.5 0 1 0 19 9.5A2.5 2.5 0 0 0 16.5 7Z" />
                                </svg>
                                </i> All</a>
                            <a class="dropdown-item" href="#">
                                <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M21.1,12.5L22.5,13.91L15.97,20.5L12.5,17L13.9,15.59L15.97,17.67L21.1,12.5M11,4A4,4 0 0,1 15,8A4,4 0 0,1 11,12A4,4 0 0,1 7,8A4,4 0 0,1 11,4M11,6A2,2 0 0,0 9,8A2,2 0 0,0 11,10A2,2 0 0,0 13,8A2,2 0 0,0 11,6M11,13C11.68,13 12.5,13.09 13.41,13.26L11.74,14.93L11,14.9C8.03,14.9 4.9,16.36 4.9,17V18.1H11.1L13,20H3V17C3,14.34 8.33,13 11,13Z" />
                                </svg>
                                Active</a>
                        </div>
                    </div>
                </div>
            </div>
            <table class="all-user-table table table-hover">
                <thead>
                    <tr>
                        <th scope="col"><a href="#">CAMP ID</a></th>
                        <th scope="col"><a href="#">NAME</a></th>
                        <th scope="col"><a href="#">ACTIVE</a></th>
                        <th scope="col"><a href="#">CAMP No.</a></th>
                        <th scope="col">CALL TIME</th>
                        <th scope="col">WEEK OFF</th>
                        <th scope="col">WEL. IVR</th>
                        <th scope="col">AFTER IVR</th>
                        <th scope="col">PARK MUSIC</th>
                        <th scope="col">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                while ($row = mysqli_fetch_assoc($reslut)) {
                    $group_ivr = $row['ivr'];

                    echo ' <tr>';
                    echo "<td><a>" . $row['compaign_id'] . "</a></td>";
                    echo "<td>" . $row['compaignname'] . "</td>";
                    ?>
                    <td>
                        <a href="pages/new_action/camp_status_edit.php?id=<?= $row['id'] ?>">
                            <?php 
                  if($row['status'] == 'Y'){
                  echo '<span class="active-yes cursor_p">' . 'Active' . '</span>';
                  } else {
                   echo '<span class="active-no cursor_p">' . 'Inactive' . '</span>';
                     }
                      ?>
                        </a>
                    </td>
                    <?php
                    echo "<td>" . $row['campaign_number'] . "</td>";
                    echo "<td>" . $row['local_call_time'] . "</td>";
                    echo "<td>" . $row['week_off'] . "</td>";
                    // echo "<td>" . $row['welcome_ivr'] . "</td>";
                      if(empty($row['welcome_ivr'])){
                      echo '<td>Empty</td>';
                      }else{
                        echo '<td>
                        <audio class="audio-player" id="myTune">
                        <source src="/'.$main_folder.'/admin/' . $row['welcome_ivr'] . '" type="audio/wav">
                  
                        </audio>
                        <button class="control" type="button" onclick="aud_play_pause(this.previousElementSibling)">
                                    <span id="play-pause-icon" style="color:green;">▶</span>
                                 </button>

                    </td>';

                      }
                  
                      if(empty($row['after_office_ivr'])){
                        echo '<td>Empty</td>';
                        }else{
                
                echo '<td>
                <audio class="audio-player" id="myTune">
                <source src="/'.$main_folder.'/admin/' . $row['after_office_ivr'] . '" type="audio/wav">
          
                </audio>
                <button class="control" type="button" onclick="aud_play_pause(this.previousElementSibling)">
                            <span id="play-pause-icon" style="color:green;">▶</span>
                        </button>
            </td>';
                        }
                        
                        if(empty($row['music_on_hold'])){
                            echo '<td>Empty</td>';
                            }else{
            echo '<td>
            <audio class="audio-player" id="myTune">
            <source src="/'.$main_folder.'/admin/' . $row['music_on_hold'] . '" type="audio/wav">
      
            </audio>
            <button class="control" type="button" onclick="aud_play_pause(this.previousElementSibling)">
                        <span id="play-pause-icon" style="color:green;">▶</span>
                    </button>
        </td>';
                            }

?>
                    <td>
                        <!-- <a class='contact_add text-primary cursor_p' data-id="<?= $row['id'] ?>" data-toggle='modal'
                            data-target='#update_camp'><i class="fa fa-pencil-square"
                                style="font-size:20px; color:blue;"></i></a>
                        <i class="fa fa-trash cursor_p text-danger show_break_report" data-id="<?= $row['id'] ?>"
                            title='You can click here to see why users take breaks' style="font-size:20px;"></i> -->
                        <?php if($group_ivr == '1'){ ?>
                        <img src="../assets/images/common-icons/assign_agent.png" alt="add_icon"
                            style="height:20px; width:27px;" class="cursor_p group_wised mb-2" data-id="<?= $row['id'] ?>"
                            title='This Campaign Activate Group vaise call'>
                    </td>
                    </tr>
                    <?php  } } ?>

                </tbody>
            </table>
        </div>
        <!-- user list table ends -->
        <?php
require 'modals.php';
?>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $(document).on("click", ".contact_add", function() {
        var cnumber = $(this).data("id");

        // Clear the fields before making the request
        $("#real_id").val("");
        $("#campaign_id").val("");
        $("#campaign_name").val("");
        $("#campaign_description").val("");
        $("#campaign_no").val("");
        $("#local_call_time").val("");
        $("#active-radio-one").val("");
        $("#week_off").val("");
        $("#script_id").val("");
        $("#get_call_launch").val("");
        $("#group_wise_new").val("");

        $.ajax({
            url: "pages/new_action/get_camp.php",
            type: "POST",
            data: {
                cnumber: cnumber
            },
            dataType: "json", // Expect JSON response
            success: function(response) {
                // Check if response is not empty
                if ($.isEmptyObject(response)) {
                    console.log("No data found");
                } else {
                    // Populate the fields with the response
                    $("#real_id").val(response.id);
                    $("#campaign_id_new").val(response.compaign_id);
                    $("#campaign_name_new").val(response.compaignname);
                    $("#campaign_description_new").val(response.campaign_dis);
                    // alert(response.campaign_dis);
                    $("#campaign_no_new").val(response.campaign_number);

                    // $("#active-radio-one").val(response.status);
                    if (response.status === 'Y') {
                        $("#active-radio-one_new").prop("checked", true);
                    } else if (response.status === 'N') {
                        $("#active-radio-two_new").prop("checked", true);
                    }

                    $("#local_call_time_new").val(response.local_call_time);
                    $("#week_off_new").val(response.week_off);
                    $("#script_id_new").val(response.script_notes);
                    $("#get_call_launch_new").val(response.get_call_lunch);
                    $("#group_wise_new").val(response.ivr);
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    });
});
</script>
<script>
$(document).ready(function() {
    $(document).on("click", ".show_break_report", function() {
        var id = $(this).data("id");
        // alert(id);
        Swal.fire({
            title: "Are you sure?",
            text: "This data is delete",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "pages/new_action/campaign_delete.php?id=" +
                    id // Redirect to block.php with the 'id' query string
            }
        });
    });

});
</script>

<script>
$(document).ready(function() {
    $(document).on("click", ".group_wised", function() {
        var id = $(this).data("id");
        window.location.href = "?c=user_group&v=show_user_group&id=" + id;
    });
});
</script>

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

