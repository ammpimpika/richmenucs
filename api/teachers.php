<?php
require_once '../config/database.php';
header('Content-Type: application/json');
$conn = getConnection();

function uploadErrorMessage($code) {
    $map = [
        UPLOAD_ERR_INI_SIZE => 'ขนาดไฟล์เกินค่า upload_max_filesize',
        UPLOAD_ERR_FORM_SIZE => 'ขนาดไฟล์เกินค่า MAX_FILE_SIZE',
        UPLOAD_ERR_PARTIAL => 'อัปโหลดไฟล์ไม่สมบูรณ์',
        UPLOAD_ERR_NO_FILE => 'ไม่พบไฟล์ที่อัปโหลด',
        UPLOAD_ERR_NO_TMP_DIR => 'ไม่มีโฟลเดอร์ชั่วคราว',
        UPLOAD_ERR_CANT_WRITE => 'ไม่สามารถเขียนไฟล์ลงดิสก์ได้',
        UPLOAD_ERR_EXTENSION => 'การอัปโหลดถูกหยุดโดยส่วนขยาย',
    ];
    return $map[$code] ?? 'อัปโหลดไฟล์ล้มเหลว';
}
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
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
        $image_url = handleUpload($_FILES['image_file']);
        if ($image_url === null) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'ย้ายไฟล์ไม่สำเร็จ']);
            exit;
        }
    } else if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] !== UPLOAD_ERR_NO_FILE) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => uploadErrorMessage($_FILES['image_file']['error'])]);
        exit;
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