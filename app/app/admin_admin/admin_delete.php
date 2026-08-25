<?php
if (isset($_GET['delete_id'])) {
    $id_del_mt = $_GET['delete_id'];

    $sql_del_img = " SELECT * FROM tbl_admin WHERE admin_id = '$id_del_mt' ";
    $result_del_img = mysqli_query($conn, $sql_del_img);
    $rs_del_img = mysqli_fetch_assoc($result_del_img);

    $fileupload1 = $rs_del_img['admin_image'];
    if ($fileupload1 != "") {
        unlink("../images/admin/$fileupload1");
    }

    $sql_dl = " DELETE FROM tbl_admin WHERE admin_id = '$id_del_mt' ";
    $result_dl = mysqli_query($conn, $sql_dl);

    if ($result_dl) {
        header("Location:index.php?act=admin&pg=admin_list");
    }
} else {
    header("Location:index.php?act=admin&pg=admin_list");
}
