
<?php
session_start();
ini_set('display_errors', 1); // Enable error display
error_reporting(E_ALL); // Report all types of errors

include "../conf/db.php";

// Initialize user object
$user = new stdClass();  // Initialize $user as a stdClass object

$user->user = isset($_POST['user_id']) ? $_POST['user_id'] : '';
$user->full_name = isset($_POST['full_name']) ? $_POST['full_name'] : '';
$user->use_did = isset($_POST['use_did']) ? $_POST['use_did'] : '';
$user->user_group = 'winet';
$user->pass = isset($_POST['pass']) ? $_POST['pass'] : '';
$user->external_num = isset($_POST['external_num']) ? $_POST['external_num'] : '';
$user->email = isset($_POST['email']) ? $_POST['email'] : '';
$date = date("Y-m-d H:i:s");
$user->user_level = '8';

// Check if user ID already exists in the database
$sel_check = "SELECT user_id FROM users WHERE user_id='{$user->user}'";
$quer_check = mysqli_query($con, $sel_check);
if (!$quer_check) {
    die('Error with query: ' . mysqli_error($con));
}

$sel_check_vicidial = "SELECT extension FROM phones WHERE extension='{$user->user}'";
$quer_check_vici = mysqli_query($conn, $sel_check_vicidial);
if (!$quer_check_vici) {
    die('Error with query: ' . mysqli_error($conn));
}

if (mysqli_num_rows($quer_check) > 0 || mysqli_num_rows($quer_check_vici) > 0) {
    echo 'This extension is already created.';
} else {
    // Insert user data into the vicidial_users table
    $sql = "INSERT INTO vicidial_users (user, full_name, user_level, user_group, pass) 
            VALUES ('{$user->user}', '{$user->full_name}', '{$user->user_level}', '{$user->user_group}', '{$user->pass}')";
    if (!mysqli_query($conn, $sql)) {
        echo 'Error inserting into vicidial_users: ' . mysqli_error($conn);
        exit;
    }

    // Insert phone data into the phones table
    $phone_ins = "INSERT INTO phones (extension, dialplan_number, voicemail_id, phone_ip, computer_ip, server_ip, login, pass, 
                status, active, phone_type, fullname, local_gmt, ASTmgrUSERNAME, ASTmgrSECRET, user_group, email) 
                VALUES ('{$user->user}', '{$user->user}', '{$user->user}', '10.101.1.16', '10.101.1.16', '{$Local_ip}', 
                '{$user->user}', '{$user->pass}', 'ACTIVE', 'Y', '{$user->user}', '{$user->full_name}', '-5.00', 
                'cron', '1234', 'winet', '{$user->email}')";
    if (!mysqli_query($conn, $phone_ins)) {
        echo 'Error inserting into phones table: ' . mysqli_error($conn);
        exit;
    }

    // Update the server rebuild flag
    $stmtA = "UPDATE servers SET rebuild_conf_files='Y' 
              WHERE generate_vicidial_conf='Y' 
              AND active_asterisk_server='Y' 
              AND server_ip='{$Local_ip}'";
    if (!mysqli_query($conn, $stmtA)) {
        echo 'Error updating servers table: ' . mysqli_error($conn);
        exit;
    }

    // Insert user data into the users table
    $sql2 = "INSERT INTO users(SuperAdmin, admin, user_id, password, full_name, status, campaigns_id, ins_date, use_did, user_type, ext_number) 
             VALUES ('N2CADMIN','{$user->user}', '{$user->user}', '{$user->pass}', '{$user->full_name}', 'Y', '{$user->use_campaign}', 
             '$date', '{$user->use_did}', '{$user->user_level}', '{$user->external_num}')";
    if (!mysqli_query($con, $sql2)) {
        echo 'Error inserting into users table: ' . mysqli_error($con);
        exit;
    }

    // Success message if everything went well
    echo 'Create User is successful';
}
?>