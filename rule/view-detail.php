
<?php
session_start();
include '../config_db.php';

$adminID = $_SESSION['admin_id'];
$studentCode = $_REQUEST['studentCode'];
$semester = $_REQUEST['semester'];
$year = $_REQUEST['year'];

if($studentCode == null || $studentCode == ''){
    ?>
    <script>window.location.href='student-score';</script>
    <?php
}

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

$sql_student = "SELECT * FROM tb_students WHERE tb_student_code = '".$studentCode."' and tb_student_status = 1";
$result_student = mysqli_query($conn, $sql_student);
$count = mysqli_num_rows($result_student);
$row_student = mysqli_fetch_assoc($result_student);

$sql_student_room = "SELECT * FROM tb_rooms WHERE tb_room_id = '".$row_student['tb_student_degree']."'";
$result_student_room = mysqli_query($conn, $sql_student_room);
$row_student_room = mysqli_fetch_assoc($result_student_room);

function convertDateThai($data){
    $year = substr($data,0,4);
    $month = substr($data,5,2);
    $date = substr($data,8,2);
    $year = (int)$year + 543;
    switch ($month){
        case 1:
            $month = 'มกราคม';
            break;
        case 2:
            $month = 'กุมภาพันธ์';
            break;
        case 3:
            $month = 'มีนาคม';
            break;
        case 4:
            $month = 'เมษายน';
            break;
        case 5:
            $month = 'พฤษภาคม';
            break;
        case 6:
            $month = 'มิถุนายน';
            break;
        case 7:
            $month = 'กรกฎาคม';
            break;
        case 8:
            $month = 'สิงหาคม';
            break;
        case 9:
            $month = 'กันยายน';
            break;
        case 10:
            $month = 'ตุลาคม';
            break;
        case 11:
            $month = 'พฤศจิกายน';
            break;
        case 12:
            $month = 'ธันวาคม';
            break;
    }


    return $date.' '.$month.' '.$year;

}

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
                <span class="text-info">รายละเอียดการถูกตัดคะแนนความประพฤติ</span>
                <p></p>
                <!--                <small class="show-font">โรงเรียนชำนาญสามัคคีวิทยา</small>-->
            </h2 class="header-title ">
        </div>

    </div>


    <div class="container">

    <?php if($studentCode) : ?>

        <div class="row">

                <div class="col-md-4">
                    <div class="card ">
                        <h4 class="card-title show-font"><span class="icon ti-user"></span> ข้อมูลนักเรียน</h4>
                        <div class="card-body">


                                <div class="sidebar-profile" id="profile">
                                    <img class="avatar " src="../file_student/small/<?php print $row_student['tb_student_code']?>.jpg" >

                                    <div class="profile-info">
                                        <table class="table table-separated">
                                            <tr>
                                                <td width="15%"></td>
                                                <td class="text-left">
                                                    <h6 class="show-font text-default">ชื่อ : <?php print $row_student['tb_student_name']?> <?php print $row_student['tb_student_sname']?></h6>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="15%"></td>
                                                <td class="text-left">
                                                    <h6 class="show-font text-default">รหัสนักเรียน : <?php print $row_student['tb_student_code']?></h6>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="15%"></td>
                                                <td class="text-left">
                                                    <h6 class="show-font text-default">ชั้น : <?php print $row_student_room['tb_room_name']?></h6>
                                                </td>
                                            </tr>

                                        </table>

                                    </div>
                                </div>

                            </div>



                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card">

                            <h4 class="card-title show-font"><span class="icon ti-close"></span> รายละเอียด</h4>

                        <div class="card-body">
                        <div class="table-responsive-lg" data-page-length="100" style="font-size: 16px">
                            <table class="table table-lg table-hover table-bordered" data-page-length='50' data-provide="datatables">
                                <thead>
                                <tr>
                                    <th  class="text-center">ที่</th>
                                    <th  class="text-center ">สาเหตุ</th>
                                    <th  class="text-center">คะแนนที่ถูกตัด</th>
                                    <th  class="text-center ">วันที่</th>

                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                $sql_rule = "SELECT * FROM tb_rules WHERE tb_student_code = '".$studentCode."' and tb_rule_semester = '".$semester."' and tb_rule_year = '".$year."' and tb_rule_status = 1";
                                $result_rule = mysqli_query($conn, $sql_rule);
                                $i = 0;

                                $count = mysqli_num_rows($result_rule);
                                if($count > 0) {
                                    while ($row_rule = mysqli_fetch_assoc($result_rule)) {

                                        $i++;
                                        $sql_rule_type = "SELECT * FROM tb_ruletypes WHERE tb_ruletype_id = '" . $row_rule['tb_ruletype_id'] . "'";
                                        $result_rule_type = mysqli_query($conn, $sql_rule_type);
                                        $row_rule_type = mysqli_fetch_assoc($result_rule_type);

                                        ?>
                                        <tr style="font-size: 14px">
                                            <td class="text-center"><?php print $i ?></td>
                                            <td class="text-center"><?php print $row_rule_type['tb_ruletype_name']?></td>
                                            <td class="text-center"><?php print $row_rule['tb_rule_score']?> คะแนน</td>
                                            <td class="text-center"><?php print convertDateThai($row_rule['tb_rule_date'])?></td>

                                        </tr>
                                        <?php
                                    }
                                }

                                ?>


                                </tbody>

                            </table>
                        </div>
                    </div>
                    </div>
                </div>


        </div>
    <?php endif?>

    </div>







</main>
<!-- END Main container -->





<!-- Scripts -->
<script src="../js/core.min.js"></script>
<script src="../js/app.min.js"></script>
<script src="../js/script.min.js"></script>

<script>



    var dateFull = $('#date').val();
    var date = dateFull.substring(0,2);
    var month = dateFull.substring(3,5);
    var year = parseInt(dateFull.substring(6,10)) + 543;

    var dateFormat = date+'-'+month+'-'+year

    $('#date').val(dateFormat);

    $('#date').on('changeDate', function(ev){
        $(this).datepicker('hide');
    });
</script>

<script>

    setInterval(function(){
        var score = $( "#score" ).val();
        if(parseInt(score) < 0){
            $( "#score" ).val('');
        }
    }, 1);

</script>

<script>
    function search() {

        var studentCode = $( "#student-code" ).val();
        $.post( "./deduction-score", {
            "search": true,
            "studentCode" : studentCode
        })
    }
</script>

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
