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
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/main2.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
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

    /* overlay ทำให้ตัวหนังสืออ่านง่ายขึ้น */
    /* body::before {
      content: "";
      position: fixed;
      inset: 0;
      background:
        radial-gradient(circle at top, rgba(15, 23, 42, 0.15), transparent 55%),
        linear-gradient(to bottom right, rgba(15, 23, 42, 0.9), rgba(15, 23, 42, 0.97));
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

    #header {
      background: transparent;
      border-bottom: none;
    }

    .bg-skys {
      background: rgba(15, 23, 42, 0.1);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border-radius: 18px;
      border: 1px solid rgba(148, 163, 184, 0.3);
      box-shadow: 0 18px 45px rgba(15, 23, 42, 0.3);
    }

    /* Page header hero */
    .page-header {
      min-height: 60vh;
      padding-top: 7rem;
      padding-bottom: 4rem;
      position: relative;
      text-align: center;
    }

    .page-header::before {
      content: "";
      position: absolute;
      inset: 0;
      background:
        radial-gradient(circle at top, rgba(15, 23, 42, 0.1), transparent 90%),
        linear-gradient(to bottom, rgba(15, 23, 42, 0.1), transparent);
      z-index: 0;
    }

    .page-header .container {
      position: relative;
      z-index: 1;
    }

    .page-header-card {
      max-width: 640px;
      margin: 0 auto;
      padding: 2.5rem 2rem;
      border-radius: 22px;
      background: radial-gradient(circle at top left,
          rgba(15, 23, 42, 0.5),
          rgba(15, 23, 42, 0.1));
      border: 1px solid rgba(148, 163, 184, 0.38);
      box-shadow: 0 22px 60px rgba(15, 23, 42, 0.95);
    }

    .page-header h2 {
      font-size: clamp(2rem, 3vw, 2.6rem);
      font-weight: 700;
      letter-spacing: 0.04em;
      color: #e0f2fe;
      margin-bottom: 0.75rem;
    }

    .page-header p {
      font-size: 1rem;
      line-height: 1.9;
      color: rgba(226, 232, 240, 0.9);
      margin-bottom: 0;
    }

    .page-header-highlight {
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      padding: 0.25rem 0.9rem;
      border-radius: 999px;
      font-size: 0.8rem;
      margin-bottom: 1rem;
      background: linear-gradient(135deg, rgba(56, 189, 248, 0.1), rgba(34, 197, 94, 0.12));
      border: 1px solid rgba(56, 189, 248, 0.5);
      color: #bae6fd;
    }

    .page-header-highlight i {
      font-size: 0.9rem;
    }

    /* Contact section */
    .contact {
      padding: 2rem 0 4rem;
    }

    .contact .info-item {
      padding: 1.4rem 1.4rem;
      border-radius: 18px;
      background: rgba(15, 23, 42, 0.5);
      border: 1px solid rgba(148, 163, 184, 0.35);
      box-shadow: 0 16px 45px rgba(15, 23, 42, 0.9);
    }

    .contact .info-item i {
      font-size: 1.8rem;
      line-height: 0;
      color: #38bdf8;
      margin-right: 0.9rem;
      margin-top: 0.15rem;
    }

    .contact .info-item h4 {
      font-size: 1rem;
      font-weight: 600;
      margin-bottom: 0.25rem;
      color: #e2e8f0;
    }

    .contact .info-item p {
      font-size: 0.9rem;
      color: rgba(226, 232, 240, 0.86);
      margin-bottom: 0;
    }

    .map-card {
      border-radius: 20px;
      overflow: hidden;
      background: rgba(15, 23, 42, 0.5);
      border: 1px solid rgba(148, 163, 184, 0.4);
      box-shadow: 0 22px 60px rgba(15, 23, 42, 0.95);
    }

    .map-card iframe {
      display: block;
      width: 100%;
      border: 0;
    }

    .map-card-header {
      padding: 0.9rem 1.5rem 0.4rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 1rem;
      border-bottom: 1px solid rgba(51, 65, 85, 0.9);
      background: radial-gradient(circle at top left,
          rgba(15, 23, 42, 0.1),
          rgba(15, 23, 42, 0.0));
    }

    .map-card-header .title {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
    }

    .map-card-header .title span:first-child {
      font-size: 0.95rem;
      font-weight: 600;
      color: #e5f4ff;
    }

    .map-card-header .title span:last-child {
      font-size: 0.8rem;
      color: rgba(148, 163, 184, 0.9);
    }

    .map-badge {
      font-size: 0.78rem;
      padding: 0.25rem 0.7rem;
      border-radius: 999px;
      border: 1px solid rgba(56, 189, 248, 0.5);
      color: #7dd3fc;
      display: inline-flex;
      align-items: center;
      gap: 0.25rem;
    }

    .map-badge i {
      font-size: 0.85rem;
    }

    @media (max-width: 991.98px) {
      .page-header {
        padding-top: 6.5rem;
        min-height: 55vh;
      }

      .contact {
        padding-top: 1rem;
      }
    }

    @media (max-width: 767.98px) {
      .page-header-card {
        padding: 2rem 1.4rem;
      }
    }
  </style>
</head>

<body>

  <!-- ======= Header ======= -->
  <?php require './layout/header.php'; ?>
  <!-- End Header -->

  <main id="main" data-aos="fade" data-aos-delay="1500">

    <!-- ======= Page Header (Hero) ======= -->
    <div class="page-header d-flex align-items-center">
      <div class="container position-relative">
        <div class="row d-flex justify-content-center">
          <div class="col-lg-8">
            <div class="page-header-card text-center">
              <div class="page-header-highlight">
                <i class="bi bi-stars"></i>
                แพลตฟอร์มท้องฟ้ามืด &amp; การท่องเที่ยวเชิงดาราศาสตร์
              </div>
              <h2 class="fkanit">ART SKY</h2>
              <p>
                เปิดประตูสู่จักรวาลกว้างใหญ่ ค้นพบเรื่องราวน่าทึ่งของดวงดาวและกาแล็กซี
                ด้วยเทคโนโลยีล้ำสมัยที่เนรมิตท้องฟ้ายามค่ำคืนให้มีชีวิตชีวา
              </p>
            </div>
          </div>
        </div>
      </div>
    </div><!-- End Page Header -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container">

        <div class="row gy-4 justify-content-center mb-3">

          <div class="col-lg-4 col-md-6">
            <div class="info-item d-flex">
              <i class="bi bi-geo-alt flex-shrink-0"></i>
              <div>
                <h4>ที่ตั้ง</h4>
                <p>มหาวิทยาลัยราชภัฏเชียงราย บ้านดู่ จังหวัดเชียงราย</p>
              </div>
            </div>
          </div><!-- End Info Item -->

          <div class="col-lg-4 col-md-6">
            <div class="info-item d-flex">
              <i class="bi bi-envelope flex-shrink-0"></i>
              <div>
                <h4>อีเมล</h4>
                <p>toktolab@crru.ac.th</p>
              </div>
            </div>
          </div><!-- End Info Item -->

          <!--
          <div class="col-lg-3">
            <div class="info-item d-flex">
              <i class="bi bi-phone flex-shrink-0"></i>
              <div>
                <h4>โทรศัพท์:</h4>
                <p>053 776 000, 053 776 001</p>
              </div>
            </div>
          </div>
          -->
        </div>

        <div class="row justify-content-center mt-3">
          <div class="col-lg-10">
            <div class="map-card">
              <div class="map-card-header">
                <div class="title">
                  <span>แผนที่หอดูดาว / ศูนย์วิจัย</span>
                  <span>มหาวิทยาลัยราชภัฏเชียงราย · บ้านดู่ · จังหวัดเชียงราย</span>
                </div>
                <span class="map-badge">
                  <i class="bi bi-geo-alt-fill"></i>
                  เปิดด้วย Google Maps
                </span>
              </div>
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14998.129801748277!2d99.8464686!3d19.9861557!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30d7011818f3ae89%3A0xed0bc907938a413c!2z4LiE4LiT4Liw4Lin4Li04LiX4Lii4Liy4Lio4Liy4Liq4LiV4Lij4LmM4LmB4Lil4Liw4LmA4LiX4LiE4LmC4LiZ4LmC4Lil4Lii4Li1IOC4oeC4q-C4suC4p-C4tOC4l-C4ouC4suC4peC4seC4ouC4o-C4suC4iuC4oOC4seC4j-C5gOC4iuC4teC4ouC4h-C4o-C4suC4og!5e0!3m2!1sth!2sth!4v1714646853575!5m2!1sth!2sth"
                width="100%" height="450" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
          </div><!-- End Map -->
        </div>

      </div>
    </section><!-- End Contact Section -->

  </main>
  <!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php require './layout/footer.php'; ?>
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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
    integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script type="text/javascript" src="./assets/vendor/slick/slick.min.js"></script>

  <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  <!-- Initialize Swiper (logic เดิม) -->
  <script>
    var swiper = new Swiper(".mySwiper", {
      spaceBetween: 30,
      centeredSlides: true,
      autoplay: {
        delay: 7000,
        disableOnInteraction: false,
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
    });
  </script>

  <!-- Slick sliders (logic เดิม) -->
  <script>
    $(document).ready(function() {
      $('.art-skys').slick({
        slidesToShow: 2,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 3000,
        arrows: false,
        dots: false,
        pauseOnHover: true,
        responsive: [{
          breakpoint: 768,
          settings: {
            slidesToShow: 2
          }
        }, {
          breakpoint: 520,
          settings: {
            slidesToShow: 2
          }
        }]
      });
    });

    $(document).ready(function() {
      $('.art-skys2').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 3000,
        arrows: false,
        dots: false,
        pauseOnHover: true,
        responsive: [{
          breakpoint: 768,
          settings: {
            slidesToShow: 2
          }
        }, {
          breakpoint: 520,
          settings: {
            slidesToShow: 2
          }
        }]
      });
    });

    $(document).ready(function() {
      $('.art-skys3').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 3000,
        arrows: false,
        dots: false,
        pauseOnHover: true,
        responsive: [{
          breakpoint: 768,
          settings: {
            slidesToShow: 2
          }
        }, {
          breakpoint: 520,
          settings: {
            slidesToShow: 1
          }
        }]
      });
    });
  </script>

</body>

</html>
