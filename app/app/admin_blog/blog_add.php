<?php

if (isset($_POST['submit'])) {

    $blog_name = mysqli_real_escape_string($conn, $_POST['blog_name']);
    $blog_date = mysqli_real_escape_string($conn, $_POST['blog_date']);
    $blog_detail = mysqli_real_escape_string($conn, $_POST['blog_detail']);

    // blog_image
    if (isset($_FILES['blog_image']['name'])) {
        $blog_image = $_FILES['blog_image']['name'];
        if ($blog_image != "") {
            $tmp = explode('.', $blog_image);
            $ext = end($tmp);

            $blog_image = "blog_" . date('Y-m-d') . '_' . rand(00000000, 99999999)  . '.' . $ext;
            $source_path = $_FILES['blog_image']['tmp_name'];

            $destination_path = "../images/blog/" . $blog_image;

            $upload = move_uploaded_file($source_path, $destination_path);

            if ($upload == false) {
                $msg = "<div class='alert alert-danger'>เกิดข้อผิดพลาดในการอัปโหลดไฟล์ </div>";
                die();
            }
        }
    } else {
        $blog_image = "";
    }

    $sql_add_admin = " INSERT INTO tbl_blog SET 
                            blog_id = NULL,
                            blog_name = '$blog_name',                            
                            blog_detail = '$blog_detail', 
                            blog_date = '$blog_date',                           
                            blog_image = '$blog_image' ";
    $result_add_admin = mysqli_query($conn, $sql_add_admin);
    if ($result_add_admin) {
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
?>
<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"><i class="nav-icon fas fa-blogspaper"></i> เพิ่มบทความ</h3>
        </div>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="blog_name">ชื่อบทความ</label>
                            <input type="text" class="form-control" name="blog_name" id="blog_name" placeholder="ชื่อบทความ" required="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="blog_date">วันที่</label>
                            <input type="date" class="form-control" name="blog_date" id="blog_date" placeholder="วันที่" required="" value="<?=date('Y-m-d')?>">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="blog_telephone">ภาพบทความ</label>
                            <input type="file" class="form-control file-3" name="blog_image" id="blog_image" placeholder="ภาพหน้าปกบทความ" required="" accept="image/*">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="blog_telephone">รายละเอียด</label>
                            <textarea class="form-control summernote" name="blog_detail" id="blog_detail" rows="10" placeholder="รายละเอียด"></textarea>
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