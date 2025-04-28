<?php
session_start();
$user_level = $_SESSION['user_level'];

if ($user_level == 2) {
    $Adminuser = $_SESSION['admin'];
    $new_user = $_SESSION['user'];
} else {
    $Adminuser = $_SESSION['user'];
}
require '../include/user.php';
include "../../../conf/db.php";
include "../../../conf/url_page.php";
include "../../../conf/Get_time_zone.php";

$user = new user();
$usersql = "Select user,user_id, full_name, user_level, user_group, active from vicidial_users";

$usersql2 = "SELECT * FROM `texttospeech` WHERE admin='$Adminuser' ORDER BY id DESC";
$selcam = "SELECT * FROM `compaign_list` WHERE admin='$Adminuser'";

$usersresult = mysqli_query($con, $usersql2);
$sqlcam = mysqli_query($con, $selcam);



$eUser = "";
$full_name = "";
$user_level = "";
$user_group = "";
$pass = "";
$error = 0;



if (isset($_POST['create_speech'])) {
    $text = $_POST['script']; // Get the entered text
    $campaign = $_POST['campaign'];
    $lang = $_POST['lang'];
    $type = $_POST['type'];

    // Text-to-Speech API integration
    $apiUrl = 'https://ivrapi.indiantts.in/tts';
    $params = [
        'type' => 'indiantts',
        'text' => $text,
        'api_key' => '101200b0-2710-11ef-b58f-bd77d76bd7b6',
        'user_id' => '190495',
        'action' => 'play',
        'numeric' => 'digit',
        'lang' => $lang, // Specify language code here
        'samplerate' => '8000',
        'ver' => '3'
    ];

    // Make API request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    // Handle API response
    if ($response) {
        // Save the WAV file
        $target_directory = "ivr/";

        // Check if directory exists, if not create it
        if (!is_dir($target_directory)) {
            mkdir($target_directory, 0777, true);
        }

        // Generate unique file name
        if ($type == 'moh') {
            $new_df_name = uniqid();
            $target_directory2 = "ivr/" . $new_df_name . "/";
            if (!is_dir($target_directory2)) {
                mkdir($target_directory2, 0777, true);
            }
            $wav_file = $target_directory2 . $new_df_name . '.wav';
        } else {
            $wav_file = $target_directory . uniqid() . '.wav';
        }
        // echo "QQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQ".$wav_file;
        // die();
        // Save the file and check for errors
        if (file_put_contents($wav_file, $response) !== false) {
            // Insert into texttospeech table
            $currentDateTime = date('Y-m-d H:i:s');
            $insert = "INSERT INTO texttospeech(file_name, type, date, status, campaign_name, admin) VALUES('$wav_file', '$type', '$currentDateTime', '1', '$campaign', '$Adminuser')";
            if (!mysqli_query($con, $insert)) {
                echo "Error inserting into texttospeech: " . mysqli_error($con);
            } else {
                // Update campaign list
                if (!empty($campaign)) {
                    if ($type == 'welcome') {
                        $column_name = 'welcome_ivr';
                    } elseif ($type == 'moh') {

                        $new_moh_class = [
                            'custom-' . $campaign => '/srv/www/htdocs/' . $main_folder . '/admin/ivr/' . $new_df_name,
                        ];

                        // Path to the musiconhold.conf file
                        $file_path = '/etc/asterisk/musiconhold.conf';

                        // Read the existing contents of the file
                        $existing_content = '';
                        if (file_exists($file_path)) {
                            $existing_content = file_get_contents($file_path);
                        }

                        // Parse the existing MOH classes
                        $existing_moh_classes = [];
                        if ($existing_content !== false) {
                            $lines = explode("\n", $existing_content);
                            $current_class = null;
                            foreach ($lines as $line) {
                                if (preg_match('/^\[(.+)\]$/', trim($line), $matches)) {
                                    $current_class = $matches[1];
                                } elseif ($current_class && preg_match('/^directory=(.+)$/', trim($line), $matches)) {
                                    $existing_moh_classes[$current_class] = $matches[1];
                                    $current_class = null;
                                }
                            }
                        }

                        $moh_classes = array_merge($existing_moh_classes, $new_moh_class);

                        $file = fopen($file_path, 'w');
                        if ($file === false) {
                            die("Unable to open or create $file_path");
                        }

                        foreach ($moh_classes as $class => $directory) {
                            fwrite($file, "[$class]\n");
                            fwrite($file, "mode=files\n");
                            fwrite($file, "directory=$directory\n");
                            fwrite($file, "random=no\n\n");
                        }

                        fclose($file);

                        $stmtA = "UPDATE servers SET rebuild_conf_files='Y' where generate_vicidial_conf='Y' and active_asterisk_server='Y' and server_ip='192.168.125.241' OR server_ip='103.113.27.163'";
                        $selstm = "SELECT active FROM vicidial_music_on_hold WHERE moh_id='vicidial_master'";
                        $sqlsel = mysqli_query($conn, $selstm);
                        $sql_row = mysqli_fetch_assoc($sqlsel);
                        $activestatus = $sql_row['active'];
                        if ($activestatus == 'Y') {
                            $active = 'N';
                        } else {
                            $active = 'Y';
                        }
                        $stmtA1 = "UPDATE vicidial_music_on_hold SET active='$active' where moh_id='vicidial_master'";
                        mysqli_query($conn, $stmtA1);
                        mysqli_query($conn, $stmtA);

                        $column_name = 'music_on_hold';
                    } else {
                        $column_name = 'after_office_ivr';
                    }
                    $up_ivr_cam = "UPDATE compaign_list SET $column_name='$wav_file' WHERE compaign_id='$campaign'";
                    if (!mysqli_query($con, $up_ivr_cam)) {
                        echo "Error updating campaign list: " . mysqli_error($con);
                    }
                }

                // Success message
                echo '
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
                <script>
                window.onload = function() {
                    Swal.fire({
                        icon: "success",
                        title: "Audio file has been saved as ' . $file . '",
                        confirmButtonText: "OK"
                    }).then(() => {
                        window.location.href = "' . $admin_ind_page . '?c=dashboard&v=ivr_converter";
                    });
                };                
                </script>';
            }
        } else {
            echo "Error saving the WAV file.";
        }
    } else {
        echo "Error generating speech.";
    }
}


if (isset($_POST['assign_speech'])) {
    $currentDateTime = date('Y-m-d H:i:s');
    $campaign = $_POST['campaign'];
    $type = $_POST['type'];
    $old_type = $_POST['old_type'];
    $sel_speech_id = $_POST['sel_speech_id'];
    $sel_speech_name = $_POST['sel_speech_name'];
    $file_name_with_extension = pathinfo($sel_speech_name, PATHINFO_FILENAME);

    if ($type == 'welcome') {
        $column_name = 'welcome_ivr';
    } elseif ($type == 'moh') {

        $new_moh_class = [
            'custom-' . $campaign => '/srv/www/htdocs/' . $main_folder . '/admin/ivr/' . $file_name_with_extension,
        ];

        // Path to the musiconhold.conf file
        $file_path = '/etc/asterisk/musiconhold.conf';

        // Read the existing contents of the file
        $existing_content = '';
        if (file_exists($file_path)) {
            $existing_content = file_get_contents($file_path);
        }

        // Parse the existing MOH classes
        $existing_moh_classes = [];
        if ($existing_content !== false) {
            $lines = explode("\n", $existing_content);
            $current_class = null;
            foreach ($lines as $line) {
                if (preg_match('/^\[(.+)\]$/', trim($line), $matches)) {
                    $current_class = $matches[1];
                } elseif ($current_class && preg_match('/^directory=(.+)$/', trim($line), $matches)) {
                    $existing_moh_classes[$current_class] = $matches[1];
                    $current_class = null;
                }
            }
        }

        $moh_classes = array_merge($existing_moh_classes, $new_moh_class);

        $file = fopen($file_path, 'w');
        if ($file === false) {
            die("Unable to open or create $file_path");
        }

        foreach ($moh_classes as $class => $directory) {
            fwrite($file, "[$class]\n");
            fwrite($file, "mode=files\n");
            fwrite($file, "directory=$directory\n");
            fwrite($file, "random=no\n\n");
        }

        fclose($file);
        $stmtA = "UPDATE servers SET rebuild_conf_files='Y' where generate_vicidial_conf='Y' and active_asterisk_server='Y' and server_ip='192.168.125.241' OR server_ip='103.113.27.163'";
        $selstm = "SELECT active FROM vicidial_music_on_hold WHERE moh_id='vicidial_master'";
        $sqlsel = mysqli_query($conn, $selstm);
        $sql_row = mysqli_fetch_assoc($sqlsel);
        $activestatus = $sql_row['active'];
        if ($activestatus == 'Y') {
            $active = 'N';
        } else {
            $active = 'Y';
        }
        $stmtA1 = "UPDATE vicidial_music_on_hold SET active='$active' where moh_id='vicidial_master'";
        mysqli_query($conn, $stmtA1);
        mysqli_query($conn, $stmtA);

        $column_name = 'music_on_hold';
    } else {
        $column_name = 'after_office_ivr';
    }
    //  echo "qqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqq".$campaign.",".$type.",".$sel_speech_id.",".$sel_speech_name.",".$column_name.",".$old_type;

    $insert = "INSERT INTO texttospeech(file_name, type, date, status, campaign_name, admin) VALUES('$sel_speech_name', '$type', '$currentDateTime', '1', '$campaign', '$Adminuser')";
    if ($old_type == $type) {

        if (!mysqli_query($con, $insert)) {
            echo "Error updating campaign list: " . mysqli_error($con);
        } else {
            $up_ivr_cam = "UPDATE compaign_list SET $column_name='$sel_speech_name' WHERE compaign_id='$campaign'";
            mysqli_query($con, $up_ivr_cam);

            // Success message
            echo '
         <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
         <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
         <script>
         window.onload = function() {
             Swal.fire({
                 icon: "success",
                 title: "Audio file has been saved as ' . $sel_speech_name . '",
                 confirmButtonText: "OK"
             }).then(() => {
                 window.location.href = "' . $admin_ind_page . '?c=dashboard&v=ivr_converter";
             });
         };                
         </script>';

        }
    } else {
        echo "Error : Select Same speech Type ! Try Again";
    }
}
?>




<style>
    .data_btn {
        background: #d1e1ff;
        color: #284f99;
        font-weight: bold;
        font-size: 16px;
        line-height: 22px;
        /* color: #637381; */
        /* background: transparent; */
        border-radius: 10px;
        padding: 15px;
        margin-right: 25px;
        transition: 0.3s all ease-in-out;
        margin-top: 25px;
        display: inline-block;
    }

    .data_btn1 {
        background: #dfcbea;
        color: #284f99;
        font-weight: bold;
        font-size: 16px;
        line-height: 22px;
        /* color: #637381; */
        /* background: transparent; */
        border-radius: 10px;
        padding: 15px;
        margin-right: 25px;
        transition: 0.3s all ease-in-out;
        margin-top: 25px;
        display: inline-block;
    }

    .data_btn2 {
        background: #f6dfce;
        color: #284f99;
        font-weight: bold;
        font-size: 16px;
        line-height: 22px;
        /* color: #637381; */
        /* background: transparent; */
        border-radius: 10px;
        padding: 15px;
        margin-right: 25px;
        transition: 0.3s all ease-in-out;
        margin-top: 25px;
        display: inline-block;
    }

    .table-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .data_btn {
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
    }

    .data_btn:hover {
        background-color: #0056b3;
    }

    #search {
        padding: 5px;
        width: 200px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
</style>
<div>
    <div class="show-users ml-5">

        <!-- user list table start -->
        <div class="table-responsive my-table ml-5">
            <div class="table-top d-flex">
                <a class="data_btn" href="#create-speech" data-toggle="modal" data-target="#create-speech">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i> Create Speech
                </a>
                <input type="text" name="search" id="search" placeholder="Search...">
            </div>
            <table class="all-user-table table table-hover all-user-table">
                <thead>
                    <tr>
                        <th scope="col"><a href="#">SR NO.</a></th>
                        <!-- <th scope="col"><a href="#">FILE NAME</a></th> -->
                        <th scope="col"><a href="#">TYPE</a></th>
                        <th scope="col"><a href="#">CAMPAIGN</a></th>
                        <th scope="col"><a href="#">FILE</a></th>
                        <th scope="col"><a href="#">DATE</a></th>
                        <th scope="col"><a href="#">ACTION</a></th>
                    </tr>
                </thead>
                <tbody>

                </tbody>

            </table>
        </div>
        <!-- user list table ends -->

    </div>
</div>

<!-- Copy user modal starts here -->

<!-- Add user modal starts here -->
<div class="modal fade" id="create-speech" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div style="min-width: 1080px;" class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create New Speech</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="form-group my-input">
                                <textarea class="form-control" rows="5" name='script'
                                    placeholder="Welcome to Winet Infratel. We prioritize customer needs with 24/7 support."
                                    id="con_name-d" required></textarea>
                            </div>
                        </div>
                        <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                            <div class="my-dropdown">
                                <select id="lang" name="lang">
                                    <!-- Add all language options here -->
                                    <option value="hi_male_v1" selected>Hindi (Male 1)</option>
                                    <option value="hi_female_v1">Hindi (Female)</option>
                                    <option value="hi_male_v2">Hindi (Male 2)</option>
                                    <option value="en_male_v1">English (Male)</option>
                                    <option value="en_female_v1">English (Female 1)</option>
                                    <option value="en_female_v4">English (Female 2)</option>
                                    <option value="en_female_v6">English (Female 3)</option>
                                    <option value="en_female_v7">English (Female 4)</option>
                                    <option value="gu_female_v2">Gujarati (Female 1)</option>
                                    <option value="gu_female_v1">Gujarati (Female 2)</option>
                                    <option value="mr_female_v1">Marathi (Female)</option>
                                    <option value="ta_female_v1">Tamil (Female)</option>
                                    <option value="kn_female_v1">Kannada (Female)</option>
                                    <option value="te_female_v1">Telugu (Female)</option>
                                    <option value="or_female_v1">Oriya (Female)</option>
                                    <option value="or_male_v1">Oriya (Male)</option>
                                    <option value="pn_female_v1">Panjabi (Female)</option>
                                    <option value="as_female_v1">Assamese (Female)</option>
                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="SelectLanguage">Select Language</label>
                            </div>
                        </div>
                        <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                            <div class="my-dropdown">
                                <select name="type">
                                    <option selected value="welcome">welcome IVR</option>
                                    <option selected value="AfterOffice">After Office IVR</option>
                                    <option value="moh">MOH FILE</option>
                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="SelectType">Select Type</label>
                            </div>
                        </div>
                        <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                            <div class="my-dropdown">
                                <select name="campaign">
                                    <?php
                                    // Ensure you have a database connection and a valid query
                                    while ($user_row1 = mysqli_fetch_array($sqlcam)) {
                                        if (mysqli_num_rows($sqlcam) == 1) {
                                            echo '<option value="' . $user_row1['compaign_id'] . '" selected>' . $user_row1['compaignname'] . '</option>';
                                        } else {
                                            echo '<option value="' . $user_row1['compaign_id'] . '">' . $user_row1['compaignname'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="SelectCampaign">Select Campaign</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary my-btn-secondary"
                        data-dismiss="modal">Cancel</button>
                    <input class="my-btn-primary" type="submit" value="submit" name="create_speech">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add user name for user id modal ends here -->

<!-- Assaign speech modal starts here -->
<div class="modal fade" id="assign_speech" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div style="min-width: 800px;" class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Assign Speech</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="my-dropdown-with-help col-12 col-md-6 col-lg-6">
                            <div class="my-dropdown">
                                <select name="type">
                                    <option selected value="welcome">welcome IVR</option>
                                    <option selected value="AfterOffice">After Office IVR</option>
                                    <option value="moh">MOH FILE</option>
                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="SelectType">Select Type</label>
                            </div>
                        </div>
                        <input type="hidden" name="sel_speech_id" id="sel_speech_id">
                        <input type="hidden" name="sel_speech_name" id="sel_speech_name">
                        <input type="hidden" name="old_type" id="old_type">
                        <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                            <div class="my-dropdown">
                                <select name="campaign">
                                    <?php
                                    $selcam2 = "SELECT * FROM compaign_list  WHERE admin='$Adminuser'";
                                    $sqlcam2 = mysqli_query($con, $selcam2);
                                    while ($user_row3 = mysqli_fetch_assoc($sqlcam2)) {
                                        if (mysqli_num_rows($sqlcam2) == 1) {
                                            echo '<option value="' . $user_row1['compaign_id'] . '" selected>' . $user_row1['compaignname'] . '</option>';
                                        } else {
                                            echo '<option value="' . $user_row3['compaign_id'] . '">' . $user_row3['compaignname'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                                <label for="SelectCampaign">Select Campaign</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary my-btn-secondary"
                        data-dismiss="modal">Cancel</button>
                    <input class="my-btn-primary" type="submit" value="submit" name="assign_speech">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Assaign speech modal ends here -->

<!-- Your modal HTML code -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $(document).on("click", ".show_break_report", function () {
            var id = $(this).data("id");
            var type = $(this).data("type");
            var file_name = $(this).data("file_name");
            // alert(id);
            Swal.fire({
                title: "Are you sure?",
                text: "This data is delete",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "delete_dir.php?id=" + id + "&type=" + type + "&file_name=" + file_name;
                }
            });
        });

        $(document).on("click", ".assign_speech", function () {
            var id = $(this).data("id");
            var file_name = $(this).data("file_name");
            var old_type = $(this).data("type");
            $("#sel_speech_id").val(id);
            $("#sel_speech_name").val(file_name);
            $("#old_type").val(old_type);

        });

    });
</script>
<script>
    $('#search').on('input', function () {
        var searchValue = $(this).val();
        $.ajax({
            url: 'pages/dashboard/search_ivr.php',
            method: 'POST',
            data: { search: searchValue },
            success: function (response) {
                $('.all-user-table tbody').html(response);
            }
        });
    });

    var searchValue = '';
    $.ajax({
        url: 'pages/dashboard/search_ivr.php',
        method: 'POST',
        data: { search: searchValue },
        success: function (response) {
            $('.all-user-table tbody').html(response);
        }
    });

</script>