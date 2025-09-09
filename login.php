<?php
session_start();
if (isset($_SESSION['user_id'])) {
  header("Location: main.php");
  exit;
}

// اتصال به دیتابیس
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'mokeb_db';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
  die("خطا در اتصال: " . $conn->connect_error);
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email']);
  $password = $_POST['password'];

  if (empty($email) || empty($password)) {
    $errors[] = "لطفاً ایمیل و رمز عبور را وارد کنید.";
  } else {
    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
      $stmt->bind_result($id, $username, $hashed_password, $role);
      $stmt->fetch();

      if (password_verify($password, $hashed_password)) {
        // ذخیره اطلاعات کاربر در نشست (سشن)
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;

        // ریدایرکت به صفحه اصلی و بستن پاپ‌آپ اگر داخل iframe باز شده
        echo "<script>
          if (window.top !== window.self) {
            window.top.location.href = 'main.php';
          } else {
            window.location.href = 'main.php';
          }
        </script>";
        exit;
      } else {
        $errors[] = "رمز عبور اشتباه است.";
      }
    } else {
      $errors[] = "ایمیلی با این مشخصات وجود ندارد لطفا ابتدا ثبت نام کنید.";
    }
    $stmt->close();
  }
}
?>
<!DOCTYPE html>
<html lang="fa">
<head>
  <meta charset="UTF-8">
  <title>ورود</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body { font-family: sans-serif; background: #f5f5f5; direction: rtl; padding: 2rem; }
    form { max-width: 400px; margin: auto; background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 0 10px #aaa; }
    input { width: 100%; padding: 0.5rem; margin-bottom: 1rem; }
    button { padding: 0.5rem 1rem; background: #ffa726; border: none; cursor: pointer; }
    .error { color: red; margin-bottom: 1rem; }
  </style>
</head>
<body>

<h2 style="text-align:center;">ورود</h2>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  foreach ($errors as $err) {
    echo "<p class='error'>• $err</p>";
  }
}
?>

<form method="POST" action="">
  <input type="email" name="email" placeholder="ایمیل" required>
  <input type="password" name="password" placeholder="رمز عبور" required>
  <button type="submit">ورود</button>
</form>

</body>
</html>
