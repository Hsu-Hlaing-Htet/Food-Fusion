<?php include '../layouts/header.php'; ?>

<script src="../assets/js/recipe.js" defer></script>
<section>
    <!-- Banner Section (unchanged) -->
    <div class="relative w-full h-[500px] bg-cover bg-center" style="background-image: url('../assets/Images/banner/banner3.svg');">
        <div class="absolute inset-0 flex flex-col items-center justify-center text-center lg:w-[800px] mx-auto">
            <div class="space-y-6">
                <h2 class="text-2xl font-bold text-red-900 animate-fade-in-down animation-delay-200 opacity-0">
                    Explore Our Recipes
                </h2>

                <p class="text-lg mt-2 text-stone-600 px-4 animate-fade-in-up animation-delay-400 opacity-0">
                    Discover thousands of unique recipes ranging from traditional family favorites to innovative culinary creations. Filter by cuisine, dietary needs, or cooking time.
                </p>
            </div>
        </div>
    </div>

    <!-- Filter Section-->

    <div class="max-w-4xl mx-auto bg-white p-6 animate-fade-in-up animation-delay-900 opacity-0">
        <h2 class="text-2xl font-bold mb-4 text-center">Filter Recipes</h2>
        <div class="flex grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <select id="difficulty" class="border border-gray-300 rounded-md p-2.5 w-full text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-900">
                <option value="">Select Difficulty</option>
                <option value="Easy">Easy</option>
                <option value="Medium">Medium</option>
                <option value="Hard">Hard</option>
            </select>


            <input type="text" name="cuisine_name" id="cuisine_name" class="border border-gray-300 rounded-md p-2.5 w-full text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-900" placeholder="Cuisine name">

            <div class="relative rounded-md shadow-sm">
                <input type="text" id="search"
                    class="block w-full p-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-900 pr-10"
                    placeholder="Search recipes...">
                <button class="absolute inset-y-0 right-0 flex items-center px-3 bg-transparent rounded-r-md transition-colors" id="searchBtn">
                    <i class="fas fa-search text-red-900"></i>
                </button>
            </div>

        </div>
    </div>

    <!-- end Filter Section-->
    <?php
    include('../include/db.php');

    // Define number of recipes per page
    $recipes_per_page = 8;

    // Get the current page or default to 1
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($page - 1) * $recipes_per_page;

    // Prepare the SQL statement to fetch recipes along with the user info
    $stmt = $conn->prepare("
    SELECT r.*, u.name AS username, u.profile_picture 
    FROM recipes r 
    JOIN users u ON r.user_id = u.user_id
    LIMIT ? OFFSET ?
    ");
    $stmt->bind_param("ii", $recipes_per_page, $offset);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch total number of recipes for pagination calculation
    $total_stmt = $conn->prepare("SELECT COUNT(*) as total FROM recipes");
    $total_stmt->execute();
    $total_result = $total_stmt->get_result();
    $total_row = $total_result->fetch_assoc();
    $total_recipes = $total_row['total'];
    $total_pages = ceil($total_recipes / $recipes_per_page);

    ?>

    <!-- Recipe Grid -->
    <div class="mx-auto mx-8 px-8 p-10 mb-8">
        <div>
            <div id="recipes" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6 px-8 mx-6">
                <?php
                if ($result->num_rows > 0) {
                    // Loop through the results and display them
                    while ($recipe = $result->fetch_assoc()) {
                ?>

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

                                // Use different variable name to avoid conflict
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
                    echo "Recipe not found.";
                }
                ?>
            </div>


            <?php if ($total_pages > 1) { ?>
                <div class="mt-6 flex justify-center" id="totalPages">
                    <ul class="flex space-x-4">
                        <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                            <li>
                                <a href="?page=<?php echo $i; ?>" class="px-4 py-2 <?php echo ($i == $page) ? 'border-2 border-red-900 text-red-900' : 'bg-gray-200 hover:bg-red-900 hover:text-white'; ?> rounded">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>


            <input type="hidden" id="totalPagesHidden" value="<?php echo $total_pages; ?>">
        </div>


    </div>

    <!-- Sticky Navigation -->
    <div class="sticky top-0 bg-white/80 backdrop-blur-md shadow-lg z-50 border-b-4 border-red-900/20 ">
        <h2 class="text-2xl md:text-3xl font-extrabold text-center mb-4 md:mb-6 text-stone-700">
            Discover Delicious Meals for Today
        </h2>
        <p class="text-lg text-center text-gray-700 mb-6 md:mb-8">
            Explore a variety of tasty dishes, from hearty dinners to delightful desserts.
            Find your perfect meal and enjoy every bite!
        </p>

        <ul class="flex justify-around text-lg mt-5" id="recipe-category">
            <li><a href="#dinner" class="nav-link hover:text-red-900" id="Dinner">Dinner</a></li>
            <li><a href="#dessert" class="nav-link hover:text-red-900" id="Dessert">Dessert</a></li>
            <li><a href="#main" class="nav-link hover:text-red-900" id="Main">Main</a></li>
            <li><a href="#soup" class="nav-link hover:text-red-900" id="Soup">Soup</a></li>
        </ul>

    </div>

    <section class="px-6 md:px-10">
        <h2 class="text-2xl md:text-3xl font-bold text-center mb-6 md:mb-8 text-red-900"></h2>

        <!-- Slider Container for Cards -->
        <div id="slider-container" class="relative overflow-hidden">
            <!-- Default Slider Content (Default Cuisine) -->
            <div id="slider" class="flex space-x-4 transition-transform duration-500 ease-in-out px-6 md:px-12 mx-20 gap-10">
            </div>

            <!-- Navigation Buttons -->
            <button id="prev" class="text-3xl absolute left-4 top-1/2 transform -translate-y-1/2 text-red-800 bg-white hover:bg-black/20 hover:scale-105 hover:shadow-2xl active:scale-95 p-3 rounded-full shadow-xl transition-all duration-300 w-12 h-12 flex items-center justify-center disabled:opacity-50 disabled:pointer-events-none z-10">
                &#10094;
            </button>

            <button id="next" class="text-3xl absolute right-4 top-1/2 transform -translate-y-1/2 text-red-800 bg-white hover:bg-black/20 hover:scale-105 hover:shadow-2xl active:scale-95 p-3 rounded-full shadow-xl transition-all duration-300 w-12 h-12 flex items-center justify-center disabled:opacity-50 disabled:pointer-events-none z-10">
                &#10095;
            </button>
        </div>
    </section>



</section>


<?php include '../layouts/footer.php'; ?>