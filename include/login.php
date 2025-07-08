<?php
ob_start();
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('db.php');

// ✅ Ensure session arrays exist
if (!isset($_SESSION['failed_attempts']) || !is_array($_SESSION['failed_attempts'])) {
    $_SESSION['failed_attempts'] = [];
}
if (!isset($_SESSION['lockout_time']) || !is_array($_SESSION['lockout_time'])) {
    $_SESSION['lockout_time'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        // ✅ Check if this email is locked out
        if (isset($_SESSION['lockout_time'][$email]) && time() < $_SESSION['lockout_time'][$email]) {
            $remaining = $_SESSION['lockout_time'][$email] - time();
            $_SESSION['flash'] = ['type' => 'error', 'message' => "Too many failed attempts for $email. Please wait $remaining seconds before trying again."];
            header("Location: ../view/index.php");
            exit();
        }

        // Check the database for user
        $stmt = $conn->prepare("SELECT user_id, name, email, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                // ✅ Successful login - reset failed attempts for this email
                unset($_SESSION['failed_attempts'][$email]);
                unset($_SESSION['lockout_time'][$email]);

                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['name'];
                $_SESSION['email'] = $user['email'];

                setcookie('login_success', 'true', time() + 3, '/');
                ob_end_flush();
                header("Location: ../view/cookbook.php");
                exit();
            } else {
                // ✅ Ensure session variable is an array before using
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
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'No user found with that email.'];
        }
    } else {
        $_SESSION['flash'] = ['type' => 'error', 'message' => 'Both email and password are required.'];
    }
    header("Location: ../view/index.php");
    exit();
}

$conn->close();
