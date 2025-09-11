<?php
// show_image.php

// ตรวจสอบว่ามี query param file หรือไม่
if (!isset($_GET['file'])) {
    http_response_code(400);
    echo 'No file specified';
    exit;
}

$file = basename($_GET['file']); // ป้องกัน path traversal

// ✅ ตรวจสอบนามสกุลไฟล์
$allowed = ['jpg','jpeg','png','gif','webp'];
$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
if (!in_array($ext, $allowed)) {
    http_response_code(403);
    echo 'Forbidden file type';
    exit;
}

// path จริงของไฟล์
$path = dirname(__DIR__) . '/uploads/' . $file;

if (!file_exists($path)) {
    http_response_code(404);
    echo 'File not found';
    exit;
}

// ส่ง header ให้ browser รู้ว่าเป็นรูปภาพ
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $path);
finfo_close($finfo);

header('Content-Type: ' . $mime);
header('Content-Length: ' . filesize($path));
readfile($path);
exit;
