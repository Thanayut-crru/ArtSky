<?php
// Session start and Connect database
include('../config/connect.php');
include('../config/function.php');
/*ดรวจสอบ sesion user_admin ไม่เท่ากับค่าว่าง และ status_login มีค่าเท่ากับ ture (1) 
สามารถ login เข้าสู่ระบบได้อย่างถูกต้อง ไม่เข้าเงื่อนไขจะส่งกลับไปหน้า login.php */
if (isset($_SESSION['sess_admin_artsky']) && isset($_SESSION['sess_login_artsky'])) {
} elseif (isset($_COOKIE['cookie_admin_artsky']) && isset($_COOKIE['cookie_login_artsky'])) {
} else {
  header('location:login.php');
}
$id_emp = $_SESSION['sess_admin_artsky'] ?? $_COOKIE['cookie_admin_artsky'];
$sql_user_emp = " SELECT * FROM tbl_admin WHERE admin_id = '$id_emp' ";
$result_user_emp = mysqli_query($conn, $sql_user_emp);
$num_check_emp = mysqli_num_rows($result_user_emp);
if ($num_check_emp == 0) {
  header('location:logout.php');
}
$rs_user_emp = mysqli_fetch_assoc($result_user_emp);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ART SKY | Admin</title>

  <!-- Favicons -->
  <link rel="apple-touch-icon" sizes="180x180" href="../images/favicon_io/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../images/favicon_io/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../images/favicon_io/favicon-16x16.png">
  <link rel="manifest" href="../images/favicon_io/site.webmanifest">
  <link rel="mask-icon" href="../images/favicon_io/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">

  <!-- Google Font: Source Sans Pro -->
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+Thai&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">

  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">

  <!-- Custom styles for this page -->
  <link href="plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

  <!-- fancybox -->
  <link href="plugins/fancybox/fancybox.css" rel="stylesheet" />

  <!-- datepicker -->
  <link href="plugins/bootstrap-datepicker-thai/css/datepicker.css" rel="stylesheet" />

  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">

  <!-- MaterialDesign -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/4.7.95/css/materialdesignicons.css" rel="stylesheet" />

  <!-- For Before Upload -->
  <link href="plugins/bootstrap-fileinput/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
  <link href="plugins/bootstrap-fileinput/themes/explorer-fa6/theme.min.css" media="all" rel="stylesheet" type="text/css" />

  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.css">

  <!--  bootstrap-icons-->
  <link rel="stylesheet" href="./plugins/bootstrap-icons-1.7.2/bootstrap-icons.css">

  <!-- video-js -->
  <link href="https://vjs.zencdn.net/7.18.1/video-js.css" rel="stylesheet" />
  <!-- City -->
  <link href="https://unpkg.com/@videojs/themes@1/dist/city/index.css" rel="stylesheet">
  <!-- Fantasy -->
  <link href="https://unpkg.com/@videojs/themes@1/dist/fantasy/index.css" rel="stylesheet">
  <!-- Forest -->
  <link href="https://unpkg.com/@videojs/themes@1/dist/forest/index.css" rel="stylesheet">
  <!-- Sea -->
  <link href="https://unpkg.com/@videojs/themes@1/dist/sea/index.css" rel="stylesheet">

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <script src="./node_modules/axios/dist/axios.min.js"></script>
  <!-- Sweetalert2 -->
  <script src="plugins/sweetalert2/sweet-alert2.min.js"></script>

  <!-- Datatable -->
  <script src="plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="plugins/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="plugins/datatables/data.th.js"></script>

  <style>
    /* Paste this css to your style sheet file or under head tag */
    /* This only works with JavaScript,
        if it's not present, don't show loader */

    body {
      font-family: 'Noto Serif Thai', serif;
    }

    .no-js #loader {
      display: none;
    }

    .js #loader {
      display: block;
      position: absolute;
      left: 100px;
      top: 0;
    }

    .se-pre-con {
      position: fixed;
      left: 0px;
      top: 0px;
      width: 100%;
      height: 100%;
      z-index: 9999;
      background: url('../images/loading.jpg') center no-repeat #fff;
    }

    /* vdeojs  */
    video[poster] {
      object-fit: cover;
    }

    .vjs-poster {
      background-size: cover;
      background-position: inherit;
    }

    .centered-and-cropped {
      object-fit: cover;
      aspect-ratio: 1 / 1;
    }

    .art-sky-img {
      aspect-ratio: 16 / 9;
      object-fit: cover;
    }
  </style>
</head>

<body class="hold-transition accent-lightblue sidebar-mini layout-fixed">
  <!-- <div class="se-pre-con"></div> -->
  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark bg-gradient-lightblue border-0">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button" data-enable-remember="true"><i class="fas fa-bars"></i></a>
        </li>
      </ul>
      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" id="darkmodes" href="javascript:;" role="button">
            <i class="bi bi-moon-stars-fill"></i>
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
            <i class="far fa-user"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
            <a href="index.php?act=admin&pg=admin_detail&view_id=<?= $rs_user_emp['admin_id'] ?>" class="dropdown-item">
              <div class="media">
                <?php if ($rs_user_emp['admin_image'] != '') { ?>
                  <img src="../images/admin/<?= $rs_user_emp['admin_image'] ?>" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                <?php } else { ?>
                  <i class="fas fa-user-circle fa-3x mr-3"></i>
                <?php } ?>
                <div class="media-body pt-2">
                  <h3 class="dropdown-item-title">
                    <?= $rs_user_emp['admin_fullname'] ?>
                  </h3>
                  <p class="text-sm"><?= $rs_user_emp['admin_username'] ?></p>
                </div>
              </div>
            </a>
            <div class="dropdown-divider"></div>
            <a href="javascript:;" onclick="logouts('logout.php')" class="dropdown-item dropdown-footer">ออกจากระบบ</a>
          </div>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-lightblue elevation-4">
      <!-- Brand Logo -->
      <a href="../index.php" target="_blank" class="brand-link bg-gradient-lightblue">
        <img src="../images/favicon_io/android-chrome-192x192.png" class="brand-image" alt="Ongkharak">
        <span class="brand-text font-weight-bold  text-light">ART SKY</span>
      </a>

      <!-- Sidebar -->
      <!-- นำเข้า sidebar เมนูด้านซ้ายจาก floder layout -->
      <?php include('layout/sidebar-menu.php'); ?>
      <!-- /.sidebar -->
    </aside>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <!-- นำเข้าหัวข้อ -->
            <?php include('content_topic.php'); ?>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">

        <!-- require file admin -->
        <?php require('file_request.php'); ?>
        <!-- /.require file admin -->

      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
      <div class="float-right d-none d-sm-block">
        <b>ART SKY</b> 1.0
      </div>
      <strong>Copyright &copy; <?= date('Y') ?> ART SKY Co.Ltd </strong> All rights reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- <script src="dist/js/jquery-1.12.4.min.js"></script> -->
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>

  <!-- Summernote -->
  <script src="plugins/summernote/summernote-bs4.min.js"></script>
  <!-- include summernote-th-TH -->
  <script src="plugins/summernote/lang/summernote-th-TH.min.js"></script>

  <!-- AdminLTE for demo purposes -->
  <!-- <script src="dist/js/demo.js"></script> -->

  <!-- thai datepicker -->
  <script type="text/javascript" src="plugins/bootstrap-datepicker-thai/js/bootstrap-datepicker.js"></script>
  <script type="text/javascript" src="plugins/bootstrap-datepicker-thai/js/bootstrap-datepicker-thai.js"></script>
  <script type="text/javascript" src="plugins/bootstrap-datepicker-thai/js/locales/bootstrap-datepicker.th.js"></script>

  <!-- fancybox -->
  <script src="plugins/fancybox/fancybox.umd.js"></script>

  <!-- Before Upload -->
  <script src="plugins/bootstrap-fileinput/js/plugins/piexif.js" type="text/javascript"></script>
  <script src="plugins/bootstrap-fileinput/js/plugins/sortable.js" type="text/javascript"></script>
  <script src="plugins/bootstrap-fileinput/js/fileinput.js" type="text/javascript"></script>
  <script src="plugins/bootstrap-fileinput/js/locales/th.js" type="text/javascript"></script>
  <script src="plugins/bootstrap-fileinput/themes/fa6/theme.min.js" type="text/javascript"></script>
  <script src="plugins/bootstrap-fileinput/themes/explorer-fa6/theme.min.js" type="text/javascript"></script>

  <!-- Select2 -->
  <script src="plugins/select2/js/select2.full.min.js"></script>
  <script src="plugins/select2/js/i18n/th.js"></script>

  <!-- video.js -->
  <script src="https://vjs.zencdn.net/7.18.1/video.min.js"></script>

  <!-- User -->
  <script src="dist/js/jquery-user-app.js"></script>

  <script>
    $('#image_name').on('change', function() {
      //get the file name
      var fileName = $(this).val();
      //replace the "Choose a file" label
      $(this).next('.custom-file-label').html(fileName);
    })

    $('.file-name').on('change', function() {
      //get the file name
      var fileName = $(this).val();
      //replace the "Choose a file" label
      $(this).next('.custom-file-label').html(fileName);
    })

    $('#member_telephone').keyup(function(e) {
      if (/\D/g.test(this.value)) {
        // Filter non-digits from input value.
        this.value = this.value.replace(/\D/g, '');
      }
    });

    $('#employee_telephone').keyup(function(e) {
      if (/\D/g.test(this.value)) {
        // Filter non-digits from input value.
        this.value = this.value.replace(/\D/g, '');
      }
    });

    // $('#employee_username').keyup(function() {
    //   $(this).val($(this).val().replace(/[^A-Za-z0-9]/g, ''))
    // });
    // $("#employee_password").keypress(function(event) {
    //   $(this).val($(this).val().replace(/[^\x00-\x7F]/ig, ''))
    // });

    // Date picker
    $('.datepicker').datepicker({
      language: 'th-th',
      format: 'dd/mm/yyyy',
      autoclose: true
    });

    $('#button-check').click(function() {
      $(".datepicker").datepicker('show');
    });

    // Date picker
    $('#day_start').datepicker({
      language: 'th-th',
      format: 'dd/mm/yyyy',
      autoclose: true
    });

    $('#button_check_start').click(function() {
      $("#day_start").datepicker('show');
    });

    // Date picker
    $('#day_end').datepicker({
      language: 'th-th',
      format: 'dd/mm/yyyy',
      autoclose: true
    });

    // Promotion 
    // Date picker
    $('#promotion_start').datepicker({
      language: 'th-th',
      format: 'dd/mm/yyyy',
      autoclose: true
    });
    $('#promotion_end').datepicker({
      language: 'th-th',
      format: 'dd/mm/yyyy',
      autoclose: true
    });

    $('#button_check_end').click(function() {
      $("#day_end").datepicker('show');
    });


    $(document).ready(function() {
      $('.summernote-1').summernote({
        lang: 'th-TH', // default: 'en-US'
        height: 400,
        fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '20', '22', '24', '32', '36', '64'],
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'italic', 'underline', 'clear']],
          ['fontname', ['fontname']],
          ['fontsize', ['fontsize']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'codeview', 'help']],
        ],
        callbacks: {
          onImageUpload: function(files) {
            uploadImage(files[0], '.summernote-1');
          },
          onMediaDelete: function(target) {
            // alert(target[0].src) 
            deleteFile(target[0].src);
          }
        }
      });
    });


    function uploadImage(file, el) {
      let formData = new FormData();
      formData.append('image', file);
      console.log(formData.append('image', file));
      $.ajax({
        url: 'admin_uploads/upload.php',
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(url) {
          var image = $('<img>').attr('src', '<?= $base_urls ?>/admin_app/admin_uploads/' + url);
          $(`${el}`).summernote("insertNode", image[0]);
        }
      });
    }

    function deleteFile(src) {
      console.log(src);
      $.ajax({
        data: {
          src: src
        },
        type: "POST",
        url: "admin_uploads/delete.php",
        cache: false,
        success: function(resp) {
          console.log(resp);
        }
      });
    }

    // Dark Mode Start
    $('#darkmodes').click(() => {
      const cat = localStorage.getItem("local_modes");
      if (cat) {
        localStorage.removeItem("local_modes");
        $('#darkmodes').html('<i class="bi bi-moon-stars-fill"></i>');
        $('body').removeClass('dark-mode');
      } else {
        localStorage.setItem("local_modes", "dark");
        $('#darkmodes').html('<i class="bi bi-brightness-high-fill"></i>');
        $('body').addClass('dark-mode');
      }
    })
    $(() => {
      if (localStorage.getItem("local_modes")) {
        $('#darkmodes').html('<i class="bi bi-brightness-high-fill"></i>');
        $('body').addClass('dark-mode');
      }
    })
    // Dark Mode End

    // Toggle Password
    $('.toggle-password').click(function() {
      $(this).children().toggleClass('fa-eye-slash');
      let input = $(this).prev();
      input.attr('type', input.attr('type') === 'password' ? 'text' : 'password');
    });

    /* สำหรับทดสอบ Select2 */
    //$('#test0').select2('open');
    // $('#test0').focus();
    // $("#test0")[0].focus();
    $('#test0').select2({
      theme: 'bootstrap4',
      language: "th"
    });
    // $('#test0').select2('open');
    // $(".select2-search__field")[0].focus();
    $('#test0').on('select2:select', function(e) {
      $('#test1').focus();
    });

    $('#test1').bind('keydown', function(e) {
      let key = e.keyCode || e.which;
      if (key === 13) {
        $("#test2").trigger("focus");
        e.preventDefault();
      }
    });

    $('#test2').bind('keydown', function(e) {
      let key = e.keyCode || e.which;
      if (key === 13) {
        $("#sbm_form001").trigger("focus");
        e.preventDefault();
      }
    });

    $('#sbm_form001').bind('keydown', function(e) {
      let key = e.keyCode || e.which;
      if (key === 13) {
        $('#frm_001').trigger("reset");
        $('#test0').val('').trigger('change');
        $('#test0').select2('open');
        // สั่ง Focus
        $(".select2-search__field")[0].focus();
        e.preventDefault();
      }
    });

    $('#sbm_form001').click((e) => {
      $('#frm_001').trigger("reset");
      $('#test0').val('').trigger('change');
      $('#test0').select2('open');
      // สั่ง Focus
      $(".select2-search__field")[0].focus();
    });

    /* สำหรับทดสอบ Select2 */

    /* Import Repair Start */
    $('.select_prd').select2({
      theme: 'bootstrap4',
      language: "th"
    });
    $('.select_prd').on('select2:select', function(e) {
      $('#product_qty').focus();
    });

    $('#product_qty').bind('keydown', function(e) {
      let key = e.keyCode || e.which;
      if (key === 13) {
        $("#product_price").trigger("focus");
        e.preventDefault();
      }
    });

    $('#product_price').bind('keydown', function(e) {
      let key = e.keyCode || e.which;
      if (key === 13) {
        $("#btn_submit").trigger("focus");
        e.preventDefault();
      }
    });

    function submitShow() {
      $('.select_prd').select2('open');
      $(".select2-search__field")[0].focus();
    }

    $(document).on('select2:open', () => {
      document.querySelector('.select2-search__field').focus();
    });
    /* Import Repair End */

    /* Customer Buy Start */
    $('#customer_id').select2({
      theme: 'bootstrap4',
      language: "th"
    });

    $('#prds_id').select2({
      theme: 'bootstrap4',
      language: "th"
    });


    /* Carrent Start */
    /* Carrent End */


    $('#customer_id').on('select2:select', function(e) {
      $('#prds_id').select2('open');
      $(".select2-search__field")[0].focus();
    });

    $('#prds_id').on('select2:select', function(e) {
      $('#product_qty').focus();
    });

    $('#price').bind('keydown', function(e) {
      let key = e.keyCode || e.which;
      if (key === 13) {
        $("#btn_submit").trigger("focus");
        e.preventDefault();
      }
    });

    function showList() {
      $('#prds_id').select2('open');
      $(".select2-search__field")[0].focus();
    }

    /* Customer Buy End */

    /* Sell Edit Start */
    function editStart() {
      $('#prds_id').select2('open');
      $(".select2-search__field")[0].focus();
    }
    /* Sell Edit End */

    /* Buy Start */
    $('#supplier_id').select2({
      theme: 'bootstrap4',
      language: "th"
    });
    $('#product_id').select2({
      theme: 'bootstrap4',
      language: "th"
    });

    $('#supplier_id').on('select2:select', function(e) {
      $('#product_id').select2('open');
      $(".select2-search__field")[0].focus();
    });

    $('#product_id').on('select2:select', function(e) {
      $('#product_qty').focus();
    });

    function showProduct() {
      $('#product_id').select2('open');
      $(".select2-search__field")[0].focus();
    }
    /* Buy End */

    /* Import Start */
    $('#buy_order_id').select2({
      theme: 'bootstrap4',
      language: "th"
    });
    /* Import End */
  </script>
</body>

</html>
<?php ob_end_flush(); ?>