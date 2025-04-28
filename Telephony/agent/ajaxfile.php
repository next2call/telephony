<?php 
require '../conf/db.php';
session_start();
date_default_timezone_set('America/New_York'); // Set the timezone to Eastern Time

if (!isset($_SESSION['user_level']) || $_SESSION['user_level'] != 1) {
    header('location:../');
    exit();
}

$sql = "SELECT * FROM vicidial_users WHERE user_id =" . $_SESSION['user_id'];
$result = mysqli_query($conn, $sql);
$users = mysqli_fetch_assoc($result);
$user = $_SESSION['user'];

$sel = "SELECT * FROM live WHERE Agent='$user' OR extension='$user'";
$qur = mysqli_query($con, $sel);
$arr = [];

if (mysqli_num_rows($qur) > 0) {
    while ($get = mysqli_fetch_array($qur)) {
         $uniqueid = $get['uniqueid'];
         $upload_data = "SELECT * FROM `upload_data` WHERE uniqueid='$uniqueid'";
         $qur_data = mysqli_query($con, $upload_data);
         $row = mysqli_fetch_assoc($qur_data);
         $company_name = $row['company_name'];
         $industry = $row['industry'];
         $country = $row['country'];
         $city = $row['city'];
         $department = $row['department'];
         $designation = $row['designation'];
         $email = $row['email'];
         $name = $row['name'];
         $phone_number = $row['phone_number'];
         $phone_2 = $row['phone_2'];
         $phone_3 = $row['phone_3'];
         $username = $row['username'];
         $admin = $row['admin'];
         $ins_date = $row['ins_date'];
         $dial_status = $row['dial_status'];
         $list_id = $row['list_id'];
         $campaign_Id = $row['campaign_Id'];
        $arr[] = [
            'uniqueid' => $get['uniqueid'],
            'extension' => $get['extension'],
            'direction' => $get['direction'],
            'company_name' => $company_name,
            'industry' => $industry,
            'country' => $country,
            'city' => $city,
            'department' => $department,
            'designation' => $designation,
            'email' => $email,
            'name' => $name,
            'phone_number' => $phone_number,
            'phone_2' => $phone_2,
            'phone_3' => $phone_3,
            'username' => $username,
            'ins_date' => $ins_date,
            'dial_status' => $dial_status,
            'list_id' => $list_id,
            'campaign_Id' => $campaign_Id,
        ];
    }
}

echo json_encode($arr);
?>
