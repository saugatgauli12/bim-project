<?php
session_start();
session_unset();
session_destroy();

// Optional: include config if using $base_url
// include '../includes/config.php';

// Redirect to login page
header("Location: login.php");
exit;
