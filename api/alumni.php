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

    // เตรียมตัวแปรสำหรับชื่อไฟล์ภาพ และรับมือกับสภาพแวดล้อมโฮสต์ (เช่น Railway)
    $imageName = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $imageName = 'alumni_' . uniqid() . '.' . $ext;
        $targetDir = dirname(__DIR__) . '/uploads/';
        if (!is_dir($targetDir)) {
            @mkdir($targetDir, 0777, true);
        }
        $targetPath = $targetDir . $imageName;
        // ย้ายไฟล์อัปโหลดไปยังโฟลเดอร์ปลายทางแบบ absolute path
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'ย้ายไฟล์ไม่สำเร็จ']);
            exit;
        }
    } elseif (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => uploadErrorMessage($_FILES['image']['error'])]);
        exit;
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