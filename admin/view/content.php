<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ./auth/login.php");
    exit();
}
$current_page = 'content_cards';
include('../view/layout/header.php');
include('../view/db.php');

// Pagination setup
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 8;
$offset = ($page - 1) * $per_page;

// Get total cards
$total_query = $conn->query("SELECT COUNT(*) AS total FROM content_cards");
$total_cards = $total_query->fetch_assoc()['total'];
$total_pages = ceil($total_cards / $per_page);

// Get cards data with section names
$stmt = $conn->prepare("
    SELECT cc.*, cs.section_name 
    FROM content_cards cc
    JOIN content_sections cs ON cc.section_id = cs.section_id
    ORDER BY cc.created_at ASC 
    LIMIT ? OFFSET ?
");
$stmt->bind_param("ii", $per_page, $offset);
$stmt->execute();
$result = $stmt->get_result();

$cards = [];
while ($row = $result->fetch_assoc()) {
    $cards[] = $row;
}
?>

<div class="flex-grow flex overflow-hidden">
    <!-- Sidebar -->
    <div class="w-1/4 bg-[#F8F9FA] overflow-y-auto border-r border-[#800020]/20">
        <?php include('../view/layout/sidebar.php'); ?>
    </div>

    <!-- Main Content -->
    <div class="w-3/4 p-6 overflow-y-auto bg-[#fcfaf7]">
        <div class="flex justify-between items-center mb-6">
            <nav aria-label="breadcrumb">
                <ol class="flex space-x-2 text-[#800020]">
                    <li class="breadcrumb-item"><a href="dashboard.php" class="hover:text-[#600018]">Admin /</a></li>
                    <li class="breadcrumb-item active">Content Cards</li>
                </ol>
            </nav>
            <a href="create_card.php" class="bg-[#800020] text-white px-4 py-2 rounded-lg hover:bg-[#600018]">
                + New
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-[#800020]/10 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-[#EBE6DA]">
                        <tr>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">ID</th>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">Section</th>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">Category</th>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">Title</th>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">Image</th>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">New</th>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#800020]/10">
                        <?php foreach ($cards as $card): ?>
                        <tr class="hover:bg-[#800020]/5 transition-colors">
                            <td class="p-3 text-sm"><?= $card['id'] ?></td>
                            <td class="p-3 text-sm">
                                <span class="font-medium"><?= htmlspecialchars($card['section_id']) ?></span><br>
                                <span class="text-xs text-gray-500"><?= htmlspecialchars($card['section_name']) ?></span>
                            </td>
                            <td class="p-3 text-sm"><?= htmlspecialchars($card['category']) ?></td>
                            <td class="p-3 text-sm">
                                <div class="font-medium"><?= htmlspecialchars($card['title']) ?></div>
                                <div class="text-xs text-gray-500"><?= htmlspecialchars($card['subtitle']) ?></div>
                            </td>
                            <td class="p-3 text-sm">
                                <?php if ($card['image_url']): ?>
                                <img src="../<?= $card['image_url'] ?>" 
                                     class="w-16 h-16 object-cover rounded-lg border border-[#800020]/20"
                                     alt="<?= htmlspecialchars($card['title']) ?>">
                                <?php endif; ?>
                            </td>
                            <td class="p-3 text-sm">
                                <?php if ($card['is_new']): ?>
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">New</span>
                                <?php endif; ?>
                            </td>
                            <td class="p-3 flex gap-2">
                                <a href="edit_card.php?id=<?= $card['id'] ?>" class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="delete_card.php?id=<?= $card['id'] ?>" class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4 border-t border-[#800020]/10 flex justify-between items-center">
                <div class="text-sm text-gray-600">
                    Showing <?= ($page - 1) * $per_page + 1 ?>-<?= min($page * $per_page, $total_cards) ?> of <?= $total_cards ?> cards
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