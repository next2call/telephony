<?php
session_start();
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// $Adminuser = $_SESSION['user'] ?? '8888';
$user_level = $_SESSION['user_level'];
include "../../../conf/db.php";
include "../../../conf/Get_time_zone.php";

$filter = $_GET['filter_data'] ?? '';
// $date = '2024-08-16'; // Adjust if you need a dynamic date
$date = date("Y-m-d");

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

if ($user_level == 2) {

    $Adminuser = $_SESSION['admin'];
    //    echo "</br>";

    $new_user = $_SESSION['user'];
    //    echo "</br>";
    $campaign_id = $_SESSION['campaign_id'];
    //    echo "</br>";

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

$condition = "DATE(break_time.start_time) = '$date'";
$condition_one = "WHERE 1=1";
if ($user_level == 2) {
    $condition_one = "WHERE campaign_Id='$campaign_id'";
    $condition_two = "users.admin = '$Adminuser' AND users.user_id != '$new_user' AND users.campaigns_id='$campaign_id' AND";
} elseif ($user_level == 9) { 
    $condition_two = "";
} elseif ($user_level == 6 || $user_level == 7) { 
    $admin = $_SESSION['admin'];
    $condition_two = "users.admin = '$admin' AND";
} else { 
    $condition_two = "users.admin = '$Adminuser' AND";

}



// User query
$user_q = "SELECT 
    SUM(status = 'Answer') AS in_call_agents,
    SUM(CASE WHEN (status = 'Ringing' OR Agent = 'NOAGENT') AND direction = 'inbound' THEN 1 ELSE 0 END) AS call_queue_agents,
    SUM(CASE WHEN status = 'Ringing'  AND direction = 'outbound' THEN 1 ELSE 0 END) AS call_dial_agents
    FROM live $condition_one";
// echo "</br>";
$userResult = mysqli_query($con, $user_q);

if ($userResult === false) {
    echo json_encode(['error' => 'User query failed: ' . mysqli_error($con)]);
    exit;
}

$userRow = mysqli_fetch_assoc($userResult);

// Main query
  $query = "SELECT 
    COUNT(DISTINCT CASE WHEN break_time.status = '2' OR break_time.status = '1' AND login_log.status = '1' AND login_log.admin != '$Adminuser' THEN break_time.user_name ELSE NULL END) AS login_agents, 
    COUNT(DISTINCT CASE WHEN break_time.break_status = '2' AND break_time.status = '2' THEN break_time.user_name ELSE NULL END) AS idle_agents, 
    COUNT(DISTINCT CASE WHEN break_time.break_status = '1' THEN break_time.user_name ELSE NULL END) AS pause_agents,
    MAX(break_time.start_time) AS max_break_time
    FROM users 
    JOIN login_log ON users.user_id = login_log.user_name 
    LEFT JOIN break_time ON break_time.user_name = users.user_id 
    WHERE $condition_two $condition";


// echo "</br>";


$result = mysqli_query($con, $query);

if ($result === false) {
    echo json_encode(['error' => 'Main query failed: ' . mysqli_error($con)]);
    exit;
}

$summary = mysqli_fetch_assoc($result);


// $alive = $summary['idle_agents'] - $userRow['in_call_agents'] - $summary['pause_agents'];
$alive = max(0, $summary['idle_agents'] - $userRow['in_call_agents'] - $summary['pause_agents']);

$response = [
    'in_call_agents' => $userRow['in_call_agents'],
    'call_queue_agents' => $userRow['call_queue_agents'],
    'call_dial_agents' => $userRow['call_dial_agents'],
    'login_agents' => $summary['login_agents'],
    'idle_agents' => $alive,
    'pause_agents' => $summary['pause_agents'],
    'max_break_time' => $summary['max_break_time'],
];

echo json_encode($response);
?>