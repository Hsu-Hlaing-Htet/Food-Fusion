<?php include '../layouts/header.php'; ?>
<section class="bg-[#F9F7F3]">
    <div class="flex justify-center">
        <!-- Start Story Section -->
        <div class="space-y-12 p-6 items-center mx-6 lg:w-[1000px]">
            <!-- My Story Section -->
            <div class="flex flex-col md:flex-row items-center md:space-x-8 animate-fade-in">
                <div class="w-full md:w-1/2">
                    <img src="../assets/Images/banner/banner4.webp" alt="My Story"
                        class="rounded-lg shadow-lg w-full h-auto transform hover:scale-105 transition duration-300 md:py-20">
                </div>
                <div class="w-full md:w-1/2 text-center md:text-left md:pt-10 md:mt-20">
                    <h2 class="text-3xl font-bold text-[#800020] mb-4 font-serif">My Story</h2>
                    <p class="text-stone-600 leading-relaxed mb-4">
                        Hi! I'm Hsu Hlaing Htet, a photographer, videographer, developer, and recipe creator.
                        I specialize in foolproof baking recipes that satisfy your sweet tooth!
                    </p>
                    <p class="text-stone-600 leading-relaxed mb-4">
                        Growing up, I loved watching my mother cook, and soon, I joined her in the kitchen.
                        Over time, I developed a passion for cooking and baking, inspired by food videos online.
                    </p>
                    <p class="text-stone-600 leading-relaxed mb-4">
                        Following this desire to cook and work in the kitchen together, the idea for a shared blog was born.
                        In our blog, we share our collection of recipes that have been passed down through generations.
                    </p>
                </div>
            </div>

            <hr class="border-t-2 border-[#800020]/20 my-12">

            <!-- Our Mission Section -->
            <div class="flex flex-col md:flex-row items-center md:space-x-8 animate-slide-up">
                <div class="w-full text-center md:text-left">
                    <h2 class="text-3xl font-bold text-[#800020] mb-4 font-serif">Our Mission</h2>
                    <p class="text-stone-600 leading-relaxed">
                        Welcome to Recipes Vibrant! Our mission is to inspire and empower home cooks with
                        easy-to-follow recipes, expert tips, and a welcoming community. We prove that
                        delicious baked goods don’t require expensive ingredients!
                    </p>
                </div>
            </div>

            <hr class="border-t-2 border-[#800020]/20 my-12">

            <!-- Quick & Easy Recipes Section -->
            <div class="flex flex-col md:flex-row items-center md:space-x-8 animate-fade-in my-10">
                <div class="w-full md:w-1/2 text-center md:text-left order-2 md:order-1">
                    <h2 class="text-3xl font-bold text-[#800020] mb-4 font-serif">Quick & Easy Recipes</h2>
                    <p class="text-stone-600 leading-relaxed">
                        Life is busy, and dinner needs to be quick and delicious! Our recipes are designed
                        to be easy yet full of flavor, using real ingredients—no pre-made sauces here!
                    </p>
                </div>
                <div class="w-full md:w-1/2 order-1 md:order-2 md:mt-5">
                    <img src="../assets/Images/banner/banner5.jpeg" alt="Quick and Easy Recipes"
                        class="rounded-lg shadow-lg w-full h-auto transform hover:scale-105 transition duration-300">
                </div>
            </div>

            <hr class="border-t-2 border-[#800020]/20 my-12">

            <!-- Timeline Section -->
            <section class="py-2">
                <h2 class="text-center text-stone-600 text-3xl font-semibold tracking-wide py-2">Our Timeline</h2>
                <div class="timeline">

                    <div class="boxes left">
                        <div class="content">
                            <h3><i class="fas fa-globe"></i> 8+ Years of Traveling & Cooking</h3>
                            <small>2015 - Present</small>
                            <p>Exploring diverse cuisines and mastering the art of cooking, from street food to fine dining.</p>
                        </div>
                    </div>

                    <div class="boxes right">
                        <div class="content">
                            <h3><i class="fas fa-plane"></i> 25+ Countries Explored Through Food</h3>
                            <small>2015 - 2023</small>
                            <p>Embarking on culinary adventures across the world, learning unique cooking styles and recipes.</p>
                        </div>
                    </div>

                    <div class="boxes left">
                        <div class="content">
                            <h3><i class="fas fa-utensils"></i> 500+ Recipes Tested and Shared</h3>
                            <small>2015 - Present</small>
                            <p>Experimenting with new ingredients and sharing the results with our community of food enthusiasts.</p>
                        </div>
                    </div>

                    <div class="boxes right">
                        <div class="content">
                            <h3><i class="fas fa-users"></i> 30 Million+ Monthly Foodies Reached</h3>
                            <small>2017 - Present</small>
                            <p>Reaching a global audience through our blog, social media, and food-related content.</p>
                        </div>
                    </div>
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

        </div>
    </div>
</section>


<?php include '../layouts/footer.php'; ?>