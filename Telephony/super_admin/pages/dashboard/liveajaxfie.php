<?php 
session_start();

$user = $_SESSION['user'];

$con = new mysqli("localhost", "cron", "1234", "vicidial_master");

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Fetch all user IDs where SuperAdmin is the current user
$sel = "SELECT user_id FROM `users` WHERE SuperAdmin = ?";
$stmt = $con->prepare($sel);
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();
$admin_user = [];

while ($rowu = $result->fetch_assoc()) {
    $admin_user[] = $rowu['user_id'];
}

$stmt->close();

if (count($admin_user) > 0) {
    // Prepare the IN clause
    $placeholders = implode(',', array_fill(0, count($admin_user), '?'));
    $types = str_repeat('s', count($admin_user));

    $sel = "SELECT 
                live.Agent, 
                live.time, 
                live.direction, 
                live.status, 
                live.call_from, 
                live.admin,
                compaign_list.compaignname 
            FROM `live`  
            JOIN compaign_list ON compaign_list.campaign_number = live.did
            WHERE compaign_list.admin IN ($placeholders)
            ORDER BY live.time DESC";

    $stmt = $con->prepare($sel);
    $stmt->bind_param($types, ...$admin_user);
    $stmt->execute();
    $result = $stmt->get_result();

    $arr = [];
    if ($result->num_rows > 0) {
        while ($get = $result->fetch_assoc()) {
            $get_agent = $get['Agent'];
            $call_status = ($get_agent == 'NOAGENT') ? 'QUEUE' : $get['status'];

            if ($get_agent == 'NOAGENT') {
                $arr[] = [
                    'Agent' => $get['Agent'],
                    'Full_name' => 'N/A',
                    'admin' => $get['admin'],
                    'time' => $get['time'],
                    'direction' => $get['direction'],
                    'status' => $call_status,
                    'call_from' => $get['call_from'],
                    'compaignname' => $get['compaignname']
                ];
            } else {
                // Fetch the agent full name if Agent is not 'NOAGENT'
                $userSel = "SELECT full_name FROM users WHERE user_id = ? OR ext_number = ?";
                $userStmt = $con->prepare($userSel);
                $userStmt->bind_param("ss", $get_agent, $get_agent);
                $userStmt->execute();
                $userResult = $userStmt->get_result();
                $userRow = $userResult->fetch_assoc();
                $full_name = $userRow['full_name'];

                $arr[] = [
                    'Agent' => $get['Agent'],
                    'Full_name' => $full_name,
                    'admin' => $get['admin'],
                    'time' => $get['time'],
                    'direction' => $get['direction'],
                    'status' => $call_status,
                    'call_from' => $get['call_from'],
                    'compaignname' => $get['compaignname']
                ];

                $userStmt->close();
            }
        }
    }

    echo json_encode($arr);

    $stmt->close();
} else {
    echo json_encode([]);
}

$con->close();
?>
