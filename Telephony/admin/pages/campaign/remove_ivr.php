<?php
session_start();
$user_level = $_SESSION['user_level'];

if($user_level == 2){
    $Adminuser = $_SESSION['admin'];
    $new_user = $_SESSION['user'];
} else {
    $Adminuser = $_SESSION['user'];
}
include "../../../conf/db.php";
include "../../../conf/url_page.php";

$main_id = $_POST['id']; 

if (isset($_POST['welcome_vr']) && ($_POST['welcome_vr'] == 'remove')) {
 $welcome_vr = $_POST['welcome_vr'];
$update_1="UPDATE `compaign_list` SET `welcome_ivr`='' WHERE `id`='$main_id'";
mysqli_query($con, $update_1);

}
// die();
if (isset($_POST['after_office_ivr']) && ($_POST['after_office_ivr'] == 'remove')) {
    $after_office_ivr = $_POST['after_office_ivr'];
    $update_2="UPDATE `compaign_list` SET `after_office_ivr`='' WHERE `id`='$main_id'";
    mysqli_query($con, $update_2);

    }

    if (isset($_POST['park_music_ivr']) && ($_POST['park_music_ivr'] == 'remove')) {
        $park_music_ivr = $_POST['park_music_ivr'];
        $update_3="UPDATE `compaign_list` SET `music_on_hold`='' WHERE `id`='$main_id'";
        mysqli_query($con, $update_3);
        }

        if (isset($_POST['no_agent_ivr']) && ($_POST['no_agent_ivr'] == 'remove')) {
            $no_agent_ivr = $_POST['no_agent_ivr'];
            $update_4="UPDATE `compaign_list` SET `no_agent_ivr`='' WHERE `id`='$main_id'";
            mysqli_query($con, $update_4);
            }

            if (isset($_POST['ringtone_ivr']) && ($_POST['ringtone_ivr'] == 'remove')) {
                $ringtone_ivr = $_POST['ringtone_ivr'];
                $update_5="UPDATE `compaign_list` SET `ring_tone_music`='' WHERE `id`='$main_id'";
                mysqli_query($con, $update_5);
                }

                if (isset($_POST['week_off_ivr']) && ($_POST['week_off_ivr'] == 'remove')) {
                    $week_off_ivr = $_POST['week_off_ivr'];
                    $update_6="UPDATE `compaign_list` SET `week_off_ivr`='' WHERE `id`='$main_id'";
                    mysqli_query($con, $update_6);
                    }

                // if (isset($_POST['id'])) {
                //     $main_id = $_POST['id']; 

                //                         $update="UPDATE `compaign_list` SET `music_on_hold`='',`welcome_ivr`='',`after_office_ivr`='',`week_off_ivr`='',`ring_tone_music`='',`no_agent_ivr`='' WHERE `id`='$main_id'";
                //                        $sel_query = mysqli_query($con, $update);

                //                        if($sel_query){
                                //    header('https://103.113.27.163/Telephony/admin/index.php?c=campaign&v=campaign_list#');
                                // echo "ok";
                                //        }else{
                                //         echo 'no'; 
                                        // header('https://103.113.27.163/Telephony/admin/index.php?c=campaign&v=campaign_list#');

                    //                    }
                    // }


    ?>