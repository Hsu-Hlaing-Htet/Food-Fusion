<?php
$current_page = 'member';
include('../view/layout/header.php');
include('../view/db.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $skills = trim($_POST['skills']);

    // Handle file upload

    $upload_dir = '../../assets/Images/team_members/';
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];

    $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/FoodFusion/assets/Images/team_members/';

    if (is_dir($upload_dir)) {
        echo "Upload directory exists: " . $upload_dir;
    } else {
        echo "Error: Upload directory not found!";
    }


    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $file_type = $_FILES['image']['type'];

        // Check if file is an image
        if (!in_array($file_type, $allowed_types)) {
            die("Invalid file type. Only JPG, PNG, and GIF allowed.");
        }

        // Get the next available file name (member1.jpg, member2.jpg, ...)
        $files = glob($upload_dir . "member*.jpg");
        $next_number = count($files) + 1;
        $new_filename = "member{$next_number}.jpg";

        // Full path for the new file
        $target_file = $upload_dir . $new_filename;

        // Move the uploaded file
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            echo "File uploaded successfully as $new_filename";
        } else {
            echo "Failed to upload file.";
        }
    } else {
        echo "No file uploaded or an error occurred.";
    }


    // Insert into database if no errors
    if (!isset($error)) {
        $stmt = $conn->prepare("
            INSERT INTO team_members 
            (name, title, description, image_url, skills)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("sssss", $name, $title, $description, $image_url, $skills);

        if ($stmt->execute()) {
            header("Location: member.php?success=1");
            exit();
        } else {
            $error = "Error saving member: " . $conn->error;
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
                    <li class="breadcrumb-item active">Add New Member</li>
                </ol>
            </nav>
        </div>

        <!-- Error Message -->
        <?php if (isset($error)): ?>
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <!-- Add Member Form -->
        <div class="bg-white rounded-lg shadow-sm border border-[#800020]/10 p-6">
            <form method="POST" enctype="multipart/form-data" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name Field -->
                    <div>
                        <label class="block text-sm font-medium text-[#800020] mb-2">Name *</label>
                        <input type="text" name="name" required
                            class="w-full px-4 py-2 border border-[#800020]/20 rounded-lg focus:ring-2 focus:ring-[#800020] focus:border-transparent">
                    </div>

                    <!-- Title Field -->
                    <div>
                        <label class="block text-sm font-medium text-[#800020] mb-2">Title *</label>
                        <input type="text" name="title" required
                            class="w-full px-4 py-2 border border-[#800020]/20 rounded-lg focus:ring-2 focus:ring-[#800020] focus:border-transparent">
                    </div>

                    <!-- Image Upload -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-[#800020] mb-2">Profile Image *</label>
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                <input type="file" name="image" accept="image/*" required
                                    class="opacity-0 absolute w-full h-full cursor-pointer">
                                <div class="px-4 py-2 border border-[#800020]/20 rounded-lg text-[#800020] hover:bg-[#800020]/5">
                                    Choose File
                                </div>
                            </div>
                            <span class="text-sm text-gray-500">JPEG, PNG (Max 2MB)</span>
                        </div>
                    </div>

                    <!-- Skills -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-[#800020] mb-2">Skills (comma separated)</label>
                        <input type="text" name="skills"
                            class="w-full px-4 py-2 border border-[#800020]/20 rounded-lg focus:ring-2 focus:ring-[#800020] focus:border-transparent"
                            placeholder="e.g., Cooking, Baking, Food Styling">
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-[#800020] mb-2">Description</label>
                        <textarea name="description" rows="4"
                            class="w-full px-4 py-2 border border-[#800020]/20 rounded-lg focus:ring-2 focus:ring-[#800020] focus:border-transparent"></textarea>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-4">
                    <a href="member.php" class="px-6 py-2 border border-[#800020]/20 rounded-lg hover:bg-[#800020]/5 text-[#800020]">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-[#800020] text-white rounded-lg hover:bg-[#600018]">
                        Add Member
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('../view/layout/footer.php'); ?>