
<?php
session_start();
include '../config_db.php';

$adminID = $_SESSION['admin_id'];
$studentCode = $_REQUEST['studentCode'];
$search = $_REQUEST['search'];
$deduction_late = $_REQUEST['deduction_late'];
$searchName = $_REQUEST['search_name'];
$searchCode = $_REQUEST['search_code'];


$status1 = true;
$status2 = true;

if($search == '' || $search == null){
    $search = "false";
}


if($deduction_late == 'true'){
    $date_day = $_REQUEST['date'];
    $date_day = date('d-m-Y', strtotime($date_day));
}
else{
    $date_day = date("d-m-Y");
}



if($search == "true" && $searchCode == "true"){
    $sql_student = "SELECT * FROM tb_students WHERE tb_student_code = '".$studentCode."' and tb_student_status = 1";
    $result_student = mysqli_query($conn, $sql_student);
    $count = mysqli_num_rows($result_student);
    $row_student = mysqli_fetch_assoc($result_student);

    $sql_student_room = "SELECT * FROM tb_rooms WHERE tb_room_id = '".$row_student['tb_student_degree']."'";
    $result_student_room = mysqli_query($conn, $sql_student_room);
    $row_student_room = mysqli_fetch_assoc($result_student_room);

    if($count > 0){
        $status1 = true;

    }
    else{
        $search = "false";
        $status1 = false;

    }
}

if($search == "true" && $searchName == "true"){
    $sql_student = "SELECT * FROM tb_students WHERE tb_student_code = '".$studentCode."' and tb_student_status = 1";
    $result_student = mysqli_query($conn, $sql_student);
    $count = mysqli_num_rows($result_student);
    $row_student = mysqli_fetch_assoc($result_student);

    $sql_student_room = "SELECT * FROM tb_rooms WHERE tb_room_id = '".$row_student['tb_student_degree']."'";
    $result_student_room = mysqli_query($conn, $sql_student_room);
    $row_student_room = mysqli_fetch_assoc($result_student_room);

    if($count > 0){
        $status2 = true;

    }
    else{
        $search = "false";
        $status2 = false;

    }
}



if($adminID == null || $adminID == ''){
    ?>
    <script>window.location.href='login';</script>
    <?php
}
function ThDate($dateSearch)
{

    $year = (int)substr($dateSearch,0,4) + 543;
    $month = substr($dateSearch,6,2);
    $date = substr($dateSearch,8,2);


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



    return "
        $date  
		$month 
		$year";
}

$month = date('n');
$year = date('Y');
if($month>='5'  && $month <='10'){
    $semester =1;

}else{
    $semester =2;
    if($month >= 1 && $month <5){
        $year = $year-1;
    }
}



$previousURL = explode("/", $_SERVER["HTTP_REFERER"]);

$sql_student = "SELECT * FROM tb_students where tb_student_status = 1";
$result_student = mysqli_query($conn, $sql_student);
while ($row = mysqli_fetch_assoc($result_student)) {
    $student_name = ' {value: "'.$row['tb_student_code'].'", label: "'.$row['tb_student_name'].' '.$row['tb_student_sname'].'" },'.$student_name;
}

function display_timetype($status){
    if($status=='1'){
        $show_status = "<span class='glyphicon glyphicon-ok text-success'></span>";
    }elseif($status=='2'){
        $show_status = "สาย";
    }elseif($status=='3'){
        $show_status = "ลา";
    }elseif($status=='4'){
        $show_status = "ลาป่วย";
    }elseif($status=='5'){
        $show_status = "ขาดเรียน";
    }elseif($status=='6'){
        $show_status = "ลากิจ";
    }elseif($status=='7'){
        $show_status = "กิจกรรม";
    }
    return $show_status;
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
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

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
                <span class="text-info">ตัดคะแนนความประพฤติ</span>
                <p></p>
                <!--                <small class="show-font">โรงเรียนชำนาญสามัคคีวิทยา</small>-->
            </h2 class="header-title ">
        </div>

    </div>


    <div class="container">


        <div class="row">
            <div class="col-md-6">
                <div class="card ">

                    <h4 class="card-title show-font"><span class="icon ti-search"></span> ค้นหานักเรียนด้วยรหัส</h4>
                    <div class="card-body">
                        <div class="col-md-12 ">
                            <form class="form-inline" method="post" action="deduction-score">

                                <div class="form-group">

                                    <input type="number" class="form-control show-font" placeholder="รหัสนักเรียน" name="studentCode">
                                    <input type="hidden" class="form-control show-font"  name="search" value="true">
                                    <input type="hidden" class="form-control show-font"  name="search_code" value="true">

                                </div>

                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit"><span class="show-font">ค้นหา</span></button>
                                </div>
                            </form>
                            <?php if($status1 == false):?>
                                <p></p>
                                <label class="text-danger">ผิดพลาด! ไม่มีรหัสนักเรียนนี้ในระบบ</label>
                            <?php endif?>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card ">

                    <h4 class="card-title show-font"><span class="icon ti-search"></span> ค้นหานักเรียนด้วยชื่อ</h4>
                    <div class="card-body">
                        <div class="col-md-12">
                            <form class="form-inline" method="post" action="deduction-score">

                                <div class="form-group">

                                    <input type="text" class="form-control show-font" placeholder="ชื่อ-นามสกุล นักเรียน" name="studentName" style="width: 300px" id="student-name">
                                    <input type="hidden" class="form-control show-font" name="studentCode" id="student-code">
                                    <input type="hidden" class="form-control show-font"  name="search" value="true">
                                    <input type="hidden" class="form-control show-font"  name="search_name" value="true">

                                </div>

                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit"><span class="show-font">ค้นหา</span></button>
                                </div>
                            </form>
                            <?php if($status2 == false):?>
                                <p></p>
                                <label class="text-danger">ผิดพลาด! ไม่มีรหัสนักเรียนนี้ในระบบ</label>
                            <?php endif?>

                        </div>
                    </div>
                </div>
            </div>

            <?php if($search == "true"):

                $sql_rule_again = "SELECT * FROM tb_rules WHERE tb_student_code = '".$row_student['tb_student_code']."' and tb_rule_semester = '".$semester."' and tb_rule_year = '".$year."' and tb_rule_status = 1";
                $result_rule_again = mysqli_query($conn, $sql_rule_again);
                $sum_score = 0;
                while($row_rule_again = mysqli_fetch_assoc($result_rule_again)){
                    $sum_score += $row_rule_again['tb_rule_score'];
                }

                $sql_add_score_rule = "SELECT * FROM tb_add_rule_score WHERE student_code = '".$row_rule['tb_student_code']."' and semester = '".$semester."' and year = '".$year."' and status = 1";
                $result_add_score_rule = mysqli_query($conn, $sql_add_score_rule);
                $sum_add_score = 0;
                while($row_add_score_rule = mysqli_fetch_assoc($result_add_score_rule)){
                    $sum_add_score += $row_add_score_rule['score'];
                }


                $real_score = (100 - $sum_score) + $sum_add_score;

                ?>



                <div class="col-md-4">
                    <div class="card ">
                        <h4 class="card-title show-font"><span class="icon ti-user"></span> ข้อมูลนักเรียน</h4>
                        <div class="card-body">

                                <div class="sidebar-profile" id="profile">
                                    <img class="avatar " src="../file_student/small/<?php print $row_student['tb_student_code']?>.jpg" >

                                    <div class="profile-info">
                                        <table class="table table-separated">
                                            <tr>

                                                <td class="text-left">
                                                    <h6 class="show-font text-default">ชื่อ : <?php print $row_student['tb_student_name']?> <?php print $row_student['tb_student_sname']?></h6>
                                                </td>
                                            </tr>
                                            <tr>

                                                <td class="text-left">
                                                    <h6 class="show-font text-default">รหัสนักเรียน : <?php print $row_student['tb_student_code']?></h6>
                                                </td>
                                            </tr>
                                            <tr>

                                                <td class="text-left">
                                                    <h6 class="show-font text-default">ชั้น : <?php print $row_student_room['tb_room_name']?></h6>
                                                </td>
                                            </tr>
                                            <tr>

                                                <td class="text-left">
                                                    <h6 class="show-font text-default">เบอร์ผู้ปกครอง : <?php print $row_student['tb_student_phone']?></h6>
                                                </td>
                                            </tr>
                                            <tr>

                                                <td class="text-left">
                                                    <h6 class="show-font text-default">คะแนนที่เหลืออยู่ : <span class="text-danger"><?php print $real_score?></span></h6>
                                                </td>
                                            </tr>

                                            <tr>

                                                <td class="text-center">
                                                    <button class="btn btn-secondary show-font h6"  data-toggle="modal" data-target="#modal-student-detail"><span class="ti-search"></span> ดูข้อมูลความประพฤติ</button>
                                                </td>
                                            </tr>

                                        </table>

                                    </div>
                                </div>

                        </div>


                    </div>
                </div>

                <div class="modal fade" id="modal-student-detail" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title show-font" id="myModalLabel">ข้อมูลความประพฤติ</h4>
                                <button type="button" class="close" data-dismiss="modal">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body bg-secondary">

                                <div class="card">
                                    <h4 class="card-title show-font text-danger"><span class="icon ti-close"></span> ข้อมูลการไม่มาโรงเรียน</h4>
                                    <div class="card-body">
                                        <div class="table-responsive-lg" style="font-size: 16px">
                                            <table class="table table-lg table-hover table-bordered" data-paging="false" data-provide="datatables">
                                                <thead>
                                                <tr>
                                                    <th  class="text-center">ที่</th>
                                                    <th  class="text-center " style="font-weight: bold;">วันที่</th>
                                                    <th  class="text-center " style="font-weight: bold;">สถานะ</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php

                                                $sql_time_absent = "SELECT * FROM tb_times WHERE tb_time_stucode = '".$row_student['tb_student_code']."' and tb_time_type != 1 and tb_time_type_update != 2 and tb_time_semester = '".$semester."' and tb_time_year = '".$year."'";
                                                $result_time_absent = mysqli_query($conn, $sql_time_absent);
                                                $i = 0;

                                                while ($row_time_absent = mysqli_fetch_assoc($result_time_absent)) {

                                                    $i++;
                                                    ?>
                                                    <tr style="font-size: 16px">
                                                        <td class="text-center"><?php print $i?></td>
                                                        <td class="text-center"><?php print ThDate($row_time_absent['tb_time_date'])?></td>
                                                        <td class="text-center"><?php print display_timetype($row_time_absent['tb_time_type'])?></td>
                                                    </tr>

                                                    <?php
                                                }

                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>




                                <div class="card">
                                    <h4 class="card-title show-font text-danger"><span class="icon ti-close"></span> ข้อมูลการมาโรงเรียนสาย</h4>
                                    <div class="card-body">
                                        <div class="table-responsive-lg" style="font-size: 16px">
                                            <table class="table table-lg table-hover table-bordered" data-page-length='100' data-paging="false" data-provide="datatables">
                                                <thead>
                                                <tr>
                                                    <th  class="text-center">ที่</th>
                                                    <th  class="text-center " style="font-weight: bold;">วันที่</th>
                                                    <th  class="text-center " style="font-weight: bold;">หมายเหตุ</th>
                                                    <th  class="text-center " style="font-weight: bold;">เวลา</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php

                                                $sql_time_late = "SELECT * FROM tb_times WHERE tb_time_stucode = '".$row_student['tb_student_code']."' and tb_time_type != 1 and tb_time_type_update = 2 and tb_time_semester = '".$semester."' and tb_time_year = '".$year."'";
                                                $result_time_late = mysqli_query($conn, $sql_time_late);
                                                $i = 0;

                                                while ($row_time_late = mysqli_fetch_assoc($result_time_late)) {

                                                    $i++;
                                                    ?>
                                                    <tr style="font-size: 16px">
                                                        <td class="text-center"><?php print $i?></td>
                                                        <td class="text-center"><?php print ThDate($row_time_late['tb_time_date'])?></td>
                                                        <td class="text-center"><?php
                                                            if($row_time_late['tb_time_reason'] == ''){
                                                                echo '-';
                                                            }
                                                            else{
                                                                print $row_time_late['tb_time_reason'];
                                                            }?></td>
                                                        <td class="text-center"><?php print substr($row_time_late['tb_time_time'],0,5)?></td>
                                                    </tr>

                                                    <?php
                                                }

                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <h4 class="card-title show-font text-danger"><span class="icon ti-close"></span> ข้อมูลการถูกตัดคะแนนความประพฤติ</h4>
                                    <div class="card-body">
                                        <div class="table-responsive-lg" style="font-size: 16px">
                                            <table class="table table-lg table-hover table-bordered" data-paging="false" data-provide="datatables">
                                                <thead>
                                                <tr>
                                                    <th  class="text-center">ที่</th>
                                                    <th  class="text-center " style="font-weight: bold;">วันที่</th>
                                                    <th  class="text-center " style="font-weight: bold;">พฤติกรรม</th>
                                                    <th  class="text-center " style="font-weight: bold;">คะแนนที่ถูกตัด</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $i=0;
                                                $sql_rule = "SELECT * FROM tb_rules WHERE tb_student_code = '".$row_student['tb_student_code']."' and tb_rule_semester = '".$semester."' and tb_rule_year = '".$year."' and tb_rule_status = 1";
                                                $result_rule = mysqli_query($conn, $sql_rule);
                                                while($row_rule = mysqli_fetch_assoc($result_rule)){
                                                    $i++;

                                                    $sql_rule_type = "SELECT * FROM tb_ruletypes WHERE tb_ruletype_id = '".$row_rule['tb_ruletype_id']."'";
                                                    $result_rule_type = mysqli_query($conn, $sql_rule_type);

                                                    while ($row_ruletype = mysqli_fetch_assoc($result_rule_type)) {
                                                        ?>
                                                        <tr style="font-size: 16px">
                                                            <td class="text-center"><?php print $i?></td>
                                                            <td class="text-center"><?php print ThDate($row_rule['tb_rule_date'])?></td>
                                                            <td class="text-center"><?php print $row_ruletype['tb_ruletype_name']?></td>
                                                            <td class="text-center"><?php print $row_rule['tb_rule_score']?> คะแนน</td>
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
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger show-font" style="font-size: 16px" data-dismiss="modal">ปิด</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card">
                        <form method="post" action="function_deduction_score.php">
                            <h4 class="card-title show-font"><span class="icon ti-close"></span> ตัดคะแนนความประพฤติ</h4>
                            <table class="table table-separated">
                                <tr>

                                    <td class="text-right" width="20%">
                                        <h6 class="show-font text-default" style="margin-top: 10px">พฤติกรรม</h6>
                                    </td>
                                    <td class="text-left">
                                        <select name="ruletype" class="form-control show-font" style="font-size:17px;" id="rule" required>
                                            <option value="" class="show-font">เลือกพฤติกรรม</option>
                                            <?php
                                            $sql_rule_type = "SELECT * FROM tb_ruletypes WHERE tb_ruletype_status = 1 and tb_ruletype_type = 'DEDUCT' order by  tb_ruletype_score asc,tb_ruletype_id asc";
                                            $result_rule_type = mysqli_query($conn, $sql_rule_type);

                                            while ($row_ruletype = mysqli_fetch_assoc($result_rule_type)) {
                                                ?>
                                                <option class="show-font" value="<?php echo $row_ruletype['tb_ruletype_id'];?>" <?php if($previousURL[6] == 'late-report' && $row_ruletype['tb_ruletype_id'] == 1 ) echo 'selected'?>><?php echo $row_ruletype['tb_ruletype_name'];?> (<? print $row_ruletype['tb_ruletype_score']?> คะแนน)</option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>

                                    <td class="text-right" width="20%">
                                        <h6 class="show-font text-default" style="margin-top: 10px">คะแนนที่ตัด</h6>
                                    </td>
                                    <td class="text-left">
                                        <input class="form-control" type="number" min="0" id="score" name="score" required>
                                        <div id="overflow-score">

                                        </div>

                                        <input class="form-control" type="hidden" name="studentCode" required value="<?php print $row_student['tb_student_code']?>">
                                    </td>
                                </tr>
                                <tr>

                                    <td class="text-right" width="20%">
                                        <h6 class="show-font text-default" style="margin-top: 10px">สถานที่</h6>
                                    </td>
                                    <td class="text-left">
                                        <input class="form-control show-font" type="text" name="place">
                                    </td>
                                </tr>

                                <tr>

                                    <td class="text-right" width="20%">
                                        <h6 class="show-font text-default" style="margin-top: 10px">ภาคเรียน</h6>
                                    </td>
                                    <td class="text-left">
                                        <input class="form-control" type="text" name="semester" value="<?php print $semester?>-<?php print $year+543?>" required readonly>
                                        <input class="form-control" type="hidden" name="deduction_late" value="<?php print $deduction_late?>">
                                    </td>
                                </tr>

                                <tr>

                                    <td class="text-right" width="20%">
                                        <h6 class="show-font text-default" style="margin-top: 10px">วันที่</h6>
                                    </td>
                                    <td class="text-left">
                                        <input class="form-control" type="text" name="date" data-provide="datepicker" data-date-format="dd-mm-yyyy" value="<?php print $date_day?>" id="date" required>
                                    </td>
                                </tr>




                            </table>

                            <footer class="card-footer text-right">

                                <button class="btn btn-primary show-font" type="submit">บันทึก</button>
                            </footer>
                        </form>
                    </div>
                </div>

            <?php endif ?>

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
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>



    var dateFull = $('#date').val();
    var date = dateFull.substring(0,2);
    var month = dateFull.substring(3,5);
    var year = parseInt(dateFull.substring(6,10));

    var dateFormat = date+'-'+month+'-'+year

    $('#date').val(dateFormat);

    $('#date').on('changeDate', function(ev){
        $(this).datepicker('hide');
    });
</script>

<script>

    var student_name = [<?php print $student_name?>]
    var options1 = {
        source: function(request, response) {
            var results = $.ui.autocomplete.filter(student_name, request.term);
            response(results.slice(0, 10));},
        select: function(event, ui) {
            event.preventDefault();
            $(this).val(ui.item.label);
            $(this).parent().find('#student-code').val(ui.item.value);


        }
    };
    $(document).on('keydown.autocomplete ', '#student-name', function() {

        $(this).autocomplete(options1);

    });


</script>



<script>



    setInterval(function(){
        var score = $( "#score" ).val();
        if(parseInt(score) <= 0){
            $( "#score" ).val('');
        }
    }, 1);

    var initialScore = $( "#rule" ).val();
    if(initialScore == '' || initialScore == null) {
        $("#rule").click(async function () {
            var ruleTypeID = $("#rule").val();
            const resp = await fetch('https://www.csw.ac.th/csw_api/get_rule_score.php', {
                method: 'post',
                headers: {
                    Accept: 'application/json',
                },
                body: JSON.stringify({
                    ruleTypeID: ruleTypeID,
                }),
            });

            const data = await resp.json();
            data.map((scorerule) => {
                $("#overflow-score").html('');
                $("#score").keyup(function () {
                    var score = $("#score").val();
                    if (parseInt(score) > parseInt(scorerule.score)) {
                        $("#overflow-score").html('<label class="text-danger">คุณใส่คะแนนเกินที่เกณฑ์ระบุ</label>');

                        setTimeout(function () {
                            $("#score").val('');

                        }, 100);
                    }
                    else {
                        $("#overflow-score").html('');
                    }
                });
            });
        });
    }
    else{

        initailFetch();
    }

    async function initailFetch() {
        var ruleTypeID = $("#rule").val();
        const resp = await fetch('https://www.csw.ac.th/csw_api/get_rule_score.php', {
            method: 'post',
            headers: {
                Accept: 'application/json',
            },
            body: JSON.stringify({
                ruleTypeID: ruleTypeID,
            }),
        });

        const data = await resp.json();
        data.map((scorerule) => {
            $("#overflow-score").html('');
            $("#score").keyup(function () {
                var score = $("#score").val();
                if (parseInt(score) > parseInt(scorerule.score)) {
                    $("#overflow-score").html('<label class="text-danger">คุณใส่คะแนนเกินที่เกณฑ์ระบุ</label>');

                    setTimeout(function () {
                        $("#score").val('');

                    }, 100);
                }
                else {
                    $("#overflow-score").html('');
                }
            });
        });
    }
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
