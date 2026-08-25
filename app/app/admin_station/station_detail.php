<?php
if (isset($_GET['view_id'])) {
    $view_id     = $_GET['view_id'];
    $sql_view    = " SELECT * FROM tbl_station WHERE station_id = '$view_id' ";
    $result_view = mysqli_query($conn, $sql_view);
    $num_view    = mysqli_num_rows($result_view);
    $rs_view     = mysqli_fetch_assoc($result_view);
    if ($num_view == 0) {
        header('Location:index.php?act=station&pg=station_list');
    }
} else {
    header('Location:index.php?act=station&pg=station_list');
}
?>
<div class="col-md-12">
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-satellite-dish"></i> รายละเอียด ART SKY</h3>
        </div>
        <div class="card-body">
            <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="station_image">รูปภาพ</label>
                    <?php if ($rs_view['station_image'] == "") { ?>
                        <div class="col-md-4">
                            <i class="fas fa-satellite-dish fa-8x"></i>
                        </div>
                    <?php } else { ?>
                        <div class="col-md-4">
                            <div class="card card-info">
                                <img src="../images/station_image/<?= $rs_view['station_image'] ?>" class="card-img-top img-fluid rounded" alt="<?= $rs_view['station_name'] ?>">
                                <div class="card-footer">
                                    <button type="button" class="btn btn-primary" data-fancybox="single" data-src="../images/station_image/<?= $rs_view['station_image'] ?>" data-caption="<?= $rs_view['station_name'] ?>">
                                        <i class="fas fa-search"></i>
                                    </button>                                    
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="form-group row">
                    <label for="station_name" class="col-sm-2 col-form-label">ชื่อสถานี</label>
                    <div class="col-sm-10 pt-2">
                        <?= $rs_view['station_name'] ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="station_latitude" class="col-sm-2 col-form-label">Latitude (ละติจูด)</label>
                    <div class="col-sm-10 pt-2">
                        <?= $rs_view['station_lat'] ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="station_longitude" class="col-sm-2 col-form-label">Longitude (ลองจิจูด)</label>
                    <div class="col-sm-10 pt-2">
                        <?= $rs_view['station_long'] ?>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                        <a href="index.php?act=station&pg=station_list" class="btn btn-dark"><i class="fas fa-fast-backward"></i> ถอยกลับ</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>