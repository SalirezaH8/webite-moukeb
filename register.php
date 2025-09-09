<?php
session_start(); // شروع سشن باید اول باشه

// اتصال به پایگاه‌داده
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'mokeb_db';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
  die("خطا در اتصال: " . $conn->connect_error);
}

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $email = trim($_POST['email']);
  $password = $_POST['password'];
  $confirm = $_POST['confirm'];

  // اعتبارسنجی
  if (empty($username) || empty($email) || empty($password)) {
    $errors[] = "همه فیلدها را پر کنید.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "ایمیل معتبر نیست.";
  } elseif ($password !== $confirm) {
    $errors[] = "رمزها یکسان نیستند.";
  } else {
    // بررسی تکراری نبودن ایمیل
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
      $errors[] = "این ایمیل قبلاً ثبت شده.";
    } else {
      $hash = password_hash($password, PASSWORD_DEFAULT);
      // نقش پیش‌فرض user ثبت می‌شود
      $default_role = 'user';
      $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
      $stmt->bind_param("ssss", $username, $email, $hash, $default_role);
      if ($stmt->execute()) {
        $_SESSION['user_id'] = $conn->insert_id;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $default_role;

        $success = true;
      } else {
        $errors[] = "خطا در ثبت اطلاعات.";
      }
    }
    $stmt->close();
  }
}
?>

<!DOCTYPE html>
<html lang="fa">
<head>
  <meta charset="UTF-8">
  <title>ثبت‌نام</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body { font-family: sans-serif; background: #f5f5f5; direction: rtl; padding: 2rem; }
    form { max-width: 400px; margin: auto; background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 0 10px #aaa; }
    input { width: 100%; padding: 0.5rem; margin-bottom: 1rem; }
    button { padding: 0.5rem 1rem; background: #ffa726; border: none; cursor: pointer; }
    .error { color: red; margin-bottom: 1rem; }
    .success { color: green; margin-bottom: 1rem; }
  </style>
</head>
<body>

<h2 style="text-align:center;">ثبت‌نام</h2>

<?php if ($success): ?>
  <p class="success">ثبت‌نام با موفقیت انجام شد. در حال انتقال...</p>
  <script>
    // ارسال پیام به پنجره پدر (اگر داخل iframe باز شده)
    window.parent.postMessage("registered", "*");
  </script>
<?php else: ?>
  <?php foreach ($errors as $err): ?>
    <p class="error">• <?= htmlspecialchars($err) ?></p>
  <?php endforeach; ?>

  <form method="POST" action="">
    <input type="text" name="username" placeholder="نام کاربری" required value="<?= isset($username) ? htmlspecialchars($username) : '' ?>">
    <input type="email" name="email" placeholder="ایمیل" required value="<?= isset($email) ? htmlspecialchars($email) : '' ?>">
    <input type="password" name="password" placeholder="رمز عبور" required>
    <input type="password" name="confirm" placeholder="تکرار رمز عبور" required>
    <button type="submit">ثبت‌نام</button>
  </form>
<?php endif; ?>

</body>
</html>
