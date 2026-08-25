<?php
require 'config/connect.php';
require 'config/function.php';
?>
<!DOCTYPE html>
<html>

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
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

  <link href="assets/css/main2.css" rel="stylesheet">

  <!-- fancybox -->
  <link href="app/plugins/fancybox/fancybox.css" rel="stylesheet" />

  <style>
    .offcanvas-btn-box {
      transition: transform .3s ease-in-out;
      /* same as what's on the panel */
    }

    .offcanvas.show+div .offcanvas-btn-box {
      transform: translateX(400px);
      position: relative;
      z-index: 1100;
    }


    /* optional junk to toggle the button text */
    .offcanvas-btn-box .btn span:last-child,
    .offcanvas.show+div .offcanvas-btn-box .btn span:first-child {
      display: none;
    }

    .offcanvas.show+div .offcanvas-btn-box .btn span:last-child {
      display: inline;
    }

    #demo {
      background: url("./images/head_bg.jpg") no-repeat top center fixed;
      background-size: cover;
    }

    .bg-6cards {
      background-color: rgba(203, 221, 246, 0.7);
    }

    .color-sky {
      color: rgba(255, 255, 255, 0.8);
    }

    .text-for7day {
      color: #4281b7;
    }

    .text-for7day a {
      color: #4281b7;
    }

    .text-for7day a:hover {
      color: rgba(203, 221, 246, 0.7);
    }
  </style>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> -->
</head>

<body class="bg-dark">

  <div id="map" style="width: 100%; height:100vh;"></div>
  <div class="offcanvas offcanvas-start shadow-sm border-0" data-bs-scroll="true" data-bs-backdrop="false" id="demo">
    <div class="offcanvas-header">
      <h2 class="offcanvas-title">
        <a class="text-decoration-none text-light" href="index">
          <i class="bi bi-moon-stars text-success"></i>
          ART SKY
        </a>
      </h2>
      <div class="ms-auto text-light">
        <a href="hotel-profile" class="btn btn-warning"><i class="far fa-user"></i> สำหรับผู้ประกอบการ</a>
      </div>
    </div>
    <div class="offcanvas-body m-1 p-1">
      <div class="input-group mb-3">
        <input type="search" id="search_data" class="form-control" placeholder="" aria-describedby="button-addon2">
        <button class="btn btn-success" type="button" id="button-addon2" disabled><i class="fas fa-search"></i> ค้นหา</button>
        <button class="btn btn-primary" type="button" id="button-addon3"><i class="fas fa-search"></i> ที่ตั้ง</button>
      </div>
      <div id="content">
        <?php
        $sql_hotel = " SELECT * FROM tbl_hotel WHERE tbl_hotel.hotel_status = 1 ORDER BY tbl_hotel.hotel_id ASC ";
        $result_hotel = mysqli_query($conn, $sql_hotel);
        while ($rs_hotel = mysqli_fetch_assoc($result_hotel)) {
          $sql_img = " SELECT tbl_hotel_image.hotel_image_name FROM tbl_hotel_image 
        WHERE tbl_hotel_image.hotel_id = '{$rs_hotel["hotel_id"]}' ORDER BY tbl_hotel_image.hotel_image_id ASC LIMIT 1 ";
          $result_img = mysqli_query($conn, $sql_img);
          $rs_img = mysqli_fetch_assoc($result_img);
        ?>
          <div class="d-flex bg-6cards p-3 rounded-3 mb-1">
            <div class="flex-grow-1 ms-3">
              <h5 class="text-for7day"><a href="hotel_popup?id=<?= $rs_hotel['hotel_id'] ?>" class="hotel-details-lightbox" data-glightbox="type: external"><?= $rs_hotel['hotel_name'] ?></a></h5>
              <p class="text-light">
                <?= number_format($rs_hotel['hotel_price'], 2) ?>฿/คืน
              <div>
                <a href="tel:<?= $rs_hotel['hotel_telephone'] ?>" class="btn btn-primary"><i class="fas fa-phone-square-alt"></i> โทรศัพท์</a>
                <a href="https://line.me/ti/p/~<?= $rs_hotel['hotel_line'] ?>" target="_blank" class="btn btn-success"><i class="fab fa-line"></i> ไลน์</a>
              </div>
              </p>
            </div>
            <div class="flex-shrink-0">
              <img src="images/hotel_image/<?= $rs_img['hotel_image_name'] ?>" width="100" class="img-fluid rounded-3" alt="..." style="aspect-ratio: 1 / 1; object-fit:cover">
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
  <div class="container-fluid d-none" style="position:relative; height:100%; margin-top:-50vh">
    <div class="offcanvas-btn-box">
      <button class="btn btn-light d-block" id="show-content" type="button" data-bs-toggle="offcanvas" data-bs-target="#demo">
        <span><i class="fas fa-caret-right"></i></span><span><i class="fas fa-caret-left"></i></span>
      </button>
    </div>
  </div>

  <!-- Vendor JS Files -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script type="text/javascript" src="./app/node_modules/axios/dist/axios.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>

  <!-- fancybox -->
  <script src="app/plugins/fancybox/fancybox.umd.js"></script>

  <script type="text/javascript">
    $(function() {
      var width = $(window).width();
      var height = $(window).height();

      if (width > 768) {
        // หน้าจอขนาดใหญ่ (เดสก์ท็อป)
        $('#show-content').click();
        // offcanvas-start
        $('#demo').removeClass('offcanvas-bottom');
        $('#demo').addClass('offcanvas-start');
      } else if (width <= 768 && width >= 480) {
        // หน้าจอขนาดกลาง (แท็บเล็ต)
        $('#show-content').click();
        $('#demo').removeClass('offcanvas-bottom');
        $('#demo').addClass('offcanvas-start');
      } else {
        // หน้าจอขนาดเล็ก (มือถือ)
        $('#show-content').click();
        $('#demo').removeClass('offcanvas-start');
        $('#demo').addClass('offcanvas-bottom');
        console.log("หน้าจอขนาดเล็ก");
      }
    });
  </script>
  <script>
    <?php
    $sql_hotel0 = " SELECT * FROM tbl_hotel WHERE tbl_hotel.hotel_status = 1 ORDER BY tbl_hotel.hotel_id ASC LIMIT 1 ";
    $result_hotel0 = mysqli_query($conn, $sql_hotel0);
    $rs_hotel0 = mysqli_fetch_assoc($result_hotel0)
    ?>
    const map = L.map('map').setView([<?= $rs_hotel0['hotel_lat'] ?>, <?= $rs_hotel0['hotel_lon'] ?>], 13);

    const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    const popup = L.popup()
      .setLatLng([<?= $rs_hotel0['hotel_lat'] ?>, <?= $rs_hotel0['hotel_lon'] ?>])
      .setContent('ยินดีต้อนรับสู่ ART SKY')
      .openOn(map);

    <?php
    $sql_hotel1 = " SELECT * FROM tbl_hotel WHERE tbl_hotel.hotel_status = 1 ORDER BY tbl_hotel.hotel_id ASC ";
    $result_hotel1 = mysqli_query($conn, $sql_hotel1);
    while ($rs_hotel1 = mysqli_fetch_assoc($result_hotel1)) {
      $sql_img1 = " SELECT tbl_hotel_image.hotel_image_name FROM tbl_hotel_image 
      WHERE tbl_hotel_image.hotel_id = '{$rs_hotel1["hotel_id"]}' ORDER BY tbl_hotel_image.hotel_image_id ASC LIMIT 1 ";
      $result_img1 = mysqli_query($conn, $sql_img1);
      $rs_img1 = mysqli_fetch_assoc($result_img1);
    ?>
      const marker<?= $rs_hotel1['hotel_id'] ?> = L.marker([<?= $rs_hotel1['hotel_lat'] ?>, <?= $rs_hotel1['hotel_lon'] ?>]).addTo(map)
        .bindPopup('<div class="text-center"><img src="images/hotel_image/<?= $rs_img1['hotel_image_name'] ?>" class="rounded-circle border-1 shadow-sm" width="50" style="aspect-ratio: 1 / 1; object-fit:cover"></div><div><?= $rs_hotel1['hotel_name'] ?></div>').openPopup();
    <?php
    }
    ?>

    function onMapClick(e) {
      popup
        .setLatLng(e.latlng)
        .setContent(`${e.latlng.lat.toFixed(3)},${e.latlng.lng.toFixed(2)}`)
        .openOn(map);
    }

    map.on('click', onMapClick);


    $('#button-addon2').click(async () => {
      let dt_content = '';
      try {
        const response = await axios.post('hotel_ajax.php', {
          search: $('#search_data').val()
        });
        console.log(response.data);
        let arr_data = response.data
        for (let index = 0; index < arr_data.length; index++) {
          const mydata = arr_data[index];
          dt_content += `<div class="d-flex bg-6cards p-3 rounded-3 mb-1">
                          <div class="flex-grow-1 ms-3">
                            <h5 class="text-for7day">${mydata.hotel_name}</h5>
                            <p class="text-light">
                            ${mydata.hotel_price}฿/คืน
                            <div>
                              <a href="tel:${mydata.hotel_telephone}" class="btn btn-primary"><i class="fas fa-phone-square-alt"></i> โทรศัพท์</a>
                              <a href="https://line.me/ti/p/~${mydata.hotel_line}" target="_blank" class="btn btn-success"><i class="fab fa-line"></i> ไลน์</a>
                            </div>
                            </p>
                          </div>
                          <div class="flex-shrink-0">
                            <img src="images/hotel_image/${mydata.hotel_image_name}" width="100" class="img-fluid rounded-3" alt="..." style="aspect-ratio: 1 / 1; object-fit:cover">
                          </div>
                        </div>`;
        }
        $('#content').html(dt_content);
      } catch (error) {
        console.error(error);
      }
    });

    async function listData() {
      let dt_content = '';
      try {
        const response = await axios.post('hotel_ajax.php', {
          search: ''
        });
        console.log(response.data);
        let arr_data = response.data
        for (let index = 0; index < arr_data.length; index++) {
          const mydata = arr_data[index];
          dt_content += `<div class="d-flex bg-6cards p-3 rounded-3 mb-1">
                          <div class="flex-grow-1 ms-3">
                            <h5 class="text-for7day">${mydata.hotel_name}</h5>
                            <p class="text-light">
                            ${mydata.hotel_price}฿/คืน
                            <div>
                              <a href="tel:${mydata.hotel_telephone}" class="btn btn-primary"><i class="fas fa-phone-square-alt"></i> โทรศัพท์</a>
                              <a href="https://line.me/ti/p/~${mydata.hotel_line}" target="_blank" class="btn btn-success"><i class="fab fa-line"></i> ไลน์</a>
                            </div>
                            </p>
                          </div>
                          <div class="flex-shrink-0">
                            <img src="images/hotel_image/${mydata.hotel_image_name}" width="100" class="img-fluid rounded-3" alt="..." style="aspect-ratio: 1 / 1; object-fit:cover">
                          </div>
                        </div>`;
        }
        $('#content').html(dt_content);
      } catch (error) {
        console.error(error);
      }
    }


    $('#search_data').on("input", function() {
      if ($('#search_data').val() === '') {
        $('#button-addon2').prop('disabled', true);
        listData();
      }
    });

    $('#search_data').on('keyup', function() {

      const search_data = $('#search_data').val();

      const txtMatch = search_data !== '';

      $('#button-addon2').prop('disabled', !txtMatch);
    });


    const portfolioDetailsLightbox = GLightbox({
      selector: '.hotel-details-lightbox',
      width: '90%',
      height: '90vh'
    });
  </script>
</body>

</html>
<?php
ob_end_flush();
?>