<?php
if (isset($_POST['submit'])) {
    $edit_id = mysqli_real_escape_string($conn, $_POST['edit_id']);
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

    $sql_check_hotel_name = " SELECT tbl_car_rental.username AS 'username' FROM tbl_car_rental WHERE tbl_car_rental.username = '$hotel_user'
                            UNION
                            SELECT tbl_hotel.hotel_user FROM tbl_hotel WHERE tbl_hotel.hotel_user = '$hotel_user' AND tbl_hotel.hotel_id <> '$edit_id' ";
    $result_check_hotel_name = mysqli_query($conn, $sql_check_hotel_name);
    $num_check_hotel_name = mysqli_num_rows($result_check_hotel_name);
    if ($num_check_hotel_name > 0) {
        echo "<script>
        $(function() {
            warnDuplicate('ชื่อผู้ใช้นี้ถูกใช้แล้ว');
        })
        </script>";
    }

    if ($num_check_hotel_name == 0) {

        $sql_hotel = " UPDATE tbl_hotel SET 
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
                                            hotel_password  = '$hotel_password'
                                            WHERE hotel_id = '$edit_id' ";
        $result_hotel = mysqli_query($conn, $sql_hotel);

        if ($_FILES['hotel_image']['name'][0] != '') {
            $id_max = $edit_id;
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
                                                    hotel_id = '$id_max',
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
<?php
// Delete Image
if (isset($_GET['del_pic'])) {
    if (!empty($_GET['del_pic'])) {
        $edit_id = $_GET['edit_id'];
        $pic_del = $_GET['del_pic'];
        $sql_del_img = " SELECT * FROM tbl_hotel_image WHERE hotel_image_id = '$pic_del' ";
        $result_del_img = mysqli_query($conn, $sql_del_img);
        $num_del_img = mysqli_num_rows($result_del_img);
        if ($num_del_img > 0) {
            $rs_del_img = mysqli_fetch_assoc($result_del_img);
            $fileupload = $rs_del_img['hotel_image_name'];
            if ($fileupload != "") {
                unlink("../images/hotel_image/$fileupload");
            }
            $sql_update_img = " DELETE FROM tbl_hotel_image WHERE hotel_image_id = '$pic_del' ";
            mysqli_query($conn, $sql_update_img);
        }
        echo '<script type="text/javascript">',
        'del_imgsuccess();',
        '</script>';
        header("refresh: 0; index.php?act=hotel&pg=hotel_edit&edit_id=$edit_id");
    }
}
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $sql_edit = " SELECT * FROM tbl_hotel WHERE hotel_id = '$edit_id' ";
    $result_edit = mysqli_query($conn, $sql_edit);
    $rs_edit = mysqli_fetch_assoc($result_edit);
    $num_edit = mysqli_num_rows($result_edit);
    if ($num_edit == 0) {
        header('Location:index.php?act=hotel&pg=hotel_list');
    }
} else {
    header('Location:index.php?act=hotel&pg=hotel_list');
}
?>
<div class="col-md-12">
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title"><i class="far fa-edit"></i> แก้ไขผู้ประกอบการโรงแรม</h3>
        </div>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="card-body">
                <div class="form-group">
                    <label for="hotel_image">รูปภาพ</label>
                    <div class="row">
                        <?php
                        $sql_img = " SELECT * FROM tbl_hotel_image WHERE hotel_id = '$edit_id' ORDER BY hotel_image_id ASC ";
                        $result_img = mysqli_query($conn, $sql_img);
                        $num_img = mysqli_num_rows($result_img);
                        while ($rs_img = mysqli_fetch_assoc($result_img)) {
                            if ($num_img > 0) {
                                if ($rs_img['hotel_image_name'] != "") { ?>
                                    <div class="col-lg-2 col-md-4">
                                        <div class="card card-info">
                                            <img src="../images/hotel_image/<?= $rs_img['hotel_image_name'] ?>" class="card-img-top img-fluid rounded-top" style="aspect-ratio: 3 / 2; object-fit: cover;" alt="<?= $rs_edit['hotel_name'] ?>">
                                            <div class="card-footer text-right">
                                                <button type="button" class="btn btn-sm btn-primary" data-fancybox="single" data-src="../images/hotel_image/<?= $rs_img['hotel_image_name'] ?>" data-caption="<?= $rs_edit['hotel_name'] ?>">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger" onclick="cdelimg('<?= $rs_img['hotel_image_name'] ?>','index.php?act=hotel&pg=hotel_edit&edit_id=<?= $rs_img['hotel_id'] ?>&del_pic=<?= $rs_img['hotel_image_id'] ?>')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                        <?php }
                            }
                        } ?>
                    </div>
                    <input type="file" class="form-control file-3" name="hotel_image[]" id="hotel_image" accept="image/*" multiple>
                </div>
                <div class="form-group">
                    <label for="hotel_name">ชื่อโรงแรม</label>
                    <input type="text" class="form-control" name="hotel_name" id="hotel_name" value="<?= $rs_edit['hotel_name'] ?>">
                </div>
                <div class="form-group">
                    <label for="hotel_lat">พิกัดละติจูด</label>
                    <input type="text" class="form-control" name="hotel_lat" id="hotel_lat" value="<?= $rs_edit['hotel_lat'] ?>">
                </div>
                <div class="form-group">
                    <label for="hotel_lon">พิกัดลองจิจูด</label>
                    <input type="text" class="form-control" name="hotel_lon" id="hotel_lon" value="<?= $rs_edit['hotel_lon'] ?>">
                </div>
                <div class="form-group">
                    <label for="hotel_price">ราคา/คืน</label>
                    <input type="number" step="0.01" class="form-control" name="hotel_price" id="hotel_price" value="<?=$rs_edit['hotel_price']?>">
                </div>
                <div class="form-group">
                    <label for="hotel_telephone">เบอร์โทรศัพท์</label>
                    <input type="text" class="form-control" name="hotel_telephone" id="hotel_telephone" value="<?=$rs_edit['hotel_telephone']?>">
                </div>
                <div class="form-group">
                    <label for="hotel_line">ไลน์</label>
                    <input type="text" class="form-control" name="hotel_line" id="hotel_line" value="<?=$rs_edit['hotel_line']?>">
                </div>
                <div class="form-group">
                    <label for="hotel_email">อีเมล</label>
                    <input type="email" class="form-control" name="hotel_email" id="hotel_email" value="<?=$rs_edit['hotel_email']?>">
                </div>
                <div class="form-group">
                    <label for="hotel_facebook">facebook</label>
                    <input type="text" class="form-control" name="hotel_facebook" id="hotel_facebook" value="<?=$rs_edit['hotel_facebook']?>">
                </div>
                <div class="form-group">
                    <label for="hotel_website">เว็บไซต์</label>
                    <input type="text" class="form-control" name="hotel_website" id="hotel_website" value="<?=$rs_edit['hotel_website']?>">
                </div>
                <hr>
                <div class="form-group">
                    <label for="hotel_user">ชื่อผู้ใช้</label>
                    <input type="text" class="form-control" name="hotel_user" id="hotel_user" value="<?=$rs_edit['hotel_user']?>">
                </div>
                <div class="form-group">
                    <label for="hotel_password">รหัสผ่าน</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="admin_password" name="hotel_password" value="<?= base64_decode($rs_edit['hotel_password']) ?>">
                        <div class="input-group-append toggle-password">
                            <i class="input-group-text far fa-eye"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <input type="hidden" name="edit_id" value="<?= $edit_id ?>">
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