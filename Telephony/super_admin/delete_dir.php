<?php
require '../conf/db.php';
require '../conf/url_page.php';

if(isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    $type = $_REQUEST['type'];
    $old_file_name = $_REQUEST['file_name'];
     $sel_cam_l = "SELECT * FROM `texttospeech` WHERE file_name='$old_file_name'";
     $sql_cam_l = mysqli_query($con, $sel_cam_l);
     
     $sel = "SELECT * FROM `texttospeech` WHERE id='$id'";
     $sql = mysqli_query($con, $sel);
     $row = mysqli_fetch_assoc($sql);
     $path = $row['file_name'];
     $campaign = $row['campaign_name'];
      // $without_ivr_directory_path = str_replace('ivr/', '', $path);
    //  $path = 'ivr/667536294f050/667536294f050.wav';
    
     if ($type == 'moh' && mysqli_num_rows($sql_cam_l) < 2) {
        if (file_exists($path)) {
            unlink($path);
        }
        $parent_dir = dirname($path);
        if (is_dir($parent_dir)) {
            $files = array_diff(scandir($parent_dir), array('.', '..'));
            if (empty($files)) {
                rmdir($parent_dir);
                $msg = 'Directory deleted successfully';
            } else {
                $msg = 'Directory not empty';
            }
        } else {
            $msg = 'Parent directory does not exist';
        }
        if(!empty($campaign)){
        $up_ivr_cam = "UPDATE compaign_list SET music_on_hold='' WHERE compaign_id='$campaign'";
        mysqli_query($con, $up_ivr_cam);
        }
    } 
     $usersql2 = "DELETE FROM `texttospeech` WHERE id='$id'"; 
    $usersresult = mysqli_query($con, $usersql2);
    echo $parent_dir." , ".$msg;
   if($usersresult){
    header("Location:".$admin_ind_page."?c=dashboard&v=ivr_converter");
}else{
    header("location:".$admin_ind_page."?c=dashboard&v=ivr_converter");
   }
} else {
    header("location:".$admin_ind_page."?c=dashboard&v=ivr_converter");
}
?>