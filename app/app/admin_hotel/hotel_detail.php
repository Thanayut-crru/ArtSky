<?php
if (isset($_GET['view_id'])) {
    $view_id = $_GET['view_id'];
    $sql = " SELECT * FROM tbl_hotel WHERE hotel_id = '$view_id' ";
    $result = mysqli_query($conn, $sql);
    $num_view = mysqli_num_rows($result);
    $rs = mysqli_fetch_assoc($result);
    if ($num_view == 0) {
        header('Location:index.php?act=hotel&pg=hotel_list');
    }
} else {
    header('Location:index.php?act=hotel&pg=hotel_list');
}
?>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <?php
            $sql_img = " SELECT * FROM tbl_hotel_image WHERE hotel_id = '$view_id' ORDER BY hotel_image_id ASC ";
            $result_img = mysqli_query($conn, $sql_img);
            $num_img = mysqli_num_rows($result_img);
            while ($rs_img = mysqli_fetch_assoc($result_img)) {
                if ($num_img > 0) {
                    if ($rs_img['hotel_image_name'] != "") { ?>
                        <div class="col-lg-2 col-md-4">
                            <div class="card card-info">
                                <img src="../images/hotel_image/<?= $rs_img['hotel_image_name'] ?>" class="card-img-top img-fluid rounded-top" style="aspect-ratio: 3 / 2; object-fit: cover;" alt="<?= $rs['hotel_name'] ?>">
                                <div class="card-footer text-right">
                                    <button type="button" class="btn btn-sm btn-primary" data-fancybox="single" data-src="../images/hotel_image/<?= $rs_img['hotel_image_name'] ?>" data-caption="<?= $rs['hotel_name'] ?>">
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
                    <label class="col-sm-2 col-form-label">ชื่อโรงแรม</label>
                    <div class="col-sm-10 pt-2">
                        <?= $rs['hotel_name'] ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">พิกัดละติจูด</label>
                    <div class="col-sm-10 pt-2">
                        <?= $rs['hotel_lat'] ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">พิกัดลองจิจูด</label>
                    <div class="col-sm-10 pt-2">
                        <?= $rs['hotel_lon'] ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">ราคา/คืน</label>
                    <div class="col-sm-10 pt-2">
                        <?= number_format($rs['hotel_price'],2) ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">เบอร์โทรศัพท์</label>
                    <div class="col-sm-10 pt-2">
                        <?= $rs['hotel_telephone'] ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">ไลน์</label>
                    <div class="col-sm-10 pt-2">
                        <?= $rs['hotel_line'] ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">อีเมล</label>
                    <div class="col-sm-10 pt-2">
                        <?= $rs['hotel_email'] ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Facebook</label>
                    <div class="col-sm-10 pt-2">
                        <?= $rs['hotel_facebook'] ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">เว็บไซต์</label>
                    <div class="col-sm-10 pt-2">
                        <?= $rs['hotel_website'] ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">วันที่ลงทะเบียน</label>
                    <div class="col-sm-10 pt-2">
                        <?= DateInThai($rs['hotel_created']) ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">วันที่อัปเดตข้อมูล</label>
                    <div class="col-sm-10 pt-2">
                        <?= DateInThai($rs['hotel_updated']) ?>
                    </div>
                </div>
                <hr>
                <!-- Content -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">ชื่อผู้ใช้</label>
                    <div class="col-sm-10 pt-2">
                        <?= $rs['hotel_user'] ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">รหัสผ่าน</label>
                    <div class="col-sm-10">
                        <div class="input-group col-lg-4 col-md-6 m-0 p-0">
                            <input type="password" class="form-control" id="admin_password" name="admin_password" autocomplete="new-password" minlength="6" placeholder="กรอกรหัสผ่าน" value="<?= base64_decode($rs['hotel_password']) ?>" readonly>
                            <div class="input-group-append toggle-password">
                                <i class="input-group-text far fa-eye"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="?act=hotel&pg=hotel_list" class="btn btn-dark mb-2"><i class="fas fa-fast-backward"></i> ถอยกลับ</a>
            </div>
        </div>
    </div>
</div>