<?php
function getConnection() {
    $host = 'localhost';  
    $dbname = 'chatbotcomsci'; 
    $username = 'root';   
    $password = '';       
    $port = '3306';      

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