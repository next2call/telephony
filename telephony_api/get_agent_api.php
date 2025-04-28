<?php
include "db.php";
include "time_zone.php";
$date = date("Y-m-d H:i:s");

$admin_id = $_REQUEST['user_id'];
// $cli = "5058068656"; 

$sel = "SELECT users.user_id, users.user_type, users.campaigns_id 
FROM users 
JOIN live ON live.Agent != users.user_id 
WHERE users.admin = ? 
AND users.status = 'Y' 
AND users.user_type = '1' 
ORDER BY RAND();
";
if ($stmt = $new_con->prepare($sel)) {
    $stmt->bind_param('s', $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['user_id'];
        echo "1," . $user_id;
    } else {
        echo "0,Agent NOT FOUND";
    }
    $stmt->close();
} else {
    echo "0,Query preparation failed,0";
}
$new_con->close();
?>