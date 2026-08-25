<?php
if (isset($_GET['delete_id'])) {
    $id_del_mt = $_GET['delete_id'];

    $sql_del_img = " SELECT * FROM tbl_blog WHERE blog_id = '$id_del_mt' ";
    $result_del_img = mysqli_query($conn, $sql_del_img);
    $rs_del_img = mysqli_fetch_assoc($result_del_img);

    $fileupload1 = $rs_del_img['blog_image'];
    if ($fileupload1 != "") {
        unlink("../images/blog/$fileupload1");
    }

    $sql_dl = " DELETE FROM tbl_blog WHERE blog_id = '$id_del_mt' ";
    $result_dl = mysqli_query($conn, $sql_dl);

    if ($result_dl) {
        header("Location:?act=blog&pg=blog_list");
    }
} else {
    header("Location:?act=blog&pg=blog_list");
}
