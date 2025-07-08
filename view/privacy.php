<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodFusion</title>

    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/font/fontawesome-free-5.15.4-web/css/all.min.css">

    <script src="../assets/js/script.js" defer></script>

</head>

<body>
    <header class="bg-[#EBE6DA] border-b-2 border-[#800020]/20">
        <nav class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo Container -->
                <a href="/" class="flex items-center gap-4 group transition-transform hover:scale-105">
                    <img src="../assets/Images/logo/logo.png"
                        alt="FoodFusion Logo"
                        class="w-16 h-16 drop-shadow-lg transition duration-300 group-hover:rotate-[15deg]">

                    <!-- Text Logo -->
                    <div class="flex flex-col">
                        <span class="font-serif text-3xl font-bold text-[#800020] tracking-wide 
                              drop-shadow-md transition-colors group-hover:text-[#600018]">
                            FoodFusion
                        </span>
                        <span class="text-xs font-medium text-stone-600 tracking-widest mt-[-4px]">
                            Culinary Community
                        </span>
                    </div>
                </a>

                <!-- Optional: Home Link -->
                <div class="flex items-center space-x-6">
                    <a href="../view/index.php"
                        class="text-[#800020] hover:text-[#600018] font-medium 
                          transition-colors flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Back to Home
                    </a>
                </div>
            </div>
        </nav>
    </header>
    <!-- Privacy Policy Content -->
    <section class="bg-[#EBE6DA] min-h-screen py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl">
            <!-- Header Section -->
            <div class="text-center mb-12">
                <div class="mb-6">
                    <div class="w-24 h-1.5 bg-red-900 mx-auto rounded-full mb-4"></div>
                    <h1 class="text-4xl font-serif font-bold text-red-900 mb-3">Privacy Promise</h1>
                    <p class="text-stone-600 text-lg">Last Updated: <?php echo date('F j, Y'); ?></p>
                </div>
                <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-sm border border-stone-200">
                    <p class="text-stone-600 leading-relaxed">
                        At <span class="text-red-900 font-semibold">FoodFusion</span>, we treat your data like a secret family recipe -
                        with care, respect, and absolute confidentiality.
                    </p>
                </div>
            </div>

            <!-- Quick Navigation -->
            <nav class="sticky top-4 bg-white rounded-xl p-6 mb-8 shadow-lg border border-stone-200 z-10">
                <div class="flex items-center gap-3 mb-4">
                    <svg class="w-6 h-6 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-stone-700">Jump to Section</h3>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <?php $sections = [
                        'info-collect' => '1. Data We Collect',
                        'info-use' => '2. How We Use It',
                        'info-protect' => '3. Protection',
                        'info-share' => '4. Sharing',
                        'your-rights' => '5. Your Rights',
                        'children' => '6. Children',
                        'cookies' => '7. Cookies',
                        'changes' => '8. Updates',
                        'contact' => '9. Contact',
                        'mediavine' => '10. Advertising'
                    ]; ?>
                    <?php foreach ($sections as $id => $title): ?>
                        <a href="#<?= $id ?>" class="text-sm px-3 py-1.5 bg-red-900/5 hover:bg-red-900/10 text-stone-600 rounded-lg transition-colors">
                            <?= $title ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </nav>

            <!-- Content Sections -->
            <div class="space-y-8">
                <!-- Section Template -->
                <?php function policySection($id, $title, $content)
                { ?>
                    <section id="<?= $id ?>" class="bg-white rounded-xl p-8 shadow-lg border-l-4 border-red-900">
                        <div class="flex items-start gap-4 mb-4">
                            <div class="w-8 h-8 bg-red-900/10 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-serif font-semibold text-red-900"><?= $title ?></h2>
                        </div>
                        <div class="ml-12 space-y-4 text-stone-600">
                            <?= $content ?>
                        </div>
                    </section>
                <?php } ?>

                <?php policySection('info-collect', '1. Ingredients We Gather', <<<HTML
                <ul class="list-disc pl-6 space-y-3 marker:text-red-900">
                    <li>
                        <span class="font-semibold text-stone-700">Personal Recipe Book:</span><br>
                        Name, email, and password when you create your culinary profile
                    </li>
                    <li>
                        <span class="font-semibold text-stone-700">Kitchen Analytics:</span><br>
                        How you interact with our recipes and features (cooking time, favorites, shares)
                    </li>
                    <li>
                        <span class="font-semibold text-stone-700">Digital Taste Buds:</span><br>
                        Cookies that remember your preferences and help personalize your experience
                    </li>
                </ul>
            HTML) ?>

                <?php policySection('info-use', '2. Our Culinary Blueprint', <<<HTML
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="p-4 bg-red-50 rounded-lg">
                        <h3 class="font-semibold mb-2">🍳 Account Management</h3>
                        <p class="text-sm">Save recipes, participate in challenges, and manage your food journal</p>
                    </div>
                    <div class="p-4 bg-red-50 rounded-lg">
                        <h3 class="font-semibold mb-2">📬 Personalized Updates</h3>
                        <p class="text-sm">Seasonal recipes, cooking tips, and community events</p>
                    </div>
                    <div class="p-4 bg-red-50 rounded-lg">
                        <h3 class="font-semibold mb-2">🔍 Continuous Improvement</h3>
                        <p class="text-sm">Enhance features based on how real cooks use our platform</p>
                    </div>
                    <div class="p-4 bg-red-50 rounded-lg">
                        <h3 class="font-semibold mb-2">📝 Feedback Response</h3>
                        <p class="text-sm">Address your questions and implement your suggestions</p>
                    </div>
                </div>
            HTML) ?>

                <?php policySection('info-protect', '3. Our Security Kitchen', <<<HTML
                <div class="flex items-start gap-4 p-4 bg-red-50 rounded-lg">
                    <svg class="w-6 h-6 flex-shrink-0 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    <div>
                        <p class="font-semibold">We use industry-standard encryption (SSL) and regular security audits</p>
                        <p class="text-sm mt-2 text-stone-500">While we guard your data like a prized recipe, no digital storage is 100% secure - we promise continuous vigilance</p>
                    </div>
                </div>
            HTML) ?>

                <!-- Continue with other sections following the same pattern -->

                <?php policySection('contact', '9. Our Contact Pantry', <<<HTML
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <a href="mailto:contact@foodfusion.com" class="hover:text-red-900 transition-colors">contact@foodfusion.com</a>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>123 Food Street, New York, NY</span>
                    </div>
                </div>
            HTML) ?>

                <!-- Mediavine Section -->
                <section id="mediavine" class="bg-white rounded-xl p-8 shadow-lg border-l-4 border-red-900">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-8 h-8 bg-red-900/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-serif font-semibold text-red-900">10. Advertising Kitchen</h2>
                    </div>
                    <div class="ml-12 space-y-6 text-stone-600">
                        <!-- Interactive Accordion-style content -->
                        <div class="border rounded-xl p-5">
                            <details open>
                                <summary class="font-semibold cursor-pointer">🍪 Cookie Types</summary>
                                <div class="mt-3 space-y-3 pl-5">
                                    <p><strong>First-party:</strong> Our own recipe cards (website functionality)</p>
                                    <p><strong>Third-party:</strong> Guest chef ingredients (advertising partners)</p>
                                </div>
                            </details>
                        </div>

                        <div class="border rounded-xl p-5">
                            <details>
                                <summary class="font-semibold cursor-pointer">🔍 Data Collected</summary>
                                <div class="mt-3 space-y-2 pl-5">
                                    <p>• Device type • Browser • IP address • Interaction patterns</p>
                                </div>
                            </details>
                        </div>

                        <div class="p-4 bg-red-50 rounded-lg text-sm">
                            <p class="font-semibold text-red-900">Your Choices Matter</p>
                            <p class="mt-2">Adjust browser settings or visit:</p>
                            <div class="flex flex-wrap gap-3 mt-3">
                                <a href="#" class="px-3 py-1 bg-white rounded-full text-sm shadow-sm border border-stone-200">NAI Opt-Out</a>
                                <a href="#" class="px-3 py-1 bg-white rounded-full text-sm shadow-sm border border-stone-200">DAA Portal</a>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Footer Navigation -->
            <div class="mt-12 pt-8 border-t border-stone-200 text-center">
                <a href="#" class="inline-flex items-center text-sm text-stone-600 hover:text-red-900 transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                    </svg>
                    Back to Top
                </a>
                <p class="mt-6 text-sm text-stone-500">We update our policies like perfecting a recipe - check back for the latest version</p>
            </div>
        </div>
    </section>

</body>

</html>