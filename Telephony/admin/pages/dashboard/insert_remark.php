<?php
include "../../../conf/db.php";
include "../../../conf/Get_time_zone.php";
session_start();
$user = $_SESSION['user'];
$date = date("Y-m-d h:i:s");

 $c_id = $_POST['c_id'];
 $c_remark_no = $_POST['c_remark_no'];
 $c_remark_comments = $_POST['c_remark_comments'];

 $update_one = "UPDATE `cdr` SET `agent_remark`='$c_remark_no',`remark_comments`='$c_remark_comments',`created_by`='$user',`created_time`='$date' WHERE id = $c_id";

// Execute the main user update query
$usersresult = mysqli_query($con, $update_one);
if ($usersresult) {
    echo "ok";
} else {
    echo "Not ok";
}

?>