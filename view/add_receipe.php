<link rel="stylesheet" href="../assets/css/animation.css">
<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="../assets/css/main.css">
<link rel="stylesheet" href="../assets/css/styles.css">
<link rel="stylesheet" href="../assets/font/fontawesome-free-5.15.4-web/css/all.min.css">

<section id="recipe-form" class="p-8 mt-8 max-w-3xl mx-auto border rounded-lg shadow-lg bg-white relative">
    <a href="cookbook.php" class="top-0 left-0 text-stone-900 text-lg flex items-center">
        <i class="fas fa-arrow-left mr-2"></i> Back to CookBook
    </a>

    <h2 class="text-2xl font-semibold mb-6 text-center">Share Your Recipe</h2>

    <div id="progress-bar" class="w-full bg-stone-300 rounded-full h-2 mb-6">
        <div id="progress" class="bg-red-900 h-2 rounded-full" style="width: 33%"></div>
    </div>

    <form action="../include/add_receipe.php" method="POST" enctype="multipart/form-data" id="recipeForm" class="w-full">
        <!-- Step 1: Recipe Details -->
        <div class="step" id="step1">
            <h3 class="text-xl font-semibold text-stone-600 mb-4">Recipe Details</h3>
            <label class="block mb-2 text-stone-600">Recipe Title:</label>
            <input type="text" name="title" required class="border border-gray-300 p-2 w-full mb-4 rounded focus:outline-none focus:ring-2  focus:ring-red-900">

            <label class="block mb-2 text-stone-600">Description:</label>
            <textarea name="description" required class="border border-gray-300 p-2 w-full mb-4 rounded focus:outline-none focus:ring-2 focus:ring-red-900"></textarea>

            <div class="flex justify-between gap-3">
                <div class="w-full">
                    <label class="block mb-2 text-stone-600">Cuisine:</label>
                    <input type="text" name="cuisine_name" id="cuisine_name" required class="border border-gray-300 p-2 w-full mb-4 rounded focus:outline-none focus:ring-2 focus:ring-red-900">
                </div>
                <div class="w-full">
                    <label class="block mb-2 text-stone-600">Difficulty Level:</label>
                    <select name="difficulty_level" class="border border-gray-300 w-full p-2 rounded focus:outline-none focus:ring-2 focus:ring-red-900">
                        <option value="Easy">Easy</option>
                        <option value="Medium">Medium</option>
                        <option value="Hard">Hard</option>
                    </select>
                </div>

            </div>
            <!-- Additional fields for Step 1... -->

            <div class="flex justify-end mt-4">

                <button type="button" onclick="nextStep(1)" class="bg-red-900 text-white px-4 py-2 rounded" id="nextBtn1">Next</button>
            </div>
        </div>

        <!-- Step 2: Time and Video -->
        <div class="step" id="step2" style="display: none;">
            <h3 class="text-xl font-semibold mb-4">Time & Video</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block mb-2 text-stone-600">Prep Time (minutes):</label>
                    <input type="number" name="prep_time" required class="border border-gray-300 w-full p-2 rounded focus:outline-none focus:ring-2 focus:ring-red-900">
                </div>
                <div>
                    <label class="block mb-2 text-stone-600">Cook Time (minutes):</label>
                    <input type="number" name="cook_time" required class="border border-gray-300 w-full p-2 rounded focus:outline-none focus:ring-2 focus:ring-red-900">
                </div>
                <div>
                    <label class="block mb-2 text-stone-600">Serving (people):</label>
                    <input type="number" name="serving" required class="border border-gray-300 w-full p-2 rounded focus:outline-none focus:ring-2 focus:ring-red-900">
                </div>
                <div>
                    <label class="block mb-2 text-stone-600">Category :</label>
                    <input type="text" name="category" required class="border border-gray-300 p-2 w-full mb-4 rounded focus:outline-none focus:ring-2 focus:ring-red-900">

                </div>
            </div>


            <!-- Video Section -->
            <div class="mb-6">
                <label class="block mb-2 text-stone-600">Upload Video (Optional):</label>
                <div class="border-2 border-gray-300 rounded-lg p-4 hover:border-red-900 transition-colors">
                    <input type="file" name="video" accept="video/*"
                        class="w-full mb-4"
                        id="videoInput"
                        onchange="previewVideo(event)">

                    <!-- Video Preview -->
                    <div id="videoPreviewContainer" class="hidden mt-4">
                        <p class="text-sm text-gray-500 mb-2">Selected Video Preview:</p>
                        <video controls id="videoPreview" class="w-full rounded-lg"></video>
                    </div>
                </div>
            </div>

            <!-- Image Section -->
            <div class="mb-6">
                <label class="block mb-2 text-stone-600">Upload Image (Optional):</label>
                <div class="border-2 border-gray-300 rounded-lg p-4 hover:border-red-900 transition-colors">
                    <input type="file" name="image" accept="image/*"
                        class="w-full mb-4"
                        id="imageInput"
                        onchange="previewImage(event)">

                    <!-- Image Preview -->
                    <div id="imagePreviewContainer" class="hidden mt-4">
                        <p class="text-sm text-gray-500 mb-2">Selected Image Preview:</p>
                        <img id="imagePreview" class="max-h-64 w-auto rounded-lg shadow-md mx-auto">
                    </div>
                </div>
            </div>



            <div class="flex justify-end mt-4">
                <button type="button" onclick="nextStep(2)" class="bg-red-900 text-white px-4 py-2 rounded" id="nextBtn2">Next</button>
            </div>
        </div>

        <!-- Step 3: Ingredients and Cooking Steps -->
        <div class="step" id="step3" style="display: none;">
            <h3 class="text-xl font-semibold mb-4">Ingredients & Cooking Steps</h3>
            <!-- Ingredients Section -->
            <div class="mb-6 w-full">
                <label class="block mb-2 text-stone-600">Ingredients:</label>
                <div id="ingredient-list">
                    <div class="ingredient-entry flex items-center justify-between w-full gap-2">
                        <div class="flex items-center space-x-2 w-full">
                            <input type="text" name="ingredient_name[]" placeholder="Ingredient Name (e.g., Sugar)" class="border border-gray-300 p-2 w-2/3 rounded focus:outline-none focus:ring-2 focus:ring-red-900">
                            <input type="text" name="quantity[]" placeholder="Quantity (e.g., 2 cups)" class="border border-gray-300 p-2 w-1/3 rounded focus:outline-none focus:ring-2 focus:ring-red-900">
                        </div>

                        <button type="button" onclick="addIngredient()" class="px-4 py-2 flex items-center gap-2">
                            <i class="fas fa-plus text-red-900"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Steps Section -->
            <label class="block mb-2 text-stone-600">Cooking Steps:</label>
            <div id="step-list" class="mb-6">

                <div class="step flex mb-2 justify-between gap-2">
                    <input type="hidden" name="step_order[]" value="1">
                    <textarea name="steps[]" placeholder="Enter cooking step (e.g., Boil water)" class="border border-gray-300 p-2 w-full mb-2 rounded focus:outline-none focus:ring-2 focus:ring-red-900"></textarea>
                    <button type="button" onclick="addStep()" class="...">
                        <i class="fas fa-plus text-red-900"></i>
                    </button>
                </div>

            </div>

            <div class="flex justify-between mt-6">
                <button type="button" onclick="window.location.href='cookbook.php';" class="bg-gray-500 text-white px-4 py-2 rounded" id="">Back</button>
                <button type="submit" class="bg-red-900 text-white px-4 py-2 rounded" id="submitBtn">Post</button>
            </div>

        </div>
    </form>


</section>

<script>
    // Image Preview Handler
    function previewImage(event) {
        const container = document.getElementById('imagePreviewContainer');
        const preview = document.getElementById('imagePreview');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                container.classList.remove('hidden');
                preview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        } else {
            container.classList.add('hidden');
            preview.src = '';
        }
    }

    // Video Preview Handler
    function previewVideo(event) {
        const container = document.getElementById('videoPreviewContainer');
        const preview = document.getElementById('videoPreview');
        const file = event.target.files[0];

        if (file) {
            container.classList.remove('hidden');
            preview.src = URL.createObjectURL(file);
            preview.load();
        } else {
            container.classList.add('hidden');
            preview.src = '';
        }
    }

    // Clear previews when navigating back
    function resetMediaPreviews() {
        document.getElementById('imagePreview').src = '';
        document.getElementById('videoPreview').src = '';
        document.getElementById('imagePreviewContainer').classList.add('hidden');
        document.getElementById('videoPreviewContainer').classList.add('hidden');
    }
    let currentStep = 1; // Track the current step

    function nextStep(step) {
        // Display the next step
        document.getElementById('step' + (step + 1)).style.display = 'block';

        // Hide the "Next" button for the current step
        document.getElementById('nextBtn' + step).style.display = 'none';

        // Update the progress bar
        let progress = (step + 1) * 33; // 33% per step
        document.getElementById('progress').style.width = progress + '%';
    }

    function addIngredient() {
        let div = document.createElement('div');
        div.className = "ingredient-entry flex items-center justify-between w-full gap-2";

        div.innerHTML = `
    <div class="flex items-center gap-2 w-full mt-3">
        <div class="flex items-center space-x-2 w-full">
                <input type="text" name="ingredient_name[]" placeholder="Ingredient Name (e.g., Sugar)" class="border border-gray-300 p-2 w-2/3 rounded focus:outline-none focus:ring-2 focus:ring-red-900">
                <input type="text" name="quantity[]" placeholder="Quantity (e.g., 2 cups)" class="border border-gray-300 p-2 w-1/3 rounded focus:outline-none focus:ring-2 focus:ring-red-900">
            </div>
        <button type="button" onclick="removeIngredient(this)" class="px-4 py-2 flex items-center gap-2">
            <i class="fas fa-minus text-stone-600"></i>
        </button>
    </div>`;

        document.getElementById('ingredient-list').appendChild(div);
    }

    let stepCounter = 1; // Add this at the top of your script

    function addStep() {
        stepCounter++;
        let div = document.createElement('div');
        div.className = "step";
        div.innerHTML = `
        <div class="flex mb-2 justify-between gap-2">
            <input type="hidden" name="step_order[]" value="${stepCounter}">
            <textarea name="steps[]" placeholder="Enter cooking step..." class="border border-gray-300 p-2 w-full mb-2 rounded focus:outline-none focus:ring-2 focus:ring-red-900"></textarea>
            <button type="button" onclick="removeStep(this)" class="...">
                <i class="fas fa-minus text-stone-600"></i>
            </button>
        </div>
    `;
        document.getElementById('step-list').appendChild(div);
    }

    // For Ingredients
    function removeIngredient(btn) {
        const ingredientEntry = btn.closest('.ingredient-entry');
        if (ingredientEntry) {
            ingredientEntry.remove();
        }
    }

    // For Steps
    function removeStep(btn) {
        const stepDiv = btn.closest('.step');
        if (stepDiv) {
            stepDiv.remove();
            // Update step numbers after removal
            document.querySelectorAll('#step-list input[name="step_order[]"]').forEach((input, index) => {
                input.value = index + 1;
            });
            stepCounter = document.querySelectorAll('#step-list .step').length;
        }
    }
</script>