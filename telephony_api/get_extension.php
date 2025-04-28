<?php

// Include database connection
include "db.php";
include "time_zone.php";




session_start();

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the DID number and DTMF from the request, ensuring they are sanitized
$press_key_indexs = filter_input(INPUT_GET, 'key_index');
$did = filter_input(INPUT_GET, 'did_number', FILTER_SANITIZE_STRING);
$dtmf = filter_input(INPUT_GET, 'dtmf', FILTER_SANITIZE_STRING);



// Select user based on DID number
$seluser = "SELECT * FROM `users` WHERE use_did = ?";
$stmtuser = $conn->prepare($seluser);
$stmtuser->bind_param('s', $did);
$stmtuser->execute();
$seluserResult = $stmtuser->get_result();
$userdid = $seluserResult->fetch_assoc();

$Agentdid = $userdid['use_did'] ?? null;
$user_id = $userdid['user_id'] ?? null;


if ($Agentdid) {
    echo "7,$user_id";
    exit();
}

// Prepare and execute the query to get campaign details
$sel = "SELECT * FROM `compaign_list` WHERE campaign_number = ?";
$stmt = $conn->prepare($sel);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param('s', $did);
$stmt->execute();
$selResult = $stmt->get_result();

if ($selResult->num_rows > 0) {
    $campaign = $selResult->fetch_assoc();
    $compaign_id = $campaign['compaign_id'];
    $type = $campaign['type'];
    $campaign_dis = $campaign['campaign_dis'];
    $status = $campaign['status'];
    $ring_time = $campaign['ring_time'];
    $welcome_ivr_cam = $campaign['welcome_ivr'];
    $after_office_ivr = $campaign['after_office_ivr'];       
    $week_off = $campaign['week_off'];       
    $week_off_ivr = $campaign['week_off_ivr'];       
    $music_on_hold = $campaign['compaign_id'];
    $musiconhold = $campaign['music_on_hold'];
    $no_agent_ivr = $campaign['no_agent_ivr'];
    $campaign_group_status = $campaign['ivr'];

    if (empty($musiconhold)) {
        $music_on_hold = 'default';
    }

    if (empty($no_agent_ivr)) {
        $no_agent = 'NoAgent';
    }else{
        $no_agent = basename($no_agent_ivr, '.wav');

    }

    $local_call_time = $campaign['local_call_time']; // Assuming $campaign['local_call_time'] contains the time range like "9:30am-7pm"

    // Extract start and end hours from local_call_time
    preg_match('/(\d{1,2}(:\d{2})?[ap]m)-(\d{1,2}(:\d{2})?[ap]m)/i', $local_call_time, $matches);
    
    $startHour = isset($matches[1]) ? date('H:i', strtotime($matches[1])) : null;
    $endHour = isset($matches[3]) ? date('H:i', strtotime($matches[3])) : null;
    
    // echo "Start Hour: " . $startHour . "<br>";
    // echo "End Hour: " . $endHour . "<br>";
    
    // Get the current time in 24-hour format
    $currentHour = date('H:i');
    
    // echo "Current Hour: " . $currentHour . "<br>";
    
    

if($currentDay==$week_off){
        $week_off_ivr_no_prefix = basename($week_off_ivr, '.wav');
        echo "9,week_off,$week_off_ivr_no_prefix,/srv/www/htdocs/Telephony/admin/ivr/,0,0,0,0,0,$compaign_id";

    }
    // Check campaign distribution and status
    elseif (($campaign_dis == 'both' && $status == 'Y') || $campaign_dis == 'inbound') {
        handleOfficeTime($conn, $compaign_id, $type, $campaign_group_status, $currentHour, $startHour, $endHour, $welcome_ivr, $after_office_ivr, $dtmf, $music_on_hold, $ring_time,  $welcome_ivr_cam, $press_key_indexs, $next_option, $no_agent);
    } else {
        echo "6,SOMTHING_WRONG,0,0,$music_on_hold";
    }
} else {
    echo "6,SOMTHING_WRONG,0,0,$music_on_hold";
}

function handleOfficeTime($conn, $campaign_id, $type, $campaign_group_status, $currentHour, $startHour, $endHour, $welcome_ivr, $after_office_ivr, $dtmf, $music_on_hold,  $ring_time,  $welcome_ivr_cam, $press_key_indexs, $next_option, $no_agent) {
    $date = date("Y-m-d");
    $query = "SELECT user_name FROM `break_time` WHERE start_time LIKE '%$date%' AND status = '2' AND campaign_id LIKE '%$campaign_id%'";
    $result = mysqli_query($conn, $query);

    // Ensure the current hour, start hour, and end hour are in "H:i" format for proper comparison
    $currentHour = date('H:i', strtotime($currentHour));
    $startHour = date('H:i', strtotime($startHour));
    $endHour = date('H:i', strtotime($endHour));

    if ($currentHour < $startHour || $currentHour > $endHour) {
        handleAfterOfficeTime($after_office_ivr, $campaign_id);
    } elseif ($result && mysqli_num_rows($result) > 0) {
        processAgentResults($conn, $result, $campaign_id, $type, $campaign_group_status, $date, $welcome_ivr, $dtmf, $music_on_hold, $ring_time,  $welcome_ivr_cam, $press_key_indexs, $next_option, $no_agent);
    } else {
        echo "0,NOAGENT,0,/srv/www/htdocs/Telephony/admin/ivr/,$music_on_hold,0,0,0,$no_agent,$campaign_id";
    }
}

function handleAfterOfficeTime($after_office_ivr, $campaign_id) {
    $after_office_ivr_no_prefix = basename($after_office_ivr, '.wav');
    echo "1,Afteroffice,$after_office_ivr_no_prefix,/srv/www/htdocs/Telephony/admin/ivr/,0,0,0,0,0,$campaign_id";
}


function processAgentResults($conn, $result, $compaign_id, $type, $campaign_group_status, $date, $welcome_ivr, $dtmf, $music_on_hold,  $ring_time,  $welcome_ivr_cam, $press_key_indexs, $next_option, $no_agent) {
    $user_start_id = '';
    $mobile_no = '';
    $welcome_ivr_camprefix = basename($welcome_ivr_cam, '.wav');


    while ($agentRow = mysqli_fetch_array($result)) {
        $agent_id = $agentRow['user_name'];
        list($user_start_id, $mobile_no, $take_call_mobile, $welcome_ivr, $next_option) = selectAgent($conn, $agent_id, $compaign_id, $type, $campaign_group_status, $date, $dtmf, $press_key_indexs);
        if (!empty($user_start_id)) {
            $_SESSION['last_user_name'] = $user_start_id; // Store the last selected user
            break;
        }
    }
    if (empty($user_start_id)) {
        echo "0,NOAGENT,0,/srv/www/htdocs/Telephony/admin/ivr/,$music_on_hold,0,0,0,$no_agent";
    } else {
        echoResponse($user_start_id, $welcome_ivr, $campaign_group_status, $music_on_hold, $mobile_no, $take_call_mobile,  $ring_time,  $welcome_ivr_cam, $press_key_indexs, $next_option, $type, $no_agent, $compaign_id);
    }
}

function selectAgent($conn, $agent_id, $compaign_id, $type, $campaign_group_status, $date, $dtmf, $press_key_indexs) {
    if ($type == 'random') {
        return selectRandomAgent($conn, $agent_id, $compaign_id, $campaign_group_status, $date, $dtmf, $press_key_indexs, $type);
    }elseif ($type == 'ring_all') {
        return selectAllAgent($conn, $agent_id, $compaign_id, $campaign_group_status, $date, $dtmf, $press_key_indexs, $type);
    } elseif ($type == 'longest_wait_time') {
        return selectLongestAgent($conn, $agent_id, $compaign_id, $campaign_group_status, $date, $dtmf, $press_key_indexs, $type);
    } else {
        return selectNonRandomAgent($conn, $agent_id, $compaign_id, $campaign_group_status, $date, $dtmf, $press_key_indexs, $type);
    }
}



function getNextOption($parent_option, $current_option) {
    // Split the parent option string by commas
    $options = explode(',', $parent_option);
    
    // Extract the first value of the current option
    $current_parts = explode('-', $current_option);
    $current_first_value = $current_parts[0];

    // Iterate through the options to find the next one
    foreach ($options as $index => $option) {
        $parts = explode('-', $option);
        if ($parts[0] == $current_first_value) {
            // Check if there is a next option
            if (isset($options[$index + 1])) {
                // Split the next option and return only the first part
                $next_parts = explode('-', $options[$index + 1]);
                return $next_parts[0];
            } else {
                return 0; // No next option
            }
        }
    }


}

function selectRandomAgent($conn, $agent_id, $compaign_id, $campaign_group_status, $date, $dtmf, $press_key_indexs, $type) {
    $user_start_id = '';
    $mobile_no = '';

    $queryRan = buildAgentQuery($conn, $dtmf, $agent_id, $compaign_id, $campaign_group_status, $date, true, $press_key_indexs, $type);
     $queryRan;
    $resultRan = mysqli_query($conn, $queryRan);
    if ($resultRan && mysqli_num_rows($resultRan) > 0) {
        $rowRan = mysqli_fetch_array($resultRan);
        $user_start_id = $rowRan['user_name'];
        $mobile_no = $rowRan['agent_number'];
        $press_key = $rowRan['press_key']; // 1,2,3
        $parent_option = $rowRan['parent_option']; // 1-1,2-1,3-1
        $menu_prompt = $rowRan['menu_prompt']; //like ivr/667ff3df109fb.wav,ivr/667ff3df09fb.wav,ivr/667ff3df109fb.wav
        $take_call_mobile = $rowRan['take_call_mobile'];

      

       // Select the correct menu prompt based on the pressed key
    if (!empty($dtmf)) {
        $menu_prompts = explode(',', $menu_prompt);
        $press_keys = explode(',', $press_key);
        // $key_index = array_search($dtmf, $press_keys);

        $final_option = $press_key_indexs.'-'.$dtmf;

     
        // Split the $parent_option string into an array
        $parent_options = explode(',', $parent_option);

        // Find the index of $dtmf in the $parent_options array
        $key_indexoptions = array_search($final_option, $parent_options);

        // print_r($key_indexoptions);


        if ($key_indexoptions !== false && isset($menu_prompts[$key_indexoptions])) {
            $welcome_ivr = $menu_prompts[$key_indexoptions];
            $current_option = $parent_options[$key_indexoptions];
            $next_option = getNextOption($parent_option, $current_option);
          
        }

          
        }else{
            $user_start_id = $rowRan['user_name'];
        }
    }
    if (empty($mobile_no)) {
        $mobile_no = '0';
    }
    return array($user_start_id, $mobile_no, $take_call_mobile, $welcome_ivr, $next_option);
}

function selectAllAgent($conn, $agent_id, $compaign_id, $campaign_group_status, $date, $dtmf, $press_key_indexs, $type) {
    // Initialize variables
    $user_start_id = [];
    $mobile_no = '';
    $welcome_ivr = '';
    $next_option = '';

    // Build and execute the query
    $queryRan = buildAgentQuery($conn, $dtmf, $agent_id, $compaign_id, $campaign_group_status, $date, true, $press_key_indexs, $type);
    $resultRan = mysqli_query($conn, $queryRan);

    if ($resultRan && mysqli_num_rows($resultRan) > 0) {
        while ($rowRan = $resultRan->fetch_assoc()) {
            // Store agent information
            $user_start_id[] = $rowRan['user_name'];
            $mobile_no = $rowRan['agent_number'];
            $press_key = $rowRan['press_key']; // e.g., "1,2,3"
            $parent_option = $rowRan['parent_option']; // e.g., "1-1,2-1,3-1"
            $menu_prompt = $rowRan['menu_prompt']; // e.g., "ivr/667ff3df109fb.wav,ivr/667ff3df09fb.wav,ivr/667ff3df109fb.wav"
            $take_call_mobile = $rowRan['take_call_mobile'];

            // Select the correct menu prompt based on the pressed key
            if (!empty($dtmf)) {
                $menu_prompts = explode(',', $menu_prompt);
                $press_keys = explode(',', $press_key);
                $final_option = $press_key_indexs . '-' . $dtmf;
                $parent_options = explode(',', $parent_option);

                // Find the index of the current option
                $key_indexoptions = array_search($final_option, $parent_options);

                // If found, set the appropriate menu prompt
                if ($key_indexoptions !== false && isset($menu_prompts[$key_indexoptions])) {
                    $welcome_ivr = $menu_prompts[$key_indexoptions];
                    $current_option = $parent_options[$key_indexoptions];
                    $next_option = getNextOption($parent_option, $current_option);
                }
            }
        }
    }

    // Default value for mobile_no if not set
    if (empty($mobile_no)) {
        $mobile_no = '0';
    }

    $user_start_id_string = implode('&SIP/', $user_start_id);


    // Return the relevant data
    return array($user_start_id_string, $mobile_no, $take_call_mobile, $welcome_ivr, $next_option);
}

function selectLongestAgent($conn, $agent_id, $compaign_id, $campaign_group_status, $date, $dtmf, $press_key_indexs, $type) {
    $user_start_id = '';
    $mobile_no = '';

    $queryRan = buildAgentQuery($conn, $dtmf, $agent_id, $compaign_id, $campaign_group_status, $date, true, $press_key_indexs, $type);
     $queryRan;
    $resultRan = mysqli_query($conn, $queryRan);
    if ($resultRan && mysqli_num_rows($resultRan) > 0) {
        $rowRan = mysqli_fetch_array($resultRan);
        $user_start_id = $rowRan['user_name'];
        $mobile_no = $rowRan['agent_number'];
        $press_key = $rowRan['press_key']; // 1,2,3
        $parent_option = $rowRan['parent_option']; // 1-1,2-1,3-1
        $menu_prompt = $rowRan['menu_prompt']; //like ivr/667ff3df109fb.wav,ivr/667ff3df09fb.wav,ivr/667ff3df109fb.wav
        $take_call_mobile = $rowRan['take_call_mobile'];

      

       // Select the correct menu prompt based on the pressed key
    if (!empty($dtmf)) {
        $menu_prompts = explode(',', $menu_prompt);
        $press_keys = explode(',', $press_key);
        // $key_index = array_search($dtmf, $press_keys);

        $final_option = $press_key_indexs.'-'.$dtmf;

     
        // Split the $parent_option string into an array
        $parent_options = explode(',', $parent_option);

        // Find the index of $dtmf in the $parent_options array
        $key_indexoptions = array_search($final_option, $parent_options);

        // print_r($key_indexoptions);


        if ($key_indexoptions !== false && isset($menu_prompts[$key_indexoptions])) {
            $welcome_ivr = $menu_prompts[$key_indexoptions];
            $current_option = $parent_options[$key_indexoptions];
            $next_option = getNextOption($parent_option, $current_option);
          
        }

          
        }else{
            $user_start_id = $rowRan['user_name'];
        }
    }
    if (empty($mobile_no)) {
        $mobile_no = '0';
    }

    return array($user_start_id, $mobile_no, $take_call_mobile, $welcome_ivr, $next_option);
}

function selectNonRandomAgent($conn, $agent_id, $compaign_id, $campaign_group_status, $date, $dtmf, $press_key_indexs, $type) {
    $user_start_id = '';
    $mobile_no = '';

    $queryRan = buildAgentQuery($conn, $dtmf, $agent_id, $compaign_id, $campaign_group_status, $date, false, $press_key_indexs, $type);
    $resultRan = mysqli_query($conn, $queryRan);
    if ($resultRan && mysqli_num_rows($resultRan) > 0) {
        $rowRan = mysqli_fetch_array($resultRan);
        $user_start_id = $rowRan['user_name'];
        $mobile_no = $rowRan['mobile_no'];
        $press_key = $rowRan['press_key']; // 1,2,3
        $parent_option = $rowRan['parent_option']; // 1-1,2-1,3-1
        $menu_prompt = $rowRan['menu_prompt']; //like ivr/667ff3df109fb.wav,ivr/667ff3df09fb.wav,ivr/667ff3df109fb.wav
        $take_call_mobile = $rowRan['take_call_mobile'];
      
     // Select the correct menu prompt based on the pressed key
     if (!empty($dtmf)) {
        $menu_prompts = explode(',', $menu_prompt);
        $press_keys = explode(',', $press_key);
        // $key_index = array_search($dtmf, $press_key_indexs);
        
        $final_option = $press_key_indexs.'-'.$dtmf;

     
        // Split the $parent_option string into an array
        $parent_options = explode(',', $parent_option);

        // Find the index of $dtmf in the $parent_options array
        $key_indexoptions = array_search($final_option, $parent_options);

        // print_r($key_indexoptions);


        if ($key_indexoptions !== false && isset($menu_prompts[$key_indexoptions])) {
            $welcome_ivr = $menu_prompts[$key_indexoptions];
            $current_option = $parent_options[$key_indexoptions];
            $next_option = getNextOption($parent_option, $current_option);

          
        }
    
        }else{
            $user_start_id = $rowRan['user_name'];
        }
    }
    if (empty($mobile_no)) {
        $mobile_no = '0';
    }
    return array($user_start_id, $mobile_no, $take_call_mobile, $welcome_ivr, $next_option);
}


function buildAgentQuery($conn, $dtmf, $agent_id, $compaign_id, $campaign_group_status, $date, $isRandom, $press_key_indexs, $type) {
   
    $press_key_indexs = filter_input(INPUT_GET, 'key_index');
    
   
    $final_option = $press_key_indexs.'-'.$dtmf;
    $randomOrder = $isRandom ? "ORDER BY RAND()" : "ORDER BY agent_priorty ASC"; // Corrected 'agent_priorty' to 'agent_priorty'
    $fields = $campaign_group_status == '1' || $campaign_group_status == '2'  ? " * " : " * ";
    $liveUsers = [];
    
    // Determine the correct user ID column name
    $Agent = $dtmf ? 'user_name' : 'user_name'; // Adjust 'id' to the correct column name in your 'users' table
    
    // Get all live users
    $innerQuery = "SELECT call_to, Agent FROM live";
    $innerStmt = $conn->prepare($innerQuery);
    if (!$innerStmt) {
        die("Prepare failed: " . $conn->error);
    }
    if (!$innerStmt->execute()) {
        die("Execute failed: " . $innerStmt->error);
    }
    $innerResult = $innerStmt->get_result();
    while ($row = $innerResult->fetch_assoc()) {
        $liveUsers[] = $row['Agent'];
        $livecall_to[] = $row['call_to'];
    }

    // Create the exclusion part of the query for live users
    $liveUsersExclusion = '';
    if (!empty($liveUsers)) {
        $liveUsersExclusion = "AND $Agent NOT IN ('" . implode("','", $liveUsers) . "')";
    }

    // Count available agents before excluding the last selected agent
    $availableAgentsQuery = "SELECT COUNT(*) as count FROM break_time WHERE start_time LIKE '%$date%' AND status = '2' AND  campaign_id LIKE '%$compaign_id%'  $liveUsersExclusion";
    $availableAgentsResult = $conn->query($availableAgentsQuery);
    if (!$availableAgentsResult) {
        die("Query failed: " . $conn->error);
    }
    $availableAgentsCount = $availableAgentsResult->fetch_assoc()['count'];

    // Exclude the last selected agent only if there are more than one agents available
    if ($availableAgentsCount >= 2 && isset($_SESSION['last_user_name']) && !empty($_SESSION['last_user_name'])) {
        $liveUsersExclusion .= " AND $Agent != '" . $_SESSION['last_user_name'] . "'";
    }
    
    if ($dtmf) {
        // echo "SELECT $fields FROM break_time WHERE parent_option LIKE '%$final_option%' AND campaign_id LIKE '%$compaign_id%' $liveUsersExclusion $randomOrder LIMIT 1";
        return "SELECT $fields FROM break_time WHERE start_time LIKE '%$date%' AND status = '2' AND parent_option LIKE '%$final_option%' AND campaign_id LIKE '%$compaign_id%' $liveUsersExclusion $randomOrder LIMIT 1";
    }elseif($type=='ring_all') {
        // echo "SELECT $fields FROM break_time WHERE start_time LIKE '%$date%' AND status = '2' AND  campaign_id LIKE '%$compaign_id%' $liveUsersExclusion";
        return "SELECT $fields FROM break_time WHERE start_time LIKE '%$date%' AND status = '2' AND  campaign_id LIKE '%$compaign_id%' $liveUsersExclusion";
    } elseif($type=='longest_wait_time') {
        
        $currentDateTime = date("Y-m-d H:i:s");

        return  "WITH no_cdr_users AS (
                SELECT 
                    s.user_name, 
                    MAX(s.start_time) AS max_start_time,
                    TIMESTAMPDIFF(SECOND, MAX(s.start_time), '$currentDateTime') AS wait_time,
                    1 AS priority
                        FROM 
                            break_time s
                        LEFT JOIN 
                            cdr c ON s.user_name = c.call_to AND DATE(c.start_time) = '$date'
                        JOIN 
                            users sc ON sc.user_id = s.user_name
                        WHERE 
                            DATE(s.start_time) = '$date'
                            AND s.status = '2'
                            AND s.campaign_id LIKE '%$compaign_id%'
                            AND c.call_to IS NULL -- Ensures no cdr values
                            $liveUsersExclusion
                        GROUP BY 
                            s.user_name
                    ),
                    cdr_users AS (
                        SELECT 
                            s.user_name, 
                            MAX(s.start_time) AS max_start_time,
                            MAX(c.end_time) AS max_end_time,
                            TIMESTAMPDIFF(SECOND, MAX(c.end_time), '$currentDateTime') AS wait_time,
                            2 AS priority
                        FROM 
                            break_time s
                        JOIN 
                            cdr c ON s.user_name = c.call_to AND DATE(c.start_time) = '$date'
                        JOIN 
                            users sc ON sc.user_id = s.user_name
                        WHERE 
                            DATE(s.start_time) = '$date'
                            AND s.status = '2'
                            AND s.campaign_id LIKE '%$compaign_id%'
                            $liveUsersExclusion
                        GROUP BY 
                            s.user_name
                    ),
                    combined AS (
                        SELECT 
                            user_name, 
                            max_start_time,
                            NULL AS max_end_time,
                            wait_time, 
                            priority
                        FROM 
                            no_cdr_users
                        UNION ALL
                        SELECT 
                            user_name, 
                            max_start_time,
                            max_end_time,
                            wait_time, 
                            priority
                        FROM 
                            cdr_users
                    )
                    SELECT 
                        user_name, 
                        max_start_time,
                        max_end_time,
                        wait_time, 
                        priority
                    FROM 
                        combined
                    ORDER BY 
                        priority, wait_time DESC
                    LIMIT 1";
    
    
    }  else {
        // echo "SELECT $fields FROM break_time WHERE start_time LIKE '%$date%' AND status = '2' AND campaign_id LIKE '%$compaign_id%' $liveUsersExclusion $randomOrder LIMIT 1";
        return "SELECT $fields FROM break_time WHERE start_time LIKE '%$date%' AND status = '2' AND  campaign_id LIKE '%$compaign_id%' $liveUsersExclusion $randomOrder LIMIT 1";
    }
}


function echoResponse($user_start_id, $welcome_ivr, $campaign_group_status, $music_on_hold, $mobile_no, $take_call_mobile,  $ring_time,  $welcome_ivr_cam, $press_key_indexs, $next_option, $type, $no_agent, $compaign_id) {
    $press_key_indexs = filter_input(INPUT_GET, 'key_index');

    if (empty($next_option)) {
        $next_option = $press_key_indexs;
   }else{
        $next_option = $next_option;
    }
    
    $welcome_ivr_no_prefix = basename($welcome_ivr, '.wav');
    $welcome_ivr_camprefix = basename($welcome_ivr_cam, '.wav');

    if ($take_call_mobile == 'mobile') {
        if (empty($welcome_ivr)) {
            echo "4,$mobile_no,0,/srv/www/htdocs/Telephony/admin/ivr/,$music_on_hold,$ring_time,1,$type,$no_agent,$compaign_id";
        } elseif ($campaign_group_status == '1') {
            echo "5,$mobile_no,$welcome_ivr_camprefix,/srv/www/htdocs/Telephony/admin/ivr/,$music_on_hold,$ring_time,1,$type,$no_agent,$compaign_id";
        }else {
            echo "4,$mobile_no,$welcome_ivr_camprefix,/srv/www/htdocs/Telephony/admin/ivr/,$music_on_hold,$ring_time,1,$type,$no_agent,$compaign_id";
        }
    } else {
        if($campaign_group_status==2){
            if (empty($welcome_ivr_cam)) {
                echo "3,$user_start_id,0,/srv/www/htdocs/Telephony/admin/ivr/,$music_on_hold,$ring_time,$next_option,$type,$no_agent,$compaign_id";
            }elseif ($welcome_ivr) {
                echo "3,$user_start_id,$welcome_ivr_no_prefix,/srv/www/htdocs/Telephony/admin/ivr/,$music_on_hold,$ring_time,$next_option,$type,$no_agent,$compaign_id";
            }else {
                echo "3,Welcome,$welcome_ivr_camprefix,/srv/www/htdocs/Telephony/admin/ivr/,$music_on_hold,$ring_time,$next_option,$type,$no_agent,$compaign_id";
            }
        }else{
            if (empty($welcome_ivr_cam)) {
                echo "2,$user_start_id,0,/srv/www/htdocs/Telephony/admin/ivr/,$music_on_hold,$ring_time,1,$type,$no_agent,$compaign_id";
            }elseif ($campaign_group_status == '1') {
                echo "3,$user_start_id,$welcome_ivr_camprefix,/srv/www/htdocs/Telephony/admin/ivr/,$music_on_hold,$ring_time,1,$type,$no_agent,$compaign_id";
            }else {
                echo "2,$user_start_id,$welcome_ivr_camprefix,/srv/www/htdocs/Telephony/admin/ivr/,$music_on_hold,$ring_time,1,$type,$no_agent,$compaign_id";
            }

        }
       
    }
}
?>
