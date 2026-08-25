<?php
require "config/connect.php";
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

  <!-- Swiper & Slick -->
  <link rel="stylesheet" href="./app/node_modules/swiper/swiper-bundle.min.css" />
  <link rel="stylesheet" type="text/css" href="./assets/vendor/slick/slick.css" />
  <link rel="stylesheet" type="text/css" href="./assets/vendor/slick/slick-theme.css" />

  <style>
    body {
      background: url("./images/head_bg.jpg") no-repeat top center fixed;
      background-size: cover;
      min-height: 100vh;
      position: relative;
      color: #e2e8f0;
    }

    /* overlay ให้ popup อ่านง่ายขึ้น */
    /* body::before {
      content: "";
      position: fixed;
      inset: 0;
      background:
        radial-gradient(circle at top, rgba(15, 23, 42, 0.16), transparent 55%),
        linear-gradient(to bottom right, rgba(15, 23, 42, 0.96), rgba(15, 23, 42, 0.98));
      z-index: -1;
    } */

    .fkanit {
      font-family: "Noto Serif Thai", serif;
      font-weight: 400;
      font-style: normal;
    }

    .color-sky {
      color: rgba(255, 255, 255, 0.8);
    }

    .art-sky-img {
      aspect-ratio: 16 / 9;
      object-fit: cover;
    }

    #header {
      background: transparent;
    }

    .bg-skys {
      background-color: rgba(0, 0, 0, 0.1);
    }

    /* Wrapper หลักของ popup */
    .gallery-single {
      padding-top: 4.5rem;
      padding-bottom: 3rem;
    }

    .hotel-popup-card {
      border-radius: 24px;
      padding: 1.5rem 1.5rem 1.75rem;
      background:
        radial-gradient(circle at top left, rgba(15, 23, 42, 0.2), rgba(15, 23, 42, 0.6));
      border: 1px solid rgba(148, 163, 184, 0.35);
      box-shadow: 0 26px 70px rgba(15, 23, 42, 0.98);
    }

    /* Swiper / Image slider */
    .slides-1 {
      border-radius: 18px;
      overflow: hidden;
      background: #020617;
      border: 1px solid rgba(30, 64, 175, 0.1);
      box-shadow: 0 18px 55px rgba(15, 23, 42, 2);
    }

    .swiper {
      width: 100%;
      height: 100%;
    }

    .swiper-wrapper {
      align-items: center;
    }

    .swiper-slide {
      display: flex;
      align-items: center;
      justify-content: center;
      background: #020617;
    }

    .swiper-slide img {
      display: block;
      width: 100%;
      aspect-ratio: 16 / 9;
      object-fit: cover;
      transition: transform 0.6s ease;
    }

    .swiper-slide img:hover {
      transform: scale(1.03);
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

    /* ข้อมูลที่พักด้านขวา */
    .portfolio-info {
      border-radius: 18px;
      padding: 1.4rem 1.5rem 1.2rem;
      background: rgba(15, 23, 42, 0.3);
      border: 1px solid rgba(148, 163, 184, 0.4);
      box-shadow: 0 18px 50px rgba(15, 23, 42, 0.5);
    }

    .portfolio-info h3 {
      font-size: 1.3rem;
      font-weight: 700;
      color: #e0f2fe;
      margin-bottom: 0.75rem;
      line-height: 1.4;
    }

    .portfolio-info ul {
      list-style: none;
      padding: 0;
      margin: 0.5rem 0 0;
    }

    .portfolio-info ul li {
      font-size: 0.9rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 0.75rem;
      padding: 0.45rem 0;
      border-bottom: 1px dashed rgba(51, 65, 85, 0.9);
    }

    .portfolio-info ul li:last-child {
      border-bottom: none;
      padding-top: 0.8rem;
    }

    .portfolio-info ul li strong {
      font-weight: 600;
      color: #e5e7eb;
      display: inline-flex;
      align-items: center;
      gap: 0.35rem;
    }

    .portfolio-info ul li span,
    .portfolio-info ul li a {
      font-size: 0.9rem;
      color: rgba(229, 231, 235, 0.9);
      text-decoration: none;
      word-break: break-all;
      text-align: right;
    }

    .portfolio-info ul li a:hover {
      color: #7dd3fc;
    }

    .info-label-icon {
      font-size: 1rem;
      color: #38bdf8;
    }

    /* ปุ่มโทร */
    .btn-visit {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.4rem;
      padding: 0.55rem 1.2rem;
      border-radius: 999px;
      font-size: 0.9rem;
      font-weight: 600;
      border: none;
      background: linear-gradient(135deg, #22c55e, #16a34a);
      color: #ecfdf5 !important;
      text-decoration: none;
      box-shadow: 0 18px 45px rgba(22, 163, 74, 0.65);
    }

    .btn-visit i {
      font-size: 1rem;
    }

    .btn-visit:hover {
      background: linear-gradient(135deg, #4ade80, #22c55e);
      color: #ecfdf5;
    }

    .btn-visit:active {
      transform: translateY(1px);
      box-shadow: 0 12px 30px rgba(22, 163, 74, 0.7);
    }

    @media (max-width: 991.98px) {
      .gallery-single {
        padding-top: 4rem;
      }

      .hotel-popup-card {
        padding: 1.25rem;
      }

      .portfolio-info {
        margin-top: 1.25rem;
      }
    }
  </style>
</head>

<body>
  <?php
  $view_id = mysqli_real_escape_string($conn, $_GET['id']);
  $sql = " SELECT * FROM tbl_car_rental WHERE car_rental_id = '$view_id' ";
  $result = mysqli_query($conn, $sql);
  $num_view = mysqli_num_rows($result);
  $rs = mysqli_fetch_assoc($result);
  ?>

  <main id="main" data-aos="fade" data-aos-delay="1500">
    <!-- ======= Gallery Single Section ======= -->
    <section id="gallery-single" class="gallery-single py-3">
      <div class="container">
        <div class="hotel-popup-card">
          <div class="row justify-content-center gy-4 align-items-start">
            <!-- Slider รูปภาพ -->
            <div class="col-lg-8">
              <div class="position-relative h-100">
                <div class="slides-1 portfolio-details-slider swiper">
                  <div class="swiper-wrapper align-items-center">

                    <?php
                    $sql_img = " SELECT * FROM tbl_car_rental_image WHERE car_rental_id = '$view_id' ORDER BY car_rental_id ASC ";
                    $result_img = mysqli_query($conn, $sql_img);
                    $num_img = mysqli_num_rows($result_img);
                    while ($rs_img = mysqli_fetch_assoc($result_img)) {
                      if ($num_img > 0) {
                        if ($rs_img['car_rental_image_name'] != "") { ?>
                          <div class="swiper-slide">
                            <img src="./images/car_rental/<?= $rs_img['car_rental_image_name'] ?>" alt="<?= $rs['car_rental_name'] ?>">
                          </div>
                    <?php }
                      }
                    } ?>

                  </div>
                  <div class="swiper-pagination"></div>
                </div>
                <p class="mb-1 small text-light fkanit mt-3">
                  <?php
                  $sql_subdistricts = " SELECT * FROM tbl_subdistricts WHERE id = {$rs['subdistrict_id']} ";
                  $result_subdistricts = mysqli_query($conn, $sql_subdistricts);
                  $rs_subdistricts = mysqli_fetch_assoc($result_subdistricts);

                  $sql_districts = " SELECT * FROM tbl_districts WHERE id = {$rs['district_id']} ";
                  $result_districts = mysqli_query($conn, $sql_districts);
                  $rs_districts = mysqli_fetch_assoc($result_districts);

                  $sql_provinces = " SELECT * FROM tbl_provinces WHERE id = {$rs['province_id']} ";
                  $result_provinces = mysqli_query($conn, $sql_provinces);
                  $rs_provinces = mysqli_fetch_assoc($result_provinces);
                  ?>
                  ต.<?= $rs_subdistricts['name_in_thai']; ?> อ.<?= $rs_districts['name_in_thai']; ?> จ.<?= $rs_provinces['name_in_thai']; ?>
                </p>
                <p class="mt-3">
                  <?= nl2br($rs['carrent_detail']) ?>
                </p>
              </div>
            </div>

            <!-- ข้อมูลที่พัก -->
            <div class="col-lg-4">
              <div class="portfolio-info">
                <h3 class="fkanit">
                  <?= $rs['car_rental_name'] ?>
                </h3>
                <ul>
                  <?php
                  if ($rs['phone']) {
                  ?>
                    <li>
                      <strong>
                        <i class="bi bi-telephone info-label-icon"></i>
                        เบอร์โทรศัพท์
                      </strong>
                      <span><?= $rs['phone'] ?></span>
                    </li>
                  <?php } ?>
                  <?php
                  if ($rs['line_id']) {
                  ?>
                    <li>
                      <strong>
                        <i class="bi bi-line info-label-icon"></i>
                        ไลน์
                      </strong>
                      <a href="https://line.me/ti/p/~<?= $rs['line_id'] ?>" target="_blank"><?= $rs['line_id'] ?></a>
                    </li>
                  <?php } ?>
                  <?php
                  if ($rs['email']) {
                  ?>
                    <li>
                      <strong>
                        <i class="bi bi-envelope info-label-icon"></i>
                        อีเมล
                      </strong>
                      <a href="mailto:<?= $rs['email'] ?>" target="_blank"><?= $rs['email'] ?></a>
                    </li>
                  <?php } ?>
                  <?php
                  if ($rs['facebook']) {
                  ?>
                    <li>
                      <strong>
                        <i class="bi bi-facebook info-label-icon"></i>
                        Facebook
                      </strong>
                      <a href="mailto:<?= $rs['facebook'] ?>" target="_blank"><?= mb_substr($rs['facebook'], 0, 30, 'UTF-8'); ?></a>
                    </li>
                  <?php } ?>
                  <?php
                  if ($rs['website']) {
                  ?>
                    <li>
                      <strong>
                        <i class="bi bi-globe2 info-label-icon"></i>
                        เว็บไซต์
                      </strong>
                      <a href="<?= $rs['website'] ?>" target="_blank">
                        <?= mb_substr($rs['website'], 0, 30, 'UTF-8'); ?>
                      </a>
                    </li>
                  <?php } ?>
                  <?php
                  if ($rs['phone']) {
                  ?>
                    <li>
                      <a href="tel:<?= $rs['phone'] ?>" class="btn-visit align-self-center">
                        <i class="bi bi-telephone-outbound"></i>
                        โทรทันที
                      </a>
                    </li>
                  <?php } ?>
                </ul>
              </div>
            </div>

          </div>
        </div>

      </div>
    </section><!-- End Gallery Single Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <!-- End Footer -->

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
  </a>

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

</body>

</html>