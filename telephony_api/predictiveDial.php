<?php
include "db.php";
include "time_zone.php";
include "../Telephony/conf/url_page.php";

// date_default_timezone_set('America/New_York'); // Set the timezone to Eastern Time
$date = date("Y-m-d"); // Get the current date

// Step 1: Fetch distinct campaign_id from break_time table
$sel = "SELECT DISTINCT campaign_id FROM break_time WHERE DATE(start_time) = ? AND status = '2'";
$stmt_campaign = $conn->prepare($sel);
$stmt_campaign->bind_param("s", $date);
$stmt_campaign->execute();
$qur_campaign = $stmt_campaign->get_result();

$campaign_ids = [];
if ($qur_campaign->num_rows > 0) {
    while ($row = $qur_campaign->fetch_assoc()) {
        $campaign_ids[] = $row['campaign_id'];
    }
} else {
    echo json_encode(['message' => 'No campaigns found']);
    exit();
}

// Step 2: Loop through each campaign_id and perform further operations
$arr = [];
foreach ($campaign_ids as $campaign_id) {

    // Check how many users are on break for this campaign
    $sel_break = "SELECT COUNT(user_name) as user_count, GROUP_CONCAT(user_name SEPARATOR ', ') as user_names FROM break_time WHERE DATE(start_time) = ? AND campaign_id = ? AND status = '2'";
    $stmt_break = $conn->prepare($sel_break);
    $stmt_break->bind_param("ss", $date, $campaign_id);
    $stmt_break->execute();
    $qur_break = $stmt_break->get_result();
    $user_count_data = $qur_break->fetch_assoc();

    $user_counts = $user_count_data['user_count'] ?? 0; // Default to 0 if no result
    $users = $user_count_data['user_names'] ?? ''; // Default to empty if no result

    if ($user_counts > 0) {
        // Fetch campaign details from compaign_list table
        $sql_data = "SELECT * FROM compaign_list WHERE compaign_id = ?";
        $stmt = $conn->prepare($sql_data);
        $stmt->bind_param("s", $campaign_id);
        $stmt->execute();
        $result_data = $stmt->get_result();
        $campaign_data = $result_data->fetch_assoc();
        $auto_dial_level = $campaign_data['auto_dial_level'] ?? 0; // Ensure fallback if campaign data not found

        // Check if auto_dial_level is 0 and return a message
        if ($auto_dial_level == 0) {
            $arr[] = ['message' => 'Please turn on autodial for campaign: ' . $campaign_id];
            continue; // Skip further processing for this campaign
        }

        // Calculate the final dial limit (total numbers to dial for the campaign)
        $final_dial = $auto_dial_level * $user_counts;

        if ($final_dial > 0) {
            // Fetch new dialable records that are NOT already being dialed in the 'live' table
            $sel_upload = "SELECT * FROM upload_data WHERE campaign_Id = ? AND dial_status = 'NEW' AND phone_number NOT IN (SELECT call_to FROM live) LIMIT ?";
            $stmt_upload = $conn->prepare($sel_upload);
            $stmt_upload->bind_param("si", $campaign_id, $final_dial);
            $stmt_upload->execute();
            $qur_upload = $stmt_upload->get_result();

            // Convert users and numbers to arrays
            $user_list = explode(', ', $users);
            $numbers = [];
            if ($qur_upload->num_rows > 0) {
                while ($get = $qur_upload->fetch_assoc()) {
                    $numbers[] = $get['phone_number'];
                }

                // Ensure each user dials the exact number of calls based on the auto_dial_level
                $total_numbers = count($numbers);
                $user_index = 0;

                while (!empty($numbers) && $user_index < $user_counts) {
                    $user = $user_list[$user_index % $user_counts]; // Rotate through users
                    
                    // Take the exact number of numbers for the current user based on auto_dial_level
                    $user_numbers = array_splice($numbers, 0, $auto_dial_level);

                    foreach ($user_numbers as $receiverNumber) {
                        // Prepare the wget command URL for each user with their assigned number
                         $wget_url = "http://".$Local_ip."/telephony_api/Autodial.php?callerNumber=$user&receiverNumber=$receiverNumber&key=jbti89692vc60b2o9nu%%5E7";

                        // Execute the wget command using PHP's exec function
                        $command = "wget -qO- \"$wget_url\"";
                        $response = exec($command);

                        // Check for any errors or output
                        if (empty($response)) {
                            $arr[] = ['error' => "Error with wget execution for user: $user and number: $receiverNumber"];
                        } else {
                            // Process the response if needed
                            $arr[] = ['api_response' => $response, 'user' => $user, 'number' => $receiverNumber];
                        }
                    }

                    // Move to the next user for the next set of numbers
                    $user_index++;
                }
            } else {
                $arr[] = ['message' => 'No new records found to dial for campaign: ' . $campaign_id];
            }
        } else {
            $arr[] = ['message' => 'No users on break or dial limit reached for campaign: ' . $campaign_id];
        }
    } else {
        $arr[] = ['message' => 'No users on break for campaign: ' . $campaign_id];
    }
}

// Step 3: Return the final result as JSON
if (!empty($arr)) {
    echo json_encode($arr);
} else {
    echo json_encode(['message' => 'No data processed']);
}
?>
