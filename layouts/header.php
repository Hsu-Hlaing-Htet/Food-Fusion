<?php include('../include/register.php'); ?>
<?php include('../include/login.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodFusion</title>
    <link rel="stylesheet" href="../assets/css/animation.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/font/fontawesome-free-5.15.4-web/css/all.min.css">
    <script src="../assets/js/script.js" defer></script>
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
</head>

<body>
    <!-- Header Section -->
    <header class="bg-[#EBE6DA] border-b-2 border-[#800020]/20 shadow-sm">
        <nav class="container mx-auto px-4 py-3 relative">

            <div class="flex items-center justify-between w-full px-6">
                <!-- Logo Container -->
                <div class="flex items-center gap-4 animate-slide-in-left animation-delay-500 opacity-0">
                    <a href="../view/index.php" class="flex items-center gap-3 group transition-transform hover:scale-105">
                        <img src="../../FoodFusion/assets/Images/logo/logo.png"
                            alt="FoodFusion Logo"
                            class="w-16 h-16 drop-shadow-lg transition duration-300">
                        <div class="flex flex-col">
                            <span class="font-playfair text-3xl font-bold text-[#800020] tracking-wide">
                                FoodFusion
                            </span>
                            <span class="font-montserrat text-xs font-medium text-stone-600 tracking-[0.2em] mt-[-4px]">
                                Culinary Community
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden lg:flex items-center gap-6 justify-end flex-grow">
                    <div class="flex gap-6">
                        <?php
                        // Get clean current page name
                        $current_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
                        $current_page = basename($current_uri);
                        ?>

                        <a href="../view/index.php" class="px-3 py-2 text-[#800020] transition-colors <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">Home</a>
                        <a href="../view/receipes.php" class="py-2 px-3 text-[#800020] transition-colors <?php echo ($current_page == 'receipes.php') ? 'active' : ''; ?>">Recipes</a>
                        <a href="../view/culinary.php" class="py-2 px-3 text-[#800020] transition-colors <?php echo ($current_page == 'culinary.php') ? 'active' : ''; ?>">Culinary Resources</a>
                        <a href="../view/educational.php" class="py-2 px-3 text-[#800020] transition-colors <?php echo ($current_page == 'educational.php') ? 'active' : ''; ?>">Education</a>

                    </div>
                    <!-- Auth Section -->
                    <div class="ml-4 flex items-center gap-4">

                        <?php if (isset($_SESSION['user_id'])): ?>
                            <?php
                            include('../include/db.php');

                            $userId = $_SESSION['user_id'];

                            // Fetch the profile picture for the logged-in user
                            $userStmt = $conn->prepare("SELECT profile_picture FROM users WHERE user_id = ?");
                            $userStmt->bind_param("i", $userId);
                            $userStmt->execute();
                            $userResult = $userStmt->get_result();
                            $userData = $userResult->fetch_assoc();

                            // Check if the profile_picture exists and is valid
                            if ($userData && isset($userData['profile_picture']) && !empty($userData['profile_picture'])) {
                                $profile_img = $userData['profile_picture'];
                            } else {
                                // Default image if no profile picture is set
                                $profile_img = 'assets/Images/profile/default.png';
                            }
                            ?>
                            <div class="relative">
                                <button onclick="toggleDropdown()" class="flex items-center gap-2 group">
                                    <img src="../<?php echo htmlspecialchars($profile_img); ?>"
                                        alt="Profile"
                                        class="w-10 h-10 rounded-full border-2 border-[#800020]/30 hover:border-[#800020] transition-colors">
                                    <span class="font-medium text-[#800020] group-hover:text-[#600018]">
                                        <?php echo $_SESSION['username'] ?>
                                    </span>
                                </button>

                                <!-- Dropdown Menu -->
                                <div id="pfdropdown-menu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-[#800020]/10 z-50">
                                    <a href="cookbook.php" class="block px-4 py-3 text-[#800020] hover:bg-[#800020]/5 transition-colors">
                                        Community Cookbook
                                    </a>
                                    <a href="javascript:void(0);" onclick="openChangePwModal()" class="block px-4 py-3 text-[#800020] hover:bg-[#800020]/5 transition-colors">
                                        Change Password
                                    </a>
                                    <a href="javascript:void(0);" onclick="openResetPwModal()" class="block px-4 py-3 text-[#800020] hover:bg-[#800020]/5 transition-colors">
                                        Reset Password
                                    </a>
                                    <a href="javascript:void(0);" onclick="openLogoutModal()" class="block px-4 py-3 text-[#800020] hover:bg-[#800020]/5 transition-colors">
                                        Logout
                                    </a>
                                </div>
                            </div>
                        <?php else: ?>
                            <button type="button"
                                onclick="openLoginModal()"
                                class="px-6 py-2 bg-[#800020] text-white rounded-0 hover:bg-[#600018] transition-colors
                                   font-medium flex items-center gap-2 shadow-sm hover:shadow-md">
                                <i class="fas fa-sign-in-alt"></i>
                                Login
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="flex items-center gap-3 justify-between">
                    <!-- Mobile Menu Button -->
                    <button id="menu-btn" class="lg:hidden flex flex-col items-center gap-1">
                        <span class="line1"></span>
                        <span class="line2"></span>
                        <span class="line3"></span>
                    </button>


                </div>


            </div>

            <!-- Mobile Menu -->
            <div id="mobilemenu" class="lg:hidden hidden z-50">
                <div class="flex flex-col items-center transition-colors text-white gap-3">
                    <?php
                    // Get clean current page name
                    $current_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
                    $current_page = basename($current_uri);
                    ?>

                    <a href="../view/index.php" class="mt-10 px-3 py-2 <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">Home</a>
                    <a href="../view/receipes.php" class="py-2 px-3 <?php echo ($current_page == 'receipes.php') ? 'active' : ''; ?>">Recipes</a>
                    <a href="../view/culinary.php" class="py-2 px-3 <?php echo ($current_page == 'culinary.php') ? 'active' : ''; ?>">Culinary Resources</a>
                    <a href="../view/educational.php" class="py-2 px-3 <?php echo ($current_page == 'educational.php') ? 'active' : ''; ?>">Education</a>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <!-- Add active class to cookbook link -->
                        <a href="../view/cookbook.php" class="py-2 px-3 <?php echo ($current_page == 'cookbook.php') ? 'active' : ''; ?>">Community Cookbook</a>

                        <!-- JS links don't need active states -->
                        <a href="javascript:void(0);" onclick="openChangePwModal()" class="py-2 px-3">Change Password</a>
                        <a href="javascript:void(0);" onclick="openResetPwModal()" class="py-2 px-3">Reset Password</a>
                        <a href="javascript:void(0);" onclick="openLogoutModal()" class="py-2 px-3">Logout</a>
                    <?php else: ?>
                        <button onclick="openLoginModal()" class="mt-4 px-4 py-2">
                            Login
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </nav>

        <?php
        require_once 'flash_message.php';
        display_flash_message();
        ?>
    </header>

    <style>
        #menu-btn {
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 30px;
            height: 30px;
            cursor: pointer;
            position: relative;
            z-index: 100;
            border: none;
            gap: 5px;
        }

        /* Span lines */
        #menu-btn .line1,
        #menu-btn .line2,
        #menu-btn .line3 {
            width: 30px;
            height: 4px;
            background-color: #800020;
            transition: all 0.3s ease-in-out;

            position: absolute;
            left: 0;
            top: 0;
        }

        /* Cross effect */
        .line1 {
            transform: translateY(7px);
        }

        .line3 {
            transform: translateY(14px);
        }

        .crossx .line1 {
            transform: rotate(45deg) translate(6px, 6px);
        }

        .crossx .line2 {
            display: none;

        }

        .crossx .line3 {
            transform: rotate(-45deg) translate(-6px, 6px);
        }

        .crossx:hover .line1,
        .crossx:hover .line3 {
            background-color: #800020;
        }

        #mobilemenu {
            transition: all 0.3s ease-in-out;
            width: 100%;
            position: absolute;
            top: 0;
            left: 0;
            background-color: rgba(0, 0, 0, 0.5);
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(128, 0, 32, 0.1);
        }
    </style>

    <!-- login  -->
    <div id="login-modal" class="modal fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-md z-50" style="display: none;">
        <div class="modal-dialog relative flex items-center justify-center w-full h-full p-4">
            <div class="modal-content bg-white shadow-lg rounded-lg p-6 max-w-md w-full max-h-[90vh] overflow-y-auto">
                <div class="modal-header flex justify-center items-center relative">
                    <h2 class="text-2xl font-bold text-stone-700">Login</h2>
                    <span class="btn-close absolute right-4 top-1/2 -translate-y-1/2 hover:text-red-500 cursor-pointer font-bold text-3xl"
                        onclick="closeLoginModal()" title="Close Modal">
                        &times;
                    </span>
                </div>


                <div class="modal-body">
                    <form action="../include/login.php" method="POST" id="login-form">
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

                        <button type="submit" id="login-btn" class="w-full bg-[#800020] text-white font-bold py-2 rounded-lg hover:bg-[#800020] transition duration-300">
                            Login
                        </button>
                        <p class="text-sm mt-3 text-center">
                            Don't have an account?
                            <a href="#" class="text-red-900 hover:text-blue-500" onclick="switchToSignUp()">Signup Now</a>
                        </p>
                        <p class="text-sm py-5 text-center">By logging in, you agree to our <a href="../view/terms&condition.php" class="text-red-900 hover:text-blue-500">Term & Conditions</a>,<a href="../view/cookiepolicy.php" class="text-red-900 hover:text-blue-500">Cookie Policy</a> and <a href="../view/privacy.php" class="text-red-900 hover:text-blue-500">Privacy Policy</a>.</p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div id="changepw-modal" class="modal fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-md z-50" style="display: none;">
        <div class="modal-dialog relative flex items-center justify-center w-full h-full p-4">
            <div class="modal-content bg-white shadow-lg rounded-lg p-6 max-w-md w-full max-h-[90vh] overflow-y-auto">


                <div class="modal-header flex justify-center items-center relative">
                    <h2 class="text-2xl font-bold text-stone-700">Change Password</h2>
                    <span class="btn-close absolute right-4 top-1/2 -translate-y-1/2 hover:text-red-500 cursor-pointer font-bold text-3xl"
                        onclick="closeChangePwModal()" title="Close Modal">
                        &times;
                    </span>
                </div>

                <div class="modal-body">
                    <form action="../include/changepw.php" method="POST">
                        <div class="mb-4">
                            <label for="old-password" class="font-bold text-gray-700">Current Password</label>
                            <input type="password" name="old_password" id="old-password"
                                class="w-full bg-white border rounded p-2 mt-2 mb-4 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-red-900"
                                placeholder="Enter Current Password" required>
                        </div>

                        <div class="mb-4">
                            <label for="new-password" class="font-bold text-gray-700">New Password</label>
                            <input type="password" name="new_password" id="new-password"
                                class="w-full bg-white border rounded p-2 mt-2 mb-4 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-red-900"
                                placeholder="Enter New Password" required>
                        </div>

                        <div class="mb-6">
                            <label for="confirm-password" class="font-bold text-gray-700">Confirm Password</label>
                            <input type="password" name="confirm_password" id="confirm-password"
                                class="w-full bg-white border rounded p-2 mt-2 mb-4 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-red-900"
                                placeholder="Confirm New Password" required>
                        </div>

                        <button type="submit"
                            class="w-full bg-[#800020] text-white font-bold py-2 rounded-lg hover:opacity-90 transition duration-300">
                            Change Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Reset Password Modal -->
    <div id="resetpw-modal" class="modal fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-md z-50" style="display: none;">
        <div class="modal-dialog relative flex items-center justify-center w-full h-full p-4">
            <div class="modal-content bg-white shadow-lg rounded-lg p-6 max-w-md w-full max-h-[90vh] overflow-y-auto">

                <div class="modal-header flex justify-center items-center relative">
                    <h2 class="text-2xl font-bold text-stone-700">Reset Password</h2>
                    <span class="btn-close absolute right-4 top-1/2 -translate-y-1/2 hover:text-red-500 cursor-pointer font-bold text-3xl"
                        onclick="closeResetPwModal()" title="Close Modal">
                        &times;
                    </span>
                </div>


                <div class="modal-body">
                    <!-- Step 1: Enter Email -->
                    <form id="otp-request-form" action="../include/send_otp.php" method="POST">
                        <div class="mb-4">
                            <label for="reset-email" class="font-bold text-gray-700">Email Address</label>
                            <input type="email" name="email" id="reset-email" class="form-group w-full bg-white rounded border p-2 mt-2 mb-4 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-red-900" placeholder="Enter Your Email" required>
                        </div>

                        <button type="submit" class="w-full bg-[#800020] text-white font-bold py-2 rounded-lg hover:bg-[#800020] transition duration-300">
                            Send OTP
                        </button>
                    </form>

                    <!-- Step 2: Enter OTP & New Password (Hidden initially) -->
                    <form id="otp-verify-form" action="../include/resetpw.php" method="POST" style="display: none;">
                        <div class="mb-4">
                            <label for="otp-code" class="font-bold text-gray-700">Enter OTP</label>
                            <input type="text" name="otp_code" id="otp-code" class="form-group w-full bg-white rounded border p-2 mt-2 mb-4 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-red-900" placeholder="Enter OTP" required>
                        </div>

                        <div class="mb-4">
                            <label for="new-password" class="font-bold text-gray-700">New Password</label>
                            <input type="password" name="new_password" id="new-password" class="form-group w-full bg-white rounded border p-2 mt-2 mb-4 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-red-900" placeholder="Enter New Password" required>
                        </div>

                        <button type="submit" class="w-full bg-[#800020] text-white font-bold py-2 rounded-lg hover:bg-[#800020] transition duration-300">
                            Reset Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const otpRequestForm = document.getElementById("otp-request-form");
            const otpVerifyForm = document.getElementById("otp-verify-form");

            otpRequestForm.addEventListener("submit", function(event) {
                event.preventDefault(); // Prevent page reload

                const formData = new FormData(otpRequestForm);

                fetch(otpRequestForm.action, {
                        method: "POST",
                        body: formData,
                    })
                    .then(response => response.text())
                    .then(data => {
                        console.log("Response from server:", data); // Log the response for debugging

                        if (data.includes("OTP Sent")) { // Check if OTP was successfully sent
                            otpRequestForm.style.display = "none"; // Hide email form
                            otpVerifyForm.style.display = "block"; // Show OTP verification form
                        } else {
                            alert(data); // Show any error message from PHP
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        alert("Something went wrong. Please try again.");
                    });
            });
        });
    </script>


    <!-- Logout Confirmation Modal -->
    <div id="logout-modal" class="modal fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-md z-50" style="display: none;">
        <div class="modal-dialog relative flex items-center justify-center w-full h-full p-4">
            <div class="modal-content bg-white shadow-lg rounded-lg p-6 max-w-md w-full max-h-[90vh] overflow-y-auto">

                <div class="modal-header flex justify-center items-center relative">
                    <h2 class="text-2xl font-bold text-stone-700">Confirm Logout</h2>
                    <span class="btn-close absolute right-4 top-1/2 -translate-y-1/2 hover:text-red-500 cursor-pointer font-bold text-3xl"
                        onclick="closeLogoutModal()" title="Close Modal">
                        &times;
                    </span>
                </div>

                <div class="modal-body text-center">
                    <p class="text-gray-700 mb-4">Are you sure you want to log out?</p>

                    <div class="flex justify-center gap-4">
                        <button onclick="closeLogoutModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition duration-300">
                            Cancel
                        </button>

                        <a href="../include/logout.php" class="px-4 py-2 bg-red-900 text-white rounded-lg hover:bg-red-900 transition duration-300">
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript to Open and Close Logout Modal -->
    <script>
        function openLogoutModal() {
            document.getElementById("logout-modal").style.display = "block";
        }

        function closeLogoutModal() {
            document.getElementById("logout-modal").style.display = "none";
        }


        // <!-- JavaScript to Open and Close Modal -->

        function openResetPwModal() {
            document.getElementById("resetpw-modal").style.display = "block";
            document.getElementById("login-modal").style.display = "none";
        }

        function closeResetPwModal() {
            document.getElementById("resetpw-modal").style.display = "none";

        }


        // <!-- ChangePwModal -->

        function openChangePwModal() {
            document.getElementById("changepw-modal").style.display = "block";
        }

        function closeChangePwModal() {
            document.getElementById("changepw-modal").style.display = "none";
        }


        // <!-- rest pw section  -->
        function toggleDropdown() {
            const dropdown = document.getElementById("pfdropdown-menu"); // Corrected ID
            dropdown.classList.toggle("hidden");
        }

        // Close the dropdown if clicked outside
        document.addEventListener("click", function(event) {
            const dropdown = document.getElementById("pfdropdown-menu"); // Corrected ID
            const button = document.querySelector(".relative > button");

            if (dropdown && button && !button.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add("hidden");
            }
        });
    </script>