<?php
ob_start();
session_start();
// remove session from variables
unset($_SESSION['sess_carrent_artsky']);
unset($_SESSION['sess_login_carrent_artsky']);
header('Location:carrent-login');
ob_end_flush();
?>