<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ./auth/login.php");
    exit();
}
include('../view/db.php'); // Make sure the database connection is correct

// Check the 'export_type' query parameter to determine which table to export
$exportType = isset($_GET['export_type']) ? $_GET['export_type'] : 'users';

// Define the file name and headers based on export type
switch ($exportType) {
    case 'request_recipe':
        $filename = 'request_recipe_export.csv';
        $headers = ['ID', 'Name', 'Email', 'Message', 'Created At'];
        $query = "SELECT id, name, email, message, created_at 
                    FROM contacts 
                    WHERE subject = 'Recipe Request'
                    ORDER BY created_at ASC";
        break;

    case 'reports':
        $filename = 'reports_export.csv';
        $headers = ['ID', 'Name', 'Email', 'Message' , 'Created At'];
        $query = " SELECT id, name, email, message, created_at 
    FROM contacts 
    WHERE subject = 'General Inquiry'
    ORDER BY created_at ASC";
        break;

    case 'events':
        $filename = 'events_export.csv';
        $headers = ['ID', 'Event Type', 'Title', 'Status'];
        $query = "SELECT cc.*, cs.section_name 
    FROM content_cards cc
    JOIN content_sections cs ON cc.section_id = cs.section_id
    WHERE cc.section_id = ?
    ORDER BY cc.created_at ASC ";
        break;

    case 'recipes':
        $filename = 'recipes_export.csv';
        $headers = ['ID', 'Name', 'Category', 'Cuisine Name', 'Difficutly Level', 'Created At', 'Update At', 'Author'];
        $query = "SELECT r.id, r.title, r.category, r.cuisine_name, r.difficulty_level, r.created_at, r.updated_at, u.name AS author 
    FROM recipes r
    JOIN users u ON r.user_id = u.user_id
    ORDER BY created_at ASC";
        break;

    case 'Members':
        $filename = 'members_export.csv';
        $headers = ['ID', 'Name', 'Title', 'Description', 'Skills', 'Created At'];
        $query = "SELECT id, name, title, description,  skills, created_at 
    FROM team_members 
    ORDER BY created_at ASC";
        break;

    case 'subscribers':
        $filename = 'subscribers_export.csv';
        $headers = ['ID', 'Email', 'Created At'];
        $query = "SELECT id, email, created_at 
        FROM subscribers 
        ORDER BY created_at ASC";
        break;

    case 'feedbacks':
        $filename = 'feedbacks_export.csv';
        $headers = ['Feedback ID', 'Name', 'Email', 'Message', 'Created At'];
        $query = "SELECT id, name, email, message, created_at 
                    FROM contacts 
                    WHERE subject = 'Feedback'
                    ORDER BY created_at ASC";
        break;

    case 'users':
        $filename = 'users_export.csv';
        $headers = ['ID', 'Name', 'Email', 'Created At', 'Updated At'];
        $query = "SELECT user_id, name, email, created_at, updated_at FROM users ORDER BY created_at ASC";
        break;


        break;
}

// Prepare and execute query
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

// Output CSV headers
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=' . $filename);

// Open the output stream
$output = fopen('php://output', 'w');

// Output the headers as the first row in the CSV
fputcsv($output, $headers);

// Fetch and output the data
while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

// Close the output stream
fclose($output);
exit;
