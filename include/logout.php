<?php
// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start the session
session_start();
session_unset();
session_destroy();


// Redirect before destroying the session
header("Location: ../view/index.php");

exit();



?>


