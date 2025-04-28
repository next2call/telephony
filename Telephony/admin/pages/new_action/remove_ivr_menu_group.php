<?php
include "../../../conf/db.php";
include "../../../conf/url_page.php";
// $id_w_url = "https://103.113.27.163/vicidial-master/admin/index.php";
// echo '</br>';

if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    $group_id = $_REQUEST['group_id'];
    // echo '</br>';   
    $sel = "SELECT * FROM menu_ivr_tbl1 WHERE WHERE id='$id'";
    $sel_q = mysqli_query($con, $sel);
    $r_data = mysqli_fetch_assoc($sel_q);
    $menu_id = $r_data['menu_id'];
// echo '</br>';
    $usersql1 = "DELETE FROM `menu_ivr_tbl2` WHERE menu_ivr_id='$menu_id'";
    mysqli_query($con, $usersql2);

     $usersql = "DELETE FROM `menu_ivr_tbl1` WHERE id='$id'";
   $usersresult = mysqli_query($con, $usersql);
//    echo '</br>';

    $usersql_1 = "DELETE FROM `vicidial_group` WHERE menu_id='$menu_id'";
     mysqli_query($con, $usersql_1);

     $usersql_2 = "DELETE FROM `vicidial_menu_group` WHERE menu_id='$menu_id'";
     mysqli_query($con, $usersql_2);

    //    echo '</br>';
    $usersql_3 = "DELETE FROM `group_agent` WHERE group_id='$group_id'";
    ysqli_query($con, $usersql_3);


    if ($id) {
        header("Location:$id_w_url?c=user_group&v=ivr_menu_group");
    } else {
        header("Location:$id_w_url?c=user_group&v=ivr_menu_group"); 
    }
    // exit(); // Ensure the script stops executing after the redirection
}
?>
 