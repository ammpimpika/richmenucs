<?php
require_once '../config/database.php';
header('Content-Type: application/json');

try {
    $conn = getConnection();
    
    // ดึงรายการหน้าเว็บทั้งหมด
    $stmt = $conn->prepare("SELECT DISTINCT page_name FROM visitors ORDER BY page_name");
    $stmt->execute();
    $pages = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo json_encode(['pages' => $pages]);
    
} catch (Exception $e) {
    echo json_encode(['pages' => [], 'error' => $e->getMessage()]);
}
?>
