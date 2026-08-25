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
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/main2.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" type="text/css" href="./assets/vendor/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="./assets/vendor/slick/slick-theme.css" />

    <style>
        /* ===== Base Background – Liquid Glass Sky ===== */
        body {
            background: url("./images/head_bg.jpg") no-repeat top center fixed;
            background-size: cover;
        }

        body::before {
            top: -10rem;
            left: -12rem;
        }

        body::after {
            bottom: -10rem;
            right: -12rem;
        }

        #header {
            background: transparent;
        }

        .fkanit {
            font-family: "Noto Serif Thai", serif;
            font-weight: 400;
            font-style: normal;
        }

        /* ===== Main Glass Container ===== */
        .section-wrapper {
            margin-top: 7.5rem;
            margin-bottom: 3.5rem;
        }

        .glass-shell {
            position: relative;
            border-radius: 1.8rem;
            padding: 2.5rem 1.75rem 2.75rem;
            background: linear-gradient(135deg,
                    rgba(255, 255, 255, 0.14),
                    rgba(255, 255, 255, 0.04));
            border: 1px solid rgba(255, 255, 255, 0.22);
            box-shadow:
                0 24px 60px rgba(0, 0, 0, 0.65),
                0 0 0 1px rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(22px) saturate(150%);
            -webkit-backdrop-filter: blur(22px) saturate(150%);
            overflow: hidden;
        }

        .glass-shell::before,
        .glass-shell::after {
            content: "";
            position: absolute;
            width: 18rem;
            height: 18rem;
            border-radius: 50%;
            filter: blur(40px);
            opacity: 0.65;
            z-index: -1;
            background: radial-gradient(circle,
                    rgba(96, 165, 250, 0.8),
                    rgba(59, 130, 246, 0.1),
                    transparent 70%);
            animation: floatBlob 18s ease-in-out infinite alternate;
        }

        .glass-shell::before {
            top: -6rem;
            left: -5rem;
        }

        .glass-shell::after {
            bottom: -7rem;
            right: -6rem;
            background: radial-gradient(circle,
                    rgba(244, 114, 182, 0.85),
                    rgba(147, 51, 234, 0.1),
                    transparent 70%);
            animation-duration: 22s;
        }

        @keyframes floatBlob {
            0% {
                transform: translate3d(0, 0, 0) scale(1);
            }

            100% {
                transform: translate3d(20px, -30px, 0) scale(1.05);
            }
        }

        /* ===== Text / Labels ===== */
        .page-title {
            letter-spacing: 0.09em;
            text-transform: uppercase;
            font-size: 0.92rem;
            color: rgba(226, 232, 255, 0.9);
        }

        .page-heading {
            font-size: 1.7rem;
            font-weight: 600;
            color: #ffffff;
        }

        .page-subtitle {
            color: rgba(214, 226, 255, 0.9);
        }

        .badge-station {
            background: radial-gradient(circle at 0% 0%,
                    rgba(56, 189, 248, 0.6),
                    rgba(59, 130, 246, 0.18));
            border: 1px solid rgba(191, 219, 254, 0.85);
            color: #e0f2ff;
            border-radius: 999px;
            padding: 0.28rem 0.95rem;
            font-size: 0.82rem;
        }

        .helper-text {
            font-size: 0.88rem;
            color: rgba(226, 235, 255, 0.86);
        }

        /* ===== Cards – Liquid Glass Panels ===== */
        .panel-glass {
            border-radius: 1.4rem;
            padding: 1rem 1rem 1.1rem;
            background: linear-gradient(145deg,
                    rgba(15, 23, 42, 0.92),
                    rgba(15, 23, 42, 0.78));
            border: 1px solid rgba(148, 163, 254, 0.40);
            box-shadow:
                0 18px 40px rgba(15, 23, 42, 0.85),
                0 0 0 1px rgba(30, 64, 175, 0.35);
        }

        .panel-glass-soft {
            border-radius: 1.4rem;
            padding: 1rem 1.1rem;
            background: radial-gradient(circle at top,
                    rgba(248, 250, 252, 0.18),
                    rgba(15, 23, 42, 0.88));
            border: 1px solid rgba(148, 163, 254, 0.35);
            box-shadow:
                0 18px 40px rgba(15, 23, 42, 0.85),
                0 0 0 1px rgba(30, 64, 175, 0.25);
        }

        .panel-header-title {
            color: #bfdbfe;
            font-weight: 600;
        }

        /* ===== Map & Star Map ===== */
        #starmap1 {
            border-radius: 1.1rem;
            width: 100%;
            aspect-ratio: 16/9;
            overflow: hidden;
            background:
                radial-gradient(circle at 10% 0%, rgba(248, 250, 252, 0.16), transparent 60%),
                radial-gradient(circle at 90% 80%, rgba(96, 165, 250, 0.2), transparent 60%),
                radial-gradient(circle at 50% 120%, rgba(30, 64, 175, 0.85), rgba(15, 23, 42, 0.95));
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.9);
        }

        #starmap1_inner {
            border-radius: 1.1rem !important;
        }

        .map-shell {
            border-radius: 1.2rem;
            background: radial-gradient(circle at top,
                    rgba(248, 250, 252, 0.12),
                    rgba(15, 23, 42, 0.95));
            border: 1px solid rgba(148, 163, 254, 0.4);
            box-shadow:
                0 18px 40px rgba(15, 23, 42, 0.85),
                0 0 0 1px rgba(30, 64, 175, 0.3);
            overflow: hidden;
        }

        .map-shell-inner {
            aspect-ratio: 16/9;
            width: 100%;
        }

        #map {
            width: 100%;
            height: 100%;
        }

        /* ===== Buttons – Liquid Pills ===== */
        .btn-location-main {
            height: 3.2rem;
            font-size: 0.98rem;
            font-weight: 600;
            border-radius: 999px;
            border: none;
            background:
                radial-gradient(circle at 0% 0%, rgba(59, 130, 246, 1), rgba(59, 130, 246, 0.85)),
                linear-gradient(135deg, rgba(56, 189, 248, 0.95), rgba(59, 130, 246, 0.98));
            color: #e5f3ff;
            box-shadow:
                0 10px 24px rgba(37, 99, 235, 0.8),
                0 0 0 1px rgba(191, 219, 254, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.45rem;
            transition: transform 0.15s ease, box-shadow 0.15s ease, filter 0.15s ease, opacity 0.15s ease;
        }

        .btn-location-main i {
            font-size: 1.2rem;
        }

        .btn-location-main:hover {
            transform: translateY(-1px);
            filter: brightness(1.06);
            box-shadow:
                0 14px 30px rgba(37, 99, 235, 0.95),
                0 0 0 1px rgba(219, 234, 254, 0.7);
            opacity: 0.98;
        }

        .btn-location-main:active {
            transform: translateY(1px) scale(0.99);
            box-shadow:
                0 6px 14px rgba(37, 99, 235, 0.8),
                0 0 0 1px rgba(191, 219, 254, 0.6);
        }

        .btn-ghost-light {
            border-radius: 999px;
            border: 1px solid rgba(226, 232, 255, 0.6);
            color: rgba(226, 232, 255, 0.94);
            background: radial-gradient(circle at 0% 0%,
                    rgba(248, 250, 252, 0.22),
                    rgba(15, 23, 42, 0.9));
            font-weight: 500;
            height: 3.1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            transition: background 0.16s ease, transform 0.12s ease, box-shadow 0.16s ease;
        }

        .btn-ghost-light:hover {
            background: radial-gradient(circle at 0% 0%,
                    rgba(248, 250, 252, 0.32),
                    rgba(15, 23, 42, 0.9));
            transform: translateY(-0.5px);
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.8);
        }

        .btn-ghost-light i {
            font-size: 1.05rem;
        }

        /* ===== Scroll-top button tweak ===== */
        .scroll-top {
            background: radial-gradient(circle at 0% 0%,
                    rgba(59, 130, 246, 0.9),
                    rgba(30, 64, 175, 0.9));
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.85);
        }

        /* ===== Responsive ===== */
        @media (max-width: 991.98px) {
            .section-wrapper {
                margin-top: 6.5rem;
            }

            .glass-shell {
                padding: 2rem 1.4rem 2.4rem;
            }

            .page-heading {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 575.98px) {
            #starmap1 {
                aspect-ratio: 4/3;
            }

            .map-shell-inner {
                aspect-ratio: 4/3;
            }
        }
    </style>

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</head>

<body class="fkanit">

    <!-- ======= Header ======= -->
    <?php require './layout/header.php'; ?>
    <!-- End Header -->

    <main id="main" data-aos="fade" data-aos-delay="1500">
        <?php
        $sql_st = " SELECT * FROM tbl_station ORDER BY RAND() LIMIT 1 ";
        $result_st = mysqli_query($conn, $sql_st);
        $no_st = mysqli_num_rows($result_st);
        if ($no_st === 0) {
            header("location:index");
        }
        $rs_st = mysqli_fetch_assoc($result_st);
        ?>

        <section class="section-wrapper">
            <div class="container-xl px-3 px-md-4">
                <div class="glass-shell">
                    <!-- Header / Intro -->
                    <div class="row align-items-start mb-4 mb-md-5">
                        <div class="col-lg-8">
                            <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                <span class="badge-station">
                                    <i class="bi bi-compass me-1"></i>
                                    สถานีสังเกตการณ์: ณ พิกัดที่เลือก
                                </span>
                            </div>
                            <div class="page-title mb-1">
                                ART SKY · STAR &amp; EARTH VIEW
                            </div>
                            <h1 class="page-heading mb-2">
                                แผนที่ท้องฟ้า &amp; ตำแหน่งดาวแบบ Real-time
                            </h1>
                            <p class="page-subtitle mb-0">
                                ดูท้องฟ้ายามค่ำคืนและพิกัดโลกจากตำแหน่งสถานี หรือใช้ตำแหน่งปัจจุบันของคุณ
                                เพื่อสัมผัสประสบการณ์ดูดาวแบบ interactive ในสไตล์ liquid glass UI
                            </p>
                        </div>
                        <div class="col-lg-4 mt-3 mt-lg-0">
                            <p class="helper-text text-lg-end mb-0">
                                แนะนำ: อนุญาตการเข้าถึงตำแหน่ง (Location) บนอุปกรณ์ของคุณ
                                เพื่อให้ระบบกำหนดพิกัดดาวและแผนที่ตรงกับตำแหน่งจริงแบบอัตโนมัติ
                            </p>
                        </div>
                    </div>

                    <div class="row g-4">
                        <!-- Star Map Panel -->
                        <div class="col-12">
                            <div class="panel-glass-soft">
                                <div class="d-flex justify-content-between align-items-center mb-2 mb-md-3">
                                    <div>
                                        <h5 class="panel-header-title mb-1">
                                            แผนที่ท้องฟ้า (Star Map)
                                        </h5>
                                        <small class="helper-text">
                                            แสดงกลุ่มดาวและตำแหน่งดาวสำคัญ ณ พิกัดที่เลือก
                                        </small>
                                    </div>
                                </div>
                                <div id="starmap1"></div>
                            </div>
                        </div>

                        <!-- Map -->
                        <div class="col-lg-7">
                            <div class="map-shell p-2 p-md-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <h5 class="panel-header-title mb-1">
                                            แผนที่ตำแหน่งสังเกตการณ์
                                        </h5>
                                        <small class="helper-text">
                                            พิกัดสถานี / พิกัดปัจจุบันของคุณจะแสดงบนแผนที่ พร้อมค่า Latitude / Longitude
                                        </small>
                                    </div>
                                </div>
                                <div id="show-map" class="map-shell-inner rounded-3 position-relative">
                                    <!-- map div will be injected here -->
                                </div>
                            </div>
                        </div>

                        <!-- Controls -->
                        <div class="col-lg-5">
                            <div class="h-100 d-flex flex-column">
                                <div class="panel-glass flex-grow-1 d-flex flex-column">
                                    <h5 class="panel-header-title mb-2">
                                        เลือกตำแหน่งแสดงผล
                                    </h5>
                                    <p class="helper-text mb-3">
                                        กด “ใช้ตำแหน่งปัจจุบันของฉัน” เพื่อใช้ GPS ของอุปกรณ์
                                        หรือกด “กลับไปตำแหน่งสถานี” เพื่อย้อนกลับไปดูจากพิกัดสถานีหลัก
                                    </p>

                                    <div class="d-grid gap-2 mt-auto">
                                        <button type="button" id="mylocation" class="btn-location-main">
                                            <i class="bi bi-geo-alt-fill"></i>
                                            <span>ใช้ตำแหน่งปัจจุบันของฉัน</span>
                                        </button>

                                        <button type="button" id="originals" class="btn-ghost-light">
                                            <i class="bi bi-arrow-counterclockwise"></i>
                                            <span>กลับไปตำแหน่งสถานี</span>
                                        </button>
                                    </div>
                                </div>

                                <div class="helper-text small text-center text-md-start mt-2">
                                    <i class="bi bi-shield-lock me-1"></i>
                                    ข้อมูลตำแหน่งของคุณใช้เฉพาะในหน้าจอนี้ เพื่อแสดงแผนที่และท้องฟ้าตามพิกัดเท่านั้น
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- ======= Footer ======= -->
    <br><br><br><br><br><br><br><br><br><br>
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

    <!-- Libs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
        integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="./app/node_modules/axios/dist/axios.min.js"></script>
    <script type="text/javascript" src="./assets/vendor/slick/slick.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- virtualsky -->
    <script src="./assets/vendor/virtualsky/stuquery.min.js"></script>
    <script src="./assets/vendor/virtualsky/virtualsky.min.js"></script>

    <script>
        // === Logic เดิม: mapStation / beginLo / mylocations / showPosition / handleError ===
        const mapStation = (lat, lon, locals) => {
            const map = L.map('map').setView([lat, lon], 13);

            const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            const marker = L.marker([lat, lon]).addTo(map)
                .bindPopup(`${locals}<br> ${lat.toFixed(3)},${lon.toFixed(3)}`)
                .openPopup();

            // Sky Map
            S.virtualsky({
                id: 'starmap1',
                projection: 'stereo',
                latitude: lat.toFixed(3),
                longitude: lon.toFixed(3),
                showstarlabels: true,
                ground: false,
                constellations: true,
            });
            $('#starmap1_inner').addClass('rounded-3');
        }

        beginLo();

        function beginLo() {
            $('#show-map').html('');
            $('#show-map').html(`<div id="map" class="rounded-3 w-100 h-100"></div>`);
            mapStation(<?= $rs_st['station_lat'] ?>, <?= $rs_st['station_long'] ?>, '<?= $rs_st['station_name'] ?>');
        }

        // My Location (logic เดิม: ใช้ navigator.geolocation)
        $('#mylocation').click(async () => {
            $('#show-map').html('');
            Swal.showLoading();
            $('#show-map').html(`<div id="map" class="rounded-3 w-100 h-100"></div>`);
            await navigator.geolocation.getCurrentPosition(showPosition, handleError);
        });

        async function mylocations() {
            $('#show-map').html('');
            Swal.showLoading();
            $('#show-map').html(`<div id="map" class="rounded-3 w-100 h-100"></div>`);
            await navigator.geolocation.getCurrentPosition(showPosition, handleError);
        }

        // Default Location
        $('#originals').click(() => {
            beginLo()
        });

        function showPosition(position) {
            mapStation(position.coords.latitude, position.coords.longitude, 'ตำแหน่งปัจจุบัน');
            if (position.coords.latitude && position.coords.longitude) {
                Swal.close();
            }
        }

        function handleError(error) {
            console.error("Error:", error.message);
        }

        function getThaiDate(dt, timezone) {
            const utcDatetime = new Date(dt * 1000 + timezone * 1000);
            const thaiYear = utcDatetime.getFullYear() + 543;
            const thaiMonth = {
                1: "มกราคม",
                2: "กุมภาพันธ์",
                3: "มีนาคม",
                4: "เมษายน",
                5: "พฤษภาคม",
                6: "มิถุนายน",
                7: "กรกฎาคม",
                8: "สิงหาคม",
                9: "กันยายน",
                10: "ตุลาคม",
                11: "พฤศจิกายน",
                12: "ธันวาคม",
            }[utcDatetime.getMonth() + 1];
            const thaiDay = {
                0: "อาทิตย์",
                1: "จันทร์",
                2: "อังคาร",
                3: "พุธ",
                4: "พฤหัสบดี",
                5: "ศุกร์",
                6: "เสาร์",
            }[utcDatetime.getDay()];

            return `${thaiDay}ที่ ${utcDatetime.getDate()} ${thaiMonth} พ.ศ. ${thaiYear}`;
        }

        function getThaiTime(dt, timezone) {
            const dateTime = new Date(dt * 1000);
            const toUtc = dateTime.getTime() + dateTime.getTimezoneOffset() * 60000;
            const currentLocalTime = toUtc + 1000 * timezone;
            const selectedDate = new Date(currentLocalTime);
            const hour = selectedDate.toLocaleString("th-TH", {
                hour: "2-digit",
                minute: "2-digit",
                hour12: false,
            });
            return `${hour}`;
        }

        async function showWheather(lat, lon) {
            try {
                const response = await axios.get(`weather-api.php?endpoint=weather&lat=${encodeURIComponent(lat)}&lon=${encodeURIComponent(lon)}`);
                let item = response.data;
                let img_icon = `<img src="https://openweathermap.org/img/wn/${item.weather[0].icon}.png" alt="icon" />`
                $('#data_1').text(item.name);
                $('#data_2').html(item.weather[0].description + ' ' + img_icon);
                $('#data_3').text(`${item.main.temp}°`);
                $('#data_4').text(getThaiTime(item.dt, item.timezone));
                $('#data_5').text(getThaiDate(item.dt, item.timezone));
                $('#data_6').text(item.clouds.all + '%');
                $('#data_7').text(item.visibility / 1000);
                $('#data_8').text(item.main.grnd_level || '-');
            } catch (error) {
                console.error(error);
            }
        }

        // ถ้าจะใช้ weather widget เดิมให้ uncomment ตรงนี้
        // showWheather(<?= $rs_st['station_lat'] ?>, <?= $rs_st['station_long'] ?>);

        // เริ่มด้วยการลองใช้ตำแหน่งปัจจุบัน (เหมือน logic เดิม)
        mylocations();
    </script>
</body>

</html>
