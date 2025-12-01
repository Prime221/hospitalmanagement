<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'hospital_management');

// Site Configuration
define('SITE_NAME', 'Unity Hospital');
define('SITE_URL', 'http://localhost/hospitalmanagement/');

// Admin Configuration
define('ADMIN_EMAIL', 'admin@unityhospital.com');
define('ADMIN_PASSWORD', 'admin123'); // Default admin password

// Session Configuration
session_start();

// Database Connection
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Alternative function for getting connection if needed
function getDBConnection() {
    global $pdo;
    return $pdo;
}

// Check if database exists
function databaseExists() {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST, DB_USERNAME, DB_PASSWORD);
        $stmt = $pdo->prepare("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?");
        $stmt->execute([DB_NAME]);
        return $stmt->rowCount() > 0;
    } catch(PDOException $e) {
        return false;
    }
}

// Utility Functions
function sanitize($input) {
    return htmlspecialchars(strip_tags(trim($input)));
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin';
}

function redirect($url) {
    header("Location: " . $url);
    exit();
}

function showMessage($message, $type = 'success') {
    $_SESSION['message'] = $message;
    $_SESSION['message_type'] = $type;
}

function displayMessage() {
    if (isset($_SESSION['message'])) {
        $type = $_SESSION['message_type'] ?? 'success';
        $message = $_SESSION['message'];
        unset($_SESSION['message'], $_SESSION['message_type']);
        
        $alertClass = $type === 'success' ? 'alert-success' : 'alert-danger';
        return "<div class='alert $alertClass alert-dismissible' role='alert'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    $message
                </div>";
    }
    return '';
}
?>
