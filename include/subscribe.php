<?php
session_start();
require_once('db.php');

$max_attempts = 3;
$block_time = 60; // in seconds

if (!isset($_SESSION['attempts'])) {
    $_SESSION['attempts'] = [];
}

// Remove expired attempts
$_SESSION['attempts'] = array_filter($_SESSION['attempts'], function ($timestamp) use ($block_time) {
    return (time() - $timestamp) < $block_time;
});

// Count current attempts
$attempts_count = count($_SESSION['attempts']);

if ($attempts_count >= $max_attempts) {
    $remaining = $block_time - (time() - $_SESSION['attempts'][0]);
    $_SESSION['flash'] = ['type' => 'error', 'message' => "Too many failed attempts for $email. Please wait $remaining seconds before trying again."];
    header("Location: ../view/index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['attempts'][] = time();
        $_SESSION['flash'] = ['type' => 'error', 'message' => "Invalid email format."];
        header("Location: ../view/index.php");
        exit;
    }

    // Check if email already exists
    $check_stmt = $conn->prepare("SELECT id FROM subscribers WHERE email = ?");
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        $_SESSION['attempts'][] = time();
        $_SESSION['flash'] = ['type' => 'error', 'message' => "This email is already subscribed."];
        $check_stmt->close();
        $conn->close();
        header("Location: ../view/index.php");
        exit;
    }
    $check_stmt->close();

    // Insert new subscriber
    $stmt = $conn->prepare("INSERT INTO subscribers (email) VALUES (?)");
    $stmt->bind_param("s", $email);

    if ($stmt->execute()) {
        $_SESSION['attempts'] = []; // Reset attempts on success
        $_SESSION['flash'] = ['type' => 'success', 'message' => "Subscribed successfully!"];
    } else {
        $_SESSION['attempts'][] = time();
        $_SESSION['flash'] = ['type' => 'error', 'message' => "Subscription failed. Please try again."];
    }

    $stmt->close();
    $conn->close();
    header("Location: ../view/index.php");
    exit;
}
?>

