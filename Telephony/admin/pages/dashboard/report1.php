<?php
session_start();
include "../../../conf/db.php";
include "../../../conf/Get_time_zone.php";

$_SESSION['page_start'] = 'Report_page';
$_SESSION['page_start'] = 'Report_page';
$user_level = $_SESSION['user_level'];
$new_campaign = $_SESSION['campaign_id'] ?? '';
if ($user_level == 2 || $user_level == 6 || $user_level == 7) {
    $user = $_SESSION['admin'];
    $new_user = $_SESSION['user'];
} else {
    $user = $_SESSION['user'];
}

if (isset($_POST['submit_search'])) {
    $agent_name = $_POST['agent_name'];
    $campains_id = $_POST['campains_id'];
    $cal_date = $_POST['cal_date'];
    $cal_date2 = $_POST['cal_date2'];
    if ((!empty($agent_name))) {
        $_SESSION['agent_name'] = $agent_name;
    } else {
        $_SESSION['agent_name'] = '';
    }
    if ((!empty($campains_id))) {
        $_SESSION['sel_campains_id'] = $campains_id;
    } else {
        $_SESSION['sel_campains_id'] = '';
    }
    if (!empty($cal_date) && !empty($cal_date2)) {
        $_SESSION['fromdate'] = $cal_date;
        $_SESSION['todate'] = $cal_date2;
    }


    if (!empty($agent_name) && !empty($cal_date) && !empty($cal_date2)  && empty($campains_id)) {
        $serch_type = 'date-agent';
    } elseif (!empty($agent_name) && empty($cal_date) && empty($cal_date2) && empty($campains_id)) {
        $serch_type = 'agent';
    } elseif (empty($agent_name) && !empty($cal_date) && !empty($cal_date2) && empty($campains_id)) {
        $serch_type = 'date';
    } elseif (!empty($campains_id) && !empty($cal_date) && !empty($cal_date2) && empty($agent_name)) {
        $serch_type = 'date-campaign';
    } elseif (!empty($campains_id) && empty($cal_date) && empty($cal_date2) && empty($agent_name)) {
        $serch_type = 'campaign';
    } elseif (!empty($campains_id) && !empty($cal_date) && !empty($cal_date2) && !empty($agent_name)) {
        $serch_type = 'date-agent-campaign';
    } elseif (!empty($campains_id) && empty($cal_date) && empty($cal_date2) && !empty($agent_name)) {
        $serch_type = 'agent-campaign';
    } 
//     echo "QQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQ".$serch_type. " , " . $agent_name . "  , " . $cal_date . "  , " . $campains_id;
// die();
    $_SESSION['serch_type'] = $serch_type;

} else {
    $_SESSION['agent_name'] = '';
    $_SESSION['sel_campains_id'] = '';
    $_SESSION['fromdate'] = '';
    $_SESSION['todate'] = '';
    $_SESSION['serch_type'] = '';
}


?>
<style>
    /* Style the audio player container */
    .audio-container {
        display: flex;
        align-items: center;
    }

    /* Style the play/pause button */
    .control {
        background: none;
        border: none;
        cursor: pointer;
    }

    /* Style the Download button and its icon */
    .download-button {
        background: none;
        border: none;
        cursor: pointer;
    }

    /* Adjust the size of the icons */
    .control span,
    .download-button i {
        font-size: 24px;
        /* Change the size as needed */
    }

    .select_date {
        margin-top: -2rem;
    }

    .img_answer {
        height: 1.2rem;
        width: 1.1rem;
    }

    table td {
        padding: 2px 10px !important;
    }
</style>

<div class="user-stats">

    <form action="" method="post">
        <div class="row my-card align-items-center">

            <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                <div class="my-dropdown">
                    <select name="agent_name" id="local_call_time">
                        <option value=""></option>
                        <?php
                        if ($user_level == '2') {
                            $sel_users = "select * from users WHERE admin = '$user' AND campaigns_id='$new_campaign' AND user_type = '1'";
                        } else if ($user_level == '9') {
                            $sel_users = "SELECT * FROM users WHERE user_type = '8' ORDER BY id DESC";
                        } else if ($user_level == 6 || $user_level == 7) {
                            $sel_users = "select * from users WHERE admin = '$user' AND user_type = '1'";
                        } else {
                            $sel_users = "select * from users WHERE admin = '$user' AND user_id != '$user' AND user_type = '1'";
                        }
                        $sel_users_query = mysqli_query($con, $sel_users);
                        while ($users_row = mysqli_fetch_array($sel_users_query)) {
                            ?>
                            <option value="<?= $users_row['user_id'] ?>"><?= $users_row['full_name'] ?></option>
                        <?php } ?>
                    </select>
                    <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                    <label for="local_call_time">Select Agent</label>
                </div>
            </div>
            <?php if($user_level != '2'){ ?>
            <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                <div class="my-dropdown">
                    <select name="campains_id" id="local_call_time">
                        <option value=""></option>
                        <?php
                        if ($user_level == '2') {
                            $sel_cam = "SELECT `compaign_id`, `compaignname` FROM `compaign_list` WHERE compaign_id='$new_campaign'";
                        } else if ($user_level == '9') {
                            $sel_cam = "SELECT `compaign_id`, `compaignname` FROM `compaign_list` ORDER BY id DESC";
                        } else if ($user_level == 6 || $user_level == 7) {
                            $sel_cam = "SELECT `compaign_id`, `compaignname` FROM `compaign_list` WHERE `admin` = '$user' ORDER BY id DESC";
                        } else {
                            $sel_cam = "SELECT `compaign_id`, `compaignname` FROM `compaign_list` WHERE `admin` = '$user' ORDER BY id DESC";
                        }
                        $sel_cam_query = mysqli_query($con, $sel_cam);
                        while ($cam_row = mysqli_fetch_array($sel_cam_query)) {
                            ?>
                            <option value="<?= $cam_row['compaign_id'] ?>"><?= $cam_row['compaignname'] ?></option>
                        <?php } ?>
                    </select>
                    <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                    <label for="local_call_time">Select Campaign</label>
                </div>
            </div>
            <?php } ?>
            <div class="my-input-with-help col-12 col-md-6 col-lg-3">
                <div class="form-group my-input">
                    <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')"
                        class="form-control str_date" id="str_date" name="cal_date" aria-describedby="begin_date">
                    <label for="begin_date">From Date</label>
                </div>
            </div>

            <div class="my-input-with-help col-12 col-md-6 col-lg-3">
                <div class="form-group my-input">
                    <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')"
                        class="form-control str_date2" id="end_date" name="cal_date2" aria-describedby="end_date">
                    <label for="end_date">To Date</label>
                </div>
            </div>
            <button class="btn btn-primary ml-5" type="submit" name="submit_search">Search</button>

        </div>
    </form>

    <div class="my-card-with-title">
        <div class="title-bar">
            <h4>Total Call Reports</h4>
            <?php
            // if ($user_level != 9) { 
            ?>
            <a class="btn btn-success ml-2 text-white" href="pages/dashboard/export_data.php">Export</a>
            <?php
            //  } 
            ?>

        </div>
        <div class="table-responsive">
            <table id="employee_grid" class="table table-bordered table-striped table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">SR.</th>
                        <th scope="col">Agent Name</th>
                        <th scope="col">Agent ID</th>
                        <th scope="col">Call From</th>
                        <th scope="col">Call To</th>
                        <th scope="col">Campaign Name</th>
                        <th scope="col">Start time</th>
                        <th scope="col">Duration</th>
                        <th scope="col">Direction</th>
                        <th scope="col">Status</th>
                        <th scope="col">Hangup</th>
                        <th scope="col">Recordings</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.0.1/js/dataTables.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
<link rel="stylesheet" href="../assets/css/dataTables.dataTables.min.css" />

<script type="text/javascript">
    $.noConflict();
    jQuery(document).ready(function ($) {
        $('#employee_grid').DataTable({
            "pageLength": 100,
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "pages/dashboard/datatables-ajax/ajaxfile.php",
                type: "post",
                error: function () {
                    $("#employee_grid_processing").css("display", "none");
                }
            },
            "columns": [
                { "data": "sr" },
                { "data": "full_name" },
                {
                    "data": "call_to",
                    render: function (data, type, row) {
                        var html = '<div>';
                        html += data;
                        html += '<a type="button" data-callernumber="' + data + '" class="badge bg-primary clicktocall ml-2 cursor_p">';
                        html += '<i class="fa fa-phone-square"></i>';
                        html += '</a>';

                        html += '</div>';
                        return html;
                    }
                },
                {
                    "data": "call_from",
                    render: function (data, type, row) {
                        if (data) {
                            var html = '<div>';
                            if (row.direction == 'inbound') {
                                html += data;
                                html += '<a type="button" data-callernumber="' + data + '" class="badge bg-primary clicktocall ml-2 cursor_p">';
                                html += '<i class="fa fa-phone-square"></i>';
                                html += '</a>';
                                html += '<a type="button" title="Click here and Block This number" class="badge bg-info ml-2 cursor_p num_block" data-number="' + data + '"><i class="fa fa-ban text-danger"></i> </a>';
                            } else {
                                html += data;
                            }
                            html += '</div>';
                            return html;
                        } else {
                            return '';
                        }
                    }
                },
                {
                    "data": "did",
                    render: function (data, type, row) {
                        if (data) {
                            var html = '<div>';
                            if (row.direction == 'outbound') {
                                html += data;
                                html += '<a type="button" data-callernumber="' + data + '" class="badge bg-primary clicktocall ml-2 cursor_p">';
                                html += '<i class="fa fa-phone-square"></i>';
                                html += '</a>';
                                html += '<a type="button" title="Click here and Block This number" class="badge bg-info ml-2 cursor_p num_block" data-number="' + data + '"><i class="fa fa-ban text-danger"></i> </a>';
                            } else {
                                html += data;
                            }
                            html += '</div>';
                            return html;
                        } else {
                            return '';
                        }
                    }
                },
                { "data": "compaignname" },
                { "data": "start_time" },
                { "data": "dur" },
                { "data": "direction" },
                { "data": "status" },
                { "data": "hangup" },
                {
                    "data": "record_url",
                    render: function (data, type, row) {
                        var audioUrl = data.replace('http://', 'https://');
                        var html = '<td>' +
                            '<audio class="audio-player" id="myTune">' +
                            '<source src="' + audioUrl + '" type="audio/wav">' +
                            '</audio>' +
                            '<button class="control" type="button" onclick="aud_play_pause(this)">' +
                            '<span class="play-pause-icon">▶</span>' +
                            '</button>' +
                            '<a href="' + audioUrl + '" download>' +
                            '<button class="download-button" type="button">' +
                            '<i class="fa fa-download"></i>' +
                            '</button>' +
                            '</a>' +
                            '</td>';
                        return html;
                    }
                }
            ]
        });
    });
</script>
<script>
    var currentAudio = null;

    function aud_play_pause(button) {
        var audio = button.previousElementSibling;

        if (currentAudio !== audio) {
            if (currentAudio) {
                currentAudio.pause();
                var currentPlayPauseIcon = currentAudio.nextElementSibling.querySelector('.play-pause-icon');
                currentPlayPauseIcon.textContent = '▶';
            }
            currentAudio = audio;
        }

        if (currentAudio.paused) {
            currentAudio.play();
            var playPauseIcon = button.querySelector('.play-pause-icon');
            playPauseIcon.textContent = '⏸';
        } else {
            currentAudio.pause();
            var playPauseIcon = button.querySelector('.play-pause-icon');
            playPauseIcon.textContent = '▶';
        }
    }
</script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $(document).on("click", ".num_block", function () {
            var number = $(this).data("number");
            // alert(number);
            Swal.fire({
                title: "Are you sure?",
                text: "This Number will be Blocked",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, block"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "pages/new_action/number_blocked.php?number=" + number;
                }
            });
        });
    });
</script>