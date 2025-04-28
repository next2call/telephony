<?php 
require '../conf/db.php';
date_default_timezone_set('America/New_York'); // Set the timezone to Eastern Time

session_start();
if (!$_SESSION['user_level'] == 1) {
    header('location:../');
}

$user = $_SESSION['user'];


$sel_lavel ="SELECT * FROM users WHERE user_id='$user'";   
$qur_laval = mysqli_query($con, $sel_lavel);
$row_lavel = mysqli_fetch_assoc($qur_laval);
$login_u_lavel = $row_lavel['user_type'];
$login_u_admin = $row_lavel['admin'];
$user_campaigns_id = $row_lavel['campaigns_id'];

if($login_u_lavel == '1'){

    $get_user = $login_u_admin;

    $conditopn = " AND (campaign_id = '$user_campaigns_id' OR campaign_id = ' ')";

}else{
    $get_user = $user;

    $conditopn = " AND '1=1'";
}

$sel ="SELECT * FROM dispo WHERE status='1' AND admin='$get_user' $conditopn";   
        $qur = mysqli_query($con, $sel);
       if (mysqli_num_rows($qur) > 0) {
    while($get = mysqli_fetch_array($qur))
        {

            $arr[] = ['id'=>$get['id'],'dispo'=>$get['dispo'],'admin'=>$get['admin'],'ins_date'=>$get['ins_date'],'status'=>$get['status']];            
        }
        echo json_encode($arr);
       
}else{
 $arr = '';
     echo json_encode($arr);
}

?>