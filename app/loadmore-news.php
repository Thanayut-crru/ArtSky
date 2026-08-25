<?php
include('./config/connect.php');
include('./config/function.php');

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

if (isset($_POST['row'])) {
    $start = (int)$_POST['row'];
    if ($start < 0) {
        $start = 0;
    }

    $limit = 3;
    $query = " SELECT * FROM {$news_table} ORDER BY news_id desc LIMIT {$start},{$limit}";
    $result = mysqli_query($conn, $query);

    if ($result !== false && $result->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $news_image_safe = basename((string)($row['news_image'] ?? ''));
            $news_image_src = ($news_image_safe !== '')
                ? ('./images/news/' . rawurlencode($news_image_safe))
                : './images/station_image/no-img.png';
?>
            <div class="col-lg-4 col-md-4">
                <div class="card border border-0 bg-skys">
                    <img src="<?= htmlspecialchars($news_image_src) ?>" class="card-img-top art-sky-img" alt="<?= htmlspecialchars($row['news_name'] ?? '') ?>" onerror="this.src='./images/station_image/no-img.png';" />
                    <div class="card-body">
                        <h5 class="card-title"><a href="news-detail?id=<?= (int)($row['news_id'] ?? 0) ?>"><?= mb_substr((string)($row['news_name'] ?? ''), 0, 50, 'UTF-8'); ?>...</a></h5>
                        <p class="card-text text-end"><a href="news-detail?id=<?= (int)($row['news_id'] ?? 0) ?>"><i class="bi bi-clock"></i> <?= isset($row['news_date']) ? date_inters($row['news_date']) : '' ?></a></p>
                    </div>
                </div>
            </div>
<?php
        }
    }
}
?>
