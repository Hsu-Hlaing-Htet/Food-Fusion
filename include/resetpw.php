<?php
session_start();
require_once 'db.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['otp_code'], $_POST['new_password'])) {
    $otp_code = $_POST['otp_code'];
    $new_password = $_POST['new_password'];
    $email = $_SESSION['otp_email'] ?? '';

    if (empty($email)) {
        $_SESSION['flash'] = ['type' => 'error', 'message' => 'Session expired. Please request OTP again'];
        echo "Session expired. Please request OTP again.";
        exit;
    }

    // Fetch OTP from the database
    $stmt = $conn->prepare("SELECT otp_code, otp_expires_at FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($db_otp_code, $db_otp_expires_at);
    $stmt->fetch();
    $stmt->close();

    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

    // Update password and clear OTP
    $stmt = $conn->prepare("UPDATE users SET password = ?, otp_code = NULL, otp_expires_at = NULL WHERE email = ?");
    $stmt->bind_param("ss", $hashed_password, $email);
    $stmt->execute();
    $stmt->close();

    // Unset session variables
    unset($_SESSION['otp_email'], $_SESSION['otp'], $_SESSION['otp_expiry']);
    header("Location: ../view/index.php");
    $_SESSION['flash'] = ['type' => 'info', 'message' => 'Password reset successfull.'];
} else {
    $_SESSION['flash'] = ['type' => 'error', 'message' => 'Invalid request.'];
}
