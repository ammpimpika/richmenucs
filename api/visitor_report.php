<?php
require_once '../config/database.php';
header('Content-Type: application/json');

try {
    $conn = getConnection();
    
    // รับพารามิเตอร์
    $date_from = isset($_GET['date_from']) ? $_GET['date_from'] : date('Y-m-d', strtotime('-7 days'));
    $date_to = isset($_GET['date_to']) ? $_GET['date_to'] : date('Y-m-d');
    $page_filter = isset($_GET['page']) ? $_GET['page'] : '';
    
    // สร้าง SQL query
    $sql = "SELECT page_name, visit_date, `count` FROM visitors WHERE visit_date BETWEEN ? AND ?";
    $params = [$date_from, $date_to];
    
    if ($page_filter) {
        $sql .= " AND page_name = ?";
        $params[] = $page_filter;
    }
    
    $sql .= " ORDER BY visit_date DESC, page_name";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $visitors = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // คำนวณสรุปข้อมูล
    $total_visits = array_sum(array_column($visitors, 'count'));
    $total_pages = count(array_unique(array_column($visitors, 'page_name')));
    $total_days = count(array_unique(array_column($visitors, 'visit_date')));
    $avg_visits = $total_days > 0 ? round($total_visits / $total_days, 2) : 0;
    
    // สรุปตามหน้าเว็บ
    $page_summary = [];
    foreach ($visitors as $visitor) {
        if (!isset($page_summary[$visitor['page_name']])) {
            $page_summary[$visitor['page_name']] = 0;
        }
        $page_summary[$visitor['page_name']] += $visitor['count'];
    }
    
    // เรียงตามจำนวนผู้เข้าชม
    arsort($page_summary);
    
    // แปลงเป็น array และคำนวณเปอร์เซ็นต์
    $page_summary_array = [];
    foreach ($page_summary as $page => $count) {
        $percentage = ($total_visits > 0) ? round(($count / $total_visits) * 100, 2) : 0;
        $page_summary_array[] = [
            'page_name' => $page,
            'total_count' => $count,
            'percentage' => $percentage
        ];
    }
    
    // ส่งข้อมูลกลับ
    echo json_encode([
        'visitors' => $visitors,
        'summary' => [
            'total_visits' => $total_visits,
            'total_pages' => $total_pages,
            'total_days' => $total_days,
            'avg_visits' => $avg_visits
        ],
        'page_summary' => $page_summary_array
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'visitors' => [],
        'summary' => [
            'total_visits' => 0,
            'total_pages' => 0,
            'total_days' => 0,
            'avg_visits' => 0
        ],
        'page_summary' => [],
        'error' => $e->getMessage()
    ]);
}
?>
