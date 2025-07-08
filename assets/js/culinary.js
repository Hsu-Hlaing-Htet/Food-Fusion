// Get all sections and navigation links
const sections = document.querySelectorAll('.section'); // Add 'section' class to each section
const navItems = document.querySelectorAll('.cali-nav-link'); // Select <a> tags directly

// Function to hide all sections
function hideSections() {
    sections.forEach(section => {
        section.style.display = 'none'; // Hide all sections
    });
}

// Function to show the clicked section
function showSection(id) {
    const section = document.getElementById(id); // Use getElementById for unique sections
    if (section) {
        section.style.display = 'block'; // Show the selected section
    }
}

// Function to remove active class from all links
function removeActiveClass() {
    navItems.forEach(item => {
        item.classList.remove('active'); 
    });
}

// Function to add active class to the clicked link
function addActiveClass(link) {
    link.classList.add('active'); 
}

// Event listener for navigation links
navItems.forEach(link => {
    link.addEventListener('click', function (event) {
        event.preventDefault(); // Prevent the default anchor behavior
        const targetId = link.getAttribute('href').substring(1); // Get the target section ID without '#'

        hideSections(); // Hide all sections
        showSection(targetId); // Show the clicked section

        removeActiveClass(); // Remove active class from all links
        addActiveClass(link); // Add active class to the clicked link
    });
});

// Initially hide all sections and show the first one (or default to eco-friendly)
hideSections();
showSection('ecofriendly'); // Pass ID, not the selector
addActiveClass(navItems[0]); // Make the first nav link active by default
