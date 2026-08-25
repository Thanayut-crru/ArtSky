<?php
if (isset($_POST['submit'])) {

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
    $hotel_password  = mysqli_real_escape_string($conn, base64_encode($_POST['hotel_password']));

    $sql_check_hotel_name = " SELECT tbl_car_rental.username AS 'username' FROM tbl_car_rental WHERE tbl_car_rental.username = '$hotel_name'
                            UNION
                            SELECT tbl_hotel.hotel_user FROM tbl_hotel WHERE tbl_hotel.hotel_user = '$hotel_name' ";
    $result_check_hotel_name = mysqli_query($conn, $sql_check_hotel_name);
    $num_check_hotel_name = mysqli_num_rows($result_check_hotel_name);
    if ($num_check_hotel_name > 0) {
        echo "<script>
        $(function() {
            warnDuplicate('ชื่อโรงแรมถูกใช้แล้ว');
        })
        </script>";
    }

    if ($num_check_hotel_name == 0) {

        $sql_hotel = " INSERT INTO tbl_hotel SET 
                                                hotel_id        = NULL,
                                                hotel_name      = '$hotel_name',
                                                hotel_lat       = '$hotel_lat',
                                                hotel_lon       = '$hotel_lon',
                                                hotel_price     =  $hotel_price,
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
        $result_hotel = mysqli_query($conn, $sql_hotel);
        $last_id = mysqli_insert_id($conn);

        if ($_FILES['hotel_image']['name'][0] != '') {

            // File info 
            for ($i = 0; $i < count($_FILES['hotel_image']['name']); ++$i) {
                $hotel_image = $_FILES['hotel_image']['name'][$i];
                $tmp = explode('.', $hotel_image);
                $ext = strtolower(end($tmp));
                $prd_image = "hotel_image_" . date('dmYHis') . '_' . rand(00000000, 99999999) . '.' . $ext;

                $imageUploadPath = "../images/hotel_image/" . $prd_image;
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
                                                    hotel_image_id = NULL,
                                                    hotel_id = '$last_id',
                                                    hotel_image_name = '$prd_image' ";
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

        if ($result_hotel) {
            echo "<script>
                    $(function() {
                        dataAddsuccess('index.php?act=hotel&pg=hotel_list');
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
<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-plus"></i> เพิ่มผู้ประกอบการโรงแรม</h3>
        </div>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="card-body">
                <div class="form-group">
                    <label for="hotel_image">รูปภาพ</label>
                    <input type="file" class="form-control file-3" name="hotel_image[]" id="hotel_image" accept="image/*" multiple>
                </div>
                <div class="form-group">
                    <label for="hotel_name">ชื่อโรงแรม</label>
                    <input type="text" class="form-control" name="hotel_name" id="hotel_name">
                </div>
                <div class="form-group">
                    <label for="hotel_lat">พิกัดละติจูด</label>
                    <input type="text" class="form-control" name="hotel_lat" id="hotel_lat">
                </div>
                <div class="form-group">
                    <label for="hotel_lon">พิกัดลองจิจูด</label>
                    <input type="text" class="form-control" name="hotel_lon" id="hotel_lon">
                </div>
                <div class="form-group">
                    <label for="hotel_price">ราคา/คืน</label>
                    <input type="number" step="0.01" class="form-control" name="hotel_price" id="hotel_price">
                </div>
                <div class="form-group">
                    <label for="hotel_telephone">เบอร์โทรศัพท์</label>
                    <input type="text" class="form-control" name="hotel_telephone" id="hotel_telephone">
                </div>
                <div class="form-group">
                    <label for="hotel_line">ไลน์</label>
                    <input type="text" class="form-control" name="hotel_line" id="hotel_line">
                </div>
                <div class="form-group">
                    <label for="hotel_email">อีเมล</label>
                    <input type="email" class="form-control" name="hotel_email" id="hotel_email">
                </div>
                <div class="form-group">
                    <label for="hotel_facebook">facebook</label>
                    <input type="text" class="form-control" name="hotel_facebook" id="hotel_facebook">
                </div>
                <div class="form-group">
                    <label for="hotel_website">เว็บไซต์</label>
                    <input type="text" class="form-control" name="hotel_website" id="hotel_website">
                </div>
                <hr>
                <div class="form-group">
                    <label for="hotel_user">ชื่อผู้ใช้</label>
                    <input type="text" class="form-control" name="hotel_user" id="hotel_user">
                </div>
                <div class="form-group">
                    <label for="hotel_password">รหัสผ่าน</label>
                    <input type="password" class="form-control" name="hotel_password" id="hotel_password">
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <button type="submit" class="btn btn-block btn-success" name="submit"><i class="fas fa-check-circle"></i> บันทึกข้อมูล</button>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <button type="reset" class="btn btn-block btn-warning"><i class="fas fa-undo-alt"></i> รีเซ็ท</button>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <a href="?act=hotel&pg=hotel_list" class="btn btn-block btn-dark mb-2"><i class="fas fa-fast-backward"></i> ถอยกลับ</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>