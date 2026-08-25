<div class="container-fluid">
    <div class="row">
        <?php
        $sql_station = " SELECT * FROM tbl_station ";
        $result_station = mysqli_query($conn, $sql_station);
        $num_station = mysqli_num_rows($result_station);
        ?>
        <div class="col-lg-4 col-md-6">
            <div class="small-box bg-lightblue">
                <div class="inner">
                    <span class="description-percentage">&nbsp;</span>
                    <h5 class="description-header"><?= number_format($num_station) ?></h5>
                    <span class="description-text">สถานีตรวจอากาศ</span>
                </div>
                <div class="icon">
                    <i class="fas fa-satellite-dish"></i>
                </div>
                <a href="?act=station&pg=station_list" class="small-box-footer">ดูเพิ่มเติม <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <?php
        $sql_blog = " SELECT * FROM tbl_blog ";
        $result_blog = mysqli_query($conn, $sql_blog);
        $num_blog = mysqli_num_rows($result_blog);
        ?>
        <div class="col-lg-4 col-md-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <span class="description-percentage">&nbsp;</span>
                    <h5 class="description-header"><?= number_format($num_blog) ?></h5>
                    <span class="description-text">บทความ</span>
                </div>
                <div class="icon">
                    <i class="fab fa-blogger"></i>
                </div>
                <a href="?act=blog&pg=blog_list" class="small-box-footer">ดูเพิ่มเติม <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <?php
        $sql_carrent = " SELECT * FROM tbl_car_rental ";
        $result_carrent = mysqli_query($conn, $sql_carrent);
        $num_carrent = mysqli_num_rows($result_carrent);
        ?>
        <div class="col-lg-4 col-md-6">
            <div class="small-box bg-gradient-dark">
                <div class="inner">
                    <span class="description-percentage">&nbsp;</span>
                    <h5 class="description-header"><?= number_format($num_carrent) ?></h5>
                    <span class="description-text">รถเช่า</span>
                </div>
                <div class="icon">
                    <i class="nav-icon fas fa-car"></i>
                </div>
                <a href="?act=carrent&pg=carrent_list" class="small-box-footer text-light">ดูเพิ่มเติม <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <?php
        $sql_hotel = " SELECT * FROM tbl_hotel ";
        $result_hotel = mysqli_query($conn, $sql_hotel);
        $num_hotel = mysqli_num_rows($result_hotel);
        ?>
        <div class="col-lg-4 col-md-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <span class="description-percentage">&nbsp;</span>
                    <h5 class="description-header"><?= number_format($num_hotel) ?></h5>
                    <span class="description-text">โรงแรม</span>
                </div>
                <div class="icon">
                    <i class="fas fa-hotel"></i>
                </div>
                <a href="?act=hotel&pg=hotel_list" class="small-box-footer">ดูเพิ่มเติม <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <?php
        $sql_admin = " SELECT * FROM tbl_admin ";
        $result_admin = mysqli_query($conn, $sql_admin);
        $num_admin = mysqli_num_rows($result_admin);
        ?>
        <div class="col-lg-4 col-md-6">
            <div class="small-box bg-light">
                <div class="inner">
                    <span class="description-percentage">&nbsp;</span>
                    <h5 class="description-header"><?= number_format($num_admin) ?></h5>
                    <span class="description-text">ผู้ใช้งาน</span>
                </div>
                <div class="icon">
                    <i class="fas fa-user-lock"></i>
                </div>
                <a href="?act=admin&pg=admin_list" class="small-box-footer">ดูเพิ่มเติม <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
</div>