<?php 
require 'config/connect.php';
$_POST = json_decode(file_get_contents("php://input"), true);
if(isset($_POST['search'])){
    $search = mysqli_real_escape_string($conn,$_POST['search']);
}else{
    $search = '';
}
$data_array = array();
$sql = "SELECT *,(SELECT tbl_hotel_image.hotel_image_name FROM tbl_hotel_image 
WHERE tbl_hotel_image.hotel_id = tbl_hotel.hotel_id 
ORDER BY tbl_hotel_image.hotel_image_id ASC LIMIT 1) AS 'hotel_image_name' 
FROM tbl_hotel 
WHERE tbl_hotel.hotel_status = 1 AND (tbl_hotel.hotel_name LIKE '%$search%' OR tbl_hotel.hotel_price LIKE '%$search%')
ORDER BY tbl_hotel.hotel_id ASC ";
$result = mysqli_query($conn,$sql);
while($rs = mysqli_fetch_assoc($result)){
    $data_array[] = $rs;
}
echo json_encode($data_array,JSON_UNESCAPED_UNICODE);
?>