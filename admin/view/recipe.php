<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ./auth/login.php");
    exit();
}
$current_page = 'recipe';
include('../view/layout/header.php');
include('../view/db.php');

// Determine the current page number
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$recipes_per_page = 8;
$offset = ($page - 1) * $recipes_per_page;

// Get total number of recipes for pagination
$total_recipes_result = $conn->query("SELECT COUNT(*) AS total FROM recipes");
$total_recipes = $total_recipes_result->fetch_assoc()['total'];
$total_pages = ceil($total_recipes / $recipes_per_page);

// SQL statement to get recipes data with LIMIT and OFFSET for pagination
$stmt = $conn->prepare("
    SELECT r.id, r.title, r.category, r.cuisine_name, r.difficulty_level, r.created_at, r.updated_at, u.name AS author 
    FROM recipes r
    JOIN users u ON r.user_id = u.user_id
    ORDER BY created_at ASC
    LIMIT ? OFFSET ?
");
$stmt->bind_param("ii", $recipes_per_page, $offset);
$stmt->execute();
$result = $stmt->get_result();

// Fetch the results
$recipes = [];
while ($row = $result->fetch_assoc()) {
    $recipes[] = $row;
}
?>

<div class="flex-grow flex overflow-hidden">
    <!-- Sidebar -->
    <div class="w-1/4 bg-[#F8F9FA] overflow-y-auto border-r border-[#800020]/20">
        <?php include('../view/layout/sidebar.php'); ?>
    </div>

    <!-- Main Content -->
    <div class="w-3/4 p-6 overflow-y-auto bg-[#fcfaf7]">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-6">
            <nav aria-label="breadcrumb">
                <ol class="flex space-x-2 text-[#800020]">
                    <li class="breadcrumb-item"><a href="dashboard.php" class="hover:text-[#600018]">Admin /</a></li>
                    <li class="breadcrumb-item active">Recipes</li>
                </ol>
            </nav>
            <a href="export.php?export_type=recipes" class="px-3 py-2 border border-[#800020]/20 rounded-lg hover:bg-[#800020]/5">
                Export<i class="fas fa-file-export ml-2 text-[#800020]/60"></i>
            </a>
        </div>

        <!-- Recipe Table Section -->
        <div class="bg-white rounded-lg shadow-sm border border-[#800020]/10 overflow-hidden">

            <!-- Search and Filters
            <div class="p-4 flex justify-between items-center">
                <div class="relative w-64">
                    <input type="text" placeholder="Search recipes..."
                        class="w-full pl-8 pr-4 py-2 border border-[#800020]/20 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#800020]">
                    <i class="fas fa-search absolute left-2 top-3 text-[#800020]/60"></i>
                </div>
                <div class="flex gap-2">
                    <button class="px-3 py-2 border border-[#800020]/20 rounded-lg hover:bg-[#800020]/5">
                        Search <i class="fas fa-search ml-2 text-[#800020]/60"></i>
                    </button>
                    <button class="px-3 py-2 border border-[#800020]/20 rounded-lg hover:bg-[#800020]/5">
                        Export <i class="fas fa-file-export ml-2 text-[#800020]/60"></i>
                    </button>
                </div>
            </div> -->

            <!-- Recipe Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-[#EBE6DA]">
                        <tr>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020] w-8">
                                <input type="checkbox" class="form-checkbox h-4 w-4 text-[#800020]">
                            </th>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">ID</th>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">Recipe Name</th>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">Category</th>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">Cuisine</th>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">Difficulty Level</th>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">Created At</th>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">Updated At</th>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">Author</th>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#800020]/10">
                        <?php foreach ($recipes as $recipe): ?>
                            <tr class="hover:bg-[#800020]/5 transition-colors">
                                <td class="p-3"><input type="checkbox" class="form-checkbox h-4 w-4 text-[#800020]"></td>
                                <td class="p-3 text-sm"><?= $recipe['id'] ?></td>
                                <td class="p-3 font-medium"><?= $recipe['title'] ?></td>
                                <td class="p-3 text-sm"><?= $recipe['category'] ?></td>
                                <td class="p-3 text-sm"><?= $recipe['cuisine_name'] ?></td>
                                <td class="p-3 text-sm"><?= $recipe['difficulty_level'] ?></td>
                                <td class="p-3 text-sm"><?= $recipe['created_at'] ?></td>
                                <td class="p-3 text-sm"><?= $recipe['updated_at'] ?></td>
                                <td class="p-3 text-sm"><?= $recipe['author'] ?></td>
                                <td class="p-3 flex gap-2">

                                    <a href="view_recipe.php?id=<?= $recipe['id'] ?>" class="text-green-600 hover:text-green-800">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Table Footer -->
            <div class="p-4 border-t border-[#800020]/10 flex justify-between items-center">
                <div class="text-sm text-gray-600">
                    Showing <?= ($page - 1) * $recipes_per_page + 1 ?>-<?= min($page * $recipes_per_page, $total_recipes) ?> of <?= $total_recipes ?> recipes
                </div>
                <div class="flex gap-2">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?= $page - 1 ?>" class="px-3 py-1 border rounded hover:bg-[#800020]/5">&laquo; Previous</a>
                    <?php endif; ?>
                    <?php if ($page < $total_pages): ?>
                        <a href="?page=<?= $page + 1 ?>" class="px-3 py-1 border rounded hover:bg-[#800020]/5">Next &raquo;</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include('../view/layout/footer.php'); ?>