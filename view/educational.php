<?php include '../layouts/header.php'; ?>
<?php
include('../include/db.php');
?>
<script src="../assets/js/edu.js" defer></script>
<section class="">
    <!-- Hero Section -->
    <div class="relative w-full h-[500px] bg-cover bg-center overflow-hidden" style="background-image: url('../assets/Images/banner/banner3.svg');">
        <div class="absolute inset-0 flex flex-col items-center justify-center text-center text-white lg:w-[800px] mx-auto">
            <div class="space-y-6">
                <h2 class="text-2xl font-bold text-red-900 animate-fade-in-down animation-delay-200 opacity-0">
                    Sustainable Kitchen Practices
                </h2>
                <p class="text-lg md:text-xl text-stone-600 max-w-2xl mx-auto mb-8 animate-fade-in-up">
                    Master eco-friendly cooking techniques and reduce your environmental impact
                </p>
            </div>
        </div>
    </div>

    <!-- Cooking Classes Section -->
    <div class="container mx-auto px-4 py-16" id="classes">
        <div class="flex flex-col lg:flex-row gap-12 items-center">
            <div class="lg:w-1/2 animate-slide-in-left">
                <img src="../assets/Images/banner/banner6.jpg" alt="Cooking Class"
                    class="rounded-2xl shadow-xl transform hover:scale-105 transition duration-500">
            </div>
            <div class="lg:w-1/2 animate-slide-in-right">
                <h2 class="text-3xl font-serif font-bold text-[#800020] mb-6">
                    Transform Your Cooking Experience
                </h2>
                <ul class="list-disc pl-6 text-lg space-y-3">
                    <li><a href="#event" class="hover:text-red-900">Cooking Events</a></li>
                    <li><a href="#class" class="hover:text-red-900">Cooking Class</a></li>
                    <li><a href="#beginner-tutorials" class="hover:text-red-900">Beginner Cooking Tutorials</a></li>
                    <li><a href="#recipe-tips" class="hover:text-red-900">Recipe Tips & Tricks</a></li>
                    <li><a href="#ingredient-spotlight" class="hover:text-red-900">Ingredient Spotlights</a></li>
                </ul>

            </div>
        </div>
    </div>

    <!-- cooking event  -->
    <section class="p-10 bg-[#EBE6DA]" id="event">
        <h2 class="text-3xl font-bold text-center mb-8 text-red-900">Cooking Event</h2>
        <?php

        // The original query doesn't need user ID parameter
        $stmt = $conn->prepare("SELECT * FROM content_cards 
            WHERE section_id = 'event'
            ORDER BY created_at DESC;");
        // Remove unnecessary bind_param
        $stmt->execute();
        $result = $stmt->get_result();
        $cards = [];
        while ($row = $result->fetch_assoc()) {
            $cards[] = $row;
        }
        ?>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-7xl mx-auto">
            <?php foreach ($cards as $card): ?>
                <a href="<?= htmlspecialchars($card['link_url']) ?>"
                    class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">

                    <div class="relative aspect-video">
                        <img src="<?= htmlspecialchars($card['image_url']) ?>"
                            alt="<?= htmlspecialchars($card['title']) ?>"
                            class="w-full h-full object-cover">
                        <?php if ($card['is_new']): ?>
                            <span class="absolute top-2 right-2 bg-red-900 text-white px-3 py-1 rounded-full text-xs">
                                New!
                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="p-6">
                        <p class="text-lg text-stone-600 mb-2 font-medium">
                            <?= htmlspecialchars($card['category']) ?>
                        </p>
                        <h3 class="text-xl font-semibold text-stone-800 leading-snug">
                            <?= htmlspecialchars($card['title']) ?>
                        </h3>
                        <?php if (!empty($card['subtitle'])): ?>
                            <p class="text-stone-600 mt-2">
                                <?= htmlspecialchars($card['subtitle']) ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Cooking Class -->
    <section class="p-6 md:p-10" id="class">
        <h2 class="text-2xl md:text-3xl font-bold text-center mb-6 md:mb-8 text-red-900">Cooking Class</h2>
        <?php
        include('../include/db.php');
        $stmt = $conn->prepare("SELECT * FROM content_cards WHERE section_id = 'cookingclass' ORDER BY created_at DESC;");
        $stmt->execute();
        $result = $stmt->get_result();
        $cards = $result->fetch_all(MYSQLI_ASSOC);
        ?>

        <div class="relative overflow-hidden">
            <!-- Slider Container -->
            <div id="eduslider" class="flex space-x-4 transition-transform duration-500 ease-in-out px-6 md:px-12 mx-8">
                <?php foreach ($cards as $card): ?>
                    <div class="max-w-[90%] sm:max-w-[70%] md:max-w-[50%] lg:max-w-[300px] shrink-0 py-5">
                        <a href="<?= htmlspecialchars($card['link_url']) ?>"
                            class="block rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden h-full">
                            <div class="relative aspect-video">
                                <img src="<?= htmlspecialchars($card['image_url']) ?>"
                                    alt="<?= htmlspecialchars($card['title']) ?>"
                                    class="w-full h-full object-cover">
                                <?php if ($card['is_new']): ?>
                                    <span class="absolute top-2 right-2 bg-red-900 text-white px-3 py-1 rounded-full text-xs">
                                        New Class!
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="p-4 md:p-6">
                                <p class="text-sm md:text-lg text-stone-600 mb-2 font-medium">
                                    <?= htmlspecialchars($card['category']) ?>
                                </p>
                                <h3 class="text-lg md:text-xl font-semibold text-stone-800 leading-snug">
                                    <?= htmlspecialchars($card['title']) ?>
                                </h3>
                                <?php if (!empty($card['subtitle'])): ?>
                                    <p class="text-sm md:text-base text-stone-600 mt-2">
                                        <?= htmlspecialchars($card['subtitle']) ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
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



    <!-- Newsletter Section -->
    <!-- Enhanced Newsletter Section -->
    <div class="container mx-auto px-4 py-12">
        <div class="bg-[#EBE6DA] rounded-2xl shadow-lg p-8 md:p-12 text-center relative overflow-hidden border border-stone-200">
            <!-- Subtle texture overlay -->
            <div class="absolute inset-0 opacity-20 bg-gradient-to-br from-red-900/5 via-transparent to-stone-700/5"></div>

            <div class="relative space-y-6 max-w-2xl mx-auto">
                <div class="space-y-3">
                    <h2 class="text-3xl md:text-4xl font-bold text-red-900 mb-2">
                        Join Our Culinary Journey
                        <span class="block mt-2 text-lg md:text-xl text-stone-700 font-medium">
                            Weekly Recipes & Cooking Wisdom
                        </span>
                    </h2>
                </div>

                <div class="flex flex-col md:flex-row gap-4 justify-center">
                    <form id="subscribeForm" action="../include/subscribe.php" method="POST" class="w-full">
                        <div class="flex flex-col md:flex-row gap-3 w-full max-w-xl mx-auto">
                            <div class="relative flex-1">
                                <input type="email" name="email" placeholder="Enter your email" required
                                    class="w-full rounded-xl px-8 py-4 text-base border-2 border-stone-200 placeholder-stone-500 bg-white shadow-sm transition-colors focus:border-red-900 transition-all duration-300 focus:outline-none">
                                <!-- Email icon -->
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>

                            <button type="submit"
                                class="py-4 px-8 rounded-xl text-base font-semibold bg-red-900 text-white hover:bg-red-800 transform transition-all duration-200 hover:scale-105 shadow-md hover:shadow-red-900/20">
                                Subscribe Now →
                            </button>
                        </div>
                    </form>
                </div>

                <p class="text-sm text-stone-600 mt-3 flex items-center justify-center space-x-2">
                    <svg class="w-4 h-4 text-red-900" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    <span>We respect your privacy - No spam ever</span>
                </p>
            </div>
        </div>
    </div>

</section>

<?php include '../layouts/footer.php'; ?>