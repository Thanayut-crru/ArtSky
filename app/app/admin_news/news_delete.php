<?php
if (isset($_GET['delete_id'])) {
    $id_del_mt = $_GET['delete_id'];

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

    $sql_del_img = " SELECT * FROM {$news_table} WHERE news_id = '$id_del_mt' ";
    $result_del_img = mysqli_query($conn, $sql_del_img);
    $rs_del_img = mysqli_fetch_assoc($result_del_img);

    $fileupload1 = $rs_del_img['news_image'];
    if ($fileupload1 != "") {
        unlink("../images/news/$fileupload1");
    }

    $sql_dl = " DELETE FROM {$news_table} WHERE news_id = '$id_del_mt' ";
    $result_dl = mysqli_query($conn, $sql_dl);

    if ($result_dl) {
        header("Location:?act=news&pg=news_list");
    }
} else {
    header("Location:?act=news&pg=news_list");
}
