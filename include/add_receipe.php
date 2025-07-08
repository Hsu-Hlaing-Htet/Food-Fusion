<?php
session_start();
require_once('db.php');

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    $_SESSION['flash'] = ['type' => 'error', 'message' => 'Invalid request method.'];
    header("Location: ../view/add_receipe.php");
    exit();
}

// Verify user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    $_SESSION['flash'] = ['type' => 'error', 'message' => 'You must be logged in to add a recipe.'];
    header("Location: ../view/add_receipe.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Collect form data
$title = $_POST['title'];
$description = $_POST['description'];
$cuisine_name = $_POST['cuisine_name'];
$difficulty_level = $_POST['difficulty_level'];
$prep_time = $_POST['prep_time'];
$cook_time = $_POST['cook_time'];
$serving = $_POST['serving'];
$category = $_POST['category'];

// Insert new recipe into database first
$stmt = $conn->prepare("INSERT INTO recipes (title, description, cuisine_name, difficulty_level, prep_time, cook_time, serving, category, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssiiisi", $title, $description, $cuisine_name, $difficulty_level, $prep_time, $cook_time, $serving, $category, $user_id);
$stmt->execute();
$recipe_id = $conn->insert_id;
$stmt->close();

// Handle image upload
$image_path = '';
if (!empty($_FILES['image']['name'])) {
    $image_uploaddir = $_SERVER['DOCUMENT_ROOT'] . "/FoodFusion/assets/Images/receipes/images/";
    $image_filename = $username . "_" . $recipe_id . ".jpg"; 
    $image_uploadfile = $image_uploaddir . $image_filename;

    if (!is_dir($image_uploaddir)) {
        mkdir($image_uploaddir, 0777, true);
    }

    if (move_uploaded_file($_FILES['image']['tmp_name'], $image_uploadfile)) {
        $image_path = '/FoodFusion/assets/Images/receipes/images/' . $image_filename;
    } else {
        $_SESSION['flash'] = ['type' => 'error', 'message' => 'Error uploading image.'];
        header("Location: ../view/add_receipe.php");
        exit();
    }
}

// Handle video upload
$video_path = '';
if (!empty($_FILES['video']['name'])) {
    $video_uploaddir = $_SERVER['DOCUMENT_ROOT'] . "/FoodFusion/assets/Images/receipes/videos/";
    $video_filename = $username . "_" . $recipe_id . ".mp4"; 
    $video_uploadfile = $video_uploaddir . $video_filename;

    if (!is_dir($video_uploaddir)) {
        mkdir($video_uploaddir, 0777, true);
    }

    if (move_uploaded_file($_FILES['video']['tmp_name'], $video_uploadfile)) {
        $video_path = '/FoodFusion/assets/Images/receipes/videos/' . $video_filename;
    } else {
        $_SESSION['flash'] = ['type' => 'error', 'message' => 'Error uploading video.'];
        header("Location: ../view/add_receipe.php");
        exit();
    }
}

// Update recipe with image and video paths
$stmt = $conn->prepare("UPDATE recipes SET image = ?, video_path = ? WHERE id = ?");
$stmt->bind_param("ssi", $image_path, $video_path, $recipe_id);
$stmt->execute();
$stmt->close();

// Insert ingredients
if (!empty($_POST['ingredient_name'])) {
    $stmt = $conn->prepare("INSERT INTO recipe_ingredients (recipe_id, name, quantity) VALUES (?, ?, ?)");

    foreach ($_POST['ingredient_name'] as $index => $ingredient) {
        $quantity = $_POST['quantity'][$index] ?? '';
        $stmt->bind_param("iss", $recipe_id, $ingredient, $quantity);
        $stmt->execute();
    }
    $stmt->close();
}

// Insert cooking steps
if (!empty($_POST['steps'])) {
    $stmt = $conn->prepare("INSERT INTO recipe_cooking_steps (recipe_id, description, step_order) VALUES (?, ?, ?)");

    foreach ($_POST['steps'] as $index => $step) {
        $step_order = $_POST['step_order'][$index] ?? ($index + 1);
        $stmt->bind_param("isi", $recipe_id, $step, $step_order);
        $stmt->execute();
    }
    $stmt->close();
}

// Success message
$_SESSION['flash'] = ['type' => 'success', 'message' => 'Recipe uploaded successfully!'];
header("Location: ../view/cookbook.php");
exit();
