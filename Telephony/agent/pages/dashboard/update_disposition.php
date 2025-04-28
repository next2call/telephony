<?php
require '../../../conf/db.php';

// if(isset($_POST['update_dispo'])) {
    $disposition = $_POST['disposition'];
    $disposition_id = $_POST['disposition_id'];
    $call_notes = $_POST['call_notes'];

    // Update query with corrected syntax
    echo $tfnsel = "UPDATE `call_notes` SET `massage`='$call_notes', `disposition`='$disposition' WHERE Id='$disposition_id'";
    $data = mysqli_query($con, $tfnsel);

    if ($data) {
        // echo json_encode(array("status" => "success"));
        echo "insert";
    } else {
        // echo json_encode(array("status" => "error"));
        echo "Not_insert";
    }
// }

echo "hello";
?>
