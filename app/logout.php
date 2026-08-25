<?php
ob_start();
session_start();
// remove session from variables
unset($_SESSION['sess_ht_artsky']);
unset($_SESSION['sess_login_artsky_ht']);
header('Location:login');
ob_end_flush();
?>