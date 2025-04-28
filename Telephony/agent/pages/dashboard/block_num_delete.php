<?php
require '../../../conf/db.php';
    $delete_id = $_POST['delete_id'];
    $delete_sql = "DELETE FROM `block_no` WHERE id='$delete_id'";
    $delete_result = mysqli_query($con, $delete_sql);

    if($delete_result){
        echo 'success';
    } else {
        echo 'error';
    }
?>