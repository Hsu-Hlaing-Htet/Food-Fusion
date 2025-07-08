<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ./auth/login.php");
    exit();
}
$current_page = 'content_sections';
include('../view/layout/header.php');
include('../view/db.php');

// Pagination setup
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 8;
$offset = ($page - 1) * $per_page;

// Get total sections
$total_query = $conn->query("SELECT COUNT(*) AS total FROM content_sections");
$total_sections = $total_query->fetch_assoc()['total'];
$total_pages = ceil($total_sections / $per_page);

// Get sections data
$stmt = $conn->prepare("
    SELECT id, section_id, section_name, created_at 
    FROM content_sections 
    ORDER BY created_at ASC 
    LIMIT ? OFFSET ?
");
$stmt->bind_param("ii", $per_page, $offset);
$stmt->execute();
$result = $stmt->get_result();

$sections = [];
while ($row = $result->fetch_assoc()) {
    $sections[] = $row;
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
                    <li class="breadcrumb-item active">Content Sections</li>
                </ol>
            </nav>
            <a href="create_section.php" class="bg-[#800020] text-white px-4 py-2 rounded-lg hover:bg-[#600018]">
                + New
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-[#800020]/10 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead class="bg-[#EBE6DA]">
                        <tr>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">ID</th>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">Section ID</th>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">Section Name</th>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">Created At</th>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#800020]/10">
                        <?php foreach ($sections as $section): ?>
                            <tr class="hover:bg-[#800020]/5 transition-colors">
                                <td class="p-3 text-sm"><?= $section['id'] ?></td>
                                <td class="p-3 font-medium"><?= htmlspecialchars($section['section_id']) ?></td>
                                <td class="p-3 text-sm"><?= htmlspecialchars($section['section_name']) ?></td>
                                <td class="p-3 text-sm"><?= $section['created_at'] ?></td>
                                <td class="p-3 flex gap-2">
                                    <a href="content.php?section=<?= $section['section_id'] ?>" class="text-green-600 hover:text-green-800">
                                        <i class="fas fa-eye"></i>
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
                    Showing <?= ($page - 1) * $per_page + 1 ?>-<?= min($page * $per_page, $total_sections) ?> of <?= $total_sections ?> sections
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