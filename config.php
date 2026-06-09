<?php
// Database Configuration
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'school_registration');

// Create connection
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to UTF-8
$conn->set_charset("utf8");

// Session configuration
session_start();

// Function to escape input
function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Function to validate admission number format
function validateAdmissionNumber($admNo) {
    return preg_match('/^[A-Z0-9]{6,10}$/', $admNo);
}

// Function to validate phone number
function validatePhone($phone) {
    return preg_match('/^[0-9]{10,15}$/', $phone);
}

// Function to validate email (optional)
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Redirect if not logged in (for admin pages)
function requireAdmin() {
    if (!isset($_SESSION['admin_id'])) {
        header("Location: login.php");
        exit();
    }
}
?>
