<?php 
require './config/connect.php'; 
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

    <link rel="stylesheet" type="text/css" href="./assets/vendor/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="./assets/vendor/slick/slick-theme.css" />

    <script src="./app/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="./app/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="./app/node_modules/axios/dist/axios.min.js"></script>

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
        <div class="page-header d-flex align-items-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-xl-9">

                        <div class="card bg-skys border-0 shadow-lg rounded-4">
                            <div class="card-body p-4 p-md-5">

                                <!-- หัวข้อ -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h1 class="h3 text-white mb-1 fkanit">
                                            สมัครเป็นผู้ประกอบการรถเช่า
                                        </h1>
                                        <p class="mb-0 text-white-50 fkanit">
                                            กรอกข้อมูลผู้ประกอบการและข้อมูลติดต่อให้ครบถ้วน เพื่อให้ลูกค้าสามารถค้นหาและจองรถได้สะดวก
                                        </p>
                                    </div>
                                    <div class="d-none d-md-block">
                                        <span class="badge bg-light text-dark fkanit">
                                            ART SKY | Partner Registration
                                        </span>
                                    </div>
                                </div>

                                <?php
                                if (isset($_POST['submit'])) {
                                    $turnstile_secret   = $turnstile_secret_key;
                                    $turnstile_response = $_POST['cf-turnstile-response'] ?? '';
                                    $url                = "https://challenges.cloudflare.com/turnstile/v0/siteverify";
                                    $post_fields        = "secret=$turnstile_secret&response=$turnstile_response";

                                    $car_rental_name = mysqli_real_escape_string($conn, $_POST['car_rental_name']);
                                    $phone           = mysqli_real_escape_string($conn, $_POST['phone']);
                                    $line_id         = mysqli_real_escape_string($conn, $_POST['line_id']);
                                    $email           = mysqli_real_escape_string($conn, $_POST['email']);
                                    $facebook        = mysqli_real_escape_string($conn, $_POST['facebook']);
                                    $website         = mysqli_real_escape_string($conn, $_POST['website']);
                                    $carrent_detail  = mysqli_real_escape_string($conn, $_POST['carrent_detail']);
                                    $province_id     = mysqli_real_escape_string($conn, $_POST['province_id']);
                                    $district_id     = mysqli_real_escape_string($conn, $_POST['district_id']);
                                    $subdistrict_id  = mysqli_real_escape_string($conn, $_POST['subdistrict_id']);
                                    $username        = mysqli_real_escape_string($conn, $_POST['username']);
                                    $password_hash   = mysqli_real_escape_string($conn, base64_encode($_POST['password']));
                                    $password_confirm = mysqli_real_escape_string($conn, base64_encode($_POST['password_confirm']));

                                    // call Turnstile
                                    $ch = curl_init($url);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                    curl_setopt($ch, CURLOPT_POST, true);
                                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
                                    $response = curl_exec($ch);
                                    curl_close($ch);

                                    $response_data = json_decode($response);

                                    // ป้องกันกรณี Turnstile ล่มหรือ json_decode ไม่ได้
                                    if (!$response_data || empty($response_data->success)) {
                                        echo <<<HTML
                                            <script>
                                                 $(()=>{
                                                    Swal.fire({
                                                        icon: "warning",
                                                        title: "ไม่สามารถลงทะเบียนได้",
                                                        text: "การตรวจสอบความปลอดภัยไม่สำเร็จ กรุณาลองใหม่อีกครั้ง",
                                                        showConfirmButton: true
                                                    });
                                                 });
                                            </script>
                                            HTML;
                                    } else {

                                        $sql_check_username = "
                                            SELECT tbl_car_rental.username AS 'username'
                                            FROM tbl_car_rental
                                            WHERE tbl_car_rental.username = '$username'
                                            UNION
                                            SELECT tbl_hotel.hotel_user
                                            FROM tbl_hotel
                                            WHERE tbl_hotel.hotel_user = '$username'
                                        ";
                                        $result_check_username = mysqli_query($conn, $sql_check_username);
                                        $num_check_username    = mysqli_num_rows($result_check_username);

                                        if ($num_check_username > 0) {
                                            echo <<<HTML
                                            <script>
                                                 $(()=>{
                                                    Swal.fire({
                                                        icon: "error",
                                                        title: "ชื่อผู้ใช้นี้ถูกใช้แล้ว",
                                                        confirmButtonText: "ตกลง"
                                                    });
                                                });
                                            </script>
                                            HTML;
                                        }

                                        if ($password_confirm !== $password_hash) {
                                            echo <<<HTML
                                            <script>
                                                 $(()=>{
                                                    Swal.fire({
                                                        icon: "error",
                                                        title: "รหัสผ่านและการยืนยันรหัสผ่านไม่ตรงกัน",
                                                        confirmButtonText: "ตกลง"
                                                    });
                                                });
                                            </script>
                                            HTML;
                                        }

                                        if ($num_check_username === 0 && $password_confirm === $password_hash) {
                                            $sql_cnm = "
                                                INSERT INTO tbl_car_rental SET 
                                                    car_rental_id      = NULL,
                                                    car_rental_name    = '$car_rental_name',
                                                    phone              = '$phone',
                                                    line_id            = '$line_id',
                                                    email              = '$email',
                                                    facebook           = '$facebook',
                                                    website            = '$website',
                                                    username           = '$username',
                                                    password_hash      = '$password_hash',
                                                    status_car_rental  = 2,
                                                    carrent_detail     = '$carrent_detail',
                                                    province_id        = '$province_id',
                                                    district_id        = '$district_id',
                                                    subdistrict_id     = '$subdistrict_id',
                                                    created_at         = CURRENT_TIMESTAMP(),
                                                    updated_at         = CURRENT_TIMESTAMP()
                                            ";
                                            $result_cnm = mysqli_query($conn, $sql_cnm);
                                            $last_id    = mysqli_insert_id($conn);

                                            if (!empty($_FILES['car_rental_image_name']['name'][0])) {

                                                for ($i = 0; $i < count($_FILES['car_rental_image_name']['name']); ++$i) {
                                                    if ($_FILES['car_rental_image_name']['error'][$i] !== UPLOAD_ERR_OK) {
                                                        continue;
                                                    }

                                                    $car_rental_image_name = $_FILES['car_rental_image_name']['name'][$i];
                                                    $tmp = explode('.', $car_rental_image_name);
                                                    $ext = strtolower(end($tmp));
                                                    $crt_image = "car_rental_image_name_" . date('dmYHis') . '_' . rand(00000000, 99999999) . '.' . $ext;

                                                    $imageUploadPath = "./images/car_rental/" . $crt_image;
                                                    $fileType        = strtolower(pathinfo($imageUploadPath, PATHINFO_EXTENSION));

                                                    // เพิ่ม svg ให้ตรงกับข้อความแจ้งเตือน
                                                    $allowTypes = array('jpg', 'jpeg', 'png', 'gif', 'svg');
                                                    if (in_array($fileType, $allowTypes)) {
                                                        $imageTemp = $_FILES["car_rental_image_name"]["tmp_name"][$i];
                                                        $imageSize = convert_filesize($_FILES["car_rental_image_name"]["size"][$i]);

                                                        $compressedImage = compressImage($imageTemp, $imageUploadPath, 75);

                                                        if ($compressedImage) {
                                                            $compressedImageSize = filesize($compressedImage);
                                                            $compressedImageSize = convert_filesize($compressedImageSize);

                                                            $sql_im = "
                                                                INSERT INTO tbl_car_rental_image SET 
                                                                    car_rental_image_id   = NULL,
                                                                    car_rental_id         = '$last_id',
                                                                    car_rental_image_name = '$crt_image'
                                                            ";
                                                            $result_im = mysqli_query($conn, $sql_im);
                                                        } else {
                                                            echo <<<HTML
                                                            <script>
                                                                 $(()=>{
                                                                    Swal.fire({
                                                                        icon: "error",
                                                                        text: "การบีบอัดภาพล้มเหลว",
                                                                        confirmButtonText: "ตกลง"
                                                                    });
                                                                });
                                                            </script>
                                                            HTML;
                                                        }
                                                    } else {
                                                        echo <<<HTML
                                                        <script>
                                                             $(()=>{
                                                                Swal.fire({
                                                                    icon: "error",
                                                                    text: "ขออภัย อนุญาตให้อัปโหลดเฉพาะไฟล์ JPG, JPEG, PNG, SVG และ GIF",
                                                                    confirmButtonText: "ตกลง"
                                                                });
                                                             });
                                                        </script>
                                                        HTML;
                                                    }
                                                }
                                            }

                                            if ($result_cnm) {
                                                echo <<<HTML
                                                <script>
                                                     $(()=>{
                                                        Swal.fire({
                                                            icon: 'success',
                                                            title: 'ลงทะเบียนสำเร็จ <br>รออนุมัติจากเจ้าหน้าที่เพื่อทำการเข้าสู่ระบบ',
                                                            showConfirmButton: false,
                                                            timer: 5000
                                                        }).then(() => { location.href='carrent-login'; });
                                                    });
                                                </script>
                                                HTML;
                                            }
                                        }
                                    }
                                }
                                ?>

                                <!-- ฟอร์มลงทะเบียนผู้ประกอบการ -->
                                <form id="carRentalRegisterForm" class="row g-3" method="post" action="" enctype="multipart/form-data">

                                    <!-- กลุ่ม: รูปภาพประกอบ -->
                                    <div class="col-12 mt-3">
                                        <h5 class="text-white fkanit mb-2">รูปภาพสำหรับรถเช่า</h5>
                                        <hr class="border-secondary mt-0 mb-3">
                                    </div>

                                    <div class="col-md-8">
                                        <label class="form-label text-white fkanit">
                                            รูปภาพร้าน / รถเช่า (อัปโหลดได้หลายรูป)
                                        </label>
                                        <div class="mb-3">
                                            <input type="file"
                                                class="form-control fkanit"
                                                name="car_rental_image_name[]"
                                                accept="image/*">
                                        </div>
                                        <div class="mb-3">
                                            <input type="file"
                                                class="form-control fkanit"
                                                name="car_rental_image_name[]"
                                                accept="image/*">
                                        </div>
                                        <div class="mb-3">
                                            <input type="file"
                                                class="form-control fkanit"
                                                name="car_rental_image_name[]"
                                                accept="image/*">
                                        </div>
                                        <div class="mb-3">
                                            <input type="file"
                                                class="form-control fkanit"
                                                name="car_rental_image_name[]"
                                                accept="image/*">
                                        </div>
                                        <div class="mb-3">
                                            <input type="file"
                                                class="form-control fkanit"
                                                name="car_rental_image_name[]"
                                                accept="image/*">
                                        </div>
                                        <div class="mb-3">
                                            <input type="file"
                                                class="form-control fkanit"
                                                name="car_rental_image_name[]"
                                                accept="image/*">
                                        </div>
                                        <div class="mb-3">
                                            <input type="file"
                                                class="form-control fkanit"
                                                name="car_rental_image_name[]"
                                                accept="image/*">
                                        </div>

                                        <div class="form-text text-light fkanit">
                                            แนะนำขนาด 1200x800px ขึ้นไป, รองรับไฟล์ .jpg .png
                                        </div>
                                    </div>

                                    <!-- กลุ่ม: ข้อมูลผู้ประกอบการ -->
                                    <div class="col-12">
                                        <h5 class="text-white fkanit mb-2">ข้อมูลผู้ประกอบการ</h5>
                                        <hr class="border-secondary mt-0 mb-3">
                                    </div>

                                    <div class="col-md-8">
                                        <label for="car_rental_name" class="form-label text-white fkanit">ชื่อผู้ประกอบการ / ชื่อร้าน *</label>
                                        <input type="text" class="form-control fkanit" id="car_rental_name" name="car_rental_name" required>
                                    </div>

                                    <!-- กลุ่ม: ข้อมูลติดต่อ -->
                                    <div class="col-12 mt-3">
                                        <h5 class="text-white fkanit mb-2">ข้อมูลติดต่อ</h5>
                                        <hr class="border-secondary mt-0 mb-3">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="phone" class="form-label text-white fkanit">เบอร์โทรศัพท์ *</label>
                                        <input type="text" class="form-control fkanit" id="phone" name="phone" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="line_id" class="form-label text-white fkanit">LINE ID</label>
                                        <input type="text" class="form-control fkanit" id="line_id" name="line_id">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="email" class="form-label text-white fkanit">อีเมล</label>
                                        <input type="email" class="form-control fkanit" id="email" name="email">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="facebook" class="form-label text-white fkanit">Facebook Page</label>
                                        <input type="text" class="form-control fkanit" id="facebook" name="facebook">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="website" class="form-label text-white fkanit">เว็บไซต์</label>
                                        <input type="text" class="form-control fkanit" id="website" name="website">
                                    </div>

                                    <!-- กลุ่ม: ที่ตั้งสาขา -->
                                    <div class="col-12 mt-3">
                                        <h5 class="text-white fkanit mb-2">ที่ตั้งสาขา</h5>
                                        <hr class="border-secondary mt-0 mb-3">
                                    </div>

                                    <div class="col-12">
                                        <label for="carrent_detail" class="form-label text-white fkanit">
                                            ระบุรายละเอียดบริการ เช่น ราคา สถานะให้บริการ และจำนวนผู้โดยสารต่อคัน
                                            รายละเอียดบริการ *
                                        </label>
                                        <textarea class="form-control fkanit" id="carrent_detail" name="carrent_detail" rows="5" required></textarea>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="province_id" class="form-label text-white fkanit">จังหวัด *</label>
                                        <select id="province_id" name="province_id" class="form-select fkanit" required>
                                            <option value="">-- เลือกจังหวัด --</option>
                                            <?php
                                            $sql_pv = "SELECT tbl_provinces.id,tbl_provinces.name_in_thai FROM tbl_provinces ORDER BY CONVERT(tbl_provinces.name_in_thai USING tis620) ASC";
                                            $result_pv = mysqli_query($conn, $sql_pv);
                                            while ($rs_pv = mysqli_fetch_assoc($result_pv)) {
                                            ?>
                                                <option value="<?= $rs_pv['id'] ?>"><?= $rs_pv['name_in_thai'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="district_id" class="form-label text-white fkanit">อำเภอ *</label>
                                        <select id="district_id" name="district_id" class="form-select fkanit" required>
                                            <option value="">-- เลือกอำเภอ --</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="subdistrict_id" class="form-label text-white fkanit">ตำบล *</label>
                                        <select id="subdistrict_id" name="subdistrict_id" class="form-select fkanit" required>
                                            <option value="">-- เลือกตำบล --</option>
                                        </select>
                                    </div>

                                    <!-- กลุ่ม: ข้อมูลเข้าสู่ระบบ -->
                                    <div class="col-12 mt-3">
                                        <h5 class="text-white fkanit mb-2">ข้อมูลเข้าสู่ระบบ</h5>
                                        <hr class="border-secondary mt-0 mb-3">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="username" class="form-label text-white fkanit">ชื่อผู้ใช้ (Username) *</label>
                                        <input type="text" class="form-control fkanit" id="username" name="username" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="password" class="form-label text-white fkanit">รหัสผ่าน *</label>
                                        <input type="password" class="form-control fkanit" id="password" name="password" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="password_confirm" class="form-label text-white fkanit">ยืนยันรหัสผ่าน *</label>
                                        <input type="password" class="form-control fkanit" id="password_confirm" name="password_confirm" required>
                                    </div>

                                    <div class="col-md-12 text-center">
                                        <div class="cf-turnstile d-inline-block mb-3" data-sitekey="<?= htmlspecialchars($turnstile_site_key, ENT_QUOTES, 'UTF-8') ?>"></div>
                                    </div>

                                    <!-- ปุ่มกด -->
                                    <div class="col-12 mt-4 d-flex justify-content-between">
                                        <button type="reset" class="btn btn-outline-light fkanit">
                                            ล้างข้อมูล
                                        </button>
                                        <button id="sbm_form" type="submit" name="submit" class="btn btn-light fkanit" disabled>
                                            ส่งคำขอลงทะเบียน
                                        </button>
                                    </div>

                                </form>

                            </div>
                        </div>

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

    <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

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
    </script>
</body>

</html>
