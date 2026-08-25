<?php
ob_start();
session_start();
// remove session from variables
unset($_SESSION['sess_admin_artsky']);
unset($_SESSION['sess_login_artsky']);
// remove all sesion
// session_destroy();
unset($_COOKIE['cookie_admin_artsky']);
setcookie('cookie_admin_artsky', '', time() - 525600);
unset($_COOKIE['cookie_login_artsky']);
setcookie('cookie_login_artsky', '', time() - 525600);

header('Location:login.php');
ob_end_flush();
?>