<?php require './config/connect.php'; ?>
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
        <div class="page-header d-flex align-items-center vh-100">
            <div class="container position-relative">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-4 col-md-6 text-center">
                        <h3>ผู้ประกอบการโรงแรมที่พัก</h3>
                        <h3>เข้าสู่ระบบ</h3>
                        <?php
                        if (isset($_POST['submit'])) {
                            $turnstile_secret   = '0x4AAAAAAAaNNk4fPx-rDaDkTp7PoIifjIA';
                            $turnstile_response = $_POST['cf-turnstile-response'];
                            $url                = "https://challenges.cloudflare.com/turnstile/v0/siteverify";
                            $post_fields        = "secret=$turnstile_secret&response=$turnstile_response";

                            $user_name = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['user_name']));
                            $pass_name = htmlspecialchars(mysqli_real_escape_string($conn, base64_encode($_POST['pass_name'])));

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
                                $sql = " SELECT * FROM tbl_hotel WHERE hotel_user = '$user_name' AND hotel_password = '$pass_name' ";
                                $result = mysqli_query($conn, $sql);
                                $num = mysqli_num_rows($result);

                                if ($num > 0) {
                                    $rs = mysqli_fetch_assoc($result);
                                    $_SESSION['sess_ht_artsky'] = base64_encode($rs['hotel_id']);
                                    $_SESSION['sess_login_artsky_ht'] = true;
                                    echo "<script>
                                             Swal.fire({
                                                 icon: 'success',
                                                 title: 'เข้าสู่ระบบสำเร็จ',
                                                 showConfirmButton: false,
                                                 timer: 5000,
                                             }).then(()=>{location.href='hotel-profile';});
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
                        <form action="" method="post" class="php-email-form">
                            <div class="row">
                                <div class="col-md-12 input-group input-group-lg mb-3">
                                    <input type="text" class="form-control bg-dark text-light border-dark" name="user_name" id="user_name" placeholder="" required>
                                </div>
                                <div class="col-md-12 input-group input-group-lg mb-3 mt-md-0">
                                    <input type="password" class="form-control bg-dark text-light border-dark" name="pass_name" id="pass_name" placeholder="" required>
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="cf-turnstile" data-sitekey="0x4AAAAAAAaNNm2nFLfZKpYn"></div>
                            </div>
                            <div class="text-center"><button type="submit" class="btn btn-lg btn-primary" name="submit" id="sbm_form"><i class="bi bi-box-arrow-in-right"></i> เข้าสู่ระบบ</button></div>
                        </form>
                        <hr>
                        <a class="mt-4 btn btn-danger fs-5" href="register"><i class="bi bi-person-add"></i> ลงทะเบียน</a>
                        <a class="mt-4 btn btn-success fs-5" target="_blank" href="http://line.me/ti/p/~kuma261"><i class="bi bi-person-lock"></i> ลืมรหัสผ่านติดต่อผู้พัฒนาระบบ</a>
                    </div>
                </div>
            </div>
        </div><!-- End Page Header -->
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