<?php
require_once '../config/database.php';
header('Content-Type: application/json');
$conn = getConnection();

// GET (all or by id)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $stmt = $conn->prepare("SELECT * FROM careers WHERE id=?");
        $stmt->execute([$_GET['id']]);
        echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
    } else {
        $stmt = $conn->query("SELECT * FROM careers");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
    exit;
}

// POST (add, update, delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ลบข้อมูล
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $stmt = $conn->prepare("DELETE FROM careers WHERE id=?");
        $stmt->execute([$_POST['id']]);
        echo json_encode(['success' => true]);
        exit;
    }

    if (!empty($_POST['id'])) {
        $stmt = $conn->prepare("UPDATE careers SET job_title=?, starting_salary=?, highlight=? WHERE id=?");
        $stmt->execute([
            $_POST['job_title'],
            $_POST['starting_salary'],
            $_POST['highlight'],
            $_POST['id']
        ]);
    } else {
        $stmt = $conn->prepare("INSERT INTO careers (job_title, starting_salary, highlight) VALUES (?, ?, ?)");
        $stmt->execute([
            $_POST['job_title'],
            $_POST['starting_salary'],
            $_POST['highlight']
        ]);
    }
    echo json_encode(['success' => true]);
    exit;
}
?> 