<?php
include "../../../conf/db.php";
include "../../../conf/Get_time_zone.php";

// Ensure session variables are set
session_start();
if (!isset($_SESSION['user_level'])) {
    echo json_encode(['error' => 'Session expired or user level not set']);
    exit;
}

$user_level = $_SESSION['user_level'];
// $Adminuser = ($user_level == 2) ? $_SESSION['admin'] : $_SESSION['user'];
if($user_level == '8'){
    // $Adminuser = $_SESSION['admin'];
    $Adminuser = $_SESSION['user'];
}elseif($user_level == '7'){

    $Adminuser = $_SESSION['admin'];
    $new_user = $_SESSION['user'];

}elseif($user_level == '2'){ 

    $Adminuser = $_SESSION['admin'];
    $new_user = $_SESSION['user'];

}else{
    $Adminuser = $_SESSION['admin'];
    $new_user = $_SESSION['user'];
}

// Fetch all admins under the SuperAdmin
$get_admin_query = $con->prepare("SELECT admin FROM users WHERE SuperAdmin = ?");
$get_admin_query->bind_param("s", $Adminuser);
$get_admin_query->execute();
$get_admin_result = $get_admin_query->get_result();

$find_admin = [];
while ($row = $get_admin_result->fetch_assoc()) {
    $find_admin[] = $row['admin'];
}

// Check if any admins found
if (empty($find_admin)) {
    echo json_encode(['error' => 'No admins found for the given SuperAdmin']);
    exit;
}

// Dynamic query to fetch users based on priority
$user_type = '1'; // Replace with dynamic input if necessary
if (isset($_POST['agent_priorty'])) {
    $agent_priority = $_POST['agent_priorty'];
    $user_type = '1'; // Static or dynamic as needed

    $find_admin_list = implode("','", $find_admin);

    $tfnsel_pri_query = $con->prepare(
        "SELECT * FROM users WHERE admin IN ('$find_admin_list') AND user_type = ?"
    );
    $tfnsel_pri_query->bind_param("i", $user_type);
    $tfnsel_pri_query->execute();
    $data_pri_result = $tfnsel_pri_query->get_result();

    $options = [];
    while ($row = $data_pri_result->fetch_assoc()) {
        $options[] = [
            'value' => $row['agent_priorty'],
            'selected' => ($agent_priority == $row['agent_priorty']),
        ];
    }

    echo json_encode($options);
} else {
    echo json_encode(['error' => 'Priority not provided']);
}
$con->close();
?>
