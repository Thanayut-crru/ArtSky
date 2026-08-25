<?php
include('./config/connect.php');
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
