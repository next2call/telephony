<?php
include "../../../conf/db.php";
include "../../../conf/url_page.php";
// $id_w_url = "https://103.113.27.163/vicidial-master/admin/index.php";
// echo '</br>';

if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    $group_id = $_REQUEST['group_id'];
    // $pid = $_REQUEST['pid'];
    // echo $id;
    $usersql = "DELETE FROM `vicidial_menu_group` WHERE id='$id'";
    mysqli_query($con, $usersql);

    //    echo '</br>';
    $usersql_2 = "DELETE FROM `group_agent` WHERE group_id='$group_id'";
    $usersresult = mysqli_query($con, $usersql_2);
    if ($usersresult) {
        header("Location:$id_w_url?c=user_group&v=show_user_menu_group");
    } else {
        header("Location:$id_w_url?c=user_group&v=show_user_menu_group");
    }
    // exit(); // Ensure the script stops executing after the redirection
}
?>
 