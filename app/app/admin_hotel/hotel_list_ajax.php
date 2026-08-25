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

    /* Table Start */
    $requestData = $_REQUEST;

    $columns = array(
        0 => 'hotel_id',
        1 => 'hotel_name',
        2 => 'hotel_price'
    );

    $sql = " SELECT hotel_id,hotel_name,hotel_price ";
    $sql .= " FROM tbl_hotel ";
    $query = mysqli_query($conn, $sql);
    $totalData = mysqli_num_rows($query);
    $totalFiltered = $totalData;

    $sql = " SELECT hotel_id,hotel_name,hotel_price,hotel_status ";
    $sql .= " FROM tbl_hotel WHERE 1=1 ";
    if (!empty($requestData['search']['value'])) {
        $sql .= " AND ( hotel_id LIKE '%" . $requestData['search']['value'] . "%' ";
        $sql .= " OR hotel_name LIKE '%" . $requestData['search']['value'] . "%' ";
        $sql .= " OR hotel_price LIKE '%" . $requestData['search']['value'] . "%') ";
    }
    $query = mysqli_query($conn, $sql);
    $totalFiltered = mysqli_num_rows($query);
    $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
    $query = mysqli_query($conn, $sql);
    $no = 1;
    $data = array();
    $st_ht = '';
    while ($row = mysqli_fetch_array($query)) {  // preparing an array
        if($row['hotel_status'] == 'Yes'){
            $st_ht = 'checked';
            $st_ht2 = 'อนุมัติ';
        }
        if($row['hotel_status'] == 'No'){
            $st_ht = '';
            $st_ht2 = 'รออนุมัติ';
        }
        $id = $row['hotel_id'];
        $hotel_name = $row["hotel_name"];

        $sql_img = " SELECT tbl_hotel_image.hotel_image_name FROM tbl_hotel_image 
        WHERE tbl_hotel_image.hotel_id = '$id' ORDER BY tbl_hotel_image.hotel_image_id ASC LIMIT 1 ";
        $result_img = mysqli_query($conn, $sql_img);
        $rs_img = mysqli_fetch_assoc($result_img);
        $pr1 = "customSwitch3_$no";
        $pr2 = "nameSwitch3_$no";
        $pr3 = $row['hotel_id'];
        $nestedData = array();
        $nestedData[] = $no;
        $nestedData[] = "
        <img src=\"../images/hotel_image/{$rs_img['hotel_image_name']}\" class=\"img-fluid rounded-circle\" width=\"50\" style=\"aspect-ratio: 1 / 1;object-fit:cover\" alt=\"{$row['hotel_name']}\">
        <a href=\"javascript:void(0)\" class=\"badge bg-secondary\" data-fancybox=\"single\" data-src=\"../images/hotel_image/{$rs_img['hotel_image_name']}\" data-caption=\"{$row['hotel_name']}\">
            <i class=\"fas fa-search\"></i>
        </a>";
        $nestedData[] = $row["hotel_name"];
        $nestedData[] = number_format($row["hotel_price"],2); 
        $nestedData[] = "<div class=\"custom-control custom-switch custom-switch-off-warning custom-switch-on-success\">
        <input type=\"checkbox\" class=\"custom-control-input\" id=\"customSwitch3_$no\" onchange=\"appChange('$pr1','$pr2','$pr3')\" $st_ht>
        <label class=\"custom-control-label\" for=\"customSwitch3_$no\" id=\"nameSwitch3_$no\">$st_ht2</label></div>";
        $nestedData[] = "
        <a href=\"index.php?act=hotel&pg=hotel_detail&view_id=$id\" class=\"btn btn-info\"><i class=\"fas fa-binoculars\"></i></a>
        <a href=\"index.php?act=hotel&pg=hotel_edit&edit_id=$id\" class=\"btn btn-warning\"><i class=\"fas fa-edit\"></i></a>
        <button class=\"btn btn-danger\" onclick=\"cdelte('$hotel_name','index.php?act=hotel&pg=hotel_delete&delete_id=$id')\"><i class=\"fas fa-trash-alt\"></i></button>
 ";
        $no++;
        $data[] = $nestedData;
    }

    $json_data = array(
        "draw" => intval($requestData['draw']),
        "recordsTotal" => intval($totalData),  // total number of records
        "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
        "data"            => $data   // total data array
    );

    echo json_encode($json_data);  // send data as json format
    /* Table End */
} else {
    header('location:../login.php');
}
