<?php
include('./config/connect.php');
include('./config/function.php');
if (isset($_POST['row'])) {
    $start = $_POST['row'];
    $limit = 3;
    $query = " SELECT * FROM tbl_blog ORDER BY blog_id desc LIMIT " . $start . "," . $limit;
    $result = mysqli_query($conn, $query);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
?>
            <div class="col-lg-4 col-md-4">
                <div class="card border border-0 bg-skys">
                    <img src="./images/blog/<?= $row['blog_image'] ?>" class="card-img-top art-sky-img" alt="<?= $row['blog_name'] ?>" />
                    <div class="card-body">
                        <h5 class="card-title"><a href="blog-detail?id=<?= $row['blog_id'] ?>"><?= mb_substr($row['blog_name'], 0, 50, 'UTF-8'); ?>...</a></h5>
                        <p class="card-text text-end"><a href="blog-detail?id=<?= $row['blog_id'] ?>"><i class="bi bi-clock"></i> <?= date_inters($row['blog_date']) ?></a></p>
                    </div>
                </div>
            </div>
<?php }
    }
}
?>