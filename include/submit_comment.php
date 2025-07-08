<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require 'db.php';

// Validate session
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "You must be logged in to submit a review";
    header("Location: /login.php");
    exit();
}

// After processing messages
if (isset($_SESSION['old_input'])) {
    $oldInput = $_SESSION['old_input'];
    unset($_SESSION['old_input']);
} else {
    $oldInput = [];
}

// Validate input
$required_fields = ['recipe_id', 'rating', 'comment'];
foreach ($required_fields as $field) {
    if (empty($_POST[$field])) {
        $_SESSION['flash'] = ['type' => 'error', 'message' => 'All fields are required'];
        $_SESSION['old_input'] = $_POST;
        header("Location: ../view/show_receipe?id=" . $_POST['recipe_id']);
        exit();
    }
}

$userId = $_SESSION['user_id'];
$recipeId = (int)$_POST['recipe_id'];
$rating = (int)$_POST['rating'];
$comment = htmlspecialchars(trim($_POST['comment']));

// Validate rating range
if ($rating < 1 || $rating > 5) {
    $_SESSION['error'] = "Rating must be between 1 and 5 stars";
    $_SESSION['old_input'] = $_POST;
    header("Location: ../view/show_receipe.php?id=$recipeId");
    exit();
}

$stmt = $conn->prepare("INSERT INTO reviews (user_id, recipe_id, rating, comment) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iiis", $userId, $recipeId, $rating, $comment);
$stmt->execute();
$stmt->close();
$_SESSION['flash'] = ['type' => 'info', 'message' => 'Comment Successfully.'];
header("Location: ../view/show_receipe.php?id=$recipeId");
exit();
