<?php
require_once('db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access.");
}

$user_id = $_SESSION['user_id'];

// Check if a file was uploaded
if (!isset($_FILES['profile_image']) || $_FILES['profile_image']['error'] != 0) {
    die("No file uploaded or an error occurred.");
}

// Define allowed file extensions
$allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

$file_extension = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));

if (!in_array($file_extension, $allowed_extensions)) {
    die("Invalid file type. Only JPG, JPEG, PNG, GIF are allowed.");
}

// Check file size (Max: 2MB)
$max_file_size = 2 * 1024 * 1024; // 2MB
if ($_FILES['profile_image']['size'] > $max_file_size) {
    die("File size exceeds the limit of 2MB.");
}

// Fetch current profile picture to delete the old one
$stmt = $conn->prepare("SELECT profile_picture FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($current_image);
$stmt->fetch();
$stmt->close();

$uploaddir = $_SERVER['DOCUMENT_ROOT'] . "/FoodFusion/assets/Images/profile/";

// Ensure the directory exists
if (!is_dir($uploaddir)) {
    mkdir($uploaddir, 0777, true);
}

// Generate a unique file name
$new_filename = "user_" . $user_id . "_" . time() . "." . $file_extension;
$uploadfile = $uploaddir . $new_filename;

// Move the uploaded file
if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $uploadfile)) {
    // Update profile picture path in database
    $profile_img_path = "assets/Images/profile/" . $new_filename;
    
    $stmt = $conn->prepare("UPDATE users SET profile_picture = ? WHERE user_id = ?");
    $stmt->bind_param("si", $profile_img_path, $user_id);
    
    if ($stmt->execute()) {
        // Delete old image if it's not the default one
        if ($current_image && $current_image !== 'assets/Images/profile/default.png') {
            $old_image_path = $_SERVER['DOCUMENT_ROOT'] . "/FoodFusion/" . $current_image;
            if (file_exists($old_image_path)) {
                unlink($old_image_path);
            }
        }
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Upload profile photo successfully'];

        header("Location: ../view/cookbook.php");
        exit;
    } else {
        $_SESSION['flash'] = ['type' => 'error', 'message' => 'Error uploading image.'];
    }
    
    $stmt->close();
} else {
    $_SESSION['flash'] = ['type' => 'error', 'message' => 'Error uploading image.'];
    die("Error uploading file.");
}

$conn->close();
?>
