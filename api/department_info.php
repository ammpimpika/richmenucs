<?php
require_once '../config/database.php';
header('Content-Type: application/json');
$conn = getConnection();

// GET (all or by id)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $stmt = $conn->prepare("SELECT * FROM department_info WHERE id=?");
        $stmt->execute([$_GET['id']]);
        echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
    } else {
        $stmt = $conn->query("SELECT * FROM department_info");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
    exit;
}

// POST (add, update, delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ลบข้อมูล
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $stmt = $conn->prepare("DELETE FROM department_info WHERE id=?");
        $stmt->execute([$_POST['id']]);
        echo json_encode(['success' => true]);
        exit;
    }

    if (!empty($_POST['id'])) {
        $stmt = $conn->prepare("UPDATE department_info SET degree_name=?, learning_support=? WHERE id=?");
        $stmt->execute([
            $_POST['degree_name'],
            $_POST['learning_support'],
            $_POST['id']
        ]);
    } else {
        $stmt = $conn->prepare("INSERT INTO department_info (degree_name, learning_support) VALUES (?, ?)");
        $stmt->execute([
            $_POST['degree_name'],
            $_POST['learning_support']
        ]);
    }
    echo json_encode(['success' => true]);
    exit;
}
?> 