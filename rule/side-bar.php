<?php
session_start();
$host = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$adminName= $_SESSION['admin_name'];
$adminSurname= $_SESSION['admin_surname'];

include '../config_db.php';


?>
<aside class="sidebar sidebar-icons-right sidebar-icons-boxed sidebar-expand-lg  sidebar-color-info sidebar-dark">
    <header class="sidebar-header sidebar-header-inverse">
        <a class="logo-icon" href="main"><img src="../img/logo-CSW.png" alt="logo icon"></a>
        <span class="logo">
          <a href="main"><img src="../img/header3.png" alt="logo" style="height: 30px"></a>
        </span>
        <span class="sidebar-toggle-fold" id="toggle-fold"></span>
    </header>

    <nav class="sidebar-navigation">

        <div class="sidebar-profile" id="profile">

                <img class="avatar" src="../img/avatar/3.jpg">

            <div class="profile-info">
                <h4 class="show-font"><?php print $adminName?> <?php print $adminSurname?></h4>
                <p>เจ้าหน้าที่ฝ่ายปกครอง</p>
            </div>
        </div>


        <ul class="menu menu-lg menu-bordery">

            <li class="menu-item <?php if($host == 'www.csw.ac.th/information/online_checkin/rule/main' || $host == 'csw.ac.th/information/online_checkin/rule/main')echo 'active'?>">
                <a class="menu-link" href="main">
                    <span class="icon ti-home"></span>
                    <span class="title">
                <span style="font-size: 16px">หน้าหลัก</span>

              </span>
                </a>
            </li>

            <li class="menu-item <?php if($host == 'www.csw.ac.th/information/online_checkin/rule/student-score' || $host == 'www.csw.ac.th/information/online_checkin/rule/student-score-late'
            || $host == 'csw.ac.th/information/online_checkin/rule/student-score' || $host == 'csw.ac.th/information/online_checkin/rule/student-score-late')echo 'active open'?>">
                <a class="menu-link active" href="#">
                    <span class="icon ti-star"></span>
                    <span class="title" style="font-size: 16px">คะแนนความประพฤติ</span>
                    <span class="arrow"></span>
                </a>
                <ul class="menu-submenu">
                    <li class="menu-item <?php if($host == 'www.csw.ac.th/information/online_checkin/rule/student-score' || $host == 'csw.ac.th/information/online_checkin/rule/student-score')echo 'active'?>">
                        <a class="menu-link " href="student-score">
                            <span class="dot"></span>
                            <span class="title">คะแนนความประพฤติทั้งหมด</span>
                        </a>
                    </li>

                    <li class="menu-item <?php if($host == 'www.csw.ac.th/information/online_checkin/rule/student-score-late' || $host == 'csw.ac.th/information/online_checkin/rule/student-score-late')echo 'active'?>">
                        <a class="menu-link" href="student-score-late">
                            <span class="dot"></span>
                            <span class="title">คะแนนความประพฤติมาสาย</span>
                        </a>
                    </li>

                </ul>
            </li>



            <li class="menu-item <?php if($host == 'www.csw.ac.th/information/online_checkin/rule/late-report' || $host == 'csw.ac.th/information/online_checkin/rule/late-report')echo 'active'?>">
                <a class="menu-link" href="late-report">
                    <span class="icon ti-files"></span>
                    <span class="title" style="font-size: 16px">รายงานนักเรียนที่มาสาย</span>
                </a>
            </li>


            <li class="menu-item <?php if($host == 'www.csw.ac.th/information/online_checkin/rule/deduction-score' || $host == 'csw.ac.th/information/online_checkin/rule/deduction-score')echo 'active'?>">
                <a class="menu-link" href="deduction-score">
                    <span class="icon ti-close"></span>
                    <span class="title" style="font-size: 16px">ตัดคะแนนความประพฤติ</span>
                </a>
            </li>


            <li class="menu-item <?php if($host == 'www.csw.ac.th/information/online_checkin/rule/sms' || $host == 'www.csw.ac.th/information/online_checkin/rule/sms-late'
            || $host == 'csw.ac.th/information/online_checkin/rule/sms' || $host == 'csw.ac.th/information/online_checkin/rule/sms-late')echo 'active open'?>">
                <a class="menu-link active" href="#">
                    <span class="icon ti-email"></span>
                    <span class="title" style="font-size: 16px">ส่ง SMS</span>
                    <span class="arrow"></span>
                </a>


            <ul class="menu-submenu">
                <li class="menu-item <?php if($host == 'www.csw.ac.th/information/online_checkin/rule/sms' || $host == 'csw.ac.th/information/online_checkin/rule/sms')echo 'active'?>">
                    <a class="menu-link " href="sms">
                        <span class="dot"></span>
                        <span class="title">SMS ประจำวัน</span>
                    </a>
                </li>

                <li class="menu-item <?php if($host == 'www.csw.ac.th/information/online_checkin/rule/sms-late' || $host == 'csw.ac.th/information/online_checkin/rule/sms-late')echo 'active'?>">
                    <a class="menu-link" href="sms-late">
                        <span class="dot"></span>
                        <span class="title">SMS นักเรียนมาสาย</span>
                    </a>
                </li>

            </ul>
            </li>


        </ul>
    </nav>

</aside>
<!-- END Sidebar -->


<!-- Topbar -->
<header class="topbar">
    <div class="topbar-left">
        <span class="topbar-btn sidebar-toggler"><i>&#9776;</i></span>

        <a class="topbar-btn d-none d-md-block" href="#" data-provide="fullscreen tooltip" title="Fullscreen">
            <i class="material-icons fullscreen-default">fullscreen</i>
            <i class="material-icons fullscreen-active">fullscreen_exit</i>
        </a>


        <div class="topbar-divider d-none d-md-block"></div>

    </div>

    <div class="topbar-right">



        <ul class="topbar-btns">


            <a class="btn btn-sm btn-danger" href="function_logout.php"><span class="ti-power-off"></span> ออกจากระบบ</a>




        </ul>

        <div class="topbar-divider"></div>

    </div>
</header>

<!--<script>-->
<!---->
<!--    var click = 0;-->
<!--    var toggle = 0;-->
<!---->
<!--    setTimeout(function(){  $('#button-late').trigger('click'); }, 200);-->
<!---->
<!--    $( "#toggle-fold" ).click(function() {-->
<!--        click ++;-->
<!--        if(click %2 == 0){-->
<!--            $('#profile').show();-->
<!--        }-->
<!--        else{-->
<!---->
<!--            $( document ).on( "mousemove", function( event ) {-->
<!--                if(click %2 == 0){-->
<!--                    event.stopPropagation();-->
<!--                }-->
<!--                else{-->
<!--                    if(event.pageX <= 80 && event.pageY >= 0){-->
<!--                        $('#profile').show('slow');-->
<!---->
<!--                    }-->
<!--                    if(event.pageX >= 260 && event.pageY >= 0){-->
<!--                        $('#profile').hide('slow');-->
<!---->
<!--                    }-->
<!--                }-->
<!---->
<!--            });-->
<!--        }-->
<!---->
<!--    });-->
<!---->
<!---->
<!--</script>-->