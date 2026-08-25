<?php
if (isset($_POST['submit'])) {

    $id_edit = mysqli_real_escape_string($conn, $_POST['id_edit']);
    $admin_fullname = mysqli_real_escape_string($conn, $_POST['admin_fullname']);
    $admin_telephone = mysqli_real_escape_string($conn, $_POST['admin_telephone']);
    $admin_email = mysqli_real_escape_string($conn, $_POST['admin_email']);
    $admin_address = mysqli_real_escape_string($conn, $_POST['admin_address']);
    $admin_username = mysqli_real_escape_string($conn, $_POST['admin_username']);
    $admin_password = base64_encode(mysqli_real_escape_string($conn, $_POST['admin_password']));

    $admin_status = mysqli_real_escape_string($conn, $_POST['admin_status']);
    $admin_type = mysqli_real_escape_string($conn, $_POST['admin_type']);

    $sql_check_fullname = " SELECT admin_fullname FROM tbl_admin WHERE admin_fullname = '$admin_fullname' AND admin_id <> '$id_edit' ";
    $result_check_fullname = mysqli_query($conn, $sql_check_fullname);
    $num_check_fullname = mysqli_num_rows($result_check_fullname);
    if ($num_check_fullname > 0) {
        echo "<script>
        $(function() {
            warnDuplicate('ชื่อ-นามสกุลนี้ถูกใช้แล้ว');
        })
        </script>";
    }

    $sql_check_email = " SELECT admin_email FROM tbl_admin WHERE admin_email = '$admin_email' AND admin_id <> '$id_edit' ";
    $result_check_email = mysqli_query($conn, $sql_check_email);
    $num_check_email = mysqli_num_rows($result_check_email);
    if ($num_check_email > 0) {
        echo "<script>
        $(function() {
            warnDuplicate('อีเมลนี้ถูกใช้แล้ว');
        })
        </script>";
    }

    $sql_check_telephone = " SELECT admin_telephone FROM tbl_admin WHERE admin_telephone = '$admin_telephone' AND admin_id <> '$id_edit' ";
    $result_check_telephone = mysqli_query($conn, $sql_check_telephone);
    $num_check_telephone = mysqli_num_rows($result_check_telephone);
    if ($num_check_telephone > 0) {
        echo "<script>
        $(function() {
            warnDuplicate('เบอร์โทรศัพท์นี้ถูกใช้แล้ว');
        })
        </script>";
    }

    $sql_check_admin_username = " SELECT tbl_admin.admin_username FROM tbl_admin
    WHERE tbl_admin.admin_username = '$admin_username' AND tbl_admin.admin_id <> '$id_edit'  ";
    $result_check_admin_username = mysqli_query($conn, $sql_check_admin_username);
    $num_check_admin_username = mysqli_num_rows($result_check_admin_username);
    if ($num_check_admin_username > 0) {
        echo "<script>
        $(function() {
            warnDuplicate('ชื่อผู้ใช้นี้ถูกใช้แล้ว');
        })
        </script>";
    }

    if ($num_check_fullname == 0 && $num_check_email == 0 && $num_check_telephone == 0 && $num_check_admin_username == 0) {

        // admin_image
        if (isset($_FILES['admin_image']['name'])) {
            $admin_image = $_FILES['admin_image']['name'];
            if ($admin_image != "") {
                $tmp = explode('.', $admin_image);
                $ext = end($tmp);

                $admin_image = "admin_" . date('dmYHis') . '_' . rand(00000000, 99999999) . '.' . $ext;
                $source_path = $_FILES['admin_image']['tmp_name'];

                $destination_path = "../images/admin/" . $admin_image;

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
                $sql_update_img = " UPDATE tbl_admin SET admin_image = '$admin_image' WHERE admin_id = '$id_edit' ";
                mysqli_query($conn, $sql_update_img);
            }
        }

        $sql_edit_admin = " UPDATE tbl_admin SET 
                            admin_fullname = '$admin_fullname',
                            admin_telephone = '$admin_telephone',
                            admin_address = '$admin_address',
                            admin_email = '$admin_email',
                            admin_status = '$admin_status',
                            admin_type = '$admin_type',
                            admin_username = '$admin_username',
                            admin_password = '$admin_password'
                            WHERE admin_id = '$id_edit'
                            ";
        $result_edit_admin = mysqli_query($conn, $sql_edit_admin);
        if ($result_edit_admin) {
            echo "<script>
                    $(function() {
                        dataAddsuccess('index.php?act=admin&pg=admin_list');
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

// Delete Image
if (isset($_GET['del_pic'])) {
    if (!empty($_GET['del_pic'])) {
        $pic_del = $_GET['del_pic'];
        $sql_del_img = " SELECT * FROM tbl_admin WHERE admin_id = '$pic_del' ";
        $result_del_img = mysqli_query($conn, $sql_del_img);
        $num_del_img = mysqli_num_rows($result_del_img);
        if ($num_del_img > 0) {
            $rs_del_img = mysqli_fetch_assoc($result_del_img);
            $fileupload = $rs_del_img['admin_image'];
            if ($fileupload != "") {
                unlink("../images/admin/$fileupload");
            }
            $sql_update_img = " UPDATE tbl_admin SET admin_image = '' WHERE admin_id = '$pic_del' ";
            mysqli_query($conn, $sql_update_img);
        }
        echo '<script type="text/javascript">',
        'del_imgsuccess();',
        '</script>';
        header("refresh: 1; index.php?act=admin&pg=admin_edit&edit_id=$pic_del");
    }
}
?>
<?php
if (isset($_GET['edit_id'])) {
    $id_edit = $_GET['edit_id'];
    $sql_edit = " SELECT * FROM tbl_admin WHERE admin_id = '$id_edit' ";
    $result_edit = mysqli_query($conn, $sql_edit);
    $rs_edit = mysqli_fetch_assoc($result_edit);
    $num_edit = mysqli_num_rows($result_edit);
    if ($num_edit == 0) {
        header('Location:index.php?act=admin&pg=admin_list');
    }
} else {
    header('Location:index.php?act=admin&pg=admin_list');
}
?>
<div class="col-md-12">
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title"><i class="far fa-edit"></i> แก้ไขผู้ใช้งาน</h3>
        </div>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="card-body">
                <div class="form-group">
                    <label for="admin_image">รูปภาพ</label>
                    <?php if ($rs_edit['admin_image'] == "") { ?>
                        <input type="file" class="form-control file-3" name="admin_image" id="admin_image" placeholder="ชื่อ-นามสกุล" accept="image/*">
                    <?php } else { ?>
                        <div class="col-md-4">
                            <div class="card card-info">
                                <img src="../images/admin/<?= $rs_edit['admin_image'] ?>" class="card-img-top img-fluid rounded" alt="<?= $rs_edit['admin_fullname'] ?>">
                                <div class="card-footer">
                                    <button type="button" class="btn btn-primary" data-fancybox="single" data-src="../images/admin/<?= $rs_edit['admin_image'] ?>" data-caption="<?= $rs_edit['admin_fullname'] ?>">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger" onclick="cdelimg('<?= $rs_edit['admin_image'] ?>','index.php?act=admin&pg=admin_edit&edit_id=<?= $rs_edit['admin_id'] ?>&del_pic=<?= $rs_edit['admin_id'] ?>')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="admin_fullname">ชื่อ-นามสกุล</label>
                            <input type="text" class="form-control" name="admin_fullname" id="admin_fullname" value="<?= $rs_edit['admin_fullname'] ?>" placeholder="ชื่อ-นามสกุล" required="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="admin_telephone">เบอร์โทรศัพท์</label>
                            <input type="text" class="form-control" name="admin_telephone" id="admin_telephone" value="<?= $rs_edit['admin_telephone'] ?>" placeholder="เบอร์โทรศัพท์" required="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="admin_email">อีเมล</label>
                            <input type="email" class="form-control" name="admin_email" id="admin_email" value="<?= $rs_edit['admin_email'] ?>" placeholder="อีเมล" required="">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="admin_address">ที่อยู่</label>
                            <textarea class="form-control" name="admin_address" id="admin_address" rows="3" placeholder="ที่อยู่"><?= $rs_edit['admin_address'] ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="admin_type">ประเภท</label>
                            <?php
                            $admin_type_1 = '';
                            if($rs_edit['admin_type'] == 'พนักงาน'){
                               $admin_type_1 = 'selected';
                            }
                            $admin_type_2 = '';
                            if($rs_edit['admin_type'] == 'ผู้ดูแลระบบ'){
                                $admin_type_2 = 'selected';
                            }
                            ?>
                            <select class="form-control select2bs4" name="admin_type" id="admin_type">
                                <option value="1" <?=$admin_type_1?>>พนักงาน</option>
                                <option value="2" <?=$admin_type_2?>>ผู้ดูแลระบบ</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="admin_status">สถานะ</label>
                            <?php
                            $admin_status_1 = '';
                            if($rs_edit['admin_status'] == 'ปกติ'){
                               $admin_status_1 = 'selected';
                            }
                            $admin_status_2 = '';
                            if($rs_edit['admin_status'] == 'ยกเลิก'){
                                $admin_status_2 = 'selected';
                            }
                            ?>
                            <select class="form-control" name="admin_status" id="admin_status">
                                <option value="1" <?=$admin_status_1?>>ปกติ</option>
                                <option value="2" <?=$admin_status_2?>>ยกเลิก</option>
                            </select>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="admin_username">ชื่อผู้ใช้</label>
                            <input type="text" class="form-control" name="admin_username" id="admin_username" value="<?= $rs_edit['admin_username'] ?>" placeholder="ชื่อผู้ใช้" required="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="admin_password">รหัสผ่าน</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="admin_password" name="admin_password" autocomplete="new-password" minlength="6" placeholder="กรอกรหัสผ่าน" value="<?= base64_decode($rs_edit['admin_password']) ?>" required>
                                <div class="input-group-append toggle-password">
                                    <i class="input-group-text far fa-eye"></i>
                                </div>
                            </div>
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