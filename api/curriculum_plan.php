<?php
require_once '../config/database.php';
header('Content-Type: application/json');
$conn = getConnection();

// ฟังก์ชันจัดการอัปโหลดไฟล์ curriculum
function handleCurriculumUpload($file) {
    $targetDir = __DIR__ . '/public/uploads/'; // เปลี่ยน path ให้ตรงกับ public/uploads
    if (!is_dir($targetDir)) @mkdir($targetDir, 0777, true);

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowedExt = ['jpg','jpeg','png','gif','webp'];
    if (!in_array($ext, $allowedExt)) return null;

    $filename = 'curriculum_' . uniqid() . '.' . $ext;
    $targetFile = $targetDir . $filename;

    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        // คืนค่า URL สำหรับ browser เรียกใช้งานได้
        return '/uploads/' . $filename;
    }
    return null;
}

// ================= GET =================
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $stmt = $conn->prepare("SELECT * FROM curriculum_plan WHERE id=?");
        $stmt->execute([$_GET['id']]);
        echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
    } else {
        $stmt = $conn->query("SELECT * FROM curriculum_plan");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
    exit;
}

// ================= POST =================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ลบข้อมูล
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $stmt = $conn->prepare("SELECT image_url FROM curriculum_plan WHERE id=?");
        $stmt->execute([$_POST['id']]);
        $img = $stmt->fetchColumn();
        $abs = __DIR__ . '/public' . $img;
        if ($img && file_exists($abs)) unlink($abs);

        $stmt = $conn->prepare("DELETE FROM curriculum_plan WHERE id=?");
        $stmt->execute([$_POST['id']]);
        echo json_encode(['success' => true]);
        exit;
    }

    // จัดการไฟล์ภาพ
    $image_url = null;
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === 0) {
        $image_url = handleCurriculumUpload($_FILES['image_file']);
    } else if (!empty($_POST['id'])) {
        // ใช้ของเดิมถ้าแก้ไขแต่ไม่ได้อัปโหลดใหม่
        $stmt = $conn->prepare("SELECT image_url FROM curriculum_plan WHERE id=?");
        $stmt->execute([$_POST['id']]);
        $image_url = $stmt->fetchColumn();
    }

    if (!empty($_POST['id'])) {
        // ลบไฟล์เดิมถ้ามีการอัปโหลดใหม่
        if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === 0) {
            $stmt = $conn->prepare("SELECT image_url FROM curriculum_plan WHERE id=?");
            $stmt->execute([$_POST['id']]);
            $old_img = $stmt->fetchColumn();
            $oldAbs = __DIR__ . '/public' . $old_img;
            if ($old_img && file_exists($oldAbs)) unlink($oldAbs);
        }
        $stmt = $conn->prepare("UPDATE curriculum_plan SET year_level=?, semester=?, image_url=? WHERE id=?");
        $stmt->execute([$_POST['year_level'], $_POST['semester'], $image_url, $_POST['id']]);
    } else {
        $stmt = $conn->prepare("INSERT INTO curriculum_plan (year_level, semester, image_url) VALUES (?, ?, ?)");
        $stmt->execute([$_POST['year_level'], $_POST['semester'], $image_url]);
    }

    echo json_encode(['success' => true, 'image_url' => $image_url]);
    exit;
}
?>
