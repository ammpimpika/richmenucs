<?php
session_start();
require_once 'config/database.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $conn = getConnection();
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ? LIMIT 1");
    $stmt->execute([$username]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        header('Location: index.html');
        exit;
    } else {
        $error = 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง';
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>เข้าสู่ระบบผู้ดูแลระบบ</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
  <div class="w-full max-w-sm mx-auto bg-white rounded-xl shadow-md p-8 mt-10">
    <h1 class="text-2xl font-bold text-center mb-6">เข้าสู่ระบบผู้ดูแลระบบ</h1>
    <?php if ($error): ?>
      <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 text-center"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="post" class="space-y-4">
      <div>
        <label class="block mb-1">ชื่อผู้ใช้</label>
        <input type="text" name="username" class="w-full border rounded px-3 py-2" required autofocus>
      </div>
      <div>
        <label class="block mb-1">รหัสผ่าน</label>
        <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
      </div>
      <button type="submit" class="w-full py-2 rounded bg-blue-500 text-white font-semibold">เข้าสู่ระบบ</button>
    </form>
  </div>
</body>
</html> 