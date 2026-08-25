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

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
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
            aspect-ratio: 16 / 9;
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
        .swiper_c1 {
            width: 100%;
            height: 100%;
        }

        .swiper_slide_c1 {
            text-align: center;
            font-size: 18px;
            background: transparent;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper_slide_c1 img {
            display: block;
            width: 100%;
            height: 100px;
            object-fit: contain;
        }

        /* Swipe End */

        .mySwiper2 .swiper {
            width: 100%;
            height: 100%;
        }

        .mySwiper2 .swiper-slide {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .mySwiper2 .sw-sls {
            padding: 0;
        }

        /* .swiper-slide img {
        } */

        .mySwiper2 .swiper-slide .card {
            border-color: var(--bs-primary-border-subtle);
            width: 100%;
        }

        .mySwiper2 .swiper-button-next,
        .mySwiper2 .swiper-button-prev {
            background-color: #5e7585;
            border-radius: 50%;
            width: var(--swiper-navigation-size);
            height: var(--swiper-navigation-size);
        }

        .mySwiper2 .swiper-button-next:after,
        .mySwiper2 .swiper-button-prev:after {
            font-size: 1.5rem;
        }

        :root {
            --swiper-theme-color: #bfe4e5;
        }

        /* css for 7days forcast start */
        .card-bg-none {
            background: transparent;
        }

        .ctp-sld {
            position: relative;
            margin-bottom: -1rem
        }

        .card-foot-small {
            margin-top: -1.5rem;
        }

        .img-sd-11 {
            object-fit: cover;
            aspect-ratio: 1 / 1;
        }

        /* css for 7days forcast end */

        .bg-htemp {
            background-color: #0d3b77;
        }

        .bg-horange {
            background-color: #f7630b;
        }

        .bg-forcasts {
            background-color: #cbddf6;
        }

        .text-for7day {
            color: #4281b7;
        }

        .bg-6cards {
            background-color: rgba(203, 221, 246, 0.7);
        }

        .bg-none {
            background: transparent;
        }
    </style>
</head>

<body>

    <!-- ======= Header ======= -->
    <?php require './layout/header.php'; ?>
    <!-- End Header -->

    <main id="main" data-aos="fade" data-aos-delay="1500">
        <!-- End Page Header -->

        <!-- Start -->
        <section>
            <div class="page-header d-flex align-items-center">
                <div class="container-fluid">
                    <div class="swiper swiper_c1 mySwiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide swiper_slide_c1">
                                <div class="col-lg-6 text-center mb-4">
                                    <img src="./images/art-sky-logo.png" alt="LOGO" class="d-block w-100">
                                    <h5 class="mt-2 fkanit color-sky">แอปพลิเคชั่นแผนที่ดาว</h5>
                                </div>
                            </div>
                            <div class="swiper-slide swiper_slide_c1">
                                <div class="col-lg-6 text-center mb-4">
                                    <img src="./images/logo-sci.png" alt="LOGO" class="d-block w-100">
                                    <h5 class="mt-2 fkanit color-sky">คณะวิทยาศาสตร์และเทคโนโลยี</h5>
                                </div>
                            </div>
                            <div class="swiper-slide swiper_slide_c1">
                                <div class="col-lg-6 text-center mb-4">
                                    <img src="./images/crru.png" alt="LOGO" class="d-block w-100">
                                    <h5 class="mt-2 fkanit color-sky">Chiangrai Rajabhat University</h5>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End -->

        <!-- ======= Contact Section ======= -->
        <?php
        if (isset($_GET['id'])) {
            $id = mysqli_real_escape_string($conn, $_GET['id']);
        }
        $sql_st = " SELECT * FROM tbl_station WHERE station_id = '$id' ";
        $result_st = mysqli_query($conn, $sql_st);
        $no_st = mysqli_num_rows($result_st);
        if ($no_st === 0) {
            header("location:index");
        }
        $rs_st = mysqli_fetch_assoc($result_st);
        ?>
        <div class="col-lg-12 text-center py-3 mb-3">
            <h2 id="day-1">สภาพอากาศ <?= $rs_st['station_name'] ?></h2>
            <h3 id="temp-now-1">28°</h3>
            <h4>
                <div id="temp-detail-1">แดดออกเป็นส่วนมาก</div>
                <div class="mt-1" id="temp-maxmin-1">สูงสุด: 32° ต่ำสุด: 20°</div>
            </h4>
        </div>
        <section class="art-skys">
            <div class="container">
                <div class="row gx-lg-5 gx-md-4 justify-content-center">
                    <div class="col-lg-4 col-6">
                        <div class="card shadow-sm border-0 card-bg-none">
                            <div class="text-light text-center p-0 ctp-sld">
                                <div class="col-10 bg-htemp mx-auto rounded-3 p-2">21:00</div>
                            </div>
                            <?php
                            $today = date("md");
                            ?>
                            <img src="images/star_image/<?= $today ?>pm.jpg" class="img-fluid rounded-3 img-sd-11 glightbox" alt="<div class='text-center fs-5'>21:00</div>">
                            <div class="bg-light rounded-3 col-11 mx-auto p-2 text-center small card-foot-small">
                                <span id="sky01">
                                    <br>

                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-6">
                        <div class="card shadow-sm border-0 card-bg-none">
                            <div class="text-light text-center p-0 ctp-sld">
                                <div class="col-10 bg-htemp mx-auto rounded-3 p-2">3:00</div>
                            </div>
                            <?php
                            $tomorrow = date("md", strtotime("+1 day"));
                            ?>
                            <img src="images/star_image/<?= $tomorrow ?>am.jpg" class="img-fluid rounded-3 img-sd-11 glightbox" alt="<div class='text-center fs-5'>3:00</div>">
                            <div class="bg-light rounded-3 col-11 mx-auto p-2 text-center small card-foot-small">
                                <span id="sky02">
                                    <br>

                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Contact Section -->
        <section class="mt-5">
            <div class="container py-4 rounded-3 bg-forcasts">
                <h3 class="text-for7day"><i class="bi bi-calendar-week"></i> พยากรณ์อากาศ 7 วัน</h3>
                <div class="swiper mySwiper2">
                    <div class="swiper-wrapper">
                        <?php
                        $today = date('Y-m-d');
                        for ($i = 1; $i < 7; $i++) {
                            $mydays = date('l', strtotime($today . ' +' . $i . ' days'));
                            $dm = date("md", strtotime("+" . $i . " day"));
                        ?>
                            <div class="swiper-slide sw-sls border-0">
                                <div class="card border-0 card-bg-none">
                                    <div class="text-light text-center p-0 ctp-sld">
                                        <div class="col-10 bg-htemp mx-auto rounded-3 p-2"><?= week_days($mydays) ?></div>
                                    </div>
                                    <img src="./images/star_image/<?= $dm ?>pm.jpg" class="img-fluid rounded-3 img-sd-11 glightbox" alt="<div class='text-center fs-5'><?= week_days($mydays) ?></div>">
                                    <img src="https://openweathermap.org/img/wn/02n.png" id="predays-img-<?= $i ?>" style="position: relative; margin-top: -4rem;" class="img-fluid ms-auto mb-3" width="50" alt="icon">
                                    <div class="bg-light rounded-3 col-11 mx-auto p-2 text-center small card-foot-small">
                                        <span id="predays-<?= $i ?>">
                                            <br>

                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="swiper-button-next shadow"></div>
                    <div class="swiper-button-prev shadow"></div>
                </div>
            </div>
        </section>
        <section class="py-5">
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6">
                        <div class="card bg-6cards">
                            <div class="h4 text-for7day card-header border-0 bg-none"><i class="bi bi-thermometer-sun"></i> อุณหภูมิ</div>
                            <div class="card-body">
                                <div class="rounded-3" id="map" style="aspect-ratio: 16 / 9;"></div>
                            </div>
                            <div class="card-footer border-0 text-primary h5 bg-none"><a class="text-primary" href="station-detail?id=<?= $rs_st['station_id'] ?>">ดูเพิ่มเติม</a> <span class="float-end"><a class="text-primary" href="station-detail?id=<?= $rs_st['station_id'] ?>"><i class="bi bi-chevron-right"></i></a></span></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card bg-6cards">
                            <div class="h4 text-for7day card-header border-0 bg-none"><i class="bi bi-sunset-fill"></i> อาทิตย์ตก</div>
                            <div class="card-body">
                                <h1 class="text-light mb-5 fw-bold" id="sun_set">18:00</h1>
                                <img src="./images/sunset_sunrise.png" class="img-fluid" style="margin-bottom: 1rem;" alt="sunset_sunrise">
                            </div>
                            <div class="card-footer border-0 text-light h5 bg-none mt-4 fw-bold">อาทิตย์ขึ้น : <span id="sun_rise">6:28</span></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card bg-6cards">
                            <div class="h4 text-for7day card-header border-0 bg-none"><i class="bi bi-sun-fill"></i> ดัชนีรังสี UV</div>
                            <div class="card-body">
                                <h1 class="text-light mb-5 fw-bold" id="uv0">0 <br>ต่ำ</h1>
                                <div class="progress-stacked" style="margin-bottom: 0.68rem;">
                                    <div class="progress" role="progressbar" aria-label="Segment one" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100" style="width: 15%">
                                        <div class="progress-bar" style="background-color: #5cc94d;" id="uv1"></div>
                                    </div>
                                    <div class="progress" role="progressbar" aria-label="Segment two" aria-valuenow="23" aria-valuemin="0" aria-valuemax="100" style="width: 23%">
                                        <div class="progress-bar" style="background-color: #ffff7f;" id="uv2"></div>
                                    </div>
                                    <div class="progress" role="progressbar" aria-label="Segment three" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100" style="width: 15%">
                                        <div class="progress-bar" style="background-color: #f19e4b;" id="uv3"></div>
                                    </div>
                                    <div class="progress" role="progressbar" aria-label="Segment four" aria-valuenow="23" aria-valuemin="0" aria-valuemax="100" style="width: 23%">
                                        <div class="progress-bar" style="background-color: #ea3323;" id="uv4"></div>
                                    </div>
                                    <div class="progress" role="progressbar" aria-label="Segment five" aria-valuenow="24" aria-valuemin="0" aria-valuemax="100" style="width: 24%">
                                        <div class="progress-bar" style="background-color: #c49bf9;" id="uv5"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer border-0 text-light h5 bg-none mt-4 fw-bold" id="uv6">ต่ำสำหรับเวลาที่เหลือ <br>ของวันนี้</div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card bg-6cards">
                            <div class="h4 text-for7day card-header border-0 bg-none"><i class="bi bi-droplet-fill"></i> ฝนตก</div>
                            <div class="card-body">
                                <h1 class="text-light mb-5 fw-bold ps-5"><span id="rain_value"></span> มม.<br>ใน 24 ชั่วโมงที่ <br>ผ่านมา</h1>
                            </div>
                            <div class="card-footer border-0 text-light h5 bg-none mt-4 fw-bold">&nbsp; <br><span id="pdr-tms"></span></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card bg-6cards">
                            <div class="h4 text-for7day card-header border-0 bg-none"><i class="bi bi-eye"></i> ทัศนวิสัย</div>
                            <div class="card-body">
                                <h1 class="text-light mb-5 fw-bold ps-5"><span id="visibility_val">8</span> กม.<br>&nbsp;<br>&nbsp;</h1>
                            </div>
                            <div class="card-footer border-0 text-light h5 bg-none mt-4 fw-bold">
                                เมฆหมอกบางส่วนส่งผลกระทบ <br>ต่อทัศนวิสัย
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card bg-6cards">
                            <div class="h4 text-for7day card-header border-0 bg-none"><i class="bi bi-moisture"></i> ความชื้น</div>
                            <div class="card-body">
                                <h1 class="text-light mb-5 fw-bold ps-5"><span id="humidity_val">32</span>%<br>&nbsp;<br>&nbsp;</h1>
                            </div>
                            <div class="card-footer border-0 text-light h5 bg-none mt-4 fw-bold">
                                จุดน้ำค้างอยู่ที่ <span id="dew_point_value">22.63</span>° ใน<br>ตอนนี้
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ======= Related news Section ======= -->
            <section class="mt-3">
                <div class="container">
                    <div class="bg-skys p-3 p-md-4">
                        <div class="section-title mb-3">
                            <h4 class="fkanit"><i class="bi bi-stars me-2"></i>ข่าวสารอื่นๆ จาก ART SKY</h4>
                            <div class="section-title-line"></div>
                        </div>

                        <div class="swiper mySwiper3">
                            <div class="swiper-wrapper">
                                <?php
                                $sql_news = " SELECT * FROM tbl_news WHERE station_id = '{$_GET['id']}' ORDER BY tbl_news.news_id DESC LIMIT 6";
                                $result_news = mysqli_query($conn, $sql_news);
                                while ($rs_news = mysqli_fetch_assoc($result_news)) {
                                ?>
                                    <div class="swiper-slide">
                                        <div class="card">
                                            <a href="news-detail?id=<?= $rs_news['news_id'] ?>" style="display:block">
                                                <img src="./images/news/<?= $rs_news['news_image'] ?>" class="card-img-top img-newss" alt="<?= $rs_news['news_name'] ?>" />
                                                <div class="card-body">
                                                    <h5 class="card-title mb-2">
                                                        <a href="news-detail?id=<?= $rs_news['news_id'] ?>">
                                                            <?= mb_substr($rs_news['news_name'], 0, 50, 'UTF-8'); ?>...
                                                        </a>
                                                    </h5>
                                                    <p class="card-text text-end mb-0">
                                                        <a href="news-detail?id=<?= $rs_news['news_id'] ?>">
                                                            <i class="bi bi-clock"></i> <?= date_inters($rs_news['news_date']) ?>
                                                        </a>
                                                    </p>
                                                </div>
                                            </a>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="./assets/vendor/slick/slick.min.js"></script>
    <script type="text/javascript" src="./app/node_modules/axios/dist/axios.min.js"></script>

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
            }
        });

        var swiper2 = new Swiper(".mySwiper2", {
            slidesPerView: 2,
            spaceBetween: 25,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                520: {
                    slidesPerView: 2
                },
                768: {
                    slidesPerView: 3
                },
                1024: {
                    slidesPerView: 4
                },
            },
        });

        var swiper3 = new Swiper(".mySwiper3", {
            slidesPerView: 3,
            spaceBetween: 25,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                520: {
                    slidesPerView: 2
                },
                768: {
                    slidesPerView: 3
                },
                1024: {
                    slidesPerView: 4
                },
            },
        });

        $(async () => {
            try {
                const response = await axios.get(`weather-api.php?endpoint=weather&lat=<?= rawurlencode($rs_st['station_lat']) ?>&lon=<?= rawurlencode($rs_st['station_long']) ?>`);
                let item = response.data;

                $('#temp-now-1').text(item.main.temp + '°');
                $('#temp-detail-1').html(`${item.weather[0].description}  <img src="https://openweathermap.org/img/wn/${item.weather[0].icon}.png" alt="icon">`);
                $('#temp-maxmin-1').text(`สูงสุด: ${item.main.temp_max}° ต่ำสุด: ${item.main.temp_min}°`);

                $('#visibility_val').text((item.visibility / 1000).toFixed(1));
                $('#humidity_val').text(item.main.humidity);

                if (item.main.humidity > 80 && (item.rain['1h'] < 0.05 || item.rain['3h'] < 0.05)) {
                    $('#sky01').html('เมฆหมอกเยอะ ยังไม่เหมาะแก่การดูดูาว');
                }
                if (item.main.humidity > 80 && (item.rain['1h'] < 0.05 || item.rain['3h'] < 0.05)) {
                    $('#sky02').html('เมฆหมอกเยอะ ยังไม่เหมาะแก่การดูดูาว');
                }
                if (item.rain['1h'] > 0.05 || item.rain['3h'] > 0.05) {
                    $('#sky02').html('มีฝนตก ยังไม่เหมาะแก่การดูดูาว');
                }

                const sunrise = epochToThaiTime(item.sys.sunrise);
                const sunset = epochToThaiTime(item.sys.sunset);
                $('#sun_set').text(sunset);
                $('#sun_rise').text(sunrise);

                if (item.rain) {
                    if (item.rain['1h']) {
                        $('#rain_value').text(item.rain['1h']);
                    }
                    if (item.rain['3h']) {
                        $('#rain_value').text(item.rain['3h']);
                    }
                } else {
                    $('#rain_value').text(0);
                }

            } catch (error) {
                console.error(error);
            }
        });

        $(async () => {
            try {
                const response2 = await axios.get(`weather-api.php?endpoint=uvi&lat=<?= rawurlencode($rs_st['station_lat']) ?>&lon=<?= rawurlencode($rs_st['station_long']) ?>`);
                let item2 = response2.data;
                let uvIndex = item2.value;

                if (uvIndex <= 2) {
                    // เขียว ต่ำ
                    $('#uv0').html(`${uvIndex} <br>ต่ำ`);
                    $('#uv6').html('ต่ำสำหรับเวลาที่เหลือ <br>ของวันนี้');
                    $('#uv1').html('<i class="bi bi-check-circle-fill"></i>');

                } else if (uvIndex >= 3 && uvIndex <= 5) {
                    // เหลือง ปานกลาง
                    $('#uv0').html(`${uvIndex} <br>ปานกลาง`);
                    $('#uv6').html('ปานกลางสำหรับเวลาที่เหลือ <br>ของวันนี้');
                    $('#uv2').html('<i class="bi bi-check-circle-fill"></i>');

                } else if (uvIndex >= 6 && uvIndex <= 7) {
                    // ส้ม สูง
                    $('#uv0').html(`${uvIndex} <br>สูง`);
                    $('#uv6').html('สูงสำหรับเวลาที่เหลือ <br>ของวันนี้');
                    $('#uv3').html('<i class="bi bi-check-circle-fill"></i>');

                } else if (uvIndex >= 8 && uvIndex <= 10) {
                    // แดง สูงมาก
                    $('#uv0').html(`${uvIndex} <br>สูงมาก`);
                    $('#uv6').html('สูงมากสำหรับเวลาที่เหลือ <br>ของวันนี้');
                    $('#uv4').html('<i class="bi bi-check-circle-fill"></i>');
                } else {
                    // ม่วง สูงจัด
                    $('#uv0').html(`${uvIndex} <br>สูงจัด`);
                    $('#uv6').html('สูงจัดสำหรับเวลาที่เหลือ <br>ของวันนี้');
                    $('#uv5').html('<i class="bi bi-check-circle-fill"></i>');
                }
            } catch (error) {
                console.error(error);
            }
        });



        const map = L.map('map').setView([<?= $rs_st['station_lat'] ?>, <?= $rs_st['station_long'] ?>], 13);
        const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
        const popup = L.popup()
            .setLatLng([<?= $rs_st['station_lat'] ?>, <?= $rs_st['station_long'] ?>])
            .setContent($('#temp-now-1').text())
            .openOn(map);

        function onMapClick(e) {
            popup
                .setLatLng(e.latlng)
                .setContent(`${e.latlng.lat.toFixed(3)},${e.latlng.lng.toFixed(2)}`)
                .openOn(map);
        }
        map.on('click', onMapClick);


        function epochToThaiTime(epoch) {
            const timestamp = epoch;
            const date = new Date(timestamp * 1000);
            const hours = date.getHours().toString().padStart(2, '0');
            const minutes = date.getMinutes().toString().padStart(2, '0');
            const time = `${hours}:${minutes}`;
            return time;
        }

        $(async () => {
            try {
                let content = '';
                const response = await axios.get('weather-api.php?endpoint=forecast&lat=<?= rawurlencode($rs_st['station_lat']) ?>&lon=<?= rawurlencode($rs_st['station_long']) ?>');
                let item = response.data.list;
                const daysEn = tmDays();
                const dayTh = weekDays(daysEn);
                for (let index = 0; index < item.length; index++) {
                    const element = item[index];
                    if (getTomorrowDate() == extractDate(element.dt_txt)) {
                        if (element.rain) {
                            if (typeof element.rain['1h'] !== undefined) {
                                rain_hour = element.rain['1h'];
                            }
                            if (typeof element.rain['3h'] !== undefined) {
                                rain_hour = element.rain['3h'];
                            }
                        } else {
                            rain_hour = 0;
                        }
                        if (rain_hour > 0 || typeof rain_hour !== undefined) {
                            if (rain_hour > 0) {
                                content = `<div>คาดว่าวัน${dayTh}มีฝน ${rain_hour} มม.</div>`;
                            }
                        }
                    }
                }
                if (content) {
                    $('#pdr-tms').html(content);
                } else {
                    $('#pdr-tms').html(`<div>คาดว่าวัน${dayTh}ไม่มีฝนตก</div>`);
                }
            } catch (error) {
                console.error(error);
            }
        });

        function extractDate(dateTimeString) {

            const dateObject = new Date(dateTimeString);

            const year = dateObject.getFullYear();
            const month = String(dateObject.getMonth() + 1).padStart(2, '0');
            const day = String(dateObject.getDate()).padStart(2, '0');

            const formattedDate = `${year}-${month}-${day}`;

            return formattedDate;
        }

        function getTomorrowDate() {
            const today = new Date();
            today.setDate(today.getDate() + 1); // Add 1 day to get tomorrow's date
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0'); // Pad month with leading zero
            const day = String(today.getDate()).padStart(2, '0'); // Pad day with leading zero

            return `${year}-${month}-${day}`;
        }

        function tmDays() {
            const today = new Date().toISOString().slice(0, 10);
            const tomorrow = new Date(today);
            tomorrow.setDate(tomorrow.getDate() + 1);
            const dayOfWeek = tomorrow.toLocaleDateString('en-US', {
                weekday: 'long'
            });
            return dayOfWeek;
        }

        function weekDays(dayName) {
            switch (dayName) {
                case 'Sunday':
                    return 'อาทิตย์';
                case 'Saturday':
                    return 'เสาร์';
                case 'Monday':
                    return 'จันทร์';
                case 'Tuesday':
                    return 'อังคาร';
                case 'Wednesday':
                    return 'พุธ';
                case 'Thursday':
                    return 'พฤหัส';
                case 'Friday':
                    return 'ศุกร์';
                default:
                    return 'Invalid day name';
            }
        }

        $(async () => {
            try {
                const responseOne = await axios.get(`weather-api.php?endpoint=onecall&lat=<?= rawurlencode($rs_st['station_lat']) ?>&lon=<?= rawurlencode($rs_st['station_long']) ?>`);
                let itemOne = responseOne.data;
                $('#dew_point_value').text(itemOne.current.dew_point);

                /* 7days Start */
                let itemOnes = responseOne.data.daily;
                let dataContent = '';
                let dataImg = '';
                for (let index = 0; index < itemOnes.length; index++) {
                    const item = itemOnes[index];
                    const skyData = parseInt(item.weather[0].icon, 10);

                    if (index == 0) {
                        if (skyData >= 1 && skyData <= 3) {
                            if (skyData == 1) {
                                dataContent = `<div>${item.weather[0].description} <br> เหมาะสมแก่การดูดาว</div>`;
                            } else {
                                dataContent = `<div>ท้องฟ้ามี${item.weather[0].description} <br> เหมาะสมแก่การดูดาว</div>`;
                            }
                        } else {
                            dataContent = `<div>ท้องฟ้ามี${item.weather[0].description} <br> ยังไม่เหมาะสมแก่การดูดาว</div>`;
                        }
                        $('#sky01').html(dataContent);
                    }

                    if (index == 1) {
                        if (skyData >= 1 && skyData <= 3) {
                            if (skyData == 1) {
                                dataContent = `<div>${item.weather[0].description} <br> เหมาะสมแก่การดูดาว</div>`;
                            } else {
                                dataContent = `<div>ท้องฟ้ามี${item.weather[0].description} <br> เหมาะสมแก่การดูดาว</div>`;
                            }
                        } else {
                            dataContent = `<div>ท้องฟ้ามี${item.weather[0].description} <br> ยังไม่เหมาะสมแก่การดูดาว</div>`;
                        }
                        $('#sky02').html(dataContent);
                    }

                    if (index > 0) {
                        if (skyData >= 1 && skyData <= 3) {
                            if (skyData == 1) {
                                dataContent = `<div>${item.weather[0].description} <br> เหมาะสมแก่การดูดาว</div>`;
                            } else {
                                dataContent = `<div>ท้องฟ้ามี${item.weather[0].description} <br> เหมาะสมแก่การดูดาว</div>`;
                            }
                        } else {
                            dataContent = `<div>ท้องฟ้ามี${item.weather[0].description} <br> ยังไม่เหมาะสมแก่การดูดาว</div>`;
                        }
                        dataImg = `https://openweathermap.org/img/wn/${item.weather[0].icon}.png`;
                        $(`#predays-img-${index}`).attr('src', dataImg);
                        $(`#predays-${index}`).html(dataContent);
                    }
                }
                /* 7days End */

            } catch (error) {
                console.error(error);
            }
        });
    </script>
</body>

</html>
