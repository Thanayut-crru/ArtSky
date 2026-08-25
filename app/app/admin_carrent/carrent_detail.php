<?php
if (isset($_GET['view_id'])) {
    $view_id = $_GET['view_id'];
    $sql = " SELECT * FROM tbl_car_rental WHERE car_rental_id = '$view_id' ";
    $result = mysqli_query($conn, $sql);
    $num_view = mysqli_num_rows($result);
    $rs = mysqli_fetch_assoc($result);
    if ($num_view == 0) {
        header('Location:index.php?act=car_rental&pg=car_rental_list');
    }
} else {
    header('Location:index.php?act=car_rental&pg=car_rental_list');
}
?>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <?php
            $sql_img = " SELECT * FROM tbl_car_rental_image WHERE car_rental_id = '$view_id' ORDER BY car_rental_image_id ASC ";
            $result_img = mysqli_query($conn, $sql_img);
            $num_img = mysqli_num_rows($result_img);
            while ($rs_img = mysqli_fetch_assoc($result_img)) {
                if ($num_img > 0) {
                    if ($rs_img['car_rental_image_name'] != "") { ?>
                        <div class="col-lg-2 col-md-4">
                            <div class="card card-info">
                                <img src="../images/car_rental/<?= $rs_img['car_rental_image_name'] ?>" class="card-img-top img-fluid rounded-top" style="aspect-ratio: 3 / 2; object-fit: cover;" alt="<?= $rs['car_rental_name'] ?>">
                                <div class="card-footer text-right">
                                    <button type="button" class="btn btn-sm btn-primary" data-fancybox="single" data-src="../images/car_rental/<?= $rs_img['car_rental_image_name'] ?>" data-caption="<?= $rs['car_rental_name'] ?>">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
            <?php }
                }
            } ?>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!-- Content -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">ข้อมูลผู้ประกอบการ</label>
                    <div class="col-sm-10 pt-2">
                        <?= $rs['car_rental_name'] ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">เบอร์โทรศัพท์</label>
                    <div class="col-sm-10 pt-2">
                        <?= $rs['phone'] ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">LINE ID</label>
                    <div class="col-sm-10 pt-2">
                        <?= $rs['line_id'] ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">อีเมล</label>
                    <div class="col-sm-10 pt-2">
                        <?= $rs['email'] ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Facebook Page</label>
                    <div class="col-sm-10 pt-2">
                        <?= $rs['facebook'] ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">เว็บไซต์</label>
                    <div class="col-sm-10 pt-2">
                        <?= $rs['website'] ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">รายละเอียดบริการ</label>
                    <div class="col-sm-10 pt-2">
                        <?= nl2br($rs['carrent_detail']) ?>
                    </div>
                </div>                
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">ตำบล</label>
                    <div class="col-sm-10 pt-2">
                        <?php 
                        $sql_subdistricts = " SELECT * FROM tbl_subdistricts WHERE id = {$rs['subdistrict_id']} ";
                        $result_subdistricts = mysqli_query($conn,$sql_subdistricts);
                        $rs_subdistricts = mysqli_fetch_assoc($result_subdistricts);
                        echo $rs_subdistricts['name_in_thai'];
                        ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">อำเภอ</label>
                    <div class="col-sm-10 pt-2">
                        <?php 
                        $sql_districts = " SELECT * FROM tbl_districts WHERE id = {$rs['district_id']} ";
                        $result_districts = mysqli_query($conn,$sql_districts);
                        $rs_districts = mysqli_fetch_assoc($result_districts);
                        echo $rs_districts['name_in_thai'];
                        ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">จังหวัด</label>
                    <div class="col-sm-10 pt-2">
                        <?php 
                        $sql_provinces = " SELECT * FROM tbl_provinces WHERE id = {$rs['province_id']} ";
                        $result_provinces = mysqli_query($conn,$sql_provinces);
                        $rs_provinces = mysqli_fetch_assoc($result_provinces);
                        echo $rs_provinces['name_in_thai'];
                        ?>
                    </div>
                </div>
                <hr>
                <!-- Content -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">ชื่อผู้ใช้</label>
                    <div class="col-sm-10 pt-2">
                        <?= $rs['username'] ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">รหัสผ่าน</label>
                    <div class="col-sm-10">
                        <div class="input-group col-lg-4 col-md-6 m-0 p-0">
                            <input type="password" class="form-control border-0" id="admin_password" name="admin_password" autocomplete="new-password" minlength="6" placeholder="กรอกรหัสผ่าน" value="<?= base64_decode($rs['password_hash']) ?>" readonly>
                            <div class="input-group-append toggle-password">
                                <i class="input-group-text far fa-eye border-0"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">วันที่บันทึก</label>
                    <div class="col-sm-10 pt-2">
                        <?= DateInThai($rs['created_at']) ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">วันที่แก้ไข</label>
                    <div class="col-sm-10 pt-2">
                        <?= DateInThai($rs['updated_at']) ?>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="?act=carrent&pg=carrent_list" class="btn btn-dark mb-2"><i class="fas fa-fast-backward"></i> ถอยกลับ</a>
            </div>
        </div>
    </div>
</div>