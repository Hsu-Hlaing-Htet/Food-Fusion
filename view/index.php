<?php include '../layouts/header.php'; ?>

<!-- start slider -->
<div class="relative w-full mx-auto overflow-hidden group">
    <!-- Navigation Buttons -->
    <button
        class="text-xl absolute left-4 top-1/2 transform -translate-y-1/2 text-red-800 bg-white/50 hover:bg-white p-3 rounded-full shadow-xl transition-all duration-300 w-12 h-12 flex items-center justify-center disabled:opacity-50 z-10"
        aria-label="Previous slide"
        id="prevBtn">
        &#10094;&#10094;
    </button>

    <button
        class="text-xl absolute right-4 top-1/2 transform -translate-y-1/2 text-red-800 bg-white/50 hover:bg-white p-3 rounded-full shadow-xl transition-all duration-300 w-12 h-12 flex items-center justify-center disabled:opacity-50 z-10"
        aria-label="Next slide"
        id="nextBtn">
        &#10095;&#10095;
    </button>

    <?php
    include('../include/db.php');
    $stmt = $conn->prepare("SELECT * FROM recipes ORDER BY updated_at DESC LIMIT 4");
    $stmt->execute();
    $result = $stmt->get_result();
    $slides = [];
    while ($row = $result->fetch_assoc()) {
        $slides[] = $row;
    }
    $slideCount = count($slides);
    ?>

    <div id="cookie-banner" class="hidden fixed bottom-0 left-5 z-50 bg-white text-stone-800 p-4 rounded-xl shadow-xl max-w-xs animate-slide-in-left animation-delay-500">
        <div class="flex flex-col gap-3">
            <div class="flex items-start gap-2">
                <span class="text-xl mt-0.5">🍪</span>
                <div>
                    <p class="text-sm font-medium mb-1">We Value Your Privacy</p>
                    <p class="text-xs text-gray-300 leading-relaxed">
                        We use cookies to enhance your experience. By clicking "Accept All", you agree to our use of cookies.
                        <a href="../../FoodFusion/view/cookiepolicy.php" class="underline hover:text-gray-200 block mt-1">Cookie Policy</a>
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap gap-2 mt-2">
                <button onclick="declineCookies()" class="text-xs px-3 py-1.5 rounded-lg bg-gray-600 hover:bg-gray-700 transition-colors">
                    Decline
                </button>
                <button onclick="acceptCookies()" class="text-xs px-3 py-1.5 rounded-lg bg-green-600 hover:bg-green-700 transition-colors">
                    Accept All
                </button>
            </div>
        </div>
    </div>

    <script>
        // Show banner on page load if cookie not accepted
        document.addEventListener('DOMContentLoaded', function() {
            if (!document.cookie.includes('cookiesAccepted=true')) {
                document.getElementById('cookie-banner').classList.remove('hidden');
            }
        });

        function acceptCookies() {
            document.getElementById('cookie-banner').classList.add('hidden');
            document.cookie = "cookiesAccepted=true; path=/; max-age=" + (60 * 60 * 24 * 365);
        }

        function declineCookies() {
            document.getElementById('cookie-banner').classList.add('hidden');
            document.cookie = "cookiesAccepted=false; path=/; max-age=" + (60 * 60 * 24 * 30);
        }
    </script>


    <!-- Slider Container -->
    <div class="flex transition-transform duration-500 ease-in-out relative" id="bannerslider">
        <?php foreach ($slides as $index => $row): ?>
            <a href="show_receipe.php?id=<?= htmlspecialchars($row['id']) ?>" class="block min-w-full relative group">
                <?php if (!empty($row['image'])): ?>
                    <img
                        src="<?= htmlspecialchars($row['image']) ?>"
                        alt="<?= htmlspecialchars($row['title']) ?>"
                        class="w-full h-96 sm:h-[600px] object-cover">
                <?php else: ?>
                    <div class="w-full h-96 sm:h-[600px] bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-500 text-2xl">No image available</span>
                    </div>
                <?php endif; ?>

                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent p-8 animate-fade-in-up animation-delay-600 opacity-0">
                    <h3 class="text-white font-bold text-3xl mb-4"><?= htmlspecialchars($row['title']) ?></h3>
                    <p class="text-gray-200 text-lg line-clamp-3"><?= htmlspecialchars($row['description'] ?? '') ?></p>
                </div>
            </a>
        <?php endforeach; ?>
        <!-- Slider Indicators -->
        <?php if ($slideCount > 0): ?>
            <!-- <div class="flex gap-3 absolute bottom-0" id="sliderIndicators"> -->
            <?php for ($i = 0; $i < $slideCount; $i++): ?>
                <!-- <button
                        class="w-2 h-2 rounded-full bg-gray-300 transition-all duration-300 hover:bg-gray-400 <?= $i === 0 ? '!bg-gray-600 w-8' : '' ?>"
                        aria-label="Go to slide <?= $i + 1 ?>"
                        data-index="<?= $i ?>"></button> -->
            <?php endfor; ?>
            <!-- </div> -->
        <?php endif; ?>
    </div>


</div>
<!-- end slider -->

<!-- banner section  -->
<section class="bg-[#EBE6DA]">
    <div class="container mx-auto px-4 py-12 lg:py-20 flex flex-col lg:flex-row items-center gap-8">
        <!-- Text Content -->
        <div class="lg:w-1/2 space-y-4 animate-slide-in-left animation-delay-500">
            <h3 class="text-4xl lg:text-5xl font-bold text-[#800020]">
                FoodFusion
            </h3>
            <p class="text-lg lg:text-xl text-stone-600">
                Your destination for culinary excellence from around the world!
            </p>
            <p class="text-lg lg:text-xl text-stone-600">
                Discover, share, and celebrate culinary traditions with FoodFusion!
            </p>
            <div class="">
                <a href="javascript:void(0);"
                    class="inline-block px-6 py-3 bg-[#800020]  text-white rounded-full hover:bg-[#600018] transition-colors animate-pulse animation-delay-500" onclick="openJoinUpModal()">
                    Join Us
                </a>
            </div>
        </div>

        <!-- Image -->
        <div class="lg:w-1/2 animate-slide-in-right delay-300">
            <img src="../assets/Images/banner/burger.png"
                alt="Burger"
                class="w-full max-w-xl hover:rotate-2 transition-transform duration-300">
        </div>
    </div>
</section>
<!-- end banner section  -->

<!-- start dessrt  -->
<section class="">
    <div class="container mx-auto p-6">
        <!-- Section Title -->
        <div class="text-center mb-6">
            <h2 class="text-3xl font-bold text-red-900 text-center mb-6 italic">Best Dessert Ever!</h2>
            <p class="text-lg font-bold text-stone-600 text-center mb-6">Sweet can make you smile.</p>
        </div>

        <!-- Recipe Grid Wrapper -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 mx-auto p-4">

            <?php
            include('../include/db.php');

            // Fetch latest 4 recipes
            $stmt = $conn->prepare("SELECT * FROM recipes WHERE category = 'Dessert' ORDER BY updated_at DESC LIMIT 4");
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) :
            ?>
                <!-- Dynamic Recipe Card -->
                <div class="receipe-card group relative overflow-hidden shadow-lg bg-cover bg-center mb-4 transition-transform duration-300 hover:scale-105 hover:shadow-xl"
                    style="background-image: url('<?php echo htmlspecialchars($row['image']); ?>');">

                    <!-- Dark Overlay -->
                    <div class="bg-black bg-opacity-50 p-6 h-full flex flex-col justify-end relative transition-all duration-300 group-hover:bg-opacity-70">
                        <h2 class="text-lg absolute top-5 sm:top-10 lg:top-40 font-semibold text-white">
                            <a href="show_receipe.php?id=<?= $row['id'] ?>" class="text-white hover:text-red-900 hover:underline hover:underline-red-900">
                                <?php echo htmlspecialchars($row['title']); ?>
                            </a>
                        </h2>
                    </div>

                    <!-- Red Bottom Section with White Separator -->
                    <div class="absolute bottom-0 left-0 w-full">
                        <div class="flex justify-between px-4 py-2 text-white text-sm relative">
                            <span class="absolute bg-red-900 sm:px-10 lg:px-2 py-2 bottom-0 left-0 rounded-tr-2xl border-t-2 border-r-2 border-white">
                                <?php echo htmlspecialchars($row['cuisine_name']); ?>
                            </span>
                            <div class="flex items-center sm:px-10 lg:px-5 rounded-tl-2xl border-t-2 border-l-2 border-white ml-3 absolute bg-red-900 py-2 bottom-0 right-0">
                                <i class="fas fa-utensils text-yellow-400 mr-1"></i>
                                <span><?php echo htmlspecialchars($row['difficulty_level']); ?></span>
                            </div>
                        </div>
                    </div>

                </div>
            <?php endwhile; ?>

        </div>
    </div>
</section>
<!-- end lastest receipes  -->

<!-- start popular recepie  -->
<section class="bg-[#EBE6DA]">
    <div class="container mx-auto p-6 lg:flex lg:space-x-4 items-center">

        <div class="">

            <h2 class="text-3xl font-bold text-stone-600 py-2">Currently Cooking</h2>
            <p class="text-stone-600 mb-3">Here are the most popular recipes.</p>
            <a href="receipes.php" class="w-full border-stone-600 text-stone-600 border-2 border-solid py-2 px-4 rounded mb-2 hover:text-white hover:bg-stone-600 transition-colors duration-300 uppercase tracking-wide text-center block">
                View Recipe
            </a>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 mx-auto p-4 gap-4">
            <?php
            include('../include/db.php');

            // Modified SQL to include necessary fields
            $stmt = $conn->prepare("SELECT 
                r.id AS recipe_id,
                r.title,
                r.cuisine_name,
                r.image,
                r.difficulty_level,
                COALESCE(l.like_count, 0) AS total_likes,
                COALESCE(rev.review_count, 0) AS total_reviews,
                COALESCE(fav.favorite_count, 0) AS total_favorites
            FROM recipes r
            LEFT JOIN (
                SELECT recipe_id, COUNT(*) AS like_count
                FROM likes
                GROUP BY recipe_id
            ) l ON r.id = l.recipe_id
            LEFT JOIN (
                SELECT recipe_id, COUNT(DISTINCT id) AS review_count
                FROM reviews
                GROUP BY recipe_id
            ) rev ON r.id = rev.recipe_id
            LEFT JOIN (
                SELECT recipe_id, COUNT(*) AS favorite_count
                FROM favorites
                GROUP BY recipe_id
            ) fav ON r.id = fav.recipe_id
            ORDER BY (total_likes + total_reviews + total_favorites) DESC
            LIMIT 4");
            $stmt->execute();
            $result = $stmt->get_result();

            while ($recipe = $result->fetch_assoc()) :
                // Set defaults for missing values
                $image = htmlspecialchars($recipe['image'] ?? '../assets/Images/default-recipe.jpg');
                $title = htmlspecialchars($recipe['title'] ?? 'New Recipe');
                $cuisine_name = htmlspecialchars($recipe['cuisine_name'] ?? 'Uncategorized');
                $difficulty = htmlspecialchars($recipe['difficulty_level'] ?? '3');
            ?>

                <!-- Dynamic Recipe Card -->
                <div class="popular-card group relative overflow-hidden shadow-lg bg-cover bg-center mb-4 lg:rounded-lg transition-transform duration-300 hover:scale-105 hover:shadow-xl"
                    style="background-image: url('<?= $image ?>');">

                    <!-- Dark Overlay -->
                    <div class="bg-black bg-opacity-50 p-6 h-full flex flex-col justify-end relative transition-all duration-300 group-hover:bg-opacity-70">
                        <h2 class="text-lg absolute top-5 lg:top-20 font-semibold text-white">
                            <a href="show_receipe.php?id=<?= $recipe['recipe_id'] ?>" class="text-white hover:text-red-900 hover:underline hover:underline-red-900">
                                <?= $title ?>
                            </a>
                        </h2>
                    </div>

                    <!-- Red Bottom Section with White Separator -->
                    <div class="absolute bottom-0 left-0 w-full">
                        <div class="flex justify-between px-4 py-2 text-white text-sm relative">
                            <span class="absolute bg-red-900 px-5 sm:px-10 lg:px-2 py-2 bottom-0 left-0 rounded-tr-2xl border-t-2 border-r-2 border-white">
                                <?= $cuisine_name ?>
                            </span>
                            <div class="flex items-center px-5 sm:px-10 lg:px-5 rounded-tl-2xl border-t-2 border-l-2 border-white ml-3 absolute bg-red-900 py-2 bottom-0 right-0">
                                <i class="fas fa-utensils text-yellow-400 mr-1"></i>
                                <span><?= $difficulty ?></span>
                            </div>
                        </div>
                    </div>

                </div>

            <?php endwhile; ?>
        </div>

        <?php
        $stmt->close();
        $conn->close();
        ?>



    </div>

</section>

<!-- Enhanced Education Section -->
<div class="py-20" id="classes">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-8 items-center">
            <!-- Image Section with Enhanced Border -->
            <div class="lg:w-1/2 w-full relative group animate-slide-in-left">
                <div class="absolute inset-0 bg-gradient-to-r from-red-900/10 to-transparent rounded-3xl"></div>
                <img src="../assets/Images/banner/banner6.jpg" alt="Cooking Class"
                    class="rounded-3xl shadow-2xl transform group-hover:scale-[1.02] transition-all duration-500 
                           border-4 border-stone-100">
            </div>

            <!-- Content Section -->
            <div class="lg:w-1/2 w-full animate-slide-in-right">
                <div class="max-w-lg lg:ml-auto space-y-6">
                    <h2 class="text-4xl md:text-5xl font-bold text-red-900 mb-6 leading-tight">
                        Master Culinary Arts
                        <span class="block mt-4 text-xl md:text-2xl text-stone-700 font-medium">
                            From Kitchen Basics to Gourmet Techniques
                        </span>
                    </h2>

                    <div class="space-y-4 text-stone-600">
                        <p class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-red-900" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" />
                            </svg>
                            Hands-on learning with professional chefs
                        </p>
                        <p class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-red-900" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" />
                            </svg>
                            Personalized feedback and progress tracking
                        </p>
                    </div>

                    <a href="educational.php"
                        class="inline-block mt-6 px-8 py-4 bg-red-900 text-white rounded-xl font-bold 
                              transform transition-all duration-300 hover:scale-105 hover:bg-stone-700 
                              shadow-lg hover:shadow-red-900/30 group animate-pulse animation-delay-500">
                        Explore Courses
                        <svg class="w-4 h-4 inline-block ml-2 group-hover:translate-x-1 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Compact Contact Prompt -->
<div class="bg-[#EBE6DA] border-y border-stone-200 relative group" id="contact-cta">
    <!-- Decorative floating elements -->
    <div class="absolute top-0 left-10 w-24 h-24 bg-red-900/10 rounded-full blur-xl opacity-50 animate-float"></div>
    <div class="absolute bottom-0 right-20 w-16 h-16 bg-stone-700/10 rounded-full blur-lg opacity-30 animate-float-delayed"></div>

    <div class="container mx-auto px-4 py-12 relative">
        <div class="flex flex-col md:flex-row items-center justify-between gap-8">
            <!-- Icon & Text Group -->
            <div class="flex items-center gap-6">
                <div class="relative p-3 bg-red-900/10 rounded-2xl transform transition-all duration-500 hover:rotate-12">
                    <div class="absolute -inset-2 border-2 border-red-900/20 rounded-2xl"></div>
                    <svg class="w-10 h-10 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="space-y-1">
                    <h3 class="text-2xl font-bold text-red-900">Need Immediate Help?</h3>
                    <p class="text-stone-600">Connect with our culinary experts 24/7</p>
                </div>
            </div>

            <!-- Animated Button -->
            <a href="../view/contactus.php"
                class="relative px-8 py-4 bg-red-900 text-white rounded-xl font-semibold
                      overflow-hidden transform transition-all duration-500 hover:scale-105
                      shadow-lg hover:shadow-red-900/20 flex items-center gap-3">
                <span class="relative z-10">Get Instant Support</span>
                <svg class="w-5 h-5 relative z-10 animate-bounce-horizontal"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
                <!-- Button hover effect -->
                <div class="absolute inset-0 bg-gradient-to-r from-red-900/30 to-transparent opacity-0 
                            group-hover:opacity-100 transition-opacity duration-300"></div>
            </a>
        </div>
    </div>
</div>

<!-- start feedback  -->
<section class="px-4">
    <div class="container mx-auto">
        <div class="px-4 py-12 lg:py-20 max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h3 class="text-4xl md:text-5xl font-serif font-bold text-[#800020] mb-4 transform transition-all duration-300 hover:scale-105">
                    What People Say
                </h3>
                <div class="w-20 h-1 bg-[#800020] mx-auto mb-8 rounded-full"></div>
                <p class="text-stone-700 text-lg max-w-2xl mx-auto">Hear what our users say about their experiences with our platform and services.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                include('../include/db.php');

                // Fixed SQL query with proper ORDER BY syntax
                $feedback_result = $conn->prepare("SELECT name, message, created_at FROM contacts WHERE subject = 'Feedback' ORDER BY created_at DESC LIMIT 3");
                $feedback_result->execute();
                $feedbacks = $feedback_result->get_result();

                if ($feedbacks->num_rows > 0) {
                    while ($feedback = $feedbacks->fetch_assoc()) {
                        echo '
                        <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition-all duration-300 hover:-translate-y-2 group">
                        <div class="flex items-start gap-4 mb-6">
                            <div class="flex-1">
                                <h4 class="font-bold text-lg text-stone-800">' . htmlspecialchars($feedback["name"]) . '</h4>
                                <p class="text-sm text-stone-500/80">' . date("M j, Y", strtotime($feedback["created_at"])) . '</p>
                            </div>
                            <svg class="w-8 h-8 text-red-900" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M10 7L8 11H11V17H5V11L7 7H10M18 7L16 11H19V17H13V11L15 7H18Z"/>
                            </svg>
                        </div>
                        <p class="text-stone-600/90 relative pl-6 border-l-4 border-red-900 min-h-[120px]">
                            <span class="absolute left-0 -translate-x-3 text-4xl text-red-900 top-0">“</span>
                            ' . nl2br(htmlspecialchars($feedback["message"])) . '
                            <span class="absolute right-0 translate-x-3 text-4xl text-red-900 bottom-0">”</span>
                        </p>
                        </div>';
                    }
                } else {
                    echo '<p class="text-stone-600 col-span-full text-center py-12 text-lg">No feedback yet. Be the first to share your thoughts!</p>';
                }

                $feedback_result->close();
                $conn->close();
                ?>
            </div>
        </div>
    </div>
</section>



<!-- sign up now  -->
<div id="joinup-modal" class="modal fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-md z-50" style="display: none;">
    <div class="modal-dialog relative flex items-center justify-center w-full h-full p-4">
        <div class="modal-content bg-white shadow-lg rounded-lg p-6 max-w-md w-full max-h-[90vh] overflow-y-auto">

            <div class="modal-header flex flex-col justify-center items-center relative text-center">
                <h2 class="text-2xl font-bold text-stone-700">Create account</h2>
                <h5 class="text-lg py-3 mb-4">to get started now!</h5>
                <span class="btn-close absolute right-4 top-4 hover:text-red-500 cursor-pointer font-bold text-3xl"
                    onclick="closeJoinUpModal()" title="Close Modal">
                    &times;
                </span>
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
                        <input type="file" name="image" id="image" autocomplete="off" class="form-control w-full outline-none">
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

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const bannerslider = document.getElementById('bannerslider');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const indicators = document.querySelectorAll('[data-index]');
        const totalSlides = <?= $slideCount ?>;
        let currentIndex = 0;

        function updateSlider() {
            bannerslider.style.transform = `translateX(-${currentIndex * 100}%)`;

            indicators.forEach((indicator, index) => {
                const isActive = index === currentIndex;
                indicator.classList.toggle('!bg-gray-600', isActive);
                indicator.classList.toggle('w-8', isActive);
                indicator.classList.toggle('bg-gray-300', !isActive);
            });

            prevBtn.disabled = currentIndex === 0;
            nextBtn.disabled = currentIndex === totalSlides - 1;
        }

        nextBtn.addEventListener('click', (e) => {
            e.preventDefault();
            if (currentIndex < totalSlides - 1) {
                currentIndex++;
                updateSlider();
            }
        });

        prevBtn.addEventListener('click', (e) => {
            e.preventDefault();
            if (currentIndex > 0) {
                currentIndex--;
                updateSlider();
            }
        });

        indicators.forEach(indicator => {
            indicator.addEventListener('click', (e) => {
                e.preventDefault();
                currentIndex = parseInt(indicator.dataset.index);
                updateSlider();
            });
        });
    });
</script>
<?php include '../layouts/footer.php'; ?>