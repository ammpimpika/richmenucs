<?php
function getConnection() {
    // ดึงค่าจาก Environment Variables
    $host = getenv('DB_HOST');  
    $dbname = getenv('DB_NAME'); 
    $username = getenv('DB_USER');   
    $password = getenv('DB_PASSWORD');       
    $port = getenv('DB_PORT');      

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