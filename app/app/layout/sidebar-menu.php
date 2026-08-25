<div class="sidebar sidebar-dark-info">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <?php
            if (isset($_GET['act'])) {
                if (($_GET['act'] == 'dashboard' && $_GET['pg'] != 'report_sales' && $_GET['pg'] != 'report_product') || $_GET['act'] == '') {
                    $dash_active = sub_active();
                }
            } else {
                $dash_active = '';
            }
            if (!isset($_GET['act']) && !isset($_GET['pg'])) {
                $dash_active = sub_active();
            }
            ?>
            <li class="nav-item">
                <a href="index.php?act=dashboard&pg=dashboard_list" class="nav-link <?= $dash_active ?>">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        ภาพรวม
                    </p>
                </a>
            </li>
            <li class="nav-header">ส่วนจัดการข้อมูล</li>
            <?php
            $station_active = '';
            if (isset($_GET['act'])) {
                if ($_GET['act'] == 'station') {
                    $station_active = 'active';
                }
            }
            ?>
            <li class="nav-item">
                <a href="index.php?act=station&pg=station_list" class="nav-link <?= $station_active ?>">
                    <i class="nav-icon fas fa-satellite-dish"></i>
                    <p>
                        สถานีตรวจอากาศ
                    </p>
                </a>
            </li>
            <?php
            $blog_active = '';
            if (isset($_GET['act'])) {
                if ($_GET['act'] == 'blog') {
                    $blog_active = 'active';
                }
            }
            ?>
            <li class="nav-item">
                <a href="index.php?act=blog&pg=blog_list" class="nav-link <?= $blog_active ?>">
                    <i class="nav-icon fab fa-blogger"></i>
                    <p>
                        บทความ
                    </p>
                </a>
            </li>

            <?php
            $news_active = '';
            if (isset($_GET['act'])) {
                if ($_GET['act'] == 'news') {
                    $news_active = 'active';
                }
            }
            ?>
            <li class="nav-item">
                <a href="index.php?act=news&pg=news_list" class="nav-link <?= $news_active ?>">
                    <i class="nav-icon far fa-newspaper"></i>
                    <p>
                        ข่าวสาร
                    </p>
                </a>
            </li>

            <?php
            $carrent_active = '';
            if (isset($_GET['act'])) {
                if ($_GET['act'] == 'carrent') {
                    $carrent_active = 'active';
                }
            }
            ?>
            <li class="nav-item">
                <a href="index.php?act=carrent&pg=carrent_list" class="nav-link <?= $carrent_active ?>">
                    <i class="nav-icon fas fa-car"></i>
                    <p>
                        รถเช่า
                    </p>
                </a>
            </li>

            <?php
            $hotel_active = '';
            if (isset($_GET['act'])) {
                if ($_GET['act'] == 'hotel') {
                    $hotel_active = 'active';
                }
            }
            ?>
            <li class="nav-item">
                <a href="index.php?act=hotel&pg=hotel_list" class="nav-link <?= $hotel_active ?>">
                    <i class="nav-icon fas fa-hotel"></i>
                    <p>
                        โรงแรม
                    </p>
                </a>
            </li>

            <li class="nav-header">ส่วนจัดการผู้ใช้</li>

            <?php
            $admin_active = '';
            if (isset($_GET['act'])) {
                if ($_GET['act'] == 'admin') {
                    $admin_active = 'active';
                }
            }
            ?>
            <li class="nav-item">
                <a href="index.php?act=admin&pg=admin_list" class="nav-link <?= $admin_active ?>">
                    <i class="nav-icon fas fa-user-lock"></i>
                    <p>
                        จัดการผู้ใช้งาน
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="javascript:;" class="nav-link" onclick="logouts('logout.php')">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    <p>
                        ออกจากระบบ
                    </p>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>