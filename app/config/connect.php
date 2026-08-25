<?php
require_once __DIR__ . '/env.php';

try {
    $dbHost = required_env('DB_HOST');
    $dbPort = (int) env('DB_PORT', '3306');
    $dbName = required_env('DB_DATABASE');
    $dbUsername = required_env('DB_USERNAME');
    $dbPassword = required_env('DB_PASSWORD');
} catch (RuntimeException $exception) {
    error_log($exception->getMessage());
    http_response_code(500);
    exit('Application configuration is incomplete.');
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
ob_start();

$conn = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName, $dbPort);
if ($conn === false) {
    error_log('Database connection failed: ' . mysqli_connect_error());
    http_response_code(500);
    exit('Unable to connect to the application database.');
}
mysqli_query($conn, 'set NAMES utf8mb4');
mysqli_query($conn, 'SET character_set_results=utf8mb4');
mysqli_query($conn, 'SET character_set_client=utf8mb4');
mysqli_query($conn, 'SET character_set_connection=utf8mb4');
date_default_timezone_set(env('APP_TIMEZONE', 'Asia/Bangkok'));

$base_urls = rtrim(required_env('APP_URL'), '/');
$turnstile_site_key = required_env('TURNSTILE_SITE_KEY');
$turnstile_secret_key = required_env('TURNSTILE_SECRET_KEY');
$puchidao = required_env('GOOGLE_APPS_SCRIPT_DAO_URL');
$puchiduen = required_env('GOOGLE_APPS_SCRIPT_DUEAN_URL');
$puchifa = required_env('GOOGLE_APPS_SCRIPT_FA_URL');
/** =========================================================
 *   COUNT VIEW (1 ครั้งต่อ 30 นาที/เบราว์เซอร์)
 * ======================================================= */
$VIEW_COOLDOWN_MIN = 30;
$now = time();
if (!isset($_SESSION['last_view_at']) || ($now - $_SESSION['last_view_at']) > ($VIEW_COOLDOWN_MIN * 60)) {
  $_SESSION['last_view_at'] = $now;
  $today = date('Y-m-d');
  $sql = "INSERT INTO tbl_views_daily(view_date, view_count)
          VALUES(?, 1)
          ON DUPLICATE KEY UPDATE view_count = view_count + 1";
  if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, 's', $today);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
  }
}

/** =========================================================
 *   ONLINE NOW (นับ session ภายใน 5 นาที)
 * ======================================================= */
$sessionId = session_id();
$userAgent = substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 255);
$nowDt = date('Y-m-d H:i:s');

$sqlUp = "INSERT INTO tbl_online_sessions(session_id, last_activity, user_agent)
          VALUES(?, ?, ?)
          ON DUPLICATE KEY UPDATE last_activity = VALUES(last_activity), user_agent = VALUES(user_agent)";
if ($stmtUp = mysqli_prepare($conn, $sqlUp)) {
  mysqli_stmt_bind_param($stmtUp, 'sss', $sessionId, $nowDt, $userAgent);
  mysqli_stmt_execute($stmtUp);
  mysqli_stmt_close($stmtUp);
}
mysqli_query($conn, "DELETE FROM tbl_online_sessions WHERE last_activity < (NOW() - INTERVAL 5 MINUTE)");

/** =========================================================
 *   PULL METRICS
 * ======================================================= */
$views_total = 0; $views_today = 0; $views_yesterday = 0; $online_now = 0; $stations = 0; $hotels = 0;

if ($res = mysqli_query($conn, "SELECT COALESCE(SUM(view_count),0) AS total FROM tbl_views_daily")) {
  $views_total = (int)mysqli_fetch_assoc($res)['total'];
}
if ($res = mysqli_query($conn, "SELECT COALESCE(SUM(view_count),0) AS today FROM tbl_views_daily WHERE view_date = CURDATE()")) {
  $views_today = (int)mysqli_fetch_assoc($res)['today'];
}
if ($res = mysqli_query($conn, "SELECT COALESCE(SUM(view_count),0) AS ytd FROM tbl_views_daily WHERE view_date = (CURDATE() - INTERVAL 1 DAY)")) {
  $views_yesterday = (int)mysqli_fetch_assoc($res)['ytd'];
}
if ($res = mysqli_query($conn, "SELECT COUNT(*) AS online FROM tbl_online_sessions WHERE last_activity >= (NOW() - INTERVAL 5 MINUTE)")) {
  $online_now = (int)mysqli_fetch_assoc($res)['online'];
}
if ($res = mysqli_query($conn, "SELECT COUNT(*) AS c FROM tbl_station")) {
  $stations = (int)mysqli_fetch_assoc($res)['c'];
}
if ($res = mysqli_query($conn, "SELECT COUNT(*) AS c FROM tbl_hotel WHERE hotel_status = 1")) {
  $hotels = (int)mysqli_fetch_assoc($res)['c'];
}
