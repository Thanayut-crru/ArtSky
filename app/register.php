<?php
require 'config/connect.php';
require 'config/function.php';
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

    <!-- Sweetalert -->
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

        #contact ::placeholder {
            color: rgba(255, 255, 255, 0.3);
            opacity: 1;
        }

        #contact ::-ms-input-placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        /* liquid glass design */
        /* กล่องรวมทั้งหมด */
        .glass-card {
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.12);
            border-radius: 22px;
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
        }

        /* หัวข้อ */
        .glass-header {
            background: rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(15px);
            padding: 18px 22px;
            border-radius: 22px 22px 0 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* ปุ่ม */
        .glass-btn {
            background: rgba(255, 255, 255, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(10px);
            color: #fff;
            transition: 0.25s;
        }

        .glass-btn:hover {
            background: rgba(255, 255, 255, 0.5);
            color: #222;
        }

        /* input แบบ glass */
        .glass-input {
            backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, 0.28);
            border: 1px solid rgba(255, 255, 255, 0.4);
            color: #fff;
        }

        .glass-input::placeholder {
            color: rgba(255, 255, 255, 0.8);
        }

        label {
            color: #fff;
            font-weight: 500;
        }

        h5,
        h6 {
            color: #fff;
        }

        .section-title {
            margin-bottom: 14px;
            border-left: 4px solid rgba(255, 255, 255, 0.6);
            padding-left: 12px;
        }

        /* liquid glass design */
    </style>
</head>

<body>

    <!-- ======= Header ======= -->
    <?php require './layout/header.php'; ?>
    <!-- End Header -->

    <main id="main" data-aos="fade" data-aos-delay="1500">

        <!-- ======= End Page Header ======= -->
        <div class="page-header d-flex align-items-center">
            <div class="container position-relative">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-6 text-center">
                        <h2>ART SKY</h2>
                        <p>ลงทะเบียนสำหรับผู้ประกอบการที่พัก</p>
                    </div>
                </div>
            </div>
        </div><!-- End Page Header -->

        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <?php
                        if (isset($_POST['submit'])) {
                            $turnstile_secret     = $turnstile_secret_key;
                            $turnstile_response   = $_POST['cf-turnstile-response'];
                            $url                  = "https://challenges.cloudflare.com/turnstile/v0/siteverify";
                            $post_fields          = "secret=$turnstile_secret&response=$turnstile_response";

                            $hotel_name = mysqli_real_escape_string($conn, $_POST['hotel_name']);
                            $hotel_lat = mysqli_real_escape_string($conn, $_POST['hotel_lat']);
                            $hotel_lon = mysqli_real_escape_string($conn, $_POST['hotel_lon']);
                            $hotel_price = mysqli_real_escape_string($conn, $_POST['hotel_price']);
                            $hotel_telephone = mysqli_real_escape_string($conn, $_POST['hotel_telephone']);
                            $hotel_line = mysqli_real_escape_string($conn, $_POST['hotel_line']);
                            $hotel_email = mysqli_real_escape_string($conn, $_POST['hotel_email']);
                            $hotel_facebook = mysqli_real_escape_string($conn, $_POST['hotel_facebook']);
                            $hotel_website = mysqli_real_escape_string($conn, $_POST['hotel_website']);
                            $hotel_user = mysqli_real_escape_string($conn, $_POST['hotel_user']);
                            $hotel_password = mysqli_real_escape_string($conn, base64_encode($_POST['hotel_password']));

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
                                        title: "ไม่สามารถลงทะเบียนได้",
                                        showConfirmButton: false,
                                        timer: 5000,
                                      });
                                    </script>';
                            } else {


                                $sql_check_hotel_name = " SELECT hotel_name FROM tbl_hotel WHERE hotel_name = '$hotel_name' ";
                                $result_check_hotel_name = mysqli_query($conn, $sql_check_hotel_name);
                                $num_check_hotel_name = mysqli_num_rows($result_check_hotel_name);
                                if ($num_check_hotel_name > 0) {
                                    echo "<script>
                                            $(function() {
                                                warnDuplicate('ชื่อโรงแรมถูกใช้แล้ว');
                                            })
                                            </script>";
                                }

                                $sql_check_hotel_user = " SELECT tbl_car_rental.username AS 'username' FROM tbl_car_rental WHERE tbl_car_rental.username = '$hotel_user'
                                                        UNION
                                                        SELECT tbl_hotel.hotel_user FROM tbl_hotel WHERE tbl_hotel.hotel_user = '$hotel_user' ";
                                $result_check_hotel_user = mysqli_query($conn, $sql_check_hotel_user);
                                $num_check_hotel_user = mysqli_num_rows($result_check_hotel_user);
                                if ($num_check_hotel_user > 0) {
                                    echo "<script>
                                            $(function() {
                                                warnDuplicate('ชื่อผู้ใช้ถูกใช้แล้ว');
                                            })
                                            </script>";
                                }

                                if ($num_check_hotel_name === 0 && $num_check_hotel_user === 0) {
                                    $sql_cnm = " INSERT INTO tbl_hotel SET hotel_id = NULL, 
                                    hotel_name      = '$hotel_name',
                                    hotel_lat       = '$hotel_lat',
                                    hotel_lon       = '$hotel_lon',
                                    hotel_price     = '$hotel_price',
                                    hotel_telephone = '$hotel_telephone',
                                    hotel_line      = '$hotel_line',
                                    hotel_email     = '$hotel_email',
                                    hotel_facebook  = '$hotel_facebook',
                                    hotel_website   = '$hotel_website',
                                    hotel_user      = '$hotel_user',
                                    hotel_password  = '$hotel_password',
                                    hotel_status    = 2,
                                    hotel_created   = CURRENT_TIMESTAMP(),
                                    hotel_updated   = CURRENT_TIMESTAMP() ";
                                    $result_cnm = mysqli_query($conn, $sql_cnm);
                                    $last_id = mysqli_insert_id($conn);

                                    if ($_FILES['hotel_image']['name'][0] != '') {
                                        // File info 
                                        for ($i = 0; $i < count($_FILES['hotel_image']['name']); ++$i) {
                                            if (empty($_FILES['hotel_image']['error'][$i])) {
                                                $hotel_image = $_FILES['hotel_image']['name'][$i];
                                                $tmp = explode('.', $hotel_image);
                                                $ext = strtolower(end($tmp));
                                                $htl_image = "hotel_image_" . date('dmYHis') . '_' . rand(00000000, 99999999) . '.' . $ext;

                                                $imageUploadPath = "./images/hotel_image/" . $htl_image;
                                                $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);

                                                // Allow certain file formats 
                                                $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
                                                if (in_array($fileType, $allowTypes)) {
                                                    // Image temp source and size 
                                                    $imageTemp = $_FILES["hotel_image"]["tmp_name"][$i];
                                                    $imageSize = convert_filesize($_FILES["hotel_image"]["size"][$i]);

                                                    // Compress size and upload image 
                                                    $compressedImage = compressImage($imageTemp, $imageUploadPath, 75);

                                                    if ($compressedImage) {
                                                        $compressedImageSize = filesize($compressedImage);
                                                        $compressedImageSize = convert_filesize($compressedImageSize);
                                                        $sql_im = " INSERT INTO tbl_hotel_image SET 
                                                         hotel_image_id   = NULL,
                                                         hotel_id         = '$last_id',
                                                         hotel_image_name = '$htl_image' ";
                                                        $result_im = mysqli_query($conn, $sql_im);
                                                    } else {
                                                        echo "<script>
                                                        $(function() {
                                                            warnDuplicate('การบีบอัดภาพล้มเหลว');
                                                        })
                                                        </script>";
                                                    }
                                                } else {
                                                    echo "<script>
                                                        $(function() {
                                                            warnDuplicate('ขออภัย อนุญาตให้อัปโหลดเฉพาะไฟล์ JPG, JPEG, PNG, SVG และ GIF');
                                                        })
                                                        </script>";
                                                }
                                            }
                                        }
                                    }

                                    if ($result_cnm) {
                                        /* Success Start */
                                        echo "<script>
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'ลงทะเบียนสำเร็จ <br>รออนุมัติจากเจ้าหน้าที่เพื่อทำการเข้าสู่ระบบ',
                                                showConfirmButton: false,
                                                timer: 5000,
                                            }).then(()=>{location.href='login';});
                                        </script>";
                                        /* Success End */
                                    }
                                }
                            }
                        }
                        ?>
                        <form action="" method="post" enctype="multipart/form-data" class="php-email-form">
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-lg-10 col-xl-8">

                                        <!-- Glass Form -->
                                        <div class="glass-card">

                                            <!-- Header -->
                                            <div class="glass-header">
                                                <h5 class="mb-0 d-flex align-items-center">
                                                    <i class="bi bi-building-add me-2"></i> ลงทะเบียนโรงแรม / ที่พัก
                                                </h5>
                                            </div>

                                            <div class="card-body p-4">

                                                <!-- Section: Hotel Info -->
                                                <h6 class="section-title">ข้อมูลโรงแรม</h6>
                                                <div class="row g-3">

                                                    <div class="col-md-12">
                                                        <label for="hotel_name">ชื่อโรงแรม *</label>
                                                        <input type="text" class="form-control glass-input" name="hotel_name" id="hotel_name" required>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="hotel_lat">ละติจูด *</label>
                                                        <input type="text" class="form-control glass-input" name="hotel_lat" id="hotel_lat" required>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="hotel_lon">ลองจิจูด *</label>
                                                        <input type="text" class="form-control glass-input" name="hotel_lon" id="hotel_lon" required>
                                                    </div>

                                                    <div class="col-md-4 d-flex align-items-end">
                                                        <button type="button" class="btn glass-btn w-100" id="location_now">
                                                            <i class="bi bi-geo-alt"></i> ใช้ตำแหน่งปัจจุบัน
                                                        </button>
                                                    </div>

                                                </div>

                                                <hr class="border-white">

                                                <!-- Section: Images -->
                                                <h6 class="section-title">รูปภาพโรงแรม</h6>
                                                <div class="row g-3">
                                                    <div class="col-md-12">
                                                        <label>รูปภาพหลัก *</label>
                                                        <input type="file" class="form-control glass-input pt-2" name="hotel_image[]" required>
                                                    </div>

                                                    <!-- Additional Images -->
                                                    <div class="col-md-6 col-lg-4">
                                                        <input type="file" class="form-control glass-input pt-2" name="hotel_image[]">
                                                    </div>
                                                    <div class="col-md-6 col-lg-4">
                                                        <input type="file" class="form-control glass-input pt-2" name="hotel_image[]">
                                                    </div>
                                                    <div class="col-md-6 col-lg-4">
                                                        <input type="file" class="form-control glass-input pt-2" name="hotel_image[]">
                                                    </div>
                                                    <div class="col-md-6 col-lg-4">
                                                        <input type="file" class="form-control glass-input pt-2" name="hotel_image[]">
                                                    </div>
                                                    <div class="col-md-6 col-lg-4">
                                                        <input type="file" class="form-control glass-input pt-2" name="hotel_image[]">
                                                    </div>
                                                    <div class="col-md-6 col-lg-4">
                                                        <input type="file" class="form-control glass-input pt-2" name="hotel_image[]">
                                                    </div>
                                                </div>

                                                <hr class="border-white">

                                                <!-- Section: Contact -->
                                                <h6 class="section-title">ข้อมูลติดต่อ</h6>
                                                <div class="row g-3">

                                                    <div class="col-md-6">
                                                        <label for="hotel_price">ราคาเริ่มต้น/คืน (ใช้ในการโปรโมทราคาเริ่มต้น)*</label>
                                                        <input type="number" step="0.01" class="form-control glass-input" name="hotel_price" id="hotel_price" required>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="hotel_telephone">เบอร์โทร *</label>
                                                        <input type="text" class="form-control glass-input" name="hotel_telephone" id="hotel_telephone" required>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="hotel_line">ไลน์ *</label>
                                                        <input type="text" class="form-control glass-input" name="hotel_line" id="hotel_line" required>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="hotel_email">อีเมล</label>
                                                        <input type="email" class="form-control glass-input" name="hotel_email" id="hotel_email">
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="hotel_facebook">Facebook</label>
                                                        <input type="text" class="form-control glass-input" name="hotel_facebook" id="hotel_facebook">
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="hotel_website">เว็บไซต์</label>
                                                        <input type="text" class="form-control glass-input" name="hotel_website" id="hotel_website">
                                                    </div>

                                                </div>

                                                <hr class="border-white">

                                                <!-- Section: Account -->
                                                <h6 class="section-title">บัญชีผู้ใช้สำหรับเข้าสู่ระบบ</h6>
                                                <div class="row g-3 justify-content-center">

                                                    <div class="col-md-8">
                                                        <label for="hotel_user">ชื่อผู้ใช้ *</label>
                                                        <input type="text" class="form-control glass-input" name="hotel_user" id="hotel_user" required>
                                                    </div>

                                                    <div class="col-md-8">
                                                        <label for="hotel_password">รหัสผ่าน *</label>
                                                        <input type="password" class="form-control glass-input" name="hotel_password" id="hotel_password" required>
                                                    </div>

                                                    <div class="col-md-8">
                                                        <label for="hotel_confirm_password">ยืนยันรหัสผ่าน *</label>
                                                        <input type="password" class="form-control glass-input" name="hotel_confirm_password" id="hotel_confirm_password" required>
                                                    </div>

                                                </div>

                                            </div>

                                            <!-- Footer -->
                                            <div class="text-center py-3">
                                                <div class="cf-turnstile d-inline-block mb-3" data-sitekey="<?= htmlspecialchars($turnstile_site_key, ENT_QUOTES, 'UTF-8') ?>"></div>
                                                <div>
                                                    <button type="submit" name="submit" id="sbm_form"
                                                        class="btn glass-btn px-5 py-2 rounded-pill fw-semibold">
                                                        <i class="bi bi-pencil-square me-1"></i> ลงทะเบียน
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>


                    </div><!-- End Contact Form -->

                </div>

            </div>
        </section>
        <!-- End Contact Section -->

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

    <script type="text/javascript" src="./assets/vendor/slick/slick.min.js"></script>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- cloudflare -->
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js?onload=_turnstileCb" defer></script>
    <script>
        $('#location_now').click(() => {
            if (navigator.geolocation) {
                Swal.showLoading();
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                Swal.fire({
                    icon: "warning",
                    title: "เบราว์เซอร์นี้ไม่รองรับตำแหน่งทางภูมิศาสตร์",
                    showConfirmButton: false,
                    timer: 5000,
                });
            }
        })

        function showPosition(position) {
            let hotel_lat = $('#hotel_lat').val(position.coords.latitude);
            let hotel_lon = $('#hotel_lon').val(position.coords.longitude);
            if (hotel_lat !== '' && hotel_lon !== '') {
                Swal.close();
            }
        }

        $(document).ready(function() {
            $('#hotel_password, #hotel_confirm_password').on('keyup', function() {
                // Get password and confirm password values
                const password = $('#hotel_password').val();
                const confirmPassword = $('#hotel_confirm_password').val();

                // Check if passwords match
                const passwordsMatch = password === confirmPassword;

                // Update submit button state
                $('#sbm_form').prop('disabled', !passwordsMatch);

                // Optionally provide visual feedback (consider accessibility)
                if (passwordsMatch) {
                    $('#hotel_confirm_password').css('border-color', 'green');
                } else {
                    $('#hotel_confirm_password').css('border-color', 'red');
                }
            });
        });

        function warnDuplicate(warnings) {
            Swal.fire({
                icon: "error",
                title: "ไม่สามารถบันทึกข้อมูลได้",
                text: warnings,
                confirmButtonText: "ตกลง",
            });
        }
    </script>

</body>

</html>
