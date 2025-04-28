<!DOCTYPE html>
<html>
<head>
    <title>Text-to-Speech Conversion</title>
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

<button onclick="openModal()">Open Form</button>

<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <form id="uploadForm" action="" method="post">
            Write text to convert:
            <textarea name="script" placeholder="Enter your text here"></textarea><br>
            <input type="submit" value="Convert" name="submit">
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById("myModal").style.display = "block";
    }

    function closeModal() {
        document.getElementById("myModal").style.display = "none";
    }
</script>

<?php
if(isset($_POST['submit'])){
    $text = $_POST['script']; // Get the entered text

    // Text-to-Speech API integration
    $apiUrl = 'https://ivrapi.indiantts.in/tts';
    $params = [
        'type' => 'indiantts',
        'text' => $text,
        'api_key' => '3c8e3150-1904-11ef-b58f-bd77d76bd7b6',
        'user_id' => '190224',
        'action' => 'play',
        'numeric' => 'hcurrency',
        'lang' => 'en', // Specify language code here
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
        $target_directory = "uploads/";
        $wav_file = $target_directory . uniqid() . '.wav';
        file_put_contents($wav_file, $response);
        
        // Output success message with download link
        echo "Speech generated successfully! <a href='$wav_file' download>Download WAV</a>";
    } else {
        echo "Error generating speech.";
    }
}
?>

</body>
</html>
