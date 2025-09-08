<?php
function getConnection() {
    $host = getenv('MYSQL_HOST');       // maglev.proxy.rlwy.net
    $dbname = getenv('MYSQL_DATABASE'); // railway
    $username = getenv('MYSQL_USER');   // root
    $password = getenv('MYSQL_PASSWORD'); // รหัสจาก Railway
    $port = getenv('MYSQL_PORT');       // 33210

    try {
        $pdo = new PDO(
            "mysql:host=$host;dbname=$dbname;port=$port;charset=utf8",
            $username,
            $password
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die('Database connection failed: ' . $e->getMessage());
    }
}
?>
