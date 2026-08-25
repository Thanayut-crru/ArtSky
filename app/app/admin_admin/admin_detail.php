<?php
if (isset($_GET['view_id'])) {
    $view_id = $_GET['view_id'];
    $sql_view = " SELECT * FROM tbl_admin WHERE admin_id = '$view_id' ";
    $result_view = mysqli_query($conn, $sql_view);
    $rs = mysqli_fetch_assoc($result_view);
    $num_view = mysqli_num_rows($result_view);
    if ($num_view == 0) {
        header('Location:index.php?act=admin&pg=admin_list');
        exit;
    }
} else {
    header('Location:index.php?act=admin&pg=admin_list');
}
?>
<div class="row">
    <div class="col-md-3">
        <div class="card card-dark">
            <div class="card-header h5 text-center">
                <?= $rs['admin_fullname'] ?>
            </div>
            <?php if ($rs['admin_image'] != '') { ?>
                <img src="../images/admin/<?= $rs['admin_image'] ?>" class="card-img-top img-fluid" alt="<?= $rs['admin_fullname'] ?>">
            <?php } else { ?>
                &nbsp;
            <?php } ?>
            <div class="card-footer">
                <div class="row">
                    <div class="col-6">
                        <a href="index.php?act=admin&pg=admin_list" class="btn btn-block btn-dark"><i class="fas fa-fast-backward"></i></a>
                    </div>
                    <div class="col-6">
                        <a href="javascript:void(0)" class="btn btn-block btn-primary" data-fancybox="single" data-src="../images/admin/<?= $rs['admin_image'] ?>" data-caption="<?= $rs['admin_fullname'] ?>">
                            <i class="fas fa-search"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-header p-2 h4">
                รายละเอียด
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active">
                        <div class="table-responsive">
                            <table class="table table-striped text-nowrap">
                                <tbody>
                                    <tr>
                                        <th>ชื่อ-นามสกุล</th>
                                        <td><?= $rs['admin_fullname'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>เบอร์โทรศัพท์</th>
                                        <td><?= $rs['admin_telephone'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>อีเมล</th>
                                        <td><?= $rs['admin_email'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>ที่อยู่</th>
                                        <td><?= nl2br($rs['admin_address']) ?></td>
                                    </tr>
                                    <tr>
                                        <th>ชื่อผู้ใช้</th>
                                        <td><?= $rs['admin_username'] ?></td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle">รหัสผ่าน</th>
                                        <td>
                                            <div class="input-group col-lg-4 col-md-6">
                                                <input type="password" class="form-control" id="admin_password" name="admin_password" autocomplete="new-password" minlength="6" placeholder="กรอกรหัสผ่าน" value="<?= base64_decode($rs['admin_password']) ?>" readonly>
                                                <div class="input-group-append toggle-password">
                                                    <i class="input-group-text far fa-eye"></i>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>สถานะ</th>
                                        <td><?= $rs['admin_status'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>ประเภท</th>
                                        <td><?= $rs['admin_type'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>วันที่บันทึก</th>
                                        <td><?= DateInThai($rs['admin_created']) ?></td>
                                    </tr>
                                    <tr>
                                        <th>วันที่แก้ไข</th>
                                        <td><?= DateInThai($rs['admin_updated']) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>