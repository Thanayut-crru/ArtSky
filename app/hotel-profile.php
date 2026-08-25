<?php
require 'config/connect.php';
require 'config/function.php';

if (isset($_SESSION['sess_ht_artsky']) && isset($_SESSION['sess_login_artsky_ht'])) {
    $hotelId   = base64_decode($_SESSION['sess_ht_artsky']);
    $sql_ht    = " SELECT * FROM tbl_hotel WHERE hotel_id = '$hotelId' ";
    $result_ht = mysqli_query($conn, $sql_ht);
    $no_ht     = mysqli_num_rows($result_ht);
    $rs_ht     = mysqli_fetch_assoc($result_ht);
    if ($no_ht === 0) {
        header("location:login");
        exit;
    }
} else {
    header("location:login");
    exit;
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>ART SKY | โปรไฟล์ที่พัก</title>
    <meta content="จัดการข้อมูลผู้ประกอบการที่พักสำหรับ ART SKY" name="description">
    <meta content="ART SKY, Hotel, Profile" name="keywords">

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

    <link rel="stylesheet" type="text/css" href="./app/plugins/fontawesome-free/css/all.min.css" />

    <!-- Sweetalert + jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
        integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="./app/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>

    <style>
        /* --------------------------
           Global & Background
        --------------------------- */
        body {
            min-height: 100vh;
            background: url("./images/head_bg.jpg") no-repeat center center fixed;
            background-size: cover;
            position: relative;
            color: #e5e7eb;
            /* font-family: "Noto Serif Thai", serif; */
        }

        /* Dark overlay */
        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background: radial-gradient(circle at top left, rgba(59, 130, 246, 0.5), transparent 40%),
                radial-gradient(circle at bottom right, rgba(16, 185, 129, 0.45), transparent 40%),
                rgba(15, 23, 42, 0.85);
            z-index: -1;
        }

        #header {
            background: transparent;
        }

        .page-header {
            border-bottom: 0;
            padding: 6rem 0 2rem 0;
        }

        .page-header-overlay {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.95), rgba(30, 64, 175, 0.85));
            border-radius: 1.5rem;
            padding: 2.5rem 2rem;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.65);
        }

        .page-header h2 {
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .page-header p {
            margin-top: 0.5rem;
            opacity: 0.8;
        }

        /* --------------------------
           Card / Panel
        --------------------------- */
        .profile-shell {
            max-width: 1080px;
        }

        .profile-card {
            background: linear-gradient(135deg,
                    rgba(15, 23, 42, 0.95),
                    rgba(15, 23, 42, 0.92));
            border-radius: 1.5rem;
            padding: 2.5rem 2rem 2.25rem;
            box-shadow:
                0 20px 45px rgba(15, 23, 42, 0.7),
                0 0 0 1px rgba(148, 163, 184, 0.08);
            backdrop-filter: blur(16px);
        }

        .profile-card-header {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .profile-title {
            font-size: 1.35rem;
            font-weight: 600;
        }

        .profile-subtitle {
            font-size: 0.9rem;
            color: #9ca3af;
        }

        .action-buttons .btn {
            border-radius: 999px;
            font-size: 0.9rem;
        }

        /* --------------------------
           Form
        --------------------------- */
        .form-label {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #9ca3af;
            margin-bottom: 0.2rem;
        }

        .form-control {
            border-radius: 0.75rem;
            border: 1px solid rgba(148, 163, 184, 0.4);
            background-color: rgba(15, 23, 42, 0.8);
            color: #e5e7eb;
            font-size: 0.95rem;
        }

        .form-control:focus {
            border-color: #38bdf8;
            box-shadow: 0 0 0 1px rgba(56, 189, 248, 0.4);
            background-color: rgba(15, 23, 42, 0.95);
            color: #f9fafb;
        }

        .form-control::placeholder {
            color: rgba(148, 163, 184, 0.7);
        }

        .input-hint {
            font-size: 0.8rem;
            color: #9ca3af;
        }

        .section-title {
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.13em;
            color: #9ca3af;
            margin-bottom: 0.75rem;
        }

        .divider-soft {
            border: none;
            border-top: 1px dashed rgba(148, 163, 184, 0.3);
            margin: 1.5rem 0 1.25rem;
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

        /* --------------------------
           Buttons
        --------------------------- */
        .btn-main {
            border-radius: 999px;
            padding: 0.55rem 1.5rem;
            font-weight: 500;
            font-size: 0.95rem;
            background: linear-gradient(135deg, #22c55e, #22d3ee);
            border: none;
            color: #0f172a;
        }

        .btn-main:hover {
            filter: brightness(1.05);
            color: #020617;
        }

        .btn-geo {
            border-radius: 999px;
            font-size: 0.85rem;
            padding: 0.5rem 1rem;
            border-color: rgba(52, 211, 153, 0.8);
            color: #a7f3d0;
        }

        .btn-geo:hover {
            background: rgba(52, 211, 153, 0.15);
            color: #a7f3d0;
        }

        .text-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.2rem 0.75rem;
            border-radius: 999px;
            font-size: 0.75rem;
            background: rgba(15, 23, 42, 0.9);
            border: 1px solid rgba(148, 163, 184, 0.4);
            color: #9ca3af;
        }

        .turnstile-wrapper {
            margin: 1.25rem 0 0.75rem;
            display: flex;
            justify-content: center;
        }

        .submit-wrapper {
            margin-top: 0.5rem;
            text-align: center;
        }

        .submit-wrapper button {
            min-width: 180px;
        }

        @media (max-width: 767.98px) {
            .page-header-overlay {
                padding: 1.75rem 1.25rem;
            }

            .profile-card {
                padding: 1.75rem 1.25rem;
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
                        <div class="page-header-overlay text-center text-white">
                            <div class="text-badge mb-2 mx-auto">
                                <i class="bi bi-building"></i>
                                ART SKY • HOTEL PARTNER
                            </div>
                            <h2 class="mb-1">จัดการข้อมูลที่พัก</h2>
                            <p class="mb-0">
                                อัปเดตข้อมูลโปรไฟล์ รูปภาพ และช่องทางการติดต่อของที่พักคุณให้ทันสมัยอยู่เสมอ
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- End Page Header -->

        <!-- ======= Contact / Profile Section ======= -->
        <section id="contact" class="contact py-4 py-md-5">
            <div class="container d-flex justify-content-center">
                <div class="profile-shell w-100">

                    <?php
                    // Delete Image
                    if (isset($_GET['del_pic'])) {
                        if (!empty($_GET['del_pic'])) {
                            $pic_del       = $_GET['del_pic'];
                            $sql_del_img   = " SELECT * FROM tbl_hotel_image WHERE hotel_image_id = '$pic_del' AND hotel_id = '{$rs_ht['hotel_id']}' ";
                            $result_del_img = mysqli_query($conn, $sql_del_img);
                            $num_del_img   = mysqli_num_rows($result_del_img);
                            if ($num_del_img > 0) {
                                $rs_del_img  = mysqli_fetch_assoc($result_del_img);
                                $fileupload  = $rs_del_img['hotel_image_name'];
                                if ($fileupload != "") {
                                    @unlink("./images/hotel_image/$fileupload");
                                }
                                $sql_update_img = " DELETE FROM tbl_hotel_image WHERE hotel_image_id = '$pic_del' ";
                                mysqli_query($conn, $sql_update_img);
                            }
                            header("refresh: 0; hotel-profile");
                        }
                    }
                    ?>

                    <?php
                    if (isset($_POST['submit'])) {
                        $turnstile_secret   = $turnstile_secret_key;
                        $turnstile_response = $_POST['cf-turnstile-response'];
                        $url                = "https://challenges.cloudflare.com/turnstile/v0/siteverify";
                        $post_fields        = "secret=$turnstile_secret&response=$turnstile_response";

                        $hotel_name      = mysqli_real_escape_string($conn, $_POST['hotel_name']);
                        $hotel_lat       = mysqli_real_escape_string($conn, $_POST['hotel_lat']);
                        $hotel_lon       = mysqli_real_escape_string($conn, $_POST['hotel_lon']);
                        $hotel_price     = mysqli_real_escape_string($conn, $_POST['hotel_price']);
                        $hotel_telephone = mysqli_real_escape_string($conn, $_POST['hotel_telephone']);
                        $hotel_line      = mysqli_real_escape_string($conn, $_POST['hotel_line']);
                        $hotel_email     = mysqli_real_escape_string($conn, $_POST['hotel_email']);
                        $hotel_facebook  = mysqli_real_escape_string($conn, $_POST['hotel_facebook']);
                        $hotel_website   = mysqli_real_escape_string($conn, $_POST['hotel_website']);
                        $hotel_user      = mysqli_real_escape_string($conn, $_POST['hotel_user']);

                        $sql_check_hotel_name   = " SELECT hotel_name FROM tbl_hotel WHERE hotel_name = '$hotel_name' AND hotel_id <> '{$rs_ht['hotel_id']}' ";
                        $result_check_hotel_name = mysqli_query($conn, $sql_check_hotel_name);
                        $num_check_hotel_name   = mysqli_num_rows($result_check_hotel_name);
                        if ($num_check_hotel_name > 0) {
                            echo "<script>
                                $(function() {
                                    warnDuplicate('ชื่อโรงแรมถูกใช้แล้ว');
                                })
                            </script>";
                        }

                        $sql_check_hotel_user   = " SELECT hotel_user FROM tbl_hotel WHERE hotel_user = '$hotel_user' AND hotel_id <> '{$rs_ht['hotel_id']}' ";
                        $result_check_hotel_user = mysqli_query($conn, $sql_check_hotel_user);
                        $num_check_hotel_user   = mysqli_num_rows($result_check_hotel_user);
                        if ($num_check_hotel_user > 0) {
                            echo "<script>
                                $(function() {
                                    warnDuplicate('ชื่อผู้ใช้ถูกใช้แล้ว');
                                })
                            </script>";
                        }

                        if ($num_check_hotel_name === 0 && $num_check_hotel_user === 0) {
                            $sql_cnm = " UPDATE tbl_hotel SET  
                                            hotel_name      = '$hotel_name',
                                            hotel_lat       = '$hotel_lat',
                                            hotel_lon       = '$hotel_lon',
                                            hotel_price     = '$hotel_price',
                                            hotel_telephone = '$hotel_telephone',
                                            hotel_line      = '$hotel_line',
                                            hotel_email     = '$hotel_email',
                                            hotel_facebook  = '$hotel_facebook',
                                            hotel_website   = '$hotel_website',
                                            hotel_user      = '$hotel_user'
                                        WHERE hotel_id = '{$rs_ht['hotel_id']}' ";
                            $result_cnm = mysqli_query($conn, $sql_cnm);
                            $last_id    = $rs_ht['hotel_id'];

                            if (!empty($_FILES['hotel_image']['name'][0])) {
                                for ($i = 0; $i < count($_FILES['hotel_image']['name']); ++$i) {
                                    if (empty($_FILES['hotel_image']['error'][$i])) {
                                        $hotel_image = $_FILES['hotel_image']['name'][$i];
                                        $tmp         = explode('.', $hotel_image);
                                        $ext         = strtolower(end($tmp));
                                        $htl_image   = "hotel_image_" . date('dmYHis') . '_' . rand(00000000, 99999999) . '.' . $ext;

                                        $imageUploadPath = "./images/hotel_image/" . $htl_image;
                                        $fileType        = pathinfo($imageUploadPath, PATHINFO_EXTENSION);

                                        $allowTypes = array('jpg', 'jpeg', 'png', 'gif');
                                        if (in_array($fileType, $allowTypes)) {
                                            $imageTemp = $_FILES["hotel_image"]["tmp_name"][$i];

                                            // compressImage & convert_filesize มาจาก function.php (คง logic เดิม)
                                            $imageSize = convert_filesize($_FILES["hotel_image"]["size"][$i]);
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
                                                    warnDuplicate('ขออภัย อนุญาตให้อัปโหลดเฉพาะไฟล์ JPG, JPEG, PNG และ GIF');
                                                })
                                            </script>";
                                        }
                                    }
                                }
                            }

                            if ($result_cnm) {
                                echo "<script>
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'บันทึกสำเร็จ',
                                        showConfirmButton: false,
                                        timer: 3000,
                                    }).then(()=>{location.href='hotel-profile';});
                                </script>";
                            }
                        }
                    }
                    ?>

                    <div class="profile-card mt-3 mt-md-0">
                        <div class="profile-card-header">
                            <div>
                                <div class="profile-title text-white">
                                    <?= htmlspecialchars($rs_ht['hotel_name']) ?>
                                </div>
                                <div class="profile-subtitle">
                                    จัดการข้อมูลผู้ประกอบการที่พัก • เข้าสู่ระบบในชื่อ
                                    <span class="text-info">@<?= htmlspecialchars($rs_ht['hotel_user']) ?></span>
                                </div>
                            </div>
                            <div class="action-buttons">
                                <a href="change" class="btn btn-outline-warning me-2">
                                    <i class="fas fa-key me-1"></i> เปลี่ยนรหัสผ่าน
                                </a>
                                <button type="button" onclick="logouts('logout')" class="btn btn-outline-light">
                                    <i class="fas fa-sign-out-alt me-1"></i> ออกจากระบบ
                                </button>
                            </div>
                        </div>

                        <form action="" method="post" enctype="multipart/form-data" class="php-email-form">
                            <!-- ข้อมูลที่พักพื้นฐาน -->
                            <div class="section-title">
                                ข้อมูลที่พัก
                            </div>
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label for="hotel_name" class="form-label">ชื่อโรงแรม / ที่พัก</label>
                                    <input type="text" class="form-control" name="hotel_name" id="hotel_name"
                                        value="<?= htmlspecialchars($rs_ht['hotel_name']) ?>" placeholder="เช่น ART SKY Hotel"
                                        required>
                                </div>
                            </div>

                            <hr class="divider-soft">

                            <!-- พิกัดที่ตั้ง -->
                            <div class="section-title d-flex align-items-center justify-content-between">
                                <span>พิกัดที่ตั้ง</span>
                            </div>
                            <div class="row g-3 align-items-end">
                                <div class="col-md-4">
                                    <label for="hotel_lat" class="form-label">ละติจูด (Latitude)</label>
                                    <input type="text" class="form-control" name="hotel_lat" id="hotel_lat"
                                        value="<?= htmlspecialchars($rs_ht['hotel_lat']) ?>"
                                        placeholder="เช่น 18.787747" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="hotel_lon" class="form-label">ลองจิจูด (Longitude)</label>
                                    <input type="text" class="form-control" name="hotel_lon" id="hotel_lon"
                                        value="<?= htmlspecialchars($rs_ht['hotel_lon']) ?>"
                                        placeholder="เช่น 98.993128" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label d-none d-md-block">&nbsp;</label>
                                    <button type="button" class="btn btn-outline-success btn-geo w-100"
                                        id="location_now">
                                        <i class="bi bi-geo-alt me-1"></i> ใช้ตำแหน่งปัจจุบัน
                                    </button>
                                    <div class="input-hint mt-1">
                                        ใช้ GPS ของอุปกรณ์เพื่อดึงค่าพิกัดอัตโนมัติ
                                    </div>
                                </div>
                            </div>

                            <hr class="divider-soft">

                            <!-- รูปภาพโรงแรม -->
                            <div class="section-title">
                                รูปภาพโรงแรม
                            </div>
                            <div class="hotel-image-grid mb-3">
                                <?php
                                $no       = 1;
                                $sql_img  = " SELECT * FROM tbl_hotel_image WHERE hotel_id = '{$rs_ht['hotel_id']}' ORDER BY hotel_image_id ASC ";
                                $result_img = mysqli_query($conn, $sql_img);
                                $num_img  = mysqli_num_rows($result_img);

                                if ($num_img > 0) {
                                    while ($rs_img = mysqli_fetch_assoc($result_img)) {
                                        if ($rs_img['hotel_image_name'] != "") {
                                ?>
                                            <div class="hotel-image-card">
                                                <a href="./images/hotel_image/<?= $rs_img['hotel_image_name'] ?>" class="glightbox">
                                                    <img src="./images/hotel_image/<?= $rs_img['hotel_image_name'] ?>" alt="Hotel image">
                                                </a>
                                                <div class="hotel-image-card-footer">
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                        onclick="cdelimg('รูปนี้','hotel-profile?del_pic=<?= $rs_img['hotel_image_id'] ?>')">
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
                                <div class="mb-2">
                                    <?php if ($i === 1 && $num_img === 0) { ?>
                                        <label class="form-label">อัปโหลดรูปภาพโรงแรม (อย่างน้อย 1 รูป)</label>
                                    <?php } ?>
                                    <div class="upload-input-wrapper">
                                        <input type="file" class="form-control pt-2 bg-transparent border-0"
                                            name="hotel_image[]" <?= ($i === 1 && $num_img === 0) ? 'required' : '' ?>
                                            accept="image/gif, image/jpeg, image/png, image/jpg">
                                        <div class="input-hint mt-1">
                                            รองรับไฟล์ JPG, JPEG, PNG, GIF แนะนำอัตราส่วน 16:9
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>

                            <hr class="divider-soft">

                            <!-- ราคาห้อง & ช่องทางติดต่อ -->
                            <div class="section-title">
                                ราคาและช่องทางการติดต่อ
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="hotel_price" class="form-label">ราคาเริ่มต้น / คืน (บาท)</label>
                                    <input type="number" step="0.01" class="form-control" name="hotel_price"
                                        id="hotel_price" value="<?= htmlspecialchars($rs_ht['hotel_price']) ?>"
                                        placeholder="เช่น 1200.00" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="hotel_telephone" class="form-label">เบอร์โทรศัพท์หลัก</label>
                                    <input type="text" class="form-control" name="hotel_telephone" id="hotel_telephone"
                                        value="<?= htmlspecialchars($rs_ht['hotel_telephone']) ?>"
                                        placeholder="เช่น 081-234-5678" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="hotel_line" class="form-label">LINE ID / LINE Official</label>
                                    <input type="text" class="form-control" name="hotel_line" id="hotel_line"
                                        value="<?= htmlspecialchars($rs_ht['hotel_line']) ?>" placeholder="@yourlineid" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="hotel_email" class="form-label">อีเมลสำหรับติดต่อ</label>
                                    <input type="email" class="form-control" name="hotel_email" id="hotel_email"
                                        value="<?= htmlspecialchars($rs_ht['hotel_email']) ?>" placeholder="you@example.com">
                                </div>

                                <div class="col-md-6">
                                    <label for="hotel_facebook" class="form-label">ลิงก์ Facebook Page</label>
                                    <input type="text" class="form-control" name="hotel_facebook" id="hotel_facebook"
                                        value="<?= htmlspecialchars($rs_ht['hotel_facebook']) ?>"
                                        placeholder="https://facebook.com/yourpage">
                                </div>
                                <div class="col-md-6">
                                    <label for="hotel_website" class="form-label">เว็บไซต์ (ถ้ามี)</label>
                                    <input type="text" class="form-control" name="hotel_website" id="hotel_website"
                                        value="<?= htmlspecialchars($rs_ht['hotel_website']) ?>"
                                        placeholder="https://www.yourhotel.com">
                                </div>
                            </div>

                            <hr class="divider-soft">

                            <!-- บัญชีผู้ใช้ -->
                            <div class="section-title">
                                บัญชีผู้ใช้สำหรับเข้าสู่ระบบ
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="hotel_user" class="form-label">ชื่อผู้ใช้ (Username)</label>
                                    <input type="text" class="form-control" name="hotel_user" id="hotel_user"
                                        value="<?= htmlspecialchars($rs_ht['hotel_user']) ?>" placeholder="เช่น artsky_hotel">
                                    <div class="input-hint mt-1">
                                        ใช้สำหรับเข้าสู่ระบบ ART SKY ของผู้ประกอบการที่พัก
                                    </div>
                                </div>
                            </div>

                            <!-- Turnstile -->
                            <div class="turnstile-wrapper">
                                <div class="cf-turnstile" data-sitekey="<?= htmlspecialchars($turnstile_site_key, ENT_QUOTES, 'UTF-8') ?>"></div>
                            </div>

                            <!-- Submit -->
                            <div class="submit-wrapper">
                                <button type="submit" name="submit" id="sbm_form" class="btn btn-main">
                                    <i class="bi bi-pencil-square me-1"></i> บันทึกการเปลี่ยนแปลง
                                </button>
                            </div>
                        </form>
                    </div><!-- /.profile-card -->

                </div>
            </div>
        </section>
        <!-- End Contact Section -->

    </main>
    <!-- End #main -->

    <!-- ======= Footer ======= -->
    <br><br><br><br>
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

    <script type="text/javascript" src="./assets/vendor/slick/slick.min.js"></script>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Cloudflare Turnstile -->
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js?onload=_turnstileCb" defer></script>

    <script>
        $('#location_now').click(() => {
            if (navigator.geolocation) {
                Swal.showLoading();
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                Swal.fire({
                    icon: "warning",
                    title: "เบราว์เซอร์นี้ไม่รองรับตำแหน่งทางภูมิศาสตร์",
                    showConfirmButton: false,
                    timer: 5000,
                });
            }
        });

        function showPosition(position) {
            $('#hotel_lat').val(position.coords.latitude);
            $('#hotel_lon').val(position.coords.longitude);
            Swal.close();
        }

        function showError() {
            Swal.fire({
                icon: "error",
                title: "ไม่สามารถดึงตำแหน่งได้",
                showConfirmButton: false,
                timer: 4000,
            });
        }

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

        function warnDuplicate(warnings) {
            Swal.fire({
                icon: "error",
                title: "ไม่สามารถบันทึกข้อมูลได้",
                text: warnings,
                confirmButtonText: "ตกลง",
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
