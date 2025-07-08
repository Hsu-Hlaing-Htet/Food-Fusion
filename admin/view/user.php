<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ./auth/login.php");
    exit();
}
$current_page = 'user'; // Changed from 'recipe' to highlight users in sidebar
include('../view/layout/header.php');
include('../view/db.php');

// Pagination setup
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$users_per_page = 8;
$offset = ($page - 1) * $users_per_page;

// Get total number of users
$total_users_result = $conn->query("SELECT COUNT(*) AS total FROM users");
$total_users = $total_users_result->fetch_assoc()['total'];
$total_pages = ceil($total_users / $users_per_page);

// Get users data with pagination
$stmt = $conn->prepare("
    SELECT user_id, name, email, profile_picture, created_at, updated_at 
    FROM users 
    ORDER BY created_at ASC
    LIMIT ? OFFSET ?
");
$stmt->bind_param("ii", $users_per_page, $offset);
$stmt->execute();
$result = $stmt->get_result();

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
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
                    <li class="breadcrumb-item active">Users</li>
                </ol>
            </nav>
            <a href="export.php?export_type=users" class="px-3 py-2 border border-[#800020]/20 rounded-lg hover:bg-[#800020]/5">
                Export<i class="fas fa-file-export ml-2 text-[#800020]/60"></i>
            </a>

        </div>

        <!-- Users Table Section -->
        <div class="bg-white rounded-lg shadow-sm border border-[#800020]/10 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead class="bg-[#EBE6DA]">
                        <tr>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020] w-8">
                                <input type="checkbox" class="form-checkbox h-4 w-4 text-[#800020]">
                            </th>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">ID</th>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">Name</th>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">Email</th>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">Profile Picture</th>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">Created At</th>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">Updated At</th>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#800020]/10">
                        <?php foreach ($users as $user): ?>
                            <tr class="hover:bg-[#800020]/5 transition-colors">
                                <td class="p-3"><input type="checkbox" class="form-checkbox h-4 w-4 text-[#800020]"></td>
                                <td class="p-3 text-sm"><?= $user['user_id'] ?></td>
                                <td class="p-3 font-medium"><?= $user['name'] ?></td>
                                <td class="p-3 text-sm"><?= $user['email'] ?></td>
                                <td class="p-3 text-sm">
                                    <?php if ($user['profile_picture']): ?>
                                        <img src="../../../FoodFusion/<?= $user['profile_picture'] ?>"
                                            class="w-10 h-10 rounded-full object-cover"
                                            alt="Profile Picture">
                                    <?php else: ?>
                                        <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                            <i class="fas fa-user text-gray-400"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="p-3 text-sm"><?= $user['created_at'] ?></td>
                                <td class="p-3 text-sm"><?= $user['updated_at'] ?></td>
                                <td class="p-3 flex gap-2">
                                    <a href="view_user.php?id=<?= $user['user_id'] ?>" class="text-green-600 hover:text-green-800">
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
                    Showing <?= ($page - 1) * $users_per_page + 1 ?>-<?= min($page * $users_per_page, $total_users) ?> of <?= $total_users ?> users
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

<?php include('../view/layout/footer.php'); ?>