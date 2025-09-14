<?php
// api/uploads.php?file=curriculum_6853c214504119.73991168.png
// รองรับทั้ง local development และ Railway deployment
$filename = basename($_GET['file']);

// ตรวจสอบว่า filename ไม่ว่าง
if (empty($filename)) {
    http_response_code(400);
    echo 'Invalid filename';
    exit;
}

// ลองหาไฟล์ใน temporary directory ก่อน (สำหรับ Railway)
$file = sys_get_temp_dir() . '/uploads/' . $filename;

// ถ้าไม่เจอใน temp directory ให้ลองหาใน public/uploads (สำหรับ local development)
if (!file_exists($file)) {
    $file = __DIR__ . '/../public/uploads/' . $filename;
}

// ถ้ายังไม่เจอ ให้ลองหาใน root directory (สำหรับ Railway)
if (!file_exists($file)) {
    $file = __DIR__ . '/../' . $filename;
}

// ถ้ายังไม่เจอ ให้ลองหาใน uploads directory ที่ root
if (!file_exists($file)) {
    $file = __DIR__ . '/../uploads/' . $filename;
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
    header('Cache-Control: public, max-age=3600'); // Cache for 1 hour
    readfile($file);
    exit;
}

// ถ้าไม่เจอไฟล์ ให้แสดง placeholder image
http_response_code(404);
header('Content-Type: image/svg+xml');
echo '<?xml version="1.0" encoding="UTF-8"?>
<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg">
  <rect width="100" height="100" fill="#f3f4f6"/>
  <text x="50" y="50" text-anchor="middle" dy=".3em" font-family="Arial, sans-serif" font-size="12" fill="#6b7280">No Image</text>
</svg>';
