<?php
require_once '../config/database.php';
header('Content-Type: application/json');
@ini_set('upload_tmp_dir', sys_get_temp_dir());
@ini_set('post_max_size', '12M');
@ini_set('upload_max_filesize', '12M');
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
    $targetDir = dirname(__DIR__) . "/uploads/"; // absolute path for Railway
    if (!is_dir($targetDir)) @mkdir($targetDir, 0777, true);
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $filename = uniqid('activity_', true) . '.' . $ext;
    $targetFile = $targetDir . $filename;
    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        @chmod($targetFile, 0666);
        return 'uploads/' . $filename;
    }
    return null;
}

// GET (all or by id)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $stmt = $conn->prepare("SELECT * FROM department_activities WHERE id=?");
        $stmt->execute([$_GET['id']]);
        echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
    } else {
        $stmt = $conn->query("SELECT * FROM department_activities");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
    exit;
}

// POST (add, update, delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ลบข้อมูล
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        // ลบไฟล์ภาพเดิม
        $stmt = $conn->prepare("SELECT activity_image_url FROM department_activities WHERE id=?");
        $stmt->execute([$_POST['id']]);
        $img = $stmt->fetchColumn();
        $abs = dirname(__DIR__) . '/' . $img;
        if ($img && file_exists($abs)) unlink($abs);
        $stmt = $conn->prepare("DELETE FROM department_activities WHERE id=?");
        $stmt->execute([$_POST['id']]);
        echo json_encode(['success' => true]);
        exit;
    }

    $activity_image_url = null;
    if (isset($_FILES['activity_image_file']) && $_FILES['activity_image_file']['error'] === UPLOAD_ERR_OK) {
        $activity_image_url = handleUpload($_FILES['activity_image_file']);
        if ($activity_image_url === null) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'ย้ายไฟล์ไม่สำเร็จ']);
            exit;
        }
    } else if (isset($_FILES['activity_image_file']) && $_FILES['activity_image_file']['error'] !== UPLOAD_ERR_NO_FILE) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => uploadErrorMessage($_FILES['activity_image_file']['error'])]);
        exit;
    } else if (!empty($_POST['id'])) {
        // ถ้าแก้ไขแต่ไม่ได้อัปโหลดใหม่ ให้ใช้ของเดิม
        $stmt = $conn->prepare("SELECT activity_image_url FROM department_activities WHERE id=?");
        $stmt->execute([$_POST['id']]);
        $activity_image_url = $stmt->fetchColumn();
    }

    if (!empty($_POST['id'])) {
        // ลบไฟล์ภาพเดิมถ้ามีการอัปโหลดใหม่
        if (isset($_FILES['activity_image_file']) && $_FILES['activity_image_file']['error'] === 0) {
            $stmt = $conn->prepare("SELECT activity_image_url FROM department_activities WHERE id=?");
            $stmt->execute([$_POST['id']]);
            $old_img = $stmt->fetchColumn();
            $oldAbs = dirname(__DIR__) . '/' . $old_img;
            if ($old_img && file_exists($oldAbs)) unlink($oldAbs);
        }
        $stmt = $conn->prepare("UPDATE department_activities SET activity_name=?, activity_image_url=? WHERE id=?");
        $stmt->execute([$_POST['activity_name'], $activity_image_url, $_POST['id']]);
    } else {
        $stmt = $conn->prepare("INSERT INTO department_activities (activity_name, activity_image_url) VALUES (?, ?)");
        $stmt->execute([$_POST['activity_name'], $activity_image_url]);
    }
    echo json_encode(['success' => true]);
    exit;
}
?>