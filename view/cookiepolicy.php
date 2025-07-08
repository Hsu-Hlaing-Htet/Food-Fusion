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
    <section class="bg-[#EBE6DA] min-h-screen" style="color: #800020;">
        <div class="container mx-auto px-4 py-12 lg:py-16 max-w-4xl">
            <header class="text-center mb-12 lg:mb-16">
                <div class="mb-8">
                    <div class="w-24 h-1.5 bg-[#800020] mx-auto mb-6 rounded-full"></div>
                    <h1 class="text-4xl lg:text-5xl font-serif font-bold text-[#800020] mb-3">Cookie Policy</h1>
                    <p class="text-stone-600 text-lg font-medium">Last Updated: <?php echo date('F j, Y'); ?></p>
                </div>
            </header>

            <!-- Summary Card -->
            <div class="bg-[#f4f4f4] rounded-xl p-6 mb-12 border border-[#800020]/20 shadow-sm">
                <div class="flex items-center gap-4 mb-4">
                    <svg class="w-8 h-8 text-[#800020]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <h3 class="text-xl font-semibold text-[#800020]">Key Points</h3>
                </div>
                <ul class="list-disc pl-8 space-y-2 text-[#800020] marker:text-[#800020]">
                    <li>We use cookies to enhance your experience</li>
                    <li>You can manage preferences at any time</li>
                    <li>Essential cookies cannot be disabled</li>
                    <li>Third-party cookies help improve our services</li>
                </ul>
            </div>

            <!-- Table of Contents -->
            <nav class="bg-[#f4f4f4] backdrop-blur-sm rounded-xl p-8 mb-12 shadow-lg border border-stone-200">
                <div class="flex items-center gap-3 mb-6">
                    <svg class="w-6 h-6 text-[#800020]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <h2 class="text-xl font-semibold text-stone-700">Policy Overview</h2>
                </div>
                <ol class="space-y-4">
                    <?php
                    $sections = [
                        'what-are-cookies' => 'What Are Cookies?',
                        'types' => 'Types We Use',
                        'purposes' => 'Purposes of Use',
                        'third-party' => 'Third-Party Cookies',
                        'management' => 'Managing Preferences',
                        'updates' => 'Policy Updates',
                        'contact' => 'Contact Us'
                    ];
                    $count = 1;
                    ?>
                    <?php foreach ($sections as $id => $title): ?>
                        <li class="flex items-center group">
                            <div class="w-2 h-2 bg-[#800020]/20 mr-3 rounded-full transition-all group-hover:bg-[#800020]"></div>
                            <a href="#<?= $id ?>" class="text-stone-600 hover:text-[#800020] transition-colors font-medium">
                                <?= $count++ ?>. <?= $title ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </nav>

            <!-- Policy Sections -->
            <div class="space-y-8">
                <!-- What Are Cookies -->
                <section id="what-are-cookies" class="bg-white rounded-xl p-8 shadow-lg border-l-4 border-[#800020]">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-8 h-8 bg-[#800020]/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-[#800020]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-serif font-semibold text-[#800020]">1. What Are Cookies?</h2>
                    </div>
                    <div class="ml-12 space-y-4 text-stone-600">
                        <p>Cookies are small text files stored on your device when you visit websites. They help:</p>
                        <ul class="list-disc pl-6 space-y-3 marker:text-[#800020]">
                            <li>Remember your preferences</li>
                            <li>Improve site functionality</li>
                            <li>Personalize your experience</li>
                            <li>Analyze website traffic</li>
                        </ul>
                    </div>
                </section>

                <!-- Types of Cookies -->
                <section id="types" class="bg-white rounded-xl p-8 shadow-lg border-l-4 border-[#800020]">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-8 h-8 bg-[#800020]/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-[#800020]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9h14M5 15h14m-9-9h1m-1 8h1m-1-4h6m-6 4h6" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-serif font-semibold text-[#800020]">2. Types We Use</h2>
                    </div>
                    <div class="ml-12 space-y-6">
                        <div class="p-4 bg-[#EBE6DA] rounded-lg">
                            <h3 class="font-semibold text-[#800020] mb-2">Essential Cookies</h3>
                            <p class="text-stone-600 text-sm">Required for basic functionality</p>
                        </div>
                        <div class="p-4 bg-[#EBE6DA] rounded-lg">
                            <h3 class="font-semibold text-[#800020] mb-2">Performance Cookies</h3>
                            <p class="text-stone-600 text-sm">Collect anonymous usage data</p>
                        </div>
                        <div class="p-4 bg-[#EBE6DA] rounded-lg">
                            <h3 class="font-semibold text-[#800020] mb-2">Functional Cookies</h3>
                            <p class="text-stone-600 text-sm">Remember preferences & settings</p>
                        </div>
                        <div class="p-4 bg-[#EBE6DA] rounded-lg">
                            <h3 class="font-semibold text-[#800020] mb-2">Marketing Cookies</h3>
                            <p class="text-stone-600 text-sm">Deliver relevant ads</p>
                        </div>
                    </div>
                </section>

                <!-- Additional Sections -->
                <section id="purposes" class="bg-white rounded-xl p-8 shadow-lg border-l-4 border-[#800020]">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-8 h-8 bg-[#800020]/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-[#800020]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-serif font-semibold text-[#800020]">3. Purposes of Use</h2>
                    </div>
                    <div class="ml-12 space-y-4 text-stone-600">
                        <p>We use cookies for the following purposes:</p>
                        <ul class="list-disc pl-6 space-y-3 marker:text-[#800020]">
                            <li>Enhancing website functionality</li>
                            <li>Analyzing website traffic</li>
                            <li>Improving user experience</li>
                        </ul>
                    </div>
                </section>

                <!-- Other sections similar to "Purposes of Use" can be added here following the same pattern. -->

                <!-- Third-Party Cookies -->
                <section id="third-party" class="bg-white rounded-xl p-8 shadow-lg border-l-4 border-[#800020]">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-8 h-8 bg-[#800020]/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-[#800020]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-serif font-semibold text-[#800020]">4. Third-Party Cookies</h2>
                    </div>
                    <div class="ml-12 space-y-4 text-stone-600">
                        <p>We may allow third-party services to set cookies to provide additional functionality, including analytics and targeted advertising. These third-party cookies include:</p>
                        <ul class="list-disc pl-6 space-y-3 marker:text-[#800020]">
                            <li>Google Analytics</li>
                            <li>Facebook Pixel</li>
                            <li>Google Ads</li>
                        </ul>
                        <p>These third parties may use the collected data according to their own privacy policies.</p>
                    </div>
                </section>

                <!-- Managing Preferences -->
                <section id="management" class="bg-white rounded-xl p-8 shadow-lg border-l-4 border-[#800020]">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-8 h-8 bg-[#800020]/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-[#800020]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 5l7 7-7 7" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-serif font-semibold text-[#800020]">5. Managing Cookie Preferences</h2>
                    </div>
                    <div class="ml-12 space-y-4 text-stone-600">
                        <p>You have control over how cookies are used on your device. You can manage your cookie preferences through:</p>
                        <ul class="list-disc pl-6 space-y-3 marker:text-[#800020]">
                            <li>Your browser settings (to block or delete cookies)</li>
                            <li>Third-party cookie opt-out tools</li>
                        </ul>
                        <p>Note that disabling certain cookies may affect your user experience on our site.</p>
                    </div>
                </section>

                <!-- Policy Updates -->
                <section id="updates" class="bg-white rounded-xl p-8 shadow-lg border-l-4 border-[#800020]">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-8 h-8 bg-[#800020]/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-[#800020]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5v14l7-7-7-7z" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-serif font-semibold text-[#800020]">6. Policy Updates</h2>
                    </div>
                    <div class="ml-12 space-y-4 text-stone-600">
                        <p>We may update this cookie policy from time to time. Any changes will be posted on this page with the updated date. Please check this page regularly to stay informed about our cookie practices.</p>
                    </div>
                </section>

                <!-- Contact Us -->
                <section id="contact" class="bg-white rounded-xl p-8 shadow-lg border-l-4 border-[#800020]">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-8 h-8 bg-[#800020]/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-[#800020]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h8M8 14h8m-8 4h8" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-serif font-semibold text-[#800020]">7. Contact Us</h2>
                    </div>
                    <div class="ml-12 space-y-4 text-stone-600">
                        <p>If you have any questions about our cookie policy, please feel free to reach out to us:</p>
                        <ul class="list-disc pl-6 space-y-3 marker:text-[#800020]">
                            <li>Email: <a href="mailto:support@foodfusion.com" class="text-[#800020] hover:text-[#800020]/80">support@foodfusion.com</a></li>
                            <li>Phone: +1 800-123-4567</li>
                            <li>Mailing Address: 123 Culinary Lane, Foodtown, FT 12345</li>
                        </ul>
                    </div>
                </section>


            </div>

            <!-- Footer -->
            <div class="mt-12 pt-8 border-t border-stone-200 text-center">
                <div class="mb-6">
                    <a href="#cookie-settings" class="inline-flex items-center px-6 py-2 bg-[#800020] text-white rounded-full hover:bg-[#800020]/90 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Manage Cookie Preferences
                    </a>
                </div>
                <p class="text-sm text-stone-600">This policy is part of our <a href="../../FoodFusion/view/privacy.php" class="text-[#800020] hover:underline">Privacy Policy</a></p>
                <a href="#" class="mt-4 inline-block text-sm text-stone-600 hover:text-[#800020] transition-colors">
                    ↑ Back to Top
                </a>
            </div>
        </div>
    </section>



</body>

</html>