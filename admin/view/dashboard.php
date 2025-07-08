<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ./auth/login.php");
    exit();
}

$current_page = 'dashboard';
?>

<?php if (isset($_COOKIE['login_success'])): ?>
    <div id="login-message" class="fixed top-5 right-5 md:right-5 md:left-auto left-1/2 md:left-auto md:translate-x-0 -translate-x-1/2 flex items-center gap-3 px-6 py-4 bg-green-50 text-green-800 border-l-4 border-green-500 rounded-lg shadow-lg animate-slideIn overflow-hidden transform transition-all duration-300 z-[1000] max-w-[95vw] md:max-w-[320px]">
        <!-- Checkmark icon -->
        <svg class="w-5 h-5 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>

        <span class="text-sm font-medium">Successfully logged in! Welcome back!</span>
    </div>
    <script>
        setTimeout(() => {
            document.getElementById('login-message').style.display = 'none';
        }, 3000);
    </script>
<?php
    // Delete the cookie
    setcookie('login_success', '', time() - 3600, '/');
endif;
?>
<?php include('../view/layout/header.php'); ?>

<div class="flex-grow flex overflow-hidden">
    <!-- Sidebar -->
    <div class="w-1/4 bg-[#F8F9FA] overflow-y-auto border-r border-[#800020]/20">
        <?php include('../view/layout/sidebar.php'); ?>
    </div>

    <!-- Main Content -->
    <div class="w-3/4 p-6 overflow-y-auto bg-[#fcfaf7]">
        <!-- Your existing dashboard content -->

        <?php
        include('./db.php');


        // Query to get the total number of users
        $totalUsersQuery = "SELECT COUNT(*) AS total_users FROM users";
        $totalUsersResult = mysqli_query($conn, $totalUsersQuery);
        $totalUsers = mysqli_fetch_assoc($totalUsersResult)['total_users'];

        // Query to get the total number of recipes
        $totalRecipesQuery = "SELECT COUNT(*) AS total_recipes FROM recipes";
        $totalRecipesResult = mysqli_query($conn, $totalRecipesQuery);
        $totalRecipes = mysqli_fetch_assoc($totalRecipesResult)['total_recipes'];

        // Query to get the total number of new reports (General Inquiry)
        $newReportsQuery = "SELECT COUNT(*) AS new_reports FROM contacts WHERE subject = 'General Inquiry'";
        $newReportsResult = mysqli_query($conn, $newReportsQuery);
        $newReports = mysqli_fetch_assoc($newReportsResult)['new_reports'];

        // Query to get the total number of recipe requests
        $totalRecipeRequestsQuery = "SELECT COUNT(*) AS total_recipe_requests FROM contacts WHERE subject = 'Recipe Request'";
        $totalRecipeRequestsResult = mysqli_query($conn, $totalRecipeRequestsQuery);
        $totalRecipeRequests = mysqli_fetch_assoc($totalRecipeRequestsResult)['total_recipe_requests'];

        // Query to get the total number of subscribers
        $totalSubscribersQuery = "SELECT COUNT(*) AS total_subscribers FROM subscribers";
        $totalSubscribersResult = mysqli_query($conn, $totalSubscribersQuery);
        $totalSubscribers = mysqli_fetch_assoc($totalSubscribersResult)['total_subscribers'];

        // Query to get the total number of team members
        $totalTeamMembersQuery = "SELECT COUNT(*) AS total_team_members FROM team_members";
        $totalTeamMembersResult = mysqli_query($conn, $totalTeamMembersQuery);
        $totalTeamMembers = mysqli_fetch_assoc($totalTeamMembersResult)['total_team_members'];

        // Query to get the total number of events (from content_sections with section_name 'events')
        $totalEventsQuery = "SELECT COUNT(*) AS total_events FROM content_cards WHERE section_id = 'event'";
        $totalEventsResult = mysqli_query($conn, $totalEventsQuery);
        $totalEvents = mysqli_fetch_assoc($totalEventsResult)['total_events'];

        // Query to get the total number of classes (from content_sections with section_name 'classes')
        $totalClassesQuery = "SELECT COUNT(*) AS total_classes FROM content_cards WHERE section_id = 'cookingclass'";
        $totalClassesResult = mysqli_query($conn, $totalClassesQuery);
        $totalClasses = mysqli_fetch_assoc($totalClassesResult)['total_classes'];

        // Query to get the total number of content
        $totalContentQuery = "SELECT COUNT(*) AS total_content FROM content_cards";
        $totalContentResult = mysqli_query($conn, $totalContentQuery);
        $totalContent = mysqli_fetch_assoc($totalContentResult)['total_content'];
        ?>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Total Users -->
            <a href="user.php" class="border-2 bg-white border-[#EBE6DA] p-6 shadow-lg transition-all duration-300 hover:shadow-2xl hover:scale-105 hover:border-[#800020]/40">
                <h3 class="text-lg font-semibold text-[#800020] mb-2">Total Users</h3>
                <div class="flex justify-between items-center">
                    <p class="text-3xl font-bold"><?= $totalUsers ?></p>
                    <i class="fas fa-users text-4xl text-[#800020]"></i> <!-- Font Awesome Users Icon -->
                </div>
            </a>

            <!-- Content Recipes -->
            <a href="recipe.php" class="border-2 bg-white border-[#EBE6DA] p-6 shadow-lg transition-all duration-300 hover:shadow-2xl hover:scale-105 hover:border-[#800020]/40">
                <h3 class="text-lg font-semibold text-[#800020] mb-2">Content Recipes</h3>
                <div class="flex justify-between items-center">
                    <p class="text-3xl font-bold"><?= $totalRecipes ?></p>
                    <i class="fas fa-utensils text-4xl text-[#800020]"></i> <!-- Font Awesome Book Icon -->
                </div>
            </a>

            <!-- New Reports -->
            <a href="report.php" class="border-2 bg-white border-[#EBE6DA] p-6 shadow-lg transition-all duration-300 hover:shadow-2xl hover:scale-105 hover:border-[#800020]/40">
                <h3 class="text-lg font-semibold text-[#800020] mb-2">New Reports</h3>
                <div class="flex justify-between items-center">
                    <p class="text-3xl font-bold"><?= $newReports ?></p>
                    <i class="fas fa-chart-line text-4xl text-[#800020]"></i> <!-- Font Awesome Clipboard Icon -->
                </div>
            </a>

            <!-- Total Recipe Requests -->
            <a href="request_recipe.php" class="border-2 bg-white border-[#EBE6DA] p-6 shadow-lg transition-all duration-300 hover:shadow-2xl hover:scale-105 hover:border-[#800020]/40">
                <h3 class="text-lg font-semibold text-[#800020] mb-2">Recipe Requests</h3>
                <div class="flex justify-between items-center">
                    <p class="text-3xl font-bold"><?= $totalRecipeRequests ?></p>
                    <i class="fas fa-receipt text-4xl text-[#800020]"></i> <!-- Font Awesome Utensils Icon -->
                </div>
            </a>

            <!-- Total Subscribers -->
            <a href="subscriber.php" class="border-2 bg-white border-[#EBE6DA] p-6 shadow-lg transition-all duration-300 hover:shadow-2xl hover:scale-105 hover:border-[#800020]/40">
                <h3 class="text-lg font-semibold text-[#800020] mb-2">Total Subscribers</h3>
                <div class="flex justify-between items-center">
                    <p class="text-3xl font-bold"><?= $totalSubscribers ?></p>
                    <i class="fas fa-bell text-4xl text-[#800020]"></i> <!-- Font Awesome User Cog Icon -->
                </div>
            </a>

            <!-- Total Team Members -->
            <a href="member.php" class="border-2 bg-white border-[#EBE6DA] p-6 shadow-lg transition-all duration-300 hover:shadow-2xl hover:scale-105 hover:border-[#800020]/40">
                <h3 class="text-lg font-semibold text-[#800020] mb-2">Total Team Members</h3>
                <div class="flex justify-between items-center">
                    <p class="text-3xl font-bold"><?= $totalTeamMembers ?></p>
                    <i class="fas fa-user-friends text-4xl text-[#800020]"></i> <!-- Font Awesome User Friends Icon -->
                </div>
            </a>

            <!-- Total Events -->
            <a href="event.php" class="border-2 bg-white border-[#EBE6DA] p-6 shadow-lg transition-all duration-300 hover:shadow-2xl hover:scale-105 hover:border-[#800020]/40">
                <h3 class="text-lg font-semibold text-[#800020] mb-2">Total Events</h3>
                <div class="flex justify-between items-center">
                    <p class="text-3xl font-bold"><?= $totalEvents ?></p>
                    <i class="fas fa-calendar-alt text-4xl text-[#800020]"></i> <!-- Font Awesome Calendar Icon -->
                </div>
            </a>

            <!-- Total Classes -->
            <a href="class.php" class="border-2 bg-white border-[#EBE6DA] p-6 shadow-lg transition-all duration-300 hover:shadow-2xl hover:scale-105 hover:border-[#800020]/40">
                <h3 class="text-lg font-semibold text-[#800020] mb-2">Total Classes</h3>
                <div class="flex justify-between items-center">
                    <p class="text-3xl font-bold"><?= $totalClasses ?></p>
                    <i class="fas fa-graduation-cap text-4xl text-[#800020]"></i> <!-- Font Awesome Chalkboard Icon -->
                </div>
            </a>

            <!-- Total Content -->
            <a href="content.php" class="border-2 bg-white border-[#EBE6DA] p-6 shadow-lg transition-all duration-300 hover:shadow-2xl hover:scale-105 hover:border-[#800020]/40">
                <h3 class="text-lg font-semibold text-[#800020] mb-2">Total Content</h3>
                <div class="flex justify-between items-center">
                    <p class="text-3xl font-bold"><?= $totalContent ?></p>
                    <i class="fas fa-folder-open text-4xl text-[#800020]"></i> <!-- Font Awesome List Icon -->
                </div>

            </a>
        </div>
            <?php
            // Include database connection
            include('./db.php');

            // Query for weekly users (you may need to modify this query based on your database structure)
            $weeklyUsersQuery = "
            SELECT 
                YEAR(created_at) AS year,
                WEEK(created_at) AS week,
                COUNT(*) AS total_users
            FROM users
            GROUP BY YEAR(created_at), WEEK(created_at)
            ORDER BY YEAR(created_at) DESC, WEEK(created_at) DESC
        ";
            $weeklyUsersResult = mysqli_query($conn, $weeklyUsersQuery);

            // Fetch data for users
            $weeklyUsersData = [];
            while ($user = mysqli_fetch_assoc($weeklyUsersResult)) {
                $weeklyUsersData[] = $user;
            }

            // Query for weekly subscribers
            $weeklySubscribersQuery = "
            SELECT 
                YEAR(created_at) AS year,
                WEEK(created_at) AS week,
                COUNT(*) AS total_subscribers
            FROM subscribers
            GROUP BY YEAR(created_at), WEEK(created_at)
            ORDER BY YEAR(created_at) DESC, WEEK(created_at) DESC
        ";
            $weeklySubscribersResult = mysqli_query($conn, $weeklySubscribersQuery);

            // Fetch data for subscribers
            $weeklySubscribersData = [];
            while ($subscriber = mysqli_fetch_assoc($weeklySubscribersResult)) {
                $weeklySubscribersData[] = $subscriber;
            }

            // Prepare labels for the graph (weeks)
            $weeks = [];
            $userCounts = [];
            $subscriberCounts = [];

            foreach ($weeklyUsersData as $data) {
                $weeks[] = "Week " . $data['week'] . " (" . $data['year'] . ")";
                $userCounts[] = $data['total_users'];
            }

            foreach ($weeklySubscribersData as $data) {
                // Ensure both datasets have the same weeks
                if (!in_array("Week " . $data['week'] . " (" . $data['year'] . ")", $weeks)) {
                    $weeks[] = "Week " . $data['week'] . " (" . $data['year'] . ")";
                    $subscriberCounts[] = 0;  // No subscribers for this week
                }
                $subscriberCounts[] = $data['total_subscribers'];
            }

            // Query for weekly recipe uploads
            $weeklyRecipesQuery = "
SELECT 
    YEAR(created_at) AS year,
    WEEK(created_at) AS week,
    COUNT(*) AS total_recipes
FROM recipes
GROUP BY YEAR(created_at), WEEK(created_at)
ORDER BY YEAR(created_at) DESC, WEEK(created_at) DESC
";
            $weeklyRecipesResult = mysqli_query($conn, $weeklyRecipesQuery);

            // Fetch data for recipes
            $weeklyRecipesData = [];
            while ($recipe = mysqli_fetch_assoc($weeklyRecipesResult)) {
                $weeklyRecipesData[] = $recipe;
            }

            // Prepare labels for the graph (weeks)
            $weeksrecip = [];
            $recipeCounts = [];

            foreach ($weeklyRecipesData as $data) {
                $weeksrecip[] = "Week " . $data['week'] . " (" . $data['year'] . ")";
                $recipeCounts[] = $data['total_recipes'];
            }


            ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Weekly New Users Graph -->
                <div class="relative">
                    <canvas id="weeklyGraph" class="w-full"></canvas>
                    <script>
                        var ctx = document.getElementById('weeklyGraph').getContext('2d');
                        var weeklyGraph = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: <?php echo json_encode($weeks); ?>,
                                datasets: [{
                                        label: 'Weekly Users',
                                        data: <?php echo json_encode($userCounts); ?>,
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                        fill: true,
                                        tension: 0.1
                                    },
                                    {
                                        label: 'Weekly Subscribers',
                                        data: <?php echo json_encode($subscriberCounts); ?>,
                                        borderColor: 'rgba(54, 162, 235, 1)',
                                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                        fill: true,
                                        tension: 0.1
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Weeks'
                                        }
                                    },
                                    y: {
                                        title: {
                                            display: true,
                                            text: 'Count'
                                        },
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    </script>
                </div>

                <!-- Weekly Recipe Uploads Graph -->
                <div class="relative">
                    <canvas id="weeklyRecipeGraph" class="w-full"></canvas>
                    <script>
                        var ctx = document.getElementById('weeklyRecipeGraph').getContext('2d');
                        var weeklyRecipeGraph = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: <?php echo json_encode($weeks); ?>,
                                datasets: [{
                                    label: 'Weekly Recipe Uploads',
                                    data: <?php echo json_encode($recipeCounts); ?>,
                                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                                    borderColor: 'rgba(255, 159, 64, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Weeks'
                                        }
                                    },
                                    y: {
                                        title: {
                                            display: true,
                                            text: 'Recipe Count'
                                        },
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    </script>
                </div>
            </div>



        </div>

    </div>

</div>

<!-- Footer -->
<?php include('../view/layout/footer.php'); ?>