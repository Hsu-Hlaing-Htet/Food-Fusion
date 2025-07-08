<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ./auth/login.php");
    exit();
}
$current_page = 'general_inquiries';
include('../view/layout/header.php');
include('../view/db.php');

// Pagination setup
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 8;
$offset = ($page - 1) * $per_page;

// Get total number of general inquiries
$total_query = $conn->prepare("SELECT COUNT(*) AS total FROM contacts WHERE subject = 'General Inquiry'");
$total_query->execute();
$total_result = $total_query->get_result();
$total_inquiries = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_inquiries / $per_page);

// Get general inquiries data
$stmt = $conn->prepare("
    SELECT id, name, email, message, created_at 
    FROM contacts 
    WHERE subject = 'General Inquiry'
    ORDER BY created_at ASC
    LIMIT ? OFFSET ?
");
$stmt->bind_param("ii", $per_page, $offset);
$stmt->execute();
$result = $stmt->get_result();

$inquiries = [];
while ($row = $result->fetch_assoc()) {
    $inquiries[] = $row;
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
                    <li class="breadcrumb-item active">General Inquiries</li>
                </ol>
            </nav>
            <a href="export.php?export_type=reports" class="px-3 py-2 border border-[#800020]/20 rounded-lg hover:bg-[#800020]/5">
                Export<i class="fas fa-file-export ml-2 text-[#800020]/60"></i>
            </a>
        </div>

        <!-- Inquiries Table Section -->
        <div class="bg-white rounded-lg shadow-sm border border-[#800020]/10 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-[#EBE6DA]">
                        <tr>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020] w-8">
                                <input type="checkbox" class="form-checkbox h-4 w-4 text-[#800020]">
                            </th>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">ID</th>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">Name</th>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">Email</th>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">Message</th>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">Received At</th>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#800020]/10">
                        <?php foreach ($inquiries as $inquiry): ?>
                            <tr class="hover:bg-[#800020]/5 transition-colors">
                                <td class="p-3"><input type="checkbox" class="form-checkbox h-4 w-4 text-[#800020]"></td>
                                <td class="p-3 text-sm"><?= $inquiry['id'] ?></td>
                                <td class="p-3 font-medium"><?= htmlspecialchars($inquiry['name']) ?></td>
                                <td class="p-3 text-sm"><?= htmlspecialchars($inquiry['email']) ?></td>
                                <td class="p-3 text-sm max-w-xs">
                                    <div class="line-clamp-2"><?= htmlspecialchars($inquiry['message']) ?></div>
                                    <?php if (strlen($inquiry['message']) > 100): ?>
                                        <a href="view_inquiry.php?id=<?= $inquiry['id'] ?>" class="text-[#800020] hover:underline mt-1 block">
                                            Read more
                                        </a>
                                    <?php endif; ?>
                                </td>
                                <td class="p-3 text-sm"><?= $inquiry['created_at'] ?></td>
                                <td class="p-3 flex gap-2">
                                    <a href="view_inquiry.php?id=<?= $inquiry['id'] ?>" class="text-blue-600 hover:text-blue-800">
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
                    Showing <?= ($page - 1) * $per_page + 1 ?>-<?= min($page * $per_page, $total_inquiries) ?> of <?= $total_inquiries ?> inquiries
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