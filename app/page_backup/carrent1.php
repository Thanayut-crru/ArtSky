<?php require './config/connect.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>ART SKY | เช่ารถ</title>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="./app/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>

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
    </style>
</head>

<body>

    <!-- ======= Header ======= -->
    <?php require './layout/header.php'; ?>
    <!-- End Header -->

    <main id="main" data-aos="fade" data-aos-delay="1500">

        <!-- ======= End Page Header ======= -->
        <!-- ======= End Page Header ======= -->
        <div class="page-header d-flex align-items-center">
            <div class="container position-relative">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <!-- กล่องค้นหาผู้ให้บริการเช่ารถ -->
                        <div class="card bg-skys border-0 shadow-lg rounded-4">
                            <div class="card-body p-4 p-md-5">

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h1 class="h3 text-white mb-1 fkanit">
                                            เลือกผู้ให้บริการเช่ารถยนต์
                                        </h1>
                                        <p class="mb-0 text-white-50 fkanit">
                                            เลือกจังหวัด อำเภอ และตำบล เพื่อค้นหาผู้ให้บริการใกล้คุณ
                                        </p>
                                    </div>
                                    <div class="d-none d-md-block text-end">
                                        <span class="badge bg-light text-dark fkanit">
                                            ค้นหาบริการ | เช่ารถ
                                        </span>
                                    </div>
                                </div>

                                <!-- แบบฟอร์มเลือกพื้นที่ -->
                                <form id="searchCarProviderForm" class="row g-3">

                                    <div class="col-md-4">
                                        <label for="province" class="form-label text-white fkanit">จังหวัด</label>
                                        <select id="province" name="province" class="form-select fkanit">
                                            <option value="">-- เลือกจังหวัด --</option>
                                            <!-- ตัวอย่าง option เริ่มต้น (จริง ๆ ให้ดึงจากฐานข้อมูล) -->
                                            <option value="10">กรุงเทพมหานคร</option>
                                            <option value="50">เชียงใหม่</option>
                                            <option value="70">ราชบุรี</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="amphure" class="form-label text-white fkanit">อำเภอ</label>
                                        <select id="amphure" name="amphure" class="form-select fkanit" disabled>
                                            <option value="">-- เลือกอำเภอ --</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="tambon" class="form-label text-white fkanit">ตำบล</label>
                                        <select id="tambon" name="tambon" class="form-select fkanit" disabled>
                                            <option value="">-- เลือกตำบล --</option>
                                        </select>
                                    </div>

                                    <div class="col-12 d-flex flex-wrap gap-2 justify-content-end mt-2">
                                        <button type="reset" class="btn btn-outline-light fkanit" id="btnResetFilter">
                                            ล้างตัวกรอง
                                        </button>
                                        <button type="submit" class="btn btn-light fkanit">
                                            ค้นหาผู้ให้บริการ
                                        </button>
                                    </div>
                                </form>

                                <!-- แสดงผลผู้ให้บริการ -->
                                <hr class="border-secondary my-4">

                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h2 class="h5 text-white mb-0 fkanit">ผู้ให้บริการเช่ารถ</h2>
                                    <small class="text-white-50 fkanit" id="providerCountLabel">
                                        เลือกพื้นที่เพื่อแสดงผู้ให้บริการ
                                    </small>
                                </div>

                                <div id="providerList" class="row g-3">
                                    <!-- ตัวอย่าง Card ผู้ให้บริการ (mock data) -->
                                    <div class="col-md-6 col-lg-4 provider-item" data-province="50" data-amphure="เชียงใหม่" data-tambon="สุเทพ">
                                        <div class="card h-100 border-0 shadow-sm rounded-4">
                                            <div class="card-body">
                                                <h5 class="card-title mb-1 fkanit">ART SKY รถเช่า สาขาเชียงใหม่</h5>
                                                <p class="mb-1 small text-muted fkanit">
                                                    ต.สุเทพ อ.เมืองเชียงใหม่ จ.เชียงใหม่
                                                </p>
                                                <p class="mb-2 small fkanit">
                                                    บริการรถเก๋ง / SUV / รถตู้ รายวัน-รายเดือน
                                                </p>
                                                <p class="mb-2 small fkanit">
                                                    <i class="bi bi-telephone"></i> 081-234-5678<br>
                                                    <i class="bi bi-line"></i> @artsky_carrent
                                                </p>
                                                <span class="badge bg-success-subtle text-success border border-success fkanit">
                                                    มีรถว่างให้เช่า
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-lg-4 provider-item" data-province="10" data-amphure="บางนา" data-tambon="บางนา">
                                        <div class="card h-100 border-0 shadow-sm rounded-4">
                                            <div class="card-body">
                                                <h5 class="card-title mb-1 fkanit">ART SKY รถเช่า สาขาบางนา</h5>
                                                <p class="mb-1 small text-muted fkanit">
                                                    ต.บางนา อ.บางนา จ.กรุงเทพมหานคร
                                                </p>
                                                <p class="mb-2 small fkanit">
                                                    ใกล้สนามบินสุวรรณภูมิ บริการรับ-ส่งฟรี
                                                </p>
                                                <p class="mb-2 small fkanit">
                                                    <i class="bi bi-telephone"></i> 089-999-0000
                                                </p>
                                                <span class="badge bg-warning-subtle text-warning border border-warning fkanit">
                                                    เหลือรถไม่มาก
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-lg-4 provider-item" data-province="50" data-amphure="สันทราย" data-tambon="สันทรายหลวง">
                                        <div class="card h-100 border-0 shadow-sm rounded-4">
                                            <div class="card-body">
                                                <h5 class="card-title mb-1 fkanit">เชียงใหม่สันทรายคาร์เรนท์</h5>
                                                <p class="mb-1 small text-muted fkanit">
                                                    ต.สันทรายหลวง อ.สันทราย จ.เชียงใหม่
                                                </p>
                                                <p class="mb-2 small fkanit">
                                                    รถกระบะ / รถบรรทุกเล็ก เหมาะสำหรับขนของ
                                                </p>
                                                <p class="mb-2 small fkanit">
                                                    <i class="bi bi-telephone"></i> 086-222-3333
                                                </p>
                                                <span class="badge bg-secondary-subtle text-secondary border border-secondary fkanit">
                                                    กรุณาโทรตรวจสอบรถว่าง
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                </div><!-- /#providerList -->

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div><!-- End Page Header -->

        <!-- End Page Header -->
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

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js?onload=_turnstileCb" defer></script>
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
    <script>
        // จำลองข้อมูลอำเภอ / ตำบล แบบง่าย ๆ (จริง ๆ แนะนำดึงจากฐานข้อมูลหรือ API)
        const amphureData = {
            "10": ["บางนา", "ลาดพร้าว", "ห้วยขวาง"],
            "50": ["เมืองเชียงใหม่", "สันทราย", "หางดง"],
            "70": ["เมืองราชบุรี", "บ้านโป่ง"]
        };

        const tambonData = {
            "บางนา": ["บางนา", "บางแก้ว"],
            "ลาดพร้าว": ["ลาดพร้าว", "จันทรเกษม"],
            "ห้วยขวาง": ["ห้วยขวาง", "ดินแดง"],
            "เมืองเชียงใหม่": ["สุเทพ", "ช้างเผือก", "แม่เหียะ"],
            "สันทราย": ["สันทรายหลวง", "หนองหาร"],
            "หางดง": ["หางดง", "สันผักหวาน"],
            "เมืองราชบุรี": ["หน้าเมือง", "ท่าราบ"],
            "บ้านโป่ง": ["บ้านโป่ง", "ท่าผา"]
        };

        $(function() {
            const $province = $('#province');
            const $amphure = $('#amphure');
            const $tambon = $('#tambon');
            const $providerItems = $('.provider-item');
            const $countLabel = $('#providerCountLabel');

            function resetAmphure() {
                $amphure.empty().append('<option value="">-- เลือกอำเภอ --</option>');
                $amphure.prop('disabled', true);
            }

            function resetTambon() {
                $tambon.empty().append('<option value="">-- เลือกตำบล --</option>');
                $tambon.prop('disabled', true);
            }

            // เมื่อเลือกจังหวัด
            $province.on('change', function() {
                const provinceId = $(this).val();
                resetAmphure();
                resetTambon();

                if (!provinceId) {
                    return;
                }

                // เติมอำเภอจาก amphureData
                const amphures = amphureData[provinceId] || [];
                amphures.forEach(a => {
                    $amphure.append(`<option value="${a}">${a}</option>`);
                });
                $amphure.prop('disabled', amphures.length === 0);
            });

            // เมื่อเลือกอำเภอ
            $amphure.on('change', function() {
                const amphureName = $(this).val();
                resetTambon();

                if (!amphureName) {
                    return;
                }

                const tambons = tambonData[amphureName] || [];
                tambons.forEach(t => {
                    $tambon.append(`<option value="${t}">${t}</option>`);
                });
                $tambon.prop('disabled', tambons.length === 0);
            });

            // กดค้นหา
            $('#searchCarProviderForm').on('submit', function(e) {
                e.preventDefault();

                const provinceId = $province.val();
                const amphureName = $amphure.val();
                const tambonName = $tambon.val();

                let resultCount = 0;

                $providerItems.each(function() {
                    const $item = $(this);
                    const itemProvince = $item.data('province')?.toString() || '';
                    const itemAmphure = ($item.data('amphure') || '').toString();
                    const itemTambon = ($item.data('tambon') || '').toString();

                    let visible = true;

                    if (provinceId && itemProvince !== provinceId) {
                        visible = false;
                    }
                    if (visible && amphureName && itemAmphure !== amphureName) {
                        visible = false;
                    }
                    if (visible && tambonName && itemTambon !== tambonName) {
                        visible = false;
                    }

                    $item.toggle(visible);
                    if (visible) resultCount++;
                });

                if (resultCount === 0) {
                    $countLabel.text('ไม่พบผู้ให้บริการตามพื้นที่ที่เลือก').removeClass('text-white-50').addClass('text-warning');
                } else {
                    $countLabel
                        .text(`พบผู้ให้บริการทั้งหมด ${resultCount} ราย`)
                        .removeClass('text-warning')
                        .addClass('text-white-50');
                }
            });

            // ปุ่มล้างตัวกรอง
            $('#btnResetFilter').on('click', function() {
                setTimeout(function() {
                    resetAmphure();
                    resetTambon();
                    $providerItems.show();
                    $countLabel
                        .text('เลือกพื้นที่เพื่อแสดงผู้ให้บริการ')
                        .removeClass('text-warning')
                        .addClass('text-white-50');
                }, 0);
            });
        });
    </script>


</body>

</html>