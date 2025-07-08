<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ./auth/login.php");
    exit();
}
$current_page = 'subscriber'; // Set current page for sidebar highlighting
include('../view/layout/header.php');
include('../view/db.php');

// Pagination setup
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$subscribers_per_page = 8;
$offset = ($page - 1) * $subscribers_per_page;

// Get total number of subscribers
$total_subscribers_result = $conn->query("SELECT COUNT(*) AS total FROM subscribers");
$total_subscribers = $total_subscribers_result->fetch_assoc()['total'];
$total_pages = ceil($total_subscribers / $subscribers_per_page);

// Get subscribers data
$stmt = $conn->prepare("
    SELECT id, email, created_at 
    FROM subscribers 
    ORDER BY created_at ASC
    LIMIT ? OFFSET ?
");
$stmt->bind_param("ii", $subscribers_per_page, $offset);
$stmt->execute();
$result = $stmt->get_result();

$subscribers = [];
while ($row = $result->fetch_assoc()) {
    $subscribers[] = $row;
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
                    <li class="breadcrumb-item active">Subscribers</li>
                </ol>
            </nav>
            <a href="export.php?export_type=subscribers" class="px-3 py-2 border border-[#800020]/20 rounded-lg hover:bg-[#800020]/5">
                Export<i class="fas fa-file-export ml-2 text-[#800020]/60"></i>
            </a>
        </div>

        <!-- Subscribers Table Section -->
        <div class="bg-white rounded-lg shadow-sm border border-[#800020]/10 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-[#EBE6DA]">
                        <tr>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020] w-8">
                                <input type="checkbox" class="form-checkbox h-4 w-4 text-[#800020]">
                            </th>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">ID</th>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">Email</th>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">Subscribed At</th>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#800020]/10">
                        <?php foreach ($subscribers as $subscriber): ?>
                            <tr class="hover:bg-[#800020]/5 transition-colors">
                                <td class="p-3"><input type="checkbox" class="form-checkbox h-4 w-4 text-[#800020]"></td>
                                <td class="p-3 text-sm"><?= $subscriber['id'] ?></td>
                                <td class="p-3 font-medium"><?= $subscriber['email'] ?></td>
                                <td class="p-3 text-sm"><?= $subscriber['created_at'] ?></td>
                                <td class="p-3 flex gap-2">
                                    <a href="delete_subscriber.php?id=<?= $subscriber['id'] ?>" class="text-red-600 hover:text-red-800">
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
                    Showing <?= ($page - 1) * $subscribers_per_page + 1 ?>-<?= min($page * $subscribers_per_page, $total_subscribers) ?> of <?= $total_subscribers ?> subscribers
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