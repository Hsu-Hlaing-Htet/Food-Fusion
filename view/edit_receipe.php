<?php
include('../include/db.php');

if (isset($_GET['id'])) {
    $recipeId = $_GET['id'];

    // Fetch recipe details
    $stmt = $conn->prepare("SELECT r.*, u.name AS username, u.profile_picture 
                          FROM recipes r 
                          JOIN users u ON r.user_id = u.user_id 
                          WHERE r.id = ?");
    $stmt->bind_param("i", $recipeId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $recipe = $result->fetch_assoc();
        $recipe['category'];
    } else {
        echo "Recipe not found.";
        exit;
    }

    // Fetch ingredients
    $stmt = $conn->prepare("SELECT name, quantity FROM recipe_ingredients WHERE recipe_id = ?");
    $stmt->bind_param("i", $recipeId);
    $stmt->execute();
    $ingredients = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // Fetch cooking steps

    $stmt = $conn->prepare("SELECT description, step_order FROM recipe_cooking_steps WHERE recipe_id = ?");
    $stmt->bind_param("i", $recipeId);
    $stmt->execute();
    $cooking_steps = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
} else {
    echo "No recipe ID provided.";
    exit;
}
?>
<link rel="stylesheet" href="../assets/css/animation.css">
<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="../assets/css/main.css">
<link rel="stylesheet" href="../assets/css/styles.css">
<link rel="stylesheet" href="../assets/font/fontawesome-free-5.15.4-web/css/all.min.css">
<section id="recipe-form" class="p-8 mt-8 max-w-3xl mx-auto border rounded-lg shadow-lg bg-white relative">
    <a href="cookbook.php" class="top-0 left-0 text-stone-900 text-lg flex items-center">
        <i class="fas fa-arrow-left mr-2"></i> Back to CookBook
    </a>

    <h2 class="text-2xl font-semibold mb-6 text-center">Update Recipe</h2>

    <form action="../include/edit_receipe.php" method="POST" enctype="multipart/form-data" id="recipeForm" class="w-full">
        <input type="hidden" name="id" value="<?= htmlspecialchars($recipe['id']) ?>">

        <!-- Updated Image Section -->
        <div class="w-full h-auto mb-4">
            <!-- Current Image -->
            <img id="imagePreview" src="<?= htmlspecialchars($recipe['image']) ?>"
                alt="<?= htmlspecialchars($recipe['title']) ?>"
                class="w-full h-80 object-cover mb-4">

            <!-- New Image Upload -->
            <label class="block mb-2 text-stone-600">Update Image (Optional):</label>
            <input type="file" name="image" accept="image/*" id="imageInput"
                class="border border-gray-300 p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-red-900"
                onchange="previewImage(event)">
        </div>

        <!-- Recipe Details -->
        <div class="mb-4">
            <label class="block mb-2 text-stone-600">Recipe Title:</label>
            <input type="text" name="title" value="<?= htmlspecialchars($recipe['title']) ?>" required
                class="border border-gray-300 p-2 w-full rounded focus:outline-none focus:ring-red-900">
        </div>

        <div class="mb-4">
            <label class="block mb-2 text-stone-600">Description:</label>
            <textarea name="description" required
                class="border border-gray-300 p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-red-900"><?= htmlspecialchars($recipe['description']) ?></textarea>
        </div>

        <!-- Cuisine and Difficulty -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block mb-2 text-stone-600">Cuisine:</label>
                <input type="text" name="cuisine_name" value="<?= htmlspecialchars($recipe['cuisine_name']) ?>" required
                    class="border border-gray-300 p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-red-900">
            </div>
            <div>
                <label class="block mb-2 text-stone-600">Difficulty Level:</label>
                <select name="difficulty_level" class="border border-gray-300 p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-red-900">
                    <option value="Easy" <?= $recipe['difficulty_level'] === 'Easy' ? 'selected' : '' ?>>Easy</option>
                    <option value="Medium" <?= $recipe['difficulty_level'] === 'Medium' ? 'selected' : '' ?>>Medium</option>
                    <option value="Hard" <?= $recipe['difficulty_level'] === 'Hard' ? 'selected' : '' ?>>Hard</option>
                </select>
            </div>
        </div>

        <!-- Timing and Servings -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
            <div>
                <label class="block mb-2 text-stone-600">Prep Time (minutes):</label>
                <input type="number" name="prep_time" value="<?= htmlspecialchars($recipe['prep_time']) ?>" required
                    class="border border-gray-300 p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-red-900">
            </div>
            <div>
                <label class="block mb-2 text-stone-600">Cook Time (minutes):</label>
                <input type="number" name="cook_time" value="<?= htmlspecialchars($recipe['cook_time']) ?>" required
                    class="border border-gray-300 p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-red-900">
            </div>
            <div>
                <label class="block mb-2 text-stone-600">Serving (people):</label>
                <input type="number" name="serving" value="<?= htmlspecialchars($recipe['serving']) ?>" required
                    class="border border-gray-300 p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-red-900">
            </div>
            <div>
                <label class="block mb-2 text-stone-600">Category :</label>
                <input type="text" name="category" value="<?= htmlspecialchars($recipe['category'] ?? 'Other') ?>" required
                    class="border border-gray-300 p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-red-900">
            </div>
        </div>

        <!-- Ingredients Section -->
        <h3 class="text-lg font-semibold mt-4 mb-2">Ingredients:</h3>
        <ul id="ingredient-list" class="space-y-4">
            <?php foreach ($ingredients as $ingredient): ?>
                <li class="ingredient-entry flex items-center gap-4">
                    <input type="text" name="ingredient_name[]" placeholder="Ingredient"
                        value="<?= htmlspecialchars($ingredient['name']) ?>"
                        class="border border-gray-300 p-2 flex-1 rounded focus:outline-none focus:ring-2 focus:ring-red-900">
                    <input type="text" name="quantity[]" placeholder="Quantity"
                        value="<?= htmlspecialchars($ingredient['quantity']) ?>"
                        class="border border-gray-300 p-2 flex-1 rounded focus:outline-none focus:ring-2 focus:ring-red-900">
                    <button type="button" onclick="removeEntry(this)" class="text-red-900 hover:text-red-700">
                        <i class="fas fa-minus-circle fa-lg"></i>
                    </button>
                </li>
            <?php endforeach; ?>
        </ul>
        <button type="button" onclick="addIngredient()" class="mt-2 text-red-900 hover:text-red-700">
            <i class="fas fa-plus-circle fa-lg mr-2"></i>Add Ingredient
        </button>

        <!-- Cooking Steps Section -->
        <h3 class="text-lg font-semibold mt-8 mb-2">Cooking Steps:</h3>
        <ul id="step-list" class="space-y-6">
            <?php foreach ($cooking_steps as $index => $step): ?>
                <li class="step-entry">
                    <div class="flex items-start gap-4">
                        <input type="hidden" name="step_order[]" value="<?= $index + 1 ?>">
                        <textarea name="steps[]"
                            class="border border-gray-300 p-2 flex-1 rounded focus:outline-none focus:ring-2 focus:ring-red-900"
                            rows="3"><?= htmlspecialchars($step['description']) ?></textarea>
                        <button type="button" onclick="removeEntry(this)" class="text-red-900 hover:text-red-700 mt-2">
                            <i class="fas fa-minus-circle fa-lg"></i>
                        </button>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
        <button type="button" onclick="addStep()" class="mt-2 text-red-900 hover:text-red-700">
            <i class="fas fa-plus-circle fa-lg mr-2"></i>Add Step
        </button>

        <!-- Updated Video Section -->
        <div class="mt-8">
            <!-- Current Video -->
            <video id="videoPreview" controls class="w-full mb-4">
                <source src="<?= htmlspecialchars($recipe['video_path']) ?>" type="video/mp4">
                Your browser does not support the video tag.
            </video>

            <!-- New Video Upload -->
            <label class="block mb-2 text-stone-600">Update Video (Optional):</label>
            <input type="file" name="video" accept="video/*" id="videoInput"
                class="border border-gray-300 p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-red-900"
                onchange="previewVideo(event)">
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end mt-8">
            <button type="submit" class="bg-red-900 text-white px-6 py-3 rounded-lg hover:bg-red-800 transition-colors">
                Update Recipe
            </button>
        </div>
    </form>
</section>

<script>
    // Image Preview
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            document.getElementById('imagePreview').src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    // Video Preview
    function previewVideo(event) {
        const file = event.target.files[0];
        if (file) {
            const video = document.getElementById('videoPreview');
            video.src = URL.createObjectURL(file);
            video.load();
        }
    }

    function addIngredient() {
        const list = document.getElementById('ingredient-list');
        const newEntry = document.createElement('li');
        newEntry.className = 'ingredient-entry flex items-center gap-4';
        newEntry.innerHTML = `
        <input type="text" name="ingredient_name[]" placeholder="Ingredient" 
               class="border border-gray-300 p-2 flex-1 rounded focus:outline-none focus:ring-2 focus:ring-red-900">
        <input type="text" name="quantity[]" placeholder="Quantity" 
               class="border border-gray-300 p-2 flex-1 rounded focus:outline-none focus:ring-2 focus:ring-red-900">
        <button type="button" onclick="removeEntry(this)" class="text-red-900 hover:text-red-700">
            <i class="fas fa-minus-circle fa-lg"></i>
        </button>
    `;
        list.appendChild(newEntry);
    }

    function addStep() {
        const list = document.getElementById('step-list');
        const newEntry = document.createElement('li');
        newEntry.className = 'step-entry';
        const stepNumber = list.children.length + 1;
        newEntry.innerHTML = `
        <div class="flex items-start gap-4">
            <input type="hidden" name="step_order[]" value="${stepNumber}">
            <textarea name="steps[]" 
                      class="border border-gray-300 p-2 flex-1 rounded focus:outline-none focus:ring-2 focus:ring-red-900" 
                      rows="3" placeholder="Describe this step"></textarea>
            <button type="button" onclick="removeEntry(this)" class="text-red-900 hover:text-red-700 mt-2">
                <i class="fas fa-minus-circle fa-lg"></i>
            </button>
        </div>
    `;
        list.appendChild(newEntry);
    }

    function removeEntry(button) {
        const entry = button.closest('li');
        if (entry) {
            entry.remove();
            // Update step numbers after removal
            document.querySelectorAll('#step-list .step-entry').forEach((li, index) => {
                li.querySelector('span').textContent = `${index + 1}.`;
            });
        }
    }
</script>