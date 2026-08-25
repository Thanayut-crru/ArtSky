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
        0 => 'blog_id',
        1 => 'blog_name',
        2 => 'blog_detail',
        3 => 'blog_date',
    );

    $sql = " SELECT blog_id,blog_name,blog_detail,blog_date ";
    $sql .= " FROM  tbl_blog ";
    $query = mysqli_query($conn, $sql);
    $totalData = mysqli_num_rows($query);
    $totalFiltered = $totalData;

    $sql = " SELECT blog_id,blog_name,blog_detail,blog_date,blog_image ";
    $sql .= " FROM  tbl_blog WHERE 1=1 ";
    if (!empty($requestData['search']['value'])) {
        $sql .= " AND ( blog_id LIKE '%" . $requestData['search']['value'] . "%' ";
        $sql .= " OR blog_name LIKE '%" . $requestData['search']['value'] . "%' ";
        $sql .= " OR blog_detail LIKE '%" . $requestData['search']['value'] . "%' ";
        $sql .= " OR blog_date LIKE '%" . $requestData['search']['value'] . "%') ";
    }
    $query = mysqli_query($conn, $sql);
    $totalFiltered = mysqli_num_rows($query);
    $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
    $query = mysqli_query($conn, $sql);
    $no = 1;
    $data = array();
    while ($row = mysqli_fetch_array($query)) {  // preparing an array
        $id = $row['blog_id'];
        $blog_name = $row["blog_name"];
        $nestedData = array();
        $nestedData[] = $no;
        $nestedData[] = "
        <img src=\"../images/blog/{$row['blog_image']}\" class=\"art-sky-img img-fluid col-6\" alt=\"{$row['blog_name']}\">
        <a href=\"javascript:void(0)\" class=\"badge bg-secondary\" data-fancybox=\"single\" data-src=\"../images/blog/{$row['blog_image']}\" data-caption=\"{$row['blog_name']}\">
            <i class=\"fas fa-search\"></i>
        </a>";
        $nestedData[] = $row["blog_name"];
        $nestedData[] = DateThais($row["blog_date"]);
        $nestedData[] = "
        <a href=\"index.php?act=blog&pg=blog_detail&view_id=$id\" class=\"btn btn-info\"><i class=\"fas fa-binoculars\"></i></a>
        <a href=\"index.php?act=blog&pg=blog_edit&edit_id=$id\" class=\"btn btn-warning\"><i class=\"fas fa-edit\"></i></a>
        <button class=\"btn btn-danger\" onclick=\"cdelte('$blog_name','index.php?act=blog&pg=blog_delete&delete_id=$id')\"><i class=\"fas fa-trash-alt\"></i></button>
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
