<?php
// delete_recipe.php
session_start();
require_once('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['recipe_id'])) {
    // Validate user session
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        die(json_encode(['error' => 'Unauthorized access']));
    }

    $recipe_id = $_POST['recipe_id'];
    $user_id = $_SESSION['user_id'];

    try {
        // Verify recipe ownership and get file paths
        $stmt = $conn->prepare("SELECT user_id, image, video_path FROM recipes WHERE id = ?");
        $stmt->bind_param("i", $recipe_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $recipe = $result->fetch_assoc();

            if ($recipe['user_id'] != $user_id) {
                $_SESSION['flash'] = ['type' => 'info', 'message' => 'Permission denied'];
                header("Location: ../view/cookbook.php");
                exit();
            }

            // Delete associated files
            $base_path = $_SERVER['DOCUMENT_ROOT'] . '/FoodFusion/';

            // Delete image
            if (!empty($recipe['image'])) {
                $image_path = $base_path . ltrim($recipe['image'], '/');
                if (file_exists($image_path)) {
                    if (!unlink($image_path)) {
                        error_log("Failed to delete image: $image_path");
                    }
                }
            }

            // Delete video
            if (!empty($recipe['video'])) {
                $video_path = $base_path . ltrim($recipe['video'], '/');
                if (file_exists($video_path)) {
                    if (!unlink($video_path)) {
                        error_log("Failed to delete video: $video_path");
                    }
                }
            }

            // Delete database entry
            $delete_stmt = $conn->prepare("DELETE FROM recipes WHERE id = ?");
            $delete_stmt->bind_param("i", $recipe_id);

            if ($delete_stmt->execute()) {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Recipe deleted successfully'];
                header("Location: ../view/cookbook.php");
                exit();
            } else {
                throw new Exception("Database deletion failed: " . $conn->error);
            }
        } else {
            throw new Exception("Recipe not found");
        }
    } catch (Exception $e) {
        http_response_code(500);
        error_log("Deletion error: " . $e->getMessage());
        $_SESSION['flash'] = ['type' => 'info', 'message' => '$e->getMessage()'];
        header("Location: ../view/cookbook.php");
        exit();
    }
} else {
    http_response_code(400);
    die(json_encode(['error' => 'Invalid request']));
}
?>
