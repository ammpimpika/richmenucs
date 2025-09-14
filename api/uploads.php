<?php
// api/uploads.php?file=curriculum_6853c214504119.73991168.png
// รองรับทั้ง local development และ Railway deployment
$filename = basename($_GET['file']);

// ลองหาไฟล์ใน temporary directory ก่อน (สำหรับ Railway)
$file = sys_get_temp_dir() . '/uploads/' . $filename;

// ถ้าไม่เจอใน temp directory ให้ลองหาใน public/uploads (สำหรับ local development)
if (!file_exists($file)) {
    $file = __DIR__ . '/../public/uploads/' . $filename;
}

if (file_exists($file)) {
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    $mime = match($ext) {
        'jpg', 'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'webp' => 'image/webp',
        default => 'application/octet-stream',
    };
    header('Content-Type: ' . $mime);
    readfile($file);
    exit;
}
http_response_code(404);
echo 'File not found';
