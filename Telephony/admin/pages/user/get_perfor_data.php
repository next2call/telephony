<?php
session_start();
include "../../../conf/db.php";
include "../../../conf/Get_time_zone.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['user_level'])) {
    die(json_encode(['error' => 'Session expired or invalid session data']));
}

$user_level = $_SESSION['user_level'];
$filter = $_REQUEST['filter_data'] ?? '';
$date = date("Y-m-d");
$condition = "1=1";
// $condition = ($filter === 'all') ? '' : "AND DATE(start_time) = '$date'";

// Determine user-specific conditions
$Adminuser = $_SESSION['user'] ?? null;
$new_camp_num = null;

if ($user_level == 2) {
    $Adminuser = $_SESSION['admin'] ?? null;
    $campaign_id = $_SESSION['campaign_id'] ?? null;

    if ($campaign_id) {
        $stmt = $con->prepare("SELECT compaign_id, campaign_number FROM compaign_list WHERE compaign_id = ?");
        $stmt->bind_param("s", $campaign_id);
        $stmt->execute();
        $row_compain = $stmt->get_result()->fetch_assoc();
        $new_camp_num = $row_compain['campaign_number'] ?? null;
    }
}

// Build the `new_condition`
switch ($user_level) {
    case 2:
        $new_condition = "admin = '$Adminuser' AND did = '$new_camp_num'";
        break;
    case 9:
        $new_condition = "1=1";
        break;
    case 6:
    case 7:
        $admin = $_SESSION['admin'] ?? null;
        $new_condition = "admin = '$admin' AND 1=1";
        break;
    default:
        $new_condition = "admin = '$Adminuser' AND 1=1";
        break;
}

// Fetch agent IDs
$tfnsel_1 = $con->prepare("SELECT user_id FROM users WHERE admin = ?");
$tfnsel_1->bind_param("s", $Adminuser);
$tfnsel_1->execute();
$result = $tfnsel_1->get_result();

$agent_ids = [];
while ($user_row = $result->fetch_assoc()) {
    $agent_ids[] = $user_row['user_id'];
}
$tfnsel_1->close();

if (empty($agent_ids)) {
    echo json_encode(['error' => 'No agents found']);
    exit;
}

$agent_ids_str = implode("','", $agent_ids);

// Main query
$query = "
    SELECT 
        COUNT(*) AS Total_Calls,
        SUM(CAST(agent_remark AS DECIMAL)) AS Total_Remarks,
        (SUM(CAST(agent_remark AS DECIMAL)) / (COUNT(*) * 10) * 100) AS Percentage_Remarks
    FROM cdr 
    WHERE status = 'ANSWER' 
      AND (call_from IN ('$agent_ids_str') OR call_to IN ('$agent_ids_str')) 
      AND agent_remark != ''
      AND $condition
    ORDER BY Total_Calls DESC";

$result = mysqli_query($con, $query);

if ($result && $row = mysqli_fetch_assoc($result)) {
    $response = [
        'Total_Calls' => $row['Total_Calls'] ?? 0,
        'Total_Remarks' => $row['Total_Remarks'] ?? 0,
        'Percentage_Remarks' => $row['Percentage_Remarks'] ?? 0.0
    ];
    echo json_encode($response);
} else {
    echo json_encode(['error' => 'Query failed or no data found']);
}

?>
