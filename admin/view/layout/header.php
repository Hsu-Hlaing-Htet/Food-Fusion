<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodFusion</title>
    <!-- Corrected asset paths -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" href="../../assets/css/animation.css">
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../../assets/css/main.css">
    <link rel="stylesheet" href="../../assets/font/fontawesome-free-5.15.4-web/css/all.min.css">
    <script src="../assets/js/script.js" defer></script>
</head>
<header class="bg-[#EBE6DA] border-b-2 border-[#800020]/20 shadow-sm">
    <nav class="container mx-auto px-4 py-3 relative">

        <div class="flex items-center justify-between w-full px-6">
            <!-- Logo Container -->
            <div class="flex items-center gap-4 animate-slide-in-left animation-delay-500 opacity-0">
                <a href="../../../../FoodFusion/view/index.php" class="flex items-center gap-3 group transition-transform hover:scale-105">
                    <img src="../../../../FoodFusion/admin/view/assets/logo/logo.png"
                        alt="FoodFusion Logo"
                        class="w-16 h-16 drop-shadow-lg transition duration-300">
                    <div class="flex flex-col">
                        <span class="font-serif text-3xl font-bold text-[#800020] tracking-wide">
                            FoodFusion
                        </span>
                        <span class="text-xs font-medium text-stone-600 tracking-widest mt-[-4px]">
                            Culinary Community
                        </span>
                    </div>
                </a>
            </div>


            <div class="flex items-center gap-6 justify-end">
                <!-- Auth Section -->
                <div class="ml-4 flex items-center gap-4">
                    <div class="relative">
                        <button onclick="toggleDropdown()" class="flex items-center gap-2 group focus:outline-none">



                            <h2 class="font-bold text-lg text-[#800020] group-hover:text-[#600018]">
                                <?php echo $_SESSION['username'] ?><span class="text-xl">&#9662;</span>
                            </h2>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="pfdropdown-menu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-[#800020]/10 z-50">
                            <a href="../../admin/view/auth/logout.php" class="block px-4 py-3 text-[#800020] hover:bg-[#800020]/5 transition-colors">
                                Logout
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </nav>
</header>

<body class="h-screen flex flex-col overflow-hidden">

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('pfdropdown-menu');
            // Toggle the visibility of the dropdown
            dropdown.classList.toggle('hidden');
        }

        // Optional: You can add functionality to close the dropdown if the user clicks outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('pfdropdown-menu');
            const button = document.querySelector('button[onclick="toggleDropdown()"]');

            if (!button.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>