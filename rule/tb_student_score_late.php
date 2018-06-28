<?php
session_start();
include '../config_db.php';

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

$semester = $_SESSION['semester'];
$year = $_SESSION['year'];

$date_day = date("Y-m-d");


?>



<br/>
<div class="table-responsive-lg" style="font-size: 16px">
    <table class="table table-lg table-hover table-bordered" data-page-length='100' data-provide="datatables">
        <thead>
        <tr>
            <th  class="text-center" style="font-weight: bold;">ที่</th>

            <th  class="text-center" style="font-weight: bold;">รหัส</th>
            <th  class="text-center " style="font-weight: bold;">รูป</th>
            <th  class="text-center " style="font-weight: bold;">ชื่อ-นามสกุล</th>
            <th  class="text-center " style="font-weight: bold;">ชั้น</th>
            <th  class="text-center" style="font-weight: bold;">คะแนนที่ถูกตัด</th>
<!--            <th  class="text-center "><span class="icon fa fa-cog"></span></th>-->

        </tr>
        </thead>
        <tbody>

        <?php
        $sql_rule = "SELECT DISTINCT tb_student_code FROM tb_rules WHERE tb_rule_semester = '".$semester."' and tb_rule_year = '".$year."' and tb_rule_status = 1 and tb_ruletype_id = 1";
        $result_rule = mysqli_query($conn, $sql_rule);
        $i = 0;

        $count = mysqli_num_rows($result_rule);
        if($count > 0) {
            while ($row_rule = mysqli_fetch_assoc($result_rule)) {

                $i++;
                $sql_student = "SELECT * FROM tb_students WHERE tb_student_code = '" . $row_rule['tb_student_code'] . "'";
                $result_student = mysqli_query($conn, $sql_student);
                $row_student = mysqli_fetch_assoc($result_student);
                $sql_room = "SELECT * FROM tb_rooms WHERE tb_room_id = '" . $row_student['tb_student_degree'] . "'";
                $result_room = mysqli_query($conn, $sql_room);
                $row_room = mysqli_fetch_assoc($result_room);
                $sql_rule_again = "SELECT * FROM tb_rules WHERE tb_student_code = '".$row_rule['tb_student_code']."' and tb_rule_semester = '".$semester."' and tb_rule_year = '".$year."' and tb_rule_status = 1 and tb_ruletype_id = 1";
                $result_rule_again = mysqli_query($conn, $sql_rule_again);
                $sum_score = 0;
                while($row_rule_again = mysqli_fetch_assoc($result_rule_again)){
                    $sum_score += $row_rule_again['tb_rule_score'];
                }


                ?>
                <tr style="font-size: 16px">

                    <td class="text-center"><?php print $i ?></td>
                    <td class="text-center"><?php print $row_student['tb_student_code']?></td>
                    <td class="text-center"><img class="zoom" src="../file_student/small/<?php print $row_student['tb_student_code']?>.jpg" style="width:60px;height:78px"></td>
                    <td><?php print $row_student['tb_student_name']?> <?php print $row_student['tb_student_sname']?></td>
                    <td class="text-center"><?php print $row_room['tb_room_name'] ?></td>
                    <td class="text-center"><?php print $sum_score?></td>

<!--                    <td class="text-center">-->
<!--                        <form method="post" action="view-detail">-->
<!--                            <input type="hidden" value="--><?php //print $row_student['tb_student_code']?><!--" name="studentCode">-->
<!--                            <input type="hidden" value="--><?php //print $semester?><!--" name="semester">-->
<!--                            <input type="hidden" value="--><?php //print $year?><!--" name="year">-->
<!--                        <button class="btn btn-info btn-sm show-font" data-provide="tooltip" title="รายละเอียด" type="submit">รายละเอียด</button>-->
<!--                        </form>-->
<!--                    </td>-->


                </tr>
                <?php
            }
        }

        ?>


        </tbody>

    </table>
</div>
<br/>



<script>
    async function changeStatus(number,id) {

        console.log('click');

        let timeID = id;
        let reason =  $( "#reason"+number ).val();

        const resp = await fetch('https://www.csw.ac.th/csw_api/check_late.php', {
            method: 'post',
            headers: {
                Accept: 'application/json',
            },
            body: JSON.stringify({
                timeID :  timeID,
                reason :  reason,
            }),
        });

        refreshTabel(resp);

    }



    function refreshTabel(resp)
    {
        $('#button-late').trigger('click');
    }

</script>

