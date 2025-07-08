<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('db.php');
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Session expired. Please log in again.");
}

$user_id = (int) $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old_password = trim($_POST["old_password"]);
    $new_password = trim($_POST["new_password"]);
    $confirm_password = trim($_POST["confirm_password"]);

    if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
        $_SESSION['error'] = "All fields are required.";
        exit();
    }

    if ($new_password !== $confirm_password) {
        $_SESSION['flash'] = ['type' => 'error', 'message' => 'New passwords do not match.'];
        exit();
    }

    // Ensure database connection
    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    // Get current password from DB
    $stmt = $conn->prepare("SELECT password FROM users WHERE user_id = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($stored_password);
    $stmt->fetch();
    $stmt->close();

    // Verify old password
    if (!password_verify($old_password, $stored_password)) {
        $_SESSION['flash'] = ['type' => 'error', 'message' => 'Old password is incorrect.'];
        exit();
    }

    // Hash new password
    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

    // Update password
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("si", $hashed_password, $user_id);

    if ($stmt->execute()) {
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Password successfully changed'];
        header("Location: ../view/cookbook.php");
        exit();
    } else {
        $_SESSION['flash'] = ['type' => 'error', 'message' => 'Error updating password.'];
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>
