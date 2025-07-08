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
    <section class="bg-[#EBE6DA] min-h-screen" style="color: #2B2523;">
        <div class="container mx-auto px-4 py-12 lg:py-16 max-w-4xl">
            <header class="text-center mb-12 lg:mb-16">
                <div class="mb-8">
                    <div class="w-24 h-1.5 bg-red-900 mx-auto mb-6 rounded-full"></div>
                    <h1 class="text-4xl lg:text-5xl font-serif font-bold text-red-900 mb-3">Terms of Service</h1>
                    <p class="text-stone-600 text-lg font-medium">Effective Date: <?php echo date('F j, Y'); ?></p>
                </div>
            </header>

            <!-- Table of Contents -->
            <nav class="bg-white/80 backdrop-blur-sm rounded-xl p-8 mb-12 shadow-lg border border-stone-200">
                <div class="flex items-center gap-3 mb-6">
                    <svg class="w-6 h-6 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <h2 class="text-xl font-semibold text-stone-700">Quick Navigation</h2>
                </div>
                <ol class="space-y-4">
                    <?php
                    $sections = [
                        'introduction' => 'Introduction',
                        'responsibilities' => 'User Responsibilities',
                        'ownership' => 'Content Ownership',
                        'privacy' => 'Privacy & Data',
                        'liability' => 'Limitation of Liability',
                        'modifications' => 'Modifications',
                        'governance' => 'Governing Law'
                    ];
                    $count = 1;
                    ?>
                    <?php foreach ($sections as $id => $title): ?>
                        <li class="flex items-center group">
                            <div class="w-2 h-2 bg-red-900/20 mr-3 rounded-full transition-all group-hover:bg-red-900"></div>
                            <a href="#<?= $id ?>" class="text-stone-600 hover:text-red-900 transition-colors font-medium">
                                <?= $count++ ?>. <?= $title ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </nav>

            <!-- Sections -->
            <div class="space-y-8">
                <?php
                $section_number = 1;
                foreach ($sections as $id => $title): ?>
                    <section id="<?= $id ?>" class="bg-white rounded-xl p-8 shadow-lg border-l-4 border-red-900">
                        <div class="flex items-start gap-4 mb-4">
                            <div class="w-8 h-8 bg-red-900/10 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-serif font-semibold text-red-900"><?= $section_number++ ?>. <?= $title ?></h2>
                        </div>
                        <div class="ml-12 space-y-4 text-stone-600">
                            <?php if ($id === 'introduction'): ?>
                                <p>By using FoodFusion, you agree to these Terms. Please read them carefully.</p>
                            <?php elseif ($id === 'responsibilities'): ?>
                                <ul class="list-disc pl-6 space-y-3 marker:text-red-900">
                                    <li>Use FoodFusion lawfully and ethically</li>
                                    <li>Maintain accurate account information</li>
                                    <li>Keep login credentials secure</li>
                                </ul>
                            <?php elseif ($id === 'ownership'): ?>
                                <p>All content on FoodFusion belongs to FoodFusion or its licensors.</p>
                            <?php elseif ($id === 'privacy'): ?>
                                <p>Refer to our <a href="../view/privacy.php" class="text-red-900 hover:underline">Privacy Policy</a> for details on data collection and security.</p>
                            <?php elseif ($id === 'liability'): ?>
                                <p>FoodFusion is not responsible for any damages resulting from website use.</p>
                            <?php elseif ($id === 'modifications'): ?>
                                <p>FoodFusion may update these terms at any time.</p>
                            <?php elseif ($id === 'governance'): ?>
                                <p>These Terms are governed by the laws of [Your Country/State].</p>
                            <?php endif; ?>
                        </div>
                    </section>
                <?php endforeach; ?>
            </div>

            <div class="mt-12 pt-8 border-t border-stone-200 text-center">
                <p class="text-sm text-stone-600">Last updated: <?php echo date('F j, Y'); ?></p>
                <div class="mt-4">
                    <a href="../view/contactus.php" class="inline-flex items-center text-red-900 hover:text-red-700 transition-colors font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Need help? Contact support
                    </a>
                </div>
                <a href="#" class="mt-6 inline-block text-sm text-stone-600 hover:text-red-900 transition-colors">
                    ↑ Back to Top
                </a>
            </div>
        </div>
    </section>

</body>

</html>