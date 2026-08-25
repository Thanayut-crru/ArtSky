<?php
require './config/connect.php';
require './config/function.php';
if (isset($_GET['id'])) {
  $sql_blog = " SELECT * FROM tbl_blog WHERE blog_id = {$_GET['id']} ";
  $result_blog = mysqli_query($conn, $sql_blog);
  $no_blog = mysqli_num_rows($result_blog);
  if ($no_blog === 0) {
    header("location:index");
  }
  $rs_blog = mysqli_fetch_assoc($result_blog);
} else {
  header("location:index");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>ART SKY</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link rel="apple-touch-icon" sizes="180x180" href="./images/favicon_io/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="./images/favicon_io/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="./images/favicon_io/favicon-16x16.png">
  <link rel="manifest" href="./images/favicon_io/site.webmanifest">
  <link rel="mask-icon" href="./images/favicon_io/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/main2.css" rel="stylesheet">
  <link rel="stylesheet" href="./app/node_modules/swiper/swiper-bundle.min.css" />
  <link rel="stylesheet" type="text/css" href="./assets/vendor/slick/slick.css" />
  <link rel="stylesheet" type="text/css" href="./assets/vendor/slick/slick-theme.css" />

  <style>
    body {
      background: url("./images/head_bg.jpg") no-repeat top center fixed;
      background-size: cover;
      min-height: 100vh;
      position: relative;
      color: #f8fafc;
    }

    /* overlay มืดๆ ให้ตัวหนังสืออ่านง่ายขึ้น */
    /* body::before {
      content: "";
      position: fixed;
      inset: 0;
      background: radial-gradient(circle at top, rgba(15, 23, 42, 0.2), transparent 50%),
        linear-gradient(to bottom right, rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.95));
      z-index: -1;
    } */

    .fkanit {
      font-family: "Noto Serif Thai", serif;
      font-weight: 400;
      font-style: normal;
    }

    .color-sky {
      color: rgba(255, 255, 255, 0.7);
    }

    #header {
      background: transparent;
      border-bottom: none;
    }

    .bg-skys {
      /* background: rgba(15, 23, 42, 0.6); */
      backdrop-filter: blur(18px);
      -webkit-backdrop-filter: blur(18px);
      border-radius: 18px;
      border: 1px solid rgba(148, 163, 184, 0.25);
      box-shadow: 0 18px 45px rgba(15, 23, 42, 0.0);
    }

    .page-wrapper {
      padding-top: 7rem;
      padding-bottom: 4rem;
    }

    .blog-hero-title {
      font-size: clamp(1.5rem, 2.5vw, 1.8rem);
      font-weight: 700;
      letter-spacing: 0.03em;
      color: #e5f4ff;
    }

    .blog-meta {
      font-size: 0.95rem;
      color: rgba(226, 232, 240, 0.85);
    }

    .blog-meta i {
      margin-right: 0.25rem;
    }

    .blog-cover {
      border-radius: 18px;
      overflow: hidden;
      box-shadow: 0 18px 45px rgba(15, 23, 42, 0.9);
      border: 1px solid rgba(148, 163, 184, 0.35);
    }

    .blog-cover img {
      width: 100%;
      height: 100%;
      display: block;
      object-fit: cover;
      aspect-ratio: 16 / 9;
      transform: scale(1.01);
      transition: transform 0.6s ease;
    }

    .blog-cover:hover img {
      transform: scale(1.04);
    }

    #content-blog {
      font-size: 1rem;
      line-height: 1.9;
      color: #e2e8f0;
    }

    #content-blog p,
    #content-blog span,
    #content-blog ul,
    #content-blog ul li,
    #content-blog ol,
    #content-blog ol li {
      color: #e2e8f0;
    }

    #content-blog a {
      color: #38bdf8;
      text-decoration: underline;
      text-decoration-thickness: 1px;
      text-underline-offset: 3px;
    }

    #content-blog a:hover {
      color: #7dd3fc;
    }

    .section-title {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 0.75rem;
      margin-bottom: 1.25rem;
    }

    .section-title h4 {
      font-size: 1.1rem;
      font-weight: 600;
      color: #e2e8f0;
      margin: 0;
    }

    .section-title-line {
      flex: 1;
      height: 1px;
      background: linear-gradient(to right,
          rgba(148, 163, 184, 0.4),
          rgba(148, 163, 184, 0));
    }

    /* Swiper Start */
    .swiper {
      width: 100%;
      padding: 1.2rem 0 2rem;
    }

    .swiper-slide {
      text-align: left;
      font-size: 0.95rem;
      background: transparent;
      display: flex;
      justify-content: center;
      align-items: stretch;
    }

    .swiper-slide .card {
      height: 100%;
      border-radius: 16px;
      overflow: hidden;
      border: 1px solid rgba(148, 163, 184, 0.35);
      background: radial-gradient(circle at top left,
          rgba(15, 23, 42, 0.95),
          rgba(15, 23, 42, 0.8));
      transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
    }

    .swiper-slide .card:hover {
      transform: translateY(-4px);
      border-color: rgba(56, 189, 248, 0.7);
      box-shadow: 0 18px 45px rgba(15, 23, 42, 0.9);
    }

    .swiper-slide .card-img-top {
      width: 100%;
      height: 150px;
      object-fit: cover;
    }

    .swiper-slide .card-body {
      padding: 0.9rem 1rem 0.85rem;
    }

    .swiper-slide .card-title a {
      font-size: 0.98rem;
      font-weight: 600;
      color: #e2e8f0;
      text-decoration: none;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .swiper-slide .card-title a:hover {
      color: #7dd3fc;
    }

    .swiper-slide .card-text a {
      font-size: 0.85rem;
      color: rgba(148, 163, 184, 0.9);
      text-decoration: none;
    }

    .swiper-slide .card-text a i {
      margin-right: 0.25rem;
    }

    .swiper-slide .card-text a:hover {
      color: #e2e8f0;
    }

    .swiper-button-next,
    .swiper-button-prev {
      color: #e2e8f0;
      width: 38px;
      height: 38px;
      border-radius: 999px;
      background: rgba(15, 23, 42, 0.7);
      border: 1px solid rgba(148, 163, 184, 0.6);
      backdrop-filter: blur(12px);
    }

    .swiper-button-next::after,
    .swiper-button-prev::after {
      font-size: 16px;
      font-weight: 700;
    }

    .swiper-pagination-bullet {
      background: rgba(148, 163, 184, 0.9);
      opacity: 0.7;
    }

    .swiper-pagination-bullet-active {
      background: #38bdf8;
      opacity: 1;
      transform: scale(1.1);
    }

    @media (max-width: 767.98px) {
      .page-wrapper {
        padding-top: 6rem;
      }

      .blog-hero-title {
        font-size: 1.5rem;
      }
    }

    .img-blogs {
      aspect-ratio: 16/9;
      object-fit: cover;
    }
  </style>
</head>

<body>

  <!-- ======= Header ======= -->
  <?php require './layout/header.php'; ?>
  <!-- End Header -->

  <main id="main" data-aos="fade" data-aos-delay="1500">
    <div class="page-wrapper">
      <!-- ======= Blog Detail Section ======= -->
      <section id="about" class="about">
        <div class="container" id="ct_about">
          <div class="row gy-4 justify-content-center">

            <div class="col-lg-10">
              <div class="bg-skys p-4 p-md-5 mb-4">
                <div class="d-flex flex-column gap-2 mb-3">
                  <h4 class="blog-hero-title fkanit text-center text-md-start mb-2">
                    <?= $rs_blog['blog_name'] ?>
                  </h4>
                  <div class="d-flex flex-wrap justify-content-center justify-content-md-between align-items-center blog-meta">
                    <div class="d-flex align-items-center gap-2 mb-2 mb-md-0">
                      <span class="badge rounded-pill text-bg-success px-3 py-2">
                        <i class="bi bi-journal-text"></i> บทความจาก ART SKY
                      </span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                      <span><i class="bi bi-clock"></i> <?= date_inters($rs_blog['blog_date']) ?></span>
                    </div>
                  </div>
                </div>

                <div class="row gy-4 align-items-start mt-3">
                  <div class="col-lg-8 col-md-12 mx-auto">
                    <div class="blog-cover">
                      <?php if ($rs_blog['blog_image'] != "") { ?>
                        <img src="./images/blog/<?= $rs_blog['blog_image'] ?>" class="img-fluid img-blogs" alt="<?= $rs_blog['blog_name'] ?>">
                      <?php } else { ?>
                        <img src="./images/blog/no_img.png" class="img-fluid img-blogs" alt="<?= $rs_blog['blog_name'] ?>">
                      <?php } ?>
                    </div>
                  </div>
                  <div class="col-lg-12 col-md-12">
                    <div id="content-blog" class="mt-3 mt-lg-0">
                      <?= $rs_blog['blog_detail'] ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </section>
      <!-- End Blog Detail Section -->

      <!-- ======= Related Blog Section ======= -->
      <section class="mt-3">
        <div class="container">
          <div class="bg-skys p-3 p-md-4">
            <div class="section-title mb-3">
              <h4 class="fkanit"><i class="bi bi-stars me-2"></i>บทความอื่น ๆ จาก ART SKY</h4>
              <div class="section-title-line"></div>
            </div>

            <div class="swiper mySwiper">
              <div class="swiper-wrapper">
                <?php
                $sql_blog = " SELECT * FROM tbl_blog WHERE blog_id <> '{$_GET['id']}' ORDER BY tbl_blog.blog_id DESC LIMIT 6";
                $result_blog = mysqli_query($conn, $sql_blog);
                while ($rs_blog = mysqli_fetch_assoc($result_blog)) {
                ?>
                  <div class="swiper-slide">
                    <div class="card">
                      <img src="./images/blog/<?= $rs_blog['blog_image'] ?>" class="card-img-top img-blogs" alt="<?= $rs_blog['blog_name'] ?>" />
                      <div class="card-body">
                        <h5 class="card-title mb-2">
                          <a href="blog-detail?id=<?= $rs_blog['blog_id'] ?>">
                            <?= mb_substr($rs_blog['blog_name'], 0, 50, 'UTF-8'); ?>...
                          </a>
                        </h5>
                        <p class="card-text text-end mb-0">
                          <a href="blog-detail?id=<?= $rs_blog['blog_id'] ?>">
                            <i class="bi bi-clock"></i> <?= date_inters($rs_blog['blog_date']) ?>
                          </a>
                        </p>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              </div>
              <div class="swiper-button-next"></div>
              <div class="swiper-button-prev"></div>
              <div class="swiper-pagination"></div>
            </div>
          </div>
        </div>
      </section>
      <!-- End Related Blog Section -->
    </div>
  </main>
  <!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php require './layout/footer.php'; ?>
  <!-- End Footer -->

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader">
    <div class="line"></div>
  </div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script type="text/javascript" src="./assets/vendor/slick/slick.min.js"></script>

  <!-- Swiper JS -->
  <script src="./app/node_modules/swiper/swiper-bundle.min.js"></script>

  <!-- Initialize Swiper -->
  <script>
    const swiper = new Swiper(".mySwiper", {
      slidesPerView: 1,
      spaceBetween: 10,
      autoplay: {
        delay: 3000,
        disableOnInteraction: false,
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      breakpoints: {
        640: {
          slidesPerView: 2,
          spaceBetween: 10,
        },
        768: {
          slidesPerView: 3,
          spaceBetween: 20,
        },
        1024: {
          slidesPerView: 3,
          spaceBetween: 24,
        },
      },
    });

    // ถ้ากลัวว่า content เดิมมี inline style แปลกๆ อยู่
    // ยังสามารถบังคับสีด้วย jQuery แบบเดิมได้
    $('#content-blog p').css("color", "#e2e8f0");
    $('#content-blog span').css("color", "#e2e8f0");
    $('#content-blog ul').css("color", "#e2e8f0");
    $('#content-blog ul li').css("color", "#e2e8f0");
    $('#content-blog ol').css("color", "#e2e8f0");
    $('#content-blog ol li').css("color", "#e2e8f0");
  </script>

</body>

</html>