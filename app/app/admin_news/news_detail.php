<?php
if (isset($_GET['view_id'])) {
    $id_view = $_GET['view_id'];

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

    $sql_view = " SELECT n.*, s.station_name FROM {$news_table} n LEFT JOIN tbl_station s ON n.station_id = s.station_id WHERE n.news_id = '$id_view' ";
    $result_view = mysqli_query($conn, $sql_view);
    $rs_view = mysqli_fetch_assoc($result_view);
    $num_view = mysqli_num_rows($result_view);
    if ($num_view == 0) {
        header('Location:?act=news&pg=news_list');
    }
} else {
    header('Location:?act=news&pg=news_list');
}

?>
<div class="col-md-12">
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title"><i class="nav-icon fab fa-blogger"></i> รายละเอียดข่าวสาร</h3>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-md-10 mb-3 h4 text-center">
                    <?= $rs_view['news_name'] ?>
                    <?php if (!empty($rs_view['station_name'])) { ?>
                        <div class="text-muted small">สถานี: <?= $rs_view['station_name'] ?></div>
                    <?php } ?>
                </div>
                <div class="col-md-2 mb-3">
                    <?= DateThais($rs_view['news_date']) ?>
                </div>
                <div class="col-md-12">
                    <?php if ($rs_view['news_image'] != "") { ?>
                        <div class="col-md-6 mx-auto">
                            <div class="card card-info">
                                <img src="../images/news/<?= $rs_view['news_image'] ?>" class="card-img-top img-fluid rounded" alt="<?= $rs_view['news_name'] ?>">
                                <div class="card-footer">
                                    <button type="button" class="btn btn-primary" data-fancybox="single" data-src="../images/news/<?= $rs_view['news_image'] ?>" data-caption="<?= $rs_view['news_name'] ?>">
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
                        <label for="news_detail">รายละเอียด</label>
                        <textarea class="form-control summernote" name="news_detail" id="news_detail" rows="10" placeholder="รายละเอียด"><?= $rs_view['news_detail'] ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 mx-auto">
                    <a href="?act=news&pg=news_list" class="btn btn-block btn-dark mb-2"><i class="fas fa-fast-backward"></i> ถอยกลับ</a>
                </div>
            </div>
        </div>
    </div>
</div>
