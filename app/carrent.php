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
    <link rel="stylesheet" type="text/css" href="./assets/vendor/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="./assets/vendor/slick/slick-theme.css" />

    <script src="./app/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="./app/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="./app/node_modules/axios/dist/axios.min.js"></script>

    <style>
        :root {
            --glass-border: rgba(255, 255, 255, 0.28);
            --glass-bg-main: rgba(15, 23, 42, 0.65);
            --glass-bg-soft: rgba(15, 23, 42, 0.55);
            --glass-highlight: rgba(56, 189, 248, 0.5);
            --glass-highlight-soft: rgba(129, 140, 248, 0.45);
            --glass-text-main: #e5e7eb;
            --glass-text-soft: #cbd5f5;
        }

        body {
            min-height: 100vh;
            margin: 0;
            color: var(--glass-text-main);
            /* Liquid glass layered background */
            background:
                url("./images/head_bg.jpg") no-repeat center top fixed;
            background-size: cover;
        }

        .fkanit {
            font-family: "Noto Serif Thai", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            font-weight: 400;
            font-style: normal;
        }

        .color-sky {
            color: rgba(255, 255, 255, 0.85);
        }

        #header {
            background: transparent;
        }

        /* Liquid glass core card */
        .glass-panel {
            position: relative;
            overflow: hidden;
            background: radial-gradient(circle at top left,
                    rgba(255, 255, 255, 0.1),
                    rgba(15, 23, 42, 0.3));
            border-radius: 28px;
            border: 1px solid var(--glass-border);
            box-shadow:
                0 24px 60px rgba(15, 23, 42, 0.3),
                0 0 0 1px rgba(15, 23, 42, 0.1);
            backdrop-filter: blur(22px) saturate(160%);
            -webkit-backdrop-filter: blur(22px) saturate(160%);
        }

        .glass-panel::before {
            content: "";
            position: absolute;
            inset: -40%;
            background:
                radial-gradient(circle at 10% 0%, rgba(255, 255, 255, 0.1), transparent 55%),
                radial-gradient(circle at 80% 100%, rgba(59, 130, 246, 0.1), transparent 58%);
            opacity: 0.9;
            pointer-events: none;
            mix-blend-mode: screen;
        }

        .glass-panel>*,
        .glass-panel form,
        .glass-panel .card-body {
            position: relative;
            z-index: 1;
        }

        .page-header {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding-top: 5rem;
            padding-bottom: 4rem;
        }

        .page-header .container {
            position: relative;
        }

        /* Small floating chips / tags */
        .badge-soft {
            background: linear-gradient(135deg, rgba(56, 189, 248, 0.18), rgba(129, 140, 248, 0.2));
            border: 1px solid rgba(148, 163, 184, 0.55);
            color: var(--glass-text-soft);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border-radius: 999px;
            padding: 0.35rem 0.9rem;
            font-size: 0.85rem;
        }

        /* Form controls : liquid glass */
        .glass-form .form-label {
            color: rgba(226, 232, 240, 0.96);
            font-size: 0.9rem;
        }

        .glass-form .form-select,
        .glass-form .form-control {
            background: rgba(15, 23, 42, 0.72);
            border-radius: 999px;
            border: 1px solid rgba(148, 163, 184, 0.5);
            color: var(--glass-text-main);
            padding-inline: 1.25rem;
            padding-block: 0.6rem;
            font-size: 0.9rem;
            box-shadow: 0 0 0 1px rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease, transform 0.1s ease;
        }

        .glass-form .form-select:focus,
        .glass-form .form-control:focus {
            outline: none;
            background: rgba(15, 23, 42, 0.9);
            border-color: rgba(56, 189, 248, 0.85);
            box-shadow:
                0 0 0 1px rgba(56, 189, 248, 0.7),
                0 18px 40px rgba(15, 23, 42, 0.95);
            transform: translateY(-1px);
        }

        .glass-form .form-select option {
            color: #0f172a;
        }

        .glass-form ::placeholder {
            color: rgba(148, 163, 184, 0.85);
        }

        /* Buttons */
        .btn-glass-primary {
            border-radius: 999px;
            border: 1px solid rgba(56, 189, 248, 0.8);
            background: radial-gradient(circle at 0% 0%,
                    rgba(56, 189, 248, 0.9),
                    rgba(56, 189, 248, 0.65));
            color: #0f172a;
            font-weight: 600;
            letter-spacing: 0.01em;
            padding: 0.55rem 1.6rem;
            box-shadow:
                0 16px 45px rgba(8, 47, 73, 0.9),
                0 0 0 1px rgba(15, 23, 42, 0.8);
            transition: transform 0.12s ease-out, box-shadow 0.12s ease-out, background 0.15s ease-out;
        }

        .btn-glass-primary:hover {
            transform: translateY(-1.5px) scale(1.01);
            box-shadow:
                0 22px 60px rgba(8, 47, 73, 0.95),
                0 0 0 1px rgba(15, 23, 42, 0.85);
            color: #020617;
        }

        .btn-glass-outline {
            border-radius: 999px;
            border: 1px solid rgba(148, 163, 184, 0.7);
            background: radial-gradient(circle at 0 0,
                    rgba(15, 23, 42, 0.75),
                    rgba(15, 23, 42, 0.5));
            color: var(--glass-text-soft);
            padding: 0.55rem 1.4rem;
            font-weight: 500;
            transition: background 0.15s ease, color 0.15s ease, border-color 0.15s ease, transform 0.1s ease;
        }

        .btn-glass-outline:hover {
            background: radial-gradient(circle at 0 0,
                    rgba(148, 163, 184, 0.22),
                    rgba(15, 23, 42, 0.95));
            border-color: rgba(248, 250, 252, 0.95);
            color: #f9fafb;
            transform: translateY(-1px);
        }

        /* Provider section header */
        .section-title-main {
            font-size: 1.35rem;
            font-weight: 600;
            color: #f9fafb;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-title-main i {
            font-size: 1.1rem;
            color: rgba(56, 189, 248, 0.95);
        }

        #providerCountLabel {
            font-size: 0.85rem;
        }

        /* Provider cards : liquid tiles */
        .provider-item {
            transition: transform 0.18s ease, filter 0.18s ease;
        }

        .provider-item:hover {
            transform: translateY(-4px);
        }

        .glass-card {
            position: relative;
            overflow: hidden;
            background:
                radial-gradient(circle at top left, rgba(248, 250, 252, 0.18), rgba(15, 23, 42, 0.3));
            border-radius: 22px;
            border: 1px solid rgba(148, 163, 184, 0.55);
            box-shadow:
                0 18px 45px rgba(15, 23, 42, 0.9),
                0 0 0 1px rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(18px) saturate(150%);
            -webkit-backdrop-filter: blur(18px) saturate(150%);
            transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.16s ease;
        }

        .glass-card::before {
            content: "";
            position: absolute;
            inset: -40%;
            background:
                radial-gradient(circle at 0 0, rgba(56, 189, 248, 0.25), transparent 55%),
                radial-gradient(circle at 100% 100%, rgba(129, 140, 248, 0.28), transparent 55%);
            opacity: 0.7;
            mix-blend-mode: screen;
            pointer-events: none;
        }

        .glass-card .card-body,
        .glass-card img {
            position: relative;
            z-index: 1;
        }

        .glass-card:hover {
            border-color: rgba(56, 189, 248, 0.9);
            box-shadow:
                0 22px 60px rgba(15, 23, 42, 0.96),
                0 0 0 1px rgba(30, 64, 175, 0.9);
            transform: translateY(-6px);
        }

        .img-car {
            aspect-ratio: 16 / 9;
            object-fit: cover;
        }

        .card-title a.hotel-details-lightbox {
            color: #e5e7eb;
            text-decoration: none;
            transition: color 0.15s ease, text-shadow 0.15s ease;
        }

        .card-title a.hotel-details-lightbox:hover {
            color: #ffffff;
            text-shadow: 0 0 18px rgba(56, 189, 248, 0.7);
        }

        .card-body small,
        .card-body .small {
            color: rgba(226, 232, 240, 0.9) !important;
        }

        .card-body i.bi-telephone {
            color: rgba(56, 189, 248, 0.95);
        }

        /* Alert when not found */
        .alert-glass {
            background: radial-gradient(circle at 0 0, rgba(248, 250, 252, 0.12), rgba(15, 23, 42, 0.9));
            border-radius: 18px;
            border: 1px solid rgba(250, 204, 21, 0.8);
            color: #fef9c3;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        /* Scroll top button refine */
        .scroll-top {
            border-radius: 999px;
            border: 1px solid rgba(148, 163, 184, 0.7);
            background: radial-gradient(circle at 0 0,
                    rgba(15, 23, 42, 0.85),
                    rgba(15, 23, 42, 0.9));
        }

        .scroll-top i {
            color: #e5e7eb;
        }

        .scroll-top:hover {
            border-color: rgba(56, 189, 248, 1);
            background: radial-gradient(circle at 0 0,
                    rgba(56, 189, 248, 0.95),
                    rgba(37, 99, 235, 0.96));
        }

        /* Responsive tweaks */
        @media (max-width: 991.98px) {
            .page-header {
                padding-top: 5.5rem;
                padding-bottom: 3rem;
            }

            .glass-panel {
                border-radius: 24px;
            }
        }

        @media (max-width: 575.98px) {
            .section-title-main {
                font-size: 1.1rem;
            }

            .glass-form .form-select,
            .glass-form .form-control {
                font-size: 0.85rem;
            }
        }
    </style>
</head>

<body>

    <!-- ======= Header ======= -->
    <?php require './layout/header.php'; ?>
    <!-- End Header -->

    <main id="main" data-aos="fade" data-aos-delay="1500">

        <!-- ======= Page Header ======= -->
        <div class="page-header d-flex align-items-center">
            <div class="container position-relative">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <!-- กล่องค้นหาผู้ให้บริการเช่ารถ | Liquid Glass -->
                        <div class="card border-0 glass-panel mt-5">
                            <div class="card-body p-4 p-md-5 glass-form">

                                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
                                    <div>
                                        <h1 class="h3 text-white mb-2 fkanit d-flex align-items-center gap-2">
                                            <span class="position-relative d-inline-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
                                                <span style="position:absolute; inset:0; border-radius:999px; background:radial-gradient(circle at 0 0, rgba(56,189,248,0.55), rgba(129,140,248,0.25)); opacity:0.6;"></span>
                                                <i class="bi bi-car-front-fill position-relative" style="font-size: 1.2rem; color:#0f172a;"></i>
                                            </span>
                                            <span>เลือกผู้ให้บริการเช่ารถยนต์</span>
                                        </h1>
                                        <p class="mb-0 text-white-50 fkanit">
                                            เลือกจังหวัด อำเภอ และตำบล เพื่อค้นหาผู้ให้บริการใกล้คุณ
                                        </p>
                                    </div>
                                    <div class="d-none d-md-flex flex-column align-items-end gap-2">
                                        <span class="badge-soft fkanit">
                                            ค้นหาบริการ · เช่ารถ
                                        </span>
                                        <small class="text-white-50 fkanit">
                                            ART SKY Dark Sky Travel Platform
                                        </small>
                                    </div>
                                </div>

                                <!-- แบบฟอร์มเลือกพื้นที่ -->
                                <form id="searchCarProviderForm" class="row g-3 mb-3" method="get" action="">
                                    <div class="col-md-4">
                                        <label for="province_id" class="form-label fkanit">จังหวัด</label>
                                        <select id="province_id" name="province_id" class="form-select fkanit">
                                            <option value="">-- เลือกจังหวัด --</option>
                                            <?php
                                            $sql_pv = "SELECT tbl_provinces.id,tbl_provinces.name_in_thai FROM tbl_provinces ORDER BY CONVERT(tbl_provinces.name_in_thai USING tis620) ASC";
                                            $result_pv = mysqli_query($conn, $sql_pv);
                                            while ($rs_pv = mysqli_fetch_assoc($result_pv)) {
                                            ?>
                                                <option value="<?= $rs_pv['id'] ?>" <?= (isset($_GET['province_id']) && $_GET['province_id'] == $rs_pv['id']) ? 'selected' : '' ?>>
                                                    <?= $rs_pv['name_in_thai'] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="district_id" class="form-label fkanit">อำเภอ</label>
                                        <select id="district_id" name="district_id" class="form-select fkanit">
                                            <option value="">-- เลือกอำเภอ --</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="subdistrict_id" class="form-label fkanit">ตำบล</label>
                                        <select id="subdistrict_id" name="subdistrict_id" class="form-select fkanit">
                                            <option value="">-- เลือกตำบล --</option>
                                        </select>
                                    </div>

                                    <div class="col-12 d-flex flex-wrap gap-2 justify-content-end mt-2">
                                        <a href="carrent" class="btn btn-glass-outline fkanit" id="btnResetFilter">
                                            <i class="bi bi-arrow-counterclockwise me-1"></i> ล้างตัวกรอง
                                        </a>
                                        <button type="submit" class="btn btn-glass-primary fkanit">
                                            <i class="bi bi-search me-1"></i> ค้นหาผู้ให้บริการ
                                        </button>
                                    </div>
                                </form>

                                <!-- แสดงผลผู้ให้บริการ -->
                                <hr class="border-secondary border-opacity-50 my-4">

                                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                                    <div class="section-title-main fkanit">
                                        <i class="bi bi-people-fill"></i>
                                        <span>ผู้ให้บริการเช่ารถ</span>
                                    </div>
                                    <small class="text-white-50 fkanit" id="providerCountLabel">
                                        <?php
                                        if (isset($_GET['province_id']) || isset($_GET['district_id']) || isset($_GET['subdistrict_id'])) {
                                            // จะอัปเดตด้วย JS เพิ่มเติมก็ได้
                                            echo "ผลลัพธ์ผู้ให้บริการตามพื้นที่ที่เลือก";
                                        } else {
                                            echo "เลือกพื้นที่เพื่อแสดงผู้ให้บริการ";
                                        }
                                        ?>
                                    </small>
                                </div>

                                <div id="providerList" class="row g-3">
                                    <?php
                                    $conditions = [];

                                    if (!empty($_GET['province_id'])) {
                                        $province_id = mysqli_real_escape_string($conn, $_GET['province_id']);
                                        $conditions[] = "province_id = '$province_id'";
                                    }

                                    if (!empty($_GET['district_id'])) {
                                        $district_id = mysqli_real_escape_string($conn, $_GET['district_id']);
                                        $conditions[] = "district_id = '$district_id'";
                                    }

                                    if (!empty($_GET['subdistrict_id'])) {
                                        $subdistrict_id = mysqli_real_escape_string($conn, $_GET['subdistrict_id']);
                                        $conditions[] = "subdistrict_id = '$subdistrict_id'";
                                    }

                                    // เงื่อนไขพื้นฐาน
                                    $base = "status_car_rental = 1";

                                    // รวมเป็น SQL
                                    if (count($conditions) > 0) {
                                        $where = $base . " AND " . implode(" AND ", $conditions);
                                        echo <<<HTML
                                                <script>
                                                     $(() => {
                                                        $('html,body').animate({
                                                                scrollTop: $("#carrent-lists").offset().top - 280
                                                            },
                                                            'slow');
                                                    })
                                                </script>
                                            HTML;
                                    } else {
                                        $where = $base;  // ไม่มี filter
                                    }

                                    $sql_carrent = "SELECT * FROM tbl_car_rental WHERE $where ORDER BY car_rental_id ASC";

                                    $result_carrent = mysqli_query($conn, $sql_carrent);
                                    $num_carrent = mysqli_num_rows($result_carrent);

                                    if ($num_carrent > 0) {
                                        while ($rs_carrent = mysqli_fetch_assoc($result_carrent)) {
                                            $sql_img = "SELECT * FROM tbl_car_rental_image WHERE car_rental_id = '{$rs_carrent['car_rental_id']}' ORDER BY car_rental_image_id ASC LIMIT 1";
                                            $result_img = mysqli_query($conn, $sql_img);
                                            $rs_img = mysqli_fetch_assoc($result_img);
                                            if (!empty($rs_img['car_rental_image_name'])) {
                                                $img_cr = "./images/car_rental/{$rs_img['car_rental_image_name']}";
                                            } else {
                                                $img_cr = "./images/carrent.svg";
                                            }
                                    ?>
                                            <div class="col-md-6 col-lg-4 provider-item" id="carrent-lists">
                                                <div class="card h-100 glass-card border-0">
                                                    <img src="<?= $img_cr ?>" class="card-img-top img-car" alt="<?= htmlspecialchars($rs_carrent['car_rental_name']) ?>">
                                                    <div class="card-body">
                                                        <h5 class="card-title mb-2 fkanit">
                                                            <a href="carrent_popup?id=<?= $rs_carrent['car_rental_id'] ?>"
                                                                class="hotel-details-lightbox"
                                                                data-glightbox="type: external">
                                                                <?= mb_substr($rs_carrent['car_rental_name'], 0, 30, 'UTF-8'); ?>
                                                            </a>
                                                        </h5>
                                                        <p class="mb-1 small fkanit">
                                                            <i class="bi bi-telephone me-1"></i>
                                                            <?= $rs_carrent['phone'] ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <div class="col-12">
                                            <div class="alert alert-glass mt-1 fkanit d-flex align-items-center gap-2">
                                                <i class="bi bi-exclamation-triangle-fill"></i>
                                                <span>ไม่พบผู้ให้บริการตามพื้นที่ที่เลือก กรุณาลองเลือกพื้นที่อื่นหรือล้างตัวกรองอีกครั้ง</span>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div><!-- /#providerList -->

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div><!-- End Page Header -->

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

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js?onload=_turnstileCb" defer></script>
    <script type="text/javascript" src="./assets/vendor/slick/slick.min.js"></script>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Ajax & Logic เดิมทั้งหมด -->
    <script>
        $('#province_id').change(async () => {
            try {
                const province_id = $('#province_id option:selected').val();
                const response = await axios.get('register-carrent-api.php?pid=' + province_id);

                const districts = response.data;

                $('#district_id').empty();
                $('#district_id').append('<option value="">-- เลือกอำเภอ --</option>');

                districts.forEach(dt => {
                    $('#district_id').append(`<option value="${dt.id}">${dt.name_in_thai}</option>`);
                });
            } catch (error) {
                console.error(error);
            }
        });

        $('#district_id').change(async () => {
            try {
                const district_id = $('#district_id option:selected').val();
                const response = await axios.get('register-carrent-api.php?did=' + district_id);

                const subdistricts = response.data;

                $('#subdistrict_id').empty();
                $('#subdistrict_id').append('<option value="">-- เลือกตำบล --</option>');

                subdistricts.forEach(sdt => {
                    $('#subdistrict_id').append(`<option value="${sdt.id}">${sdt.name_in_thai}</option>`);
                });
            } catch (error) {
                console.error(error);
            }
        });

        $(document).ready(function() {
            $('#password, #password_confirm').on('keyup change', function() {
                const password = $('#password').val();
                const confirmPassword = $('#password_confirm').val();
                const passwordsMatch = password !== '' && (password === confirmPassword);

                $('#sbm_form').prop('disabled', !passwordsMatch);

                if (confirmPassword === '') {
                    $('#password_confirm').css('border-color', '');
                } else if (passwordsMatch) {
                    $('#password_confirm').css('border-color', 'green');
                } else {
                    $('#password_confirm').css('border-color', 'red');
                }
            });
        });

        // โหลดจังหวัดก่อน
        $('#province_id').val('<?= $_GET['province_id'] ?? '' ?>').trigger('change');

        // ดีเลย์ 300ms รอจังหวัดโหลดอำเภอ
        setTimeout(function() {

            $('#district_id').val('<?= $_GET['district_id'] ?? '' ?>').trigger('change');

            // ดีเลย์อีก 300ms รออำเภอโหลดตำบล
            setTimeout(function() {

                $('#subdistrict_id').val('<?= $_GET['subdistrict_id'] ?? '' ?>').trigger('change');

            }, 300);

        }, 300);

        const portfolioDetailsLightbox = GLightbox({
            selector: '.hotel-details-lightbox',
            width: '90%',
            height: '90vh'
        });

        // ส่งฟอร์มด้วย GET ตาม logic เดิม (กันลืม)
        $('#searchCarProviderForm').on('submit', function() {
            // ให้ browser submit ปกติ
        });
    </script>

</body>

</html>