<?php
session_start(); // Start the session
require_once('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form inputs
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    // Validate inputs
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $_SESSION['flash'] = ['type' => 'error', 'message' => 'All fields are required.'];
        header("Location: ../view/contactus.php");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['flash'] = ['type' => 'error', 'message' => 'Invalid email format.'];
        header("Location: ../view/contactus.php");
        exit;
    }

    // Prepare and insert into database
    $stmt = $conn->prepare("INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $subject, $message);

    if ($stmt->execute()) {
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Message sent successfully!'];
    } else {
        $_SESSION['flash'] = ['type' => 'error', 'message' => 'Error: ' . $stmt->error];
    }

    // Close connection
    $stmt->close();
    $conn->close();

    // Redirect back with flash message
    header("Location: ../view/contactus.php");
    exit;
}
?>
