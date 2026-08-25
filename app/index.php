<?php
require './config/connect.php';
require './config/function.php';

// ===== News (tbl_news) for homepage =====
$news_table = 'tbl_news';
try {
    $probe = mysqli_query($conn, "SELECT 1 FROM tbl_news LIMIT 1");
    if ($probe === false) {
        $news_table = 'news';
    }
} catch (Throwable $e) {
    $news_table = 'news';
}

$news_items = [];
try {
    $sql_news = "SELECT n.news_id, n.station_id, n.news_name, n.news_detail, n.news_date, n.news_image, s.station_name\n"
        . "FROM {$news_table} n\n"
        . "LEFT JOIN tbl_station s ON n.station_id = s.station_id\n"
        . "ORDER BY n.news_date DESC, n.news_id DESC\n"
        . "LIMIT 6";
    $result_news = mysqli_query($conn, $sql_news);
    if ($result_news !== false) {
        while ($row = mysqli_fetch_assoc($result_news)) {
            $news_items[] = $row;
        }
    }
} catch (Throwable $e) {
    $news_items = [];
}

$news_swiper_loop = count($news_items) > 3;

function artsky_news_excerpt(string $html, int $maxChars = 160): string
{
    $text = trim(preg_replace('/\s+/u', ' ', strip_tags($html)));
    if ($text === '') {
        return '';
    }
    if (function_exists('mb_strimwidth')) {
        return mb_strimwidth($text, 0, $maxChars, '...', 'UTF-8');
    }
    return (strlen($text) > $maxChars) ? (substr($text, 0, $maxChars) . '...') : $text;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>ART SKY</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="./images/favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./images/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./images/favicon_io/favicon-16x16.png">
    <link rel="manifest" href="./images/favicon_io/site.webmanifest">
    <link rel="mask-icon" href="./images/favicon_io/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#000814">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/main2.css" rel="stylesheet">
    <link rel="stylesheet" href="./app/node_modules/swiper/swiper-bundle.min.css" />

    <style>
        :root {
            --sky-primary: #38bdf8;
            --sky-secondary: #0ea5e9;
            --sky-accent: #22c55e;
            --sky-bg-dark: #020617;
            --glass-bg: rgba(15, 23, 42, 0.72);
            --glass-border: rgba(148, 163, 184, 0.35);
            --glass-shadow: 0 24px 60px rgba(15, 23, 42, 0.9);
            --radius-xl: 24px;
            --radius-lg: 18px;
            --blur-xl: blur(22px);
        }

        * {
            scroll-behavior: smooth;
        }

        body {
            min-height: 100vh;
            margin: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Noto Sans Thai", sans-serif;
            color: #e5e7eb;
            background:
                #020617 url("./images/head_bg.jpg") no-repeat top center fixed;
            background-size: cover;
            position: relative;
            overflow-x: hidden;
        }

        .fkanit {
            font-family: "Noto Serif Thai", "Noto Sans Thai", system-ui, -apple-system, sans-serif;
            font-weight: 400;
            font-style: normal;
        }

        .color-sky {
            color: rgba(241, 245, 249, 0.96);
        }

        #header {
            background: transparent;
        }

        .bg-skys {
            background: linear-gradient(135deg,
                    rgba(15, 23, 42, 0.0),
                    rgba(15, 23, 42, 0.1),
                    rgba(8, 47, 73, 0.2));
            backdrop-filter: blur(20px);
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.1);
        }

        .art-sky-img {
            aspect-ratio: 9 / 16;
            object-fit: cover;
            border-radius: var(--radius-lg) var(--radius-lg) 0 0;
        }

        .card.border-0.bg-skys {
            overflow: hidden;
            position: relative;
            transition: transform 0.45s ease, box-shadow 0.45s ease, border-color 0.45s ease;
        }

        .card.border-0.bg-skys::before {
            content: "";
            position: absolute;
            inset: -40%;
            opacity: 0;
            transition: opacity 0.5s ease, transform 0.5s ease;
            z-index: 0;
        }

        .card.border-0.bg-skys:hover {
            transform: translateY(-10px) scale(1.01);
            box-shadow: 0 28px 80px rgba(15, 23, 42, 0.95);
            border-color: rgba(56, 189, 248, 0.6);
        }

        .card.border-0.bg-skys:hover::before {
            opacity: 1;
            transform: translate3d(0, -5px, 0);
        }

        .card.border-0.bg-skys .card-body {
            position: relative;
            z-index: 1;
        }

        .card-title a,
        .card-text a {
            text-decoration: none;
            color: #e5e7eb;
        }

        .card-title a:hover,
        .card-text a:hover {
            color: var(--sky-primary);
        }

        .section-header {
            margin-bottom: 1.75rem;
        }

        .section-header h1,
        .section-header h2 {
            font-weight: 800;
            letter-spacing: 0.03em;
            /* background: linear-gradient(120deg, #e5e7eb, #bae6fd, #a5f3fc); */
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            text-shadow: 0 0 24px rgba(15, 23, 42, 0.85);
        }

        .section-header p {
            margin-top: 0.5rem;
            margin-bottom: 0;
            color: rgba(226, 232, 240, 0.78);
            font-size: 0.98rem;
        }

        /* ===== Visitor Stats Cards ===== */
        .stats-wrap {
            position: relative;
            z-index: 5;
            margin-top: 82px;
        }

        @media (min-width: 992px) {
            .stats-wrap {
                margin-top: 96px;
            }
        }

        /* .stats-inner {
            backdrop-filter: var(--blur-xl);
        } */

        .stats-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            padding: 4px 4px 8px;
            border-bottom: 1px solid rgba(148, 163, 184, 0.3);
            margin-bottom: 10px;
        }

        .stats-header-title {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: rgba(148, 163, 184, 0.95);
        }

        .stats-header-pill {
            font-size: 0.75rem;
            padding: 4px 10px;
            border-radius: 999px;
            border: 1px solid rgba(56, 189, 248, 0.7);
            background: radial-gradient(circle at top,
                    rgba(15, 23, 42, 0.1),
                    rgba(8, 47, 73, 0.3));
            color: rgba(226, 232, 240, 0.9);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .stats-header-pill i {
            font-size: 0.9rem;
            color: #38bdf8;
        }

        .stat-card {
            /* backdrop-filter: blur(18px);
            background: radial-gradient(circle at top left,
                    rgba(15, 23, 42, 0.5),
                    rgba(15, 23, 42, 0.1)); */
            border: 1px solid rgba(148, 163, 184, 0.45);
            border-radius: 18px;
            padding: 14px 14px 12px;
            color: #f9fafb;
            box-shadow: 0 14px 40px rgba(15, 23, 42, 0.9);
            position: relative;
            overflow: hidden;
        }

        .stat-card::after {
            content: "";
            position: absolute;
            /* inset: -40%;
            background:
                radial-gradient(circle at 0% 0%, rgba(56, 189, 248, 0.0), transparent 55%),
                radial-gradient(circle at 100% 100%, rgba(129, 140, 248, 0.1), transparent 55%);
            opacity: 0; */
            /* transition: opacity 0.4s ease, transform 0.4s ease; */
            z-index: 0;
        }

        .stat-card:hover::after {
            opacity: 1;
            transform: translate3d(0, -3px, 0);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            border-color: rgba(56, 189, 248, 0.9);
        }

        .stat-card .d-flex {
            position: relative;
            z-index: 1;
        }

        .stat-label {
            font-size: 0.86rem;
            opacity: 0.88;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: rgba(148, 163, 184, 0.96);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 800;
            line-height: 1.1;
            margin-top: 2px;
            color: #e5f8ff;
        }

        .stat-sub {
            font-size: 0.85rem;
            opacity: 0.88;
            margin-top: 4px;
            color: rgba(203, 213, 225, 0.96);
        }

        .stat-trend.up {
            color: #4ade80;
        }

        .stat-trend.down {
            color: #fb7185;
        }

        .stat-icon {
            font-size: 22px;
            width: 46px;
            height: 46px;
            border-radius: 18px;
            display: grid;
            place-items: center;
            background: radial-gradient(circle at top left,
                    rgba(56, 189, 248, 0.18),
                    rgba(15, 23, 42, 0.82));
            border: 1px solid rgba(56, 189, 248, 0.45);
        }

        /* ===== News ===== */
        .news-wrap {
            position: relative;
            z-index: 4;
            margin-top: 14px;
        }

        .news-inner {
            border: 1px solid rgba(148, 163, 184, 0.35);
            border-radius: 18px;
            padding: 16px;
            background: radial-gradient(circle at top left,
                    rgba(15, 23, 42, 0.35),
                    rgba(15, 23, 42, 0.12));
            box-shadow: 0 16px 55px rgba(15, 23, 42, 0.85);
        }

        .news-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 4px 4px 12px;
            border-bottom: 1px solid rgba(148, 163, 184, 0.25);
            margin-bottom: 12px;
        }

        .news-title h2 {
            margin: 0;
            font-size: 1.05rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: rgba(226, 232, 240, 0.92);
        }

        .news-title .hint {
            font-size: 0.82rem;
            color: rgba(148, 163, 184, 0.95);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .news-card {
            border: 1px solid rgba(148, 163, 184, 0.38);
            border-radius: 18px;
            overflow: hidden;
            background: rgba(2, 6, 23, 0.2);
            transition: transform 0.35s ease, border-color 0.35s ease, box-shadow 0.35s ease;
            height: 100%;
        }

        .news-card:hover {
            transform: translateY(-6px);
            border-color: rgba(56, 189, 248, 0.85);
            box-shadow: 0 26px 70px rgba(15, 23, 42, 0.9);
        }

        .news-thumb {
            background: linear-gradient(135deg,
                    rgba(56, 189, 248, 0.22),
                    rgba(34, 197, 94, 0.12),
                    rgba(2, 6, 23, 0.35));
        }

        .news-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            align-items: center;
            font-size: 0.78rem;
            color: rgba(148, 163, 184, 0.96);
            margin-bottom: 8px;
        }

        .news-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 999px;
            border: 1px solid rgba(56, 189, 248, 0.55);
            background: rgba(15, 23, 42, 0.25);
            color: rgba(226, 232, 240, 0.9);
        }

        .news-pill i {
            color: #38bdf8;
        }

        .news-name {
            font-size: 1.02rem;
            font-weight: 800;
            line-height: 1.25;
            color: rgba(226, 232, 240, 0.98);
            margin-bottom: 8px;
        }

        .news-desc {
            font-size: 0.92rem;
            color: rgba(203, 213, 225, 0.95);
            margin-bottom: 0;
        }

        .newsSwiper {
            width: 100%;
            padding: 6px 0 18px;
        }

        .newsSwiper .swiper-slide {
            text-align: left;
            display: flex;
            justify-content: center;
            align-items: stretch;
            height: auto;
        }

        .news-link {
            display: block;
            text-decoration: none;
            color: inherit;
            height: 100%;
            width: 100%;
            max-width: 420px;
        }

        .news-link:hover {
            color: inherit;
        }

        .news-swiper-next,
        .news-swiper-prev {
            color: rgba(226, 232, 240, 0.92);
            width: 40px;
            height: 40px;
        }

        .news-swiper-next::after,
        .news-swiper-prev::after {
            font-size: 18px;
            font-weight: 700;
        }

        .news-swiper-pagination .swiper-pagination-bullet {
            background: rgba(148, 163, 184, 0.6);
            opacity: 1;
        }

        .news-swiper-pagination .swiper-pagination-bullet-active {
            background: linear-gradient(135deg, #38bdf8, #22c55e);
            box-shadow: 0 0 12px rgba(56, 189, 248, 0.8);
        }

        /* ===== Hero / Swiper ===== */
        .page-header {
            min-height: 68vh;
            display: flex;
            align-items: stretch;
            position: relative;
            padding: 40px 0 60px;
        }

        .page-header::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at top,
                    rgba(15, 23, 42, 0.0),
                    rgba(15, 23, 42, 0.0));
            z-index: 0;
        }

        .page-header>.container-fluid {
            position: relative;
            z-index: 1;
        }

        .hero-glass {
            max-width: 1040px;
            margin: 0 auto;
            border-radius: var(--radius-xl);
            border: 1px solid rgba(148, 163, 184, 0.4);
            /* background:
                radial-gradient(circle at top left,
                    rgba(15, 23, 42, 0.1),
                    rgba(15, 23, 42, 0.3)); */
            box-shadow: var(--glass-shadow);
            /* backdrop-filter: var(--blur-xl); */
            padding: 24px 20px 26px;
            position: relative;
            overflow: hidden;
        }

        .hero-glass::before {
            content: "";
            position: absolute;
            inset: -40%;
            /* background:
                conic-gradient(from 180deg,
                    rgba(56, 189, 248, 0.1),
                    transparent,
                    rgba(94, 234, 212, 0.12),
                    transparent,
                    rgba(56, 189, 248, 0.1)); */
            /* opacity: 0.28; */
            mix-blend-mode: screen;
            pointer-events: none;
        }

        .hero-inner {
            position: relative;
            z-index: 1;
        }

        .hero-tagline {
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.16em;
            color: rgba(148, 163, 184, 0.95);
            margin-bottom: 6px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .hero-tagline span.dot {
            width: 7px;
            height: 7px;
            border-radius: 999px;
            background: #22c55e;
            box-shadow: 0 0 18px rgba(34, 197, 94, 0.9);
        }

        .hero-title {
            font-size: clamp(1.6rem, 2.2vw + 1.4rem, 2.4rem);
            font-weight: 800;
            margin-bottom: 4px;
            background: linear-gradient(120deg, #e5e7eb, #bae6fd, #a5f3fc);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }

        .hero-subtitle {
            font-size: 0.96rem;
            color: rgba(203, 213, 225, 0.92);
            max-width: 580px;
            margin: 0 auto 16px;
        }

        .hero-divider {
            width: 46px;
            margin: 12px auto 22px;
            border-bottom: 1px solid rgba(148, 163, 184, 0.8);
        }

        .swiper {
            width: 100%;
            height: 100%;
        }

        .swiper-slide {
            text-align: center;
            background: transparent;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper-slide-inner {
            width: 100%;
            max-width: 320px;
            margin: 0 auto;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: auto;
            max-height: 220px;
            object-fit: contain;
            filter: drop-shadow(0 25px 40px rgba(15, 23, 42, 0.9));
        }

        .swiper-slide h3 {
            margin-top: 14px;
            font-size: 1.05rem;
            color: rgba(226, 232, 240, 0.96);
        }

        .swiper-button-next,
        .swiper-button-prev {
            color: #e5e7eb;
            width: 40px;
            height: 40px;
        }

        .swiper-button-next::after,
        .swiper-button-prev::after {
            font-size: 18px;
            font-weight: 700;
        }

        .swiper-pagination-bullet {
            background: rgba(148, 163, 184, 0.6);
            opacity: 1;
        }

        .swiper-pagination-bullet-active {
            background: linear-gradient(135deg, #38bdf8, #22c55e);
            box-shadow: 0 0 12px rgba(56, 189, 248, 0.8);
        }

        /* Counters */
        .counter {
            display: inline-block;
            transition: transform 0.3s ease, text-shadow 0.3s ease;
        }

        .counter.animated {
            transform: scale(1.06);
            text-shadow: 0 0 30px rgba(56, 189, 248, 0.75);
        }

        /* Layout spacing tweaks */
        main#main {
            padding-bottom: 80px;
        }

        .art-skys {
            margin-top: 10px;
        }

        .dark-sky-section {
            position: relative;
            z-index: 3;
        }

        .dark-sky-shell {
            width: min(1180px, calc(100% - 32px));
            margin: 0 auto;
        }

        .dark-sky-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
            align-items: stretch;
        }

        .dark-sky-card {
            display: flex;
            flex-direction: column;
            height: 100%;
            overflow: hidden;
            color: #f8fafc;
            text-decoration: none;
            border: 1px solid rgba(226, 232, 240, 0.2);
            border-radius: 12px;
            background: rgba(15, 23, 42, 0.68);
            box-shadow: 0 18px 42px rgba(2, 6, 23, 0.5);
            transition: transform 0.22s ease, border-color 0.22s ease, box-shadow 0.22s ease;
        }

        .dark-sky-card:hover,
        .dark-sky-card:focus-visible {
            color: #f8fafc;
            transform: translateY(-5px);
            border-color: rgba(56, 189, 248, 0.7);
            box-shadow: 0 22px 52px rgba(2, 6, 23, 0.68);
        }

        .dark-sky-media {
            position: relative;
            aspect-ratio: 9 / 16;
            background: rgba(15, 23, 42, 0.9);
            overflow: hidden;
        }

        .dark-sky-media img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
            transition: transform 0.35s ease;
        }

        .dark-sky-card:hover .dark-sky-media img,
        .dark-sky-card:focus-visible .dark-sky-media img {
            transform: scale(1.04);
        }

        .dark-sky-badge {
            position: absolute;
            left: 12px;
            top: 12px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            max-width: calc(100% - 24px);
            padding: 5px 10px;
            border-radius: 999px;
            background: rgba(2, 6, 23, 0.78);
            color: rgba(226, 232, 240, 0.96);
            font-size: 0.76rem;
            line-height: 1.2;
            backdrop-filter: blur(12px);
        }

        .dark-sky-body {
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex: 1 1 auto;
            padding: 14px 14px 15px;
        }

        .dark-sky-name {
            margin: 0;
            color: #f8fafc;
            font-size: 1rem;
            font-weight: 700;
            line-height: 1.35;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .dark-sky-desc {
            margin: 0;
            color: rgba(203, 213, 225, 0.88);
            font-size: 0.86rem;
            line-height: 1.45;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .dark-sky-more {
            display: flex;
            justify-content: center;
            margin-top: 22px;
        }

        .dark-sky-more-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 44px;
            padding: 10px 20px;
            border: 1px solid rgba(56, 189, 248, 0.46);
            border-radius: 999px;
            background: rgba(14, 165, 233, 0.15);
            color: #e0f2fe;
            font-weight: 700;
            box-shadow: 0 14px 32px rgba(2, 6, 23, 0.35);
        }

        .dark-sky-more-btn:hover,
        .dark-sky-more-btn:focus-visible {
            background: rgba(14, 165, 233, 0.26);
            border-color: rgba(125, 211, 252, 0.8);
            color: #ffffff;
        }

        .dark-sky-item[hidden],
        .dark-sky-more[hidden] {
            display: none !important;
        }

        .hotel-sky-section {
            position: relative;
            z-index: 3;
        }

        .hotel-sky-shell {
            width: min(1180px, calc(100% - 32px));
            margin: 0 auto;
        }

        .hotel-sky-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
            align-items: stretch;
        }

        .hotel-sky-card {
            display: flex;
            flex-direction: column;
            height: 100%;
            min-height: 100%;
            overflow: hidden;
            color: #f8fafc;
            text-decoration: none;
            border: 1px solid rgba(226, 232, 240, 0.2);
            border-radius: 12px;
            background: rgba(15, 23, 42, 0.68);
            box-shadow: 0 18px 42px rgba(2, 6, 23, 0.5);
            transition: transform 0.22s ease, border-color 0.22s ease, box-shadow 0.22s ease;
        }

        .hotel-sky-card:hover,
        .hotel-sky-card:focus-visible {
            color: #f8fafc;
            transform: translateY(-5px);
            border-color: rgba(56, 189, 248, 0.7);
            box-shadow: 0 22px 52px rgba(2, 6, 23, 0.68);
        }

        .hotel-sky-media {
            position: relative;
            aspect-ratio: 9 / 16;
            background: rgba(15, 23, 42, 0.9);
            overflow: hidden;
        }

        .hotel-sky-media img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
            transition: transform 0.35s ease;
        }

        .hotel-sky-card:hover .hotel-sky-media img,
        .hotel-sky-card:focus-visible .hotel-sky-media img {
            transform: scale(1.04);
        }

        .hotel-sky-badge {
            position: absolute;
            left: 12px;
            top: 12px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            max-width: calc(100% - 24px);
            padding: 5px 10px;
            border-radius: 999px;
            background: rgba(2, 6, 23, 0.78);
            color: rgba(226, 232, 240, 0.96);
            font-size: 0.76rem;
            line-height: 1.2;
            backdrop-filter: blur(12px);
        }

        .hotel-sky-body {
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex: 1 1 auto;
            padding: 14px 14px 15px;
        }

        .hotel-sky-name {
            margin: 0;
            color: #f8fafc;
            font-size: 1rem;
            font-weight: 700;
            line-height: 1.35;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .hotel-sky-price {
            margin: 0;
            color: rgba(203, 213, 225, 0.88);
            font-size: 0.86rem;
            line-height: 1.45;
        }

        .hotel-sky-item[hidden],
        .hotel-sky-more[hidden] {
            display: none !important;
        }

        @media (max-width: 991.98px) {
            .dark-sky-grid {
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 12px;
            }

            .hotel-sky-grid {
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 12px;
            }

            .dark-sky-body {
                padding: 11px;
            }

            .dark-sky-name {
                font-size: 0.9rem;
            }

            .dark-sky-desc,
            .dark-sky-badge {
                font-size: 0.74rem;
            }

            .hotel-sky-body {
                padding: 11px;
            }

            .hotel-sky-name {
                font-size: 0.9rem;
            }

            .hotel-sky-price,
            .hotel-sky-badge {
                font-size: 0.74rem;
            }
        }

        @media (max-width: 767.98px) {
            .stats-inner {
                padding: 16px 12px 10px;
            }

            .stat-card {
                padding: 12px 12px 10px;
            }

            .stat-value {
                font-size: 1.6rem;
            }

            .hero-title {
                font-size: 1.55rem;
            }

            .hero-subtitle {
                font-size: 0.9rem;
            }

            .swiper-slide-inner {
                max-width: 260px;
            }

            .dark-sky-shell {
                width: min(680px, calc(100% - 18px));
            }

            .dark-sky-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 18px 12px;
            }

            .dark-sky-media {
                aspect-ratio: 1 / 1.22;
            }

            .dark-sky-card {
                border: 0;
                border-radius: 22px;
                background: #ffffff;
                color: #172554;
                box-shadow: 0 12px 26px rgba(15, 23, 42, 0.14);
            }

            .dark-sky-card:hover,
            .dark-sky-card:focus-visible {
                color: #172554;
                transform: translateY(-3px);
                box-shadow: 0 16px 32px rgba(15, 23, 42, 0.2);
            }

            .dark-sky-badge {
                left: 10px;
                top: 10px;
                max-width: calc(100% - 20px);
                padding: 4px 8px;
                background: rgba(255, 255, 255, 0.9);
                color: #334155;
                font-size: 0.68rem;
                box-shadow: 0 6px 16px rgba(15, 23, 42, 0.16);
            }

            .dark-sky-body {
                gap: 7px;
                padding: 12px 12px 13px;
            }

            .dark-sky-name {
                color: #172554;
                font-size: 0.93rem;
                line-height: 1.35;
            }

            .dark-sky-desc {
                color: #64748b;
                font-size: 0.78rem;
                line-height: 1.35;
                -webkit-line-clamp: 1;
            }

            .dark-sky-more {
                margin-top: 20px;
            }

            .dark-sky-more-btn {
                min-height: 42px;
                background: #ffffff;
                border-color: rgba(203, 213, 225, 0.95);
                color: #172554;
                box-shadow: 0 10px 24px rgba(15, 23, 42, 0.12);
            }

            .dark-sky-more-btn:hover,
            .dark-sky-more-btn:focus-visible {
                background: #f8fafc;
                border-color: rgba(56, 189, 248, 0.7);
                color: #0f172a;
            }

            .hotel-sky-shell {
                width: min(680px, calc(100% - 18px));
            }

            .hotel-sky-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 18px 12px;
            }

            .hotel-sky-media {
                aspect-ratio: 1 / 1.22;
            }

            .hotel-sky-card {
                border: 0;
                border-radius: 22px;
                background: #ffffff;
                color: #172554;
                box-shadow: 0 12px 26px rgba(15, 23, 42, 0.14);
            }

            .hotel-sky-card:hover,
            .hotel-sky-card:focus-visible {
                color: #172554;
                transform: translateY(-3px);
                box-shadow: 0 16px 32px rgba(15, 23, 42, 0.2);
            }

            .hotel-sky-badge {
                left: 10px;
                top: 10px;
                max-width: calc(100% - 20px);
                padding: 4px 8px;
                background: rgba(255, 255, 255, 0.9);
                color: #334155;
                font-size: 0.68rem;
                box-shadow: 0 6px 16px rgba(15, 23, 42, 0.16);
            }

            .hotel-sky-body {
                gap: 7px;
                padding: 12px 12px 13px;
            }

            .hotel-sky-name {
                color: #172554;
                font-size: 0.93rem;
                line-height: 1.35;
            }

            .hotel-sky-price {
                color: #64748b;
                font-size: 0.78rem;
                line-height: 1.35;
            }
        }

        .hotel-sky-card {
            cursor: pointer;
        }
    </style>

    <script type="text/javascript" src="./app/node_modules/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="./app/node_modules/axios/dist/axios.min.js"></script>
</head>

<body>

    <!-- ======= Header ======= -->
    <?php require './layout/header.php'; ?>
    <!-- End Header -->

    <main id="main" data-aos="fade" data-aos-delay="350">

        <!-- ===== Visitor Stats Cards (Top) ===== -->
        <section class="stats-wrap container">
            <div class="stats-inner rounded rounded-3" data-aos="fade-up" data-aos-delay="150">
                <div class="stats-header">
                    <div class="stats-header-title">
                        ART SKY LIVE INSIGHTS
                    </div>
                    <div class="stats-header-pill">
                        <i class="bi bi-stars"></i>
                        อัปเดตแบบเรียลไทม์ภายใน 5 นาที
                    </div>
                </div>
                <div class="row g-3 g-md-3 g-lg-3">
                    <div class="col-6 col-md-6 col-lg-3">
                        <div class="stat-card h-100">
                            <div class="d-flex align-items-center gap-3">
                                <div class="stat-icon">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div>
                                    <div class="stat-label">ออนไลน์ตอนนี้</div>
                                    <div class="stat-value counter" data-count="<?= $online_now ?>">0</div>
                                    <div class="stat-sub">ผู้ใช้ที่กำลังสำรวจแผนที่ดาว</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-md-6 col-lg-3">
                        <div class="stat-card h-100">
                            <div class="d-flex align-items-center gap-3">
                                <div class="stat-icon">
                                    <i class="bi bi-calendar-day"></i>
                                </div>
                                <div>
                                    <div class="stat-label">เข้าชมวันนี้</div>
                                    <div class="stat-value counter" data-count="<?= $views_today ?>">0</div>
                                    <?php
                                    $trend = $views_yesterday == 0 ? 100 : round((($views_today - $views_yesterday) / max($views_yesterday, 1)) * 100);
                                    $isUp = ($views_today >= $views_yesterday);
                                    ?>
                                    <div class="stat-sub">
                                        <span class="stat-trend <?= $isUp ? 'up' : 'down' ?>">
                                            <i class="bi <?= $isUp ? 'bi-arrow-up-right' : 'bi-arrow-down-right' ?>"></i>
                                            <?= ($trend >= 0 ? '+' : '') . $trend ?>% จากเมื่อวาน
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-md-6 col-lg-3">
                        <div class="stat-card h-100">
                            <div class="d-flex align-items-center gap-3">
                                <div class="stat-icon">
                                    <i class="bi bi-bar-chart-line"></i>
                                </div>
                                <div>
                                    <div class="stat-label">เข้าชมทั้งหมด</div>
                                    <div class="stat-value counter" data-count="<?= $views_total ?>">0</div>
                                    <div class="stat-sub">จำนวนผู้เข้าชมสะสมรายวัน</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-md-6 col-lg-3">
                        <div class="stat-card h-100">
                            <div class="d-flex align-items-center gap-3">
                                <div class="stat-icon">
                                    <i class="bi bi-building"></i>
                                </div>
                                <div>
                                    <div class="stat-label">พื้นที่ท้องฟ้ามืด</div>
                                    <div class="stat-value counter" data-count="<?= $stations ?>">0</div>
                                    <div class="stat-sub"><?= number_format($hotels) ?> ที่พักสำหรับนอนดูดาว</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- ======= News (under LIVE INSIGHTS) ======= -->
        <section class="news-wrap container" data-aos="fade-up" data-aos-delay="180">
            <div class="news-inner">
                <div class="news-title">
                    <h2><i class="bi bi-newspaper me-2"></i>ข่าวสาร</h2>
                    <div class="hint">
                        <i class="bi bi-clock-history"></i>
                        อัปเดตล่าสุด
                    </div>
                </div>

                <?php if (!empty($news_items)) { ?>
                    <div class="swiper newsSwiper">
                        <div class="swiper-wrapper mb-3">
                            <?php foreach ($news_items as $news) {
                                $newsId = (int)($news['news_id'] ?? 0);
                                $newsName = (string)($news['news_name'] ?? '');
                                $newsDetail = (string)($news['news_detail'] ?? '');
                                $newsDate = (string)($news['news_date'] ?? '');
                                $newsImage = (string)($news['news_image'] ?? '');
                                $stationName = (string)($news['station_name'] ?? '');
                                $excerpt = artsky_news_excerpt($newsDetail, 170);
                                $imgSrc = ($newsImage !== '')
                                    ? ('./images/news/' . rawurlencode(basename($newsImage)))
                                    : './images/station_image/no-img.png';
                            ?>
                                <div class="swiper-slide">
                                    <a class="news-link" href="news-detail?id=<?= $newsId ?>" aria-label="อ่านข่าว: <?= htmlspecialchars($newsName) ?>">
                                        <div class="news-card">
                                            <img class="news-thumb img-fluid" style="object-fit: cover;" src="<?= htmlspecialchars($imgSrc) ?>" alt="<?= htmlspecialchars($newsName) ?>" onerror="this.src='./images/station_image/no-img.png';" />
                                            <div class="p-3">
                                                <div class="news-meta">
                                                    <span class="news-pill">
                                                        <i class="bi bi-calendar2-week"></i>
                                                        <?= htmlspecialchars(function_exists('DateThais') ? DateThais($newsDate) : $newsDate) ?>
                                                    </span>
                                                    <?php if ($stationName !== '') { ?>
                                                        <span class="news-pill">
                                                            <i class="bi bi-geo-alt"></i>
                                                            <?= htmlspecialchars($stationName) ?>
                                                        </span>
                                                    <?php } ?>
                                                </div>
                                                <div class="news-name fkanit"><?= htmlspecialchars($newsName) ?></div>
                                                <p class="news-desc"><?= htmlspecialchars($excerpt !== '' ? $excerpt : 'รายละเอียดข่าวสารอยู่ระหว่างอัปเดต') ?></p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="swiper-button-next news-swiper-next"></div>
                        <div class="swiper-button-prev news-swiper-prev"></div>
                        <div class="swiper-pagination news-swiper-pagination"></div>
                        <div class="text-end"><a class="btn btn-success" href="news">อ่านทั้งหมด</a></div>
                    </div>
                <?php } else { ?>
                    <div class="text-center py-4" style="color: rgba(148, 163, 184, 0.95);">
                        <i class="bi bi-info-circle me-1"></i>
                        ยังไม่มีข่าวสารในขณะนี้
                    </div>
                <?php } ?>
            </div>
        </section>

        <!-- ======= Page Header / Swiper ======= -->
        <section>
            <div class="page-header d-flex align-items-center">
                <div class="container-fluid">
                    <div class="hero-glass" data-aos="fade-up" data-aos-delay="230">
                        <div class="hero-inner text-center mb-3">
                            <div class="hero-tagline">
                                <span class="dot"></span> Platform เพื่อคนรักท้องฟ้ามืดและดาราศาสตร์
                            </div>
                            <h1 class="hero-title">ART SKY – แผนที่ท้องฟ้ามืดของประเทศไทย</h1>
                            <p class="hero-subtitle">
                                สำรวจพื้นที่ท้องฟ้ามืด สถานีตรวจวัด และที่พักแนะนำนอนดูดาว
                                ที่ออกแบบมาสำหรับนักท่องเที่ยวดาราศาสตร์และนักวิจัยด้านมลภาวะแสง
                            </p>
                            <div class="hero-divider"></div>
                        </div>

                        <div class="swiper mySwiper">
                            <div class="swiper-wrapper mb-5">
                                <div class="swiper-slide">
                                    <div class="swiper-slide-inner">
                                        <img src="./images/art-sky-logo.png" alt="ART SKY Logo" class="img-fluid">
                                        <h3 class="mt-2 color-sky">แอปพลิเคชันแผนที่ดาว</h3>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="swiper-slide-inner">
                                        <img src="./images/logo-sci.png" alt="Science Faculty Logo" class="img-fluid">
                                        <h3 class="mt-2 color-sky">คณะวิทยาศาสตร์และเทคโนโลยี</h3>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="swiper-slide-inner">
                                        <img src="./images/crru.png" alt="CRRU Logo" class="img-fluid">
                                        <h3 class="mt-2 color-sky">Chiang Rai Rajabhat University</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ======= Stations ======= -->
        <section class="dark-sky-section pt-4 pt-md-5">
            <div class="col-lg-12 text-center">
                <div class="section-header" data-aos="fade-up">
                    <h1 class="hero-title">พื้นที่ท้องฟ้ามืด</h1>
                </div>
            </div>

            <div class="dark-sky-shell" data-aos="fade-up" data-aos-delay="150">
                <div class="dark-sky-grid" id="darkSkyGrid">
                    <?php
                    $sql_st = " SELECT * FROM tbl_station ORDER BY station_id ASC ";
                    $result_st = mysqli_query($conn, $sql_st);
                    $no_st = 1;
                    while ($rs_st = mysqli_fetch_assoc($result_st)) {
                        $station_image = $rs_st['station_image'] != '' ? $rs_st['station_image'] : 'no-img.png';
                    ?>
                        <div class="dark-sky-item">
                            <a class="dark-sky-card" href="station?id=<?= (int)$rs_st['station_id'] ?>" aria-label="ดูรายละเอียด <?= htmlspecialchars($rs_st['station_name']) ?>">
                                <div class="dark-sky-media">
                                    <img src="images/station_image/<?= htmlspecialchars($station_image) ?>" alt="<?= htmlspecialchars($rs_st['station_name']) ?>" onerror="this.src='images/station_image/no-img.png';" />
                                    <span class="dark-sky-badge">
                                        <i class="bi bi-stars"></i>
                                        พื้นที่ดูดาว
                                    </span>
                                </div>
                                <div class="dark-sky-body">
                                    <h3 class="dark-sky-name fkanit"><?= htmlspecialchars($rs_st['station_name']) ?></h3>
                                    <p class="dark-sky-desc">
                                        <span id="stat_des_<?= $no_st ?>">ท้องฟ้าปลอดโปร่ง อุณหภูมิเพิ่มขึ้น 1-2 องศา</span>
                                    </p>
                                </div>
                            </a>
                        </div>
                    <?php $no_st++;
                    } ?>
                </div>
                <div class="dark-sky-more" id="darkSkyMore" hidden>
                    <button class="dark-sky-more-btn" type="button" id="darkSkyMoreBtn">
                        ดูเพิ่มเติม
                        <i class="bi bi-chevron-down"></i>
                    </button>
                </div>
            </div>
        </section>

        <!-- ======= Hotels ======= -->
        <section class="hotel-sky-section mt-5 pt-4 pt-md-5">
            <div class="col-lg-12 text-center">
                <div class="section-header" data-aos="fade-up">
                    <h2 class="hero-title p-2">ART SKY Places</h2>
                    <p>ที่พักแนะนำสำหรับนอนดูดาวใกล้พื้นที่ท้องฟ้ามืด</p>
                </div>
            </div>

            <div class="hotel-sky-shell" data-aos="fade-up" data-aos-delay="150">
                <div class="hotel-sky-grid" id="hotelSkyGrid">
                    <?php
                    $sql_hotel1 = " SELECT * FROM tbl_hotel WHERE tbl_hotel.hotel_status = 1 ORDER BY tbl_hotel.hotel_id ASC ";
                    $result_hotel1 = mysqli_query($conn, $sql_hotel1);
                    while ($rs_hotel1 = mysqli_fetch_assoc($result_hotel1)) {
                        $sql_img1 = " SELECT tbl_hotel_image.hotel_image_name FROM tbl_hotel_image 
                          WHERE tbl_hotel_image.hotel_id = '{$rs_hotel1["hotel_id"]}' 
                          ORDER BY tbl_hotel_image.hotel_image_id ASC LIMIT 1 ";
                        $result_img1 = mysqli_query($conn, $sql_img1);
                        $rs_img1 = mysqli_fetch_assoc($result_img1);
                        $imgName = $rs_img1['hotel_image_name'] ?? 'no-img.png';
                    ?>
                        <div class="hotel-sky-item">
                            <a class="hotel-sky-card" href="hotel" aria-label="ดูที่พัก <?= htmlspecialchars($rs_hotel1['hotel_name']) ?>">
                                <div class="hotel-sky-media">
                                    <img src="./images/hotel_image/<?= htmlspecialchars($imgName) ?>" alt="<?= htmlspecialchars($rs_hotel1['hotel_name']) ?>" onerror="this.src='./images/hotel_image/no-img.png';" />
                                    <span class="hotel-sky-badge">
                                        <i class="bi bi-house-heart"></i>
                                        ที่พักดูดาว
                                    </span>
                                </div>
                                <div class="hotel-sky-body">
                                    <h3 class="hotel-sky-name fkanit">
                                        <?= htmlspecialchars($rs_hotel1['hotel_name']) ?>
                                    </h3>
                                    <p class="hotel-sky-price">
                                        เริ่มต้น <?= number_format((float)$rs_hotel1['hotel_price']) ?>฿
                                    </p>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                </div>
                <div class="dark-sky-more hotel-sky-more" id="hotelSkyMore" hidden>
                    <button class="dark-sky-more-btn" type="button" id="hotelSkyMoreBtn">
                        ดูเพิ่มเติม
                        <i class="bi bi-chevron-down"></i>
                    </button>
                </div>
            </div>
        </section>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <?php require './layout/footer.php'; ?>
    <!-- End Footer -->

    <a href="#" class="scroll-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <div id="preloader">
        <div class="line"></div>
    </div>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

    <!-- Swiper JS -->
    <script src="./app/node_modules/swiper/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
        if (document.querySelector('.mySwiper')) {
            const heroSwiper = new Swiper(".mySwiper", {
                spaceBetween: 30,
                centeredSlides: true,
                autoplay: {
                    delay: 7000,
                    disableOnInteraction: false,
                },
                loop: true,
                pagination: {
                    el: ".mySwiper .swiper-pagination",
                    clickable: true
                },
                navigation: {
                    nextEl: ".mySwiper .swiper-button-next",
                    prevEl: ".mySwiper .swiper-button-prev"
                },
            });
        }

        if (document.querySelector('.newsSwiper')) {
            const newsSwiper = new Swiper(".newsSwiper", {
                spaceBetween: 14,
                slidesPerView: 1,
                autoplay: {
                    delay: 4500,
                    disableOnInteraction: false,
                },
                loop: <?= $news_swiper_loop ? 'true' : 'false' ?>,
                pagination: {
                    el: ".news-swiper-pagination",
                    clickable: true,
                },
                navigation: {
                    nextEl: ".news-swiper-next",
                    prevEl: ".news-swiper-prev",
                },
                breakpoints: {
                    768: {
                        slidesPerView: 2,
                    },
                    992: {
                        slidesPerView: 3,
                    }
                }
            });
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const setupExpandableGrid = ({
                gridId,
                itemSelector,
                moreId,
                moreBtnId
            }) => {
                const grid = document.getElementById(gridId);
                const moreWrap = document.getElementById(moreId);
                const moreBtn = document.getElementById(moreBtnId);

                if (!grid || !moreWrap || !moreBtn) return null;

                const items = Array.from(grid.querySelectorAll(itemSelector));
                let visibleCount = 0;

                const getBatchSize = () => 4;

                const renderItems = () => {
                    items.forEach((item, index) => {
                        item.hidden = index >= visibleCount;
                    });
                    moreWrap.hidden = visibleCount >= items.length;
                };

                const resetItems = () => {
                    const batchSize = getBatchSize();
                    visibleCount = Math.min(items.length, batchSize);
                    renderItems();
                };

                moreBtn.addEventListener("click", () => {
                    const batchSize = getBatchSize();
                    visibleCount = Math.min(items.length, visibleCount + batchSize);
                    renderItems();
                });

                resetItems();

                return resetItems;
            };

            const resetHandlers = [
                setupExpandableGrid({
                    gridId: "darkSkyGrid",
                    itemSelector: ".dark-sky-item",
                    moreId: "darkSkyMore",
                    moreBtnId: "darkSkyMoreBtn"
                }),
                setupExpandableGrid({
                    gridId: "hotelSkyGrid",
                    itemSelector: ".hotel-sky-item",
                    moreId: "hotelSkyMore",
                    moreBtnId: "hotelSkyMoreBtn"
                })
            ].filter(Boolean);

            let resizeTimer;
            window.addEventListener("resize", () => {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => {
                    resetHandlers.forEach((resetItems) => resetItems());
                }, 180);
            });
        });
    </script>

    <!-- Station sky condition via OneCall + Counter Animation -->
    <script>
        async function stationTemp(lat, lon, id) {
            try {
                const responseOne = await axios.get(`weather-api.php?endpoint=onecall&lat=${encodeURIComponent(lat)}&lon=${encodeURIComponent(lon)}`);
                let itemOne = responseOne.data;
                $('#dew_point_value').text(itemOne.current.dew_point);

                let itemOnes = responseOne.data.daily;
                let dataContent = '';
                for (let index = 0; index < itemOnes.length; index++) {
                    const item = itemOnes[index];
                    const skyData = parseInt(item.weather[0].icon, 10); // "01d" -> 1
                    if (index == 0) {
                        if (skyData >= 1 && skyData <= 3) {
                            if (skyData == 1) dataContent = `${item.weather[0].description} เหมาะสมแก่การดูดาว`;
                            else dataContent = `ท้องฟ้ามี${item.weather[0].description} เหมาะสมแก่การดูดาว`;
                        } else dataContent = `ท้องฟ้ามี${item.weather[0].description} ยังไม่เหมาะสมแก่การดูดาว`;
                        document.getElementById(id).innerHTML = dataContent;
                    }
                }
            } catch (error) {
                console.error(error);
            }
        }
        <?php
        $sql_st2 = " SELECT * FROM tbl_station ORDER BY station_id ASC ";
        $result_st2 = mysqli_query($conn, $sql_st2);
        $no_st2 = 1;
        while ($rs_st2 = mysqli_fetch_assoc($result_st2)) {
            $lats = $rs_st2["station_lat"];
            $lons = $rs_st2["station_long"];
            $ctid = 'stat_des_' . $no_st2;
            $no_st2++;
            echo "stationTemp('" . addslashes($lats) . "', '" . addslashes($lons) . "', '" . addslashes($ctid) . "');\n";
        } ?>

        function animateCounter(el, duration = 1500) {
            const target = parseInt(el.getAttribute("data-count"), 10);
            const start = 0;
            const startTime = performance.now();

            function update(now) {
                const progress = Math.min((now - startTime) / duration, 1);
                const value = Math.floor(progress * (target - start) + start);
                el.textContent = value.toLocaleString();
                if (progress < 1) {
                    requestAnimationFrame(update);
                } else {
                    el.classList.add("animated");
                    setTimeout(() => el.classList.remove("animated"), 360);
                }
            }
            requestAnimationFrame(update);
        }

        document.addEventListener("DOMContentLoaded", () => {
            const counters = document.querySelectorAll(".counter");
            counters.forEach(counter => animateCounter(counter, 2000));
        });
    </script>

</body>

</html>
