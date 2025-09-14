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

// ค้นหาไฟล์ในหลายตำแหน่ง
$searchPaths = [
    // 1. Temp directory (Railway)
    sys_get_temp_dir() . '/uploads/' . $filename,
    // 2. Public uploads (local development)
    __DIR__ . '/../public/uploads/' . $filename,
    // 3. Root uploads (Railway fallback)
    __DIR__ . '/../uploads/' . $filename,
    // 4. Current directory (Railway fallback)
    __DIR__ . '/' . $filename,
    // 5. Root directory (Railway fallback)
    __DIR__ . '/../' . $filename
];

$file = null;
foreach ($searchPaths as $path) {
    if (file_exists($path)) {
        $file = $path;
        break;
    }
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

// ถ้าไม่เจอไฟล์ ให้ลองหาไฟล์ dress อื่นที่มีอยู่
$tempDir = sys_get_temp_dir() . '/uploads/';
$fallbackFile = null;

if (is_dir($tempDir)) {
    $files = scandir($tempDir);
    foreach($files as $file) {
        if ($file != '.' && $file != '..' && strpos($file, 'dress_') === 0) {
            $fallbackFile = $file;
            break;
        }
    }
}

if ($fallbackFile && file_exists($tempDir . $fallbackFile)) {
    // แสดงไฟล์ fallback
    $ext = strtolower(pathinfo($fallbackFile, PATHINFO_EXTENSION));
    $mime = match($ext) {
        'jpg', 'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'webp' => 'image/webp',
        default => 'application/octet-stream',
    };
    header('Content-Type: ' . $mime);
    header('Cache-Control: public, max-age=3600');
    readfile($tempDir . $fallbackFile);
    exit;
}

// ถ้าไม่เจอไฟล์ใดๆ ให้แสดง placeholder image
http_response_code(404);
header('Content-Type: image/svg+xml');
echo '<?xml version="1.0" encoding="UTF-8"?>
<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg">
  <rect width="100" height="100" fill="#f3f4f6"/>
  <text x="50" y="50" text-anchor="middle" dy=".3em" font-family="Arial, sans-serif" font-size="12" fill="#6b7280">No Image</text>
</svg>';
