<?php
include "../../../conf/url_page.php";
$mohdi = $_REQUEST['mohdi'];
$campaign_id = $_REQUEST['campaign_id'];

$new_moh_class = [
    'custom-'.$campaign_id => '/srv/www/htdocs/'.$main_folder.'/admin/ivr/' . $mohdi,
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

// Merge the new MOH class with the existing ones
$moh_classes = array_merge($existing_moh_classes, $new_moh_class);

// Open the file for writing
$file = fopen($file_path, 'w');
if ($file === false) {
    die("Unable to open or create $file_path");
}

// Write the MOH classes to the file
foreach ($moh_classes as $class => $directory) {
    fwrite($file, "[$class]\n");
    fwrite($file, "mode=files\n");
    fwrite($file, "directory=$directory\n");
    fwrite($file, "random=no\n\n");
}

// Close the file
fclose($file);

echo "custom_moh.conf has been updated successfully.\n";

// Rebuild and reload Vicidial and Asterisk configuration
exec('sudo /usr/share/astguiclient/ADMIN_update_server_ip.pl', $output, $return_var);
exec('sudo /usr/share/astguiclient/ADMIN_keepalive_ALL.pl --astguiclient', $output, $return_var);

// Reload the Asterisk MOH configuration
exec('sudo asterisk -rx "moh reload"', $output, $return_var);

// Check if the command was successful
if ($return_var === 0) {
    echo "Asterisk MOH configuration reloaded successfully.\n";
} else {
    echo "Failed to reload Asterisk MOH configuration.\n";
    echo "Command output:\n" . implode("\n", $output);
}

?>
