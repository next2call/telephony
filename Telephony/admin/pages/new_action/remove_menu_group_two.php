<?php
include "../../../conf/db.php";
include "../../../conf/url_page.php";

if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    $group_id = $_REQUEST['group_id'];
    $pid = $_REQUEST['pid'];
    // echo $id;
    $usersql = "DELETE FROM `menu_ivr_tbl2` WHERE id='$id'";
    mysqli_query($con, $usersql);

    $usersql_2q = "DELETE FROM `group_agent` WHERE group_id='$group_id'";
    mysqli_query($con, $usersql_2q);

    
    if ($usersresult) {
        // header("Location:$id_w_url?c=user_group&v=ivr_menu_group?id=$pid");
        header("Location:https://103.113.27.163/vicidial-master/admin/index.php?c=user_group&v=ivr_menu_group_one&id=$id");
    } else {
        // header("Location:$id_w_url?c=user_group&v=ivr_menu_group?id=$pid");
        header("Location:https://103.113.27.163/vicidial-master/admin/index.php?c=user_group&v=ivr_menu_group_one&id=$id");
    }
    // exit(); // Ensure the script stops executing after the redirection
}
?>
