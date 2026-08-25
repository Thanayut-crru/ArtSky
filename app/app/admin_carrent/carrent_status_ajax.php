<?php
include('../../config/connect.php');
include('../../config/function.php');
if ((isset($_SESSION['sess_admin_artsky']) && isset($_SESSION['sess_login_artsky'])) || (isset($_COOKIE['cookie_admin_artsky']) && isset($_COOKIE['cookie_login_artsky']))) {

    /* Connect Start */
    $id_emp          = $_SESSION['sess_admin_artsky'] ?? $_COOKIE['cookie_admin_artsky'];
    $sql_user_emp    = " SELECT * FROM tbl_admin WHERE admin_id = '$id_emp' ";
    $result_user_emp = mysqli_query($conn, $sql_user_emp);
    $num_check_emp   = mysqli_num_rows($result_user_emp);
    if ($num_check_emp == 0) {
        header('location:../logout.php');
    }
    $rs_user_emp = mysqli_fetch_assoc($result_user_emp);
      /* Connect End */

    $status_id = mysqli_real_escape_string($conn, $_GET['status']);
    $id        = mysqli_real_escape_string($conn, $_GET['id']);
    if ($status_id && $id) {
        $sql    = " UPDATE tbl_car_rental SET status_car_rental = '$status_id' WHERE car_rental_id = '$id' ";
        $result = mysqli_query($conn, $sql);
        if($result){
            echo json_encode(["msg"=>"success"]);
        }
    }
}
