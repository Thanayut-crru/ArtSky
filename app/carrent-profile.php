<?php
require './config/connect.php';
require './config/function.php';
if (isset($_SESSION['sess_carrent_artsky']) && isset($_SESSION['sess_login_carrent_artsky'])) {
    $cId   = base64_decode($_SESSION['sess_carrent_artsky']);
    $sql_cr    = " SELECT * FROM tbl_car_rental WHERE car_rental_id = '$cId' ";
    $result_cr = mysqli_query($conn, $sql_cr);
    $no_cr    = mysqli_num_rows($result_cr);
    $rs_cr     = mysqli_fetch_assoc($result_cr);
    if ($no_cr === 0) {
        header("location:carrent-login");
        exit;
    }
} else {
    header("location:carrent-login");
    exit;
}
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

        /* --------------------------
           Hotel Images
        --------------------------- */
        .hotel-image-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .hotel-image-card {
            background: rgba(15, 23, 42, 0.9);
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(15, 23, 42, 0.7);
            border: 1px solid rgba(148, 163, 184, 0.2);
            max-width: 260px;
            flex: 1 1 220px;
        }

        .hotel-image-card img {
            width: 100%;
            object-fit: cover;
            aspect-ratio: 16 / 9;
        }

        .hotel-image-card-footer {
            padding: 0.5rem 0.75rem 0.75rem;
            text-align: right;
            background: linear-gradient(to top,
                    rgba(15, 23, 42, 0.95),
                    rgba(15, 23, 42, 0.75));
        }

        .upload-input-wrapper {
            background: rgba(15, 23, 42, 0.8);
            border-radius: 0.9rem;
            border: 1px dashed rgba(148, 163, 184, 0.6);
            padding: 0.9rem 1rem;
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
                            <div class="card-header p-3">
                                <button type="button" class="float-end btn btn-danger" onclick="logouts('carrent-logout');"><i class="bi bi-box-arrow-right"></i> ออกจากระบบ</button>
                            </div>
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

                                // Delete Image
                                if (isset($_GET['del_pic'])) {
                                    if (!empty($_GET['del_pic'])) {
                                        $pic_del       = $_GET['del_pic'];
                                        $sql_del_img   = " SELECT * FROM tbl_car_rental_image WHERE car_rental_image_id = '$pic_del' AND car_rental_id = '{$rs_cr['car_rental_id']}' ";
                                        $result_del_img = mysqli_query($conn, $sql_del_img);
                                        $num_del_img   = mysqli_num_rows($result_del_img);
                                        if ($num_del_img > 0) {
                                            $rs_del_img  = mysqli_fetch_assoc($result_del_img);
                                            $fileupload  = $rs_del_img['car_rental_image_name'];
                                            if ($fileupload != "") {
                                                @unlink("./images/car_rental/$fileupload");
                                            }
                                            $sql_update_img = " DELETE FROM tbl_car_rental_image WHERE car_rental_image_id = '$pic_del' AND car_rental_id = '{$rs_cr['car_rental_id']}' ";
                                            mysqli_query($conn, $sql_update_img);
                                        }
                                        header("refresh: 0; carrent-profile");
                                    }
                                }

                                // Submit Form
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
                                            WHERE tbl_car_rental.username = '$username' AND tbl_car_rental.car_rental_id <> '{$rs_cr['car_rental_id']}'
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
                                                UPDATE tbl_car_rental SET 
                                                          car_rental_name = '$car_rental_name',
                                                          phone           = '$phone',
                                                          line_id         = '$line_id',
                                                          email           = '$email',
                                                          facebook        = '$facebook',
                                                          website         = '$website',
                                                          username        = '$username',
                                                          password_hash   = '$password_hash',
                                                          carrent_detail  = '$carrent_detail',
                                                          province_id     = '$province_id',
                                                          district_id     = '$district_id',
                                                          subdistrict_id  = '$subdistrict_id'
                                                    WHERE car_rental_id   = '{$rs_cr['car_rental_id']}'
                                                    
                                            ";
                                            $result_cnm = mysqli_query($conn, $sql_cnm);
                                            $last_id    = $rs_cr['car_rental_id'];

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
                                                            title: 'บันทึกสำเร็จ',
                                                            showConfirmButton: false,
                                                            timer: 3000
                                                        });
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
                                        <h5 class="text-white fkanit mb-2 align-middle">รูปภาพสำหรับรถเช่า
                                        </h5>
                                        <hr class="border-secondary mt-2 mb-3">
                                    </div>

                                    <div class="col-md-8">
                                        <div class="hotel-image-grid mb-3">
                                            <?php
                                            $no       = 1;
                                            $sql_img  = " SELECT * FROM tbl_car_rental_image WHERE car_rental_id = '{$rs_cr['car_rental_id']}' ORDER BY car_rental_image_name ASC ";
                                            $result_img = mysqli_query($conn, $sql_img);
                                            $num_img  = mysqli_num_rows($result_img);

                                            if ($num_img > 0) {
                                                while ($rs_img = mysqli_fetch_assoc($result_img)) {
                                                    if ($rs_img['car_rental_image_name'] != "") {
                                            ?>
                                                        <div class="hotel-image-card">
                                                            <a href="./images/car_rental/<?= $rs_img['car_rental_image_name'] ?>" class="glightbox">
                                                                <img src="./images/car_rental/<?= $rs_img['car_rental_image_name'] ?>" alt="Hotel image">
                                                            </a>
                                                            <div class="hotel-image-card-footer">
                                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                                    onclick="cdelimg('รูปนี้','carrent-profile?del_pic=<?= $rs_img['car_rental_image_id'] ?>')">
                                                                    <i class="bi bi-trash"></i> ลบรูปนี้
                                                                </button>
                                                            </div>
                                                        </div>
                                            <?php
                                                    }
                                                    $no++;
                                                }
                                            }
                                            ?>
                                        </div>


                                        <?php
                                        // ช่องสำหรับอัปโหลดรูปเพิ่มให้ครบ 7 รูป (ตาม logic เดิม)
                                        for ($i = 1; $i <= (7 - $num_img); $i++) {
                                        ?>
                                            <div class="mb-3">
                                                <?php if ($i === 1 && $num_img === 0) { ?>
                                                    <label class="form-label text-white fkanit">
                                                        รูปภาพร้าน / รถเช่า (อัปโหลดได้หลายรูปอย่างน้อย 1 รูป)
                                                    </label>
                                                <?php } ?>
                                                <div class="upload-input-wrapper">
                                                    <input type="file" class="form-control fkanit"
                                                        name="car_rental_image_name[]" <?= ($i === 1 && $num_img === 0) ? 'required' : '' ?>
                                                        accept="image/gif, image/jpeg, image/png, image/jpg">
                                                    <div class="input-hint mt-1 text-light small">
                                                        รองรับไฟล์ JPG, JPEG, PNG, GIF แนะนำอัตราส่วน 16:9
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
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
                                        <input type="text" class="form-control fkanit" id="car_rental_name" name="car_rental_name" value="<?= $rs_cr['car_rental_name'] ?>" required>
                                    </div>

                                    <!-- กลุ่ม: ข้อมูลติดต่อ -->
                                    <div class="col-12 mt-3">
                                        <h5 class="text-white fkanit mb-2">ข้อมูลติดต่อ</h5>
                                        <hr class="border-secondary mt-0 mb-3">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="phone" class="form-label text-white fkanit">เบอร์โทรศัพท์ *</label>
                                        <input type="text" class="form-control fkanit" id="phone" name="phone" value="<?= $rs_cr['phone'] ?>" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="line_id" class="form-label text-white fkanit">LINE ID</label>
                                        <input type="text" class="form-control fkanit" id="line_id" name="line_id" value="<?= $rs_cr['line_id'] ?>">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="email" class="form-label text-white fkanit">อีเมล</label>
                                        <input type="email" class="form-control fkanit" id="email" name="email" value="<?= $rs_cr['email'] ?>">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="facebook" class="form-label text-white fkanit">Facebook Page</label>
                                        <input type="text" class="form-control fkanit" id="facebook" name="facebook" value="<?= $rs_cr['facebook'] ?>">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="website" class="form-label text-white fkanit">เว็บไซต์</label>
                                        <input type="text" class="form-control fkanit" id="website" name="website" value="<?= $rs_cr['website'] ?>">
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
                                        <textarea class="form-control fkanit" id="carrent_detail" name="carrent_detail" rows="5" required><?= $rs_cr['carrent_detail'] ?></textarea>
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
                                        <input type="text" class="form-control fkanit" id="username" name="username" value="<?= $rs_cr['username'] ?>" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="password" class="form-label text-white fkanit">รหัสผ่าน *</label>
                                        <input type="password" class="form-control fkanit" id="password" name="password" value="<?= base64_decode($rs_cr['password_hash']) ?>" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="password_confirm" class="form-label text-white fkanit">ยืนยันรหัสผ่าน *</label>
                                        <input type="password" class="form-control fkanit" id="password_confirm" name="password_confirm" value="<?= base64_decode($rs_cr['password_hash']) ?>" required>
                                    </div>

                                    <div class="col-md-12 text-center">
                                        <div class="cf-turnstile d-inline-block mb-3" data-sitekey="<?= htmlspecialchars($turnstile_site_key, ENT_QUOTES, 'UTF-8') ?>"></div>
                                    </div>

                                    <!-- ปุ่มกด -->
                                    <div class="col-lg-8 col-md-12 mt-4 mx-auto text-center">
                                        <button id="sbm_form" type="submit" name="submit" class="btn btn-lg btn-success fkanit m-3">
                                            <i class="bi bi-check-circle"></i> บันทึก
                                        </button>
                                        <button type="reset" class="btn btn-lg btn-outline-light fkanit m-3">
                                            <i class="bi bi-arrow-clockwise"></i> คืนค่าเดิม
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

        // โหลดจังหวัดก่อน
        $('#province_id').val('<?= $rs_cr['province_id'] ?>').trigger('change');

        // ดีเลย์ 300ms รอจังหวัดโหลดอำเภอ
        setTimeout(function() {

            $('#district_id').val('<?= $rs_cr['district_id'] ?>').trigger('change');

            // ดีเลย์อีก 300ms รออำเภอโหลดตำบล
            setTimeout(function() {

                $('#subdistrict_id').val('<?= $rs_cr['subdistrict_id'] ?>').trigger('change');

            }, 300);

        }, 300);

        /* Delete Confirm Delimages */
        function cdelimg(val1, link1) {
            Swal.fire({
                title: "คุณต้องการลบรูปภาพใช่หรือไม่?",
                text: "ยืนยันลบรูปภาพ " + val1,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "ยืนยันลบ",
                cancelButtonText: "ยกเลิก",
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: "success",
                        title: "ลบข้อมูลสำเร็จ",
                        showConfirmButton: false,
                        timer: 1000,
                    });
                    location.href = link1;
                }
            });
        }

        /* Logout Confirm Sweetalert */
        function logouts(link1) {
            Swal.fire({
                title: "ยืนยันออกจากระบบใช่หรือไม่?",
                text: "ออกจากระบบ ART SKY",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "ยืนยัน",
                cancelButtonText: "ยกเลิก",
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: "success",
                        title: "ออกจากระบบสำเร็จ",
                        showConfirmButton: false,
                        timer: 1000,
                    });
                    location.href = link1;
                }
            });
        }
    </script>
</body>

</html>
