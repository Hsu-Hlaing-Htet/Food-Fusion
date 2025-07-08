<?php
session_start();
include('../layout/flash_message.php');
display_flash_message();
include('../db.php');
ini_set('display_errors', 1);
error_reporting(E_ALL);

// ✅ Ensure session arrays exist
if (!isset($_SESSION['failed_attempts']) || !is_array($_SESSION['failed_attempts'])) {
    $_SESSION['failed_attempts'] = [];
}
if (!isset($_SESSION['lockout_time']) || !is_array($_SESSION['lockout_time'])) {
    $_SESSION['lockout_time'] = [];
}

if (isset($_POST['login-btn'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        // ✅ Check if this email is locked out
        if (isset($_SESSION['lockout_time'][$email]) && time() < $_SESSION['lockout_time'][$email]) {
            $remaining = $_SESSION['lockout_time'][$email] - time();
            $_SESSION['flash'] = ['type' => 'error', 'message' => "Too many failed attempts for $email. Please wait $remaining seconds before trying again."];
            header("Location: ../auth/login.php");
            exit();
        }

        // Check the database for user
        $stmt = $conn->prepare("SELECT id, name, email, password FROM admins WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                // ✅ Successful login - reset failed attempts for this email
                unset($_SESSION['failed_attempts'][$email]);
                unset($_SESSION['lockout_time'][$email]);

                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['name'];
                $_SESSION['email'] = $user['email'];
                // Set flash message for successful login
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Login Successful! Welcome back!'];

                setcookie('login_success', 'true', time() + 3, '/');
                header("Location: ../dashboard.php");
                exit();
            } else {
                // Increment failed attempts and handle lockout
                if (!isset($_SESSION['failed_attempts'][$email])) {
                    $_SESSION['failed_attempts'][$email] = 0;
                }

                $_SESSION['failed_attempts'][$email]++;

                if ($_SESSION['failed_attempts'][$email] >= 3) {
                    $_SESSION['lockout_time'][$email] = time() + 30; // Lock this email for 30 seconds
                    $_SESSION['flash'] = ['type' => 'error', 'message' => "Too many failed attempts for $email. Please wait 30 seconds before trying again."];
                } else {
                    $_SESSION['flash'] = ['type' => 'error', 'message' => "Invalid password. Attempt {$_SESSION['failed_attempts'][$email]} of 3."];
                }
            }
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'No admin found with that email.'];
        }
    } else {
        $_SESSION['flash'] = ['type' => 'error', 'message' => 'Both email and password are required.'];
    }
    header("Location: ../auth/login.php");
    exit();
}
?>

<link rel="stylesheet" href="../../../assets/font/fontawesome-free-5.15.4-web/css/all.min.css">
<link rel="stylesheet" href="../../../assets/css/style.css">
<link rel="stylesheet" href="../../../assets/css/styles.css">
<link rel="stylesheet" href="../../assets/css/style.css">



<div class="relative flex items-center justify-center w-full h-full p-4">
    <div class="bg-white border-2 shadow-lg rounded-lg p-6 max-w-md w-full max-h-[90vh] overflow-y-auto">
        <div class="modal-header flex justify-center items-center relative">
            <h2 class="text-2xl font-bold text-stone-700">Login</h2>

        </div>


        <div class="modal-body">
            <?php display_flash_message(); ?>
            <form action="" method="POST" id="login-form">
                <div class="mb-4">
                    <label for="email" class="font-bold text-gray-700">Email</label>
                    <input type="email" name="email" id="email" class="form-group w-full bg-white flex items-center border rounded p-2 mt-2 mb-4 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-red-900" placeholder="Enter Email" required>
                </div>

                <div class="mb-4">
                    <label for="password" class="font-bold text-gray-700">Password</label>
                    <input type="password" name="password" id="password" class="form-group w-full bg-white flex items-center border rounded p-2 mt-2 mb-4 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-red-900" placeholder="Enter Password" required>
                </div>

                <div class="flex items-center justify-between mb-4">
                    <label class="flex items-center text-gray-600">
                        <input type="checkbox" name="remember" id="remember" class="mr-2">
                        Remember Me
                    </label>
                    <a href="javascript:void(0);" onclick="openResetPwModal()" class="text-red-900 hover:underline">Forgot Password?</a>
                </div>

                <button type="submit" name="login-btn" id="login-btn" class="w-full bg-[#800020] text-white font-bold py-2 rounded-lg hover:bg-[#800020] transition duration-300">
                    Login
                </button>
                <p class="text-sm mt-3 text-center">
                    Don't have an account?
                    <a href="../auth/register.php" class="text-red-900 hover:text-blue-500">Signup Now</a>
                </p>
            </form>
        </div>
    </div>
</div>