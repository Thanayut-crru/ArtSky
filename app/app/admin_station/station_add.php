<?php
if (isset($_POST['submit'])) {

    $station_name      = mysqli_real_escape_string($conn, $_POST['station_name']);
    $station_lat  = mysqli_real_escape_string($conn, $_POST['station_lat']);
    $station_long = mysqli_real_escape_string($conn, $_POST['station_long']);

    if (isset($_FILES['station_image']['name'])) {

        $station_image = $_FILES['station_image']['name'];
        $tmp           = explode('.', $station_image);
        $ext           = strtolower(end($tmp));
        $st_image      = "station_image_" . date('dmYHis') . '_' . rand(00000000, 99999999) . '.' . $ext;
        
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

    $sql_unit = " INSERT INTO tbl_station SET 
                                            station_id    = NULL,
                                            station_name  = '$station_name',
                                            station_lat   = '$station_lat',
                                            station_long  = '$station_long',
                                            station_image = '$st_image' ";
    $result_unit = mysqli_query($conn, $sql_unit);
    if ($result_unit) {
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
?>
<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-plus"></i> เพิ่มสถานี ART SKY</h3>
        </div>
        <div class="card-body">
            <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
                <div class="form-group row">
                    <label for="station_image" class="col-sm-2 col-form-label align-content-center">รูปภาพ</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control file-3" name="station_image" id="station_image" accept="image/*">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="station_name" class="col-sm-2 col-form-label">ชื่อสถานี</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="station_name" name="station_name" placeholder="ชื่อสถานี" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="station_lat" class="col-sm-2 col-form-label">Latitude (ละติจูด)</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="station_lat" name="station_lat" placeholder="ละติจูด">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="station_long" class="col-sm-2 col-form-label">Longitude (ลองจิจูด)</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="station_long" name="station_long" placeholder="ลองจิจูด">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                        <button type="submit" name="submit" class="btn btn-primary"><i class="far fa-check-circle"></i> บันทึก</button>
                        <button type="reset" class="btn btn-warning"><i class="fas fa-redo-alt"></i> รีเซ็ต</button>
                        <a href="index.php?act=station&pg=station_list" class="btn btn-dark"><i class="fas fa-fast-backward"></i> ถอยกลับ</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>