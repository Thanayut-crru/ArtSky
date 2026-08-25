<?php
require './config/connect.php';
require './config/function.php';
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
    }

    .fkanit {
      font-family: "Noto Serif Thai", serif;
      font-weight: 400;
      font-style: normal;
    }

    .color-sky {
      color: rgba(255, 255, 255, 0.8);
    }

    .art-sky-img {
      aspect-ratio: 9 / 16;
      object-fit: cover;
    }

    #header {
      background: transparent;
    }

    .bg-skys {
      background-color: rgba(0, 0, 0, 0.5);
    }

    /* Start Slider */
    .slick-slide {
      margin: 0px 100px;
    }

    .slick-slide img {
      width: 100%;
    }

    .slick-slider {
      position: relative;
      display: block;
      box-sizing: border-box;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
      -webkit-touch-callout: none;
      -khtml-user-select: none;
      -ms-touch-action: pan-y;
      touch-action: pan-y;
      -webkit-tap-highlight-color: transparent;
    }

    .slick-list {
      position: relative;
      display: block;
      overflow: hidden;
      margin: 0;
      padding: 0;
    }

    .slick-list:focus {
      outline: none;
    }

    .slick-list.dragging {
      cursor: pointer;
      cursor: hand;
    }

    .slick-slider .slick-track,
    .slick-slider .slick-list {
      -webkit-transform: translate3d(0, 0, 0);
      -moz-transform: translate3d(0, 0, 0);
      -ms-transform: translate3d(0, 0, 0);
      -o-transform: translate3d(0, 0, 0);
      transform: translate3d(0, 0, 0);
    }

    .slick-track {
      position: relative;
      top: 0;
      left: 0;
      display: block;
    }

    .slick-track:before,
    .slick-track:after {
      display: table;
      content: '';
    }

    .slick-track:after {
      clear: both;
    }

    .slick-loading .slick-track {
      visibility: hidden;
    }

    .slick-slide {
      display: none;
      float: left;
      height: 100%;
      min-height: 1px;
    }

    [dir='rtl'] .slick-slide {
      float: right;
    }

    .slick-slide img {
      display: block;
    }

    .slick-slide.slick-loading img {
      display: none;
    }

    .slick-slide.dragging img {
      pointer-events: none;
    }

    .slick-initialized .slick-slide {
      display: block;
    }

    .slick-loading .slick-slide {
      visibility: hidden;
    }

    .slick-vertical .slick-slide {
      display: block;
      height: auto;
      border: 1px solid transparent;
    }

    .slick-arrow.slick-hidden {
      display: none;
    }

    /* End Slider */

    /* Swipe Start */
    .swiper {
      width: 100%;
      height: 100%;
    }

    .swiper-slide {
      text-align: center;
      font-size: 18px;
      background: transparent;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .swiper-slide img {
      display: block;
      width: 100%;
      height: 250px;
      object-fit: contain;
    }

    /* Swipe End */
  </style>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script type="text/javascript" src="./app/node_modules/axios/dist/axios.min.js"></script>
</head>

<body>

  <!-- ======= Header ======= -->
  <?php require './layout/header.php'; ?>
  <!-- End Header -->

  <main id="main" data-aos="fade" data-aos-delay="1500">

    <!-- ======= End Page Header ======= -->
    <!-- <div class="page-header d-flex align-items-center">
      <div class="container position-relative">
        <div class="row d-flex justify-content-center">
          <div class="col-lg-6 text-center">
            <img src="./images/crru.png" alt="LOGO" width="100px" class="img-fluid">
            <h3 class="mt-2">Chiangrai Rajabhat University</h3>
          </div>
        </div>
      </div>
    </div> -->
    <!-- End Page Header -->

    <!-- Start -->
    <section>
      <div class="page-header d-flex align-items-center">
        <div class="container-fluid">
          <div class="swiper mySwiper">
            <div class="swiper-wrapper">
              <div class="swiper-slide">
                <div class="col-lg-6 text-center">
                  <img src="./images/art-sky-logo.png" alt="LOGO" class="d-block w-100">
                  <h3 class="mt-2 color-sky">แอปพลิเคชั่นแผนที่ดาว</h3>
                </div>
              </div>
              <div class="swiper-slide">
                <div class="col-lg-6 text-center">
                  <img src="./images/logo-sci.png" alt="LOGO" class="d-block w-100">
                  <h3 class="mt-2 color-sky">คณะวิทยาศาสตร์และเทคโนโลยี</h3>
                </div>
              </div>
              <div class="swiper-slide">
                <div class="col-lg-6 text-center mb-5">
                  <img src="./images/crru.png" alt="LOGO" class="d-block w-100">
                  <h3 class="mt-2 color-sky">Chiangrai Rajabhat University</h3>
                </div>
              </div>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
          </div>
        </div>
      </div>
    </section>
    <!-- End -->

    <!-- ======= Contact Section ======= -->
    <div class="col-lg-12 text-center">
      <div class="section-header">
        <h2>ART SKY Station</h2>
        <p>สถานีตรวจวัดอากาศ</p>
      </div>
    </div>
    <section class="art-skys slider">
      <?php
      $sql_st = " SELECT * FROM tbl_station ORDER BY station_id ASC ";
      $result_st = mysqli_query($conn, $sql_st);
      $no_st = 1;
      while ($rs_st = mysqli_fetch_assoc($result_st)) {
        if ($rs_st['station_image'] != '') {
          $station_image = $rs_st['station_image'];
        } else {
          $station_image = 'no-img.png';
        }
      ?>
        <div class="slide m-1">
          <div class="col-lg-10 col-md-10 mx-auto">
            <div class="card border border-0 bg-skys">
              <img src="images/station_image/<?= $station_image ?>" class="card-img-top art-sky-img" alt="Hollywood Sign on The Hill" />
              <div class="card-body">
                <h5 class="card-title text-center"><a href="station?id=<?= $rs_st['station_id'] ?>"><?= $rs_st['station_name'] ?></a></h5>
                <p class="card-text text-center">
                  <a href="station?id=<?= $rs_st['station_id'] ?>">
                    <spna id="stat_des_<?= $no_st ?>">ท้องฟ้าปลอดโปร่ง อุณหภูมิเพิ่มขึ้น 1-2 องศา</spna>
                  </a>
                </p>
              </div>
            </div>
          </div>
        </div>
      <?php $no_st++;
      } ?>
    </section>

    <!-- <div class="col-lg-12 mt-5 pt-5 text-center">
      <div class="section-header">
        <h2>Art Sky Blog</h2>
        <p>ข่าวสารบทความ</p>
      </div>
    </div>
    <section class="art-skys2 slider">

      <?php
      $sql_blog = " SELECT * FROM tbl_blog ORDER BY tbl_blog.blog_id DESC LIMIT 6";
      $result_blog = mysqli_query($conn, $sql_blog);
      while ($rs_blog = mysqli_fetch_assoc($result_blog)) {
      ?>
        <div class="slide m-1">
          <div class="col-lg-11 col-md-11 mx-auto">
            <div class="card border border-0 bg-skys">
              <img src="./images/blog/<?= $rs_blog['blog_image'] ?>" class="card-img-top art-sky-img" alt="<?= $rs_blog['blog_name'] ?>" />
              <div class="card-body">
                <h5 class="card-title"><a href="blog-detail?id=<?= $rs_blog['blog_id'] ?>"><?= $rs_blog['blog_name'] ?></a></h5>
                <p class="card-text text-end"><a href="blog-detail?id=<?= $rs_blog['blog_id'] ?>"><i class="bi bi-clock"></i> <?= date_inters($rs_blog['blog_date']) ?></a></p>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>

    </section> -->


    <div class="col-lg-12 mt-5 pt-5 text-center">
      <div class="section-header">
        <h2>ART SKY Place</h2>
        <p>ที่พักแนะนำนอนดูดาว</p>
      </div>
    </div>
    </div>
    <section class="art-skys3 slider">
      <?php
      $sql_hotel1 = " SELECT * FROM tbl_hotel WHERE tbl_hotel.hotel_status = 1 ORDER BY tbl_hotel.hotel_id ASC ";
      $result_hotel1 = mysqli_query($conn, $sql_hotel1);
      while ($rs_hotel1 = mysqli_fetch_assoc($result_hotel1)) {
        $sql_img1 = " SELECT tbl_hotel_image.hotel_image_name FROM tbl_hotel_image 
      WHERE tbl_hotel_image.hotel_id = '{$rs_hotel1["hotel_id"]}' ORDER BY tbl_hotel_image.hotel_image_id ASC LIMIT 1 ";
        $result_img1 = mysqli_query($conn, $sql_img1);
        $rs_img1 = mysqli_fetch_assoc($result_img1);
      ?>
        <div class="slide m-1">
          <div class="col-lg-11 col-md-11 mx-auto">
            <div class="card border border-0 bg-skys">
              <img src="./images/hotel_image/<?=$rs_img1['hotel_image_name']?>" class="card-img-top" alt="Los Angeles Skyscrapers" />
              <div class="card-body">
                <h5 class="card-title text-center"><a href="hotel"><?=$rs_hotel1['hotel_name']?></a></h5>
                <p class="card-text text-center"><a href="hotel"><?=$rs_hotel1['hotel_price']?>฿</a></p>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
    </section>

    <!-- End Contact Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php require './layout/footer.php'; ?>
  <!-- End Footer -->

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader">
    <div class="line"></div>
  </div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script type="text/javascript" src="./assets/vendor/slick/slick.min.js"></script>

  <!-- Swiper JS -->
  <script src="./app/node_modules/swiper/swiper-bundle.min.js"></script>

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

    async function stationTemp(lat, lon, id) {
      try {
        const responseOne = await axios.get(`https://api.openweathermap.org/data/2.5/onecall?lat=${lat}&lon=${lon}&units=metric&lang=th&appid=<?= $api_keys ?>`);
        let itemOne = responseOne.data;
        $('#dew_point_value').text(itemOne.current.dew_point);

        /* 7days Start */
        let itemOnes = responseOne.data.daily;
        let dataContent = '';
        for (let index = 0; index < itemOnes.length; index++) {
          const item = itemOnes[index];
          const skyData = parseInt(item.weather[0].icon, 10);

          if (index == 0) {
            if (skyData >= 1 && skyData <= 3) {
              if (skyData == 1) {
                dataContent = `${item.weather[0].description} เหมาะสมแก่การดูดาว`;
              } else {
                dataContent = `ท้องฟ้ามี${item.weather[0].description} เหมาะสมแก่การดูดาว`;
              }
            } else {
              dataContent = `ท้องฟ้ามี${item.weather[0].description} ยังไม่เหมาะสมแก่การดูดาว`;
            }
            $(`#${id}`).html(dataContent);
          }
        }
        /* 7days End */

      } catch (error) {
        console.error(error);
      }
    }
    <?php
    $sql_st2 = " SELECT * FROM tbl_station ORDER BY station_id ASC ";
    $result_st2 = mysqli_query($conn, $sql_st2);
    $no_st2 = 1;
    while ($rs_st2 = mysqli_fetch_assoc($result_st2)) {
      $lats = $rs_st2["station_lat"];
      $lons = $rs_st2["station_long"];
      $ctid = 'stat_des_' . $no_st2;
    ?>
      stationTemp('<?= $lats ?>', '<?= $lons ?>', '<?= $ctid ?>');
    <?php $no_st2++;
    } ?>
  </script>

</body>

</html>