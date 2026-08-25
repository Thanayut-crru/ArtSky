<?php

if (isset($_POST['submit'])) {

    // Support either `tbl_news` or `news` as table name
    $news_table = 'tbl_news';
    try {
        $probe = mysqli_query($conn, "SELECT 1 FROM tbl_news LIMIT 1");
        if ($probe === false) {
            $news_table = 'tbl_news';
        }
    } catch (Throwable $e) {
        $news_table = 'tbl_news';
    }

    $station_id = mysqli_real_escape_string($conn, $_POST['station_id']);
    $news_name = mysqli_real_escape_string($conn, $_POST['news_name']);
    $news_date = mysqli_real_escape_string($conn, $_POST['news_date']);
    $news_detail = mysqli_real_escape_string($conn, $_POST['news_detail']);

    // news_image
    if (isset($_FILES['news_image']['name'])) {
        $news_image = $_FILES['news_image']['name'];
        if ($news_image != "") {
            $tmp = explode('.', $news_image);
            $ext = end($tmp);

            $news_image = "news_" . date('Y-m-d') . '_' . rand(00000000, 99999999)  . '.' . $ext;
            $source_path = $_FILES['news_image']['tmp_name'];

            $destination_path = "../images/news/" . $news_image;

            $upload = move_uploaded_file($source_path, $destination_path);

            if ($upload == false) {
                $msg = "<div class='alert alert-danger'>เกิดข้อผิดพลาดในการอัปโหลดไฟล์ </div>";
                die();
            }
        }
    } else {
        $news_image = "";
    }

    $sql_add_admin = " INSERT INTO {$news_table} SET 
                            news_id = NULL,
                            station_id = '$station_id',
                            news_name = '$news_name',                            
                            news_detail = '$news_detail', 
                            news_date = '$news_date',                           
                            news_image = '$news_image' ";
    $result_add_admin = mysqli_query($conn, $sql_add_admin);
    if ($result_add_admin) {
        echo "<script>
                    $(function() {
                        dataAddsuccess('?act=news&pg=news_list');
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

$stations = [];
$res_station = mysqli_query($conn, "SELECT station_id, station_name FROM tbl_station ORDER BY station_id ASC");
if ($res_station) {
    while ($row = mysqli_fetch_assoc($res_station)) {
        $stations[] = $row;
    }
}
?>
<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"><i class="nav-icon fab fa-blogger"></i> เพิ่มข่าวสาร</h3>
        </div>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="news_name">ชื่อข่าว</label>
                            <input type="text" class="form-control" name="news_name" id="news_name" placeholder="ชื่อข่าว" required="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="news_date">วันที่</label>
                            <input type="date" class="form-control" name="news_date" id="news_date" placeholder="วันที่" required="" value="<?=date('Y-m-d')?>">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="station_id">สถานี</label>
                            <select class="form-control select2bs4" name="station_id" id="station_id" required="">
                                <option value="">-- เลือกสถานี --</option>
                                <?php foreach ($stations as $st) { ?>
                                    <option value="<?= $st['station_id'] ?>"><?= $st['station_id'] ?> - <?= $st['station_name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="news_image">ภาพข่าว</label>
                            <input type="file" class="form-control file-3" name="news_image" id="news_image" placeholder="ภาพข่าว" required="" accept="image/*">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="news_detail">รายละเอียด</label>
                            <textarea class="form-control summernote" name="news_detail" id="news_detail" rows="10" placeholder="รายละเอียด"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <button type="submit" class="btn btn-block btn-success mb-2" name="submit"><i class="fas fa-check-circle"></i> บันทึกข้อมูล</button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <button type="reset" class="btn btn-block btn-warning mb-2"><i class="fas fa-undo-alt"></i> รีเซ็ท</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
