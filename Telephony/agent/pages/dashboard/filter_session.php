<?php
session_start();
include "../../../conf/Get_time_zone.php";
// Set session variable based on filter_data
if (isset($_POST['filter_data']) && $_POST['filter_data'] == 'all') {
    
    $_SESSION['filter_data'] = $_POST['filter_data'];
    echo json_encode(['status' => 'success']);
} elseif(isset($_POST['filter_data']) && $_POST['filter_data'] == 'today') {

    $_SESSION['filter_data'] = $_POST['filter_data'];
    echo json_encode(['status' => 'success']);


}else{
    echo json_encode(['status' => 'error', 'message' => 'No filter data provided']);   
}
?>
