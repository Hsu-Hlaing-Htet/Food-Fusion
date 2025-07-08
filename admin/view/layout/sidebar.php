<?php
$currentPage = basename($_SERVER['PHP_SELF']); // Get current page name
?>

<!-- Sidebar -->
<div class="sidebar p-3 bg-[#F8F9FA] border-r border-[#800020]/20 w-full h-full">
    <ul class="space-y-2">
        <!-- Dashboard Link -->
        <li class="<?= ($currentPage == 'dashboard.php') ? 'bg-[#800020]/10 active' : '' ?>">
            <a href="dashboard.php" class="flex items-center px-4 py-3 text-[#800020] hover:bg-[#800020]/5 transition-colors">
                <i class="fas fa-tachometer-alt w-6"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Content Management Dropdown -->
        <li class="group relative">
            <a href="#" id="contentToggle" class="flex items-center justify-between px-4 py-3 text-[#800020] hover:bg-[#800020]/5">
                <div class="flex items-center">
                    <i class="fas fa-folder-open w-6"></i>
                    <span>Content</span>
                </div>
                <i class="fas fa-chevron-down text-sm"></i>
            </a>
            <ul id="contentList" class="pl-8 w-full left-0 <?= in_array($currentPage, ['section.php', 'content.php', 'class.php', 'event.php']) ? '' : 'hidden' ?>">
                <li class="<?= ($currentPage == 'section.php') ? 'bg-[#800020]/10 active' : '' ?>">
                    <a href="section.php" class="flex items-center px-4 py-3 text-[#800020] hover:bg-[#800020]/5">
                        <i class="fas fa-cogs w-6"></i> Sections
                    </a>
                </li>
                <li class="<?= ($currentPage == 'content.php') ? 'bg-[#800020]/10 active' : '' ?>">
                    <a href="content.php" class="flex items-center px-4 py-3 text-[#800020] hover:bg-[#800020]/5">
                        <i class="fas fa-id-card w-6"></i> Content Cards
                    </a>
                </li>
                <li class="<?= ($currentPage == 'class.php') ? 'bg-[#800020]/10 active' : '' ?>">
                    <a href="class.php" class="flex items-center px-4 py-3 text-[#800020] hover:bg-[#800020]/5">
                        <i class="fas fa-graduation-cap w-6"></i> Class
                    </a>
                </li>
                <li class="<?= ($currentPage == 'event.php') ? 'bg-[#800020]/10 active' : '' ?>">
                    <a href="event.php" class="flex items-center px-4 py-3 text-[#800020] hover:bg-[#800020]/5">
                        <i class="fas fa-calendar-alt w-6"></i> Event
                    </a>
                </li>
            </ul>
        </li>

        <!-- Users -->
        <li class="<?= ($currentPage == 'user.php') ? 'bg-[#800020]/10 active' : '' ?>">
            <a href="user.php" class="flex items-center px-4 py-3 text-[#800020] hover:bg-[#800020]/5">
                <i class="fas fa-users w-6"></i> <span>Users</span>
            </a>
        </li>

        <!-- Recipes -->
        <li class="<?= ($currentPage == 'recipe.php') ? 'bg-[#800020]/10 active' : '' ?>">
            <a href="recipe.php" class="flex items-center px-4 py-3 text-[#800020] hover:bg-[#800020]/5">
                <i class="fas fa-utensils w-6"></i> <span>Recipes</span>
            </a>
        </li>

        <!-- Members -->
        <li class="<?= ($currentPage == 'member.php') ? 'bg-[#800020]/10 active' : '' ?>">
            <a href="member.php" class="flex items-center px-4 py-3 text-[#800020] hover:bg-[#800020]/5">
                <i class="fas fa-users w-6"></i> <span>Members</span>
            </a>
        </li>

        <!-- Subscribers -->
        <li class="<?= ($currentPage == 'subscriber.php') ? 'bg-[#800020]/10 active' : '' ?>">
            <a href="subscriber.php" class="flex items-center px-4 py-3 text-[#800020] hover:bg-[#800020]/5">
                <i class="fas fa-bell w-6"></i> <span>Subscribers</span>
            </a>
        </li>

        <!-- Feedback -->
        <li class="<?= ($currentPage == 'feedback.php') ? 'bg-[#800020]/10 active' : '' ?>">
            <a href="feedback.php" class="flex items-center px-4 py-3 text-[#800020] hover:bg-[#800020]/5">
                <i class="fas fa-comment-dots w-6"></i> <span>Feedback</span>
            </a>
        </li>

        <!-- Reports -->
        <li class="<?= ($currentPage == 'report.php') ? 'bg-[#800020]/10 active' : '' ?>">
            <a href="report.php" class="flex items-center px-4 py-3 text-[#800020] hover:bg-[#800020]/5">
                <i class="fas fa-chart-line w-6"></i> <span>Reports</span>
            </a>
        </li>

        <!-- Recipe Request -->
        <li class="<?= ($currentPage == 'request_recipe.php') ? 'bg-[#800020]/10 active' : '' ?>">
            <a href="request_recipe.php" class="flex items-center px-4 py-3 text-[#800020] hover:bg-[#800020]/5">
                <i class="fas fa-receipt w-6"></i> <span>Recipe Request</span>
            </a>
        </li>
    </ul>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const toggleButton = document.getElementById("contentToggle");
        const contentList = document.getElementById("contentList");

        // Check if dropdown was open before (stored in localStorage)
        if (localStorage.getItem("contentDropdown") === "open") {
            contentList.classList.remove("hidden");
        }

        toggleButton.addEventListener("click", function(event) {
            event.preventDefault();
            contentList.classList.toggle("hidden");

            // Save the state to localStorage
            if (contentList.classList.contains("hidden")) {
                localStorage.setItem("contentDropdown", "closed");
            } else {
                localStorage.setItem("contentDropdown", "open");
            }
        });

        // When clicking on a submenu item, keep dropdown open
        document.querySelectorAll("#contentList a").forEach(link => {
            link.addEventListener("click", function() {
                localStorage.setItem("contentDropdown", "open");
            });
        });

    });
</script>