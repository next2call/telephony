<?php
include "../../../conf/db.php";

if(isset($_POST['cnumber'])) {
    $id = $_POST['cnumber'];
    // echo $id;
    $usersql2 = "SELECT * FROM `dispo` WHERE id='$id'"; 
    $usersresult = mysqli_query($con, $usersql2);
    $row = mysqli_fetch_assoc($usersresult);
    $dispo = $row["dispo"];
    echo $dispo; // Sending the full name back as the response
}
?>
