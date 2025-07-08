<?php include '../layouts/header.php'; ?>
<?php
include('../include/db.php');
?>
<script src="../assets/js/culinary.js" defer></script>
<div class="relative w-full h-[500px] bg-cover bg-center" style="background-image: url('../assets/Images/banner/banner3.svg');">
    <div class="absolute inset-0 flex flex-col items-center justify-center text-center lg:w-[800px] mx-auto">
        <div class="space-y-6">
            <h2 class="text-2xl font-bold text-red-900 animate-fade-in-down animation-delay-900 opacity-0">
                Start Your Culinary Adventure
            </h2>

            <p class="text-lg mt-2 text-stone-600 px-4 animate-fade-in-up animation-delay-900">
                Join our community of food lovers and never run out of kitchen inspiration. Save favorites, create collections, and share your culinary masterpieces.
            </p>
        </div>
    </div>
</div>

<!-- Sticky Navigation -->
<div class="sticky top-0 bg-white shadow-md p-4 z-50">
    <ul class="flex justify-around text-lg">
        <li><a href="#ecofriendly" class="cali-nav-link hover:text-red-900">Eco Friendly</a></li>
        <li><a href="#food-storage" class="cali-nav-link hover:text-red-900">Food Storage Tips</a></li>
        <li><a href="#kitchenhacks" class="cali-nav-link hover:text-red-900">Kitchen Hacks</a></li>
        <li><a href="#health" class="cali-nav-link hover:text-red-900">Health and Nutrition</a></li>
        <li><a href="#cleaning" class="cali-nav-link hover:text-red-900">Cleaning</a></li>
    </ul>
</div>
<!-- Eco friendly  -->
<section class="bg-[#EBE6DA] p-8 md:p-12 section" id="ecofriendly">
    <?php
    include('../include/db.php');

    // The original query doesn't need user ID parameter
    $ecostmt = $conn->prepare("SELECT * FROM content_cards 
            WHERE section_id = 'ecofriendly'
            ORDER BY created_at DESC;");
    // Remove unnecessary bind_param
    $ecostmt->execute();
    $ecoresult = $ecostmt->get_result();
    $ecocards = [];
    while ($ecorow = $ecoresult->fetch_assoc()) {
        $ecocards[] = $ecorow;
    }
    ?>
    <h2 class="text-3xl font-bold text-center mb-8 md:mb-12 text-red-900">
        Eco-Friendly Kitchen Solutions
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-7xl mx-auto">
        <?php foreach ($ecocards as $ecocard): ?>
            <a href="<?= htmlspecialchars($ecocard['link_url']) ?>"
                class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden animate-fade-in-down animation-delay-900 opacity-0">

                <div class="relative aspect-video">
                    <img src="<?= htmlspecialchars($ecocard['image_url']) ?>"
                        alt="<?= htmlspecialchars($ecocard['title']) ?>"
                        class="w-full h-full object-cover">
                    <?php if ($ecocard['is_new']): ?>
                        <span class="absolute top-2 right-2 bg-red-900 text-white px-3 py-1 rounded-full text-xs">
                            New!
                        </span>
                    <?php endif; ?>
                </div>

                <div class="p-6">
                    <p class="text-lg text-stone-600 mb-2 font-medium">
                        <?= htmlspecialchars($ecocard['category']) ?>
                    </p>
                    <h3 class="text-xl font-semibold text-stone-800 leading-snug">
                        <?= htmlspecialchars($ecocard['title']) ?>
                    </h3>
                    <?php if (!empty($ecocard['subtitle'])): ?>
                        <p class="text-stone-600 mt-2">
                            <?= htmlspecialchars($ecocard['subtitle']) ?>
                        </p>
                    <?php endif; ?>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</section>
<!-- Food Storage and Kitchen Organization  -->
<section class="p-10 section" id="food-storage">
    <h2 class="text-3xl font-bold text-center mb-8 text-red-900">Food Storage and Kitchen Organization</h2>
    <?php

    // The original query doesn't need user ID parameter
    $stmt = $conn->prepare("SELECT * FROM content_cards 
            WHERE section_id = 'food-storage'
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
                class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden animate-fade-in-down animation-delay-900 opacity-0">

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

<!-- Kitchen Hacks Section -->
<section class="bg-[#EBE6DA] p-10 section" id="kitchenhacks">
    <h2 class="text-3xl font-bold text-center mb-8 text-red-900">Kitchen Hacks</h2>

    <?php
    $stmt = $conn->prepare("SELECT * FROM content_cards WHERE section_id = 'kitchenhacks' ORDER BY created_at DESC;");
    $stmt->execute();
    $result = $stmt->get_result();
    $kitchenCards = [];
    while ($row = $result->fetch_assoc()) {
        $kitchenCards[] = $row;
    }
    ?>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-7xl mx-auto">
        <?php foreach ($kitchenCards as $kitchenCard): ?>
            <a href="<?= htmlspecialchars($kitchenCard['link_url']) ?>"
                class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden animate-fade-in-down animation-delay-900 opacity-0">

                <div class="relative aspect-video">
                    <img src="<?= htmlspecialchars($kitchenCard['image_url']) ?>"
                        alt="<?= htmlspecialchars($kitchenCard['title']) ?>"
                        class="w-full h-full object-cover">
                    <?php if ($kitchenCard['is_new']): ?>
                        <span class="absolute top-2 right-2 bg-red-900 text-white px-3 py-1 rounded-full text-xs">
                            New!
                        </span>
                    <?php endif; ?>
                </div>

                <div class="p-6">
                    <p class="text-lg text-stone-600 mb-2 font-medium">
                        <?= htmlspecialchars($kitchenCard['category']) ?>
                    </p>
                    <h3 class="text-xl font-semibold text-stone-800 leading-snug">
                        <?= htmlspecialchars($kitchenCard['title']) ?>
                    </h3>
                    <?php if (!empty($kitchenCard['subtitle'])): ?>
                        <p class="text-stone-600 mt-2">
                            <?= htmlspecialchars($kitchenCard['subtitle']) ?>
                        </p>
                    <?php endif; ?>
                </div>
            </a>
        <?php endforeach; ?>
    </div>

</section>

<!--Health and Nutrition  -->
<section class="p-10 section" id="health">
    <h2 class="text-3xl font-bold text-center mb-8 text-red-900">Health and Nutrition</h2>

    <?php

    // The original query doesn't need user ID parameter
    $stmt = $conn->prepare("SELECT * FROM content_cards 
            WHERE section_id = 'health'
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
                class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden animate-fade-in-down animation-delay-900 opacity-0">

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

<!-- Cleaning  -->
<section class="p-10 bg-[#EBE6DA] section" id="cleaning">
    <h2 class="text-3xl font-bold text-center mb-8 text-red-900">Cleaning</h2>

    <?php

    // The original query doesn't need user ID parameter
    $stmt = $conn->prepare("SELECT * FROM content_cards 
            WHERE section_id = 'cleaning'
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
                class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden animate-fade-in-down animation-delay-900 opacity-0">

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
                                class="w-full rounded-xl px-8 py-4 text-base border-2 border-stone-200  placeholder-stone-500 bg-white  shadow-sm transition-colors focus:border-red-900 transition-all duration-300 focus:outline-none">
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


<?php include '../layouts/footer.php'; ?>