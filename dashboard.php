<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
  <div class="bg-white rounded-xl shadow-md p-8 w-full max-w-md text-center">
    <h1 class="text-2xl font-bold mb-6">ยินดีต้อนรับแอดมิน</h1>
    <a href="logout.php" class="inline-block px-6 py-2 rounded bg-red-500 text-white font-semibold hover:bg-red-600 transition">ออกจากระบบ</a>
  </div>
</body>
</html> 