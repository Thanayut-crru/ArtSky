<?php
// Session start and Connect database
include('../../config/connect.php');
/*ดรวจสอบ sesion user_admin ไม่เท่ากับค่าว่าง และ status_login มีค่าเท่ากับ ture (1) 
สามารถ login เข้าสู่ระบบได้อย่างถูกต้อง ไม่เข้าเงื่อนไขจะส่งกลับไปหน้า login.php */
if (isset($_SESSION['sess_admin_artsky']) && isset($_SESSION['sess_login_artsky'])) {
} elseif (isset($_COOKIE['cookie_admin_artsky']) && isset($_COOKIE['cookie_login_artsky'])) {
} else {
    header('location:../login.php');
}

$src = $_POST['src'];
$file_name = str_replace($base_urls . '/admin_app/admin_uploads/images/', '', $src); // striping host to get relative path
$del_name = "images/" . $file_name;
if (unlink($del_name)) {
    echo 'File Delete Successfully';
}
