<?php
if (isset($_POST['submit'])) {

    $admin_fullname = mysqli_real_escape_string($conn, $_POST['admin_fullname']);
    $admin_telephone = mysqli_real_escape_string($conn, $_POST['admin_telephone']);
    $admin_email = mysqli_real_escape_string($conn, $_POST['admin_email']);
    $admin_address = mysqli_real_escape_string($conn, $_POST['admin_address']);
    $admin_username = mysqli_real_escape_string($conn, $_POST['admin_username']);
    $admin_password = base64_encode(mysqli_real_escape_string($conn, $_POST['admin_password']));
    $admin_status = mysqli_real_escape_string($conn, $_POST['admin_status']);
    $admin_type = mysqli_real_escape_string($conn, $_POST['admin_type']);

    $sql_check_fullname = " SELECT admin_fullname FROM tbl_admin WHERE admin_fullname = '$admin_fullname' ";
    $result_check_fullname = mysqli_query($conn, $sql_check_fullname);
    $num_check_fullname = mysqli_num_rows($result_check_fullname);
    if ($num_check_fullname > 0) {
        echo "<script>
        $(function() {
            warnDuplicate('ชื่อ-นามสกุลนี้ถูกใช้แล้ว');
        })
        </script>";
    }

    $sql_check_email = " SELECT admin_email FROM tbl_admin WHERE admin_email = '$admin_email' ";
    $result_check_email = mysqli_query($conn, $sql_check_email);
    $num_check_email = mysqli_num_rows($result_check_email);
    if ($num_check_email > 0) {
        echo "<script>
        $(function() {
            warnDuplicate('อีเมลนี้ถูกใช้แล้ว');
        })
        </script>";
    }

    $sql_check_telephone = " SELECT admin_telephone FROM tbl_admin WHERE admin_telephone = '$admin_telephone' ";
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
                                    WHERE tbl_admin.admin_username = '$admin_username' ";
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
                    die();
                }
            }
        } else {
            $admin_image = "";
        }

        $sql_add_admin = " INSERT INTO tbl_admin SET 
                            admin_id = NULL,
                            admin_fullname = '$admin_fullname',
                            admin_telephone = '$admin_telephone',
                            admin_address = '$admin_address',
                            admin_email = '$admin_email',
                            admin_status = '$admin_status',
                            admin_type = '$admin_type',
                            admin_username = '$admin_username',
                            admin_password = '$admin_password',
                            admin_image = '$admin_image',
                            admin_created = CURRENT_TIMESTAMP,
                            admin_updated = CURRENT_TIMESTAMP ";
        $result_add_admin = mysqli_query($conn, $sql_add_admin);
        if ($result_add_admin) {
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
?>
<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-plus"></i> เพิ่มผู้ใช้งาน</h3>
        </div>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="card-body">
                <div class="form-group">
                    <label for="admin_image">รูปภาพ</label>
                    <input type="file" class="form-control file-3" name="admin_image" id="admin_image" placeholder="ชื่อ-นามสกุล" accept="image/*">
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="admin_fullname">ชื่อ-นามสกุล</label>
                            <input type="text" class="form-control" name="admin_fullname" id="admin_fullname" placeholder="ชื่อ-นามสกุล" required="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="admin_telephone">เบอร์โทรศัพท์</label>
                            <input type="text" class="form-control" name="admin_telephone" id="admin_telephone" placeholder="เบอร์โทรศัพท์" required="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="admin_email">อีเมล</label>
                            <input type="email" class="form-control" name="admin_email" id="admin_email" placeholder="อีเมล" required="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="admin_address">ที่อยู่</label>
                            <textarea class="form-control" name="admin_address" id="admin_address" rows="3" placeholder="ที่อยู่"></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="admin_type">ประเภท</label>
                            <select class="form-control select2bs4" name="admin_type" id="admin_type">
                                <option value="1">พนักงาน</option>
                                <option value="2">ผู้ดูแลระบบ</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="admin_status">สถานะ</label>
                            <select class="form-control" name="admin_status" id="admin_status">
                                <option value="1">ปกติ</option>
                                <option value="2">ยกเลิก</option>
                            </select>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="admin_username">ชื่อผู้ใช้</label>
                            <input type="text" class="form-control" name="admin_username" id="admin_username" placeholder="ชื่อผู้ใช้" value="<?= $_POST['admin_username'] ?? '' ?>" required="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="admin_password">รหัสผ่าน</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="admin_password" name="admin_password" autocomplete="new-password" minlength="6" placeholder="กรอกรหัสผ่าน" value="<?= $_POST['admin_password'] ?? '' ?>" required>
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