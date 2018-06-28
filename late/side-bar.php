<?php
session_start();
$host = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$teacherNumber = $_SESSION['teacher_number'];

include '../config_db.php';

$sql_teacher = "SELECT * FROM tb_teachers WHERE tb_teacher_number = '".$teacherNumber."'";
$result_teacher = mysqli_query($conn, $sql_teacher);
$row_teacher = mysqli_fetch_assoc($result_teacher);

$sql_room = "SELECT * FROM tb_rooms WHERE tb_room_id = '".$row_teacher['tb_teacher_degree']."'";
$result_room = mysqli_query($conn, $sql_room);
$row_room = mysqli_fetch_assoc($result_room);


$sql_position = "SELECT * FROM tb_positions WHERE tb_position_id = '".$row_teacher['tb_teacher_position']."'";
$result_position = mysqli_query($conn, $sql_position);
$row_position = mysqli_fetch_assoc($result_position);

$sql_department = "SELECT * FROM tb_departments WHERE tb_department_id = '".$row_teacher['tb_department_id']."'";
$result_department = mysqli_query($conn, $sql_department);
$row_department = mysqli_fetch_assoc($result_department);


?>
<aside class="sidebar sidebar-expand-lg sidebar-lg sidebar-iconic sidebar-dark sidebar-color-info">
    <header class="sidebar-header sidebar-header-inverse">
        <span class="logo text-center">
          <a href="main"><img src="../img/logo-CSW.png" alt="logo" style="height: 40px"></a>
        </span>
    </header>

    <nav class="sidebar-navigation">



        <ul class="menu menu-lg menu-bordery">

            <li class="menu-item <?if($host == 'www.csw.ac.th/information/online_checkin/late2/main' || $host == 'csw.ac.th/information/online_checkin/late2/main')echo 'active'?>">
                <a class="menu-link" href="main">
                    <span class="icon ti-home"></span>
                    <span class="title">
                <span style="font-size: 16px">หน้าหลัก</span>

              </span>
                </a>
            </li>

            <li class="menu-item <?if($host == 'www.csw.ac.th/information/online_checkin/late2/report' || $host == 'csw.ac.th/information/online_checkin/late2/report')echo 'active'?>">
                <a class="menu-link" href="report">
                    <span class="icon ti-files"></span>
                    <span class="title" style="font-size: 16px">รายงาน</span>
                </a>
            </li>


        </ul>
    </nav>

</aside>
<!-- END Sidebar -->


<!-- Topbar -->
<header class="topbar ">
    <div class="topbar-left">
        <span class="topbar-btn sidebar-toggler"><i>&#9776;</i></span>

        <a class="topbar-btn d-none d-md-block" href="#" data-provide="fullscreen tooltip" title="Fullscreen">
            <i class="material-icons fullscreen-default">fullscreen</i>
            <i class="material-icons fullscreen-active">fullscreen_exit</i>
        </a>


        <div class="topbar-divider d-none d-md-block"></div>



    </div>


<header>


    <?php if($host == 'www.csw.ac.th/information/online_checkin/late2/main' || $host == 'csw.ac.th/information/online_checkin/late2/main'):?>
        <span class="text-info show-font" style="font-size: 24px">เช็คชื่อนักเรียนที่มาโรงเรียนสาย</span>
        <small class="show-font" style="font-size: 24px"><?php print thDate($date_day)?></small>
    <?php elseif ($host == 'www.csw.ac.th/information/online_checkin/late2/report' || $host == 'csw.ac.th/information/online_checkin/late2/report'):?>
        <span class="text-info show-font" style="font-size: 24px">รายงานนักเรียนที่มาโรงเรียนสาย</span>
        <small class="show-font" style="font-size: 24px"><?php print thDate($date_day)?></small>
    <?php endif?>
</header>

    <div class="topbar-right">



        <ul class="topbar-btns">
            <li class="dropdown">
                <span class="topbar-btn" data-toggle="dropdown" style="font-size: 16px"><img class="avatar" src="../id-plan/file_uploads/<?php print $teacherNumber?>.jpg"> <?php print $row_teacher['tb_teacher_name']?></span>
                <div class="dropdown-menu dropdown-menu-right">

                    <a class="dropdown-item" href="function_logout.php" style="font-size: 14px"><i class="ti-power-off"></i> ออกจากระบบ</a>

                </div>
            </li>



        </ul>

        <div class="topbar-divider"></div>

    </div>
</header>