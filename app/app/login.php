<?php
include('../config/connect.php');
// ตรวจพบ session user_admin และ status_login หน้า login จะเข้า index อัตโนมัติ
if (isset($_SESSION['sess_admin_artsky']) && isset($_SESSION['sess_login_artsky'])) {
    header('location:index.php');
}
if (isset($_COOKIE['cookie_admin_artsky']) && isset($_COOKIE['cookie_login_artsky'])) {
    header('location:index.php');
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="ART SKY Co.Ltd.">
    <meta name="generator" content="Hugo 0.88.1">
    <title>ART SKY | Administrator</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="../images/favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../images/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../images/favicon_io/favicon-16x16.png">
    <link rel="shortcut icon" sizes="192x192" href="../images/favicon_io/android-chrome-192x192.png">
    <link rel="shortcut icon" sizes="512x512" href="../images/favicon_io/android-chrome-512x512.png">
    <link rel="manifest" href="../images/favicon_io/site.webmanifest">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai&display=swap" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .img-logo:hover {
            cursor: pointer;
            opacity: 0.8;
            filter: alpha(opacity=80);
        }


        body::before {
            content: "";
            z-index: -1;
            position: inherit;
            left: inherit;
            top: inherit;
            width: inherit;
            height: inherit;
            background-image: inherit;
            background-size: cover;
            filter: blur(4px);
        }

        body {
            background-image: url("../images/bg.jpg");
            background-size: 0 0;
            width: 100%;
            height: 100%;
            position: fixed;
            font-family: 'Noto Sans Thai', sans-serif;
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
            background: url('../images/loading.svg') center no-repeat #fff;
        }

        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }

        .form-signin {
            padding: 15px;
            margin: auto;
        }

        .form-signin .checkbox {
            font-weight: 400;
        }

        .form-signin .form-floating:focus-within {
            z-index: 2;
        }

        .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }

        .text-purple {
            color: #8d448b;
        }

        .btn-purple {
            box-shadow: inset 0px 1px 0px 0px #97c4fe;
            background: linear-gradient(to bottom, #3d94f6 5%, #1e62d0 100%);
            background-color: #3d94f6;
            border-radius: 6px;
            border: 1px solid #337fed;
            display: inline-block;
            cursor: pointer;
            color: #ffffff;
            font-family: Arial;
            font-size: 15px;
            font-weight: bold;
            padding: 6px 24px;
            text-decoration: none;
            text-shadow: 0px 1px 0px #1570cd;
            position: absolute;
            bottom: -1.5rem;
            left: 0;
            right: 0;
            margin: 0 auto;
            width: 93%;
            height: 3.25rem;
        }

        .btn-purple:hover {
            background: linear-gradient(to bottom, #1e62d0 5%, #3d94f6 100%);
            background-color: #1e62d0;
        }

        .btn-purple:active {
            background: linear-gradient(to bottom, #1e62d0 5%, #3d94f6 100%);
            background-color: #1e62d0;
            color: #ffffff;
        }

        .checkbox-purple {
            color: #3d94f6;
        }

        .form-check-input:checked {
            background-color: #1e62d0;
            border-color: #3d94f6;
        }
    </style>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css" />
    <!-- Custom styles for this template -->
</head>

<body class="text-center">
    <div class="se-pre-con"></div>
    <main class="container">
        <!-- เปลี่ยนดีไซน์ใหม่เพื่อรองรับการย่อหน้าจอแบบมือถือได้ -->
        <!-- form-signin col-lg-4 col-md-12 -->
        <?php
        $actions_post = '';
        if (isset($_POST['submit'])) {

            $username = mysqli_real_escape_string($conn, $_POST['username']); // Protect SQL Injection ป้องกัน sql Injection 
            $password = base64_encode(mysqli_real_escape_string($conn, $_POST['password'])); // Protect SQL Injection ป้องกัน sql Injection
            if (isset($_POST['member_me'])) {
                $member_me = mysqli_real_escape_string($conn, $_POST['member_me']); // Protect SQL Injection ป้องกัน sql Injection
            } else {
                $member_me = '';
            }

            $sql = " SELECT * FROM tbl_admin WHERE admin_username = '$username' AND admin_password = '$password' ";

            $res = mysqli_query($conn, $sql);
            $rs = mysqli_fetch_assoc($res);

            $count = mysqli_num_rows($res);

            if ($count == 1) {
                $msg = "<div class='alert alert-success'>Login Successful.</div>";
                $_SESSION['sess_admin_artsky'] = $rs['admin_id']; //To check whether the user is logged in or not and logout will unset it
                $_SESSION['sess_login_artsky'] = true; // To
                if ($member_me == 1) {
                    setcookie('cookie_admin_artsky', $rs['admin_id'], time() + 525600);
                    setcookie('cookie_login_artsky', true, time() + 525600);
                }
                header("refresh:1;url=index.php");
                $actions_post = 'success';
                $msg = "
                <div class='col-lg-4 col-md-8 mx-auto'>
                    <div class='alert alert-success'>
                    <i class=\"far fa-check-circle\"></i> เข้าสู่ระบบสำเร็จ <br><i class=\"fas fa-hourglass-half\"></i> โปรดรอสักครู่
                    </div>
                </div>
                ";
            } else {
                $msg = "
                <div class='col-lg-4 col-md-8 mx-auto'>
                    <div class='alert alert-danger'><i class=\"fas fa-exclamation-circle\"></i> ชื่อผู้ใช้ หรือ รหัสผ่าน <br>ไม่ถูกต้องโปรดตรวจสอบใหม่</div>
                </div>";
            }
        }

        ?>
        <?php
        if (isset($msg)) {
            echo $msg;
        }
        ?>
        <?php if ($actions_post != 'success') { ?>
            <div class="col-lg-4 col-md-8 mx-auto">
            <div class="card p-3 border-0 shadow-sm">
                <form action="" method="POST">
                    <img src="../images/logo_login.svg" class="img-logo col-3 mt-2 mb-3" alt="IMG-LOGO" onclick="javascript:location.href='../index'" data-bs-toggle="tooltip" data-bs-placement="top" title="กลับสู่หน้าหลัก">
                    <h1 class="h3 mb-3 fw-normal">
                        <span class="text-dark font-weight-bold display-6">ART SKY</span>
                    </h1>
                    <div class="form-floating mb-2">
                        <input type="text" class="form-control rounded" name="username" id="floatingInput" placeholder="ชื่อผู้ใช้" required>
                        <label for="floatingInput">ชื่อผู้ใช้</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" class="form-control rounded" name="password" id="floatingPassword" placeholder="รหัสผ่าน" required>
                        <label for="floatingPassword">รหัสผ่าน</label>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6 text-md-start">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="member_me" value="1" id="member_me">
                                    <label class="text-dark fw-bold" class="form-check-label" for="member_me">
                                        บันทึกไว้
                                    </label>
                                </div>
                            </div>
                            <!-- <div class="col-6 text-md-end" id="forget-pass">
                                <a class="text-decoration-none text-purple" href="forget.php">ลืมรหัสผ่าน</a>
                            </div> -->
                        </div>
                    </div>
                    <div class="mb-3">&nbsp;</div>
                    <button class="btn btn-lg btn-purple" type="submit" name="submit" value="Login"><i class="fas fa-external-link-alt"></i> เข้าสู่ระบบ</button>
                </form>
            </div>
            </div>
        <?php } ?>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/jquery-1.12.4.min.js"></script>
    <script>
        //paste this code under the head tag or in a separate js file.
        // Wait for window load
        $(window).load(function() {
            // Animate loader off screen
            $(".se-pre-con").fadeOut("slow");;
        });
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
</body>

</html>
<?php ob_end_flush(); ?>