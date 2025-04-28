<?php
session_start();
include "../../../conf/db.php";
include "../../../conf/Get_time_zone.php";
// $Adminuser = $_SESSION['user'];
$user_level = $_SESSION['user_level'];
$filter = $_REQUEST['filter_data'] ?? '';
$date = date("Y-m-d");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($user_level == 2) {
    $Adminuser = $_SESSION['admin'];
    $new_user = $_SESSION['user'];
    $campaign_id = $_SESSION['campaign_id'];
    $user_sql2 = "SELECT compaign_id, campaign_number FROM compaign_list WHERE compaign_id='$campaign_id'";
    $user_query = mysqli_query($con, $user_sql2);
    if (!$user_query) {
        die("Query Failed: " . mysqli_error($con));
    }
    $row_compain = mysqli_fetch_assoc($user_query);
    $new_camp_num = $row_compain['campaign_number'];
} else {
    $Adminuser = $_SESSION['user'];
}

//   echo "</br>";

if ($filter == 'today') {
    $condition = "AND start_time LIKE '%$date%'";
} elseif ($filter == 'all') {
    $condition = "";
} else {
    $condition = "AND start_time LIKE '%$date%'";
}

if ($user_level == 2) {
    $new_condition = "admin = '$Adminuser' AND did='$new_camp_num'";
} elseif ($user_level == 9) {
    $new_condition = "1=1";
} elseif ($user_level == 6 || $user_level == 7) {
    $admin = $_SESSION['admin'];
    $new_condition = "admin = '$admin' AND 1=1";
} else {
    $new_condition = "admin = '$Adminuser' AND 1=1";
}


$query = "SELECT 
        COUNT(*) AS total_call,
        SUM(CASE WHEN status = 'ANSWER' THEN 1 ELSE 0 END) AS answer_call,
        SUM(CASE WHEN status = 'CANCEL' THEN 1 ELSE 0 END) AS cancel_call,
        SUM(CASE WHEN status = 'NOANSWER' THEN 1 ELSE 0 END) AS NOANSWER,
        SUM(CASE WHEN status != 'ANSWER' AND status != 'CANCEL' THEN 1 ELSE 0 END) AS congestion_call,
        SUM(CASE WHEN direction = 'outbound' THEN 1 ELSE 0 END) AS outbound_call,
        SUM(CASE WHEN direction = 'inbound' THEN 1 ELSE 0 END) AS inbound_call
    FROM cdr
    WHERE $new_condition";
// echo '</br>';

$result = mysqli_query($con, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);

    $total_call = $row['total_call'];
    $answer_call = $row['answer_call'];
    $cancel_call = $row['cancel_call'];
    $noanswer_call = $row['NOANSWER'];
    $congestion_call = $row['congestion_call'];
    $outbound_call = $row['outbound_call'];
    $inbound_call = $row['inbound_call'];

    $response = [
        'total_call' => $total_call,
        'answer_call' => $answer_call,
        'cancel_call' => $cancel_call,
        'noanswer_call' => $noanswer_call,
        'congetion_call' => $congestion_call,
        'outbond_call' => $outbound_call,
        'Inbond_call' => $inbound_call
    ];

    echo json_encode($response);
} else {
    echo json_encode(['error' => 'Query failed']);
}




?>