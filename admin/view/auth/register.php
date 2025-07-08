<?php
session_start();
include('../layout/flash_message.php');
display_flash_message();
include('../db.php');
ini_set('display_errors', 1);
error_reporting(E_ALL);


if (isset($_POST['signup-btn'])) {
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];


    // Validate first name & last name (Only letters, no numbers or special characters)
    if (!preg_match("/^[a-zA-Z]+$/", $first_name) || !preg_match("/^[a-zA-Z]+$/", $last_name)) {
        $_SESSION['flash'] = ['type' => 'error', 'message' => 'First name and last name must contain only letters.'];
        echo "Name validation passed!";
        header("Location: ../auth/register.php");
        exit();
    }
    // Validate empty fields first
    if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($confirm_password)) {
        $_SESSION['flash'] = ['type' => 'error', 'message' => 'All fields are required.'];
        header("Location: ../auth/register.php");
        // echo "Some fields are empty!";
        exit();
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $_SESSION['flash'] = ['type' => 'error', 'message' => 'Invalid email format.'];
        header("Location: ../auth/register.php");
        // echo "Email validation passed!";
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
        header("Location: ../auth/register.php");
        // echo "Password validation passed!";
        exit();
    }

    // Check if passwords match
    if ($password !== $confirm_password) {
        $_SESSION['flash'] = ['type' => 'error', 'message' => 'Passwords do not match.'];
        header("Location: ../auth/register.php");
        // echo "Password validation passed!";
        exit();
    }
    $name = $first_name . " " . $last_name;
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Check if email is already registered
    $stmt = $conn->prepare("SELECT id FROM admins WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // echo "Email: " . $email;
        $_SESSION['flash'] = ['type' => 'error', 'message' => 'Email is already registered.'];
        header("Location: ../auth/register.php");
        exit();
    }
    $stmt->close();

    // Check if username (first + last name) already exists
    $stmt = $conn->prepare("SELECT id FROM admins WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['flash'] = ['type' => 'error', 'message' => 'Username already exists.'];
        $stmt->close();
        header("Location: ../auth/register.php");
        exit();
    }
    $stmt->close();

    // Get next available user ID (Auto-increment simulation)
    $result = $conn->query("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'admins'");
    if (!$result) {
        die("Error fetching AUTO_INCREMENT: " . $conn->error);
    }
    $row = $result->fetch_assoc();
    if (!$row) {
        die("Failed to fetch AUTO_INCREMENT.");
    }
    $next_user_id = $row['AUTO_INCREMENT'] ?? 1;

    $uploaddir = $_SERVER['DOCUMENT_ROOT'] . "/FoodFusion/admin/view/assets/images/";

    if (!is_dir($uploaddir) && !mkdir($uploaddir, 0777, true)) {
        die("Failed to create directory.");
    }

    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        die("File upload error: " . $_FILES['image']['error']);
    }

    $file_extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($file_extension, $allowed_extensions)) {
        die("Invalid file type.");
    }

    $max_file_size = 2 * 1024 * 1024; // 2MB
    if ($_FILES['image']['size'] > $max_file_size) {
        die("File size exceeds the limit of 2MB.");
    }

    $clean_username = preg_replace("/[^a-zA-Z0-9]/", "_", strtolower($first_name . "_" . $last_name));
    $new_filename = $clean_username . "_" . $next_user_id . "." . $file_extension;
    $uploadfile = $uploaddir . $new_filename;

    if (empty($uploadfile)) {
        die("No file path generated.");
    }

    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) {
        echo "File uploaded successfully: " . $uploadfile;
        $profile_img_path = "assets/images/" . $new_filename;
    } else {
        echo "Error uploading file. Check permissions and path.";
        print_r(error_get_last());
        $profile_img_path = 'assets/Images/profile/default.png';
    }

    // Insert user into the database
    $stmt = $conn->prepare("INSERT INTO admins (name, email, password, profile_picture) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $hashed_password, $profile_img_path);

    if ($stmt->execute()) {
        echo "success",
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Registered successfully.You Can Login Now.'];
        header("Location: ../auth/login.php");
        exit();
    } else {
        echo "fail",
        $_SESSION['flash'] = ['type' => 'error', 'message' => 'Registration failed: ' . $stmt->error];
        header("Location: ../auth/register.php");
        exit();
    }
    $stmt->close();
    $conn->close();
}
?>





<link rel="stylesheet" href="../../../assets/font/fontawesome-free-5.15.4-web/css/all.min.css">
<link rel="stylesheet" href="../../../assets/css/style.css">
<link rel="stylesheet" href="../../../assets/css/styles.css">

<div class="relative flex border-2 items-center justify-center w-full h-full p-4">
    <div class="bg-white shadow-lg rounded-lg p-6 max-w-md w-full max-h-[90vh] overflow-y-auto">

        <div class="modal-header flex flex-col justify-center items-center relative text-center">
            <h2 class="text-2xl font-bold text-stone-700">Create account</h2>
            <h5 class="text-lg py-3 mb-4">to get started now!</h5>

        </div>


        <div class="modal-body">
            <?php display_flash_message(); ?>
            <form method="POST" action="" id="joinup-form" enctype="multipart/form-data">
                <div class="form-group w-full bg-white flex items-center rounded border p-2 mt-2 mb-4 hover:border-2 hover:border-red-900 transation-colors duration-300">
                    <input type="text" name="first_name" placeholder="First Name" autocomplete="off" class="form-control w-full outline-none" required>
                </div>

                <div class="form-group w-full bg-white flex items-center rounded border p-2 mt-2 mb-4 hover:border-2 hover:border-red-900 transation-colors duration-300">
                    <input type="text" name="last_name" placeholder="Last Name" autocomplete="off" class="form-control w-full outline-none" required>
                </div>

                <div class="form-group w-full bg-white rounded border p-2 mt-2 mb-4 hover:border-2 hover:border-red-900 transation-colors duration-300">
                    <input type="email" name="email" id="email" autocomplete="off" placeholder="Email Address" class="form-control w-full outline-none" required>
                </div>

                <div class="form-group w-full bg-white flex items-center rounded border p-2 mt-2 mb-4 hover:border-2 hover:border-red-900 transation-colors duration-300">
                    <input type="password" name="password" id="signuppassword" autocomplete="off" placeholder="Password" class="form-control w-full outline-none" required>
                    <div class="cursor-pointer ml-2 text-gray-600" id="showsignpw">
                        <i class="far fa-eye-slash"></i>
                    </div>
                </div>

                <div class="form-group w-full bg-white flex items-center rounded border p-2 mt-2 mb-4 hover:border-2 hover:border-red-900 transation-colors duration-300">
                    <input type="password" name="confirm_password" id="confirmpassword" autocomplete="off" placeholder="Confirm Password" class="form-control w-full outline-none" required>
                    <div class="cursor-pointer ml-2 text-gray-600" id="showsigncpw">
                        <i class="far fa-eye-slash"></i>
                    </div>
                </div>

                <div class="flex items-center rounded border p-2 mt-2 mb-4">
                    <input type="file" name="image" id="image" autocomplete="off" class="form-control w-full outline-none">
                </div>

                <button type="submit" class="w-full bg-red-900 text-white border-2 border-solid border-red-900 py-2 px-4 rounded mb-2 hover:bg-white hover:text-red-900 hover:border-red-900 transition-colors duration-300" id="signup-btn" name="signup-btn">
                    Sign Up
                </button>

                <p class="text-sm py-5 text-center">
                    Already have an account?
                    <a href="../auth/login.php" class="text-red-900 hover:text-blue-500">Login Now</a>
                </p>

            </form>
        </div>
    </div>
</div>

<script>
    // Password visibility toggle
    document.querySelectorAll('.fa-eye-slash').forEach(icon => {
        icon.addEventListener('click', function(e) {
            const input = this.closest('div').previousElementSibling;
            const type = input.type === 'password' ? 'text' : 'password';
            input.type = type;
            this.classList.toggle('fa-eye-slash');
            this.classList.toggle('fa-eye');
        });
    });
</script>