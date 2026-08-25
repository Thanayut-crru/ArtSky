<?php
if (isset($_POST['submit'])) {

    $edit_id         = mysqli_real_escape_string($conn, $_POST['edit_id']);
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
    $password_confirm  = mysqli_real_escape_string($conn, base64_encode($_POST['password_confirm']));

    $sql_check_username = " SELECT tbl_car_rental.username AS 'username' FROM tbl_car_rental WHERE tbl_car_rental.username = '$username' AND car_rental_id <> '$edit_id'
                            UNION
                            SELECT tbl_hotel.hotel_user FROM tbl_hotel WHERE tbl_hotel.hotel_user = '$username' ";
    $result_check_username = mysqli_query($conn, $sql_check_username);
    $num_check_username    = mysqli_num_rows($result_check_username);
    if ($num_check_username > 0) {
        echo "<script>
        $(function() {
            warnDuplicate('ชื่อผู้ใช้นี้ถูกใช้แล้ว');
        })
        </script>";
    }

    if ($password_confirm !== $password_hash) {
        echo "<script>
        $(function() {
            warnDuplicate('รหัสผ่านและการยืนยันรหัสผ่านไม่ตรงกัน');
        })
        </script>";
    }

    if ($num_check_username == 0 && $password_confirm === $password_hash) {

        $sql_rental = " UPDATE tbl_car_rental SET                                                
                                                car_rental_name   = '$car_rental_name',
                                                phone             = '$phone',
                                                line_id           = '$line_id',
                                                email             = '$email',
                                                facebook          = '$facebook',
                                                website           = '$website',
                                                username          = '$username',
                                                password_hash     = '$password_hash',
                                                carrent_detail    = '$carrent_detail',
                                                province_id       = '$province_id',
                                                district_id       = '$district_id',
                                                subdistrict_id    = '$subdistrict_id'
                                                WHERE car_rental_id = '$edit_id' ";
        $result_rental = mysqli_query($conn, $sql_rental);
        $last_id = $edit_id;

        if ($_FILES['car_rental_image_name']['name'][0] != '') {

            // File info 
            for ($i = 0; $i < count($_FILES['car_rental_image_name']['name']); ++$i) {
                $car_rental_image_name = $_FILES['car_rental_image_name']['name'][$i];
                $tmp                   = explode('.', $car_rental_image_name);
                $ext                   = strtolower(end($tmp));
                $crt_image             = "car_rental_image_name_" . date('dmYHis') . '_' . rand(00000000, 99999999) . '.' . $ext;

                $imageUploadPath = "../images/car_rental/" . $crt_image;
                $fileType        = pathinfo($imageUploadPath, PATHINFO_EXTENSION);

                // Allow certain file formats 
                $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
                if (in_array($fileType, $allowTypes)) {
                    // Image temp source and size 
                    $imageTemp = $_FILES["car_rental_image_name"]["tmp_name"][$i];
                    $imageSize = convert_filesize($_FILES["car_rental_image_name"]["size"][$i]);

                    // Compress size and upload image 
                    $compressedImage = compressImage($imageTemp, $imageUploadPath, 75);

                    if ($compressedImage) {
                        $compressedImageSize = filesize($compressedImage);
                        $compressedImageSize = convert_filesize($compressedImageSize);

                        $sql_im = " INSERT INTO tbl_car_rental_image SET 
                                                    car_rental_image_id   = NULL,
                                                    car_rental_id         = '$last_id',
                                                    car_rental_image_name = '$crt_image' ";
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

        if ($result_rental) {
            echo "<script>
                    $(function() {
                        dataAddsuccess('index.php?act=carrent&pg=carrent_list');
                    })
            </script>";
        } else {
            $msg = "<div class=\"alert alert-danger\">ไม่สามารถเพิ่มข้อมูลได้</div>";
            echo "<script>
                    $(function() {
                        dataAddunsuccess();
                    })
            </script>";
        }
    }
}
?>
<!-- Custom UI สำหรับฟอร์มเพิ่มรถเช่า -->
<?php
// Delete Image
if (isset($_GET['del_pic'])) {
    if (!empty($_GET['del_pic'])) {
        $edit_id = $_GET['edit_id'];
        $pic_del = $_GET['del_pic'];
        $sql_del_img = " SELECT * FROM tbl_car_rental_image WHERE car_rental_image_id = '$pic_del' ";
        $result_del_img = mysqli_query($conn, $sql_del_img);
        $num_del_img = mysqli_num_rows($result_del_img);
        if ($num_del_img > 0) {
            $rs_del_img = mysqli_fetch_assoc($result_del_img);
            $fileupload = $rs_del_img['car_rental_image_name'];
            if ($fileupload != "") {
                unlink("../images/car_rental/$fileupload");
            }
            $sql_update_img = " DELETE FROM tbl_car_rental_image WHERE car_rental_image_id = '$pic_del' ";
            mysqli_query($conn, $sql_update_img);
        }
        echo '<script type="text/javascript">',
        'del_imgsuccess();',
        '</script>';
        header("refresh: 0; index.php?act=carrent&pg=carrent_edit&edit_id=$edit_id");
    }
}


if (isset($_GET['edit_id'])) {
    $edit_id     = mysqli_real_escape_string($conn, $_GET['edit_id']);
    $sql_edit    = " SELECT * FROM tbl_car_rental WHERE car_rental_id = '$edit_id' ";
    $result_edit = mysqli_query($conn, $sql_edit);
    $rs_edit     = mysqli_fetch_assoc($result_edit);
    $num_edit    = mysqli_num_rows($result_edit);
    if ($num_edit === 0) {
        header('Location:index.php?act=carrent&pg=carrent_list');
    }
} else {
    header('Location:index.php?act=carrent&pg=carrent_list');
}
?>
<div class="col-md-12">
    <div class="card card-outline card-warning rounded rounded-3">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h3 class="card-title mb-0 text-warning">
                <i class="fas fa-edit me-1"></i>
                แก้ไขรถเช่า
            </h3>
        </div>

        <form method="POST" action="" enctype="multipart/form-data">
            <div class="card-body">
                <div class="row">
                    <!-- รูปภาพ -->
                    <div class="col-12">
                        <div class="row">
                            <?php
                            $sql_img = " SELECT * FROM tbl_car_rental_image WHERE car_rental_id = '$edit_id' ORDER BY car_rental_image_id ASC ";
                            $result_img = mysqli_query($conn, $sql_img);
                            $num_img = mysqli_num_rows($result_img);
                            while ($rs_img = mysqli_fetch_assoc($result_img)) {
                                if ($num_img > 0) {
                                    if ($rs_img['car_rental_image_name'] != "") { ?>
                                        <div class="col-lg-2 col-md-4">
                                            <div class="card card-info">
                                                <img src="../images/car_rental/<?= $rs_img['car_rental_image_name'] ?>" class="card-img-top img-fluid rounded-top" style="aspect-ratio: 3 / 2; object-fit: cover;" alt="<?= $rs_edit['car_rental_name'] ?>">
                                                <div class="card-footer text-right">
                                                    <button type="button" class="btn btn-sm btn-primary" data-fancybox="single" data-src="../images/car_rental/<?= $rs_img['car_rental_image_name'] ?>" data-caption="<?= $rs_edit['car_rental_name'] ?>">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-danger" onclick="cdelimg('<?= $rs_img['car_rental_image_name'] ?>','index.php?act=carrent&pg=carrent_edit&edit_id=<?= $rs_img['car_rental_id'] ?>&del_pic=<?= $rs_img['car_rental_image_id'] ?>')">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                            <?php }
                                }
                            } ?>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="car_rental_image_name" class="form-label">รูปภาพรถเช่า</label>
                        <input type="file" class="form-control file-3" name="car_rental_image_name[]" id="car_rental_image_name" accept="image/*" multiple>
                        <div class="form-text text-muted">
                            สามารถอัปโหลดได้หลายรูป (เช่น รูปรถมุมต่าง ๆ / ภายในรถ)
                        </div>
                    </div>

                    <!-- กลุ่ม: ข้อมูลผู้ประกอบการ -->
                    <div class="col-12 mt-2">
                        <div class="form-section-title text-warning mb-3">
                            <i class="fas fa-store"></i> ข้อมูลผู้ประกอบการ
                        </div>
                        <div class="form-section-subtitle">
                            ระบุชื่อผู้ให้บริการหรือชื่อร้านให้ชัดเจน เพื่อให้ผู้ใช้จดจำได้ง่าย
                        </div>
                        <div class="form-section-divider"></div>
                    </div>

                    <div class="col-md-8 mb-3">
                        <label for="car_rental_name" class="form-label">ชื่อผู้ประกอบการ / ชื่อร้าน *</label>
                        <input type="text" class="form-control" id="car_rental_name" name="car_rental_name" value="<?= $rs_edit['car_rental_name'] ?>" required>
                    </div>

                    <!-- กลุ่ม: ข้อมูลติดต่อ -->
                    <div class="col-12 mt-3">
                        <div class="form-section-title text-warning mb-3">
                            <i class="fas fa-phone-alt"></i> ข้อมูลติดต่อ
                        </div>
                        <div class="form-section-subtitle">
                            ช่องทางติดต่อสำคัญ เพื่อให้ลูกค้าสอบถามหรือจองรถได้สะดวก
                        </div>
                        <div class="form-section-divider"></div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="phone" class="form-label">เบอร์โทรศัพท์ *</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?= $rs_edit['phone'] ?>" required>
                        <div class="form-text text-muted">
                            ใช้เบอร์ที่สามารถติดต่อได้จริง
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="line_id" class="form-label">LINE ID</label>
                        <input type="text" class="form-control" id="line_id" name="line_id" value="<?= $rs_edit['line_id'] ?>">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="email" class="form-label">อีเมล</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= $rs_edit['email'] ?>">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="facebook" class="form-label">Facebook Page</label>
                        <input type="text" class="form-control" id="facebook" name="facebook" value="<?= $rs_edit['facebook'] ?>">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="website" class="form-label">เว็บไซต์</label>
                        <input type="text" class="form-control" id="website" name="website" value="<?= $rs_edit['website'] ?>">
                    </div>

                    <!-- กลุ่ม: พื้นที่ให้บริการ -->
                    <div class="col-12 mt-3">
                        <div class="form-section-title text-warning mb-3">
                            <i class="fas fa-map-marker-alt"></i> พื้นที่ให้บริการ
                        </div>
                        <div class="form-section-subtitle">
                            ระบุรายละเอียดบริการ เช่น ราคา สถานะให้บริการ และจำนวนผู้โดยสารต่อคัน
                        </div>
                        <div class="form-section-divider"></div>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="carrent_detail" class="form-label">
                            รายละเอียดบริการ *
                        </label>
                        <textarea class="form-control" id="carrent_detail" name="carrent_detail" rows="4" required
                            placeholder="ตัวอย่าง:&#10;- ราคาเริ่มต้น 800 บาท/วัน&#10;- ให้บริการทุกวัน 08:00 – 20:00 น.&#10;- รองรับผู้โดยสารสูงสุด 4 คนต่อคัน"><?= $rs_edit['carrent_detail'] ?></textarea>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="province_id" class="form-label">จังหวัด *</label>
                        <select id="province_id" name="province_id" class="form-control select2bs4" required>
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

                    <div class="col-md-4 mb-3">
                        <label for="district_id" class="form-label">อำเภอ *</label>
                        <select id="district_id" name="district_id" class="form-control select2bs4" required>
                            <option value="">-- เลือกอำเภอ --</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="subdistrict_id" class="form-label">ตำบล *</label>
                        <select id="subdistrict_id" name="subdistrict_id" class="form-control select2bs4" required>
                            <option value="">-- เลือกตำบล --</option>
                        </select>
                    </div>

                    <!-- กลุ่ม: ข้อมูลเข้าสู่ระบบ -->
                    <div class="col-12 mt-3">
                        <div class="form-section-title text-warning mb-3">
                            <i class="fas fa-user-lock"></i> ข้อมูลเข้าสู่ระบบ
                        </div>
                        <div class="form-section-subtitle">
                            ใช้สำหรับให้ผู้ประกอบการเข้าระบบจัดการข้อมูลรถเช่า
                        </div>
                        <div class="form-section-divider"></div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="username" class="form-label">ชื่อผู้ใช้ (Username) *</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?= $rs_edit['username'] ?>" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="password" class="form-label">รหัสผ่าน *</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" value="<?= base64_decode($rs_edit['password_hash']) ?>">
                            <div class="input-group-append toggle-password">
                                <i class="input-group-text far fa-eye"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="password_confirm" class="form-label">ยืนยันรหัสผ่าน *</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password_confirm" name="password_confirm" value="<?= base64_decode($rs_edit['password_hash']) ?>">
                            <div class="input-group-append toggle-password">
                                <i class="input-group-text far fa-eye"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer border-top-0 pt-3 pb-4">
                <div class="row g-2">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <input type="hidden" name="edit_id" value="<?= $rs_edit['car_rental_id'] ?>">
                        <button type="submit" class="btn btn-success btn-block" name="submit">
                            <i class="fas fa-check-circle"></i> บันทึกข้อมูล
                        </button>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <button type="reset" class="btn btn-warning btn-block">
                            <i class="fas fa-undo-alt"></i> รีเซ็ตฟอร์ม
                        </button>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <a href="?act=carrent&pg=carrent_list" class="btn btn-dark btn-block mb-2">
                            <i class="fas fa-fast-backward"></i> กลับไปหน้ารายการ
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $('#province_id').change(async () => {
        try {
            const province_id = $('#province_id option:selected').val();
            const response = await axios.get('admin_carrent/carrent_api.php?pid=' + province_id);

            // สมมุติว่าผลลัพธ์เป็น array ของ object ที่มี id และ name
            const districts = response.data;

            // ล้าง option เก่าใน select ปลายทาง
            $('#district_id').empty();

            // เพิ่ม default option
            $('#district_id').append('<option value="">-- เลือกอำเภอ --</option>');

            // วนใส่ option ใหม่
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
            const response = await axios.get('admin_carrent/carrent_api.php?did=' + district_id);

            // สมมุติว่าผลลัพธ์เป็น array ของ object ที่มี id และ name
            const subdistricts = response.data;

            // ล้าง option เก่าใน select ปลายทาง
            $('#subdistrict_id').empty();

            // เพิ่ม default option
            $('#subdistrict_id').append('<option value="">-- เลือกตำบล --</option>');

            // วนใส่ option ใหม่
            subdistricts.forEach(sdt => {
                $('#subdistrict_id').append(`<option value="${sdt.id}">${sdt.name_in_thai}</option>`);
            });
        } catch (error) {
            console.error(error);
        }
    });

    // โหลดจังหวัดก่อน
    $('#province_id').val('<?= $rs_edit['province_id'] ?>').trigger('change');

    // ดีเลย์ 300ms รอจังหวัดโหลดอำเภอ
    setTimeout(function() {

        $('#district_id').val('<?= $rs_edit['district_id'] ?>').trigger('change');

        // ดีเลย์อีก 300ms รออำเภอโหลดตำบล
        setTimeout(function() {

            $('#subdistrict_id').val('<?= $rs_edit['subdistrict_id'] ?>').trigger('change');

        }, 300);

    }, 300);
</script>