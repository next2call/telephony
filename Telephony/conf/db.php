<?php

define('DB_HOST','localhost');
define('DB_USER','cron');
define('DB_PASS','1234');
define('DB_NAME','asterisk');
define('NEW_DB_NAME','telephony_db');
$conn=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

$con=mysqli_connect(DB_HOST,DB_USER,DB_PASS,NEW_DB_NAME);
