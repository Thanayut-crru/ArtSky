<?php
if (isset($_GET['view_id'])) {
    $id_view = $_GET['view_id'];
    $sql_view = " SELECT * FROM tbl_blog WHERE blog_id = '$id_view' ";
    $result_view = mysqli_query($conn, $sql_view);
    $rs_view = mysqli_fetch_assoc($result_view);
    $num_view = mysqli_num_rows($result_view);
    if ($num_view == 0) {
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
            <div class="card-body">

                <div class="row">
                    <div class="col-md-10 mb-3 h4 text-center">
                        <?= $rs_view['blog_name'] ?>
                    </div>
                    <div class="col-md-2 mb-3">
                        <?= DateThais($rs_view['blog_date']) ?>
                    </div>
                    <div class="col-md-12">
                            <?php if ($rs_view['blog_image'] != "") { ?>
                                <div class="col-md-6 mx-auto">
                                    <div class="card card-info">
                                        <img src="../images/blog/<?= $rs_view['blog_image'] ?>" class="card-img-top img-fluid rounded" alt="<?= $rs_view['blog_name'] ?>">
                                        <div class="card-footer">
                                            <button type="button" class="btn btn-primary" data-fancybox="single" data-src="../images/blog/<?= $rs_view['blog_image'] ?>" data-caption="<?= $rs_view['blog_name'] ?>">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="col-md-6 mx-auto">
                                    <i class="fab fa-blogger fa-10x"></i>
                                </div>
                            <?php } ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="blog_telephone">รายละเอียด</label>
                            <textarea class="form-control summernote" name="blog_detail" id="blog_detail" rows="10" placeholder="รายละเอียด"><?= $rs_view['blog_detail'] ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 mx-auto">
                        <a href="?act=blog&pg=blog_list" class="btn btn-block btn-dark mb-2"><i class="fas fa-fast-backward"></i> ถอยกลับ</a>
                    </div>
                </div>
            </div>
    </div>
</div>