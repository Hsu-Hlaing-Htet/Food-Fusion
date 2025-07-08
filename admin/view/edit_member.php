<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ./auth/login.php");
    exit();
}
$current_page = 'member';
include('../view/layout/header.php');
include('../view/db.php');
// Get member ID from URL
$member_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch existing member data
$stmt = $conn->prepare("SELECT * FROM team_members WHERE id = ?");
$stmt->bind_param("i", $member_id);
$stmt->execute();
$result = $stmt->get_result();
$member = $result->fetch_assoc();

if (!$member) {
    header("Location: member.php?error=Member not found");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $skills = trim($_POST['skills']);

    // Image handling
    $upload_dir = '../../assets/Images/team_members/';
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/FoodFusion/assets/Images/team_members/';

    if (is_dir($upload_dir)) {
        echo "Upload directory exists: " . $upload_dir;
    } else {
        echo "Error: Upload directory not found!";
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK && isset($_POST['member_id'])) {
        $file_type = $_FILES['image']['type'];
        $member_id = intval($_POST['member_id']); // Get Member ID from form

        // Check if file is an image
        if (!in_array($file_type, $allowed_types)) {
            die("Invalid file type. Only JPG, PNG, and GIF allowed.");
        }

        $new_filename = "member{$member_id}.jpg"; // Overwrite existing file
        $target_file = $upload_dir . $new_filename;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            echo "File updated successfully as $new_filename";
        } else {
            echo "Failed to update file.";
        }
    } else {
        echo "No file uploaded, error occurred, or member ID missing.";
    }

    // Update database if no errors
    if (!isset($error)) {
        $stmt = $conn->prepare("
            UPDATE team_members 
            SET name = ?, title = ?, description = ?, image_url = ?, skills = ?
            WHERE id = ?
        ");
        $stmt->bind_param("sssssi", $name, $title, $description, $image_url, $skills, $member_id);

        if ($stmt->execute()) {
            header("Location: member.php?success=2");
            exit();
        } else {
            $error = "Error updating member: " . $conn->error;
        }
    }
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
                    <li class="breadcrumb-item"><a href="member.php" class="hover:text-[#600018]">Team Members /</a></li>
                    <li class="breadcrumb-item active">Edit Member</li>
                </ol>
            </nav>
        </div>

        <!-- Error Message -->
        <?php if (isset($error)): ?>
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <!-- Edit Member Form -->
        <div class="bg-white rounded-lg shadow-sm border border-[#800020]/10 p-6">
            <form method="POST" enctype="multipart/form-data" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name Field -->
                    <div>
                        <label class="block text-sm font-medium text-[#800020] mb-2">Name *</label>
                        <input type="text" name="name" required
                            value="<?= htmlspecialchars($member['name']) ?>"
                            class="w-full px-4 py-2 border border-[#800020]/20 rounded-lg focus:ring-2 focus:ring-[#800020] focus:border-transparent">
                    </div>

                    <!-- Title Field -->
                    <div>
                        <label class="block text-sm font-medium text-[#800020] mb-2">Title *</label>
                        <input type="text" name="title" required
                            value="<?= htmlspecialchars($member['title']) ?>"
                            class="w-full px-4 py-2 border border-[#800020]/20 rounded-lg focus:ring-2 focus:ring-[#800020] focus:border-transparent">
                    </div>

                    <!-- Image Upload -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-[#800020] mb-2">Profile Image</label>
                        <div class="flex items-center space-x-4">
                            <?php if ($member['image_url']): ?>
                                <img src="../<?= htmlspecialchars($member['image_url']) ?>"
                                    class="w-20 h-20 object-cover rounded-lg border border-[#800020]/20">
                            <?php endif; ?>
                            <div class="flex-1">
                                <div class="relative">
                                    <input type="file" name="image" accept="image/*"
                                        class="opacity-0 absolute w-full h-full cursor-pointer">
                                    <div class="px-4 py-2 border border-[#800020]/20 rounded-lg text-[#800020] hover:bg-[#800020]/5">
                                        Change Image
                                    </div>
                                </div>
                                <span class="text-sm text-gray-500">Leave empty to keep current image</span>
                            </div>
                        </div>
                    </div>

                    <!-- Skills -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-[#800020] mb-2">Skills (comma separated)</label>
                        <input type="text" name="skills"
                            value="<?= htmlspecialchars($member['skills']) ?>"
                            class="w-full px-4 py-2 border border-[#800020]/20 rounded-lg focus:ring-2 focus:ring-[#800020] focus:border-transparent"
                            placeholder="e.g., Cooking, Baking, Food Styling">
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-[#800020] mb-2">Description</label>
                        <textarea name="description" rows="4"
                            class="w-full px-4 py-2 border border-[#800020]/20 rounded-lg focus:ring-2 focus:ring-[#800020] focus:border-transparent"><?= htmlspecialchars($member['description']) ?></textarea>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-4">
                    <a href="member.php" class="px-6 py-2 border border-[#800020]/20 rounded-lg hover:bg-[#800020]/5 text-[#800020]">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-[#800020] text-white rounded-lg hover:bg-[#600018]">
                        Update Member
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('../view/layout/footer.php'); ?>