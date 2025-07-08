<?php
$servername = "localhost";
$username = "root";
$password = "hsuhlainghtet347";
$database = "foodfusiondb";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
