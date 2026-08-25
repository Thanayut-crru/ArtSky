<?php
require 'config/connect.php';
require 'config/function.php';
?>
<!DOCTYPE html>
<html>

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
    <meta name="theme-color" content="#000000">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

    <link href="assets/css/main2.css" rel="stylesheet">

    <!-- Leaflet -->
    <!-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/> -->
    <link rel="stylesheet" href="./assets/dist/leaflet.css" />

    <!-- Icons -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/> -->
    <link rel="stylesheet" href="./app/plugins/fontawesome-free/css/all.min.css" />

    <!-- Fancybox -->
    <link rel="stylesheet" href="./app/plugins/fancybox/fancybox.css" />

    <style>
        body {
            background-color: #020617;
            color: #e5e7eb;
            /* font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; */
        }

        #map {
            width: 100%;
            height: 100vh;
            z-index: 1;
        }

        /* Offcanvas panel */
        #demo {
            background: radial-gradient(circle at top, #0f172a 0, #020617 45%, #020617 100%),
                url("./images/head_bg.jpg") no-repeat top center fixed;
            background-size: cover;
            color: #e5e7eb;
        }

        #demo::before {
            content: "";
            position: absolute;
            inset: 0;
            background: url("./images/head_bg.jpg") no-repeat top center fixed;
            background-size: cover;
            backdrop-filter: blur(8px);
            z-index: -1;
        }

        /* #demo {
      background: url("./images/head_bg.jpg") no-repeat top center fixed;
      background-size: cover;
    } */

        body .offcanvas {
            --bs-offcanvas-height: 45vh !important;
        }


        .offcanvas-header {
            border-bottom: 1px solid rgba(148, 163, 184, 0.3);
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .offcanvas-title a {
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            font-size: 1.1rem;
        }

        .offcanvas-body {
            padding: 0.75rem 0.75rem 1rem;
            overflow-y: auto;
        }

        /* Toggle button slide animation */
        .offcanvas-btn-box {
            transition: transform .3s ease-in-out;
        }

        .offcanvas.show+div .offcanvas-btn-box {
            transform: translateX(400px);
            position: relative;
            z-index: 1100;
        }

        .offcanvas-btn-box .btn span:last-child,
        .offcanvas.show+div .offcanvas-btn-box .btn span:first-child {
            display: none;
        }

        .offcanvas.show+div .offcanvas-btn-box .btn span:last-child {
            display: inline;
        }

        /* Search box */
        .search-wrapper {
            background: rgba(15, 23, 42, 0.85);
            border-radius: 1rem;
            padding: 0.75rem;
            box-shadow: 0 16px 30px rgba(15, 23, 42, 0.55);
            margin-bottom: 0.75rem;
        }

        .search-wrapper .form-control {
            border-radius: 999px 0 0 999px !important;
            border: none;
            background-color: rgba(15, 23, 42, 0.9);
            color: #e5e7eb;
            font-size: 0.9rem;
        }

        .search-wrapper .form-control::placeholder {
            color: #64748b;
            font-size: 0.85rem;
        }

        .search-wrapper .btn-search-main {
            border-radius: 0 999px 999px 0 !important;
            border: none;
            font-size: 0.9rem;
            padding-inline: 0.9rem;
        }

        .search-wrapper .btn-location {
            border-radius: 999px;
            font-size: 0.85rem;
            padding-inline: 0.9rem;
        }

        /* Hotel cards */
        .hotel-card {
            background: radial-gradient(circle at top left, rgba(56, 189, 248, 0.10), rgba(15, 23, 42, 0.95));
            border-radius: 1rem;
            padding: 0.85rem;
            margin-bottom: 0.75rem;
            border: 1px solid rgba(148, 163, 184, 0.25);
            box-shadow: 0 16px 30px rgba(15, 23, 42, 0.65);
            display: flex;
            gap: 0.75rem;
            align-items: stretch;
            transition: all .2s ease-out;
        }

        .hotel-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 22px 40px rgba(15, 23, 42, 0.9);
            border-color: rgba(96, 165, 250, 0.7);
        }

        .hotel-card .hotel-image {
            width: 96px;
            min-width: 96px;
            height: 96px;
            border-radius: 0.85rem;
            object-fit: cover;
            border: 1px solid rgba(148, 163, 184, 0.4);
        }

        .hotel-card-title a {
            color: #e5e7eb;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
        }

        .hotel-card-title a:hover {
            color: #38bdf8;
        }

        .hotel-price {
            font-size: 0.9rem;
            color: #e5e7eb;
            margin-bottom: 0.35rem;
        }

        .hotel-price span {
            font-weight: 600;
            color: #4ade80;
        }

        .hotel-actions .btn {
            font-size: 0.8rem;
            padding: 0.25rem 0.7rem;
            border-radius: 999px;
        }

        .hotel-actions .btn i {
            margin-right: 0.25rem;
        }

        .hotel-meta {
            font-size: 0.75rem;
            color: #94a3b8;
        }

        .badge-night {
            font-size: 0.7rem;
            border-radius: 999px;
            padding: 0.15rem 0.55rem;
            background: rgba(30, 64, 175, 0.7);
            color: #e0f2fe;
        }

        .hotel-list-scroll {
            padding-right: 0.15rem;
        }

        @media (max-width: 767.98px) {
            .hotel-card {
                padding: 0.75rem;
            }

            .hotel-card .hotel-image {
                width: 80px;
                min-width: 80px;
                height: 80px;
            }

            .offcanvas-header {
                padding-inline: 0.75rem;
            }
        }

        /* Map click popup */
        .leaflet-popup-content-wrapper {
            border-radius: 0.75rem;
        }

        /* Toggle button container */
        .canvas-toggle-container {
            position: fixed;
            top: 50%;
            left: 0.25rem;
            transform: translateY(-50%);
            z-index: 1200;
        }

        .canvas-toggle-container .btn {
            border-radius: 999px;
            padding: 0.4rem 0.5rem;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.8);
            border: 1px solid rgba(148, 163, 184, 0.5);
        }

        .canvas-toggle-container .btn i {
            font-size: 1.1rem;
        }
    </style>

    <!-- <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script> -->
    <script src="./assets/dist/leaflet.js"></script>
</head>

<body>

    <div id="map"></div>

    <!-- Sidebar -->
    <div class="offcanvas offcanvas-start shadow-lg border-0" data-bs-scroll="true" data-bs-backdrop="false" aria-hidden="true" id="demo">
        <div class="offcanvas-header">
            <div class="d-flex flex-column">
                <h2 class="offcanvas-title mb-0">
                    <a class="text-decoration-none text-light d-flex align-items-center" href="index">
                        <i class="bi bi-moon-stars text-success me-2"></i>
                        ART SKY
                    </a>
                </h2>
                <small class="text-secondary" style="font-size: 0.75rem;">แผนที่ที่พักชมฟ้า / ดาราศาสตร์</small>
            </div>

            <div class="d-flex align-items-center ms-auto gap-2">
                <a href="hotel-profile" class="btn btn-sm btn-warning rounded-pill">
                    <i class="far fa-user me-1"></i> สำหรับผู้ประกอบการ
                </a>
                <button type="button" class="btn-close btn-close-white ms-1" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
        </div>

        <div class="offcanvas-body m-0 p-2">
            <!-- Search -->
            <div class="search-wrapper">
                <div class="input-group mb-2">
                    <span class="input-group-text bg-transparent border-0 ps-2">
                        <i class="fas fa-search text-secondary"></i>
                    </span>
                    <input
                        type="search"
                        id="search_data"
                        class="form-control border border-1 border-secondary"
                        placeholder="ค้นหาชื่อที่พัก, ราคา"
                        aria-describedby="button-addon2">
                    <button class="btn btn-success btn-search-main" type="button" id="button-addon2" disabled>
                        <i class="fas fa-search"></i> ค้นหา
                    </button>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <button class="btn btn-outline-info btn-location" type="button" id="button-addon3" data-fancybox data-src="#dialog-content">
                        <i class="fas fa-location-arrow"></i> ค้นหาจากที่ตั้ง
                    </button>
                    <small class="ms-2 text-secondary" style="font-size: 0.7rem;">
                        แสดงผลรีสอร์ต / โฮมสเตย์ / ที่พักที่เปิดให้บริการ
                    </small>
                </div>
            </div>

            <!-- Hotel list -->
            <div id="content" class="hotel-list-scroll">
                <?php
                $sql_hotel = " SELECT * FROM tbl_hotel WHERE tbl_hotel.hotel_status = 1 ORDER BY tbl_hotel.hotel_id ASC ";
                $result_hotel = mysqli_query($conn, $sql_hotel);
                while ($rs_hotel = mysqli_fetch_assoc($result_hotel)) {
                    $sql_img = " SELECT tbl_hotel_image.hotel_image_name FROM tbl_hotel_image 
            WHERE tbl_hotel_image.hotel_id = '{$rs_hotel["hotel_id"]}' ORDER BY tbl_hotel_image.hotel_image_id ASC LIMIT 1 ";
                    $result_img = mysqli_query($conn, $sql_img);
                    $rs_img = mysqli_fetch_assoc($result_img);
                ?>
                    <div class="hotel-card">
                        <div class="flex-shrink-0 d-flex align-items-center">
                            <img src="images/hotel_image/<?= $rs_img['hotel_image_name'] ?>" class="hotel-image" alt="ภาพที่พัก">
                        </div>
                        <div class="flex-grow-1 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <h5 class="hotel-card-title mb-0">
                                        <a href="hotel_popup?id=<?= $rs_hotel['hotel_id'] ?>" class="hotel-details-lightbox" data-glightbox="type: external">
                                            <?= $rs_hotel['hotel_name'] ?>
                                        </a>
                                    </h5>
                                    <span class="badge-night">
                                        <i class="bi bi-stars me-1"></i>ชมดาว
                                    </span>
                                </div>
                                <p class="hotel-price mb-1">
                                    <span>เริ่มต้น <?= number_format($rs_hotel['hotel_price'], 2) ?>฿</span> / คืน
                                </p>
                                <!-- <p class="hotel-meta mb-1">
                  <i class="fas fa-map-marker-alt me-1"></i> Lat: <?= $rs_hotel['hotel_lat'] ?>, Lon: <?= $rs_hotel['hotel_lon'] ?>
                </p> -->
                            </div>
                            <div class="hotel-actions mt-1">
                                <div class="btn-group" role="group">
                                    <a href="tel:<?= $rs_hotel['hotel_telephone'] ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-phone-square-alt"></i> โทร
                                    </a>
                                    <a href="https://line.me/ti/p/~<?= $rs_hotel['hotel_line'] ?>" target="_blank" class="btn btn-sm btn-success">
                                        <i class="fab fa-line"></i> ไลน์
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <!-- Modal -->
        <div id="dialog-content" class="col-lg-6" style="display: none; background: transparent;">
            <style>
                .glass-card-btn {
                    border: none;
                    background: transparent;
                    padding: 0;
                    cursor: pointer;
                }

                .glass-card {
                    position: relative;
                    border-radius: 1.4rem;
                    overflow: hidden;
                    backdrop-filter: blur(14px) saturate(160%);
                    -webkit-backdrop-filter: blur(14px) saturate(160%);
                    background: rgba(255, 255, 255, 0.08);
                    border: 1px solid rgba(255, 255, 255, 0.2);
                    transition: 0.25s ease;
                    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.5);
                }

                .glass-card:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 18px 45px rgba(0, 0, 0, 0.65);
                    border-color: rgba(255, 255, 255, 0.35);
                }

                .glass-card img {
                    width: 100%;
                    height: 130px;
                    object-fit: cover;
                    opacity: 0.85;
                    transition: 0.3s;
                }

                .glass-card:hover img {
                    opacity: 1;
                    transform: scale(1.06);
                }

                .glass-card-title {
                    position: absolute;
                    bottom: 35%;
                    left: 0;
                    width: 100%;
                    text-align: center;
                    font-weight: 600;
                    font-size: 1rem;
                    color: #fff;
                    text-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
                }

                .liquid-glass-card {
                    position: relative;
                    border-radius: 24px;
                    padding: 14px 18px 10px;
                    background: linear-gradient(135deg,
                            rgba(15, 23, 42, 0.1),
                            rgba(15, 23, 42, 0.2));
                    box-shadow:
                        0 24px 60px rgba(15, 23, 42, 0.0),
                        0 0 0 1px rgba(15, 23, 42, 0.0) inset;
                    backdrop-filter: blur(5px) saturate(160%);
                    -webkit-backdrop-filter: blur(5px) saturate(160%);
                    color: #f9fafb;
                    max-width: 420px;
                }

                /* เส้นไฮไลต์ขอบบนให้ดูเป็นน้ำๆ */
                .liquid-glass-card::before {
                    content: "";
                    position: absolute;
                    inset: 1px 1px auto 1px;
                    height: 100%;
                    border-radius: inherit;
                    background: linear-gradient(135deg,
                            rgba(248, 250, 252, 0.22),
                            rgba(148, 163, 184, 0.02));
                    opacity: 0.75;
                    pointer-events: none;
                }
            </style>
            <div class="container py-4">
                <div class="row g-3">
                    <div class="col-lg-6 col-md-6">
                        <button type="button" class="glass-card-btn w-100" onclick="moveMapToCurrentLocation()">
                            <div class="glass-card">
                                <img src="./images/current_location.jpg" alt="ตำแหน่งปัจจุบัน">
                                <div class="glass-card-title"><span class="liquid-glass-card">ตำแหน่งปัจจุบัน</span></div>
                            </div>
                        </button>
                    </div>
                    <?php
                    $pattern = '/^-?\d+(\.\d+)?$/';
                    $sql_station = " SELECT * FROM tbl_station ORDER BY CONVERT(station_name USING tis620) ASC";
                    $result_station = mysqli_query($conn, $sql_station);
                    while ($rs_station = mysqli_fetch_assoc($result_station)) {
                        if (preg_match($pattern, $rs_station['station_lat']) && preg_match($pattern, $rs_station['station_long'])) {
                    ?>
                            <!-- Area -->
                            <div class="col-lg-6 col-md-6">
                                <button type="button" class="glass-card-btn w-100" onclick="moveMap(<?= $rs_station['station_lat'] ?>,<?= $rs_station['station_long'] ?>)">
                                    <div class="glass-card">
                                        <img src="./images/station_image/<?= $rs_station['station_image'] ?>" alt="<?= $rs_station['station_name'] ?>">
                                        <div class="glass-card-title"><span class="liquid-glass-card"><?= $rs_station['station_name'] ?></span></div>
                                    </div>
                                </button>
                            </div>
                            <!-- Area -->
                    <?php }
                    } ?>
                </div>
            </div>
        </div>
        <!-- Modal -->
    </div>

    <!-- Toggle button -->
    <div class="canvas-toggle-container">
        <div class="offcanvas-btn-box">
            <button
                class="btn btn-dark text-light d-flex align-items-center justify-content-center"
                id="show-content"
                type="button"
                data-bs-toggle="offcanvas"
                data-bs-target="#demo">
                <span><i class="fas fa-caret-right"></i></span>
                <span><i class="fas fa-caret-left"></i></span>
            </button>
        </div>
    </div>

    <!-- Vendor JS Files -->
    <script src="./app/plugins/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="./app/node_modules/axios/dist/axios.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>

    <!-- Fancybox -->
    <script type="text/javascript" src="./app/plugins/fancybox/fancybox.umd.js"></script>


    <script type="text/javascript">
        $(function() {
            var width = $(window).width();

            // เปิด sidebar ตอนโหลดหน้า
            $('#show-content').click();

            if (width > 768) {
                // Desktop
                $('#demo').removeClass('offcanvas-bottom').addClass('offcanvas-start');
            } else if (width <= 768 && width >= 480) {
                // Tablet
                $('#demo').removeClass('offcanvas-bottom').addClass('offcanvas-start');
            } else {
                // Mobile
                $('#demo').removeClass('offcanvas-start').addClass('offcanvas-bottom');
                console.log("หน้าจอขนาดเล็ก");
            }
        });
    </script>

    <script>
        <?php
        $sql_hotel0 = " SELECT * FROM tbl_hotel WHERE tbl_hotel.hotel_status = 1 ORDER BY tbl_hotel.hotel_id ASC LIMIT 1 ";
        $result_hotel0 = mysqli_query($conn, $sql_hotel0);
        $rs_hotel0 = mysqli_fetch_assoc($result_hotel0);
        ?>

        function createMap(lat, lon, zoom = 13) {
            const map = L.map('map').setView([lat, lon], zoom);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);
            return map; // ถ้าต้องการใช้ map ต่อข้างนอก
        }

        // ใช้งาน
        const map = createMap(<?= $rs_hotel0['hotel_lat'] ?>, <?= $rs_hotel0['hotel_lon'] ?>);

        function moveMap(lat, lon, zoom = 13) {
            map.setView([lat, lon], zoom);
            $('.carousel__button.is-close').trigger('click');
        }

        function moveMapToCurrentLocation() {
            if (!navigator.geolocation) {
                alert("อุปกรณ์นี้ไม่รองรับการระบุตำแหน่ง");
                return;
            }

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const lat = position.coords.latitude;
                    const lon = position.coords.longitude;

                    console.log("ตำแหน่งปัจจุบัน:", lat, lon);

                    // เลื่อนแผนที่ไปยังตำแหน่งผู้ใช้
                    map.setView([lat, lon], 13);

                    // ปักหมุด
                    L.marker([lat, lon]).addTo(map)
                        .bindPopup("ตำแหน่งปัจจุบันของคุณ")
                        .openPopup();
                    $('.carousel__button.is-close').trigger('click');
                },
                (error) => {
                    alert("ไม่สามารถดึงตำแหน่งได้: " + error.message);
                }
            );
        }


        // const map = L.map('map').setView([<?= $rs_hotel0['hotel_lat'] ?>, <?= $rs_hotel0['hotel_lon'] ?>], 13);
        // 18.79715595333264, 99.00229437613878

        // const map = L.map('map').setView([18.79715595333264, 99.00229437613878], 13);


        // const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        //     maxZoom: 19,
        //     attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        // }).addTo(map);

        // const popup = L.popup()
        //     .setLatLng([<?= $rs_hotel0['hotel_lat'] ?>, <?= $rs_hotel0['hotel_lon'] ?>])
        //     .setContent('ยินดีต้อนรับสู่ ART SKY')
        //     .openOn(map);
        // const popup = L.popup()
        //     .setLatLng([18.79715595333264, 99.00229437613878])
        //     .setContent('ยินดีต้อนรับสู่ ART SKY')
        //     .openOn(map);
        const popup = L.popup();
        <?php
        $pattern = '/^-?\d+(\.\d+)?$/';
        $sql_hotel1 = " SELECT * FROM tbl_hotel WHERE tbl_hotel.hotel_status = 1 ORDER BY tbl_hotel.hotel_id ASC ";
        $result_hotel1 = mysqli_query($conn, $sql_hotel1);
        while ($rs_hotel1 = mysqli_fetch_assoc($result_hotel1)) {
            $sql_img1 = " SELECT tbl_hotel_image.hotel_image_name FROM tbl_hotel_image 
        WHERE tbl_hotel_image.hotel_id = '{$rs_hotel1["hotel_id"]}' ORDER BY tbl_hotel_image.hotel_image_id ASC LIMIT 1 ";
            $result_img1 = mysqli_query($conn, $sql_img1);
            $rs_img1 = mysqli_fetch_assoc($result_img1);

            if (
                preg_match($pattern, $rs_hotel1['hotel_lat']) &&
                preg_match($pattern, $rs_hotel1['hotel_lon'])
            ) {
        ?>
                const marker<?= $rs_hotel1['hotel_id'] ?> = L.marker([<?= $rs_hotel1['hotel_lat'] ?>, <?= $rs_hotel1['hotel_lon'] ?>]).addTo(map)
                    .bindPopup(
                        `<div class="text-center mb-1" onclick="listData('<?= addslashes($rs_hotel1['hotel_name']) ?>')" style="cursor:pointer">
                        <img src="images/hotel_image/<?= $rs_img1['hotel_image_name'] ?>" class="rounded-circle border border-2" width="56" style="aspect-ratio: 1 / 1; object-fit:cover">
                    </div>
                    <div style="font-weight:600; font-size:0.9rem; margin-bottom:0.15rem; cursor:pointer" onclick="listData('<?= addslashes($rs_hotel1['hotel_name']) ?>')">
                        <?= addslashes($rs_hotel1['hotel_name']) ?>
                    </div>
                    <div style="font-size:0.8rem; color:#4ade80; cursor:pointer" onclick="listData('<?= addslashes($rs_hotel1['hotel_name']) ?>')">เริ่มต้น <?= number_format($rs_hotel1['hotel_price'], 2) ?>฿ / คืน</div>`
                    );
        <?php
            }
        }
        ?>

        function onMapClick(e) {
            popup
                .setLatLng(e.latlng)
                .setContent(`${e.latlng.lat.toFixed(5)}, ${e.latlng.lng.toFixed(5)}`)
                .openOn(map);
        }

        map.on('click', onMapClick);

        // =========================
        // Search (logic เดิม)
        // =========================
        $('#button-addon2').click(async () => {
            let dt_content = '';
            try {
                const response = await axios.post('hotel_ajax.php', {
                    search: $('#search_data').val()
                });
                let arr_data = response.data;
                for (let index = 0; index < arr_data.length; index++) {
                    const mydata = arr_data[index];
                    dt_content += `
            <div class="hotel-card">
              <div class="flex-shrink-0 d-flex align-items-center">
                <img src="images/hotel_image/${mydata.hotel_image_name}" class="hotel-image" alt="ภาพที่พัก">
              </div>
              <div class="flex-grow-1 d-flex flex-column justify-content-between">
                <div>
                  <div class="d-flex align-items-center justify-content-between mb-1">
                    <h5 class="hotel-card-title mb-0">
                    <a href="hotel_popup?id=${mydata.hotel_id}" class="hotel-details-lightbox" data-glightbox="type: external">${mydata.hotel_name}</a>
                    </h5>
                    <span class="badge-night">
                      <i class="bi bi-stars me-1"></i>ชมดาว
                    </span>
                  </div>
                  <p class="hotel-price mb-1">
                    <span>เริ่มต้น ${mydata.hotel_price}฿</span> / คืน
                  </p>
                </div>
                <div class="hotel-actions mt-1">
                  <div class="btn-group" role="group">
                    <a href="tel:${mydata.hotel_telephone}" class="btn btn-sm btn-primary">
                      <i class="fas fa-phone-square-alt"></i> โทร
                    </a>
                    <a href="https://line.me/ti/p/~${mydata.hotel_line}" target="_blank" class="btn btn-sm btn-success">
                      <i class="fab fa-line"></i> ไลน์
                    </a>
                  </div>
                </div>
              </div>
            </div>`;
                }
                $('#content').html(dt_content);
                portfolioDetailsLightbox.reload();
            } catch (error) {
                console.error(error);
            }
        });

        async function listData(key) {
            let dt_content = '';
            if (key) {
                search = key;
                $('#search_data').val(key);
            } else {
                search = '';
            }
            try {
                const response = await axios.post('hotel_ajax.php', {
                    search: search
                });
                let arr_data = response.data;
                for (let index = 0; index < arr_data.length; index++) {
                    const mydata = arr_data[index];
                    dt_content += `
            <div class="hotel-card">
              <div class="flex-shrink-0 d-flex align-items-center">
                <img src="images/hotel_image/${mydata.hotel_image_name}" class="hotel-image" alt="ภาพที่พัก">
              </div>
              <div class="flex-grow-1 d-flex flex-column justify-content-between">
                <div>
                  <div class="d-flex align-items-center justify-content-between mb-1">
                    <h5 class="hotel-card-title mb-0">
                      <a href="hotel_popup?id=${mydata.hotel_id}" class="hotel-details-lightbox" data-glightbox="type: external">${mydata.hotel_name}</a>
                    </h5>
                    <span class="badge-night">
                      <i class="bi bi-stars me-1"></i>ชมดาว
                    </span>
                  </div>
                  <p class="hotel-price mb-1">
                    <span>เริ่มต้น ${mydata.hotel_price}฿</span> / คืน
                  </p>
                </div>
                <div class="hotel-actions mt-1">
                  <div class="btn-group" role="group">
                    <a href="tel:${mydata.hotel_telephone}" class="btn btn-sm btn-primary">
                      <i class="fas fa-phone-square-alt"></i> โทร
                    </a>
                    <a href="https://line.me/ti/p/~${mydata.hotel_line}" target="_blank" class="btn btn-sm btn-success">
                      <i class="fab fa-line"></i> ไลน์
                    </a>
                  </div>
                </div>
              </div>
            </div>`;
                }
                $('#content').html(dt_content);
                if (key) {
                    // ค้นหาลิงก์ที่ข้อความตรงเป๊ะ
                    const target = $('a.hotel-details-lightbox').filter(function() {
                        return $(this).text().trim() === key;
                    }).first(); // เอาอันแรกที่เจอ (กัน popup ซ้ำ)

                    // ถ้าพบลิงก์ที่ข้อความตรงเป๊ะ
                    if (target.length) {

                        const url = target.attr('href');

                        // เปิด GLightbox ทันที (แทน .trigger('click'))
                        GLightbox({
                            elements: [{
                                href: url,
                                width: '90%',
                                height: '90vh',
                                type: "external"
                            }]
                        }).open();
                    }
                }
                portfolioDetailsLightbox.reload();
            } catch (error) {
                console.error(error);
            }
        }

        $('#search_data').on("input", function() {
            if ($('#search_data').val() === '') {
                $('#button-addon2').prop('disabled', true);
                listData();
            }
        });

        $('#search_data').on('keyup', function() {
            const search_data = $('#search_data').val();
            const txtMatch = search_data !== '';
            $('#button-addon2').prop('disabled', !txtMatch);
        });

        const portfolioDetailsLightbox = GLightbox({
            selector: '.hotel-details-lightbox',
            width: '90%',
            height: '90vh'
        });
    </script>
    <div class="gtranslate_wrapper"></div>
    <script>
        window.gtranslateSettings = {
            "default_language": "th",
            "languages": ["th", "en", "zh-CN"],
            "globe_color": "#66aaff",
            "wrapper_selector": ".gtranslate_wrapper",
            "flag_size": 24,
            "horizontal_position": "left",
            "vertical_position": "bottom",
            "alt_flags": {
                "en": "usa"
            },
            "globe_size": 40
        }
    </script>
    <script src="https://cdn.gtranslate.net/widgets/latest/globe.js" defer></script>
</body>

</html>
<?php
ob_end_flush();
?>