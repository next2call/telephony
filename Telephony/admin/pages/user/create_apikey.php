<?php 
session_start();
$Adminuser = $_SESSION['user'];
include "../../../conf/db.php";
include "../../../conf/Get_time_zone.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['user_id'])) {
        $user_id = $_POST['user_id'];
        function generateApiKey($length = 32) {
            return bin2hex(random_bytes($length / 2)); // Generate a secure random API key
        }
        $new_api_key = generateApiKey();

      
            $up = "UPDATE users SET api_key = '$new_api_key' WHERE user_id = '$user_id'";
        
            if (mysqli_query($con, $up)) {
                echo json_encode(['status' => 'success', 'api_key' => $new_api_key]);
            } else {
                // User not found or no change was made
                echo json_encode(['status' => 'error', 'message' => 'User not found or key not updated']);
            }

    } else {
        echo json_encode(['status' => 'error', 'message' => 'User ID is required']);
    }
} else {

    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

?>