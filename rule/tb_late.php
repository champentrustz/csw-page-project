<?php
session_start();
include '../config_db.php';

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

$date_day = $_SESSION['date_day'];

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

<script>
    $(document).ready( function () {
        $('#myTable').DataTable();
    } );
</script>

<br/>
<div class="table-responsive-lg" style="font-size: 16px">
<table class="table table-xl table-hover table-bordered fixed" data-page-length='100' data-provide="datatables"  >
    <thead>
      <tr>
        <th  class="text-center" style="font-weight: bold;">ที่</th>

        <th  class="text-center" style="font-weight: bold;">รหัส</th>
        <th  class="text-center " style="font-weight: bold;">รูป</th>
        <th  class="text-center " style="font-weight: bold;">ชื่อ-นามสกุล</th>
        <th  class="text-center " style="font-weight: bold;">ชั้น</th>
        <th  class="text-center " style="font-weight: bold;">สถานะก่อนหน้า</th>
        <th  class="text-center" style="font-weight: bold;">สาย</th>
        <th  class="text-center " style="font-weight: bold;">ขาด</th>
        <th  class="text-center " style="font-weight: bold;">หมายเหตุ</th>
        <th  class="text-center " style="font-weight: bold;">เวลา</th>
        <th  class="text-center"><span class="fa fa-cog"></span></th>

      </tr>
    </thead>
    <tbody>

    <?php
    $sql_time_late = "SELECT * FROM tb_times WHERE tb_time_date = '".$date_day."' and tb_time_type != 1 and tb_time_type_update = 2 order by tb_time_degree asc, tb_time_stucode asc";
    $result_time_late = mysqli_query($conn, $sql_time_late);
    $i = 0;

    $count = mysqli_num_rows($result_time_late);
    if($count > 0) {
        while ($row_time_late = mysqli_fetch_assoc($result_time_late)) {

            $sql_rule = "SELECT * FROM tb_rules WHERE tb_student_code = '".$row_time_late['tb_time_stucode']."' and tb_rule_status = 1 and tb_rule_date = '".$row_time_late['tb_time_date']."' and tb_ruletype_id = 1";
            $result_rule = mysqli_query($conn, $sql_rule);
            $count_rule = mysqli_num_rows($result_rule);

            $i++;
            $sql_student = "SELECT * FROM tb_students WHERE tb_student_code = '" . $row_time_late['tb_time_stucode'] . "'";
            $result_student = mysqli_query($conn, $sql_student);
            $row_student = mysqli_fetch_assoc($result_student);

            $sql_room = "SELECT * FROM tb_rooms WHERE tb_room_id = '" . $row_student['tb_student_degree'] . "'";
            $result_room = mysqli_query($conn, $sql_room);
            $row_room = mysqli_fetch_assoc($result_room);

            $sql_data_student = "SELECT * FROM tb_times WHERE tb_time_stucode = '" . $row_student['tb_student_code'] . "' and tb_time_semester = '".$semester."' and tb_time_year = '".$year."' and tb_time_type != 1 and tb_time_date <= '".$date_day."'";
            $result_data_student = mysqli_query($conn, $sql_data_student);
            $absent = 0;
            $late = 0;

            while($row_data_student = mysqli_fetch_assoc($result_data_student)){

                if($row_data_student['tb_time_type_update'] == 2){
                    $late++;
                }
                else{
                    $absent++;
                }
            }

            ?>
            <tr style="font-size: 16px">
                <td class="text-center"><?php print $i ?></td>
                <td class="text-center"><?php print $row_student['tb_student_code']?></td>
                <td class="text-center"><img class="zoom" src="../file_student/small/<?php print $row_student['tb_student_code']?>.jpg" style="width:60px;height:78px"></td>
                <td width="20%"><?php print $row_student['tb_student_name']?> <?php print $row_student['tb_student_sname']?></td>
                <td class="text-center"><?php print $row_room['tb_room_name']?></td>
                <td class="text-center"><?php print display_timetype($row_time_late['tb_time_type'])?></td>
                <td class="text-center"><?php
                    if($late > 4) {
                        echo '<span class="text-danger">'.$late.'</span>';
                    }
                    else{
                        print $late;
                    }
                ?>
                </td>
                <td class="text-center"><?php
                    if($absent > 4) {
                        echo '<span class="text-danger">'.$absent.'</span>';
                    }
                    else{
                        print $absent;
                    }
                    ?>

                </td>
                <td class="text-center"><?php
                    if($row_time_late['tb_time_reason'] == ''){
                        echo '-';
                    }
                    else{
                        print $row_time_late['tb_time_reason'];
                    }?></td>
                <td class="text-center"><?php print substr($row_time_late['tb_time_time'],0,5)?></td>
                <td class="text-center">
                    <form action="deduction-score" method="post">
                    <input type="hidden" class="form-control show-font" placeholder="รหัสนักเรียน" name="studentCode" value="<?php print $row_time_late['tb_time_stucode']?>">
                    <input type="hidden" class="form-control show-font"  name="search" value="true">
                        <input type="hidden" class="form-control show-font"  name="search_code" value="true">
                    <input type="hidden" class="form-control show-font"  name="date" value="<?php print $date_day?>">
                    <input type="hidden" class="form-control show-font"  name="deduction_late" value="true">
                    <button class="btn btn-info btn-sm show-font" data-provide="tooltip" title="ตัดคะแนน" type="submit" <?php if($count_rule > 0) echo "disabled"?>>ตัดคะแนน</button>
                    </form>
                </td>


            </tr>
            <?php
        }
    }

    ?>


    </tbody>

</table>
</div>
<br/>


