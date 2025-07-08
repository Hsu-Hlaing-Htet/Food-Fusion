<?php
include('db.php');

// Get filter parameters from the URL
$difficulty = isset($_GET['difficulty']) ? $_GET['difficulty'] : '';
$cuisine_name = isset($_GET['cuisine_name']) ? $_GET['cuisine_name'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

$recipes_per_page = 8;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $recipes_per_page;

// SQL for counting total recipes without pagination
$total_sql = "SELECT COUNT(*) as total FROM recipes r WHERE 1=1";
$params = [];
$types = '';

if (!empty($difficulty)) {
    $total_sql .= " AND r.difficulty_level = ?";
    $params[] = $difficulty;
    $types .= 's';
}
if (!empty($cuisine_name)) {
    $total_sql .= " AND r.cuisine_name LIKE ?";
    $params[] = "%" . $cuisine_name . "%";
    $types .= 's';
}
if (!empty($search)) {
    $total_sql .= " AND r.title LIKE ?";
    $params[] = "%" . $search . "%";
    $types .= 's';
}

$total_stmt = $conn->prepare($total_sql);
if (!empty($params)) {
    $total_stmt->bind_param($types, ...$params);
}
$total_stmt->execute();
$total_result = $total_stmt->get_result();
$total_row = $total_result->fetch_assoc();
$total_recipes = $total_row['total'];
$total_pages = ($total_recipes <= $recipes_per_page) ? 1 : ceil($total_recipes / $recipes_per_page);

// Build the main SQL query with filters and pagination
$sql = "SELECT r.*, u.name AS username, u.profile_picture 
        FROM recipes r 
        JOIN users u ON r.user_id = u.user_id 
        WHERE 1=1";

if (!empty($difficulty)) {
    $sql .= " AND r.difficulty_level = ?";
}
if (!empty($cuisine_name)) {
    $sql .= " AND r.cuisine_name LIKE ?";
}
if (!empty($search)) {
    $sql .= " AND r.title LIKE ?";
}

$sql .= " LIMIT ? OFFSET ?";

$stmt = $conn->prepare($sql);
$params[] = $recipes_per_page;
$params[] = $offset;
$types .= 'ii';

$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

// Check if there are any recipes
if ($result->num_rows > 0) {
    while ($recipe = $result->fetch_assoc()) {
?>

        <!-- Display Recipe Content -->
        <a class="group bg-white rounded-lg shadow-md hover:shadow-xl transition-all duration-300 transform hover:scale-105" href="show_receipe.php?id=<?= $recipe['id'] ?>">
            <div class="w-full h-40 overflow-hidden rounded-lg">
                <img src="<?php echo $recipe['image']; ?>" alt="<?php echo $recipe['title']; ?>"
                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
            </div>
            <div class="mt-4 px-4">
                <p class="text-lg font-semibold transition-colors duration-300 group-hover:text-red-900">
                    <?php echo $recipe['title']; ?>
                </p>
                <p class="text-sm text-gray-500">By <?php echo $recipe['username']; ?></p>
            </div>
            <div class="flex justify-between items-center mt-2 px-4">
                <p class="text-sm bg-red-900 text-white px-2 py-1 rounded transition-transform duration-300 hover:scale-105">
                    <?php echo $recipe['cuisine_name']; ?>
                </p>
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

                        for ($i = 0; $i < $full_stars; $i++) {
                            echo '<i class="fas fa-star"></i>';
                        }

                        if ($has_half_star) {
                            echo '<i class="fas fa-star-half-alt"></i>';
                        }

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
    // Add hidden input for total pages
    echo "<input type='hidden' id='totalPagesHidden' value='{$total_pages}'>";
} else {
    echo "<div class='flex justify-center items-center'><p class='text-center text-red-900'>No recipes found.</p></div>";
    // Ensure no pagination is shown
    echo "<input type='hidden' id='totalPagesHidden' value='0'>";
}
?>