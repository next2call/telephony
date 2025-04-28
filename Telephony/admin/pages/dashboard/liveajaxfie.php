<?php 
session_start();
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
include "../../../conf/db.php";
include "../../../conf/Get_time_zone.php";

// Check if user is set in the session
if (!isset($_SESSION['user'])) {
    die("User not logged in");
}


$user = $_SESSION['user'];

$user_level = $_SESSION['user_level'];

if ($user_level == 9) { 
    $new_condition = "1=1";
    $sel = "SELECT 
                live.Agent, 
                live.time, 
                live.direction, 
                live.status, 
                live.call_from, 
                live.call_to, 
                live.admin, 
                compaign_list.compaignname 
            FROM 
                `live` 
            JOIN 
                compaign_list ON compaign_list.compaign_id = live.campaign_Id
            WHERE 
               $new_condition
            ORDER BY 
                live.time DESC"; 
    $stmt = $con->prepare($sel);
} else if ($user_level == 2 || $user_level == 6 || $user_level == 7) { 
    $admin = $_SESSION['admin'];
    $new_condition = "compaign_list.admin = ?";
    $sel = "SELECT 
                live.Agent, 
                live.time, 
                live.direction, 
                live.status, 
                live.call_from, 
                live.call_to, 
                live.admin, 
                compaign_list.compaignname 
            FROM 
                `live` 
            JOIN 
                compaign_list ON compaign_list.compaign_id = live.campaign_Id
            WHERE 
               $new_condition
            ORDER BY 
                live.time DESC"; 
    $stmt = $con->prepare($sel);
    $stmt->bind_param("s", $admin);
} else { 
    $new_condition = "compaign_list.admin = ?";
    $sel = "SELECT 
                live.Agent, 
                live.time, 
                live.direction, 
                live.status, 
                live.call_from, 
                live.call_to, 
                live.admin, 
                compaign_list.compaignname 
            FROM 
                `live` 
            JOIN 
                compaign_list ON compaign_list.compaign_id = live.campaign_Id
            WHERE 
               $new_condition
            ORDER BY 
                live.time DESC"; 
    $stmt = $con->prepare($sel);
    $stmt->bind_param("s", $user); // Assuming $user is set for admins
}

$stmt->execute();
$result = $stmt->get_result();

$arr = [];

// Function to convert the DateInterval to total seconds
function intervalToSeconds($interval) {
    return ($interval->days * 24 * 60 * 60) +
           ($interval->h * 60 * 60) +
           ($interval->i * 60) +
           $interval->s;
}

// Function to convert total seconds to HH:MM:SS format
function secondsToTime($seconds) {
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    $seconds = $seconds % 60;
    return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
}

if ($result->num_rows > 0) {
    while($get = $result->fetch_assoc()) {
        // Convert the given time to a DateTime object
        $start_time = new DateTime($get['time']);

        // Get the current time
        $current_time = new DateTime();

        // Calculate the difference
        $interval = $start_time->diff($current_time);

        // Calculate the total seconds of the interval
        $total_seconds = intervalToSeconds($interval);

        // Convert the total seconds to HH:MM:SS format
        $time_in_seconds_format = secondsToTime($total_seconds);

        if ($get['Agent'] == 'NOAGENT') {
            $arr[] = [
                'Agent' => $get['Agent'],
                'Full_name' => Null,
                'admin' => $get['admin'],
                'time' => $get['time'],
                'time_in_seconds' => $time_in_seconds_format, // Added duration from start time to current time in HH:MM:SS
                'direction' => $get['direction'],
                'status' => 'QUEUE', // Fixed status for NOAGENT
                'call_from' => $get['call_from'],
                'call_to' => $get['call_to'],
                'compaignname' => $get['compaignname']
            ];
        } else {
            // Fetch the agent full name if Agent is not 'NOAGENT'
            $userSel = "SELECT full_name FROM users WHERE user_id = ? OR ext_number = ?";
            $userStmt = $con->prepare($userSel);
            $userStmt->bind_param("ss", $get['Agent'], $get['Agent']);
            $userStmt->execute();
            $userResult = $userStmt->get_result();
            if ($userResult->num_rows > 0) {
                $userRow = $userResult->fetch_assoc();
                $full_name = $userRow['full_name'];
            } else {
                $full_name = Null;
            }

            // Now you can use $time_in_seconds_format in your array
            $arr[] = [
                'Agent' => $get['Agent'],
                'Full_name' => $full_name,
                'admin' => $get['admin'],
                'time' => $get['time'],
                'time_in_seconds' => $time_in_seconds_format, // Added duration from start time to current time in HH:MM:SS
                'direction' => $get['direction'],
                'status' => $get['status'],
                'call_from' => $get['call_from'],
                'call_to' => $get['call_to'],
                'compaignname' => $get['compaignname']
            ];
            $userStmt->close();
        }
    }
}

echo json_encode($arr);

// Close the connection
$stmt->close();
$con->close();
?>
