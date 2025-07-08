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

// Check if the user already favorited the recipe
$sql = "SELECT * FROM favorites WHERE user_id = ? AND recipe_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $recipe_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // If the user already favorited, remove the favorite (unfavorite)
    $deleteSql = "DELETE FROM favorites WHERE user_id = ? AND recipe_id = ?";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bind_param("ii", $user_id, $recipe_id);
    $deleteStmt->execute();

    // Set status to "unfavorited"
    $status = 'unfavorited';
} else {
    // If the user hasn't favorited, insert a new favorite (favorite)
    $insertSql = "INSERT INTO favorites (user_id, recipe_id) VALUES (?, ?)";
    $insertStmt = $conn->prepare($insertSql);
    $insertStmt->bind_param("ii", $user_id, $recipe_id);
    $insertStmt->execute();

    // Set status to "favorited"
    $status = 'favorited';
}

// Get the updated favorite count
$countSql = "SELECT COUNT(*) AS favorites_count FROM favorites WHERE recipe_id = ?";
$countStmt = $conn->prepare($countSql);
$countStmt->bind_param("i", $recipe_id);
$countStmt->execute();
$result = $countStmt->get_result()->fetch_assoc();

// Return status, updated favorite count
exit(json_encode([
    'status' => $status,
    'favorites_count' => $result['favorites_count']
]));
?>
