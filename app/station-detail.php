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

        .bg-6cards {
            background-color: rgba(203, 221, 246, 0.7);
        }

        .text-for7day {
            color: #4281b7;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</head>

<body>

    <!-- ======= Header ======= -->
    <?php require './layout/header.php'; ?>
    <!-- End Header -->

    <main id="main" data-aos="fade" data-aos-delay="1500">
        <!-- ======= About Section ======= -->
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
        <section style="margin-top: 8rem;" class="vh-100">
            <div class="container-fluid px-1 px-md-3 py-0 mx-auto">
                <div class="row d-flex justify-content-start px-4 gx-4">
                    <div class="col-lg-12 col-md-12">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="card wt1 mb-3 rounded-3 shadow-sm p-3 bg-6cards">
                                    <h2 class="ms-auto me-4 mt-3 mb-0 text-end text-for7day" id="data_1">เชียงราย</h2>
                                    <p class="ms-auto me-4 mb-0 med-font text-end text-light" id="data_2">ฝนตก</p>
                                    <h1 class="ms-auto me-4 large-font text-end text-light" id="data_3">-20&#176;</h1>
                                    <p class="time-font mb-0 ms-4 mt-auto text-light" id="data_4">
                                        08:30 <span class="sm-font">AM</span>
                                    </p>
                                    <p class="ms-4 text-light" id="data_5">Wednesday, 18 October 2019</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="card wt2 mb-3 rounded-3 shadow-sm p-3 bg-6cards">
                                    <h2 class="ms-auto me-4 mt-3 mb-0 text-end">&nbsp;</h2>
                                    <p class="ms-auto me-4 mb-0 med-font text-end text-for7day">ความหนาแน่นของเมฆ</p>
                                    <h1 class="ms-auto me-4 large-font text-end text-light" id="data_6">20%</h1>
                                    <p class="time-font mb-0 ms-4 mt-auto pt-3 text-light">
                                        ทัศนวิสัย <span id="data_7"></span> กม.</span>
                                    </p>
                                    <p class="ms-4 mb-4 text-light">ความกดอากาศ <span id="data_8"></span> hPa </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 mb-3">
                                <div id="show-map">
                                </div>
                                <div class="mt-3 text-center">
                                    <button type="button" id="mylocation" class="btn btn-primary"><i class="fas fa-location-arrow"></i> ตำแหน่งปัจจุบัน</button>
                                    <button type="button" id="originals" class="btn btn-warning"><i class="fas fa-map-marker-alt"></i> ตำแหน่งสถานี</button>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 mb-3">
                                <div id="starmap1" class="rounded-3 shadow-sm" style="aspect-ratio: 16/9;"></div>
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
    <script type="text/javascript" src="./app/node_modules/axios/dist/axios.min.js"></script>
    <script type="text/javascript" src="./assets/vendor/slick/slick.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- virtualsky -->
    <script src="./assets/vendor/virtualsky/stuquery.min.js"></script>
    <script src="./assets/vendor/virtualsky/virtualsky.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
        const mapStation = (lat, lon, locals) => {
            const map = L.map('map').setView([lat, lon], 13);

            const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            const marker = L.marker([lat, lon]).addTo(map)
                .bindPopup(`${locals}<br> ${lat.toFixed(3)},${lon.toFixed(3)}`)
                .openPopup();

            /* Sky Map Start */
            S.virtualsky({
                id: 'starmap1',
                projection: 'stereo',
                latitude: lat.toFixed(3),
                longitude: lon.toFixed(3),
                showstarlabels: true,
                ground: false,
                constellations: true,
            });
            $('#starmap1_inner').addClass('rounded');
            /* Sky Map End*/
        }

        beginLo();

        function beginLo() {
            $('#show-map').html('');
            $('#show-map').html(`<div id="map" class="rounded shadow-sm" style="aspect-ratio: 16/9;"></div>`);
            mapStation(<?= $rs_st['station_lat'] ?>, <?= $rs_st['station_long'] ?>, '<?= $rs_st['station_name'] ?>');
        }

        // My Location
        $('#mylocation').click(async () => {
            $('#show-map').html('');
            Swal.showLoading();
            $('#show-map').html(`<div id="map" class="rounded shadow-sm" style="aspect-ratio: 16/9;"></div>`);
            await navigator.geolocation.getCurrentPosition(showPosition, handleError);
        });

        // Default Location
        $('#originals').click(() => {
            beginLo()
        });

        function showPosition(position) {
            mapStation(position.coords.latitude, position.coords.longitude, 'ตำแหน่งปัจจุบัน');
            if(position.coords.latitude && position.coords.longitude){
                Swal.close();
            }
        }

        function handleError(error) {
            console.error("Error:", error.message);
        }


        function getThaiDate(dt, timezone) {
            // Convert timestamp and timezone to UTC datetime
            const utcDatetime = new Date(dt * 1000 + timezone * 1000);
            // Convert to Thai Buddhist calendar date
            const thaiYear = utcDatetime.getFullYear() + 543; // Add 543 for Buddhist era
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
            } [utcDatetime.getMonth() + 1]; // Months are 0-indexed
            const thaiDay = {
                0: "อาทิตย์",
                1: "จันทร์",
                2: "อังคาร",
                3: "พุธ",
                4: "พฤหัสบดี",
                5: "ศุกร์",
                6: "เสาร์",
            } [utcDatetime.getDay()];

            // Format the Thai date string
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
            return `${hour}`; //Thursday, 21 July 2022 18:14
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

        showW();

        function showW() {
            showWheather(<?= $rs_st['station_lat'] ?>, <?= $rs_st['station_long'] ?>);
        }
    </script>
</body>

</html>
