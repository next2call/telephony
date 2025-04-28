<?php 

include "db.php";

$date = date("Y-m-d H:i:s"); // Corrected to 24-hour format for consistency with datetime fields
$number = $_REQUEST['number'];
$did = $_REQUEST['did_number'];


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


// Check the block_no and status from the database
$select_query = "SELECT block_no, status FROM block_no WHERE block_no = '$number' AND admin = '$admin'";
$result = mysqli_query($conn, $select_query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $block_no = $row['block_no'];
    $status = $row['status'];

    // Perform action based on block_no and status
    if ($status == 1) {
        echo "1,Block";
    } else {
        echo "0,Not_Block";
    }
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
