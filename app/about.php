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
  <!-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" /> -->
  <link rel="stylesheet" type="text/css" href="./assets/vendor/slick/slick.css" />
  <link rel="stylesheet" type="text/css" href="./assets/vendor/slick/slick-theme.css" />
  <style>
    body {
      background: url("./images/head_bg.jpg") no-repeat top center fixed;
      background-size: cover;
    }

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
    }

    .bg-skys {
      background-color: rgba(0, 0, 0, 0.5);
    }

    .about-glass-card {
      position: relative;
      border-radius: 24px;
      padding: 28px 26px;
      background: linear-gradient(135deg,
          rgba(9, 15, 35, 0.3),
          rgba(28, 60, 110, 0.3));
      border: 1px solid rgba(255, 255, 255, 0.50);
      box-shadow: 0 22px 60px rgba(0, 0, 0, 0.75);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      overflow: hidden;
      color: #f5f7ff;
    }

    .about-glass-card::before,
    .about-glass-card::after {
      content: "";
      position: absolute;
      border-radius: 999px;
      filter: blur(2px);
      pointer-events: none;
    }

    .about-glass-card::before {
      width: 220px;
      height: 220px;
      top: -80px;
      right: -60px;
      background: radial-gradient(circle,
          rgba(123, 220, 255, 0.35),
          transparent 60%);
    }

    .about-glass-card::after {
      width: 260px;
      height: 260px;
      bottom: -120px;
      left: -80px;
      background: radial-gradient(circle,
          rgba(179, 157, 255, 0.3),
          transparent 60%);
    }

    .about-glass-inner {
      position: relative;
      z-index: 1;
    }

    .about-glass-heading {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 6px;
    }

    .about-glass-pill {
      padding: 3px 10px;
      border-radius: 999px;
      font-size: 0.72rem;
      letter-spacing: 0.16em;
      text-transform: uppercase;
      background: linear-gradient(120deg,
          rgba(123, 220, 255, 0.25),
          rgba(179, 157, 255, 0.3));
      border: 1px solid rgba(255, 255, 255, 0.18);
      color: #f8fbff;
    }

    .about-glass-heading h2 {
      margin: 0;
      font-size: 1.9rem;
      font-weight: 600;
      background: linear-gradient(110deg, #ffffff, #e5f6ff);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }

    .about-glass-divider {
      height: 1px;
      width: 100%;
      margin: 0.9rem 0 1.4rem;
      background: linear-gradient(90deg,
          rgba(124, 220, 255, 0),
          rgba(124, 220, 255, 0.75),
          rgba(179, 157, 255, 0));
      opacity: 0.85;
    }

    .about-glass-body {
      font-size: 0.96rem;
      line-height: 1.8;
      color: rgba(235, 242, 255, 0.96);
    }

    .about-glass-body p {
      margin-bottom: 0.9rem;
    }

    @media (max-width: 575.98px) {
      .about-glass-card {
        padding: 22px 18px;
        border-radius: 20px;
      }

      .about-glass-heading h2 {
        font-size: 1.6rem;
      }

      .about-glass-body {
        font-size: 0.94rem;
      }
    }
  </style>
</head>

<body>

  <!-- ======= Header ======= -->
  <?php require './layout/header.php'; ?>
  <!-- End Header -->

  <main id="main" data-aos="fade" data-aos-delay="1500">

    <!-- ======= End Page Header ======= -->
    <div class="page-header d-flex align-items-center">
      <div class="container position-relative">
        <div class="row d-flex justify-content-center">
          <div class="col-lg-6 text-center">
            <h2>เกี่ยวกับ ART SKY</h2>
            <p>เทคโนโลยีสมัยใหม่ส่งเสริมการท่องเที่ยวในจังหวัดเชียงราย</p>
          </div>
        </div>
      </div>
    </div><!-- End Page Header -->

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container">

        <div class="row gy-4 justify-content-center">
          <div class="col-lg-12">
            <div class="about-glass-card">
              <div class="about-glass-inner content">
                <div class="about-glass-heading">
                  <span class="about-glass-pill">Platform Overview</span>
                  <h2>About ARTSKY</h2>
                </div>

                <div class="about-glass-divider"></div>

                <div class="about-glass-body text-justify">
                  <p>
                    ARTSKY คือแพลตฟอร์มนวัตกรรมดิจิทัลเพื่อการอนุรักษ์ท้องฟ้ามืดและส่งเสริมการท่องเที่ยวท้องฟ้ามืดอย่างยั่งยืน
                    พัฒนาโดยทีมวิจัยจาก มหาวิทยาลัยราชภัฏเชียงราย (CRRU) โดยมีเป้าหมายในการสร้าง
                    “แผนที่ท้องฟ้ามืดของประเทศไทย” ผ่านระบบภูมิสารสนเทศ (GIS) และฐานข้อมูลมลภาวะแสงแบบเรียลไทม์
                  </p>

                  <p>
                    ผู้ใช้สามารถ 🌠 รายงานค่าความสว่างของท้องฟ้า, 🔭 ตรวจสอบจุดดูดาวที่เหมาะสม, และ 🌿 เข้าร่วมกิจกรรมของชุมชนได้ในแอปเดียว
                  </p>

                  <p>
                    ARTSKY ยังเชื่อมโยงข้อมูลการท่องเที่ยวท้องฟ้ามืดในจังหวัดเชียงรายและพื้นที่ทั่วประเทศ
                    เพื่อให้ “การดูดาว” ไม่ใช่เพียงงานอดิเรก แต่เป็นเครื่องมือขับเคลื่อนเศรษฐกิจและการอนุรักษ์อย่างยั่งยืน
                  </p>

                  <p>
                    ภายใต้ระบบ ARTSKY STATION ทุกพื้นที่สามารถสมัครเข้าร่วมเป็น “จุดดูดาวระดับสากล” ได้
                    โดยเพียงเก็บข้อมูลสภาพท้องฟ้า ความมืดของแสง และสภาพอากาศในพื้นที่
                    ระบบจะบันทึกและเผยแพร่ข้อมูลเหล่านี้ให้ผู้คนทั่วประเทศได้เห็นความงดงามของท้องฟ้าในพื้นที่นั้น
                    พร้อมเปิดโอกาสด้านการเรียนรู้ การท่องเที่ยว และเศรษฐกิจชุมชนอย่างยั่งยืน
                  </p>

                  <p>
                    มาร่วมกันเป็นส่วนหนึ่งของ “Chiang Rai Dark Sky Network” เพื่อส่งต่อ “แสงดาว” ให้คนทั้งโลกได้รู้จัก
                    เชียงราย — เมืองแห่งท้องฟ้ามืดและแรงบันดาลใจ 🪐
                  </p>

                  <p class="mt-3">
                    <strong>ที่มาและแรงบันดาลใจของ ARTSKY</strong><br>
                    แพลตฟอร์ม ARTSKY เกิดขึ้นจากแรงบันดาลใจในงานวิจัยของทีมวิจัยด้านดาราศาสตร์และเทคโนโลยี
                    มหาวิทยาลัยราชภัฏเชียงราย ซึ่งได้ต่อยอดจาก 2 โครงการหลัก ได้แก่ —
                  </p>

                  <p>
                    โครงการย่อยที่ 2: “การพัฒนาระบบสารสนเทศอัจฉริยะสำหรับการท่องเที่ยวเชิงดาราศาสตร์ในจังหวัดเชียงราย”
                    ภายใต้โครงการหลัก “การเพิ่มศักยภาพแหล่งท่องเที่ยวสร้างสรรค์เชิงดาราศาสตร์ สามภูสู่ดอย จังหวัดเชียงราย”
                    ได้รับการสนับสนุนงบประมาณด้านวิทยาศาสตร์ วิจัย และนวัตกรรม ประจำปีงบประมาณ พ.ศ. 2567 (ววน. 67)
                  </p>

                  <p>
                    โครงการวิจัย: “การอนุรักษ์ฟ้ามืด: ทางเลือกใหม่สู่การพัฒนาการท่องเที่ยวสีเขียวในจังหวัดเชียงราย”
                    ได้รับการสนับสนุนงบประมาณด้านวิทยาศาสตร์ วิจัย และนวัตกรรม ประจำปีงบประมาณ พ.ศ. 2569 (ววน. 69)
                  </p>

                  <p>
                    ทั้งสองโครงการเป็นรากฐานสำคัญที่หล่อหลอมแนวคิดการสร้างแพลตฟอร์มดิจิทัลเพื่ออนุรักษ์ท้องฟ้ามืดของประเทศไทยอย่างมีส่วนร่วมและยั่งยืน
                    โดยเน้นให้ชุมชนท้องถิ่นเป็นศูนย์กลางของการเปลี่ยนแปลง — เพื่อให้ “แสงดาว” กลับคืนสู่ท้องฟ้าเชียงรายอีกครั้ง 🌠
                  </p>

                  <p class="mt-3">
                    🙏 <strong>ขอขอบคุณ</strong><br>
                    ทีมวิจัย ARTSKY ขอขอบคุณ<br>
                    • ข้อมูลภาพจำลองท้องฟ้าจาก Stellarium.org<br>
                    • ข้อมูลสภาพอากาศจาก OpenWeatherMap.org<br>
                    • และ source code เพื่อจำลองท้องฟ้าเชิงตอบโต้ (interactive sky simulation) จาก VirtualSky<br>
                    ซึ่งเป็นองค์ประกอบสำคัญที่ทำให้ ARTSKY สามารถเชื่อมโยงความงดงามของท้องฟ้ายามค่ำคืนกับเทคโนโลยี
                    เพื่อการเรียนรู้ การอนุรักษ์ และการท่องเที่ยวได้อย่างสมบูรณ์แบบ
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>


      </div>
    </section><!-- End About Section -->
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
  <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script> -->
  <script type="text/javascript" src="./assets/vendor/slick/slick.min.js"></script>

  <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  <!-- Initialize Swiper -->
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