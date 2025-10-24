<?php
// Database connection configuration

// Detect environment automatically
if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) {
    // Local development
    $servername = "localhost";
    $username   = "root";
    $password   = "";
    $database   = "anu_hospitality_staff";
} else {
    // Production (Hostinger)
    $servername = "localhost"; // Hostinger uses localhost for MySQL
    $username   = "your_hostinger_db_username";
    $password   = "your_hostinger_db_password";
    $database   = "your_hostinger_db_name";
}

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    error_log("Database connection failed: " . $conn->connect_error);
    die(json_encode([
        'status' => 'error',
        'message' => 'Database connection failed. Please try again later.'
    ]));
}

// Optional: set charset to utf8mb4 for better encoding support
$conn->set_charset("utf8mb4");
?>
