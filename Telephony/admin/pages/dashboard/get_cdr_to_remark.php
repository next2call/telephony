<?php
include "../../../conf/db.php";
include "../../../conf/Get_time_zone.php";

if (isset($_REQUEST['data_id'])) {
    $data_id = $_REQUEST['data_id'];

    // Corrected SQL query with proper syntax
    $usersql2 = "
        SELECT 
            cdr.*, 
            IFNULL(users.full_name, 'NONE') AS full_name,
            IFNULL(users.campaigns_id, 'NONE') AS campaigns_id,
            IFNULL(compaign_list.compaignname, 'NONE') AS compaignname 
        FROM cdr
        LEFT JOIN users ON users.user_id = cdr.call_to
        LEFT JOIN compaign_list ON compaign_list.compaign_id = users.campaigns_id
        WHERE cdr.id = ?
    ";

    // Prepare and execute the query
    $stmt = $con->prepare($usersql2);

    if ($stmt === false) {
        echo json_encode(['error' => 'Failed to prepare the statement: ' . $con->error]);
        exit;
    }

    $stmt->bind_param('s', $data_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'No data found']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'data_id not provided']);
}

$con->close();
?>
