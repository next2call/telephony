<?php 
include "../../../conf/db.php";
include "../../../conf/Get_time_zone.php";
session_start();
$user_level = $_SESSION['user_level'];

if ($user_level == 7 || $user_level == 6 || $user_level == 2) {
    $Adminuser = $_SESSION['admin'];
    $new_user = $_SESSION['user'];
    $new_campaign = $_SESSION['campaign_id'];
} else {
    $Adminuser = $_SESSION['user'];
}

// Get the system IP address
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $Ip_Address = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $Ip_Address = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $Ip_Address = $_SERVER['REMOTE_ADDR'];
}

// Escape user inputs
$to_email = $con->real_escape_string($_POST['to_email']);
$subject_name = $con->real_escape_string($_POST['subject_name']);
$email_body = $_POST['email_body']; // Don't escape, let PHPMailer handle HTML
$date = date('Y-m-d H:i:s');

// Convert CSS styles to inline
function inlineCSS($html) {
    // Match CSS styles
    preg_match_all('/<style[^>]*>(.*?)<\/style>/is', $html, $matches);
    $css = implode(" ", $matches[1]);

    // Remove styles from HTML
    $html = preg_replace('/<style[^>]*>.*?<\/style>/is', '', $html);

    // Apply styles inline
    preg_match_all('/\.([\w-]+)\s*\{([^}]+)\}/', $css, $styleMatches, PREG_SET_ORDER);
    foreach ($styleMatches as $match) {
        $class = trim($match[1]);
        $styles = trim($match[2]);
        $html = preg_replace_callback(
            '/class=["\']([^"\']*\b' . preg_quote($class, '/') . '\b[^"\']*)["\']/i',
            function ($matches) use ($styles) {
                return 'style="' . $styles . '"';
            },
            $html
        );
    }

    return $html;
}

// Apply inline CSS to email body
$email_body = inlineCSS($email_body);

// Insert into database
$insert_db = "INSERT INTO `email_templates` (`to_emails`, `subject`, `email_body`, `Admin`, `Create_time`, `Ip_Address`) 
              VALUES ('$to_email','$subject_name','$email_body','$Adminuser','$date','$Ip_Address')";

// Execute query
$usersresult = mysqli_query($con, $insert_db);
if ($usersresult) {

    require '../../../smtp/PHPMailerAutoload.php';

    // Create PHPMailer instance
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Host = "smtp.hostinger.com";
    $mail->Port = 587;
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';

    // Use environment variables for security
    $mail->Username = getenv('SMTP_USER') ?: "abhijeet.jha@next2call.com";
    $mail->Password = getenv('SMTP_PASS') ?: "WRg$36#%$#";
    $mail->setFrom($mail->Username, "Telephony Notifications");

    // Set email subject and body
    $mail->Subject = $subject_name;
    $mail->Body = $email_body; // CKEditor HTML content with inline styles

    // Process multiple recipients (comma-separated emails)
    $email_list = explode(',', $to_email);
    $valid_emails = [];
    foreach ($email_list as $email) {
        $email = trim($email);
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $mail->addAddress($email);
            $valid_emails[] = $email;
        }
    }

    // Check if any valid emails exist
    if (empty($valid_emails)) {
        die("Error: No valid email addresses found.");
    }

    // Attempt to send the email
    if (!$mail->send()) {
        error_log("Mail error: " . $mail->ErrorInfo);
        echo "Email sending failed.";
    } else {
        // echo "Email sent successfully to: " . implode(", ", $valid_emails);
        echo "Email sent successfully";
    }
}
?>
