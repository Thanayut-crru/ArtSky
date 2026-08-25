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
        0 => 'station_id',
        1 => 'station_name',
    );

    $sql = " SELECT station_id,station_name ";
    $sql .= " FROM  tbl_station ";
    $query = mysqli_query($conn, $sql);
    $totalData = mysqli_num_rows($query);
    $totalFiltered = $totalData;

    $sql = " SELECT station_id,station_name ";
    $sql .= " FROM  tbl_station WHERE 1=1 ";
    if (!empty($requestData['search']['value'])) {
        $sql .= " AND ( station_id LIKE '%" . $requestData['search']['value'] . "%' ";
        $sql .= " OR station_name LIKE '%" . $requestData['search']['value'] . "%') ";
    }
    $query = mysqli_query($conn, $sql);
    $totalFiltered = mysqli_num_rows($query);
    $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
    $query = mysqli_query($conn, $sql);

    $data = array();
    while ($row = mysqli_fetch_array($query)) {  // preparing an array
        $id = $row['station_id'];
        $station_name = $row["station_name"];
        $nestedData = array();
        $nestedData[] = $row["station_id"];
        $nestedData[] = $row["station_name"];
        $nestedData[] = "
        <a href=\"index.php?act=station&pg=station_detail&view_id=$id\" class=\"btn btn-info\"><i class=\"fas fa-binoculars\"></i></a>
        <a href=\"index.php?act=station&pg=station_edit&edit_id=$id\" class=\"btn btn-warning\"><i class=\"fas fa-edit\"></i></a>
        <button class=\"btn btn-danger\" onclick=\"cdelte('$station_name','index.php?act=station&pg=station_delete&delete_id=$id')\"><i class=\"fas fa-trash-alt\"></i></button>
 ";
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
