<?php

include "db.php";

// Allow requests from any origin
header("Access-Control-Allow-Origin: *");

// Allow POST and GET methods
header("Access-Control-Allow-Methods: POST, GET");

// Allow specified headers
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// Set the content type for the response to JSON
header('Content-type: application/json');

// Get request parameters
$Status = $_REQUEST['status'];
$extension = $_REQUEST['extension'];
$password = $_REQUEST['password'];
$template_id = $_REQUEST['template_id'];
$api_key = $_REQUEST['api_key'];

// Function to handle errors
function respondWithError($message) {
    echo json_encode(["ERROR" => $message]);
    exit();
}

// Function to handle success
function respondWithSuccess($message) {
    echo json_encode(["SUCCESS" => $message]);
    exit();
}

// Check if API key is missing or blank
if (empty($api_key)) {
    respondWithError("API KEY IS MISSING");
}

// Check if API KEY is valid (using 'conn' for this database)
$stmt = $conn->prepare("SELECT admin, api_key FROM users WHERE api_key = ?");
$stmt->bind_param("s", $api_key);
$stmt->execute();
$stmt->bind_result($admin, $db_api_key);
$stmt->fetch();

if (empty($db_api_key)) {
    respondWithError("INVALID API KEY");
}
$stmt->close();

if ($Status === "ADD" && $extension && $password && $template_id) {
    // Scenario 1: Add phone (using 'con' for this database)
    
    // Check if extension is available
    $stmt = $con->prepare("SELECT COUNT(*) AS count FROM phones WHERE extension = ?");
    $stmt->bind_param("s", $extension);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    
    if ($count > 0) {
        respondWithError("PHONE $extension IS EXISTING");
    } else {
        $insertQuery = "INSERT INTO phones (extension, dialplan_number, voicemail_id, server_ip, login, pass, status, active, phone_type, fullname, protocol, local_gmt, ASTmgrUSERNAME, ASTmgrSECRET, login_pass, webphone_dialbox, webphone_mute, webphone_volume, webphone_debug, outbound_cid, template_id, conf_secret, user_group, conf_qualify, webphone_layout, mohsuggest, peer_status, ping_time, webphone_settings) VALUES ('$extension', '$extension', '$extension', '192.168.125.241', '$extension', '$password', 'ACTIVE', 'Y', '$extension', '$extension', 'SIP', 5.50, 'cron', '1234',  '$password', 'Y', 'Y', 'Y', 'N', '$extension', '$template_id', '$password', '$template_id', 'Y', '', '', '', '', 'VICIPHONE_SETTINGS')";
        $Stmt = $con->prepare($insertQuery);
        
        // Insert new user using 'conn'
        $insertUserQuery = "INSERT INTO users (admin, user_id, password, user_type, full_name, status)
            VALUES (?, ?, ?, '1', ?, 'Y')";
        $userStmt = $conn->prepare($insertUserQuery);
        $userStmt->bind_param("ssss", $admin, $extension, $password, $extension);
        $userStmt->execute();
        $userStmt->close();

        // Update configuration file rebuild status
        $updateStmt = "UPDATE servers SET rebuild_conf_files='Y' WHERE generate_vicidial_conf='Y' AND active_asterisk_server='Y' AND server_ip='192.168.125.241'";
        $con->query($updateStmt);

        if ($Stmt->execute()) {

            respondWithSuccess("PHONE HAS BEEN ADDED $extension|$password");
        } else {
            respondWithError("Failed to add extension: " . $con->error);
        }
        $Stmt->close();
    }
} elseif (($Status == "Y" || $Status == "N") && $extension) {
    // Scenario 2: Update status (using 'con')
    
    // Update the phone status
    $stmt = $con->prepare("UPDATE phones SET active = ? WHERE extension = ?");
    $stmt->bind_param("ss", $Status, $extension);
    
    if ($stmt->execute()) {
        // Update the user status in the users table (using 'conn')
        $userStmt = $conn->prepare("UPDATE users SET status = ? WHERE user_id = ?");
        $userStmt->bind_param("ss", $Status, $extension);
        
        if ($userStmt->execute()) {
            respondWithSuccess("PHONE AND USER STATUS UPDATED $extension|$Status");
        } else {
            respondWithError("Failed to update user status: " . $conn->error);
        }
        $userStmt->close();
    } else {
        respondWithError("Failed to update phone status: " . $con->error);
    }
    $stmt->close();
} elseif ($Status === "CHANGE" && $extension && $password) {
    // Scenario 3: Update password (using 'con' for phones and 'conn' for users)
    
    // Update password in the phones table
    $stmt = $con->prepare("UPDATE phones SET pass = ? WHERE extension = ?");
    $stmt->bind_param("ss", $password, $extension);
    
    if ($stmt->execute()) {
        // Update password in the users table (using 'conn')
        $userStmt = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
        $userStmt->bind_param("ss", $password, $extension);
        
        if ($userStmt->execute()) {
            respondWithSuccess("PHONE AND USER PASSWORD UPDATED $extension|$password");
        } else {
            respondWithError("Failed to update user password: " . $conn->error);
        }
        $userStmt->close();
    } else {
        respondWithError("Failed to update phone password: " . $con->error);
    }
    $stmt->close();
} else {
    respondWithError("SOMETHING WENT WRONG");
}

// Close the database connections
$conn->close();
$con->close();

?>
