<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ./auth/login.php");
    exit();
}
$current_page = 'team_members';
include('../view/layout/header.php');
include('../view/db.php');

// Pagination setup
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$members_per_page = 8;
$offset = ($page - 1) * $members_per_page;

// Get total number of team members
$total_members_result = $conn->query("SELECT COUNT(*) AS total FROM team_members");
$total_members = $total_members_result->fetch_assoc()['total'];
$total_pages = ceil($total_members / $members_per_page);

// Get team members data
$stmt = $conn->prepare("
    SELECT id, name, title, description, image_url, skills, created_at 
    FROM team_members 
    ORDER BY created_at ASC
    LIMIT ? OFFSET ?
");
$stmt->bind_param("ii", $members_per_page, $offset);
$stmt->execute();
$result = $stmt->get_result();

$team_members = [];
while ($row = $result->fetch_assoc()) {
    $team_members[] = $row;
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
                    <li class="breadcrumb-item active">Team Members</li>
                </ol>
            </nav>
            <div class="flex justify-between items-center gap-4">
                <a href="export.php?export_type=members" class="px-3 py-2 border border-[#800020]/20 rounded-lg hover:bg-[#800020]/5">
                    Export<i class="fas fa-file-export ml-2 text-[#800020]/60"></i>
                </a>
                <a href="add_member.php" class="text-red-900 px-4 py-2 rounded-lg hover:font-bold">
                    + New
                </a>
            </div>

        </div>

        <!-- Team Members Table Section -->
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
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">Title</th>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">Skills</th>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">Image</th>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">Created At</th>
                            <th class="p-3 text-left text-sm font-semibold text-[#800020]">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#800020]/10">
                        <?php foreach ($team_members as $member): ?>
                            <tr class="hover:bg-[#800020]/5 transition-colors">
                                <td class="p-3"><input type="checkbox" class="form-checkbox h-4 w-4 text-[#800020]"></td>
                                <td class="p-3 text-sm"><?= $member['id'] ?></td>
                                <td class="p-3 font-medium"><?= $member['name'] ?></td>
                                <td class="p-3 text-sm"><?= $member['title'] ?></td>
                                <td class="p-3 text-sm">
                                    <?php if (!empty($member['skills'])): ?>
                                        <div class="flex flex-wrap gap-2">
                                            <?php
                                            $skills = explode(',', $member['skills']);
                                            foreach ($skills as $skill):
                                            ?>
                                                <span class="px-2 py-1 bg-[#800020]/10 text-[#800020] rounded-full text-xs">
                                                    <?= trim($skill) ?>
                                                </span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-gray-400">No skills listed</span>
                                    <?php endif; ?>
                                </td>
                                <td class="p-3 text-sm">
                                    <?php if ($member['image_url']): ?>
                                        <img src="../<?= $member['image_url'] ?>"
                                            class="w-12 h-12 rounded-full object-cover border-2 border-[#800020]/20"
                                            alt="<?= $member['name'] ?>">
                                    <?php else: ?>
                                        <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center border-2 border-[#800020]/20">
                                            <i class="fas fa-user text-gray-400"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="p-3 text-sm"><?= $member['created_at'] ?></td>
                                <td class="p-3 flex gap-2">
                                    <a href="edit_member.php?id=<?= $member['id'] ?>" class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="delete_member.php?id=<?= $member['id'] ?>" class="text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <a href="view_team.php?id=<?= $member['id'] ?>" class="text-green-600 hover:text-green-800">
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
                    Showing <?= ($page - 1) * $members_per_page + 1 ?>-<?= min($page * $members_per_page, $total_members) ?> of <?= $total_members ?> members
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