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

if ($_FILES['image']['name']) {
    if (!$_FILES['image']['error']) {
        $name = md5(rand(100, 200));
        $ext = explode('.', $_FILES['image']['name']);
        $filename = $name . '.' . strtolower(end($ext));
        $destination = "images/$filename"; //change this directory
        $location = $_FILES["image"]["tmp_name"];
        move_uploaded_file($location, $destination);
        echo  "images/$filename"; //change this URL
    } else {
        echo  $message = 'Ooops!  Your upload triggered the following error:  ' . $_FILES['image']['error'];
    }
}
