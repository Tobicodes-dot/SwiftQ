<?php
session_start();
include_once '../../config.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit("Method not allowed");
}

//Collect and sanitize input data

$companyName   = trim($_POST['company_name'] ?? '');
$industry      = trim($_POST['industry'] ?? '');
$region        = trim($_POST['company_region'] ?? '');
$email         = trim($_POST['email'] ?? '');
$password      = $_POST['password'] ?? '';

// Basic validation

if (
    empty($companyName) || 
    empty($industry) || 
    empty($region) ||
    empty($email) || 
    empty($password)
) {
    http_response_code(400);
    exit("All fields are required");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    exit("Invalid email format");
}

//upload company logo

if (!isset($_FILES['company_logo'])) {
    exit("No file received");
}

$logo = $_FILES['company_logo'];

if ($logo['error'] !== UPLOAD_ERR_OK) {
    exit("Upload error code: " . $logo['error']);
}

$uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/SwiftQ/Public/uploads/company_logos/";

if (!is_dir($uploadDir)) {
    exit("Upload directory missing: " . $uploadDir);
}

if (!is_writable($uploadDir)) {
    exit("Upload directory not writable");
}

$logoName = uniqid("logo_") . "_" . basename($logo['name']);
$destination = $uploadDir . $logoName;

if (!move_uploaded_file($logo['tmp_name'], $destination)) {
    exit("Failed to save uploaded logo");
}



//password hashing
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

//Database transaction

try {
    // check if email already exists
    $check = $pdo->prepare("SELECT id FROM companies WHERE email = ?");
    $check->execute([$email]);

    if ($check->rowCount() > 0) {
        exit("Email already exists");
    }

    $stmt = $pdo->prepare("
        INSERT INTO companies 
        (company_name, industry, logo, company_region, email, password, Joined_at)
        VALUES (?, ?, ?, ?, ?, ?, NOW())
    ");

    $stmt->execute([
        $companyName,
        $industry,
        $logoName,
        $region,
        $email,
        $hashedPassword
    ]);

    // success
    header("Location: ../../../Public/dashboard/");
    exit;

} catch (PDOException $e) {
    exit("Registration failed: " . $e->getMessage());
}

?>