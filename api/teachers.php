<?php
require_once '../config/database.php';
header('Content-Type: application/json');
$conn = getConnection();

function handleUpload($file) {
    $targetDir = dirname(__DIR__) . "/uploads/"; // use absolute path for Railway
    if (!is_dir($targetDir)) @mkdir($targetDir, 0777, true);
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $filename = uniqid('teacher_', true) . '.' . $ext;
    $targetFile = $targetDir . $filename;
    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        return 'uploads/' . $filename; // return relative public URL
    }
    return null;
}

// GET (all or by id)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $stmt = $conn->prepare("SELECT * FROM teachers WHERE id=?");
        $stmt->execute([$_GET['id']]);
        echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
    } else {
        $stmt = $conn->query("SELECT * FROM teachers");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
    exit;
}

// POST (add, update, delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ลบข้อมูล
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        // ลบไฟล์ภาพเดิม
        $stmt = $conn->prepare("SELECT image_url FROM teachers WHERE id=?");
        $stmt->execute([$_POST['id']]);
        $img = $stmt->fetchColumn();
        $abs = dirname(__DIR__) . '/' . $img;
        if ($img && file_exists($abs)) unlink($abs);
        $stmt = $conn->prepare("DELETE FROM teachers WHERE id=?");
        $stmt->execute([$_POST['id']]);
        echo json_encode(['success' => true]);
        exit;
    }

    $image_url = null;
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === 0) {
        $image_url = handleUpload($_FILES['image_file']);
    } else if (!empty($_POST['id'])) {
        // ถ้าแก้ไขแต่ไม่ได้อัปโหลดใหม่ ให้ใช้ของเดิม
        $stmt = $conn->prepare("SELECT image_url FROM teachers WHERE id=?");
        $stmt->execute([$_POST['id']]);
        $image_url = $stmt->fetchColumn();
    }

    if (!empty($_POST['id'])) {
        // ลบไฟล์ภาพเดิมถ้ามีการอัปโหลดใหม่
        if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === 0) {
            $stmt = $conn->prepare("SELECT image_url FROM teachers WHERE id=?");
            $stmt->execute([$_POST['id']]);
            $old_img = $stmt->fetchColumn();
            $oldAbs = dirname(__DIR__) . '/' . $old_img;
            if ($old_img && file_exists($oldAbs)) unlink($oldAbs);
        }
        $stmt = $conn->prepare("UPDATE teachers SET full_name=?, image_url=? WHERE id=?");
        $stmt->execute([$_POST['full_name'], $image_url, $_POST['id']]);
    } else {
        $stmt = $conn->prepare("INSERT INTO teachers (full_name, image_url) VALUES (?, ?)");
        $stmt->execute([$_POST['full_name'], $image_url]);
    }
    echo json_encode(['success' => true]);
    exit;
}
?> 