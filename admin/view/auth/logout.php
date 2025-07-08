<?php
// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to the login page

$_SESSION['flash'] = ['type' => 'error', 'message' => "Successfully Logout!"];
header("Location: ../../../admin/view/auth/login.php");
echo "Name validation passed!";
exit();
