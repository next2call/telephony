<?php 
session_start();
$user_level = $_SESSION['user_level'];

if($user_level == 2){
    $user = $_SESSION['admin'];
    $new_user = $_SESSION['user'];
} else {
    $user = $_SESSION['user'];
}
include "../../../conf/db.php";
include "../../../conf/url_page.php";
include "../../../conf/Get_time_zone.php";

$search = $_POST['search'];
if(!empty($_POST['search'])){
    $sql = "SELECT * FROM `texttospeech` WHERE admin='$user' AND (`file_name` LIKE '%$search%' OR `type` LIKE '%$search%' OR `date` LIKE '%$search%' OR `status` LIKE '%$search%' OR `campaign_name` LIKE '%$search%' OR `admin` LIKE '%$search%')";
} else {
    $sql = "SELECT * FROM `texttospeech` WHERE admin='$user' ORDER BY id DESC";
}
$result = $con->query($sql);

if ($result->num_rows > 0) {
    $sr = 1;
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $sr . '</td>';
        echo '<td>' . $row["type"] . '</td>';
        echo '<td>' . $row["campaign_name"] . '</td>';
        echo '<td><audio controls><source src="/' . $main_folder . '/admin/' . $row['file_name'] . '" type="audio/wav">Your browser does not support the audio element.</audio></td>';
        echo '<td>' . $row["date"] . '</td>';
        ?>
        <td>
            <i class="fa fa-pencil-square cursor_p assign_speech" aria-hidden="true" data-toggle="modal"
               data-target="#assign_speech" data-id="<?= $row['id'] ?>"
               data-type="<?php echo $row['type']; ?>"
               data-file_name="<?php echo $row['file_name']; ?>"
               style="font-size:20px; color:blue;"></i>

            <i class="fa fa-trash cursor_p show_break_report" style="font-size:24px; color:red;"
               data-id="<?php echo $row['id']; ?>" data-type="<?php echo $row['type']; ?>"
               data-file_name="<?php echo $row['file_name']; ?>"
               title="You can click here to remove ivr file"></i>
        </td>
        <?php
        echo '</tr>';
        $sr++;
    }
} else {
    echo "<tr><td colspan='6'>No results found</td></tr>";
}

?>
