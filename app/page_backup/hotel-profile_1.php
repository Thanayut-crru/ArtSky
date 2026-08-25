<?php
require 'config/connect.php';
require 'config/function.php';
if (isset($_SESSION['sess_ht_artsky']) && isset($_SESSION['sess_login_artsky_ht'])) {
    $hotelId = base64_decode($_SESSION['sess_ht_artsky']);
    $sql_ht = " SELECT * FROM tbl_hotel WHERE hotel_id = '$hotelId' ";
    $result_ht = mysqli_query($conn, $sql_ht);
    $no_ht = mysqli_num_rows($result_ht);
    $rs_ht = mysqli_fetch_assoc($result_ht);
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

    <link rel="stylesheet" type="text/css" href="./app/plugins/fontawesome-free/css/all.min.css" />

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
                        <p>ข้อมูลผู้ประกอบการที่พัก</p>
                    </div>
                </div>
            </div>
        </div><!-- End Page Header -->

        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container">
                <div class="row justify-content-center mt-4">
                    <div class="col-lg-9">
                        <?php
                        // Delete Image
                        if (isset($_GET['del_pic'])) {
                            if (!empty($_GET['del_pic'])) {
                                $pic_del = $_GET['del_pic'];
                                $sql_del_img = " SELECT * FROM tbl_hotel_image WHERE hotel_image_id = '$pic_del' AND hotel_id = '{$rs_ht['hotel_id']}' ";
                                $result_del_img = mysqli_query($conn, $sql_del_img);
                                $num_del_img = mysqli_num_rows($result_del_img);
                                if ($num_del_img > 0) {
                                    $rs_del_img = mysqli_fetch_assoc($result_del_img);
                                    $fileupload = $rs_del_img['hotel_image_name'];
                                    if ($fileupload != "") {
                                        unlink("./images/hotel_image/$fileupload");
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
                            $turnstile_secret     = '0x4AAAAAAAaNNk4fPx-rDaDkTp7PoIifjIA';
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

                            $sql_check_hotel_name = " SELECT hotel_name FROM tbl_hotel WHERE hotel_name = '$hotel_name' AND hotel_id <> '{$rs_ht['hotel_id']}' ";
                            $result_check_hotel_name = mysqli_query($conn, $sql_check_hotel_name);
                            $num_check_hotel_name = mysqli_num_rows($result_check_hotel_name);
                            if ($num_check_hotel_name > 0) {
                                echo "<script>
                                            $(function() {
                                                warnDuplicate('ชื่อโรงแรมถูกใช้แล้ว');
                                            })
                                            </script>";
                            }

                            $sql_check_hotel_user = " SELECT hotel_user FROM tbl_hotel WHERE hotel_user = '$hotel_user' AND hotel_id <> '{$rs_ht['hotel_id']}' ";
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
                                $last_id = $rs_ht['hotel_id'];

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
                                                title: 'บันทึกสำเร็จ',
                                                showConfirmButton: false,
                                                timer: 3000,
                                            }).then(()=>{location.href='hotel-profile';});
                                          </script>";
                                    /* Success End */
                                }
                            }
                        }
                        ?>
                        <div class="col-12 mb-3 text-center">
                            <a href="change" class="btn btn-warning me-2"><i class="fas fa-key"></i> เปลี่ยนรหัสผ่าน</a><a href="logout" class="btn btn-dark"><i class="fas fa-sign-out-alt"></i> ออกจากระบบ</a>
                        </div>
                        <form action="" method="post" enctype="multipart/form-data" class="php-email-form">
                            <div class="row">
                                <div class="col-md-12 form-group mb-3">
                                    <input type="text" class="form-control" name="hotel_name" id="hotel_name" value="<?= $rs_ht['hotel_name'] ?>" placeholder="ชื่อโรงแรม" required>
                                </div>
                                <div class="col-md-4 form-group mb-3 mt-md-0">
                                    <input type="text" class="form-control" name="hotel_lat" id="hotel_lat" value="<?= $rs_ht['hotel_lat'] ?>" placeholder="พิกัดละติจูด" required>
                                </div>
                                <div class="col-md-4 form-group mb-3 mt-md-0">
                                    <input type="text" class="form-control" name="hotel_lon" id="hotel_lon" value="<?= $rs_ht['hotel_lon'] ?>" placeholder="พิกัดลลองจิจู" required>
                                </div>
                                <div class="col-md-4 form-group mb-3 mt-md-0 align-content-center">
                                    <button type="button" class="btn btn-success" id="location_now"><i class="bi bi-geo-alt"></i> ใช้ตำแหน่งปัจจุบัน</button>
                                </div>

                                <?php
                                $no = 1;
                                $sql_img = " SELECT * FROM tbl_hotel_image WHERE hotel_id = '{$rs_ht['hotel_id']}' ORDER BY hotel_image_id ASC ";
                                $result_img = mysqli_query($conn, $sql_img);
                                $num_img = mysqli_num_rows($result_img);
                                if ($num_img > 0) {
                                    while ($rs_img = mysqli_fetch_assoc($result_img)) {
                                        if ($no == 1) {
                                ?>
                                            <?php if ($rs_img['hotel_image_name'] != "") { ?>
                                                <div class="card col-3 border-0" style="background-color:transparent;">
                                                    <img src="./images/hotel_image/<?= $rs_img['hotel_image_name'] ?>" class="img-fluid glightbox rounded-3" style="object-fit: cover; aspect-ratio: 16 / 9;">
                                                    <div class="card-footer text-end"><button type="button" class="btn btn-danger" onclick="cdelimg('รูปนี้','hotel-profile?del_pic=<?= $rs_img['hotel_image_id'] ?>')">x</button></div>
                                                </div>
                                            <?php } else { ?>
                                                <div class="col-md-12 form-group mb-3 mt-md-0">
                                                    <label for="">รูปภาพโรงแรม</label>
                                                    <input type="file" class="form-control pt-2 mb-3" name="hotel_image[]" required accept="image/gif, image/jpeg, image/png, imge/jpg">
                                                </div>
                                            <?php } ?>
                                        <?php
                                        } else {
                                        ?>
                                            <?php if ($rs_img['hotel_image_name'] != "") { ?>
                                                <div class="card col-3 border-0" style="background-color:transparent;">
                                                    <img src="./images/hotel_image/<?= $rs_img['hotel_image_name'] ?>" class="img-fluid glightbox rounded-3" style="object-fit: cover; aspect-ratio: 16 / 9;">
                                                    <div class="card-footer text-end"><button type="button" class="btn btn-danger" onclick="cdelimg('รูปนี้','hotel-profile?del_pic=<?= $rs_img['hotel_image_id'] ?>')">x</button></div>
                                                </div>
                                            <?php } else { ?>
                                                <div class="col-md-12 form-group mb-3 mt-md-0">
                                                    <input type="file" class="form-control pt-2" name="hotel_image[]" required accept="image/gif, image/jpeg, image/png, imge/jpg">
                                                </div>
                                            <?php } ?>
                                <?php
                                        }
                                        $no++;
                                    }
                                } ?>
                                <?php
                                for ($i = 1; $i <= (7 - $num_img); $i++) {
                                ?>
                                    <div class="col-md-12 form-group mb-3 mt-md-0">
                                        <input type="file" class="form-control pt-2" name="hotel_image[]" accept="image/gif, image/jpeg, image/png, imge/jpg">
                                    </div>
                                <?php
                                }
                                ?>
                                <div class="col-md-6 form-group mb-3 mt-md-0">
                                    <input type="number" step="0.01" class="form-control" name="hotel_price" id="hotel_price" value="<?= $rs_ht['hotel_price'] ?>" placeholder="ราคา/คืน" required>
                                </div>
                                <div class="col-md-6 form-group mb-3 mt-md-0">
                                    <input type="text" class="form-control" name="hotel_telephone" id="hotel_telephone" value="<?= $rs_ht['hotel_telephone'] ?>" placeholder="เบอร์โทรศัพท์" required>
                                </div>
                                <div class="col-md-6 form-group mb-3 mt-md-0">
                                    <input type="text" class="form-control" name="hotel_line" id="hotel_line" value="<?= $rs_ht['hotel_line'] ?>" placeholder="ไลน์" required>
                                </div>
                                <div class="col-md-6 form-group mb-3 mt-md-0">
                                    <input type="email" class="form-control" name="hotel_email" id="hotel_email" value="<?= $rs_ht['hotel_email'] ?>" placeholder="อีเมล">
                                </div>
                                <div class="col-md-6 form-group mb-3 mt-md-0">
                                    <input type="text" class="form-control" name="hotel_facebook" id="hotel_facebook" value="<?= $rs_ht['hotel_facebook'] ?>" placeholder="Facebook">
                                </div>
                                <div class="col-md-6 form-group mb-3 mt-md-0">
                                    <input type="text" class="form-control" name="hotel_website" id="hotel_website" value="<?= $rs_ht['hotel_website'] ?>" placeholder="เว็บไซต์">
                                </div>
                                <hr>
                                <div class="col-md-6 form-group mb-3 mt-md-0">
                                    <input type="text" class="form-control" name="hotel_user" id="hotel_user" value="<?= $rs_ht['hotel_user'] ?>" placeholder="ชื่อผู้ใช้">
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="cf-turnstile" data-sitekey="0x4AAAAAAAaNNm2nFLfZKpYn"></div>
                            </div>
                            <div class="text-center"><button type="submit" name="submit" id="sbm_form"><i class="bi bi-pencil-square"></i> บันทึก</button></div>
                        </form>
                    </div><!-- End Contact Form -->

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
    </script>

</body>

</html>