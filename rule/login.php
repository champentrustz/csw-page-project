<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
$adminID = $_SESSION['admin_id'];
if($adminID != null || $adminID != ''){
    ?>
    <script>window.location.href='main.php';</script>
    <?php
}
?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->

    <title>C.S.W. Online Behavior</title>

    <!-- Styles -->
    <link href="../css/core.min.css" rel="stylesheet">
    <link href="../css/app.min.css" rel="stylesheet">
    <link href="../css/style.min.css" rel="stylesheet">

</head>

<style>
    @import url('https://fonts.googleapis.com/css?family=Athiti');
    *{
        font-family: 'Athiti', sans-serif;
    }
    .show-font{
        font-family: 'Athiti', sans-serif;
    }

</style>

<body class="min-h-fullscreen bg-img center-vh p-20  pace-done" style="background-image: url(../img/bg-login.jpg);" data-overlay="7"><div class="pace  pace-inactive"><div class="pace-progress" data-progress-text="100%" data-progress="99" style="width: 100%;">
        <div class="pace-progress-inner"></div>
    </div>
    <div class="pace-activity"></div></div>

<div class="card card-round card-shadowed px-50 py-30 w-400px mb-0" style="max-width: 100%">
<!--    <h5 class="text-uppercase">Sign in</h5>-->
<!--    <br>-->

    <div class="text-center">
    <img src="../img/logo-CSW.png"style="width: 200px; height: 150px;">
    </div>
    <br>

    <form class="form-type-material" method="post" action="function_login.php">
        <div class="form-group">
            <input type="text" class="form-control" id="username" name="username">
            <label for="username" style="font-size: 16px">ชื่อผู้ใช้งาน</label>
        </div>

        <div class="form-group">
            <input type="password" class="form-control" id="password" name="password">
            <label for="password" style="font-size: 16px">รหัสผ่าน</label>
        </div>


        <div class="form-group">
            <button class="btn btn-block btn-primary" type="submit" style="font-size: 16px"><span class="show-font">เข้าสู่ระบบ</span></button>
        </div>
    </form>

    <a href="../" style="font-size: 14px" class="text-info">กลับสู่หน้าหลัก</a>

    <hr class="w-30px">

</div>






<!-- Scripts -->

<script src="../js/core.min.js"></script>
<script src="../js/app.js"></script>
<script src="../js/script.min.js"></script>
</body>
</html>

