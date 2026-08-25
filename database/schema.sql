-- ArtSky database schema (structure only, no data)
-- Sanitized for public sharing: all INSERT statements removed to exclude admin credentials,
-- operator contact details (tbl_admin, tbl_car_rental, tbl_hotel), and other real records.
-- Generated from the project's db_artsky.sql for the ArtSky research paper repository.

CREATE TABLE `tbl_admin` (
  `admin_id` int(11) NOT NULL COMMENT 'ไอดีแอดมิน',
  `admin_fullname` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'ชื่อนามสกุล',
  `admin_telephone` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT 'โทรศัพท์',
  `admin_address` text CHARACTER SET utf8 NOT NULL COMMENT 'ที่อยู่',
  `admin_email` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT 'อีเมล',
  `admin_status` enum('ปกติ','ยกเลิก') NOT NULL COMMENT 'สถานะ',
  `admin_type` enum('ผู้ใช้งาน','ผู้ดูแลระบบ') NOT NULL COMMENT 'ประเภท',
  `admin_username` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT 'ชื่อผู้ใช้',
  `admin_password` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT 'รหัสผ่าน',
  `admin_image` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT 'รูปโปรไฟล์',
  `admin_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'วันที่',
  `admin_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'แก้ไข'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `tbl_blog` (
  `blog_id` int(11) NOT NULL,
  `blog_name` varchar(255) NOT NULL,
  `blog_detail` text NOT NULL,
  `blog_date` date NOT NULL,
  `blog_image` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `tbl_car_rental` (
  `car_rental_id` int(11) UNSIGNED NOT NULL,
  `car_rental_name` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `line_id` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `facebook` varchar(150) NOT NULL,
  `website` varchar(200) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(150) NOT NULL,
  `status_car_rental` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `carrent_detail` text NOT NULL,
  `province_id` int(11) UNSIGNED NOT NULL,
  `district_id` int(11) UNSIGNED NOT NULL,
  `subdistrict_id` int(11) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `tbl_car_rental_image` (
  `car_rental_image_id` int(11) NOT NULL COMMENT 'ID',
  `car_rental_id` int(11) NOT NULL COMMENT 'รหัสรถเช่าผู้ประกอบการ',
  `car_rental_image_name` varchar(150) NOT NULL COMMENT 'รูปภาพรถ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `tbl_districts` (
  `id` int(11) NOT NULL,
  `code` int(11) NOT NULL,
  `name_in_thai` varchar(150) NOT NULL,
  `name_in_english` varchar(150) NOT NULL,
  `province_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tbl_hotel` (
  `hotel_id` int(11) NOT NULL,
  `hotel_name` varchar(255) NOT NULL,
  `hotel_lat` varchar(50) NOT NULL,
  `hotel_lon` varchar(50) NOT NULL,
  `hotel_price` decimal(10,2) NOT NULL,
  `hotel_telephone` varchar(50) NOT NULL,
  `hotel_line` varchar(100) NOT NULL,
  `hotel_email` varchar(150) NOT NULL,
  `hotel_facebook` varchar(150) NOT NULL,
  `hotel_website` varchar(200) NOT NULL,
  `hotel_user` varchar(100) NOT NULL,
  `hotel_password` varchar(100) NOT NULL,
  `hotel_status` enum('Yes','No') NOT NULL,
  `hotel_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `hotel_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `tbl_hotel_image` (
  `hotel_image_id` int(11) NOT NULL,
  `hotel_id` int(11) NOT NULL,
  `hotel_image_name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `tbl_news` (
  `news_id` int(11) NOT NULL COMMENT 'ไอดีข่าว',
  `station_id` int(11) NOT NULL COMMENT 'รหัสสถานี',
  `news_name` varchar(255) NOT NULL COMMENT 'ชื่อข่าว',
  `news_detail` text NOT NULL COMMENT 'รายละเอียดข่าย',
  `news_date` date NOT NULL COMMENT 'วันที่',
  `news_image` varchar(150) NOT NULL COMMENT 'รูปภาพข่าว'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `tbl_online_sessions` (
  `session_id` varchar(128) NOT NULL,
  `last_activity` datetime NOT NULL,
  `user_agent` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `tbl_provinces` (
  `id` int(11) NOT NULL,
  `code` int(11) NOT NULL,
  `name_in_thai` varchar(150) NOT NULL,
  `name_in_english` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tbl_station` (
  `station_id` int(11) NOT NULL,
  `station_name` varchar(255) NOT NULL,
  `station_lat` varchar(50) NOT NULL,
  `station_long` varchar(50) NOT NULL,
  `station_image` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `tbl_subdistricts` (
  `id` int(11) NOT NULL,
  `code` int(11) NOT NULL,
  `name_in_thai` varchar(150) NOT NULL,
  `name_in_english` varchar(150) DEFAULT NULL,
  `latitude` decimal(6,3) NOT NULL,
  `longitude` decimal(6,3) NOT NULL,
  `district_id` int(11) NOT NULL,
  `zip_code` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tbl_views_daily` (
  `view_date` date NOT NULL,
  `view_count` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

