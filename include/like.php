<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
session_start();
require 'db.php'; // Ensure db.php correctly initializes $conn

if (!isset($_SESSION['user_id'])) {
    exit(json_encode(['status' => 'error', 'message' => 'Login required']));
}

if (!isset($_POST['recipe_id'])) {
    exit(json_encode(['status' => 'error', 'message' => 'No recipe ID received']));
}

$recipe_id = intval($_POST['recipe_id']);
$user_id = $_SESSION['user_id'];

// Check if the user already liked the recipe
$sql = "SELECT * FROM likes WHERE user_id = ? AND recipe_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $recipe_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // If the user already liked, remove the like (unlike)
    $deleteSql = "DELETE FROM likes WHERE user_id = ? AND recipe_id = ?";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bind_param("ii", $user_id, $recipe_id);
    $deleteStmt->execute();

    // Set status to "unliked"
    $status = 'unliked';
} else {
    // If the user hasn't liked, insert a new like (like)
    $insertSql = "INSERT INTO likes (user_id, recipe_id) VALUES (?, ?)";
    $insertStmt = $conn->prepare($insertSql);
    $insertStmt->bind_param("ii", $user_id, $recipe_id);
    $insertStmt->execute();

    // Set status to "liked"
    $status = 'liked';
}

// Get the updated like count
$countSql = "SELECT COUNT(*) AS likes_count FROM likes WHERE recipe_id = ?";
$countStmt = $conn->prepare($countSql);
$countStmt->bind_param("i", $recipe_id);
$countStmt->execute();
$result = $countStmt->get_result()->fetch_assoc();

// Return status and updated like count
exit(json_encode(['status' => $status, 'likes_count' => $result['likes_count']]));
