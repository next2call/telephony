<?php
include "../../../conf/db.php";
include "../../../conf/Get_time_zone.php";

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM `email_templates` WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('i', $id); // 'i' for integer
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode([
            "to_emails"  => $row["to_emails"],
            "subject"    => $row["subject"], // Fixed spelling mistake (was 'subjact')
            "email_body" => $row["email_body"]
        ]);
    } else {
        echo json_encode(["error" => "No data found"]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "ID not provided"]);
}

$con->close();
?>
