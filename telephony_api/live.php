<?php
include "db.php";
include "time_zone.php";
// date_default_timezone_set('America/New_York'); // Set the timezone to Eastern Time

$date = date("Y-m-d H:i:s"); // Get the current date and time

// Sanitize input parameters
$uniqueid = filter_input(INPUT_GET, 'uniqueid', FILTER_SANITIZE_STRING);
$did = filter_input(INPUT_GET, 'did', FILTER_SANITIZE_STRING);
$call_to = filter_input(INPUT_GET, 'call_to', FILTER_SANITIZE_STRING);
$call_from = filter_input(INPUT_GET, 'call_from', FILTER_SANITIZE_STRING);
$Agent = filter_input(INPUT_GET, 'Agent', FILTER_SANITIZE_STRING);
$direction = filter_input(INPUT_GET, 'direction', FILTER_SANITIZE_STRING);
$status = filter_input(INPUT_GET, 'status', FILTER_SANITIZE_STRING);

if ($uniqueid && $status) {
    // Select user based on DID number or Agent
    $stmtuser = $conn->prepare("SELECT * FROM `users` WHERE use_did = ? OR user_id = ?");
    $stmtuser->bind_param('ss', $did, $Agent);

    if ($stmtuser->execute()) {
        $seluserResult = $stmtuser->get_result();
        $userdid = $seluserResult->fetch_assoc();

        $admin = $userdid['admin'] ?? null;
        $full_name = $userdid['full_name'] ?? null;
        $campaigns_id = $userdid['campaigns_id'] ?? null;

        $stmtuser->close();

        if (empty($admin)) {
            // Select campaign based on campaign number if admin not found
            $stmtcampaign = $conn->prepare("SELECT * FROM `compaign_list` WHERE campaign_number = ?");
            $stmtcampaign->bind_param('s', $did);

            if ($stmtcampaign->execute()) {
                $selcampaignResult = $stmtcampaign->get_result();
                $usercampaign = $selcampaignResult->fetch_assoc();

                $admin = $usercampaign['admin'] ?? null;
                $full_name = $Agent;
                $campaigns_id = $usercampaign['compaign_id'] ?? null;

                $stmtcampaign->close();
            } else {
                error_log("Execute failed: " . $stmtcampaign->error);
                echo "Error: Unable to execute campaign query.";
                exit;
            }
        }

        switch ($status) {
            case 'Ringing':
                handleRinging($conn, $uniqueid, $did, $call_to, $call_from, $Agent, $admin, $date, $direction, $status, $full_name, $campaigns_id);
                break;

            case 'Answer':
                handleAnswer($conn, $uniqueid, $Agent, $call_to);
                break;

            case 'NOAGENT':
                handleNoAgent($conn, $uniqueid, $Agent);
                break;

            case 'delete':
                handleDelete($conn, $uniqueid, $Agent);
                break;

            default:
                echo "Invalid status";
                break;
        }
    } else {
        error_log("Execute failed: " . $stmtuser->error);
        echo "Error: Unable to execute user query.";
        exit;
    }
} else {
    echo "Invalid parameters";
}

$conn->close();

// Function to handle 'Ringing' status
function handleRinging($conn, $uniqueid, $did, $call_to, $call_from, $Agent, $admin, $date, $direction, $status, $full_name, $campaigns_id) {
    $stmtcheck = $conn->prepare("SELECT `uniqueid` FROM `live` WHERE `uniqueid` = ?");
    $stmtcheck->bind_param('s', $uniqueid);
    $stmtcheck->execute();
    $stmtcheck->store_result();

    if ($stmtcheck->num_rows > 0) {
        $stmtcheck->close();
        $stmtupdate = $conn->prepare("UPDATE `live` SET `call_to` = ?, `Agent` = ?, `status` = 'Answer' WHERE `uniqueid` = ?");
        $stmtupdate->bind_param('sss', $call_to, $Agent, $uniqueid);
        if ($stmtupdate->execute()) {
            echo "Call_status_updated_to_Answer";
        } else {
            error_log("Execute failed: " . $stmtupdate->error);
            echo "Error: Unable to update call status.";
        }
        $stmtupdate->close();
    } else {
        $stmtcheck->close();
        $stmtinsert = $conn->prepare("INSERT INTO `live` (`uniqueid`, `did`, `call_to`, `call_from`, `Agent`, `admin`, `time`, `direction`, `status`, `Agent_name`, `campaign_Id`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmtinsert->bind_param('sssssssssss', $uniqueid, $did, $call_to, $call_from, $Agent, $admin, $date, $direction, $status, $full_name, $campaigns_id);
        if ($stmtinsert->execute()) {
            echo "Call_status_set_to_Ringing";
        } else {
            error_log("Execute failed: " . $stmtinsert->error);
            echo "Error: Unable to insert call.";
        }
        $stmtinsert->close();
    }
}

// Function to handle 'Answer' status
function handleAnswer($conn, $uniqueid, $Agent, $call_to) {
    $stmtcheck = $conn->prepare("SELECT `Agent`, `call_to` FROM `live` WHERE `uniqueid` = ?");
    $stmtcheck->bind_param('s', $uniqueid);
    if ($stmtcheck->execute()) {
        $stmtcheck->store_result();
        if ($stmtcheck->num_rows > 0) {
            $stmtcheck->bind_result($Agent, $call_to);
            $stmtcheck->fetch();
            $stmtcheck->close();

            $stmtupdate = $conn->prepare("UPDATE `live` SET `status` = 'Answer', `Agent` = ?, `call_to` = ? WHERE `uniqueid` = ?");
            $stmtupdate->bind_param('sss', $Agent, $call_to, $uniqueid);
            if ($stmtupdate->execute()) {
                echo "Call_status_updated_to_Answer";
            } else {
                error_log("Execute failed: " . $stmtupdate->error);
                echo "Error: Unable to update call status.";
            }
            $stmtupdate->close();
        } else {
            echo "Unique ID not found";
            $stmtcheck->close();
        }
    } else {
        error_log("Execute failed: " . $stmtcheck->error);
        echo "Error: Unable to check unique ID.";
    }
}

// Function to handle 'NOAGENT' status
function handleNoAgent($conn, $uniqueid) {
    $stmtupdate = $conn->prepare("UPDATE `live` SET `status` = 'NOAGENT' WHERE `uniqueid` = ?");
    $stmtupdate->bind_param('s', $uniqueid);
    if ($stmtupdate->execute()) {
        echo "Call_status_updated_to_NOAGENT";
    } else {
        error_log("Execute failed: " . $stmtupdate->error);
        echo "Error: Unable to update call status.";
    }
    $stmtupdate->close();
}

// Function to handle 'delete' status
function handleDelete($conn, $uniqueid, $Agent) {
    $stmtcheck = $conn->prepare("SELECT `Agent` FROM `live` WHERE `uniqueid` = ?");
    $stmtcheck->bind_param('s', $uniqueid);
    if ($stmtcheck->execute()) {
        $stmtcheck->store_result();
        if ($stmtcheck->num_rows > 0) {
            $stmtcheck->bind_result($Agent);
            $stmtcheck->fetch();
            $stmtcheck->close();

            $stmtdelete = $conn->prepare("DELETE FROM `live` WHERE `uniqueid` = ?");
            $stmtdelete->bind_param('s', $uniqueid);
            if ($stmtdelete->execute()) {
                echo "Call_Hangup,$Agent";
            } else {
                error_log("Execute failed: " . $stmtdelete->error);
                echo "Error: Unable to delete call.";
            }
            $stmtdelete->close();
        } else {
            echo "Unique ID not found";
            $stmtcheck->close();
        }
    } else {
        error_log("Execute failed: " . $stmtcheck->error);
        echo "Error: Unable to check unique ID.";
    }
}
?>
