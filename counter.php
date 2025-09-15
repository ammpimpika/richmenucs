<?php
require_once 'config/database.php';
header('Content-Type: application/json');

try {
    $conn = getConnection();

    $page = isset($_GET['page']) ? $_GET['page'] : 'home';
    $today = date("Y-m-d");

    // ตรวจสอบว่ามีข้อมูลของวันนี้แล้วหรือยัง
    $stmt = $conn->prepare("SELECT `count` FROM visitors WHERE page_name = ? AND visit_date = ?");
    $stmt->execute([$page, $today]);
    $existing = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing) {
        // อัปเดทจำนวนผู้เข้าชม
        $stmt = $conn->prepare("UPDATE visitors SET `count` = `count` + 1 WHERE page_name = ? AND visit_date = ?");
        $stmt->execute([$page, $today]);
        $countToday = $existing['count'] + 1;
    } else {
        // เพิ่มข้อมูลใหม่
        $stmt = $conn->prepare("INSERT INTO visitors (page_name, visit_date, `count`) VALUES (?, ?, 1)");
        $stmt->execute([$page, $today]);
        $countToday = 1;
    }

    echo json_encode(['visits' => $countToday]);

} catch (Exception $e) {
    echo json_encode(['visits' => 0, 'error' => $e->getMessage()]);
}
