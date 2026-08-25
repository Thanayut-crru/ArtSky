<?php
require './config/connect.php';
require './config/function.php';

// Support either `tbl_news` or `news` as table name
$news_table = 'tbl_news';
try {
    $probe = mysqli_query($conn, "SELECT 1 FROM tbl_news LIMIT 1");
    if ($probe === false) {
        $news_table = 'news';
    }
} catch (Throwable $e) {
    $news_table = 'news';
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
    <meta name="theme-color" content="#ffffff">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/main2.css" rel="stylesheet">

    <!-- Swiper & Slick -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" type="text/css" href="./assets/vendor/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="./assets/vendor/slick/slick-theme.css" />

    <style>
        body {
            background: url("./images/head_bg.jpg") no-repeat top center fixed;
            background-size: cover;
            min-height: 100vh;
            position: relative;
            color: #e2e8f0;
        }

        .fkanit {
            font-family: "Noto Serif Thai", serif;
            font-weight: 400;
            font-style: normal;
        }

        .color-sky {
            color: rgba(255, 255, 255, 0.8);
        }

        .art-sky-img {
            aspect-ratio: 16 / 9;
            object-fit: cover;
            width: 100%;
            display: block;
        }

        #header {
            background: transparent;
            border-bottom: none;
        }

        .bg-skys {
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-radius: 18px;
            border: 1px solid rgba(148, 163, 184, 0.28);
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.9);
        }

        .page-wrapper {
            padding-top: 7rem;
            padding-bottom: 4rem;
        }

        .section-header h2 {
            font-size: clamp(1.8rem, 3vw, 2.4rem);
            font-weight: 700;
            color: #e0f2fe;
            letter-spacing: 0.04em;
        }

        .section-header p {
            color: rgba(226, 232, 240, 0.8);
            margin-bottom: 0;
        }

        .section-header::after {
            content: "";
            display: block;
            width: 80px;
            height: 3px;
            margin: 1rem auto 0;
            border-radius: 999px;
            background: linear-gradient(to right, #38bdf8, #22c55e);
        }

        .art-skys2.slider {
            margin-top: 2rem;
        }

        .slick-slide {
            margin: 0 16px;
        }

        .slick-slide img {
            width: 100%;
        }

        .card-highlight {
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid rgba(148, 163, 184, 0.4);
            background:
                radial-gradient(circle at top left, rgba(15, 23, 42, 0.95), rgba(15, 23, 42, 0.8));
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        }

        .card-highlight:hover {
            transform: translateY(-4px);
            border-color: rgba(56, 189, 248, 0.85);
            box-shadow: 0 22px 60px rgba(15, 23, 42, 0.95);
        }

        .card-highlight .card-body {
            padding: 1rem 1.25rem 0.9rem;
        }

        .card-highlight .card-title a {
            font-size: 1rem;
            font-weight: 600;
            color: #e2e8f0;
            text-decoration: none;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .card-highlight .card-title a:hover {
            color: #7dd3fc;
        }

        .card-highlight .card-text a {
            font-size: 0.85rem;
            color: rgba(148, 163, 184, 0.9);
            text-decoration: none;
        }

        .card-highlight .card-text a i {
            margin-right: 0.25rem;
        }

        .card-highlight .card-text a:hover {
            color: #e2e8f0;
        }

        .postList .card {
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid rgba(148, 163, 184, 0.3);
            background:
                radial-gradient(circle at top left, rgba(15, 23, 42, 0.96), rgba(15, 23, 42, 0.85));
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        }

        .postList .card:hover {
            transform: translateY(-6px);
            border-color: rgba(34, 197, 94, 0.9);
            box-shadow: 0 22px 55px rgba(15, 23, 42, 0.95);
        }

        .postList .card-body {
            padding: 1rem 1.25rem 0.9rem;
        }

        .postList .card-title a {
            font-size: 1rem;
            font-weight: 600;
            color: #e2e8f0;
            text-decoration: none;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .postList .card-title a:hover {
            color: #bef264;
        }

        .postList .card-text a {
            font-size: 0.85rem;
            color: rgba(148, 163, 184, 0.9);
            text-decoration: none;
        }

        .postList .card-text a:hover {
            color: #e2e8f0;
        }

        .loadmore {
            margin-top: 2.5rem;
        }

        #loadBtn {
            padding: 0.65rem 1.75rem;
            border-radius: 999px;
            font-weight: 600;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            box-shadow: 0 15px 40px rgba(22, 163, 74, 0.5);
        }

        #loadBtn i {
            font-size: 1rem;
        }

        #loadBtn:hover {
            background: linear-gradient(135deg, #4ade80, #22c55e);
        }

        #loadBtn:active {
            transform: translateY(1px);
            box-shadow: 0 10px 28px rgba(22, 163, 74, 0.55);
        }

        @media (max-width: 991.98px) {
            .page-wrapper {
                padding-top: 6.5rem;
            }
        }

        @media (max-width: 767.98px) {
            .slick-slide {
                margin: 0 8px;
            }
        }
    </style>
</head>

<body>

    <!-- ======= Header ======= -->
    <?php require './layout/header.php'; ?>
    <!-- End Header -->

    <main id="main" data-aos="fade" data-aos-delay="1500">
        <div class="page-wrapper">
            <div class="container">
                <div class="col-lg-12 text-center">
                    <div class="section-header">
                        <h2 class="fkanit">Art Sky News</h2>
                        <p>ข่าวสารจาก ART SKY</p>
                    </div>
                </div>
            </div>

            <!-- Top Highlight Slider -->
            <section class="art-skys2 slider mt-4">
                <?php
                $sql_news = " SELECT * FROM {$news_table} ORDER BY {$news_table}.news_id DESC LIMIT 6";
                $result_news = mysqli_query($conn, $sql_news);
                while ($result_news !== false && ($rs_news = mysqli_fetch_assoc($result_news))) {
                    $news_image_safe = basename((string)($rs_news['news_image'] ?? ''));
                    $news_image_src = ($news_image_safe !== '')
                        ? ('./images/news/' . rawurlencode($news_image_safe))
                        : './images/station_image/no-img.png';
                ?>
                    <div class="slide m-1">
                        <div class="col-lg-11 col-md-11 mx-auto">
                            <div class="card card-highlight border-0">
                                <img src="<?= htmlspecialchars($news_image_src) ?>" class="card-img-top art-sky-img" alt="<?= htmlspecialchars($rs_news['news_name'] ?? '') ?>" onerror="this.src='./images/station_image/no-img.png';" />
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="news-detail?id=<?= (int)($rs_news['news_id'] ?? 0) ?>">
                                            <?= mb_substr((string)($rs_news['news_name'] ?? ''), 0, 50, 'UTF-8'); ?>...
                                        </a>
                                    </h5>
                                    <p class="card-text text-end mb-0">
                                        <a href="news-detail?id=<?= (int)($rs_news['news_id'] ?? 0) ?>">
                                            <i class="bi bi-clock"></i>
                                            <?= isset($rs_news['news_date']) ? date_inters($rs_news['news_date']) : '' ?>
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </section>

            <!-- News Grid + Load More -->
            <section class="mt-5">
                <div class="container-fluid">
                    <div class="row postList g-4 g-lg-5">
                        <?php
                        $count_query = " SELECT count(*) as allcount FROM {$news_table} ";
                        $count_result = mysqli_query($conn, $count_query);
                        $count_fetch = ($count_result !== false) ? mysqli_fetch_assoc($count_result) : array('allcount' => 0);
                        $postCount = (int)($count_fetch['allcount'] ?? 0);
                        $limit = 3;

                        $query = " SELECT * FROM {$news_table} ORDER BY news_id DESC LIMIT 0," . $limit;
                        $result = mysqli_query($conn, $query);
                        if ($result !== false && $result->num_rows > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $news_image_safe = basename((string)($row['news_image'] ?? ''));
                                $news_image_src = ($news_image_safe !== '')
                                    ? ('./images/news/' . rawurlencode($news_image_safe))
                                    : './images/station_image/no-img.png';
                        ?>
                                <div class="col-lg-4 col-md-6">
                                    <div class="card border-0 bg-skys">
                                        <img src="<?= htmlspecialchars($news_image_src) ?>" class="card-img-top art-sky-img" alt="<?= htmlspecialchars($row['news_name'] ?? '') ?>" onerror="this.src='./images/station_image/no-img.png';" />
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <a href="news-detail?id=<?= (int)($row['news_id'] ?? 0) ?>">
                                                    <?= mb_substr((string)($row['news_name'] ?? ''), 0, 50, 'UTF-8'); ?>...
                                                </a>
                                            </h5>
                                            <p class="card-text text-end mb-0">
                                                <a href="news-detail?id=<?= (int)($row['news_id'] ?? 0) ?>">
                                                    <i class="bi bi-clock"></i>
                                                    <?= isset($row['news_date']) ? date_inters($row['news_date']) : '' ?>
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>

                    <div class="loadmore col-12 text-center">
                        <button type="button" id="loadBtn" class="btn btn-success">
                            <i class="bi bi-arrow-clockwise"></i> แสดงมากขึ้น
                        </button>
                        <input type="hidden" id="row" value="0">
                        <input type="hidden" id="postCount" value="<?php echo $postCount; ?>">
                    </div>
                </div>
            </section>
        </div>
    </main>

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
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
        integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script type="text/javascript" src="./assets/vendor/slick/slick.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.art-skys2').slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 3000,
                arrows: false,
                dots: false,
                pauseOnHover: true,
                responsive: [{
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 2
                    }
                }, {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 1
                    }
                }]
            });
        });

        $(document).ready(function() {
            $(document).on('click', '#loadBtn', function() {
                var row = Number($('#row').val());
                var count = Number($('#postCount').val());
                var limit = 3;
                row = row + limit;
                $('#row').val(row);
                $("#loadBtn").val('Loading...');

                $.ajax({
                    type: 'POST',
                    url: 'loadmore-news.php',
                    data: 'row=' + row,
                    success: function(data) {
                        var rowCount = row + limit;
                        $('.postList').append(data);
                        if (rowCount >= count) {
                            $('#loadBtn').css("display", "none");
                        } else {
                            $("#loadBtn").val('Load More');
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>
