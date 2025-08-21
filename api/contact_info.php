<?php
require_once '../config/database.php';
header('Content-Type: application/json');
$conn = getConnection();

// GET (all or by id)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $stmt = $conn->prepare("SELECT * FROM contact_info WHERE id=?");
        $stmt->execute([$_GET['id']]);
        echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
    } else {
        $stmt = $conn->query("SELECT * FROM contact_info");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
    exit;
}

// POST (add, update, delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ลบข้อมูล
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $stmt = $conn->prepare("DELETE FROM contact_info WHERE id=?");
        $stmt->execute([$_POST['id']]);
        echo json_encode(['success' => true]);
        exit;
    }

    if (!empty($_POST['id'])) {
        $stmt = $conn->prepare("UPDATE contact_info SET phone_number=?, facebook_page=?, website=? WHERE id=?");
        $stmt->execute([
            $_POST['phone_number'],
            $_POST['facebook_page'],
            $_POST['website'],
            $_POST['id']
        ]);
    } else {
        $stmt = $conn->prepare("INSERT INTO contact_info (phone_number, facebook_page, website) VALUES (?, ?, ?)");
        $stmt->execute([
            $_POST['phone_number'],
            $_POST['facebook_page'],
            $_POST['website']
        ]);
    }
    echo json_encode(['success' => true]);
    exit;
}
?> 