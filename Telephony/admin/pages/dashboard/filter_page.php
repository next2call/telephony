<?php
session_start();
include "../../../conf/db.php";
include "../../../conf/Get_time_zone.php";

$_SESSION['page_start'] = 'Report_page';  

$user_level = $_SESSION['user_level'];
$user = ($user_level == 2) ? $_SESSION['admin'] : $_SESSION['user'];

$get_data = $_POST['data'];
$filter_data =$_POST['filter_data'];
$date = date("Y-m-d");
$_SESSION['filter_type'] = $get_data;
$_SESSION['filter_data_ex'] = $filter_data;

// Initialize the SQL query
$tfnsel = "SELECT * FROM cdr WHERE admin = ?";
$parameters = [$user];

// Add date filter if necessary
if ($filter_data == 'today') {
    $tfnsel .= " AND DATE(start_time) = ?";
    $parameters[] = $date;
}

if ($get_data == 'total_call') {
    // No additional filter needed
} elseif ($get_data == 'other_call') {
    $tfnsel .= " AND status != 'CANCEL' AND status != 'ANSWER'";
} elseif ($get_data == 'answer_call') {
    $tfnsel .= " AND status = 'ANSWER'";
} elseif ($get_data == 'cancel_call') {
    $tfnsel .= " AND status = 'CANCEL'";
} elseif ($get_data == 'no_answer') {
    $tfnsel .= " AND status = 'NOANSWER'";
} elseif ($get_data == 'out_boundcall') {
    $tfnsel .= " AND direction = 'outbound'";
} elseif ($get_data == 'inbound_call') {
    $tfnsel .= " AND direction = 'inbound'";
} else {
    // Handle unexpected values
   
}

// Finalize the query
$tfnsel .= " ORDER BY id DESC";

$stmt = $con->prepare($tfnsel);
if ($filter_data == 'today') {
    $stmt->bind_param("ss", $parameters[0], $parameters[1]);
} else {
    $stmt->bind_param("s", $parameters[0]);
}
$stmt->execute();
$result = $stmt->get_result();

function format_duration($seconds) {
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    $seconds = $seconds % 60;
    return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
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
    .control span, .download-button i {
        font-size: 24px; /* Change the size as needed */
    }

    .select_date {
        margin-top: -2rem;
    }

    .img_answer {
        height: 1.2rem;
        width: 1.1rem;
    }
</style>

<div class="ml-5">
    <!-- Layout Start -->
    <div class="total-stats">
        <div class="ml-5">
            <h3><?php echo str_replace('_', ' ', strtoupper($get_data)); ?></h3>
            <div class="select">
                <a class="btn btn-success ml-2" href="pages/dashboard/filter_export_data.php">Export</a>
            </div>
        </div>
        <div class="container mt-4">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Call From</th>
                        <th>Number</th>
                        <th>Start time</th>
                        <th>End time</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th>Hangup</th>
                        <th>Direction</th>
                        <th>Recording URL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    while ($row = $result->fetch_assoc()):
                        $call_from = htmlspecialchars($row['call_from'], ENT_QUOTES, 'UTF-8');
                        $call_to = htmlspecialchars($row['call_to'], ENT_QUOTES, 'UTF-8');
                        $start_time = htmlspecialchars($row['start_time'], ENT_QUOTES, 'UTF-8');
                        $end_time = htmlspecialchars($row['end_time'], ENT_QUOTES, 'UTF-8');
                        $record_url = htmlspecialchars($row['record_url'], ENT_QUOTES, 'UTF-8');
                        $status = htmlspecialchars($row['status'], ENT_QUOTES, 'UTF-8');
                        $hangup = htmlspecialchars($row['hangup'], ENT_QUOTES, 'UTF-8');
                        $direction = htmlspecialchars($row['direction'], ENT_QUOTES, 'UTF-8');
                        $sec = (int) $row['dur'];
                        $duration = format_duration($sec);
                        $noly10 = htmlspecialchars(substr($call_from, 2), ENT_QUOTES, 'UTF-8');
                        $updatedUrl = str_replace("http://", "https://", $record_url);
                    ?>
                    <tr>
                        <td><?php echo $count++; ?></td>
                        <td>
                            <?php if ($direction == 'inbound'): ?>
                                <?php echo $call_from; ?>
                                <a type="button" data-callernumber="<?= $noly10 ?>" class="badge bg-primary clicktocall ml-2 cursor_p">
                                    <i class="fa fa-phone-square"></i>
                                </a>
                            <?php else: ?>
                                <?php echo $call_from; ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($direction == 'outbound'): ?>
                                <?php echo $call_to; ?>
                                <a type="button" data-callernumber="<?= htmlspecialchars($call_to, ENT_QUOTES, 'UTF-8') ?>" class="badge bg-primary clicktocall ml-2 cursor_p">
                                    <i class="fa fa-phone-square"></i>
                                </a>
                            <?php else: ?>
                                <?php echo $call_to; ?>
                            <?php endif; ?>
                        </td>
                        <td><?php echo $start_time; ?></td>
                        <td><?php echo $end_time; ?></td>
                        <td><?php echo $duration; ?></td>
                        <td><?php echo $status; ?></td>
                        <td><?php echo $hangup; ?></td>
                        <td><?php echo $direction; ?></td>
                        <td>
                            <audio class="audio-player" data-url="<?php echo $updatedUrl; ?>" src="<?php echo $updatedUrl; ?>" type="audio/wav"></audio>
                            <button class="control" type="button">
                                <span class="play-pause-icon">▶</span>
                            </button>
                            <a href="<?php echo $updatedUrl; ?>" download>
                                <button class="download-button" type="button">
                                    <i class="fa fa-download"></i>
                                </button>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Layout End -->
</div>

<script>
  var currentAudio = null;
var currentButton = null;

function aud_play_pause(button) {
    var audio = button.previousElementSibling;

    // If a different audio is already playing, pause it
    if (currentAudio && currentAudio !== audio) {
        currentAudio.pause();
        currentButton.querySelector('.play-pause-icon').textContent = '▶'; // Reset the icon of the previous button
    }

    // Toggle the play/pause state of the current audio
    if (audio.paused) {
        audio.play();
        button.querySelector('.play-pause-icon').textContent = '⏸'; // Update icon to "pause"
        currentAudio = audio;
        currentButton = button;
    } else {
        audio.pause();
        button.querySelector('.play-pause-icon').textContent = '▶'; // Update icon to "play"
        currentAudio = null;
        currentButton = null;
    }
}

// Add event listeners to all control buttons
document.querySelectorAll('.control').forEach(button => {
    button.addEventListener('click', function() {
        aud_play_pause(this);
    });
});

</script>
