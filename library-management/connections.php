<?php
// Set the time zone to Asia/Manila
date_default_timezone_set('Asia/Manila');


// Database configuration
$env_host = "localhost";
$env_dbname = "library-management";
$env_username = "root";
$env_password = "";


$env_protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
//for hosting
//remove the library-management/ or adjust base on folder name
$env_basepath = $env_protocol . '://' . $_SERVER['HTTP_HOST'] . '/library-management/';


try {
    // Create a PDO instance
    $pdo = new PDO("mysql:host=$env_host;dbname=$env_dbname;charset=utf8mb4", $env_username, $env_password);

    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Optionally, set other attributes as needed
    // $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // You can now use the $pdo variable to perform database operations
} catch (PDOException $e) {
    // Handle database connection errors
    echo "Connection failed: " . $e->getMessage();
}
