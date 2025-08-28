<?php
header('Content-Type: application/json');

     $host = $_ENV['MYSQL_HOST'] ?? 'mysql.railway.internal';
    $dbname = $_ENV['MYSQL_DATABASE'] ?? 'railway';
    $username = $_ENV['MYSQL_USER'] ?? 'root';
    $password = $_ENV['MYSQL_PASSWORD'] ?? 'GdTryknnTzQyEyWGnmrWJMTkwjvvWCst';
    $port = $_ENV['MYSQL_PORT'] ?? '3306';

$conn = new mysqli($host, $user, $pass, $db, $port);
if ($conn->connect_error) {
    echo json_encode(['visits' => 0]);
    exit;
}

// ใช้พารามิเตอร์ page จาก URL ถ้ามี, ถ้าไม่มีใช้ "home"
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$today = date("Y-m-d");

// ตรวจสอบว่ามีข้อมูลของวันนี้แล้วหรือยัง
$sql = "SELECT * FROM visitors WHERE page_name='$page' AND visit_date='$today'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $conn->query("UPDATE visitors SET count = count + 1 WHERE page_name='$page' AND visit_date='$today'");
} else {
    $conn->query("INSERT INTO visitors (page_name, visit_date, count) VALUES ('$page', '$today', 1)");
}

// ดึงจำนวนผู้เข้าชมวันนี้
$res = $conn->query("SELECT count FROM visitors WHERE page_name='$page' AND visit_date='$today'");
$row = $res->fetch_assoc();
$countToday = $row['count'] ?? 0;

$conn->close();

// ส่ง JSON กลับ
echo json_encode(['visits' => $countToday]);
