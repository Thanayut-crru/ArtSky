<?php
/* ตัวอย่าง หัวข้อคอนเทน
ภาพรวม          หน้าหลัก/ภาพรวม/จัดการภาพรวม 
ด้วยการใช้ funciton topicName , topicName2, topicSecond ตามลำดับ
*/

function topicName($files)
{
    switch ($files) {
        case '':
            $file = 'ภาพรวม';
            break;
        case 'dashboard':
            $file = 'ภาพรวม';
            break;
        case 'admin':
            $file = 'จัดการผู้ใช้งาน';
            break;
        case 'station':
            $file = 'จัดการข้อมูลสถานีตรวจอากาศ';
            break;
        case 'blog':
            $file = 'จัดการข้อมูลบทความ';
            break;
        case 'news':
            $file = 'จัดการข้อมูลข่าวสาร';
            break;
        case 'hotel':
            $file = 'จัดการข้อมูลโรงแรม';
            break;
        case 'carrent':
            $file = 'จัดการข้อมูลรถเช่า';
            break;
        default:
            $file = '';
            break;
    }
    return $file;
}


function topicName2($files2)
{
    $mn = $files2; // ชื่อไฟล์เริ่มต้น เช่น index.php?act=dashboard&pg=dash_list ค่าที่ได้คือ act=dashboard
    $mn2 = $files2 . '_list'; // ไฟล์เริ่มต้นในโฟลเดอร์แรก เช่น admin_dashboard ไฟล์เริ่มต้น dah_list.php
    switch ($files2) {
        case '':
            $mn = "<li class=\"breadcrumb-item\"><a href=\"?act=dashboard&pg=dashboard_list\">ภาพรวม</a></li>";
            break;
        case 'dashboard':
            $mn = "<li class=\"breadcrumb-item\"><a href=\"?act=$mn&pg=$mn2\">ภาพรวม</a></li>";
            break;
        case 'admin':
            $mn = "<li class=\"breadcrumb-item\"><a href=\"?act=$mn&pg=$mn2\">ข้อมูลผู้ใช้งาน</a></li>";
            break;
        case 'station':
            $mn = "<li class=\"breadcrumb-item\"><a href=\"?act=$mn&pg=$mn2\">ข้อมูลสถานีตรวจอากาศ</a></li>";
            break;
        case 'blog':
            $mn = "<li class=\"breadcrumb-item\"><a href=\"?act=$mn&pg=$mn2\">ข้อมูลบทความ</a></li>";
            break;
        case 'news':
            $mn = "<li class=\"breadcrumb-item\"><a href=\"?act=$mn&pg=$mn2\">ข้อมูลข่าวสาร</a></li>";
            break;
        case 'hotel':
            $mn = "<li class=\"breadcrumb-item\"><a href=\"?act=$mn&pg=$mn2\">ข้อมูลโรงแรม</a></li>";
            break;
        case 'carrent':
            $mn = "<li class=\"breadcrumb-item\"><a href=\"?act=$mn&pg=$mn2\">ข้อมูลรถเช่า</a></li>";
            break;
    }
    return $mn;
}

function topicSecond($topiclast)
{
    $file = $topiclast;
    switch ($file) {
        case '':
            $file = "<li class=\"breadcrumb-item active\">ภาพรวมทั้งหมด</li>";
            break;
        case 'dashboard_list':
            $file = "<li class=\"breadcrumb-item active\">ภาพรวมทั้งหมด</li>";
            break;
        case 'admin_add':
            $file = "<li class=\"breadcrumb-item active\">เพิ่มข้อมูล</li>";
            break;
        case 'admin_list':
            $file = "<li class=\"breadcrumb-item active\">รายการ</li>";
            break;
        case 'admin_edit':
            $file = "<li class=\"breadcrumb-item active\">แก้ไข</li>";
            break;
        case 'admin_detail':
            $file = "<li class=\"breadcrumb-item active\">รายละเอียด</li>";
            break;
        case 'station_list':
            $file = "<li class=\"breadcrumb-item active\">รายการ</li>";
            break;
        case 'station_add':
            $file = "<li class=\"breadcrumb-item active\">เพิ่มข้อมูล</li>";
            break;
        case 'station_edit':
            $file = "<li class=\"breadcrumb-item active\">แก้ไขข้อมูล</li>";
            break;
        case 'station_detail':
            $file = "<li class=\"breadcrumb-item active\">รายละเอียดข้อมูล</li>";
            break;
        case 'station_delete':
            $file = "<li class=\"breadcrumb-item active\">ลบข้อมูล</li>";
            break;

        case 'blog_list':
            $file = "<li class=\"breadcrumb-item active\">รายการ</li>";
            break;
        case 'blog_add':
            $file = "<li class=\"breadcrumb-item active\">เพิ่มข้อมูล</li>";
            break;
        case 'blog_edit':
            $file = "<li class=\"breadcrumb-item active\">แก้ไขข้อมูล</li>";
            break;
        case 'blog_detail':
            $file = "<li class=\"breadcrumb-item active\">รายละเอียดข้อมูล</li>";
            break;
        case 'blog_delete':
            $file = "<li class=\"breadcrumb-item active\">ลบข้อมูล</li>";
            break;

        case 'news_list':
            $file = "<li class=\"breadcrumb-item active\">รายการ</li>";
            break;
        case 'news_add':
            $file = "<li class=\"breadcrumb-item active\">เพิ่มข้อมูล</li>";
            break;
        case 'news_edit':
            $file = "<li class=\"breadcrumb-item active\">แก้ไขข้อมูล</li>";
            break;
        case 'news_detail':
            $file = "<li class=\"breadcrumb-item active\">รายละเอียดข้อมูล</li>";
            break;
        case 'news_delete':
            $file = "<li class=\"breadcrumb-item active\">ลบข้อมูล</li>";
            break;

        case 'hotel_list':
            $file = "<li class=\"breadcrumb-item active\">รายการ</li>";
            break;
        case 'hotel_add':
            $file = "<li class=\"breadcrumb-item active\">เพิ่มข้อมูล</li>";
            break;
        case 'hotel_edit':
            $file = "<li class=\"breadcrumb-item active\">แก้ไขข้อมูล</li>";
            break;
        case 'hotel_detail':
            $file = "<li class=\"breadcrumb-item active\">รายละเอียดข้อมูล</li>";
            break;
        case 'hotel_delete':
            $file = "<li class=\"breadcrumb-item active\">ลบข้อมูล</li>";
            break;

        case 'carrent_list':
            $file = "<li class=\"breadcrumb-item active\">รายการ</li>";
            break;
        case 'carrent_add':
            $file = "<li class=\"breadcrumb-item active\">เพิ่มข้อมูล</li>";
            break;
        case 'carrent_edit':
            $file = "<li class=\"breadcrumb-item active\">แก้ไขข้อมูล</li>";
            break;
        case 'carrent_detail':
            $file = "<li class=\"breadcrumb-item active\">รายละเอียดข้อมูล</li>";
            break;
        case 'carrent_delete':
            $file = "<li class=\"breadcrumb-item active\">ลบข้อมูล</li>";
            break;
    }
    return $file;
}
?>
<?php
if (isset($_GET['act']) && isset($_GET['pg'])) {
?>
    <div class="col-sm-6">
        <h1><?= topicName($_GET['act']) ?></h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php"><i class="fas fa-home"></i> หน้าหลัก</a></li>
            <?php
            // ตรวจสอบไฟล์ที่นำเข้ามีอยู่จริงไหม ถ้าไม่มีไม่แสดงผล
            $file = 'admin_' . $_GET['act'] . '/' . $_GET['pg'] . '.php';
            if (file_exists($file) or ($_GET['act'] == "" && $_GET['act'] == "")) {
                echo topicName2($_GET['act']);
                echo topicSecond($_GET['pg']);
            }
            ?>
        </ol>
    </div>
<?php } else { ?>
    <div class="col-sm-6">
        <h1><?= topicName('') ?></h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php"><i class="fas fa-home"></i> หน้าหลัก</a></li>
            <?php
            echo topicName2('');
            echo topicSecond('');
            ?>
        </ol>
    </div>
<?php } ?>