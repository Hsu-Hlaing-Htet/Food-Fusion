document.addEventListener("DOMContentLoaded", function () {
    function fetchRecipes(page = 1) {
        const difficulty = document.getElementById("difficulty").value;
        const cuisine_name = document.getElementById("cuisine_name").value;
        const search = document.getElementById("search").value;

        fetch(`../include/get_recipes.php?difficulty=${difficulty}&cuisine_name=${cuisine_name}&search=${search}&page=${page}`)
            .then(response => response.text())
            .then(data => {
                document.getElementById("recipes").innerHTML = data;
                updatePagination(page);
            })
            .catch(error => console.error("Error fetching recipes:", error));
    }

    document.querySelector("#searchBtn").addEventListener("click", function (e) {
        e.preventDefault();
        fetchRecipes(); // Fetch results for page 1
    });

    function updatePagination(currentPage) {
        const totalPages = document.getElementById("totalPagesHidden")?.value || 1;
        let paginationHTML = "";

        if (totalPages > 1) {
            paginationHTML += `<ul class="flex space-x-4">`;
            for (let i = 1; i <= totalPages; i++) {
                paginationHTML += `
                    <li>
                        <a href="#" class="page-link px-4 py-2 ${i == currentPage ? 'border-2 border-red-900 text-red-900' : 'bg-gray-200 hover:bg-red-900 hover:text-white'} rounded" data-page="${i}">
                            ${i}
                        </a>
                    </li>`;
            }
            paginationHTML += `</ul>`;
        }

        document.getElementById("totalPages").innerHTML = paginationHTML;

        // Add event listeners to pagination links
        document.querySelectorAll(".page-link").forEach(link => {
            link.addEventListener("click", function (e) {
                e.preventDefault();
                const page = this.getAttribute("data-page");
                fetchRecipes(page);
            });
        });
    }



});

// category slider 


document.addEventListener("DOMContentLoaded", function () {
    let allRecipes = []; // Store all recipes for the selected cuisine
    let currentIndex = 0; // To track the current index of the displayed recipe
    let currentCategory = 'Dinner'; // Default category is 

    // Function to load recipes for a given cuisine
    function loadCategory(category) {
        fetch(`../include/slide_recipe.php?category=${category}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                allRecipes = data;
                currentCategory = category;
                currentIndex = 0; // Reset to first recipe
                updateSlider(); // Update the slider with new recipes
                setActiveCuisine(category); // Update the active cuisine link
            })
            .catch(error => console.error('Error loading category data:', error));
    }

    // Function to update the slider with the current recipes
    function updateSlider() {
        const sliderContainer = document.getElementById('slider');
        if (!sliderContainer) {
            console.error("Slider container not found!");
            return;
        }

        sliderContainer.innerHTML = ''; // Clear the existing slider content



        // Loop through all recipes and generate the HTML for the cards
        allRecipes.forEach(recipe => {
            const cardHTML = `
                <div class="sliderecipe-card max-w-[90%] sm:max-w-[80%] md:max-w-[60%] lg:max-w-[400px] shrink-0 py-5">
                    <div class="relative w-[200px] h-[300px] overflow-hidden shadow-lg bg-cover bg-center mb-4 lg:rounded-lg 
                                hover:transform hover:scale-105 hover:shadow-xl transition-all duration-300"
                        style="background-image: url('${recipe.image}');">
                        <div class="bg-black bg-opacity-50 p-6 h-full flex flex-col justify-end relative 
                                hover:bg-opacity-70 transition-all duration-300">
                            <h2 class="text-lg absolute sm:top-5 lg:top-20 font-semibold text-white">
                                <a href="show_receipe.php?id=${recipe.id}" 
                                class="text-white hover:text-red-900 hover:underline transition-colors duration-300">
                                    ${recipe.title}
                                </a>
                            </h2>
                        </div>
                        <div class="absolute bottom-0 left-0 w-full">
                            <div class="flex justify-between px-4 py-2 text-white text-sm relative">
                                <span class="absolute bg-red-900 sm:px-10 lg:px-2 py-2 bottom-0 left-0 rounded-tr-2xl 
                                        border-t-2 border-r-2 border-white hover:bg-red-800 transition-colors duration-300">
                                    ${recipe.cuisine_name}
                                </span>
                                <div class="flex items-center sm:px-10 lg:px-5 rounded-tl-2xl border-t-2 border-l-2 
                                        border-white ml-3 absolute bg-red-900 py-2 bottom-0 right-0 
                                        hover:bg-red-800 transition-colors duration-300">
                                    <i class="fas fa-utensils text-yellow-400 mr-1"></i>
                                    <span>${recipe.difficulty_level}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            `;
            sliderContainer.innerHTML += cardHTML; // Append each card
        });
    }

    // Function to update the active class on the selected cuisine link
    function setActiveCuisine(category) {
        // Select all the <a> tags within the #recipe-category list
        const categoryLinks = document.querySelectorAll('#recipe-category li a');

        categoryLinks.forEach(link => {
            // If the link's id matches the category, add the 'active' class
            if (link.id.toLowerCase() === category.toLowerCase()) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });
    }

    // Set the default active link (Dinner) when the page loads
    document.addEventListener("DOMContentLoaded", () => {
        setActiveCuisine('Dinner'); // Default active link
    });

    // Add click event listeners to change active class on user click
    document.querySelectorAll('#recipe-category li a').forEach(link => {
        link.addEventListener('click', function (event) {
            // Prevent the default anchor link behavior
            event.preventDefault();

            // Set the clicked link as active
            setActiveCuisine(event.target.id);
        });
    });


    document.getElementById('next').addEventListener('click', function () {
        const sliderContainer = document.getElementById('slider');
        const cardWidth = sliderContainer.querySelector('.sliderecipe-card').offsetWidth;

        // Ensure we don't exceed the number of recipes
        if (currentIndex < allRecipes.length - 1) {
            currentIndex++; // Move to the next recipe
            const scrollAmount = cardWidth + 16; // Account for the margin-right (16px)
            sliderContainer.scrollBy({ left: scrollAmount, behavior: 'smooth' }); // Scroll the container
        }
    });

    document.getElementById('prev').addEventListener('click', function () {
        const sliderContainer = document.getElementById('slider');
        const cardWidth = sliderContainer.querySelector('.sliderecipe-card').offsetWidth;

        // Ensure we don't go below index 0
        if (currentIndex > 0) {
            currentIndex--; // Move to the previous recipe
            const scrollAmount = cardWidth + 16; // Account for the margin-right (16px)
            sliderContainer.scrollBy({ left: -scrollAmount, behavior: 'smooth' }); // Scroll the container
        }
    });

    // Handle the cuisine navigation link clicks
    document.getElementById('Dinner').addEventListener('click', function (event) {
        event.preventDefault(); // Prevent default link behavior
        loadCategory('Dinner');
    });

    document.getElementById('Dessert').addEventListener('click', function (event) {
        event.preventDefault();
        loadCategory('Dessert');
    });

    document.getElementById('Main').addEventListener('click', function (event) {
        event.preventDefault();
        loadCategory('Main');
    });

    document.getElementById('Soup').addEventListener('click', function (event) {
        event.preventDefault();
        loadCategory('Soup');
    });



    loadCategory('Dinner');
});

