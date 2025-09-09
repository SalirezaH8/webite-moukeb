<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="fa">
<head>
  <meta charset="UTF-8">
  <title>داشبورد</title>
  <style>
    body { font-family: sans-serif; direction: rtl; padding: 2rem; background-color: #eef; }
  </style>
</head>
<body>
  <h2>خوش آمدی <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
  <p>شما وارد شده‌اید.</p>
  <a href="logout.php">خروج</a>
</body>
</html>
