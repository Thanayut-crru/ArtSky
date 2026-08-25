<?php
function status_show($data_status)
{
    if ($data_status == 'YES') {
        $data = 'เปิด';
    }
    if ($data_status == 'NO') {
        $data = 'ปิด';
    }
    return $data;
}

function str_time_diff($timestamp = null, $html = true, $days_before_full_date = 3)
{
    // เราจะหาค่า "ช่วงห่างของเวลาปัจจุบันกับเวลาที่กำหนด"
    // โดยเวลาปัจจุบันนั้นหาได้จากฟังก์ชั่น time()
    // ซึ่งเวลาที่กำหนดนั้นก็จะอยู่ในตัวแปร $timestamp
    // ซึ่งทั้งหมดจะมีหน่วยเป็นวินาที ซึ่งจะเก็บไว้ในตัวแปร $diff
    // แต่ก่อนอื่นเราต้องตรวจว่า $timestamp เป็นตัวเลขหรือไม่
    if (is_numeric($timestamp)) {
        // ถ้าใช่ ก็เอาไปลบกับเวลาปัจจุบันเลย
        $diff = time() - $timestamp;
    } else {
        // ถ้าไม่ ก็อนุมานว่ามันเป็นสตริง เช่น 2013-03-07 07:57:12
        // ลองเอาไปแปลงเป็นวินาทีด้วย strtotime() แล้วลบกับเวลาปัจจุบัน
        $diff = time() - strtotime($timestamp);
    }
    // หากความต่างของเวลาปัจจุบันกับ $timestamp เป็น 0
    if (!$diff) {
        $str = "เมื่อสักครู่";
    }
    // หากความต่างของเวลาปัจจุบันกับ $timestamp น้อยกว่า 1 นาที
    elseif ($diff < 60) {
        $str = "$diff วินาทีที่แล้ว";
    }
    // หากความต่างของเวลาปัจจุบันกับ $timestamp น้อยกว่า 1 ชั่วโมง
    elseif ($diff < 3600) {
        $str = (int)($diff / 60) . ' นาทีที่แล้ว';
    }
    // หากความต่างของเวลาปัจจุบันกับ $timestamp น้อยกว่า 1 วัน
    elseif ($diff < 86400) {
        $str = (int)($diff / 3600) . ' ชั่วโมงที่แล้ว';
    }
    // หากความต่างของเวลาปัจจุบันกับ $timestamp น้อยกว่าจำนวนวันที่กำหนดไว้
    // ในตัวแปร $days_before_full_date ที่เราจะใช้เป็นตัวบอกว่า
    // ควรจะแสดงวันที่เต็มเมื่อช่วงห่างเกินกี่วัน
    elseif ($diff < 86400 * $days_before_full_date) {
        $str = (int)($diff / 86400) . ' วันที่แล้ว';
    }
    // หากตัวแปร $html เป็นจริง
    // หรือตัวแปร $str ยังไม่ถูกสร้างขึ้น ซึ่งเป็นเพราะช่วงห่างไม่อยู่ในเงื่อนไขข้างต้นเลย
    if ($html || !isset($str)) {
        // ตัวแปรที่ใช้แสดงผลชื่อเดือนภาษาไทย
        static $months = array(
            // ให้ index เริ่มที่ 1
            1 => 'มกราคม',  'กุมภาพันธ์', 'มีนาคม',    'เมษายน',
            'พฤษภาคม', 'มิถุนายน',  'กรกฎาคม',  'สิงหาคม',
            'กันยายน',  'ตุลาคม',   'พฤศจิกายน', 'ธันวาคม'
        );
        // หาค่าส่วนต่างๆ ของวันที่ปัจจุบันที่ต้องการ ด้วย explode() สตริงที่สร้างจาก date()
        // สมมติ date('j n Y H:s') สร้างสตริงออกมาแบบนี้ '8 4 2013 04:29'
        // เมื่อ explode() สตริงดังกล่าวโดยมี "ช่องว่าง" เป็นตัวแบ่ง
        // ก็จะได้ array('8', '4', '2013', '04:29')
        // และเพราะ array ดังกล่าวเป็น indexed array
        // เราจึงสามารถแยกใส่ตัวแปรได้ด้วย list()
        list($day, $month, $year, $time) = explode(' ', date('j n Y H:s'));
        // ทำค.ศ.ให้เป็นพ.ศ.ด้วยการ +543
        $year += 543;
        // วันที่เต็ม ที่จะใช้แสดงแบบเต็ม หรือใช้ใน attribute title
        $full_str = "วันที่ $day $months[$month] $year เวลา $time";
        // หาก $str ยังไม่ได้ถูกสร้างขึ้น แสดงว่าเราต้องแสดงวันที่แบบเต็ม
        if (!isset($str)) {
            // ทำให้ $str มีค่าเดียวกันกับ $full_str
            $str = $full_str;
        }
    }
    // คืนค่ากลับไป
    return $str;
}

function DateThaiFull($strDate)
{
    $strYear = date("Y", strtotime($strDate));
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour = date("H", strtotime($strDate));
    $strMinute = date("i", strtotime($strDate));
    $strSeconds = date("s", strtotime($strDate));
    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear เวลา $strHour:$strMinute น.";
}
function DateThai($strDate)
{
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour = date("H", strtotime($strDate));
    $strMinute = date("i", strtotime($strDate));
    $strSeconds = date("s", strtotime($strDate));
    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear เวลา $strHour:$strMinute น.";
}

function DateNormal($strDate)
{
    $strYear = date("Y", strtotime($strDate));
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour = date("H", strtotime($strDate));
    $strMinute = date("i", strtotime($strDate));
    $strSeconds = date("s", strtotime($strDate));
    return "$strDay/$strMonth/$strYear เวลา $strHour:$strMinute:$strSeconds";
}
function date_inters($strDate)
{
    $strYear = date("Y", strtotime($strDate));
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    return "$strDay/$strMonth/$strYear";
}
function DateThais($strDate)
{
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("m", strtotime($strDate));
    $strDay = date("d", strtotime($strDate));
    return "$strDay/$strMonth/$strYear";
}

function DateInThai($strDate)
{
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour = date("H", strtotime($strDate));
    $strMinute = date("i", strtotime($strDate));
    $strSeconds = date("s", strtotime($strDate));
    return "$strDay/$strMonth/$strYear เวลา $strHour:$strMinute:$strSeconds";
}

function thdate_sqls($bDay)
{
    //22-11-2543 to 2000-11-22
    $date_recent  = substr("$bDay", 0, 2); //นับจากเริ่มต้นไป 2ตัว ในที่นี้คือ 29
    $month_recent = substr("$bDay", 3, 2); //นับจากตัวที่ 3 ไป 2ตัว ในที่นี้คือ 05
    $year_recent = substr("$bDay", 6, 4) - 543; //นับจากตัวที่ 6 เริ่มต้นไป 4ตัว ในที่นี้คือ 2011
    $date_recent_box = "$year_recent" . "-$month_recent" . "-$date_recent";
    return $date_recent_box;
}

function main_active()
{
    return "menu-is-opening menu-open";
}
function sub_active()
{
    return "active";
}
function display_show()
{
    return "style=\"display:block\"";
}

function media_type($mtype)
{
    $tmp = explode('.', $mtype);
    $ext = end($tmp);
    return $ext;
}

// วัน/เดือน/ค.ศ.
function date_days($bDay)
{
    //22-11-2022 to 22/11/2022
    $date_recent  = substr("$bDay", 0, 2); //นับจากเริ่มต้นไป 2 ตัว ในที่นี้คือ 22
    $month_recent = substr("$bDay", 3, 2); //นับจากตัวที่ 3 ไป 2 ตัว ในที่นี้คือ 11
    $year_recent = substr("$bDay", 6, 4) + 543; //นับจากตัวที่ 6 เริ่มต้นไป 4 ตัว ในที่นี้คือ 2022
    $date_recent_box = "$date_recent" . "/$month_recent" . "/$year_recent";
    return $date_recent_box;
}

function date_months($bDay)
{
    //11-2000 to 11/2543
    $month_recent  = substr("$bDay", 0, 2);
    $year_recent = substr("$bDay", 3, 4) + 543;
    $month_years_thai = "$month_recent" . "/$year_recent";
    return $month_years_thai;
}



// Page
function page_navi($total_item, $cur_page, $per_page = 10, $query_str = "", $min_page = 2)
{

    $total_page = ceil($total_item / $per_page);
    $cur_page = (isset($cur_page)) ? $cur_page : 1;
    $diff_page = NULL;
    if ($cur_page > $min_page) {
        $diff_page = $total_page - $cur_page;
    }
    $limit_page = $min_page;
    $f_num_page = ($cur_page <= $min_page) ? 1 : (floor($cur_page / $min_page) * $min_page) + 1;
    if ($diff_page > $min_page) {
        $limit_page = ($min_page + $f_num_page) - 1;
    } else {
        if (isset($diff_page)) {
            $limit_page = $total_page;
        } else {
            $limit_page = $min_page;
        }
    }
    $show_page = ($total_page <= $min_page) ? $total_page : $limit_page;
    $l_num_page = 1;
    $prev_page = $cur_page - 1;
    $next_page = $cur_page + 1;
    $temp_query_str = $query_str;
    $query_str = "";
    if ($temp_query_str && is_array($temp_query_str) && count($temp_query_str) > 0) {
        array_pop($temp_query_str);
        $query_str = http_build_query($temp_query_str);
        if ($query_str != "") {
            $query_str = "?" . $query_str;
        }
    }
    $mark_char = ($query_str != "") ? "&" : "?";

    echo '<nav>
      <ul class="pagination justify-content-center">
        <li class="page-item">
        <a class="page-link" href="' . $query_str . $mark_char . 'page=1"> <i class="fas fa-step-backward"></i></a>
        </li>
        ';
    echo '
        <li class="page-item ' . (($cur_page == 1) ? "disabled" : "") . '">
          <a class="page-link"  href="' . $query_str . $mark_char . 'page=' . $prev_page . '"> <i class="fas fa-chevron-left"></i></a> 
        </li> 
    ';
    for ($i = $f_num_page; $i <= $show_page; $i++) {
        echo '     
        <li class="page-item ' . (($i == $cur_page) ? "active" : "") . '"> 
          <a class="page-link" href="' . $query_str . $mark_char . 'page=' . $i . '"> ' . $i . ' </a> 
        </li>     
    ';
    }
    echo '
        <li class="page-item ' . (($next_page > $total_page) ? "disabled" : "") . '"> 
            <a class="page-link"  href="' . $query_str . $mark_char . 'page=' . $next_page . '"> <i class="fas fa-chevron-right"></i></a> 
        </li>     
    ';
    echo '
        <li class="page-item">
          <input type="number" class="form-control" min="1" max="' . $total_page . '"
                  style="width:80px;" onClick="this.select()" onchange="window.location=\'' . $query_str . $mark_char . 'page=\'+this.value"  value="' . $cur_page . '" />
        </li> 
    ';
    echo '
        <li class="page-item"> 
            <a class="page-link"  href="' . $query_str . $mark_char . 'page=' . $total_page . '"> <i class="fas fa-step-forward"></i></a> 
        </li>     
      </ul>
    </nav>        
    ';
}

function compressImage($source, $destination, $quality)
{
    // Get image info 
    $imgInfo = getimagesize($source);
    $mime = $imgInfo['mime'];

    // Create a new image from file 
    switch ($mime) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($source);
            break;
        case 'image/png':
            $image = imagecreatefrompng($source);
            break;
        case 'image/gif':
            $image = imagecreatefromgif($source);
            break;
        default:
            $image = imagecreatefromjpeg($source);
    }

    // Save image 
    imagejpeg($image, $destination, $quality);

    // Return compressed image 
    return $destination;
}

function convert_filesize($bytes, $decimals = 2)
{
    $size = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
}

function month_th($m)
{
    switch ($m) {
        case 1:
            $m = 'มกราคม';
            break;
        case 2:
            $m = 'กุมภาพันธ์';
            break;
        case 3:
            $m = 'มีนาคม';
            break;
        case 4:
            $m = 'เมษายน';
            break;
        case 5:
            $m = 'พฤษภาคม';
            break;
        case 6:
            $m = 'มิถุนายน';
            break;
        case 7:
            $m = 'กรกฎาคม';
            break;
        case 8:
            $m = 'สิงหาคม';
            break;
        case 9:
            $m = 'กันยายน';
            break;
        case 10:
            $m = 'ตุลาคม';
            break;
        case 11:
            $m = 'พฤศจิกายน';
            break;
        case 12:
            $m = 'ธันวาคม';
            break;
    }
    return $m;
}

function get_client_ip()
{
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function thaid_sql($strDate)
{
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("d", strtotime($strDate));
    return "$strDay/$strMonth/$strYear";
}

function fulladmins($admins)
{
    global $conn;
    $sql = " SELECT admin_fullname FROM tbl_admin WHERE admin_id = '$admins' ";
    $result = mysqli_query($conn, $sql);
    $rs = mysqli_fetch_assoc($result);
    return $rs['admin_fullname'];
}
function fullcustomers($customers)
{
    global $conn;
    $sql = " SELECT customer_fullname FROM tbl_customer WHERE customer_id = '$customers' ";
    $result = mysqli_query($conn, $sql);
    $rs = mysqli_fetch_assoc($result);
    return $rs['customer_fullname'];
}

function units_fn($un)
{
    global $conn;
    $sql = " SELECT unit_name FROM tbl_unit WHERE unit_id = '$un' ";
    $result = mysqli_query($conn, $sql);
    $rs = mysqli_fetch_assoc($result);
    return $rs['unit_name'];
}

function unit_fnc($uns)
{
    global $conn;
    $sql = " SELECT unit_name FROM tbl_unit WHERE unit_id = '$uns' ";
    $result = mysqli_query($conn, $sql);
    $rs = mysqli_fetch_assoc($result);
    return $rs['unit_name'];
}

/* Convert Digital to Thai Start */
function Convert($amount_number)
{
    $amount_number = number_format($amount_number, 2, ".", "");
    $pt = strpos($amount_number, ".");
    $number = $fraction = "";
    if ($pt === false)
        $number = $amount_number;
    else {
        $number = substr($amount_number, 0, $pt);
        $fraction = substr($amount_number, $pt + 1);
    }

    $ret = "";
    $baht = ReadNumber($number);
    if ($baht != "")
        $ret .= $baht . "บาท";

    $satang = ReadNumber($fraction);
    if ($satang != "")
        $ret .=  $satang . "สตางค์";
    else
        $ret .= "ถ้วน";
    return $ret;
}

function ReadNumber($number)
{
    $position_call = array("แสน", "หมื่น", "พัน", "ร้อย", "สิบ", "");
    $number_call = array("", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า");
    $number = $number + 0;
    $ret = "";
    if ($number == 0) return $ret;
    if ($number > 1000000) {
        $ret .= ReadNumber(intval($number / 1000000)) . "ล้าน";
        $number = intval(fmod($number, 1000000));
    }

    $divider = 100000;
    $pos = 0;
    while ($number > 0) {
        $d = intval($number / $divider);
        $ret .= (($divider == 10) && ($d == 2)) ? "ยี่" : ((($divider == 10) && ($d == 1)) ? "" : ((($divider == 1) && ($d == 1) && ($ret != "")) ? "เอ็ด" : $number_call[$d]));
        $ret .= ($d ? $position_call[$pos] : "");
        $number = $number % $divider;
        $divider = $divider / 10;
        $pos++;
    }
    return $ret;
}
/* Convert Digital to Thai End */

function indexvalue($variable)
{
    if ($variable >= 1) {
        $index_value = '<i class="fas fa-caret-up"></i>';
    }
    if ($variable < 0) {
        $index_value = '<i class="fas fa-caret-down"></i>';
    }
    if ($variable == 0) {

        $index_value = '<i class="fas fa-caret-left"></i>';
    }
    return $index_value;
}

function week_days($ndays)
{
    switch ($ndays) {
        case 'Sunday':
            $dth = 'อาทิตย์';
            break;
        case 'Saturday':
            $dth = 'เสาร์';
            break;
        case 'Monday':
            $dth = 'จันทร์';
            break;
        case 'Tuesday':
            $dth = 'อังคาร';
            break;
        case 'Wednesday':
            $dth = 'พุธ';
            break;
        case 'Thursday':
            $dth = 'พฤหัส';
            break;
        case 'Friday':
            $dth = 'ศุกร์';
            break;
    }
    return $dth;
}
