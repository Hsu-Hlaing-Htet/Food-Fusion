<?php
require_once('db.php');
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Validate first name & last name (Only letters, no numbers or special characters)
    if (!preg_match("/^[a-zA-Z]+$/", $first_name) || !preg_match("/^[a-zA-Z]+$/", $last_name)) {
        $_SESSION['flash'] = ['type' => 'error', 'message' => 'First name and last name must contain only letters.'];
        header("Location: ../view/index.php");
        exit();
    }
    // Validate empty fields first
    if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($confirm_password)) {
        $_SESSION['flash'] = ['type' => 'error', 'message' => 'All fields are required.'];
        header("Location: ../view/index.php");
        exit();
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['flash'] = ['type' => 'error', 'message' => 'Invalid email format.'];
        header("Location: ../view/index.php");
        exit();
    }

    // Validate password strength
    if (
        strlen($password) < 8 ||
        !preg_match("/[A-Z]/", $password) ||
        !preg_match("/[a-z]/", $password) ||
        !preg_match("/[0-9]/", $password)
    ) {
        $_SESSION['flash'] = ['type' => 'error', 'message' => 'Password must be at least 8 characters long and include uppercase, lowercase, number, and special character.'];
        header("Location: ../view/index.php");
        exit();
    }

    // Check if passwords match
    if ($password !== $confirm_password) {
        $_SESSION['flash'] = ['type' => 'error', 'message' => 'Passwords do not match.'];
        header("Location: ../view/index.php");
        exit();
    }
    $name = $first_name . " " . $last_name;
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Check if email is already registered
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['flash'] = ['type' => 'error', 'message' => 'Email is already registered.'];
        header("Location: ../view/index.php");
        exit();
    }
    $stmt->close();

    // Check if username (first + last name) already exists
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['flash'] = ['type' => 'error', 'message' => 'Username already exists.'];
        $stmt->close();
        header("Location: ../view/index.php");
        exit();
    }
    $stmt->close();

    // Get next available user ID (Auto-increment simulation)
    $result = $conn->query("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users'");
    $row = $result->fetch_assoc();
    $next_user_id = $row['AUTO_INCREMENT'] ?? 1;

    $uploaddir = $_SERVER['DOCUMENT_ROOT'] . "/FoodFusion/assets/Images/profile/";

    // Ensure the image directory exists
    if (!is_dir($uploaddir)) {
        if (mkdir($uploaddir, 0777, true)) {
            echo "Directory created successfully.";
        } else {
            echo "Failed to create directory.";
        }
    }

    // Define allowed file extensions
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

    $file_extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

    $max_file_size = 2 * 1024 * 1024; // 2MB
    if ($_FILES['image']['size'] > $max_file_size) {
        die("File size exceeds the limit of 2MB.");
    }

    $clean_username = preg_replace("/[^a-zA-Z0-9]/", "_", strtolower($first_name . "_" . $last_name));
    $new_filename = $clean_username . "_" . $next_user_id . "." . $file_extension;
    $uploadfile = $uploaddir . $new_filename;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) {
        echo "File uploaded successfully: " . $uploadfile;
        $profile_img_path = "assets/Images/profile/" . $new_filename;
    } else {
        echo "Error uploading file. Check permissions and path.";
        print_r(error_get_last()); // Prints the last PHP error
        $profile_img_path = 'assets/Images/profile/default.png'; // Default image if upload fails
    }

    // Insert user into the database
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, profile_picture) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $hashed_password, $profile_img_path);

    if ($stmt->execute()) {
        $_SESSION['flash'] = ['type' => 'info', 'message' => 'Registered successfully.'];

        // Set session variable to show the cookie consent
        $_SESSION['show_cookie_message'] = true;

        // Redirect to the index page after successful registration
        header("Location: ../view/index.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
