<?php
// ตั้งค่าการเชื่อมต่อฐานข้อมูลโดยดึงข้อมูลจาก Environment Variables ของ Railway
  $host = $_ENV['MYSQL_HOST'] ?? 'mysql.railway.internal';
    $dbname = $_ENV['MYSQL_DATABASE'] ?? 'railway';
    $username = $_ENV['MYSQL_USER'] ?? 'root';
    $password = $_ENV['MYSQL_PASSWORD'] ?? 'GdTryknnTzQyEyWGnmrWJMTkwjvvWCst';
    $port = $_ENV['MYSQL_PORT'] ?? '3306';

// ตรวจสอบว่าได้รับค่าจาก Environment Variables หรือไม่
if (!$host || !$user || !$pass || !$db || !$port) {
    die("Error: Database connection variables not set.");
}

// เชื่อมต่อฐานข้อมูล
$conn = new mysqli($host, $user, $pass, $db, $port);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    // ใน Production ควรเขียนโค้ดจัดการข้อผิดพลาดให้ดีกว่านี้
    die("Connection failed: " . $conn->connect_error);
}

// กำหนดโซนเวลาให้ถูกต้อง
date_default_timezone_set('Asia/Bangkok'); 

// รับค่าชื่อหน้าเว็บจาก URL โดยใช้ GET method
// และป้องกัน SQL Injection
$page_name = isset($_GET['page']) ? $conn->real_escape_string($_GET['page']) : 'default';

// กำหนดวันที่ปัจจุบัน
$today = date("Y-m-d");

// SQL query เพื่อตรวจสอบว่ามีข้อมูลสำหรับหน้านี้และวันนี้หรือไม่
$sql_check = "SELECT * FROM counter WHERE page_name = '$page_name' AND visit_date = '$today'";
$result = $conn->query($sql_check);

if ($result->num_rows > 0) {
    // ถ้ามีข้อมูลอยู่แล้ว ให้อัปเดตจำนวนผู้เข้าชม
    $sql_update = "UPDATE counter SET count = count + 1 WHERE page_name = '$page_name' AND visit_date = '$today'";
    $conn->query($sql_update);
} else {
    // ถ้ายังไม่มีข้อมูล ให้เพิ่มแถวใหม่
    $sql_insert = "INSERT INTO counter (page_name, visit_date, count) VALUES ('$page_name', '$today', 1)";
    $conn->query($sql_insert);
}

// ดึงยอดรวมผู้เข้าชมสำหรับหน้านี้มาแสดงผล
$sql_select = "SELECT SUM(count) AS page_visits FROM counter WHERE page_name = '$page_name'";
$result = $conn->query($sql_select);
$row = $result->fetch_assoc();

// แสดงผลในรูปแบบ JSON
header('Content-Type: application/json');
echo json_encode(['visits' => $row['page_visits']]);

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>