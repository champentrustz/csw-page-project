
<?php
session_start();
include '../config_db.php';

$adminID = $_SESSION['admin_id'];
if($adminID == null || $adminID == ''){
    ?>
    <script>window.location.href='login';</script>
    <?php
}
function ThDate()
{
//วันภาษาไทย
    $ThDay = array ( "อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกร์", "เสาร์" );
//เดือนภาษาไทย
    $ThMonth = array ( "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน","พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม","กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม" );

//กำหนดคุณสมบัติ
    $week = date( "w" ); // ค่าวันในสัปดาห์ (0-6)
    $months = date( "m" )-1; // ค่าเดือน (1-12)
    $day = date( "d" ); // ค่าวันที่(1-31)
    $years = date( "Y" )+543; // ค่า ค.ศ.บวก 543 ทำให้เป็น ค.ศ.

    return "วัน$ThDay[$week] 
		ที่ $day  
		เดือน $ThMonth[$months] 
		พ.ศ. $years";
}
$date_day = date("Y-m-d");

$sql_sms = "SELECT * FROM tb_sms_late WHERE date = '".$date_day."'";
$result_sms = mysqli_query($conn, $sql_sms);
$count_sms = mysqli_num_rows($result_sms);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>C.S.W. Online Behavior</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,300i" rel="stylesheet">

    <!-- Styles -->
    <link href="../css/core.min.css" rel="stylesheet">
    <link href="../css/app.min.css" rel="stylesheet">
    <link href="../css/style.min.css" rel="stylesheet">

    <!-- Favicons -->
</head>


<style>

    @import url('https://fonts.googleapis.com/css?family=Athiti');
    *{
        font-family: 'Athiti', sans-serif;
    }
    .show-font{
        font-family: 'Athiti', sans-serif;
    }

    .zoom {
        -webkit-transition: all 0.35s ease-in-out;
        -moz-transition: all 0.35s ease-in-out;
        transition: all 0.35s ease-in-out;
        cursor: -webkit-zoom-in;
        cursor: -moz-zoom-in;
        cursor: zoom-in;
    }

    .zoom:hover,
    .zoom:active,
    .zoom:focus {
        -ms-transform: scale(2.5);
        -moz-transform: scale(2.5);
        -webkit-transform: scale(2.5);
        -o-transform: scale(2.5);
        transform: scale(2.5);
        position:relative;
        z-index:100;
    }

</style>

<body>



<!-- Preloader -->
<div class="preloader">
    <div class="spinner-dots">
        <span class="dot1"></span>
        <span class="dot2"></span>
        <span class="dot3"></span>
    </div>
</div>

<?php include "side-bar.php";?>


<!-- Main container -->
<main class="main-container">

    <div class="card text-center">
        <div class="col-md-12">
            <h2 class="header-title">
                <p></p>
                <span class="text-info">ส่ง SMS นักเรียนที่มาโรงเรียนสายประจำวัน</span>
                <small class="show-font"><?php print thDate()?></small>
                <p></p>
                <!--                <small class="show-font">โรงเรียนชำนาญสามัคคีวิทยา</small>-->
            </h2 class="header-title ">
        </div>

    </div>



    <div class="container">
        <div class="card">
            <h4 class="card-title show-font">สถานะการส่ง SMS :
                <?php if($count_sms > 0) {?>
                    <span class="text-success">ส่ง SMS แล้ว</span></h4>
                <?php
                }
            else {?>
                <span class="text-danger">ยังไม่ได้ส่ง SMS</span></h4>
                <div class="card-body">

                    <p><a class="btn btn-primary col-md-3" href="function_send_sms_late.php"><span class="show-font">ส่ง SMS</span></a></p>

                </div>
                <?php
                }?>










    </div>

        <div class="card">
            <h4 class="card-title show-font">รายงานการส่ง SMS นักเรียนที่มาโรงเรียนสายประจำวัน</h4>
            <div class="card-body">
                <div class="table-responsive-lg" style="font-size: 16px">
                    <table class="table table-lg table-hover table-bordered" data-page-length='100' data-provide="datatables">
                        <thead>
                        <tr>
                            <th  class="text-center">ที่</th>

                            <th  class="text-center">รหัส</th>
                            <th  class="text-center">รูป</th>
                            <th  class="text-center">ชื่อ-นามสกุล</th>
                            <th  class="text-center">ชั้น</th>
                            <th  class="text-center">หมายเหตุ</th>

                        </tr>
                        <tbody>

                        <?php

                        $i = 0;
                        $content = file_get_contents("https://www.csw.ac.th/csw_api/get_sms_late_data.php");

                        $jsonArrays = json_decode($content,true);

                        foreach ($jsonArrays as $data){
                            if($data['deduction_score'] == false) {
                                $i++;
                                ?>
                                <tr>
                                    <td class="text-center"><?php print $i ?></td>
                                    <td class="text-center"><?php print $data['student_code'] ?></td>
                                    <td class="text-center"><img class="zoom"
                                                                 src="../file_student/small/<?php print $data['student_code'] ?>.jpg"
                                                                 style="width:60px;height:78px"></td>
                                    <td><?php print $data['student_name'] ?></td>
                                    <td class="text-center"><?php print $data['room'] ?></td>
                                    <td class="text-center"><?php
                                        if ($data['note'] == '') {
                                            echo '-';
                                        } else {
                                            print $data['note'];
                                        } ?></td>
                                </tr>

                                <?php
                            }
                        }

                        ?>
                        </tbody>
                        </thead>
                    </table>

                </div>

            </div>
        </div>

    <div id="log"></div>


</main>
<!-- END Main container -->





<!-- Scripts -->
<script src="../js/core.min.js"></script>
<script src="../js/app.min.js"></script>
<script src="../js/script.min.js"></script>


<script>

    var click = 0;
    var toggle = 0;

    setTimeout(function(){  $('#button-late').trigger('click'); }, 200);

    $( "#toggle-fold" ).click(function() {
        click ++;
        if(click %2 == 0){
            $('#profile').show();
        }
        else{

            $( document ).on( "mousemove", function( event ) {
                if(click %2 == 0){
                    event.stopPropagation();
                }
                else{
                    if(event.pageX <= 80 && event.pageY >= 0){
                        $('#profile').show('slow');

                    }
                    if(event.pageX >= 260 && event.pageY >= 0){
                        $('#profile').hide('slow');

                    }
                }

            });
        }

    });


</script>


</body>
</html>
