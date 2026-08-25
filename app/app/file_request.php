<?php
//----------------- GET File form module-----------------------------------
// นำเข้า folder ตัวแปร mn แทนชื่อ admin_folder(ชื่อfolder) ตัวแปร file แทนชื่อไฟล์
if (isset($_GET['act']) && isset($_GET['pg'])) {
    $file = 'admin_' . $_GET['act'] . '/' . $_GET['pg'] . '.php';
    if (file_exists($file) && isset($_GET['act']) && isset($_GET['pg'])) {
        // นำเข้าไฟล์จากตัวแปลที่รับด้านบน
        require $file;
    } elseif (file_exists($file) or !$_GET['act'] or !$_GET['pg']) {
        // หน้าเริ่มต้นเมือทำการ login เข้าสู่ระบบ
        require 'admin_dashboard/dashboard_list.php';
    } else {
        // กรุณาใส่ลิงค์ url ผิดพลาดจะเรียกหน้า 404 ขึ้นมาเพื่อแจ้งเตือน
        require '404.html';
    }
} else {
    require 'admin_dashboard/dashboard_list.php';
}
