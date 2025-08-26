<?php
// ✅ ตั้งค่าการเชื่อมต่อฐานข้อมูลโดยดึงข้อมูลจาก Environment Variables ของ Railway
$host     = $_ENV['MYSQL_HOST']     ?? 'mysql.railway.internal';
$dbname   = $_ENV['MYSQL_DATABASE'] ?? 'railway';
$username = $_ENV['MYSQL_USER']     ?? 'root';
$password = $_ENV['MYSQL_PASSWORD'] ?? '';
$port     = $_ENV['MYSQL_PORT']     ?? '3306';

// ✅ ตรวจสอบว่าได้รับค่าจาก Environment Variables ครบหรือไม่
if (!$host || !$username || !$password || !$dbname || !$port) {
    die("Error: Database connection variables not set.");
}

// ✅ เชื่อมต่อฐานข้อมูล
$conn = new mysqli($host, $username, $password, $dbname, $port);

// ✅ ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ✅ กำหนดโซนเวลา
date_default_timezone_set('Asia/Bangkok'); 

// ✅ รับค่าชื่อหน้าเว็บจาก URL
$page_name = isset($_GET['page']) ? $conn->real_escape_string($_GET['page']) : 'default';

// ✅ กำหนดวันที่ปัจจุบัน
$today = date("Y-m-d");

// ✅ ตรวจสอบว่ามีข้อมูลสำหรับหน้านี้และวันนี้หรือไม่
$sql_check = "SELECT * FROM counter WHERE page_name = '$page_name' AND visit_date = '$today'";
$result = $conn->query($sql_check);

if ($result->num_rows > 0) {
    // ถ้ามีข้อมูลแล้ว ให้อัปเดตจำนวน
    $sql_update = "UPDATE counter SET count = count + 1 WHERE page_name = '$page_name' AND visit_date = '$today'";
    $conn->query($sql_update);
} else {
    // ถ้ายังไม่มี ให้เพิ่มใหม่
    $sql_insert = "INSERT INTO counter (page_name, visit_date, count) VALUES ('$page_name', '$today', 1)";
    $conn->query($sql_insert);
}

// ✅ ดึงยอดรวมผู้เข้าชมของหน้านี้
$sql_select = "SELECT SUM(count) AS page_visits FROM counter WHERE page_name = '$page_name'";
$result = $conn->query($sql_select);
$row = $result->fetch_assoc();

// ✅ ส่งออกเป็น JSON
header('Content-Type: application/json');
echo json_encode(['visits' => (int)$row['page_visits']]);

// ✅ ปิดการเชื่อมต่อ
$conn->close();
?>
