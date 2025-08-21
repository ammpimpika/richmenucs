<?php
require_once '../config/database.php';
header('Content-Type: application/json');
$conn = getConnection();

// GET (all or by id)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $stmt = $conn->prepare("SELECT * FROM alumni WHERE id=?");
        $stmt->execute([$_GET['id']]);
        echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
    } else {
        $stmt = $conn->query("SELECT * FROM alumni");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
    exit;
}

// POST (add, update, delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ลบข้อมูล
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $stmt = $conn->prepare("DELETE FROM alumni WHERE id=?");
        $stmt->execute([$_POST['id']]);
        echo json_encode(['success' => true]);
        exit;
    }

    // เตรียมตัวแปรสำหรับชื่อไฟล์ภาพ
    $imageName = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $imageName = 'alumni_' . uniqid() . '.' . $ext;
        move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $imageName);
    }

    if (!empty($_POST['id'])) {
        // กรณีแก้ไข ถ้ามีอัปโหลดรูปใหม่ ให้ update image ด้วย
        if ($imageName) {
            $stmt = $conn->prepare("UPDATE alumni SET nickname=?, first_name=?, last_name=?, job_title=?, company=?, image=? WHERE id=?");
            $stmt->execute([
                $_POST['nickname'],
                $_POST['first_name'],
                $_POST['last_name'],
                $_POST['job_title'],
                $_POST['company'],
                $imageName,
                $_POST['id']
            ]);
        } else {
            $stmt = $conn->prepare("UPDATE alumni SET nickname=?, first_name=?, last_name=?, job_title=?, company=? WHERE id=?");
            $stmt->execute([
                $_POST['nickname'],
                $_POST['first_name'],
                $_POST['last_name'],
                $_POST['job_title'],
                $_POST['company'],
                $_POST['id']
            ]);
        }
    } else {
        $stmt = $conn->prepare("INSERT INTO alumni (nickname, first_name, last_name, job_title, company, image) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['nickname'],
            $_POST['first_name'],
            $_POST['last_name'],
            $_POST['job_title'],
            $_POST['company'],
            $imageName
        ]);
    }
    echo json_encode(['success' => true]);
    exit;
}
?> 