<?php
session_start();
header('Content-Type: application/json');

require_once '../../config.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Email and password are required']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid email format']);
    exit;
}

try {
    // Check if company exists
    $stmt = $pdo->prepare("SELECT id, company_name, password FROM companies WHERE email = ?");
    $stmt->execute([$email]);
    $company = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$company || !password_verify($password, $company['password'])) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
        exit;
    }

    // Set session
    $_SESSION['company_id'] = $company['id'];
    $_SESSION['company_name'] = $company['company_name'];
    $_SESSION['email'] = $email;

    header("Location: /SwiftQ/Public/loader.html?to=/SwiftQ/Public/dashboard/company/company_dashboard.php");
    exit;

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
