<?php
include "../../../conf/db.php";
include "../../../conf/Get_time_zone.php";
if (isset($_POST['cnumber'])) {
    $id = $_POST['cnumber'];
    $usersql2 = "SELECT * FROM `users` WHERE user_id=?";
    $stmt = $con->prepare($usersql2);
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'No data found']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'cnumber not provided']);
}

$con->close();
?>
