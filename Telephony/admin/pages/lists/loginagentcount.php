<?php
session_start();
include "../../../conf/db.php";
include "../../../conf/Get_time_zone.php";
header('Content-Type: application/json');

 $Adminuser = $_SESSION['user'];
// echo "</br>";

 $date = date("Y-m-d");

// echo "</br>";


     $usersql2 = "SELECT COUNT(*) as user_id FROM `users` JOIN login_log ON users.user_id = login_log.user_name WHERE login_log.status = '1' AND log_in_time LIKE '%$date%' AND users.admin='$Adminuser' AND users.user_id!='$Adminuser'";
    // $usersql2 = "SELECT COUNT(*) as user_id FROM `users` JOIN login_log ON  users.user_id=login_log.user_name  WHERE login_log.status='1' AND log_in_time like '%$date%'";
    $stmt = $con->prepare($usersql2);
    $stmt->bind_param('i', $list_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    echo json_encode(['count' => $row['user_id']]);


$con->close();
?>
