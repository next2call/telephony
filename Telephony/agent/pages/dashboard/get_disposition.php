<?php
require '../../../conf/db.php';
include "../../../conf/Get_time_zone.php";
if(isset($_POST['id'])) {
    $id = $_POST['id'];
    // echo $id;
    // $usersql2 = "SELECT * FROM `call_notes` WHERE Id='$id'"; 
    // $usersresult = mysqli_query($con, $usersql2);
    // $row = mysqli_fetch_assoc($usersresult);
    // $disposition = $row["disposition"];
    // // $massage = $row["massage"];
    
    // echo $disposition; // Sending the full name back as the response

    $tfnsel = "SELECT * FROM `call_notes` WHERE Id='$id'";
    $data = mysqli_query($con, $tfnsel);

    if (mysqli_num_rows($data) > 0) {
        $row = mysqli_fetch_array($data);
        echo json_encode($row);
    } else {
        echo "Disposition not found";
    }
    
}


?>
