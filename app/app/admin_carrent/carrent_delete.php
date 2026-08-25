<?php
if (isset($_GET['delete_id'])) {
    $id_del_mt = $_GET['delete_id'];

    $sql_img = " SELECT * FROM tbl_car_rental_image WHERE car_rental_id = '$id_del_mt' ";
    $result_img = mysqli_query($conn, $sql_img);

    while ($rs_img = mysqli_fetch_assoc($result_img)) {
        $fileupload1 = $rs_img['car_rental_image_name'];
        if ($fileupload1 != "") {
            unlink("../images/car_rental/$fileupload1");
        }
    }

    $sql_dl = " DELETE FROM tbl_car_rental WHERE car_rental_id = '$id_del_mt' ";
    $result_dl = mysqli_query($conn, $sql_dl);

    if ($result_dl) {
        header("Location:index.php?act=carrent&pg=carrent_list");
    }
} else {
    header("Location:index.php?act=carrent&pg=carrent_list");
}
