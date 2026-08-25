<?php
// Support either `tbl_news` or `news` as table name
$news_table = 'tbl_news';
try {
    $probe = mysqli_query($conn, "SELECT 1 FROM tbl_news LIMIT 1");
    if ($probe === false) {
        $news_table = 'news';
    }
} catch (Throwable $e) {
    $news_table = 'news';
}

if (isset($_POST['submit'])) {

    $id_edit = mysqli_real_escape_string($conn, $_POST['id_edit']);
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

            $news_image = "news_" . date('Y-m-d') . '_' . rand(00000000, 99999999) . '.' . $ext;
            $source_path = $_FILES['news_image']['tmp_name'];

            $destination_path = "../images/news/" . $news_image;

            $upload = move_uploaded_file($source_path, $destination_path);

            if ($upload == false) {
                $msg = "<div class='alert alert-danger'>เกิดข้อผิดพลาดในการอัปโหลดไฟล์ </div>";
                echo "<script>
                            $(function() {
                                dataAddunsuccess();
                            })
                        </script>";
                die();
            }
            $sql_update_img = " UPDATE {$news_table} SET news_image = '$news_image' WHERE news_id = '$id_edit' ";
            mysqli_query($conn, $sql_update_img);
        }
    }

    $sql_edit_admin = " UPDATE {$news_table} SET 
                            station_id = '$station_id',
                            news_name = '$news_name',                            
                            news_detail = '$news_detail', 
                            news_date = '$news_date'
                            WHERE news_id = '$id_edit'
                            ";
    $result_edit_admin = mysqli_query($conn, $sql_edit_admin);
    if ($result_edit_admin) {
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

// Delete Image
if (isset($_GET['del_pic'])) {
    if (!empty($_GET['del_pic'])) {
        $pic_del = $_GET['del_pic'];
        $sql_del_img = " SELECT * FROM {$news_table} WHERE news_id = '$pic_del' ";
        $result_del_img = mysqli_query($conn, $sql_del_img);
        $num_del_img = mysqli_num_rows($result_del_img);
        if ($num_del_img > 0) {
            $rs_del_img = mysqli_fetch_assoc($result_del_img);
            $fileupload = $rs_del_img['news_image'];
            if ($fileupload != "") {
                unlink("../images/news/$fileupload");
            }
            $sql_update_img = " UPDATE {$news_table} SET news_image = '' WHERE news_id = '$pic_del' ";
            mysqli_query($conn, $sql_update_img);
        }
        echo '<script type="text/javascript">',
        'del_imgsuccess();',
        '</script>';
        header("refresh: 1; ?act=news&pg=news_edit&edit_id=$pic_del");
    }
}
?>
<?php
if (isset($_GET['edit_id'])) {
    $id_edit = $_GET['edit_id'];
    $sql_edit = " SELECT * FROM {$news_table} WHERE news_id = '$id_edit' ";
    $result_edit = mysqli_query($conn, $sql_edit);
    $rs_edit = mysqli_fetch_assoc($result_edit);
    $num_edit = mysqli_num_rows($result_edit);
    if ($num_edit == 0) {
        header('Location:?act=news&pg=news_list');
    }
} else {
    header('Location:?act=news&pg=news_list');
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
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title"><i class="nav-icon fab fa-blogger"></i> แก้ไขข่าวสาร</h3>
        </div>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="card-body">

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="news_name">ชื่อข่าว</label>
                            <input type="text" class="form-control" name="news_name" id="news_name" value="<?= $rs_edit['news_name'] ?>" placeholder="ชื่อข่าว" required="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="news_date">วันที่</label>
                            <input type="date" class="form-control" name="news_date" id="news_date" value="<?= $rs_edit['news_date'] ?>" placeholder="วันที่" required="">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="station_id">สถานี</label>
                            <select class="form-control select2bs4" name="station_id" id="station_id" required="">
                                <option value="">-- เลือกสถานี --</option>
                                <?php foreach ($stations as $st) { ?>
                                    <option value="<?= $st['station_id'] ?>" <?= ($st['station_id'] == $rs_edit['station_id']) ? 'selected' : '' ?>><?= $st['station_id'] ?> - <?= $st['station_name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="news_image">รูปภาพ</label>
                            <?php if ($rs_edit['news_image'] == "") { ?>
                                <input type="file" class="form-control file-3" name="news_image" id="news_image" required="" accept="image/*">
                            <?php } else { ?>
                                <div class="col-md-6 mx-auto">
                                    <div class="card card-info">
                                        <img src="../images/news/<?= $rs_edit['news_image'] ?>" class="card-img-top img-fluid rounded" alt="<?= $rs_edit['news_name'] ?>">
                                        <div class="card-footer">
                                            <button type="button" class="btn btn-primary" data-fancybox="single" data-src="../images/news/<?= $rs_edit['news_image'] ?>" data-caption="<?= $rs_edit['news_name'] ?>">
                                                <i class="fas fa-search"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger" onclick="cdelimg('<?= $rs_edit['news_image'] ?>','?act=news&pg=news_edit&edit_id=<?= $rs_edit['news_id'] ?>&del_pic=<?= $rs_edit['news_id'] ?>')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="news_detail">รายละเอียด</label>
                            <textarea class="form-control summernote" name="news_detail" id="news_detail" rows="10" placeholder="รายละเอียด"><?= $rs_edit['news_detail'] ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <input type="hidden" name="id_edit" value="<?= $id_edit ?>">
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
