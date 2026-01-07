<?php

if (!isset($_POST['filename'])) {
    http_response_code(400);
    echo "No filename provided";
    exit;
}

$file_path = '../../../Public/uploads/company_logos/' . basename($_POST['filename']);

if (file_exists($file_path)) {
    // Make file writable if it isn't already
    if (!is_writable($file_path)) {
        chmod($file_path, 0777);
    }
    
    // Try to delete the file
    if (unlink($file_path)) {
        // Also delete from database if it exists
        try {
            require_once '../../config.php';
            $stmt = $pdo->prepare("DELETE FROM companies WHERE logo_path = :logo_path");
            $stmt->bindParam(':logo_path', $file_path);
            $stmt->execute();
        } catch (PDOException $e) {
            // Log error but still confirm file deletion
        }
        
        http_response_code(200);
        echo "Deleted successfully";
    } else {
        http_response_code(500);
        $error = error_get_last()['message'] ?? 'Unknown error';
        echo "Delete failed: " . $error;
    }
} else {
    http_response_code(404);
    echo "File not found";
}
?>
