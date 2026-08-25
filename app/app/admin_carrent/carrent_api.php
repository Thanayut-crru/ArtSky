<?php
include('../../config/connect.php');
include('../../config/function.php');
if ((isset($_SESSION['sess_admin_artsky']) && isset($_SESSION['sess_login_artsky'])) || (isset($_COOKIE['cookie_admin_artsky']) && isset($_COOKIE['cookie_login_artsky']))) {

    /* Connect Start */
    $id_emp = $_SESSION['sess_admin_artsky'] ?? $_COOKIE['cookie_admin_artsky'];
    $sql_user_emp = " SELECT * FROM tbl_admin WHERE admin_id = '$id_emp' ";
    $result_user_emp = mysqli_query($conn, $sql_user_emp);
    $num_check_emp = mysqli_num_rows($result_user_emp);
    if ($num_check_emp == 0) {
        header('location:../logout.php');
    }
    $rs_user_emp = mysqli_fetch_assoc($result_user_emp);
    /* Connect End */
    $pid = $_GET['pid'] ?? '';
    if ($pid !== '') {
        $province_array = [];
        $stmt = $conn->prepare("SELECT tbl_districts.id,tbl_districts.name_in_thai FROM tbl_provinces INNER JOIN tbl_districts
        ON tbl_provinces.id = tbl_districts.province_id
        WHERE tbl_provinces.id = ? ORDER BY CONVERT(tbl_districts.name_in_thai USING tis620) ASC");
        $stmt->bind_param("i", $pid);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($rs_pv = $result->fetch_assoc()) {
            $province_array[] = [
                "id" => $rs_pv['id'],
                "name_in_thai" => $rs_pv['name_in_thai'],
            ];
        }
        echo json_encode($province_array, JSON_UNESCAPED_UNICODE);
    }

    $did = $_GET['did'] ?? '';
    if ($did !== '') {
        $district_array = [];
        $stmt = $conn->prepare("SELECT tbl_subdistricts.id,tbl_subdistricts.name_in_thai FROM tbl_districts 
        INNER JOIN tbl_subdistricts
        ON tbl_subdistricts.district_id = tbl_districts.id
        WHERE tbl_districts.id = ?
        ORDER BY CONVERT(tbl_subdistricts.name_in_thai USING tis620) ASC");
        $stmt->bind_param("i", $did);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($rs_pv = $result->fetch_assoc()) {
            $district_array[] = [
                "id" => $rs_pv['id'],
                "name_in_thai" => $rs_pv['name_in_thai'],
            ];
        }
        echo json_encode($district_array, JSON_UNESCAPED_UNICODE);
    }
} else {
    header('location:../login.php');
}
