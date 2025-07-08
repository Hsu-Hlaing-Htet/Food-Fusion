<?php
session_start();
require '../vendor/autoload.php'; // Load PHPMailer
require_once 'db.php'; // Connect to the database

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = $_POST["email"];
    $otp = rand(100000, 999999); // Generate 6-digit OTP

    echo $email;

    // Store OTP in session & database
    $_SESSION['otp_email'] = $email;
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_expiry'] = time() + 300; // 5 minutes expiry

    $expiry_time = date('Y-m-d H:i:s', time() + 300);
    $stmt = $conn->prepare("UPDATE users SET otp_code = ?, otp_expires_at = ? WHERE email = ?");
    $stmt->execute([$otp, $expiry_time, $email]);

    echo $email;

    // Send OTP via PHPMailer
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Gmail SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'hsuhtet562@gmail.com'; // Your Gmail
        $mail->Password = 'xxfv mzpk efkt vwrz'; // Use App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email details
        $mail->setFrom('hsuhtet562@gmail.com', 'Food Fusion');
        $mail->addAddress($email);
        $mail->Subject = "Your OTP Code For Food Fusion";
        $mail->Body = "Your OTP is: $otp. It will expire in 5 minutes.";

        $mail->send();
        $_SESSION['flash'] = ['type' => 'info', 'message' => 'OTP Sent! Check your email.'];
        echo 'OTP Sent! Check your email.';
    } catch (Exception $e) {
        $_SESSION['flash'] = ['type' => 'info', 'message' => 'Failed to send OTP. Mailer Error: ' . $mail->ErrorInfo];
        echo 'Failed to send OTP. Mailer Error: ' . $mail->ErrorInfo;
    }
} else {
    $_SESSION['flash'] = ['type' => 'info', 'message' => 'Invalid request'];
    echo 'Invalid request.';
} 