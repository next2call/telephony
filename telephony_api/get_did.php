<?php 

include "db.php";
include "time_zone.php";

// date_default_timezone_set('Asia/Kolkata'); // Set the timezone to Indian Standard Time


// Get the current date
$date = date("Y-m-d");

// Get the extension from the request
$extension = isset($_REQUEST['extension']) ? $_REQUEST['extension'] : '';

// Check if the extension is provided
if (empty($extension)) {
    echo "0,0,0,0";
    exit();
}

try {
    // Prepare and execute the query to get the campaign name and user type
    $userLogQuery = "SELECT campaign_name, user_type FROM login_log WHERE log_in_time LIKE ? AND user_name = ?";
    $stmt = $conn->prepare($userLogQuery);
    $searchDate = "%$date%";
    $stmt->bind_param('ss', $searchDate, $extension);
    $stmt->execute();
    $userLogResult = $stmt->get_result();

    // Check if the user log query returned any results
    if ($userLogResult->num_rows > 0) {
        $userLogRow = $userLogResult->fetch_assoc();
        $campaign_name = $userLogRow['campaign_name'];
        $user_type = $userLogRow['user_type'];

        if($user_type == '8' || $user_type == '2'){
            $ring_time = 60;
        }else{
              // Prepare and execute the query to get 
              $camDidQuery = "SELECT * FROM `compaign_list` WHERE compaign_id = ?";
              $stmt = $conn->prepare($camDidQuery);
              $stmt->bind_param('s', $campaign_name);
              $stmt->execute();
              $camDidResult = $stmt->get_result();
              $camDidRow = $camDidResult->fetch_assoc();
              $ring_time = $camDidRow['ring_time'];
              $music_on_hold = $camDidRow['compaign_id'];       
              $compaign_id = $camDidRow['compaign_id'];       
              $musiconhold = $camDidRow['music_on_hold'];
              $campaign_dis = $camDidRow['campaign_dis'];


        }

        if (empty($musiconhold)){
            $music_on_hold = 'default';
        }else{
            $music_on_hold;
        }
        

        // Prepare and execute the query to get the user's DID
        $userDidQuery = "SELECT use_did FROM `users` WHERE user_id = ?";
        $stmt = $conn->prepare($userDidQuery);
        $stmt->bind_param('s', $extension);
        $stmt->execute();
        $userDidResult = $stmt->get_result();
        
        // Check if the user DID query returned any results
        if ($userDidResult->num_rows > 0) {
            $userDidRow = $userDidResult->fetch_assoc();
            $use_did = $userDidRow['use_did'];
            
            // Output the DID if it exists
            if (!empty($use_did)) {
                if($campaign_dis=='inbound'){
                    echo "0,outboundNotAllow,0,0";
                }else{
                    echo "1,$use_did,$music_on_hold,$ring_time,$compaign_id";
                }
                exit();
            } else if ($user_type == '2') {
                echo "1,$use_did,$music_on_hold,60,$compaign_id";
                exit();
            }
             else if ($user_type == '8') {
                echo "1,$use_did,$music_on_hold,60,$compaign_id";
                exit();
            } else {
                // Prepare and execute the query to get the campaign number
                $camDidQuery = "SELECT * FROM `compaign_list` WHERE compaign_id = ?";
                $stmt = $conn->prepare($camDidQuery);
                $stmt->bind_param('s', $campaign_name);
                $stmt->execute();
                $camDidResult = $stmt->get_result();
                
                // Check if the campaign query returned any results
                if ($camDidResult->num_rows > 0) {
                    $camDidRow = $camDidResult->fetch_assoc();
                    $did = $camDidRow['outbond_cli'];
                    $ring_time = $camDidRow['ring_time'];
                    $music_on_hold = $camDidRow['compaign_id'];       
                    $compaign_id = $camDidRow['compaign_id'];       
                    $musiconhold = $camDidRow['music_on_hold'];
                    $campaign_dis = $camDidRow['campaign_dis'];

                    if (empty($musiconhold)){
                        $music_on_hold = 'default';
                    }else{
                        $music_on_hold;
                    }

                    if($campaign_dis=='inbound'){
                        echo "0,outboundNotAllow,0,0";
                    }else{
                        echo "1,$did,$music_on_hold,$ring_time,$compaign_id";
                    }

                } else {
                    echo "0,0,0,0";
                }
                exit();
            }
        } else {
            echo "0,0,0,0";
        }
    } else {
        echo "0,0,0,0";
    }
} catch (Exception $e) {
    // Handle any errors
    echo "0,0,0,0";
    error_log($e->getMessage());
}
?>
