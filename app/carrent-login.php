<?php require './config/connect.php'; 
if (isset($_SESSION['sess_carrent_artsky']) && isset($_SESSION['sess_login_carrent_artsky'])) {
    $cId   = base64_decode($_SESSION['sess_carrent_artsky']);
    $sql_cr    = " SELECT * FROM tbl_car_rental WHERE car_rental_id = '$cId' ";
    $result_cr = mysqli_query($conn, $sql_cr);
    $no_cr    = mysqli_num_rows($result_cr);
    $rs_cr     = mysqli_fetch_assoc($result_cr);
    if ($no_cr > 0) {
        header("location:carrent-profile");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>ART SKY | Carrent Login</title>
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

        /* liquid glass */
        /* พื้นหลังแบบ liquid / glass */
        .page-header.glass-hero {
            position: relative;
            overflow: hidden;
        }

        .page-header.glass-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        /* ละออง / bubble ด้านหลัง */
        .glass-bubble {
            position: absolute;
            border-radius: 999px;
            filter: blur(40px);
            opacity: 0.45;
            pointer-events: none;
        }

        .glass-bubble.b1 {
            width: 220px;
            height: 220px;
            top: 10%;
            left: 8%;
            background: transparent;
        }

        .glass-bubble.b2 {
            width: 260px;
            height: 260px;
            bottom: -40px;
            right: 5%;
            background: transparent;
        }

        /* กล่อง login แบบ glass */
        .glass-card {
            position: relative;
            background: linear-gradient(135deg,
                    rgba(15, 23, 42, 0.8),
                    rgba(15, 23, 42, 0.55));
            border-radius: 1.5rem;
            border: 1px solid rgba(148, 163, 184, 0.35);
            box-shadow:
                0 24px 60px rgba(15, 23, 42, 0.8),
                0 0 0 1px rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(26px);
            -webkit-backdrop-filter: blur(26px);
        }

        .glass-card::before {
            content: "";
            position: absolute;
            inset: 1px;
            border-radius: inherit;
            background: radial-gradient(circle at 0 0, rgba(248, 250, 252, 0.06), transparent 55%);
            pointer-events: none;
        }

        .glass-card-inner {
            position: relative;
            z-index: 1;
        }

        .glass-title-main {
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            font-size: 0.9rem;
            color: #a5b4fc;
        }

        .glass-title {
            font-weight: 700;
            font-size: 1.6rem;
            color: #e5e7eb;
        }

        .glass-subtitle {
            font-size: 0.95rem;
            color: #9ca3af;
        }

        /* Input แบบ glass */
        .glass-input-group {
            background: rgba(15, 23, 42, 0.7);
            border-radius: 999px;
            border: 1px solid rgba(148, 163, 184, 0.6);
            padding-inline: 0.5rem;
            transition: all 0.2s ease;
        }

        .glass-input-group:focus-within {
            border-color: #38bdf8;
            box-shadow: 0 0 0 1px rgba(56, 189, 248, 0.4),
                0 18px 35px rgba(15, 23, 42, 0.9);
            background: rgba(15, 23, 42, 0.9);
        }

        .glass-input-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            padding-inline: 0.5rem;
            color: #9ca3af;
            font-size: 1.1rem;
        }

        .glass-input {
            border: none !important;
            background: transparent !important;
            color: #e5e7eb !important;
            box-shadow: none !important;
        }

        .glass-input::placeholder {
            color: #6b7280;
        }

        /* ปุ่มหลัก */
        .btn-glass-primary {
            border-radius: 999px;
            border: none;
            padding: 0.75rem 1.4rem;
            width: 100%;
            background-image: linear-gradient(135deg, #38bdf8, #22c55e);
            color: #0b1120;
            font-weight: 600;
            letter-spacing: 0.03em;
            box-shadow:
                0 16px 40px rgba(34, 197, 94, 0.55),
                0 0 0 1px rgba(15, 23, 42, 0.6);
            transition: all 0.18s ease;
        }

        .btn-glass-primary:hover {
            transform: translateY(-1px) translateZ(0);
            box-shadow:
                0 22px 45px rgba(34, 197, 94, 0.75),
                0 0 0 1px rgba(15, 23, 42, 0.9);
            filter: brightness(1.03);
        }

        .btn-glass-secondary {
            border-radius: 999px;
            padding: 0.6rem 1.2rem;
            font-weight: 500;
        }

        /* เส้นคั่นแบบ soft */
        .glass-divider {
            border-color: rgba(148, 163, 184, 0.35);
        }

        .link-soft {
            color: #a5b4fc;
            text-decoration: none;
        }

        .link-soft:hover {
            color: #c4b5fd;
            text-decoration: underline;
        }

        /* Turnstile */
        .cf-turnstile-wrapper {
            background: rgba(15, 23, 42, 0.7);
            border-radius: 1rem;
            padding: 0.75rem;
            border: 1px dashed rgba(148, 163, 184, 0.6);
        }

        @media (max-width: 576px) {
            .glass-card {
                border-radius: 1.25rem;
            }
        }

        /* liquid glass */
    </style>
</head>

<body>

    <!-- ======= Header ======= -->
    <?php require './layout/header.php'; ?>
    <!-- End Header -->

    <main id="main" data-aos="fade" data-aos-delay="1500">

        <!-- ======= End Page Header ======= -->
        <div class="page-header glass-hero d-flex align-items-center vh-100">
            <!-- liquid bubbles -->
            <div class="glass-bubble b1"></div>
            <div class="glass-bubble b2"></div>

            <div class="container position-relative">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-4 col-md-7 col-sm-10">

                        <div class="glass-card p-4 p-md-5">
                            <div class="glass-card-inner text-center">

                                <!-- PHP logic เดิม -->
                                <?php
                                if (isset($_POST['submit'])) {
                                    $turnstile_secret   = $turnstile_secret_key;
                                    $turnstile_response = $_POST['cf-turnstile-response'];
                                    $url                = "https://challenges.cloudflare.com/turnstile/v0/siteverify";
                                    $post_fields        = "secret=$turnstile_secret&response=$turnstile_response";

                                    $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
                                    $pass_name = mysqli_real_escape_string($conn, base64_encode($_POST['pass_name']));

                                    $ch = curl_init($url);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                    curl_setopt($ch, CURLOPT_POST, true);
                                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
                                    $response = curl_exec($ch);
                                    curl_close($ch);

                                    $response_data = json_decode($response);
                                    if ($response_data->success != 1) {
                                        echo '<script>
                           Swal.fire({
                             icon: "warning",
                             title: "ไม่สามารถเข้าสู่ระบบได้",
                             showConfirmButton: false,
                             timer: 5000,
                           });
                         </script>';
                                    } else {
                                        $sql = " SELECT * FROM tbl_car_rental WHERE username = '$user_name' AND password_hash = '$pass_name' ";
                                        $result = mysqli_query($conn, $sql);
                                        $num = mysqli_num_rows($result);

                                        if ($num > 0) {
                                            $rs = mysqli_fetch_assoc($result);
                                            $_SESSION['sess_carrent_artsky'] = base64_encode($rs['car_rental_id']);
                                            $_SESSION['sess_login_carrent_artsky'] = true;
                                            echo "<script>
                                 Swal.fire({
                                     icon: 'success',
                                     title: 'เข้าสู่ระบบสำเร็จ',
                                     showConfirmButton: false,
                                     timer: 1000,
                                 }).then(()=>{location.href='carrent-profile';});
                               </script>";
                                        } else {
                                            echo '<script>
                           Swal.fire({
                             icon: "warning",
                             title: "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง",
                             confirmButtonText: "ตกลง",
                             showConfirmButton: true
                           });
                         </script>';
                                        }
                                    }
                                }
                                ?>

                                <!-- หัวข้อ -->
                                <div class="mb-2 text-uppercase glass-title-main">
                                    ผู้ประกอบการรถเช่า
                                </div>
                                <h3 class="glass-title mb-1">
                                    เข้าสู่ระบบ
                                </h3>
                                <p class="glass-subtitle mb-4">
                                    ลงชื่อเข้าใช้เพื่อจัดการข้อมูลรถเช่าและการจองของคุณ
                                </p>

                                <!-- ฟอร์ม -->
                                <form action="" method="post" class="php-email-form text-start">
                                    <div class="row gy-3">

                                        <!-- Username -->
                                        <div class="col-md-12">
                                            <label for="user_name" class="form-label text-light small mb-1">
                                                ชื่อผู้ใช้งาน
                                            </label>
                                            <div class="d-flex align-items-center glass-input-group">
                                                <span class="glass-input-icon">
                                                    <i class="bi bi-person"></i>
                                                </span>
                                                <input
                                                    type="text"
                                                    class="form-control glass-input"
                                                    name="user_name"
                                                    id="user_name"
                                                    placeholder="ชื่อผู้ใช้งาน / Username"
                                                    required>
                                            </div>
                                        </div>

                                        <!-- Password -->
                                        <div class="col-md-12">
                                            <label for="pass_name" class="form-label text-light small mb-1">
                                                รหัสผ่าน
                                            </label>
                                            <div class="d-flex align-items-center glass-input-group">
                                                <span class="glass-input-icon">
                                                    <i class="bi bi-lock"></i>
                                                </span>
                                                <input
                                                    type="password"
                                                    class="form-control glass-input"
                                                    name="pass_name"
                                                    id="pass_name"
                                                    placeholder="กรอกรหัสผ่านของคุณ"
                                                    required>
                                            </div>
                                        </div>

                                        <!-- Turnstile -->
                                        <div class="col-md-12 mt-2">
                                            <div class="cf-turnstile-wrapper d-flex justify-content-center">
                                                <div class="cf-turnstile" data-sitekey="<?= htmlspecialchars($turnstile_site_key, ENT_QUOTES, 'UTF-8') ?>"></div>
                                            </div>
                                        </div>

                                        <!-- Submit -->
                                        <div class="col-md-12 mt-3">
                                            <button
                                                type="submit"
                                                class="btn btn-glass-primary"
                                                name="submit"
                                                id="sbm_form">
                                                <i class="bi bi-box-arrow-in-right me-1"></i> เข้าสู่ระบบ
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                <hr class="my-4 glass-divider">

                                <!-- ปุ่ม register + ติดต่อ dev -->
                                <div class="d-flex flex-column gap-3">
                                    <a class="btn btn-danger btn-glass-secondary fs-6" href="register-carrent">
                                        <i class="bi bi-person-add me-1"></i> ลงทะเบียนผู้ประกอบการใหม่
                                    </a>

                                    <a class="btn btn-success btn-glass-secondary fs-6" target="_blank"
                                        href="https://m.me/artsky.support">
                                        <i class="bi bi-person-lock me-1"></i> ลืมรหัสผ่าน &mdash; ติดต่อผู้พัฒนาระบบ
                                    </a>
                                </div>

                            </div><!-- /.glass-card-inner -->
                        </div><!-- /.glass-card -->

                    </div>
                </div>
            </div>
        </div>

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

</body>

</html>
