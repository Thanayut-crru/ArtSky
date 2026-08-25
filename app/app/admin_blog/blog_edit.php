<?php
if (isset($_POST['submit'])) {

    $id_edit = mysqli_real_escape_string($conn, $_POST['id_edit']);
    $blog_name = mysqli_real_escape_string($conn, $_POST['blog_name']);
    $blog_date = mysqli_real_escape_string($conn, $_POST['blog_date']);
    $blog_detail = mysqli_real_escape_string($conn, $_POST['blog_detail']);

    // blog_image
    if (isset($_FILES['blog_image']['name'])) {
        $blog_image = $_FILES['blog_image']['name'];
        if ($blog_image != "") {
            $tmp = explode('.', $blog_image);
            $ext = end($tmp);

            $blog_image = "blog_" . date('Y-m-d') . '_' . rand(00000000, 99999999) . '.' . $ext;
            $source_path = $_FILES['blog_image']['tmp_name'];

            $destination_path = "../images/blog/" . $blog_image;

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
            $sql_update_img = " UPDATE tbl_blog SET blog_image = '$blog_image' WHERE blog_id = '$id_edit' ";
            mysqli_query($conn, $sql_update_img);
        }
    }

    $sql_edit_admin = " UPDATE tbl_blog SET 
                            blog_name = '$blog_name',                            
                            blog_detail = '$blog_detail', 
                            blog_date = '$blog_date'
                            WHERE blog_id = '$id_edit'
                            ";
    $result_edit_admin = mysqli_query($conn, $sql_edit_admin);
    if ($result_edit_admin) {
        echo "<script>
                    $(function() {
                        dataAddsuccess('?act=blog&pg=blog_list');
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
        $sql_del_img = " SELECT * FROM tbl_blog WHERE blog_id = '$pic_del' ";
        $result_del_img = mysqli_query($conn, $sql_del_img);
        $num_del_img = mysqli_num_rows($result_del_img);
        if ($num_del_img > 0) {
            $rs_del_img = mysqli_fetch_assoc($result_del_img);
            $fileupload = $rs_del_img['blog_image'];
            if ($fileupload != "") {
                unlink("../images/blog/$fileupload");
            }
            $sql_update_img = " UPDATE tbl_blog SET blog_image = '' WHERE blog_id = '$pic_del' ";
            mysqli_query($conn, $sql_update_img);
        }
        echo '<script type="text/javascript">',
        'del_imgsuccess();',
        '</script>';
        header("refresh: 1; ?act=blog&pg=blog_edit&edit_id=$pic_del");
    }
}
?>
<?php
if (isset($_GET['edit_id'])) {
    $id_edit = $_GET['edit_id'];
    $sql_edit = " SELECT * FROM tbl_blog WHERE blog_id = '$id_edit' ";
    $result_edit = mysqli_query($conn, $sql_edit);
    $rs_edit = mysqli_fetch_assoc($result_edit);
    $num_edit = mysqli_num_rows($result_edit);
    if ($num_edit == 0) {
        header('Location:?act=blog&pg=blog_list');
    }
} else {
    header('Location:?act=blog&pg=blog_list');
}

?>
<div class="col-md-12">
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title"><i class="nav-icon fas fa-blogspaper"></i> แก้ไขบทความ</h3>
        </div>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="card-body">

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="blog_name">ชื่อบทความ</label>
                            <input type="text" class="form-control" name="blog_name" id="blog_name" value="<?= $rs_edit['blog_name'] ?>" placeholder="ชื่อบทความ" required="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="blog_date">วันที่</label>
                            <input type="date" class="form-control" name="blog_date" id="blog_date" value="<?= $rs_edit['blog_date'] ?>" placeholder="วันที่" required="">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="blog_image">รูปภาพ</label>
                            <?php if ($rs_edit['blog_image'] == "") { ?>
                                <input type="file" class="form-control file-3" name="blog_image" id="blog_image" required="" accept="image/*">
                            <?php } else { ?>
                                <div class="col-md-6 mx-auto">
                                    <div class="card card-info">
                                        <img src="../images/blog/<?= $rs_edit['blog_image'] ?>" class="card-img-top img-fluid rounded" alt="<?= $rs_edit['blog_name'] ?>">
                                        <div class="card-footer">
                                            <button type="button" class="btn btn-primary" data-fancybox="single" data-src="../images/blog/<?= $rs_edit['blog_image'] ?>" data-caption="<?= $rs_edit['blog_name'] ?>">
                                                <i class="fas fa-search"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger" onclick="cdelimg('<?= $rs_edit['blog_image'] ?>','?act=blog&pg=blog_edit&edit_id=<?= $rs_edit['blog_id'] ?>&del_pic=<?= $rs_edit['blog_id'] ?>')">
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
                            <label for="blog_telephone">รายละเอียด</label>
                            <textarea class="form-control summernote" name="blog_detail" id="blog_detail" rows="10" placeholder="รายละเอียด"><?= $rs_edit['blog_detail'] ?></textarea>
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