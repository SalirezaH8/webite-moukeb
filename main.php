<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fa">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>موکب ما</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Vazirmatn&display=swap');
    body {
      font-family: 'Vazirmatn', sans-serif;
      margin: 0;
      padding: 0;
      direction: rtl;
      background-color: #f8f8f8;
    }
    header {
      background-color: #222;
      color: white;
      padding: 1rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
    }
    .logo {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      text-decoration: none;
      color: white;
    }
    .logo img {
      width: 40px;
      height: 40px;
    }
    .login {
      background-color: #ffa726;
      padding: 0.5rem 1rem;
      border-radius: 5px;
      color: #222;
      text-decoration: none;
      transition: all 0.3s ease;
      cursor: pointer;
    }
    .login:hover {
      background-color: #ffb74d;
      transform: scale(1.05);
    }
    .menu-toggle {
      display: none;
      background-color: #333;
      color: white;
      padding: 1rem;
      text-align: center;
      cursor: pointer;
    }
    nav {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      background-color: #333;
    }
    nav a {
      color: white;
      padding: 1rem;
      text-decoration: none;
      transition: all 0.3s ease;
    }
    nav a:hover {
      background-color: #ffa726;
      transform: scale(1.1);
    }
    section {
      padding: 2rem;
      max-width: 900px;
      margin: auto;
    }
    .gallery {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
    }
    .gallery-item {
      width: 200px;
      aspect-ratio: 3 / 4;
      overflow: hidden;
      border-radius: 10px;
      background-color: #ddd;
      text-align: center;
      box-shadow: 0 0 8px rgba(0,0,0,0.2);
      position: relative;
      transition: all 0.3s ease;
    }
    .gallery-item img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
      transition: all 0.3s ease;
    }
    .gallery-item:hover {
      position: absolute;
      z-index: 10;
      width: auto;
      height: auto;
      aspect-ratio: unset;
      max-width: 90vw;
      max-height: 90vh;
    }
    .gallery-item:hover img {
      object-fit: contain;
      width: 100%;
      height: auto;
    }
    .caption {
      background-color: white;
      color: #333;
      font-size: 0.9rem;
      padding: 0.5rem;
      text-align: center;
    }
    form {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }
    input, textarea, button {
      padding: 0.5rem;
      font-size: 1rem;
      transition: all 0.3s ease;
    }
    button:hover {
      background-color: #ffa726;
      transform: scale(1.1);
      cursor: pointer;
    }
    footer {
      text-align: center;
      padding: 1rem;
      background-color: #222;
      color: white;
      margin-top: 2rem;
    }
    .modal {
      position: fixed;
      top: 0; right: 0; bottom: 0; left: 0;
      background: rgba(0,0,0,0.5);
      z-index: 999;
      display: none;
      justify-content: center;
      align-items: center;
    }
    .modal-content {
      background: #fff;
      border-radius: 8px;
      width: 400px;
      max-width: 90%;
      padding: 1rem;
      position: relative;
    }

    /* اسلایدر */
    .slider-container {
      position: relative;
      max-width: 800px;
      height: 400px;
      margin: 20px auto;
      overflow: hidden;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.25);
      background: #000;
      user-select: none;
    }

    .slide {
  position: absolute;
  top: 0; left: 0;
  width: 100%;
  height: 100%;
  opacity: 0;
  transition: opacity 1s ease;
  border-radius: 12px;
  object-fit: cover;
  z-index: 1;
  overflow: hidden;
}

.slide.active {
  opacity: 1;
  z-index: 2;
}
.slide img {
  width: 100%;
  height: 100%;
  object-fit: contain; /* عکس داخل قاب می‌نشیند و بزرگ یا کوچک می‌شود */
  border-radius: 12px;
  background-color: #000; /* برای فضای خالی اطراف عکس */
}

/* متن روی عکس */
.slide-caption {
  position: absolute;
  bottom: 20px;
  right: 20px; /* راست چین */
  left: 20px;  /* برای فاصله گرفتن از کناره‌ها */
  color: white;
  background: rgba(0,0,0,0.5);
  padding: 10px 15px;
  border-radius: 8px;
  font-size: 1.1rem;
  font-weight: 600;
  text-align: right;
  box-shadow: 0 0 8px rgba(0,0,0,0.7);
  user-select: none;
  max-height: 30%;
  overflow: auto;
  line-height: 1.3;
  pointer-events: none; /* جلوگیری از کلیک روی متن */
}


    .slider-controls {
      position: absolute;
      top: 50%;
      width: 100%;
      display: flex;
      justify-content: space-between;
      transform: translateY(-50%);
      padding: 0 15px;
      box-sizing: border-box;
      z-index: 10;
    }

    .slider-controls button {
      background: rgba(0,0,0,0.5);
      border: none;
      color: white;
      font-size: 2.5rem;
      padding: 0 14px;
      border-radius: 50%;
      cursor: pointer;
      transition: background-color 0.3s ease;
      user-select: none;
      box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }
    .slider-controls button:hover {
      background: #ffa726;
      color: #222;
    }

    @media (max-width: 768px) {
      .menu-toggle {
        display: block;
      }
      nav {
        display: none;
        flex-direction: column;
      }
      nav.active {
        display: flex;
      }
      nav a {
        flex: 1 1 100%;
        text-align: center;
      }
      header {
        flex-direction: column;
        gap: 1rem;
      }
      .slider-container {
        height: 250px;
      }
    }
  </style>
</head>
<body>

<header>
  <a href="index.php" class="logo">
    <img src="picture 3.jpg" alt="لوگو موکب" />
    <span>موکب ما</span>
  </a>
  <div style="display: flex; gap: 1rem;">
    <?php if (isset($_SESSION['username'])): ?>
      <span style="color: white;">سلام، <?= htmlspecialchars($_SESSION['username']) ?></span>
      <a href="logout.php" class="login">خروج</a>
    <?php else: ?>
      <a class="login" onclick="openLogin()">ورود</a>
      <a class="login" onclick="openRegister()">ثبت‌نام</a>
    <?php endif; ?>
  </div>
</header>

<div class="menu-toggle" onclick="toggleMenu()">☰ منو</div>
<nav id="main-nav">
  <a href="#about">درباره ما</a>
  <a href="#news">اطلاعیه‌ها</a>
  <a href="#services">خدمات</a>
  <a href="#gallery">گالری</a>
  <a href="#signup">ثبت‌نام</a>
  <a href="#contact">تماس با ما</a>
</nav>

<!-- اسلایدر -->
<!-- اسلایدر حرفه‌ای -->
<div class="slider-container">
  <div class="slides">
    <div class="slide active">
      <img src="picture1.jpg" alt="اسلاید ۱">
      <div class="slide-caption">متن اختصاصی برای اسلاید اول</div>
    </div>
    <div class="slide">
      <img src="picture2.jpg" alt="اسلاید ۲">
      <div class="slide-caption">متن اختصاصی برای اسلاید دوم</div>
    </div>
    <div class="slide">
      <img src="picture3.jpg" alt="اسلاید ۳">
      <div class="slide-caption">متن اختصاصی برای اسلاید سوم</div>
    </div>
  </div>
  <button class="prev" onclick="prevSlide()">‹</button>
  <button class="next" onclick="nextSlide()">›</button>
  <div class="dots">
    <span class="dot active" onclick="goSlide(0)"></span>
    <span class="dot" onclick="goSlide(1)"></span>
    <span class="dot" onclick="goSlide(2)"></span>
  </div>
</div>
<section id="latest-news">
  <h2>آخرین اخبار</h2>
  <div style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
    <?php
    // اتصال به پایگاه‌داده
    $conn = new mysqli("localhost", "root", "", "mokeb_db");
    $conn->set_charset("utf8mb4");

    // دریافت سه خبر آخر از جدول news
    $result = $conn->query("SELECT * FROM news ORDER BY created_at DESC LIMIT 3");

    while ($row = $result->fetch_assoc()) {
      echo '<div style="width:280px; background:white; border-radius:10px; box-shadow:0 0 8px rgba(0,0,0,0.1); overflow:hidden;">';
      echo '<img src="uploads/' . htmlspecialchars($row["image"]) . '" style="width:100%; height:180px; object-fit:cover;">';
      echo '<div style="padding:10px;">';
      echo '<h3 style="font-size:1.1rem; margin:0;">' . htmlspecialchars($row["title"]) . '</h3>';
      echo '<p style="font-size:0.9rem;">' . nl2br(htmlspecialchars(mb_substr($row["content"], 0, 100))) . '...</p>';
      echo '</div></div>';
    }

    $conn->close();
    ?>
  </div>
</section>



<section id="about">
  <h2>درباره ما</h2>
  <p>موکب ما با هدف خدمت به زائران اربعین تأسیس شده و تلاش می‌کند فضایی گرم و صمیمی برای زائران فراهم کند.</p>
</section>

<section id="news">
  <h2>اطلاعیه‌ها</h2>
  <ul>
    <li>ثبت‌نام خادمان آغاز شد.</li>
    <li>حرکت کاروان روز ۱۰ صفر انجام می‌شود.</li>
  </ul>
</section>

<section id="services">
  <h2>خدمات موکب</h2>
  <ul>
    <li>اسکان رایگان</li>
    <li>غذا و نوشیدنی</li>
    <li>خدمات پزشکی</li>
    <li>برنامه‌های فرهنگی و مذهبی</li>
  </ul>
</section>

<section id="gallery">
  <h2>گالری تصاویر</h2>
  <div class="gallery">
    <div class="gallery-item">
      <img src="picture1.jpg" alt="عکس موکب ۱" />
      <div class="caption">پذیرایی از زائران</div>
    </div>
    <div class="gallery-item">
      <img src="picture2.jpg" alt="عکس موکب ۲" />
      <div class="caption">پخت غذای نذری</div>
    </div>
    <div class="gallery-item">
      <img src="picture3.jpg" alt="عکس موکب ۳" />
      <div class="caption">ایستگاه سلامت</div>
    </div>
  </div>
</section>

<section id="signup">
  <h2>فرم ثبت‌نام</h2>
  <form>
    <input type="text" placeholder="نام و نام خانوادگی" />
    <input type="tel" placeholder="شماره تماس" />
    <input type="text" placeholder="شهر محل سکونت" />
    <textarea placeholder="نوع همکاری (مثلاً پخت غذا، پذیرایی و ...)"></textarea>
    <button type="submit">ارسال</button>
  </form>
</section>

<section id="contact">
  <h2>تماس با ما</h2>
  <p>شماره تماس: ۰۹۱۲۳۴۵۶۷۸۹</p>
  <p>آدرس موکب: مسیر نجف به کربلا - عمود ۱۰۵۰</p>
</section>

<footer>
  <p>&copy; 2025 موکب ما | طراحی با ❤️</p>
</footer>

<!-- مودال ورود -->
<div id="loginModal" class="modal">
  <div class="modal-content">
    <span onclick="closeModal()" style="float:left; cursor:pointer; font-size:1.5rem;">&times;</span>
    <iframe src="login.php" width="100%" height="400" frameborder="0"></iframe>
  </div>
</div>

<!-- مودال ثبت‌نام -->
<div id="registerModal" class="modal">
  <div class="modal-content">
    <span onclick="closeRegisterModal()" style="float:left; cursor:pointer; font-size:1.5rem;">&times;</span>
    <iframe src="register.php" width="100%" height="450" frameborder="0"></iframe>
  </div>
</div>

<script>
  function toggleMenu() {
    document.getElementById('main-nav').classList.toggle('active');
  }
  function openLogin() {
    document.getElementById('loginModal').style.display = 'flex';
  }
  function closeModal() {
    document.getElementById('loginModal').style.display = 'none';
  }
  function openRegister() {
    document.getElementById('registerModal').style.display = 'flex';
  }
  function closeRegisterModal() {
    document.getElementById('registerModal').style.display = 'none';
  }
  window.addEventListener("message", function(event) {
    if (event.data === "registered") {
      document.getElementById('registerModal').style.display = 'none';
      window.location.reload();
    }
  });

  let currentSlide = 0;
  const slides = document.querySelectorAll('.slide');

  function showSlide(index) {
    slides.forEach((slide, i) => {
      slide.classList.remove('active');
      if (i === index) slide.classList.add('active');
    });
  }

  function nextSlide() {
    currentSlide = (currentSlide + 1) % slides.length;
    showSlide(currentSlide);
  }

  function prevSlide() {
    currentSlide = (currentSlide - 1 + slides.length) % slides.length;
    showSlide(currentSlide);
  }

  // اسلاید خودکار هر 5 ثانیه
  setInterval(nextSlide, 5000);
</script>

</body>
</html>
