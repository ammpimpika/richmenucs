<?php
require_once 'config/database.php';

try {
    $conn = getConnection();
    
    // ข้อมูลหน้าต่างๆ ที่ต้องการเพิ่ม
    $pages = [
        'contact',
        'tuition', 
        'dresscode',
        'department',
        'career-path',
        'curriculum',
        'alumni',
        'teachers',
        'index'
    ];
    
    $today = date("Y-m-d");
    
    echo "<h2>เพิ่มข้อมูลหน้าเว็บลงในตาราง visitors</h2>";
    echo "<p>วันที่: " . $today . "</p>";
    echo "<ul>";
    
    foreach ($pages as $page) {
        // ตรวจสอบว่ามีข้อมูลแล้วหรือไม่
        $stmt = $conn->prepare("SELECT id FROM visitors WHERE page_name = ? AND visit_date = ?");
        $stmt->execute([$page, $today]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$existing) {
            // เพิ่มข้อมูลใหม่
            $stmt = $conn->prepare("INSERT INTO visitors (page_name, visit_date, `count`) VALUES (?, ?, 0)");
            $stmt->execute([$page, $today]);
            echo "<li>✅ เพิ่มหน้า '$page' สำเร็จ</li>";
        } else {
            echo "<li>⚠️ หน้า '$page' มีข้อมูลอยู่แล้ว</li>";
        }
    }
    
    echo "</ul>";
    
    // แสดงข้อมูลทั้งหมดในตาราง
    echo "<h3>ข้อมูลทั้งหมดในตาราง visitors:</h3>";
    $stmt = $conn->prepare("SELECT * FROM visitors ORDER BY page_name, visit_date DESC");
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>ID</th><th>Page Name</th><th>Visit Date</th><th>Count</th></tr>";
    
    foreach ($results as $row) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['page_name'] . "</td>";
        echo "<td>" . $row['visit_date'] . "</td>";
        echo "<td>" . $row['count'] . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>เกิดข้อผิดพลาด: " . $e->getMessage() . "</p>";
}
?>
