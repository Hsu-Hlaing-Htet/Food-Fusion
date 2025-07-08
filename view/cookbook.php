<?php
session_start();
// Redirect to index.php if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../view/index.php");
    exit();
}

include '../layouts/header.php';
include('../include/db.php');

$userId = $_SESSION['user_id'];

$userStmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$userStmt->bind_param("i", $userId);
$userStmt->execute();
$userResult = $userStmt->get_result();
$userData = $userResult->fetch_assoc();


if ($userData) {
    $profile_img = $userData['profile_picture'];
} else {
    $profile_img = '/FoodFusion/assets/Images/profile/default.png';
}

?>

<?php if (isset($_COOKIE['login_success'])): ?>
    <div id="login-message" class="fixed top-5 right-5 md:right-5 md:left-auto left-1/2 md:left-auto md:translate-x-0 -translate-x-1/2 flex items-center gap-3 px-6 py-4 bg-green-50 text-green-800 border-l-4 border-green-500 rounded-lg shadow-lg animate-slideIn overflow-hidden transform transition-all duration-300 z-[1000] max-w-[95vw] md:max-w-[320px]">
        <!-- Checkmark icon -->
        <svg class="w-5 h-5 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>

        <span class="text-sm font-medium">Successfully logged in! Welcome back!</span>
    </div>
    <script>
        setTimeout(() => {
            document.getElementById('login-message').style.display = 'none';
        }, 3000);
    </script>
<?php
    // Delete the cookie
    setcookie('login_success', '', time() - 3600, '/');
endif;
?>

<section class="">
    <!--start banner section  -->
    <div class="relative w-full h-[500px] bg-cover bg-center overflow-hidden" style="background-image: url('../assets/Images/banner/banner3.svg');">
        <div class="absolute inset-0 flex flex-col items-center justify-center text-center text-white lg:w-[800px] mx-auto">
            <div class="space-y-6">
                <h2 class="text-2xl font-bold text-red-900 animate-fade-in-down animation-delay-200 opacity-0">
                    Discover Our Community Cookbook
                </h2>

                <p class="text-lg mt-2 text-stone-600 px-4 animate-slide-in-left animation-delay-400 opacity-0">
                    Our Community Cookbook brings together a vibrant collection of recipes contributed by food enthusiasts from around the globe. This is where home cooks, professional chefs, and food lovers share their favorite recipes, cooking tips, and unique twists on classic dishes.
                </p>

                <div class="animate-fade-in-up animation-delay-600 opacity-0">
                    <a href="add_receipe.php" class="inline-block font-semibold px-6 py-3 bg-[#800020] text-white rounded-full hover:bg-[#600018] mt-4 transition-all duration-300 hover:scale-105  animate-pulse animation-delay-800">
                        Share Your Recipe
                    </a>
                </div>
            </div>
        </div>
    </div>


    <section class="flex justify-center items-center">
        <div class="p-6 md:p-8 mx-4 lg:w-[400px] w-full relative">
            <!-- Profile Section -->
            <div class="relative text-center">
                <div class="relative mx-auto w-fit">
                    <div class="relative flex justify-center items-center">
                        <img id="profilePreview" src="/FoodFusion/assets/Images/profile/<?= htmlspecialchars(basename($profile_img)) ?>"
                            alt="Profile"
                            class="w-24 h-24 md:w-32 md:h-32 rounded-full shadow-md border-4 border-stone-600/30 object-cover">

                        <!-- Change Photo Button -->
                        <button id="openProfileForm" class="absolute -bottom-2 right-0 bg-red-900 hover:bg-red-800 text-[#EBE6DA] px-4 py-1 rounded-full text-sm font-medium 
                        transition-all duration-300 shadow-md hover:shadow-lg flex items-center gap-2">
                            <i class="fas fa-camera text-xs"></i>
                            <span>Change</span>
                        </button>
                    </div>
                </div>

                <!-- User Info -->
                <div class="mt-6">
                    <h1 class="text-2xl md:text-3xl font-bold text-stone-600 mb-1">
                        <?= htmlspecialchars($_SESSION['username']) ?>
                    </h1>
                    <p class="text-stone-600/80 text-sm md:text-base">
                        <?= htmlspecialchars($_SESSION['email'] ?? 'Email Not Available') ?>
                    </p>
                </div>
            </div>

            <!-- Profile Management Form (Hidden by default) -->
            <div id="profileForm" class="hidden fixed inset-0 bg-stone-600/50 z-50 flex items-center justify-center">
                <div class="bg-[#EBE6DA] p-6 rounded-2xl w-full max-w-md mx-4 relative">
                    <button id="closeProfileForm" class="absolute top-4 right-4 text-stone-600 hover:text-red-900">
                        <i class="fas fa-times text-xl"></i>
                    </button>

                    <h2 class="text-2xl font-bold text-stone-600 mb-4">Update Profile Photo</h2>

                    <form id="profileUpdateForm" enctype="multipart/form-data" method="POST" action="../include/change_profile.php">
                        <div class="space-y-4">
                            <!-- Profile Image Upload -->
                            <div class="relative flex justify-center items-center">

                                <!-- Upload Area -->
                                <label class="w-24 h-24 md:w-32 md:h-32 rounded-full overflow-hidden bg-[#EBE6DA] border-2 border-stone-600/30 flex items-center justify-center cursor-pointer hover:border-red-900/50 transition">
                                    <!-- Profile Image Preview -->
                                    <img id="formProfilePreview" src="/FoodFusion/assets/Images/profile/<?= htmlspecialchars(basename($profile_img)) ?>"
                                        class="w-full h-full object-cover">

                                    <!-- Upload Icon (Only visible when no image is selected) -->
                                    <div id="uploadIcon" class="absolute flex flex-col items-center justify-center text-center text-stone-600/50">
                                        <i class="fas fa-cloud-upload-alt text-3xl mb-2"></i>
                                        <p class="text-sm text-stone-600/80">
                                            <span class="font-semibold">Click to upload</span> or drag and drop
                                        </p>
                                    </div>

                                    <!-- Hidden File Input -->
                                    <input type="file" id="profileImage" name="profile_image" class="hidden" accept="image/*">
                                </label>
                            </div>

                            <!-- Form Actions -->
                            <div class="flex gap-4 mt-6">
                                <button type="button" id="cancelProfileForm"
                                    class="flex-1 px-4 py-2 bg-stone-600/80 text-[#EBE6DA] rounded-lg hover:bg-stone-600 transition-colors">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="flex-1 px-4 py-2 bg-red-900 text-[#EBE6DA] rounded-lg hover:bg-red-800 transition-colors">
                                    Save Changes
                                </button>
                            </div>

                    </form>
                </div>
            </div>

        </div>
    </section>
    <!-- start past history  -->

    <!-- user post  -->
    <div class="flex max-w-7xl mx-auto space-x-2 gap-2 flex-col lg:flex-row p-5 ">
        <!-- Posts by User Section -->
        <div class="flex-shrink-0 w-full lg:w-3/5 mb-3">
            <h2 class="text-2xl font-semibold text-stone-700 mb-4">Uploaded Posts</h2>
            <?php
            // Fetch all recipes posted by the user
            $user_id = $_SESSION['user_id'];
            $query = "SELECT * FROM recipes WHERE user_id = ? ORDER BY updated_at DESC";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($recipe = $result->fetch_assoc()) {
            ?>
                    <!-- Post Card Structure -->
                    <div class="bg-white rounded-lg shadow-lg mb-6">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm text-gray-600">
                                    <?php
                                    if (!empty($recipe['updated_at'])) {
                                        // Format date to show day name, date, and time
                                        $formattedDate = date('l, F j, Y \a\t g:i A', strtotime($recipe['updated_at']));
                                        echo htmlspecialchars($formattedDate);
                                    } else {
                                        echo 'Not updated yet';
                                    }
                                    ?>
                                </p>
                            </div>

                            <!-- Rest of your dropdown code remains the same -->
                            <div class="relative">
                                <button class="text-gray-500 hover:text-gray-700 p-2 rounded-full transition-colors focus:outline-none">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                                <div class="settings-dropdown hidden absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg py-2 border border-gray-100">
                                    <a href="edit_receipe.php?id=<?= $recipe['id'] ?>"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                        <i class="fas fa-pen mr-3 text-blue-500 w-4"></i>
                                        Edit
                                    </a>
                                    <form method="POST" action="../include/delete_recipe.php" class="w-full">
                                        <input type="hidden" name="recipe_id" value="<?= $recipe['id'] ?>">
                                        <button type="submit"
                                            onclick="return confirm('Permanently delete this recipe?')"
                                            class="w-full flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                            <i class="fas fa-trash-alt mr-3 text-red-500 w-4"></i>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Post Image -->
                        <div class="flex justify-center items-center w-full h-[500px] bg-gray-500">
                            <img src="<?php echo htmlspecialchars($recipe['image']); ?>" alt="<?php echo htmlspecialchars($recipe['title']); ?>" class="w-3/4 h-full object-cover">
                        </div>

                        <!-- Post Content -->
                        <div class="px-6">
                            <h2 class="text-2xl font-semibold text-gray-800"><?php echo htmlspecialchars($recipe['title']); ?></h2>
                            <p class="text-gray-600 mt-2"><?php echo htmlspecialchars($recipe['description']); ?>
                                <a href="show_receipe.php?id=<?= $recipe['id'] ?>"
                                    class="text-blue-500 hover:text-blue-700 text-sm px-3 py-1 transition-all">
                                    Read More
                                </a>
                            </p>


                            <!-- Ratings Section -->
                            <div class="flex items-center mt-4">
                                <?php
                                $recipe_id = $recipe['id'];
                                $rating_stmt = $conn->prepare("SELECT AVG(rating) AS average_rating, COUNT(*) AS total_reviews FROM reviews WHERE recipe_id = ?");
                                $rating_stmt->bind_param("i", $recipe_id);
                                $rating_stmt->execute();
                                $rating_result = $rating_stmt->get_result(); // Changed variable name
                                $rating_data = $rating_result->fetch_assoc();

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

                            <!-- Inside the recipe card -->
                            <div class="mt-4 flex items-center justify-between">
                                <!-- Social Actions Left -->
                                <div class="flex space-x-4">
                                    <!-- Like Button -->
                                    <?php
                                    // Fetch the like count from the database
                                    $recipe_id = $recipe['id'];
                                    $likes_stmt = $conn->prepare("SELECT COUNT(*) AS likes_count FROM likes WHERE recipe_id = ?"); // Changed to $likes_stmt
                                    $likes_stmt->bind_param("i", $recipe_id);
                                    $likes_stmt->execute();
                                    $likes_result = $likes_stmt->get_result(); // Changed to $likes_result
                                    $like_data = $likes_result->fetch_assoc();
                                    $likes_count = $like_data['likes_count'] ?? 0;
                                    $likes_stmt->close(); // Close the likes statement
                                    ?>
                                    <button class="social-btn group" data-recipe-id="<?= $recipe['id'] ?>">
                                        <i class="fas fa-thumbs-up"></i>
                                        <span class="action-text">Like</span>
                                        <span class="count"><?= $likes_count ?></span>
                                    </button>

                                    <!-- Comment Dropdown -->
                                    <?php
                                    $count_stmt = $conn->prepare("SELECT COUNT(*) AS comment_count 
                                                                        FROM reviews 
                                                                        WHERE recipe_id = ? 
                                                                        AND comment IS NOT NULL 
                                                                        AND TRIM(comment) <> ''");
                                    $count_stmt->bind_param("i", $recipe['id']);
                                    $count_stmt->execute();
                                    $count_result = $count_stmt->get_result();
                                    $comment_count = $count_result->fetch_assoc()['comment_count'];
                                    $count_stmt->close();
                                    ?>

                                    <button onclick="toggleCommentDropdown(<?= htmlspecialchars($recipe['id']) ?>)" class="social-btn group">
                                        <i class="fas fa-comment"></i>
                                        <span class="action-text">Comment</span>
                                        <span class="count"><?= $comment_count ?></span>
                                    </button>


                                    <!-- Share Button -->
                                    <div class="social-btn group">
                                        <!-- Share Button Section -->
                                        <div class="relative">
                                            <button class="share-btn flex items-center px-4 py-2 rounded-lg text-gray-600 transition-all duration-200 ease-in-out"
                                                onclick="toggleShareOptions(event)">
                                                <i class="fas fa-share-alt mr-2"></i> Share
                                            </button>

                                            <!-- Share Options Dropdown -->
                                            <div id="shareOptions" class="hidden absolute top-full right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-40">
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
                            </div>

                            <div class="flex items-center mt-4">
                                <div class="flex items-center text-yellow-500">
                                </div>
                                <span class="text-gray-600 ml-3"></span>
                            </div>

                            <!-- Comments Dropdown -->
                            <div id="comment-<?= htmlspecialchars($recipe['id']) ?>" class="hidden commentsdropdown mt-4 flex flex-col gap-2">

                                <?php
                                $current_recipe_id = $recipe['id'];
                                $comment_stmt = $conn->prepare("SELECT 
                                                                        r.comment, 
                                                                        r.created_at, 
                                                                        u.name, 
                                                                        u.profile_picture 
                                                                        FROM reviews r
                                                                        JOIN users u ON r.user_id = u.user_id
                                                                        WHERE r.recipe_id = ? 
                                                                        AND r.comment IS NOT NULL
                                                                        AND TRIM(r.comment) <> ''
                                                                        ORDER BY r.created_at DESC");

                                $comment_stmt->bind_param("i", $current_recipe_id);
                                $comment_stmt->execute();
                                $comments_result = $comment_stmt->get_result();

                                if ($comments_result->num_rows > 0) {
                                    while ($comment = $comments_result->fetch_assoc()) {
                                ?>
                                        <div class="comment py-2">
                                            <div class="comment-header flex items-center">
                                                <img src="<?= '/FoodFusion/' . htmlspecialchars($comment['profile_picture']) ?>"
                                                    alt="Profile Picture" class="w-8 h-8 rounded-full mr-2">
                                                <div>
                                                    <span class="font-semibold"><?= htmlspecialchars($comment['name']) ?></span>
                                                    <span class="text-gray-500 text-sm ml-2">
                                                        <?= date('M j, Y', strtotime($comment['created_at'])) ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="comment-body mt-2 ml-10">
                                                <p class="text-gray-700"><?= htmlspecialchars($comment['comment']) ?></p>
                                            </div>
                                            <hr class="my-3">
                                        </div>
                                <?php
                                    }
                                } else {
                                    echo '<p class="text-gray-500 py-2">No comments yet. Be the first to comment!</p>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>

            <?php
                }
            } else {
                echo "No recipes found for this user.";
            }
            ?>


        </div>

        <!-- Favorites Section -->
        <div class="flex-shrink-0 w-full lg:order-last lg:w-1/5">
            <h2 class="text-2xl font-semibold text-stone-700 mb-4">Your Favorites</h2>
            <!-- Recent Views Section -->
            <?php
            include('../include/db.php');

            // Check if user is logged in
            $userId = $_SESSION['user_id'] ?? null;

            // Fetch user data
            $userData = [];
            if ($userId) {
                $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
                $stmt->bind_param("i", $userId);
                $stmt->execute();
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();
            }

            // Fetch favorite recipes
            $favorites = [];
            if ($userId) {
                $favStmt = $conn->prepare("
                            SELECT r.id, r.title, r.description, r.image, r.created_at 
                            FROM favorites f
                            JOIN recipes r ON f.recipe_id = r.id
                            WHERE f.user_id = ?
                                                ");
                $favStmt->bind_param("i", $userId);
                $favStmt->execute();
                $favResult = $favStmt->get_result();
                $favorites = $favResult->fetch_all(MYSQLI_ASSOC);
            }
            ?>

            <?php if (!empty($favorites)): ?>
                <div class="flex overflow-x-auto gap-4 pb-4">
                    <?php foreach ($favorites as $recipe): ?>
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden w-64 flex-shrink-0">
                            <!-- Recipe Image -->
                            <div class="w-full h-40 relative">

                                <img src="<?php echo htmlspecialchars($recipe['image']); ?>"
                                    alt="<?= htmlspecialchars($recipe['title']) ?>"
                                    class="w-full h-full object-cover">


                            </div>
                            <!-- User Profile Badge -->
                            <div class="flex items-center px-4 py-3">
                                <?php

                                $recipe_id = $recipe['id'];

                                $recipeStmt = $conn->prepare("SELECT user_id FROM recipes WHERE id = ?");
                                $recipeStmt->bind_param("i", $recipe_id);
                                $recipeStmt->execute();
                                $recipeResult = $recipeStmt->get_result();
                                $recipeData = $recipeResult->fetch_assoc();

                                $authorData = null; // Ensure it's defined to avoid errors

                                if ($recipeData) {
                                    $user_id = $recipeData['user_id'];

                                    // Fetch user details
                                    $authorStmt = $conn->prepare("SELECT name, profile_picture FROM users WHERE user_id = ?");
                                    $authorStmt->bind_param("i", $user_id);
                                    $authorStmt->execute();
                                    $authorResult = $authorStmt->get_result();
                                    $authorData = $authorResult->fetch_assoc();
                                }
                                ?>

                                <?php if (!empty($authorData)) : ?>
                                    <img src="<?= '/FoodFusion/' . htmlspecialchars($authorData['profile_picture']) ?>"
                                        alt="Profile Picture" class="w-8 h-8 rounded-full mr-2">
                                    <span><?= htmlspecialchars($authorData['name'] ?? 'Unknown') ?></span>
                                <?php else : ?>
                                    <span>Unknown Author</span>
                                <?php endif; ?>
                            </div>


                            <!-- Recipe Details -->
                            <div class="px-4">
                                <h3 class="text-lg font-semibold text-gray-800 truncate"><?= htmlspecialchars($recipe['title']) ?></h3>
                                <p class="text-gray-600 text-sm mt-2 line-clamp-3"><?= htmlspecialchars($recipe['description']) ?></p>
                                <!-- Rating Display -->
                                <div class="mt-2 text-yellow-500">
                                    <?php
                                    $recipe_id = $recipe['id'];

                                    $ratingStmt = $conn->prepare("SELECT AVG(rating) AS average_rating, COUNT(*) AS total_reviews FROM reviews WHERE recipe_id = ?");
                                    $ratingStmt->bind_param("i", $recipe_id);
                                    $ratingStmt->execute();
                                    $ratingResult = $ratingStmt->get_result();
                                    $ratingData = $ratingResult->fetch_assoc();

                                    // Ensure values are set
                                    $average_rating = number_format($ratingData['average_rating'] ?? 0, 1);
                                    $total_reviews = $ratingData['total_reviews'] ?? 0;
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
                                    <span class="text-gray-600">
                                        <?php if (isset($total_reviews) && $total_reviews > 0): ?>
                                            <?= $average_rating ?> (<?= $total_reviews ?> reviews)
                                        <?php else: ?>
                                            No reviews yet
                                        <?php endif; ?>

                                    </span>
                                </div>

                                <div class="mt-3 flex justify-between items-center">
                                    <a href="show_receipe.php?id=<?= $recipe['id'] ?>"
                                        class="text-blue-500 text-sm hover:text-blue-700">
                                        View Recipe
                                    </a>
                                    <span class="text-xs text-gray-500">
                                        <?= date('M j, Y', strtotime($recipe['created_at'])) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-4 text-gray-500">
                    No favorite recipes yet. Start adding some!
                </div>
            <?php endif; ?>
        </div>


        <!-- Recent Like Section -->
        <div class="flex-shrink-0 w-full lg:order-first lg:w-1/5">
            <h2 class="text-2xl font-semibold text-stone-700 mb-4">Recent Likes</h2>
            <div class="flex overflow-x-auto gap-4 pb-4">
                <?php
                $userId = $_SESSION['user_id'] ?? null;
                if ($userId) {
                    $stmt = $conn->prepare("SELECT r.id, r.title, r.description, r.image, l.created_at AS liked_at
                                    FROM likes l
                                    JOIN recipes r ON l.recipe_id = r.id
                                    WHERE l.user_id = ?
                                    ORDER BY l.created_at DESC");
                    $stmt->bind_param("i", $userId);
                    $stmt->execute();
                    $recentLikes = $stmt->get_result();

                    if ($recentLikes->num_rows > 0) {
                        while ($like = $recentLikes->fetch_assoc()) {
                ?>
                            <div class="bg-white rounded-lg shadow-lg overflow-hidden w-64 flex-shrink-0">
                                <!-- Recipe Image -->
                                <div class="w-full h-40 relative">
                                    <img src="<?= htmlspecialchars($like['image']) ?>"
                                        alt="<?= htmlspecialchars($like['title']) ?>"
                                        class="w-full h-full object-cover">
                                </div>
                                <!-- Profile Section -->
                                <div class="flex items-center px-4 py-3">
                                    <?php
                                    $recipe_id = $like['id'];
                                    $recipeStmt = $conn->prepare("SELECT user_id FROM recipes WHERE id = ?");
                                    $recipeStmt->bind_param("i", $recipe_id);
                                    $recipeStmt->execute();
                                    $recipeResult = $recipeStmt->get_result();
                                    $recipeData = $recipeResult->fetch_assoc();

                                    $authorData = null;
                                    if ($recipeData) {
                                        $user_id = $recipeData['user_id'];

                                        // Fetch user details
                                        $authorStmt = $conn->prepare("SELECT name, profile_picture FROM users WHERE user_id = ?");
                                        $authorStmt->bind_param("i", $user_id);
                                        $authorStmt->execute();
                                        $authorResult = $authorStmt->get_result();
                                        $authorData = $authorResult->fetch_assoc();
                                    }
                                    ?>
                                    <?php if (!empty($authorData)) : ?>
                                        <img src="<?= '/FoodFusion/' . htmlspecialchars($authorData['profile_picture']) ?>"
                                            alt="Profile Picture" class="w-8 h-8 rounded-full mr-2">
                                        <span><?= htmlspecialchars($authorData['name'] ?? 'Unknown') ?></span>
                                    <?php else : ?>
                                        <span>Unknown Author</span>
                                    <?php endif; ?>
                                </div>
                                <!-- Recipe Details -->
                                <div class="px-4">
                                    <h3 class="text-lg font-semibold text-gray-800 truncate"><?= htmlspecialchars($like['title']) ?></h3>
                                    <p class="text-gray-600 text-sm mt-2 line-clamp-3"><?= htmlspecialchars($like['description']) ?></p>
                                    <!-- Rating Display -->
                                    <div class="mt-2 text-yellow-500">
                                        <?php
                                        // Fetch the rating for each recipe
                                        $ratingStmt = $conn->prepare("SELECT AVG(rating) AS average_rating, COUNT(*) AS total_reviews FROM reviews WHERE recipe_id = ?");
                                        $ratingStmt->bind_param("i", $recipe_id);
                                        $ratingStmt->execute();
                                        $ratingResult = $ratingStmt->get_result();
                                        $ratingData = $ratingResult->fetch_assoc();
                                        $average_rating = number_format($ratingData['average_rating'] ?? 0, 1);
                                        $total_reviews = $ratingData['total_reviews'] ?? 0;
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
                                        <span class="text-gray-600">
                                            <?= ($total_reviews > 0) ? "$average_rating ($total_reviews reviews)" : "No reviews yet"; ?>
                                        </span>
                                    </div>
                                    <div class="mt-3 flex justify-between items-center">
                                        <a href="show_receipe.php?id=<?= $like['id'] ?>"
                                            class="text-blue-500 text-sm hover:text-blue-700">
                                            View Recipe
                                        </a>
                                        <span class="text-xs text-gray-500">
                                            <?= date('M j, Y', strtotime($like['liked_at'])) ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php
                        } // End of while loop
                    } else { ?>
                        <div class="text-center py-4 text-gray-500">
                            No favorite recipes yet. Start adding some!
                        </div>
                <?php } // End of if ($recentLikes->num_rows > 0)
                } // End of if ($userId) 
                ?>
            </div>
        </div>


    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Toggle profile form visibility
            function toggleProfileForm() {
                document.getElementById('profileForm').classList.toggle('hidden');
                document.body.classList.toggle('overflow-hidden');
            }

            // Open profile form on change button click
            document.getElementById('openProfileForm').addEventListener('click', function(e) {
                e.preventDefault();
                toggleProfileForm();
            });
            document.getElementById('profileImage').addEventListener('change', function(e) {
                const [file] = e.target.files;
                const preview = document.getElementById('formProfilePreview');
                const uploadIcon = document.getElementById('uploadIcon');

                if (file) {
                    preview.src = URL.createObjectURL(file);
                    uploadIcon.style.display = 'none'; // Hide upload icon when image is selected
                } else {
                    uploadIcon.style.display = 'flex'; // Show icon if no image
                }
            });


            // Close profile form
            document.getElementById('closeProfileForm').addEventListener('click', toggleProfileForm);
            document.getElementById('cancelProfileForm').addEventListener('click', toggleProfileForm);

            // Handle profile image preview in form
            document.getElementById('profileImage').addEventListener('change', function(e) {
                const [file] = e.target.files;
                if (file) {
                    document.getElementById('formProfilePreview').src = URL.createObjectURL(file);
                }
            });
        });
        // Toggle share options visibility
        function toggleShareOptions(event) {
            const shareOptions = document.getElementById('shareOptions');
            shareOptions.classList.toggle('hidden');
        }


        // Toggle comments dropdown
        function toggleCommentDropdown(recipeId) {
            console.log("Recipe ID clicked:", recipeId); // Debugging

            const commentDropdown = document.getElementById(`comment-${recipeId}`);

            if (!commentDropdown) {
                console.error(`Dropdown not found: comment-${recipeId}`); // Debugging
                return;
            }

            commentDropdown.classList.toggle('hidden');
        }

        // Toggle settings dropdown
        document.querySelectorAll('.settings-dropdown').forEach(dropdown => {
            dropdown.previousElementSibling.addEventListener('click', (e) => {
                e.stopPropagation();
                dropdown.classList.toggle('hidden');
            });
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.relative')) {
                document.querySelectorAll('.settings-dropdown').forEach(d => {
                    d.classList.add('hidden');
                });
            }
        });
    </script>
</section>
<?php include '../layouts/footer.php'; ?>