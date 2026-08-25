<?php require './config/connect.php'; 
if (isset($_SESSION['sess_ht_artsky']) && isset($_SESSION['sess_login_artsky_ht'])) {
    $hotelId   = base64_decode($_SESSION['sess_ht_artsky']);
    $sql_ht    = " SELECT * FROM tbl_hotel WHERE hotel_id = '$hotelId' ";
    $result_ht = mysqli_query($conn, $sql_ht);
    $no_ht     = mysqli_num_rows($result_ht);
    $rs_ht     = mysqli_fetch_assoc($result_ht);
    if ($no_ht > 0) {
        header("location:hotel-profile");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="th">

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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
        integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="./app/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>

    <style>
        body {
            background: url("./images/head_bg.jpg") no-repeat top center fixed;
            background-size: cover;
            /* font-family: "Noto Serif Thai", serif; */
        }

        #header {
            background: transparent;
        }

        .login-page-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .login-card {
            background: rgba(0, 0, 0, 0.16);
            border-radius: 1.25rem;
            padding: 2.25rem 2rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(10px);
        }

        .login-card h3 {
            color: #ffffff;
        }

        .login-subtitle {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        .form-label {
            color: rgba(255, 255, 255, 0.85);
            font-size: 0.85rem;
            margin-bottom: 0.35rem;
        }

        .input-group-text {
            background-color: rgba(15, 23, 42, 0.95);
            border-color: rgba(148, 163, 184, 0.6);
            color: rgba(148, 163, 184, 0.95);
        }

        .form-control.bg-dark {
            background-color: rgba(15, 23, 42, 0.95) !important;
            border-color: rgba(148, 163, 184, 0.6);
            color: #f9fafb;
            border-radius: 0.75rem;
        }

        .form-control.bg-dark::placeholder {
            color: rgba(148, 163, 184, 0.7);
        }

        .form-control.bg-dark:focus {
            border-color: #38bdf8;
            box-shadow: 0 0 0 1px rgba(56, 189, 248, 0.4);
        }

        .btn-login {
            border-radius: 999px;
            padding-inline: 2.5rem;
        }

        .btn-login i {
            margin-right: 0.25rem;
        }

        .btn-action {
            border-radius: 999px;
        }

        .toggle-password {
            cursor: pointer;
        }
    </style>
</head>

<body>

    <!-- ======= Header ======= -->
    <?php require './layout/header.php'; ?>
    <!-- End Header -->

    <main id="main" data-aos="fade" data-aos-delay="1500">

        <!-- ======= Page Header / Login ======= -->
        <div class="page-header d-flex align-items-center login-page-wrapper">
            <div class="container position-relative">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-4 col-md-6">
                        <div class="login-card text-center">

                            <h3 class="mb-0">ผู้ประกอบการโรงแรมที่พัก</h3>
                            <h3 class="mb-2">เข้าสู่ระบบ</h3>
                            <p class="login-subtitle mb-3">
                                เข้าสู่ระบบเพื่อจัดการข้อมูลโรงแรมของคุณบน ART SKY
                            </p>

                            <?php
                            if (isset($_POST['submit'])) {
                                $turnstile_secret   = $turnstile_secret_key;
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
                                                 timer: 1000,
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

                            <form action="" method="post" class="php-email-form mt-3 text-start">
                                <!-- Username -->
                                <div class="mb-3">
                                    <label for="user_name" class="form-label">
                                        <i class="bi bi-person-circle me-1"></i> ชื่อผู้ใช้งาน
                                    </label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text">
                                            <i class="bi bi-person"></i>
                                        </span>
                                        <input
                                            type="text"
                                            class="form-control bg-dark text-light border-secondary"
                                            name="user_name"
                                            id="user_name"
                                            placeholder="กรอกชื่อผู้ใช้งาน (Username)"
                                            autocomplete="username"
                                            required>
                                    </div>
                                </div>

                                <!-- Password -->
                                <div class="mb-3">
                                    <label for="pass_name" class="form-label">
                                        <i class="bi bi-shield-lock me-1"></i> รหัสผ่าน
                                    </label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text">
                                            <i class="bi bi-lock"></i>
                                        </span>
                                        <input
                                            type="password"
                                            class="form-control bg-dark text-light border-secondary"
                                            name="pass_name"
                                            id="pass_name"
                                            placeholder="กรอกรหัสผ่าน"
                                            autocomplete="current-password"
                                            required>
                                        <span class="input-group-text toggle-password" id="togglePassword">
                                            <i class="bi bi-eye-slash" id="togglePasswordIcon"></i>
                                        </span>
                                    </div>
                                </div>

                                <!-- Turnstile -->
                                <div class="text-center my-3">
                                    <div class="cf-turnstile" data-sitekey="<?= htmlspecialchars($turnstile_site_key, ENT_QUOTES, 'UTF-8') ?>"></div>
                                </div>

                                <div class="text-center mb-2">
                                    <button
                                        type="submit"
                                        class="btn btn-lg btn-primary btn-login"
                                        name="submit"
                                        id="sbm_form">
                                        <i class="bi bi-box-arrow-in-right"></i> เข้าสู่ระบบ
                                    </button>
                                </div>
                            </form>

                            <hr class="border-secondary">

                            <div class="d-grid gap-2">
                                <a class="btn btn-danger fs-6 btn-action" href="register">
                                    <i class="bi bi-person-add"></i> ลงทะเบียน
                                </a>
                                <a class="btn btn-success fs-6 btn-action" target="_blank"
                                    href="https://m.me/artsky.support">
                                    <i class="bi bi-person-lock"></i> ลืมรหัสผ่านติดต่อผู้พัฒนาระบบ
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div><!-- End Page Header -->
    </main>

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
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        // toggle show / hide password
        $('#togglePassword').on('click', function() {
            const passInput = $('#pass_name');
            const icon = $('#togglePasswordIcon');
            const currentType = passInput.attr('type');
            if (currentType === 'password') {
                passInput.attr('type', 'text');
                icon.removeClass('bi-eye-slash').addClass('bi-eye');
            } else {
                passInput.attr('type', 'password');
                icon.removeClass('bi-eye').addClass('bi-eye-slash');
            }
        });
    </script>

</body>

</html>
