<?php
// api/uploads.php?file=curriculum_6853c214504119.73991168.png
$file = __DIR__ . '/../public/uploads/' . basename($_GET['file']);
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
