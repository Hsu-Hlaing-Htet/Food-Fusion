<?php include '../layouts/header.php'; ?>
<?php
include('../include/db.php');

// Check if 'id' is passed via GET
if (isset($_GET['id'])) {
    $recipeId = $_GET['id'];

    // Prepare the query to fetch recipe details along with the user's name and profile picture
    $stmt = $conn->prepare("
        SELECT r.*, u.name AS username, u.profile_picture 
        FROM recipes r 
        JOIN users u ON r.user_id = u.user_id
        WHERE r.id = ?
    ");
    $stmt->bind_param("i", $recipeId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the recipe exists
    if ($result->num_rows > 0) {
        $recipe = $result->fetch_assoc();
    } else {
        echo "Recipe not found.";
        exit;
    }

    // Fetch ingredients
    $stmt = $conn->prepare("SELECT name, quantity FROM recipe_ingredients WHERE recipe_id = ?");
    $stmt->bind_param("i", $recipeId);
    $stmt->execute();
    $ingredients = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // Fetch cooking steps
    $stmt = $conn->prepare("SELECT description FROM recipe_cooking_steps WHERE recipe_id = ?");
    $stmt->bind_param("i", $recipeId);
    $stmt->execute();
    $cooking_steps = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
} else {
    echo "No recipe ID provided.";
    exit;
}

// Check if profile image exists, else set default
$profile_img = !empty($recipe['profile_picture']) ? $recipe['profile_picture'] : 'default.png';

?>

<!-- Display Recipe Details -->
<section class="grid grid-cols-1 md:grid-cols-3 p-8 bg-white">
    <!-- Recipe Detail -->
    <div class="md:col-span-2 bg-[#f4f4f4]">
        <div class="shadow overflow-hidden w-full">
            <!-- user profile -->
            <div class="flex flex-col sm:flex-row items-center space-x-0 p-6">
                <img src="/FoodFusion/assets/Images/profile/<?php echo htmlspecialchars(basename($profile_img)); ?>"
                    alt="Profile" class="w-16 h-16 sm:w-16 sm:h-16 rounded-full shadow-md border-2 border-gray-300">
                <div class="text-center sm:text-left mt-4 px-3 sm:mt-0">
                    <p class="text-md font-semibold text-gray-900"><?php echo htmlspecialchars($recipe['username']); ?></p>
                    <p class="text-sm text-gray-600"><?php $formattedDate = date('l, F j, Y \a\t g:i A', strtotime($recipe['updated_at']));
                                                        echo htmlspecialchars($formattedDate); ?></p>
                </div>
            </div>
            <!-- recipe detail  -->
            <div id="recipe-container">
                <!-- Recipe Title -->
                <h2 class="text-xl sm:text-3xl font-semibold text-stone-900 px-6 mb-4"><?php echo htmlspecialchars($recipe['title']); ?></h2>

                <!-- Recipe Image -->
                <?php if (!empty($recipe['image'])): ?>
                    <div class="w-full h-[500px]">
                        <img src="<?php echo htmlspecialchars($recipe['image']); ?>" alt="<?php echo htmlspecialchars($recipe['title']); ?>"
                            class="w-full h-full object-cover">
                    </div>
                <?php endif; ?>

                <div class="flex justify-between">
                    <!-- Ratings Section -->
                    <div class="flex items-center px-6 mt-2">
                        <?php
                        // Get average rating and total reviews from database
                        $recipe_id = $recipe['id']; // Make sure $recipe is defined earlier
                        $stmt = $conn->prepare("SELECT 
                            AVG(rating) AS average_rating, 
                            COUNT(*) AS total_reviews 
                            FROM reviews 
                            WHERE recipe_id = ?");
                        $stmt->bind_param("i", $recipe_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $rating_data = $result->fetch_assoc();

                        $average_rating = number_format($rating_data['average_rating'] ?? 0, 1);
                        $total_reviews = $rating_data['total_reviews'] ?? 0;
                        ?>

                        <div class="flex text-yellow-500 space-x-1">
                            <?php
                            $full_stars = floor($average_rating);
                            $has_half_star = (float)$average_rating - $full_stars >= 0.5;
                            $empty_stars = 5 - $full_stars - ($has_half_star ? 1 : 0);

                            // Full stars
                            for ($i = 0; $i < $full_stars; $i++) {
                                echo '<i class="fas fa-star"></i>';
                            }

                            // Half star
                            if ($has_half_star) {
                                echo '<i class="fas fa-star-half-alt"></i>';
                            }

                            // Empty stars
                            for ($i = 0; $i < $empty_stars; $i++) {
                                echo '<i class="far fa-star"></i>';
                            }
                            ?>
                        </div>

                        <span class="text-gray-600 ml-3">
                            <?php if ($total_reviews > 0): ?>
                                <?= $average_rating ?> (<?= $total_reviews ?> reviews)
                            <?php else: ?>
                                No reviews yet
                            <?php endif; ?>
                        </span>
                    </div>


                    <div class="flex items-center px-6 mt-2">

                        <!-- Download Button -->
                        <button class="download-btn flex items-center px-4 py-2 rounded-lg text-gray-700 hover:text-white hover:bg-gray-600 transition-all duration-200 ease-in-out"
                            onclick="downloadRecipe()">
                            <i class="fas fa-download mr-2"></i> Download
                        </button>
                        <!-- Print Button -->
                        <button class="print-btn flex items-center px-4 py-2 rounded-lg text-gray-700 hover:text-white hover:bg-gray-600 transition-all duration-200 ease-in-out"
                            onclick="window.print()">
                            <i class="fas fa-print mr-2"></i> Print
                        </button>
                    </div>
                </div>

                <!-- Recipe Content -->
                <div class="p-6">
                    <p class="text-gray-800 mt-3 leading-relaxed font-semibold">Description:</p>
                    <p class="text-stone-600 mt-3 leading-relaxed"><?php echo nl2br(htmlspecialchars($recipe['description'] ?? ' ')); ?></p>

                    <!-- Recipe Details in Row Format -->
                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:flex lg:flex-wrap text-gray-700 text-sm sm:text-base">
                        <div class="items-center space-x-2 lg:border-r-2 lg:border-dashed lg:border-stone-600 px-4 py-2">
                            <i class="fas fa-utensils text-gray-500"></i><strong>Cuisine:</strong>
                            <p> <?php echo htmlspecialchars($recipe['cuisine_name'] ?? ' '); ?></p>
                        </div>
                        <div class="items-center space-x-2 lg:border-r-2 lg:border-dashed lg:border-stone-600 px-4 py-2">
                            <i class="fas fa-chart-line text-gray-500"></i><strong>Difficulty:</strong>
                            <p><?php echo htmlspecialchars($recipe['difficulty_level'] ?? ' '); ?></p>
                        </div>
                        <div class="items-center space-x-2 lg:border-r-2 lg:border-dashed lg:border-stone-600 px-4 py-2">
                            <i class="fas fa-clock text-gray-500"></i><strong>Prep Time:</strong>
                            <p><?php echo htmlspecialchars($recipe['prep_time'] ?? ' '); ?> min</p>
                        </div>
                        <div class="items-center space-x-2 lg:border-r-2 lg:border-dashed lg:border-stone-600 px-4 py-2">
                            <i class="fas fa-hourglass-half text-gray-500"></i><strong>Cook Time:</strong>
                            <p><?php echo htmlspecialchars($recipe['cook_time'] ?? ' '); ?> min</p>
                        </div>
                        <div class="items-center space-x-2 lg:border-r-2 lg:border-dashed lg:border-stone-600 px-4 py-2">
                            <i class="fas fa-user-friends text-gray-500"></i><strong>Serving:</strong>
                            <p><?php echo htmlspecialchars($recipe['serving']  ?? ' '); ?> People</p>
                        </div>
                        <div class="items-center space-x-2 px-4 py-2">
                            <i class="fas fa-utensils text-gray-500"></i><strong>Category:</strong>
                            <p><?php echo htmlspecialchars($recipe['category'] ?? ' '); ?></p>
                        </div>
                    </div>

                    <!-- Ingredients Section -->
                    <h3 class="text-lg font-semibold mt-4">Ingredients:</h3>
                    <ul class="list-disc list-inside text-gray-700">
                        <?php foreach ($ingredients as $ingredient): ?>
                            <li class="mt-2"><?php echo htmlspecialchars($ingredient['quantity']) . "  " . htmlspecialchars($ingredient['name']); ?></li>
                        <?php endforeach; ?>
                    </ul>

                    <!-- Cooking Steps Section -->
                    <h3 class="text-lg font-semibold mt-4">Cooking Steps:</h3>
                    <ul class="list-none text-gray-700">
                        <?php
                        $stepNumber = 1;
                        foreach ($cooking_steps as $step): ?>
                            <li class="mt-5">
                                <p class="text-lg font-semibold">Step <?php echo $stepNumber; ?>:</p>
                                <?php echo htmlspecialchars($step['description']); ?>
                            </li>
                        <?php
                            $stepNumber++;
                        endforeach; ?>
                    </ul>

                </div>

                <!-- Recipe Video -->

                <?php if (!empty($recipe['video_path'])): ?>
                    <div class="w-full h-[500px]">
                        <video controls class="w-full h-full object-cover">
                            <source src="<?php echo htmlspecialchars($recipe['video_path']); ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>

                <?php endif; ?>
            </div>

            <!-- sign up now  -->
            <div id="joinup-modal" class="modal fade" style="display: none;">
                <div class="modal-dialog bg-[#f4f4f4]">
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <h2 class="text-2xl font-bold pt-4 mt-4">Create account</h2>
                            <p class="text-lg py-3 mb-4">to get started now!</p>
                            <span class="btn-close hover:text-red-500" onclick="closeJoinUpModal()" title="Close Modal">&times;</span>
                        </div>

                        <div class="modal-body">
                            <form method="POST" action="../include/register.php" id="joinup-form" enctype="multipart/form-data">
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
                                    <input type="file" name="image" id="image" autocomplete="off" placeholder="Confirm Password" class="form-control w-full outline-none">
                                </div>

                                <button type="submit" class="w-full bg-red-900 text-white border-2 border-solid border-red-900 py-2 px-4 rounded mb-2 hover:bg-white hover:text-red-900 hover:border-red-900 transition-colors duration-300" id="signup-btn" name="signup-btn">
                                    Sign Up
                                </button>

                                <p class="text-sm py-5 text-center">
                                    Already have an account?
                                    <a href="#" class="text-red-900 hover:text-blue-500" onclick="switchToLogin()">Login Now</a>
                                </p>

                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- reaction section -->
            <div>
                <!-- Always show reaction buttons -->
                <div class="mt-4 flex items-center justify-center space-x-4 gap-20">

                    <!-- like section -->
                    <div class="px-20">
                        <?php
                        include('../include/db.php'); // Ensure correct path

                        $recipe_id = $recipe['id']; // Get recipe ID

                        // Prepare and execute query using MySQLi to get likes count
                        $query = "SELECT COUNT(*) AS likes_count FROM likes WHERE recipe_id = ?";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("i", $recipe_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $like_result = $result->fetch_assoc();
                        $likes_count = $like_result['likes_count'] ?? 0;

                        // Check if the current user has liked the recipe
                        $user_id = $_SESSION['user_id'] ?? null; // Make sure the user is logged in
                        $is_liked = false;

                        if ($user_id) {
                            $sql = "SELECT 1 FROM likes WHERE user_id = ? AND recipe_id = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("ii", $user_id, $recipe_id);
                            $stmt->execute();
                            $stmt->store_result();
                            if ($stmt->num_rows > 0) {
                                $is_liked = true; // The user has liked the recipe
                            }
                        }

                        // Pass the `is_liked` status to the front-end
                        ?>
                        <!-- Like Button -->
                        <button class="like-btn flex items-center <?= $is_liked ? 'text-blue-600' : 'text-gray-500' ?> hover:text-blue-600 transition-all duration-200 ease-in-out mx-2 transition-transform hover:scale-105"
                            data-recipe-id="<?= $recipe_id ?>" data-is-liked="<?= $is_liked ? 'true' : 'false' ?>">
                            <i class="fas fa-thumbs-up mr-2"></i>
                            <span class="like-count"><?= $likes_count ?></span>
                        </button>
                    </div>

                    <!-- favorite -->
                    <div class="px-20">
                        <?php
                        include('../include/db.php'); // Ensure correct path

                        $recipe_id = $recipe['id']; // Get recipe ID

                        // Prepare and execute query using MySQLi
                        $query = "SELECT COUNT(*) AS favorites_count FROM favorites WHERE recipe_id = ?";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("i", $recipe_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $favorite_result = $result->fetch_assoc();
                        $favorite_count = $favorite_result['favorites_count'] ?? 0;

                        // Check if the current user has favorited the recipe
                        $user_id = $_SESSION['user_id'] ?? null; // Make sure the user is logged in
                        $is_favorited = false;

                        if ($user_id) {
                            $sql = "SELECT 1 FROM favorites WHERE user_id = ? AND recipe_id = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("ii", $user_id, $recipe_id);
                            $stmt->execute();
                            $stmt->store_result();
                            if ($stmt->num_rows > 0) {
                                $is_favorited = true; // The user has favorited the recipe
                            }
                        }
                        ?>
                        <!-- Favorite Button -->
                        <button class="favorite-btn flex items-center <?= $is_favorited ? 'text-red-600' : 'text-gray-500' ?> transition-all duration-200 ease-in-out transition-transform hover:scale-105"
                            data-recipe-id="<?= $recipe['id'] ?>">
                            <i class="fas fa-heart mr-2"></i>
                            <span class="favorite-count"><?= $favorite_count ?></span>
                        </button>
                    </div>

                    <!-- share section  -->
                    <div class="px-20">
                        <!-- Share Button Section -->
                        <div class="relative">
                            <button class="share-btn flex items-center px-4 py-2 rounded-lg  text-gray-600 hover:text-green-500 transition-all duration-200 ease-in-out transition-transform hover:scale-105"
                                onclick="toggleShareOptions(event)">
                                <i class="fas fa-share-alt mr-2"></i> Share
                            </button>

                            <!-- Share Options Dropdown -->
                            <div id="shareOptions" class="hidden absolute top-full right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-10">
                                <div class="p-2">
                                    <button class="share-option w-full flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md"
                                        data-platform="facebook">
                                        <i class="fab fa-facebook-f mr-2 text-blue-600"></i> Facebook
                                    </button>
                                    <button class="share-option w-full flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md"
                                        data-platform="twitter">
                                        <i class="fab fa-twitter mr-2 text-blue-400"></i> Twitter
                                    </button>
                                    <button class="share-option w-full flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md"
                                        data-platform="email">
                                        <i class="fas fa-envelope mr-2 text-gray-600"></i> Email
                                    </button>
                                    <button class="share-option w-full flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md"
                                        data-platform="discord">
                                        <i class="fab fa-discord mr-2 text-[#5865F2]"></i> Discord
                                    </button>
                                    <button class="share-option w-full flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md"
                                        data-platform="youtube">
                                        <i class="fab fa-youtube mr-2 text-red-600"></i> YouTube
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <!-- comment section  -->
                <div class="bg-white">
                    <div class="p-6">
                        <h3 class="text-lg text-stone-700 font-semibold">Reviews:</h3>

                        <!-- Display Past Comments -->
                        <div class="comments-list mt-4">
                            <?php
                            $stmt = $conn->prepare("SELECT r.rating, r.comment, r.created_at, u.name, u.profile_picture
                            FROM reviews r
                            JOIN users u ON r.user_id = u.user_id
                            WHERE r.recipe_id = ?
                            ORDER BY r.created_at DESC");
                            $stmt->bind_param("i", $recipeId);
                            $stmt->execute();
                            $comments = $stmt->get_result();

                            while ($comment = $comments->fetch_assoc()):
                            ?>
                                <div class="comment py-2">
                                    <div class="comment-header flex items-center">
                                        <?php
                                        // Check if profile picture exists, otherwise use default
                                        $profilePicture = !empty($comment['profile_picture']) ? '/FoodFusion/' . $comment['profile_picture'] : '/FoodFusion/assets/Images/profile/default_profile.jpg';
                                        ?>
                                        <img src="<?= $profilePicture ?>" class="user-avatar h-16 w-16 rounded-full object-cover">
                                        <div class="ml-3">
                                            <div class="stars text-yellow-500">
                                                <?php for ($i = 0; $i < $comment['rating']; $i++): ?>
                                                    ★
                                                <?php endfor; ?>
                                            </div>
                                            <span class="user-name font-semibold text-lg"><?= $comment['name'] ?></span>
                                            <p class="comment-text text-gray-700"><?= $comment['comment'] ?></p>
                                            <span class="comment-date text-sm text-gray-500"><?= date('M j, Y', strtotime($comment['created_at'])) ?></span>
                                        </div>
                                    </div>
                                </div>


                            <?php endwhile; ?>
                        </div>



                        <!-- Comment Form Section -->
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <div class="review-form">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Leave a Review</h3>

                                <form id="commentForm" action="../include/submit_comment.php" method="POST" class="space-y-4">
                                    <input type="hidden" name="recipe_id" value="<?= htmlspecialchars($recipe['id']) ?>">

                                    <!-- Rating Section -->
                                    <div class="flex items-center space-x-2">
                                        <span class="text-gray-600 text-sm">Your Rating:</span>
                                        <div class="rating-stars flex space-x-1">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <input type="radio" id="star<?= $i ?>" name="rating" value="<?= $i ?>" class="hidden">
                                                <label for="star<?= $i ?>" class="cursor-pointer text-xl">
                                                    <i class="far fa-star rating-icon" data-value="<?= $i ?>"></i>
                                                </label>
                                            <?php endfor; ?>
                                        </div>
                                    </div>

                                    <!-- Comment Box -->
                                    <div class="border rounded-lg transition-all duration-200 focus:outline-none hover:border-red-900 focus:border-red-900 focus:ring-2 focus:ring-red-900">
                                        <textarea name="comment" rows="2"
                                            class="w-full px-4 py-3 rounded-lg resize-none focus:outline-none text-gray-700 placeholder-gray-400"
                                            placeholder="Share your thoughts about this recipe..."
                                            required><?= isset($_SESSION['comment']) ? htmlspecialchars($_SESSION['comment']) : '' ?></textarea>

                                        <!-- Submit Button -->
                                        <div class="flex justify-end p-2">
                                            <button type="submit" class="flex items-center px-4 py-2 bg-red-900 hover:bg-red-200 text-white rounded-lg transition-colors">
                                                <i class="fas fa-paper-plane mr-2"></i>

                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        <?php else: ?>
                            <!-- Login Prompt -->
                            <div class="login-prompt text-center mt-6">
                                <p class="text-gray-700">You must be
                                    <span class="font-semibold text-red-900 cursor-pointer hover:underline"
                                        onclick="showLoginModal()">logged in</span>
                                    to leave a review.
                                </p>
                            </div>
                        <?php endif; ?>

                    </div>

                    <style>
                        .rating-icon {
                            color: #d1d5db;
                            /* Default gray */
                            transition: color 0.2s ease-in-out;
                        }

                        .rating-icon.active {
                            color: #f59e0b !important;
                            /* Yellow */
                        }
                    </style>

                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const stars = document.querySelectorAll(".rating-icon");

                            function updateStars(value) {
                                stars.forEach(star => {
                                    if (parseInt(star.getAttribute("data-value")) <= value) {
                                        star.classList.add("active");
                                        star.classList.replace("far", "fas"); // Solid star when selected
                                    } else {
                                        star.classList.remove("active");
                                        star.classList.replace("fas", "far"); // Outline star when not selected
                                    }
                                });
                            }

                            stars.forEach(star => {
                                star.addEventListener("click", function() {
                                    const value = parseInt(this.getAttribute("data-value"));
                                    document.getElementById("star" + value).checked = true;
                                    updateStars(value);
                                });

                                // Hover effect: temporary star highlighting
                                star.addEventListener("mouseenter", function() {
                                    const value = parseInt(this.getAttribute("data-value"));
                                    stars.forEach(s => {
                                        if (parseInt(s.getAttribute("data-value")) <= value) {
                                            s.classList.add("active");
                                        } else {
                                            s.classList.remove("active");
                                        }
                                    });
                                });

                                // Remove hover effect when mouse leaves
                                star.addEventListener("mouseleave", function() {
                                    const checkedStar = document.querySelector('input[name="rating"]:checked');
                                    updateStars(checkedStar ? parseInt(checkedStar.value) : 0);
                                });
                            });

                            // Ensure selected rating persists when page reloads
                            const checkedStar = document.querySelector('input[name="rating"]:checked');
                            if (checkedStar) {
                                updateStars(parseInt(checkedStar.value));
                            }
                        });
                    </script>


                </div>




            </div>
        </div>
    </div>

    <!-- Related Recipes Grid -->
    <div class="w-full overflow-y-auto w-full flex justify-center overflow-hidden">
        <!-- Loop through each related recipe -->
        <div class="overflow-hidden">
            <h3 class="text-xl leading-relaxed  text-center font-semibold  text-red-800 p-3 mb-4">Related Recipes</h3>
            <div id="recipes" class="flex justify-center flex-wrap gap-4 p-4">

                <?php
                $recipe_id = $recipe['id'];
                // echo $recipe_id;

                // Get the cuisine name of the current recipe
                $cuisine_name = $recipe['cuisine_name'];

                // Modified query to select all recipes with the same cuisine_name
                $stmt = $conn->prepare("
                        SELECT r.*, u.name AS username, u.profile_picture 
                        FROM recipes r 
                        JOIN users u ON r.user_id = u.user_id
                        WHERE r.cuisine_name = ? LIMIT 4
                        ");
                $stmt->bind_param("s", $cuisine_name);  // Bind the cuisine_name to the query
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    // Loop through the results and display them
                    while ($recipe = $result->fetch_assoc()) {
                ?>

                        <a class="bg-[#f4f4f4] rounded-lg shadow-md hover:shadow-lg transition duration-300 w-64" href="show_receipe.php?id=<?= $recipe['id'] ?>">
                            <div class="w-full border-2 h-60 overflow-hidden rounded-lg">
                                <img src="<?php echo $recipe['image']; ?>" alt="<?php echo $recipe['title']; ?>" class="w-full h-full object-cover">
                            </div>
                            <div class="mt-4 px-4">
                                <p class="text-lg font-semibold"><?php echo $recipe['title']; ?></p>
                                <p class="text-sm text-gray-500">By <?php echo $recipe['username']; ?></p>
                            </div>
                            <div class="flex justify-between items-center mt-2 px-4">
                                <p class="text-sm bg-red-900 text-white px-2 py-1 rounded"><?php echo $recipe['cuisine_name']; ?></p>
                                <!-- <p class="text-sm text-gray-500">Recipe ID: <?php echo $recipe['id']; ?></p>  -->
                                <p><span class="font-semibold text-red-900"><?php echo $recipe['difficulty_level']; ?></span></p>
                            </div>
                            <!-- Rating Section -->
                            <div class="mt-2 text-sm text-gray-500 px-4 mb-6">
                                <?php
                                $recipe_id = $recipe['id'];
                                $stmt = $conn->prepare("SELECT 
                                    AVG(rating) AS average_rating, 
                                    COUNT(*) AS total_reviews 
                                    FROM reviews 
                                    WHERE recipe_id = ?");
                                $stmt->bind_param("i", $recipe_id);
                                $stmt->execute();

                                $rating_result = $stmt->get_result();
                                $rating_data = $rating_result->fetch_assoc();

                                $original_average = (float)($rating_data['average_rating'] ?? 0);
                                $average_rating = number_format($original_average, 1);
                                $total_reviews = $rating_data['total_reviews'] ?? 0;
                                ?>

                                <div class="flex items-center">
                                    <div class="flex text-yellow-500 space-x-1">
                                        <?php
                                        $full_stars = floor($original_average);
                                        $has_half_star = ($original_average - $full_stars) >= 0.5;
                                        $empty_stars = 5 - $full_stars - ($has_half_star ? 1 : 0);

                                        // Full stars
                                        for ($i = 0; $i < $full_stars; $i++) {
                                            echo '<i class="fas fa-star"></i>';
                                        }

                                        // Half star
                                        if ($has_half_star) {
                                            echo '<i class="fas fa-star-half-alt"></i>';
                                        }

                                        // Empty stars
                                        for ($i = 0; $i < $empty_stars; $i++) {
                                            echo '<i class="far fa-star"></i>';
                                        }
                                        ?>
                                    </div>

                                    <span class="text-gray-600 ml-3">
                                        <?php if ($total_reviews > 0): ?>
                                            <?= $average_rating ?> (<?= $total_reviews ?> reviews)
                                        <?php else: ?>
                                            No reviews yet
                                        <?php endif; ?>
                                    </span>
                                </div>
                            </div>
                        </a>

                <?php
                    }
                } else {
                    echo "No recipes found with the same cuisine.";
                }
                ?>
            </div>
        </div>
    </div>



</section>

<style>
    @media print {
        * {
            visibility: hidden !important;
        }

        #recipe-container,
        #recipe-container * {
            visibility: visible !important;
        }

        #recipe-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
        }
    }
</style>

<script>
    function downloadRecipe() {
        // Get the content of the recipe container
        const recipeContent = document.getElementById('recipe-container').innerHTML;

        // Create a Blob object to store the content as HTML
        const blob = new Blob([recipeContent], {
            type: 'text/html'
        });

        // Create an anchor element for triggering the download
        const link = document.createElement('a');

        // Set the download file name
        link.download = 'recipe.html';

        // Create an object URL for the Blob object
        link.href = URL.createObjectURL(blob);

        // Trigger the download by simulating a click
        link.click();
    }

    // Add login check functionality
    const isLoggedIn = <?= isset($_SESSION['user_id']) ? 'true' : 'false' ?>;

    // Modal control functions
    function showLoginModal() {
        document.getElementById('login-modal').style.display = 'block';
        document.getElementById('joinup-modal').style.display = 'none';
    }

    function showSignupModal() {
        document.getElementById('joinup-modal').style.display = 'block';
        document.getElementById('login-modal').style.display = 'none';
    }

    function closeModals() {
        document.getElementById('login-modal').style.display = 'none';
        document.getElementById('joinup-modal').style.display = 'none';
    }

    // Switch between modals
    function switchToSignUp() {
        showSignupModal();
    }

    function switchToLogin() {
        showLoginModal();
    }

    // Handle reaction buttons
    document.querySelectorAll('.like-btn, .favorite-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            if (!isLoggedIn) {
                e.preventDefault();
                showLoginModal();
            }
            // Else, existing AJAX functionality continues
        });
    });

    // Handle comment form submission
    const commentForm = document.getElementById('commentForm');
    if (commentForm) {
        commentForm.addEventListener('submit', function(e) {
            if (!isLoggedIn) {
                e.preventDefault();
                showLoginModal();
            }
        });
    }

    // Update modal control to properly handle closing
    document.addEventListener('DOMContentLoaded', () => {
        // Close modals when clicking outside
        window.onclick = function(event) {
            const loginModal = document.getElementById('login-modal');
            const signupModal = document.getElementById('joinup-modal');

            if (event.target === loginModal) loginModal.style.display = 'none';
            if (event.target === signupModal) signupModal.style.display = 'none';
        }
    });

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

    // Close modal when clicking outside
    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            closeModals();
        }
    }


    // like 

    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".like-btn").forEach(button => {
            let recipeId = button.getAttribute("data-recipe-id");
            let likeCountElement = button.querySelector(".like-count");
            let isLiked = button.getAttribute("data-is-liked") === 'true'; // Get the initial like status from the data attribute

            // Set the button color based on the initial like status
            if (isLiked) {
                button.classList.add("text-blue-600");
                button.classList.remove("text-gray-500");
            } else {
                button.classList.remove("text-blue-600");
                button.classList.add("text-gray-500");
            }

            // Handle button click to toggle like status
            button.addEventListener("click", function() {
                // Send a POST request to like.php to toggle like
                fetch("../include/like.php", { // Make sure path is correct
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded"
                        },
                        body: "recipe_id=" + recipeId
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === "liked" || data.status === "unliked") {
                            likeCountElement.textContent = data.likes_count;

                            // Toggle the button's color based on the like status
                            if (data.status === "liked") {
                                button.classList.add("text-blue-600");
                                button.classList.remove("text-gray-500");
                            } else {
                                button.classList.remove("text-blue-600");
                                button.classList.add("text-gray-500");
                            }
                        } else {
                            console.error("Error:", data.message);
                        }
                    })
                    .catch(error => console.error("Fetch Error:", error));
            });
        });
    });


    // favourite 
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".favorite-btn").forEach(button => {
            button.addEventListener("click", function() {
                let recipeId = this.getAttribute("data-recipe-id");
                let favoriteCountElement = this.querySelector(".favorite-count");

                // Send a POST request to favorite.php
                fetch("../include/favorite.php", { // Make sure path is correct
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded"
                        },
                        body: "recipe_id=" + recipeId
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === "favorited" || data.status === "unfavorited") {
                            favoriteCountElement.textContent = data.favorites_count;

                            // Toggle the button's color based on the favorite status
                            if (data.status === "favorited") {
                                this.classList.add("text-red-600");
                                this.classList.remove("text-gray-500");
                            } else {
                                this.classList.remove("text-red-600");
                                this.classList.add("text-gray-500");
                            }
                        } else {
                            console.error("Error:", data.message);
                        }
                    })
                    .catch(error => console.error("Fetch Error:", error));
            });
        });
    });

    // Toggle share options visibility
    function toggleShareOptions(event) {
        const shareOptions = document.getElementById('shareOptions');
        shareOptions.classList.toggle('hidden');
    }

    // Handle share action
    document.querySelectorAll('.share-option').forEach(button => {
        button.addEventListener('click', function() {
            const platform = this.getAttribute('data-platform');
            const recipeUrl = window.location.href; // Get the current URL of the page
            const recipeId = getRecipeIdFromUrl(recipeUrl); // Assuming you have a function to extract the recipe ID

            // Send the share action to the backend
            trackShare(recipeId, platform);

            // Call the share function to open the platform-specific share link
            shareOnPlatform(platform, recipeUrl);
        });
    });

    // Function to send share data to the backend
    function trackShare(recipeId, platform) {
        const data = new FormData();
        data.append('recipe_id', recipeId);
        data.append('platform', platform);

        fetch('share.php', {
                method: 'POST',
                body: data
            })
            .then(response => response.json())
            .then(data => {
                console.log('Share response:', data); // Log response for debugging
                if (data.status === 'success') {
                    console.log('Share tracked successfully');
                } else {
                    console.log('Failed to track share:', data.message);
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Function to handle sharing on different platforms
    // Just sharing functionality, no backend tracking
    function shareOnPlatform(platform, url) {
        switch (platform) {
            case 'facebook':
                window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`, '_blank');
                break;
            case 'twitter':
                window.open(`https://twitter.com/share?url=${encodeURIComponent(url)}`, '_blank');
                break;
            case 'email':
                window.location.href = `mailto:?body=${encodeURIComponent(`Check this recipe: ${url}`)}`;
                break;
            case 'discord':
                window.open(`https://discord.com/channels/@me?message=${encodeURIComponent(url)}`, '_blank');
                break;
            case 'youtube':
                window.open(`https://www.youtube.com/share?url=${encodeURIComponent(url)}`, '_blank');
                break;
            default:
                console.log('Unknown platform:', platform);
        }
    }


    // Function to extract recipe ID from the URL (you can modify this based on how your URLs are structured)
    function getRecipeIdFromUrl(url) {
        const urlParts = url.split('/');
        return urlParts[urlParts.length - 1]; // Assuming the recipe ID is the last part of the URL
    }
</script>

<?php include '../layouts/footer.php'; ?>