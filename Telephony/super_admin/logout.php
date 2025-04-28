<?php
session_start();
print_r($_SESSION);
unset($_SESSION['user_level']);
unset($_SESSION['user']);
unset($_SESSION);
session_destroy();
header('location:../');
