<?php
include('../../config/connect.php');
include('../../config/function.php');
if ((isset($_SESSION['sess_admin_artsky']) && isset($_SESSION['sess_login_artsky'])) || (isset($_COOKIE['cookie_admin_artsky']) && isset($_COOKIE['cookie_login_artsky']))) {

    // Support either `tbl_news` or `news` as table name
    $news_table = 'tbl_news';
    try {
        $probe = mysqli_query($conn, "SELECT 1 FROM tbl_news LIMIT 1");
        if ($probe === false) {
            $news_table = 'tbl_news';
        }
    } catch (Throwable $e) {
        $news_table = 'tbl_news';
    }

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
        0 => 'news_id',
        1 => 'news_name',
        2 => 'news_detail',
        3 => 'news_date',
    );

    $draw = intval($requestData['draw'] ?? 0);
    $start = intval($requestData['start'] ?? 0);
    $length = intval($requestData['length'] ?? 10);

    $data = array();
    $totalData = 0;
    $totalFiltered = 0;

    try {
        $sqlCount = "SELECT n.news_id FROM {$news_table} n";
        $qCount = mysqli_query($conn, $sqlCount);
        if ($qCount !== false) {
            $totalData = mysqli_num_rows($qCount);
        }
        $totalFiltered = $totalData;

        $sql = " SELECT n.news_id,n.station_id,n.news_name,n.news_detail,n.news_date,n.news_image,s.station_name ";
        $sql .= " FROM {$news_table} n LEFT JOIN tbl_station s ON n.station_id = s.station_id WHERE 1=1 ";
        if (!empty($requestData['search']['value'])) {
            $sv = $requestData['search']['value'];
            $sql .= " AND ( n.news_id LIKE '%" . $sv . "%' ";
            $sql .= " OR n.news_name LIKE '%" . $sv . "%' ";
            $sql .= " OR n.news_detail LIKE '%" . $sv . "%' ";
            $sql .= " OR n.news_date LIKE '%" . $sv . "%' ";
            $sql .= " OR s.station_name LIKE '%" . $sv . "%' ";
            $sql .= " OR n.station_id LIKE '%" . $sv . "%') ";
        }

        $qFilter = mysqli_query($conn, $sql);
        if ($qFilter !== false) {
            $totalFiltered = mysqli_num_rows($qFilter);
        }

        $orderCol = $columns[$requestData['order'][0]['column']] ?? 'news_id';
        $orderDir = $requestData['order'][0]['dir'] ?? 'asc';

        $sql .= " ORDER BY " . $orderCol . "   " . $orderDir . "  LIMIT " . $start . " ," . $length . "   ";
        $query = mysqli_query($conn, $sql);

        $no = 1;
        while ($query !== false && ($row = mysqli_fetch_array($query))) {
            $id = $row['news_id'];
            $news_name = $row['news_name'];
            $station_name = $row['station_name'] ?? '';
            $news_image = $row['news_image'] ?? '';

            $nestedData = array();
            $nestedData[] = $no;

            if ($news_image != '') {
                $nestedData[] = "
                <img src=\"../images/news/{$news_image}\" class=\"art-sky-img img-fluid col-6\" alt=\"{$news_name}\">
                <a href=\"javascript:void(0)\" class=\"badge bg-secondary\" data-fancybox=\"single\" data-src=\"../images/news/{$news_image}\" data-caption=\"{$news_name}\">
                    <i class=\"fas fa-search\"></i>
                </a>";
            } else {
                $nestedData[] = "<span class=\"text-muted\">-</span>";
            }

            $nestedData[] = $station_name != ''
                ? $news_name . "<div class=\"text-muted small\">สถานี: {$station_name}</div>"
                : $news_name;

            $nestedData[] = DateThais($row['news_date']);

            $nestedData[] = "
            <a href=\"index.php?act=news&pg=news_detail&view_id=$id\" class=\"btn btn-info\"><i class=\"fas fa-binoculars\"></i></a>
            <a href=\"index.php?act=news&pg=news_edit&edit_id=$id\" class=\"btn btn-warning\"><i class=\"fas fa-edit\"></i></a>
            <button class=\"btn btn-danger\" onclick=\"cdelte('$news_name','index.php?act=news&pg=news_delete&delete_id=$id')\"><i class=\"fas fa-trash-alt\"></i></button>
            ";

            $no++;
            $data[] = $nestedData;
        }

        $json_data = array(
            "draw" => $draw,
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    } catch (Throwable $e) {
        echo json_encode(array(
            "draw" => $draw,
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => array(),
            "error" => "News AJAX error: " . $e->getMessage()
        ));
    }
    /* Table End */
} else {
    header('location:../login.php');
}
