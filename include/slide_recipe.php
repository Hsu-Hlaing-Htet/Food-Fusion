<?php
include('../include/db.php');

// Get the cuisine name from the URL parameter
if (isset($_GET['category'])) {
    $category = $_GET['category']; 
} else {
    $category = 'Dinner'; 
}
// Prepare the SQL query
$stmt = $conn->prepare("SELECT * FROM recipes WHERE category = ? ORDER BY updated_at DESC");
$stmt->bind_param('s', $category);
$stmt->execute();
$result = $stmt->get_result();

// Fetch the results and store them in an array
$recipes = [];
while ($row = $result->fetch_assoc()) {
    $recipes[] = $row;
}

// Return the results as JSON
header('Content-Type: application/json');
echo json_encode($recipes);
?>
