<?php
session_start();
require_once('db.php');

// Get recipe ID from appropriate source
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // From POST when submitting form
    if (!isset($_POST['id'])) {
        echo "No recipe ID provided.";
        exit;
    }
    $recipe_id = $_POST['id'];
} else {
    // From GET when loading page
    if (!isset($_GET['id'])) {
        echo "No recipe ID provided.";
        exit;
    }
    $recipe_id = $_GET['id'];
}

// Add validation for numeric ID
if (!is_numeric($recipe_id)) {
    die("Invalid recipe ID");
}
$recipe_id = (int)$recipe_id;

// Fetch the existing recipe details
$stmt = $conn->prepare("SELECT * FROM recipes WHERE id = ?");
$stmt->bind_param("i", $recipe_id);
$stmt->execute();
$result = $stmt->get_result();
$recipe = $result->fetch_assoc();

if (!$recipe) {
    echo "Recipe not found.";
    exit;
}

$stmt = $conn->prepare("SELECT name, quantity FROM recipe_ingredients WHERE recipe_id = ?");
$stmt->bind_param("i", $recipe_id);
$stmt->execute();
$ingredients = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Fetch steps with order
$stmt = $conn->prepare("SELECT description, step_order 
                       FROM recipe_cooking_steps 
                       WHERE recipe_id = ? 
                       ORDER BY step_order ASC");
$stmt->bind_param("i", $recipe_id);
$stmt->execute();
$cooking_steps = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $recipe['user_id']) {
        $_SESSION['flash'] = ['type' => 'error', 'message' => 'You are not authorized to edit this recipe.'];
        header("Location: ../view/cookbook.php");
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $cuisine_name = $_POST['cuisine_name'];
    $difficulty_level = $_POST['difficulty_level'];
    $prep_time = $_POST['prep_time'];
    $cook_time = $_POST['cook_time'];
    $serving = $_POST['serving'];
    $category = $_POST['category'];

    // Handle file uploads for image
    $image_path = $recipe['image']; // Default to current image
    if (!empty($_FILES['image']['name'])) {
        $image_uploaddir = $_SERVER['DOCUMENT_ROOT'] . "/FoodFusion/assets/Images/receipes/images/";
        $image_filename = $_SESSION['username'] . "_" . $recipe_id . ".jpg";
        $image_uploadfile = $image_uploaddir . $image_filename;

        // Ensure the image directory exists
        if (!is_dir($image_uploaddir)) {
            mkdir($image_uploaddir, 0777, true);
        }

        // Upload new image
        if (move_uploaded_file($_FILES['image']['tmp_name'], $image_uploadfile)) {
            $image_path = '/FoodFusion/assets/Images/receipes/images/' . $image_filename;
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Error uploading image.'];
            header("Location: ../view/edit_receipe.php?id=$recipe_id");
            exit();
        }
    }

    // Handle file uploads for video
    $video_path = $recipe['video_path']; // Default to current video
    if (!empty($_FILES['video']['name'])) {
        $video_uploaddir = $_SERVER['DOCUMENT_ROOT'] . "/FoodFusion/assets/Images/receipes/videos/";
        $video_filename = $_SESSION['username'] . "_" . $recipe_id . ".mp4";
        $video_uploadfile = $video_uploaddir . $video_filename;

        // Ensure the video directory exists
        if (!is_dir($video_uploaddir)) {
            mkdir($video_uploaddir, 0777, true);
        }

        // Upload new video
        if (move_uploaded_file($_FILES['video']['tmp_name'], $video_uploadfile)) {
            $video_path = '/FoodFusion/assets/Images/receipes/videos/' . $video_filename;
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Error uploading video.'];
            header("Location: ../view/edit_receipe.php?id=$recipe_id");
            exit();
        }
    }

    // Update recipe in the database
    $stmt = $conn->prepare("UPDATE recipes SET title = ?, description = ?, cuisine_name = ?, difficulty_level = ?, prep_time = ?, cook_time = ?, serving = ?, category = ?, video_path = ?, image = ? WHERE id = ?");
    $stmt->bind_param("ssssiiisssi", $title, $description, $cuisine_name, $difficulty_level, $prep_time, $cook_time, $serving, $category, $video_path, $image_path, $recipe_id);
    $stmt->execute();

    // Update ingredients
    if (!empty($_POST['ingredient_name'])) {
        // Delete old ingredients before inserting new ones
        $stmt = $conn->prepare("DELETE FROM recipe_ingredients WHERE recipe_id = ?");
        $stmt->bind_param("i", $recipe_id);
        $stmt->execute();

        // Insert new ingredients
        $stmt = $conn->prepare("INSERT INTO recipe_ingredients (recipe_id, name, quantity) VALUES (?, ?, ?)");
        foreach ($_POST['ingredient_name'] as $index => $ingredient) {
            $quantity = $_POST['quantity'][$index];
            $stmt->bind_param("iss", $recipe_id, $ingredient, $quantity);
            $stmt->execute();
        }
        $stmt->close();
    }

    // Update cooking steps
    if (!empty($_POST['steps'])) {
        // Delete old steps first
        $stmt = $conn->prepare("DELETE FROM recipe_cooking_steps WHERE recipe_id = ?");
        $stmt->bind_param("i", $recipe_id);
        $stmt->execute();

        // Insert new steps WITH STEP ORDER
        $stmt = $conn->prepare("INSERT INTO recipe_cooking_steps (recipe_id, description, step_order) VALUES (?, ?, ?)");
        foreach ($_POST['steps'] as $index => $step) {
            $step_order = $_POST['step_order'][$index] ?? ($index + 1);
            $stmt->bind_param("isi", $recipe_id, $step, $step_order);
            $stmt->execute();
        }
        $stmt->close();
    }

    // Success message
    $_SESSION['flash'] = ['type' => 'success', 'message' => 'Recipe updated successfully!'];
    header("Location: ../view/cookbook.php");
    exit();
}
?>
