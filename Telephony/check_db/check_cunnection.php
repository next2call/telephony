<?php
require_once '../conf/db.php';
require_once '../conf/Get_time_zone.php';
require_once '../conf/sql_operation.php';

// Check database connections securely
if (isset($con) && isset($conn)) {
    error_log("Database connection successful", 0); // Logs message instead of exposing it
    echo '✅Database connection is OK';
} else {
    error_log("Database connection failed", 0); // Logs failure
    echo '❌Database connection issue. Please try again later.';
    echo "👉 Please go to path (/Telephony/conf/db.php";
}
?>
