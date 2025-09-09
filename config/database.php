<?php
function getConnection() {
    // ดึงค่าจาก Environment Variables ของ Railway
    $host = $_ENV['MYSQL_HOST'] ?? 'mysql.railway.internal';
    $dbname = $_ENV['MYSQL_DATABASE'] ?? 'railway';
    $username = $_ENV['MYSQL_USER'] ?? 'root';
    $password = $_ENV['MYSQL_PASSWORD'] ?? 'eWWnwknGFgttggaFdzTUvIfcoEAMTKSn';
    $port = $_ENV['MYSQL_PORT'] ?? '3306';

    try {
        $pdo = new PDO(
            "mysql:host=$host;dbname=$dbname;port=$port;charset=utf8", 
            $username, 
            $password
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        // ใน Production ควร log ข้อความ error แทนที่จะแสดงให้ผู้ใช้เห็น
        die('Database connection failed: ' . $e->getMessage());
    }
}
?>