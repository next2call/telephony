<?php
include "db.php";
include "time_zone.php";
$date = date("Y-m-d H:i:s");

$cli = $_REQUEST['cli'];
// $cli = "5058068656"; 
$sel = "SELECT users.user_id, users.user_type, users.campaigns_id, users.use_did, users.no_capping 
        FROM users
        JOIN campaign_user ON campaign_user.agent_id = users.user_id
        JOIN compaign_list ON compaign_list.compaign_id = campaign_user.campaign_id
        WHERE compaign_list.outbond_cli = ? AND users.no_capping > 1 ORDER BY campaign_user.id ASC";
if ($stmt = $new_con->prepare($sel)) {
    $stmt->bind_param('s', $cli);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_did = $row['use_did'];
        $user_id = $row['user_id'];
        echo "1," . $user_did . "," . $user_id;
    } else {
        echo "0,CLI NOT FOUND,0";
    }
    $stmt->close();
} else {
    echo "0,Query preparation failed,0";
}
$new_con->close();
?>