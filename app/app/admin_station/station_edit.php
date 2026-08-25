<?php
if (isset($_POST['submit'])) {

    $id_edit = mysqli_real_escape_string($conn, $_POST['id_edit']);
    $station_name = mysqli_real_escape_string($conn, $_POST['station_name']);
    $station_lat = mysqli_real_escape_string($conn, $_POST['station_lat']);
    $station_long = mysqli_real_escape_string($conn, $_POST['station_long']);

    if (isset($_FILES['station_image']['name'])) {

        $station_image   = $_FILES['station_image']['name'];
        $tmp             = explode('.', $station_image);
        $ext             = strtolower(end($tmp));
        $st_image       = "station_image_" . date('dmYHis') . '_' . rand(00000000, 99999999) . '.' . $ext;

        $imageUploadPath = "../images/station_image/" . $st_image;
        $fileType        = pathinfo($imageUploadPath, PATHINFO_EXTENSION);

        // Allow certain file formats 
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($fileType, $allowTypes)) {
            // Image temp source and size 
            $imageTemp = $_FILES["station_image"]["tmp_name"];
            $imageSize = convert_filesize($_FILES["station_image"]["size"]);

            // Compress size and upload image 
            $compressedImage = compressImage($imageTemp, $imageUploadPath, 75);

            if ($compressedImage) {
                $compressedImageSize = filesize($compressedImage);
                $compressedImageSize = convert_filesize($compressedImageSize);
                $sql_img = " UPDATE tbl_station SET                                             
                                            station_image = '$st_image'
                                            WHERE station_id   = '$id_edit' ";
                $result_img = mysqli_query($conn, $sql_img);
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

    $sql_station = " UPDATE tbl_station SET                                             
                                            station_name = '$station_name',
                                            station_lat = '$station_lat',
                                            station_long = '$station_long'
                                            WHERE station_id   = '$id_edit' ";
    $result_station = mysqli_query($conn, $sql_station);
    if ($result_station) {
        echo "<script>
                    $(function() {
                        dataAddsuccess('index.php?act=station&pg=station_list');
                    })
            </script>";
    } else {
        echo "<script>
                    $(function() {
                        dataAddunsuccess();
                    })
            </script>";
    }
}

// Delete Image
if (isset($_GET['del_pic'])) {
    if (!empty($_GET['del_pic'])) {
        $pic_del = $_GET['del_pic'];
        $sql_del_img = " SELECT * FROM tbl_station WHERE station_id = '$pic_del' ";
        $result_del_img = mysqli_query($conn, $sql_del_img);
        $num_del_img = mysqli_num_rows($result_del_img);
        if ($num_del_img > 0) {
            $rs_del_img = mysqli_fetch_assoc($result_del_img);
            $fileupload = $rs_del_img['station_image'];
            if ($fileupload != "") {
                unlink("../images/station_image/$fileupload");
            }
            $sql_update_img = " UPDATE tbl_station SET station_image = '' WHERE station_id = '$pic_del' ";
            mysqli_query($conn, $sql_update_img);
        }
        echo '<script type="text/javascript">',
        'del_imgsuccess();',
        '</script>';
        header("refresh: 1; index.php?act=station&pg=station_edit&edit_id=$pic_del");
    }
}
?>
<?php
if (isset($_GET['edit_id'])) {
    $edit_id     = $_GET['edit_id'];
    $sql_edit    = " SELECT * FROM tbl_station WHERE station_id = '$edit_id' ";
    $result_edit = mysqli_query($conn, $sql_edit);
    $num_edit    = mysqli_num_rows($result_edit);
    $rs_edit     = mysqli_fetch_assoc($result_edit);
    if ($num_edit == 0) {
        header('Location:index.php?act=station&pg=station_list');
    }
} else {
    header('Location:index.php?act=station&pg=station_list');
}
?>
<div class="col-md-12">
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title"><i class="far fa-edit"></i> เพิ่มสถานี ART SKY</h3>
        </div>
        <div class="card-body">
            <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="station_image">รูปภาพ</label>
                    <?php if ($rs_edit['station_image'] == "") { ?>
                        <input type="file" class="form-control file-3" name="station_image" id="station_image" accept="image/*">
                    <?php } else { ?>
                        <div class="col-md-4">
                            <div class="card card-info">
                                <img src="../images/station_image/<?= $rs_edit['station_image'] ?>" class="card-img-top img-fluid rounded" alt="<?= $rs_edit['station_name'] ?>">
                                <div class="card-footer">
                                    <button type="button" class="btn btn-primary" data-fancybox="single" data-src="../images/station_image/<?= $rs_edit['station_image'] ?>" data-caption="<?= $rs_edit['station_name'] ?>">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger" onclick="cdelimg('<?= $rs_edit['station_image'] ?>','index.php?act=station&pg=station_edit&edit_id=<?= $rs_edit['station_id'] ?>&del_pic=<?= $rs_edit['station_id'] ?>')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="form-group row">
                    <label for="station_name" class="col-sm-2 col-form-label">ชื่อสถานี</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="station_name" name="station_name" value="<?= $rs_edit['station_name'] ?>" placeholder="ชื่อสถานี" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="station_latitude" class="col-sm-2 col-form-label">Latitude (ละติจูด)</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="station_lat" name="station_lat" value="<?= $rs_edit['station_lat'] ?>" placeholder="ละติจูด">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="station_longitude" class="col-sm-2 col-form-label">Longitude (ลองจิจูด)</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="station_long" name="station_long" value="<?= $rs_edit['station_long'] ?>" placeholder="ลองจิจูด">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                        <input type="hidden" name="id_edit" value="<?= $rs_edit['station_id'] ?>">
                        <button type="submit" name="submit" class="btn btn-primary"><i class="far fa-check-circle"></i> บันทึก</button>
                        <button type="reset" class="btn btn-warning"><i class="fas fa-redo-alt"></i> รีเซ็ต</button>
                        <a href="index.php?act=station&pg=station_list" class="btn btn-dark"><i class="fas fa-fast-backward"></i> ถอยกลับ</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>