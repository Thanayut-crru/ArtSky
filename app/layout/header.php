<header id="header" class="header d-flex align-items-center fixed-top">
  <div class="container-fluid d-flex align-items-center justify-content-between">

    <a href="index" class="logo d-flex align-items-center  me-auto me-lg-0">
      <!-- Uncomment the line below if you also wish to use an image logo -->
      <!-- <img src="assets/img/logo.png" alt=""> -->
      <i class="bi bi-moon-stars"></i>
      <h1>ART SKY</h1>
    </a>

    <?php
    $curPageName = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);
    $index = '';
    if ($curPageName == 'index.php') {
      $index = 'class="active"';
    }
    $about = '';
    if ($curPageName == 'about.php') {
      $about = 'class="active"';
    }
    $contact = '';
    if ($curPageName == 'contact.php') {
      $contact = 'class="active"';
    }
    $hotel = '';
    if ($curPageName == 'hotel.php') {
      $hotel = 'class="active"';
    }
    $blog = '';
    if ($curPageName == 'blog.php') {
      $blog = 'class="active"';
    }
    $vilsualsky = '';
    if ($curPageName == 'vilsualsky.php') {
      $vilsualsky = 'class="active"';
    }
    $login = '';
    if ($curPageName == 'login.php') {
      $login = 'active';
    }
    $carrent = '';
    if ($curPageName == 'carrent.php') {
      $carrent = 'class="active"';
    }
    $carrent_login = '';
    if ($curPageName == 'carrent-login.php') {
      $carrent_login = 'active';
    }

    $news = '';
    if ($curPageName == 'news.php') {
      $news = 'active';
    }
    ?>
    <nav id="navbar" class="navbar">
      <ul>
        <li><a href="index" <?= $index ?>>หน้าหลัก</a></li>
        <li><a href="about" <?= $about ?>>เกี่ยวกับ</a></li>
        <li><a href="hotel" <?= $hotel ?>>โรงแรม & ที่พัก</a></li>
        <li><a href="carrent" <?= $carrent ?>>เช่ารถ</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?= $login ?> <?= $carrent_login ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            สำหรับผู้ประกอบการ
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item <?= $login ?>" href="login">ผู้ประกอบการโรงแรม & ที่พัก</a></li>
            <li><a class="dropdown-item <?= $carrent_login ?>" href="carrent-login">ผู้ประกอบการรถเช่า</a></li>
          </ul>
        </li>
        <li><a href="vilsualsky" <?= $vilsualsky ?>>VirtualSky</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?= $login ?> <?= $carrent_login ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            ข่าวสาร
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item <?= $news ?>" href="news">ข่าวสาร</a></li>
            <li><a class="dropdown-item <?= $blog ?>" href="blog">บทความ</a></li>
          </ul>
        </li>
        <li><a href="contact" <?= $contact ?>>ติดต่อเรา</a></li>
      </ul>
    </nav><!-- .navbar -->

    <div class="header-social-links">
      <!-- <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
        <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></i></a> -->
    </div>
    <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
    <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
  </div>
</header>