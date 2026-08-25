<?php
if (isset($_GET['delete_id'])) {
    $id_del_mt = $_GET['delete_id'];

    $sql_img = " SELECT * FROM tbl_hotel_image WHERE hotel_id = '$id_del_mt' ";
    $result_img = mysqli_query($conn, $sql_img);

    while ($rs_img = mysqli_fetch_assoc($result_img)) {
        $fileupload1 = $rs_img['hotel_image_name'];
        if ($fileupload1 != "") {
            unlink("../images/hotel_image/$fileupload1");
        }
    }

    $sql_dl = " DELETE FROM tbl_hotel WHERE hotel_id = '$id_del_mt' ";
    $result_dl = mysqli_query($conn, $sql_dl);

    if ($result_dl) {
        header("Location:index.php?act=hotel&pg=hotel_list");
    }
} else {
    header("Location:index.php?act=hotel&pg=hotel_list");
}
