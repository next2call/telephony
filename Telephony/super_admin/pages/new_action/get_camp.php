<?php
include "../../../conf/db.php";

if(isset($_POST['cnumber'])) {
    $id = $_POST['cnumber'];
    $usersql2 = "SELECT * FROM `compaign_list` WHERE id='$id'";
    $usersresult = mysqli_query($con, $usersql2);
    
    // Check if data is retrieved successfully
    if($row = mysqli_fetch_assoc($usersresult)) {
        // Convert the row data to JSON and send it back as response
        echo json_encode($row);
    } else {
        // If no data found, send an empty response
        echo json_encode([]);
    }
} else {
    // If 'cnumber' is not set in POST data, send an empty response
    echo json_encode([]);
}
?>
